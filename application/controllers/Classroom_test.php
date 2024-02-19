<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classroom_test class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 마이페이지와 관련된 controller 입니다.
 */
class Classroom_test extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Classroom');
	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Classroom_model';
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
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'main',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "클래스룸",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "클래스룸",
		);
		$today = date("Ymd");
		//$where[] = "(cb_lms_process.p_viewYn = 'y' or (cb_lms_process.p_viewYn = 's' and cb_lms_process.p_sdate <= ".$today." and cb_lms_process.p_edate >= ".$today."))";
		$basic_where[] = "(p.p_viewYn = 'y' or (p.p_viewYn = 's' and p.p_sdate <= ".$today." and p.p_edate >= ".$today."))";
		//수강중인강의
//		$my_where = $basic_where;
//		$my_where[] = 
		$q = "select p.p_title, p.p_thumbnail, p.p_sno as index2 , mp.mp_endYn from cb_lms_process as p inner join cb_my_process as mp on p.p_sno = mp.p_sno where ".implode(" and ",$basic_where)." order by p.p_essentialYn  desc, p.p_recommendYn, p.p_sno desc limit 10";
		//debug($q);
		$r = $this->db->query($q);
		$view['now']['list'] = $r->result_array(); 
		//필수강의
		$ess_where = $basic_where;
		$ess_where[] = "p.p_essentialYn = 'y'";
		$q = "select p.p_title, p.p_thumbnail, p.p_sno as index2 , mp.* from cb_lms_process as p left join cb_my_process as mp on p.p_sno = mp.p_sno where ".implode(" and ",$ess_where)." order by p.p_essentialYn  desc, p.p_recommendYn, p.p_sno desc limit 10";
		$r = $this->db->query($q);
		$view['ess']['list'] = $r->result_array(); 
		//debug($view['ess']['list']);
		//추천강의
		$rec_where = $basic_where;
		$rec_where[] = "p.p_recommendYn = 'y'";
		$q = "select p.p_title, p.p_thumbnail, p.p_sno as index2 , mp.* from cb_lms_process as p left join cb_my_process as mp on p.p_sno = mp.p_sno where ".implode(" and ",$rec_where)." order by p.p_recommendYn desc, p.p_essentialYn, p.p_sno desc limit 10";
		$r = $this->db->query($q);
		$view['rec']['list'] = $r->result_array(); 
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 *  강의 상세
	 */
	public function detail()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'detail',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "강의상세",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "강의상세",
			);
		
		//프로젝트 정보
		$q = "select * from cb_lms_process where p_sno = '".$_GET[p_sno]."'";
		$r = $this->db->query($q);
		$view['p_data'] = (array) $r->row();
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function my_class()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'my_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "나의수강목록",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "나의수강목록",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function complete_class()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'complete_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "수강완료과정",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "수강완료과정",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function business_class()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'business_class',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "기업강의목록",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "기업강의목록",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function player()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'player',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "동영상 플레이어",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "동영상 플레이어",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	public function player_test()
	{
		
		//입뺀인지 확인
		if(!$_GET[mp_sno]){
			alert('올바른 경로로 접근해주세요!','/classroom');
		}else{
//			$q = "select c.cca_value, c.cca_id from cb_lms_process_category as pc left join cb_category as c on pc.cca_id = c.cca_id where pc.p_sno = '".$_GET[p_sno]."' order by c.cca_parent asc, c.cca_order";
//			$r = $this->db->query($q);
//			$view['category']['list'] = $r->result_array(); 
			
			$q = "select mp.*, p.* from cb_my_process as mp inner join cb_lms_process as p on mp.p_sno = p.p_sno where mp.mp_sno = '".$_GET[mp_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
			$r = $this->db->query($q);
			$my_process = (array) $r->row();
			
			if($my_process[mp_sno]){
				$business_exYn = business_exYn($my_process[p_sno],$this->member->item('company_idx'));
				if($business_exYn == 'y'){
					alert('비활성화 된 강의입니다. 관리자에 문의해주세요!','/classroom');
				}else{
					//기업 등급과 노출 추가등을 따져서 수강신청이 가능한지 판단함 f면 뻥카, y 면 수강신청가능, n 이면 불가
					$view['business_studyYn'] = business_studyYn($my_process[p_sno],$this->member->item('company_idx'));
					//가능한 것 중에 난 이미 수강신청했는지
					$q = "select mp_sno from cb_my_process where p_sno = '".$my_process[p_sno]."' and mem_id = '".$this->member->item('mem_id')."'";
					$r = $this->db->query($q);
					$my_process2 = (array) $r->row();
					if($my_process2[mp_sno]){ //이미 했다면 a
						
						$q = "select mps.* from cb_my_process as mp left join cb_my_process_sub as mps on mp.mp_sno = mps.mp_sno where mp.mp_sno = '".$_GET[mp_sno]."' and mp.mem_id = '".$this->member->item('mem_id')."'";
						$r = $this->db->query($q);
						$curriculum = $r->result_array();
						$moveYn = 0; //이동 가능 커리큘럼
						foreach ($curriculum as $k => $v){
							//이동 가능 커리큘럼, 완료된게 있으면 그거보다 하나 + 하도록
							if($v[mps_endYn] == 'y'){
								$moveYn++;	
							}
							//커리큘럼 번호가 있다면 가능여부 판단
							if($_GET[mps_sno]){
								if($v[mps_sno] == $_GET[mps_sno]){ //커리큘럼 배열의 키값 찾기
									$mps_sno = $v[mps_sno];
								}
							}
							
							if($v[mps_type] == 'v'){
								$q = "select video_name, video_url from cb_video where video_idx = '".$v[t_sno]."'";
								$r = $this->db->query($q);
								$t_sno = (array) $r->row();
								$curriculum[$k][title] = $t_sno[video_name]."(영상)";
								$curriculum[$k][video_url] = $t_sno[video_url];
							}else if($v[mps_type] == 'g'){
								$q = "select g_nm from cb_gamecontents where g_sno = '".$v[t_sno]."'";
								$r = $this->db->query($q);
								$t_sno = (array) $r->row();
								$curriculum[$k][title] = $t_sno[g_nm]."(게임)";
							}else{
								$curriculum[$k][title] = "씨앗 ".$v[t_sno]."개 지급";
							}
							$last_no = $k;
							
						}
						$curriculum[$moveYn][moveYn] = 'y';
						if(!$_GET[mps_sno]){
							$curriculum[0]['active'] = "active";
							if($curriculum[0][mps_type] == 's'){ //이동 단계가 씨앗일때
								if($curriculum[0][mps_endYn] == 'y'){
									alert('이미 수령하셨어요','/classroom/player?mp_sno='.$_GET[mp_sno]);
								}else{
									redirect('/classroom/process_ps?mode=s&&mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno]);
								}
							}else if($curriculum[0][mps_type] == 'g'){
								redirect('/classroom/game?mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno]);
							}else{
								$my_process['video_url'] = $curriculum[0][video_url];
							}
							$mps_sno = $curriculum[0][mps_sno];
						}else{
							if($curriculum[$mps_sno][moveYn] == 'y' || $curriculum[$mps_sno][mps_endYn] == 'y'){ //이동가능할때
								if($curriculum[$mps_sno][mps_type] == 's'){ //이동 단계가 씨앗일때
									if($curriculum[$mps_sno][mps_endYn] == 'y'){
										alert('이미 수령하셨어요','/classroom/player?mp_sno='.$_GET[mp_sno]);
									}else{
										redirect('/classroom/process_ps?mode=s&&mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno]);
									}
								}else if($curriculum[$mps_sno][mps_type] == 'g'){
									redirect('/classroom/game?mp_sno='.$_GET[mp_sno].'&&mps_sno='.$_GET[mps_sno]);
								}else{
									$my_process['video_url'] = $curriculum[$mps_sno][video_url];
								}
								
								
							}else{
								alert('이전 커리큘럼을 완료해주세요!','/classroom/player?mp_sno='.$_GET[mp_sno]);
							}
						}
						
						
						
						$view['curriculum']['list'] = $curriculum; 
						
						//debug($curriculum);
						
						
						if($my_process[p_viewYn] == 'y'){
							$my_process['view_time'] = "상시 노출";
						}else{
							$my_process['view_time'] = substr($my_process[p_sdate], 0, 4).".".substr($my_process[p_sdate], 4, 2).".".substr($my_process[p_sdate], 6, 2)." ~ ".substr($my_process[p_edate], 0, 4).".".substr($my_process[p_edate], 4, 2).".".substr($my_process[p_edate], 6, 2);
						}
						//debug($my_process);
						$my_process[mps_sno] = $mps_sno;
						$view[my_process] = $my_process;
						
						//카테고리 
						$q = "select c.cca_value, c.cca_id from cb_lms_process_category as pc left join cb_category as c on pc.cca_id = c.cca_id where pc.p_sno = '".$my_process[p_sno]."' order by c.cca_parent asc, c.cca_order";
						$r = $this->db->query($q);
						$view['category']['list'] = $r->result_array(); 
						//debug($view['category']['list']);
						//debug($view[my_process]);
						
					}else{
						alert('신청하지 않는 강의입니다.!','/classroom');
					}
				}
			}else{
				alert('존재하지 않는 강의입니다.. 관리자에 문의해주세요!','/classroom');
			}
		}
		
		$layoutconfig = array(
			'path' => 'classroom_test',
			'layout' => 'layout',
			'skin' => 'player_test',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "동영상 플레이어",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "동영상 플레이어",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function test_game()
	{
		
		$layoutconfig = array(
			'path' => 'classroom',
			'layout' => 'layout',
			'skin' => 'test_game',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 0,
			'use_mobile_sidebar' => 0,
			'skin_dir' => 'bootstrap',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "테스트 게임",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "테스트 게임",
			);
		
		
		
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

    // 동영상 재생시간 초기화
    public function setPlayerStart()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayStart'){
            $sql = "UPDATE cb_my_process_sub SET mps_sectionTime = '0' WHERE mps_sno = '".$post['mps_sno']."'";
            $this->db->query($sql);

			// 누적시간 체크해서 영상전체시간 90% 넘기면 완료처리
			$this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();

			if($row['mps_playTime'] / $post['maxduration'] * 100 >= 90){
				$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			}

            $result['code'] = 'ok';
            $result['msg'] = 'data save complete';
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 동영상 재생시간, 누적시간 저장하기(1분마다)
    public function setPlayerTime()
    {
        $post = $this->input->post();
        
        if($post['mode'] == 'chkPlayTime'){
			
			// 누적시간 체크해서 영상전체시간 90% 넘기면 완료처리
			$this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();

			if($row['mps_playTime'] / $post['maxduration'] * 100 >= 90){
				$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			}

            $this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
            $mps_playTime = $row['mps_playTime'] + 60;

			$where = array(
				'mps_sectionTime' => $post['mps_sectionTime'],
				'mps_sno' => $post['mps_sno'],
			);
            $this->db->select('count(*) as cnt');
            $this->db->where($where);
            $datas = $this->db->get('my_process_sub');
            $rows = $datas->row_array();

            if($rows['cnt'] > 0){
				$result['code'] = 'fail';
            	$result['msg'] = 'already been saved';
            } else {
				$sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."', mps_sectionTime = '".$post['mps_sectionTime']."' WHERE mps_sno = '".$post['mps_sno']."'";
                $this->db->query($sql);

				$result['code'] = 'ok';
            	$result['msg'] = 'data save complete';
			}
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 동영상 90% 시청 시 완료처리
    public function setPlayerComplete()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayComplete'){
            $sql = "UPDATE cb_my_process_sub SET mps_endYn = '".$post['mps_endYn']."' WHERE mps_sno = '".$post['mps_sno']."'";
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

    // 동영상 100% 시청 시 나머지시간 더하기
    public function setPlayerEnd()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayEnd'){
            $this->db->select('mps_playTime, mps_sectionTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
            $mps_playTime = $row['mps_playTime'] + $post['remainTime'];

            $sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."', mps_timeline = '".$row['mps_sectionTime']."' WHERE mps_sno = '".$post['mps_sno']."'";
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

    // 동영상 시청 시 페이지 벗어나는 경우 초만 더하기
    public function setPlayerOut()
    {
        $post = $this->input->post();

        if($post['mode'] == 'chkPlayOut'){
            $this->db->select('mps_playTime, mps_sectionTime, mps_timeline');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();
            
            $mps_playTime = $row['mps_playTime'] + $post['seconds'];

			if($row['mps_sectionTime'] > $row['mps_timeline']){
				$sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."', mps_timeline = '".$row['mps_sectionTime']."' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			} else {
				$sql = "UPDATE cb_my_process_sub SET mps_playTime = '".$mps_playTime."' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);
			}
            

            $result['code'] = 'ok';
            $result['msg'] = 'data save complete';
        } else {
            $result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

	// 동영상 누적시간 체크
	public function getPlayerAccumulatedTime()
	{
		$post = $this->input->post();

		if($post['mode'] == 'chkPlayAccumulatedTime'){
			$this->db->select('mps_playTime');
            $this->db->where('mps_sno', $post['mps_sno']);
            $data = $this->db->get('my_process_sub');
            $row = $data->row_array();

			if($row['mps_playTime'] / $post['maxduration'] * 100 >= 90){
				$sql = "UPDATE cb_my_process_sub SET mps_endYn = 'y' WHERE mps_sno = '".$post['mps_sno']."'";
            	$this->db->query($sql);

				$result['code'] = 'ok';
            	$result['msg'] = 'data save complete';
			} else {
				$result['code'] = 'fail';
            	$result['msg'] = 'not yet complete';
			}
		} else {
			$result['code'] = 'fail';
            $result['msg'] = 'mode is incorrect';
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
	}
}
