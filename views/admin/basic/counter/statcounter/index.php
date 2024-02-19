<div class="flex-wrap">
	<div class="left">
		<h2>접속자 통계 그래프</h2>
		<a href="/admin/counter/statcounter/users" class="btn btn-default">더보기</a>
		<div class="box">
			<div class="box-header">
				<ul>
					<li><?php echo element('name', element('nowymd', element('graphEx', element('list', $view)))); ?> <?php echo element('count', element('nowymd', element('graphEx', element('list', $view)))); ?></li>
					<li><?php echo element('name', element('exymd', element('graphEx', element('list', $view)))); ?> <?php echo element('count', element('exymd', element('graphEx', element('list', $view)))); ?></li>
					<li><?php echo element('name', element('accymd', element('graphEx', element('list', $view)))); ?> <?php echo element('count', element('accymd', element('graphEx', element('list', $view)))); ?></li>
				</ul>
			</div>
			<div class="box-table">
				<div class="box-table-header">
					<form class="form-inline" id="flist1" name="flist1" method="get" >
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
	<div class="right">
		<h2>기기별 그래프</h2>
		<a href="/admin/counter/statcounter/devices" class="btn btn-default">더보기</a>
		<div class="box">
			<div class="box-table">
				<div class="box-table-header">
					<form class="form-inline" id="flist2" name="flist2" method="get" >
						<div class="box-table-button">
							<div class="btn-group" role="group" aria-label="...">
								<input type="radio" name="ymd" value="day" id="day_os"><label for="day_os" class="btn <?php if($this->input->get('ymd') == 'day' || $this->input->get('ymd') == ''){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">일</label>
								<input type="radio" name="ymd" value="month" id="month_os"><label for="month_os" class="btn <?php if($this->input->get('ymd') == 'month'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">월</label>
								<input type="radio" name="ymd" value="year" id="year_os"><label for="year_os" class="btn <?php if($this->input->get('ymd') == 'year'){ echo 'btn-warning'; } else { echo 'btn-default'; } ?>">년</label>
							</div>
						</div>
					</form>
					<script type="text/javascript">
					//<![CDATA[
					$('#flist2 input[name="ymd"]').on('click', function(){
						$('#flist2').submit();
					});
					//]]>
					</script>
				</div>
				<div id="chart_div2"></div>
			</div>
		</div>
	</div>
</div>
<div class="box">
	<h2>회원별 접속 현황</h2>
	<div class="box-table">
		<?php
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>최근 접속 시간</th>
							<th>회원명</th>
							<th>총 접속 시간</th>
							<th>최근 접속 기기</th>
							<th>Browser</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $result) {
					?>
						<tr>
							<td><?php echo element('mem_lastlogin_datetime', $result); ?></td>
							<td><?php echo element('mem_username', $result); ?></td>
							<td><?php echo element('acctime', $result); ?></td>
							<td><?php echo element('device', $result); ?></td>
							<td><?php echo element('browser', $result); ?></td>
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
	data.addColumn('number', '접속자 수');
	
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

	var data2 = new google.visualization.arrayToDataTable([
		['OS', '접속비율'],
		<?php
		if (element('device', element('list', $view))) {
			foreach (element('device', element('list', $view)) as $result) {
		?>
		['<?php echo element('name', $result); ?>',<?php echo element('count', $result, 0); ?>],
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

	var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));

	chart2.draw(data2, {
		width: '100%', height: '400',
	});
}

$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/index/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});
</script>
