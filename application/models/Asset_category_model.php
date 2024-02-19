<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Asset_category_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cb_asset_category';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cate_sno'; // 사용되는 테이블의 프라이머리키

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
	
	public function get_all_category()
	{
		$cachename = 'asset-category-all';
		if ( ! $result = $this->cache->get($cachename)) {
			$return = $this->get($primary_value = '', $select = '', $where = '', $limit = '', $offset = 0, $findex = 'cate_type , cate_order', $forder = 'desc , asc');
			if ($return) {
				foreach ($return as $key => $value) {
					//debug($value);
					$result[$value['cate_parent']][] = $value;
				}
				$this->cache->save($cachename, $result);
			}
		}
		return $result;
	}
}
