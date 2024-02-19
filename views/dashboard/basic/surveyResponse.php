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
</style>


<div class="asmo_dashboard">	
	
	<div class="asmo_dashboard_sub asmo_survey" id="asmo_survey_response">
		<div class="asmo_survey_box">
			<div class="dash_sub_head">
				<h2><?=busiNm($this->member->item('company_idx'))?> 서베이</h2>
			</div>
			<div class="dash_sub_body">
				<div class="survey_title_box">
					<h3 class="survey_title"><?= element('title', element('info', $view)[0]); ?></h3>
					<p class="survey_explanation"><?= element('description', element('info', $view)[0]); ?></p>
				</div>
				<div class="survey_detail_box">
					<form>

					<?php 
					$elements = element('element', $view);
					//var_dump($elements);
					$count = 1;
					$i = 0;

					foreach ($elements as $elem) {
						$id = $count + $i;

						switch ($elem['survey_element_type']) {
							case "subtitle": {
								echo '<div class="survey_detail_title_box"><h3 class="survey_detail_title">'.$elem['content'].'</h3></div>';

							}
							break;
							case "free_text": {
								echo '<div class="survey_detail_response_box text_radio_box">
									<div class="survey_Q">
										<p class="survey_Q_title">'.$elem['content'].'</p>
									</div>
									<div class="survey_A">';
									
									$answers = explode("|", $elem['option_descriptions']);
									$j = 0;					
									foreach ($answers as $answer) {
										$answer_id = $id + $j;

										echo '<div class="text_radio">
												<input type="radio" id="survey_A'.$answer_id.'" name="survey_A" value="'.$j.'">
												<label for="survey_A'.$answer_id.'">'.$answer.'</label>
												</div>';

										$j = $j + 1;

									}
								
									echo "</div>";

									/*echo '<div class="survey_A ">
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
								</div>';*/
							}
							break;

						}

					}
					$count = $count + 1;
					?>

				
		
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