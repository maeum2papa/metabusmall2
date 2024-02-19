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
 * 관리자>교환소관리>복지상품템플리소관리 controller 입니다.
 */
class Template extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cmall/template';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Cmall_item_template');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Cmall_item_template_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'cmall', 'dhtml_editor');

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
		

		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 템플릿 사용 현황 목록
	 */
	public function status($pid = 0)
	{
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout_popup', 'skin' => 'status');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 템플릿 추가
	 */
	public function write($pid = 0)
	{
        
        $view = array();
		$view['view'] = array();

        $primary_key = $this->{$this->modelname}->primary_key;


        /**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

        /**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'is_submit',
				'label' => '전송',
				'rules' => 'trim|numeric',
			),
			array(
				'field' => 'citt_name',
				'label' => '템플릿상품명',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'citt_summary',
				'label' => '템플릿상품설명',
				'rules' => 'trim',
			),
			array(
				'field' => 'citt_status',
				'label' => '노출여부',
				'rules' => 'trim|numeric',
			),
            array(
				'field' => 'citt_price',
				'label' => '예치금차감금액',
				'rules' => 'trim|required|numeric|is_natural',
			)
        );
        
        $this->form_validation->set_rules($config);
        $form_validation = $this->form_validation->run();
        $file_error = '';
        
        /**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($form_validation === false OR $file_error !== '') {
            
            /**
             * 수정 페이지일 경우 기존 데이터를 가져옵니다
             */
            $getdata = array();
            if ($pid) {
                $getdata = $this->{$this->modelname}->get_one($pid);
            } else {
                // 기본값 설정
                $getdata['citt_status'] = '1';
            }

            $view['view']['data'] = $getdata;
            
            /**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

        } else {
            /**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

            $formdata['citt_name'] = $this->input->post('citt_name');
            $formdata['citt_summary'] = $this->input->post('citt_summary');
            $formdata['citt_price'] = $this->input->post('citt_price');
            $formdata['citt_ship_type'] = $this->input->post('citt_ship_type');
            $formdata['citt_status'] = $this->input->post('citt_status');
            $formdata['citt_content'] = $this->input->post('citt_content');
            $formdata['citt_mobile_content'] = $this->input->post('citt_mobile_content');

            $i = 0;
            foreach($_FILES as $k=>$v){
                $formdata[$k] = $this->input->post('citt_file_'.$i);
                if($formdata[$k] == NULL) $formdata[$k] = "";
                $i++;
            }


            //image upload
            $this->load->library('upload');
            $upload_path = config_item('uploads_dir') . '/cmallitemtemplate/';
            $filecount = 0;

            foreach($_FILES as $k=>$v){
                if($v['error']==0){
                    $filecount = $filecount + 1;
                }
            }

            if($filecount > 0){
                if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				$upload_path .= cdate('Y') . '/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				$upload_path .= cdate('m') . '/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
                

                foreach($_FILES as $k=>$v){
                    if($v['error']==0){
                        
                        $uploadconfig = array();
						$uploadconfig['upload_path'] = $upload_path;
						$uploadconfig['allowed_types'] = '*';
						$uploadconfig['encrypt_name'] = true;
                        
                        $this->upload->initialize($uploadconfig);
                        
                        if ($this->upload->do_upload($k)) {
							$filedata = $this->upload->data();

                            $formdata[$k] = $upload_path.$filedata['file_name'];

						} else {
							$file_error = $this->upload->display_errors();
							break;
						}
                    }
                }
            }
            
             
            if ($pid) {

                $updatedata = $formdata;
                $updatedata["citt_updated_datetime"] = cdate('Y-m-d H:i:s');
                $this->{$this->modelname}->update($pid,$updatedata);
            
            } else {

                $insertdata = $formdata;
                $insertdata["citt_datetime"] = cdate('Y-m-d H:i:s');
                $this->{$this->modelname}->insert($insertdata);

            }
            
            if ($this->input->post($pid)) {
				redirect(current_url(), 'refresh');
			} else {
				$param =& $this->querystring;
				$redirecturl = admin_url($this->pagedir . '?' . $param->output());
				redirect($redirecturl);
			}
        }

        
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'write');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

}
