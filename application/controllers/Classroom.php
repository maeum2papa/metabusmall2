<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mypage class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 마이페이지와 관련된 controller 입니다.
 */
class Classroom extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Lmsprocess','Classroom');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Classroom_model';
	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'cmall', 'dhtml_editor');
	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring'));
		if (!$this->member->is_member()) {
			redirect('https://collaborland.kr/');
		}else{
			$this->load->library(array('pagination', 'querystring', 'accesslevel', 'cmalllib'));
		}
	}


	/**
	 * 페이지기본 기본
	 */
	public function index()
	{
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'main',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "클래스룸",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "클래스룸",
		);
		$today = date("Ymd");
		//$where[] = "(cb_lms_process.p_viewYn = 'y' or (cb_lms_process.p_viewYn = 's' and cb_lms_process.p_sdate <= ".$today." and cb_lms_process.p_edate >= ".$today."))";
		$basic_where[] = "(p.p_viewYn = 'y' or (p.p_viewYn = 's' and p.p_sdate <= ".$today." and p.p_edate >= ".$today."))";
		//수강중인강의
		$my_where = $basic_where;
		$my_where[] = "mp.mem_id = '".$this->member->item('mem_id')."'";
		$q = "select p.p_title, p.p_thumbnail, p.p_sno as index2, p.p_viewYn, p.p_sdate, p.p_edate,  mp.mp_sno,  mp.mp_endYn from cb_lms_process as p inner join cb_my_process as mp on p.p_sno = mp.p_sno where ".implode(" and ",$my_where)." order by p.p_essentialYn  desc, p.p_recommendYn, p.p_sno desc limit 10";
		//debug($q);
		$r = $this->db->query($q);
		$view['now']['list'] = $r->result_array(); 
		//필수강의
		$ess_where = $basic_where;
		$ess_where[] = "p.p_essentialYn = 'y'";
		$q = "select p.p_title, p.p_thumbnail, p.p_sno as index2 from cb_lms_process as p where ".implode(" and ",$ess_where)." order by p.p_essentialYn  desc, p.p_recommendYn, p.p_sno desc limit 10";
		$r = $this->db->query($q);
		$essential = $r->result_array();
		if($essential){
			foreach ($essential as $k => $v){
				$q = "select mp_sno, p_sno from cb_my_process where mem_id = '".$this->member->item('mem_id')."' and p_sno = '".$v[index2]."'";
				$r = $this->db->query($q);
				$cb_my_process = (array) $r->row();
				if($cb_my_process[p_sno]){
					$v[p_sno] = $cb_my_process[p_sno];
				}
				$view['ess']['list'][] = $v;
			}	
		}
		
		//$view['ess']['list'] = $r->result_array(); 
		//debug($view['ess']['list']);
		//추천강의
		$rec_where = $basic_where;
		$rec_where[] = "p.p_recommendYn = 'y'";
		$q = "select p.p_title, p.p_thumbnail, p.p_sno as index2 from cb_lms_process as p where ".implode(" and ",$rec_where)." order by p.p_recommendYn desc, p.p_essentialYn, p.p_sno desc limit 10";
		$r = $this->db->query($q);
		$rec = $r->result_array(); 
		if($rec){
			foreach ($rec as $k => $v){
				$q = "select mp_sno, p_sno from cb_my_process where mem_id = '".$this->member->item('mem_id')."' and p_sno = '".$v[index2]."'";
				$r = $this->db->query($q);
				$cb_my_process = (array) $r->row();
				if($cb_my_process[p_sno]){
					$v[p_sno] = $cb_my_process[p_sno];
				}
				$view['rec']['list'][] = $v;
			}	
		}
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 *  강의 상세
	 */
	public function detail()
	{
		//입뺀인지 확인
		if(!$_GET[p_sno]){
			alert('올바른 경로로 접근해주세요!','https://collaborland.kr/');
		}else{
			$business_exYn = business_exYn($_GET[p_sno],$this->member->item('company_idx'));
			if($business_exYn == 'y'){
				alert('비활성화 된 강의입니다. 관리자에 문의해주세요!','/classroom');
			}else{
				//기업 등급과 노출 추가등을 따져서 수강신청이 가능한지 판단함 f면 뻥카, y 면 수강신청가능, n 이면 불가
				$view['business_studyYn'] = business_studyYn($_GET[p_sno],$this->member->item('company_idx'));
				//가능한 것 중에 난 이미 수강신청했는지
				$q = "select * from cb_my_process where p_sno = '".$_GET[p_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
				$r = $this->db->query($q);
				$my_process = (array) $r->row();
				if($my_process[mp_sno]){ //이미 했다면 a
					$view['business_studyYn'] = 'a';
				}
			}
		}
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'detail',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "강의상세",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "강의상세",
			);
		
		//프로젝트 정보
		$q = "select * from cb_lms_process where p_sno = '".$_GET[p_sno]."'";
		$r = $this->db->query($q);
		$view['p_data'] = (array) $r->row();
		//카테고리
		$q = "select c.cca_value, c.cca_id from cb_lms_process_category as pc left join cb_category as c on pc.cca_id = c.cca_id where pc.p_sno = '".$_GET[p_sno]."' order by c.cca_parent asc, c.cca_order";
		$r = $this->db->query($q);
		$view['category']['list'] = $r->result_array(); 
		//debug($view['category']['list']);
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function my_class()
	{
		
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$sfield = $this->input->get('sfield', null, '');
		$forder = $this->input->get('forder', null, 'desc');
		
		
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array();
		$where['my_process.mem_id'] = $this->member->item('mem_id');
		$where['my_process.mp_endYn'] = 'n';

		
		
		$result = $this->{$this->modelname}->get_myclass_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				if($val[p_essentialYn] == 'y'){
					$result['list'][$key]['essentialYn'] = '추천';
				}else{
					$result['list'][$key]['essentialYn'] = '-';
				}
				
				$q = "select c.cca_value, count(pc.c_sno) as cnt from cb_lms_process_category as pc left join cb_category as c on pc.cca_id = c.cca_id where pc.p_sno = '".$val[p_sno]."'";
				$r = $this->db->query($q);
				$cate_data = (array) $r->row();
				if($cate_data[cnt] > 1){
					$cnt = $cate_data[cnt] - 1;
					$result['list'][$key]['category'] = $cate_data[cca_value]." 외".$cnt."건";
				}else{
					$result['list'][$key]['category'] = $cate_data[cca_value];
				}
				if($val[p_viewYn] == 'y'){
					$result['list'][$key]['view_time'] = "상시 노출";
				}else{
					$result['list'][$key]['view_time'] = substr($val[p_sdate], 0, 4).".".substr($val[p_sdate], 4, 2).".".substr($val[p_sdate], 6, 2)." ~ ".substr($val[p_edate], 0, 4).".".substr($val[p_edate], 4, 2).".".substr($val[p_edate], 6, 2);
				}
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('classroom/my_class?') . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'my_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "나의수강목록",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "나의수강목록",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function complete_class()
	{
		
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$sfield = $this->input->get('sfield', null, '');
		$forder = $this->input->get('forder', null, 'desc');
		
		
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array();
		$where['my_process.mem_id'] = $this->member->item('mem_id');
		$where['my_process.mp_endYn'] = 'y';

		
		
		$result = $this->{$this->modelname}->get_myclass_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				if($val[p_essentialYn] == 'y'){
					$result['list'][$key]['essentialYn'] = '추천';
				}else{
					$result['list'][$key]['essentialYn'] = '-';
				}
				
				$q = "select c.cca_value, count(pc.c_sno) as cnt from cb_lms_process_category as pc left join cb_category as c on pc.cca_id = c.cca_id where pc.p_sno = '".$val[p_sno]."'";
				$r = $this->db->query($q);
				$cate_data = (array) $r->row();
				if($cate_data[cnt] > 1){
					$cnt = $cate_data[cnt] - 1;
					$result['list'][$key]['category'] = $cate_data[cca_value]." 외".$cnt."건";
				}else{
					$result['list'][$key]['category'] = $cate_data[cca_value];
				}
				if($val[p_viewYn] == 'y'){
					$result['list'][$key]['view_time'] = "상시 노출";
				}else{
					$result['list'][$key]['view_time'] = substr($val[p_sdate], 0, 4).".".substr($val[p_sdate], 4, 2).".".substr($val[p_sdate], 6, 2)." ~ ".substr($val[p_edate], 0, 4).".".substr($val[p_edate], 4, 2).".".substr($val[p_edate], 6, 2);
				}
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('classroom/complete_class?') . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'complete_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "수강완료과정",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "수강완료과정",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function business_class()
	{

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$sfield = $this->input->get('sfield', null, '');
		$forder = "my_process.mp_sno";
		
		
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$like = array();
		
		if($_GET[menu]){
			$like['lms_process.p_cate'] = $_GET[menu];
		}
		$where = array();
		if($_GET[ess] == 'y'){
			$where['lms_process.p_essentialYn'] = 'y';
		}
		
		$result = $this->Lmsprocess_model->get_user_list($per_page, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, '', $this->member->item('mem_id'));
		
		
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				$result['list'][$key]['category'] = explode('*|*',$val[p_cate]);
				
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('classroom/business_class?') . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'business_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "기업강의목록",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "기업강의목록",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

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

        $layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'cert_export',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "수료증출력",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "수료증출력",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function player()
	{
		//debug($_SESSION);
		//debug($_COOKIE);
		//입뺀인지 확인
		if(!$_GET[mp_sno]){
			alert('올바른 경로로 접근해주세요!','/classroom');
		}else{
			//게임은 필요없고 동영상 사이트만 캐시체크
			
			$q = "select mp.*, p.* from cb_my_process as mp inner join cb_lms_process as p on mp.p_sno = p.p_sno where mp.mp_sno = '".$_GET[mp_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
			$r = $this->db->query($q);
			$my_process = (array) $r->row();
			
			if($my_process[mp_sno]){
				$business_exYn = business_exYn($my_process[p_sno],$this->member->item('company_idx'));
				if($business_exYn == 'y'){
					alert('비활성화 된 강의입니다. 관리자에 문의해주세요!','/classroom');
				}else{
					//내가 수강한 강의가 맞는지 확인
					$q = "select mp_sno from cb_my_process where p_sno = '".$my_process[p_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
					$r = $this->db->query($q);
					$my_process2 = (array) $r->row();
					if($my_process2[mp_sno]){ //내가 수강한 강의가 맞다면
						
						$q = "select mps.* from cb_my_process as mp left join cb_my_process_sub as mps on mp.mp_sno = mps.mp_sno where mp.mp_sno = '".$_GET[mp_sno]."' and mp.mem_id = '".$this->member->item('mem_id')."' order by mps.mps_sno";
						$r = $this->db->query($q);
						$curriculum = $r->result_array();
						//mps_sno = 
						if(!$_GET[mps_sno]){
							$_GET[mps_sno] = $curriculum[0][mps_sno];
						}
						
						$moveYn = 0; //이동 가능 커리큘럼
						foreach ($curriculum as $k => $v){
							//이동 가능 커리큘럼, 완료된게 있으면 그거보다 하나 + 하도록
							if($v[mps_endYn] == 'y'){
								$moveYn++;	
							}
							
							if($v[mps_sno] == $_GET[mps_sno]){ //커리큘럼 배열의 키값 찾기
								$mps_sno_key = $k;
								$curriYn = 'y';
								if($v[mps_type] == 'g'){ //현재 번호가 게임이면 그냥 이동
									redirect('/classroom/game?mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno]);
								}else if($v[mps_type] == 's'){
									redirect('/classroom/seed?mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno]);
								}else{
									$curriculum[$k][active] = 'active';
								}
								
							}
							
							
							if($v[mps_type] == 'v'){
								$q = "select video_name, video_url from cb_video where video_idx = '".$v[t_sno]."'";
								$r = $this->db->query($q);
								$t_sno = (array) $r->row();
								$curriculum[$k][title] = $t_sno[video_name]."(영상)";
								$curriculum[$k][video_url] = $t_sno[video_url];
								$curriculum[$k][moveUrl] = '/classroom/player?mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno];
							}else if($v[mps_type] == 'g'){
								$q = "select g_nm from cb_gamecontents where g_sno = '".$v[t_sno]."'";
								$r = $this->db->query($q);
								$t_sno = (array) $r->row();
								$curriculum[$k][title] = $t_sno[g_nm]."(게임)";
								$curriculum[$k][moveUrl] = '/classroom/game?mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno];
							}else{
								$curriculum[$k][title] = "씨앗 ".$v[t_sno]."개 지급";
								$curriculum[$k][moveUrl] = 'n';
							}
							$last_no = $k;
							
						}
						$curriculum[$moveYn][moveYn] = 'y';
						
						
						if($curriYn != 'y'){ // 없는 번호임
							alert('없는 강의입니다. 관리자에 문의해주세요','/classroom');
						}else{
							if($curriculum[$mps_sno_key][moveYn] != 'y' && $curriculum[$mps_sno_key][mps_endYn] != 'y'){ //번호는 있는데 이전 과정이 없음
								alert('이전 커리큘럼을 완료해주세요!','/classroom/player?mp_sno='.$_GET[mp_sno]);
							}else{ //모든 조건 통과 이제 강의 데이터
								
								$curriculum[$mps_sno_key][moveUrl] = 'n';
								$view['curriculum']['list'] = $curriculum; 

								if($my_process[p_viewYn] == 'y'){
									$my_process['view_time'] = "상시 노출";
								}else{
									$my_process['view_time'] = substr($my_process[p_sdate], 0, 4).".".substr($my_process[p_sdate], 4, 2).".".substr($my_process[p_sdate], 6, 2)." ~ ".substr($my_process[p_edate], 0, 4).".".substr($my_process[p_edate], 4, 2).".".substr($my_process[p_edate], 6, 2);
								}
								$my_process[video_url] = $curriculum[$mps_sno_key][video_url];

								$my_process[mps_sno] = $_GET[mps_sno];
								$my_process[next_sno] = $curriculum[$mps_sno_key+1][mps_sno];
								$view[my_process] = $my_process;

								//카테고리 
								$q = "select c.cca_value, c.cca_id from cb_lms_process_category as pc left join cb_category as c on pc.cca_id = c.cca_id where pc.p_sno = '".$my_process[p_sno]."' order by c.cca_parent asc, c.cca_order";
								$r = $this->db->query($q);
								$view['category']['list'] = $r->result_array(); 
								//debug($view['category']['list']);
								// 같은 브라우저 같은 아이디 일때 중복 시청 금지
								$sql = "UPDATE cb_member SET mem_login_chk2 = '".$_COOKIE[mysession]."' WHERE mem_id = '".$this->member->item('mem_id')."'";
								$this->db->query($sql);

								// 타임라인 불러오기(동영상)
								$qq = "SELECT mps_endYn, mps_timeline FROM cb_my_process_sub WHERE mp_sno = '".$_GET['mp_sno']."' AND mps_type = 'v'";
								$rr = $this->db->query($qq);
								$view['timeline']['list'] = $rr->result_array();
								
							}
						}
						
					}else{
						alert('신청하지 않는 강의입니다.!','/classroom');
					}
				}
			}else{
				alert('존재하지 않는 강의입니다.. 관리자에 문의해주세요!','/classroom');
			}
		}
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'player',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "동영상 플레이어",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "동영상 플레이어",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function player_test()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'player_test',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "동영상 플레이어",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "동영상 플레이어",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	//씨앗 처리
	public function seed()
	{
		$req = array_merge($_GET, $_POST);
		$tot_sub = $end_eub = $now_key = 0;
		
		
		$q = "select * from cb_my_process_sub where mp_sno = '".$req[mp_sno]."'";
		$r = $this->db->query($q);
		$cb_my_process_sub = $r->result_array();
		
		if($cb_my_process_sub){
			foreach ($cb_my_process_sub as $k => $v){
				if($req[mps_sno] == $v[mps_sno]){
					$now_key = $k;
				}
				if($v[mps_endYn] == 'y'){ 
					$end_eub++;
				}
				$tot_sub++;
			}
			
			//이전단계가 완료되었는지 확인
			$before_key = $now_key - 1;
			$next_key = $now_key + 1;
			
			
			if($cb_my_process_sub[$before_key][mps_endYn] == 'y'){
				//이미 지급했는지 확인
				if($cb_my_process_sub[$now_key][mps_endYn] != 'y'){
					//지급 안됐으면 지급해주고 로그남겨
					//로그를 위한 과정이름 구하기
					$q = "select p.p_title from cb_my_process as mp left join cb_lms_process as p on mp.p_sno = p.p_sno where mp.mp_sno = '".$req[mp_sno]."'";
					$r = $this->db->query($q);
					$p_title = (array) $r->row();
					//씨앗 개수 확인
					$txt = "[".$p_title[p_title]."] 에서 씨앗 ".$cb_my_process_sub[$now_key][t_sno]."개 획득";
					//가능하다면 삽입
					$param = array(
						'log_memNo'      => $this->member->item('mem_id'),
						'log_txt'      => $txt,
						'log_place'      => "classroom",
					);
					$this->db->insert('cb_object_log', $param);
					$pid = $this->db->insert_id();
					if($pid > 0){
						//과정 완료 처리
						$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$req[mps_sno]."'";
						$this->db->query($sql);
						//씨앗 지급
						$sql = "UPDATE cb_member SET mem_cur_seed = mem_cur_seed + ".$cb_my_process_sub[$now_key][t_sno]." WHERE mem_id = '".$this->member->item('mem_id')."'";
						$this->db->query($sql);
						//완료율 확인
						//현재 완료율 정의
						$end_eub = $end_eub + 1;
						$now_percent = number_format(($end_eub/$tot_sub)*100);
						if($now_percent == '100'){
							$mp_endYn = 'y';
							// 240110 lkt 수료일자 추가
							$mp_endDt = date('Y-m-d H:i:s');
							$sql = "INSERT INTO cb_member_lms_end_log SET mp_sno = '".$req['mp_sno']."', mp_endDt = '".$mp_endDt."'";
							$this->db->query($sql);
						}else{
							$mp_endYn = 'n';
						}
						$sql = "UPDATE cb_my_process SET mp_percent = '".$now_percent."', mp_endYn = '".$mp_endYn."'  WHERE mp_sno = '".$req[mp_sno]."'";
						$this->db->query($sql);
					}
					
				}
				
				//지급을 했떤 안했던 다음 단계 계산
				//다음단계 확인
					
				if($cb_my_process_sub[$next_key][mps_sno]){ //다음 단계가 있다면 보내
					if($cb_my_process_sub[$next_key][mps_type] == 'g'){ //현재 번호가 게임이면 그냥 이동
						redirect('/classroom/game?mp_sno='.$req[mp_sno].'&&mps_sno='.$cb_my_process_sub[$next_key][mps_sno]);
					}else if($cb_my_process_sub[$next_key][mps_type] == 's'){
						redirect('/classroom/seed?mp_sno='.$req[mp_sno].'&&mps_sno='.$cb_my_process_sub[$next_key][mps_sno]);
					}else{
						redirect('/classroom/player?mp_sno='.$req[mp_sno].'&&mps_sno='.$cb_my_process_sub[$next_key][mps_sno]);
					}

				}else{ //없으면 완료
					alert('본 과정이 완료되었습니다.','/classroom/complete_class');
				}
				
				
			}else{ //이전 단계가 완료되지 않음
				alert('이전 단계를 먼저 완료해주세요','/classroom');	
			}
		}else{
			alert('필수 항목 누락입니다. 관리자에 문의주세요','/classroom');	
		}
		
		exit;
		
	}
	public function game()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'test_game',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "테스트 게임",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "테스트 게임",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	public function test_game()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'test_game',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "테스트 게임",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "테스트 게임",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function company_class() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'company_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "company_class",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "company_class",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	/**
	 *  보험 신청 처리 파일
	 */
	public function process_ps()
	{
		
		$req = array_merge($_GET, $_POST);
		$today = date("Ymd");
		
		if(!$_GET[p_sno]){
			$q = "select * from cb_my_process where mp_sno = '".$req[mp_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
			$r = $this->db->query($q);
			$my_process_chk = (array) $r->row();
			$_GET[p_sno] = $req[p_sno] = $my_process_chk[p_sno];
		}
		
		$business_exYn = business_exYn($_GET[p_sno],$this->member->item('company_idx'));
		//기업 등급과 노출 추가등을 따져서 수강신청이 가능한지 판단함 f면 뻥카, y 면 수강신청가능, n 이면 불가
		$business_studyYn = business_studyYn($_GET[p_sno],$this->member->item('company_idx'));
		
		//여기까지는 모든 모드에서 공통적용
		$basic_where[] = "(p.p_viewYn = 'y' or (p.p_viewYn = 's' and p.p_sdate <= ".$today." and p.p_edate >= ".$today."))";
		$basic_where[] = " p.p_sno = '".$_GET[p_sno]."'";
		//수강중인강의
		$q = "select p.plan_idx, p.p_curriYn from cb_lms_process as p where ".implode(" and ",$basic_where)."";
		$r = $this->db->query($q);
		$process = (array) $r->row();
			
		
		
		switch ($req['mode']) {
			case 'reg':
				
				if($process[plan_idx]){
					//일단 뻥카인지 확인 뻥이면 f , 가능이면 y , 불가면 np_curriYn
					if($business_studyYn == 'f'){
						$txt = false_process();
						alert($txt.'입니다. 신청이 불가합니다.');
					}else if($business_studyYn == 'n'){
						alert('수강이 불가합니다. 관리자에 문의해주세요!','/classroom');
					}else{
						if($business_exYn == 'y'){
							alert('비활성화 된 강의입니다. 관리자에 문의해주세요!','/classroom');
						}else{
							//가능한 것 중에 난 이미 수강신청했는지
							$q = "select * from cb_my_process where p_sno = '".$_GET[p_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
							$r = $this->db->query($q);
							$my_process = (array) $r->row();
							if($my_process[mp_sno]){ //이미 했다면 a
								alert('이미 수강중인 강의입니다!','/classroom');
							}else{
								//가능하다면 삽입
								$param = array(
									'p_sno'      => $_GET[p_sno],
									'mem_id'      => $this->member->item('mem_id'),
								);
								$this->db->insert('cb_my_process', $param);
								$pid = $this->db->insert_id();
								if($pid > 0){
									unset($param);
									$q = "select * from cb_lms_process_curriculum where p_sno = '".$_GET[p_sno]."' order by c_sno";
									$r = $this->db->query($q);
									$sub_arr = $r->result_array(); 
									foreach ($sub_arr as $k => $v){
										$param = array(
											'mp_sno'      => $pid,
											'mps_type'      => $v[c_type],
											't_sno'      => $v[t_sno],
										);
										$this->db->insert('cb_my_process_sub', $param);
									}
									alert('수강신청이 정상 처리되었습니다.','/classroom/my_class');
								}else{
									alert('수강신청이 되지 않았습니다. 관리자에 문의해주세요!','/classroom');
								}
							}
						}
					}
				}else{
					alert('존재하지 않는 과정입니다.',"/classroom");
				}
				
				break;
			
			case 's':
				
				$req = array_merge($_GET, $_POST);
				$today = date("Ymd");
				
				debug($req);
				exit;
				
				break;
			
			case 'g':
				
				if($process[plan_idx]){
					//일단 뻥카인지 확인 뻥이면 f , 가능이면 y , 불가면 np_curriYn
					if($business_studyYn == 'f'){
						$txt = false_process();
						alert($txt.'입니다. 신청이 불가합니다.');
					}else if($business_studyYn == 'n'){
						alert('수강이 불가합니다. 관리자에 문의해주세요!','/classroom');
					}else{
						if($business_exYn == 'y'){
							alert('비활성화 된 강의입니다. 관리자에 문의해주세요!','/classroom');
						}else{
							//완료가 된건지 확인
							$q = "select * from cb_my_process_sub where mps_sno = '".$_GET[mps_sno]."'";
							$r = $this->db->query($q);
							$my_process_sub = (array) $r->row();
							if($my_process_sub[mps_endYn] == 'y'){ //완료가 됐다면 다음 단계를 구해보자 일단 % 재계산 도
								$q = "select * from cb_my_process_sub where mp_sno = '".$req[mp_sno]."' order by mps_sno";
								$r = $this->db->query($q);
								$my_process_sub_arr = $r->result_array(); 
								//231225 어차피 반복문 돌려야되니까 따로 count 쿼리 쓰지 말기
								$tot_sub = $end_eub = $now_key = 0;
								foreach ($my_process_sub_arr as $k => $v){
									if($v[mps_sno] == $_GET[mps_sno]){
										$now_key = $k;
									}
									if($v[mps_endYn] == 'y'){ 
										$end_eub++;
									}
									$tot_sub++;
								}
								//현재 완료율 정의
								$now_percent = number_format(($end_eub/$tot_sub)*100);
								if($now_percent == '100'){
									$mp_endYn = 'y';
									// 240110 lkt 수료일자 추가
									$mp_endDt = date('Y-m-d H:i:s');
									$sql = "INSERT INTO cb_member_lms_end_log SET mp_sno = '".$req['mp_sno']."', mp_endDt = '".$mp_endDt."'";
									$this->db->query($sql);
								}else{
									$mp_endYn = 'n';
								}
								$sql = "UPDATE cb_my_process SET mp_percent = '".$now_percent."', mp_endYn = '".$mp_endYn."'  WHERE mp_sno = '".$req[mp_sno]."'";
								$this->db->query($sql);
								//다음 단계 정의
								$next_key = $now_key + 1;
								if($my_process_sub_arr[$next_key][mps_sno]){ //다음 단계가 있다면 보내
									if($my_process_sub_arr[$next_key][mps_type] == 'g'){ //현재 번호가 게임이면 그냥 이동
										redirect('/classroom/game?mp_sno='.$req[mp_sno].'&&mps_sno='.$my_process_sub_arr[$next_key][mps_sno]);
									}else if($my_process_sub_arr[$next_key][mps_type] == 's'){
										redirect('/classroom/seed?mp_sno='.$req[mp_sno].'&&mps_sno='.$my_process_sub_arr[$next_key][mps_sno]);
									}else{
										redirect('/classroom/player?mp_sno='.$req[mp_sno].'&&mps_sno='.$my_process_sub_arr[$next_key][mps_sno]);
									}
									
								}else{ //없으면 완료
									alert('본 과정이 완료되었습니다.','/classroom/complete_class');
								}
								
							}else{ //완료가 안됐다면 한번 더 들어줘(아마도 배속 플레이때문?)mp_sno=20&&mps_sno=52
								alert('아직 완료되지 않았습니다. 한번 더 해주세요','/classroom/game?mp_sno='.$req[mp_sno].'&&mps_sno='.$req[mps_sno]);
							}
							
						}
					}
				}else{
					alert('존재하지 않는 과정입니다.',"/classroom");
				}
				
				break;
				
			case 'v':
				
				
				if($process[plan_idx]){
					//일단 뻥카인지 확인 뻥이면 f , 가능이면 y , 불가면 np_curriYn
					if($business_studyYn == 'f'){
						$txt = false_process();
						alert($txt.'입니다. 신청이 불가합니다.');
					}else if($business_studyYn == 'n'){
						alert('수강이 불가합니다. 관리자에 문의해주세요!','/classroom');
					}else{
						if($business_exYn == 'y'){
							alert('비활성화 된 강의입니다. 관리자에 문의해주세요!','/classroom');
						}else{
							//완료가 된건지 확인
							$q = "select * from cb_my_process_sub where mps_sno = '".$_GET[mps_sno]."'";
							$r = $this->db->query($q);
							$my_process_sub = (array) $r->row();
							if($my_process_sub[mps_endYn] == 'y'){ //완료가 됐다면 다음 단계를 구해보자 일단 % 재계산 도
								$q = "select * from cb_my_process_sub where mp_sno = '".$req[mp_sno]."' order by mps_sno";
								$r = $this->db->query($q);
								$my_process_sub_arr = $r->result_array(); 
								//231225 어차피 반복문 돌려야되니까 따로 count 쿼리 쓰지 말기
								$tot_sub = $end_eub = $now_key = 0;
								foreach ($my_process_sub_arr as $k => $v){
									if($v[mps_sno] == $_GET[mps_sno]){
										$now_key = $k;
									}
									if($v[mps_endYn] == 'y'){ 
										$end_eub++;
									}
									$tot_sub++;
								}
								//현재 완료율 정의
								$now_percent = number_format(($end_eub/$tot_sub)*100);
								if($now_percent == '100'){
									$mp_endYn = 'y';
									// 240110 lkt 수료일자 추가
									$mp_endDt = date('Y-m-d H:i:s');
									$sql = "INSERT INTO cb_member_lms_end_log SET mp_sno = '".$req['mp_sno']."', mp_endDt = '".$mp_endDt."'";
									$this->db->query($sql);
								}else{
									$mp_endYn = 'n';
								}
								$sql = "UPDATE cb_my_process SET mp_percent = '".$now_percent."', mp_endYn = '".$mp_endYn."'  WHERE mp_sno = '".$req[mp_sno]."'";
								$this->db->query($sql);
								//다음 단계 정의
								$next_key = $now_key + 1;
								if($my_process_sub_arr[$next_key][mps_sno]){ //다음 단계가 있다면 보내
									if($my_process_sub_arr[$next_key][mps_type] == 'g'){ //현재 번호가 게임이면 그냥 이동
										redirect('/classroom/game?mp_sno='.$req[mp_sno].'&&mps_sno='.$my_process_sub_arr[$next_key][mps_sno]);
									}else if($my_process_sub_arr[$next_key][mps_type] == 's'){
										redirect('/classroom/seed?mp_sno='.$req[mp_sno].'&&mps_sno='.$my_process_sub_arr[$next_key][mps_sno]);
									}else{
										redirect('/classroom/player?mp_sno='.$req[mp_sno].'&&mps_sno='.$my_process_sub_arr[$next_key][mps_sno]);
									}
									
								}else{ //없으면 완료
									alert('본 과정이 완료되었습니다.','/classroom/complete_class');
								}
								
							}else{ //완료가 안됐다면 한번 더 들어줘(아마도 배속 플레이때문?)mp_sno=20&&mps_sno=52
								alert('아직 완료되지 않았습니다. 한번 더 시청해주세요','/classroom/player?mp_sno='.$req[mp_sno].'&&mps_sno='.$req[mps_sno]);
							}
							
						}
					}
				}else{
					alert('존재하지 않는 과정입니다.',"/classroom");
				}
				
				break;
		}
	}
	

    public function endYn()
    {
        $post = $this->input->post();
        
        if($post['mode'] == 'chk'){
            $this->db->select('mps_endYn');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
			if($row[mps_endYn] == 'y'){
				$result['code'] = 'y';
			}else{
				$result['code'] = 'n';
			}
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }
	
	// 동영상 재생시간 초기화
    public function chk()
    {
        $post = $this->input->post();
		
		if($this->member->item('mem_login_chk') != $_SESSION[seum_login_chk]){
			$result['code'] = 'n';
			$this->session->sess_destroy();
		}else{
			if($this->member->item('mem_login_chk2') != $_COOKIE[mysession]){
				$result['code'] = 's';
			}else{
				$result['code'] = 'y';
			}
		}

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }


    // 동영상 재생시간, 누적시간 저장하기(1분마다)
    public function setPlayerTime()
    {
        $post = $this->input->post();
        $result['debug'] = $post;
        if($post['mode'] == 'chkPlayTime'){
			
			// 누적시간 체크해서 영상전체시간 90% 넘기면 완료처리
			$this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();

			if($row['mps_playTime'] / $post['maxduration'] * 100 >= 90){
				$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			}

            $this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
            $mps_playTime = $row['mps_playTime'] + (60 / $post['playbackRate']);

			$where = array(
				'mps_sectionTime' => $post['mps_sectionTime'],
				'mps_sno' => $post['mps_sno'],
			);
            $this->db->select('count(*) as cnt');
            $this->db->where($where);
            $datas = $this->db->get('my_process_sub');
            $rows = $datas->row_array();

            if($rows['cnt'] > 0){
				$result['code'] = 'fail';
            	$result['msg'] = 'already been saved';
            } else {
				$sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."', mps_sectionTime = '".$post['mps_sectionTime']."' WHERE mps_sno = '".$post['mps_sno']."'";
                $this->db->query($sql);

				$result['code'] = 'ok';
            	$result['msg'] = 'data save complete';
			}
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 동영상 90% 시청 시 완료처리
    public function setPlayerComplete()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayComplete'){
            $sql = "UPDATE cb_my_process_sub SET mps_endYn = '".$post['mps_endYn']."' WHERE mps_sno = '".$post['mps_sno']."'";
            $this->db->query($sql);

            $result['code'] = 'ok';
            $result['msg'] = 'data save complete';
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 동영상 100% 시청 시 나머지시간 더하기
    public function setPlayerEnd()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayEnd'){
            $this->db->select('mps_playTime, mps_sectionTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
            $mps_playTime = $row['mps_playTime'] + $post['remainTime'];

            $sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."', mps_timeline = '".$row['mps_sectionTime']."' WHERE mps_sno = '".$post['mps_sno']."'";
            $this->db->query($sql);

            $result['code'] = 'ok';
            $result['msg'] = 'data save complete';
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 동영상 시청 시 페이지 벗어나는 경우 초만 더하기
    public function setPlayerOut()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayOut'){
            $this->db->select('mps_playTime, mps_sectionTime, mps_timeline');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
            $mps_playTime = $row['mps_playTime'] + $post['seconds'];

			if($row['mps_sectionTime'] > $row['mps_timeline']){
				$sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."', mps_timeline = '".$row['mps_sectionTime']."' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			} else {
				$sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			}
            

            $result['code'] = 'ok';
            $result['msg'] = 'data save complete';
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

	// 동영상 누적시간 체크
	public function getPlayerAccumulatedTime()
	{
		$post = $this->input->post();

		if($post['mode'] == 'chkPlayAccumulatedTime'){
			$this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();

			if($row['mps_playTime'] / $post['maxduration'] * 100 >= 90){
				$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);

				$result['code'] = 'ok';
            	$result['msg'] = 'data save complete';
			} else {
				$result['code'] = 'fail';
            	$result['msg'] = 'not yet complete';
			}
		} else {
			$result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
	}

	// 동영상 완료여부 체크
	public function getEndYn()
	{
		$post = $this->input->post();

		if($post['mode'] == 'chkEndYn'){
			$this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
			if($row['mps_playTime'] / $post['maxduration'] * 100 >= 90){
				$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			}

			$this->db->select('mps_endYn');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();

			$result['code'] = 'ok';
			$result['msg'] = 'data load complete';
			$result['endfl'] = $row['mps_endYn'];
		} else {
			$result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
	}

	// 동영상 시작시간 체크
	public function setStartDt()
	{
		$post = $this->input->post();

		if($post['mode'] == 'setStartDt'){
			$mll_datetime = date('Y-m-d H:i:s');
			$sql = "INSERT INTO cb_member_lms_log SET mem_id = '".$post['mem_id']."', mll_datetime = '".$mll_datetime."'";
			$this->db->query($sql);

			$result['code'] = 'ok';
			$result['msg'] = 'data save complete';
		} else {
			$result['code'] = 'fail';
			$result['msg'] = 'mode is incorrect';
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
	}
	
}
