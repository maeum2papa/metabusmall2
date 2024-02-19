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
 * 채팅과 관련된 controller 입니다.
 */
class Chat extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Land');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Land_model';
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
		$this->load->library(array('querystring'));
		if (!$this->member->is_member()) {
			redirect('https://collaborland.kr/');
		}
	}


	/**
	 * 페이지기본 기본
	 */
	public function index()
	{
		if (!$this->member->is_member()) {
			
			alert("본 서비스는 로그인 후 사용 가능합니다.","/login");
		}
		$layoutconfig = array(
			'path' => 'chat',
			'layout' => 'layout',
			'skin' => 'main',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'bootstrap',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'bootstrap',
			'page_title' => "채팅",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "채팅",
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		//$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function getInfo($idx = NULL) {
		if ($idx != NULL) {						

			$q = "select mem_nickname, mem_div, mem_state from cb_member where mem_id = ".$idx;
			$r = $this->db->query($q);
			$datas = $r->result_array();  
			$data = $datas[0];
			
			echo "{\"mem_nickname\": \"${data['mem_nickname']}\", \"mem_div\": \"${data['mem_div']}\", \"mem_state\": \"${data['mem_state']}\"}";
		}
	}

}
