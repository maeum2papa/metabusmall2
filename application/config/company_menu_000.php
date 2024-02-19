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


$config['admin_page_menu']['cinfo'] =
    array(
        '__config'					=> array('운영관리', 'fa-users'),
        'menu'						=> array(
            'company'               => array('기업관리', ''),
            'members'				=> array('회원관리', ''),
            'fruits'				=> array('열매 지급/차감 관리', ''),
            'statcounter'			=> array('접속통계', ''),
            'lmscounter'			=> array('학습통계', ''),
        ),
    );
