<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stat model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Stat_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'member_login_log';
	public $_table2 = 'member';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mll_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	public function get_by_time_start_end($company_idx, $orderby)
    {
        $this->db->select('SUBSTRING(mll_datetime,1,10) as mll_datetime');
        $this->db->join('member', 'member.mem_id = member_login_log.mem_id', 'left');
        $this->db->where('member.company_idx', $company_idx);
        $this->db->where('mll_success', 1);
        $this->db->order_by('mll_datetime', $orderby);
        $this->db->limit(1, 0);
        $qry = $this->db->get($this->_table);
        $result = $qry->row_array();

        return $result['mll_datetime'];
    }

    public function get_by_time_hour($start_date = '', $end_date = '', $orderby = 'asc', $company_idx)
    {
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';
        $this->db->select('date_format(mll_datetime, "%H") as mll_datetime, count(time(mll_datetime)) as mll_count');
        $this->db->join('member', 'member.mem_id = member_login_log.mem_id', 'left');
        $this->db->where('member.company_idx', $company_idx);
        $this->db->where('mll_success', 1);
        $this->db->group_by(1);
		$this->db->order_by('mll_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

        return $result;
    }

    public function get_by_time_day($start_date = '', $end_date = '', $orderby = 'asc', $company_idx)
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';
        $this->db->select('SUBSTRING(mll_datetime,1,10) as mll_datetime, count(day(mll_datetime)) as mll_count');
        $this->db->join('member', 'member.mem_id = member_login_log.mem_id', 'left');
        $this->db->where('member.company_idx', $company_idx);
        $this->db->where('mll_success', 1);
        $this->db->group_by('day(mll_datetime)');
		$this->db->order_by('mll_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}

    public function get_by_time_month($start_date = '', $end_date = '', $orderby = 'asc', $company_idx)
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';
        $this->db->select('SUBSTRING(mll_datetime,1,7) as mll_datetime, count(month(mll_datetime)) as mll_count');
        $this->db->join('member', 'member.mem_id = member_login_log.mem_id', 'left');
        $this->db->where('member.company_idx', $company_idx);
        $this->db->where('mll_success', 1);
        $this->db->group_by('month(mll_datetime)');
		$this->db->order_by('mll_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}

    public function get_by_time_year($start_date = '', $end_date = '', $orderby = 'asc', $company_idx)
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';
        $this->db->select('SUBSTRING(mll_datetime,1,4) as mll_datetime, count(year(mll_datetime)) as mll_count');
        $this->db->join('member', 'member.mem_id = member_login_log.mem_id', 'left');
        $this->db->where('member.company_idx', $company_idx);
        $this->db->where('mll_success', 1);
        $this->db->group_by('year(mll_datetime)');
		$this->db->order_by('mll_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}

    public function get_by_date($ymd, $year, $month, $day, $company_idx)
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
        $this->db->select('mll_datetime, mll_useragent');
        $this->db->join('member', 'member.mem_id = member_login_log.mem_id', 'left');
        if($ymd == 'day'){
            $this->db->where('day(mll_datetime)', $day);
            $this->db->where('month(mll_datetime)', $month);
            $this->db->where('year(mll_datetime)', $year);
        } else if($ymd == 'month'){
            $this->db->where('month(mll_datetime)', $month);
            $this->db->where('year(mll_datetime)', $year);
        } else if($ymd == 'year'){
            $this->db->where('year(mll_datetime)', $year);
        } else {
            $this->db->where('day(mll_datetime)', $day);
        }
        $this->db->where('mll_success', 1);
        $this->db->where('member.company_idx', $company_idx);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}

    public function get_by_login_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {
        $select = 'substring(mll_datetime, 1, 10) as mll_datetime';
		$join[] = array('table' => 'member', 'on' => 'member.mem_id = member_login_log.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

		return $result;
    }
}
