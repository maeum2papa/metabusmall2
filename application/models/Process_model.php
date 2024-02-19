<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_model extends CB_Model
{
    /**
     * 테이블명
     */
    public $_table = 'process';

    /**
     * 사용되는 테이블의 프라이머리키
     */
    public $primary_key = 'process_idx'; // 사용되는 테이블의 프라이머리키

    public $search_sfield = '';

    function __construct()
    {
        parent::__construct();
    }

    public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $cate_flag = 0, $sop = 'OR')
    {
        $join = array();

        $select = 'process.*, plan.plan_name';
        $join[] = array('table' => 'plan', 'on' => 'process.plan_idx = plan.plan_idx', 'type' => 'inner');

        if($cate_flag == 1) $join[] = array('table' => 'category_rel', 'on' => 'process.process_idx = category_rel.process_idx', 'type' => 'inner');

        $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

        return $result;
    }

    public function get_category_list($cca_parent=0)
    {
        $sql = "select * from cb_category where cca_parent = $cca_parent order by cca_order, cca_value asc; ";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }

    public function get_category_rel_list($pid)
    {
        $sql = "SELECT c.cca_id, c.cca_desc FROM cb_category_rel AS r
                    INNER JOIN cb_category AS c ON r.cca_id = c.cca_id
                WHERE r.process_idx = $pid ORDER BY c.cca_order ASC";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }

    public function get_company_rel_list($pid)
    {
        $sql = "SELECT c.company_idx, c.company_name FROM cb_process_rel AS r
                    INNER JOIN cb_company_info AS c ON r.company_idx = c.company_idx
                WHERE r.process_idx = $pid ORDER BY c.company_name ASC";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }

    public function set_category_rel($idx, $add_category_idx)
    {
        $sql = "delete from cb_category_rel where process_idx = $idx";
        $this->db->query($sql);

        foreach($add_category_idx as $l)
        {
            $sql = "insert into cb_category_rel (cca_id,process_idx) values ($l, $idx)";
            $this->db->query($sql);
        }

        return true;
    }

    public function set_company_rel($idx, $add_company_idx)
    {
        $sql = "delete from cb_process_rel where process_idx = $idx";
        $this->db->query($sql);

        foreach($add_company_idx as $l)
        {
            $sql = "insert into cb_process_rel (company_idx,process_idx) values ($l, $idx)";
            $this->db->query($sql);
        }

        return true;
    }

    public function get_video_list()
    {
        $sql = "SELECT video_idx, video_name from cb_video order by video_name ASC";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }

    public function get_game_content_list()
    {
        $sql = "SELECT g_sno, g_nm from cb_gamecontents order by g_sno ASC";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }

    public function get_curriculum_list($pid)
    {
        $sql = "select c.*, v.video_name, g.g_nm from cb_curriculum as c
                 left join cb_video as v on v.video_idx = c.video_idx
                 left join cb_gamecontents as g on g.g_sno = c.game_content_idx
                where c.del_flag = 'n' and c.process_idx = $pid order by c.order_num asc";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }

    public function set_curriculum_save($in_array)
    {
        $sql = "select ifnull(max(order_num),0) + 1 as cnt from cb_curriculum where process_idx = ".$in_array['process_idx'];
        $rs = $this->db->query($sql);
        $row_array = $rs->row_array();
        $in_array['order_num'] = $row_array['cnt'];

        $this->db->insert('cb_curriculum', $in_array);

        return $this->db->insert_id();
    }

    public function set_curriculum_del($pid, $curriculum_idx)
    {
        $this->db->update('cb_curriculum', array('del_flag'=>'y','del_dt'=>date('Y-m-d H:i:s')), array('curriculum_idx'=>$curriculum_idx,'process_idx'=>$pid));
    }

    public function set_item_cnt($pid, $curriculum_idx, $item_cnt)
    {
        $this->db->update('cb_curriculum', array('item_cnt'=>$item_cnt), array('curriculum_idx'=>$curriculum_idx,'process_idx'=>$pid));
    }

    public function curriculum_use_save($curriculum_idx, $type_flg)
    {
        $this->db->update('cb_curriculum', array('state'=>$type_flg), array('curriculum_idx'=>$curriculum_idx));
    }

    public function set_order_num_save($pid, $item, $position)
    {
        $this->db->update('cb_curriculum', array('order_num'=>$position), array('curriculum_idx'=>$item,'process_idx'=>$pid));
    }
}
?>