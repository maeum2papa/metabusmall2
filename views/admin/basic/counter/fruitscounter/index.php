<div class="box">
	<div class="box-table">
		<?php
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>부서명</th>
							<th>회원명</th>
							<th>씨앗 제공량</th>
							<th>씨앗 심은량</th>
							<th>열매 수확량</th>
                            <th>열매 사용량</th>
                            <th>물 획득량</th>
                            <th>물 사용량</th>
                            <th>비료 획득량</th>
                            <th>비료 사용량</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $result) {
					?>
						<tr>
							<td><?php echo element('mem_div', $result); ?></td>
							<td><?php echo element('mem_username', $result); ?></td>
							<td><?php echo element('mem_cur_seed', $result); ?></td>
							<td><?php echo element('mem_use_seed', $result); ?></td>
							<td><?php echo element('mem_cur_fruit', $result); ?></td>
							<td><?php echo element('mem_use_fruit', $result); ?></td>
                            <td><?php echo element('mem_cur_water', $result); ?></td>
							<td><?php echo element('mem_use_water', $result); ?></td>
                            <td><?php echo element('mem_cur_fertilizer', $result); ?></td>
							<td><?php echo element('mem_use_fertilizer', $result); ?></td>
						</tr>
					<?php
						}
					}
					if ( ! element('board', element('list', $view))) {
					?>
						<tr>
							<td colspan="6" class="nopost">자료가 없습니다</td>
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
			</div>
		<?php echo form_close(); ?>
		<div class="box-info">
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
			</div>			
		</div>
	</div>
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/index/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});
</script>