<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pagemenu class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>페이지설정>메뉴관리 controller 입니다.
 */
class Process extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'lms/process';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Lmsprocess');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Lmsprocess_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_document_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();
		
		//플랜선택 윤진봉
		$q = "select * from cb_plan";
		$r = $this->db->query($q);
		$view['view']['plan'] = $r->result_array(); 
		
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'p_sno' => $param->sort('p_sno', 'asc'),
			'plan_idx' => $param->sort('plan_idx', 'asc'),
			'p_regDt' => $param->sort('p_regDt', 'desc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('p_title', 'p_desc', 'p_teacher'); // 검색이 가능한 필드
		// $this->{$this->modelname}->search_field_equal = array('seum_departmentNm'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('p_sno', 'plan_idx', 'p_regDt'); // 정렬이 가능한 필드
		
		
		//템플릿 종류 검색 추가
		$where = array();
		
		if ($_GET['plan_idx']) {	
			$where['lms_process.plan_idx'] = $view['view']['plan_idx'] = $_GET['plan_idx'];
		}
		if ($_GET['p_curriYn']) {	
			$where['lms_process.p_curriYn'] = $view['view']['p_curriYn'] = $_GET['p_curriYn'];
		}
		
		
		
		$result = $this->{$this->modelname}->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				if($result['list'][$key]['p_viewYn'] == 'y'){
					$result['list'][$key]['p_viewTxt'] = '상시노출';
				}else if($result['list'][$key]['p_viewYn'] == 'n'){
					$result['list'][$key]['p_viewTxt'] = '미노출';
				}else{
					$result['list'][$key]['p_viewTxt'] = $result['list'][$key]['p_sdate']." ~ ".$result['list'][$key]['p_edate'];
				}
				//카테고리
				$q = "SELECT pc.cca_id, c.cca_desc FROM cb_lms_process_category AS pc
							INNER JOIN cb_category AS c ON pc.cca_id = c.cca_id
						WHERE pc.p_sno = '".$result['list'][$key]['p_sno']."' ORDER BY c.cca_desc ASC";
				$r= $this->db->query($q);
				$result['list'][$key]['category'] = $r->result_array();
				//커리큘럼
				$q = "SELECT * FROM cb_lms_process_curriculum where p_sno = '".$result['list'][$key]['p_sno']."'";
				$r = $this->db->query($q);
				$curri_arr = $r->result_array();

				foreach ($curri_arr as $k => $v) {
					if($v[c_type] == 'v'){
						$q = "select video_name from cb_video where video_idx = '".$v[t_sno]."'";
						$r = $this->db->query($q);
						$v_data = (array) $r->row();
						if($v_data){
							$result2[$k][c_order] = $v[c_order];
							$result2[$k][c_type] = "영상";
							$result2[$k][c_content] = $v_data[video_name];
						}
					}else if($v[c_type] == 'g'){
						$q = "select g_nm from cb_gamecontents where g_sno = '".$v[t_sno]."'";
						$r = $this->db->query($q);
						$g_data = (array) $r->row();
						if($g_data){
							$result2[$k][c_order] = $v[c_order];
							$result2[$k][c_type] = "게임";
							$result2[$k][c_content] = $g_data[g_nm];
						}
					}else{
						$result2[$k][c_order] = $v[c_order];
						$result2[$k][c_type] = "씨앗";
						$result2[$k][c_content] = $v[t_sno]."개 지급";
					}
				}
				$result['list'][$key]['curri'] = $result2;
				
				
			}
		}
		//debug($result);
		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('p_title' => '과정명', 'p_desc' => '과정설명', 'p_teacher' => '강사설명');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? ltrim($skeyword) : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 등록
	 */
	public function write($pid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_document_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;
		
		//debug($view['view']['category']);
		
		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->{$this->modelname}->get_one($pid);
			$getdata['category_rel_list'] = $this->{$this->modelname}->get_category_rel_list($pid);
            $getdata['company_rel_list'] = $this->{$this->modelname}->get_company_rel_list($pid);

            $getdata['category_no'] = count($getdata['category_rel_list']);
            $getdata['company_no'] = count($getdata['company_rel_list']);
			
			//시작일 종료일 처리
			$getdata['p_sdate'] = substr($getdata[p_sdate], 0, 4)."-".substr($getdata[p_sdate], 4, 2)."-".substr($getdata[p_sdate], 6, 2);
			$getdata['p_edate'] = substr($getdata[p_edate], 0, 4)."-".substr($getdata[p_edate], 4, 2)."-".substr($getdata[p_edate], 6, 2);
			
			//커리큘럼 목록
			if($getdata['p_curriYn'] == 'y'){
				$view['view']['curri_list'] = $this->{$this->modelname}->get_curri_list($pid);	
			}
		}
		
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'p_sno',
				'label' => '번호',
				'rules' => 'trim',
			),
			array(
				'field' => 'p_title',
				'label' => '과정이름',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'p_viewYn',
				'label' => '노출여부',
				'rules' => 'trim',
			),
		);

		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'p_sno',
				'label' => '번호',
				'rules' => 'trim|required|alpha_dash|min_length[1]|max_length[50]|is_unique[document.doc_key.doc_id.' . $getdata['doc_id'] . ']',
			);
		} else {
			// $config[] = array(
			// 	'field' => 'seum_sno',
			// 	'label' => '부서번호',
			// 	'rules' => 'trim|required|alpha_dash|min_length[1]|max_length[50]|is_unique[document.doc_key]',
			// );
		}
		
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			$view['view']['data'] = $getdata;
			//debug($view['view']['g_question']);
			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
			//플랜 리스트
			$view['view']['plan_list'] = $this->{$this->modelname}->get_plan_list();
			$view['view']['company_list'] = $this->{$this->modelname}->get_company_list();
			//카테고리 목록
			$view['view']['category_list'] = $this->{$this->modelname}->get_category_list();
			$view['view']['category_sub_list'] = $this->{$this->modelname}->get_category_list(1);
			//게임목록
			$view['view']['game_list'] = $this->{$this->modelname}->get_game_list();
			//비디오목록
			$view['view']['video_list'] = $this->{$this->modelname}->get_video_list();
			
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'write');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		} else {

			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */
			$in_post = $this->input->post();
			
			//특정일 일때 시작일 종료일
			if($in_post[p_sdate]){
				$p_sdate = str_replace("-", "", $this->input->post('p_sdate', null, ''));
			}else{
				$p_sdate = 0;
			}
			if($in_post[p_edate]){
				$p_edate = str_replace("-", "", $this->input->post('p_edate', null, ''));
			}else{
				$p_edate = 0;
			}
			
			
			if($in_post[add_category_idx]){
				$p_category = implode("*|*",$in_post[add_category_idx]);
				
				foreach ($in_post[add_category_idx] as $k => $v){
					$q = "select cca_value  from cb_category where cca_id = '".$v."'";
					$r = $this->db->query($q);
					$cca_value = (array) $r->row();
					$cca_arr[] = $cca_value[cca_value];
				}
				$p_cate = implode("*|*",$cca_arr);
				
			}else{
				$p_category = '';
				$p_cate = '';
			}
			
			
			if($in_post[add_company_idx]){
				$p_add_company = implode("*|*",$in_post[add_company_idx]);
			}else{
				$p_add_company = '';
			}
			//커리큘럼처리
			if($in_post[cur_num]){
				foreach ($in_post[cur_num] as $k => $v) {
					$curri_arr[$k][cur_num] = $v;
					$curri_arr[$k][cur_sno] = $in_post[cur_sno][$k];
					$curri_arr[$k][cur_type] = $in_post[cur_type][$k];
				}
				$curri_json = json_encode($curri_arr);
				
			}
			
			
			
			$param = array(
				'p_title' => $this->input->post('p_title', null, ''),
				'p_subtitle' => $this->input->post('p_subtitle', null, ''),
				'plan_idx' => $this->input->post('plan_idx', null, ''),
				'reg_company_idx' => $this->input->post('reg_company_idx', null, ''),
				'p_essentialYn' => $this->input->post('p_essentialYn', null, ''),
				'p_recommendYn' => $this->input->post('p_recommendYn', null, ''),
				'p_viewYn' => $this->input->post('p_viewYn', null, ''),
				'p_sdate' => $p_sdate,
				'p_edate' => $p_edate,
				'p_desc' => $this->input->post('p_desc', null, ''),
				'p_teacher' => $this->input->post('p_teacher', null, ''),
				'p_cate' => $p_cate,
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($pid > 0) {
				
				$this->{$this->modelname}->update($pid, $param);
				
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				
				
				$this->{$this->modelname}->insert($param);
				$pid = $this->db->insert_id();
				$this->session->set_flashdata(
					'message',
					'정상적으로 입력되었습니다'
				);
			}
			
			//추가 기업 , 카테고리, 컬리큘럼 관리
			$this->{$this->modelname}->set_company($pid,$p_add_company);
			$this->{$this->modelname}->set_category($pid,$p_category);
			$this->{$this->modelname}->set_curri($pid,$curri_json);
			
			//파일처리 231217 asmo yjb
			$this->load->library('upload');
			$thumb_path = config_item('uploads_dir') . '/lms_thumb/';
			if (isset($_FILES) && isset($_FILES['p_thumbnail']) && isset($_FILES['p_thumbnail']['name']) && $_FILES['p_thumbnail']['name'])
			{
				
				//기존 이미지 삭제	
				if($getdata[p_thumbnail]){
					$fn = "/var/www/html".$getdata[p_thumbnail];
					//unlink("../../../../..".$getdata[item_img_th]);
					
					if(is_file($fn)) {
						unlink($fn);
					}
				}
				
				$uploadconfig = array();
				$uploadconfig['upload_path'] = $thumb_path;
				$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);
				
				$imageExt = strrchr($_FILES['p_thumbnail']['name'], '.');
				$fname = $this->input->post('p_title', null, '').$imageExt;
				
				if ($this->upload->do_upload('p_thumbnail')) {
					$img = $this->upload->data();
					$updatephoto1 = "/".$thumb_path.element('file_name', $img);
					$updatedata[p_thumbnail] = $updatephoto1;
				} else {
					$file_error = $this->upload->display_errors();
				}
			}
			
			if($updatedata){
				$this->{$this->modelname}->update($pid, $updatedata);
			}
			
			
			
			
			
			
			
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['after'] = Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);
		}
	}
	
	
	public function get_category_sub($pid)
    {
        $rs = $this->{$this->modelname}->get_category_list($pid);

        $html = "";
        foreach($rs as $l)
        {
            $html .= "<option value='" . $l['cca_id'] . "'>" . $l['cca_value'] . "</option>";
        }

        echo $html;
    }
	
	public function get_video($pid=null)
    {
		$rs = $this->{$this->modelname}->get_video_list(rawurldecode($pid));

        $html = "";
        foreach($rs as $k => $v)
        {
			if($k == 0){
				$checked = "checked";
			}else{
				$checked = "";
			}
            $html .= "<li class='list-group-item'><input type='hidden' id='video_choice".$v[video_idx]."' value='".$v[video_name]."' /><input type='radio' name='video_choice' value='".$v[video_idx]."' ".$checked." />".$v[video_name]."</li>";
        }

        echo $html;
    }
	
	public function get_game($pid=null)
    {
		$rs = $this->{$this->modelname}->get_game_list(rawurldecode($pid));

        $html = "";
        foreach($rs as $k => $v)
        {
			if($k == 0){
				$checked = "checked";
			}else{
				$checked = "";
			}
            $html .= "<li class='list-group-item'><input type='hidden' id='game_choice".$v[g_sno]."' value='".$v[g_nm]."' /><input type='radio' name='game_choice' value='".$v[g_sno]."' ".$checked." />".$v[g_nm]."</li>";
        }

        echo $html;
    }
	
	
	/**
	 * 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_pagemenu_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					
					$this->{$this->modelname}->delete($val);
				}
			}
		}

		$this->_delete_cache();


		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 삭제되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}

	/**
	 * 메뉴관련 캐시를 삭제합니다
	 */
	public function _delete_cache()
	{
		$this->cache->delete('pagemenu-mobile');
		$this->cache->delete('pagemenu-desktop');
	}
}
