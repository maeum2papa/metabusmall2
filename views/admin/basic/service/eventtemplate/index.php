<div class="box">
	<div class="btn-group pull-right" role="group" aria-label="...">
		<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">템플릿 추가</a>
	</div>
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
		<div class="box-table-header">
			<div class="input-group">
				선택한 이벤트를
				<select name="chgstate" id="chgstate">
					<option value="">선택해주세요.</option>
					<option value="d">삭제</option>
					<option value="y">노출</option>
					<option value="n">미노출</option>
				</select>
				<button type="button" class="btn btn-default btn-sm" id="btn-change-state">변경</button>
			</div>
			<select name="sort" id="sort">
				<option value="">정렬</option>
				<option value="a.template_name asc" <?php if(element('sort', element('search', $view)) == 'a.template_name asc'){ echo 'selected';} ?>>이름순</option>
				<option value="a.template_regDt desc" <?php if(element('sort', element('search', $view)) == 'a.template_regDt desc'){ echo 'selected';} ?>>등록순</option>
				<option value="template_count desc" <?php if(element('sort', element('search', $view)) == 'template_count desc'){ echo 'selected';} ?>>사용순</option>
			</select>
		</div>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
                            <th><input type="checkbox" name="chkall" id="chkall" /></th>
							<th><a href="<?php echo element('template_idx', element('sort', $view)); ?>">번호</a></th>
							<th>템플릿 이름</th>
							<th>사용</th>
							<th>노출 여부</th>
							<th>등록일</th>
                            <th>수정</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
                            <td title="관리"><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('template_idx', $result); ?>" /></td>
							<td title="번호"><?php echo number_format(element('num', $result)); ?></td>
							<td title="템플릿 이름"><?php echo html_escape(element('template_name', $result)); ?></td>
							<td title="사용"><button type="button" class="btn" style="background:none;" onclick="openPopup(<?php echo element('template_idx', $result); ?>)"><?php echo number_format(element('template_count', $result)); ?></button></td>
                            <td title="노출 여부"><?php echo element('template_showFl', $result); ?></td>
							<td title="작성일"><?php echo element('template_regDt', $result); ?></td>
							<td title="수정"><a href="/admin/service/eventtemplate/modify/<?php echo element('template_idx', $result);?>">수정</a></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="11" class="nopost">자료가 없습니다</td>
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
<div id="popupContainer" class="event_popup">
	<span class="close" onclick="closePopup()">&times;</span>
    <iframe id="myIframe" src="" frameborder="0"></iframe>
</div>
<script>
	$('#btn-change-state').click(function(){
		if ($("input[name='chk[]']:checked").length < 1) {
			alert('템플릿을 선택해주세요.');
			return false;
		}
		if($('select[name="chgstate"]').val() == ''){
			alert('상태값을 선택해주세요.');
			return false;
		}

        if($("input[name='chk[]']:checked").length > 0 && $('select[name="chgstate"]').val() != ''){
            if($('select[name="chgstate"]').val() == 'd'){
                var result = confirm('템플릿이 삭제됩니다.');
            } else if($('select[name="chgstate"]').val() == 'y'){
                var result = confirm('템플릿이 노출됩니다.');
            } else if($('select[name="chgstate"]').val() == 'n'){
                var result = confirm('템플릿이 미노출됩니다.');
            }

            if(result){
                $('#flist').submit();
            } else {
                
            }
        }
	});

	$('#sort').change(function(){
		$('#flist').submit();
	});

	function openPopup(idx){
		$('#popupContainer').hide();
		$('#myIframe').attr('src','about:blank');
		$('#myIframe').attr('src','/admin/service/eventtemplate/counts/'+idx);
		$('#popupContainer').show();
	}

	function openPopup2(idx){
		$('#popupContainer').hide();
		$('#myIframe').attr('src','about:blank');
		$('#myIframe').attr('src','/admin/service/eventtemplate/event_info/'+idx);
		$('#popupContainer').show();
	}

	function closePopup() {
		$('#popupContainer').hide();
		$('#myIframe').attr('src','about:blank');
	}

	$('#closeButton').click(function(){
		$('#myIframe').attr('src','about:blank');
		$('#popupContainer').hide();
	});
</script>