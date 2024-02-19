<div id="asmo_classroom">
	<div id="asmo_classroom_detail">
		<section class="detail_slides">
			<div class="main_slder">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img src="<?=element('p_thumbnail', $p_data); ?>" alt="detail_1">
						</div>
					</div>
					<!-- <div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
					<div class="swiper-pagination"></div> -->
				</div>
			</div>

		</section>
		<section class="detail_info">
			<div class="detail_info_top">
				<div class="detail_info_category">
					<?php if(element('list', $category)){?>
					<?php foreach (element('list', $category) as $k => $v){?>
					<span><?=$v[cca_value]?></span>
					<?php }} ?>
				</div>

				<div class="detail_info_title">
					<strong><?=element('p_title', $p_data); ?></strong>
					<p><?=element('p_subtitle', $p_data); ?></p>
				</div>

				<div class="detail_info_btn">
					<a class="asmo_apply_class_btn" href='javascript:void(0);' onclick="myClass('<?=$business_studyYn?>');">수강신청</a>
					<a href="<?php echo site_url('classroom'); ?>">목록으로</a>
				</div>
			</div>

			<div class="detail_info_curri">

				<div class="detail_info_curri_list">
					<?=element('p_desc', $p_data); ?>
				</div>
			</div>
		</section>

		<section class="detail_btn">
			<a class="asmo_apply_class_btn" href='javascript:void(0);' onclick="myClass('<?=$business_studyYn?>');">수강신청</a>
			<a href="<?php echo site_url('classroom'); ?>">목록으로</a>
		</section>

		<section class="fixed_bar_wrap">
			<div class="fixed_bar">
				<div class="fixed_bar_btn">
					<a class="asmo_apply_class_btn" href='javascript:void(0);' onclick="myClass('<?=$business_studyYn?>');">수강신청</a>
					<a href="<?php echo site_url('classroom'); ?>">목록으로</a>
				</div>
		</section>
		</div>
	</div>
</div>


<script type="text/javascript">

	//asmo 윤진봉 231221 수강신청 함수
		function myClass(arg){
		if(arg == 'a'){
			alert('이미 수강중인 과정입니다.');
		}else if(arg == 'n'){
			alert('수강이 불가한 과정입니다. 관리자에 문의해주세요');
		}else if(arg == 'f'){
			var txt = "<?=false_process()?>";
			alert(txt+'입니다. 신청이 불가합니다.');
		}else{
			location.href = '/classroom/process_ps?mode=reg&&p_sno=<?=$_GET[p_sno]?>';
		}
		
	}

	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');


	const main_swiper = new Swiper('.main_slder .swiper-container', {
		speed: 500,
		effect: 'fade',
		loop: true,
		// pagination: {
		// 	el: '.main_slder .swiper-pagination',
		// 	clickable: true,
		// },
		// navigation: {
		// 	nextEl: '.main_slder .swiper-button-next',
		// 	prevEl: '.main_slder .swiper-button-prev',
		// },
	});




</script>