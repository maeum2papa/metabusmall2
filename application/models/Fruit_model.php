<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fruit model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Fruit_model extends CB_Model
{
    /**
	 * 테이블명
	 */
	public $_table = 'fruit_log';
	public $_table2 = 'member';

    /**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'log_sno'; // 사용되는 테이블의 프라이머리키
	public $primary_key2 = 'mem_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

    public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'fruit_log.*, member.mem_cur_fruit, member.mem_userid, member.mem_username, member.mem_nickname, member.mem_is_admin, member.mem_icon, company_info.company_name';
		$join[] = array('table' => 'member', 'on' => 'member.mem_id = fruit_log.log_memNo', 'type' => 'left');
		$join[] = array('table' => 'company_info', 'on' => 'company_info.company_idx = member.company_idx', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
	}

	public function get_fruit_member_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'member.*, company_info.company_name';
		$join[] = array('table' => 'company_info', 'on' => 'company_info.company_idx = member.company_idx', 'type' => 'left');

		if (empty($findex) OR ! in_array($findex, $this->allow_order_field)) {
			$findex = $this->primary_key2;
		}
		$forder = (strtoupper($forder) === 'ASC') ? 'ASC' : 'DESC';
		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';

		$count_by_where = array();
		$search_where = array();
		$search_like = array();
		$search_or_like = array();
		if ($sfield && is_array($sfield)) {
			foreach ($sfield as $skey => $sval) {
				$ssf = $sval;
				if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
					if (in_array($ssf, $this->search_field_equal)) {
						$search_where[$ssf] = $skeyword;
					} else {
						$swordarray = explode(' ', $skeyword);
						foreach ($swordarray as $str) {
							if (empty($ssf)) {
								continue;
							}
							if ($sop === 'AND') {
								$search_like[] = array($ssf => $str);
							} else {
								$search_or_like[] = array($ssf => $str);
							}
						}
					}
				}
			}
		} else {
			$ssf = $sfield;
			if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
				if (in_array($ssf, $this->search_field_equal)) {
					$search_where[$ssf] = $skeyword;
				} else {
					$swordarray = explode(' ', $skeyword);
					foreach ($swordarray as $str) {
						if (empty($ssf)) {
							continue;
						}
						if ($sop === 'AND') {
							$search_like[] = array($ssf => $str);
						} else {
							$search_or_like[] = array($ssf => $str);
						}
					}
				}
			}
		}

		if ($select) {
			$this->db->select($select);
		}
		$this->db->from($this->_table2);
		if ( ! empty($join['table']) && ! empty($join['on'])) {
			if (empty($join['type'])) {
				$join['type'] = 'left';
			}
			$this->db->join($join['table'], $join['on'], $join['type']);
		} elseif (is_array($join)) {
			foreach ($join as $jkey => $jval) {
				if ( ! empty($jval['table']) && ! empty($jval['on'])) {
					if (empty($jval['type'])) {
						$jval['type'] = 'left';
					}
					$this->db->join($jval['table'], $jval['on'], $jval['type']);
				}
			}
		}

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($like) {
			$this->db->like($like);
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		if ($count_by_where) {
			$this->db->where($count_by_where);
		}

		$this->db->order_by($findex, $forder);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table2);
		if ( ! empty($join['table']) && ! empty($join['on'])) {
			if (empty($join['type'])) {
				$join['type'] = 'left';
			}
			$this->db->join($join['table'], $join['on'], $join['type']);
		} elseif (is_array($join)) {
			foreach ($join as $jkey => $jval) {
				if ( ! empty($jval['table']) && ! empty($jval['on'])) {
					if (empty($jval['type'])) {
						$jval['type'] = 'left';
					}
					$this->db->join($jval['table'], $jval['on'], $jval['type']);
				}
			}
		}
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($like) {
			$this->db->like($like);
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		if ($count_by_where) {
			$this->db->where($count_by_where);
		}
		$qry = $this->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

		return $result;
	}

	/** 
	 * 열매 지급/차감(관리자) 로그 등록
	 */
	public function insertFruitLog($log_memNo, $log_txt, $fru_fruit, $fur_type, $fru_related_id, $fru_action, $nowFruit)
	{
		$sql = "INSERT INTO cb_fruit_log 
				SET 
					log_memNo = '".$log_memNo."', 
					log_txt = '".$log_txt."', 
					log_regDt = '".date('Y-m-d H:i:s')."', 
					fru_fruit = '".$fru_fruit."', 
					fur_type = '".$fur_type."', 
					fru_related_id = '".$fru_related_id."', 
					fru_action = '".$fru_action."', 
					fru_now_fruit = '".$nowFruit."'
				";
		$this->db->query($sql);
	}

	/** 
	 * 열매 지급/차감(관리자) 회원정보 업데이트
	 */
	public function updateFruit($mem_id, $nowFruit)
	{
		$sql = "UPDATE cb_member SET mem_cur_fruit = '".$nowFruit."' WHERE mem_id = '".$mem_id."'";
		$this->db->query($sql);
	}

	/**
	 * 현재 보유 열매 개수 체크
	 */
	public function getCountFruit($mem_id)
	{
		$this->db->select('mem_cur_fruit');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->where('mem_id', $mem_id);

        $result = $this->db->get($this->_table2);

        return $result->row_array();
	}
}