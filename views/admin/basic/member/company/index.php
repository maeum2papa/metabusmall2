<div class="box">
	<div class="btn-group pull-right" role="group" aria-label="...">
		<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">기업등록</a>
	</div>
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<table class="table table-hover table-striped table-bordered" style="text-align: left;">
				<tbody>
					<tr>
						<th class="col-sm-2">기업명</th>
						<td class="col-sm-10 form-inline">
							<div class="form-inline input-group">
								<input type="text" class="form-control" name="company_name" value="<?php echo html_escape(element('company_name', element('search', $view))); ?>" placeholder="Search for..." />
								<span class="input-group-btn">
									<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색</button>
								</span>
								<?php foreach(element('plan', element('search', $view)) as $k => $v){ ?>
								<label for="plan_<?php echo element('plan_idx', $v);?>"><input type="checkbox" name="plan[]" id="plan_<?php echo element('plan_idx', $v);?>" value="<?php echo element('plan_idx', $v);?>" <?php echo element('checked', $v);?>><?php echo element('plan_name', $v);?></label>
								<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="col-sm-2">이용시작일</th>
						<td class="col-sm-10 form-inline">
							<div class="form-inline">
								<input type="text" name="use_sday_1" value="<?php echo element('use_sday_1', element('search', $view));?>" id="use_sday_1" class="form-control input datepicker">
								~
								<input type="text" name="use_sday_2" value="<?php echo element('use_sday_2', element('search', $view));?>" id="use_sday_2" class="form-control input datepicker">
							</div>
						</td>
					</tr>
					<tr>
						<th class="col-sm-2">이용종료일</th>
						<td class="col-sm-10 form-inline">
							<div class="form-inline">
								<input type="text" name="use_eday_1" value="<?php echo element('use_eday_1', element('search', $view));?>" id="use_eday_1" class="form-control input datepicker">
								~
								<input type="text" name="use_eday_2" value="<?php echo element('use_eday_2', element('search', $view));?>" id="use_eday_2" class="form-control input datepicker">
							</div>
						</td>
					</tr>
					<tr>
						<th class="col-sm-2">상태</th>
						<td class="col-sm-10 form-inline">
							<div class="form-inline">
								<label for="search-state"><input type="checkbox" name="state" value="<?php if(element('state', element('search', $view)) == 'use'){ echo 'use';} else { echo '';}?>" id="search-state" <?php if(element('state', element('search', $view)) == 'use'){ echo 'checked';}?>>활성화 기업만</label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="input-group">
					선택한 기업을
					<select name="chgstate" id="chgstate">
						<option value="">선택해주세요.</option>
						<option value="unuse">비활성화로</option>
						<option value="use">활성화로</option>
					</select>
					<button type="button" class="btn btn-default btn-sm" id="btn-change-state">변경</button>
				</div>
				<select name="sort" id="sort">
					<option value="">정렬</option>
					<option value="a.company_name asc" <?php if(element('sort', element('search', $view)) == 'a.company_name asc'){ echo 'selected';} ?>>이름순</option>
					<option value="a.reg_date desc" <?php if(element('sort', element('search', $view)) == 'a.reg_date desc'){ echo 'selected';} ?>>등록순</option>
					<option value="a.use_eday asc" <?php if(element('sort', element('search', $view)) == 'a.use_eday asc'){ echo 'selected';} ?>>종료일임박순</option>
					<option value="a.use_cnt desc" <?php if(element('sort', element('search', $view)) == 'a.use_cnt desc'){ echo 'selected';} ?>>이용인원순</option>
				</select>
			</div>
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>선택</th>
							<th>번호</th>
							<th>기업명</th>
							<th>기업명(영문)</th>
							<th>플랜</th>
							<th>상품</th>
							<th>이용시작일</th>
                            <th>이용종료일</th>
                            <th>이용인원</th>
                            <th>결제금액</th>
							<th>예치금</th>
							<th>등록일</th>
							<th>상태</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('board', element('list', $view))) {
						foreach (element('board', element('list', $view)) as $k => $v) {
					?>
						<tr>
							<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('company_idx', $v); ?>" /></td>
							<td><?php echo element('num', $v); ?></td>
                            <td>
								<a href="<?php echo admin_url($this->pagedir); ?>/modify/<?php echo element(element('primary_key', $view), $v); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">
									<?php echo element('company_name', $v); ?>
								</a>
							</td>
                            <td><?php echo element('company_code', $v); ?></td>
                            <td><?php echo element('plan_name', $v); ?></td>
							<td><?php if(element('plan_type', $v) == 'm'){echo '월간';}else{echo '연간';} ?></td>
                            <td><?php echo element('use_sday', $v); ?></td>
                            <td><?php echo element('use_eday', $v); ?></td>
                            <td><?php echo number_format(element('use_cnt', $v)); ?></td>
                            <td></td>
                            <td><a href="/admin/member/company/deposit/<?php echo element('company_idx', $v); ?>"><?php echo number_format(element('company_deposit', $v)); ?></a></td>
                            <td><?php echo display_datetime(element('reg_date', $v), 'full'); ?></td>
                            <td><?php echo $view['state_str'][element('state', $v)]; ?></td>
						</tr>
                    <?php
                        }
                    } else echo '<tr><td colspan="13" class="nopost">자료가 없습니다</td></tr>';
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
<script>
	$('#btn-change-state').click(function(){
		if ($("input[name='chk[]']:checked").length < 1) {
			alert('기업을 선택해주세요.');
			return;
		}
		if($('select[name="chgstate"]').val() == ''){
			alert('상태값을 선택해주세요.');
			return false;
		}

		$('#flist').submit();
	});

	$('#sort').change(function(){
		$('#flist').submit();
	});

	$('#search-state').click(function(){
		if($(this).is(':checked') === true){
			$(this).val('use');
		} else {
			$(this).val('');
		}
	});
</script>
