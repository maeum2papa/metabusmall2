<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Board model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */



class Dashboard_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'business_esset';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cl_sno'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}
	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = '*';
		$result = $this->_get_list_common($select, '', $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

}
