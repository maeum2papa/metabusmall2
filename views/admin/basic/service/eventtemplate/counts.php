<h2><?php echo element('menu_title', element('layout', $view)); ?></h2>
<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
                            <th><input type="checkbox" name="chkall" id="chkall" /></th>
							<th><a href="<?php echo element('event_idx', element('sort', $view)); ?>">번호</a></th>
							<th>기업명</th>
							<th>이벤트 시작일</th>
							<th>이벤트 종료일</th>
							<th>이벤트명</th>
                            <th>인원</th>
                            <th>상태</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
                            <td title="관리"><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('event_idx', $result); ?>" /></td>
							<td title="번호"><?php echo number_format(element('num', $result)); ?></td>
							<td title="기업명"><?php echo html_escape(element('company_name', $result)); ?></td>
                            <td title="이벤트 시작일"><?php echo element('event_startDt', $result); ?></td>
                            <td title="이벤트 종료일"><?php echo element('event_endDt', $result); ?></td>
                            <td title="이벤트명"><a href="/admin/service/eventtemplate/event_info/<?php echo element('event_idx', $result); ?>"><?php echo html_escape(element('event_name', $result)); ?></a></td>
							<td title="인원"><?php echo number_format(element('event_member_count', $result)); ?></td>
                            <td title="상태"><?php if(element('event_showFl', $result) == 'y'){ echo '활성화';}else{ echo '비활성화'; } ?></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="11" class="nopost">자료가 없습니다</td>
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