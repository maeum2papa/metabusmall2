<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videoinfo extends CB_Controller
{

    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'lms/videoinfo';

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('video');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'video_model';

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'chkstring');

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
			'video_idx' => $param->sort('video_idx', 'asc'),
			'video_name' => $param->sort('video_name', 'asc'),
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
		$this->{$this->modelname}->allow_search_field = array('video_name', 'video_url'); // 검색이 가능한 필드
		// $this->{$this->modelname}->search_field_equal = array('seum_departmentNm'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('video_idx', 'video_name'); // 정렬이 가능한 필드
		
		$result = $this->{$this->modelname}->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				
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
		$search_option = array('video_name' => '동영상이름', 'video_url' => '파일이름');
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
				'field' => 'video_idx',
				'label' => '번호',
				'rules' => 'trim',
			),
			array(
				'field' => 'video_name',
				'label' => '영상이름',
				'rules' => 'trim',
			),
			array(
				'field' => 'video_url',
				'label' => '파일명',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'video_desc',
				'label' => '영상설명',
				'rules' => 'trim',
			),
		);

		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'video_idx',
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
			
			//$in_post = $this->input->post();
			
			$param = array(
				'video_name' => $this->input->post('video_name', null, ''),
				'video_url' => $this->input->post('video_url', null, ''),
				'video_desc' => $this->input->post('video_desc', null, ''),
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($pid > 0) {
				
				$q = "select video_idx from cb_video where video_url = '".$this->input->post('video_url', null, '')."' and video_idx != '".$pid."'";
				$r = $this->db->query($q);
				$video_idx = (array) $r->row();
				if($video_idx[video_idx]){
					alert('이미 존재하는 파일명이에요 안돼요 그건 죠!!');
				}
				
				
				$this->{$this->modelname}->update($pid, $param);
				
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				$q = "select video_idx from cb_video where video_url = '".$this->input->post('video_url', null, '')."'";
				$r = $this->db->query($q);
				$video_idx = (array) $r->row();
				if($video_idx[video_idx]){
					alert('이미 존재하는 파일명이에요 안돼요 그건 제리!!');
				}
				
				$this->{$this->modelname}->insert($param);
				$pid = $this->db->insert_id();
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
?>