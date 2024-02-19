<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventtemplate extends CB_Controller
{
    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'servicing/eventtemplate';

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
            $date = date('Y-m-d');
            foreach($post['chk'] as $k => $v){
                $v = (int) $v;
                if($post['chgstate'] == 'y'){
                    $sql = "update cb_event_company set event_startDt = '".$date."', event_showFl = 'y' where event_idx = ".$v;
                    $this->db->query($sql);
                } else if($post['chgstate'] == 'n'){
                    $sql = "update cb_event_company set event_endDt = '".$date."', event_showFl = 'n' where event_idx = ".$v;
                    $this->db->query($sql);
                } else if($post['chgstate'] == 'd'){
                    $sql = "select event_showFl from cb_event_company where event_idx = ".$v;
                    $r = $this->db->query($sql);
                    $rst = $r->row_array();
                    if($rst['event_showFl'] == 'n'){
                        $sql = "delete from cb_event_company where event_idx = ".$v;
                        $this->db->query($sql);
                    } else {
                        $this->session->set_flashdata(
                            'message',
                            '활성화된 이벤트는 삭제가 불가능합니다'
                        );
                    }
                    
                }
            }
        }
        

        // 리스트
        $view = array();
        $view['view'] = array();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        $view['view']['sort'] = array(
            'event_name' => $param->sort('a.event_name', 'asc'),
            'event_regDt' => $param->sort('a.event_regDt', 'desc'),
            'close_endDt' => $param->sort('DATEDIFF(event_endDt, CURDATE())', ''),
            'count_member' => $param->sort('count_member', 'desc'),
        );
        $findex = $this->input->get('findex', null, '');
        $forder = $this->input->get('forder', null, '');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        $this->{$this->modelname}->allow_search_field = array('event_name'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('event_name', 'event_regDt', 'close_endDt', 'count_member'); // 정렬이 가능한 필드

        $view['view']['search']['event_name'] = $this->input->get('event_name', null, '');
        $view['view']['search']['event_startDt_1'] = $this->input->get('event_startDt_1', null, '');
        $view['view']['search']['event_startDt_2'] = $this->input->get('event_startDt_2', null, '');
        $view['view']['search']['event_endDt_1'] = $this->input->get('event_endDt_1', null, '');
        $view['view']['search']['event_endDt_2'] = $this->input->get('event_endDt_2', null, '');
        $view['view']['search']['event_showFl'] = $this->input->get('event_showFl', null, '');

        $where = " WHERE a.company_idx = '".$this->member->item('company_idx')."' ";
       
        if($this->input->get('event_name')){
            $where .= " AND a.event_name LIKE '%".$this->input->get('event_name')."%' ";
        }

        if($this->input->get('event_startDt_1') && $this->input->get('event_startDt_2')){
            $where .= " AND a.event_startDt >= '".$this->input->get('event_startDt_1')."' AND a.event_startDt <= '".$this->input->get('event_startDt_2')."' ";
        }

        if($this->input->get('event_endDt_1') && $this->input->get('event_endDt_2')){
            $where .= " AND a.event_endDt >= '".$this->input->get('event_endDt_1')."' AND a.event_endDt <= '".$this->input->get('event_endDt_2')."' ";
        }

        if($this->input->get('event_showFl')){
            $where .= " AND a.event_showFl = '".$this->input->get('event_showFl')."' ";
        }

        if($this->input->post('sort')){
            $orderBy = " ORDER BY ".$this->input->post('sort');
        } else {
            $orderBy = " ORDER BY a.event_regDt DESC ";
        }

        $view['view']['search']['sort'] = $this->input->post('sort');
 
        $sql = "SELECT a.*, COUNT(b.mem_id) AS count_member FROM cb_event_company AS a LEFT JOIN cb_member AS b ON b.company_idx = a.company_idx 
        AND FIND_IN_SET(a.event_idx, b.event_idx) ".$where." GROUP BY a.event_idx ".$orderBy;
        $qry = $this->db->query($sql);
		$total_result = $qry->result_array();
		$total_rows = count($total_result);

        $sql .= " limit ".$offset.", ".$per_page;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        $list_num = $total_rows - ($page - 1) * $per_page;
        foreach($result as $k => $v){
            $result[$k]['num'] = $list_num--;
            if($v['event_showFl'] == 'n'){
                $result[$k]['event_showFl'] = '비활성화';
            } else if($v['event_showFl'] == 'y'){
                $result[$k]['event_showFl'] = '활성화';
            } 
        }

        $view['view']['data']['list'] = $result;

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

        $view['view']['event_idx'] = $pid;

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

        $per_page = 5;
        $offset = ($page - 1) * $per_page;

        $sql = "select a.*, b.template_name from cb_event_company as a left join cb_event_template as b on b.template_idx = a.template_idx where a.event_idx = ".$pid;
        $qry = $this->db->query($sql);
        $rst = $qry->row_array();
        $view['view']['data']['basic'] = $rst;
        
        if($rst['event_showFl'] == 'y'){
            $view['view']['data']['basic']['event_showFl'] = '활성화';
        } else {
            $view['view']['data']['basic']['event_showFl'] = '비활성화';
        }
        $event_name = $rst['event_name'];

        $sql = "select mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email from cb_member where company_idx = '".$this->member->item('company_idx')."' and FIND_IN_SET(".$pid.", event_idx)";
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

    public function delete($pid = 0)
    {
        if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}

        $sql = "select event_showFl from cb_event_company where event_idx = ".$pid;
        $r = $this->db->query($sql);
        $rst = $r->row_array();
        if($rst['event_showFl'] == 'n'){
            $sql = "delete from cb_event_company where event_idx = ".$pid;
            $this->db->query($sql);
        } else {
            $this->session->set_flashdata(
                'message',
                '활성화된 이벤트는 삭제가 불가능합니다'
            );
        }

        $redirecturl = '/admin/servicing/eventtemplate';
        redirect($redirecturl);
    }

    public function add_member()
    {
        // 리스트
        $view = array();
        $view['view'] = array();

        $param =& $this->querystring;
        
        $where = "";

        if($this->input->get('mem_div')){
            $where .= " and mem_div like '%".$this->input->get('mem_div')."%' ";
        }

        if($this->input->get('mem_employ_1') && $this->input->get('mem_employ_2')){
            $where .= " and mem_employ >= '".$this->input->get('mem_employ_1')."' and mem_employ <= '".$this->input->get('mem_employ_2')."' ";
        }

        if($this->input->get('mem_birthday_1') && $this->input->get('mem_birthday_2')){
            $where .= " and mem_birthday >= '".$this->input->get('mem_birthday_1')."' and mem_birthday <= '".$this->input->get('mem_birthday_2')."' ";
        }

        if($this->input->get('mem_username')){
            $where .= " and (mem_username like '%".$this->input->get('mem_username')."%' or mem_nickname like '%".$this->input->get('mem_username')."%') ";
        }

        $sql = "select mem_id, mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email, mem_employ, mem_birthday, mem_useYn from cb_member where company_idx = '".$this->member->item('company_idx')."'".$where;
		$qry = $this->db->query($sql);
		$result = $qry->result_array();
        $total_rows = count($result);
        foreach($result as $k => $v){
            $result[$k]['num'] = $total_rows--;
            if(!$v['mem_username']){
                $result[$k]['mem_username'] = $v['mem_nickname'];
            } 

            if($v['mem_useYn'] == 'y'){
                $result[$k]['mem_useYn'] = '활성화';
            } else {
                $result[$k]['mem_useYn'] = '비활성화';
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

        $layoutconfig = array('layout' => 'layout_popup', 'skin' => 'add_member');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['layout']['menu_title'] = "그룹원 추가";
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function write()
    {
        $view = array();
        $view['view'] = array();

        $getdata = array();

        // 이벤트 불러오기
        $q = "select event_idx, event_name from cb_event_company where company_idx = ".$this->member->item('company_idx');
        $r = $this->db->query($q);
        $evt_list = $r->result_array();

        $view['view']['evt_list'] = $evt_list;

        // 템플릿 불러오기
        $q = "select template_idx, template_name from cb_event_template";
        $r = $this->db->query($q);
        $tpl_list = $r->result_array();

        $view['view']['tpl_list'] = $tpl_list;
		

        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'write');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['layout']['menu_title'] = " 이벤트 추가";
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

        $sql = "select event_showFl from cb_event_company where event_idx = ".$pid;
        $r = $this->db->query($sql);
        $rst = $r->row_array();
        if($rst['event_showFl'] == 'n'){
            $view = array();
            $view['view'] = array();

            $view['view']['event_idx'] = $pid;

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

            // 이벤트 그룹 회원 불러오기
            $q = "select mem_id, mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email from cb_member where FIND_IN_SET(".$pid.", event_idx) and company_idx = ".$this->member->item('company_idx');
            $r = $this->db->query($q);
            $egm_list = $r->result_array();
            $view['view']['egm_list'] = $egm_list;

            $sql = "select * from cb_event_company where event_idx = ".$pid;
            $qry = $this->db->query($sql);
            $result = $qry->row_array();		

            $view['view']['data'] = $result;
            
            $view['view']['data']['primary_key'] = $pid;

            $this->load->library('form_validation');

            $layoutconfig = array('layout' => 'layout', 'skin' => 'modify');
            $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
            $view['layout']['menu_title'] = " 이벤트 수정";
            $this->data = $view;
            $this->layout = element('layout_skin_file', element('layout', $view));
            $this->view = element('view_skin_file', element('layout', $view));
        } else {
            $this->session->set_flashdata(
                'message',
                '활성화된 이벤트는 수정이 불가능합니다'
            );

            $redirecturl = '/admin/servicing/eventtemplate';
            redirect($redirecturl);
        }
    }

    public function paste($pid = 0)
    {
        if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}

        $sql = "select event_showFl from cb_event_company where event_idx = ".$pid;
        $r = $this->db->query($sql);
        $rst = $r->row_array();
        if($rst['event_showFl'] == 'n'){
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

            // 이벤트 그룹 회원 불러오기
            $q = "select mem_id, mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email from cb_member where FIND_IN_SET(".$pid.", event_idx) and company_idx = ".$this->member->item('company_idx');
            $r = $this->db->query($q);
            $egm_list = $r->result_array();
            $view['view']['egm_list'] = $egm_list;

            $sql = "select * from cb_event_company where event_idx = ".$pid;
            $qry = $this->db->query($sql);
            $result = $qry->row_array();		

            $view['view']['data'] = $result;
            
            $view['view']['data']['primary_key'] = $pid;

            $this->load->library('form_validation');

            $layoutconfig = array('layout' => 'layout', 'skin' => 'paste');
            $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
            $view['layout']['menu_title'] = " 이벤트 추가";
            $this->data = $view;
            $this->layout = element('layout_skin_file', element('layout', $view));
            $this->view = element('view_skin_file', element('layout', $view));
        } else {
            $this->session->set_flashdata(
                'message',
                '활성화된 이벤트는 수정이 불가능합니다'
            );

            $redirecturl = '/admin/servicing/eventtemplate';
            redirect($redirecturl);
        }
    }

    public function save()
    {
        $post = $this->input->post();

        $this->load->library('upload');

        if (isset($_FILES) && isset($_FILES['event_thumb_file']) && isset($_FILES['event_thumb_file']['name']) && $_FILES['event_thumb_file']['name'])
        {
            $upload_path = config_item('uploads_dir') . '/event_thumb/';
            $upload_path = upload_mkdir($upload_path);

            $uploadconfig = array();
            $uploadconfig['upload_path'] = $upload_path;
            $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);
            if ($this->upload->do_upload('event_thumb_file')) {
                $img = $this->upload->data();
                $updatephoto = "/".$upload_path.element('file_name', $img);
                $post['event_thumb'] = $updatephoto;
            } else {
                $file_error = $this->upload->display_errors();
            }
        } 

        if($post['mode'] == 'register'){
            $sql = "INSERT INTO cb_event_company SET 
                    company_idx = '".$this->member->item('company_idx')."', 
                    template_idx = '".$post['template_idx']."', 
                    event_name = '".$post['event_name']."', 
                    event_contents = '".$post['event_contents']."', 
                    event_startDt = '".$post['event_startDt']."', 
                    event_endDt = '".$post['event_endDt']."', 
                    event_point = '".$post['event_point']."', 
                    event_giveFl = '".$post['event_giveFl']."', 
                    event_give_day = '".$post['event_give_day']."',
                    event_showFl = 'n', 
                    event_thumb = '".$post['event_thumb']."', 
                    event_message_all = '".$post['event_message_all']."', 
                    event_message_group = '".$post['event_message_group']."', 
                    event_dashboard_group = '".$post['event_dashboard_group']."', 
                    event_regDt = now()
            ";
            $this->db->query($sql);
            $register_id = $this->db->insert_id();

            if($post['addEventGroup']){
                $eventGroupMembers = explode(',',$post['addEventGroup']);
                foreach($eventGroupMembers as $k => $v){
                    $v = (int) $v;
                    $q = "select event_idx from cb_member where mem_id = ".$v;
                    $r = $this->db->query($q);
                    $rst = $r->row_array();
                    if($rst['event_idx']){
                        $items = explode(',',$rst['event_idx']);
                        $newItem = $register_id;
                        if(!in_array($newItem, $items)){
                            $items[] = $newItem;
                            sort($items);
                        }
                        $rst['event_idx'] = implode(',', $items);
    
                        $sql = "update cb_member set event_idx = '".$rst['event_idx']."' where mem_id = ".$v;
                    } else {
                        $sql = "update cb_member set event_idx = '".$register_id."' where mem_id = ".$v;
                    }
                }
            }

            $this->session->set_flashdata(
                'message',
                '이벤트가 정상적으로 등록되었습니다'
            );
        } else if($post['mode'] == 'update'){
            if($post['event_thumb'] == ''){
                $post['event_thumb'] = $post['event_thumb_ori'];
            }
            $sql = "UPDATE cb_event_company SET 
                    company_idx = '".$this->member->item('company_idx')."', 
                    template_idx = '".$post['template_idx']."', 
                    event_name = '".$post['event_name']."', 
                    event_contents = '".$post['event_contents']."', 
                    event_startDt = '".$post['event_startDt']."', 
                    event_endDt = '".$post['event_endDt']."', 
                    event_point = '".$post['event_point']."', 
                    event_giveFl = '".$post['event_giveFl']."', 
                    event_give_day = '".$post['event_give_day']."',
                    event_showFl = 'n', 
                    event_thumb = '".$post['event_thumb']."', 
                    event_message_all = '".$post['event_message_all']."', 
                    event_message_group = '".$post['event_message_group']."', 
                    event_dashboard_group = '".$post['event_dashboard_group']."' 
                    WHERE event_idx = '".$post['event_idx']."'
            ";
            $this->db->query($sql);

            if($post['addEventGroup']){
                $eventGroupMembers = explode(',',$post['addEventGroup']);
                foreach($eventGroupMembers as $k => $v){
                    $v = (int) $v;
                    $q = "select event_idx from cb_member where mem_id = ".$v;
                    $r = $this->db->query($q);
                    $rst = $r->row_array();
                    if($rst['event_idx']){
                        $items = explode(',',$rst['event_idx']);
                        $newItem = $post['event_idx'];
                        if(!in_array($newItem, $items)){
                            $items[] = $newItem;
                            sort($items);
                        }
                        $rst['event_idx'] = implode(',', $items);
    
                        $sql = "update cb_member set event_idx = '".$rst['event_idx']."' where mem_id = ".$v;
                    } else {
                        $sql = "update cb_member set event_idx = '".$post['event_idx']."' where mem_id = ".$v;
                    }
                }
            }

            $this->session->set_flashdata(
                'message',
                '이벤트가 정상적으로 수정되었습니다'
            );
        } 

        $redirecturl = '/admin/servicing/eventtemplate';
        redirect($redirecturl);
    }

    public function loadevent()
    {
        $post = $this->input->post();
        $q = "select * from cb_event_company where event_idx = ".$post['event_idx'];
        $r = $this->db->query($q);
        $data = $r->row_array();

        // 이벤트 그룹 회원 불러오기
        $q = "select mem_id, mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email from cb_member where FIND_IN_SET(".$post['event_idx'].", event_idx) and company_idx = ".$this->member->item('company_idx');
        $r = $this->db->query($q);
        $egm_list = $r->result_array();
        $data['egm_list'] = $egm_list;

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

    public function loadTempDesc()
    {
        $post = $this->input->post();
        $q = "select template_name, template_contents from cb_event_template where template_idx = ".$post['template_idx'];
        $r = $this->db->query($q);
        $data = $r->row_array();

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

    public function loadMemInfo()
    {
        $post = $this->input->post();
        $q = "select mem_id, mem_div, mem_position, mem_username, mem_nickname, mem_userid, mem_email from cb_member where mem_id = ".$post['mem_id'];
        $r = $this->db->query($q);
        $data = $r->row_array();
        if(!$data['mem_username']){
            $data['mem_username'] = $data['mem_nickname'];
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