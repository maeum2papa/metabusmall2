<?php 
$url = uri_string(); 
$url_arr = explode('/', $url);
?>
<ul class="masterlmscnt-submenu btn-group">
    <li><a href="/admin/counter/masterlmscnt" class="btn btn-sm btn-default <?php if(!$url_arr[3]){ echo 'btn-warning'; } ?>">시간대별 학습통계</a></li>
	<li><a href="/admin/counter/masterlmscnt/apply" class="btn btn-sm btn-default <?php if($url_arr[3] == 'apply'){ echo 'btn-warning'; } ?>">학습 신청 통계</a></li>
	<li><a href="/admin/counter/masterlmscnt/cert" class="btn btn-sm btn-default <?php if($url_arr[3] == 'cert'){ echo 'btn-warning'; } ?>">교육 이수증</a></li>
</ul>
<div class="box">
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
        <div class="box-search">
            <table class="table table-hover table-striped table-bordered" style="text-align: left;">
                <colgroup>
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col>
                </colgroup>
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
                        <th>부서 검색</th>
                        <td colspan="3"><input type="text" name="mem_div" value="<?php echo $this->input->get('mem_div'); ?>" class="form-control input-small"></td>
                    </tr>
                    <tr>
                        <th>회원 검색</th>
                        <td colspan="3"><input type="text" name="mem_username" value="<?php echo $this->input->get('mem_username'); ?>" class="form-control input-small"></td>
                    </tr>
                    <tr>
                        <th>기간 검색</th>
                        <td colspan="3" class="form-inline">
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
                        <th>카테고리 검색</th>
                        <td class="form-inline">
                            <select name="cca_id_fir" id="cca_id_fir" class="form-control">
                                <option value="">선택하세요</option>
                                <?php foreach(element('cca_parent', element('list', $view)) as $k => $v){ ?>
                                    <option value="<?php echo element('cca_id', $v); ?>" <?php if($this->input->get('cca_id_fir') == element('cca_id', $v)){ echo 'selected';}?>><?php echo element('cca_value', $v); ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <th>세부카테고리</th>
                        <td>
                            <select name="cca_id_sec" id="cca_id_sec" class="form-control">
                                <option value="">선택하세요</option>
                                <?php if($this->input->get('cca_id_fir')){ ?>
                                    <?php foreach(element('cca_child', element('list', $view)) as $k => $v){ ?>
                                        <option value="<?php echo element('cca_id', $v); ?>" <?php if($this->input->get('cca_id_sec') == element('cca_id', $v)){ echo 'selected';}?>><?php echo element('cca_value', $v); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>과정명 검색</th>
                        <td colspan="3"><input type="text" name="list_skeyword" value="<?php echo $this->input->get('list_skeyword'); ?>" class="form-control input-small"></td>
                    </tr>
                </tbody>
            </table>
            <span class="input-group-btn">
                <button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
            </span>
        </div>
    </form>
</div>
<div class="box">
    <div class="box-table">
        <?php
        $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
        echo form_open(current_full_url(), $attributes);
        ?>
        <div class="table-responsive">
            <h4>과정 학습자 현황</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>부서명</th>
                        <th>회원명</th>
                        <th>수료일자</th>
                        <th>카테고리</th>
                        <th>세부카테고리</th>
                        <th>과정명</th>
                        <th>수료증출력</th>
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
                        <td><?php echo element('mp_endDt', $result); ?></td>
                        <td><?php echo element('cca_parent_value', $result); ?></td>
                        <td><?php echo element('cca_value', $result); ?></td>
                        <td><?php echo element('p_title', $result); ?></td>
                        <td>
                            <?php if(element('mp_endYn', $result) == 'y'){ ?>
                                <a href="/admin/counter/masterlmscnt/cert_export/<?php echo element('mp_sno', $result);?>">출력</a>
                            <?php } else { ?>
                                미출력
                            <?php } ?>
                        </td>
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
                <a href="/admin/counter/masterlmscnt/cert_export_all?<?php echo $this->input->server('QUERY_STRING', null, '');?>" class="btn btn-outline btn-default btn-sm">수료증 전체 다운로드</a>
				<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
			</div>			
		</div>
    </div>
</div>
<script type="text/javascript">
$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/cert/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});
$('#cca_id_fir').change(function(){
    if($(this).val() != ''){
        $.ajax({
            method: "POST",
            url: "/admin/counter/masterlmscnt/getCcaChild",
            data: {
                mode: 'getCcaChild',
                cca_parent: $(this).val(),
                csrf_test_name : cb_csrf_hash
            },
        }).success(function(data){
            var json = $.parseJSON(data);
            var cca_arr = json.cca_list;
            var cca_arr_cnt = cca_arr.length;
            html = "";
            for(i=0;i<cca_arr_cnt;i++){
                html += "<option value='"+cca_arr[i].cca_id+"'>"+cca_arr[i].cca_value+"</option>";
            }
            $('#cca_id_sec option').remove();
            $('#cca_id_sec').append(html);

        }).error(function(e){
            console.log(e.responseText);
        });
    }
});
</script>