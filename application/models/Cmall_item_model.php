<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmall item model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Cmall_item_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cmall_item';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cit_id'; // 사용되는 테이블의 프라이머리키

	public $allow_order = array('cit_order asc', 'cit_datetime desc', 'cit_datetime asc', 'cit_hit desc', 'cit_hit asc', 'cit_review_count desc',
		'cit_review_count asc', 'cit_review_average desc', 'cit_review_average asc', 'cit_price desc', 'cit_price asc', 'cit_sell_count desc');

	function __construct()
	{
		parent::__construct();
	}

	
	public function get_latest($config)
	{
		$where['cit_status'] = 1;
		if (element('cit_type1', $config)) {
			$where['cit_type1'] = 1;
		}
		if (element('cit_type2', $config)) {
			$where['cit_type2'] = 1;
		}
		if (element('cit_type3', $config)) {
			$where['cit_type3'] = 1;
		}
		if (element('cit_type4', $config)) {
			$where['cit_type4'] = 1;
		}
		$limit = element('limit', $config) ? element('limit', $config) : 4;

		$this->db->select('cmall_item.*');
		$this->db->where($where);
		$this->db->limit($limit);
		$this->db->order_by('cit_order', 'asc');
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}


	/**
	 * List 페이지 커스테마이징 함수
	 */
	public function get_item_list($limit = '', $offset = '', $where = '', $category_id = 0, $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		
		if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'cit_order asc';
		}
		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('cit_name', 'cit_content');
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

		$this->db->select('cmall_item.*');
		$this->db->from($this->_table);

		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		$category_id = (int) $category_id;
		if ($category_id) {
			$this->db->join('cmall_category_rel', 'cmall_item.cit_id = cmall_category_rel.cit_id', 'inner');
			$this->db->where('cca_id', $category_id);
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
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($category_id) {
			$this->db->join('cmall_category_rel', 'cmall_item.cit_id = cmall_category_rel.cit_id', 'inner');
			$this->db->where('cca_id', $category_id);
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

		if(count($result['list'])>0){

			//재화가치 가져오기
			$this->load->model("Company_info_model");
			$coin_value = $this->Company_info_model->get_company_coin_value();

			foreach($result['list'] as $k => $v){

				$result['list'][$k]['fruit_cit_price'] = 0;

				if($v['cit_money_type']=='f'){
					$result['list'][$k]['fruit_cit_price'] = $v['cit_price'] / $coin_value;
					if($result['list'][$k]['fruit_cit_price'] < 0){
						$result['list'][$k]['fruit_cit_price'] = 0;
					} 
				}
				
			}
		}

		return $result;
	}


	public function update_hit($primary_value = '')
	{
		if (empty($primary_value)) {
			return false;
		}

		$this->db->where($this->primary_key, $primary_value);
		$this->db->set('cit_hit', 'cit_hit+1', false);
		$result = $this->db->update($this->_table);
		return $result;
	}

	/**
	 * overwrite
	 */
	public function delete($primary_value = '')
	{

		if ($primary_value) {
			$updatedata = array(
				'cit_del_flag' => 'y',
				'cit_del_dt' => cdate('Y-m-d H:i:s'),
			);
			$this->db->where($this->primary_key, $primary_value);
			$this->db->set($updatedata);
		}

		$result = $this->db->update($this->_table);

		return $result;
	}

	/**
	 * shop 메이에서 추천 상품 불러오기
	 * - 추천 체크 && 아이템 카테고리 = true
	 * - 삭제된게 아니면 = true
	 */
	public function get_latest_shop($config,$cconfig,$company_idx=0)
	{
		$where['cmall_item.cit_status'] = 1;
		$where['cmall_item.cit_type1'] = 1;
		$where['cmall_category_rel.cca_id'] = $config['cca_id']; //cb_cmall_category_rel.cca_id
		$where['cmall_category.cca_parent'] = 0;
		$where['cmall_item.cit_del_flag'] = 'n'; //cb_cmall_item.cit_del_flag
		
		$limit = ($config['limit'])?$config['limit']:4;
		
		$this->db->select('cmall_item.*,cmall_category.cca_id');
		$this->db->join('cmall_category_rel', 'cmall_category_rel.cit_id = cmall_item.cit_id', 'left');
		$this->db->join('cmall_category','cmall_category.cca_id = cmall_category_rel.cca_id','left');
		//자사몰 필터링은 위한 조건
		if($cconfig['custom']['category']['company'] == $config['cca_id']){
			$where['cmall_item.company_idx'] = $company_idx;
		}
		$this->db->where($where);
		$this->db->limit($limit);
		$this->db->order_by('cmall_item.cit_id', 'DESC');
		$qry = $this->db->get("cmall_item");
		$result = $qry->result_array();
		
		if(count($result)>0){

			//재화가치 가져오기
			$this->load->model("Company_info_model");
			$coin_value = $this->Company_info_model->get_company_coin_value();

			foreach($result as $k => $v){

				$result[$k]['fruit_cit_price'] = 0;

				if($v['cit_money_type']=='f'){
					$result[$k]['fruit_cit_price'] = $v['cit_price'] / $coin_value;
					if($result[$k]['fruit_cit_price'] < 0){
						$result[$k]['fruit_cit_price'] = 0;
					} 
				}
				
			}
		}

		return $result;
	}


    /**
     * 템플릿으로 생성된 상품 리스트
     */
    public function get_template_item_list($per_page="", $offset="", $where="", $orderby=""){

        if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'cit_id desc';
		}

        $this->db->select('*');
		$this->db->from($this->_table);

		if ($where) {
			$this->db->where($where);
		}
	
		$this->db->order_by($orderby);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();
		


		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table);
		if ($where) {
			$this->db->where($where);
		}
		
		$qry = $this->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

        return $result;

    }


    /**
     * 템플릿상품 노출 변경
     */
    public function change_cit_stauts($citt_id,$change_cit_status){

        if ($citt_id) {
			$updatedata = array(
				'cit_status' => $change_cit_status,
				'cit_updated_datetime' => cdate('Y-m-d H:i:s'),
			);
			$this->db->where("citt_id", $citt_id);
			$this->db->set($updatedata);
		}

		$result = $this->db->update($this->_table);

		return $result;
    }


    /**
     * 최근 cit_key 구하기 (상품페이지주소 추천하기 위해서)
     */
    public function get_lately_cit_key($cit_key){
        
        $this->db->select('cit_key');
		$this->db->from($this->_table);

        $where = array();
        $where["cit_key like "] = $cit_key."%";
        $this->db->where($where);

        $this->db->order_by("cit_key desc");

        $this->db->limit(1,0);

        $qry = $this->db->get();
        $row = $qry->row_array();
        
        return $row['cit_key'];
    }
}
