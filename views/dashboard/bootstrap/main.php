<!-- <?php
echo busiIcon($this->member->item('company_idx'));
echo busiNm($this->member->item('company_idx'));

$user_info = $this->member->item('mem_id');
?> -->

<style>
	header, .navbar, footer { /* 각종메뉴 숨김처리 */
		display:none !important;
	}

	body {
		background-color: #F1F1F1;
	}
</style>


<div id="asmo_dashboard">
	
	<div id="asmo_dashboard_main">
		

		<div class="dashboard_main">
			<div class="dashboard_main_top dashboard_top_banner">
				<div class="dashboard_top_banner_blur"></div>
				<div class="dashboard_main_top_box">
					<h1>안녕하세요 <b><?php echo html_escape($this->member->item('mem_nickname')); ?>님</b> <br>오늘은 <?=busiNm($this->member->item('company_idx'))?>에 입사한지 365일 째 되는 날이에요!</h1>

					<div class="dashboard_top_adv">
						<?=banner('dashboard_top_adv')?>
					</div>
					
				</div>
			</div>

			<div class="dashboard_main_wrapper">
				<div class="dashboard_main_contents">
					<div class="dashboard_main_contents--left">

						<!-- 이벤트 있을 때 -->
						<div class="asmo_event_box">
							<strong id="asmo_event_content">오늘은 입사한 지 1년째 되는 특별한 날이에요. <br> 축하합니다!🎉</strong>
						</div>
						<!-- 이벤트 있을 때 -->

						<div class="dashboard_box user_info_box">						
							<div class="user_img_info_box">
								<div class="user_img_box">
									<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png?v=<?php echo mt_rand(); ?>" alt="preview_img" onerror="this.onerror=null; this.src='<?php echo element('layout_skin_url', $layout); ?>/seum_img/preview/character_default.png'">
								</div>
								<div class="user_info_wrap">
									<span class="info_department"><?php echo html_escape($this->member->item('mem_div')); ?></span>
									<strong class="info_name_position">
										<?php echo html_escape($this->member->item('mem_nickname')); ?> 
										<span class="info_position"><?php echo html_escape($this->member->item('mem_position')); ?></span>
									</strong>

									<div class="user_info_flex_box stateMsg">
										<strong>한줄인사</strong>

										<?php
										$memStateValue = html_escape($this->member->item('mem_state'));

										if ($memStateValue !== '') {
											
											echo '<span>' . $memStateValue . '</span>';
											echo '<input type="text" name="mem_state" maxlength=15 placeholder="상태명을 입력하세요" style="display: none;">';
										} else {
											
											echo '<span>상태명을 입력하세요</span>';
											echo '<input type="text" name="mem_state" maxlength=15 placeholder="상태명을 입력하세요" style="display: none;">';
										}
										?>

										<button id="statusButton"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg.png" alt="statusMsg"></button>
									</div>

									<div class="user_info_flex_box titleMsg">
										<strong>활성칭호</strong>

										<span>
											위대한 선구자
										</span>
										
										<button id="titleButton"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg.png" alt="titleMsg"></button>
									</div>
								</div>
							</div>

							<div class="user_rank_fruit_coin_box">
								<div class="asmo_rank_box rank_box">
									<div class="asmo_info_img_box">
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/ranking.svg" alt="ranking">
									</div>

									<div class="asmo_info_box">

										<!-- 랭킹 등수 -->
										<p>9위</p>
										<!-- 랭킹 등수 -->

									</div>
								</div>
								<div class="asmo_fruit_box status_box">
									<div class="asmo_info_img_box">
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.svg" alt="fruit">
									</div>
									<div class="asmo_info_box">
										<p><?php echo html_escape($this->member->item('mem_cur_fruit')); ?><span>개</span></p>
									</div>
								</div>
								<div class="asmo_coin_box coin_box">
									<div class="asmo_info_img_box">
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/point.svg" alt="point">
									</div>
									<div class="asmo_info_box">
										<p><?php echo html_escape($this->member->item('mem_point')); ?><span>개</span></p>
									</div>
								</div>
							</div>

							<div class="user_quest_box quest_menu_btn">
								<div class="user_quest_info">
									<p>일일퀘스트 현황</p>
									
									<p class="quest_result">
										1/5
									</p>
								</div>
							</div>
						</div>
						<div class="dashboard_box dashboard_banner_slider">
							<div class="swiper dashboard_adv_box">
								<div class="swiper-wrapper">
										<?=banner('dashboard_adv','','','<li class="swiper-slide">','</li>')?>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard_main_contents--mid">
						<div class="dashboard_box schedule_box">
							<div class="dashboard_box_title">
								<strong>이달의 일정 [5]</strong>
								<a href="<?php echo site_url('dashboard/calender'); ?>" class="schedule_box_btn">
									<?=banner('plus')?>
								</a>
							</div>

							<div class="dashboard_box_cont">
								<a href="javascript:void(0)" class="schedule_box_cont">
									<div class="schedule_box_cont_info">
										<p>팀메타 신년회</p>
									</div>
									<div class="schedule_box_cont_date">
										<span>2024-01-12</span>,
										<span>19:00</span>
									</div>
								</a>

								<a href="javascript:void(0)" class="schedule_box_cont">
									<div class="schedule_box_cont_info">
										<p>창립기념일</p>
									</div>
									<div class="schedule_box_cont_date">
										<span>2024-01-26</span>,
										<span>종일</span>
									</div>
								</a>

								<a href="javascript:void(0)" class="schedule_box_cont">
									<div class="schedule_box_cont_info">
										<p>2024 상반기 워크숍</p>
									</div>
									<div class="schedule_box_cont_date">
										<span>2024-01-28 ~ 2024-02-01</span>,
										<span>종일</span>
									</div>
								</a>

								<a href="javascript:void(0)" class="schedule_box_cont">
									<div class="schedule_box_cont_info">
										<p>2024 상반기 워크숍</p>
									</div>
									<div class="schedule_box_cont_date">
										<span>2024-01-28 ~ 2024-02-01</span>,
										<span>종일</span>
									</div>
								</a>


								<!-- 아무 일정 없을 시 -->
								<!-- <div class="empty_cont_box">
									<p>등록된 일정이 없습니다.</p>
								</div> -->
							</div>
						</div>
						<div class="dashboard_box event_box">
							<div class="dashboard_box_title">
								<strong>이달의 이벤트 [5]</strong>
								<a href="<?php echo site_url('dashboard/event'); ?>" class="event_box_btn">
									<?=banner('plus')?>
								</a>
							</div>

							<div class="dashboard_box_cont">
								<a href="" class="event_box_cont">
									<span>생일자</span>

									<div class="event_box_cont_info">
										<div class="event_img_box"><?=banner('event_birthday')?></div>
										<strong>15<span>명</span></strong>
									</div>
								</a>

								<a href="" class="event_box_cont">
									<span>결혼</span>

									<div class="event_box_cont_info">
										<div class="event_img_box"><?=banner('event_marriage')?></div>
										<strong>15<span>명</span></strong>
									</div>
								</a>

								<a href="" class="event_box_cont">
									<span>진급</span>

									<div class="event_box_cont_info">
										<div class="event_img_box"><?=banner('event_promotion')?></div>
										<strong>15<span>명</span></strong>
									</div>
								</a>

								<a href="" class="event_box_cont">
									<span>신규입사자</span>

									<div class="event_box_cont_info">
										<div class="event_img_box"><?=banner('event_join')?></div>
										<strong>15<span>명</span></strong>
									</div>
								</a>

								<a href="" class="event_box_cont">
									<span>성과왕</span>

									<div class="event_box_cont_info">
										<div class="event_img_box"><?=banner('event_etc')?></div>
										<strong>15<span>명</span></strong>
									</div>
								</a>

								<!-- 아무 이벤트 없을 시 -->
								<!-- <div class="empty_cont_box">
									<p>이번달에는 이벤트가 없어요</p>
								</div> -->
							</div>

						</div>
						<div class="dashboard_box courseStatus_box">
							<div class="dashboard_box_title">
								<strong>나의 수강 현황</strong>
							</div>

							<div class="courseStatus_box_cont">
								<div class="asmo_processOn_box">
									<a href="<?php echo site_url('classroom/my_class'); ?>" class="asmo_processOn_info">
										<p>수강중</p>
										<strong><?php echo element('cnt', element('process_on', element('data', $view))); ?></strong>
									</a>
								</div>
								<div class="asmo_processCompleted_box">
									<a href="<?php echo site_url('classroom/complete_class'); ?>" class="asmo_processCompleted_info">
										<p>수강완료</p>
										<strong><?php echo element('cnt', element('process_completed', element('data', $view))); ?></strong>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard_main_contents--right">
						<div class="dashboard_box survey_box">
							<div class="dashboard_box_title">
								<strong>설문조사</strong>
								<a href="<?php echo site_url('dashboard/survey'); ?>" class="survey_box_btn">
									<?=banner('plus')?>
								</a>
							</div>

							<div class="dashboard_box_cont">
								<a href="" class="survey_box_cont">
									<span class="survey_name">2024 직원 만족도 조사</span>
									<span class="survey_Yn">참여하기</span>
								</a>

								<a href="" class="survey_box_cont">
									<span class="survey_name">직장 내 괴롭힘 조사</span>
									<span class="survey_Yn complete">참여완료</span>
								</a>

								<a href="" class="survey_box_cont">
									<span class="survey_name">구내식당 운영 만족도 조사</span>
									<span class="survey_Yn">참여하기</span>
								</a>

								<a href="" class="survey_box_cont">
									<span class="survey_name">2024 직원 만족도 조사</span>
									<span class="survey_Yn">참여하기</span>
								</a>

								<a href="" class="survey_box_cont">
									<span class="survey_name">2024 직원 만족도 조사</span>
									<span class="survey_Yn">참여하기</span>
								</a>

								<!-- 아무 설문 없을 시 -->
								<!-- <div class="empty_cont_box">
									<p>등록된 설문이 없습니다.</p>
								</div> -->
							</div>
						</div>
						<div class="dashboard_box notice_box">
								<div class="panel">
									<div class="dashboard_box_title">
										<strong><?=busiNm($this->member->item('company_idx'))?> 공지사항</strong>
										<a href="<?php echo site_url('board/cnotice'); ?>" class="notice_box_btn">
											<?=banner('plus')?>
										</a>
									</div>

									<div class="table-responsive">
										<div class="table_wrap">
											<?php foreach (element('list', element('cnotice_fix', element('data', $view))) as $result) { ?>
												<a href="<?php echo element('post_link', $result); ?>" class="table_row">
													<span><?php echo html_escape(element('post_title', $result)); ?></span>
													<span class="px80"><?php echo element('post_datetime', $result); ?></span>
												</a>
											<?php } ?>
											<?php foreach (element('list', element('cnotice', element('data', $view))) as $result) { ?>
												<a href="<?php echo element('post_link', $result); ?>" class="table_row">
													<span><?php echo html_escape(element('post_title', $result)); ?></span>
													<span class="px80"><?php echo element('post_datetime', $result); ?></span>
												</a>
											<?php } ?>
											
											<!-- 아무 공지사항 없을 시 -->
											<!-- <div class="empty_cont_box">
												<p>등록된 공지사항이 없습니다.</p>
											</div> -->

										</div>
									</div>

								</div>

						</div>
						<div class="dashboard_box faq_box">
							<div class="link_box company">
								<a href="<?php echo site_url('board/cqna'); ?>">
									<span>기업담당자에게 궁금하신점이 있으신가요?</span>
									<strong><?=busiNm($this->member->item('company_idx'))?> 1:1 문의</strong>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- 일정 정보 팝업 -->
