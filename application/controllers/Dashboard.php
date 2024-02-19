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
class Dashboard extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Dashboard');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Dashboard_model';
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
		}
	}


	/**
	 * 페이지기본 기본
	 */
	public function index()
	{
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'main',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "대쉬보드",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "대쉬보드",
		);
		
		if ($this->member->is_member()) {
			$q = "select company_code from cb_company_info where company_idx = '".$this->member->item('company_idx')."'";
			$r = $this->db->query($q);
			$company_code = (array) $r->row();
			$domain_arr = explode(".",$_SERVER["HTTP_HOST"]);
			
			//자기 도메인이 아닌곳에 와있으면 리다렉이트
			if(!in_array($company_code[company_code], $domain_arr)){
				$url_after_login = "https://".$company_code[company_code].".collaborland.kr/dashboard";
				redirect($url_after_login);
			}else{
				//기본아이템
				//if($this->member->item('mem_id') == 2){
					
					$q = "select * from cb_asset_item where item_basicYn = 'y'";
					$r = $this->db->query($q);
					$basic_arr = $r->result_array(); 
					
					$q = "select mi.seum_sno, mi.endDt, ai.* from cb_member_item as mi left join cb_asset_item as ai on mi.item_sno = ai.item_sno  where mi.mem_id = '".$this->member->item('mem_id')."' and basicYn = 'y'";
					$r = $this->db->query($q);
					$mi_arr = $r->result_array(); //내가 가지고 있는 멤버 아이템
					
					if($mi_arr){
						foreach ($mi_arr as $k => $v) {
							$seum_sno_arr[] = $v[seum_sno];
						}
						foreach ($basic_arr as $k => $v) {
							
							$q = "select seum_sno from cb_member_item where mem_id = '".$this->member->item('mem_id')."' and item_sno = '".$v[item_sno]."'";
							$r = $this->db->query($q);
							$mem_data = (array) $r->row(); //베이직중에 내가 가진거 일치시킴
							if($mem_data[seum_sno]){ //있으면 지워야 할 배열에서 제거
								$seum_sno_arr = array_diff($seum_sno_arr, array($mem_data[seum_sno]));
							}else{
								$param = array(
									'item_sno'      => $v[item_sno],
									'mem_id'      => $this->member->item('mem_id'),
									'startDt'      => date("Ymd"),
									'endDt'  => "30001231",
									'basicYn'  => "y",
								);
								$this->db->insert('cb_member_item', $param);
								unset($param);
							}
						}
						
					}else{ //신규 접속일때
						foreach ($basic_arr as $k => $v) {
							$param = array(
								'item_sno'      => $v[item_sno],
								'mem_id'      => $this->member->item('mem_id'),
								'startDt'      => date("Ymd"),
								'endDt'  => "30001231",
								'basicYn'  => "y",
							);
							$this->db->insert('cb_member_item', $param);
							unset($param);
						}
					}
					if($seum_sno_arr){
						foreach ($seum_sno_arr as $k => $v) {
							$delete_array[seum_sno] = $v;
							$result = $this->db->delete("cb_member_item", $delete_array); 
							unset($delete_array);
						}
					}
					
					$q = "select * from cb_asset_category where cate_type = 'i' and ( cate_parent = 5 or cate_parent = 7) order by cate_order";
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
				//}

				// 공지사항 최신리스트
				// 고정
				$where = array(
					'brd_id' => 1,
					'post_notice' => 1,
				);
				$this->db->select('post_id, post_title, post_datetime');
				//$this->db->from('post');
				$this->db->where($where);
				$this->db->order_by('post_datetime', 'desc');
				$this->db->limit(3, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['notice_fix']['list'] = $qry->result_array();
				foreach($view['view']['data']['notice_fix']['list'] as $k => $v){
					$view['view']['data']['notice_fix']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['notice_fix']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}
				$cnt_notice_fix = count($view['view']['data']['notice_fix']['list']);

				// 일반
				$where = array(
					'brd_id' => 1,
				);
				$this->db->select('post_id, post_title, post_datetime');
				//$this->db->from('post');
				$this->db->where($where);
				$this->db->order_by('post_datetime', 'desc');
				$this->db->limit(3-$cnt_notice_fix, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['notice']['list'] = $qry->result_array();
				foreach($view['view']['data']['notice']['list'] as $k => $v){
					$view['view']['data']['notice']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['notice']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}

				// 기업 공지사항 최신리스트
				// 고정
				$where2 = array(
					'post.brd_id' => 2,
					'post.post_notice' => 1,
					'member.company_idx' => $this->member->item('company_idx'),
				);
				$this->db->select('post_id, post.post_title, post.post_datetime');
				//$this->db->from('post');
				$this->db->join('member', 'member.mem_id = post.mem_id', 'left');
				$this->db->where($where2);
				$this->db->order_by('post.post_datetime', 'desc');
				$this->db->limit(3, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['cnotice_fix']['list'] = $qry->result_array();
				foreach($view['view']['data']['cnotice_fix']['list'] as $k => $v){
					$view['view']['data']['cnotice_fix']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['cnotice_fix']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}
				$cnt_cnotice_fix = count($view['view']['data']['cnotice_fix']['list']);

				// 일반
				$where2 = array(
					'post.brd_id' => 2,
					'member.company_idx' => $this->member->item('company_idx'),
				);
				$this->db->select('post_id, post.post_title, post.post_datetime');
				//$this->db->from('post');
				$this->db->join('member', 'member.mem_id = post.mem_id', 'left');
				$this->db->where($where2);
				$this->db->order_by('post.post_datetime', 'desc');
				$this->db->limit(3-$cnt_cnotice_fix, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['cnotice']['list'] = $qry->result_array();
				foreach($view['view']['data']['cnotice']['list'] as $k => $v){
					$view['view']['data']['cnotice']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['cnotice']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}

				// 모바일 공지사항 최신리스트
				// 고정
				$where = array(
					'brd_id' => 1,
					'post_notice' => 1,
				);
				$this->db->select('post_id, post_title, post_datetime');
				//$this->db->from('post');
				$this->db->where($where);
				$this->db->order_by('post_datetime', 'desc');
				$this->db->limit(4, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['mnotice_fix']['list'] = $qry->result_array();
				foreach($view['view']['data']['mnotice_fix']['list'] as $k => $v){
					$view['view']['data']['mnotice_fix']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['mnotice_fix']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}
				$cnt_mnotice_fix = count($view['view']['data']['mnotice_fix']['list']);

				// 일반
				$where = array(
					'brd_id' => 1,
				);
				$this->db->select('post_id, post_title, post_datetime');
				//$this->db->from('post');
				$this->db->where($where);
				$this->db->order_by('post_datetime', 'desc');
				$this->db->limit(4-$cnt_mnotice_fix, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['mnotice']['list'] = $qry->result_array();
				foreach($view['view']['data']['mnotice']['list'] as $k => $v){
					$view['view']['data']['mnotice']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['mnotice']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}

				// 모바일 기업 공지사항 최신리스트
				// 고정
				$where2 = array(
					'post.brd_id' => 2,
					'post.post_notice' => 1,
					'member.company_idx' => $this->member->item('company_idx'),
				);
				$this->db->select('post_id, post.post_title, post.post_datetime');
				//$this->db->from('post');
				$this->db->join('member', 'member.mem_id = post.mem_id', 'left');
				$this->db->where($where2);
				$this->db->order_by('post.post_datetime', 'desc');
				$this->db->limit(4, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['mcnotice_fix']['list'] = $qry->result_array();
				foreach($view['view']['data']['mcnotice_fix']['list'] as $k => $v){
					$view['view']['data']['mcnotice_fix']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['mcnotice_fix']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}
				$cnt_mcnotice_fix = count($view['view']['data']['mcnotice_fix']['list']);

				// 일반
				$where2 = array(
					'post.brd_id' => 2,
					'member.company_idx' => $this->member->item('company_idx'),
				);
				$this->db->select('post_id, post.post_title, post.post_datetime');
				//$this->db->from('post');
				$this->db->join('member', 'member.mem_id = post.mem_id', 'left');
				$this->db->where($where2);
				$this->db->order_by('post.post_datetime', 'desc');
				$this->db->limit(4-$cnt_mcnotice_fix, 0);
				$qry = $this->db->get('post');
				$view['view']['data']['mcnotice']['list'] = $qry->result_array();
				foreach($view['view']['data']['mcnotice']['list'] as $k => $v){
					$view['view']['data']['mcnotice']['list'][$k]['post_link'] = '/post/'.$v['post_id'];
					$view['view']['data']['mcnotice']['list'][$k]['post_datetime'] = date('Y.m.d', strtotime($v['post_datetime']));
				}

				// 수강정보
				// 수강중인 과정
				$where3 = array(
					'my_process.mem_id' => $this->member->item('mem_id'),
					'my_process.mp_endYn' => 'n',
					'lms_process.p_viewYn <>' => 'n',
				);
				$this->db->select('count(*) as cnt');
				$this->db->join('lms_process', 'lms_process.p_sno = my_process.p_sno', 'left');
				$this->db->where($where3);
				$qry = $this->db->get('my_process');
				$view['view']['data']['process_on'] = $qry->row_array();
				if($view['view']['data']['process_on']['cnt'] == 0){
					$view['view']['data']['process_on']['cnt'] = 0;
				}

				// 종료예정 과정
				$where4 = array(
					'my_process.mem_id' => $this->member->item('mem_id'),
					'my_process.mp_endYn' => 'n',
					'lms_process.p_viewYn <>' => 'n',
					'lms_process.p_edate >' => date("Y-m-d", strtotime("-7 Day")),
				);
				$this->db->select('count(*) as cnt');
				$this->db->join('lms_process', 'lms_process.p_sno = my_process.p_sno', 'left');
				$this->db->where($where4);
				$qry = $this->db->get('my_process');
				$view['view']['data']['process_scheduled_to_end'] = $qry->row_array();
				if($view['view']['data']['process_scheduled_to_end']['cnt'] == 0){
					$view['view']['data']['process_scheduled_to_end']['cnt'] = 0;
				}

				// 수강완료 과정
				$where5 = array(
					'my_process.mem_id' => $this->member->item('mem_id'),
					'my_process.mp_endYn' => 'y',
					'lms_process.p_viewYn <>' => 'n',
				);
				$this->db->select('count(*) as cnt');
				$this->db->join('lms_process', 'lms_process.p_sno = my_process.p_sno', 'left');
				$this->db->where($where5);
				$qry = $this->db->get('my_process');
				$view['view']['data']['process_completed'] = $qry->row_array();
				if($view['view']['data']['process_completed']['cnt'] == 0){
					$view['view']['data']['process_completed']['cnt'] = 0;
				}

				// 수강완료율 : 100 * (수강완료 / (수강중 + 수강완료))
				$view['view']['data']['process_percentage'] = 100 * ($view['view']['data']['process_completed']['cnt'] / ($view['view']['data']['process_on']['cnt'] + $view['view']['data']['process_completed']['cnt']));
				if(is_nan($view['view']['data']['process_percentage']) || $view['view']['data']['process_percentage'] == 'NAN'){
					$view['view']['data']['process_percentage'] = 0;
				} else {
					$view['view']['data']['process_percentage'] = floor($view['view']['data']['process_percentage']);
				}

				// 랭킹 정보(소속기업의 회원정보들만 가져오기)
				$where = array(
					'member.mem_id <>' => '',
					'member.company_idx' => $this->member->item('company_idx'),
					'game_field.crop_flag' => 1,
				);
				$this->db->select('game_field.mem_id, member.mem_username, member.mem_nickname, count(cb_game_field.field_idx) as cnt');
				$this->db->join('member', 'member.mem_id = game_field.mem_id', 'left');
				$this->db->where($where);
				$this->db->group_by('game_field.mem_id');
				$this->db->order_by('cnt', 'desc');
				$qry = $this->db->get('game_field');
				$view['view']['data']['ranking']['list'] = $rankingList = $qry->result_array();
				$rankingListCount = count($rankingList);
				unset($where);

				foreach($view['view']['data']['ranking']['list'] as $k => $v){
					$view['view']['data']['ranking']['list'][$k]['num'] = $k+1;
				}

				// 개인 포함 랭킹순위
				foreach($view['view']['data']['ranking']['list'] as $k => $v){
					if($v['mem_id'] == $this->member->item('mem_id')){
						$view['view']['data']['ranking']['myrank'] = $k+1;
						if($k >= 0 && $k <= 2){ // 위에서 3등 안에 있을 경우
							$view['view']['data']['ranking']['mylist'][0] = $view['view']['data']['ranking']['list'][0];
							$view['view']['data']['ranking']['mylist'][1] = $view['view']['data']['ranking']['list'][1];
							$view['view']['data']['ranking']['mylist'][2] = $view['view']['data']['ranking']['list'][2];
							$view['view']['data']['ranking']['mylist'][3] = $view['view']['data']['ranking']['list'][3];
							$view['view']['data']['ranking']['mylist'][4] = $view['view']['data']['ranking']['list'][4];
						} else if($k > 2 && $k < $rankingListCount - 2){ // 위에서 4등 ~ 밑에서 4등 사이인 경우
							$view['view']['data']['ranking']['mylist'][0] = $view['view']['data']['ranking']['list'][$k-2];
							$view['view']['data']['ranking']['mylist'][1] = $view['view']['data']['ranking']['list'][$k-1];
							$view['view']['data']['ranking']['mylist'][2] = $view['view']['data']['ranking']['list'][$k];
							$view['view']['data']['ranking']['mylist'][3] = $view['view']['data']['ranking']['list'][$k+1];
							$view['view']['data']['ranking']['mylist'][4] = $view['view']['data']['ranking']['list'][$k+2];
						} else { // 밑에서 3등 안에 있을 경우
							$view['view']['data']['ranking']['mylist'][0] = $view['view']['data']['ranking']['list'][$rankingListCount-5];
							$view['view']['data']['ranking']['mylist'][1] = $view['view']['data']['ranking']['list'][$rankingListCount-4];
							$view['view']['data']['ranking']['mylist'][2] = $view['view']['data']['ranking']['list'][$rankingListCount-3];
							$view['view']['data']['ranking']['mylist'][3] = $view['view']['data']['ranking']['list'][$rankingListCount-2];
							$view['view']['data']['ranking']['mylist'][4] = $view['view']['data']['ranking']['list'][$rankingListCount-1];
						}
					}
				}
			}
//			
		}else{
			redirect('login/logout');
		}
		
		
		//debug($mData);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function guest()
	{
		

		
		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'guest',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "게스트",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "게스트",
		);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	

//	/**
//	 *  스페이스 페이지
//	 */
//	public function test()
//	{
//		
//		$q = "select member_item  from cb_member where mem_id = '".$this->member->item('mem_id')."'";
//		$r = $this->db->query($q);
//		$mem_data = (array) $r->row();
//		debug($mem_data[member_item]);
//		debug(json_decode($mem_data[member_item], true));
//		exit;
//	}
	
	// 젭 통계 페이지 statistics
	public function test()
	{
		
		
//		$to = "123syuri@naver.com";
//
//		   $subject = "PHP 메일 발송";
//
//		   $contents = "PHP mail()함수를 이용한 메일 발송 테스트";
//
//		   $headers = "From: diceworld@krepca.or.kr\r\n";
//		
//		
//		if(mail($to, $subject, $contents, $headers)) {
//			echo "메일발신 성공<br>";
//		}else{
//			echo "메일발신 실패<br>";
//		}
		
		phpinfo();
		//메일 수신주소
		$toEmail 	= "123syuri@naver.com";	

		//제목
		$subject="메일 테스트 세번째";

		//내용
		$content="내용이 들어갑니다";

		//한글 안깨지게 만들어줌
		$subject = "=?UTF-8?B?".base64_encode($subject)."?=";

		$headers .= 'From: cs2@collaborland.kr '. "\r\n";  
		$headers .= 'Reply-To: cs2@collaborland.kr ' . "\r\n"; 
		 // Return Path는 PHP 5.2 에서까지만 쓰였다는것 같다 의미없음
		 //$headers .= 'Return-Path: 보낸사람@보낸도메인.com ' . "\r\n";
		//참조
		//$headers .= 'CC: 보낸사람@보낸도메인.com ' ."\r\n";
		//숨은참조
		//$headers .= 'BCC: 보낸사람@보낸도메인.com ' . "\r\n";
		$headers .= 'Organization: Sender Organization ' . "\r\n";
		$headers .= 'MIME-Version: 1.0 ' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8 ' . "\r\n";
		$headers .= 'X-Priority: 3 ' ."\r\n" ;
		$headers .= 'X-Mailer: PHP". phpversion() ' ."\r\n" ;

		$mailResult = mail($toEmail, $subject, $content, $headers);

		if($mailResult) {
			echo "발송완료";
		}else{
			echo "발송X";
		}
		
		exit;
		
	}
	
	
	
	/**
	 *  스페이스 페이지
	 */
	public function test1()
	{
		$view['view']['mem_id'] = (int) $this->member->item('mem_id');
		
		if($_GET['mapid']){
			$view['view']['mapid'] = $_GET['mapid'];
		}else{
			$view['view']['mapid'] = 'n';
		}
//		$q = "select * from cb_seum_timer where seum_id = '".$_GET['id']."' and seum_map = '".$_GET['mapid']."' order by seum_sno desc";
//		$r = $this->db->query($q);
//		$time_arr = $r->result_array();
//		
//		if($time_arr[0]){ // 값이 존재할때
//			//시작 시간과 끝 시간을 비교해서 시작이 끝보다 크면 진행
//			//$seum_start = strtotime($time_arr[0]['seum_start']);
//			//$seum_end = strtotime($time_arr[0]['seum_end']);
//			if($time_arr[0][reset_yn] == 'n'){ //진행중
//				$view['view']['time_state'] = 'ing';
//			}else if($time_arr[0][reset_yn] == 'i'){ //일시 정지중
//				$view['view']['time_state'] = 'stop';
//			}else{ //리셋됨
//				$view['view']['time_state'] = 'reset';
//			}
//		}else{ //값이 존재하지 않으면 처음 온거 혹은 리셋
//			$view['view']['time_state'] = 'reset';
//		}
		
		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'test',
			'layout_dir' => 'basic',
			'mobile_layout_dir' => 'basic',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'basic',
			'mobile_skin_dir' => 'basic',
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
		
//		$q = "select * from cb_seum_timer where seum_id = '".$_GET['id']."' and seum_map = '".$_GET['mapid']."' order by seum_sno desc";
//		$r = $this->db->query($q);
//		$time_arr = $r->result_array();
//		
//		if($time_arr[0]){ // 값이 존재할때
//			//시작 시간과 끝 시간을 비교해서 시작이 끝보다 크면 진행
//			//$seum_start = strtotime($time_arr[0]['seum_start']);
//			//$seum_end = strtotime($time_arr[0]['seum_end']);
//			if($time_arr[0][reset_yn] == 'n'){ //진행중
//				$view['view']['time_state'] = 'ing';
//			}else if($time_arr[0][reset_yn] == 'i'){ //일시 정지중
//				$view['view']['time_state'] = 'stop';
//			}else{ //리셋됨
//				$view['view']['time_state'] = 'reset';
//			}
//		}else{ //값이 존재하지 않으면 처음 온거 혹은 리셋
//			$view['view']['time_state'] = 'reset';
//		}
		
		
		$layoutconfig = array(
			'path' => 'myland',
			'layout' => 'layout',
			'skin' => 'test2',
			'layout_dir' => 'basic',
			'mobile_layout_dir' => 'basic',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'basic',
			'mobile_skin_dir' => 'basic',
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
	 * 상태명 저장하기
	 */
	public function setMemState()
	{
		$post = $this->input->post();

		if($post['mode'] == 'setMemState'){
			$sql = "UPDATE cb_member SET mem_state = '".$post['mem_state']."' WHERE mem_id = '".$post['mem_id']."'";
            $this->db->query($sql);

			$result['code'] = 'ok';
            $result['msg'] = 'data save complete';
		} else {
			$result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
	}


	/**
	 * 
	 * Event 페이지
	 * 
	 */
	public function event() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'event',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "Event",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "Event",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	 /**
	  * 
	  * calendar 페이지
	  *
	  */
	  public function calender() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'calender',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "calender",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "calender",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

	  }

	  /**
	   * 
	   * survey 페이지
	   * 
	   */
	  public function survey() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'survey',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "Event",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "Survey",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

	  }

	    /**
	   * 
	   * survey Response 페이지
	   * 
	   */
	  public function surveyResponse() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'surveyResponse',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "SurveyResponse",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "SurveyResponse",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

	  }

	   /**
	   * 
	   * survey Result 페이지
	   * 
	   */
	  public function surveyResult() {
		$view = array();
		$view['view'] = array();

		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'surveyResult',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "SurveyResult",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "SurveyResult",
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));

	  }

}
