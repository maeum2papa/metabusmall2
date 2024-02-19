<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *--------------------------------------------------------------------------
 *Admin Page 에 보일 메뉴를 정의합니다.
 *--------------------------------------------------------------------------
 *
 * Admin Page 에 새로운 메뉴 추가시 이곳에서 수정해주시면 됩니다.
 *
 */


$config['admin_page_menu']['exchange'] =
	array(
		'__config'					=> array('교환소관리', 'fa-shopping-cart'),
		'menu'						=> array(
			'cmallorder'			=> array('복지교환소관리', ''),
			'cmallitem'				=> array('복지교관소주문내역', ''),
			'qna'					=> array('상품문의', ''),
			'review'				=> array('상품후기', '')
		),
	);
