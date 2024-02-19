<!-- <?php
echo busiIcon($this->member->item('company_idx'));
echo busiNm($this->member->item('company_idx'));

$user_info = $this->member->item('mem_id');
?> -->

<style>
	body {
		background-color: #F1F1F1;
	}

	header, .navbar, footer { /* 각종메뉴 숨김처리 */
		display:none !important;
	}

	/* 슬라이더 스타일 설정 */
	#slider {
		width: 100%;
		-webkit-appearance: none;
		appearance: none;
		height: 10px;
		border-radius: 5px;
		background: #d3d3d3;
		outline: none;
		opacity: 0.7;
		transition: opacity 0.2s;
	}

	/* 눈금 스타일 설정 */
	#slider::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		width: 20px;
		height: 20px;
		border-radius: 50%;
		background: #4caf50;
		cursor: pointer;
	}

	/* 눈금에만 걸리도록 설정 */
	#slider::-moz-range-progress {
		background-color: #4caf50;
	}
</style>


<div class="asmo_dashboard">
	
	<div class="asmo_dashboard_sub asmo_survey" id="asmo_survey_response">
		<div class="asmo_survey_box">
			<div class="dash_sub_head">
				<h2><?=busiNm($this->member->item('company_idx'))?> 서베이</h2>
			</div>
			<div class="dash_sub_body">
				<div class="survey_title_box">
					<h3 class="survey_title">2024 직원 만족도 조사</h3>
					<p class="survey_explanation">2024년 상반기 신규입사자를 대상으로 직원 만족도 조사를 실시합니다.<br> 많은 참여 바랍니다.</p>
				</div>
				<div class="survey_detail_box">
					<h3 class="survey_detail_title">회사비전</h3>
					<p class="survey_detail_explanation">본인이 느끼는 회사의 비전에 대해 자유롭게 의견을 제출해주세요.</p>
					<div class="survey_detail_line"></div>
					<form>
						<div class="survey_detail_response_box text_radio_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 현재 우리 회사에서 개선해야 할 가장 중요한 문제는 무엇이라고 생각하십니까? <span>* 필수 응답 항목 입니다.</span></p>
							</div>
							<div class="survey_A ">
								<div class="text_radio">
									<input type="radio" id="survey_A1" name="survey_A" value="1">
									<label for="survey_A1">회사의 비전 (성장가능성)</label>
								</div>
								<div class="text_radio">
									<input type="radio" id="survey_A2" name="survey_A" value="2">
									<label for="survey_A2">직원의 직무 만족</label>
								</div>
								<div class="text_radio">
									<input type="radio" id="survey_A3" name="survey_A" value="3">
									<label for="survey_A3">근무 여건</label>
								</div>
								<div class="text_radio">
									<input type="radio" id="survey_A4" name="survey_A" value="4">
									<label for="survey_A4">기타</label>
								</div>
							</div>
						</div>
						<div class="survey_detail_response_box img_radio_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 현재 우리 회사에서 개선해야 할 가장 중요한 문제는 무엇이라고 생각하십니까? </p>
							</div>
							<div class="survey_A ">
								<div class="img_radio">
									<input type="radio" id="survey_A5" name="survey_A" value="5">
									<label for="survey_A5">
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/survey_img.png" alt="survey_img">
									</label>
								</div>
								<div class="img_radio">
									<input type="radio" id="survey_A6" name="survey_A" value="6">
									<label for="survey_A6">
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/survey_img.png" alt="survey_img">
									</label>
								</div>
								<div class="img_radio">
									<input type="radio" id="survey_A7" name="survey_A" value="7">
									<label for="survey_A7">
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/survey_img.png" alt="survey_img">
									</label>
								</div>
								
							</div>
						</div>
						<div class="survey_detail_response_box textarea_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 현재 우리 회사에서 개선해야 할 가장 중요한 문제는 무엇이라고 생각하십니까? <span>* 필수 응답 항목 입니다.</span></p>
							</div>
							<div class="survey_A ">
								<textarea name="survey_A" id="survey_A" placeholder="자유롭게 의견을 작성해주세요."></textarea>
							</div>
						</div>
						<div class="survey_detail_response_box star_rating_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 우리 회사는 나에게 비전을 제시하고 있다.</p>
							</div>
							<div class="survey_A ">
								<div class="star_rating_box_wrap">
									<div class="star_rating" data-value="0.5">
										<input type="radio" id="star_rating_half" name="star_rating" value="0.5">
										<label for="star_rating_half">0.5</label>
									</div>
									<div class="star_rating" data-value="1">
										<input type="radio" id="star_rating1" name="star_rating" value="1">
										<label for="star_rating1">1</label>
									</div>
									<div class="star_rating" data-value="1.5">
										<input type="radio" id="star_rating_1_half" name="star_rating" value="1.5">
										<label for="star_rating_1_half">1.5</label>
									</div>
									<div class="star_rating" data-value="2">
										<input type="radio" id="star_rating2" name="star_rating" value="2">
										<label for="star_rating2">2</label>
									</div>
									<div class="star_rating" data-value="2.5">
										<input type="radio" id="star_rating_2_half" name="star_rating" value="2.5">
										<label for="star_rating_2_half">2.5</label>
									</div>
									<div class="star_rating" data-value="3">
										<input type="radio" id="star_rating3" name="star_rating" value="3">
										<label for="star_rating3">3</label>
									</div>
									<div class="star_rating" data-value="3.5">
										<input type="radio" id="star_rating_3_half" name="star_rating" value="3.5">
										<label for="star_rating_3_half">3.5</label>
									</div>
									<div class="star_rating" data-value="4">
										<input type="radio" id="star_rating4" name="star_rating" value="4">
										<label for="star_rating4">4</label>
									</div>
									<div class="star_rating" data-value="4.5">
										<input type="radio" id="star_rating_4_half" name="star_rating" value="4.5">
										<label for="star_rating_4_half">4.5</label>
									</div>
									<div class="star_rating" data-value="5">
										<input type="radio" id="star_rating5" name="star_rating" value="5">
										<label for="star_rating5">5</label>
									</div>
								</div>
								<p><span id="star_rating_num"></span>점</p>
							</div>

						</div>
						<div class="survey_detail_response_box range_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 우리 회사는 나에게 비전을 제시하고 있다.</p>
							</div>
							<div class="survey_A ">
								<span>0%</span>
								<input type="range" id="range" name="range" min="0" max="100" value="50">
								<span>100%</span>

							</div>
						</div>
			
					</form>
			
				</div>
			</div>
		</div>
		
		<div class="survey_btn_box">
			<a href="">목록으로</a>
			<button type="submit" class="survey_submit_btn">제출하기</button>
		</div>
	</div>

</div>


<!-- 일정 정보 팝업 -->
<div class="popup_layer_bg" id="survey_submit_popup">
	<div class="survey_submit_popup">
		<div class="survey_submit_popup_box">
			<div class="survey_submit_popup_title">
				<p>응답 제출이 완료되었습니다.<br>서베이에 응해주셔서 감사합니다:)</p>
			</div>
			<div class="survey_submit_popup_button">
				<a href="">목록으로</a>
				<a href="">결과 확인</a>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">

	const rangeInput = document.getElementById('range');
	rangeInput.addEventListener('input', () => {
		const step = 10; // 눈금 간격
		const value = Math.round(rangeInput.value / step) * step;
		rangeInput.value = value;
	});

	$('.star_rating').click(function(){
		var rating = $(this).data('value');
		$('.star_rating').removeClass('on');
		$(this).addClass('on').prevAll().addClass('on');
		$('#star_rating_num').text(rating);
	});

	$(document).ready(function() {
		$('#dashboard').addClass('selected');
	});
</script>