<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mypage class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 마이페이지와 관련된 controller 입니다.
 */
class Myland extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Myland');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Myland_model';
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
		$this->load->library(array('querystring'));
		if (!$this->member->is_member()) {
			redirect('https://collaborland.kr/');
		}else{
			
				//전체 주문중에 아직 처리되지 않았고 아이템주문인 것들 찾아
				$q = "select cod.cod_id, cit.cit_item_arr from cb_cmall_order_detail as cod inner join cb_cmall_item as cit on cod.cit_id = cit.cit_id where cod.cit_item_applyYn = 'n' and cod.cit_item_type = 'i' and cod.mem_id = '".$this->member->item('mem_id')."'";
				$r = $this->db->query($q);
				$item_order = $r->result_array(); 
				
				$item_arr = array();
				//debug($item_arr);
				//찾은 주문들로 아이템 배열 만들어서 중복 제거해
				foreach ($item_order as $k => $v) {
					$item_no = explode(",",$v[cit_item_arr]);
					$item_arr = array_merge($item_arr, $item_no);
					$sql = "UPDATE cb_cmall_order_detail SET cit_item_applyYn = 'y' WHERE cod_id = '".$v['cod_id']."'";
					$this->db->query($sql);
				}
				$item_arr = array_unique($item_arr);
				//debug($item_arr);
				//중복제거된 배열 루프 돌리면서 없는것만 인서트해
				if($item_arr){
					foreach ($item_arr as $k => $v) {
						$q = "select seum_sno from cb_member_item where mem_id = '".$this->member->item('mem_id')."' and item_sno = '".$v."'";
						$r = $this->db->query($q);
						$mem_data = (array) $r->row(); //베이직중에 내가 가진거 일치시킴
						if(!$mem_data[seum_sno]){ //있으면 지워야 할 배열에서 제거
							$param = array(
								'item_sno'      => $v,
								'mem_id'      => $this->member->item('mem_id'),
								'startDt'      => date("Ymd"),
								'endDt'  => "30001231",
								'basicYn'  => "n",
							);
							$this->db->insert('cb_member_item', $param);
							unset($param);
						}
					}
				}
				
			
		}
	}


	/**
	 * 페이지기본 기본
	 */
	public function index()
	{
		redirect("/myland/space");
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}


	/**
	 *  스페이스 페이지
	 */
	public function space()
	{
		if (!$this->member->is_member()) {
			
			alert("본 서비스는 로그인 후 사용 가능합니다.","/login");
		}else{
			
		}



		// TEST 용 -> 아이템 업데이트
		$q = "select * from cb_asset_category where cate_type = 'i' and ( cate_parent = 5 or cate_parent = 7 or cate_parent = 30) order by cate_order";
		$r = $this->db->query($q);
		$cate_arr = $r->result_array();
		foreach ($cate_arr as $k => $v) {
			$mitem[cate_value] = $v[cate_value];
			$mitem[cate_kr] = $v[cate_kr];
			$q = "select mi.seum_sno, mi.endDt, ai.* from cb_member_item as mi left join cb_asset_item as ai on mi.item_sno = ai.item_sno  where mi.mem_id = '".$this->member->item('mem_id')."' and ai.cate_sno = '".$v[cate_sno]."'";
			$r = $this->db->query($q);
			$mitem[item] = $r->result_array();
			if($v[cate_parent] == '5'){ //아바타 일때
				$mem_item_arr[avatar][] = $mitem;
			} else if ($v[cate_parent] == '30') {
				$mem_item_arr[outer][] = $mitem;
			}else{
				$mem_item_arr[land][] = $mitem;
			}
			
		}
		
		$mem_item = json_encode($mem_item_arr, true);
		
		$update_data = array(
			'member_item'      => $mem_item,
		);
		$update_where = array(
			'mem_id'      => $this->member->item('mem_id'),
		);
		$result = $this->db->update('cb_member', $update_data, $update_where);




		
		$view['view']['mem_id'] = (int) $this->member->item('mem_id');
		
		if($_GET['mapid']){
			$view['view']['mapid'] = $_GET['mapid'];
		}else{
			$view['view']['mapid'] = 'n';
		}

		
		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'space',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "게임타이틀",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "게임화면",
			);
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	/**
	 *  스페이스 페이지
	 */
	public function inner_space()
	{
		
		if (!$this->member->is_member()) {
			
			alert("본 서비스는 로그인 후 사용 가능합니다.","/login");
		}
		
		$view['view']['mem_id'] = (int) $this->member->item('mem_id');
		
		if($_GET['mapid']){
			$view['view']['mapid'] = $_GET['mapid'];
		}else{
			$view['view']['mapid'] = 'n';
		}

		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'inner_space',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "게임타이틀",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "게임화면",
			);
		

		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	/**
	 *  스페이스 페이지
	 */
	public function test()
	{
		$view['view']['mem_id'] = (int) $this->member->item('mem_id');
		
		if($_GET['mapid']){
			$view['view']['mapid'] = $_GET['mapid'];
		}else{
			$view['view']['mapid'] = 'n';
		}
		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'test',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'bootstrap',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'bootstrap',
			'page_title' => "게임타이틀",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "게임화면",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function test2()
	{
		if($_GET['id']){
			$view['view']['zepid'] = $_GET['id'];
		}else{
			$view['view']['zepid'] = 'n';
		}
		
		if($_GET['mapid']){
			$view['view']['mapid'] = $_GET['mapid'];
		}else{
			$view['view']['mapid'] = 'n';
		}

		
		
		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'test2',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'bootstrap',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'bootstrap',
			'page_title' => "게임타이틀",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "게임화면",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	/**
	 *  ZEP 처리페이지
	 */
	public function zepps()
	{
		//header('Access-Control-Allow-Origin: http://example.com');

		if($_GET['arg'] == 's' && $_GET['zepid'] && $_GET['mapid']){
			//신규 시작인데 기존에 돌고 있던게 있으면 리셋 시켜줘
			$update_data = array(
				'reset_yn'      => 'y',
			);
			$update_where = array(
				'seum_id'      => $_GET['zepid'],
				'seum_map'      => $_GET['mapid'],
			);
			$result = $this->db->update('cb_seum_timer', $update_data, $update_where);
			
			//위에서 기존에 돌고 있던건 리셋 시켰고 이제는 신규 카운트 담아줌
			$param = array(
				'seum_id'      => $_GET['zepid'],
				'seum_map'      => $_GET['mapid'],
				'seum_start'  => date("Y-m-d H:i:s"),
			);

			$this->{$this->modelname}->insert($param);	
			$return_url = "https://collabor.kr/zep/zep?id=".$_GET['zepid']."&&mapid=".$_GET['mapid'];
			echo("<script>location.replace('".$return_url."');</script>"); 
			
		}else if($_GET['arg'] == 'i' && $_GET['zepid'] && $_GET['mapid']){ //일시중지 요청
			$q = "select * from cb_seum_timer where reset_yn = 'n' and seum_id = '".$_GET['zepid']."' and seum_map = '".$_GET['mapid']."' order by seum_sno desc";
			$r = $this->db->query($q);
			$mem_arr = $r->result_array(); 
			if($mem_arr[0]['seum_sno']){
				$update_data = array(
					'reset_yn'      => 'i',
					'seum_end'  => date("Y-m-d H:i:s"),
				);
				$update_where = array(
					'seum_sno'      => $mem_arr[0]['seum_sno'],
				);
				$result = $this->db->update('cb_seum_timer', $update_data, $update_where);	
			}
			
			$return_url = "https://collabor.kr/zep/zep?id=".$_GET['zepid']."&&mapid=".$_GET['mapid'];
			echo("<script>location.replace('".$return_url."');</script>"); 
			
		}else if($_GET['arg'] == 'r' && $_GET['zepid'] && $_GET['mapid']){ //리셋
			$q = "select * from cb_seum_timer where reset_yn != 'y' and seum_id = '".$_GET['zepid']."' and seum_map = '".$_GET['mapid']."' order by seum_sno desc";
			$r = $this->db->query($q);
			$mem_arr = $r->result_array(); 
			if($mem_arr[0]['seum_sno']){
				$update_data = array(
					'reset_yn'      => 'y',
					'seum_end'  => date("Y-m-d H:i:s"),
				);
				$update_where = array(
					'seum_sno'      => $mem_arr[0]['seum_sno'],
				);
				$result = $this->db->update('cb_seum_timer', $update_data, $update_where);	
			}
			
			$return_url = "https://collabor.kr/zep/zep?id=".$_GET['zepid']."&&mapid=".$_GET['mapid'];
			echo("<script>location.replace('".$return_url."');</script>"); 
			
		}else if($_GET['arg'] == 'c'){
			
			$q = "select * from cb_seum_timer where seum_map = '".$_GET['mapid']."' order by seum_sno desc";
			$r = $this->db->query($q);
			$mem_arr = $r->result_array(); 
			//$this->seumlib->gd_debug($mem_arr);
			if($mem_arr[0]['reset_yn'] == 'n'){ //진행중인게 있다면
				$arr = array("continue" => "ing");
			}else if($mem_arr[0]['reset_yn'] == 'i'){ //일시정지
				$arr = array("continue" => "stop");
			}else{ //진행중인게 없다면
				$arr = array("continue" => "reset");
			}
			
			$callback_name = $_GET["callback"];
			if($_GET['callback']) {
				echo $callback_name."(".json_encode($arr).");";
			} else {
				echo json_encode($arr);
			}
		}
		
	}
	
	/**
	 *  처리페이지
	 */
	public function posco()
	{
		$ch = curl_init(); // 초기화

		curl_setopt($ch, CURLOPT_POST, 1); // post
		curl_setopt($ch, CURLOPT_URL, "https://swpsso.posco.net/idms/U61/jsp/isValidSSO.jsp");	// 주소
		curl_setopt($ch, CURLOPT_COOKIE, 'SWP-H-SESSION-ID='.$_POST[ssoToken]);	// 헤더
		curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST[ssoToken]); // 파라미터 값
		curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0); // 파라미터값 사이즈  0일때 무한
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return 값 반환
		
		$content = curl_exec($ch);	// 실행
		$result = explode(",",$content);
		
		
		
		
		$insert_data = array(
			'seum_result'      => $content,
			'seum_regDt'      => date("Y-m-d H:i:s"),
		);
		$result2 = $this->db->insert('cb_zep_posco', $insert_data);
		
		
		
		
		
		//debug($result);
		$title = str_replace("cn=", "", urldecode($result[4])); // 부서명
		$name1 = urldecode($result[8]); // 영문 성명
		$name2 = urldecode($result[6]); //직책명
		//$name = $name2."  ".$name1;
		$name = $name2.$name1;
		
		$return_url = 'https://zep.us/play/ykgmwz?customData={"name":"'.$name.'", "moveSpeed":150, "title":"'.$title.'"}';
		//debug($return_url);
		//exit;
		echo("<script>location.replace('".$return_url."');</script>"); 
		
		exit;
		
	}
	
	// 젭 통계 페이지 statistics
	public function statistics()
	{
		$q = $this->db->query("select m_no, p_no from cb_zep_map where m_url like '%".$_GET['map_id']."%'");
		$r = $q->row_array();
		
		if($r[m_no]){ //존재하는 맵일때
			$today = date("Y-m-d");
			$q1 = $this->db->query("select sno from cb_zep_visit where mem_id = '".$_GET['p_no']."' and p_no = '".$r[p_no]."' and m_no = '".$r[m_no]."' and reg_dt like '%".$today."%'");
			$r1 = $q1->row_array();
			if($r1[sno]){ //오늘 해당 맵에 방문 기록이 있을때
				$return[msg] = 'fail';
			}else{ //오늘 해당 맵에 방문 기록이 없을때
				$insert_data = array(
					'mem_id'      => $_GET['p_no'],
					'login_yn'      => $_GET['login_yn'],
					'p_no'      => $r[p_no],
					'm_no'      => $r['m_no'],
					'reg_dt'  => date("Y-m-d H:i:s"),
				);
				$result = $this->db->insert('cb_zep_visit', $insert_data);	
				$return[msg] = 'success';
			}
			
		}else{
			$return[msg] = 'fail';
		}
		
		echo json_encode($return);
		
		exit;
		
	}

	/**
	 * TermsOfService
	 */

	 public function termsOfService() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'termsOfService',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "termsOfService",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "termsOfService",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

	  }


}
