<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pagemenu class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>페이지설정>메뉴관리 controller 입니다.
 */
class Asset_item extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'asset/asset_item';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Asset_item');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Asset_item_model';

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
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_document_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'item_sno' => $param->sort('item_sno', 'asc'),
			'item_kr' => $param->sort('item_kr', 'asc'),
			'item_type' => $param->sort('item_type', 'asc'),
			'item_regDt' => $param->sort('item_regDt', 'desc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('item_kr', 'cate_kr', 'item_regDt'); // 검색이 가능한 필드
		// $this->{$this->modelname}->search_field_equal = array('seum_departmentNm'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('item_sno', 'item_kr', 'item_type', 'item_regDt'); // 정렬이 가능한 필드
		
		
		//템플릿 종류 검색 추가
		$where = array();
		
		if ($_GET['item_type']) {	
			$where['item_type'] = $view['view']['item_type'] = $_GET['item_type'];
		}
		
		
		
		
		$result = $this->{$this->modelname}->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

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
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('item_kr' => '아이템명', 'cate_kr' => '카테고리명');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? ltrim($skeyword) : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

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

	/**
	 * 등록
	 */
	public function write($pid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_document_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;
		
		//debug($view['view']['category']);
		
		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->{$this->modelname}->get_one($pid);
			
		}
		
		//카테고리 윤진봉
		if($getdata[item_type] == 'l'){
			$q = "select * from cb_asset_category where  cate_type = 'i' and cate_parent = '7' order by cate_parent, cate_order";
		}else{
			$q = "select * from cb_asset_category where  cate_type = 'i' and cate_parent = '5' order by cate_parent, cate_order";
		}
		$r = $this->db->query($q);
		$view['view']['category'] = $r->result_array(); 
		
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'item_sno',
				'label' => '번호',
				'rules' => 'trim',
			),
			array(
				'field' => 'cate_sno',
				'label' => '카테고리',
				'rules' => 'trim',
			),
			array(
				'field' => 'item_nm',
				'label' => '템플릿',
				'rules' => 'trim|required',
			),
			array(
				'field' => 'item_type',
				'label' => '종류',
				'rules' => 'trim',
			),
		);

		if ($this->input->post($primary_key)) {
			$config[] = array(
				'field' => 'item_sno',
				'label' => '번호',
				'rules' => 'trim|required|alpha_dash|min_length[1]|max_length[50]|is_unique[document.doc_key.doc_id.' . $getdata['doc_id'] . ']',
			);
		} else {
			// $config[] = array(
			// 	'field' => 'seum_sno',
			// 	'label' => '부서번호',
			// 	'rules' => 'trim|required|alpha_dash|min_length[1]|max_length[50]|is_unique[document.doc_key]',
			// );
		}
		
		$this->form_validation->set_rules($config);

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			$view['view']['data'] = $getdata;
			if($getdata[item_type] == 'l'){
				$view['view']['item_type'] = 'l';
				$view['view']['img_in'] = json_decode($getdata[item_img_in], true);
				$view['view']['img_in_first'] = $view['view']['img_in'][0];
				//debug($view['view']['img_in']);
			}else{
				$view['view']['item_type'] = 'a';
				
			}
			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'write');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		} else {

			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = array(
				'cate_sno' => $this->input->post('cate_sno', null, ''),
				'item_type' => $this->input->post('item_type', null, ''),
				'item_nm' => $this->input->post('item_nm', null, ''),
				'item_kr' => $this->input->post('item_kr', null, ''),
				'item_img_in_txt' => $this->input->post('item_img_in_txt', null, ''),
				'item_basicYn' => $this->input->post('item_basicYn', null, ''),
				'item_modDt' => date("Y-m-d H:i:s"),
			);

			if ( $this->input->post($primary_key) != $pid ){
			}
			$upfilesYn = 'n';
			
			if($_FILES['upfiles']){
				foreach ($_FILES[upfiles][error] as $k => $v){
					if($v == '0'){
						$upfilesYn = 'y';
					}
				}
			}
			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($pid) {
				
				
				
				
				$updateYn = 'y'; //파일 업로드 때문에 수정/신규 구분하기 위함
				
				
				
				
				$this->{$this->modelname}->update($pid, $updatedata);
				unset($updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				
				$param = array(
					'cate_sno' => $this->input->post('cate_sno', null, ''),
					'item_type' => $this->input->post('item_type', null, ''),
					'item_nm' => $this->input->post('item_nm', null, ''),
					'item_kr' => $this->input->post('item_kr', null, ''),
					'item_img_in_txt' => $this->input->post('item_img_in_txt', null, ''),
					'item_basicYn' => $this->input->post('item_basicYn', null, ''),
					'item_regDt' => date("Y-m-d H:i:s"),
					'item_modDt' => date("Y-m-d H:i:s"),
				);
				$this->{$this->modelname}->insert($param);
				$pid = $this->db->insert_id();
				$this->session->set_flashdata(
					'message',
					'정상적으로 입력되었습니다'
				);
			}
			
			
			//파일처리 231118 asmo yjb
			$this->load->library('upload');
			if($this->input->post('item_type', null, '') == 'a'){
				$item_img_path = config_item('uploads_dir') . '/item/avata/';
			}else{
				$item_img_path = config_item('uploads_dir') . '/item/land/';
			}
			
			//랜드 인게임 아이템 먼저 처리
			if($this->input->post('item_type', null, '') == 'l'){
				if ($upfilesYn == 'y'){
					
					$item_img_in_path = $item_img_path."in/";
					$uploadconfig = array();
					$uploadconfig['upload_path'] = $item_img_in_path;
					$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
					$uploadconfig['encrypt_name'] = true;

					$this->upload->initialize($uploadconfig);
					$upfiles_text = $this->input->post('upfiles_text');
					
					if($updateYn == 'y'){ //수정일때
						//기존 이미지 삭제	
						if($getdata[item_img_in]){
							$item_img_in_ori = json_decode($getdata[item_img_in], true);
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
							$item_img_in_arr[$k][txt] = $upfiles_text[$k];
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
								$item_img_in_arr[$k][txt] = $upfiles_text[$k];

							} else {
								$file_error = $this->upload->display_errors();
							}
						}
					}
					
				}else{ //인게임 파일이 없을때
					$upfiles_text = $this->input->post('upfiles_text');
					$uploadFileNm = $this->input->post('uploadFileNm');
					foreach ($_FILES[upfiles][name] as $k => $v){
						$item_img_in_arr[$k][img] = $uploadFileNm[$k];
						$item_img_in_arr[$k][txt] = $upfiles_text[$k];
					}
				}
				//공통적용
				if($item_img_in_arr){
					$updatedata[item_img_in] = json_encode($item_img_in_arr);	
				}
			}
			
			
			
			if (isset($_FILES) && isset($_FILES['item_img_th_file']) && isset($_FILES['item_img_th_file']['name']) && $_FILES['item_img_th_file']['name'])
			{
				
				$item_img_th_path = $item_img_path."th/";
				//기존 이미지 삭제	
				if($getdata[item_img_th]){
					$fn = "/var/www/html".$getdata[item_img_th];
					//unlink("../../../../..".$getdata[item_img_th]);
					
					if(is_file($fn)) {
						unlink($fn);
					}
				}
				
				$uploadconfig = array();
				$uploadconfig['upload_path'] = $item_img_th_path;
				$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);
				
				$imageExt = strrchr($_FILES['item_img_th_file']['name'], '.');
				$fname = $this->input->post('item_nm', null, '').$imageExt;
				
				if ($this->upload->do_upload('item_img_th_file')) {
					$img = $this->upload->data();
					$updatephoto1 = "/".$item_img_th_path.element('file_name', $img);
					$updatedata[item_img_th] = $updatephoto1;
				} else {
					$file_error = $this->upload->display_errors();
				}
			}
			if (isset($_FILES) && isset($_FILES['item_img_in_file']) && isset($_FILES['item_img_in_file']['name']) && $_FILES['item_img_in_file']['name'])
			{
				$item_img_in_path = $item_img_path."in/";
				//기존 이미지 삭제	
				if($getdata[item_img_in]){
					$fn = "/var/www/html".$getdata[item_img_in];
					//unlink("../../../../..".$getdata[item_img_th]);
					
					if(is_file($fn)) {
						unlink($fn);
					}
				}

				$uploadconfig = array();
				$uploadconfig['upload_path'] = $item_img_in_path;
				$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);
				
				$imageExt = strrchr($_FILES['item_img_in_file']['name'], '.');
				$fname = $this->input->post('item_nm', null, '').$imageExt;
				
				if ($this->upload->do_upload('item_img_in_file')) {
					$img = $this->upload->data();
					$updatephoto2 = "/".$item_img_in_path.element('file_name', $img);
					$updatedata[item_img_in] = $updatephoto2;
					
				} else {
					$file_error = $this->upload->display_errors();
				}
				
				
			}if (isset($_FILES) && isset($_FILES['item_img_ch_file']) && isset($_FILES['item_img_ch_file']['name']) && $_FILES['item_img_ch_file']['name'])
			{
				$item_img_ch_path = $item_img_path."ch/";
				
				//기존 이미지 삭제	
				if($getdata[item_img_ch]){
					$fn = "/var/www/html".$getdata[item_img_ch];
					//unlink("../../../../..".$getdata[item_img_th]);
					
					if(is_file($fn)) {
						unlink($fn);
					}
				}
				
				$uploadconfig = array();
				$uploadconfig['upload_path'] = $item_img_ch_path;
				$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);
				
				$imageExt = strrchr($_FILES['item_img_ch_file']['name'], '.');
				$fname = $this->input->post('item_nm', null, '').$imageExt;
				
				if ($this->upload->do_upload('item_img_ch_file')) {
					$img = $this->upload->data();
					$updatephoto3 = "/".$item_img_ch_path.element('file_name', $img);
					$updatedata[item_img_ch] = $updatephoto3;
					
				} else {
					$file_error = $this->upload->display_errors();
				}
			}
			if($updatedata){
				$this->{$this->modelname}->update($pid, $updatedata);
			}
			
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['after'] = Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);
		}
	}
	//종류에 따른 카테고리 호출
	public function category()
    {
		$pid = $this->input->get('val', null, '');
		if($pid == 'a'){
			$cate_parent = '5';
		}else{
			$cate_parent = '7';
		}
		$q = "select * from cb_asset_category where  cate_type = 'i' and cate_parent = '".$cate_parent."' order by cate_order";
		$r = $this->db->query($q);
		$rs = $r->result_array(); 
		
        $html = "";
        foreach($rs as $val)
        {
            $html .= "<option value='" . $val['cate_sno'] . "'>" . $val['cate_kr'] . "</option>";
        }

        echo $html;
    }
	
	
	/**
	 * 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_page_pagemenu_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					
					$q = "select *  from cb_asset_item where item_sno = '".$val."'";
					$r = $this->db->query($q);
					$iData = (array) $r->row();
					if($iData[item_img_th]){
						$fn = "/var/www/html".$iData[item_img_th];
						if(is_file($fn)) {
							unlink($fn);
						}
					}
					if($iData[item_img_in]){
						if($iData[item_type] == 'l'){
							
							$item_img_in = json_decode($iData[item_img_in], true);
							foreach ($item_img_in as $k => $v) {
								foreach ($v as $k1 => $v1) {
									if($k1 == 'img'){
										$fn = "/var/www/html".$v1;
										if(is_file($fn)) {
											unlink($fn);
										}
									}
								}
							}
						}else{
							$fn = "/var/www/html".$iData[item_img_in];
							if(is_file($fn)) {
								unlink($fn);
							}
						}
					}
					
					if($iData[item_img_ch]){
						$fn = "/var/www/html".$iData[item_img_ch];
						if(is_file($fn)) {
							unlink($fn);
						}
					}
					
					$this->{$this->modelname}->delete($val);
				}
			}
		}

		$this->_delete_cache();


		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 삭제되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}

	/**
	 * 메뉴관련 캐시를 삭제합니다
	 */
	public function _delete_cache()
	{
		$this->cache->delete('pagemenu-mobile');
		$this->cache->delete('pagemenu-desktop');
	}
}
