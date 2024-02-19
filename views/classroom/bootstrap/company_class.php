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
	<div id="asmo_classroom_company">
		<div class="asmo_classList">
			<div class="class_list_top">
				<div class="list_name_box">
					<a href="">컬래버랜드 강의</a>
					<a class="selected" href="">기업 강의</a>
					<div class="list_name_box_line"></div>
				</div>

				<form action="#" method="get" id="companySearchFrm"> <!-- 검색창 -->
					<fieldset>
						<legend class="skip">검색양식</legend>
						<button type="button" id="companyBtn"></button>
						<input type="text" name="search" id="companyTxt">
					</fieldset>
				</form>
			</div>
			<div class="class_list_ctg">
				<!-- 기업강의 과정 카테고리 들어가야 합니다. -->
				<div class="class_list_ctg_box">
					<span class="list_ctg">전체 강의</span>
				</div>
			</div>

			<div class="class_list">

				<h2> <!-- 카테고리 제목 들어가야 합니다. -->전체 강의 <span><?=($view['data']['total_rows'])?></span>개</h2>

				<div class="class_video_wrap">
					<div class="class_video">
						<a href="#">
							<div class="class_video_tnail">
								<p class="class_video_tnail_o">
									<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail">

									<span class="cclassA">수강신청</span>
								</p> <!-- 강의 이미지 썸네일 -->
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

					<div class="class_video">
						<a href="#">
							<div class="class_video_tnail">
								<p class="class_video_tnail_o">
									<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail">

									<span class="cclassD">수강중인 강의</span>
								</p> <!-- 강의 이미지 썸네일 -->
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

					<div class="class_video">
						<a href="#">
							<div class="class_video_tnail">
								<p class="class_video_tnail_o">
									<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail">

									<span class="cclassA">수강신청</span>
								</p> <!-- 강의 이미지 썸네일 -->
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

					<div class="class_video">
						<a href="#">
							<div class="class_video_tnail">
								<p class="class_video_tnail_o">
									<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cpn01.png" alt="thumbnail">

									<span class="cclassA">수강신청</span>
								</p> <!-- 강의 이미지 썸네일 -->
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
</div>



<script type="text/javascript">

</script>