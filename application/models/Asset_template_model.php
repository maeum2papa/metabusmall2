<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Asset_template_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'asset_template';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'tp_sno'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'asset_template.*, asset_category.cate_value, asset_category.cate_parent, asset_category.cate_kr';
		$join[] = array('table' => 'asset_category', 'on' => 'asset_template.cate_sno = asset_category.cate_sno', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}
}
