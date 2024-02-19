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


$config['admin_page_menu']['counter'] =
	array(
		'__config'					=> array('통계', 'fa-bar-chart-o'),
		'menu'						=> array(
			'statcounter'			=> array('접속통계', ''),
            'lmscounter'			=> array('학습통계', ''),
			'fruitscounter'			=> array('열매통계', ''),
            'shopcounter'			=> array('SHOP통계', ''),
		),
	);
