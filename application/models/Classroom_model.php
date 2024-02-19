<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Board model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */



class Classroom_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'my_process';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mp_sno'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}
	
	public function get_myclass_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'my_process.mp_sno, my_process.mp_endYn, my_process.mp_percent, lms_process.* ';
		$join[] = array('table' => 'lms_process', 'on' => 'my_process.p_sno = lms_process.p_sno', 'type' => 'inner');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}
	public function get_business_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'my_process.mp_sno, my_process.mp_endYn, my_process.mp_percent, lms_process.* ';
		$join[] = array('table' => 'lms_process', 'on' => 'my_process.p_sno = lms_process.p_sno', 'type' => 'right');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

}
