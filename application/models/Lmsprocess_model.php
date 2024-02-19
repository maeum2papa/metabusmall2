<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Lmsprocess_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'lms_process';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'p_sno'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'lms_process.*, plan.plan_name';
		$join[] = array('table' => 'plan', 'on' => 'lms_process.plan_idx = plan.plan_idx', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}
	
	public function get_user_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR', $mem_id = '')
	{
		$select = 'lms_process.*, my_process.mp_endYn, my_process.mp_sno';
		$join[] = array('table' => 'my_process', 'on' => 'lms_process.p_sno = my_process.p_sno AND my_process.mem_id = '.$mem_id, 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}
	
	
	public function get_business_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'lms_process.*, plan.plan_name, lms_process_company_exposure.exYn';
		$join[] = array('table' => 'plan', 'on' => 'lms_process.plan_idx = plan.plan_idx', 'type' => 'left');
		$join[] = array('table' => 'lms_process_company_exposure', 'on' => 'lms_process.p_sno = lms_process_company_exposure.p_sno', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		//debug($result);
		return $result;
	}
	
	//플랜 리스트
	public function get_plan_list()
    {
        $q = "SELECT plan_idx, plan_name FROM cb_plan";
        $r = $this->db->query($q);
        $result = $r->result_array();

        return $result;
    }
	//컴퍼니 리스트
	public function get_company_list()
    {
        $q = "SELECT company_idx, company_name FROM cb_company_info where state = 'use'";
        $r = $this->db->query($q);
        $result = $r->result_array();

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
		$q = "SELECT pc.cca_id, c.cca_desc FROM cb_lms_process_category AS pc
                    INNER JOIN cb_category AS c ON pc.cca_id = c.cca_id
                WHERE pc.p_sno = '".$pid."' ORDER BY c.cca_desc ASC";
        $r= $this->db->query($q);
        $result = $r->result_array();
		

        return $result;
    }
	public function get_company_rel_list($pid)
    {

		$q = "SELECT pc.company_idx, c.company_name FROM cb_lms_process_company AS pc
                    INNER JOIN cb_company_info AS c ON pc.company_idx = c.company_idx
                WHERE pc.p_sno = '".$pid."' and c.state = 'use' ORDER BY c.company_name ASC";
        $r = $this->db->query($q);
        $result = $r->result_array();
		
        return $result;
    }
	
	public function get_game_list($pid=null)
    {
		if($pid){
			$where = "where g_nm like '%".$pid."%'";
		}
        $sql = "SELECT g_sno, g_nm FROM cb_gamecontents ".$where." ORDER BY g_sno DESC limit 10";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();

        return $result;
    }
	
	public function get_video_list($pid=null)
    {
		if($pid){
			$where = "where video_name like '%".$pid."%'";
		}
        $sql = "SELECT video_idx, video_name FROM cb_video ".$where." ORDER BY video_idx DESC limit 10";
        $rs = $this->db->query($sql);
        $result = $rs->result_array();
		
        return $result;
    }
	public function get_curri_list($pid=null)
    {
		if($pid){
			$where = "where p_sno = '".$pid."'";
		}
        $q = "SELECT * FROM cb_lms_process_curriculum ".$where." ORDER BY c_order";
        $r = $this->db->query($q);
        $result2 = $r->result_array();
		
		foreach ($result2 as $k => $v) {
			if($v[c_type] == 'v'){
				$q = "select video_name from cb_video where video_idx = '".$v[t_sno]."'";
				$r = $this->db->query($q);
				$v_data = (array) $r->row();
				if($v_data){
					$result[$k][c_order] = $v[c_order];
					$result[$k][c_type] = "영상";
					$result[$k][c_content] = $v_data[video_name];
				}
			}else if($v[c_type] == 'g'){
				$q = "select g_nm from cb_gamecontents where g_sno = '".$v[t_sno]."'";
				$r = $this->db->query($q);
				$g_data = (array) $r->row();
				if($g_data){
					$result[$k][c_order] = $v[c_order];
					$result[$k][c_type] = "게임";
					$result[$k][c_content] = $g_data[g_nm];
				}
			}else{
				$result[$k][c_order] = $v[c_order];
				$result[$k][c_type] = "씨앗";
				$result[$k][c_content] = $v[t_sno]."개 지급";
			}
		}
		
        return $result;
    }
	
	public function set_category($pid=null,$p_add_category=null)
    {
		//삭제를 위한 기본 배열
	 	$q = "SELECT cca_id FROM cb_lms_process_category where p_sno = '".$pid."'";
        $r = $this->db->query($q);
        $cca_id = $r->result_array();
		if($cca_id){
			foreach ($cca_id as $k => $v) {
				$cca_id_arr[] = $v[cca_id];
			}
		}
		
		
		if($pid && $p_add_category){
			$add_category = explode("*|*",$p_add_category);
			
			foreach ($add_category as $k => $v) {
				$q = "SELECT c_sno FROM cb_lms_process_category WHERE cca_id = '".$v."' and p_sno = '".$pid."'";
				$r = $this->db->query($q);
				$c_sno = (array) $r->row();	
				if(!$c_sno[c_sno]){
					$param = array(
						'cca_id'      => $v,
						'p_sno'      => $pid,
					);
					$this->db->insert('cb_lms_process_category', $param);
				}
				//삭제를 위한 배열
				$p_diff_cate[] = $v;
			}
		}else{
			$p_diff_cate = array();
		}
		//배열 삭제 처리
		if($cca_id_arr){
			$cca_id_arr = array_diff($cca_id_arr, $p_diff_cate);
			if($cca_id_arr){
				foreach ($cca_id_arr as $k => $v) {
					$sql = "delete from cb_lms_process_category where p_sno = '".$pid."' and cca_id = '".$v."'";
					$this->db->query($sql);
				}
			}
		}
    }
	
	public function set_company($pid=null,$p_add_company=null)
    {
		//삭제를 위한 기본 배열
	 	$q = "SELECT company_idx FROM cb_lms_process_company where p_sno = '".$pid."'";
        $r = $this->db->query($q);
        $company_idx = $r->result_array();
		if($company_idx){
			foreach ($company_idx as $k => $v) {
				$company_idx_arr[] = $v[company_idx];
			}
		}
		
		
		if($pid && $p_add_company){
			$add_company_idx = explode("*|*",$p_add_company);
			
			foreach ($add_company_idx as $k => $v) {
				$q = "SELECT c_sno FROM cb_lms_process_company WHERE company_idx = '".$v."' and p_sno = '".$pid."'";
				$r = $this->db->query($q);
				$c_sno = (array) $r->row();	
				if(!$c_sno[c_sno]){
					$param = array(
						'p_sno'      => $pid,
						'company_idx'      => $v,
					);
					$this->db->insert('cb_lms_process_company', $param);
				}
				//삭제를 위한 배열
				$p_diff_company[] = $v;
			}
		}else{
			$p_diff_company = array();
		}
		//배열 삭제 처리
		if($company_idx_arr){
			$company_idx_arr = array_diff($company_idx_arr, $p_diff_company);
			if($company_idx_arr){
				foreach ($company_idx_arr as $k => $v) {
					$sql = "delete from cb_lms_process_company where p_sno = '".$pid."' and company_idx = '".$v."'";
					$this->db->query($sql);
				}
			}
		}
    }
	
	public function set_curri($pid=null,$curri_json=null)
    {
		//커리큘럼은 수정 및 삭제 안됨 , 과정을 새로 등록하는걸로
				
		if($pid && $curri_json){
			$curri_arr = json_decode($curri_json, true);
			
			foreach ($curri_arr as $k => $v) {
				$param = array(
					'p_sno'      => $pid,
					'c_type'      => $v[cur_type],
					't_sno'      => $v[cur_sno],
					'c_order'      => $v[cur_num],
				);
				$this->db->insert('cb_lms_process_curriculum', $param);
				$sno = $this->db->insert_id();
				if($sno){
					$upYn = 'y';
				}
			}
			if($upYn == 'y'){
				$update_data = array(
					'p_curriYn'      => 'y',
				);
				$update_where = array(
					'p_sno'      => $pid,
				);
				$result = $this->db->update('cb_lms_process', $update_data, $update_where);  	
			}
			 
		}
    }
}
