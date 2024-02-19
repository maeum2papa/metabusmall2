<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Acctimecrontab class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 이용시간 누적 crontab 실행 매일 3시간 마다
 */
class Acctimecrontab extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Stat', 'Stat_count', 'Stat_count_date', 'Post');
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
		$this->load->library(array('querystring'));
	}


	/**
	 * 이용시간 누적
	 */
	public function index()
	{
		// 회원별 누적시키기
		$now = date('Y-m-d H').':00:00';
		$ex_hour = date('Y-m-d H:i:s', strtotime('-3 hours', strtotime($now)));
		$sql = "select mem_id from cb_member_login_log where mll_success = 1 and mll_datetime >= '".$ex_hour."' and mll_datetime < '".$now."' group by mem_id";
		$data = $this->db->query($sql);
		$data_arr = $data->result_array();
		foreach($data_arr as $k => $v){
			$sql = "UPDATE cb_member SET acc_time = acc_time + 10800 WHERE mem_id = '".$v['mem_id']."'";
			$this->db->query($sql);
		}
		
		exit;
	}


	
}
