<style>
	/* 미노출 처리 */
	header, .navbar, .sidebar, footer, #feedback_write_btn { display:none; }
</style>

<div id="asmo_guest_name_page" class="access">
	<div class="panel panel-default asmo_guest_login_page">
		<div class="table-heading">
			<?=banner('login_logo')?>
		</div>

		<div class="panel-body">
			<div class="asmo_guest_login">
				<strong>게스트 로그인</strong>
				<p>사용하실 이름을 입력해주세요.</p>
			</div>

			<form class="asmo_guset_name_box">
				<div class="form-group">
					<label class="col-lg-4 control-label">이름 입력</label>
					<div class="col-lg-7">

						<input type="text" name="" class="form-control" value="" accesskey="L" placeholder="이름 입력" />

					</div>
				</div>

				<span>※ 입력하신 이름은 변경이 불가합니다.</span>

				<div class="form-group login_btn">
					<div class="col-sm-2 col-sm-offset-3">							
						<button type="submit" class="btn btn-primary btn-sm">컬래버랜드 접속</button>
					</div>
					<div class="col-sm-6 col-sm-offset-1">
						<label for="autologin">
							<input type="checkbox" name="autologin" id="autologin" value="1" /> 자동로그인
						</label>
					</div>
				</div>
			</form>
		</div>

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
</div>