<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Members class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>운영관리>기업관리 controller 입니다.
 */
class Company extends CB_Controller
{
    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'cinfo/company';

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
     * 기업수정페이지를 가져오는 메소드입니다
     */
    public function index()
    {
        $pid = $this->member->item('company_idx');

        $view = array();
        $view['view'] = array();

        $primary_key = $this->{$this->modelname}->primary_key;
        $view['view']['primary_key'] = $primary_key;

        $getdata = array();

        //$view['view']['plan_list'] = $this->{$this->modelname}->get_plan_list();
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

        // 플랜정보
        $sql = "select plan_name from cb_plan where plan_idx = ".$getdata['plan_idx'];
        $r = $this->db->query($sql);
        $rowdata = $r->row_array();
        $getdata['plan_name'] = $rowdata['plan_name'];

        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'index');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
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
            $redirecturl = '/admin/cinfo/company';

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
            $redirecturl = '/admin/cinfo/company';

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
                'template_office' => $in_post['template_office'],
                'template_class' => $in_post['template_class'],
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
            $redirecturl = '/admin/cinfo/company';

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
            $redirecturl = '/admin/cinfo/company';

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
                $redirecturl = '/admin/cinfo/company';

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
}