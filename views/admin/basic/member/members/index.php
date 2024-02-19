<div class="box">
	
	
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		
		<div class="box-search">
			<div style="width: 100%; height: 50px;"></div>
			<div style="height: 40px; float: left;">이용가능인원 <?=number_format($view[data][total_rows])?>명 &nbsp; &nbsp; &nbsp;</div>
			<div style="height: 40px; float: left;">현재이용인원 <?=number_format($view[useYn])?>명 &nbsp; &nbsp; &nbsp;</div>
			<div class="btn-group pull-right" role="group" aria-label="..." style="height: 40px;">
				<a href="./members/excel_upload" class="btn btn-outline btn-default btn-sm"><i class="fa fa-file-excel-o"></i> 엑셀 업로드</a>
				<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
				<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
<!--				<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>-->
				<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">직원추가</a>
			</div>
			<div class="row" style="clear: both">
				
				<div class="btn-group btn-group-sm" role="group" style="float: left">
					<a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('mgr_id')) ? 'btn-success' : 'btn-default'; ?>">전체그룹</a>
					<?php
					foreach (element('all_group', $view) as $gkey => $gval) {
					?>
						<a href="?mgr_id=<?php echo element('mgr_id', $gval); ?>" class="btn btn-sm <?php echo (element('mgr_id', $gval) === $this->input->get('mgr_id')) ? 'btn-success' : 'btn-default'; ?>"><?php echo element('mgr_title', $gval); ?></a>
					<?php
					}
					?>
				</div>
				
				<div class="col-md-6 col-md-offset-3" style="margin-left: 0; width: 650px; float: left;">
					<select class="form-control" name="sfield" style="width: 250px;">
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group" style="width: 300px;">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist', 'method' => 'get');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="btn-group btn-group-sm" role="group" style="display: none">
					<a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('mem_is_admin') && ! $this->input->get('mem_denied')) ? 'btn-success' : 'btn-default'; ?>">전체회원</a>
					<a href="?mem_is_admin=1" class="btn btn-sm <?php echo ($this->input->get('mem_is_admin')) ? 'btn-success' : 'btn-default'; ?>">최고관리자</a>
					<a href="?mem_denied=1" class="btn btn-sm <?php echo ($this->input->get('mem_denied')) ? 'btn-success' : 'btn-default'; ?>">차단회원</a>
				</div>
				<div class="btn-group btn-group-sm" role="group" style="display: none">
					<a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('mgr_id')) ? 'btn-success' : 'btn-default'; ?>">전체그룹</a>
					<?php
					foreach (element('all_group', $view) as $gkey => $gval) {
					?>
						<a href="?mgr_id=<?php echo element('mgr_id', $gval); ?>" class="btn btn-sm <?php echo (element('mgr_id', $gval) === $this->input->get('mgr_id')) ? 'btn-success' : 'btn-default'; ?>"><?php echo element('mgr_title', $gval); ?></a>
					<?php
					}
					?>
				</div>
                <div class="btn-group btn-group-sm" role="group" style="display: none">
                    <select id="sh_company_name" name="sh_company_name" class="form-control" onchange="onchange_company();">
                        <option value="">전체기업</option>
                        <?php  foreach($view['company_list'] as $l) { echo "<option value='".$l['company_idx']."'>".$l['company_name']."</option>";}?>
                    </select>
                </div>
				<?php
				ob_start();
				?>
					
				<?php
				$buttons = ob_get_contents();
				ob_end_flush();
				?>
			</div>
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><input type="checkbox" name="chkall" id="chkall" /></th>
							<th><a href="<?php echo element('mem_id', element('sort', $view)); ?>">번호</a></th>
                            <th style="width: 110px;">기업명</th>
                            <th style="width: 140px;">부서명</th>
                            <th>직책</th>
                            <th>보유씨앗</th>
                            <th>보유열매</th>
							<th><a href="<?php echo element('mem_userid', element('sort', $view)); ?>">아이디</a></th>
							<th><a href="<?php echo element('mem_username', element('sort', $view)); ?>">실명</a></th>
							<th><a href="<?php echo element('mem_nickname', element('sort', $view)); ?>">닉네임</a></th>
							<th><a href="<?php echo element('mem_email', element('sort', $view)); ?>">이메일</a></th>
							<?php if ($this->cbconfig->item('use_selfcert')) { ?>
								<th>본인인증</th>
							<?php } ?>
							<?php if ($this->cbconfig->item('use_sociallogin')) { ?>
								<th>소셜연동</th>
							<?php } ?>
							<th><a href="<?php echo element('mem_register_datetime', element('sort', $view)); ?>">가입일</a></th>
							<th><a href="<?php echo element('mem_lastlogin_datetime', element('sort', $view)); ?>">최근로그인</a></th>
                            <th>회원그룹</th>
							<th>승인</th>
							<th>학습현황</th>
							<th>수정</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
							<td><?php echo number_format(element('num', $result)); ?></td>
                            <td><?php echo element('company_name', $result); ?></td>
                            <td><?php echo element('mem_div', $result); ?></td>
                            <td><?php echo element('mem_position', $result); ?></td>
                            <td><?php echo number_format(element('mem_cur_seed', $result)); ?></td>
                            <td><?php echo number_format(element('mem_cur_fruit', $result)); ?></td>
							<td><?php echo element('mem_userid', $result); ?></td>
							<td>
								<span><?php echo html_escape(element('mem_username', $result)); ?></span>
								<?php echo element('mem_is_admin', $result) ? '<span class="label label-primary">최고관리자</span>' : ''; ?>
								<?php echo element('mem_denied', $result) ? '<span class="label label-danger">차단</span>' : ''; ?>
							</td>
							<td><?php echo element('display_name', $result); ?></td>
							<td><?php echo html_escape(element('mem_email', $result)); ?></td>
							<?php if ($this->cbconfig->item('use_selfcert')) { ?>
								<td>
									<?php
									echo (element('selfcert_type', element('meta', $result)) === 'phone') ? '<span class="label label-success">휴대폰</span>' : '';
									echo (element('selfcert_type', element('meta', $result)) === 'ipin') ? '<span class="label label-success">IPIN</span>' : '';
									echo is_adult(element('selfcert_birthday', element('meta', $result))) ? '<span class="label label-danger">성인</span>' : '';
									?>
								</td>
							<?php } ?>
							<?php if ($this->cbconfig->item('use_sociallogin')) { ?>
								<td>
									<?php if ($this->cbconfig->item('use_sociallogin_facebook') && element('facebook_id', element('social', $result))) { ?>
										<a href="javascript:;" onClick="social_open('facebook', '<?php echo element('mem_id', $result); ?>');"><img src="<?php echo base_url('assets/images/social_facebook.png'); ?>" width="15" height="15" alt="페이스북 로그인" title="페이스북 로그인" /></a>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_sociallogin_twitter') && element('twitter_id', element('social', $result))) { ?>
										<a href="javascript:;" onClick="social_open('twitter', '<?php echo element('mem_id', $result); ?>');"><img src="<?php echo base_url('assets/images/social_twitter.png'); ?>" width="15" height="15" alt="트위터 로그인" title="트위터 로그인" /></a>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_sociallogin_google') && element('google_id', element('social', $result))) { ?>
										<a href="javascript:;" onClick="social_open('google', '<?php echo element('mem_id', $result); ?>');"><img src="<?php echo base_url('assets/images/social_google.png'); ?>" width="15" height="15" alt="구글 로그인" title="구글 로그인" /></a>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_sociallogin_naver') && element('naver_id', element('social', $result))) { ?>
										<a href="javascript:;" onClick="social_open('naver', '<?php echo element('mem_id', $result); ?>');"><img src="<?php echo base_url('assets/images/social_naver.png'); ?>" width="15" height="15" alt="네이버 로그인" title="네이버 로그인" /></a>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_sociallogin_kakao') && element('kakao_id', element('social', $result))) { ?>
										<a href="javascript:;" onClick="social_open('kakao', '<?php echo element('mem_id', $result); ?>');"><img src="<?php echo base_url('assets/images/social_kakao.png'); ?>" width="15" height="15" alt="카카오 로그인" title="카카오 로그인" /></a>
									<?php } ?>
								</td>
							<?php } ?>
							<td><?php echo display_datetime(element('mem_register_datetime', $result), 'full'); ?></td>
							<td><?php echo display_datetime(element('mem_lastlogin_datetime', $result), 'full'); ?></td>
							<td><?php echo element('member_group', $result); ?></td>
							<td><?php echo element('mem_denied', $result) ? '<span class="label label-danger">차단</span>' : '승인'; ?></td>
							<td><a href="/admin/counter/masterlmscnt/apply_mem_detail/<?php echo element(element('primary_key', $view), $result); ?>" class="btn btn-outline btn-default btn-xs">학습현황</a></td>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="16" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="box-info">
				<?php echo element('paging', $view); ?>
				<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
				<?php echo $buttons; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	
</div>

<script type="text/javascript">
//<![CDATA[
function social_open(stype, mem_id) {
	var pop_url = cb_admin_url + '/member/members/socialinfo/' + stype + '/' + mem_id;
	window.open(pop_url, 'win_socialinfo', 'left=100,top=100,width=730,height=500,scrollbars=1');
	return false;
}

function onchange_company()
{
    $('#flist').submit();
}

$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
})

$(function() {
    $('#sh_company_name').val('<?php echo $this->input->get('sh_company_name'); ?>');
});

//]]>
</script>
