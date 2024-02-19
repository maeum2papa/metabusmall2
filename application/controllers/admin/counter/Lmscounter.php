<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Statcounter class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>통계>학습통계 controller 입니다.
 */
class Lmscounter extends CB_Controller
{
    /**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'counter/lmscounter';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Stat_count', 'Stat_count_date', 'Post');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Stat_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

	/**
	 * 시간대별 학습통계
	 */
	public function index($export = '')
	{
		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		

        // 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$company_idx = $this->member->item('company_idx');
			}
		} 

		if($this->input->get('sfield') && $this->input->get('skeyword')){
			$searchWhere = " and ".$this->input->get('sfield')." like '%".$this->input->get('skeyword')."%' ";
		}

		// 회원별 학습자 현황
		$sql = "select b.company_name, a.mem_id, a.mem_email, a.mem_username, a.mem_nickname from cb_member as a 
		left join cb_company_info as b on b.company_idx = a.company_idx where a.company_idx = '".$company_idx."'".$searchWhere;
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
		foreach($result as $k => $v){
			// 실명 없는 경우 닉네임으로 대체
			if($v['mem_username'] == ''){
				$result[$k]['mem_username'] = $v['mem_nickname'];
			}

			// 총 학습시간
			$sql = "select sum(a.mps_playTime) as sum from cb_my_process_sub as a left join cb_my_process as b on b.mp_sno = a.mp_sno where a.mps_type = 'v' and b.mem_id = '".$v['mem_id']."'";
			$qry = $this->db->query($sql);
			$res = $qry->row_array();
			$seconds = $res['sum'];
			$H = floor($seconds / 3600);
			$i = floor(($seconds / 60) % 60);
			$s = $seconds % 60;
			$result[$k]['acctime'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

			// 신청과정 개수
			$sql = "select count(*) as cnt from cb_my_process as a left join cb_lms_process as b on b.p_sno = a.p_sno where a.mem_id = '".$v['mem_id']."' and b.p_viewYn != 'n'";
			$qry = $this->db->query($sql);
			$res = $qry->row_array();
			$result[$k]['lms_process_all'] = $res['cnt'];

			// 수료과정 개수
			$sql = "select count(*) as cnt from cb_my_process where mp_endYn = 'y' and mem_id = '".$v['mem_id']."'";
			$qry = $this->db->query($sql);
			$res = $qry->row_array();
			$result[$k]['lms_process_complete'] = $res['cnt'];
		}

		$view['view']['list']['board'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('mem_email' => '로그인 아이디', 'mem_username' => '이름', 'mem_nickname' => '닉네임');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);

		// 시간대별 학습 현황 start
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		$orderby = (strtolower($this->input->get('orderby')) === 'desc') ? 'desc' : 'asc';
		if($this->input->get('ymd') == 'day'){
			$sql = "SELECT date_format(mll_datetime,'%H') as mll_datetime, count(time(mll_datetime)) as mll_count FROM cb_member_lms_log as a left join cb_member as b on b.mem_id = a.mem_id 
			WHERE b.company_idx = ".$company_idx." and a.mll_datetime >= '".$start_date." 00:00:00' and mll_datetime <= '".$end_date." 23:59:59' ".$searchWhere." group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
		} else if($this->input->get('ymd') == 'month'){
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-31');
			$sql = "SELECT SUBSTRING(mll_datetime,1,10) as mll_datetime, count(day(mll_datetime)) as mll_count FROM cb_member_lms_log as a left join cb_member as b on b.mem_id = a.mem_id 
			WHERE b.company_idx = ".$company_idx." and a.mll_datetime >= '".$start_date." 00:00:00' and mll_datetime <= '".$end_date." 23:59:59' ".$searchWhere." group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
		} else if($this->input->get('ymd') == 'year'){
			$start_date = date('Y-01-01');
			$end_date = date('Y-12-31');
			$start_year = substr($start_date, 0, 4);
			$end_year = substr($end_date, 0, 4);
			$start_month = substr($start_date, 5, 2);
			$end_month = substr($end_date, 5, 2);
			$start_year_month = $start_year * 12 + $start_month;
			$end_year_month = $end_year * 12 + $end_month;
			$sql = "SELECT SUBSTRING(mll_datetime,1,7) as mll_datetime, count(month(mll_datetime)) as mll_count FROM cb_member_lms_log as a left join cb_member as b on b.mem_id = a.mem_id 
			WHERE b.company_idx = ".$company_idx." and a.mll_datetime >= '".$start_date." 00:00:00' and mll_datetime <= '".$end_date." 23:59:59' ".$searchWhere." group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
		} else {
			$sql = "SELECT date_format(mll_datetime,'%H') as mll_datetime, count(time(mll_datetime)) as mll_count FROM cb_member_lms_log as a left join cb_member as b on b.mem_id = a.mem_id 
			WHERE b.company_idx = ".$company_idx." and a.mll_datetime >= '".$start_date." 00:00:00' and mll_datetime <= '".$end_date." 23:59:59' ".$searchWhere." group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
		}

		$arr = array();
		$max = 0;
		$sum_count = 0;

		$result = array();
		if ($list && is_array($list)) {
			foreach ($list as $key => $value) {
				$result[$value['mll_datetime']] = $value;
			}
		}

		if ($result && is_array($result)) {
			foreach ($result as $key => $value) {
				$arr[$value['mll_datetime']] = $value['mll_count'];

				if ($value['mll_count'] > $max) {
					$max = $value['mll_count'];
				}

				$sum_count += $value['mll_count'];
			}
		}
		if ($result && is_array($result)) {
			foreach ($result as $key => $value) {
				$count = $value['mll_count'];
				$result[$value['mll_datetime']]['count'] = $count;

				$rate = ($count / $sum_count * 100);
				$result[$value['mll_datetime']]['rate'] = $rate;
				$s_rate = number_format($rate, 1);
				$result[$value['mll_datetime']]['s_rate'] = $s_rate;

				$bar = (int)($count / $max * 100);
				$result[$value['mll_datetime']]['bar'] = $bar;
			}

			$view['view']['graph']['max_value'] = $max;
			$view['view']['graph']['sum_count'] = $sum_count;
		}

		if($this->input->get('ymd') == 'day'){
			for ($i=0; $i<24; $i++) {
				$hour = sprintf("%02d", $i);
				if( ! isset($result[$hour])) $result[$hour] = '';
			}
		} else if($this->input->get('ymd') == 'month'){
			$date = $start_date;
			while ($date <= $end_date) {
				if( ! isset($result[$date])) $result[$date] = '';
				$date = cdate('Y-m-d', strtotime($date) + 86400);
			}
		} else if($this->input->get('ymd') == 'year'){
			for ($i = $start_year_month; $i <= $end_year_month; $i++) {
				$year = floor($i / 12);
				if ($year * 12 == $i) $year--;
				$month = sprintf("%02d", ($i - ($year * 12)));
				$date = $year . '-' . $month;
				if( ! isset($result[$date])) $result[$date] = '';
			}
		} else {
			for ($i=0; $i<24; $i++) {
				$hour = sprintf("%02d", $i);
				if( ! isset($result[$hour])) $result[$hour] = '';
			}
		}

		if ($orderby === 'desc') {
			krsort($result);
		} else {
			ksort($result);
		}

		$view['view']['list']['graph'] = $result;
		// 시간대별 학습 현황 end

		if ($export === 'excel') {

			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=시간대별학습현황_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/index_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

	/**
	 * 학습 신청 통계
	 */
	public function apply($export = '')
	{
		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('list_skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		$sWhere = "";

        $list_start_date = $view['view']['list_start_date'] = $this->input->get('list_start_date');
        $list_end_date = $view['view']['list_end_date'] = $this->input->get('list_end_date');
		$list_ymd = $view['view']['list_ymd'] = $this->input->get('list_ymd');
		if(!$list_ymd){
			if($list_start_date && $list_end_date){
				$sWhere .= " and p_regDt >= '".$list_start_date." 00:00:00' and p_regDt <= '".$list_end_date." 23:59:59' ";
				$view['view']['list_ymd'] = '';
			}
		} else {
			if($list_ymd == 'day'){
				$view['view']['list_start_date'] = date('Y-m-d');
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and p_regDt >= '".$view['view']['list_start_date']." 00:00:00' and p_regDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '7day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-7 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and p_regDt >= '".$view['view']['list_start_date']." 00:00:00' and p_regDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '15day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-15 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and p_regDt >= '".$view['view']['list_start_date']." 00:00:00' and p_regDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '1month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-1 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and p_regDt >= '".$view['view']['list_start_date']." 00:00:00' and p_regDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '3month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-3 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and p_regDt >= '".$view['view']['list_start_date']." 00:00:00' and p_regDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else {
				$view['view']['list_start_date'] = '';
				$view['view']['list_end_date'] = '';
			}
		}
        
        if($this->input->get('planfield')){
            $sWhere .= " and plan_idx = ".$this->input->get('planfield');
        }

        if($this->input->get('list_skeyword')){
			$sWhere .= " and p_title like '%".$this->input->get('list_skeyword')."%' ";
		}

        // 과정 현황 start
		$sql = "select p_sno, plan_idx, p_title, p_regDt from cb_lms_process where p_viewYn != 'n' ".$sWhere." order by p_regDt desc";
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        foreach($result as $k => $v){
			$sWhere2 = "";
			// 해당 기업관리자 소속 기업회원만 조회
			if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
				if($this->member->item('mem_level') == '100'){ // 기업관리자
					$sWhere2 .= " and b.company_idx = ".$this->member->item('company_idx');
				}
			} 
            // 플랜
            $sql = "select plan_name from cb_plan where plan_idx = ".$v['plan_idx'];
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result[$k]['plan_name'] = $rowdata['plan_name'];

            // 등록일
            $result[$k]['p_regDt'] = substr($v['p_regDt'], 0, 10);

            // 신청자 수
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id where a.p_sno = '".$v['p_sno']."'".$sWhere2;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result[$k]['plan_apply_cnt'] = $rowdata['cnt'];

            // 수료자 수
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id where a.p_sno = '".$v['p_sno']."' and a.mp_endYn = 'y'".$sWhere2;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result[$k]['plan_end_cnt'] = $rowdata['cnt'];
        }

        $sql = "select plan_idx, plan_name from cb_plan order by plan_idx asc";
        $r = $this->db->query($sql);
        $result['plan'] = $r->result_array();

        // 과정 현황 end

		$view['view']['list']['board'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/apply?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

        /**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('p_title' => '과정명');
		$view['view']['list_skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);

		$sWhere3 = "";
		// 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere3 .= " and b.company_idx = ".$this->member->item('company_idx');
			}
		} 

        // 학습 신청 통계 start
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if($this->input->get('ymd') == 'day'){
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where a.mp_regDt >= '".$start_date." 00:00:00' and a.mp_regDt <= '".$end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result2['cnt'] = $rowdata['cnt'];

            $ex_start_date = date('Y-m-d', strtotime('-1 day'));
            $ex_end_date = date('Y-m-d', strtotime('-1 day'));
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where a.mp_regDt >= '".$ex_start_date." 00:00:00' and a.mp_regDt <= '".$ex_end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();

			if($rowdata['cnt'] < 1){
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / 1 * 100);
			} else {
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / $rowdata['cnt'] * 100);
			}
		} else if($this->input->get('ymd') == 'month'){
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-31');
			$sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where a.mp_regDt >= '".$start_date." 00:00:00' and a.mp_regDt <= '".$end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result2['cnt'] = $rowdata['cnt'];

            $ex_start_date = date('Y-m-01', strtotime('-1 month'));
            $ex_end_date = date('Y-m-31', strtotime('-1 month'));
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where a.mp_regDt >= '".$ex_start_date." 00:00:00' and a.mp_regDt <= '".$ex_end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();

            if($rowdata['cnt'] < 1){
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / 1 * 100);
			} else {
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / $rowdata['cnt'] * 100);
			}
		} else if($this->input->get('ymd') == 'year'){
			$start_date = date('Y-01-01');
			$end_date = date('Y-12-31');
			$sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where a.mp_regDt >= '".$start_date." 00:00:00' and a.mp_regDt <= '".$end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result2['cnt'] = $rowdata['cnt'];

            $ex_start_date = date('Y-01-01', strtotime('-1 year'));
            $ex_end_date = date('Y-12-31', strtotime('-1 year'));
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where a.mp_regDt >= '".$ex_start_date." 00:00:00' and a.mp_regDt <= '".$ex_end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            
            if($rowdata['cnt'] < 1){
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / 1 * 100);
			} else {
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / $rowdata['cnt'] * 100);
			}
		} else {
			$sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where mp_regDt >= '".$start_date." 00:00:00' and mp_regDt <= '".$end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result2['cnt'] = $rowdata['cnt'];

            $ex_start_date = date('Y-m-d', strtotime('-1 day'));
            $ex_end_date = date('Y-m-d', strtotime('-1 day'));
            $sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id 
            where mp_regDt >= '".$ex_start_date." 00:00:00' and mp_regDt <= '".$ex_end_date." 23:59:59'".$sWhere3;
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();

            if($rowdata['cnt'] < 1){
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / 1 * 100);
			} else {
				$result2['per'] = floor(($result2['cnt'] - $rowdata['cnt']) / $rowdata['cnt'] * 100);
			}
		}
        if(is_nan($result2['per']) || $result2['per'] == 'NAN'){
            $result2['per'] = 0;
        }
		$view['view']['list']['graph'] = $result2;
		// 학습 신청 통계 end

		if ($export === 'excel') {

			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=학습신청통계현황_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/apply_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'apply');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

	/**
	 * 학습 신청 통계 자세히 보기
	 */
	public function apply_detail($p_sno = 0)
	{
		$view = array();
		$view['view'] = array();

		$p_sno = (int) $p_sno;
		if (empty($p_sno) OR $p_sno < 1) {
			show_404();
		}

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('list_skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		$sWhere = "";
		// 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere .= " and b.company_idx = ".$this->member->item('company_idx');
			}
		} 

		$sql = "select p_sno, plan_idx, p_title, p_regDt from cb_lms_process where p_sno = ".$p_sno;
		$qry = $this->db->query($sql);
		$result = $qry->row_array();
        // 플랜
		$sql = "select plan_name from cb_plan where plan_idx = ".$result['plan_idx'];
		$r = $this->db->query($sql);
		$rowdata = $r->row_array();
		$result['plan_name'] = $rowdata['plan_name'];

		// 등록일
		$result['p_regDt'] = substr($result['p_regDt'], 0, 10);

		// 신청자 수
		$sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id where a.p_sno = ".$p_sno.$sWhere;
		$r = $this->db->query($sql);
		$rowdata = $r->row_array();
		$result['plan_apply_cnt'] = $rowdata['cnt'];

		// 수료자 수
		$sql = "select count(*) as cnt from cb_my_process as a left join cb_member as b on b.mem_id = a.mem_id where a.p_sno = ".$p_sno." and a.mp_endYn = 'y' ".$sWhere;
		$r = $this->db->query($sql);
		$rowdata = $r->row_array();
		$result['plan_end_cnt'] = $rowdata['cnt'];

		// 카테고리
		$sql = "select a.cca_id, a.cca_parent from cb_category as a left join cb_lms_process_category as b on b.cca_id = a.cca_id where b.p_sno = ".$p_sno;
		$r = $this->db->query($sql);
		$rowdata = $r->row_array();
		$result['cca_id_fir'] = $rowdata['cca_parent'];
		$result['cca_id_sec'] = $rowdata['cca_id'];

		$view['view']['post']['board'] = $result;
	
		if($this->input->get('mp_endYn')){
			$sWhere .= " and a.mp_endYn = '".$this->input->get('mp_endYn')."' ";
		}

		if($this->input->get('list_skeyword')){
			if($this->input->get('list_sfield') == 'mem_username'){
				$sWhere .= " and (b.mem_username like '%".$this->input->get('list_skeyword')."%' or b.mem_nickname like '%".$this->input->get('list_skeyword')."%') ";
			} else {
				$sWhere .= " and b.mem_email like '%".$this->input->get('list_skeyword')."%' ";
			}
		}

		$sql = "select b.mem_id, b.mem_email, b.mem_username, b.mem_nickname, a.mp_endYn from cb_my_process as a 
		left join cb_member as b on b.mem_id = a.mem_id where a.p_sno = ".$p_sno.$sWhere;
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result2 = $qry->result_array();
		foreach($result2 as $k => $v){
			// 실명 없는 경우 닉네임으로 대체
			if($v['mem_username'] == ''){
				$result2[$k]['mem_username'] = $v['mem_nickname'];
			}

			// 과정
			$sql = "select sum(mps_playTime) as sum from cb_my_process_sub as a left join cb_my_process as b on b.mp_sno = a.mp_sno where b.p_sno = ".$p_sno." and b.mem_id = ".$v['mem_id'];
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			$seconds = $rowdata['sum'];
			$H = floor($seconds / 3600);
			$i = floor(($seconds / 60) % 60);
			$s = $seconds % 60;
			$result2[$k]['p_time'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

			// 상태
			if($v['mp_endYn'] == 'y'){
				$result2[$k]['p_status'] = 'FINISH';
			} else {
				$result2[$k]['p_status'] = 'OPEN';
			}
			
		}

		$view['view']['list']['board'] = $result2;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/apply_detail?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'apply_detail');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 학습자 현황 상세
	 */
	public function apply_mem_detail($mem_id = 0)
	{
		$view = array();
		$view['view'] = array();

        $mem_id = (int) $mem_id;
		if (empty($mem_id) OR $mem_id < 1) {
			show_404();
		}

		$sql = "select mem_email, mem_username, mem_nickname from cb_member where mem_id = ".$mem_id;
		$r = $this->db->query($sql);
		$rowdata = $r->row_array();
		// 로그인 아이디
		$rst['mem_email'] = $rowdata['mem_email'];

		// 이름
		if(!$rowdata['mem_username']){
			$rst['mem_username'] = $rowdata['mem_nickname'];
		} else {
			$rst['mem_username'] = $rowdata['mem_username'];
		}

		// 총 학습 시간
		$sql = "select sum(a.mps_playTime) as sum from cb_my_process_sub as a left join cb_my_process as b on b.mp_sno = a.mp_sno where a.mps_type = 'v' and b.mem_id = ".$mem_id;
		$r = $this->db->query($sql);
		$res = $r->row_array();
		$seconds = $res['sum'];
		$H = floor($seconds / 3600);
		$i = floor(($seconds / 60) % 60);
		$s = $seconds % 60;
		$rst['acctime'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

		// 신청과정
		$sql = "select count(*) as cnt from cb_my_process as a left join cb_lms_process as b on b.p_sno = a.p_sno where a.mem_id = ".$mem_id." and b.p_viewYn != 'n'";
		$r = $this->db->query($sql);
		$res = $r->row_array();
		$rst['lms_process_all'] = $res['cnt'];

		// 수료과정
		$sql = "select count(*) as cnt from cb_my_process where mp_endYn = 'y' and mem_id = ".$mem_id;
		$r = $this->db->query($sql);
		$res = $r->row_array();
		$rst['lms_process_complete'] = $res['cnt'];

		$view['view']['post'] = $rst;

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		$searchWhere = "";
		if($this->input->get('list_skeyword')){
			if($this->input->get('list_sfield') == 'lms_category'){
				$sql = "select cca_id from cb_category where cca_value like '%".$this->input->get('list_skeyword')."%'";
				$r = $this->db->query($sql);
				$rowdata = $r->result_array();
				$cca_id_arr = array();
				foreach($rowdata as $k => $v){
					$cca_id_arr[] = $v['cca_id'];
				}
				$cca_id_arr = implode(',',$cca_id_arr);
				$searchWhere = " and c.cca_id in (".$cca_id_arr.") ";
			} else if($this->input->get('list_sfield') == 'lms_title'){
				$searchWhere = " and d.p_title like '%".$this->input->get('list_skeyword')."%' ";
			}
		}

		$sql = "select a.*, c.cca_desc, d.p_title from cb_my_process as a 
		left join cb_lms_process_category as b on b.p_sno = a.p_sno 
		left join cb_category as c on c.cca_id = b.cca_id 
		left join cb_lms_process as d on d.p_sno = a.p_sno 
		where a.mem_id = ".$mem_id.$searchWhere." group by a.mp_sno";
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
		foreach($result as $k => $v){
			// 카테고리
			$sql = "select count(cca_desc) as cnt from cb_my_process as a 
			left join cb_lms_process_category as b on b.p_sno = a.p_sno 
			left join cb_category as c on c.cca_id = b.cca_id where a.mp_sno = ".$v['mp_sno'];
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			if($rowdata['cnt'] > 1){
				$result[$k]['cca_desc']  = $v['cca_desc'].' 외 '.($rowdata['cnt'] - 1);
			}

			// 과정 시간
			$sql = "select mps_playTime from cb_my_process_sub where mps_type = 'v' and mp_sno = ".$v['mp_sno'];
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			$seconds = $rowdata['mps_playTime'];
			$H = floor($seconds / 3600);
			$i = floor(($seconds / 60) % 60);
			$s = $seconds % 60;
			$result[$k]['acctime'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

			// 상태
			$sql = "select mp_endYn from cb_my_process where p_sno = ".$v['p_sno'];
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			if($rowdata['mp_endYn'] == 'n'){
				$result[$k]['p_status'] = 'OPEN';
			} else {
				$result[$k]['p_status'] = 'FINISH';
			}

		}


		$view['view']['list'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/apply_mem_detail?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'apply_mem_detail');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 교육 이수증
	 */
	public function cert($export = '')
	{
		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('list_skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		$where = array();
        // 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$company_idx = $this->member->item('company_idx');
			}
		} 

        $searchWhere = "";

        // 부서 검색
        if($this->input->get('mem_div')){
            $searchWhere .= " and b.mem_div like '%".$this->input->get('mem_div')."%' ";
        }

        // 회원 검색
        if($this->input->get('mem_username')){
            $searchWhere .= " and (b.mem_username like '%".$this->input->get('mem_username')."%' or b.mem_nickname like '%".$this->input->get('mem_username')."%') ";
        }

        // 기간 검색
        $list_start_date = $view['view']['list_start_date'] = $this->input->get('list_start_date');
        $list_end_date = $view['view']['list_end_date'] = $this->input->get('list_end_date');
		$list_ymd = $view['view']['list_ymd'] = $this->input->get('list_ymd');
		if(!$list_ymd){
			if($list_start_date && $list_end_date){
				$searchWhere .= " and a.mp_endDt >= '".$list_start_date." 00:00:00' and a.mp_endDt <= '".$list_end_date." 23:59:59' ";
				$view['view']['list_ymd'] = '';
			}
		} else {
			if($list_ymd == 'day'){
				$view['view']['list_start_date'] = date('Y-m-d');
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '7day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-7 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '15day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-15 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '1month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-1 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '3month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-3 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else {
				$view['view']['list_start_date'] = '';
				$view['view']['list_end_date'] = '';
			}
		}

        if($this->input->get('cca_id_fir')){
            if($this->input->get('cca_id_sec')){
                $searchWhere .= " and e.cca_id = ".$this->input->get('cca_id_sec');
            } else {
                $searchWhere .= " and e.cca_parent = ".$this->input->get('cca_id_fir');
            }
        }

        // 과정명 검색
        if($this->input->get('list_skeyword')){
			$searchWhere .= " and c.p_title like '%".$this->input->get('list_skeyword')."%' ";
		}

        // 교육 이수증 start
        $sql = "select a.mp_sno, a.p_sno, a.mem_id, a.mp_endYn, a.mp_endDt, b.mem_username, b.mem_nickname, b.mem_div, c.p_title, e.cca_value, e.cca_parent from cb_my_process as a 
        left join cb_member as b on b.mem_id = a.mem_id 
        left join cb_lms_process as c on c.p_sno = a.p_sno 
        left join cb_lms_process_category as d on d.p_sno = a.p_sno 
        left join cb_category as e on e.cca_id = d.cca_id 
        where b.company_idx = ".$company_idx.$searchWhere." order by a.mp_endDt desc, e.cca_id asc, e.cca_order asc";
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        foreach($result as $k => $v){
            // 실명 없는 경우 닉네임으로 대체
			if($v['mem_username'] == ''){
				$result[$k]['mem_username'] = $v['mem_nickname'];
			}

            // 수료일자
			$sql = "select mp_endDt from cb_member_lms_end_log where mp_sno = ".$v['mp_sno'];
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			if(!$rowdata['mp_endDt']){
				$result[$k]['mp_endDt'] = '0000-00-00';
			} else {
				$result[$k]['mp_endDt'] = substr($rowdata['mp_endDt'], 0, 10);
			}

            // 상위 카테고리
            $sql = "select cca_value from cb_category where cca_id = '".$v['cca_parent']."'";
            $r = $this->db->query($sql);
            $rowdata = $r->row_array();
            $result[$k]['cca_parent_value'] = $rowdata['cca_value'];
        }

        // 교육 이수증 end

		$view['view']['list']['board'] = $result;

		$sql = "select cca_id, cca_value from cb_category where cca_parent = 0 order by cca_order asc";
		$r = $this->db->query($sql);
		$rst = $r->result_array();
		$view['view']['list']['cca_parent'] = $rst;

		if($this->input->get('cca_id_fir')){
			$sql = "select cca_id, cca_value from cb_category where cca_parent = ".$this->input->get('cca_id_fir')." order by cca_order asc";
			$r = $this->db->query($sql);
			$rst2 = $r->result_array();
			$view['view']['list']['cca_child'] = $rst2;
		}

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/cert?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

        /**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('p_title' => '과정명');
		$view['view']['list_skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);

		if ($export === 'excel') {

			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=교육이수증_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/cert_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'cert');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

	/**
	 * 교육 이수증 출력 단건
	 */
    public function cert_export($mp_sno = 0)
    {
        $view = array();
		$view['view'] = array();

        $mp_sno = (int) $mp_sno;
		if (empty($mp_sno) OR $mp_sno < 1) {
			show_404();
		}

        $sql = "select * from cb_my_process where mp_sno = ".$mp_sno;
        $r = $this->db->query($sql);
        $result = $r->row_array();
		$result['mp_endDt'] = substr($result['mp_endDt'], 0, 10);
        
        $sql = "select a.mem_userid, a.mem_div, a.mem_username, a.mem_nickname, b.company_name from cb_member as a left join cb_company_info as b on b.company_idx = a.company_idx where a.mem_id = ".$result['mem_id'];
        $r = $this->db->query($sql);
        $rowdata = $r->row_array();
		$result['mem_userid'] = $rowdata['mem_userid'];
		$result['mem_div'] = $rowdata['mem_div'];
        if(!$rowdata['mem_username']){
            $result['mem_username'] = $rowdata['mem_nickname'];
        } else {
            $result['mem_username'] = $rowdata['mem_username'];
        }
        $result['company_name'] = $rowdata['company_name'];

        $sql = "select p_title from cb_lms_process where p_sno = ".$result['p_sno'];
        $r = $this->db->query($sql);
        $rowdata = $r->row_array();
        $result['p_title'] = $rowdata['p_title'];

        $sql = "select mps_playTime from cb_my_process_sub where mp_sno = ".$mp_sno." and mps_type = 'v'";
        $r = $this->db->query($sql);
        $rowdata = $r->row_array();
        $seconds = $rowdata['mps_playTime'];
        $H = floor($seconds / 3600);
        $i = floor(($seconds / 60) % 60);
        $s = $seconds % 60;
        $result['p_time'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

		// 수료일자
		$sql = "select mp_endDt from cb_member_lms_end_log where mp_sno = ".$mp_sno;
		$r = $this->db->query($sql);
		$rowdata = $r->row_array();
		if(!$rowdata['mp_endDt']){
			$result['cert_date'] = date('Y-m-d');
		} else {
			$result['cert_date'] = substr($rowdata['mp_endDt'], 0, 10);
		}

        $view['view']['post'] = $result;

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'cert_export');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));

    }

	/**
	 * 교육 이수증 출력 다건
	 */
    public function cert_export_all($company_idx = 0)
    {
        $view = array();
		$view['view'] = array();

        $company_idx = (int) $company_idx;
		if (empty($company_idx) OR $company_idx < 1) {
			show_404();
		}

		$searchWhere = "";

        // 부서 검색
        if($this->input->get('mem_div')){
            $searchWhere .= " and b.mem_div like '%".$this->input->get('mem_div')."%' ";
        }

        // 회원 검색
        if($this->input->get('mem_username')){
            $searchWhere .= " and (b.mem_username like '%".$this->input->get('mem_username')."%' or b.mem_nickname like '%".$this->input->get('mem_username')."%') ";
        }

        // 기간 검색
        $list_start_date = $view['view']['list_start_date'] = $this->input->get('list_start_date');
        $list_end_date = $view['view']['list_end_date'] = $this->input->get('list_end_date');
		$list_ymd = $view['view']['list_ymd'] = $this->input->get('list_ymd');
		if(!$list_ymd){
			if($list_start_date && $list_end_date){
				$searchWhere .= " and a.mp_endDt >= '".$list_start_date." 00:00:00' and a.mp_endDt <= '".$list_end_date." 23:59:59' ";
				$view['view']['list_ymd'] = '';
			}
		} else {
			if($list_ymd == 'day'){
				$view['view']['list_start_date'] = date('Y-m-d');
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '7day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-7 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '15day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-15 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '1month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-1 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '3month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-3 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$searchWhere .= " and a.mp_endDt >= '".$view['view']['list_start_date']." 00:00:00' and a.mp_endDt <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else {
				$view['view']['list_start_date'] = '';
				$view['view']['list_end_date'] = '';
			}
		}

        if($this->input->get('cca_id_fir')){
            if($this->input->get('cca_id_sec')){
                $searchWhere .= " and f.cca_id = ".$this->input->get('cca_id_sec');
            } else {
                $searchWhere .= " and f.cca_parent = ".$this->input->get('cca_id_fir');
            }
        }

        // 과정명 검색
        if($this->input->get('list_skeyword')){
			$searchWhere .= " and d.p_title like '%".$this->input->get('list_skeyword')."%' ";
		}
		
		$sql = "select a.*, b.mem_userid, b.mem_username, b.mem_nickname, b.mem_div, c.company_name, d.p_title, f.cca_value, f.cca_parent from cb_my_process as a 
        left join cb_member as b on b.mem_id = a.mem_id 
		left join cb_company_info as c on c.company_idx = b.company_idx 
        left join cb_lms_process as d on d.p_sno = a.p_sno 
        left join cb_lms_process_category as e on e.p_sno = a.p_sno 
        left join cb_category as f on f.cca_id = e.cca_id 
        where b.company_idx = ".$company_idx.$searchWhere." and a.mp_endYn = 'y' order by a.mp_endDt desc, f.cca_id asc, f.cca_order asc";
        $r = $this->db->query($sql);
        $result = $r->result_array();
		foreach($result as $k => $v){
			$result[$k]['mp_endDt'] = substr($v['mp_endDt'], 0, 10);

			// 실명 없는 경우 닉네임으로 대체
			if($v['mem_username'] == ''){
				$result[$k]['mem_username'] = $v['mem_nickname'];
			}

			if(!$v['mem_username']){
				$result[$k]['mem_username'] = $v['mem_nickname'];
			} else {
				$result[$k]['mem_username'] = $v['mem_username'];
			}

			$sql = "select mps_playTime from cb_my_process_sub where mp_sno = ".$v['mp_sno']." and mps_type = 'v'";
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			$seconds = $rowdata['mps_playTime'];
			$H = floor($seconds / 3600);
			$i = floor(($seconds / 60) % 60);
			$s = $seconds % 60;
			$result[$k]['p_time'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

			$sql = "select mp_endDt from cb_member_lms_end_log where mp_sno = ".$v['mp_sno'];
			$r = $this->db->query($sql);
			$rowdata = $r->row_array();
			if(!$rowdata['mp_endDt']){
				$result[$k]['cert_date'] = date('Y-m-d');
			} else {
				$result[$k]['cert_date'] = substr($rowdata['mp_endDt'], 0, 10);
			}

		}

        $view['view']['post'] = $result;

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'cert_export_all');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

	/**
	 * 서브카테고리 불러오기
	 */
	public function getCcaChild()
	{
		$post = $this->input->post();

		if($post['mode'] == 'getCcaChild'){
			$sql = "select cca_id, cca_value from cb_category where cca_parent = ".$post['cca_parent']." order by cca_order asc";
			$r = $this->db->query($sql);
			$rst = $r->result_array();

			$result['code'] = 'ok';
			$result['msg'] = 'data load complete';
			$result['cca_list'] = $rst;
		} else {
			$result['code'] = 'fail';
			$result['msg'] = 'mode is incorrect';
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
	}

}