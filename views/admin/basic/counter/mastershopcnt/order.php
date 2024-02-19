<?php 
$url = uri_string(); 
$url_arr = explode('/', $url);
?>
<ul class="shopcounter-submenu btn-group">
	<li><a href="/admin/counter/mastershopcnt" class="btn btn-sm btn-default <?php if(!$url_arr[3]){ echo 'btn-warning'; } ?>">판매순위</a></li>
	<li><a href="/admin/counter/mastershopcnt/order" class="btn btn-sm btn-default <?php if($url_arr[3] == 'order'){ echo 'btn-warning'; } ?>">주문통계</a></li>
</ul>
<div class="box">
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
        <div class="box-search">
            <table>
                <tbody>
                    <tr>
                        <th>기업 검색</th>
                        <td colspan="3">
                            <select name="company_idx" id="company_idx" class="form-control">
                                <option value="">전체</option>
                                <?php foreach(element('filter', $view) as $k => $v){ ?>
                                    <option value="<?php echo element('company_idx', $v); ?>" <?php if($this->input->get('company_idx') == element('company_idx', $v)){ echo 'selected'; }?>><?php echo element('company_name', $v); ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>카테고리</th>
                        <td>
                            <?php foreach(element('category', element('filter', $view)) as $k => $v){ ?>
                            <label for="category_<?php echo $k;?>">
                                <input type="checkbox" name="category[]" id="category_<?php echo $k;?>" value="<?php echo element('cca_id', $v); ?>" <?php echo element('checked', $v); ?>> <?php echo element('cca_value', $v); ?>
                            </label>
                            <?php } ?>
                        </td>
                    </tr>
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
                </tbody>
            </table>
            <span class="input-group-btn">
                <button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
            </span>
        </div>
    </form>
    <div class="box-table">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>총 판매금액</th>
                        <th>총 구매건수</th>
                        <th>총 구매자수</th>
                        <th>총 구매개수</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td><?php echo number_format(element('cor_total_money_sum_c', element('total', element('list', $view))));?>원 / <?php echo number_format(element('cor_total_money_sum_f', element('total', element('list', $view))));?>개</td>
                        <td><?php echo number_format(element('cor_id_cnt', element('total', element('list', $view))));?></td>
                        <td><?php echo number_format(element('mem_id_cnt', element('total', element('list', $view))));?></td>
                        <td><?php echo number_format(element('cod_count_sum', element('total', element('list', $view))));?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-table">
		<?php
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="company_idx" value="<?php echo $this->input->get('company_idx'); ?>">
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered table-responsive">
                    <colgroup>
                        <col width="4%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                        <col width="6%">
                    </colgroup>
					<thead>
						<tr>
							<th rowspan="2">날짜</th>
							<th colspan="4">전체</th>
							<th colspan="4">PC 쇼핑몰</th>
                            <th colspan="4">모바일 쇼핑몰</th>
                            <th colspan="4">태블릿 쇼핑몰</th>
						</tr>
                        <tr>
                            <th>판매금액</th>
                            <th>구매건수</th>
                            <th>구매자수</th>
                            <th>구매개수</th>
                            <th>판매금액</th>
                            <th>구매건수</th>
                            <th>구매자수</th>
                            <th>구매개수</th>
                            <th>판매금액</th>
                            <th>구매건수</th>
                            <th>구매자수</th>
                            <th>구매개수</th>
                            <th>판매금액</th>
                            <th>구매건수</th>
                            <th>구매자수</th>
                            <th>구매개수</th>
                        </tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $k => $v) {
					?>
						<tr>
                            <td><?php echo element('cor_datetime', $v); ?></td>
                            <td><?php echo number_format(element('cor_total_money_sum', element('total', $v))); ?></td>
                            <td><?php echo number_format(element('cor_id_cnt', element('total', $v))); ?></td>
                            <td><?php echo number_format(element('mem_id_cnt', element('total', $v))); ?></td>
                            <td><?php echo number_format(element('cod_count_sum', element('total', $v))); ?></td>
                            <td><?php echo number_format(element('cor_total_money_sum', element('pc', $v))); ?></td>
                            <td><?php echo number_format(element('cor_id_cnt', element('pc', $v))); ?></td>
                            <td><?php echo number_format(element('mem_id_cnt', element('pc', $v))); ?></td>
                            <td><?php echo number_format(element('cod_count_sum', element('pc', $v))); ?></td>
                            <td><?php echo number_format(element('cor_total_money_sum', element('mo', $v))); ?></td>
                            <td><?php echo number_format(element('cor_id_cnt', element('mo', $v))); ?></td>
                            <td><?php echo number_format(element('mem_id_cnt', element('mo', $v))); ?></td>
                            <td><?php echo number_format(element('cod_count_sum', element('mo', $v))); ?></td>
                            <td><?php echo number_format(element('cor_total_money_sum', element('tb', $v))); ?></td>
                            <td><?php echo number_format(element('cor_id_cnt', element('tb', $v))); ?></td>
                            <td><?php echo number_format(element('mem_id_cnt', element('tb', $v))); ?></td>
                            <td><?php echo number_format(element('cod_count_sum', element('tb', $v))); ?></td>
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
<script>
$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/order/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});
</script>