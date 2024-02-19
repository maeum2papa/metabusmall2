
<div id="asmo_classroom">
	<div id="asmo_classroom_business">
		<div class="business_top_wrap">
			<div class="top_left_wrap">
				<strong>전체 강의 <span id="list_length"><?=($view['data']['total_rows'])?></span>개</strong>

				<div class="top_left_checkbox">
					<input type="checkbox" id="check" name="check" value="check" onClick="check_ess()">
					<label for="check">필수 강의만 보기</label>
				</div>
			</div>
			<div class="top_right_wrap">
				<div class="board_select_box">
					<select class="form-control"  onChange="location.href = '/classroom/business_class?menu=<?=$_GET[menu]?>&&forder='+this.value;">
						<option value="">정렬</option>
						<option value="my_process.mp_percent" <?php if($_GET[forder] == 'my_process.mp_percent'){?>selected <?php }?>>진도율 순</option>
						<option value="my_process.mp_sno" <?php if($_GET[forder] == 'my_process.mp_sno'){?>selected <?php }?>>시작일 순</option>
					</select>
				</div>
				<a href="<?php echo site_url('classroom/my_class'); ?>">나의 수강 목록<em></em></a>
			</div>
		</div>

		<div class="business_list_wrap">


			<?php  
				if(count($view['data']['list'])>0){
					foreach($view['data']['list'] as $k=>$v){ 
			?>
			<div class="class_video" >
				<div style="cursor: pointer;" class="class_video_box" onClick="location.href='<?php echo site_url('classroom/detail?p_sno='.$v[p_sno]); ?>'" >
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
			</div>
			<?php  
					}
			?>
			<?php }else{ ?>
			<div class="class_video nopost" >없음</div>
			<?php  
				}
			?>



		</div>

		<nav><?php echo element('paging', $view); ?></nav>
	</div>
</div>



<script type="text/javascript">


	const swiper = new Swiper('.swiper-container', {	
		slidesPerView: 'auto',
		freeMode: true,	
	});



	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.wrapper').classList.add('asmo_classroom');


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