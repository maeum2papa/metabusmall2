<div class="box">
    <div class="btn-group pull-right" role="group" aria-label="...">
		<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">이벤트 추가</a>
	</div>
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
        <h3>이벤트검색</h3>
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
                        <th>이벤트명</th>
                        <td colspan="3"><input type="text" name="event_name" value="<?php echo $this->input->get('event_name'); ?>" class="form-control input-small"></td>
                    </tr>
                    <tr>
                        <th>이벤트시작일</th>
                        <td colspan="3" class="form-inline">
							<input type="text" class="form-control input-small datepicker " name="event_startDt_1" value="<?php echo $this->input->get('event_startDt_1'); ?>" readonly="readonly" />
							 - 
							<input type="text" class="form-control input-small datepicker" name="event_startDt_2" value="<?php echo $this->input->get('event_startDt_2'); ?>" readonly="readonly" />
                            <button type="button" class="btn" onclick="deleteInput('event_startDt')">삭제</button>
						</td>
                    </tr>
                    <tr>
                        <th>이벤트종료일</th>
                        <td colspan="3" class="form-inline">
							<input type="text" class="form-control input-small datepicker " name="event_endDt_1" value="<?php echo $this->input->get('event_endDt_1'); ?>" readonly="readonly" />
							 - 
							<input type="text" class="form-control input-small datepicker" name="event_endDt_2" value="<?php echo $this->input->get('event_endDt_2'); ?>" readonly="readonly" />
                            <button type="button" class="btn" onclick="deleteInput('event_endDt')">삭제</button>
						</td>
                    </tr>
                    <tr>
                        <th>상태</th>
                        <td colspan="3" class="form-inline">
                            <label for="event_showFl"><input type="checkbox" name="event_showFl" id="event_showFl" value="<?php echo $this->input->get('event_showFl'); ?>" <?php if($this->input->get('event_showFl') == 'y'){echo 'checked';}?>> 활성화 이벤트</label>
                        </td>
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
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
        <h3>이벤트목록</h3>
		<div class="box-table-header">
			<div class="input-group">
				선택한 이벤트를
				<select name="chgstate" id="chgstate">
					<option value="">선택해주세요.</option>
					<option value="n">비활성화로</option>
					<option value="y">활성화로</option>
                    <option value="d">삭제</option>
				</select>
				<button type="button" class="btn btn-default btn-sm" id="btn-change-state">변경</button>
			</div>
			<select name="sort" id="sort">
				<option value="">정렬</option>
				<option value="a.event_name asc" <?php if(element('sort', element('search', $view)) == 'a.event_name asc'){ echo 'selected';} ?>>이름순</option>
				<option value="a.event_regDt desc" <?php if(element('sort', element('search', $view)) == 'a.event_regDt desc'){ echo 'selected';} ?>>등록순</option>
				<option value="DATEDIFF(event_endDt, CURDATE())" <?php if(element('sort', element('search', $view)) == 'DATEDIFF(event_endDt, CURDATE())'){ echo 'selected';} ?>>종료일임박순</option>
                <option value="count_member desc" <?php if(element('sort', element('search', $view)) == 'count_member desc'){ echo 'selected';} ?>>인원순</option>
			</select>
		</div>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
                            <th><input type="checkbox" name="chkall" id="chkall" /></th>
							<th><a href="<?php echo element('template_idx', element('sort', $view)); ?>">번호</a></th>
							<th>이벤트 시작일</th>
							<th>이벤트 종료일</th>
							<th>이벤트명</th>
							<th>인원</th>
                            <th>상태</th>
                            <th>수정</th>
                            <th>삭제</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
                            <td title="관리"><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('event_idx', $result); ?>" /></td>
							<td title="번호"><?php echo number_format(element('num', $result)); ?></td>
							<td title="이벤트 시작일"><?php echo html_escape(element('event_startDt', $result)); ?></td>
                            <td title="이벤트 종료일"><?php echo html_escape(element('event_endDt', $result)); ?></td>
							<td title="이벤트명"><button type="button" class="btn" style="background:none;" onclick="openPopup(<?php echo element('event_idx', $result); ?>)"><?php echo element('event_name', $result); ?></button></td>
                            <td title="인원"><?php echo element('count_member', $result); ?></td>
							<td title="상태"><?php echo element('event_showFl', $result); ?></td>
							<td title="수정"><a href="/admin/servicing/eventtemplate/modify/<?php echo element('event_idx', $result);?>">수정</a></td>
                            <td title="삭제"><a href="/admin/servicing/eventtemplate/delete/<?php echo element('event_idx', $result);?>">삭제</a></td>
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
	
</div>
<div id="popupContainer" class="event_popup">
	<button type="button" class="btn" id="btnPaste">복사</button>
	<button type="button" class="btn" id="btnModify">수정</button>
	<span class="close" onclick="closePopup()">&times;</span>
    <iframe id="myIframe" src="" frameborder="0"></iframe>
</div>
<script>
	$('#btn-change-state').click(function(){
		if ($("input[name='chk[]']:checked").length < 1) {
			alert('이벤트를 선택해주세요.');
			return false;
		}
		if($('select[name="chgstate"]').val() == ''){
			alert('상태값을 선택해주세요.');
			return false;
		}

        if($("input[name='chk[]']:checked").length > 0 && $('select[name="chgstate"]').val() != ''){
            if($('select[name="chgstate"]').val() == 'y'){
                var result = confirm('오늘 날짜로 이벤트가 시작됩니다.');
            } else if($('select[name="chgstate"]').val() == 'n'){
                var result = confirm('오늘 날짜로 이벤트가 종료됩니다.');
            } else if($('select[name="chgstate"]').val() == 'd'){
                var result = confirm('선택하신 이벤트를 삭제하시겠습니까?');
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

    function deleteInput(id){
        $('input[name="'+id+'_1"]').val('');
        $('input[name="'+id+'_2"]').val('');
    }

	function openPopup(idx){
		$('#popupContainer').hide();
		$('#myIframe').attr('src','about:blank');
		$('#myIframe').attr('src','/admin/servicing/eventtemplate/event_info/'+idx);
		$('#popupContainer #btnPaste').attr('onclick', '');
		$('#popupContainer #btnPaste').attr('onclick', 'movePaste('+idx+')');
		$('#popupContainer #btnModify').attr('onclick', '');
		$('#popupContainer #btnModify').attr('onclick', 'moveModify('+idx+')');
		$('#popupContainer').show();
	}

	function movePaste(idx){
		location.href='/admin/servicing/eventtemplate/paste/'+idx;
	}

	function moveModify(idx){
		location.href='/admin/servicing/eventtemplate/modify/'+idx;
	}

	function closePopup() {
		$('#popupContainer').hide();
		$('#myIframe').attr('src','about:blank');
	}

    $('#event_showFl').click(function(){
        if($(this).is(':checked') == true){
            $('#event_showFl').val('y');
        } else {
            $('#event_showFl').val('');
        }
    });
</script>