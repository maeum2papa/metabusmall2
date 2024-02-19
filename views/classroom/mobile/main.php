
<div id="asmo_classroom">
	<div id="asmo_classroom_main">
		<div id="asmo_classroom_main_tit">
			<strong><span><?php echo html_escape($this->member->item('mem_nickname')); ?></span>님이 수강중인 강의</strong>
			<a href="<?php echo site_url('classroom/my_class'); ?>">나의 수강 목록<em></em></a>
		</div>
		<!-- 수강중인 강의 -->
		<section class="take_class_sec">
			<div class="swiper-container mySwiper takeClassSwiper">
				<div class="swiper-wrapper">
					<?php if(element('list', $now)){?>
					<?php foreach (element('list', $now) as $k => $v){
							if($v[p_viewYn] == 'y'){
								$view_time = "상시 노출";
							}else{
								$view_time = substr($v[p_sdate], 0, 4).".".substr($v[p_sdate], 4, 2).".".substr($v[p_sdate], 6, 2)." ~ ".substr($v[p_edate], 0, 4).".".substr($v[p_edate], 4, 2).".".substr($v[p_edate], 6, 2);
							}
					?>
					<div class="swiper-slide">
						<a href="<?php echo site_url('classroom/player?mp_sno='.$v[mp_sno]); ?>">
							<div class="class_video_img">
								<img src="<?=$v[p_thumbnail]?>" alt="thumbnail">
							</div>
							<div class="class_video_info">
								<div class="class_video_info_title">
									<span><?=$v[p_title]?></span>
								</div>
								<div class="class_video_info_date">
									<em class="asmo_class_seed">+ 100</em><span><?=$view_time?></span>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>
					<?php }else{?>
					<div class="class_video nopost">
						수강중인 강의가 없습니다.
					</div>
					<?php } ?>
				</div>
			</div>

			
		</section>
		<!-- //수강중인 강의 -->	
		<!-- 필수 강의 -->
		<section class="class_sec">
			<div class="asmo_class_main_common_tit">
				<strong>필수 강의</strong>
				<a href="<?php echo site_url('classroom/business_class'); ?>">더보기</a>
			</div>

			<div class="class_video_box">
				<?php if(element('list', $ess)){?>
				<?php foreach (element('list', $ess) as $k => $v){?>
				<div class="class_video">
					<a href="<?php echo site_url('classroom/detail?p_sno='.$v[index2]); ?>">
						<div class="class_video_img">
							<img src="<?=$v[p_thumbnail]?>" alt="thumbnail">
							<em class="asmo_class_seed">+ 100</em>
						</div>
						<div class="class_video_info">
							<div class="class_video_info_title">
								<span><?=$v[p_title]?></span>
							</div>
							<div class="class_video_info_icon">
								<?php if($v[p_sno]){?>
								<span>수강중</span>
								<?php }else{?>
								<span class="class_apply">수강 신청</span>
								<?php }?>
							</div>
						</div>
					</a>
				</div>
				<?php } ?>
				<?php }else{?>
				<div class="class_video nopost">
					필수 강의가 없습니다.
				</div>
				<?php } ?>

			</div>

		</section>
		<!-- //필수 강의 -->
		<!-- 추천 강의 -->
		<section class="class_sec">
			<div class="asmo_class_main_common_tit">
				<strong>추천 강의</strong>
				<a href="<?php echo site_url('classroom/business_class'); ?>">더보기</a>
			</div>	

			<div class="class_video_box">
				<?php if(element('list', $rec)){?>
				<?php foreach (element('list', $rec) as $k => $v){?>
				<div class="class_video">
					<a href="<?php echo site_url('classroom/detail?p_sno='.$v[index2]); ?>">
						<div class="class_video_img">
							<img src="<?=$v[p_thumbnail]?>" alt="thumbnail">
							<em class="asmo_class_seed">+ 100</em>
						</div>
						<div class="class_video_info">
							<div class="class_video_info_title">
								<span><?=$v[p_title]?></span>
							</div>
							<div class="class_video_info_icon">
								<?php if($v[p_sno]){?>
								<span>수강중</span>
								<?php }else{?>
								<span class="class_apply">수강 신청</span>
								<?php }?>
							</div>
						</div>
					</a>
				</div>
				<?php } ?>
				<?php }else{?>
				<div class="class_video nopost">
					추천 강의가 없습니다.
				</div>
				<?php } ?>

			</div>

		</section>
		<!-- //추천 강의 -->
	</div>
</div>

<script>
	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.wrapper').classList.add('asmo_classroom');

	//asmo lhb 231218 수강중인 강의 스와이퍼 붙이기 
	const mySwiper = new Swiper('.takeClassSwiper', {
		speed: 500,
		// effect: 'fade',
		slidesPerView : 4,
		centeredSlides: true,
		spaceBetween: 24,
		loop: true,
		pagination: {
			el: 'null',
		},
	});
	//asmo lhb 231218 수강중인 강의 스와이퍼 붙이기 끝

</script>