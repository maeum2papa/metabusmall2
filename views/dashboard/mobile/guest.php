<?php
// if (element('board_list', $view)) {
// 	foreach (element('board_list', $view) as $key => $board) {
// 		$config = array(
// 			'skin' => 'mobile',
// 			'brd_key' => element('brd_key', $board),
// 			'limit' => 5,
// 			'length' => 40,
// 			'is_gallery' => '',
// 			'image_width' => '',
// 			'image_height' => '',
// 			'cache_minute' => 1,
// 		);
// 		echo $this->board->latest($config);
// 	}
// }

?>
<style>
	/* 푸터 미노출 처리 */
	footer { display:none; }
</style>

<section id="asmo_dash_wrap">
	<article class="dash_top_wrap">
		<div class="forM" id="asmo_profile_forM">
			<div class="asmo_profile_left">
				<div class="asmo_profile_img_wrap">
					<!-- 유저 이미지 들어갈 곳 -->
					<img src="<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png?v=<?php echo mt_rand(); ?>" alt="preview_img" onerror="this.onerror=null; this.src='<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/character_default.png'">
				</div>
				<div class="asmo_info_wrap">
					<p class="asmo_name"><b><?php echo html_escape($this->member->item('mem_nickname')); ?></b><span><?php echo html_escape($this->member->item('mem_position')); ?></span></p>
					<p><?php echo html_escape($this->member->item('mem_div')); ?></p>
				</div>
			</div>
			<div class="asmo_profile_right">
				<div class="asmo_status_inner">
					<div class="asmo_status_btn_wrap">
						<strong>상태명</strong><button class="statusButton"></button>
					</div>
					<div class="asmo_status_input_wrap">
						<?php
							$memStateValue = html_escape($this->member->item('mem_state'));

							if ($memStateValue !== '') {
								
								echo '<span>' . $memStateValue . '</span>';
								echo '<input type="text" maxlength=15 placeholder="상태명을 입력하세요." style="display: none;">';
							} else {
								echo '<span style="display: none;"></span>';
								echo '<input class="asmo_status_before" type="text" maxlength=15 placeholder="상태명을 입력하세요.">';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="asmo_dash_cm_banner forM"><?=banner('dashboard_adv_mo')?></div>
	</article>
	<!-- 태블릿용 구조 -->
	<article class="dash_mid_wrap forT">
		<div id="asmo_member_profile">
			<div class="asmo_profile_top">
				<div class="asmo_profile_img_wrap">
					<!-- 유저 이미지 들어갈 곳 -->
					<img src="<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png?v=<?php echo mt_rand(); ?>" alt="preview_img" onerror="this.onerror=null; this.src='<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/character_default.png'">
				</div>
				<div class="asmo_info_wrap">
					<p class="asmo_name"><b><?php echo html_escape($this->member->item('mem_nickname')); ?></b><span><?php echo html_escape($this->member->item('mem_position')); ?></span></p>
					<p><?php echo html_escape($this->member->item('mem_div')); ?></p>
				</div>
			</div>
			<div class="asmo_profile_bottom">
				<div class="asmo_status_inner">
					<div class="asmo_status_btn_wrap">
						<strong>상태명</strong><button class="statusButton"></button>
					</div>
					<div class="asmo_status_input_wrap">
						<?php
							$memStateValue = html_escape($this->member->item('mem_state'));

							if ($memStateValue !== '') {
								
								echo '<span>' . $memStateValue . '</span>';
								echo '<input type="text" maxlength=15 placeholder="상태명을 입력하세요." style="display: none;">';
							} else {
								echo '<span style="display: none;"></span>';
								echo '<input class="asmo_status_before" type="text" maxlength=15 placeholder="상태명을 입력하세요.">';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div id="asmo_class_process">
			<ul>
				<li class="asmo_class_p_box ing">
					<a href="<?php echo site_url('classroom/my_class'); ?>">
						<span></span>
						<p>수강중</p>
						<strong><?php echo element('cnt', element('process_on', element('data', $view))); ?></strong>
					</a>
				</li>
				<li class="asmo_class_p_box soon">
					<a href="<?php echo site_url('classroom/my_class'); ?>">
						<span></span>
						<p>종료예정</p>
						<strong><?php echo element('cnt', element('process_scheduled_to_end', element('data', $view))); ?></strong>
					</a>	
				</li>
				<li class="asmo_class_p_box end">
					<a href="<?php echo site_url('classroom/complete_class'); ?>">
						<span></span>
						<p>수강완료</p>
						<strong><?php echo element('cnt', element('process_completed', element('data', $view))); ?></strong>
					</a>
				</li>
			</ul>
			<p class="asmo_average_bar_wrap">
				<span>수강 완료율</span>
				<em><i style="width:<?php echo element('process_percentage', element('data', $view)); ?>%"></i></em>
			</p>
		</div>
		<div id="asmo_rank_info">
			<div class="asmo_rank_inner">
				<h4>랭킹정보<span class="asmo_common_more asmo_rank_popup">더보기</span></h4>
				<ol>
					<li class="asmo_rank_tit">
						<span>순위</span>
						<span>이름</span>
						<span>누적열매</span>
					</li>
					<?php foreach (element('mylist', element('ranking', element('data', $view))) as $result) { ?>
						<li <?php if($result['mem_id'] == $this->member->item('mem_id')){ echo "class='active'"; } ?>>
							<span><em><?php echo $result['num']; ?></em></span>
							<span><?php if($result['mem_nickname']){ echo $result['mem_nickname']; } else { echo $result['mem_username']; }?></span>
							<span><?php echo $result['cnt']; ?>개</span>
						</li>
					<?php } ?>
				</ol>
			</div>
		</div>
	</article>
	<article class="dash_bottom_wrap forT">
		<div class="asmo_dash_board_container">
			<!-- asmo lhb 231215 태블릿용 공지 게시글 리스트 -->
			<div class="asmo_dash_list_wrap">
				<div class="asmo_list_common_tit"><b>컬래버랜드 공지사항</b><a class="asmo_common_more" href="<?php echo site_url('board/notice'); ?>">더보기</a></div>
				<!-- asmo lhb 231215 컬래버 공지사항 -->
				<ol>
					<li><a href="/"><span>컬래버랜드 공지사항 제목입니다. 컬래버랜드 공지사항 제목</span><em>2023.10.24</em></a></li>
					<li><a href="/"><span>컬래버랜드 공지사항 제목입니다. 컬래버랜드 공지사항 제목</span><em>2023.10.24</em></a></li>
					<li><a href="/"><span>컬래버랜드 공지사항 제목입니다. 컬래버랜드 공지사항 제목</span><em>2023.10.24</em></a></li>
				</ol>
				<!-- //asmo lhb 231215 컬래버 공지사항 -->
			</div>
			<div class="asmo_dash_list_wrap forT">
				<div class="asmo_list_common_tit"><b><?=busiNm($this->member->item('company_idx'))?> 공지사항</b><a class="asmo_common_more" href="<?php echo site_url('board/cnotice'); ?>">더보기</a></div>
				<!-- asmo lhb 231215 기업랜드 공지사항 -->
				<ol>
					<li><a href="/"><span>기업랜드 공지사항 제목입니다. 컬래버랜드 공지사항 제목</span><em>2023.10.24</em></a></li>
					<li><a href="/"><span>기업랜드 공지사항 제목입니다. 컬래버랜드 공지사항 제목</span><em>2023.10.24</em></a></li>
					<li><a href="/"><span>기업랜드 공지사항 제목입니다. 컬래버랜드 공지사항 제목</span><em>2023.10.24</em></a></li>
				</ol>
				<!-- //asmo lhb 231215 기업랜드 공지사항 -->
			</div>
			<!-- //asmo lhb 231215 태블릿용 공지 게시글 리스트 -->
		</div>
		<div class="asmo_dash_qa_wrap">
			<ul>
				<li class="orange"><a href="<?php echo site_url('board/qna'); ?>">컬래버랜드 문의하기</a></li>
				<li class="blue"><a href="<?php echo site_url('board/cqna'); ?>"><?=busiNm($this->member->item('company_idx'))?> 문의하기</a></li>
				<li class="black"><a href="<?php echo site_url('faq/faq'); ?>">FAQ 바로가기</a></li>
			</ul>
		</div>
		<div class="asmo_dash_cm_wrap forT">
			<div class="asmo_dash_cm_banner forT swiper-container">
				<ul class="swiper-wrapper">
					<?=banner('dashboard_adv_tablet','','2','<li class="swiper-slide">','</li>')?>
				</ul>
			</div>
			<div class="asmo_dash_myland">
				<a href="/">마이랜드 바로가기</a>
			</div>
		</div>
	</article>
	<!--// 태블릿용구조 끝 -->
	<!-- 모바일용구조 -->
	<article class="forM asmo_dash_cont_forM">
		<div id="asmo_class_process_forM">
			<ul>
				<li class="asmo_class_p_box ing">
					<a href="<?php echo site_url('classroom/my_class'); ?>">
						<span></span>
						<p>수강중</p>
						<strong><?php echo element('cnt', element('process_on', element('data', $view))); ?></strong>
					</a>
				</li>
				<li class="asmo_class_p_box soon">
					<a href="<?php echo site_url('classroom/my_class'); ?>">
						<span></span>
						<p>종료예정</p>
						<strong><?php echo element('cnt', element('process_scheduled_to_end', element('data', $view))); ?></strong>
					</a>	
				</li>
				<li class="asmo_class_p_box end">
					<a href="<?php echo site_url('classroom/complete_class'); ?>">
						<span></span>
						<p>수강완료</p>
						<strong><?php echo element('cnt', element('process_completed', element('data', $view))); ?></strong>
					</a>
				</li>
			</ul>
			<p class="asmo_average_bar_wrap">
				<span>수강 완료율</span>
				<em><i style="width:<?php echo element('process_percentage', element('data', $view)); ?>%"></i></em>
			</p>
		</div>
		<!-- asmo lhb 231215 모바일용 공지 게시글 리스트 -->
		<div id="asmo_dash_list_wrap_forM">
			<div id="asmo_notice_tab">
				<ul>
					<li class="active main_notice">컬래버랜드 공지사항</li>
					<li class="c_notice"><?=busiNm($this->member->item('company_idx'))?> 공지사항</li>
					<span class="asmo_tab_bar"></span>
				</ul>
				<a class="asmo_common_more active" href="<?php echo site_url('board/notice'); ?>">더보기</a>
				<a class="asmo_common_more" href="<?php echo site_url('board/cnotice'); ?>">더보기</a>
			</div>
			<div id="asmo_notice_tab_cont_wrap">
				<!-- asmo lhb 231215 컬래버 공지사항 -->
				<div class="asmo_notice_tab_box active">
					<ol>
						<?php foreach (element('list', element('mnotice_fix', element('data', $view))) as $result) { ?>
							<li>
								<a href="<?php echo element('post_link', $result); ?>">
									<span><?php echo html_escape(element('post_title', $result)); ?></span>
								</a>
							</li>
						<?php } ?>
						<?php foreach (element('list', element('mnotice', element('data', $view))) as $result) { ?>
							<li>
								<a href="<?php echo element('post_link', $result); ?>">
									<span><?php echo html_escape(element('post_title', $result)); ?></span>
								</a>
							</li>
						<?php } ?>
					</ol>
				</div>
				<!-- //asmo lhb 231215 컬래버 공지사항 -->
				<!-- asmo lhb 231215 기업랜드 공지사항 -->
				<div class="asmo_notice_tab_box">
					<ol>
						<?php foreach (element('list', element('mcnotice_fix', element('data', $view))) as $result) { ?>
							<li>
								<a href="<?php echo element('post_link', $result); ?>">
									<span><?php echo html_escape(element('post_title', $result)); ?></span>
								</a>
							</li>
						<?php } ?>
						<?php foreach (element('list', element('mcnotice', element('data', $view))) as $result) { ?>
							<li>
								<a href="<?php echo element('post_link', $result); ?>">
									<span><?php echo html_escape(element('post_title', $result)); ?></span>
								</a>
							</li>
						<?php } ?>
					</ol>
				</div>
				<!-- //asmo lhb 231215 기업랜드 공지사항 -->
			</div>
		</div>
		<!-- //asmo lhb 231215 모바일용 공지 게시글 리스트 -->
		<div class="asmo_dash_qa_wrap">
			<ul>
				<li class="orange"><a href="<?php echo site_url('board/qna'); ?>">컬래버랜드 문의하기</a></li>
				<li class="blue"><a href="<?php echo site_url('board/cqna'); ?>"><?=busiNm($this->member->item('company_idx'))?> 문의하기</a></li>
				<li class="black"><a href="<?php echo site_url('faq/faq'); ?>">FAQ 바로가기</a></li>
			</ul>
		</div>
	</article>
	<!-- //모바일용구조 -->
</section>

<script>

	// asmo sh 231221 시간대 별 하늘 이미지 변경 스크립트
	var now = new Date();
	var hour = now.getHours();

	console.log(hour);

	if (hour >= 6 && hour < 16) {
		$('.dash_top_wrap').addClass('day');
	} else if (hour >= 16 && hour < 19) {
		$('.dash_top_wrap').addClass('sunset');
	} else {
		$('.dash_top_wrap').addClass('night');
	}
	
	
	//asmo lhb 231220 광고배너 스와이퍼 붙이기
	const main_swiper = new Swiper('.asmo_dash_cm_banner.swiper-container.forT', {
		speed: 200,
		loop: true,
		autoplay: {
        delay: 2500,
			disableOnInteraction: false,
		},
	});
	//asmo lhb 231220 광고배너 스와이퍼 붙이기 끝
	



	//asmo lhb 231215 모바일에서 공지사항 탭 바 너비 및 애니메이션 이벤트 
	var asmoNoticeTab = document.querySelector('#asmo_notice_tab .main_notice'); //공지사항 탭

	var asmoNoticeTabW = asmoNoticeTab.offsetWidth; //공지사항 탭 너비 값

	var asmoBar = document.querySelector('.asmo_tab_bar'); //탭 바 


	asmoBar.style.width = asmoNoticeTabW + 'px'; //초기 공지사항 탭 너비 지정

	const asmoTab = document.querySelectorAll('#asmo_notice_tab ul li');

	asmoTab.forEach((el, index) => {

		el.onclick = () => {

			var asmoThisW = el.offsetWidth; //클릭한 탭의 너비

			var asmoMore = document.querySelectorAll('#asmo_notice_tab .asmo_common_more');

			var asmoTabCont = document.querySelectorAll('#asmo_notice_tab_cont_wrap .asmo_notice_tab_box');

			asmoBar.style.width = asmoThisW + 'px'; //클릭한 탭의 너비를 바 너비에 적용

			var asmoLeft = el.offsetLeft;


			asmoBar.style.left = asmoLeft + 'px';

			if( index == 1 ){ //기업 공지사항 클릭 시

				document.querySelector('.main_notice').classList.remove('active');
				document.querySelector('.c_notice').classList.add('active');
				asmoMore[0].classList.remove('active');
				asmoMore[index].classList.add('active');
				asmoTabCont[0].classList.remove('active');
				asmoTabCont[index].classList.add('active');

			}else { //전체 공지사항 클릭 시
				
				document.querySelector('.c_notice').classList.remove('active');
				document.querySelector('.main_notice').classList.add('active');
				asmoMore[1].classList.remove('active');
				asmoMore[index].classList.add('active');
				asmoTabCont[1].classList.remove('active');
				asmoTabCont[index].classList.add('active');

			}

		}

	});


	//asmo lhb 231215 모바일에서 공지사항 탭 바 너비 및 애니메이션 이벤트 끝 

	// asmo sh 231120 대시보드 메인 페이지 상단 좌측 상태명 수정 스크립트
	$('.asmo_status_inner button').on('click', function() {
		toggleEditMode();
	});

	$('.asmo_status_inner input').on('keyup', function(event) {
		if (event.key === 'Enter') {
			updateStateName();
		}
	});

	function toggleEditMode() {
		var spanElement = $('.asmo_status_inner span');
		var inputElement = $('.asmo_status_inner input');

		var statusButton = $('.statusButton');


		if (spanElement.is(':visible')) { //상태명 있을 때
			

			spanElement.hide();
			statusButton.addClass('check');
			inputElement.show().focus();

		} else { //상태명 입력 전
			
			statusButton.addClass('check'); //수정버튼 체크 아이콘으로 변경
			inputElement.removeClass('asmo_status_before').focus(); //인풋창 보더 살리고 포커스
			updateStateName();
		}
	}

	function updateStateName() {


		var stateName = $('.asmo_status_inner input').val().trim();
		var spanElement = $('.asmo_status_inner span');

		var statusButton = $('.statusButton');


		if (stateName !== '') {
			spanElement.text(stateName).show();
			$('.asmo_status_inner input').hide();
			statusButton.removeClass('check');

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


</script>