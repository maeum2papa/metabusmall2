<?php

?>
<div class="asmo_classroom">
	<div id="asmo_classroom_business">
		<div class="business_top_wrap">
			<div class="top_left_wrap">
				<strong>전체 강의 <span id="list_length"><?=($view['data']['total_rows'])?></span>개</strong>

				<div class="top_left_checkbox">
					<input type="checkbox" id="check" name="check" value="y" onClick="check_ess()">
					<label for="check">필수 강의만 보기</label>
				</div>
			</div>
			<div class="top_right_wrap">
				<div class="board_select_box"  style="display: none">
					<select class="form-control"  onChange="location.href = '/classroom/business_class?menu=<?=$_GET[menu]?>&&forder='+this.value;">
						<option value="">정렬</option>
						<option value="my_process.mp_percent" <?php if($_GET[forder] == 'my_process.mp_percent'){?>selected <?php }?>>진도율 순</option>
						<option value="my_process.mp_sno" <?php if($_GET[forder] == 'my_process.mp_sno'){?>selected <?php }?>>시작일 순</option>
					</select>
				</div>
				<a href="<?php echo site_url('classroom/my_class'); ?>">나의 수강 목록 <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/more.svg" alt="more"></a>
			</div>
		</div>

		<div class="buneess_list_wrap">
			<?php  
				if(count($view['data']['list'])>0){
					foreach($view['data']['list'] as $k=>$v){ 

					// 240215 컬래버랜드 시연을 위한 코드입니다.
					$class_seed_value = ($k % 2 === 0) ? "+50개" : "+10개";
						
			?>
			<div class="class_video">
				<?php if($v[mp_sno]){?>
				<div style="cursor: pointer;" class="class_video_box" onClick="location.href='<?php echo site_url('classroom/player?mp_sno='.$v[mp_sno]);?>'">
				<?php }else{?>
				<div style="cursor: pointer;" class="class_video_box" onClick="location.href='<?php echo site_url('classroom/detail?p_sno='.$v[p_sno]);?>'">
				<?php }?>
				
					
					<div class="class_video_img">
						<img src="<?=$v[p_thumbnail]?>" alt="thumbnail">
					</div>


					<div class="class_video_category swiper-container">
						<div class="swiper-wrapper">
							<?php foreach($v[category] as $v1){  ?>
							<div class="swiper-slide">
								<?=$v1?>
							</div>
							<?php  } ?>
							
						</div>
					</div>

					<div class="class_video_info">
						<div class="class_video_info_title">
							<span><?=$v[p_title]?></span>
						</div>
						<div class="class_video_info_desc">
							<span><?=$v[p_subtitle]?></span>
						</div>
					</div>
					<div class="class_video_icon">
						<?php if($v[mp_endYn] == 'y'){?>
						<span>수강완료</span>
						<?php }else if($v[mp_endYn] == 'n'){?>
						<span>수강중</span>
						<?php } ?>
						
					</div>
				</div>

				<div class="class_video_point_box">
					<!-- 씨앗일 때 -->
					<p class="asmo_class_seed"><?php echo $class_seed_value; ?></p>
					<!-- //씨앗일 때 -->

					<!-- 포인트일 때 -->
					<!-- <p class="asmo_class_point"><?php echo $class_seed_value; ?></p> -->
					<!-- //포인트일 때 -->
				</div>

			</div>
			<?php  
					}
			?>
			<?php }else{ ?>
			<div class="class_video nopost" style="font-size: 1.6rem">없음</div>
			<?php  
				}
			?>
			


			

		</div>

		<nav><?php echo element('paging', $view); ?></nav>

		
		</div>
	</div>
</div>



<script type="text/javascript">

	const swiper = new Swiper('.swiper-container', {
		loop: false,
		centeredSlides: false,
		slidesPerView: 'auto',
		slideToClickedSlide: true,		
	});

	// asmo sh 231128 클래스룸 기업 전체 강의 목록 페이지 디자인 상 헤더숨김 처리 스크립트
	$(document).ready(function() {
		$('header').addClass('dn');
		$('.navbar').removeClass('dn');
		// $('.sidebar').addClass('dn');
		// $('footer').addClass('dn');

		$('.main').addClass('add');

		// 클래스룸 페이지일 때 사이드바 메뉴 활성화
		$('#classroom').addClass('selected');
	});
	
	function check_ess(){
		
		if ( true ==  $("#check").is(":checked") ) { 
			location.href = '/classroom/business_class?menu=<?=$_GET[menu]?>&&ess=y';
		}else{
			location.href = '/classroom/business_class?menu=<?=$_GET[menu]?>';
		}
		
	}
	<?php if($_GET[ess] == 'y'){?>
	$("input:checkbox[id='check']").prop("checked", true);
	<?php }?>
	


</script>