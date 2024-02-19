<div class="box">
	<div class="box-table">
		<?php echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>'); ?>
		<div class="box-table-header">
			<h4><a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">회원검색</a></h4>
			<a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1"><i class="fa fa-chevron-up pull-right"></i></a>
		</div>
		<div class="collapse in" id="collapse1">
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
	</div>
	<div class="box-table">
		<?php 
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="5%">
					<col>
					<col>
					<col>
					<col>
				</colgroup>
				<thead>
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" /></th>
						<th>번호</th>
						<th>회원아이디</th>
						<th>실명(닉네임)</th>
						<th>기업명</th>
						<th>보유 열매량</th>
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
							<td><a href="?sfield=fruit_log.log_memNo&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('mem_userid', $result)); ?></a></td>
							<td><?php echo element('mem_username', $result); ?>(<?php echo element('mem_nickname', $result); ?>)</td>
							<td><?php echo element('company_name', $result); ?></a></td>
							<td><?php echo number_format(element('mem_cur_fruit', $result)); ?></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="8" class="nopost">자료가 없습니다</td>
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
		<div class="table-responsive">
			<input type="hidden" name="mode" value="register">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="10%">
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th>지급/차감여부</th>
						<td>
							<label class="radio-inline">
								<input type="radio" name="fruitCheckFl" value="add" checked="checked">
								지급(+)
							</label>
							<label class="radio-inline">
								<input type="radio" name="fruitCheckFl" value="remove">
								차감(-)
							</label>
						</td>
					</tr>
					<tr>
						<th>금액설정</th>
						<td>
							<input type="text" name="fruitValue" maxlength="8">
						</td>
					</tr>
					<tr>
						<th>지급/차감사유</th>
						<td>
							<input type="text" name="log_txt">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="btn-group pull-right" role="group" aria-label="...">
			<button type="submit" class="btn btn-outline btn-success btn-sm">열매 지급/차감</button>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
