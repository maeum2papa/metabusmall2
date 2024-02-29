<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmall helper
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */


/**
 * 게시물 열람 페이지 주소를 return 합니다
 */
if ( ! function_exists('cmall_item_url')) {
	function cmall_item_url($url = '')
	{
		$url = trim($url, '/');
		$itemurl = site_url(config_item('uri_segment_cmall_item') . '/' . $url);
		return $itemurl;
	}
}

/**
 * 임시 저장된 주문 데이터를 serialize인지 base64_encode 인지 체크하여 배열로 리턴합니다.
 */
if ( ! function_exists('cmall_tmp_replace_data')) {
	function cmall_tmp_replace_data($data)
	{
		$result = is_serialized($data) ? unserialize($data) : unserialize(base64_decode($data));
		return $result;
	}
}

//주문데이터 가져오기
if ( ! function_exists('get_cmall_order_data')) {
	function get_cmall_order_data($order_no, $is_cache=true)
	{
		static $cache = array();

		if( $is_cache && isset($cache[$order_no]) ){
			return $cache[$order_no];
		}

		$CI = & get_instance();

		$CI->load->model('Cmall_order_model');

		$where = array(
			'cor_id' => $order_no
		);
		$cache[$order_no] = $order = $CI->Cmall_order_model->get_one('', '', $where);

		return $order;
	}
}

if ( ! function_exists('get_cmall_key_localize')) {
	function get_cmall_key_localize(){

		$keys = array(
			'order'		=> '주문확인',	//주문
			'deposit'	=> '입금', //입금
			'cancel'	=> '주문취소', //취소
			'end'	=> '발송완료', //취소
			'ready'	=> '발송대기', 
		);

		return $keys;

	}
}

if ( ! function_exists('cmall_print_stype_names')) {
	function cmall_print_stype_names($key, $print=false){
		$key = strtolower($key);
		$tmps = get_cmall_key_localize();

		if( $print ){	//출력한다면
			if( array_key_exists($key, $tmps) ){
				echo $tmps[$key];
			} else {
				echo $key;
			}
		} else {
			if( array_key_exists($key, $tmps) ){
				return $tmps[$key];
			} else {
				return $key;
			}
		}
	}
}

if ( ! function_exists('cmall_get_stype_names')) {
	function cmall_get_stype_names($str, $index=null, $array_return=false){
		$tmps = get_cmall_key_localize();

		$key = array_search($str, $tmps);

		if ( $key !== false ){
			return $key;
		}

		return $str;
	}
}

if ( ! function_exists('check_datetime') ){
	// 일자 시간을 검사한다.
	function check_datetime($datetime)
	{
		if ($datetime == "0000-00-00 00:00:00")
			return true;

		$year		= substr($datetime, 0, 4);
		$month		= substr($datetime, 5, 2);
		$day		= substr($datetime, 8, 2);
		$hour		= substr($datetime, 11, 2);
		$minute		= substr($datetime, 14, 2);
		$second		= substr($datetime, 17, 2);

		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

		$tmp_datetime = date("Y-m-d H:i:s", $timestamp);
		if ($datetime == $tmp_datetime)
			return true;
		else
			return false;
	}
}

