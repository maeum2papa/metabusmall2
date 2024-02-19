<?php 
$url = uri_string(); 
$url_arr = explode('/', $url);
?>
<ul class="masterlmscnt-submenu btn-group">
	<li><a href="/admin/counter/masterlmscnt" class="btn btn-sm btn-default <?php if(!$url_arr[3]){ echo 'btn-warning'; } ?>">시간대별 학습통계</a></li>
	<li><a href="/admin/counter/masterlmscnt/apply" class="btn btn-sm btn-default <?php if($url_arr[3] == 'apply'){ echo 'btn-warning'; } ?>">학습 신청 통계</a></li>
	<li><a href="/admin/counter/masterlmscnt/cert" class="btn btn-sm btn-default <?php if($url_arr[3] == 'cert'){ echo 'btn-warning'; } ?>">교육 이수증</a></li>
</ul>
<div class="">
	<a href="./apply" class="btn btn-outline btn-sm">전체</a>
	<?php foreach(element('filter', $view) as $k => $v){ ?>
		<a href="?company_idx=<?php echo element('company_idx', $v); ?>" class="btn btn-outline btn-sm"><?php echo element('company_name', $v); ?></a>
	<?php } ?>
</div>
<div class="flex-wrap">
	<div class="left">
		<div class="box">
			<div class="box-table">
				<div class="box-table-header">
					<form class="form-inline" id="flist1" name="flist1" method="get" >
						<input type="hidden" name="company_idx" value="<?php echo $this->input->get('company_idx'); ?>">
						<div class="box-table-button">
							<div class="btn-group" role="group" aria-label="...">
								<input type="radio" name="ymd" value="day" id="day"><label for="day" class="btn <?php if($this->input->get('ymd') == 'day' || $this->input->get('ymd') == ''){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">일</label>
								<input type="radio" name="ymd" value="month" id="month"><label for="month" class="btn <?php if($this->input->get('ymd') == 'month'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">월</label>
								<input type="radio" name="ymd" value="year" id="year"><label for="year" class="btn <?php if($this->input->get('ymd') == 'year'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">년</label>
							</div>
						</div>
					</form>
					<script type="text/javascript">
					//<![CDATA[
					$('#flist1 input[name="ymd"]').on('click', function(){
						$('#flist1').submit();
					});
					//]]>
					</script>
				</div>
				<div>
					<?php echo element('cnt', element('graph', element('list', $view))); ?>과정
					<?php if($this->input->get('ymd') == '' || $this->input->get('ymd') == 'day'){ echo '전일';} 
					else if($this->input->get('ymd') == 'month'){ echo '전월'; }
					else if($this->input->get('ymd') == 'year'){ echo '전년';} ?> 대비 <?php echo element('per', element('graph', element('list', $view))); ?>%
				</div>
			</div>
		</div>
	</div>
</div>
<div class="box">
	<h2>학습자 현황</h2>
	<div class="box-table">
		<?php
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="company_idx" value="<?php echo $this->input->get('company_idx'); ?>">
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>과정명</th>
							<th>플랜</th>
							<th>등록일</th>
							<th>신청자 수</th>
							<th>수료자 수</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $result) {
					?>
						<tr>
							<td><a href="/admin/counter/masterlmscnt/apply_detail/<?php echo element('p_sno', $result); ?>"><?php echo element('p_title', $result); ?></a></td>
							<td><?php echo element('plan_name', $result); ?></td>
							<td><?php echo element('p_regDt', $result); ?></td>
							<td><?php echo element('plan_apply_cnt', $result); ?></td>
							<td><?php echo element('plan_end_cnt', $result); ?></td>
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
		<input type="hidden" name="company_idx" value="<?php echo $this->input->get('company_idx'); ?>">
		<div class="box-search">
			<table>
				<tbody>
					<tr>
						<th>기간 검색</th>
						<td class="form-inline">
							<input type="text" class="form-control input-small datepicker " name="list_start_date" value="<?php echo element('list_start_date', $view); ?>" readonly="readonly" />
							 - 
							<input type="text" class="form-control input-small datepicker" name="list_end_date" value="<?php echo element('list_end_date', $view); ?>" readonly="readonly" />
							<div class="btn-group" role="group" aria-label="...">
								<input type="radio" name="list_ymd" value="day" id="list_day0"><label for="list_day0" class="btn <?php if($this->input->get('list_ymd') == 'day'){ echo 'btn-warning';}else{ echo 'btn-default'; }?>">오늘</label>
								<input type="radio" name="list_ymd" value="7day" id="list_day7"><label for="list_day7" class="btn <?php if($this->input->get('list_ymd') == '7day'){ echo 'btn-warning';}else{ echo 'btn-default'; }?>">7일</label>
								<input type="radio" name="list_ymd" value="15day" id="list_day15"><label for="list_day15" class="btn <?php if($this->input->get('list_ymd') == '15day'){ echo 'btn-warning';}else{ echo 'btn-default'; }?>">15일</label>
								<input type="radio" name="list_ymd" value="1month" id="list_month1"><label for="list_month1" class="btn <?php if($this->input->get('list_ymd') == '1month'){ echo 'btn-warning';}else{ echo 'btn-default'; }?>">1개월</label>
								<input type="radio" name="list_ymd" value="3month" id="list_month3"><label for="list_month3" class="btn <?php if($this->input->get('list_ymd') == '3month'){ echo 'btn-warning';}else{ echo 'btn-default'; }?>">3개월</label>
								<input type="radio" name="list_ymd" value="all" id="list_all"><label for="list_all" class="btn <?php if($this->input->get('list_ymd') == '' || $this->input->get('list_ymd') == 'all'){ echo 'btn-warning';}else{ echo 'btn-default'; }?>">전체</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>플랜</th>
						<td>
							<select class="form-control" name="planfield" >
								<option value="">전체</option>
								<?php foreach(element('plan', element('board', element('list', $view))) as $k => $v){ ?>
									<option value="<?php echo $v['plan_idx']; ?>" <?php if($this->input->get('planfield') == $v['plan_idx']){ echo 'selected'; } ?>><?php echo $v['plan_name']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>과정명</th>
						<td>
							<div class="input-group">
								<input type="text" class="form-control" name="list_skeyword" value="<?php echo $this->input->get('list_skeyword'); ?>" placeholder="Search for..." />
								<span class="input-group-btn">
									<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
								</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>	
	</form>
</div>
<script type="text/javascript">
$('input[name="list_ymd"]').click(function(){
	$('#fsearch').submit();
});
$('select[name="planfield"]').change(function(){
	$('#fsearch').submit();
});
$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/apply/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});
</script>
