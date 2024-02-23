<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmallorder class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>컨텐츠몰관리>주문내역 controller 입니다.
 */
class Cmallorder extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cmall/cmallorder';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Cmall_order', 'Cmall_item', 'Cmall_order_detail');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Cmall_order_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'cmall');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'cmalllib'));
	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cmall_cmallorder_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'cor_id',
				'label' => '구매아이디',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'mem_id',
				'label' => '회원아이디',
				'rules' => 'trim|required|numeric|is_natural',
			),
			array(
				'field' => 'cit_id',
				'label' => '상품아이디',
				'rules' => 'trim|required|numeric|is_natural',
			),
			array(
				'field' => 'cod_download_days',
				'label' => '다운로드기간',
				'rules' => 'trim|numeric|is_natural',
			),
		);
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$cod_download_days = $this->input->post('cod_download_days') ? $this->input->post('cod_download_days') : 0;
			$updatedata = array(
				'cod_download_days' => $cod_download_days,
			);
			$where = array(
				'cor_id' => $this->input->post('cor_id'),
				'mem_id' => $this->input->post('mem_id'),
				'cit_id' => $this->input->post('cit_id'),
			);
			$this->Cmall_order_detail_model->update('', $updatedata, $where);

			redirect(current_full_url(), 'refresh');
		}

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

		$findex = $this->input->get('findex') ? $this->input->get('findex') : 'cor_datetime';
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('cor_id', 'member.mem_nickname', 'cmall_order.mem_realname', 'member.mem_userid', 'cor_content', 'cor_total_money', 'cor_cash', 'cor_memo', 'cor_admin_memo', 'cor_ip', 'member.mem_id'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('member.mem_id', 'cor_total_money', 'cor_cash'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('cor_id', 'cor_approve_datetime'); // 정렬이 가능한 필드

		$where = array();

		/** 상세 검색 start */

		if(!$this->input->get('search_datetime_type')){
			$search_datetime_type = 'cor_datetime';
		}else{
			$search_datetime_type = $this->input->get('search_datetime_type');
		}

		if(!$this->input->get('search_datetime_start')){
			$start_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00")." -7day"));
		}else{
			$start_date = $this->input->get('search_datetime_start').' 00:00:00';
		}

		if(!$this->input->get('search_datetime_end')){
			$end_date = date("Y-m-d 23:59:59");
		}else{
			$end_date = $this->input->get('search_datetime_end').' 23:59:59';
		}	

		$view['view']['search']['search_datetime_type'] = $search_datetime_type;
		$where["cb_cmall_order.".$search_datetime_type.' >='] = $view['view']['search']['search_datetime_start'] = $start_date;
		$where["cb_cmall_order.".$search_datetime_type.' <='] = $view['view']['search']['search_datetime_end'] = $end_date;
		// SQL : cor_datetime = <= '2023-12-19'

		
		if ($this->input->get('cor_pay_type')) {
			$where['cb_cmall_order.cor_pay_type'] = $this->input->get('cor_pay_type');
		}

		//기업관리자에게 데이터 제한
		if($this->session->userdata['mem_admin_flag']!=0){
			$where['cb_cmall_order.company_idx'] = $this->session->userdata['company_idx'];
		}

		
		if($this->input->get("status")){
			$statuss = array();
			foreach($this->input->get("status") as $k=>$v){
				$statuss[] = $v;
			}			

			$where["cb_cmall_order.status in('".implode("','",$statuss)."')"] = null;
			// SQL : status in('order')
		}

		if($this->input->get("search_order_value")!=""){
			$search_order_value = $this->input->get("search_order_value");
			if($this->input->get("search_order_key")=="mem_phone"){
				$search_order_value = str_replace("-","",$this->input->get("search_order_value"));
			}
			$like["cb_cmall_order.".$this->input->get("search_order_key")] = $search_order_value;
		}

		if($this->input->get("cor_id")!=""){
			$where["cb_cmall_order.cor_id"] = $this->input->get("cor_id");
		}

		if($this->input->get("company_idx")){
			$company_idxs = array();
			foreach($this->input->get("company_idx") as $k=>$v){
				$company_idxs[] = $v;
			}
			$where["cb_cmall_order.company_idx in('".implode("','",$company_idxs)."')"] = null;
		}

		if($this->input->get("cmall_category")){
			$cmall_categorys = array();
			foreach($this->input->get("cmall_category") as $k=>$v){
				$cmall_categorys[] = $v;
				$or_where[] = "(FIND_IN_SET(".$v.", tmp_cb_cmall_order_detail.cca_id) > 0)";
			}

			$or = "(".implode(" OR ",$or_where).")";
			
			$where[$or] = null;
		}
		
		/** 상세 검색 end */
		// $result = $this->{$this->modelname}
		// 	->get_admin_list($per_page, $offset, $where, $like, $findex, $forder, $sfield, $skeyword);
		$join  = array(
			"table" => "
			(
				SELECT cb_cmall_order_detail.cor_id, tmp_cb_cmall_category_rel.cit_id, CONCAT(GROUP_CONCAT(tmp_cb_cmall_category_rel.cca_id SEPARATOR ', ')) AS cca_id
				FROM cb_cmall_order_detail
				INNER JOIN
					(
						SELECT DISTINCT tmp_cb_cmall_category_rel.*
						FROM cb_cmall_category_rel 
						INNER JOIN 
							(
								SELECT cb_cmall_category_rel.cit_id, cb_cmall_category.cca_id, cb_cmall_category.cca_parent
								FROM cb_cmall_category 
								INNER JOIN cb_cmall_category_rel 
								ON cb_cmall_category_rel.cca_id = cb_cmall_category.cca_id
								WHERE cb_cmall_category.cca_parent = 0
							) AS tmp_cb_cmall_category_rel
						ON cb_cmall_category_rel.cit_id = tmp_cb_cmall_category_rel.cit_id
					) AS tmp_cb_cmall_category_rel
				ON cb_cmall_order_detail.cit_id = tmp_cb_cmall_category_rel.cit_id
				GROUP BY cb_cmall_order_detail.cor_id
			) AS tmp_cb_cmall_order_detail
			",
			"on"=>"ON cb_cmall_order.cor_id = tmp_cb_cmall_order_detail.cor_id"
		);
		$result = $this->{$this->modelname}
			->_get_list_common("cb_cmall_order.*",$join,$per_page, $offset, $where, $like, $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		// debug($result);
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				if($val['company_idx']) $result['list'][$key]['company_name'] = busiNm($val['company_idx']);
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
				$result['list'][$key]['pay_method'] = $this->cmalllib->get_paymethodtype(element('cor_pay_type', $val));
				$result['list'][$key]['order_status'] = cmall_print_stype_names(element('status', $val));

				$orderdetail = $this->Cmall_order_detail_model->get_by_item(element('cor_id', $val));

				if ($orderdetail) {
					foreach ($orderdetail as $okey => $oval) {
						$orderdetail[$okey]['item'] = $item
							= $this->Cmall_item_model->get_one(element('cit_id', $oval));
						$orderdetail[$okey]['itemdetail'] = $itemdetail
							= $this->Cmall_order_detail_model->get_detail_by_item(element('cor_id', $val), element('cit_id', $oval));

						$orderdetail[$okey]['item']['possible_download'] = 1;

						if (element('cod_download_days', element(0, $itemdetail))) {
							$endtimestamp = strtotime(element('cor_approve_datetime', $val))
								+ 86400 * element('cod_download_days', element(0, $itemdetail));
							$orderdetail[$okey]['item']['download_end_date'] = $enddate = cdate('Y-m-d', $endtimestamp);

							$orderdetail[$okey]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
						}
					}
				}
				$result['list'][$key]['orderdetail'] = $orderdetail;
			}
		}
		$view['view']['data'] = $result;

		if($this->session->userdata['mem_admin_flag']==0){
			$this->load->model("Company_info_model");
			$forder = "company_name asc";
			$where = array();
			$companys =$this->Company_info_model->get_admin_list(0, 9999999999999, $where, '', null, $forder, null, null);
			$view['view']['data']['companys'] = $companys['list'];
		}

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('member.mem_nickname' => '회원명', 'cmall_order.mem_realname' => '회원실명', 'member.mem_userid' => '회원아이디', 'cor_content' => '내용', 'cor_total_money' => '결제금액');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['form_url'] = admin_url($this->pagedir . '/form');

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function form($cor_id){
		
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cmall_cmallorder_form';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'cor_id',
				'label' => '구매아이디',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'mem_id',
				'label' => '회원아이디',
				'rules' => 'trim|required|numeric|is_natural',
			),
			array(
				'field' => 'pcase',
				'label' => '액션',
				'rules' => 'trim|required',
			),
		);
		$this->form_validation->set_rules($config);
		
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$cor_id = $this->input->post('cor_id');
			$mem_id = $this->input->post('mem_id');
			$pcase = $this->input->post('pcase');

			if( $pcase === 'product' ){
				debug($this->input->post());
				$ori_ct_status = $this->input->post('ct_status');
				$ct_status = $this->input->post('ct_status') ? cmall_get_stype_names($ori_ct_status) : '';
				$pg_cancel = $this->input->post('pg_cancel');
				$cnt = $this->input->post('cit_id') ? count($this->input->post('cit_id')) : '';
				$cit_ids = $this->input->post('cit_id') ? $this->input->post('cit_id') : array();
				$chk = $this->input->post('chk') ? $this->input->post('chk') : array();
				$cod_download_days = $this->input->post('cod_download_days') ? $this->input->post('cod_download_days') : array();
				$ct_qtys = $this->input->post('ct_qty') ? $this->input->post('ct_qty') : array();

				$now = date('Y-m-d H:i:s');

				$order = get_cmall_order_data($cor_id);
				$status_normal = array('order', 'deposit');
				$order_detail_filter = [];
				
				//주문상품
				if ($order) {
					$order_detail = $this->Cmall_order_detail_model->get_by_item($cor_id);
					
					if ($order_detail) {
						foreach ($order_detail as $okey => $oval) {
							$order_detail[$okey]['item'] = $item
								= $this->Cmall_item_model->get_one(element('cit_id', $oval));
							$order_detail[$okey]['itemdetail'] = $itemdetail
								= $this->Cmall_order_detail_model->get_detail_by_item($cor_id, element('cit_id', $oval));
						}
					}

					foreach($chk as $k=>$v){
						$cit_id = $cit_ids[$v];
						foreach($order_detail as $k2=>$v2){
							if($cit_id == $v2['cit_id']){
								$order_detail_filter[] = $v2;
							}
						}
					}
				}

				if($order['cor_pay_type']=='f'){

					$now = date('Y-m-d H:i:s');

					if ( ! function_exists('fuse')) {
						$this->load->helper('fruit');
					}

					foreach ($order_detail_filter as $okey => $oval) {

						//아이템 상품은 상태 변경 패스
						if($oval["item"]["cit_item_type"] == 'i'){
							continue;
						}

						//변경하고자 하는 주문상품 상태과 현 주문상품 상태가 같으면 패스
						foreach($oval['itemdetail'] as $k2=>$v2){
							if($ct_status == $v2['cod_status']){
								continue;
							}

							/**
							 * 주문확인 -> 취소
							 */
							if($v2['cod_status'] == 'order' && $ct_status == 'cancel'){

								//주문의 열매 환원
								$order['cor_cash'] -= ($v2['cod_fruit']);
								$order['cor_refund_price'] += $v2['cod_fruit'];
								fuse($order['mem_id'], $v2['cod_fruit'], "주문상품취소 (주문번호 : ".$cor_id.", 상품 : ".$oval['item']['cit_name']."[".$v2['cde_title']."])", $now, "order", $v2['cod_id'], "관리자가 주문상품취소");
								
								//기업 예치금 환원
								if($v2['cod_company_deposit']>0){
									$order['cor_company_deposit'] -= $v2['cod_company_deposit'];
								 	company_depoist_use($order['mem_id'], $v2['cod_company_deposit'], "주문상품취소 (주문번호 : ".$cor_id.", 상품 : ".$oval['item']['cit_name']."[".$v2['cde_title']."])", $now, "order", $v2['cod_id'], "관리자가 주문상품취소");
								}

								//재고 복구
								cmall_item_stock_change($v2['cit_id'],$v2['cod_count']); //함수 내부에서 재고 타입 검증
								
								//주문 상품 사용한 열매, 예치금, 코인(포인트) 초기화
								$this->Cmall_order_detail_model->pay_init($v2['cod_id']);

								//주문 상품 상태 변경
								$this->Cmall_order_detail_model->set_status_cancel($v2['cod_id'],$now);
								

								$updatedata = array(
									"cor_cash"=>$order['cor_cash'],
									"cor_refund_price"=>$order['cor_refund_price'],
									"cor_company_deposit"=>$order['cor_company_deposit']
								);
								
								$where = array(
									'cor_id' => $cor_id
								);

								$this->Cmall_order_model->update('', $updatedata, $where);
							}

							 /**
							 * 주문확인 -> 발송완료
							 */
							if($v2['cod_status'] == 'order' && $ct_status == 'end'){
								//cb_cmall_order_detail.cod_status = end;
								$this->Cmall_order_detail_model->set_status_change($v2['cod_id'],'end',$now);
							}

							 /**
							 * 발송완료 -> 주문확인
							 */
							if($v2['cod_status'] == 'end' && $ct_status == 'order'){
								//cb_cmall_order_detail.cod_status = end;
								$this->Cmall_order_detail_model->set_status_change($v2['cod_id'],'order',$now);
							}
						}
						
					}
				
				}elseif($order['cor_pay_type']=='c'){

					foreach ($order_detail_filter as $okey => $oval) {

						//아이템 상품은 상태 변경 패스
						if($oval["item"]["cit_item_type"] == 'i'){
							continue;
						}

						foreach($oval['itemdetail'] as $k2=>$v2){

							/**
							 * 주문확인 -> 발송완료
							 */
							if($v2['cod_status'] == 'order' && $ct_status == 'end'){
								//cb_cmall_order_detail.cod_status = end;
								$this->Cmall_order_detail_model->set_status_change($v2['cod_id'],'end',$now);
							}

							/**
							 * 발송완료 -> 주문확인
							 */
							if($v2['cod_status'] == 'end' && $ct_status == 'order'){
								//cb_cmall_order_detail.cod_status = end;
								$this->Cmall_order_detail_model->set_status_change($v2['cod_id'],'order',$now);
							}
						}
					}

				}

				//주문 상태 업데이트
				$order_detail_confirm = $this->Cmall_order_detail_model->get_by_item($cor_id);
				if ($order_detail_confirm) {
					
					$tmp_order_new_status = array(
						'order'=>0,
						'end'=>0,
						'cancel'=>0
					);

					foreach ($order_detail_confirm as $okey => $oval) {
						$tmp_itemdetail = $this->Cmall_order_detail_model->get_detail_by_item($cor_id, element('cit_id', $oval));
						foreach($tmp_itemdetail as $k2=>$v2){
							$tmp_order_new_status[$v2['cod_status']] += 1;
						}
					}

					foreach($tmp_order_new_status as $k=>$v){
						if($v > 0){
							
							$updatedata = array(
								"status"=>$k
							);

							if($k=='cancel'){
								$updatedata['cor_status'] = 0;
							}
							
							$where = array(
								'cor_id' => $cor_id
							);

							$this->Cmall_order_model->update('', $updatedata, $where);

							break;
						}
					}

				}


				// for ($i=0; $i<$cnt; $i++)
				// {
				// 	$k = element($i, $chk);
				// 	$cit_id = element($k, $cit_ids);

				// 	if(!$cit_id)
				// 		continue;

				// 	/*
				// 	$item_detail = $this->Cmall_order_detail_model->get_detail_by_item($cor_id, $cit_id);

				// 	if( ! element('cit_id', $item_detail) ){
				// 		continue;
				// 	}
				// 	*/

				// 	$updatedata = array(		//주문상태 수정
				// 				'cod_status' => $ct_status,
				// 			);

				// 	if( element($k, $cod_download_days) !== null ){		//다운로드기간 수정

				// 		$updatedata['cod_download_days'] = (int) element($k, $cod_download_days);

				// 	}

				// 	$where = array(
				// 		'cor_id' => $cor_id,
				// 		'mem_id' => $mem_id,
				// 		'cit_id' => $cit_id,
				// 	);

				// 	$this->Cmall_order_detail_model->update('', $updatedata, $where);
				// }

				// $cancel_change = false;
				// $pg_cancel_log = '';
				// $mod_history = '';

				// if( $ct_status == 'cancel'){

				// 	if( $pg_cancel ){

				// 		$select = "count(*) as od_count1, SUM(IF(cod_status = 'cancel', 1, 0)) as od_count2";
				// 		$where = array(
				// 			'cor_id' => $cor_id,
				// 			'mem_id' => $mem_id,
				// 			);

				// 		$row = $this->Cmall_order_detail_model->get_one('', $select, $where);
						
				// 		// PG 신용카드 결제 취소일 때
				// 		if($row['od_count1'] === $row['od_count2']) {
				// 			$cancel_change = true;

				// 			$pg_res_cd = '';
				// 			$pg_res_msg = '';
				// 			$pg_cancel_log = '';

				// 			$order = get_cmall_order_data($cor_id);

				// 			$this->load->library('paymentlib');

				// 			$pg_res_cd = '';

				// 			$result = array(
				// 				'req_tx' => 'pay',
				// 				'res_cd' => '0000',
				// 				'tno' => element('cor_tno', $order),
				// 				'cust_ip' => $this->input->ip_address(),
				// 				'refund_msg' => iconv('utf-8', 'euc-kr', '쇼핑몰 운영자 승인 취소'),
				// 				);

				// 			if( element('cor_tno', $order) && in_array( element('cor_pay_type', $order), array('card', 'easy') ) ){
				// 				switch ( element('cor_pg', $order) ){

				// 					case 'lg' :

				// 						$pg_res_cd = $this->paymentlib->xpay_admin_cancel($result, true);

				// 						break;
				// 					case 'kcp' :

				// 						$pg_res_cd = $this->paymentlib->kcp_pp_ax_hub_cancel($result, true);

				// 						break;
				// 					case 'inicis' :

				// 						$pg_res_cd = $this->paymentlib->inipay_admin_cancel($result, true);

				// 						break;

				// 				}

				// 				// PG 취소요청 성공했으면
				// 				if($pg_res_cd === 'success') {
				// 					$pg_cancel_log = ' PG 신용카드 승인취소 처리';

				// 					$updatedata = array(
				// 						'cor_refund_price' => element('cor_cash', $order),
				// 					);
				// 					$where = array(
				// 						'cor_id' => $cor_id,
				// 						'mem_id' => $mem_id,
				// 					);
				// 					$this->Cmall_order_model->update('', $updatedata, $where);

				// 				}
				// 			}
				// 		}

				// 	} //enf if $pg_cancel

				// 	// 관리자 주문취소 로그
				// 	$mod_history .= date('Y-m-d H:i:s', time()).' '.$mem_id.' 주문'.$ori_ct_status.' 처리'.$pg_cancel_log."\n";

				// }

				// // 미수금 등의 정보
				// $info = get_cmall_order_amounts($cor_id);

				// $updatedata = array(
				// 	'cor_refund_price' => $info['od_cancel_price'],
				// 	'cor_cash' => $info['od_cash_price'],
				// );

				// if($mod_history){

				// 	$mod_history = $order['cor_order_history'].$mod_history;

				// 	$updatedata['cor_order_history'] = $mod_history;
				// }

				// if( $cancel_change ){

				// 	$updatedata['status'] = $ct_status;
				// 	$updatedata['cor_status'] = 0;

				// } else {

				// 	if (in_array($ct_status, $status_normal)) { // 정상인 주문상태만 기록
				// 		$updatedata['status'] = $ct_status;
				// 	}

				// 	if ( $ct_status === 'deposit' ){		//입금이면
				// 		$updatedata['cor_status'] = 1;
				// 	} else { //주문 또는 취소 인 경우

				// 		$select = "count(*) as od_count1, SUM(IF(cod_status = 'order', 1, 0)) as od_count2, SUM(IF(cod_status = 'cancel', 1, 0)) as od_count3";
				// 		$where = array(
				// 			'cor_id' => $cor_id,
				// 			'mem_id' => $mem_id,
				// 			);

				// 		$row = $this->Cmall_order_detail_model->get_one('', $select, $where);

				// 		if( ($row['od_count1'] === $row['od_count2']) || ($row['od_count1'] === $row['od_count3']) ) {
				// 			$updatedata['cor_status'] = 0;
				// 			$updatedata['status'] = $ct_status;
				// 		}

				// 	}

				// }

				// $where = array(
				// 	'cor_id' => $this->input->post('cor_id'),
				// 	'mem_id' => $this->input->post('mem_id'),
				// );

				// $this->Cmall_order_model->update('', $updatedata, $where);

			} else if( $pcase === 'info' ){
				
				//$cor_cash = (int) $this->input->post('cor_cash');
				//$cor_approve_datetime = $this->input->post('cor_approve_datetime');
				//$cor_deposit = (int) $this->input->post('cor_deposit');
				//$cor_refund_price = (int) $this->input->post('cor_refund_price');
				$cor_admin_memo = $this->input->post('cor_admin_memo');
				//$cor_bank_info = $this->input->post('cor_bank_info');

				if($cor_approve_datetime){
					if (check_datetime( $cor_approve_datetime ) == false){
						alert('결제일시 오류입니다.');
					}
				}

				// 주문정보
				$info = get_cmall_order_data($cor_id, false);

				if(!$info)
					alert('주문자료가 존재하지 않습니다.');

				// 결제정보 반영
				$updatedata = array(
					//'cor_cash' => $cor_cash,
					//'cor_approve_datetime' => $cor_approve_datetime,
					//'cor_deposit' => $cor_deposit,
					//'cor_refund_price' => $cor_refund_price,
					'cor_admin_memo' => $cor_admin_memo,
					//'cor_bank_info' => $cor_bank_info,
					);
				
				if($this->input->post('cor_ship_zipcode')!=''){
					$updatedata['cor_ship_zipcode'] = $this->input->post('cor_ship_zipcode');
				}
				
				if($this->input->post('cor_ship_address')!=''){
					$updatedata['cor_ship_address'] = $this->input->post('cor_ship_address');
				}

				if($this->input->post('cor_ship_address_detail')!=''){
					$updatedata['cor_ship_address_detail'] = $this->input->post('cor_ship_address_detail');
				}

				//미수금 금액을 구함
				// $notyet = abs(element('cor_cash_request', $info)) - abs($cor_cash);
				// $cart_status = false;

				// if( 'order' == element('status', $info) && $notyet == 0 ){ // 주문 상태이면
				// 	$updatedata['status'] = 'deposit';	 //입금 상태로 변경
				// 	$updatedata['cor_status'] = 1;
				// 	$cart_status = true;
				// }

				$where = array(
					'cor_id' => $cor_id,
					'mem_id' => $mem_id,
				);

				$this->Cmall_order_model->update('', $updatedata, $where);

				// if( $cart_status ){
				// 	$updatedata = array(
				// 		'cod_status' => 'deposit',
				// 		);

				// 	$where = array(
				// 		'cor_id' => $cor_id,
				// 		'mem_id' => $mem_id,
				// 		'cod_status' => 'order',
				// 	);

				// 	$this->Cmall_order_detail_model->update('', $updatedata, $where);
				// }
			}

			redirect(current_full_url(), 'refresh');
		}

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		
		if (empty($cor_id) OR $cor_id < 1) {
			alert('잘못된 접근입니다');
		}
		
		$order = $this->{$this->modelname}->get_one($cor_id);
		if ( ! element('cor_id', $order)) {
			alert('해당 주문이 존재하지 않습니다.');
		}

		if($this->session->userdata['mem_admin_flag']!=0){
			if($order['company_idx'] != $this->session->userdata['company_idx']){
				alert('잘못된 접근입니다');	
			}
		}
		
		// if ($this->member->is_admin() === false
		// 	&& (int) element('mem_id', $order) !== $mem_id) {
		// 	alert('잘못된 접근입니다');
		// }

		$orderdetail = $this->Cmall_order_detail_model->get_by_item($cor_id);
		if ($orderdetail) {
			foreach ($orderdetail as $key => $value) {
				$orderdetail[$key]['item'] = $item
					= $this->Cmall_item_model->get_one(element('cit_id', $value));
				$orderdetail[$key]['itemdetail'] = $itemdetail
					= $this->Cmall_order_detail_model
					->get_detail_by_item($cor_id, element('cit_id', $value));

				$orderdetail[$key]['item']['possible_download'] = 1;
				if (element('cod_download_days', element(0, $itemdetail)) && element('cor_approve_datetime', $order)) {
					$endtimestamp = strtotime(element('cor_approve_datetime', $order))
						+ 86400 * element('cod_download_days', element(0, $itemdetail));
					$orderdetail[$key]['item']['download_end_date'] = $enddate
						= cdate('Y-m-d', $endtimestamp);

					$orderdetail[$key]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
				}
			}
		}

		$view['view']['data'] = $order;
		$view['view']['orderdetail'] = $orderdetail;

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'form');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

	}

	//주문상태변경(상품일괄변경)
	public function statuschange(){
		$cor_ids = $this->input->post('chk');
		$change_status = $this->input->post('change_status');
		$now = date('Y-m-d H:i:s');
		
		if(count($cor_ids) > 0){

			$this->load->model(array('Cmall_order_model','Cmall_order_detail_model','Cmall_item_model'));

			foreach($cor_ids as $k => $cor_id){

				//주문정보
				$order = $this->Cmall_order_model->get_one($cor_id);

				//주문상품
				if ($order) {
					$order_detail = $this->Cmall_order_detail_model->get_by_item(element('cor_id', $order));
					
					if ($order_detail) {
						foreach ($order_detail as $okey => $oval) {
							$order_detail[$okey]['item'] = $item
								= $this->Cmall_item_model->get_one(element('cit_id', $oval));
							$order_detail[$okey]['itemdetail'] = $itemdetail
								= $this->Cmall_order_detail_model->get_detail_by_item(element('cor_id', $order), element('cit_id', $oval));
						}
					}
				}

				//주문 상태와 주문상품 상태가 서로 다르면 차단
				foreach($order_detail as $k2=>$v2){

					if($this->session->userdata['mem_admin_flag']!=0){
						if($this->session->userdata['company_idx']!=$v2['item']['company_idx']){
							alert("다른몰의 상품이 포함된 주문입니다. 상태 변경을 중지 합니다.(주문번호 : ".$cor_id.")");
							exit;
						}
					}

					if($v2['item']['cit_item_type'] == 'i'){
						alert("아이템 상품이 포함되어 상태를 변경할 수 없습니다. 상태 변경을 중지 합니다.(주문번호 : ".$cor_id.")");
						exit;
					}
					
					foreach($v2['itemdetail'] as $k3 => $v3){
						if($order['status'] != $v3['cod_status']){
							alert("주문상품 단위로 상태 변경이 필요한 주문이 있어서 상태 변경을 중지 합니다.(주문번호 : ".$cor_id.")");
							exit;
						};

						if($v3['cod_status']=='cancel'){
							alert("취소된 주문 또는 주문상품은 상태를 변경할 수 없습니다. 상태 변경을 중지 합니다.(주문번호 : ".$cor_id.")");
							exit;
						}
					}
				}
				
				if($order['cor_pay_type']=='f'){

					if ( ! function_exists('fuse')) {
						$this->load->helper('fruit');
					}

					/**
					 * 주문확인 -> 취소
					 */
					if($order['status'] == 'order' && $change_status == 'cancel'){
						
						//주문의 열매와 예치금 환원, 주문의 코인 환원
						$return_fruit = $order['cor_cash'];

						fuse($order['mem_id'], $return_fruit, "주문취소 (주문번호 : ".$cor_id.")", $now, "order", $cor_id, "관리자가 주문취소");

						if($order['cor_company_deposit']>0){
						
							//예치금 환원
							company_depoist_use($order['mem_id'], $order['cor_company_deposit'], "주문취소 (주문번호 : ".$cor_id.")", $now, "order", $cor_id, "관리자가 주문취소");

						}
						
						//주문 상품 사용한 열매, 예치금 초기화
						$this->Cmall_order_model->pay_init($cor_id);

						//cb_cmall_order.status = cancel
						//cb_cmall_order.cor_status = 0;
						$this->Cmall_order_model->set_status_cancel($cor_id,$now);

						foreach($order_detail as $k2=>$v2){

							foreach($v2['itemdetail'] as $k3=>$v3){
								//재고 복구
								cmall_item_stock_change($v3['cit_id'],$v3['cod_count']); //함수 내부에서 재고 타입 검증
								
								//주문 상품 사용한 열매, 예치금, 코인(포인트) 초기화
								$this->Cmall_order_detail_model->pay_init($v3['cod_id']);
								
								//주문 상품 상태 변경
								$this->Cmall_order_detail_model->set_status_cancel($v3['cod_id'],$now);
							}
							
						}
					}

					/**
					 * 주문확인 -> 발송완료
					 */
					if($order['status'] == 'order' && $change_status == 'end'){
						//cb_cmall_order.status = end
						$this->Cmall_order_model->set_status_change($cor_id, 'end', $now);

						foreach($order_detail as $k2=>$v2){
							foreach($v2['itemdetail'] as $k3=>$v3){
								//cb_cmall_order_detail.cod_status = end;
								$this->Cmall_order_detail_model->set_status_change($v3['cod_id'],'end',$now);
							}
						}
					}

					/**
					 * 발송완료 -> 주문확인
					 */
					if($order['status'] == 'end' && $change_status == 'order'){
						//cb_cmall_order.status = order
						$this->Cmall_order_model->set_status_change($cor_id, 'order',$now);

						//cb_cmall_order_detail.cod_status = order;
						foreach($order_detail as $k2=>$v2){
							foreach($v2['itemdetail'] as $k3=>$v3){
								$this->Cmall_order_detail_model->set_status_change($v3['cod_id'],'order',$now);
							}
						}
					}

					
				}elseif($order['cor_pay_type']=='c'){

					/**
					 * 주문확인 -> 발송완료
					 */
					if($order['status'] == 'order' && $change_status == 'end'){
						//cb_cmall_order.status = end
						$this->Cmall_order_model->set_status_change($cor_id, 'end',$now);

						foreach($order_detail as $k2=>$v2){
							foreach($v2['itemdetail'] as $k3=>$v3){
								//cb_cmall_order_detail.cod_status = end;
								$this->Cmall_order_detail_model->set_status_change($v3['cod_id'],'end',$now);
							}
						}
					}

					/**
					 * 발송완료 -> 주문확인
					 */
					if($order['status'] == 'end' && $change_status == 'order'){
						//cb_cmall_order.status = order
						$this->Cmall_order_model->set_status_change($cor_id, 'order',$now);

						//cb_cmall_order_detail.cod_status = order;
						foreach($order_detail as $k2=>$v2){
							foreach($v2['itemdetail'] as $k3=>$v3){
								$this->Cmall_order_detail_model->set_status_change($v3['cod_id'],'order',$now);
							}
						}
					}

				}
				
			}
			alert("상태가 변경되었습니다.",$_SERVER['HTTP_REFERER']);
		}else{
			alert("상태를 변경할 주문번호가 없습니다.");
		}
	}


	/**
	 * 주문내역 엑셀 출력
	 */
	public function exportexcel(){

		$where = array();
		$excel_data = array();
		$custom_config = config_item('custom');
		$order_status = get_cmall_key_localize();

		/** 상세 검색 start */

		if(!$this->input->get('search_datetime_type')){
			$search_datetime_type = 'cor_datetime';
		}else{
			$search_datetime_type = $this->input->get('search_datetime_type');
		}

		if(!$this->input->get('search_datetime_start')){
			$start_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00")." -7day"));
		}else{
			$start_date = $this->input->get('search_datetime_start').' 00:00:00';
		}

		if(!$this->input->get('search_datetime_end')){
			$end_date = date("Y-m-d 23:59:59");
		}else{
			$end_date = $this->input->get('search_datetime_end').' 23:59:59';
		}	

		$view['view']['search']['search_datetime_type'] = $search_datetime_type;
		$where["cb_cmall_order.".$search_datetime_type.' >='] = $view['view']['search']['search_datetime_start'] = $start_date;
		$where["cb_cmall_order.".$search_datetime_type.' <='] = $view['view']['search']['search_datetime_end'] = $end_date;
		
		if ($this->input->get('cor_pay_type')) {
			$where['cb_cmall_order.cor_pay_type'] = $this->input->get('cor_pay_type');
		}

		if($this->session->userdata['mem_admin_flag']!=0){
			$where['cb_cmall_order.company_idx'] = $this->session->userdata['company_idx'];
		}

		if($this->input->get("status")){
			$statuss = array();
			foreach($this->input->get("status") as $k=>$v){
				$statuss[] = $v;
			}			

			$where["cb_cmall_order.status in('".implode("','",$statuss)."')"] = null;
			// SQL : status in('order')
		}

		if($this->input->get("search_order_value")!=""){
			$search_order_value = $this->input->get("search_order_value");
			if($this->input->get("search_order_key")=="mem_phone"){
				$search_order_value = str_replace("-","",$this->input->get("search_order_value"));
			}
			$like["cb_cmall_order.".$this->input->get("search_order_key")] = $search_order_value;
		}

		if($this->input->get("cor_id")!=""){
			$where["cb_cmall_order.cor_id"] = $this->input->get("cor_id");
		}

		if($this->input->get("company_idx")){
			$company_idxs = array();
			foreach($this->input->get("company_idx") as $k=>$v){
				$company_idxs[] = $v;
			}
			$where["cb_cmall_order.company_idx in('".implode("','",$company_idxs)."')"] = null;
		}

		if($this->input->get("cmall_category")){
			$cmall_categorys = array();
			foreach($this->input->get("cmall_category") as $k=>$v){
				$cmall_categorys[] = $v;
				$or_where[] = "(FIND_IN_SET(".$v.", tmp_cb_cmall_order_detail.cca_id) > 0)";
			}

			$or = "(".implode(" OR ",$or_where).")";
			
			$where[$or] = null;
		}

		/** 상세 검색 end */
		// $result = $this->{$this->modelname}
		// 	->get_admin_list(0, 9999999999999, $where, $like, $findex, $forder, $sfield, $skeyword);
		$join  = array(
			"table" => "
			(
				SELECT cb_cmall_order_detail.cor_id, tmp_cb_cmall_category_rel.cit_id, CONCAT(GROUP_CONCAT(tmp_cb_cmall_category_rel.cca_id SEPARATOR ', ')) AS cca_id
				FROM cb_cmall_order_detail
				INNER JOIN
					(
						SELECT DISTINCT tmp_cb_cmall_category_rel.*
						FROM cb_cmall_category_rel 
						INNER JOIN 
							(
								SELECT cb_cmall_category_rel.cit_id, cb_cmall_category.cca_id, cb_cmall_category.cca_parent
								FROM cb_cmall_category 
								INNER JOIN cb_cmall_category_rel 
								ON cb_cmall_category_rel.cca_id = cb_cmall_category.cca_id
								WHERE cb_cmall_category.cca_parent = 0
							) AS tmp_cb_cmall_category_rel
						ON cb_cmall_category_rel.cit_id = tmp_cb_cmall_category_rel.cit_id
					) AS tmp_cb_cmall_category_rel
				ON cb_cmall_order_detail.cit_id = tmp_cb_cmall_category_rel.cit_id
				GROUP BY cb_cmall_order_detail.cor_id
			) AS tmp_cb_cmall_order_detail
			",
			"on"=>"ON cb_cmall_order.cor_id = tmp_cb_cmall_order_detail.cor_id"
		);
		$result = $this->{$this->modelname}
			->_get_list_common("cb_cmall_order.*",$join,0,9999999999999, $where, $like, $findex, $forder, $sfield, $skeyword);
		
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				if($val['company_idx']) $result['list'][$key]['company_name'] = busiNm($val['company_idx']);
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
				$result['list'][$key]['pay_method'] = $this->cmalllib->get_paymethodtype(element('cor_pay_type', $val));
				$result['list'][$key]['order_status'] = cmall_print_stype_names(element('status', $val));

				$orderdetail = $this->Cmall_order_detail_model->get_by_item(element('cor_id', $val));

				if ($orderdetail) {
					foreach ($orderdetail as $okey => $oval) {
						$orderdetail[$okey]['item'] = $item
							= $this->Cmall_item_model->get_one(element('cit_id', $oval));
						$orderdetail[$okey]['itemdetail'] = $itemdetail
							= $this->Cmall_order_detail_model->get_detail_by_item(element('cor_id', $val), element('cit_id', $oval));

						$orderdetail[$okey]['item']['possible_download'] = 1;

						if (element('cod_download_days', element(0, $itemdetail))) {
							$endtimestamp = strtotime(element('cor_approve_datetime', $val))
								+ 86400 * element('cod_download_days', element(0, $itemdetail));
							$orderdetail[$okey]['item']['download_end_date'] = $enddate = cdate('Y-m-d', $endtimestamp);

							$orderdetail[$okey]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
						}

						foreach($itemdetail as $k3=>$v3){
							$row = array(
								"cor_id"=>$val['cor_id'],//주문번호
								"cor_datetime"=>str_replace("-",".",substr($val['cor_datetime'],0,10)),//주문일
								"company_name"=>$result['list'][$key]['company_name'], //기업명
								"mem_email"=>$val['mem_email'], //이메일
								"mem_realname"=>$val['mem_realname'], //회원명
								"mem_phone"=>$val['mem_phone'], //전화번호
								"cca_value"=>cmall_item_parent_category_name($oval['cit_id']), //카테고리
								"cit_item_type"=>$custom_config['item']['type'][$item['cit_item_type']], // 상품구분
								"cit_name"=>$item['cit_name']."(".$v3['cde_title'].")",// 주문상품
								"cod_count"=>$v3['cod_count'],// 개수
								"cod_status"=>$order_status[$v3['cod_status']],// 주문상태
								"cor_pay_type"=>$this->cmalllib->get_paymethodtype($val['cor_pay_type']),// 결제수단
								"cod_price"=>($v3['cit_price'] + $v3['cde_price']) * $v3['cod_count'],// 결제금액
							);

							if($val['cor_ship_zipcode']!=''){
								$row['cor_address'] = "[".$val['cor_ship_zipcode']."] ".$val['cor_ship_address']." ".$val["cor_ship_address_detail"]; //배송지
							}else{
								$row['cor_address'] = "";
							}

							//사용열매/코인
							if($val['cor_pay_type']=="f"){
								$row['cor_fruit_or_coin_amount'] = $v3['cod_fruit'];
							}else{
								$row['cor_fruit_or_coin_amount'] = $v3['cit_price'] * $v3["cod_count"];
							}
							
							if($this->session->userdata['mem_admin_flag']!=0){
								if($this->session->userdata['company_idx'] != $item['company_idx']){
									continue;
								}
							}

							$excel_data[] = $row;
						}
					}
				}
				$result['list'][$key]['orderdetail'] = $orderdetail;
			}
		}
		
		$view['view']['data']['list'] = $excel_data;
		$view['view']['data']['mem_admin_flag'] = $this->session->userdata['mem_admin_flag'];
		
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=주문내역_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/excel', $view, true);


		//super
		/*
		주문번호
		주문일
		기업명
		회원이메일
		회원명
		전화번호
		카테고리
		상품구분
		주문상품
		개수
		주문상태
		결제수단
		결제금액
		*/

		//company
		/*
		주문번호
		주문일
		회원이메일
		회원명
		전화번호
		배송지
		카테고리
		상품구분
		주문상품
		개수
		주문상태
		결제수단
		사용열매/코인
		실결제금액
		*/

	
	}
}
