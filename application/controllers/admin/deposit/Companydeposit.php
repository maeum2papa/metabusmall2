<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Depositlist class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>예치금>충전내역 controller 입니다.
 */
class Companydeposit extends CB_Controller
{
	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'deposit/companydeposit/lists';

    /**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Company_deposit_model';


    /**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

        $this->load->model('Company_deposit_model');

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
	public function lists()
	{
        
        $view = array();
		$view['view'] = array();

        /**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;


        $per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		if($this->input->get('type') == 1 ){
			$where["ccd_deposit > "] = 0;
		}else if($this->input->get('type') == 2 ){
			$where["ccd_deposit < "] = 0;
		}
		
		if($this->session->userdata['mem_admin_flag']!=0){
			$where['company_idx'] = $this->session->userdata['company_idx'];
		}
        
        $result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
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
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array(
			'layout' => 'layout', 
			'skin' => 'index',
			'page_title' => '예치금변동내역',
			'page_name' => '예치금변동내역'
		);
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['layout']['menu_title'] = "예치금변동내역";

		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 예치금 변동내역추가
	 */
	public function write()
	{
		if($this->sessin->userdata['mem_admin_flag']!=0){
			alert("잘못된 접근입니다.");
			exit;
		}
        
        $this->load->model('Company_info_model');

        $result = $this->Company_info_model
            ->get_admin_list(0, 999999999999, $where, '', $findex, $forder, $sfield, $skeyword);

        $view['view']['data']['companys'] = $result['list'];

        /**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array(
			'layout' => 'layout', 
			'skin' => 'write',
			'page_title' => '예치금변동내역',
			'page_name' => '예치금변동내역'
		);
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['layout']['menu_title'] = "예치금변동내역";
		
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

    }


    /**
	 * 예치금 변동내역추가 저장
	 */
	public function save()
	{
		if($this->sessin->userdata['mem_admin_flag']!=0){
			alert("잘못된 접근입니다.");
			exit;
		}

        $this->load->helper('cmall_helper');

        $this->load->model('Company_info_model');

        if($this->input->post('company_idx')==''){
            alert("잘못된 접근입니다.");
            exit;
        }

        if($this->input->post('ccd_deposit') == 0){
            alert("예치금이 0일 수 없습니다.");
            exit;
        }

        if($this->input->post('ccd_content') == ""){
            alert("내용은 필수입니다.");
            exit;
        }

        $now = date("Y-m-d H:i:s");

        $insertdata["company_idx"] = $this->input->post('company_idx');
        $insertdata["mem_id"] = $this->session->userdata['mem_id'];
        $insertdata["ccd_datetime"] = $now;
        $insertdata["ccd_content"] = "관리자(admin) ".$this->input->post('ccd_content');
        $insertdata["ccd_deposit"] = $this->input->post('ccd_deposit');
        $insertdata["ccd_type"] = "admin";
        $insertdata["ccd_action"] = "관리자가 어드민";
        $insertdata["ccd_now_deposit"] = 0;

        $company_deposit = camll_company_deposit($this->input->post('company_idx'));
        $insertdata["ccd_now_deposit"] = $company_deposit + ($this->input->post('ccd_deposit'));

        $this->Company_deposit_model->insert($insertdata);

        $updatedata['company_deposit'] = $insertdata["ccd_now_deposit"];

        $this->Company_info_model->update($this->input->post('company_idx'), $updatedata);
        
        redirect('admin/deposit/companydeposit/lists');
    }
}