<div class="popup_layer_bg" id="schedule_info_popup">
	<div class="schedule_info_popup">
		<div class="schedule_info_popup_box">
			<div class="schedule_info_popup_title">
				<strong>창립기념일</strong>
			</div>
			<div class="schedule_info_popup_cont">
				<div class="schedule_info_popup_cont_info">
					<div class="schedule_date_box">
						<span class="schedule_date">2024-01-23 (화)</span>
						<span>종일</span>
					</div>
				</div>
				<div class="schedule_info_popup_cont_memo">
					<span>(주)팀메타의 창립기념일입니다.</span>
				</div>
			</div>
		</div>

		<button id="schedule_info_popup_close">닫기</button>
	</div>
</div>



<!-- 첫 로그인 시 이용안내 팝업 -->
<div class="popup_layer_bg" id="first_login_popup">
	<div class="first_login_popup">
		<div class="first_login_popup_box">
			<div class="first_login_popup_cont">
				<p>안녕하세요 <?php echo html_escape($this->member->item('mem_nickname')); ?>님😊</p>
				<p>컬래버랜드에 오신 걸 환영합니다! <br> 항해를 떠나기 전, 이용 가이드를 꼭 읽어보세요:)</p>
			</div>
			<div class="first_login_popup_btn">
				<a href="">컬래버랜드 이용가이드 보기</a>
			</div>

			<button id="first_login_popup_close">닫기</button>									
		</div>
	</div>
