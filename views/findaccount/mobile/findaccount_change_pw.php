<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<style>
	/* 푸터 미노출 처리 */
	footer { display:none; }
</style>

<div class="findarea">
	<div class="table-box">
		<div class="table-heading">패스워드 변경하기</div>
		<div class="table-body change_pw">
			<?php
			
			
			if ( ! element('error_message', $view) && ! element('success_message', $view)) {
				
				$attributes = array('class' => 'form-horizontal', 'name' => 'fresetpw', 'id' => 'fresetpw');
				echo form_open(current_full_url(), $attributes);
			?>
				<h3>패스워드 변경</h3>
				<p class="text">회원님의 패스워드를 변경합니다. 비밀번호는 4자리 이상이어야 합니다.</p>
				<ol class="change_password">
					<li>
						<!-- <span>아이디</span> -->
						<div class="asmo_id_wrap">
							<?php echo element('mem_userid', $view); ?>
						</div>
					</li>
					<li>
						<!-- <span>새로운 패스워드</span> -->
						<input type="password" name="new_password" id="new_password" class="input" placeholder="새로운 패스워드 입력" />
					</li>
					<li>
						<!-- <span>새로운 패스워드(재입력)</span> -->
						<input type="password" name="new_password_re" id="new_password_re" class="input" placeholder="새로운 패스워드 재입력" />
					</li>
					<li class="asmo_reset_btn_wrap">
						<!-- <span></span> -->
						<button id="asmo_reset_pw_btn" type="submit" class="btn btn-black btn-sm">패스워드 변경하기</button>
					</li>
				</ol>
			<?php
				echo show_alert_message(element('info', $view), '<div class="alert alert-info">', '</div>');
				echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
				echo show_alert_message(element('error_message', $view), '<div class="alert alert-dismissible alert-warning"><button type="button" class="close alertclose" >&times;</button>', '</div>');
				echo show_alert_message(element('success_message', $view), '<div class="alert alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
				echo form_close();
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
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
