<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmall order detail model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Cmall_order_detail_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cmall_order_detail';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cod_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_by_item($cor_id = 0)
	{
		$cor_id = preg_replace('/[^0-9]/', '', $cor_id);
		if (empty($cor_id) OR $cor_id < 1) {
			return;
		}

		$this->db->select('cit_id');
		$this->db->where('cor_id', $cor_id);
		$this->db->group_by('cit_id');
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}


	public function get_detail_by_item($cor_id = 0, $cit_id = 0)
	{
		$cor_id = preg_replace('/[^0-9]/', '', $cor_id);
		if (empty($cor_id) OR $cor_id < 1) {
			return;
		}
		$cit_id = preg_replace('/[^0-9]/', '', $cit_id);
		if (empty($cit_id) OR $cit_id < 1) {
			return;
		}

		$this->db->select('cmall_item_detail.*, cmall_order_detail.cod_id, cmall_order_detail.cod_count, cmall_order_detail.cod_download_days, cmall_order_detail.cod_status, cmall_order_detail.cod_fruit, cmall_order_detail.company_coin_value, cmall_order_detail.cit_price, cmall_order_detail.cde_price, cmall_order_detail.cod_company_deposit');
		$this->db->from('cmall_order_detail');
		$this->db->join('cmall_item_detail', 'cmall_order_detail.cde_id = cmall_item_detail.cde_id', 'inner');
		$this->db->where('cmall_order_detail.cor_id', $cor_id);
		$this->db->where('cmall_order_detail.cit_id', $cit_id);
		$qry = $this->db->get();
		$result = $qry->result_array();

		return $result;
	}

	/**
	 * 회원이 구매한 상품 조회 (한번만 구매 가능한 상품을 구매 했는지 확인하기 위함)
	 */
	public function get_detail_by_item2($mem_id = 0, $cit_id = 0){

		$cit_id = preg_replace('/[^0-9]/', '', $cit_id);
		if (empty($cit_id) OR $cit_id < 1) {
			return;
		}

		$this->db->select('cmall_order_detail.*');
		$this->db->from('cmall_order_detail');
		$this->db->where('cmall_order_detail.mem_id', $mem_id);
		$this->db->where('cmall_order_detail.cit_id', $cit_id);
		
		$this->db->group_start();
			$this->db->or_where('cmall_order_detail.cod_status', 'order');
			$this->db->or_where('cmall_order_detail.cod_status', 'end');
		$this->db->group_end();
		// (a='a' OR a='b')

		$qry = $this->db->get();
		$result = $qry->result_array();


		return $result;

	}


	/**
	 * 결제 초기화
	 */
	public function pay_init($cod_id){
		$q = "update cb_cmall_order_detail set cod_fruit=0, cod_company_deposit=0, cod_point=0 where cod_id='".$cod_id."'";
		$this->db->query($q);
	}


	/**
	 * 주문상품 상태 취소 처리
	 */
	public function set_status_cancel($cod_id,$now){ 
		$q = "update cb_cmall_order_detail set cod_status='cancel', cod_cancel_datetime='".$now."' where cod_id='".$cod_id."'";
		$this->db->query($q);
	}

	/**
	 * 주문상품 상태 변경 처리
	 */
	public function set_status_change($cod_id,$status,$now){
		$q = "update cb_cmall_order_detail set cod_status='".$status."' where cod_id='".$cod_id."'";
		$this->db->query($q);

		if($status=='end'){
			$q = "update cb_cmall_order_detail set cod_end_datetime='".$now."' where cod_id='".$cod_id."'";
		}else if($status=='cancel'){
			$q = "update cb_cmall_order_detail set cod_cancel_datetime='".$now."' where cod_id='".$cod_id."'";
		}

		$this->db->query($q);

	}
}
