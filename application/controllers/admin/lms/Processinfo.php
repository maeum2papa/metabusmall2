<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Processinfo extends CB_Controller
{

    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'lms/processinfo';

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('company_info','process');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'process_model';

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
        $view = array();
        $view['view'] = array();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        $view['view']['sort'] = array(
            'process_title' => $param->sort('process_title', 'asc'),
            'state' => $param->sort('state', 'asc'),
            'reg_date' => $param->sort('reg_date', 'desc'),
        );

        $findex = $this->input->get('findex', null, '');
        $forder = $this->input->get('forder', null, '');
        $sfield = 'process_title';
        $skeyword = $this->input->get('skeyword', null, '');

        $_GET['sh_span'] = ($this->input->get('sh_span') == '')? 'reg_date' : $this->input->get('sh_span');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        $this->{$this->modelname}->allow_search_field = array('process_title'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('process_title', 'state', 'reg_date'); // 정렬이 가능한 필드

        $view['view']['plan_list'] = $this->company_info_model->get_plan_list();

        $view['view']['plan_chkflag'] = 0;
        $plan_where = '';

        foreach($view['view']['plan_list'] as $l)
        {
            if(isset($_GET['chk_plan_'.$l['plan_idx']]))
            {
                $view['view']['plan_chkflag'] = 1;
                $plan_where .= $l['plan_idx'].",";
            }
        }

        $where = ' cb_process.process_idx is not null ';

        if($plan_where != '')
        {
            $plan_where = rtrim($plan_where,",");
            $where .= " and cb_process.plan_idx in ($plan_where) ";
        }

        if($this->input->get('sday') != '')
        {
            $where .= " and cb_process.".$this->input->get('sh_span')." >= '".$this->input->get('sday')."' ";
        }

        if($this->input->get('eday') != '')
        {
            $where .= " and cb_process.".$this->input->get('sh_span')." <= '".$this->input->get('eday')."' ";
        }

        $cate_flag = 0;

        if($this->input->get('cate_2') != '')
        {
            $where .= " and category_rel.cca_id = ".$this->input->get('cate_2');
            $cate_flag = 1;
        }

        $result = $this->{$this->modelname}
            ->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword, $cate_flag);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        $view['view']['data'] = $result;
        $view['view']['state_str'] = array('use'=>'활성화','unuse'=>'비활성화');
        $view['view']['flag_str'] = array('X','O');

        $view['view']['category_list'] = $this->{$this->modelname}->get_category_list();
        $view['view']['nowday'] = date('Y-m-d');
        $view['view']['weekday'] = date('Y-m-d',strtotime("-7 day"));
        $view['view']['fiftday'] = date('Y-m-d',strtotime("-15 day"));
        $view['view']['month'] = date('Y-m-d',strtotime("-1 month"));
        $view['view']['months'] = date('Y-m-d',strtotime("-3 month"));

        $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

        $config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        $search_option = array('process_title'=>'과정명');
        $view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
        $view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['listall_url'] = admin_url($this->pagedir);
        $view['view']['write_url'] = admin_url($this->pagedir . '/write');

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

        $view['view']['plan_list'] = $this->company_info_model->get_plan_list();
        $view['view']['company_list'] = $this->company_info_model->get_company_list();

        $view['view']['category_list'] = $this->{$this->modelname}->get_category_list();
        $view['view']['category_sub_list'] = $this->{$this->modelname}->get_category_list(1);

        if($pid)
        {
            $getdata = $this->{$this->modelname}->get_one($pid);

            $getdata['category_rel_list'] = $this->{$this->modelname}->get_category_rel_list($pid);
            $getdata['company_rel_list'] = $this->{$this->modelname}->get_company_rel_list($pid);

            $getdata['category_no'] = count($getdata['category_rel_list']);
            $getdata['company_no'] = count($getdata['company_rel_list']);

        } else {
            $getdata['view_sdate'] = date('Y-m-d');
            $getdata['view_edate'] = date('Y-m-d');
            $getdata['state'] = 'unuse';
            $getdata['plan_idx'] = $view['view']['plan_list'][0]['plan_idx'];
            $getdata['required_flag'] = 0;
            $getdata['propose_flag'] = 0;
            $getdata['reg_company_idx'] = 0;

            $getdata['category_no'] = 0;
            $getdata['company_no'] = 0;
        }
		
		//자료첨부파일
		$view['view']['img_in'] = json_decode($getdata[process_data_name], true);
		$view['view']['img_in_first'] = $view['view']['img_in'][0];
		
		
        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        $layoutconfig = array('layout' => 'layout', 'skin' => 'write');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function save()
    {
        $in_post = $this->input->post();
        $idx = $in_post['process_idx'];
        $add_category_idx = $in_post['add_category_idx'];
        $add_company_idx = $in_post['add_company_idx'];

        if($in_post['process_data_delchk'] == 1)
        {
            unset($in_post['process_data_delchk']);
            $in_post['process_data_name'] = '';
            $in_post['process_data_path'] = '';
        }

        

        $in_post['required_flag'] = ($in_post['required_flag'] == '')? 0 : 1;
        $in_post['propose_flag'] = ($in_post['propose_flag'] == '')? 0 : 1;

        unset($in_post['process_idx']);
        unset($in_post['add_category_idx']);
        unset($in_post['add_company_idx']);

        $this->load->library('upload');

        if (isset($_FILES) && isset($_FILES['process_img_file']) && isset($_FILES['process_img_file']['name']) && $_FILES['process_img_file']['name'])
        {
            $upload_path = config_item('uploads_dir') . '/process_img/';
            $upload_path = upload_mkdir($upload_path);

            $uploadconfig = array();
            $uploadconfig['upload_path'] = $upload_path;
            $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);

            if ($this->upload->do_upload('process_img_file')) {
                $img = $this->upload->data();
                $updatephoto = "/".$upload_path.element('file_name', $img);
                $in_post['process_img'] = $updatephoto;
            } else {
                $file_error = $this->upload->display_errors();
            }
        }

        if (isset($_FILES) && isset($_FILES['process_banner_file']) && isset($_FILES['process_banner_file']['name']) && $_FILES['process_banner_file']['name'])
        {
            $upload_path = config_item('uploads_dir') . '/process_banner/';
            $upload_path = upload_mkdir($upload_path);

            $uploadconfig = array();
            $uploadconfig['upload_path'] = $upload_path;
            $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);

            if ($this->upload->do_upload('process_banner_file')) {
                $img = $this->upload->data();
                $updatephoto = "/".$upload_path.element('file_name', $img);
                $in_post['process_banner'] = $updatephoto;
            } else {
                $file_error = $this->upload->display_errors();
            }
        }

        //첨부 자료
		$upfilesYn = 'n';
		if($_FILES['upfiles']){
			foreach ($_FILES[upfiles][error] as $k => $v){
				if($v == '0'){
					$upfilesYn = 'y';
				}
			}
		}
		
		if ($upfilesYn == 'y'){
			
			$item_img_in_path = $item_img_path = config_item('uploads_dir') . '/process_data/';
			$uploadconfig = array();
			$uploadconfig['upload_path'] = $item_img_in_path;
			$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif|zip|pdf';
			$uploadconfig['encrypt_name'] = true;

			$this->upload->initialize($uploadconfig);

			if($idx != ''){ //수정일때
				$getdata = $this->{$this->modelname}->get_one($idx);
				//기존 이미지 삭제	
				if($getdata[process_data_name]){
					$item_img_in_ori = json_decode($getdata[process_data_name], true);
					foreach ($item_img_in_ori as $k => $v){
						if($v[img]){
							$ori_img[] = $v[img]; //전체 이미지 일단 구하고 여기서부터 지울 이미지 찾기
						}
					}
					$uploadFileNm = $this->input->post('uploadFileNm');
					
					$ori_img = array_diff($ori_img,$uploadFileNm);
					
					
					
					foreach ($ori_img as $k => $v){
						if($v){
							$fn = "/var/www/html".$v;
							if(is_file($fn)) {
								unlink($fn);
							}
						}
					}
				}
				foreach ($_FILES[upfiles] as $k => $v){
					foreach ($v as $k1 => $v1){
						$_FILES[upfiles.$k1][$k] = $v1;

					}	
				}


				foreach ($_FILES[upfiles][name] as $k => $v){
					if($v){
						if ($this->upload->do_upload('upfiles'.$k)) {
							$img = $this->upload->data();
							$updatephoto2 = "/".$item_img_in_path.element('file_name', $img);
							$uploadFileNm[$k] = $updatephoto2;

						} else {
							$file_error = $this->upload->display_errors();
						}	
					}
					$item_img_in_arr[$k][img] = $uploadFileNm[$k];
				}



			}else{ //신규 등록이었을때 이미지 수정 없음
				foreach ($_FILES[upfiles] as $k => $v){
					foreach ($v as $k1 => $v1){
						$_FILES[upfiles.$k1][$k] = $v1;

					}	
				}

				foreach ($_FILES[upfiles][name] as $k => $v){
					if ($this->upload->do_upload('upfiles'.$k)) {
						$img = $this->upload->data();
						$updatephoto2 = "/".$item_img_in_path.element('file_name', $img);
						$item_img_in_arr[$k][img] = $updatephoto2;

					} else {
						$file_error = $this->upload->display_errors();
					}
				}
			}

		}else{ //인게임 파일이 없을때
			$uploadFileNm = $this->input->post('uploadFileNm');
			foreach ($_FILES[upfiles][name] as $k => $v){
				$item_img_in_arr[$k][img] = $uploadFileNm[$k];
			}
		}
		//공통적용
		if($item_img_in_arr){
			$in_post[process_data_name] = json_encode($item_img_in_arr);	
		}
		unset($in_post[uploadFileNm]);

        

        if($idx == '') $idx = $this->{$this->modelname}->insert($in_post);
        else $this->{$this->modelname}->update($idx, $in_post);

        if(is_array($add_category_idx) == 1) $this->{$this->modelname}->set_category_rel($idx, $add_category_idx);
        else $this->{$this->modelname}->set_category_rel($idx, array());

        if(is_array($add_company_idx) == 1) $this->{$this->modelname}->set_company_rel($idx, $add_company_idx);
        else $this->{$this->modelname}->set_company_rel($idx, array());

        $this->session->set_flashdata(
            'message',
            '정상적으로 저장되었습니다'
        );

        $param =& $this->querystring;
        $redirecturl = admin_url($this->pagedir . '?' . $param->output());

        redirect($redirecturl);
    }

    public function get_category_sub($pid)
    {
        $rs = $this->{$this->modelname}->get_category_list($pid);

        $html = "";
        foreach($rs as $l)
        {
            $html .= "<option value='" . $l['cca_id'] . "'>" . $l['cca_value'] . "</option>";
        }

        echo $html;
    }

    public function download($pid)
    {
        $mode = substr($pid, 0, 1);
        $idx = substr($pid, 1);
        $getdata = $this->{$this->modelname}->get_one($idx);

        if($mode == 'd')
        {
            $name = $getdata['process_data_name'];
            $path = $getdata['process_data_path'];
        } elseif($mode == 't') {
            $name = $getdata['teacher_info'];
            $path = $getdata['teacher_info_path'];
        }

        $this->load->helper('download');

        $data = file_get_contents($_SERVER["DOCUMENT_ROOT"].$path);
        force_download($name, $data);
    }

    public function content($pid)
    {
        $view = array();
        $view['view'] = array();

        $primary_key = $this->{$this->modelname}->primary_key;
        $view['view']['primary_key'] = $primary_key;

        $view['view']['pid'] = $pid;

        $getdata = array();

        $view['view']['video_list'] = $this->{$this->modelname}->get_video_list();
        $view['view']['state_str'] = array('use'=>'활성화','unuse'=>'비활성화');
        $view['view']['div_str'] = array('video'=>'동영상','game'=>'게임','item'=>'씨앗');

        $getdata = $this->{$this->modelname}->get_curriculum_list($pid);
        $view['view']['data'] = $getdata;

        $this->load->library('form_validation');

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'content');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function get_content_list($pid)
    {
        $f_str = array( 'video'=>array('key'=>'video_idx','val'=>'video_name'),
                        'game'=>array('key'=>'game_content_idx','val'=>'game_content_name'));

        if($pid == 'video') $rs = $this->{$this->modelname}->get_video_list();
        else $rs = $this->{$this->modelname}->get_game_content_list();

        $html = "";
        foreach($rs as $l)
        {
            $html .= "<option value='" . $l[$f_str[$pid]['key']] . "'>" . $l[$f_str[$pid]['val']] . "</option>";
        }

        echo $html;
    }

    public function content_save($pid)
    {
        $in_get = $this->input->get();
        $in_array = array('process_idx'=>$pid,'curriculum_div'=>$in_get['curriculum_value']);

        if($in_get['curriculum_value'] == 'video') $in_array['video_idx'] = $in_get['content_idx'];
        elseif($in_get['curriculum_value'] == 'game') $in_array['game_content_idx'] = $in_get['content_idx'];
        elseif($in_get['curriculum_value'] == 'item') $in_array['item_cnt'] = ($in_get['item_cnt'] == '')? 1 : $in_get['item_cnt'];

        $idx = $this->{$this->modelname}->set_curriculum_save($in_array);

        echo $idx;
    }

    public function content_del($pid)
    {
        $curriculum_idx = $this->input->get('curriculum_idx');
        $this->{$this->modelname}->set_curriculum_del($pid, $curriculum_idx);
    }

    public function item_cnt($pid)
    {
        $curriculum_idx = $this->input->get('curriculum_idx');
        $item_cnt = $this->input->get('item_cnt');
        $this->{$this->modelname}->set_item_cnt($pid, $curriculum_idx, $item_cnt);
    }

    public function curriculum_use_save()
    {
        $curriculum_idx = $this->input->get('idx');
        $type_flg = $this->input->get('type_flg');
        $this->{$this->modelname}->curriculum_use_save($curriculum_idx, $type_flg);

        echo 0;
    }

    public function set_order_num($pid)
    {
        $listItem = $this->input->get('listItem');

        foreach ($listItem as $position => $item)
        {
            $this->{$this->modelname}->set_order_num_save($pid, $item, $position);
        }
    }

}
?>