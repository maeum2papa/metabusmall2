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
class Asset_template extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'asset/asset_template';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Asset_template');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Asset_template_model';

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
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_document_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'tp_sno' => $param->sort('tp_sno', 'asc'),
			'tp_nm' => $param->sort('tp_nm', 'asc'),
			'tp_type' => $param->sort('tp_type', 'asc'),
			'tp_regDt' => $param->sort('tp_regDt', 'desc'),
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
		$this->{$this->modelname}->allow_search_field = array('tp_nm', 'cate_value', 'tp_regDt'); // 검색이 가능한 필드
		// $this->{$this->modelname}->search_field_equal = array('seum_departmentNm'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('tp_sno', 'tp_nm', 'tp_type', 'tp_regDt'); // 정렬이 가능한 필드
		
		
		//템플릿 종류 검색 추가
		$where = array();
		
		if ($_GET['tp_type']) {	
			$where['tp_type'] = $view['view']['tp_type'] = $_GET['tp_type'];
		}
		
		
		
		
		$result = $this->{$this->modelname}->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
			}
		}

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
		$search_option = array('tp_nm' => '템플릿명', 'cate_value' => '카테고리명', 'seum_useDt' => '사용일');
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
		//카테고리 윤진봉
		$q = "select * from cb_asset_category where  cate_type = 'tl' and cate_parent = '0' order by cate_order";
		$r = $this->db->query($q);
		$view['view']['category2'] = $r->result_array(); 
		
		$q = "select * from cb_asset_category where  cate_type = 'tg' and cate_parent = '0' order by cate_order";
		$r = $this->db->query($q);
		$view['view']['category1'] = $r->result_array(); 
		//debug($view['view']['category']);
		
		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->{$this->modelname}->get_one($pid);
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
				'field' => 'tp_sno',
				'label' => '번호',
				'rules' => 'trim',
			),
			array(
				'field' => 'cate_sno',
				'label' => '카테고리',
				'rules' => 'trim',
			),
			array(
				'field' => 'tp_nm',
				'label' => '템플릿',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'tp_type',
				'label' => '종류',
				'rules' => 'trim',
			),
		);

		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'tp_sno',
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

			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 
			 * 특정 기업 노출을 위하여, 기업 리스트를 추가합니다.
			 * 
			 */
			$q = "select company_idx, company_name from cb_company_info where state = 'use'";
            $r = $this->db->query($q);
            $com_list = $r->result_array();

			$com_map = [];

			foreach ($com_list as $row) {
				$com_map[$row['company_idx']] = $row['company_name'];
			}


            $view['view']['com_list'] = $com_list;
			$view['view']['com_list_map'] = $com_map;


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

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			
			if($this->input->post('tp_type', null, '') == 'g'){
				$cate_sno = $this->input->post('cate_sno1', null, '');
			}else{
				$cate_sno = $this->input->post('cate_sno2', null, '');
			}
			
			$updatedata = array(
				'tp_sno' => $this->input->post('tp_sno', null, ''),
				'cate_sno' => $cate_sno,
				'tp_nm' => $this->input->post('tp_nm', null, ''),				
				'tp_nm_ko' => empty($this->input->post('tp_nm_ko', null, null)) ? NULL : $this->input->post('tp_nm_ko'),
				'tp_type' => $this->input->post('tp_type', null, ''),
				'tp_show_type' => $this->input->post('template_showFl'), 
                'tp_show_company' => $this->input->post('selectedOptions'),
				'tp_qcount' => $this->input->post('tp_g_qcount', null, 0),
				'tp_modDt' => date("Y-m-d H:i:s"),
			);

			if ( $this->input->post($primary_key) != $pid ){
			}

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($pid) {
				$this->{$this->modelname}->update($pid, $updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				
				$param = array(
					'cate_sno' => $cate_sno,
					'tp_nm' => $this->input->post('tp_nm', null, ''),
					'tp_type' => $this->input->post('tp_type', null, ''),
					'tp_regDt' => date("Y-m-d H:i:s"),
					'tp_modDt' => date("Y-m-d H:i:s"),
				);
				$this->{$this->modelname}->insert($param);
				$this->session->set_flashdata(
					'message',
					'정상적으로 입력되었습니다'
				);
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
