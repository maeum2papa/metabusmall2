<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
	/* 미노출 처리 */
	header, .navbar, .sidebar, footer, #feedback_write_btn { display:none; }
</style>

<div class="search">

	<div class="contents_wrap asmo_tos">

		<!-- asmo sh 231116 회원 비밀번호 변경 페이지 로고 생성 -->
		<a href="javascript:;"><?=banner('change_pw_logo')?></a>
		<!-- //asmo sh 231116 회원 비밀번호 변경 페이지 로고 생성 -->

		<!-- asmo sh 231116 div.panel 생성 -->
		<div class="panel">
		<!-- //asmo sh 231116 div.panel 생성 -->
			
			<div class="panel-heading">
				<h4>이용약관 동의</h4>
			</div>
			<div class="panel-body">
				<form>
					<p class="asmo_pw_change_p">서비스 이용 전, 컬래버랜드 약관을 확인해주세요.</p>


					
					
					<div class="form-group_wrap">

						<div class="checkbox_all">
							<input type="checkbox" name="agree_all" id="agree_all" value="1" />
							<label for="agree_all"> 전체동의</label>
						</div>

						<div class="form-group">
							

							<div class="col-lg-12">
								<span>이용약관 동의</span>
								<div class="checkbox">

									<input type="checkbox" name="agree" id="agree" value="1" /> 
									<label for="agree">동의합니다 (필수)</label>
								</div>
							</div>

							<div class="col-lg-12">
								<textarea class="form-control" rows="3" readonly="readonly">제 1 장 총 칙 제 1 조 (목적) 이 약관은 {COMPANY_NAME}(이하 "사이트"라 합니다)에서 제공하는 인터넷서비스(이하 "서비스"라 합니다)의 이용 조건 및 절차에 관한 기본적인 사항을 규정함을 목적으로 합니다. 제 2 조 (약관의 효력 및 변경) ① 이 약관은 서비스 화면이나 기타의 방법으로 이용고객에게 공지함으로써 효력을 발생합니다. ② 사이트는 이 약관의 내용을 변경할 수 있으며, 변경된 약관은 제1항과 같은 방법으로 공지 또는 통지함으로써 효력을 발생합니다. 제 3 조 (용어의 정의) 이 약관에서 사용하는 용어의 정의는 다음과 같습니다. ① 회원 : 사이트와 서비스 이용계약을 체결하거나 이용자 아이디(ID)를 부여받은 개인 또는 단체를 말합니다. ② 신청자 : 회원가입을 신청하는 개인 또는 단체를 말합니다. ③ 아이디(ID) : 회원의 식별과 서비스 이용을 위하여 회원이 정하고 사이트가 승인하는 문자와 숫자의 조합을 말합니다. ④ 비밀번호 : 회원이 부여 받은 아이디(ID)와 일치된 회원임을 확인하고, 회원 자신의 비밀을 보호하기 위하여 회원이 정한 문자와 숫자의 조합을 말합니다. ⑤ 해지 : 사이트 또는 회원이 서비스 이용계약을 취소하는 것을 말합니다. 제 2 장 서비스 이용계약 제 4 조 (이용계약의 성립) ① 이용약관 하단의 동의 버튼을 누르면 이 약관에 동의하는 것으로 간주됩니다. ② 이용계약은 서비스 이용희망자의 이용약관 동의 후 이용 신청에 대하여 사이트가 승낙함으로써 성립합니다. 제 5 조 (이용신청) ① 신청자가 본 서비스를 이용하기 위해서는 사이트 소정의 가입신청 양식에서 요구하는 이용자 정보를 기록하여 제출해야 합니다. ② 가입신청 양식에 기재하는 모든 이용자 정보는 모두 실제 데이터인 것으로 간주됩니다. 실명이나 실제 정보를 입력하지 않은 사용자는 법적인 보호를 받을 수 없으며, 서비스의 제한을 받을 수 있습니다.</textarea>
							</div>
						</div>

						<div class="form-group">
							

							<div class="col-lg-12">
								<span>개인정보 수집 및 이용동의</span>1
								<div class="checkbox">

									<input type="checkbox" name="agree2" id="agree2" value="1" /> 
									<label for="agree2">동의합니다 (필수)</label>
								</div>
							</div>

							<div class="col-lg-12">
								<textarea class="form-control" rows="3" readonly="readonly">제 1 장 총 칙 제 1 조 (목적) 이 약관은 {COMPANY_NAME}(이하 "사이트"라 합니다)에서 제공하는 인터넷서비스(이하 "서비스"라 합니다)의 이용 조건 및 절차에 관한 기본적인 사항을 규정함을 목적으로 합니다. 제 2 조 (약관의 효력 및 변경) ① 이 약관은 서비스 화면이나 기타의 방법으로 이용고객에게 공지함으로써 효력을 발생합니다. ② 사이트는 이 약관의 내용을 변경할 수 있으며, 변경된 약관은 제1항과 같은 방법으로 공지 또는 통지함으로써 효력을 발생합니다. 제 3 조 (용어의 정의) 이 약관에서 사용하는 용어의 정의는 다음과 같습니다. ① 회원 : 사이트와 서비스 이용계약을 체결하거나 이용자 아이디(ID)를 부여받은 개인 또는 단체를 말합니다. ② 신청자 : 회원가입을 신청하는 개인 또는 단체를 말합니다. ③ 아이디(ID) : 회원의 식별과 서비스 이용을 위하여 회원이 정하고 사이트가 승인하는 문자와 숫자의 조합을 말합니다. ④ 비밀번호 : 회원이 부여 받은 아이디(ID)와 일치된 회원임을 확인하고, 회원 자신의 비밀을 보호하기 위하여 회원이 정한 문자와 숫자의 조합을 말합니다. ⑤ 해지 : 사이트 또는 회원이 서비스 이용계약을 취소하는 것을 말합니다. 제 2 장 서비스 이용계약 제 4 조 (이용계약의 성립) ① 이용약관 하단의 동의 버튼을 누르면 이 약관에 동의하는 것으로 간주됩니다. ② 이용계약은 서비스 이용희망자의 이용약관 동의 후 이용 신청에 대하여 사이트가 승낙함으로써 성립합니다. 제 5 조 (이용신청) ① 신청자가 본 서비스를 이용하기 위해서는 사이트 소정의 가입신청 양식에서 요구하는 이용자 정보를 기록하여 제출해야 합니다. ② 가입신청 양식에 기재하는 모든 이용자 정보는 모두 실제 데이터인 것으로 간주됩니다. 실명이나 실제 정보를 입력하지 않은 사용자는 법적인 보호를 받을 수 없으며, 서비스의 제한을 받을 수 있습니다.</textarea>
							</div>
						</div>

						<div class="form-group">
							
							<div class="col-lg-12">
								<span>마케팅 활용/ 광고성 정보 수신동의</span>
								<div class="checkbox">
									<input type="checkbox" name="agree3" id="agree3" value="1" /> 
									<label for="agree3">동의합니다 (선택)</label>
								</div>
							</div>

							<div class="col-lg-12">
								<textarea class="form-control" rows="3" readonly="readonly">제 1 장 총 칙 제 1 조 (목적) 이 약관은 {COMPANY_NAME}(이하 "사이트"라 합니다)에서 제공하는 인터넷서비스(이하 "서비스"라 합니다)의 이용 조건 및 절차에 관한 기본적인 사항을 규정함을 목적으로 합니다. 제 2 조 (약관의 효력 및 변경) ① 이 약관은 서비스 화면이나 기타의 방법으로 이용고객에게 공지함으로써 효력을 발생합니다. ② 사이트는 이 약관의 내용을 변경할 수 있으며, 변경된 약관은 제1항과 같은 방법으로 공지 또는 통지함으로써 효력을 발생합니다. 제 3 조 (용어의 정의) 이 약관에서 사용하는 용어의 정의는 다음과 같습니다. ① 회원 : 사이트와 서비스 이용계약을 체결하거나 이용자 아이디(ID)를 부여받은 개인 또는 단체를 말합니다. ② 신청자 : 회원가입을 신청하는 개인 또는 단체를 말합니다. ③ 아이디(ID) : 회원의 식별과 서비스 이용을 위하여 회원이 정하고 사이트가 승인하는 문자와 숫자의 조합을 말합니다. ④ 비밀번호 : 회원이 부여 받은 아이디(ID)와 일치된 회원임을 확인하고, 회원 자신의 비밀을 보호하기 위하여 회원이 정한 문자와 숫자의 조합을 말합니다. ⑤ 해지 : 사이트 또는 회원이 서비스 이용계약을 취소하는 것을 말합니다. 제 2 장 서비스 이용계약 제 4 조 (이용계약의 성립) ① 이용약관 하단의 동의 버튼을 누르면 이 약관에 동의하는 것으로 간주됩니다. ② 이용계약은 서비스 이용희망자의 이용약관 동의 후 이용 신청에 대하여 사이트가 승낙함으로써 성립합니다. 제 5 조 (이용신청) ① 신청자가 본 서비스를 이용하기 위해서는 사이트 소정의 가입신청 양식에서 요구하는 이용자 정보를 기록하여 제출해야 합니다. ② 가입신청 양식에 기재하는 모든 이용자 정보는 모두 실제 데이터인 것으로 간주됩니다. 실명이나 실제 정보를 입력하지 않은 사용자는 법적인 보호를 받을 수 없으며, 서비스의 제한을 받을 수 있습니다.</textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<button type="submit" class="btn btn-success btn-sm">다음</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- asmo sh 231116 디자인 상 배경 꾸며주는 div 생성 -->
		<div class="bg_div" id="bg_circle_1"></div>
		<div class="bg_div" id="bg_circle_2"></div>
		<div class="bg_div" id="bg_circle_3"></div>
		<div class="bg_div" id="bg_circle_5"></div>
	
		<img class="bg_icon" id="bg_icon_1" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/left_bottom_plus_yellow.svg" alt="left_bottom_plus_yellow">
		<img class="bg_icon" id="bg_icon_2" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/right_bottom_plus_blue.svg" alt="right_bottom_plus_blue">
		<img class="bg_icon" id="bg_icon_3" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/left_top_plus_blue.svg" alt="left_top_plus_blue">
		<img class="bg_icon" id="bg_icon_4" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/right_plus_yellow.svg" alt="right_plus_yellow">
		<img class="bg_icon" id="bg_icon_5" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/left_plus_yellow.svg" alt="left_plus_yellow">
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		$('.main').addClass('add');


	});


</script>
