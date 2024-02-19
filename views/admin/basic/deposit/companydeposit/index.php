<div class="box">
		<div class="box-table">
			<?php
			echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			echo show_alert_message($this->session->flashdata('dangermessage'), '<div class="alert alert-auto-close alert-dismissible alert-danger"><button type="button" class="close alertclose" >&times;</button>', '</div>');
			$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
			echo form_open(current_full_url(), $attributes);
			?>
				<div class="box-table-header">
					<div class="btn-group btn-group-sm" role="group">
						<a href="<?php echo admin_url('deposit/companydeposit/lists'); ?>" class="btn btn-sm <?php echo ( ! $this->input->get('type') && ! $this->input->get('type')) ? 'btn-success' : 'btn-default';?>">전체내역</a>
						<a href="<?php echo admin_url('deposit/companydeposit/lists'); ?>?type=1" class="btn btn-sm <?php echo ($this->input->get('type') == 1) ? 'btn-success' : 'btn-default';?>">충전내역</a>
						<a href="<?php echo admin_url('deposit/companydeposit/lists'); ?>?type=2" class="btn btn-sm <?php echo ($this->input->get('type') == 2) ? 'btn-success' : 'btn-default';?>">사용내역</a>
					</div>
					<?php
					ob_start();

					if($this->session->userdata['mem_admin_flag']==0){
					?>
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="/admin/deposit/companydeposit/write" class="btn btn-outline btn-danger btn-sm">예치금 변동내역추가</a>
						</div>
					<?php
					}
					$buttons = ob_get_contents();
					ob_end_flush();
					?>
				</div>
				<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th><a href="<?php echo element('dep_id', element('sort', $view)); ?>">번호</a></th>
                                <th>기업명</th>
								<th>일시</th>
								<th>구분</th>
                                <th>내용</th>
								<th>결제금액</th>
								<th>누적금액</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (element('list', element('data', $view))) {
							foreach (element('list', element('data', $view)) as $result) {
						?>
							<tr>
								<td><?php echo number_format(element('num', $result)); ?></td>
                                <td><?php echo busiNm($result['company_idx']);?> (code : <?php echo $result['company_idx'];?>)</td>
								<td><?php echo $result['ccd_datetime'];?></td>
								<td><?php echo ($result['ccd_deposit']>0)?"<button type='button' class='btn btn-primary'>충전</button>":"<button type='button' class='btn btn-danger'>사용</button>";?></td>
                                <td><?php echo $result['ccd_content']?></td>
								<td class="text-right"><?php echo number_format($result['ccd_deposit']);?></td>
								<td class="text-right"><?php echo number_format($result['ccd_now_deposit']);?></td>
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
</div>
