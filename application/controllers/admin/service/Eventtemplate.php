<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventtemplate extends CB_Controller
{
    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'service/eventtemplate';

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
    protected $helpers = array('form', 'array', 'chkstring', 'dhtml_editor');

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
        // 이벤트 삭제, 노출, 미노출
        $post = $this->input->post();
        //var_dump($post);
        if($post['chk'] && $post['chgstate']){
            $date = date('Y-m-d H:i:s');
            foreach($post['chk'] as $k => $v){
                $v = (int) $v;
                if($post['chgstate'] == 'd'){
                    $sql = "update cb_event_company set event_showFl = 'n' where template_idx = ".$v;
                    $this->db->query($sql);

                    $sql = "delete from cb_event_template where template_idx = ".$v;
                    $this->db->query($sql);
                } else if($post['chgstate'] == 'y'){
                    $sql = "update cb_event_template set template_showFl = 'y' where template_idx = ".$v;
                    $this->db->query($sql);
                } else if($post['chgstate'] == 'n'){
                    $sql = "update cb_event_company set event_showFl = 'n' where template_idx = ".$v;
                    $this->db->query($sql);

                    $sql = "update cb_event_template set template_showFl = 'n' where template_idx = ".$v;
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
            'template_name' => $param->sort('a.template_name', 'asc'),
            'template_regDt' => $param->sort('a.template_regDt', 'desc'),
            'template_count' => $param->sort('template_count', 'desc'),
        );
        $findex = $this->input->get('findex', null, '');
        $forder = $this->input->get('forder', null, '');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        $this->{$this->modelname}->allow_search_field = array('template_name'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('template_name', 'template_regDt', 'template_count'); // 정렬이 가능한 필드

        $view['view']['search']['template_name'] = $this->input->get('template_name', null, '');

        $where = " WHERE 1 ";
       
        if($this->input->get('template_name')){
            $where .= " AND a.template_name LIKE '%".$this->input->get('template_name')."%' ";
        }

        if($this->input->post('sort')){
            $orderBy = " ORDER BY ".$this->input->post('sort');
        } else {
            $orderBy = " ORDER BY a.template_regDt DESC ";
        }

        $view['view']['search']['sort'] = $this->input->post('sort');
 
        $sql = "SELECT a.*, count(CASE WHEN b.event_showFl = 'y' or b.event_showFl = 'n' THEN b.template_idx ELSE NULL END) AS template_count FROM cb_event_template AS a left join cb_event_company AS b on b.template_idx = a.template_idx ".$where." GROUP BY a.template_idx ".$orderBy;
        $qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

        $sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        $list_num = $total_rows - ($page - 1) * $per_page;
        foreach($result as $k => $v){
            $result[$k]['num'] = $list_num--;
            if($v['template_showFl'] == 'n'){
                $result[$k]['template_showFl'] = '미노출';
            } else if($v['template_showFl'] == 'y'){
                $result[$k]['template_showFl'] = '노출';
            } else if($v['template_showFl'] == 's'){
                $result[$k]['template_showFl'] = '특정기업 노출';
            }
            $result[$k]['template_regDt'] = date('Y-m-d', strtotime($v['template_regDt']));
        }

        $view['view']['data']['list'] = $result;

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

    public function counts($pid = 0)
    {
        if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}

        // 리스트
        $view = array();
        $view['view'] = array();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;
 
        $sql = "select a.*, b.template_name, c.company_name from cb_event_company as a 
        left join cb_event_template as b on b.template_idx = a.template_idx 
        left join cb_company_info as c on c.company_idx = a.company_idx where a.template_idx = ".$pid;
        $qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

        $sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        $list_num = $total_rows - ($page - 1) * $per_page;
        foreach($result as $k => $v){
            $template_name = $v['template_name'];
            $result[$k]['num'] = $list_num--;
            $result[$k]['event_startDt'] = date('Y-m-d', strtotime($v['event_startDt']));
            $result[$k]['event_endDt'] = date('Y-m-d', strtotime($v['event_endDt']));

            $sql = "select count(mem_id) as event_member_count from cb_member where event_idx = ".$v['event_idx']." and company_idx = ".$v['company_idx'];
            $q = $this->db->query($sql);
            $r = $q->row_array();
            $result[$k]['event_member_count'] = $r['event_member_count'];
        }

        $view['view']['data']['list'] = $result;

        //var_dump($view['view']['list']['board']);
 
        $view['view']['state_str'] = array('use'=>'활성화','unuse'=>'비활성화');

        $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

        $config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
        $config['total_rows'] = $view['view']['data']['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        $layoutconfig = array('layout' => 'layout_popup', 'skin' => 'counts');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['layout']['menu_title'] = $template_name." 템플릿 사용 목록";
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function event_info($pid = 0)
    {
        if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}

        // 리스트
        $view = array();
        $view['view'] = array();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

        $per_page = 5;
        $offset = ($page - 1) * $per_page;

        $sql = "select a.*, b.company_name, c.template_name from cb_event_company as a 
        left join cb_company_info as b on b.company_idx = a.company_idx 
        left join cb_event_template as c on c.template_idx = a.template_idx where a.event_idx = ".$pid;
        $qry = $this->db->query($sql);
        $rst = $qry->row_array();
        $view['view']['data']['basic'] = $rst;
        
        if($rst['event_showFl'] == 'y'){
            $view['view']['data']['basic']['event_showFl'] = '활성화';
        } else {
            $view['view']['data']['basic']['event_showFl'] = '비활성화';
        }
        $event_name = $rst['event_name'];

        $sql = "select mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email from cb_member where company_idx = '".$rst['company_idx']."' and FIND_IN_SET(".$pid.", event_idx)";
        $qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

        $sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        $list_num = $total_rows - ($page - 1) * $per_page;
        foreach($result as $k => $v){
            $result[$k]['num'] = $list_num--;
            if(!$v['mem_username']){
                $result[$k]['mem_username'] = $v['mem_nickname'];
            } 
        }

        $view['view']['data']['list'] = $result;

        //var_dump($view['view']['list']['board']);
 
        $view['view']['state_str'] = array('use'=>'활성화','unuse'=>'비활성화');

        $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

        $config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
        $config['total_rows'] = $view['view']['data']['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        $layoutconfig = array('layout' => 'layout_popup', 'skin' => 'event_info');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['layout']['menu_title'] = $event_name." 이벤트 정보";
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function write()
    {
        $view = array();
        $view['view'] = array();

        $getdata = array();

        // 템플릿 불러오기
        $q = "select template_idx, template_name from cb_event_template";
        $r = $this->db->query($q);
        $tpl_list = $r->result_array();

        $view['view']['tpl_list'] = $tpl_list;

        // 기업명 불러오기
        $q = "select company_idx, company_name from cb_company_info where state = 'use'";
        $r = $this->db->query($q);
        $com_list = $r->result_array();
        $view['view']['com_list'] = $com_list;
		

        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'write');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['layout']['menu_title'] = " 이벤트 템플릿 추가";
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function modify($pid = 0)
    {
        if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}

        $view = array();
        $view['view'] = array();

        // 템플릿 불러오기
        $q = "select template_idx, template_name from cb_event_template";
        $r = $this->db->query($q);
        $tpl_list = $r->result_array();

        $view['view']['tpl_list'] = $tpl_list;

        // 기업명 불러오기
        $q = "select company_idx, company_name from cb_company_info where state = 'use'";
        $r = $this->db->query($q);
        $com_list = $r->result_array();
        $view['view']['com_list'] = $com_list;

        $sql = "select * from cb_event_template where template_idx = ".$pid;
        $qry = $this->db->query($sql);
        $result = $qry->row_array();		

        $view['view']['data'] = $result;
        if($result['template_show_company'] == 's'){
            $template_show_company_list = explode(',',$result['template_show_company']);
            foreach($template_show_company_list as $k => $v){
                $q = "select company_name from cb_company_info where company_idx = ".$v;
                $r = $this->db->query($q);
                $company_name = $r->row_array();
                $view['view']['data']['template_show_company_list'][$k]['company_idx'] = $v;
                $view['view']['data']['template_show_company_list'][$k]['company_name'] = $company_name['company_name'];
            }
        }
        
        $view['view']['data']['primary_key'] = $pid;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'modify');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['layout']['menu_title'] = " 이벤트 템플릿 정보/수정";
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function save()
    {
        $post = $this->input->post();
        
        $post['template_show_company'] = $post['selectedOptions'];
        
        if($post['mode'] == 'register'){
            if($post['template_showFl'] == 's'){
                $sql = "INSERT INTO cb_event_template SET 
                template_name = '".$post['template_name']."', 
                template_contents = '".$post['template_contents']."', 
                template_showFl = 's', 
                template_show_company = '".$post['template_show_company']."', 
                template_regDt = now()";
            } else {
                $sql = "INSERT INTO cb_event_template SET 
                template_name = '".$post['template_name']."', 
                template_contents = '".$post['template_contents']."', 
                template_showFl = '".$post['template_showFl']."', 
                template_regDt = now()";
            }
        } else {
            if($post['template_showFl'] == 's'){
                $sql = "UPDATE cb_event_template SET 
                template_name = '".$post['template_name']."', 
                template_contents = '".$post['template_contents']."', 
                template_showFl = 's', 
                template_show_company = '".$post['template_show_company']."' 
                where template_idx = ".$post['template_idx'];
            } else {
                $sql = "UPDATE cb_event_template SET 
                template_name = '".$post['template_name']."', 
                template_contents = '".$post['template_contents']."', 
                template_showFl = '".$post['template_showFl']."' 
                where template_idx = ".$post['template_idx'];
            }
        }
        
        $this->db->query($sql);

        $this->session->set_flashdata(
            'message',
            '템플릿이 정상적으로 등록되었습니다'
        );

        $redirecturl = '/admin/service/eventtemplate';
        redirect($redirecturl);
    }

    public function loadtemplate()
    {
        $post = $this->input->post();
        $q = "select template_name, template_contents, template_showFl, template_show_company from cb_event_template where template_idx = ".$post['template_idx'];
        $r = $this->db->query($q);
        $data = $r->row_array();
        if($data['template_show_company'] == 's'){
            $template_show_company_list = explode(',',$data['template_show_company']);
            $data['template_show_company_list'] = '';
            foreach($template_show_company_list as $k => $v){
                $q = "select company_name from cb_company_info where company_idx = ".$v;
                $r = $this->db->query($q);
                $company_name = $r->row_array();
                $data['template_show_company_list'] .= "<button type='button' class='btn' data-value='".$v."'>".$company_name['company_name']." X</button>";
            }
        }
        

        if($data){
            $result['code'] = 'ok';
            $result['data'] = $data;
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'data is not exist';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }
}