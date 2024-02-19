<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CB_Model
{
    /**
     * 테이블명
     */
    public $_table = 'video';

    /**
     * 사용되는 테이블의 프라이머리키
     */
    public $primary_key = 'video_idx'; // 사용되는 테이블의 프라이머리키

    public $search_sfield = '';

    function __construct()
    {
        parent::__construct();
    }

    public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $cate_flag = 0, $sop = 'OR')
    {
        $join = array();

        $select = '*';

        $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

        return $result;
    }

}
?>