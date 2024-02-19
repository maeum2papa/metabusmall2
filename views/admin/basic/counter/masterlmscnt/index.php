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
	<a href="./masterlmscnt" class="btn btn-outline btn-sm">전체</a>
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
				<div id="chart_div"></div>
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
							<th>로그인 아이디</th>
							<th>이름</th>
							<th>총 학습 시간</th>
							<th>신청 과정</th>
							<th>수료 과정</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $result) {
					?>
						<tr>
							<td><?php echo element('mem_email', $result); ?></td>
							<td><?php echo element('mem_username', $result); ?></td>
							<td><?php echo element('acctime', $result); ?></td>
							<td><?php echo element('lms_process_all', $result); ?></td>
							<td><?php echo element('lms_process_complete', $result); ?></td>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {

	var data = new google.visualization.DataTable();

	<?php if($this->input->get('ymd') == 'day'){ ?>
		data.addColumn('string', '일');
	<?php } else if($this->input->get('ymd') == 'month'){ ?>
		data.addColumn('string', '월');
	<?php } else if($this->input->get('ymd') == 'year'){ ?>
		data.addColumn('string', '년');
	<?php } else { ?>
		data.addColumn('string', '일');
	<?php } ?>
	data.addColumn('number', '학습자 수');
	
	data.addRows([
		<?php
		if (element('graph', element('list', $view))) {
			foreach (element('graph', element('list', $view)) as $key => $result) {
		?>
		['<?php echo $key; ?>',<?php echo element('mll_count', $result, 0); ?>],
		<?php
			}
		}
		?>
	]);

	var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));

	chart.draw(data, {
		width: '100%', height: '400',
		legendTextStyle: {fontName: 'gulim', fontSize: '12'},
		tooltipTextStyle: {color: '#006679', fontName: 'dotum', fontSize: '12'},
		hAxis: {textStyle: {color: '#959595', fontName: 'dotum', fontSize: '12'}},
		vAxis: {textStyle: {color: '#959595', fontName: 'dotum', fontSize: '12'}, gridlineColor: '#e1e1e1', baselineColor: '#e1e1e1', textPosition: 'out'},
		lineWidth: 3,
		pointSize: 5
	});
}

$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/index/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});
</script>
