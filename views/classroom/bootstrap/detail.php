
<style>
	header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	} 

	body {
		background: linear-gradient(160deg, #333 11%, #222 42.7%, #000 75%);
		background-attachment: fixed;
		color: #fff;
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
</style> 


<div class="asmo_classroom">
	<div id="asmo_classroom_detail">

		<div class="class_detail_wrap">
			<div class="class_detail_top">
				
				<p><?=element('p_subtitle', $p_data); ?></p> <!-- 부제목입니다 -->
				<div class="class_detail_title_wrap">
					<h2><?=element('p_title', $p_data); ?></h2> <!-- 제목입니다 -->
					<div class="class_detail_box">
					<?php if(element('list', $category)){?>
					<?php foreach (element('list', $category) as $k => $v){?>
						<span><?=$v[cca_value]?></span>
					<?php }} ?>

					<p class="class_video_tnailPoint"> 
						<!-- 씨앗 포인트 개수 -->
						<span class="seedPoint">+100개</span> 
						
						<!-- 복지 포인트 개수 -->
						<!-- <span class="cpnPoint">+100개</span>  -->
					</p>
					</div>
				</div>
			</div>

			<div class="class_detail_cont">
				<div class="class_detail_cont_L">
					<h3>강의 소개</h3>
					<div class="class_detail_intro">
						<?=element('p_desc', $p_data); ?>
					</div>
				</div>
				<div class="class_detail_cont_R">
					<img src="<?=element('p_thumbnail', $p_data); ?>" alt="thumbnail">

					<!-- 강의 썸네일이 없을 경우 이 부분은 활성화 해주세요! -->
					<div class="cDnone_tnail" style="display: none;"><p><?=element('p_title', $p_data); ?></p></div>
					<!-- //강의 썸네일이 없을 경우 이 부분은 활성화 해주세요! -->
				</div>
			</div>

			<div class="class_detail_btn">
				<a href='javascript:void(0);' onclick="myClass('<?=$business_studyYn?>');">수강신청</a>
				<a href="<?php echo site_url('classroom/business_class'); ?>">목록으로</a>
			</div>
		</div>
		
		<div class="class_reco_wrap">
			<h3>혹시 이런 강의는 어떠신가요?</h3>
			<div class="class_recommend">
				<div class="class_recommend_box">
					<a href="#">
						<div class="class_video_tnail">
							<p class="class_video_tnail_o"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail"></p> <!-- 강의 이미지 썸네일 -->
							<p class="class_video_tnailPoint"> 
								<!-- 씨앗 포인트 개수 -->
								<span class="seedPoint">+100개</span> 
								
								<!-- 복지 포인트 개수 -->
								<!-- <span class="cpnPoint">+100개</span>  -->
							</p>
						</div>
						<div class="class_video_cont">
							<p class="class_video_title">강의 제목</p> <!-- 강의 제목입니다 -->
							<p class="class_video_conbtm">간략한 내용</p> <!-- 강의 내용 간략한 설명입니다 -->
						</div>
					</a>
				</div>

				<div class="class_recommend_box">
					<a href="#">
						<div class="class_video_tnail">
							<p class="class_video_tnail_o"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail"></p> <!-- 강의 이미지 썸네일 -->
							<p class="class_video_tnailPoint"> 
								<!-- 씨앗 포인트 개수 -->
								<span class="seedPoint">+100개</span> 
								
								<!-- 복지 포인트 개수 -->
								<!-- <span class="cpnPoint">+100개</span>  -->
							</p>
						</div>
						<div class="class_video_cont">
							<p class="class_video_title">강의 제목</p> <!-- 강의 제목입니다 -->
							<p class="class_video_conbtm">간략한 내용</p> <!-- 강의 내용 간략한 설명입니다 -->
						</div>
					</a>
				</div>

				<div class="class_recommend_box">
					<a href="#">
						<div class="class_video_tnail">
							<p class="class_video_tnail_o"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail"></p> <!-- 강의 이미지 썸네일 -->
							<p class="class_video_tnailPoint"> 
								<!-- 씨앗 포인트 개수 -->
								<span class="seedPoint">+100개</span> 
								
								<!-- 복지 포인트 개수 -->
								<!-- <span class="cpnPoint">+100개</span>  -->
							</p>
						</div>
						<div class="class_video_cont">
							<p class="class_video_title">강의 제목</p> <!-- 강의 제목입니다 -->
							<p class="class_video_conbtm">간략한 내용</p> <!-- 강의 내용 간략한 설명입니다 -->
						</div>
					</a>
				</div>
			</div>
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

			// asmo sh 240214 수강신청 불가능한 경우 alert 창 text 변경
			// alert(txt+'입니다. 신청이 불가합니다.');
			alert('준비중입니다.');
		}else{
			location.href = '/classroom/process_ps?mode=reg&&p_sno=<?=$_GET[p_sno]?>';
		}
		
	}

	// asmo sh 231123 클래스룸 상세 페이지 디자인 상 헤더, nav바 숨김 처리 스크립트
	$(document).ready(function() {

		$('.main').addClass('add');

		// 클래스룸 페이지일 때 사이드바 메뉴 활성화
		$('#classroom').addClass('selected');
	});
	
	
	
	
	
</script>