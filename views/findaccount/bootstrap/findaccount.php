<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
	/* 미노출 처리 */
	header, .navbar, .sidebar, footer, #feedback_write_btn { display:none; }
</style>

<div class="search col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">

		<!-- asmo sh 231114 계정 찾기 아이콘 배너 추가 -->
			<?=banner('find_account_icon')?>
		<!-- //asmo sh 231114 계정 찾기 아이콘 배너 추가 -->

			패스워드 재설정
		</div>
		<div class="panel-body">
			<?php
			echo validation_errors('<div class="alert_findaccount alert alert-warning" role="alert">', '</div>');
			echo show_alert_message(element('message', $view), '<div class="alert_findaccount alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'findidpwform', 'id' => 'findidpwform');
			echo form_open(current_full_url(), $attributes);
			?>
				<input type="hidden" name="findtype" value="findidpw" />
				<legend>패스워드 재설정 메일 발송</legend>

				<!-- asmo sh 231114 디자인 상 텍스트에 <br> 태그 추가 -->
				<p>로그인 시 사용하는 이메일 주소를 입력하시면 패스워드 재설정 안내 메일이 발송됩니다.</p>
				<!-- //asmo sh 231114 디자인 상 텍스트에 <br> 태그 추가 -->

				<div class="input-group col-md-8">

					<!-- asmo sh 231114 placeholder "Email Address" -> "이메일 입력"으로 변경  -->
					<input type="email" name="idpw_email" id="idpw_email" class="form-control" placeholder="이메일 입력" />
					<!-- //asmo sh 231114 placeholder "Email Address" -> "이메일 입력"으로 변경  -->

					<span class="input-group-btn">
						<button class="btn btn-black btn-sm" type="submit">메일 발송</button>
					</span>
				</div>
			<?php
			echo form_close();

			if ($this->cbconfig->item('use_register_email_auth')) {
				$attributes = array('class' => 'form-horizontal', 'name' => 'verifyemailform', 'id' => 'verifyemailform');
				echo form_open(current_full_url(), $attributes);
				?>
					<input type="hidden" name="findtype" value="verifyemail" />
					<legend>인증메일 재발송</legend>
					<p>회원가입이나, 이메일주소 변경 후 인증 메일을 받지 못한 경우 다시 받을 수 있습니다.</p>
					<div class="input-group col-md-8">
						<input type="email" name="verify_email" id="verify_email" class="form-control" placeholder="Email Address" />
						<span class="input-group-btn">
							<button class="btn btn-black btn-sm" type="submit">인증메일 재발송</button>
						</span>
					</div>
				<?php
				echo form_close();
				$attributes = array('class' => 'form-horizontal', 'name' => 'changeemailform', 'id' => 'changeemailform');
				echo form_open(current_full_url(), $attributes);
				?>
					<input type="hidden" name="findtype" value="changeemail" />
					<legend>이메일 주소 변경</legend>
					<p>인증메일이 도착하지 않아 어려움을 겪고 계시다면, 다른 이메일 주소로 변경해 인증해보세요.</p>
					<div class="form-group">
						<label class="col-lg-3 control-label">아이디</label>
						<div class="col-md-4">
							<input type="text" name="change_userid" id="change_userid" class="form-control" placeholder="User ID" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">비밀번호</label>
						<div class="col-md-4">
							<input type="password" name="change_password" id="change_password" class="form-control" placeholder="Password" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">새로운이메일주소</label>
						<div class="col-md-6">
							<input type="email" name="change_email" id="change_email" class="form-control" placeholder="Email Address" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4 col-lg-offset-3">
							<button type="submit" class="btn btn-black btn-sm">새로운 이메일주소로 인증메일 재발송</button>
						</div>
					</div>
			<?php
				echo form_close();
			}
			?>
		</div>

		<!-- asmo sh 231114 디자인 상 배경 꾸며주는 div 생성 -->
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

	// asmo sh 231114 계정찾기 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {

			$('.main').addClass('add');

			// 계정 찾기 페이지 디자인 상 피드백 버튼 숨김 처리 스크립트
			//$('#feedback_write_btn').addClass('dn');
		});

//<![CDATA[
$(function() {
	$('#findidpwform').validate({
		rules: {
			idpw_email : { required:true, email:true }
		}
	});
	$('#verifyemailform').validate({
		rules: {
			verify_email : { required:true, email:true }
		}
	});
	$('#changeemailform').validate({
		rules: {
			change_userid : { required:true, minlength:3 },
			change_password : { required:true, minlength:4 },
			change_email : { required:true, email:true }
		}
	});
});
//]]>
</script>
