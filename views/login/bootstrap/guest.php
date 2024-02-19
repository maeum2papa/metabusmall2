<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>



<style>
	/* 미노출 처리 */
	header, .navbar, .sidebar, footer, #feedback_write_btn { display:none; }
</style>

<div class="access col-md-6 col-md-offset-3">
	<div class="panel panel-default asmo_guest_login_page">
		
		
		<!-- asmo sh 231113 "로그인" 대신 컬래버랜드 로고 추가 -->
		<div class="table-heading">
			<?=banner('login_logo')?>
		</div>
		<!-- //asmo sh 231113 "로그인" 대신 컬래버랜드 로고 추가 -->


		<div class="panel-body">

			<!-- asmo sh 240201 게스트 로그인 링크 추가 -->
			<div class="asmo_guest_login">
				<strong>게스트 로그인</strong>
				<p>발급받은 초대코드를 입력해주세요.</p>
			</div>

			<!-- //asmo sh 240201 게스트 로그인 링크 추가 -->

			<?php
			echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
			echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-horizontal', 'name' => 'flogin', 'id' => 'flogin');
			echo form_open(current_full_url(), $attributes);
			?>
				<input type="hidden" name="url" value="<?php echo html_escape($this->input->get_post('url')); ?>" />
				<div class="form-group">
					<!--label class="col-lg-4 control-label"><?php echo element('userid_label_text', $view);?></label-->

					<!-- 초대코드 입력 input -->
                    <label class="col-lg-4 control-label">초대코드 입력</label>
					<div class="col-lg-7">

						<input type="text" name="mem_userid" class="form-control" value="<?php echo set_value('mem_userid'); ?>" accesskey="L" placeholder="초대코드 입력" />

					</div>
				</div>
				
				<div class="form-group login_btn">
					<div class="col-sm-2 col-sm-offset-3">

						<!-- asmo sh 231113 디자인 상 "로그인" -> "컬래버랜드 접속" 텍스트 변경 -->
						<button type="submit" class="btn btn-primary btn-sm">컬래버랜드 접속</button>
						<!-- //asmo sh 231113 디자인 상 "로그인" -> "컬래버랜드 접속" 텍스트 변경 -->

					</div>
					<div class="col-sm-6 col-sm-offset-1">
						<label for="autologin">
							<input type="checkbox" name="autologin" id="autologin" value="1" /> 자동로그인
						</label>
					</div>
				</div>
				<div class="alert alert-dismissible alert-info autologinalert" style="display:none;">
					자동로그인 기능을 사용하시면, 브라우저를 닫더라도 로그인이 계속 유지될 수 있습니다. 자동로그인 기능을 사용할 경우 다음 접속부터는 로그인할 필요가 없습니다. 단, 공공장소에서 이용 시 개인정보가 유출될 수 있으니 꼭 로그아웃을 해주세요.
				</div>
			<?php echo form_close(); ?>
			<?php
			if ($this->cbconfig->item('use_sociallogin')) {
				$this->managelayout->add_js(base_url('assets/js/social_login.js'));
			?>
				<div class="form-group mt30 form-horizontal">
					<label class="col-lg-4 control-label">소셜로그인</label>
					<div class="col-lg-7">
					<?php if ($this->cbconfig->item('use_sociallogin_facebook')) {?>
						<a href="javascript:;" onClick="social_connect_on('facebook');" title="페이스북 로그인"><img src="<?php echo base_url('assets/images/social_facebook.png'); ?>" width="22" height="22" alt="페이스북 로그인" title="페이스북 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_twitter')) {?>
						<a href="javascript:;" onClick="social_connect_on('twitter');" title="트위터 로그인"><img src="<?php echo base_url('assets/images/social_twitter.png'); ?>" width="22" height="22" alt="트위터 로그인" title="트위터 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_google')) {?>
						<a href="javascript:;" onClick="social_connect_on('google');" title="구글 로그인"><img src="<?php echo base_url('assets/images/social_google.png'); ?>" width="22" height="22" alt="구글 로그인" title="구글 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_naver')) {?>
						<a href="javascript:;" onClick="social_connect_on('naver');" title="네이버 로그인"><img src="<?php echo base_url('assets/images/social_naver.png'); ?>" width="22" height="22" alt="네이버 로그인" title="네이버 로그인" /></a>
					<?php } ?>
					<?php if ($this->cbconfig->item('use_sociallogin_kakao')) {?>
						<a href="javascript:;" onClick="social_connect_on('kakao');" title="카카오 로그인"><img src="<?php echo base_url('assets/images/social_kakao.png'); ?>" width="22" height="22" alt="카카오 로그인" title="카카오 로그인" /></a>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="panel-footer">
			<div class="pull-right">
				<!--a href="<?php echo site_url('register'); ?>" class="btn btn-success btn-sm" title="회원가입">회원가입</a-->
				
				<!-- asmo sh 231113 디자인 상 '아이디 패스워드 찾기' -> '비밀번호 재설정'으로 변경 후 팝업 레이어 버튼으로 변경 -->
				<!-- <a href="<?php echo site_url('findaccount'); ?>" class="btn btn-default btn-sm" title="패스워드 재설정">패스워드 재설정</a> -->
				<!-- //asmo sh 231113 디자인 상 '아이디 패스워드 찾기' -> '비밀번호 재설정'으로 변경 후 팝업 레이어 버튼으로 변경 -->

			</div>
		</div>

		<!-- asmo sh 231114 디자인 상 배경 꾸며주는 div 생성 -->
		<div class="bg_div" id="bg_circle_1"></div>
		<div class="bg_div" id="bg_circle_2"></div>
		<div class="bg_div" id="bg_circle_3"></div>
		<div class="bg_div" id="bg_circle_4"></div>
		<div class="bg_div" id="bg_circle_5"></div>
		<div class="bg_div" id="bg_circle_6"></div>
		<div class="bg_div" id="bg_circle_7"></div>
		<div class="bg_div" id="bg_circle_8"></div>
		<div class="bg_div" id="bg_circle_9"></div>

		<img class="bg_icon" id="bg_icon_1" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/left_bottom_plus_yellow.svg" alt="left_bottom_plus_yellow">
		<img class="bg_icon" id="bg_icon_2" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/right_bottom_plus_blue.svg" alt="right_bottom_plus_blue">
		<img class="bg_icon" id="bg_icon_3" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/left_top_plus_blue.svg" alt="left_top_plus_blue">
		<img class="bg_icon" id="bg_icon_4" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/right_plus_yellow.svg" alt="right_plus_yellow">
		<img class="bg_icon" id="bg_icon_5" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/left_plus_yellow.svg" alt="left_plus_yellow">




	</div>
	
	
	<!-- asmo sh 240201 비활성상태 로그인 시 모달창 생성 -->
	<div id="asmo_inactive_login_bg">
		<div class="asmo_inactive_login">
			<p>비활성화된 계정입니다.<br> 담당자에게 문의해주세요.</p>
			<button type="button" class="btn btn-primary btn-sm" id="asmo_inactive_login_close">닫기</button>
		</div>
	</div>
	
</div>

<!-- asmo sh 231114 로딩창 생성 -->
<!-- <div id="loading" class=>
	<div class="star_bg_box">
		<img class="star_bg" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/star_bg.svg" alt="star_bg">
		<img class="star_bg_twinkle" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/star_bg_twinkle.svg" alt="star_bg_twinkle">
	</div>

	<div class="loading_logo_box">
		<img class="loading_logo_white" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/collabor_white.svg" alt="collabor_white">
		<img class="loading_logo_gradient" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/collabor_gradient.svg" alt="collabor_gradient">			
	</div>
</div> -->


<script type="text/javascript">

	// 로딩창 불러오는 스크립트 
	function showLoading() {
		$('#loading').addClass('on');
	}

	function onSubmitLogin() {
		// 만약 로그인이 성공한다면

		showLoading();
	}

	// $.ajax({		
	// 	url:"xxxxxxxxxxxxxxxxxxx",
	// 	type:'POST',		
	// 	dataType:'json',		
	// 	data:JSON.stringify(sendObject),		
	// 	contentType: 'text/html;charset=UTF-8',		
	// 	mimeType: 'application/json',		
	// 	success:function(data) {			
	// 		if(data.MESSAGE) {				 
	// 			alert("로그인성공");				 
	// 			window.location.href = "main.html";			
	// 		} else {				
	// 			alert("로그인실패");			
	// 		}		
	// 	},		
	// 	error:function(data,status,er) {			
	// 		alert("error: "+data+" status: "+status+" er:"+er);		
	// 	}	
	// });



	// asmo sh 231114 로그인 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {
		// $('header').addClass('dn');
		// $('.navbar').addClass('dn');
		// $('.sidebar').addClass('dn');
		// $('footer').addClass('dn');

		$('.main').addClass('add');

	});

//<![CDATA[
$(function() {
	$('#flogin').validate({
		rules: {
			mem_userid : { required:true, minlength:3 },
			mem_password : { required:true, minlength:4 }
		},
		
	});
});
$(document).on('change', "input:checkbox[name='autologin']", function() {
	if (this.checked) {
		$('.autologinalert').show(300);
	} else {
		$('.autologinalert').hide(300);
	}
});
//]]>
</script>

