<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 열매 헬퍼
 */


if ( ! function_exists('fadd')) {
    /**
     * 열매추가
     * @param int $mem_id 대상회원PK
     * @param int $amount 추가열매량
     * @param string $message 메시지
     * @param int $admin_mem_id 열매주는관리자회원, system의 경우 0
     */
	function fadd($mem_id, $amount, $message, $admin_mem_id = 0){
		


        //log write

	}
}


if ( ! function_exists('famount')) {
    /**
     * 사용가능 열매 조회
     * @param int $mem_id 대상회원PK
     * @return int amount 사용가능 열매
     */
    function famount($mem_id){
        $CI =& get_instance();
		$q = "select mem_cur_fruit from cb_member where mem_id = '".$mem_id."'";
		$r = $CI->db->query($q);
		$mem = (array) $r->row();
		return $mem['mem_cur_fruit'];
    }
}



if ( ! function_exists('fhistoty')) {
    /**
     * 회원 열매 내역
     * @param int $limit
     * @param int $offset
     * @param int $where
     * @param int $orderby
     * @param int $sfield
     * @param int $skeyword
     * @return array list 내역
     */
    function fhistoty($limit, $offset, $where, $orderby, $sfield, $skeyword){

        $CI =& get_instance();

        $table = "fruit_log";

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

		$CI->db->select('fruit_log.*');
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



if ( ! function_exists('fuse')) {
    /**
     * 열매 사용/충전
     * @param int $mem_id 대상회원PK
     * @param int $amount 열매사용량
     * @param string $message 메시지
     * @param datetime $cor_datetime 결제일시
     * @param string $type 타입 : order, member 등
     * @param int $related_id 관련 인덱스 : 주문 PK 등
     * @param string $action 액션 설명
     */
    function fuse($mem_id, $amount, $message, $cor_datetime, $type, $related_id, $action){
        $CI =& get_instance();

		//현재 열매
		$q = "select 
					mem_cur_fruit
				from
					cb_member 
				where
					mem_id = '".$mem_id."'
		";
		$r = $CI->db->query($q);
		$mem = (array) $r->row();
		$mem_cur_fruit = $mem['mem_cur_fruit'];
        
        //로그 기록
		$q = "insert into 
                    cb_fruit_log 
                set
                    log_memNo = '".$mem_id."',
                    log_txt = '".$message."',
                    log_regDt = '".$cor_datetime."',
                    fru_fruit = '".$amount."',
                    fur_type = '".$type."',
                    fru_related_id = '".$related_id."',
                    fru_action = '".$action."',
					fru_now_fruit = '".($mem_cur_fruit + ($amount))."'
                ";
        $CI->db->query($q);

        //사용 가능한 열매 차감
        $q = "update 
                    cb_member
                set
                    mem_cur_fruit = mem_cur_fruit + (".$amount.")
                where
                    mem_id = '".$mem_id."'
            ";
        
        $CI->db->query($q);
    }
}


if ( ! function_exists('fdeposit')) {
    /**
     * 열매 전환가치를 적용하여 사용시킬 예치금 산출
     * @param Array $items 주문상품들
     * @param int $company_idx 주문하는 회원의 소속 기업PK
     * @return int 차감할 예치금
     */
    function fdeposit($items, $company_idx){
        // 자사몰 상품일때는 열매만 소모되고 기업 예치금은 그대로
        // 팀메타 아이템(열매) + 자사몰 상품(열매) 경우 있을 수 있음
        $use_deposit = 0;
        $use_items = array(); //계산 대상 아이템
        $cconfig['custom'] = config_item('custom');
        //$cconfig['custom']['category']['company']
        
        foreach($items as $k => $v){
            
            // 1. 열매 결제가 아닌게 들어왔는지 체크
            if($v['cit_money_type'] == 'c'){
                alert(cmsg('3100'));
                exit;
            }

            if($v['company_idx'] != $company_idx || $v['cca_id'] != $cconfig['custom']['category']['company']){
                $use_items[] = $v;
            }

        }

        if(count($use_items) > 0){
            
            foreach($use_items as $k => $v){
                $use_deposit += $v['cct_count'] * $v['cit_price'];
            }

        }

        return $use_deposit;
    }
}