if ( ! function_exists('get_cmall_order_amounts')) {

	function get_cmall_order_amounts($order_no){

		$CI = & get_instance();

		$od = get_cmall_order_data( $order_no );

		if( ! element('cor_id', $od) ){
			return false;
		}

		$info = array();

		// 주문금액정보

		$CI->load->model(array('Cmall_order_model', 'Cmall_item_model', 'Cmall_order_detail_model'));

		$orderdetail = $CI->Cmall_order_detail_model->get_by_item(element('cor_id', $od));

		$od_cancel_price = 0;
		$od_total_price = 0;
		$od_cash_price = 0;

		if ($orderdetail) {
			foreach ($orderdetail as $okey => $oval) {

				$orderdetail[$okey]['item'] = $item
							= $CI->Cmall_item_model->get_one(element('cit_id', $oval));

				$orderdetail[$okey]['itemdetail'] = $itemdetail
							= $CI->Cmall_order_detail_model->get_detail_by_item(element('cor_id', $od), element('cit_id', $oval));

				$orderdetail[$okey]['item']['possible_download'] = 1;

				if (element('cod_download_days', element(0, $itemdetail))) {
					$endtimestamp = strtotime(element('cor_approve_datetime', $val))
						+ 86400 * element('cod_download_days', element(0, $itemdetail));
					$orderdetail[$okey]['item']['download_end_date'] = $enddate = cdate('Y-m-d', $endtimestamp);

					$orderdetail[$okey]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
				}

				foreach( $itemdetail as $detail ){

					$cod_status = element('cod_status', $detail);

					if( in_array( $cod_status, array('cancel') ) ){	//주문취소
						$od_cancel_price += ((int) element('cit_price', $item) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
					} else if ( $cod_status === 'deposit' ) {
						$od_cash_price += ((int) element('cit_price', $item) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
					}

					$od_total_price += ((int) element('cit_price', $item) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
				}

			}	//end foreach
		}	//end if $orderdetail

		$info['od_total_price']	= $od_total_price;	//총 요청 금액
		$info['od_cash_price']	= $od_cash_price;	//입금된 금액
		$info['od_cancel_price']	= $od_cancel_price;	//취소된 금액

		return $info;

	}	//end function

}

if ( ! function_exists('exists_inicis_cmall_order')) {

	function exists_inicis_cmall_order($order_no, $pp=array(), $od_time=''){

		$CI = & get_instance();

		$CI->session->set_userdata('unique_id', '');
		$CI->session->set_userdata('order_cct_id', '');

		$CI->load->model('Payment_inicis_log_model');
		$CI->Payment_inicis_log_model->delete($oid);		//임시 저장 삭제

		redirect('cmall/orderresult/' . $order_no);

	}

}

// 상품의 최상위 카테고리 cca_id 구하기 ( 아이테몰 / 공통몰 / 자사몰 )
if ( ! function_exists('cmall_item_parent_category')) {
	/**
	 * @param int $cit_id 상품PK
	 * @return int 상품의 최상위 카테고리PK
	 */
	function cmall_item_parent_category($cit_id){

		$CI =& get_instance();
		$q = "select 
					cb_cmall_category.cca_id 
				from 
					cb_cmall_category_rel left join cb_cmall_category on cb_cmall_category_rel.cca_id = cb_cmall_category.cca_id
				where 
					cb_cmall_category_rel.cit_id = '".$cit_id."' 
					AND 
					cb_cmall_category.cca_parent = 0
					";
		$r = $CI->db->query($q);
		$result = (array) $r->row();
		
		return $result['cca_id'];
	}

}

// 상품의 최상위 카테고리명 구하기 ( 아이테몰 / 공통몰 / 자사몰 )
if ( ! function_exists('cmall_item_parent_category_name')) {
	/**
	 * @param int $cit_id 상품PK
	 * @return int 상품의 최상위 카테고리PK
	 */
	function cmall_item_parent_category_name($cit_id){

		$CI =& get_instance();
		$q = "select 
					cb_cmall_category.cca_value 
				from 
					cb_cmall_category_rel left join cb_cmall_category on cb_cmall_category_rel.cca_id = cb_cmall_category.cca_id
				where 
					cb_cmall_category_rel.cit_id = '".$cit_id."' 
					AND 
					cb_cmall_category.cca_parent = 0
					";
		$r = $CI->db->query($q);
		$result = (array) $r->row();
		
		return $result['cca_value'];
	}

}

//회원이 소속된 기업 PK
if ( ! function_exists('camll_company_idx')) {
	function camll_company_idx($mem_id){
		$CI =& get_instance();
		$q = "select 
					mem_id
				from 
					cb_member
				where
					company_idx = (select company_idx from cb_member where mem_id = '".$mem_id."') 
					and 
					mem_level = 100
		";
		$r = $CI->db->query($q);
		$company_admin = (array) $r->row();

		return $company_admin['mem_id'];
	}
}

//예치금 추가/차감 기록
if ( ! function_exists('company_depoist_use')) {
	/**
     * 예치금 사용
     * @param int $mem_id 대상회원PK
     * @param int $amount 예치금사용량
     * @param string $message 메시지
     * @param datetime $cor_datetime 결제일시
     * @param string $type 타입 : order, member 등
     * @param int $related_id 관련 인덱스 : 주문 PK 등
     * @param string $action 액션 설명
     */
	function company_depoist_use($mem_id, $amount, $message, $cor_datetime, $type, $related_id, $action){
		$CI =& get_instance();

		//company_idx 찾기
		$q = "select company_idx from cb_member where mem_id='".$mem_id."'";
		$r = $CI->db->query($q);
		$member = (array) $r->row();

		$company_idx = $member['company_idx'];

		//현재 예치금
		$q = "select company_deposit from cb_company_info where company_idx='".$company_idx."'";
		$r = $CI->db->query($q);
		$company = (array) $r->row();
		$company_deposit = $company['company_deposit'];


		//cb_company_deposit에 기록
		$q = "insert into 
					cb_company_deposit 
                set
					company_idx = '".$company_idx."',
					mem_id = '".$mem_id."',
                    ccd_content = '".$message."',
                    ccd_datetime = '".$cor_datetime."',
                    ccd_deposit = '".$amount."',
                    ccd_type = '".$type."',
                    ccd_related_id = '".$related_id."',
                    ccd_action = '".$action."',
					ccd_now_deposit = '".($company_deposit + ($amount))."'
                ";
        $CI->db->query($q);
		
		//cb_company_info.company_deposit 업데이트
		$q = "update cb_company_info set company_deposit = company_deposit + (".$amount.") where company_idx='".$company_idx."'";
		$CI->db->query($q);

	}
}


//회원이 소속된 기업의 예치금 가져오기
if ( ! function_exists('camll_company_deposit')) {
	/**
	 * @param int $company_idx 기업PK
	 * @return int 기업의 최고회원의 예치금 합
	 */
	function camll_company_deposit($company_idx){
		$CI =& get_instance();
		$q = "select 
					company_deposit
				from 
					cb_company_info
				where
					company_idx = '".$company_idx."'
		";
		$r = $CI->db->query($q);
		$company = (array) $r->row();
		
		return $company['company_deposit'];
	}
}


//상품 재고 수정 (차감/증감)
if ( ! function_exists('cmall_item_stock_change')) {
	function cmall_item_stock_change($cit_id,$cct_count){

		$CI =& get_instance();
		$q = "select cit_stock_type, cit_stock_cnt from cb_cmall_item where cit_id='".$cit_id."'";
		$r = $CI->db->query($q);
		$item = (array) $r->row();

		if($item['cit_stock_type']=='s'){

			$cit_stock_cnt = $item['cit_stock_cnt'] + ($cct_count);

			$q = "update cb_cmall_item set cit_stock_cnt = ".$cit_stock_cnt." where cit_id='".$cit_id."'";
			$CI->db->query($q);

		}

	}
}


//한번만 구매한 상품을 주문 했는지 확인
if ( ! function_exists('cmall_item_one_sale_order')) {
	/**
	 * @param int $mem_id 회원PK
	 * @param int $cit_id 상품PK
	 * @return boolean (true = 구매한적 있음)
	 */
	function cmall_item_one_sale_order($mem_id,$cit_id){

		$result = false;
		
		$CI =& get_instance();

		$CI->load->model(array("Cmall_item_model","Cmall_order_detail_model"));
		$item = $CI->Cmall_item_model->get_one($cit_id);

		if($item['cit_one_sale']=='y'){
			$data = $CI->Cmall_order_detail_model->get_detail_by_item2($mem_id,$cit_id);
			if(count($data) > 0){
				$result = true;
			}
		}
		
		return $result;
	}
}


/**
 * 상품과 연동된 아이템 카테고리들 구하기
 */
if ( ! function_exists('cmall_item_asset_category_link')) {
	function cmall_item_asset_category_link($cit_item_arr){

		$result = array();

		$CI =& get_instance();

		$CI->load->model(array("Asset_item_model","Asset_category_model"));

		foreach($cit_item_arr as $k => $v){
			$row = $CI->Asset_item_model->get_one($v);
			$row = $CI->Asset_category_model->get_one($row['cate_sno']);

			$result[$v] = $row;
		}

		return $result;
		
	}
}