<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmall item model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Cmall_item_template_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cmall_item_template';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'citt_id'; // 사용되는 테이블의 프라이머리키

	public $allow_order = array(
        'citt_id desc'
    );

	function __construct()
	{
		parent::__construct();
	}


	/**
	 * List 페이지 커스테마이징 함수
	 */
	public function get_item_list($limit = '', $offset = '', $where = '', $orderby = '')
	{
		
		if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'citt_id desc';
		}

		$this->db->select('*');
		$this->db->from($this->_table);

		if ($where) {
			$this->db->where($where);
		}
	
		$this->db->order_by($orderby);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();
		


		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table);
		if ($where) {
			$this->db->where($where);
		}
		
		$qry = $this->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

		return $result;
	}

	/**
	 * 삭제
	 */
	public function delete($citt_id = 0)
	{

		if ($citt_id > 0) {
			$updatedata = array(
				'citt_status' => 3,
				'citt_updated_datetime' => cdate('Y-m-d H:i:s'),
			);
			$this->db->where($this->primary_key, $citt_id);
			$this->db->set($updatedata);
		}

		$result = $this->db->update($this->_table);

		return $result;

	}


	/**
	 * 노출상태변경
	 */
	public function update($change_citt_status = 0, $citt_id = 0)
	{

		if ($citt_id > 0) {
			$updatedata = array(
				'citt_status' => $change_citt_status,
				'citt_updated_datetime' => cdate('Y-m-d H:i:s'),
			);
			$this->db->where($this->primary_key, $citt_id);
			$this->db->set($updatedata);
		}

		$result = $this->db->update($this->_table);

		return $result;

	}


	
}
