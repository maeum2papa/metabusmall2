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
	
	<div class="asmo_dashboard_sub asmo_survey" id="asmo_survey_result">
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
					<div class="survey_detail_title_box">
						<h3 class="survey_detail_title">회사비전</h3>
						<p class="survey_detail_explanation">본인이 느끼는 회사의 비전에 대해 자유롭게 의견을 제출해주세요.</p>
					</div>
					<form>
						<div class="survey_detail_response_box text_radio_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 현재 우리 회사에서 개선해야 할 가장 중요한 문제는 무엇이라고 생각하십니까? <span>* 필수 응답 항목 입니다.</span></p>
							</div>
							<div class="survey_A">
								<div class="text_radio">
									<p>회사의 비전 (성장가능성)</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 57.4%;"></div>
										<span class="radio_response_num">57.4% (응답자 : 14명)</span>
									</div>
								</div>
								<div class="text_radio">
									<p>직원의 직무 만족</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 25.2%;"></div>
										<span class="radio_response_num">25.2% (응답자 : 6명)</span>
									</div>
								</div>
								<div class="text_radio">
									<p>근무 여건</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>
								<div class="text_radio">
									<p>기타</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 0.1%;"></div>
										<span class="radio_response_num">0.1% (응답자 : 1명)</span>
									</div>
								</div>

								<div class="text_radio etcYn">
									<p>▶ 기타 의견 : 연봉</p>
								</div>
							</div>
						</div>
						<div class="survey_detail_response_box img_radio_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 현재 우리 회사에서 개선해야 할 가장 중요한 문제는 무엇이라고 생각하십니까? </p>
							</div>
							<div class="survey_A">
								<div class="img_radio">
									<label>
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/survey_img.png" alt="survey_img">
									</label>

									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 60%;"></div>
										<span class="radio_response_num">60% (응답자 : 15명)</span>
									</div>
								</div>
								<div class="img_radio">
									<label>
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/survey_img.png" alt="survey_img">
									</label>

									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 30%;"></div>
										<span class="radio_response_num">30% (응답자 : 7명)</span>
									</div>
								</div>
								<div class="img_radio">
									<label>
										<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/survey_img.png" alt="survey_img">
									</label>

									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 10%;"></div>
										<span class="radio_response_num">10% (응답자 : 3명)</span>
									</div>
								</div>
							</div>
						</div>
						<div class="survey_detail_response_box textarea_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 현재 우리 회사에서 개선해야 할 가장 중요한 문제는 무엇이라고 생각하십니까? <span>* 필수 응답 항목 입니다.</span></p>
							</div>
							<div class="survey_A ">
								<textarea name="survey_A-1" readonly id="survey_A-1">헌법재판소 재판관의 임기는 6년으로 하며, 법률이 정하는 바에 의하여 연임할 수 있다. 정당의 설립은 자유이며, 복수정당제는 보장된다. 제2항과 제3항의 처분에 대하여는 법원에 제소할 수 없다. 국민의 자유와 권리는 헌법에 열거되지 아니한 이유로 경시되지 아니한다. 대통령의 선거에 관한 사항은 법률로 정한다. 원장은 국회의 동의를 얻어 대통령이 임명하고, 그 임기는 4년으로 하며, 1차에 한하여 중임할 수 있다.</textarea>
								<textarea name="survey_A-2" readonly id="survey_A-2">헌법재판소 재판관의 임기는 6년으로 하며, 법률이 정하는 바에 의하여 연임할 수 있다. 정당의 설립은 자유이며, 복수정당제는 보장된다. 제2항과 제3항의 처분에 대하여는 법원에 제소할 수 없다.</textarea>
								<textarea name="survey_A-3" readonly id="survey_A-3">헌법재판소 재판관의 임기는 6년으로 하며, 법률이 정하는 바에 의하여 연임할 수 있다. 정당의 설립은 자유이며, 복수정당제는 보장된다. 제2항과 제3항의 처분에 대하여는 법원에 제소할 수 없다.</textarea>
								<textarea name="survey_A-4" readonly id="survey_A-4">헌법재판소 재판관의 임기는 6년으로 하며, 법률이 정하는 바에 의하여 연임할 수 있다. 정당의 설립은 자유이며, 복수정당제는 보장된다. 제2항과 제3항의 처분에 대하여는 법원에 제소할 수 없다.</textarea>
							</div>
						</div>
						<div class="survey_detail_response_box star_rating_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 우리 회사는 나에게 비전을 제시하고 있다.</p>
							</div>
							<div class="survey_A ">
								<div class="star_rating_box_wrap">
									<div class="star_rating">
										<p>1점</p>
										<div class="radio_graph">
											<div class="radio_graph_bar" style="width: 17.3%;"></div>
											<span class="radio_response_num">17.3% (응답자 : 4명)</span>
										</div>
									</div>
									<div class="star_rating">
										<p>2점</p>
										<div class="radio_graph">
											<div class="radio_graph_bar" style="width: 17.3%;"></div>
											<span class="radio_response_num">17.3% (응답자 : 4명)</span>
										</div>
									</div>
									<div class="star_rating">
										<p>3점</p>
										<div class="radio_graph">
											<div class="radio_graph_bar" style="width: 17.3%;"></div>
											<span class="radio_response_num">17.3% (응답자 : 4명)</span>
										</div>
									</div>
									<div class="star_rating">
										<p>4점</p>
										<div class="radio_graph">
											<div class="radio_graph_bar" style="width: 17.3%;"></div>
											<span class="radio_response_num">17.3% (응답자 : 4명)</span>
										</div>
									</div>
									<div class="star_rating">
										<p>5점</p>
										<div class="radio_graph">
											<div class="radio_graph_bar" style="width: 17.3%;"></div>
											<span class="radio_response_num">17.3% (응답자 : 4명)</span>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="survey_detail_response_box range_box">
							<div class="survey_Q">
								<p class="survey_Q_title">Q. 우리 회사는 나에게 비전을 제시하고 있다.</p>
							</div>
							<div class="survey_A">
								<div class="asmo_range">
									<p>0%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>10%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>20%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>30%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>40%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>
								

								<div class="asmo_range">
									<p>50%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>60%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>70%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>80%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>90%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

								<div class="asmo_range">
									<p>100%</p>
									<div class="radio_graph">
										<div class="radio_graph_bar" style="width: 17.3%;"></div>
										<span class="radio_response_num">17.3% (응답자 : 4명)</span>
									</div>
								</div>

							</div>
						</div>
			
					</form>
			
				</div>
			</div>
		</div>
		
		<div class="survey_btn_box">
			<a href="">목록으로</a>
			
			<!-- 다운로드 버튼 -->
			<a href="" class="download">엑셀 다운로드</a>
		</div>
	</div>

</div>



<script type="text/javascript">
	$(document).ready(function() {
		$('#dashboard').addClass('selected');
	});
</script>