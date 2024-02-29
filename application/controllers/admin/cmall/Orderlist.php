<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Orderlist class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>컨텐츠몰관리>구매내역 controller 입니다.
 */
class Orderlist extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cmall/orderlist';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Cmall_order', 'Cmall_item', 'Cmall_order_detail');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Cmall_order_detail_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'cmall');

	/**
	 * 주문 상태
	 */
	protected $status = array("order"=>"주문확인","ready"=>"발송대기","end"=>"발송완료","cancel"=>"주문취소");


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
		$eventname = 'event_admin_cmall_orderlist_index';
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
				'field' => 'cod_id',
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
				'cod_id' => $this->input->post('cod_id'),
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

		$findex = $this->input->get('findex') ? $this->input->get('findex') : 'cod_approve_datetime';
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('cod_id', 'member.mem_nickname', 'cmall_order.mem_realname', 'member.mem_userid', 'cod_content', 'cod_total_money', 'cod_cash', 'cod_memo', 'cod_admin_memo', 'cod_ip', 'member.mem_id'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('member.mem_id', 'cod_total_money', 'cod_cash'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('cod_id'); // 정렬이 가능한 필드


		$where["cb_cmall_item.cit_item_type != 'i'"] = null;

		if($this->session->userdata['mem_admin_flag']!=0){
			//기업관리자
			$where['cb_cmall_item.company_idx'] = $this->session->userdata['company_idx'];
		}

		if ($this->input->get('cod_pay_type')) {
			$where['cb_cmall_order_detail.cod_pay_type'] = $this->input->get('cod_pay_type');
		}

		if($this->input->get("citt_id_use") == 1){
			$where['citt_id > 0'] = null;
		}elseif($this->input->get("citt_id_use") == "0"){
			$where['citt_id = 0'] = null;
		}

		if($this->session->userdata['mem_admin_flag']==0){
			//슈퍼관리자 : 템틀릿 상품만 보기
			$where['citt_id > 0'] = null;
		}




		if($this->input->get("cor_id")!=""){
			$where['cb_cmall_order_detail.cor_id'] = $this->input->get("cor_id");
		}

		if($this->input->get("search_datetime_type")=="cor_datetime"){
			$search_datetime_type = "cb_cmall_order.cor_datetime";
		}

		if($this->input->get("search_datetime_type")=="cor_ready_datetime"){
			$search_datetime_type = "cb_cmall_order_detail.cor_ready_datetime";
		}

		if($this->input->get("search_datetime_type")=="cor_end_datetime"){
			$search_datetime_type = "cb_cmall_order_detail.cod_end_datetime";
		}

		if($this->input->get("search_datetime_type")=="cor_cancel_datetime"){
			$search_datetime_type = "cb_cmall_order_detail.cod_cancel_datetime";
		}

		if($this->input->get("search_datetime_start")!="" && $search_datetime_type){
			$where[$search_datetime_type." >= '".$this->input->get("search_datetime_start")." 00:00:00'"] = null;
		}

		if($this->input->get("search_datetime_end")!="" && $search_datetime_type){
			$where[$search_datetime_type." <= '".$this->input->get("search_datetime_end")." 23:59:59'"] = null;
		}

		if(count($this->input->get("status")) > 0){
			$where["cb_cmall_order_detail.cod_status in ('".implode("','",$this->input->get("status"))."')"] = null;
		}




		if($this->input->get("search_order_key")=="mem_phone"){
			$search_order_key = "cb_cmall_order.mem_phone";
		}

		if($this->input->get("search_order_key")=="mem_email"){
			$search_order_key = "cb_cmall_order.mem_email";
		}

		if($this->input->get("search_order_key")=="mem_realname"){
			$search_order_key = "cb_cmall_order.mem_realname";
		}
		
		if($this->input->get("search_order_value")!=""){
			$where[$search_order_key] = $this->input->get("search_order_value");
		}


		if(count($this->input->get('company_idx')) > 0){
			$where["cb_cmall_item.company_idx in ('".implode("','",$this->input->get("company_idx"))."')"] = null;
		}


		$result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		$this->load->model("Company_info_model");

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				
				unset($tmp);
				if($val['company_idx']){
					$tmp = $this->Company_info_model->get_one($val['company_idx']);
					$result['list'][$key]['company_name'] = $tmp['company_name'];
				}


				$result['list'][$key]['cod_status_name'] = $this->status[$val['cod_status']];

				
			}
		}
		$view['view']['data'] = $result;

		//검색 시 기업 리스트
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
		$search_option = array('member.mem_nickname' => '회원명', 'cmall_order.mem_realname' => '회원실명', 'member.mem_userid' => '회원아이디', 'cod_content' => '내용', 'cod_total_money' => '결제금액');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);

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



	//주문상태변경
	public function statuschange(){
		$cod_ids = $this->input->post('chk');
		$change_status = $this->input->post('change_status');
		$now = date('Y-m-d H:i:s');



		
		
		if(count($cod_ids) > 0){

			$this->load->model(array('Cmall_order_model','Cmall_order_detail_model','Cmall_item_model','Member_model','Company_info_model'));
			$this->load->library('point');

			foreach($cod_ids as $k => $cod_id){

				unset($tmp);
				$cod = $this->Cmall_order_detail_model->get_one($cod_id);
				$item = $this->Cmall_item_model->get_one($cod['cit_id']);

				$cor_ids[] = $cod['cor_id'];

				if($this->session->userdata['mem_admin_flag']!=0){
					if($this->session->userdata['company_idx']!=$item['company_idx']){
						alert("다른몰의 상품이 포함된 주문입니다. 상태 변경을 중지 합니다.(주문번호 : ".$cod['cor_id'].")");
						exit;
					}
				}

				if($item['cit_item_type'] == 'i'){
					alert("아이템 상품은 상태를 변경할 수 없습니다. 상태 변경을 중지 합니다.(주문번호 : ".$cod['cor_id'].")");
					exit;
				}

				if($cod['cod_status']=='cancel'){
					alert("취소된 주문상품은 상태를 변경할 수 없습니다. 상태 변경을 중지 합니다.(주문번호 : ".$cod['cor_id'].")");
					exit;
				}

				
				
				/**
				 * 주문확인 -> 발송대기
				 */
				if($cod['cod_status'] == 'order' && $change_status == 'ready'){

					if($item['citt_id'] > 0){
						//템플릿상품
						$transition[$item['company_idx']][] = array(
							"cod" => $cod,
							"item" => $item,
							"order_member" => $this->Member_model->get_one($cod['mem_id']),
							"amount" => ($cod['cod_point']*100)*(-1)
						);
					}else{
						//자체상품
						$this->Cmall_order_detail_model->set_status_change($cod['cod_id'],'ready',$now);
					}
				}

				/**
				 * 발송대기 -> 발송완료
				 */
				if($cod['cod_status'] == 'ready' && $change_status == 'end'){
					$this->Cmall_order_detail_model->set_status_change($cod_id,'end',$now);
				}

				/**
				 * 주문확인 -> 주문취소
				 */
				if($cod['cod_status'] == 'order' && $change_status == 'cancel'){		
					
					//복지포인트 복구
					$this->point->insert_point($cod['mem_id'], $cod['cod_point'], "주문취소 (주문번호 : ".$cod['cor_id'].", 주문상품 : ".$item['cit_name'].")", "order", $cod['cor_id'], "주문취소");

					$this->Cmall_order_detail_model->set_status_change($cod_id,'cancel',$now);

					//재고 복구
					cmall_item_stock_change($item['cit_id'],$cod['cod_count']); //함수 내부에서 재고 타입 검증

					//주문 상품 사용한 복지포인트 초기화
					$this->Cmall_order_detail_model->pay_init($cod_id);
				}

			}


			/**
			 * 주문의 상태 업데이트
			 */
			$cor_ids = array_unique($cor_ids);
			foreach($cor_ids as $cor_id){
				$this->Cmall_order_detail_model->set_order_status_update($cor_id);
			}
			

			/**
			 * 주문확인 -> 발송대기, 변경이 있으면 예치금 합산 계산
			 */
			if(count($transition)>0){

				foreach($transition as $company_idx => $change_ready_datas){
					
					$total_amount = 0;

					$company_deposit = camll_company_deposit($company_idx);

					if(count($change_ready_datas)>0){
						foreach($change_ready_datas as $data){
							$total_amount = $total_amount + $data['amount'];
						}
					}

					if(($company_deposit + $total_amount) >= 0){
						//예치금충분

						foreach($change_ready_datas as $data){
							$message = $data['order_member']["mem_username"]."(".$data['order_member']["mem_userid"].") 상품구매 (주문번호 : ".$data['cod']['cor_id'].", 주문상품 : ".$data['item']['cit_name'].")";

							//예치금사용
							company_depoist_use($data['cod']['mem_id'], $data['amount'], $message, $now, "order", $data['cod']['cor_id'], "발송대기");

							//상태변경
							$this->Cmall_order_detail_model->set_status_change($data['cod']['cod_id'],'ready',$now);
						}

					}else{
						//예치금부족
						
						$company_info = $this->Company_info_model->get_one($company_idx);
						
						
						$fails[$company_idx]['company_name'] = $company_info['company_name'];
						$fails[$company_idx]['company_deposit'] = $company_deposit;

						foreach($change_ready_datas as $data){
							$fails[$company_idx]['detail'][] = array(
								"cor_id"=>$data['cod']['cor_id'],
								"cit_name"=>$data['item']['cit_name'],
								"amount"=>$data['amount']
							);
						}
					}
				}

				/**
				 * 주문의 상태 업데이트
				 */
				$cor_ids = array_unique($cor_ids);
				foreach($cor_ids as $cor_id){
					$this->Cmall_order_detail_model->set_order_status_update($cor_id);
				}


				if(count($fails) > 0){
					
					$view['view']['data'] = $fails;
					$view['view']['return_url'] = admin_url($this->pagedir);
					/**
					 * 레이아웃 설정
					 */

					$layoutconfig = array('layout' => 'layout_popup', 'skin' => 'changestatusfail');
					$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
					$this->data = $view;
					$this->layout = element('layout_skin_file', element('layout', $view));
					$this->view = element('view_skin_file', element('layout', $view));
				}else{
					redirect(admin_url($this->pagedir), 'refresh');
				}

			}else{
				redirect(admin_url($this->pagedir), 'refresh');
			}
			
			
		}else{
			alert("상태를 변경할 자료가 없습니다.");
		}
	}



	/**
	 * 엑셀시트다운로드
	 */
	public function exportexcel(){

		$this->load->model(array("Company_info_model","Member_model","Cmall_order_model","Cmall_item_model"));

		$where["cb_cmall_item.cit_item_type != 'i'"] = null;

		if($this->session->userdata['mem_admin_flag']!=0){
			//기업관리자
			$where['cb_cmall_item.company_idx'] = $this->session->userdata['company_idx'];
		}

		if ($this->input->get('cod_pay_type')) {
			$where['cb_cmall_order_detail.cod_pay_type'] = $this->input->get('cod_pay_type');
		}

		if($this->input->get("citt_id_use") == 1){
			$where['citt_id > 0'] = null;
		}elseif($this->input->get("citt_id_use") == "0"){
			$where['citt_id = 0'] = null;
		}

		if($this->session->userdata['mem_admin_flag']==0){
			//슈퍼관리자 : 템틀릿 상품만 보기
			$where['citt_id > 0'] = null;
		}




		if($this->input->get("cor_id")!=""){
			$where['cb_cmall_order_detail.cor_id'] = $this->input->get("cor_id");
		}

		if($this->input->get("search_datetime_type")=="cor_datetime"){
			$search_datetime_type = "cb_cmall_order.cor_datetime";
		}

		if($this->input->get("search_datetime_type")=="cor_ready_datetime"){
			$search_datetime_type = "cb_cmall_order_detail.cor_ready_datetime";
		}

		if($this->input->get("search_datetime_type")=="cor_end_datetime"){
			$search_datetime_type = "cb_cmall_order_detail.cod_end_datetime";
		}

		if($this->input->get("search_datetime_type")=="cor_cancel_datetime"){
			$search_datetime_type = "cb_cmall_order_detail.cod_cancel_datetime";
		}

		if($this->input->get("search_datetime_start")!="" && $search_datetime_type){
			$where[$search_datetime_type." >= '".$this->input->get("search_datetime_start")." 00:00:00'"] = null;
		}

		if($this->input->get("search_datetime_end")!="" && $search_datetime_type){
			$where[$search_datetime_type." <= '".$this->input->get("search_datetime_end")." 23:59:59'"] = null;
		}

		if(count($this->input->get("status")) > 0){
			$where["cb_cmall_order_detail.cod_status in ('".implode("','",$this->input->get("status"))."')"] = null;
		}




		if($this->input->get("search_order_key")=="mem_phone"){
			$search_order_key = "cb_cmall_order.mem_phone";
		}

		if($this->input->get("search_order_key")=="mem_email"){
			$search_order_key = "cb_cmall_order.mem_email";
		}

		if($this->input->get("search_order_key")=="mem_realname"){
			$search_order_key = "cb_cmall_order.mem_realname";
		}
		
		if($this->input->get("search_order_value")!=""){
			$where[$search_order_key] = $this->input->get("search_order_value");
		}


		if(count($this->input->get('company_idx')) > 0){
			$where["cb_cmall_item.company_idx in ('".implode("','",$this->input->get("company_idx"))."')"] = null;
		}

		$findex = 'cod_approve_datetime';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$result = $this->{$this->modelname}
			->get_admin_list(9999999999999, 0, $where, '', $findex, $forder, $sfield, $skeyword);

		if(count($result['list'])>0){
			foreach($result['list'] as $k=>$v){

				unset($tmp);
				$tmp = $this->Company_info_model->get_one($v['company_idx']);
				$v['company_name'] = $tmp['company_name'];


				unset($tmp);
				$tmp = $this->Member_model->get_one($v['mem_id']);
				$v['mem_div'] = $tmp['mem_div'];
				$v['mem_position'] = $tmp['mem_position'];
				$v['mem_username'] = $tmp['mem_username'];
				

				unset($tmp);
				$tmp = $this->Cmall_order_model->get_one($v['cor_id']);
				$v['mem_phone'] = $tmp['mem_phone'];
				$v['cor_ship_zipcode'] = $tmp['cor_ship_zipcode'];
				$v['cor_ship_address'] = $tmp['cor_ship_address'];
				$v['cor_ship_address_detail'] = $tmp['cor_ship_address_detail'];


				unset($tmp);
				$tmp = $this->Cmall_item_model->get_one($v['cit_id']);
				$v['cit_name'] = $tmp['cit_name'];

				
				$v['status_name'] = $this->status[$v['cod_status']];

				$result['list'][$k] = $v;
			}
		}
		
		$view['view']['data']['list'] = $result['list'];
		$view['view']['data']['mem_admin_flag'] = $this->session->userdata['mem_admin_flag'];

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=주문내역_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/excel', $view, true);

	}

}
