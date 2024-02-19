<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Gamecontents_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'gamecontents';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'g_sno'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'gamecontents.*, asset_template.tp_nm';
		$join[] = array('table' => 'asset_template', 'on' => 'gamecontents.tp_sno = asset_template.tp_sno', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}
}
