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
	
	<div class="asmo_dashboard_sub" id="asmo_dashboard_event">
		<div class="dash_event_left_box">
			<div class="dash_sub_head">
				<h2><?=busiNm($this->member->item('company_idx'))?> 이벤트</h2>
			</div>

			<div class="dash_sub_body">

				<div class="dash_event_list_bar"></div>


				<div class="dash_event_selectbox">
					<div class="event_select_year">
						<select class="form-control">
							<option>2023</option>
							<option>2021</option>
							<option>2022</option>
							<option>2023</option>
							<option>2024</option>
							<option>2025</option>
						</select>
					</div>

					<div class="event_select_month">
						<select class="form-control">
							<option>1월</option>
							<option>2월</option>
							<option>3월</option>
							<option>4월</option>
							<option>5월</option>
							<option>6월</option>
							<option>7월</option>
							<option>8월</option>
							<option>9월</option>
							<option>10월</option>
							<option>11월</option>
							<option>12월</option>
						</select>
					</div>
				</div>

				<div class="dash_event_list">
				
					<div class="event_list_box">
						<div class="event_list_img">

						</div>
						<div class="event_list_title">
							<p>2023년 신년 이벤트</p>
							<span>팀메타 1월 생일자 이벤트를 진행합니다.</span>
						</div>

						<div class="event_list_etc">
							<div class="event_icon">
								<?=banner('event_birthday')?>
							</div>
							<strong>15<span>명</span></strong>
						</div>

					</div>

					<div class="event_list_box">
						<div class="event_list_img">

						</div>
						<div class="event_list_title">
							<p>진급자</p>
							<span>2024년 팀메타 진급 직원을 축하해주세요</span>
						</div>

						<div class="event_list_etc">
							<div class="event_icon">
								<?=banner('event_promotion')?>
							</div>
							<strong>15<span>명</span></strong>
						</div>
					</div>

					<div class="event_list_box">
						<div class="event_list_img">

						</div>
						<div class="event_list_title">
							<p>2023년 신년 이벤트</p>
							<span>팀메타 1월 생일자 이벤트를 진행합니다.</span>
						</div>

						<div class="event_list_etc">
							<div class="event_icon">
								<?=banner('event_promotion')?>
							</div>
							<strong>15<span>명</span></strong>
						</div>
					</div>

					<div class="event_list_box">
						<div class="event_list_img">

						</div>
						<div class="event_list_title">
							<p>진급자</p>
							<span>2024년 팀메타 진급 직원을 축하해주세요</span>
						</div>

						<div class="event_list_etc">
							<div class="event_icon">
								<?=banner('event_birthday')?>
							</div>
							<strong>15<span>명</span></strong>
						</div>
					</div>

				</div>
						
			</div>
		</div>

		<div class="dash_event_right_box">
			<div class="event_cont_box dn">
				<div class="event_cont_img">

				</div>

				<div class="event_cont">
					<h2>1월 생일자</h2>
					<p>팀메타 1월 생일자 이벤트를 진행합니다.</p>

					<span>동료의 랜드에 방문하여 축하해 주세요!</span>

					<div class="event_cont_land">
						<div class="event_cont_land_box">
							<span>R&D센터 ㅣ 서비스개발부 ㅣ 디자인팀</span>
							<p>홍길동 <span>대리</span></p>
							<a href=""><b>방문하기</b></a>
						</div>

						<div class="event_cont_land_box">
							<span>R&D센터 ㅣ 서비스개발부 ㅣ 디자인팀</span>
							<p>홍길동 <span>대리</span></p>
							<a href=""><b>방문하기</b></a>
						</div>

						<div class="event_cont_land_box">
							<span>R&D센터 ㅣ 서비스개발부 ㅣ 디자인팀</span>
							<p>홍길동 <span>대리</span></p>
							<a href=""><b>방문하기</b></a>
						</div>

						<div class="event_cont_land_box">
							<span>R&D센터 ㅣ 서비스개발부 ㅣ 디자인팀</span>
							<p>홍길동 <span>대리</span></p>
							<a href=""><b>방문하기</b></a>
						</div>
					</div>
				</div>
			</div>


			<!-- 이벤트 클릭 전 -->
			<div class="before_click">
				<p>이벤트 카드를 눌러 <br> 동료들을 축하해주세요</p>
			</div>
		</div>

		
	</div>
</div>


<script type="text/javascript">
	$(".event_list_box").click(function() {
		$(".event_list_box").removeClass("selected");
		$(this).addClass("selected");

		$(".event_cont_box").removeClass("dn");
		$(".before_click").addClass("dn");
	});

	$(document).ready(function() {
		$('#dashboard').addClass('selected');
	});

</script>