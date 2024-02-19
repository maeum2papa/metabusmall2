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
 * crontab 실행
 */
class Crontab extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Myland');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Myland_model';
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
	}


	/**
	 * 페이지기본 기본
	 */
	public function index()
	{
		//두번 안돌게 처리
		$q = "select * from cb_crontab_log where seum_regDt like '".date("Y-m-d")."%'";
		$r = $this->db->query($q);
		$cron_log = (array) $r->row();
		
		if(!$cron_log_start[seum_sno]){
			
			//스타트 로그저장
			$param[seum_position] = 's';
			$this->db->insert('cb_crontab_log', $param);

			// 물길어오는거 리셋 매일
			$update_data = array(
				'my_waterYn'      => 'y',
				'any_waterYn'      => 'y',
				'any_visitYn'      => 'n',
			);

			$result = $this->db->update('cb_member', $update_data); 








			//종료로그저장
			$param[seum_position] = 'e';
			$this->db->insert('cb_crontab_log', $param);
			
			
		}
		
		
		
		
		exit;
		
		
	}


	
}
