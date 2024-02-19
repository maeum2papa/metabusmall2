<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Jerryst class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>서비스관리>서베이 관리 controller 입니다.
 */
class Survey extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'servicing/survey';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Company_info','Member_meta', 'Member_group', 'Member_group_member', 'Member_nickname', 'Member_extra_vars', 'Member_userid', 'Social_meta');

	protected $modelname = 'Banner_click_log_model';

	public $per_page = 10;


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
		$this->load->library(array('pagination', 'upload', 'querystring'));

	}

	/**
	 * 기본 페이지를 가져오는 메소드입니다.
	 */
	public function index()
	{

		$eventname = 'event_admin_survey_index';
		$this->load->event($eventname);
		

		$view = array();
		$view['view'] = array();		

		// 이벤트가 존재하면 실행합니다.
		$view['view']['event']['before'] = Events::trigger('before', $eventname);



		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		$companyIdx = $this->member->get_member()["company_idx"];
		$where_condition = "WHERE company_idx = ${companyIdx}";
		$orderBy = "ORDER BY reg_date";
		$number = "ASC";
		$reverseNumber = "";

		$sort_option = $this->input->get('sort_option');

		if ($sort_option === "title" || $sort_option === "reg_date" || $sort_option === "end_date" || $sort_option === "real_participants_count") {
			$orderBy = "ORDER BY ${sort_option}";
		}

		$title = $this->input->get('survey_title');

		if (!empty($title)) {
			$where_condition = $where_condition." AND title LIKE '%${title}%'";
		}

		$start_date_start = $this->input->get('survey_start_date_start');
		$start_date_end = $this->input->get('survey_start_date_end');

		if (!empty($this->input->get("is_enabled_survey"))) {
			$where_condition = $where_condition." AND state = 'use'";
		}

		if (!empty($start_date_start) && !empty($start_date_end)) {
			$where_condition = $where_condition." AND start_date BETWEEN '${start_date_start}' AND '${start_date_end}'";
		} else if (empty($start_date_start) && !empty($start_date_end)) {
			$where_condition = $where_condition." AND start_date <= '${start_date_end}'";
		} else if (!empty($start_date_start) && empty($start_date_end)) {
			$where_condition = $where_condition." AND start_date >= '${start_date_start}'";
		}

		$end_date_start = $this->input->get('survey_end_date_start');
		$end_date_end = $this->input->get('survey_end_date_end');

		
		if (!empty($end_date_start) && !empty($end_date_end)) {
			$where_condition = $where_condition." AND end_date BETWEEN '${start_date_start}' AND '${start_date_end}'";
		} else if (empty($end_date_start) && !empty($end_date_end)) {
			$where_condition = $where_condition." AND end_date <= '${end_date_end}'";
		} else if (!empty($end_date_start) && empty($end_date_end)) {
			$where_condition = $where_condition." AND end_date >= '${end_date_start}'";
		}
		


		if ($number == "ASC") {
			$reverseNumber = "DESC";
		} else {
			$reverseNumber = "ASC";
		}

		$now = date('Y-m-d');

		$sql = "SELECT survey_id, title, reg_date, start_date, end_date, state, real_participants_count,
				CASE
					WHEN (start_date = '0000-00-00' || end_date = '0000-00-00') THEN ''
					WHEN (end_date < '${now}') THEN '설문 종료'
					WHEN (start_date <= '${now}') THEN '설문 중'
					WHEN (start_date > '${now}') THEN '설문 전'
				END AS date_status,
				CASE 
					WHEN (start_date <= '${now}' AND (start_date != '0000-00-00' AND end_date != '0000-00-00')) THEN 'n'
				ELSE 'y'
				END AS can_editable,
				ROW_NUMBER() 
				OVER(${orderBy} ${number}, survey_id ${number}) AS order_column FROM cb_survey_list ${where_condition}";


		// where 검색 조건 추가
		// 페이징 처리
		$sql = $sql." ${orderBy} ${reverseNumber}, survey_id ${reverseNumber} LIMIT ${offset}, ${per_page}";		


		$result = $this->db->query($sql);		

		$view['view']['data']['list'] = $result->result_array();
		$row_sql = "SELECT COUNT('survey_id') AS total_rows FROM cb_survey_list ${where_condition}";


		$total_rows = $this->db->query($row_sql)->row_array()["total_rows"];

		$view['view']['data']['total_rows'] = $total_rows;


		
		/**
	 	  * 페이지네이션을 생성합니다
	    */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;



		/**
		 * 
		 * 검색 옵션 및 추가 & 삭제 등 필요한 값들을 전달합니다.
		 * 
		 */

		 $view['view']['current_url'] = admin_url($this->pagedir);
		 $view['view']['write_url'] = admin_url($this->pagedir . '/write');
		 $view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());


		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}



	public function listupdate() {
		$eventname = 'event_admin_survey_listdelete';		
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);


		if ($this->input->post('chk') && is_array($this->input->post('chk')) && $this->input->post('change_active')) {
			$state =  $this->input->post('change_active');
			$today = date("Y-m-d");

			$count = 0;

			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					if ($state == "use") {
						$this->db->query("UPDATE cb_survey_list SET state = '$state' WHERE survey_id = $val AND end_date > $today");						
					} else if ($state == "unuse") {
						$this->db->query("UPDATE cb_survey_list SET state = '$state' WHERE survey_id = $val AND start_date > $today");						
					}

					$count = $count + $this->db->query("SELECT ROW_COUNT() AS c")->row_array()['c'];
				}
			}			
		}



		Events::trigger('after', $eventname);



		$this->session->set_flashdata(
			'message',
			$count.'건이 정상적으로 수정되었습니다.'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}

	/**
	 * 설문 수정 및 등록 페이지를 가져오는 메소드입니다.
	 */
	public function write()
	{

		$eventname = 'event_admin_survey_write';
		$this->load->event($eventname);
		

		$view = array();
		$view['view'] = array();		

		// 이벤트가 존재하면 실행합니다.
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$companyIdx = $this->member->get_member()["company_idx"];

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */


		$pid = $this->input->post('survey_id') ?: 0;

		if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}

		/**
		 *  수정이 가능한지 체크합니다.
		 * 
		 * 1. 권한문제
		 * 2. 기간이 지난 문제
		 * 
		 */


		/**
		 * 수정 페이지일 경우 기존에 작성했던 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata["info"] = $this->db->query("SELECT * FROM cb_survey_list WHERE survey_id = ${pid} AND company_idx = ${companyIdx}")->result_array();
			if (count($getdata["info"]) != 0) {
				$getdata["element"] = $this->db->query("SELECT * FROM cb_survey_element WHERE survey_id = ${pid}")->result_array();
				$getdata["participants"] = $this->db->query("SELECT participants.survey_id, mem.mem_id, mem.mem_position, mem.mem_username, mem.mem_email,
				 mem.mem_userid FROM cb_survey_participants as participants LEFT JOIN cb_member AS mem ON participants.mem_id = mem.mem_id WHERE survey_id = ${pid}")->result_array();
			}
		} else {
			$getdata["survey_list"] = $this->db->query("SELECT title, survey_id FROM cb_survey_list WHERE company_idx = ${companyIdx}")->result_array();
			$view['view']['load_url'] = admin_url($this->pagedir . '/getSurveyDetail');

		}


		$this->load->library('form_validation');
		
		// 추후 유효성 검사 체크
		$config = array(
			array(
				'field' => 'surveyName',
				'label' => '서베이 이름',
				'rules' => 'trim|required',
			),
		);

		$this->form_validation->set_rules($config);
		
		// 저장되는 경우 form - 실행됨
		
		if ($this->form_validation->run()) {			
			$post_data = $this->input->post();		
					
						
			/*echo "<pre>";
			print_r($post_data); // 모든 데이터를 print_r로 출력
			echo "</pre>";

			return;*/


			$survey_id = $this->input->post('survey_id') ?: 0;

			$surveyStart = $this->input->post('surveyStart');
			$surveyEnd = $this->input->post('surveyEnd');
			$shareResults = $this->input->post('shareResults') != "on" ? 'n' : 'y';
			$anonymousResponses = $this->input->post('anonymousResponses') != "on" ? 'n' : 'y';
			$surveyNotify = $this->input->post('surveyNotify') != "on" ? 'n' : 'y';

			$members_id = $this->input->post('members_id');
			$members_id_count = count($members_id);
			
			
			$surveyReward = $this->input->post('surveyReward') ?: 0;
			if (intval($surveyReward) < 0) {
				$surveyReward = 0;
			}

			$surveyName = $this->input->post('surveyName');
			$surveyDescript = $this->input->post('surveyDescript');			

			$state = 'unuse';

			if (empty($surveyStart) || empty($surveyEnd)) {
				$surveyStart = "NULL";
				$surveyEnd = "NULL";				
			} else {
				$state = 'use';
			}

			// survey 배열에서 데이터를 받음
			$survey = $this->input->post('survey');
			

			if ($survey_id) {	
				$temp = $survey_id;
				
				// 기업 유효 확인
				$survey_id = $this->db->query("SELECT survey_id FROM cb_survey_list WHERE company_idx = ${companyIdx} AND survey_id = ${survey_id}")->result_array()[0]["survey_id"];

				if (intval($survey_id) == 0) {
					$this->session->set_flashdata(
						'message',
						'유효하지 않은 설문입니다.'
					);
					$param =& $this->querystring;
					$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		
					redirect($redirecturl);
				}

				// 트렌잭션
				$this->db->trans_start();

				// 쿼리 -> 설문 저장
				$this->db->query("UPDATE cb_survey_list 
				SET title = '${surveyName}', 
					description = '${surveyDescript}', 
					start_date = '${surveyStart}', 
					end_date = '${surveyEnd}', 
					state = 'n', 
					expose_status = '${shareResults}', 
					is_anonymous = '${anonymousResponses}', 
					reward_point = ${surveyReward}, 
					noti_enabled = '${surveyNotify}', 
					total_participant_count = ${members_id_count}, 
					company_idx = ${companyIdx}, 
					file_name = '' 
				WHERE survey_id = ${survey_id} AND company_idx = ${companyIdx};");
			

				// 참가자 삭제
				$this->db->query("DELETE FROM `cb_survey_participants` WHERE survey_id = ${survey_id}");

				// 참가자 저장
				$count = count($members_id);
				for ($i = 0; $i < $count; $i++) {
					$mem_id = $members_id[$i];
					$this->db->query("INSERT INTO `cb_survey_participants`(`survey_id`, `mem_id`, `is_responded`) VALUES (${survey_id}, ${mem_id}, 'n')");
				};

		
				$surveyArray = $this->input->post('survey');

				// survey 아이템 삭제
				$this->db->query("DELETE FROM `cb_survey_element` WHERE survey_id = ${survey_id}");

				// survey 아이템 추가
				$count = 1;
				foreach ($surveyArray as $item) {
					$title = $item['title'];
					$type = $item['type'];
					$is_essential = "n";
					
					$can_etc_answer = 'n';
					$can_multiple_choice = 'n';
					$option_counts = 0;
					$element_type = "";

					$option_descriptions = '';					

					if ($item['questionType'] != null && $item['questionType']['is_essential'] == "on")  {
						$is_essential = 'y';
					}

					if ($item['questionType'] != null && $item['questionType']['can_etc_answer'] == "on")  {
						$can_etc_answer = 'y';
					}

					if ($item['questionType'] != null && $item['questionType']['can_multiple_choice'] == "on")  {
						$can_multiple_choice = 'y';
					}

					// type에 따라 다른 데이터에 접근
					switch ($type) {
						case 'sub_title':
							// sub_title에 대한 처리
							$element_type = "subtitle";
							break;
						case 'desc_field':
							// desc_field에 대한 처리
							$element_type = "desc_field";
							break;
						case 'division_line':
							// division_line에 대한 처리
							$element_type = "division-line";

							break;
						case 'FreeText':
							$element_type = "free_text";

							$freeTextAnswer = $item['answer'];				
							$option_counts = count($freeTextAnswer);
							for ($j = 0; $j < $option_counts; $j++) {
								if ($j != 0) {
									$option_descriptions = $option_descriptions."|";
								}
								$option_descriptions = $option_descriptions.$freeTextAnswer[$j];
							}
							break;
						case 'OEQ':
							$element_type = "oeq";						
							break;
						case 'fiveStar':
							$element_type = "5star";
							$option_counts = 11;
							break;
						case 'Percentage':
							$element_type = "percentage";
							$option_counts = 11;
							break;
						default:
							continue;
					}

					$this->db->query("INSERT INTO `cb_survey_element`(`survey_id`, `element_order`, `survey_element_type`,
					`is_essential`, `content`, `option_descriptions`, `can_etc_answer`, `can_multiple_choice`, `option_counts`) 
					VALUES (${survey_id}, ${count}, '${element_type}', '${is_essential}', '${title}', '${option_descriptions}', '${can_etc_answer}', '${can_multiple_choice}', ${option_counts})");
					$count = $count + 1;
				}
				

				$this->db->trans_complete();	
				if ($this->db->trans_status() == FALSE) {
					// 실패시 롤백
					$this->db->trans_rollback();				
	
					$this->session->set_flashdata(
						'warning',
						'저장에 실패했습니다.'
					);

					$param =& $this->querystring;
					$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		
					redirect($redirecturl);
		
					return;
	
				}

				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다.'
				);
				$param =& $this->querystring;
				$redirecturl = admin_url($this->pagedir . '?' . $param->output());
	
				redirect($redirecturl);
	
				return;
			}

			// 트렌잭션
			$this->db->trans_start();

			$this->db->query("INSERT INTO `cb_survey_list`(`title`, `description`, `start_date`, `end_date`, `state`, `expose_status`, `is_anonymous`, `reward_point`, `noti_enabled`, 
			`total_participant_count`, `real_participants_count`, `company_idx`, `file_name`) VALUES 
			('${surveyName}', '${surveyDescript}', '${surveyStart}', '${surveyEnd}', '${state}', '${shareResults}', '${anonymousResponses}', ${surveyReward}, '${surveyNotify}', ${members_id_count}, 0, ${companyIdx}, '')");

			$survey_id = $this->db->insert_id();

			// 쿼리 -> 설문 저장
			// 참가자 저장
			$count = count($members_id);
			for ($i = 0; $i < $count; $i++) {
				$mem_id = $members_id[$i];
				$this->db->query("INSERT INTO `cb_survey_participants`(`survey_id`, `mem_id`, `is_responded`) VALUES (${survey_id}, ${mem_id}, 'n')");
			}

			$surveyArray = $this->input->post('survey');

			$string = "";

			$count = 1;
			foreach ($surveyArray as $item) {
				$title = $item['title'];
				$type = $item['type'];
				$is_essential = "n";
				
				$can_etc_answer = 'n';
				$can_multiple_choice = 'n';
				$option_counts = 0;
				$element_type = "";

				$option_descriptions = '';

				
				if ($item['questionType'] != null && $item['questionType']['is_essential'] == "on")  {
					$is_essential = 'y';
				}

				if ($item['questionType'] != null && $item['questionType']['can_etc_answer'] == "on")  {
					$can_etc_answer = 'y';
				}

				if ($item['questionType'] != null && $item['questionType']['can_multiple_choice'] == "on")  {
					$can_multiple_choice = 'y';
				}

			
				// type에 따라 다른 데이터에 접근
				switch ($type) {
					case 'sub_title':
						// sub_title에 대한 처리
						$element_type = "subtitle";
						break;
					case 'desc_field':
						// desc_field에 대한 처리
						$element_type = "desc_field";
						break;
					case 'division_line':
						// division_line에 대한 처리
						$element_type = "division-line";

						break;
					case 'FreeText':
						$element_type = "free_text";

						$freeTextAnswer = $item['answer'];				
						$option_counts = count($freeTextAnswer);
						for ($j = 0; $j < $option_counts; $j++) {
							if ($j != 0) {
								$option_descriptions = $option_descriptions."|";
							}
							$option_descriptions = $option_descriptions.$freeTextAnswer[$j];
						}
						break;
					case 'OEQ':
						$element_type = "oeq";						
						break;
					case 'fiveStar':
						$element_type = "5star";
						$option_counts = 11;
						break;
					case 'Percentage':
						$element_type = "percentage";
						$option_counts = 11;
						break;
					default:
						continue;
				}

				$this->db->query("INSERT INTO `cb_survey_element`(`survey_id`, `element_order`, `survey_element_type`,
				`is_essential`, `content`, `option_descriptions`, `can_etc_answer`, `can_multiple_choice`, `option_counts`) 
				VALUES (${survey_id}, ${count}, '${element_type}', '${is_essential}', '${title}', '${option_descriptions}', '${can_etc_answer}', '${can_multiple_choice}', ${option_counts})");
				$count = $count + 1;

				$string = $string."<br>"."INSERT INTO `cb_survey_element`(`survey_id`, `element_order`, `survey_element_type`,
				`is_essential`, `content`, `option_descriptions`, `can_etc_answer`, `can_multiple_choice`, `option_counts`) 
				VALUES (${survey_id}, ${count}, '${element_type}', '${is_essential}', '${title}', '${option_descriptions}', '${can_etc_answer}', '${can_multiple_choice}', ${option_counts})";
			}

			// 트렌잭션 종료

			$this->db->trans_complete();	
			if ($this->db->trans_status() == FALSE) {
				// 실패시 롤백
				$this->db->trans_rollback();				

				$this->session->set_flashdata(
					'warning',
					'저장에 실패했습니다.'
				);

				return;
			}
			
			$this->session->set_flashdata(
				'message',
				'정상적으로 저장되었습니다.'
			);
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);

						
			/*echo "<pre>";
			print_r($post_data); // 모든 데이터를 print_r로 출력
			echo "</pre>";*/
				

			return;
		} 



		/**
		 * 
		 * 검색 옵션 및 추가 & 삭제 등 필요한 값들을 전달합니다.
		 * 
		 */
		 $view['view']['write_url'] = admin_url($this->pagedir . '/write');


		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'write');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		
		$view['view']['data'] = $getdata;
		
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));		
	}


	/**
	 * 
	 * 설문을 불러오는 메소드입니다. (API 전용)
	 * 
	 */
	public function getSurveyDetail($pid = 0) {
        /*if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $previous_url = admin_url($this->pagedir);            
            redirect($previous_url);
        }*/

		$companyIdx = $this->member->get_member()["company_idx"];


		$getdata = array();
		if ($pid) {
			$getdata["info"] = $this->db->query("SELECT * FROM cb_survey_list WHERE survey_id = ${pid} AND company_idx = ${companyIdx}")->result_array();
			if (count($getdata["info"]) != 0) {
				$getdata["element"] = $this->db->query("SELECT * FROM cb_survey_element WHERE survey_id = ${pid}")->result_array();
				$getdata["participants"] = $this->db->query("SELECT participants.survey_id, mem.mem_id, mem.mem_position, mem.mem_username, mem.mem_email,
				 mem.mem_userid FROM cb_survey_participants as participants LEFT JOIN cb_member AS mem ON participants.mem_id = mem.mem_id WHERE survey_id = ${pid}")->result_array();
			}
		}

		echo json_encode($getdata);		
	}



	/**
	 * 
	 * 
	 * 
	 */
	public function memberList()
	{
	
		/**
		 * 
		 *  부서 가져오기 
		 * 
		 */

		$companyIdx = $this->member->get_member()["company_idx"];


		$sql = "WITH RECURSIVE hierarchy AS ( 
			SELECT company_idx, cco_id, oc_id, oc_name, oc_parent, 0 AS level FROM cb_company_organ 
			WHERE oc_parent = 1 AND company_idx = ${companyIdx}
			UNION ALL SELECT t.company_idx, t.cco_id, t.oc_id, t.oc_name, t.oc_parent, h.level + 1 FROM cb_company_organ t
			JOIN hierarchy h ON t.oc_parent = h.oc_id WHERE t.company_idx = ${companyIdx}
		) 

		SELECT cco_id, company_idx, oc_id, oc_name, oc_parent, level FROM hierarchy";
		
        $results = $this->db->query($sql)->result_array();

		$level_1 = "<select class='form-control' name='2depth'  style='width: 150px;'><option selected disabled>2depth</option>";

		foreach ($results as $row) {
            if ($row['level'] == 0) {
				$level_1 = $level_1."<option value='".$row['oc_id']."'>".$row['oc_name']."</option>";
			}
        }

		$level_1 = $level_1."</select>";
		



		$view['view']['data']['level_1'] = $level_1;

		/**
		 * 레이아웃 설정
		 */

		$layoutconfig = array('layout' => 'layout_popup', 'skin' => 'memberList');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}


	public function test() {
	}

	/**
	 * 
	 * 	 
	 * 
	 */
	public function testSurvey($pid = 0) {
		$view = array();
		$view['view'] = array();

		$data_array = $this->db->query("SELECT * from cb_survey_list WHERE survey_id = ${pid}")->result_array();		
		$element_array = $this->db->query("SELECT * from cb_survey_element AS element WHERE element.survey_id = ${pid}")->result_array();		

		if (count($data_array) == 0) {
			echo "유효하지 않은 설문입니다.";
			
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());
			redirect($redirecturl);

			return;
		}




		
		$layoutconfig = array(
			'path' => 'dashboard',
			'layout' => 'layout',
			'skin' => 'surveyResponse',
			'layout_dir' => 'bootstrap',
			'mobile_layout_dir' => 'mobile',
			'use_sidebar' => 1,
			'use_mobile_sidebar' => 1,
			'skin_dir' => 'basic',
			'mobile_skin_dir' => 'mobile',
			'page_title' => "surveyResponse",
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => "sample_survey",
		);


		$view['view']['info'] = $data_array;
		$view['view']['element'] = $element_array;


		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function getMemberList()	
	{
		$this->load->model('Member_model');

		$view = array();
		$view['view'] = array();



		/***
		 * 
		 * 
		 * 
		 *		$end_date_start = $this->input->get('survey_end_date_start');
		 *		$end_date_end = $this->input->get('survey_end_date_end');
         *
		 *		
		 *		if (!empty($end_date_start) && !empty($end_date_end)) {
		 *			$where_condition = $where_condition." AND start_date BETWEEN '${start_date_start}' AND '${start_date_end}'";
		 *		}
		 * 
		 * 
		 */

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		

		$per_page = 5;
		$offset = ($page - 1) * $per_page;
		
		$this->Member_model->allow_search_field = array('mem_username', 'mem_nickname'); // 검색이 가능한 필드
		$this->Member_model->search_field_equal = array('mem_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->Member_model->allow_order_field = array('member.mem_id'); // 정렬이 가능한 필드

		$where = array();    
		
		$where['member.company_idx'] = $this->member->get_member()["company_idx"];

		if ($mgr_id = (int) $this->input->get('mgr_id')) {
			if ($mgr_id > 0) {
				$where['mgr_id'] = $mgr_id;
			}
		}

		$like = array();		
		
		if ($user_name = $this->input->get('username')) {
			$like['mem_username'] = $user_name;
		}
		
		
		$result = $this->Member_model
			->get_admin_list($per_page, $offset, $where, $like, null, null, null, null);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				$where = array(
					'mem_id' => element('mem_id', $val),
				);
				$result['list'][$key]['member_group_member'] = $this->Member_group_member_model->get('', '', $where, '', 0, 'mgm_id', 'ASC');
				$mgroup = array();
				if ($result['list'][$key]['member_group_member']) {
					foreach ($result['list'][$key]['member_group_member'] as $mk => $mv) {
						if (element('mgr_id', $mv)) {
							$mgroup[] = $this->Member_group_model->item(element('mgr_id', $mv));
						}
					}
				}
				$result['list'][$key]['member_group'] = '';
				if ($mgroup) {
					foreach ($mgroup as $mk => $mv) {
						if ($result['list'][$key]['member_group']) {
							$result['list'][$key]['member_group'] .= ', ';
						}
						$result['list'][$key]['member_group'] .= element('mgr_title', $mv);
					}
				}
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
				$result['list'][$key]['meta'] = $this->Member_meta_model->get_all_meta(element('mem_id', $val));
				$result['list'][$key]['social'] = $this->Social_meta_model->get_all_meta(element('mem_id', $val));

				$result['list'][$key]['num'] = $list_num--;
			}
		}

		$view['view']['data'] = $result;				
		$view['view']['all_group'] = $this->Member_group_model->get_all_group();
        $view['view']['company_list'] = $this->Company_info_model->get_company_list();

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $temp_model->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir)."/getMemberList" . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		echo '<table class="table table-hover table-bordered mg0">';
		echo '<tbody>';
		echo '<tr>';
		echo '<th>선택</th>';
		echo '<th>번호</th>';
		echo '<th>소속</th>';
		echo '<th>직급</th>';
		echo '<th>직원명</th>';
		echo '<th>아이디</th>';
		echo '<th>이메일</th>';
		echo '<th>입사일</th>';
		echo '<th>생일</th>';
		echo '<th>상태</th>';
		echo '</tr>';
		if(count($result['list'])>0){
			foreach($result['list'] as $k=>$v){
				echo '<tr>';
				echo '<td><input type="checkbox" name="mem_id[]" class="mem_id[]" value="'.$v['mem_id'].'"></td>';
				echo '<td>'.$v['mem_id'].'</td>';
				echo '<td name="mem_ocname[]"></td>';
				echo '<td name="mem_position[]"></td>';
				echo '<td name="mem_username[]">'.$v['mem_username'].'</td>';
				echo '<td name="mem_userid[]">'.$v['mem_userid'].'</td>';
				echo '<td name="mem_email[]">'.$v["mem_email"].'</td>';
				echo '<td></td>';
				echo '<td>'.$v["mem_birthday"].'</td>';
				echo '<td name="mem_useYn[]">'.(($v['mem_useYn']=='y')?"활성화":"비활성화").'</td>';
				echo '</tr>';
			}
		}
		echo '</tbody>';
		echo '</table>';
		
		echo "<div class='mt10 text-center mb20'>";
		echo $view['view']['paging'];
		echo "</div>";
	}


}
