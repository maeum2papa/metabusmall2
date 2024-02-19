
<style>
	header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	} 

	body {
		background: linear-gradient(160deg, #333 11%, #222 42.7%, #000 75%);
		background-attachment: fixed;
	}

	footer .container {
		background: transparent;
	}

	footer .container .company_info_box .company_info b {
		display: block;
		margin: 0 0 20px;
		font-size: 1.6rem;
		color: #fff;
	}

	footer .container .company_info_box .company_info span {
		font-size: 1.6rem;
		color: #fff;
	}

	#class_sideBar {
		display: block !important;
	}
</style> 


<div class="asmo_classroom">
	<div id="asmo_classroom_main">

		<!-- 검색창 -->
		<form action="#" method="get" id="classRoom_searchFrm">
            <fieldset>
                <legend class="dn">검색양식</legend>
                <button type="button" id="clasSBtn"></button>
                <input type="text" name="search" id="clasSTxt">
            </fieldset>
        </form>

		<section class="take_class_sec" id="continue_view">
			<div class="swiper-container mySwiper">
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
						<div class="view_thumbnail_bg">
							<img src="<?=$v[p_thumbnail]?>" alt="thumbnail">
						</div>
						<div class="view_cont">
							<h2><span class="view_name"><?php echo html_escape($this->member->item('mem_nickname')); ?></span> 님의 수강중인 강의</h2>
							<div class="col_title_cont">
								<h2 class="ct_subtitle"><?=$v[p_subtitle]?>부제목입니다</h2> <!-- 부제목 입니다 -->
                                <h1 class="ct_title"><?=$v[p_title]?></h1> <!-- 제목입니다 -->
                                <p class="ct_con"> <!-- 과정 설명입니다 -->
									<?=$v[p_desc]?>
                                    사람의 감정을 교류하는 것을 공감이라고 합니다.
                                    사소한 리액션 만으로도 상대방의 공감을 이끌어 
                                    관계를 더욱 향상 시킬 수 있습니다. 
                                    상대의 언어보다 마음에 집중해 주세요.
                                    사람의 감정을 교류하는 것을 공감이라고 합니다.
                                    사소한 리액션 만으로도 상대방의 공감을 이끌어 
                                    관계를 더욱 향상 시킬 수 있습니다. 
                                    상대의 언어보다 마음에 집중해 주세요.
                                </p>
							</div>
							<div class="col_btn_box">
								<a href="<?php echo site_url('classroom/player?mp_sno='.$v[mp_sno]); ?>">
									<span>이어서 보기</span>
								</a>
							</div>
						</div>
					</div>

					
						<?php } ?>
					<?php }else{?>
					<div class="class_video nopost">
						수강중인 강의가 없습니다.
					</div>
					<?php } ?>
					

				</div>

				<div class="swiper-pagination"></div>

			</div>

			<!-- <a href="<?php echo site_url('classroom/my_class'); ?>">나의 수강 목록 <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/more.svg" alt="more"></a> -->
		</section>

		
		
		<section class="class_sec">
			<div class="class_sec_top">
				<h1>컬래버랜드 강의</h1>
                <a href="#" class="class_sec_more"><span>더보기</span></a>
			</div>

			<div class="class_video_box">
				<?php if(element('list', $ess)){?>
					<?php foreach (element('list', $ess) as $k => $v){?>
				<div class="class_video">
					<a href="<?php echo site_url('classroom/detail?p_sno='.$v[index2]); ?>">

						<div class="class_video_tnail">
							<p class="class_video_tnail_o"><img src="<?=$v[p_thumbnail]?>" alt="thumbnail"></p> <!-- 강의 이미지 썸네일 -->
							<p class="class_video_tnailPoint"> 
								<span class="seedPoint">+100개</span> <!-- 씨앗 포인트 개수 -->
								
							</p>
						</div>
						<div class="class_video_cont">
							<p class="class_video_title"><?=$v[p_title]?></p> <!-- 강의 제목입니다 -->
							<p class="class_video_conbtm"><?=$v[p_subtitle]?>간략한 내용</p> <!-- 강의 내용 간략한 설명입니다 -->
						</div>
					</a>
				</div>
					<?php } ?>
				<?php }else{?>
					<div class="class_video nopost">
						강의가 없습니다. 
					</div>
					
				<?php } ?>
				
			</div>

			<!-- <a href="<?php echo site_url('classroom/business_class'); ?>">더보기</a> -->
		</section>	
			
			
		<section class="class_sec" id="company_class">
			<div class="class_sec_top">
				<h1>기업 강의</h1>
                <a href="#" class="class_sec_more"><span>더보기</span></a>
			</div>

			<div class="class_video_box">
				<?php if(element('list', $rec)){?>
					<?php foreach (element('list', $rec) as $k => $v){?>
				<div class="class_video">
					<a href="<?php echo site_url('classroom/detail?p_sno='.$v[index2]); ?>">
						<div class="class_video_tnail">
							<p class="class_video_tnail_o"><img src="<?=$v[p_thumbnail]?>" alt="thumbnail"></p> <!-- 강의 이미지 썸네일 -->
							<p class="class_video_tnailPoint"> <!-- 복지 포인트입니다 -->
								<span class="cpnPoint">+100개</span> <!-- 복지 포인트 개수 -->
							</p>
						</div>
						<div class="class_video_cont">
							<p class="class_video_title"><?=$v[p_title]?></p> <!-- 강의 제목입니다 -->
							<p class="class_video_conbtm"><?=$v[p_subtitle]?>간략한 내용</p> <!-- 강의 내용 간략한 설명입니다 -->
						</div>
					</a>
				</div>
					<?php } ?>
				<?php }else{?>
				<!-- <div class="class_video nopost">
					추천 강의가 없습니다.
				</div> -->
				<?php } ?>
				
			</div>

			<!-- <a href="<?php echo site_url('classroom/business_class'); ?>">더보기</a> -->
		</section>
	</div>
</div>




<script type="text/javascript">

	

	const swiper = new Swiper('.swiper-container', {
		pagination : {
			el: "#continue_view .swiper-pagination",
		},
	});

	$(document).ready(function() {

		// asmo sh 240215 #continue_view, #company_class 숨김처리 스크립트
		if($('#continue_view .swiper-slide').length == 0){
			$('#continue_view').addClass('dn');
		}

		if($('#company_class .class_video').length == 0){
			$('#company_class').addClass('dn');
		}

		$('.main').addClass('add');

		// 클래스룸 페이지일 때 사이드바 메뉴 활성화
		$('#classroom').addClass('selected');
	});
</script>