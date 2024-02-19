<div class="box">
    <div class="box-table">
        <?php
            echo show_alert_message($this->session->flashdata('message1'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminmodify1', 'id' => 'fadminmodify1', 'onsubmit' => 'return submitContents(this)');
            echo form_open_multipart(admin_url($this->pagedir).'/save'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
        ?>
            <input type="hidden" name="mode" value="register">
            <div class="box-table-header">
                <div class="input-group">
                    이벤트 불러오기
                    <select name="chgstate" id="chgstate">
                        <option value="">목록</option>
                        <?php foreach(element('evt_list', $view) as $k => $v){ ?>
                        <option value="<?php echo element('event_idx', $v);?>"><?php echo element('event_name', $v);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="box-table-header">
                <h4>이벤트 정보</h4>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">이벤트명</th>
                        <td class="col-sm-10" colspan="3"><input type="text" class="form-control" name="event_name" id="event_name" value="<?php echo set_value('event_name', element('event_name', element('data', $view))); ?>" /></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">이벤트내용</th>
                        <td class="col-sm-10" colspan="3"><input type="text" class="form-control" name="event_contents" id="event_contents" value="<?php echo set_value('event_contents', element('event_contents', element('data', $view))); ?>" /></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">이벤트 시작일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control datepicker" name="event_startDt" id="event_startDt" value="<?php echo set_value('event_startDt', element('event_startDt', element('data', $view))); ?>" /></td>
                        <th class="col-sm-2">이벤트 종료일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control datepicker" name="event_endDt" id="event_endDt" value="<?php echo set_value('event_endDt', element('event_endDt', element('data', $view))); ?>" /></td>
                    </tr>
                </tbody>
            </table>
            <div class="box-table-header">
                <h4>이벤트 기능</h4>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">템플릿 선택</th>
                        <td class="col-sm-10" colspan="3">
                            <select name="template_idx" id="template_idx">
                                <option value="">목록</option>
                                <?php foreach(element('tpl_list', $view) as $k => $v){ ?>
                                <option value="<?php echo element('template_idx', $v);?>" <?php if(element('template_idx', element('data', $view)) == element('template_idx', $v)){ echo 'selected'; } ?>><?php echo element('template_name', $v);?></option>
                                <?php } ?>
                            </select>
                            <button type="button" class="btn" id="template_desc" onclick="openTempList()">템플릿 설명</button>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">칭호 선택</th>
                        <td class="col-sm-10" colspan="3"></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">포인트 지급</th>
                        <td class="col-sm-10 form-inline" colspan="3"><input type="text" class="form-control input-small" name="event_point" id="event_point" value="<?php echo set_value('event_point', element('event_point', element('data', $view))); ?>" /></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">포인트/칭호 지급일</th>
                        <td class="col-sm-10 form-inline" colspan="3">
                            <label for="st"><input type="radio" name="event_giveFl" value="st" id="st">시작일 지급</label>
                            <label for="en"><input type="radio" name="event_giveFl" value="en" id="en">종료일 지급</label>
                            <label for="sp"><input type="radio" name="event_giveFl" value="sp" id="sp">특정일 지급</label>
                            <input type="text" class="form-control datepicker" name="event_give_day" id="event_give_day" value="<?php echo set_value('event_give_day', element('event_give_day', element('data', $view))); ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="box-table-header">
                <h4>이벤트 그룹</h4>
                <input type="hidden" name="addEventGroup">
                <button type="button" class="btn" onclick="addMember()">추가</button>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="chkall" id="chkall" /></th>
                        <th>번호</th>
                        <th>소속</th>
                        <th>직급</th>
                        <th>직원명</th>
                        <th>아이디</th>
                        <th>이메일</th>
                    </tr>
                </thead>
                <tbody id="event_group_member_list"></tbody>
            </table>
            <div class="table-bottom">
                <button type="button" class="btn" onclick="delMember()">삭제</button>
            </div>
            <div class="box-table-header">
                <h4>이벤트 알림 설정</h4>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">이벤트 썸네일 이미지</th>
                        <td class="col-sm-10" colspan="3">
                            <input type="file" name="event_thumb_file" id="event_thumb_file">
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">쪽지 알림</th>
                        <td class="col-sm-10" colspan="3">
                            <p>* 이벤트 시작 시 마이랜드의 우체통으로 아래 내용으로 쪽지가 발송됩니다</p>
                            <ul>
                                <li class="form-inline">
                                    <span>전체에게</span>
                                    <textarea name="event_message_all" id="event_message_all" cols="100" rows="10"></textarea>
                                </li>
                                <li class="form-inline">
                                    <span>그룹원에게</span>
                                    <textarea name="event_message_group" id="event_message_group" cols="100" rows="10"></textarea>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">대시보드 알림</th>
                        <td class="col-sm-10" colspan="3">
                            <p>* 그룹원의 대시보드에 아래 내용으로 카드가 노출됩니다​</p>
                            <ul>
                                <li class="form-inline">
                                    <span>그룹원에게</span>
                                    <textarea name="event_dashboard_group" id="event_dashboard_group" cols="100" rows="10"></textarea>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="table-bottom text-center mt20">
                <button type="button" class="btn btn-default btn-sm btn-history-back">취소</button>
                <button type="submit" class="btn btn-success btn-sm">이벤트 수정</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div id="popupContainer" class="event_popup">
	<span class="close" onclick="closePopup()">&times;</span>
    <div class="box tpl_box">
        <div class="left">
            <ul id="tpl_list">
                <?php foreach(element('tpl_list', $view) as $k => $v){ ?>
                <li><a href="javascript:void(0);" onclick="openDesc(<?php echo element('template_idx', $v); ?>)"><?php echo element('template_name', $v); ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="right">
            <h3 class="tpl_name"></h3>
            <div class="tpl_contents"></div>
        </div>
    </div>
</div>
<div id="popupContainer2" class="event_popup">
    <span class="close" onclick="closePopup2()">&times;</span>
    <iframe id="myIframe" src="" frameborder="0"></iframe>
</div>
<script>
    // 이벤트 불러오기
    $('#chgstate').on('change', function(){
        if($(this).val() != ''){
            var idx = $(this).val();

            $.ajax({
				method: "POST",
				url: "/admin/servicing/eventtemplate/loadevent",
				data: {
					event_idx : idx,
					csrf_test_name : cb_csrf_hash
				},
			}).success(function(data){
				var json = $.parseJSON(data);
                $('#event_name').val(json.data.event_name);
                $('#event_contents').val(json.data.event_contents);
                $('#event_startDt').val(json.data.event_startDt);
                $('#event_endDt').val(json.data.event_endDt);
                $('input[name="event_giveFl"][value='+json.data.event_giveFl+']').prop('checked', true);
                if(json.data.event_giveFl == 'sp'){
                    $('#event_give_day').val(json.data.event_give_day);
                } else {
                    $('#event_give_day').val('');
                }
                $('#event_point').val(json.data.event_point);
                $('#template_idx').val(json.data.template_idx);
                $('#template_desc').attr('onclick', 'openDesc('+json.data.template_idx+')');
                $('#event_message_all').text(json.data.event_message_all);
                $('#event_message_group').text(json.data.event_message_group);
                $('#event_dashboard_group').text(json.data.event_dashboard_group);
				// console.log(json);
			}).error(function(e){
				console.log(e.responseText);
			});
        }
    });

    // 템플릿 설명 팝업 열기
    function openTempList(){
        $('#popupContainer').hide();
        $('#popupContainer').show();
    }

    // 템플릿 설명 팝업 목록 상세
    function openDesc(idx){
        $('#popupContainer .tpl_name').text('');
        $('#popupContainer .tpl_contents').html('');
        $.ajax({
            method: "POST",
            url: "/admin/servicing/eventtemplate/loadTempDesc",
            data: {
                template_idx: idx,
                csrf_test_name: cb_csrf_hash
            },
        }).success(function(data){
            var json = $.parseJSON(data);
            $('#popupContainer .tpl_name').text(json.data.template_name);
            $('#popupContainer .tpl_contents').html(json.data.template_contents);
        }).error(function(e){
            console.log(e.responseText);
        });
    }

    // 직원정보 팝업 기획 후 작업
    function openPopup(idx){
		// $('#popupContainer2').hide();
		// $('#myIframe').attr('src','about:blank');
		// $('#myIframe').attr('src','/admin/servicing/eventtemplate/get_member/'+idx);
		// $('#popupContainer').show();
	}

    // 템플릿 설명 팝업 닫기
    function closePopup() {
		$('#popupContainer').hide();
		$('#popupContainer .tpl_name').text('');
        $('#popupContainer .tpl_contents').html('');
	}

    // 이벤트 그룹 추가 팝업 닫기
    function closePopup2() {
		$('#popupContainer2').hide();
		$('#myIframe').attr('src','about:blank');
	}

    // 이벤트 그룹 추가 팝업 열기
    function addMember(){
        $('#popupContainer2').hide();
        $('#myIframe').attr('src','about:blank');
		$('#myIframe').attr('src','/admin/servicing/eventtemplate/add_member');
		$('#popupContainer2').show();
    }

    // 이벤트 그룹 추가 팝업 데이터 적용
    function applyValues(values) {
        $('#popupContainer2').hide();
        $('#myIframe').attr('src','about:blank');
        // 각 값들에 대해 AJAX 요청을 보냄
        values.forEach(function(value, index){
            // 이미 추가된 데이터인지 확인하기 위해 ID 추출
            var existingIds = [];
            $('#event_group_member_list tr').each(function(){
                var existingId = $(this).find('td:first-child input').val();
                existingIds.push(existingId);
            });

            // 만약 이미 추가된 데이터라면 AJAX 요청을 보내지 않고 함수 종료
            if (existingIds.includes(value)) {
                alert("mem_id : " + value + "는 이미 추가된 데이터입니다.");
                return;
            }

            // AJAX 요청을 보냄
            var num = $('#event_group_member_list tr').length + index;
            $.ajax({
                url: '/admin/servicing/eventtemplate/loadMemInfo',
                type: 'POST',
                data: {
                    csrf_test_name : cb_csrf_hash,
                    mem_id: value
                }
            }).success(function(data){
				var json = $.parseJSON(data);
                var html = "";
                html += "";
                html += "<tr id='tr_"+json.data.mem_id+"'>";
                html += "<td><input type='checkbox' name='chk[]' class='list-chkbox' value='"+json.data.mem_id+"' /></td>";
                html += "<td>"+parseInt(num+1)+"</td>";
                html += "<td>"+json.data.mem_div+"</td>";
                html += "<td>"+json.data.mem_position+"</td>";
                html += "<td><a href='javascript:void(0);' onclick='openPopup("+json.data.mem_id+")'>"+json.data.mem_username+"</a></td>";
                html += "<td>"+json.data.mem_userid+"</td>";
                html += "<td>"+json.data.mem_email+"</td>";
                html += "</tr>";
                
                $('#event_group_member_list').append(html);
                updateRowNumbers();
			}).error(function(e){
				console.log(e.responseText);
			});
        });
    }

    // 이벤트 그룹 회원 삭제
    function delMember(){
        var checkedCheckboxes = $('#event_group_member_list input[type="checkbox"]:checked');

        // 체크된 체크박스의 부모 <tr>을 삭제합니다.
        checkedCheckboxes.each(function() {
            $(this).closest('tr').remove();
        });
        updateRowNumbers();
    }

    // 이벤트 그룹 데이터 재정렬(번호 매기기)
    function updateRowNumbers() {
        $('#event_group_member_list tr').each(function(index) {
            $(this).find('td:eq(1)').text(index + 1); // 각 행의 번호 업데이트
        });
    }

    function submitContents(f){
        var existingIds = [];
        $('#event_group_member_list tr').each(function(){
            var existingId = $(this).find('td:first-child input').val();
            existingIds.push(existingId);
        });
        $('input[name="addEventGroup"]').val(existingIds);
        try {
            f.form.submit();
        } catch(e) {}
    }
</script>