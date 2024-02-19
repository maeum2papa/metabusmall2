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
 * 관리자>통계>접속통계 controller 입니다.
 */
class Statcounter extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'counter/statcounter';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Stat', 'Stat_count', 'Stat_count_date', 'Post', 'Currentvisitor');

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
	 * 접속통계
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

		$sWhere = ""; 
		// 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere .= " and company_idx = ".$this->member->item('company_idx');
			}
		} 

		// 회원별 접속 현황
		$sql = "select mem_id, mem_username, mem_nickname, mem_lastlogin_datetime, acc_time from cb_member where 1 ".$sWhere." order by mem_lastlogin_datetime desc";
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

			// 접속기기
			$sql = "select mll_useragent from cb_member_login_log where mem_id = '".$v['mem_id']."' and mll_success = 1 order by mll_datetime desc limit 0, 1";
			$qry = $this->db->query($sql);
			$res = $qry->row_array();

			$useragent = get_useragent_info($res['mll_useragent']);
			if($useragent['os'] == 'windows' || $useragent['os'] == 'macintosh'){
				$result[$k]['device'] = '데스크톱';
			} else if($useragent['os'] == 'iphone' || $useragent['os'] == 'android' || $useragent['os'] == 'linux'){
				$result[$k]['device'] = '모바일';
			} else if($useragent['os'] == 'ipad' || $useragent['os'] == '-'){
				$result[$k]['device'] = '태블릿';
			}

			if(strpos($useragent['browserversion'], 'sm-t')){
				$result[$k]['device'] = '태블릿';
			}

			$result[$k]['browser'] = $useragent['browsername'];

			$seconds = $v['acc_time'];
			$H = floor($seconds / 3600);
			$i = floor(($seconds / 60) % 60);
			$s = $seconds % 60;
			$result[$k]['acctime'] = sprintf('%02d:%02d:%02d', $H, $i, $s);

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
		$search_option = array('mll_ip' => 'IP', 'mll_datetime' => '날짜', 'mll_referer' => '이전주소', 'mll_url' => '현재주소', 'mll_useragent' => 'OS/Browser');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		
		$minute = (int) $this->cbconfig->item('currentvisitor_minute');
		if ($minute < 1) {
			$minute = 10;
		}
		$curdatetime = cdate('Y-m-d H:i:s', ctimestamp() - $minute * 60);

		$cachename = 'delete_old_currentvisitor_cache';
		$cachetime = 60;
		if ( ! $result = $this->cache->get($cachename)) {
			$deletewhere = array(
				'cur_datetime < ' => $curdatetime,
			);
			$this->Currentvisitor_model->delete_where($deletewhere);
			$this->cache->save($cachename, cdate('Y-m-d H:i:s'), $cachetime);
		}

		// 접속자 통계 그래프 start
		$sWhere2 = "";
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere2 .= " and b.company_idx = ".$this->member->item('company_idx');
			}
		} 
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		$orderby = (strtolower($this->input->get('orderby')) === 'desc') ? 'desc' : 'asc';
		if($this->input->get('ymd') == 'day'){
			$sql = "SELECT date_format(mll_datetime,'%H') as mll_datetime, count(time(mll_datetime)) as mll_count FROM `cb_member_login_log` as a left join cb_member as b on b.mem_id=a.mem_id 
			WHERE 1 ".$sWhere2." and a.mll_datetime >= '".$start_date." 00:00:00' and mll_datetime <= '".$end_date." 23:59:59' and mll_success = 1 group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
			foreach($list as $k => $v){
				$sql = "select count(a.mem_id) as cnt from cb_currentvisitor as a left join cb_member as b on b.mem_id = a.mem_id 
				where a.mem_id != 0 and date_format(a.cur_datetime, '%H') = '".$v['mll_datetime']."' ".$sWhere2;
				$r = $this->db->query($sql);
				$rst = $r->row_array();
				$list[$k]['mll_count'] = $v['mll_count'] + $rst['cnt'];
			}
		} else if($this->input->get('ymd') == 'month'){
			$start_date = substr($start_date, 0, 7).'-01';
			$end_date = substr($end_date, 0, 7).'-31';
			$sql = "SELECT substring(mll_datetime, 1, 10) as mll_datetime, count(day(mll_datetime)) as mll_count FROM `cb_member_login_log` as a left join cb_member as b on b.mem_id=a.mem_id 
			WHERE 1 ".$sWhere2." and a.mll_datetime >= '".$start_date." 00:00:00' and a.mll_datetime <= '".$end_date." 23:59:59' and mll_success = 1 group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
			foreach($list as $k => $v){
				$sql = "select count(a.mem_id) as cnt from cb_currentvisitor as a left join cb_member as b on b.mem_id = a.mem_id 
				where a.mem_id != 0 and substring(a.cur_datetime, 1, 10) = '".$v['mll_datetime']."' ".$sWhere2;
				$r = $this->db->query($sql);
				$rst = $r->row_array();
				$list[$k]['mll_count'] = $v['mll_count'] + $rst['cnt'];
			}
		} else if($this->input->get('ymd') == 'year'){
			$start_year = substr($start_date, 0, 4);
			$end_year = substr($end_date, 0, 4);
			$start_month = substr($start_date, 5, 2);
			$end_month = substr($end_date, 5, 2);
			$start_year_month = $start_year * 12 + $start_month;
			$end_year_month = $end_year * 12 + $end_month;
			$start_date2 = substr($start_date, 0, 4).'-01-01';
			$end_date2 = substr($end_date, 0, 4).'-12-31';
			$sql = "SELECT substring(mll_datetime, 1, 7) as mll_datetime, count(month(mll_datetime)) as mll_count FROM `cb_member_login_log` as a left join cb_member as b on b.mem_id=a.mem_id 
			WHERE 1 ".$sWhere2." and a.mll_datetime >= '".date('Y')."-01-01 00:00:00' and a.mll_datetime <= '".date('Y')."-12-31 23:59:59' and mll_success = 1 group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
			foreach($list as $k => $v){
				$sql = "select count(a.mem_id) as cnt from cb_currentvisitor as a left join cb_member as b on b.mem_id = a.mem_id 
				where a.mem_id != 0 and substring(a.cur_datetime, 1, 7) = '".$v['mll_datetime']."' ".$sWhere2;
				$r = $this->db->query($sql);
				$rst = $r->row_array();
				$list[$k]['mll_count'] = $v['mll_count'] + $rst['cnt'];
			}
		} else {
			$sql = "SELECT date_format(mll_datetime,'%H') as mll_datetime, count(time(mll_datetime)) as mll_count FROM `cb_member_login_log` as a left join cb_member as b on b.mem_id=a.mem_id 
			WHERE 1 ".$sWhere2." and a.mll_datetime >= '".$start_date." 00:00:00' and a.mll_datetime <= '".$end_date." 23:59:59' and mll_success = 1 group by 1 order by mll_datetime asc";
			$data = $this->db->query($sql);
			$list = $data->result_array();
			foreach($list as $k => $v){
				$sql = "select count(a.mem_id) as cnt from cb_currentvisitor as a left join cb_member as b on b.mem_id = a.mem_id 
				where a.mem_id != 0 and date_format(a.cur_datetime, '%H') = '".$v['mll_datetime']."' ".$sWhere2;
				$r = $this->db->query($sql);
				$rst = $r->row_array();
				$list[$k]['mll_count'] = $v['mll_count'] + $rst['cnt'];
			}
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

		if($this->input->get('ymd') == 'day'){
			// 오늘 방문자수
			$nowymd = date('Y-m-d');
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime >= '".$nowymd." 00:00:00' and a.mll_datetime <= '".$nowymd." 23:59:59' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();

			$view['view']['list']['graphEx']['nowymd']['name'] = '오늘 방문수';
			$view['view']['list']['graphEx']['nowymd']['count'] = $row['cnt'];

			// 어제 방문자수
			$exymd = date('Y-m-d', strtotime('-1 day'));
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime >= '".$exymd." 00:00:00' and a.mll_datetime <= '".$exymd." 23:59:59' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();

			$view['view']['list']['graphEx']['exymd']['name'] = '어제 방문수';
			$view['view']['list']['graphEx']['exymd']['count'] = $row['cnt'];

			// 누적 방문자수
			$accymd = $nowymd.' 23:59:59';
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime <= '".$accymd."' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();	

			$view['view']['list']['graphEx']['accymd']['name'] = '누적 방문수';
			$view['view']['list']['graphEx']['accymd']['count'] = $row['cnt'];
		} else if($this->input->get('ymd') == 'month'){
			// 이번달 방문자수
			$nowymd = date('Y-m');
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime >= '".$nowymd."-01 00:00:00' and a.mll_datetime <= '".$nowymd."-31 23:59:59' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();
			$view['view']['list']['graphEx']['nowymd']['name'] = '이번달 방문수';
			$view['view']['list']['graphEx']['nowymd']['count'] = $row['cnt'];

			// 지난달 방문자수
			$exymd = date('Y-m', strtotime('-1 month'));
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime >= '".$exymd."-01 00:00:00' and a.mll_datetime <= '".$exymd."-31 23:59:59' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();
			$view['view']['list']['graphEx']['exymd']['name'] = '지난달 방문수';
			$view['view']['list']['graphEx']['exymd']['count'] = $row['cnt'];

			// 누적 방문자수
			$accymd = $nowymd.'-31 23:59:59';
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime <= '".$accymd."' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();
			$view['view']['list']['graphEx']['accymd']['name'] = '누적 방문수';
			$view['view']['list']['graphEx']['accymd']['count'] = $row['cnt'];
		} else if($this->input->get('ymd') == 'year'){
			// 올해 방문자수
			$nowymd = date('Y');
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime >= '".$nowymd."-01-01 00:00:00' and a.mll_datetime <= '".$nowymd."-12-31 23:59:59' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();
			$view['view']['list']['graphEx']['nowymd']['name'] = '올해 방문수';
			$view['view']['list']['graphEx']['nowymd']['count'] = $row['cnt'];

			// 작년 방문자수
			$exymd = date('Y', strtotime('-1 year'));
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime >= '".$exymd."-01-01 00:00:00' and a.mll_datetime <= '".$exymd."-12-31 23:59:59' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();
			$view['view']['list']['graphEx']['exymd']['name'] = '작년 방문수';
			$view['view']['list']['graphEx']['exymd']['count'] = $row['cnt'];

			// 누적 방문자수
			$accymd = $nowymd.'-12-31 23:59:59';
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime <= '".$accymd."' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();
			$view['view']['list']['graphEx']['accymd']['name'] = '누적 방문수';
			$view['view']['list']['graphEx']['accymd']['count'] = $row['cnt'];
		} else {
			// 오늘 방문자수
			$nowymd = date('Y-m-d');
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime like '".$nowymd."%' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();

			$view['view']['list']['graphEx']['nowymd']['name'] = '오늘 방문수';
			$view['view']['list']['graphEx']['nowymd']['count'] = $row['cnt'];

			// 어제 방문자수
			$exymd = date('Y-m-d', strtotime('-1 day'));
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime like '".$exymd."%' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();

			$view['view']['list']['graphEx']['exymd']['name'] = '어제 방문수';
			$view['view']['list']['graphEx']['exymd']['count'] = $row['cnt'];

			// 누적 방문자수
			$accymd = $nowymd.' 23:59:59';
			$sql = "select count(mll_id) as cnt from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and a.mll_datetime <= '".$accymd."' ".$sWhere2;
			$r = $this->db->query($sql);
			$row = $r->row_array();

			$view['view']['list']['graphEx']['accymd']['name'] = '누적 방문수';
			$view['view']['list']['graphEx']['accymd']['count'] = $row['cnt'];
		}
		

		// 접속자 통계 그래프 end

		// 기기별 그래프 start
		$sWhere3 = "";
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere3 .= " and member.company_idx = ".$this->member->item('company_idx');
			}
		} 
		$custom_datetime = date('Y-m-d');
		$custom_day = substr($custom_datetime, 8, 2);
		$custom_month = substr($custom_datetime, 5, 2);
		$custom_year = substr($custom_datetime, 0, 4);
		if($this->input->get('ymd') == 'day'){
			$sql = "SELECT mll_useragent FROM cb_member_login_log as member_login_log 
			left join cb_member as member on member.mem_id = member_login_log.mem_id 
			WHERE 1 ".$sWhere3." and mll_datetime >= '".$custom_datetime." 00:00:00' and mll_datetime <= '".$custom_datetime." 23:59:59' and mll_success = 1 ORDER BY mll_datetime desc";
			$r = $this->db->query($sql);
			$result2 = $r->result_array();
		} else if($this->input->get('ymd') == 'month'){
			$sql = "SELECT mll_useragent FROM cb_member_login_log as member_login_log 
			left join cb_member as member on member.mem_id = member_login_log.mem_id 
			WHERE 1 ".$sWhere3." and month(mll_datetime) = '".$custom_month."' and year(mll_datetime) = '".$custom_year."' and mll_success = 1 ORDER BY mll_datetime desc";
			$r = $this->db->query($sql);
			$result2 = $r->result_array();
		} else if($this->input->get('ymd') == 'year'){
			$sql = "SELECT mll_useragent FROM cb_member_login_log as member_login_log 
			left join cb_member as member on member.mem_id = member_login_log.mem_id 
			WHERE 1 ".$sWhere3." and year(mll_datetime) = '".$custom_year."' and mll_success = 1 ORDER BY mll_datetime desc";
			$r = $this->db->query($sql);
			$result2 = $r->result_array();
		} else {
			$sql = "SELECT mll_useragent FROM cb_member_login_log as member_login_log 
			left join cb_member as member on member.mem_id = member_login_log.mem_id 
			WHERE 1 ".$sWhere3." and day(mll_datetime) = '".$custom_day."' and month(mll_datetime) = '".$custom_month."' and year(mll_datetime) = '".$custom_year."' and mll_success = 1 ORDER BY mll_datetime desc";
			$r = $this->db->query($sql);
			$result2 = $r->result_array();
		}
		
		$sum_count = 0;
		$arr = array();
		$max = 0;
		if ($result2 && is_array($result2)) {
			foreach ($result2 as $key => $value) {
				$userAgent = get_useragent_info(element('mll_useragent', $value));
				$s = $userAgent['os'];
				if (empty($s)) {
					$s = '-';
				}
				if ( ! isset($arr[$s])) {
					$arr[$s] = 0;
				}
				$arr[$s]++;

				if ($arr[$s] > $max) {
					$max = $arr[$s];
				}

				$sum_count++;
			}
		}

		$view['view']['list']['device'] = array();
		$i = 0;
		$k = 0;
		$save_count = -1;
		$tot_count = 0;

		if (count($arr)) {
			arsort($arr);
			$arr2['pc'] = $arr['windows'] + $arr['macintosh'];
			$arr2['mo'] = $arr['iphone'] + $arr['android'] + $arr['linux'];
			$arr2['tb'] = $arr['ipad'] + $arr['sm-t'];

			foreach ($arr2 as $key => $value) {
				$count = (int) $arr2[$key];
				$view['view']['list']['device'][$k]['count'] = $count;
				$i++;
				if ($save_count !== $count) {
					$no = $i;
					$save_count = $count;
				}
				$view['view']['list']['device'][$k]['no'] = $no;

				if ($key === '-') {
					$key = '알수없음';
				}
				$view['view']['list']['device'][$k]['key'] = $key;
				$rate = ($count / $sum_count * 100);
				$view['view']['list']['device'][$k]['rate'] = $rate;
				$s_rate = number_format($rate, 1);
				$view['view']['list']['device'][$k]['s_rate'] = $s_rate;

				$bar = (int)($count / $max * 100);
				$view['view']['list']['device'][$k]['bar'] = $bar;

				$k++;
			}
			$view['view']['device']['max_value'] = $max;
			$view['view']['device']['sum_count'] = $sum_count;
		}
		foreach($view['view']['list']['device'] as $kk => $vv){
			if($vv['key'] == 'pc'){
				$view['view']['list']['device'][$kk]['name'] = '데스크톱';
			} else if($vv['key'] == 'mo'){
				$view['view']['list']['device'][$kk]['name'] = '모바일';
			} else if($vv['key'] == 'tb'){
				$view['view']['list']['device'][$kk]['name'] = '태블릿';
			}
		}
		// 기기별 그래프 end


		if ($export === 'excel') {

			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=회원별접속현황_' . cdate('Y_m_d') . '.xls');
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
	 * 접속통계 > 접속자 통계 그래프 더보기
	 */
	public function users($export = '')
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

		$minute = (int) $this->cbconfig->item('currentvisitor_minute');
		if ($minute < 1) {
			$minute = 10;
		}
		$curdatetime = cdate('Y-m-d H:i:s', ctimestamp() - $minute * 60);

		$cachename = 'delete_old_currentvisitor_cache';
		$cachetime = 60;
		if ( ! $result = $this->cache->get($cachename)) {
			$deletewhere = array(
				'cur_datetime < ' => $curdatetime,
			);
			$this->Currentvisitor_model->delete_where($deletewhere);
			$this->cache->save($cachename, cdate('Y-m-d H:i:s'), $cachetime);
		}

		$where = array();
        // 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$company_idx = $this->member->item('company_idx');
			}
		} 
		$view['view']['start_date'] = $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : cdate('Y-m-d');
		$view['view']['end_date'] = $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : cdate('Y-m-d');
		if($this->input->get('ymd') == 'month'){
			if($start_date == $end_date){
				$start_date = substr($start_date, 0, 7).'-01';
				$end_date = substr($end_date, 0, 7).'-31';
			}
		} else if($this->input->get('ymd') == 'year'){
			if($start_date == $end_date){
				$start_date = substr($start_date, 0, 4).'-01-01';
				$end_date = substr($end_date, 0, 4).'-12-31';
			}
		}
		
		if($this->input->get('ymd') == 'day'){
			$select = 'date_format(mll_datetime,"%H") as mll_datetime';
			$start_date = $start_date.' 00:00:00';
			$end_date = $end_date.' 23:59:59';
		} else if($this->input->get('ymd') == 'month'){
			$select = 'substring(mll_datetime, 1, 10) as mll_datetime';
		} else if($this->input->get('ymd') == 'year'){
			$select = 'substring(mll_datetime, 1, 7) as mll_datetime';
		} else {
			$select = 'date_format(mll_datetime,"%H") as mll_datetime';
			$start_date = $start_date.' 00:00:00';
			$end_date = $end_date.' 23:59:59';
		}
		$sql = "select ".$select." from cb_member_login_log as a 
		left join cb_member as b on b.mem_id = a.mem_id where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and 
		a.mll_success = 1 group by 1 order by a.mll_datetime desc";
		$r = $this->db->query($sql);
		$result = $r->result_array();
		$total_rows = count($result);

		$sql .= " limit ".$offset.",".$per_page;
		$r = $this->db->query($sql);
		$result = $r->result_array();

		foreach($result as $key => $value){
			if($this->input->get('ymd') == 'day'){
				$like = date('Y-m-d', strtotime($start_date))." ".$value['mll_datetime']."%";
			} else if($this->input->get('ymd') == 'month'){
				$like = $value['mll_datetime']."%";
			} else if($this->input->get('ymd') == 'year'){
				$like = $value['mll_datetime']."%";
			} else {
				$like = date('Y-m-d', strtotime($start_date))." ".$value['mll_datetime']."%";
			}
			$q = "select count(mll_id) as visit_count from cb_member_login_log as a 
			left join cb_member as b on b.mem_id = a.mem_id where a.mll_datetime like '".$like."' and b.company_idx = ".$company_idx." and a.mll_success = 1";
			$r = $this->db->query($q);
			$res1 = $r->row_array();

			$result[$key]['visit_count'] = $res1['visit_count'];

			if($this->input->get('ymd') == 'day'){
				$datetime = date('Y-m-d', strtotime($start_date)).' '.$value['mll_datetime'].':59:59';
			} else if($this->input->get('ymd') == 'month'){
				$datetime = $value['mll_datetime'].' 23:59:59';
			} else if($this->input->get('ymd') == 'year'){
				$datetime = $value['mll_datetime'].'-31 23:59:59';
			} else {
				$datetime = date('Y-m-d', strtotime($start_date)).' '.$value['mll_datetime'].':59:59';
			}

			$q = "select count(mll_id) as visit_count from cb_member_login_log as a 
			left join cb_member as b on b.mem_id = a.mem_id where a.mll_datetime <= '".$datetime."' and b.company_idx = ".$company_idx." and a.mll_success = 1";
			//var_dump($q);
			$r = $this->db->query($q);
			$res2 = $r->row_array();

			$result[$key]['acc_visit_count'] = $res2['visit_count'];
		}

		$view['view']['list']['board'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/users?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		if ($export === 'excel') {
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=접속자통계_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/users_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'users');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

	/**
	 * 접속통계 > 기기별 그래프 더보기
	 */
	public function devices($export = '')
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

		$where = array();
        // 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$company_idx = $this->member->item('company_idx');
			}
		} 
		$view['view']['start_date'] = $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : date('Y-m-d');
		$view['view']['end_date'] = $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : date('Y-m-d');
		if($this->input->get('ymd') == 'month'){
			if($start_date == $end_date){
				$start_date = substr($start_date, 0, 7).'-01';
				$end_date = substr($end_date, 0, 7).'-31';
			}
		} else if($this->input->get('ymd') == 'year'){
			if($start_date == $end_date){
				$start_date = substr($start_date, 0, 4).'-01-01';
				$end_date = substr($end_date, 0, 4).'-12-31';
			}
		}
		
		$start_year = substr($start_date, 0, 4);
		$end_year = substr($end_date, 0, 4);
		$start_month = substr($start_date, 0, 7);
		$end_month = substr($end_date, 0, 7);
		
		if($this->input->get('ymd') == 'day'){
			$start_date = $start_date.' 00:00:00';
			$end_date = $end_date.' 23:59:59';
		} else if($this->input->get('ymd') == 'month'){
			$start_date = $start_month.'-01 00:00:00';
			$end_date = $end_month.'-31 23:59:59';
		} else if($this->input->get('ymd') == 'year'){
			$start_date = $start_year.'-01-01 00:00:00';
			$end_date = $end_year.'-12-31 23:59:59';
		} else {
			$start_date = $start_date.' 00:00:00';
			$end_date = $end_date.' 23:59:59';
		}

		

		if($this->input->get('deviceFl') == 'mobile'){
			$select = "(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%iphone%' or a.mll_useragent like '%android%' or a.mll_useragent like '%linux%')) as mobileCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%iphone%' or a.mll_useragent like '%android%' or a.mll_useragent like '%linux%')) as mobileAccCnt";
		} else if($this->input->get('deviceFl') == 'desktop'){
			$select = "(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%windows%' or a.mll_useragent like '%macintosh%')) as desktopCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%windows%' or a.mll_useragent like '%macintosh%')) as desktopAccCnt";
		} else if($this->input->get('deviceFl') == 'tablet'){
			$select = "(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%ipad%' or (a.mll_useragent not like '%iphone%' and a.mll_useragent not like '%android%' and a.mll_useragent not like '%linux%' and a.mll_useragent not like '%windows%' and a.mll_useragent not like '%macintosh%'))) as tabletCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%ipad%' or (a.mll_useragent not like '%iphone%' and a.mll_useragent not like '%android%' and a.mll_useragent not like '%linux%' and a.mll_useragent not like '%windows%' and a.mll_useragent not like '%macintosh%'))) as tabletAccCnt";
		} else {
			$select = "(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%iphone%' or a.mll_useragent like '%android%' or a.mll_useragent like '%linux%')) as mobileCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%iphone%' or a.mll_useragent like '%android%' or a.mll_useragent like '%linux%')) as mobileAccCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%windows%' or a.mll_useragent like '%macintosh%')) as desktopCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%windows%' or a.mll_useragent like '%macintosh%')) as desktopAccCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime >= '".$start_date."' and a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%ipad%' or (a.mll_useragent not like '%iphone%' and a.mll_useragent not like '%android%' and a.mll_useragent not like '%linux%' and a.mll_useragent not like '%windows%' and a.mll_useragent not like '%macintosh%'))) as tabletCnt, 
			(select count(a.mll_useragent) from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id 
			where a.mll_datetime <= '".$end_date."' and b.company_idx = ".$company_idx." and a.mll_success = 1 
			and (a.mll_useragent like '%ipad%' or (a.mll_useragent not like '%iphone%' and a.mll_useragent not like '%android%' and a.mll_useragent not like '%linux%' and a.mll_useragent not like '%windows%' and a.mll_useragent not like '%macintosh%'))) as tabletAccCnt";
		}
		$sql = "select ".$select." from cb_member_login_log as a left join cb_member as b on b.mem_id = a.mem_id where a.mll_success = 1 and b.company_idx = ".$company_idx." group by 1";
		$r = $this->db->query($sql);
		$result = $r->row_array();
		if($this->input->get('deviceFl') == 'mobile'){
			$data = array(
				array(
					'device_type' => '모바일',
					'visit_count' => $result['mobileCnt'],
					'acc_visit_count' => $result['mobileAccCnt']
				)
			);
		} else if($this->input->get('deviceFl') == 'desktop'){
			$data = array(
				array(
					'device_type' => '데스크톱',
					'visit_count' => $result['desktopCnt'],
					'acc_visit_count' => $result['desktopAccCnt']
				)
			);
		} else if($this->input->get('deviceFl') == 'tablet'){
			$data = array(
				array(
					'device_type' => '태블릿',
					'visit_count' => $result['tabletCnt'],
					'acc_visit_count' => $result['tabletAccCnt']
				)
			);
		} else {
			$data = array(
				array(
					'device_type' => '모바일',
					'visit_count' => $result['mobileCnt'],
					'acc_visit_count' => $result['mobileAccCnt']
				), array(
					'device_type' => '데스크톱',
					'visit_count' => $result['desktopCnt'],
					'acc_visit_count' => $result['desktopAccCnt']
				), array(
					'device_type' => '태블릿',
					'visit_count' => $result['tabletCnt'],
					'acc_visit_count' => $result['tabletAccCnt']
				)
			);
		}
		

		$view['view']['list']['board'] = $data;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '/devices?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		if ($export === 'excel') {
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=기기별통계_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/devices_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'devices');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

}
