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
					<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">템플릿추가</a>
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
							<th>선택</th>
							<th><a href="<?php echo element('item_sno', element('sort', $view)); ?>">고유번호</a></th>
							<th><a href="<?php echo element('cate_kr', element('sort', $view)); ?>">카테고리</a></th>
							<th><a href="<?php echo element('item_kr', element('sort', $view)); ?>">이름</a></th>
							<th>구분</th>
							<th>기본노출</th>
							<th>등록일</th>
							<th>수정일</th>
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
							<td><?=number_format(element('item_sno', $result)); ?></td>
							<td><?php echo element('cate_kr', $result); ?></td>
							<td><?php echo element('item_kr', $result); ?></td>
							<td>
								<?php 
								if(element('item_type', $result) == 'a'){ 
									echo "아바타";
								}else if(element('item_type', $result) == 'l'){
									echo "랜드";
								}
								?>
							</td>
							<td>
								<?php 
								if(element('item_basicYn', $result) == 'y'){ 
									echo "기본노출";
								}else if(element('item_basicYn', $result) == 'n'){
									echo "구매후노출";
								}
								?>
							</td>
							<td><?php echo element('item_regDt', $result); ?></td>
							<td><?php echo element('item_modDt', $result); ?></td>
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
					<select class="form-control" name="item_type"  style="width: 150px;">
						<option value="">아이템구분</option>
						<option value="a" <?php if(element('item_type', $view) == 'a'){?>selected<?php } ?>>아바타</option>
						<option value="l" <?php if(element('item_type', $view) == 'l'){?>selected<?php } ?>>랜드</option>
					</select>
					<div class="input-group" style="width: 50%;">
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