</div>


<script type="text/javascript">

	// 팝업창 스크립트
	$('.schedule_box_cont').on('click', function() {
		$('#schedule_info_popup').css('display', 'block');
	});

	$('#schedule_info_popup_close').on('click', function() {
		$('#schedule_info_popup').css('display', 'none');
	});

	// 이용안내 팝업창 닫기
	$('#first_login_popup_close').on('click', function() {
		$('#first_login_popup').css('display', 'none');
	});

	


	function updateBannerByHour() {
		var now = new Date();
		var hour = now.getHours();
		var bannerElement = $('.dashboard_top_banner');

		if (hour >= 6 && hour < 16) {
			updateBannerClass(bannerElement, 'day');
		} else if (hour >= 16 && hour < 19) {
			updateBannerClass(bannerElement, 'sunset');
		} else {
			updateBannerClass(bannerElement, 'night');
		}

		console.log("시간: " , hour);
	}

	function updateBannerClass(element, newClass) {
		element.removeClass(['day', 'sunset', 'night']).addClass(newClass);
	}

	setInterval(updateBannerByHour, 60000);


	updateBannerByHour();


	$(document).ready(function() {

		$('.asmo_event_box').addClass('on');

		$('#dashboard').addClass('selected');

		// asmo sh 231221 대시보드 메인 페이지 하단 우측 배너 슬라이드 스크립트
		const mySwiper = new Swiper('.dashboard_adv_box', {
			speed: 500,
			autoplay: {
			delay: 3000,
				disableOnInteraction: false,
			},
			loop: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});

		var user_info = <?php echo json_encode($user_info) ?>;
		console.log(user_info);

		// asmo sh 231114 대시보드 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트

		$('.main').addClass('add');


		// asmo sh 231120 대시보드 메인 페이지 상단 좌측 상태명 수정 스크립트
		$('.stateMsg button').on('click', function() {
			toggleEditMode();
		});

		$('.stateMsg input').on('keyup', function(event) {
			if (event.key === 'Enter') {
				updateStateName();
			}
		});

		function toggleEditMode() {
			var spanElement = $('.stateMsg span');
			var inputElement = $('.stateMsg input');

			var statusButton = $('#statusButton img');


			if (spanElement.is(':visible')) {
				
				
				spanElement.hide();

				inputElement.show();

				inputElement.val(spanElement.text()).show().focus();

				statusButton.attr('src', '<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg.svg');
			} else {
				
				updateStateName();
			}
		}

		function updateStateName() {
			var stateName = $('.stateMsg input').val().trim();
			var spanElement = $('.stateMsg span');

			var statusButton = $('#statusButton img');


			if (stateName !== '') {
				spanElement.text(stateName).show();
				$('.stateMsg input').hide();

				statusButton.attr('src', '<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg.png');

				$.ajax({
					method: "POST",
					url: "/dashboard/setMemState",
					data: {
						mode: 'setMemState',
						mem_id: '<?php echo $this->member->item('mem_id'); ?>',
						mem_state: stateName,
						csrf_test_name: cb_csrf_hash
					},
				}).success(function(data){
					var json = $.parseJSON(data);
					location.reload();
				}).error(function(e){
					console.log(e.responseText);
				});
			}
		}
	});
</script>