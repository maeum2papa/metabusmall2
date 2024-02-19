<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Curriculum_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cb_category';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cca_id'; // 사용되는 테이블의 프라이머리키

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
		$cachename = 'curriculum-all';
		if ( ! $result = $this->cache->get($cachename)) {
			$return = $this->get($primary_value = '', $select = '', $where = '', $limit = '', $offset = 0, $findex = 'cca_order', $forder = 'asc');
			if ($return) {
				foreach ($return as $key => $value) {
					//debug($value);
					$result[$value['cca_parent']][] = $value;
				}
				//debug($result);
				$this->cache->save($cachename, $result);
			}
		}
		return $result;
	}
}
