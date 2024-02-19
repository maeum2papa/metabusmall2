<?php
echo busiIcon($this->member->item('company_idx'));
echo busiNm($this->member->item('company_idx'));

$user_info = $this->member->item('mem_id');
?>



<div id="asmo_dashboard">
	
	<div id="asmo_dashboard_main">
		

		<div class="dashboard_main">
			<div class="dashboard_top_banner">
				<!-- <?=banner('dashboard_top_banner')?> -->
			</div>

			<div class="dashboard_main_wrapper">
				<div class="dashboard_main_contents">
					<div class="dashboard_main_contents_top">
						<div class="contents_top_left">
							<div class="contents_top_left_img">
								<!-- 유저 이미지 들어갈 곳 -->
								<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png?v=<?php echo mt_rand(); ?>" alt="preview_img" onerror="this.onerror=null; this.src='<?php echo element('layout_skin_url', $layout); ?>/seum_img/preview/character_default.png'">
							</div>

							<div class="contents_top_left_info">
								<div class="contents_top_left_info_name">
									<strong><?php echo html_escape($this->member->item('mem_nickname')); ?></strong>
									<strong id="info_position"><?php echo html_escape($this->member->item('mem_position')); ?></strong>
								</div>
								<div class="contents_top_left_info_department">
									<span id="info_department"><?php echo html_escape($this->member->item('mem_div')); ?></span>
								</div>
							</div>

							<div class="contents_top_left_info_stateMsg">
								<strong>상태명</strong>

								<button id="statusButton"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg.svg" alt="statusMsg"></button>
								
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
							</div>
						</div>
						<div class="contents_top_middle">

							<div class="contents_top_middle_info">
								<div class="contents_top_middle_info_box status_box">
									<div class="etc_icon">
										<?=banner('fruit')?>
									</div>
									<div class="etc_info">
										<div class="etc_info_box">
											<span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?></span>
											개
										</div>
									</div>
								</div>

								<div class="contents_top_middle_info_box coin_box">
									<div class="etc_icon">
										<?=banner('coin')?>
									</div>
									<div class="etc_info">
										<div class="etc_info_box">
											<span id="fruit_count"><?php echo html_escape($this->member->item('mem_point')); ?></span>
											개
										</div>
									</div>
								</div>
							</div>
								
							<div class="contents_top_middle_bottom">
								<a href="<?php echo site_url('classroom/my_class'); ?>">
									<div class="contents_top_middle_bottom_box class">
										<div class="bottom_box_img">
											<?=banner('class')?>
										</div>
										<span>수강중인 과정</span>
										<strong id="class_num"><?php echo element('cnt', element('process_on', element('data', $view))); ?></strong>
									</div>
								</a>
								
								<a href="<?php echo site_url('classroom/my_class'); ?>">
									<div class="contents_top_middle_bottom_box end">
										<div class="bottom_box_img">
											<?=banner('end')?>
										</div>
										<span>종료예정 과정</span>
										<strong id="end_num"><?php echo element('cnt', element('process_scheduled_to_end', element('data', $view))); ?></strong>
									</div>
								</a>

								<a href="<?php echo site_url('classroom/complete_class'); ?>">
									<div class="contents_top_middle_bottom_box graduation">
										<div class="bottom_box_img">
											<?=banner('graduation')?>
										</div>
										<span>수강완료 과정</span>
										<strong id="graduation_num"><?php echo element('cnt', element('process_completed', element('data', $view))); ?></strong>
									</div>
								</a>
							</div>

							<div class="contents_top_middle_bottom_box_wrap">
								<span>수강 완료율</span>

								<div class="enroll_rate_bar">
									<div class="enroll_rate_bar_fill" style="width: <?php echo element('process_percentage', element('data', $view)); ?>%;"></div>
								</div>

								<span id="enroll_rate"><?php echo element('process_percentage', element('data', $view)); ?></span><span>%</span>
							</div>


						</div>


						<div class="contents_top_right">
							<div class="contents_top_right_top_box">
								<strong>랭킹 정보</strong>

								<table>
									<tr>
										<th>순위</th>
										<th>이름</th>
										<th>누적열매개수</th>
									</tr>
									<?php foreach (element('mylist', element('ranking', element('data', $view))) as $result) { ?>
										<tr>
											<td><span id="1st_rank"><?php echo $result['num']; ?></span></td>
											<td><span id="1st_name"><?php if($result['mem_username']){ echo $result['mem_username']; } else { echo $result['mem_nickname']; }?></span></td>
											<td><span id="1st_enroll_rate"><?php echo $result['cnt']; ?></span>개</td>
										</tr>
									<?php } ?>
								</table>

								<a href="javascript:;" class="lank_box">
									<?=banner('plus')?>
								</a>
							</div>

							
						</div>
					</div>
					
					<div class="dashboard_main_contents_bottom">
						<div class="contents_bottom_left">

							<div class="notice_box">
								<div class="panel">
									<div class="panel-heading">
										공지사항
										<div class="view-all pull-right">
											<a href="<?php echo site_url('board/notice'); ?>"></a>
										</div>
									</div>

									<div class="table-responsive">
										<div class="table_wrap">
											<?php foreach (element('list', element('notice', element('data', $view))) as $result) { ?>
												<a href="<?php echo element('post_link', $result); ?>" class="table_row">
													<span><?php echo html_escape(element('post_title', $result)); ?></span>
													<span class="px80"><?php echo element('post_datetime', $result); ?></span>
												</a>
											<?php } ?>
										</div>
									</div>

								</div>
							</div>

							<div class="notice_box">
								<div class="panel">
									<div class="panel-heading">
										<?=busiNm($this->member->item('company_idx'))?> 공지사항
										<div class="view-all pull-right">
											<a href="<?php echo site_url('board/cnotice'); ?>"></a>
										</div>
									</div>

									<div class="table-responsive">
										<div class="table_wrap">
											<?php foreach (element('list', element('cnotice', element('data', $view))) as $result) { ?>
												<a href="<?php echo element('post_link', $result); ?>" class="table_row">
													<span><?php echo html_escape(element('post_title', $result)); ?></span>
													<span class="px80"><?php echo element('post_datetime', $result); ?></span>
												</a>
											<?php } ?>
											
										</div>
									</div>

								</div>
							</div>

						</div>
						<div class="contents_bottom_middle">

							<div class="link_box">
								<a href="<?php echo site_url('board/qna'); ?>">컬래버랜드 문의 바로가기</a>
							</div>

							<div class="link_box company">
								<a href="<?php echo site_url('board/cqna'); ?>"><?=busiNm($this->member->item('company_idx'))?> 문의 바로가기</a>
							</div>

							<div class="link_box faq">
								<a href="<?php echo site_url('faq/faq'); ?>">FAQ 바로가기</a>
							</div>

						</div>
						<div class="contents_bottom_right">
							<div class="swiper mySwiper dashboard_adv_box">
								<div class="swiper-wrapper">
										<?=banner('dashboard_adv','','','<li class="swiper-slide">','</li>')?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
	$(document).ready(function() {

		// asmo sh 231221 시간대 별 하늘 이미지 변경 스크립트
		var now = new Date();
		var hour = now.getHours();

		console.log(hour);

		if (hour >= 6 && hour < 16) {
			$('#asmo_dashboard_main .dashboard_main .dashboard_top_banner').addClass('day');
		} else if (hour >= 16 && hour < 19) {
			$('#asmo_dashboard_main .dashboard_main .dashboard_top_banner').addClass('sunset');
		} else if (hour >= 19 && hour < 6) {
			$('#asmo_dashboard_main .dashboard_main .dashboard_top_banner').addClass('night');
		}

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
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		// $('.sidebar').addClass('dn');
		$('footer').addClass('dn');

		$('.main').addClass('add');


		// asmo sh 231120 대시보드 메인 페이지 상단 좌측 상태명 수정 스크립트
		$('.contents_top_left_info_stateMsg button').on('click', function() {
			toggleEditMode();
		});

		$('.contents_top_left_info_stateMsg input').on('keyup', function(event) {
			if (event.key === 'Enter') {
				updateStateName();
			}
		});

		function toggleEditMode() {
			var spanElement = $('.contents_top_left_info_stateMsg span');
			var inputElement = $('.contents_top_left_info_stateMsg input');

			var statusButton = $('#statusButton img');


			if (spanElement.is(':visible')) {
				
				
				spanElement.hide();

				inputElement.show();

				inputElement.val(spanElement.text()).show().focus();

				statusButton.attr('src', '<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg_edit.svg');
			} else {
				
				updateStateName();
			}
		}

		function updateStateName() {
			var stateName = $('.contents_top_left_info_stateMsg input').val().trim();
			var spanElement = $('.contents_top_left_info_stateMsg span');

			var statusButton = $('#statusButton img');


			if (stateName !== '') {
				spanElement.text(stateName).show();
				$('.contents_top_left_info_stateMsg input').hide();

				statusButton.attr('src', '<?php echo element('layout_skin_url', $layout); ?>/seum_img/dashboard/statusMsg.svg');

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