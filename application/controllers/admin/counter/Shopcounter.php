<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Statcounter class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>통계>SHOP통계 controller 입니다.
 */
class Shopcounter extends CB_Controller
{
    /**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'counter/shopcounter';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Stat_count', 'Stat_count_date', 'Post');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Stat_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

	/**
	 * 판매순위
	 */
	public function index($export = '')
	{
		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		$sWhere = "";

		// 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere = " and e.company_idx = ".$this->member->item('company_idx');
			}
		} 

		if($this->input->get('category') && empty($this->input->get('category')) === false){
			$category = implode(',',$this->input->get('category'));
			$sWhere .= " and f.cca_id in (".$category.") ";
		} else {
			// 기업몰 기본값
			$sWhere .= " and f.cca_id = 2 ";
		}

		// 검색
		// 카테고리(기업몰, 공용몰, 아이템몰)
		$sql = "select cca_id, cca_value from cb_cmall_category where 1 order by cca_order";
		$r = $this->db->query($sql);
		$rst = $r->result_array();
		foreach($rst as $k => $v){
			if(in_array($v['cca_id'], $this->input->get('category'))){
				$rst[$k]['checked'] = 'checked';
			} else {
				$rst[$k]['checked'] = '';
			}

			if(empty($this->input->get('category')) === true){
				if($v['cca_id'] == 2){
					$rst[$k]['checked'] = 'checked';
				}
			}
		}
		$view['view']['filter']['category'] = $rst;
		
		$list_start_date = $view['view']['list_start_date'] = $this->input->get('list_start_date');
        $list_end_date = $view['view']['list_end_date'] = $this->input->get('list_end_date');
		$list_ymd = $view['view']['list_ymd'] = $this->input->get('list_ymd');
		if(!$list_ymd){
			if($list_start_date && $list_end_date){
				$sWhere .= " and a.cit_datetime >= '".$list_start_date." 00:00:00' and a.cit_datetime <= '".$list_end_date." 23:59:59' ";
				$view['view']['list_ymd'] = '';
			}
		} else {
			if($list_ymd == 'day'){
				$view['view']['list_start_date'] = date('Y-m-d');
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cit_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cit_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '7day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-7 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cit_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cit_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '15day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-15 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cit_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cit_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '1month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-1 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cit_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cit_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '3month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-3 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cit_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cit_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else {
				$view['view']['list_start_date'] = '';
				$view['view']['list_end_date'] = '';
			}
		}

		$sql = "select (select sum(d.cor_total_money) from cb_cmall_item as a 
		left join cb_cmall_item_detail as b on b.cit_id = a.cit_id 
		left join cb_cmall_order_detail as c on c.cit_id = a.cit_id 
		left join cb_cmall_order as d on d.cor_id = c.cor_id 
		left join cb_member as e on e.mem_id = d.mem_id 
		left join cb_cmall_category_rel as f on f.cit_id = a.cit_id 
		left join cb_cmall_category as g on g.cca_id = f.cca_id 
		where d.status != 'cancel' and g.cca_value != '' and d.cor_pay_type = 'c' ".$sWhere.") as cor_total_money_sum_c, 
		(select sum(d.cor_total_money) from cb_cmall_item as a 
		left join cb_cmall_item_detail as b on b.cit_id = a.cit_id 
		left join cb_cmall_order_detail as c on c.cit_id = a.cit_id 
		left join cb_cmall_order as d on d.cor_id = c.cor_id 
		left join cb_member as e on e.mem_id = d.mem_id 
		left join cb_cmall_category_rel as f on f.cit_id = a.cit_id 
		left join cb_cmall_category as g on g.cca_id = f.cca_id 
		where d.status != 'cancel' and g.cca_value != '' and d.cor_pay_type = 'f' ".$sWhere.") as cor_total_money_sum_f, 
		sum(c.cod_count) as cod_count_sum, count(d.cor_id) as cor_count from cb_cmall_item as a 
		left join cb_cmall_item_detail as b on b.cit_id = a.cit_id 
		left join cb_cmall_order_detail as c on c.cit_id = a.cit_id 
		left join cb_cmall_order as d on d.cor_id = c.cor_id 
		left join cb_member as e on e.mem_id = d.mem_id 
		left join cb_cmall_category_rel as f on f.cit_id = a.cit_id 
		left join cb_cmall_category as g on g.cca_id = f.cca_id 
		where d.status != 'cancel' and g.cca_value != '' ".$sWhere;
		$qry = $this->db->query($sql);
		$result = $qry->row_array();
		$view['view']['list']['total'] = $result;


		$sql = "select row_number() over(order by sum(d.cor_total_money) desc) as num, a.cit_id, a.cit_name, a.cit_price, a.cit_file_1 from cb_cmall_item as a 
		left join cb_cmall_item_detail as b on b.cit_id = a.cit_id 
		left join cb_cmall_order_detail as c on c.cit_id = a.cit_id 
		left join cb_cmall_order as d on d.cor_id = c.cor_id 
		left join cb_member as e on e.mem_id = d.mem_id 
		left join cb_cmall_category_rel as f on f.cit_id = a.cit_id 
		left join cb_cmall_category as g on g.cca_id = f.cca_id 
		where d.status != 'cancel' and g.cca_value != '' ".$sWhere." 
		group by a.cit_id order by sum(d.cor_total_money) desc";
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
		foreach($result as $k => $v){
			$result[$k]['item_thumb'] = '/uploads/cmallitem/'.$v['cit_file_1']; 

			$sWhere2 = "";
			if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
				if($this->member->item('mem_level') == '100'){ // 기업관리자
					$sWhere2 = " and c.company_idx = ".$this->member->item('company_idx');
				}
			} 

			// 상품금액 = 각 디바이스별 구매수량 X 상품금액(1개)
			$sql = "select 
			(select sum(b.cor_total_money) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%windows%' or b.cor_useragent like '%macintosh%')) as pcsum, 
			(select sum(b.cor_total_money) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%iphone%' or b.cor_useragent like '%android%' or b.cor_useragent like '%linux%')) as mosum, 
			(select sum(b.cor_total_money) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%ipad%' or (b.cor_useragent not like '%windows%' and b.cor_useragent not like '%maxintosh%' 
			and b.cor_useragent not like '%iphone%' and b.cor_useragent not like '%android%' and b.cor_useragent not like '%linux%'))) as tbsum 
			from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id left join cb_member as c on c.mem_id = a.mem_id where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." group by 1";
			$r = $this->db->query($sql);
			$rowdata = $r->result_array();
			foreach($rowdata as $k2 => $v2){
				if(!$v2['pcsum']){
					$rowdata[$k2]['pcsum'] = 0;
				}
				if(!$v2['mosum']){
					$rowdata[$k2]['mosum'] = 0;
				}
				if(!$v2['tbsum']){
					$rowdata[$k2]['tbsum'] = 0;
				}
				$rowdata[$k2]['sum'] = $rowdata[$k2]['pcsum'] + $rowdata[$k2]['mosum'] + $rowdata[$k2]['tbsum'];
			}
			$result[$k]['device1'] = $rowdata;

			// 구매수량 = 각 디바이스별 구매수량
			$sql = "select 
			(select sum(a.cod_count) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%windows%' or b.cor_useragent like '%macintosh%')) as pcsum, 
			(select sum(a.cod_count) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%iphone%' or b.cor_useragent like '%android%' or b.cor_useragent like '%linux%')) as mosum, 
			(select sum(a.cod_count) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%ipad%' or (b.cor_useragent not like '%windows%' and b.cor_useragent not like '%maxintosh%' 
			and b.cor_useragent not like '%iphone%' and b.cor_useragent not like '%android%' and b.cor_useragent not like '%linux%'))) as tbsum 
			from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id left join cb_member as c on c.mem_id = a.mem_id where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." group by 1";
			$r = $this->db->query($sql);
			$rowdata = $r->result_array();
			foreach($rowdata as $k2 => $v2){
				if(!$v2['pcsum']){
					$rowdata[$k2]['pcsum'] = 0;
				}
				if(!$v2['mosum']){
					$rowdata[$k2]['mosum'] = 0;
				}
				if(!$v2['tbsum']){
					$rowdata[$k2]['tbsum'] = 0;
				}
				$rowdata[$k2]['sum'] = $rowdata[$k2]['pcsum'] + $rowdata[$k2]['mosum'] + $rowdata[$k2]['tbsum'];
			}
			$result[$k]['device2'] = $rowdata;

			// 구매건수 = 주문건수
			$sql = "select 
			(select count(b.cor_id) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%windows%' or b.cor_useragent like '%macintosh%')) as pcsum, 
			(select count(b.cor_id) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%iphone%' or b.cor_useragent like '%android%' or b.cor_useragent like '%linux%')) as mosum, 
			(select count(b.cor_id) from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." and (b.cor_useragent like '%ipad%' or (b.cor_useragent not like '%windows%' and b.cor_useragent not like '%maxintosh%' 
			and b.cor_useragent not like '%iphone%' and b.cor_useragent not like '%android%' and b.cor_useragent not like '%linux%'))) as tbsum 
			from cb_cmall_order_detail as a left join cb_cmall_order as b on b.cor_id = a.cor_id left join cb_member as c on c.mem_id = a.mem_id where a.cit_id = ".$v['cit_id']." and a.cod_status != 'cancel' ".$sWhere2." group by 1";
			$r = $this->db->query($sql);
			$rowdata = $r->result_array();
			foreach($rowdata as $k2 => $v2){
				if(!$v2['pcsum']){
					$rowdata[$k2]['pcsum'] = 0;
				}
				if(!$v2['mosum']){
					$rowdata[$k2]['mosum'] = 0;
				}
				if(!$v2['tbsum']){
					$rowdata[$k2]['tbsum'] = 0;
				}
				$rowdata[$k2]['sum'] = $rowdata[$k2]['pcsum'] + $rowdata[$k2]['mosum'] + $rowdata[$k2]['tbsum'];
			}
			$result[$k]['device3'] = $rowdata;
			
		}
		
		$view['view']['list']['board'] = $result;


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		if ($export === 'excel') {

			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=시간대별학습현황_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/index_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}

	public function order($export = '')
	{
		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = $this->input->get('listnum') ? $this->input->get('listnum') : 10;
		$offset = ($page - 1) * $per_page;

		$sWhere = "";

		// 해당 기업관리자 소속 기업회원만 조회
		if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아니면
			if($this->member->item('mem_level') == '100'){ // 기업관리자
				$sWhere = " and c.company_idx = ".$this->member->item('company_idx');
			}
		} 

		if($this->input->get('category') && empty($this->input->get('category')) === false){
			$category = implode(',',$this->input->get('category'));
			$sWhere .= " and e.cca_id in (".$category.") ";
		} else {
			// 기업몰 기본값
			$sWhere .= " and e.cca_id = 2 ";
		}

		// 검색
		// 카테고리(기업몰, 공용몰, 아이템몰)
		$sql = "select cca_id, cca_value from cb_cmall_category where 1 order by cca_order";
		$r = $this->db->query($sql);
		$rst = $r->result_array();
		foreach($rst as $k => $v){
			if(in_array($v['cca_id'], $this->input->get('category'))){
				$rst[$k]['checked'] = 'checked';
			} else {
				$rst[$k]['checked'] = '';
			}

			if(empty($this->input->get('category')) === true){
				if($v['cca_id'] == 2){
					$rst[$k]['checked'] = 'checked';
				}
			}
		}
		$view['view']['filter']['category'] = $rst;
		
		$list_start_date = $view['view']['list_start_date'] = $this->input->get('list_start_date');
        $list_end_date = $view['view']['list_end_date'] = $this->input->get('list_end_date');
		$list_ymd = $view['view']['list_ymd'] = $this->input->get('list_ymd');
		if(!$list_ymd){
			if($list_start_date && $list_end_date){
				$sWhere .= " and a.cor_datetime >= '".$list_start_date." 00:00:00' and a.cor_datetime <= '".$list_end_date." 23:59:59' ";
				$view['view']['list_ymd'] = '';
			}
		} else {
			if($list_ymd == 'day'){
				$view['view']['list_start_date'] = date('Y-m-d');
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cor_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cor_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '7day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-7 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cor_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cor_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '15day'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-15 day'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cor_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cor_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '1month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-1 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cor_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cor_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else if($list_ymd == '3month'){
				$view['view']['list_start_date'] = date('Y-m-d', strtotime('-3 month'));
				$view['view']['list_end_date'] = date('Y-m-d');
				$sWhere .= " and a.cor_datetime >= '".$view['view']['list_start_date']." 00:00:00' and a.cor_datetime <= '".$view['view']['list_end_date']." 23:59:59' ";
			} else {
				$view['view']['list_start_date'] = '';
				$view['view']['list_end_date'] = '';
			}
		}

		$sql = "select (select sum(a.cor_total_money) from cb_cmall_order as a 
		left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
		left join cb_member as c on c.mem_id = a.mem_id 
		left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
		left join cb_cmall_category as e on e.cca_id = d.cca_id 
		where a.status != 'cancel' and a.status = b.cod_status and a.cor_pay_type = 'c' ".$sWhere.") as cor_total_money_sum_c, 
		(select sum(a.cor_total_money) from cb_cmall_order as a 
		left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
		left join cb_member as c on c.mem_id = a.mem_id 
		left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
		left join cb_cmall_category as e on e.cca_id = d.cca_id 
		where a.status != 'cancel' and a.status = b.cod_status and a.cor_pay_type = 'f' ".$sWhere.") as cor_total_money_sum_f, 
		count(a.cor_id) as cor_id_cnt, sum(b.cod_count) as cod_count_sum from cb_cmall_order as a 
		left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
		left join cb_member as c on c.mem_id = a.mem_id 
		left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
		left join cb_cmall_category as e on e.cca_id = d.cca_id 
		where a.status != 'cancel' and a.status = b.cod_status ".$sWhere;
		$qry = $this->db->query($sql);
		$resultTotal = $qry->row_array();
		$view['view']['list']['total']['cor_total_money_sum_c'] = $resultTotal['cor_total_money_sum_c'];
		$view['view']['list']['total']['cor_total_money_sum_f'] = $resultTotal['cor_total_money_sum_f'];
		$view['view']['list']['total']['cor_id_cnt'] = $resultTotal['cor_id_cnt'];
		$view['view']['list']['total']['cod_count_sum'] = $resultTotal['cod_count_sum'];

		$sql = "select count(a.cor_id) as mem_id_cnt from cb_cmall_order as a 
		left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
		left join cb_member as c on c.mem_id = a.mem_id 
		left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
		left join cb_cmall_category as e on e.cca_id = d.cca_id 
		where a.status != 'cancel' and a.status = b.cod_status ".$sWhere." group by a.mem_id";
		$qry = $this->db->query($sql);
		$resultTotal = $qry->result_array();
		$view['view']['list']['total']['mem_id_cnt'] = count($resultTotal);

		$sql = "select substring(a.cor_datetime, 1, 10) as cor_datetime from cb_cmall_order as a 
		left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
		left join cb_member as c on c.mem_id = a.mem_id 
		left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
		left join cb_cmall_category as e on e.cca_id = d.cca_id 
		where a.status != 'cancel' and a.status = b.cod_status ".$sWhere." group by 1 order by a.cor_datetime asc";
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
		foreach($result as $k => $v){
			// 전체
			$sql = "select sum(a.cor_total_money) as cor_total_money_sum, count(a.cor_id) as cor_id_cnt, sum(b.cod_count) as cod_count_sum from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' ".$sWhere;
			$r = $this->db->query($sql);
			$rst1 = $r->row_array();
			$result[$k]['total']['cor_total_money_sum'] = $rst1['cor_total_money_sum'];
			$result[$k]['total']['cor_id_cnt'] = $rst1['cor_id_cnt'];
			$result[$k]['total']['cod_count_sum'] = $rst1['cod_count_sum'];

			$sql = "select count(a.mem_id) as mem_id_cnt from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' ".$sWhere." group by a.mem_id";
			$r = $this->db->query($sql);
			$rst1 = $r->result_array();
			$result[$k]['total']['mem_id_cnt'] = count($rst1);
			
			// pc
			$sql = "select sum(a.cor_total_money) as cor_total_money_sum, count(a.cor_id) as cor_id_cnt, sum(b.cod_count) as cod_count_sum from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' and (a.cor_useragent like '%windows%' or a.cor_useragent like '%macintosh%') ".$sWhere;
			$r = $this->db->query($sql);
			$rst2 = $r->row_array();
			$result[$k]['pc']['cor_total_money_sum'] = $rst2['cor_total_money_sum'];
			$result[$k]['pc']['cor_id_cnt'] = $rst2['cor_id_cnt'];
			$result[$k]['pc']['cod_count_sum'] = $rst2['cod_count_sum'];

			$sql = "select count(a.mem_id) as mem_id_cnt from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' and (a.cor_useragent like '%windows%' or a.cor_useragent like '%macintosh%') ".$sWhere." group by a.mem_id";
			$r = $this->db->query($sql);
			$rst2 = $r->result_array();
			$result[$k]['pc']['mem_id_cnt'] = count($rst2);

			// 모바일
			$sql = "select sum(a.cor_total_money) as cor_total_money_sum, count(a.cor_id) as cor_id_cnt, sum(b.cod_count) as cod_count_sum from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' and (a.cor_useragent like '%iphone%' or a.cor_useragent like '%android%' or a.cor_useragent like '%linux%') ".$sWhere;
			$r = $this->db->query($sql);
			$rst3 = $r->row_array();
			$result[$k]['mo']['cor_total_money_sum'] = $rst3['cor_total_money_sum'];
			$result[$k]['mo']['cor_id_cnt'] = $rst3['cor_id_cnt'];
			$result[$k]['mo']['cod_count_sum'] = $rst3['cod_count_sum'];

			$sql = "select count(a.mem_id) as mem_id_cnt from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' and (a.cor_useragent like '%iphone%' or a.cor_useragent like '%android%' or a.cor_useragent like '%linux%') ".$sWhere." group by a.mem_id";
			$r = $this->db->query($sql);
			$rst3 = $r->result_array();
			$result[$k]['mo']['mem_id_cnt'] = count($rst3);

			// 태블릿
			$sql = "select sum(a.cor_total_money) as cor_total_money_sum, count(a.cor_id) as cor_id_cnt, sum(b.cod_count) as cod_count_sum from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' and (a.cor_useragent like '%ipad%' or (a.cor_useragent not like '%windows%' and a.cor_useragent not like '%maxintosh%' 
			and a.cor_useragent not like '%iphone%' and a.cor_useragent not like '%android%' and a.cor_useragent not like '%linux%')) ".$sWhere;
			$r = $this->db->query($sql);
			$rst4 = $r->row_array();
			$result[$k]['tb']['cor_total_money_sum'] = $rst4['cor_total_money_sum'];
			$result[$k]['tb']['cor_id_cnt'] = $rst4['cor_id_cnt'];
			$result[$k]['tb']['cod_count_sum'] = $rst4['cod_count_sum'];

			$sql = "select count(a.mem_id) as mem_id_cnt from cb_cmall_order as a 
			left join cb_cmall_order_detail as b on b.cor_id = a.cor_id 
			left join cb_member as c on c.mem_id = a.mem_id 
			left join cb_cmall_category_rel as d on d.cit_id = b.cit_id 
			left join cb_cmall_category as e on e.cca_id = d.cca_id 
			where a.status != 'cancel' and a.status = b.cod_status and a.cor_datetime like '".$v['cor_datetime']."%' and (a.cor_useragent like '%ipad%' or (a.cor_useragent not like '%windows%' and a.cor_useragent not like '%maxintosh%' 
			and a.cor_useragent not like '%iphone%' and a.cor_useragent not like '%android%' and a.cor_useragent not like '%linux%')) ".$sWhere." group by a.mem_id";
			$r = $this->db->query($sql);
			$rst4 = $r->result_array();
			$result[$k]['tb']['mem_id_cnt'] = count($rst4);
		}

		$view['view']['list']['board'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		if ($export === 'excel') {

			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=시간대별학습현황_' . cdate('Y_m_d') . '.xls');
			echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir . '/order_excel', $view, true);

		} else {
			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'order');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}
	}
}