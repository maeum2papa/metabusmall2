<script type="text/javascript" src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">회원아이디</label>
				<div class="col-sm-10 form-inline">
					<span class="form-control"><?php echo set_value('mem_userid', element('mem_userid', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">회원이메일</label>
				<div class="col-sm-8">
					<span class="form-control"><?php echo set_value('mem_email', element('mem_email', element('data', $view))); ?></span>
				</div>
				<div class="col-sm-2">
					<span class="form-control"><?php echo set_checkbox('mem_email_cert', '1', (element('mem_email_cert', element('data', $view)) ? '인증' : '미인증')); ?></span>
				</div>
			</div>

        <div class="form-group">
            <label class="col-sm-2 control-label">소속기업</label>
            <div class="col-sm-10 form-inline">
				<input type="text" class="form-control" name="company_name" value="<?php echo element('company_name', element('data', $view)); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">부서명</label>
            <div class="col-sm-10">
				<input type="text" class="form-control" name="mem_div" value="<?php echo set_value('mem_div', element('mem_div', element('data', $view))); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">직책</label>
            <div class="col-sm-10">
				<input type="text" class="form-control" name="mem_position" value="<?php echo set_value('mem_position', element('mem_position', element('data', $view))); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">상태</label>
            <div class="col-sm-10">
				<input type="text" class="form-control" name="mem_state" value="<?php echo set_value('mem_state', element('mem_state', element('data', $view))); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">현재보유_씨앗</label>
            <div class="col-sm-10">
				<span class="form-control"><?php echo set_value('mem_cur_seed', element('mem_cur_seed', element('data', $view))); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">현재보유_열매</label>
            <div class="col-sm-10">
				<span class="form-control"><?php echo set_value('mem_cur_fruit', element('mem_cur_fruit', element('data', $view))); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">랭킹</label>
            <div class="col-sm-10">
				<span class="form-control"><?php echo set_value('mem_ranking', element('mem_ranking', element('data', $view))); ?></span>
            </div>
        </div>
        <div class="form-group">
				<label class="col-sm-2 control-label">회원실명</label>
				<div class="col-sm-10">
					<span class="form-control"><?php echo set_value('mem_username', element('mem_username', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">닉네임</label>
				<div class="col-sm-10">
					<span class="form-control"><?php echo set_value('mem_nickname', element('mem_nickname', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">회원그룹</label>
				<div class="col-sm-10">
					<span class="form-control">
						<?php foreach(element('member_group', element('data', $view)) as $k => $v){ ?>
							<?php if(element('mgr_id', $v) == '1'){ echo '사용자';}else{ echo '기업관리자';} ?>
						<?php } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">레벨</label>
				<div class="col-sm-10 form-inline">
					<span class="form-control"><?php echo element('mem_level', element('data', $view)); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">홈페이지</label>
				<div class="col-sm-10">
					<span class="form-control"><?php echo set_value('mem_homepage', element('mem_homepage', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">생일</label>
				<div class="col-sm-10">
					<span class="form-control"><?php echo set_value('mem_birthday', element('mem_birthday', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">전화번호</label>
				<div class="col-sm-10">
					<span class="form-control"><?php echo set_value('mem_phone', element('mem_phone', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">성별</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="form-control"><?php if(element('mem_sex', element('data', $view)) == 1){ echo '남성'; }else{ echo '여성'; } ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">주소</label>
				<div class="col-sm-10">
					<label for="mem_zipcode">우편번호</label>
					<label>
						<span class="form-control"><?php echo set_value('mem_zipcode', element('mem_zipcode', element('data', $view))); ?></span>
					</label>
					<div class="addr-line">
						<label for="mem_address1">기본주소</label>
						<span class="form-control"><?php echo set_value('mem_address1', element('mem_address1', element('data', $view))); ?></span>
					</div>
					<div class="addr-line">
						<label for="mem_address2">상세주소</label>
						<span class="form-control"><?php echo set_value('mem_address2', element('mem_address2', element('data', $view))); ?></span>
					</div>
					<label for="mem_address3">참고항목</label>
					<span class="form-control"><?php echo set_value('mem_address3', element('mem_address3', element('data', $view))); ?></span>
					<span class="form-control"><?php echo set_value('mem_address4', element('mem_address4', element('data', $view))); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">프로필사진</label>
				<div class="col-sm-10">
					<img src="<?php echo member_photo_url(element('mem_photo', element('data', $view))); ?>" alt="회원 사진" title="회원 사진" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">회원아이콘</label>
				<div class="col-sm-10">
					<img src="<?php echo member_icon_url(element('mem_icon', element('data', $view))); ?>" alt="회원 아이콘" title="회원 아이콘" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">메일받기</label>
				<div class="col-sm-10">
					<span class="form-control">
						<?php if(element('mem_receive_email', element('data', $view)) == 1){ echo '사용'; }else{ echo '미사용'; } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">쪽지사용</label>
				<div class="col-sm-10">
					<span class="form-control">
						<?php if(element('mem_use_note', element('data', $view)) == 1){ echo '사용'; }else{ echo '미사용'; } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SMS 문자받기</label>
				<div class="col-sm-10">
					<span class="form-control">
						<?php if(element('mem_receive_sms', element('data', $view)) == 1){ echo '사용'; }else{ echo '미사용'; } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">프로필공개</label>
				<div class="col-sm-10">
					<span class="form-control">
						<?php if(element('mem_open_profile', element('data', $view)) == 1){ echo '공개'; }else{ echo '비공개'; } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">승인상태</label>
				<div class="col-sm-10 form-inline">
					<span class="form-control">
						<?php if(element('mem_denied', element('data', $view)) == 0){ echo '승인'; }else{ echo '차단'; } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">최고관리자</label>
				<div class="col-sm-10 form-inline">
					<span class="form-control">
						<?php if(element('mem_is_admin', element('data', $view)) === 1){ echo '최고관리자입니다'; }else{ echo '아닙니다'; } ?>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">프로필</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="mem_profile_content" readonly><?php echo set_value('mem_profile_content', element('mem_profile_content', element('data', $view))); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">관리자용 메모</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="mem_adminmemo"><?php echo set_value('mem_adminmemo', element('mem_adminmemo', element('data', $view))); ?></textarea>
				</div>
			</div>
			<?php
			if (element('html_content', $view)) {
				foreach (element('html_content', $view) as $key => $value) {
			?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="<?php echo element('field_name', $value); ?>"><?php echo element('display_name', $value); ?></label>
					<div class="col-sm-10"><?php echo element('input', $value); ?></div>
				</div>
			<?php
				}
			}
			?>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >목록으로</button>
				<!-- <button type="submit" class="btn btn-success btn-sm">저장하기</button> -->
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	// $('#fadminwrite').validate({
	// 	rules: {
	// 		mem_userid: { required: true, minlength:3, maxlength:20 },
	// 		mem_username: {minlength:2, maxlength:20 },
	// 		mem_nickname: {required :true, minlength:2, maxlength:20 },
	// 		mem_email: {required :true, email:true },
	// 		mem_password: {minlength :4 }
	// 	}
	// });

    // $('#company_idx').val('<?php echo set_value('company_idx', element('company_idx', element('data', $view))); ?>');
});
//]]>
</script>
