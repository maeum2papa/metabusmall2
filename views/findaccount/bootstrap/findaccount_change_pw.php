<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
	/* 미노출 처리 */
	header, .navbar, .sidebar, footer { display:none; }
</style>

<div class="search col-md-8 col-md-offset-2">

<!-- asmo sh 231114 div.contents_wrap 생성 및 디자인 상 alert창 없애기 위해 del_alert 클래스 추가 -->
	<div class="contents_wrap del_alert">
<!-- //asmo sh 231116 div.contents_wrap 생성 및 디자인 상 alert창 없애기 위해 del_alert 클래스 추가 -->


		<!-- asmo sh 231114 패스워드 변경하기 페이지 로고 생성 -->
		<a href=""><?=banner('change_pw_logo')?></a>
		<!-- //asmo sh 231114 패스워드 변경하기 페이지 로고 생성 -->

		<div class="panel panel-default">
			<div class="panel-heading"><?=banner('find_account_icon')?>패스워드 재설정</div>
			<div class="panel-body">
				<!-- asmo sh 231114 -->
				<?php
				echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
				echo show_alert_message(element('error_message', $view), '<div class="alert alert-dismissible alert-warning"><button type="button" class="close alertclose" >&times;</button>', '</div>');
				echo show_alert_message(element('success_message', $view), '<div class="alert alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
				if ( ! element('error_message', $view) && ! element('success_message', $view)) {
					echo show_alert_message(element('info', $view), '<div class="alert alert-info">', '</div>');
					$attributes = array('class' => 'form-horizontal', 'name' => 'fresetpw', 'id' => 'fresetpw');
					echo form_open(current_full_url(), $attributes);
				?>
					<legend>패스워드 재설정</legend>
					<!-- asmo sh 231114 텍스트 변경  -->
					<p class="asmo_pw_change_p"><?php echo element('mem_nickname', $view); ?>님의 패스워드를 변경합니다. 비밀번호는 4자리 이상이어야 합니다.</p>
					<!-- //asmo sh 231114 텍스트 변경  -->
					<div class="form-group">
						<label class="col-lg-3 control-label">아이디</label>
						<div class="col-md-4 id"><?php echo element('mem_email', $view); ?></div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">새로운 패스워드</label>
						<div class="col-md-4">
							<!-- asmo sh 231114 placeholder "새로운 패스워드 입력"로 변경  -->
							<input type="password" name="new_password" id="new_password" class="form-control" placeholder="새로운 패스워드 입력" />
							<!-- //asmo sh 231114 placeholder "새로운 패스워드 입력"로 변경  -->
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">새로운 패스워드(재입력)</label>
						<div class="col-md-4">
							<!-- asmo sh 231114 placeholder "새로운 패스워드 재입력"로 변경  -->
							<input type="password" name="new_password_re" id="new_password_re" class="form-control" placeholder="새로운 패스워드 재입력" />
							<!-- //asmo sh 231114 placeholder "새로운 패스워드 재입력"로 변경  -->
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4 col-lg-offset-3">
							<button type="submit" class="btn btn-black btn-sm">패스워드 변경하기</button>
						</div>
					</div>
				<?php
					echo form_close();
				}
				?>
			</div>
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

	// asmo sh 231114 패스워드 변경하기 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {
		

		$('.main').addClass('add');
	});

//<![CDATA[
$(function() {
	$('#fresetpw').validate({
		rules: {
			new_password : { required:true, minlength:<?php echo element('password_length', $view); ?> },
			new_password_re : { required:true, minlength:<?php echo element('password_length', $view); ?>, equalTo : '#new_password' }
		}
	});
});
//]]>
</script>
