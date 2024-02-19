<div class="box">
    <div class="box-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/write'); ?>/<?php echo element(element('primary_key', $view), element('data', $view)); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">과정정보</a></li>
        <?php if(element(element('primary_key', $view), element('data', $view))) { ?>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/content'); ?>/<?php echo element(element('primary_key', $view), element('data', $view)); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">커리큘럼</a></li>
        <?php } ?>
        </ul>
    </div>
    <div class="box-table">
    <?php
        echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
        echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
        $attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
        echo form_open_multipart(admin_url($this->pagedir).'/save'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
    ?>
        <input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
        <div class="box-table-header">
            <h4>과정정보</h4>
        </div>        
        <div class="form-group">
            <label class="col-sm-2 control-label">과정명</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="process_title" value="<?php echo set_value('process_title', element('process_title', element('data', $view))); ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">플랜</label>
            <div class="col-sm-10 form-inline">
                <select name="plan_idx" id="plan_idx" class="form-control">
                    <?php  foreach($view['plan_list'] as $l) { echo "<option value='".$l['plan_idx']."'>".$l['plan_name']."</option>";}?>
                </select>
                <select name="reg_company_idx" id="reg_company_idx" class="form-control">
                    <option value="0">없음</option>
                    <?php  foreach($view['company_list'] as $l) { echo "<option value='".$l['company_idx']."'>".$l['company_name']."</option>";}?>
                </select>
                <p class="help-block">*엔터프라이즈 플랜인 경우 입력업체를 지정해야 합니다.</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">활성화여부</label>
            <div class="col-sm-10 form-inline">
                <select name="state" id="state" class="form-control">
                    <option value="use">활성화</option>
                    <option value="unuse">비활성화</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">썸네일이미지</label>
            <div class="col-sm-10">
                <?php
                if(element('process_img', element('data', $view)))
                    echo "<img src='".element('process_img', element('data', $view))."' style='width:100px;height:auto;'/>";
                ?>
                <input type="file" name="process_img_file" id="process_img_file" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">배너이미지</label>
            <div class="col-sm-10">
                <?php
                if(element('process_banner', element('data', $view)))
                    echo "<img src='".element('process_banner', element('data', $view))."' style='width:100px;height:auto;'/>";
                ?>
                <input type="file" name="process_banner_file" id="process_banner_file" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">과정설명</label>
            <div class="col-sm-10">
                <?php echo display_dhtml_editor('process_desc', set_value('process_desc', element('process_desc', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label">강사프로필</label>
            <div class="col-sm-10">
                <?php echo display_dhtml_editor('teacher_info', set_value('teacher_info', element('teacher_info', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
            </div>
        </div>
		
		
		<div class="form-group gl_div">
				<label class="col-sm-2 control-label">자료첨부파일</label>
				<div class="col-sm-10"  id="uploadBox">
					<div style="width: 100%; margin-bottom: 10px;">
						<img src='<?=element('img', element('img_in_first', $view))?>' style='width:100px;height:auto;'/>
						<input type="file" name="upfiles[]" style="display: inline-block" />

						<a class="btn btn-white btn-icon-plus addUploadBtn btn-sm">추가</a>
						<input type="hidden" name="uploadFileNm[]" value="<?=element('img', element('img_in_first', $view))?>">
					</div>
					<?php
					foreach (element('img_in', $view) as $k => $v) {
						if($k > 0){
							
					?>
					<div style="width: 100%; margin-bottom: 10px;">
						<img src='<?=$v[img]?>' style='width:100px;height:auto;'/>
						<input type="file" name="upfiles[]" style="display: inline-block" />

						<a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm">삭제</a>
						<input type="hidden" name="uploadFileNm[]" value="<?=$v[img]?>">
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		
		
		
        <div class="form-group">
            <label class="col-sm-2 control-label">강의구분</label>
            <div class="col-sm-10">
                <label for="required_flag" class="checkbox-inline">
                    <input type="checkbox" id="required_flag" name="required_flag" value="1"> 필수강의
                </label>
                <label for="propose_flag" class="checkbox-inline">
                    <input type="checkbox" id="propose_flag" name="propose_flag" value="1"> 추천강의
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">노출시작일</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="view_sdate" name="view_sdate" value="<?php echo set_value('view_sdate', element('view_sdate', element('data', $view))); ?>" readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">노출종료일</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="view_edate" name="view_edate" value="<?php echo set_value('view_edate', element('view_edate', element('data', $view))); ?>" readonly />
            </div>
        </div>
        <div class="box-table-header">
            <h4>카테고리</h4>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">카테고리</label>
            <div class="col-sm-10 form-inline">
                <select id="category_sel_1" class="form-control" onchange="category_change()">
                    <?php foreach($view['category_list'] as $l) { echo "<option value='".$l['cca_id']."'>".$l['cca_value']."</option>";}?>
                </select>
                <select id="category_sel_2" class="form-control">
                    <?php foreach($view['category_sub_list'] as $l) { echo "<option value='".$l['cca_id']."'>".$l['cca_value']."</option>";}?>
                </select>
                <a href="javascript:add_category_li()" class="btn btn-default btn-sm">추가</a>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <ul class="list-group" id="add_category_div">
                <?php foreach($view['data']['category_rel_list'] as $k => $l) { ?>
                    <li class="list-group-item" id="add_category_<?php echo $k?>">
                        <input type="hidden" name="add_category_idx[]" id="add_category_idx_<?php echo $l['cca_id']?>" value="<?php echo $l['cca_id']?>" />
                        <a href="javascript:adddiv_del('add_category_<?php echo $k?>')" class="mb-2 mr-2 fa fa-window-close fa-lg"></a> <?php echo $l['cca_desc']?>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <div class="box-table-header">
            <h4>추가노출기업</h4>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">추가노출기업</label>
            <div class="col-sm-10 form-inline">
                <select id="in_add_company" class="form-control">
                    <?php foreach($view['company_list'] as $l) { echo "<option value='".$l['company_idx']."'>".$l['company_name']."</option>";}?>
                </select>
                <a href="javascript:add_company_li()" class="btn btn-default btn-sm">추가</a>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10 form-inline">
                <ul class="list-group" id="add_company_div">
                <?php foreach($view['data']['company_rel_list'] as $k => $l) { ?>
                    <li class="list-group-item" id="add_company_<?php echo $k?>">
                        <input type="hidden" name="add_company_idx[]" id="add_company_idx_<?php echo $l['company_idx']?>" value="<?php echo $l['company_idx']?>" />
                        <a href="javascript:adddiv_del('add_company_<?php echo $k?>')" class="mb-2 mr-2 fa fa-window-close fa-lg"></a> <?php echo $l['company_name']?>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <div class="btn-group pull-right" role="group" aria-label="...">
            <a class="btn btn-default btn-sm btn-history-back" href="<?php echo admin_url($this->pagedir); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">취소하기</a>
            <a class="btn btn-success btn-sm" href="javascript:save();">저장하기</a>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
	
	$(document).ready(function () {	
		
		$('body').on('click', '.addUploadBtn', function () {

			var uploadBoxCount = $('#uploadBox').find('input[name="upfiles[]"]').length;
			if (uploadBoxCount >= 20) {
				alert("업로드는 최대 20개만 지원합니다");
				return;
			}

			var addUploadBox = '<div style="width: 100%; margin-bottom: 10px;"><input type="file" name="upfiles[]" style="display: inline-block" /><a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm">삭제</a></div>';
			$('#uploadBox').append(addUploadBox);
		});

		$('body').on('click', '.minusUploadBtn', function () {
			index = $(this).prevAll('input:file').attr('index'); //$('.file-upload button.uploadremove').index(target)+1;
			$("input[name='uploadFileNm[" + index + "]']").remove();
			$(this).closest('div').remove();
		})	
	});
	
	
    $(function() {
        $('#fadminwrite').validate({
            rules: {
                process_title: { required: true }
            }
        });

        $('#view_sdate').datepicker({format: "yyyy-mm-dd",language : "kr"});
        $('#view_edate').datepicker({format: "yyyy-mm-dd",language : "kr"});

        $('#state').val('<?php echo set_value('state', element('state', element('data', $view))); ?>');
        $('#plan_idx').val('<?php echo set_value('plan_idx', element('plan_idx', element('data', $view))); ?>');
        $('#reg_company_idx').val('<?php echo set_value('reg_company_idx', element('reg_company_idx', element('data', $view))); ?>');

        $("input:checkbox[id='required_flag']").prop('checked',<?php echo set_value('required_flag', element('required_flag', element('data', $view))); ?>);
        $("input:checkbox[id='propose_flag']").prop('checked',<?php echo set_value('propose_flag', element('propose_flag', element('data', $view))); ?>);
    });

    function save()
    {
        oEditors.getById["process_desc"].exec("UPDATE_CONTENTS_FIELD", []);
		oEditors.getById["teacher_info"].exec("UPDATE_CONTENTS_FIELD", []);
        $('#fadminwrite').submit();
    }

    function category_change()
    {
        var pid = $('#category_sel_1').val();

        $.get('/admin/lms/processinfo/get_category_sub/'+pid, function(data){
            $('#category_sel_2').html(data);
        });
    }

    var category_no = <?php echo set_value('category_no', element('category_no', element('data', $view))); ?>;
    function add_category_li()
    {
        var idx = $('#category_sel_2').val();
        var chk_idx =  $('#add_category_idx_'+idx).val();

        if(chk_idx == undefined)
        {
            var root_name = $('#category_sel_1 option:checked').text();
            var sub_name = $('#category_sel_2 option:checked').text();

            category_no ++;

            var html = '<li class="list-group-item" id="add_category_'+ category_no+'">';
            html += '<input type="hidden" name="add_category_idx[]" id="add_category_idx_'+idx+'" value="'+idx+'">';
            html += '<a href="javascript:adddiv_del(\'add_category_'+ category_no+'\')" class="mb-2 mr-2 fa fa-window-close fa-lg"></a> '+root_name+' &gt; '+sub_name;
            html += '</li>';

            $('#add_category_div').append(html);
        }
    }

    var company_no = <?php echo set_value('company_no', element('company_no', element('data', $view))); ?>;
    function add_company_li()
    {
        var idx = $('#in_add_company').val();
        var chk_idx =  $('#add_company_idx_'+idx).val();

        if(chk_idx == undefined)
        {
            var name = $('#in_add_company option:checked').text();

            company_no ++;

            var html = '<li class="list-group-item" id="add_company_'+ company_no+'">';
            html += '<input type="hidden" name="add_company_idx[]" id="add_company_idx_'+idx+'" value="'+idx+'">';
            html += '<a href="javascript:adddiv_del(\'add_company_'+ company_no+'\')" class="mb-2 mr-2 fa fa-window-close fa-lg"></a> '+name;
            html += '</li>';

            $('#add_company_div').append(html);
        }
    }

    function adddiv_del(id)
    {
        $('#'+id).remove();
    }
    //]]>
</script>
