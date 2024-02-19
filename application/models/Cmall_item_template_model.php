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
	public function get_item_list($limit = '', $offset = '', $where = '', $category_id = 0, $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
	
		return NULL;
	}

	
}
