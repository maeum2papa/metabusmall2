<script type="text/javascript">
$(document).ready(function () {
	$("#fsearch").validate({
		submitHandler: function (form) {
			var skeyword = $("#skeyword").val();
			if(!skeyword){
			   $("#skeyword").val("  ");
		   	}
			form.submit();
		},
	});
});
</script>	
<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
			<?php
			ob_start();
			?>
				<div class="btn-group pull-right" role="group" aria-label="...">
					<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
					<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
					<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">과정추가</a>
				</div>
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
							<th style="width: 70px;">선택</th>
							<th style="width: 90px;"><a href="<?php echo element('num', element('sort', $view)); ?>">고유번호</a></th>
							<th style="width: 120px;">썸네일</th>
							<th style="width: 150px;"><a href="<?php echo element('plan_idx', element('sort', $view)); ?>">플랜</a></th>
							<th>과정명</th>
							<th style="width: 150px;">노출기간</th>
							<th style="width: 230px;">카테고리</th>
							<th>커리큘럼</th>
							<th style="width: 130px;">등록일</th>
							<th style="width: 70px;">수정</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?=element(element('primary_key', $view), $result); ?>" /></td>
							<td><?=number_format(element('num', $result)); ?></td>
							<td><img src='<?=element('p_thumbnail', $result); ?>' style='width:100px;height:auto;'/></td>
							<td><?php echo element('plan_name', $result); ?></td>
							<td><?=cut_str(element('p_title', $result),15); ?></td>
							<td><?=element('p_viewTxt', $result); ?></td>
							<td>
							<?php if(element('category', $result)){
								foreach (element('category', $result) as $k => $v) {
							?>
								<?=cut_str($v[cca_desc],20); ?><br>
							<?php
								}
							}?>
							</td>
							<td>
							<?php if(element('p_curriYn', $result) == 'y'){
								foreach (element('curri', $result) as $k => $v) {
							?>
								[<?=$v[c_type]?>]<?=cut_str($v[c_content],20); ?><br>
							<?php
								}
							}?>
							</td>
							<td><?=cut_str(element('p_regDt', $result),10,' '); ?></td>
                            <td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="12" class="nopost">자료가 없습니다</td>
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
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3" style="margin-left: 15%; width: 70%">
					<select class="form-control" name="sfield"   style="width: 150px;">
						<?php echo element('search_option', $view); ?>
					</select>
					<select class="form-control" id="plan_idx" name="plan_idx"  style="width: 150px;">
						<option value="">-플랜선택-</option>
						<?php
						foreach (element('plan', $view) as $v) {
						?>
						<option value="<?=$v[plan_idx]?>" <?php if(element('plan_idx', $view) == $v[plan_idx]){?>selected<?php } ?>><?=$v[plan_name]?></option>
						<?php
						}
						?>
					</select>
					<select class="form-control" id="p_curriYn" name="p_curriYn"  style="width: 150px;">
						<option value="">-<?=false_process()?>여부-</option>
						<option value="n" <?php if(element('p_curriYn', $view) == 'n'){?>selected<?php } ?>>예</option>
						<option value="y" <?php if(element('p_curriYn', $view) == 'y'){?>selected<?php } ?>>아니오</option>
					</select>
					<div class="input-group" style="width: 30%;">
						<input type="text" class="form-control" id="skeyword" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
