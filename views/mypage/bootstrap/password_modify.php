<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
	/* 미노출 처리 */
	header, .navbar, .sidebar, footer, #feedback_write_btn { display:none; }
</style>

<!-- asmo sh 231116 회원 비밀번호 변경 div.mypage에 pw_modi 클래스 추가 -->
<div class="mypage pw_modi">
<!-- //asmo sh 231116 회원 비밀번호 변경 div.mypage에 pw_modi 클래스 추가 -->

	<ul class="nav nav-tabs">
		<li><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
		<li><a href="<?php echo site_url('mypage/post'); ?>" title="나의 작성글">나의 작성글</a></li>
		<?php if ($this->cbconfig->item('use_point')) { ?>
			<li><a href="<?php echo site_url('mypage/point'); ?>" title="포인트">포인트</a></li>
		<?php } ?>
		<li><a href="<?php echo site_url('mypage/followinglist'); ?>" title="팔로우">팔로우</a></li>
		<li><a href="<?php echo site_url('mypage/like_post'); ?>" title="내가 추천한 글">추천</a></li>
		<li><a href="<?php echo site_url('mypage/scrap'); ?>" title="나의 스크랩">스크랩</a></li>
		<li><a href="<?php echo site_url('mypage/loginlog'); ?>" title="나의 로그인기록">로그인기록</a></li>
		<li class="active"><a href="<?php echo site_url('membermodify'); ?>" title="정보수정">정보수정</a></li>
		<li><a href="<?php echo site_url('membermodify/memberleave'); ?>" title="탈퇴하기">탈퇴하기</a></li>
	</ul>

	<!-- asmo sh 231116 div.contents_wrap 생성 -->
	<div class="contents_wrap">
	<!-- //asmo sh 231116 div.contents_wrap 생성 -->

		<!-- asmo sh 231116 회원 비밀번호 변경 페이지 로고 생성 -->
		<a href="<?php echo site_url('dashboard'); ?>"><?=banner('change_pw_logo')?></a>
		<!-- //asmo sh 231116 회원 비밀번호 변경 페이지 로고 생성 -->

		<!-- asmo sh 231116 div.panel 생성 -->
		<div class="panel">
		<!-- //asmo sh 231116 div.panel 생성 -->
			
			<div class="page-header">
				<h4>패스워드 재설정</h4>
			</div>
			<div class="form-horizontal mt20">
				<?php
				echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
				echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
				echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
				echo show_alert_message(element('info', $view), '<div class="alert alert-info dn">', '</div>');
				$attributes = array('class' => 'form-horizontal', 'name' => 'fchangepassword', 'id' => 'fchangepassword');
				echo form_open(current_url(), $attributes);
				?>

					<legend>패스워드 재설정</legend>
					<!-- asmo sh 231114 텍스트 변경  -->
					<p class="asmo_pw_change_p">안전한 서비스 이용을 위해 임시 패스워드를 사용하실 패스워드로 변경해주세요. <br> 비밀번호는 4자리 이상이어야 합니다.</p>
					<div class="form-group">
						<label for="mem_userid" class="col-sm-3 control-label">아이디</label>
						<div class="col-sm-9 id">
							<p class="form-control-static"><strong><?php echo $this->member->item('mem_email'); ?></strong></p>
						</div>
					</div>
					<div class="form-group">
						<label for="cur_password" class="col-sm-3 control-label">현재비밀번호</label>
						<div class="col-sm-9">

							<!-- asmo sh 231114 placeholder "현재 패스워드"로 변경  -->
							<input type="password" class="form-control px150" id="cur_password" name="cur_password" placeholder="현재 패스워드" />
							<!-- //asmo sh 231114 placeholder "현재 패스워드"로 변경  -->

						</div>
					</div>
					<div class="form-group">
						<label for="new_password" class="col-sm-3 control-label">새로운비밀번호</label>
						<div class="col-sm-9">

							<!-- asmo sh 231114 placeholder "새로운 패스워드 입력"로 변경  -->
							<input type="password" class="form-control px150" id="new_password" name="new_password" placeholder="새로운 패스워드 입력" />
							<!-- //asmo sh 231114 placeholder "새로운 패스워드 입력"로 변경  -->

						</div>
					</div>
					<div class="form-group">
						<label for="new_password_re" class="col-sm-3 control-label">재입력</label>
						<div class="col-sm-9">

							<!-- asmo sh 231114 placeholder "새로운 패스워드 재입력"로 변경  -->
							<input type="password" class="form-control px150" id="new_password_re" name="new_password_re" placeholder="새로운 패스워드 재입력" />
							<!-- //asmo sh 231114 placeholder "새로운 패스워드 재입력"로 변경  -->

						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-9 col-lg-offset-3">
							<button type="submit" class="btn btn-success btn-sm">패스워드 변경하기</button>
						</div>
					</div>
				<?php echo form_close(); ?>
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

//<![CDATA[
$(function() {
	$('#fchangepassword').validate({
		rules: {
			cur_password : { required:true },
			new_password : { required:true, minlength:<?php echo element('password_length', $view); ?> },
			new_password_re : { required:true, minlength:<?php echo element('password_length', $view); ?>, equalTo: '#new_password' }
		}
	});
});
//]]>
</script>
