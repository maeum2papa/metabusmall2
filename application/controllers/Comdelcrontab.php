<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comdelcrontab class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 기업 비활성화 적용 및 삭제 체크
 */
class Comdelcrontab extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Company_info');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Company_info_model';
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
	 * 비활성화 및 삭제
	 */
	public function index()
	{
        $today = date('Y-m-d');
		// 기업별 이용종료일 체크 => 비활성화(기업, 회원)
        $sql = "SELECT company_idx, use_eday FROM cb_company_info WHERE state = 'use' and use_eday < '".$today."'";
        $r = $this->db->query($sql);
        $result = $r->result_array();
        foreach($result as $k => $v){
            $sql = "UPDATE cb_company_info SET state = 'unuse', com_stateDt = '".$today." 00:00:00' WHERE company_idx = ".$v['company_idx'];
            $this->db->query($sql);

            $sql = "UPDATE cb_member SET mem_useYn = 'n', mem_useDt = '".$today." 00:00:00' WHERE company_idx = ".$v['company_idx'];
            $this->db->query($sql);
        }


        // 이용종료일 6개월 뒤 삭제
        $sql = "SELECT company_idx, com_stateDt FROM cb_company_info WHERE state = 'unuse'";
        $r = $this->db->query($sql);
        $result = $r->result_array();
        foreach($result as $k => $v){
            $timestamp = strtotime('+6 months', strtotime($v['com_stateDt']));
            if(date('Y-m-d', $timestamp) == $today){
                $sql = "DELETE FROM cb_company_info WHERE company_idx = ".$v['company_idx'];
                $this->db->query($sql);
            }
        }

		// 이벤트 활성화
		$sql = "UPDATE cb_event_company SET event_showFl = 'y' WHERE event_startDt = '".$today."'";
		$this->db->query($sql);

		// 이벤트 비활성화
		$sql = "UPDATE cb_event_company SET event_showFl = 'n' WHERE DATE(event_endDt) = CURDATE() - INTERVAL 1 DAY";
		$this->db->query($sql);
		
		exit;
	}


	
}
