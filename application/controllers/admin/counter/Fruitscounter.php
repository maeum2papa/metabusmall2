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
 * 관리자>통계>열매통계 controller 입니다.
 */
class Fruitscounter extends CB_Controller
{
    /**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'counter/fruitscounter';

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
				$sWhere .= " and a.company_idx = ".$this->member->item('company_idx');
			}
		} 

		
		$sql = "select a.mem_id, a.mem_div, a.mem_username, a.mem_nickname, a.mem_cur_seed, a.mem_cur_fruit, a.mem_cur_fish, a.mem_cur_decoy, a.mem_cur_water, a.mem_cur_fertilizer, b.company_name 
		from cb_member as a 
		left join cb_company_info as b on b.company_idx = a.company_idx where 1".$sWhere;
		$qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

		$sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
		foreach($result as $k => $v){
			// 실명 없는 경우 닉네임으로 대체
			if($v['mem_username'] == ''){
				$result[$k]['mem_username'] = $v['mem_nickname'];
			}

			// 씨앗 심은량
			$q = "select count(*) as cnt from cb_game_field where mem_id = ".$v['mem_id'];
			$r = $this->db->query($q);
			$rowdata = $r->row_array();
			$result[$k]['mem_use_seed'] = $rowdata['cnt'];

			// 열매 사용량
			$q = "select sum(cor_cash) as sum from cb_cmall_order where mem_id = ".$v['mem_id']." and cor_pay_type = 'f' and status != 'cancel'";
			$r = $this->db->query($q);
			$rowdata = $r->row_array();
			if($rowdata['sum'] && empty($rowdata['sum']) === false){
				$result[$k]['mem_use_fruit'] = $rowdata['sum'];
			} else {
				$result[$k]['mem_use_fruit'] = 0;
			}

			// 물 사용량
			$q = "select count(*) as cnt from cb_object_log where log_memNo = ".$v['mem_id']." and log_txt like '%물을 사용하였습니다.%'";
			$r = $this->db->query($q);
			$rowdata = $r->row_array();
			$result[$k]['mem_use_water'] = $rowdata['cnt'];

			// 비료 사용량
			$q = "select count(*) as cnt from cb_object_log where log_memNo = ".$v['mem_id']." and log_txt like '%비료를 사용하였습니다.%'";
			$r = $this->db->query($q);
			$rowdata = $r->row_array();
			$result[$k]['mem_use_fertilizer'] = $rowdata['cnt'];

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
}