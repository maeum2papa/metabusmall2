<div class="box">
    <h2>기기별 통계</h2>
    <div class="box-table">
		<div class="box-table-header">
			<form class="form-inline" name="flist" id="flist" method="get" >
				<div class="form-hidden" style="display:none;">
					<input type="hidden" name="ymd" value="<?php echo $this->input->get('ymd'); ?>">
					<input type="hidden" name="deviceFl" value="<?php echo $this->input->get('deviceFl'); ?>">
				</div>
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
				<div class="box-table-button">
					<div class="btn-group" role="group" aria-label="...">
					<input type="radio" name="deviceFl" value="all" id="all"><label for="all" class="btn <?php if($this->input->get('deviceFl') == '' || $this->input->get('deviceFl') == 'all'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">전체</label>
						<input type="radio" name="deviceFl" value="mobile" id="mobile"><label for="mobile" class="btn <?php if($this->input->get('deviceFl') == 'mobile'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">모바일</label>
						<input type="radio" name="deviceFl" value="desktop" id="desktop"><label for="desktop" class="btn <?php if($this->input->get('deviceFl') == 'desktop'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">데스크톱</label>
						<input type="radio" name="deviceFl" value="tablet" id="tablet"><label for="tablet" class="btn <?php if($this->input->get('deviceFl') == 'tablet'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">태블릿</label>
					</div>
				</div>
			</form>
			<script type="text/javascript">
			//<![CDATA[
			$('#flist input[type=radio]').each(function(){
				$(this).on('click', function(){
					var name = $(this).attr('name');
					var value = $(this).val();
					$('.form-hidden input[name="'+name+'"]').val(value);
					$('#flist').submit();
				});
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
							<th>기기 유형</th>
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
							<td><?php echo element('device_type', $result); ?></td>
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
	exporturl = '<?php echo admin_url($this->pagedir . '/devices/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	//console.log(exporturl);
	document.location.href = exporturl;
});
</script>