<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Members class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>회원설정>열매관리 controller 입니다.
 */
class Fruits extends CB_Controller
{
    /**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'member/fruits';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Fruit', 'Company_info','Member_meta', 'Member_group', 'Member_group_member', 'Member_nickname', 'Member_extra_vars', 'Member_userid', 'Social_meta');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Fruit_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'chkstring', 'url');

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
		$eventname = 'event_admin_member_fruits_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		// 검색이 가능한 필드
		$this->{$this->modelname}->allow_search_field = array(
			'company_info.company_name', 
			'member.mem_userid', 
			'member.mem_nickname', 
			'fruit_log.fru_related_id', 
			'fruit_log.log_regDt', 
			'fruit_log.log_txt'
		); 
		$this->{$this->modelname}->search_field_equal = array('log_sno', 'log_memNo'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('log_sno'); // 정렬이 가능한 필드
		$result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
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
		$search_option = array(
			'company_info.company_name'=>'기업명', 
			'member.mem_userid'=>'회원아이디', 
			'member.mem_nickname'=>'회원명', 
			'fruit_log.fru_related_id'=>'처리자',  
			'fruit_log.log_regDt' => '날짜', 
			'fruit_log.log_txt' => '내용'
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index', 'page_title' => '열매 지급/차감 관리', 'page_name' => "열매 지급/차감 관리");
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 열매지급(관리자 수기지급)
	 */
	public function write()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_member_fruits_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'mem_id' => $param->sort('mem_id', 'asc'),
			'mem_userid' => $param->sort('mem_userid', 'asc'),
			'mem_username' => $param->sort('mem_username', 'asc'),
			'mem_nickname' => $param->sort('mem_nickname', 'asc'),
			'mem_email' => $param->sort('mem_email', 'asc'),
			'mem_point' => $param->sort('mem_point', 'asc'),
			'mem_register_datetime' => $param->sort('mem_register_datetime', 'asc'),
			'mem_lastlogin_datetime' => $param->sort('mem_lastlogin_datetime', 'asc'),
			'mem_level' => $param->sort('mem_level', 'asc'),
		);
		$findex = $this->input->get('findex', null, 'member.mem_id');
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('member.mem_username','company_info.company_name','member.mem_id','member.mem_userid','member.mem_nickname'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('member.mem_id', 'member.mem_level', 'member.mem_is_admin'); // 검색중 like 가 아닌 = 검색을 하는 필드

		$where = array();
		if ($this->input->get('mem_is_admin')) {
			$where['member.mem_is_admin'] = 1;
		}
		if ($this->input->get('mem_denied')) {
			$where['member.mem_denied'] = 1;
		}
        if ($this->input->get('sh_company_name')) {
            $where['member.company_idx'] = $this->input->get('sh_company_name');
        }
		if ($mgr_id = (int) $this->input->get('mgr_id')) {
			if ($mgr_id > 0) {
				$where['mgr_id'] = $mgr_id;
			}
		}

		$result = $this->{$this->modelname}
			->get_fruit_member_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				$where = array(
					'mem_id' => element('mem_id', $val),
				);
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);

				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->Member_model->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = '/admin/member/fruits/write' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('member.mem_username' => '실명','member.mem_nickname' => '닉네임','member.mem_userid' => '회원아이디','company_info.company_name' => '기업명');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'write', 'page_title' => '열매 지급/차감 관리', 'page_name' => "열매 지급/차감 관리");
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

		if($this->input->post('mode') == 'register'){
			$fruitCheckFl = $this->input->post('fruitCheckFl'); // 지급/차감 여부
			$log_txt = $this->input->post('log_txt'); // 사유
			if(!$log_txt){
				alert('사유를 입력해주세요.');
				return false;
			}
			if(!$this->input->post('fruitValue')){
				alert('열매개수를 입력해주세요.');
				return false;
			}
			if($fruitCheckFl == 'add'){
				$fru_fruit = $this->input->post('fruitValue'); // 열매개수
			} else {
				$fru_fruit = '-'.$this->input->post('fruitValue'); // 열매개수
			}
			$fur_type = 'admin';
			$fru_related_id = $this->session->userdata('mem_userid');
			$fru_action = '관리자수기지급';
			if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
				foreach ($this->input->post('chk') as $val) {
					if ($val) {
						$fCount = $this->{$this->modelname}->getCountFruit($val);
						if($fruitCheckFl == 'remove'){
							if((int) $fCount['mem_cur_fruit'] < (int) $this->input->post('fruitValue')){
								alert('차감개수가 현재보유량보다 많습니다.');
								return false;
							} else {
								$nowFruit = $fCount['mem_cur_fruit'] - (int) $this->input->post('fruitValue');
							}
						} else {
							$nowFruit = $fCount['mem_cur_fruit'] + (int) $this->input->post('fruitValue');
						}
						
						$this->{$this->modelname}->insertFruitLog($val, $log_txt, $fru_fruit, $fur_type, $fru_related_id, $fru_action, $nowFruit);
						$this->{$this->modelname}->updateFruit($val, $nowFruit);

					}
				}
				redirect('/admin/member/fruits/write');
			} else {
				alert('열매를 지급/차감할 회원을 선택해주세요.');
				return false;
			}
		}
	}
}