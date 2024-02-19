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
class Asset_category extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'asset/asset_category';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Asset_category');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Asset_category_model';

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
	 * 분류관리를 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_asset_assetcategory_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		if ($this->input->post('type') === 'add') {
			$config = array(
				array(
					'field' => 'cate_parent',
					'label' => '상위카테고리',
					'rules' => 'trim',
				),
				array(
					'field' => 'cate_value',
					'label' => '카테고리명',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'cate_order',
					'label' => '정렬순서',
					'rules' => 'trim|numeric|is_natural',
				),
			);
		} else {
			$config = array(
				array(
					'field' => 'cate_sno',
					'label' => '카테고리아이디',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'cate_value',
					'label' => '카테고리명',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'cate_order',
					'label' => '정렬순서',
					'rules' => 'trim|numeric|is_natural',
				),
			);
		}
		$this->form_validation->set_rules($config);


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			if ($this->input->post('type') === 'add') {

				$cate_order = $this->input->post('cate_order') ? $this->input->post('cate_order') : 0;
				$insertdata = array(
					'cate_type' => $this->input->post('cate_type', null, ''),
					'cate_value' => $this->input->post('cate_value', null, ''),
					'cate_kr' => $this->input->post('cate_kr', null, ''),
					'cate_parent' => $this->input->post('cate_parent', null, 0),
					'cate_order' => $cate_order,
				);
				$this->Asset_category_model->insert($insertdata);
				$this->cache->delete('asset-category-all');
				$this->cache->delete('asset-category-detail');

				$view['view']['alert_message'] = '카테고리 설정이 저장되었습니다';

				redirect(admin_url($this->pagedir), 'refresh');

			}
			if ($this->input->post('type') === 'modify') {

				$cate_order = $this->input->post('cate_order') ? $this->input->post('cate_order') : 0;
				$updatedata = array(
					'cate_type' => $this->input->post('cate_type', null, ''),
					'cate_value' => $this->input->post('cate_value', null, ''),
					'cate_kr' => $this->input->post('cate_kr', null, ''),
					'cate_order' => $cate_order,
				);
				$this->Asset_category_model->update($this->input->post('cate_sno'), $updatedata);
				$this->cache->delete('asset-category-all');
				$this->cache->delete('asset-category-detail');

				$view['view']['alert_message'] = '카테고리 정보가 수정되었습니다';

				redirect(admin_url($this->pagedir), 'refresh');

			}
		}

		$getdata = $this->Asset_category_model->get_all_category();
		$view['view']['data'] = $getdata;
		//debug($getdata);
		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $primary_key;

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
	 * 카테고리 삭제
	 */
	public function delete($cca_id = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_asset_assetcategory_delete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		$cca_id = (int) $cca_id;
		if (empty($cca_id) OR $cca_id < 1) {
			show_404();
		}

		$this->Asset_category_model->delete($cca_id);
		$this->cache->delete('asset-category-all');
		$this->cache->delete('asset-category-detail');

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
}
