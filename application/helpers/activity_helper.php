<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 활동 헬퍼
 */

 if ( ! function_exists('ahistoty')) {
    /**
     * 회원 활동 내역
     * @param int $limit
     * @param int $offset
     * @param int $where
     * @param int $orderby
     * @param int $sfield
     * @param int $skeyword
     * @return array list 내역
     */
    function ahistoty($limit, $offset, $where, $orderby, $sfield, $skeyword){

        $CI =& get_instance();

        $table = "object_log";

		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('log_txt');
		}

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

		$CI->db->select('object_log.*');
		$CI->db->from($table);

		if ($where) {
			$CI->db->where($where);
		}
		if ($search_where) {
			$CI->db->where($search_where);
		}

		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$CI->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$CI->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$CI->db->or_like($skey, $sval);
				}
			}
			$CI->db->group_end();
		}

		$CI->db->order_by($orderby);
		if ($limit) {
			$CI->db->limit($limit, $offset);
		}
		$qry = $CI->db->get();
		$result['list'] = $qry->result_array();

		$CI->db->select('count(*) as rownum');
		$CI->db->from($table);
		if ($where) {
			$CI->db->where($where);
		}
		if ($search_where) {
			$CI->db->where($search_where);
		}

		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$CI->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$CI->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$CI->db->or_like($skey, $sval);
				}
			}
			$CI->db->group_end();
		}
		$qry = $CI->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

		return $result;
    }
}