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

$config['admin_page_menu']['lms'] =
    array(
        '__config'					=> array('LMS', 'fa-pencil-square-o'),
        'menu'						=> array(
            'curriculum'			=> array('과정카테고리', ''),
			'process'			=> array('과정관리', ''),
            'videoinfo'    			=> array('동영상컨텐츠', ''),
			'gamecontents'    			=> array('게임컨텐츠', ''),
        ),
    );
