<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Post model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Post_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'post';
	public $_table2 = 'comment';
	public $_table3 = 'member';
	public $_table4 = 'company_info';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'post_id'; // 사용되는 테이블의 프라이머리키

	public $allow_order = array('post_num, post_reply', 'post_datetime desc', 'post_datetime asc', 'post_hit desc', 'post_hit asc', 'post_comment_count desc', 'post_comment_count asc', 'post_comment_updated_datetime desc', 'post_comment_updated_datetime asc', 'post_like desc', 'post_like asc', 'post_id desc');

	public $company_idx = 0;

    private $where = '';

    function __construct()
	{
        $this->company_idx = $this->session->userdata['company_idx'];

        $this->where = " (case when post_extra_vars.pev_value is not null and post_extra_vars.pev_value != '' then post_extra_vars.pev_value  >= DATE_FORMAT(NOW(),'%m/%d/%Y') else 1=1 end) ";

		// 전체관리자인 경우 전체목록 노출이 안되어 주석처리
		//if($this->company_idx != 0) $this->where .= " and cb_member.company_idx in (0,". $this->company_idx.") ";
        

		parent::__construct();
	}

	/**
	 * List 댓글 커스터마이징 함수
	 */
	public function get_comment_list($post_num)
	{
		$where = array(
			'post_reply <>' => '',
			'post_num' => $post_num,
		);
		$this->db->select('post.*, company_info.company_name, member.mem_div, member.mem_position, member.company_idx, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point');
		$this->db->from($this->_table);
		$this->db->join('member', 'member.mem_id = post.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->join("(select post_id, pev_value from cb_post_extra_vars where pev_key = 'view_eday') as post_extra_vars", "post.post_id = post_extra_vars.post_id", 'left');

        $this->db->where($where);

		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		return $result;
	}

	/**
	 * List 기업정보 불러오기
	 */
	public function get_company_info($mem_id)
	{
		$where = array(
			'mem_id' => $mem_id,
		);
		$this->db->select('member.company_idx, company_info.company_name');
		$this->db->from($this->_table3);
		$this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
		$this->db->where($where);
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		return $result;
	}


	/**
	 * List 소속 idx 불러오기
	 */
	public function get_company_idx($mem_userid)
	{
		$where = array(
			'mem_userid' => $mem_userid,
		);
		$this->db->select('company_idx');
		$this->db->from($this->_table3);
		$this->db->where($where);
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		return $result;
	}

	/**
	 * List 어드민 문의게시판(기업)
	 */
	public function get_admin_cqna_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $company_idx, $sop = 'OR')
	{
		$select = 'post.*';
		$join['table'] = 'member';
		$join['on'] = 'member.mem_id = post.mem_id';
		$join['type'] = 'left';
		$where = array(
			'post.post_del <>' => 2, 
            'post.brd_id' =>4, 
			'post.post_reply' => '',
			'member.company_idx' => $company_idx,
		);
		$result = $this->_get_list_common($select = 'post.*', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

	/**
	 * List 어드민 공지사항(기업)
	 */
	public function get_admin_cnotice_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $company_idx, $sop = 'OR')
	{
		$select = 'post.*';
		$join['table'] = 'member';
		$join['on'] = 'member.mem_id = post.mem_id';
		$join['type'] = 'left';
		$where = array(
			'post.post_del <>' => 2, 
            'post.brd_id' =>2, 
			'member.company_idx' => $company_idx,
		);
		$result = $this->_get_list_common($select = 'post.*', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

	/**
	 * 답변등록 시 원글 답변완료 표기
	 */
	public function update_reply_chk($post_id)
	{
		$post_id = (int) $post_id;
		if (empty($post_id) OR $post_id < 1) {
			return false;
		}
		$this->db->where($this->primary_key, $post_id);
		$data = array('post_reply_chk' => 'y');
		$this->db->update($this->_table, $data);

		return true;
	}

	/**
	 * List 페이지 커스테마이징 함수
	 */
	public function get_post_list($limit = '', $offset = '', $where = '', $category_id = '', $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'post.post_num, post.post_reply';
		}

		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('post.post_title', 'post.post_content');
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

		$this->db->select('post.*, company_info.company_name, member.mem_div, member.mem_position, member.company_idx, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point');
		$this->db->from($this->_table);
		$this->db->join('member', 'member.mem_id = post.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->join("(select post_id, pev_value from cb_post_extra_vars where pev_key = 'view_eday') as post_extra_vars", "post.post_id = post_extra_vars.post_id", 'left');

        $this->db->where($this->where);

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($category_id) {
			if (strpos($category_id, '.')) {
				$this->db->like('post_category', $category_id . '', 'after');
			} else {
				$this->db->group_start();
				$this->db->where('post_category', $category_id);
				$this->db->or_like('post_category', $category_id . '.', 'after');
				$this->db->group_end();
			}
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

		$this->db->order_by($orderby);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table);
        $this->db->join('member', 'member.mem_id = post.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->join("(select post_id, pev_value from cb_post_extra_vars where pev_key = 'view_eday') as post_extra_vars", "post.post_id = post_extra_vars.post_id", 'left');

        $this->db->where($this->where);
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($category_id) {
			if (strpos($category_id, '.')) {
				$this->db->like('post_category', $category_id . '', 'after');
			} else {
				$this->db->group_start();
				$this->db->where('post_category', $category_id);
				$this->db->or_like('post_category', $category_id . '.', 'after');
				$this->db->group_end();
			}
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
		$qry = $this->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

		return $result;
	}


	public function get_notice_list($brd_id = 0, $except_all_notice = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$brd_id = (int) $brd_id;
		if (empty($brd_id) OR $brd_id < 1) {
			return;
		}

		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('post_title', 'post_content');
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

		$this->db->select('post.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point');
		$this->db->from($this->_table);
        $this->db->join('member', 'post.mem_id = member.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->join("(select post_id, pev_value from cb_post_extra_vars where pev_key = 'view_eday') as post_extra_vars", "post.post_id = post_extra_vars.post_id", 'left');

        $this->db->where($this->where);

		if ($except_all_notice) {
			$this->db->where('brd_id', $brd_id);
			$this->db->where('post_notice', 1);
		} else {
			$this->db->where('(( brd_id = ' . $brd_id . ' AND post_notice = 1) OR post_notice = 2) ', null, false);
		}

		$this->db->where('post_del <>', 2);

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
		$this->db->order_by('post_num, post_reply');

		$qry = $this->db->get();
		$result = $qry->result_array();

		return $result;
	}


	/**
	 * List 페이지 커스테마이징 함수
	 */
	public function get_prev_next_post($post_id = 0, $post_num = 0, $type = '', $where = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$post_id = (int) $post_id;
		if (empty($post_id) OR $post_id < 1) {
			return false;
		}

		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('post_title', 'post_content');
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

		$this->db->select('post.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point');
		$this->db->from($this->_table);
        $this->db->join('member', 'post.mem_id = member.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->join("(select post_id, pev_value from cb_post_extra_vars where pev_key = 'view_eday') as post_extra_vars", "post.post_id = post_extra_vars.post_id", 'left');

        $this->db->where($this->where);
		if ($type === 'next') {
			$where['post_num >'] = $post_num;
		} else {
			$where['post_num <'] = $post_num;
		}

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
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

		$orderby = $type === 'next'
			? 'post_num, post_reply' : 'post_num desc, post_reply desc';

		$this->db->order_by($orderby);
		$this->db->limit(1);
		$qry = $this->db->get();
		$result = $qry->row_array();

		return $result;
	}


	/**
	 * List 페이지 커스테마이징 함수
	 */
	public function get_search_list($limit = '', $offset = '', $where = '', $like = '', $board_id = 0, $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'post_num, post_reply';
		}

		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('post_title', 'post_content');
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

		$this->db->select('post.*, board.brd_key, board.brd_name, board.brd_mobile_name, board.brd_order, board.brd_search,
			member.mem_id, member.mem_userid, member.mem_nickname, member.mem_icon, member.mem_photo, member.mem_point ');
		$this->db->from('post');
		$this->db->join('board', 'brd_id = board.brd_id', 'inner');
        $this->db->join('member', 'post.mem_id = member.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->join("(select post_id, pev_value from cb_post_extra_vars where pev_key = 'view_eday') as post_extra_vars", "post.post_id = post_extra_vars.post_id", 'left');

        $this->db->where(" (case when post_extra_vars.pev_value is not null then post_extra_vars.pev_value >= DATE_FORMAT(NOW(),'%m/%d/%Y') end) ");
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
		$this->db->where( array('brd_search' => 1));
		$board_id = (int) $board_id;
		if ($board_id)	{
			$this->db->where( array('b.brd_id' => $board_id));
		}

		$this->db->order_by($orderby);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();

		$this->db->select('count(*) cnt, board.brd_id');
		$this->db->from('post');
		$this->db->join('board', 'brd_id = board.brd_id', 'inner');

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
		$this->db->where( array('brd_search' => 1));
		$this->db->group_by('board.brd_id');
		$qry = $this->db->get();
		$cnt = $qry->result_array();
		$result['total_rows'] = 0;
		if ($cnt) {
			foreach ($cnt as $key => $value) {
				if (element('brd_id', $value)) {
					$result['board_rows'][$value['brd_id']] = element('cnt', $value);
				}
			}
			if ($board_id) {
				$result['total_rows'] = $result['board_rows'][$board_id];
			} else {
				$result['total_rows'] = array_sum($result['board_rows']);
			}
		}

		return $result;
	}


	public function get_rss_list($where = '', $where_in = '', $limit = '', $offset = '')
	{
		if ($where) {
			$this->db->where($where);
		}
		if ($where_in) {
			$this->db->where_in('brd_id', $where_in);
		}
		$this->db->order_by('post_num, post_reply');
		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		$qry = $this->db->get($this->_table);
		$result['list'] = $qry->result_array();
		return $result;
	}


	public function comment_updated($primary_value = '', $datetime = '')
	{
		if (empty($primary_value)) {
			return false;
		}

		$this->db->where($this->primary_key, $primary_value);
		$this->db->set('post_comment_count', 'post_comment_count+1', false);
		$this->db->set('post_comment_updated_datetime', $datetime);
		$result = $this->db->update($this->_table);

		return $result;
	}


	public function next_post_num()
	{
		$this->db->select_min('post_num');
		$result = $this->db->get($this->_table);
		$row = $result->row_array();
		$row['post_num'] = (isset($row['post_num'])) ? $row['post_num'] : 0;
		$post_num = $row['post_num'] - 1;
		return $post_num;
	}

	public function get_mem_company($post_id)
    {
        $this->db->select('company_info.company_name, member.mem_div, member.mem_position');
        $this->db->join('member', 'post.mem_id = member.mem_id', 'left');
        $this->db->join('company_info', 'company_info.company_idx = member.company_idx', 'left');
        $this->db->where($this->primary_key, $post_id);

        $result = $this->db->get($this->_table);

        return $result->row_array();
    }
}
