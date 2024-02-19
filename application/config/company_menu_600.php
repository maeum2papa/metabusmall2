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


$config['admin_page_menu']['cmall'] =
	array(
		'__config'					=> array('SHOP 관리', 'fa-shopping-cart'),
		'menu'						=> array(
			'cmallorder'			=> array('주문내역', ''),
			'cmallitem'				=> array('상품관리', ''),
			'qna'					=> array('상품문의', ''),
			'review'				=> array('상품사용후기', ''),
            '../deposit/companydeposit/lists'			=> array('예치금변동내역', '')
		),
	);
