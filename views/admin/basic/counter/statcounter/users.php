<div class="box">
    <h2>접속자 통계</h2>
    <div class="box-table">
		<div class="box-table-header">
			<form class="form-inline" name="flist" id="flist" method="get" >
				<div class="box-table-button">
					<span class="mr10">
						기간 : <input type="text" class="form-control input-small datepicker " name="start_date" value="<?php echo element('start_date', $view); ?>" readonly="readonly" /> - <input type="text" class="form-control input-small datepicker" name="end_date" value="<?php echo element('end_date', $view); ?>" readonly="readonly" />
					</span>
					<div class="btn-group" role="group" aria-label="...">
						<input type="radio" name="ymd" value="day" id="day"><label for="day" class="btn <?php if($this->input->get('ymd') == 'day' || $this->input->get('ymd') == ''){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">일</label>
						<input type="radio" name="ymd" value="month" id="month"><label for="month" class="btn <?php if($this->input->get('ymd') == 'month'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">월</label>
						<input type="radio" name="ymd" value="year" id="year"><label for="year" class="btn <?php if($this->input->get('ymd') == 'year'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">년</label>
					</div>
				</div>
			</form>
			<script type="text/javascript">
			//<![CDATA[
			$('input[name="ymd"]').on('click', function(){
				if($(this).val() == 'day'){
					if($('input[name="start_date"]').val() !== $('input[name="end_date"]').val()){
						alert('일별 검색은 당일만 조회 가능합니다.');
						return false;
					}
				}
				$('#flist').submit();
			});
			//]]>
			</script>
		</div>
		<?php
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><?php if($this->input->get('ymd') == 'day' || $this->input->get('ymd') == ''){ echo '시간'; } else { echo '날짜'; } ?></th>
							<th>방문 수</th>
							<th>누적 방문 수</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $result) {
					?>
						<tr>
							<td><?php echo element('mll_datetime', $result); ?></td>
							<td><?php echo element('visit_count', $result); ?></td>
							<td><?php echo element('acc_visit_count', $result); ?></td>
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
</div>
<script type="text/javascript">
$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/users/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	//console.log(exporturl);
	document.location.href = exporturl;
});
</script>