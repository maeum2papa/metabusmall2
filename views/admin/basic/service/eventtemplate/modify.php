<div class="box">
    <div class="box-table">
    <?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite', 'onsubmit' => 'return submitContents(this)');
		echo form_open_multipart(admin_url($this->pagedir).'/save'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
		
    ?>
        <input type="hidden" name="mode" value="update">
        <input type="hidden" name="template_idx" value="<?php echo element('primary_key', element('data', $view)); ?>">
        <div class="box-table-header">
			<div class="input-group">
				템플릿 불러오기
				<select name="chgstate" id="chgstate">
					<option value="">목록</option>
                    <?php foreach(element('tpl_list', $view) as $k => $v){ ?>
                    <option value="<?php echo element('template_idx', $v);?>" <?php if(element('template_idx', element('data', $view)) == element('template_idx', $v)){ echo 'selected'; } ?>><?php echo element('template_name', $v);?></option>
                    <?php } ?>
				</select>
			</div>
		</div>
        <div class="box-table-header">
            <h4>템플릿 정보</h4>
        </div>
        <table class="table table-hover table-striped table-bordered">
            <tbody>
                <tr>
                    <th>템플릿 이름</th>
                    <td><input type="text" class="input px400" name="template_name" value="<?php echo element('template_name', element('data', $view)); ?>"></td>
                </tr>
                <tr>
                    <th>템플릿 설명</th>
                    <td>
                        <textarea class="smarteditor dhtmleditor" name="template_contents" id="template_contents" cols="10" rows="100"><?php echo element('template_contents', element('data', $view)); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>템플릿 노출</th>
                    <td>
                        <div class="input-group">
                            <label for="showy" class="checkbox-inline"><input type="radio" name="template_showFl" value="y" <?php if(element('template_showFl', element('data', $view)) == 'y'){ echo 'checked'; } ?> id="showy">노출</label>
                            <label for="shown" class="checkbox-inline"><input type="radio" name="template_showFl" value="n" <?php if(element('template_showFl', element('data', $view)) == 'n'){ echo 'checked'; } ?> id="shown">미노출</label>
                            <label for="shows" class="checkbox-inline"><input type="radio" name="template_showFl" value="s" <?php if(element('template_showFl', element('data', $view)) == 's'){ echo 'checked'; } ?> id="shows">특정기업 노출</label>
                            <select name="template_show_company" id="template_show_company">
                                <option value="">목록</option>
                                <?php foreach(element('com_list', $view) as $k => $v){ ?>
                                <option value="<?php echo element('company_idx', $v);?>"><?php echo element('company_name', $v);?></option>
                                <?php } ?>
                            </select>
                            <div id="selectedOptions">
                                <?php if(element('template_showFl', element('data', $view)) == 's'){ ?>
                                    <?php foreach(element('template_show_company_list', element('data', $view)) as $k => $v){ ?>
                                    <button type="button" class="btn" data-value="<?php echo element('company_idx', $v); ?>"><?php echo element('company_name', $v); ?></button>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="selectedOptions" value="">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="table-bottom text-center mt20">
            <button type="button" class="btn btn-default btn-sm btn-history-back">취소</button>
            <button type="submit" class="btn btn-success btn-sm">작성완료</button>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript" src="/plugin/editor/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "template_contents",
        sSkinURI: "/plugin/editor/nse_files/SmartEditor2Skin.html",
        fCreator: "createSEditor2"
    });

    $(document).ready(function(){
        <?php if(element('template_showFl', element('data', $view)) != 's'){ ?>
        $('#template_show_company option').attr('disabled', true);
        <?php } ?>

        $('input[name="template_showFl"]').click(function(){
            if($(this).val() == 's'){
                $('#template_show_company option').attr('disabled', false);
            } else {
                $('#template_show_company option').attr('disabled', true);
            }
        });
    });

    var selectedValues = [];

    $('#template_show_company').on('change', function(){
        $('#template_show_company option:selected').each(function(){
            if($(this).val() != ''){
                var selectedValue = $(this).val();
                var selectedText = $(this).text();
                if(selectedValues.indexOf(selectedValue) === -1) {
                    selectedValues.push(selectedValue);
                    var buttonHtml = '<button type="button" class="btn" data-value="' + selectedValue + '">' + selectedText + ' X</button>';
                    $('#selectedOptions').append(buttonHtml);
                }

                $('#template_show_company').val('');
            }
        });
    });

    $('#selectedOptions').on('click', 'button', function(){
        var valueToRemove = String($(this).data('value')); // 삭제할 값
        $(this).remove(); // 버튼을 제거합니다.
        selectedValues = selectedValues.filter(function(value) {
            return String(value) !== valueToRemove; // 문자열로 변환하여 일치 여부 확인
        });
        console.log(selectedValues);
    });

    
    $('#chgstate').on('change', function(){
        if($(this).val() != ''){
            var idx = $(this).val();

            $.ajax({
				method: "POST",
				url: "/admin/service/eventtemplate/loadtemplate",
				data: {
					template_idx : idx,
					csrf_test_name : cb_csrf_hash
				},
			}).success(function(data){
				var json = $.parseJSON(data);
                $('#template_name').val(json.data.template_name);
                oEditors.getById['template_contents'].exec('SET_IR', ['']);
                oEditors.getById['template_contents'].exec('PASTE_HTML', [json.data.template_contents]);
                $('input[name="template_showFl"][value='+json.data.template_showFl+']').prop('checked', true);
                if(json.data.template_showFl == 's'){
                    $('#selectedOptions').empty();
                    $('#template_show_company option').attr('disabled', false);
                    $('#selectedOptions').append(json.data.template_show_company_list);
                    selectedValues.push(json.data.template_show_company);
                } else {
                    $('#selectedOptions').empty();
                    $('#template_show_company option').attr('disabled', true);
                    $('#template_show_company').val('');
                    selectedValues = [];
                }
				// console.log(json);
			}).error(function(e){
				console.log(e.responseText);
			});
        }
    });

    function submitContents(f){
        oEditors.getById["template_contents"].exec("UPDATE_CONTENTS_FIELD", []);
        selectedValues.sort(function(a, b){
            return a - b;
        });
        $('input[name="selectedOptions"]').val(selectedValues);
        try {
            f.form.submit();
        } catch(e) {}
    }
</script>