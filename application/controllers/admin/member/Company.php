<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CB_Controller
{

    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'member/company';

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Company_info', 'Company_deposit');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Company_info_model';

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'chkstring');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('pagination', 'querystring'));
    }

    /**
     * 목록을 가져오는 메소드입니다
     */
    public function index()
    {
        // 기업 활성화, 비활성화 적용
        $post = $this->input->post();
        if($post['chk'] && $post['chgstate']){
            $date = date('Y-m-d H:i:s');
            foreach($post['chk'] as $k => $v){
                $sql = "update cb_company_info set state = '".$post['chgstate']."', com_stateDt = '".$date."' where company_idx = ".$v;
                $this->db->query($sql);
                
                if($post['chgstate'] == 'unuse'){
                    $sql = "update cb_member set mem_useYn = 'n', mem_useDt = '".$date."' where company_idx = ".$v;
                    $this->db->query($sql);
                }
            }
        }

        // 리스트
        $view = array();
        $view['view'] = array();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        $view['view']['sort'] = array(
            'company_name' => $param->sort('company_name', 'asc'),
            'state' => $param->sort('state', 'asc'),
            'reg_date' => $param->sort('reg_date', 'desc'),
        );
        $findex = $this->input->get('findex', null, '');
        $forder = $this->input->get('forder', null, '');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        $this->{$this->modelname}->allow_search_field = array('company_name', 'company_code', 'company_num', 'company_tel', 'company_mail'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array('company_code', 'state'); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('company_name', 'state', 'reg_date'); // 정렬이 가능한 필드

        $sql = "select plan_idx, plan_name from cb_plan";
		$r = $this->db->query($sql);
		$view['view']['search']['plan'] = $r->result_array();
        foreach($view['view']['search']['plan'] as $k => $v){
			if(in_array($v['plan_idx'], $this->input->get('plan'))){
				$view['view']['search']['plan'][$k]['checked'] = 'checked';
			} else {
				$view['view']['search']['plan'][$k]['checked'] = '';
			}
		}

        $view['view']['search']['company_name'] = $this->input->get('company_name', null, '');
        $view['view']['search']['use_sday_1'] = $this->input->get('use_sday_1', null, '');
        $view['view']['search']['use_sday_2'] = $this->input->get('use_sday_2', null, '');
        $view['view']['search']['use_eday_1'] = $this->input->get('use_eday_1', null, '');
        $view['view']['search']['use_eday_2'] = $this->input->get('use_eday_2', null, '');
        $view['view']['search']['state'] = $this->input->get('state', null, '');

        $where = " WHERE 1 ";

        if($this->input->get('plan')){
			$plan = implode(',',$this->input->get('plan'));
			$where .= " AND a.plan_idx in (".$plan.") ";
		}
       
        if($this->input->get('company_name')){
            $where .= " AND a.company_name LIKE '%".$this->input->get('company_name')."%' ";
        }

        if($this->input->get('use_sday_1') && $this->input->get('use_sday_2')){
            $where .= " AND a.use_sday >= '".$this->input->get('use_sday_1')."' AND a.use_sday <= '".$this->input->get('use_sday_2')."' ";
        }

        if($this->input->get('use_eday_1') && $this->input->get('use_eday_2')){
            $where .= " AND a.use_eday >= '".$this->input->get('use_eday_1')."' AND a.use_eday <= '".$this->input->get('use_eday_2')."' ";
        }

        if($this->input->get('state')){
            $where .= " AND a.state = 'use' ";
        }

        if($this->input->post('sort')){
            $orderBy = " ORDER BY ".$this->input->post('sort');
        } else {
            $orderBy = " ORDER BY a.reg_date DESC ";
        }

        $view['view']['search']['sort'] = $this->input->post('sort');
 
        $sql = "SELECT a.company_idx, a.company_name, a.company_code, a.use_sday, a.use_eday, a.use_cnt, a.reg_date, a.state, a.company_deposit, a.plan_type, b.plan_name 
        FROM cb_company_info AS a LEFT JOIN cb_plan AS b ON b.plan_idx = a.plan_idx ".$where.$orderBy;
        $qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

        $sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        $list_num = $total_rows - ($page - 1) * $per_page;
        foreach($result as $k => $v){
            $result[$k]['num'] = $list_num--;
        }

        $view['view']['list']['board'] = $result;

        //var_dump($view['view']['list']['board']);
 
        $view['view']['state_str'] = array('use'=>'활성화','unuse'=>'비활성화');

        $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

        $config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
        $config['total_rows'] = $view['view']['data']['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        $view['view']['listall_url'] = admin_url($this->pagedir);
        $view['view']['write_url'] = admin_url($this->pagedir . '/write');
        $view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

        $layoutconfig = array('layout' => 'layout', 'skin' => 'index');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));

    }

    public function write($pid = 0)
    {
        $view = array();
        $view['view'] = array();

        $primary_key = $this->{$this->modelname}->primary_key;
        $view['view']['primary_key'] = $primary_key;

        $getdata = array();

        $view['view']['plan_list'] = $this->{$this->modelname}->get_plan_list();
		//템플릿 리스트 추가
		$q = "select tp_sno, cate_sno, tp_nm, tp_nm_ko from cb_asset_template where cate_sno in ('1','6','9','10')";
		$r = $this->db->query($q);
		$tp_list = $r->result_array();
		
		foreach ($tp_list as $v) {
			if($v['cate_sno'] == '1'){
				$view['view']['inner_list'][] = $v;
			}else if($v['cate_sno'] == '6'){
				$view['view']['outer_list'][] = $v;
			}else if($v['cate_sno'] == '9'){
				$view['view']['office_list'][] = $v;
			}else if($v['cate_sno'] == '10'){
				$view['view']['class_list'][] = $v;
			}
		}

        $getdata['use_sday'] = date('Y-m-d');
        $getdata['use_eday'] = date('Y-m-d');
        $getdata['code_chk'] = '';
        $getdata['state'] = 'use';
        $getdata['plan_idx'] = $view['view']['plan_list'][0]['plan_idx'];
        $getdata['mem_use_cnt'] = 0;

        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'write');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function modify($pid = 0)
    {
        $view = array();
        $view['view'] = array();

        $primary_key = $this->{$this->modelname}->primary_key;
        $view['view']['primary_key'] = $primary_key;

        $getdata = array();

        $view['view']['plan_list'] = $this->{$this->modelname}->get_plan_list();
		//템플릿 리스트 추가
		$q = "select tp_sno, cate_sno, tp_nm, tp_nm_ko from cb_asset_template where cate_sno in ('1','6','9','10')";
		$r = $this->db->query($q);
		$tp_list = $r->result_array();
		
		foreach ($tp_list as $v) {
			if($v['cate_sno'] == '1'){
				$view['view']['inner_list'][] = $v;
			}else if($v['cate_sno'] == '6'){
				$view['view']['outer_list'][] = $v;
			}else if($v['cate_sno'] == '9'){
				$view['view']['office_list'][] = $v;
			}else if($v['cate_sno'] == '10'){
				$view['view']['class_list'][] = $v;
			}
		}

        $getdata = $this->{$this->modelname}->get_one($pid);
        $getdata['code_chk'] = 1;

        // 현재이용인원
        $sql = "select count(mem_id) as cnt from cb_member where company_idx = ".$pid." and mem_useYn = 'y'";
        $r = $this->db->query($sql);
        $rowdata = $r->row_array();
        if(!$rowdata['cnt'] || $rowdata['cnt'] < 1){
            $getdata['mem_use_cnt'] = 0;
        } else {
            $getdata['mem_use_cnt'] = $rowdata['cnt'];
        }

        // 조직구성정보
        $sql = "select oc_id, oc_name, oc_parent from cb_company_organ where company_idx = ".$pid." order by cco_id asc";
        $r = $this->db->query($sql);
        $rst = $r->result_array();
        $getdata['organ'] = $rst;

        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'modify');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function deposit($pid = 0)
    {
        $view = array();
        $view['view'] = array();

        /**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

        $per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

        $where['company_idx'] = $view['view']['company_idx'] = $pid;
		if($this->input->get('type') == 1 ){
            $where["ccd_deposit > "] = 0;
		}else if($this->input->get('type') == 2 ){
			$where["ccd_deposit < "] = 0;
		}

        $result = $this->Company_deposit_model
			->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

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
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array(
			'layout' => 'layout', 
			'skin' => 'deposit',
			'page_title' => '예치금사용내역',
			'page_name' => '예치금사용내역'
		);
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['layout']['menu_title'] = "예치금사용내역";

		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

    public function save()
    {
        $in_post = $this->input->post();
        $idx = $in_post['company_idx'];

        unset($in_post['company_idx']);

        $this->load->library('upload');

        if (isset($_FILES) && isset($_FILES['company_logo_file']) && isset($_FILES['company_logo_file']['name']) && $_FILES['company_logo_file']['name'])
        {
            $upload_path = config_item('uploads_dir') . '/company_logo/';
            $upload_path = upload_mkdir($upload_path);

            $uploadconfig = array();
            $uploadconfig['upload_path'] = $upload_path;
            $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);

            if ($this->upload->do_upload('company_logo_file')) {
                $img = $this->upload->data();
                $updatephoto = "/".$upload_path.element('file_name', $img);
                $in_post['company_logo'] = $updatephoto;
            } else {
                $file_error = $this->upload->display_errors();
            }
        }

        for($i = 1; $i <= 10; $i++){
            if($in_post['manage_name_'.$i] == '' || !$in_post['manage_name_'.$i]){
                $in_post['manage_name_'.$i] = NULL;
            }

            if($in_post['manage_div_'.$i] == '' || !$in_post['manage_div_'.$i]){
                $in_post['manage_div_'.$i] = NULL;
            }

            if($in_post['manage_email_'.$i] == '' || !$in_post['manage_email_'.$i]){
                $in_post['manage_email_'.$i] = NULL;
            }

            if($in_post['manage_tel_'.$i] == '' || !$in_post['manage_tel_'.$i]){
                $in_post['manage_tel_'.$i] = NULL;
            }
        }

        if($in_post['state'] == 'unuse'){
            $com_stateDt = date('Y-m-d H:i:s');
        } else {
            $com_stateDt = NULL;
        }
        
        // 기업정보 insert
        $param = array(
            'company_name' => $in_post['company_name'],
            'company_code' => $in_post['company_code'],
            'company_logo' => $in_post['company_logo'],
            'template_inner' => $in_post['template_inner'],
            'template_outer' => $in_post['template_outer'],
            'template_office' => $in_post['template_office'],
            'template_class' => $in_post['template_class'],
            'plan_idx' => $in_post['plan_idx'],
            'plan_type' => $in_post['plan_type'],
            'use_sday' => $in_post['use_sday'],
            'use_eday' => $in_post['use_eday'],
            'use_cnt' => $in_post['use_cnt'],
            'company_num' => $in_post['company_num'],
            'company_type' => $in_post['company_type'],
            'company_uptae' => $in_post['company_uptae'],
            'company_addr' => $in_post['company_addr'],
            'company_tel' => $in_post['company_tel'],
            'company_mail' => $in_post['company_mail'],
            'state' => $in_post['state'],
            'com_stateDt' => $com_stateDt,
            'reg_date' => date('Y-m-d H:i:s'),
            'company_deposit' => $in_post['company_deposit'],
            'manage_name_1' => $in_post['manage_name_1'],
            'manage_div_1' => $in_post['manage_div_1'],
            'manage_email_1' => $in_post['manage_email_1'],
            'manage_tel_1' => $in_post['manage_tel_1'],
            'manage_name_2' => $in_post['manage_name_2'],
            'manage_div_2' => $in_post['manage_div_2'],
            'manage_email_2' => $in_post['manage_email_2'],
            'manage_tel_2' => $in_post['manage_tel_2'],
            'manage_name_3' => $in_post['manage_name_3'],
            'manage_div_3' => $in_post['manage_div_3'],
            'manage_email_3' => $in_post['manage_email_3'],
            'manage_tel_3' => $in_post['manage_tel_3'],
            'manage_name_4' => $in_post['manage_name_4'],
            'manage_div_4' => $in_post['manage_div_4'],
            'manage_email_4' => $in_post['manage_email_4'],
            'manage_tel_4' => $in_post['manage_tel_4'],
            'manage_name_5' => $in_post['manage_name_5'],
            'manage_div_5' => $in_post['manage_div_5'],
            'manage_email_5' => $in_post['manage_email_5'],
            'manage_tel_5' => $in_post['manage_tel_5'],
            'manage_name_6' => $in_post['manage_name_6'],
            'manage_div_6' => $in_post['manage_div_6'],
            'manage_email_6' => $in_post['manage_email_6'],
            'manage_tel_6' => $in_post['manage_tel_6'],
            'manage_name_7' => $in_post['manage_name_7'],
            'manage_div_7' => $in_post['manage_div_7'],
            'manage_email_7' => $in_post['manage_email_7'],
            'manage_tel_7' => $in_post['manage_tel_7'],
            'manage_name_8' => $in_post['manage_name_8'],
            'manage_div_8' => $in_post['manage_div_8'],
            'manage_email_8' => $in_post['manage_email_8'],
            'manage_tel_8' => $in_post['manage_tel_8'],
            'manage_name_9' => $in_post['manage_name_9'],
            'manage_div_9' => $in_post['manage_div_9'],
            'manage_email_9' => $in_post['manage_email_9'],
            'manage_tel_9' => $in_post['manage_tel_9'],
            'manage_name_10' => $in_post['manage_name_10'],
            'manage_div_10' => $in_post['manage_div_10'],
            'manage_email_10' => $in_post['manage_email_10'],
            'manage_tel_10' => $in_post['manage_tel_10'],
        );
        $this->db->insert('cb_company_info', $param);
        $idx = $this->db->insert_id();

        if($in_post['chart_data']){
            // 조직도 추가
            $chart_data = json_decode($in_post['chart_data'], true);
            foreach($chart_data as $k => $v){
                $oc_param = array(
                    'company_idx' => $idx,
                    'oc_id' => $v['id'],
                    'oc_name' => $v['name'],
                    'oc_parent' => $v['parent'],
                );
                $this->db->insert('cb_company_organ', $oc_param);
            }
        }

        if($in_post['company_deposit'] > 0){
            $this->load->helper('cmall_helper');
            
            $now = date("Y-m-d H:i:s");

            $insertdata["company_idx"] = $idx;
            $insertdata["mem_id"] = $this->session->userdata['mem_id'];
            $insertdata["ccd_datetime"] = $now;
            $insertdata["ccd_content"] = "관리자(admin) 기업 등록";
            $insertdata["ccd_deposit"] = $in_post['company_deposit'];
            $insertdata["ccd_type"] = "admin";
            $insertdata["ccd_action"] = "관리자가 어드민";
            $insertdata["ccd_now_deposit"] = $in_post['company_deposit'];

            $this->Company_deposit_model->insert($insertdata);
        }

        $this->session->set_flashdata(
            'message',
            '기업이 등록되었습니다'
        );

        $param =& $this->querystring;
        $redirecturl = admin_url($this->pagedir . '?' . $param->output());

        redirect($redirecturl);
    }

    public function update()
    {
        $in_post = $this->input->post();
        $idx = $in_post['company_idx'];
        $mode = $in_post['mode'];

        // 기업정보 업데이트
        if($mode == 'update1'){
            $this->load->library('upload');

            if (isset($_FILES) && isset($_FILES['company_logo_file']) && isset($_FILES['company_logo_file']['name']) && $_FILES['company_logo_file']['name'])
            {
                $upload_path = config_item('uploads_dir') . '/company_logo/';
                $upload_path = upload_mkdir($upload_path);

                $uploadconfig = array();
                $uploadconfig['upload_path'] = $upload_path;
                $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                $uploadconfig['encrypt_name'] = true;

                $this->upload->initialize($uploadconfig);

                if ($this->upload->do_upload('company_logo_file')) {
                    $img = $this->upload->data();
                    $updatephoto = "/".$upload_path.element('file_name', $img);
                    $in_post['company_logo'] = $updatephoto;
                } else {
                    $file_error = $this->upload->display_errors();
                }
            }

            $param = array(
                'company_logo' => $in_post['company_logo'],
                'company_num' => $in_post['company_num'],
                'company_type' => $in_post['company_type'],
                'company_uptae' => $in_post['company_uptae'],
                'company_addr' => $in_post['company_addr'],
                'company_tel' => $in_post['company_tel'],
                'company_mail' => $in_post['company_mail'],
            );
            $param_where = array(
                'company_idx'      => $idx,
            );
            $this->db->update('cb_company_info', $param, $param_where);

            $this->session->set_flashdata(
                'message1',
                '정보가 수정되었습니다.'
            );

            $param =& $this->querystring;
            $redirecturl = admin_url($this->pagedir . '/modify/'.$idx.'?' . $param->output());

            redirect($redirecturl);
        }

        // 결제정보 업데이트
        else if($mode == 'update2'){
            if($in_post['state'] == 'unuse'){
                $com_stateDt = date('Y-m-d H:i:s');
            } else {
                $com_stateDt = NULL;
            }
            $param = array(
                'plan_idx' => $in_post['plan_idx'],
                'plan_type' => $in_post['plan_type'],
                'use_sday' => $in_post['use_sday'],
                'use_eday' => $in_post['use_eday'],
                'use_cnt' => $in_post['use_cnt'],
                'state' => $in_post['state'],
                'com_stateDt' => $com_stateDt,
            );
            $param_where = array(
                'company_idx'      => $idx,
            );
            $this->db->update('cb_company_info', $param, $param_where);

            // 기업 비활성화시 회원 비활성화 적용
            if($in_post['state'] == 'unuse'){
                $date = date('Y-m-d H:i:s');
                $sql = "update cb_member set mem_useYn = 'n', mem_useDt = '".$date."' where company_idx = ".$idx;
                $this->db->query($sql);
            }

            $this->session->set_flashdata(
                'message2',
                '정보가 수정되었습니다.'
            );

            $param =& $this->querystring;
            $redirecturl = admin_url($this->pagedir . '/modify/'.$idx.'?' . $param->output());

            redirect($redirecturl);
        }

        // 서비스정보 업데이트
        else if($mode == 'update3'){
            // 예치금 내역 저장
            $sql = "SELECT company_deposit FROM cb_company_info WHERE company_idx = ".$idx;
            $r = $this->db->query($sql);
            $rst = $r->row_array();
            $company_deposit = $rst['company_deposit'];
            if($company_deposit != $in_post['company_deposit']){
                
                $now = date("Y-m-d H:i:s");

                $insertdata = array();
    
                $insertdata["company_idx"] = $idx;
                $insertdata["mem_id"] = $this->session->userdata['mem_id'];
                $insertdata["ccd_datetime"] = $now;
                $insertdata["ccd_content"] = "관리자(admin) 기업 수정";
                $insertdata["ccd_deposit"] = $in_post['company_deposit'] - $company_deposit;
                $insertdata["ccd_type"] = "admin";
                $insertdata["ccd_action"] = "관리자가 어드민";
                $insertdata["ccd_now_deposit"] = $in_post['company_deposit'];

                $sql = "INSERT INTO cb_company_deposit 
                        SET company_idx = ".$insertdata["company_idx"].", 
                            mem_id = ".$insertdata["mem_id"].", 
                            ccd_datetime = '".$insertdata["ccd_datetime"]."', 
                            ccd_content = '".$insertdata["ccd_content"]."', 
                            ccd_deposit = '".$insertdata["ccd_deposit"]."', 
                            ccd_type = '".$insertdata["ccd_type"]."', 
                            ccd_related_id = NULL, 
                            ccd_action = '".$insertdata["ccd_action"]."', 
                            ccd_now_deposit = '".$insertdata["ccd_now_deposit"]."'
                        ";
                $this->db->query($sql);
            }

            $param = array(
                'template_inner' => $in_post['template_inner'],
                'template_outer' => $in_post['template_outer'],
                'template_office' => $in_post['template_office'],
                'template_class' => $in_post['template_class'],
                'company_deposit' => $in_post['company_deposit'],
            );
            $param_where = array(
                'company_idx'      => $idx,
            );
            $this->db->update('cb_company_info', $param, $param_where);

            $this->session->set_flashdata(
                'message3',
                '정보가 수정되었습니다.'
            );

            $param =& $this->querystring;
            $redirecturl = admin_url($this->pagedir . '/modify/'.$idx.'?' . $param->output());

            redirect($redirecturl);
        }

        // 담당자정보 업데이트
        else if($mode == 'update4'){
            for($i = 1; $i <= 10; $i++){
                if($in_post['manage_name_'.$i] == '' || !$in_post['manage_name_'.$i]){
                    $in_post['manage_name_'.$i] = NULL;
                }
    
                if($in_post['manage_div_'.$i] == '' || !$in_post['manage_div_'.$i]){
                    $in_post['manage_div_'.$i] = NULL;
                }
    
                if($in_post['manage_email_'.$i] == '' || !$in_post['manage_email_'.$i]){
                    $in_post['manage_email_'.$i] = NULL;
                }
    
                if($in_post['manage_tel_'.$i] == '' || !$in_post['manage_tel_'.$i]){
                    $in_post['manage_tel_'.$i] = NULL;
                }
            }

            $param = array(
                'manage_name_1' => $in_post['manage_name_1'],
                'manage_div_1' => $in_post['manage_div_1'],
                'manage_email_1' => $in_post['manage_email_1'],
                'manage_tel_1' => $in_post['manage_tel_1'],
                'manage_name_2' => $in_post['manage_name_2'],
                'manage_div_2' => $in_post['manage_div_2'],
                'manage_email_2' => $in_post['manage_email_2'],
                'manage_tel_2' => $in_post['manage_tel_2'],
                'manage_name_3' => $in_post['manage_name_3'],
                'manage_div_3' => $in_post['manage_div_3'],
                'manage_email_3' => $in_post['manage_email_3'],
                'manage_tel_3' => $in_post['manage_tel_3'],
                'manage_name_4' => $in_post['manage_name_4'],
                'manage_div_4' => $in_post['manage_div_4'],
                'manage_email_4' => $in_post['manage_email_4'],
                'manage_tel_4' => $in_post['manage_tel_4'],
                'manage_name_5' => $in_post['manage_name_5'],
                'manage_div_5' => $in_post['manage_div_5'],
                'manage_email_5' => $in_post['manage_email_5'],
                'manage_tel_5' => $in_post['manage_tel_5'],
                'manage_name_6' => $in_post['manage_name_6'],
                'manage_div_6' => $in_post['manage_div_6'],
                'manage_email_6' => $in_post['manage_email_6'],
                'manage_tel_6' => $in_post['manage_tel_6'],
                'manage_name_7' => $in_post['manage_name_7'],
                'manage_div_7' => $in_post['manage_div_7'],
                'manage_email_7' => $in_post['manage_email_7'],
                'manage_tel_7' => $in_post['manage_tel_7'],
                'manage_name_8' => $in_post['manage_name_8'],
                'manage_div_8' => $in_post['manage_div_8'],
                'manage_email_8' => $in_post['manage_email_8'],
                'manage_tel_8' => $in_post['manage_tel_8'],
                'manage_name_9' => $in_post['manage_name_9'],
                'manage_div_9' => $in_post['manage_div_9'],
                'manage_email_9' => $in_post['manage_email_9'],
                'manage_tel_9' => $in_post['manage_tel_9'],
                'manage_name_10' => $in_post['manage_name_10'],
                'manage_div_10' => $in_post['manage_div_10'],
                'manage_email_10' => $in_post['manage_email_10'],
                'manage_tel_10' => $in_post['manage_tel_10'],
            );
            $param_where = array(
                'company_idx'      => $idx,
            );
            $this->db->update('cb_company_info', $param, $param_where);

            $this->session->set_flashdata(
                'message4',
                '정보가 수정되었습니다.'
            );

            $param =& $this->querystring;
            $redirecturl = admin_url($this->pagedir . '/modify/'.$idx.'?' . $param->output());

            redirect($redirecturl);
        }

        // 조직정보 업데이트
        else if($mode == 'update5'){
            if($in_post['chart_data']){
                // 조직도 초기화
                $del_where = array(
                    'company_idx' => $idx,
                );
                $this->db->delete("cb_company_organ", $del_where); 
    
                // 조직도 추가
                $chart_data = json_decode($in_post['chart_data'], true);
                foreach($chart_data as $k => $v){
                    $oc_param = array(
                        'company_idx' => $idx,
                        'oc_id' => $v['id'],
                        'oc_name' => $v['name'],
                        'oc_parent' => $v['parent'],
                    );
                    $this->db->insert('cb_company_organ', $oc_param);
                }

                $this->session->set_flashdata(
                    'message5',
                    '정보가 수정되었습니다.'
                );

                $param =& $this->querystring;
                $redirecturl = admin_url($this->pagedir . '/modify/'.$idx.'?' . $param->output());

                redirect($redirecturl);
            }
        }
    }

    public function chk_code()
    {
        $in_get = $this->input->get();
        if($in_get['code'] != '')
        {
            $rs = $this->{$this->modelname}->get_company_code($company_code);

            echo $rs['cnt'];
        } else echo 1;
    }
}
