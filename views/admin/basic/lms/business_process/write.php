
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		//echo form_open(current_full_url(), $attributes);
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">컨텐츠번호(자동생성)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="p_sno" value="<?php echo set_value('p_sno', element('p_sno', element('data', $view))); ?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">과정명</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="p_title" value="<?php echo set_value('p_title', element('p_title', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">플랜</label>
				<div class="col-sm-10 form-inline">
					<select class="form-control" id="plan_idx" name="plan_idx">
						<?php foreach ($view['plan_list'] as $v) { ?>
						<option value="<?=$v[plan_idx]?>" <?php if(element('plan_idx', element('data', $view)) == $v[plan_idx]){?>selected<?php } ?>><?=$v[plan_name]?></option>
						<?php } ?>
					</select>
					<select class="form-control" id="reg_company_idx" name="reg_company_idx">
						<option value="0">없음</option>
						<?php foreach ($view['company_list'] as $v) { ?>
						<option value="<?=$v[company_idx]?>" <?php if(element('reg_company_idx', element('data', $view)) == $v[company_idx]){?>selected<?php } ?>><?=$v[company_name]?></option>
						<?php } ?>
					</select>
					<p class="help-block">*엔터프라이즈 플랜인 경우 입력업체를 지정해야 합니다.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">노출여부</label>
				<div class="col-sm-10 form-inline">
					<label class="radio-inline" for="p_viewYn_y">
						<input type="radio" name="p_viewYn" id="p_viewYn_y" value="y" checked <?php echo set_radio('p_viewYn', 'y', (element('p_viewYn', element('data', $view)) == 'y' ? true : false)); ?>  onclick="p_viewYn1('y')" /> 상시노출
					</label>
					<label class="radio-inline" for="p_viewYn_n">
						<input type="radio" name="p_viewYn" id="p_viewYn_n" value="n" <?php echo set_radio('p_viewYn', 'n', (element('p_viewYn', element('data', $view)) == 'n' ? true : false)); ?> onclick="p_viewYn1('n')" /> 미노출
					</label>
					<label class="radio-inline" for="p_viewYn_s">
						<input type="radio" name="p_viewYn" id="p_viewYn_s" value="s" <?php echo set_radio('p_viewYn', 's', (element('p_viewYn', element('data', $view)) == 's' ? true : false)); ?> onclick="p_viewYn1('s')" /> 특정일 노출
					</label>
					<p class="help-block">*특정일 노출의 경우 아래 시작일 종료일을 정확하게 입력해주세요.</p>
				</div>
			</div>
			<div class="form-group seum_cal">
				<label class="col-sm-2 control-label">노출시작일</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="p_sdate" name="p_sdate" value="<?php echo set_value('p_sdate', element('p_sdate', element('data', $view))); ?>" readonly />
				</div>
			</div>
			<div class="form-group seum_cal">
				<label class="col-sm-2 control-label">노출종료일</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="p_edate" name="p_edate" value="<?php echo set_value('p_edate', element('p_edate', element('data', $view))); ?>" readonly />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">썸네일이미지</label>
				<div class="col-sm-10">
					<?php
					if(element('p_thumbnail', element('data', $view)))
						echo "<img src='".element('p_thumbnail', element('data', $view))."' style='width:100px;height:auto;'/>";
					?>
					<input type="file" name="p_thumbnail" id="p_thumbnail" />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group gl_div">
				<label class="col-sm-2 control-label">자료첨부파일<br>개발중</label>
				<div class="col-sm-10"  id="uploadBox1" style="display: none">
					<div style="width: 100%; margin-bottom: 10px;">
						<?php if(element('img', element('img_in_first', $view))){?>
						<img src='<?=element('img', element('img_in_first', $view))?>' style='width:100px;height:auto;'/>
						<?php } ?>
						<input type="file" name="upfiles[]" class="add_file" style="display: inline-block" />

						<a class="btn btn-default addUploadBtn1 btn-sm">추가</a>
						<input type="hidden" name="uploadFileNm[]" value="<?=element('img', element('img_in_first', $view))?>">
					</div>
					<?php
					foreach (element('img_in', $view) as $k => $v) {
						if($k > 0){
							
					?>
					<div style="width: 100%; margin-bottom: 10px;">
						<img src='<?=$v[img]?>' style='width:100px;height:auto;'/>
						<input type="file" name="upfiles[]" class="add_file" style="display: inline-block" />

						<a class="btn btn-default minusUploadBtn1 btn-sm">삭제</a>
						<input type="hidden" name="uploadFileNm[]" value="<?=$v[img]?>">
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">과정설명</label>
				<div class="col-sm-10">
					<?php echo display_dhtml_editor('p_desc', set_value('p_desc', element('p_desc', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">강사프로필</label>
				<div class="col-sm-10">
					<?php echo display_dhtml_editor('p_teacher', set_value('p_teacher', element('p_teacher', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
				</div>
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
			<div class="form-group gl_div">
				<label class="col-sm-2 control-label">커리큘럼</label>
				<div class="col-sm-10"  id="uploadBox">
					<?php if(element('p_curriYn', element('data', $view)) != 'y'){ ?>
					<div style="width: 100%; margin-bottom: 10px;">
						<select class="form-control" id="q_type" name="q_type"  style="width: 150px;" onChange="curriculum_change(this.value)">
							<option value="v" selected>동영상</option>
							<option value="g">게임</option>
							<option value="s">씨앗</option>
						</select>
						<a class="btn btn-default addUploadBtn">추가</a>
					</div>
					<div style="width: 100%; margin-bottom: 10px; display: block;" id="curriculum_v" class="curriculums" >
						<ul id="video_search">
							<li class="list-group-item form-inline">
								<input type="text" class="form-control" id="video_search_txt" value="" style="width: 250px;" /> 
								<a class="btn btn-default chg_video">영상검색</a>
							</li>
						</ul>
						<ul class="list-group" id="video_ul">
							<?php foreach (element('video_list', $view) as $k => $v) {?>
								<?php if($k == 0){ $checked = "checked";}else{$checked = "";}?>
							<li class='list-group-item'>
								<input type='hidden' id="video_choice<?=$v[video_idx]?>" value="<?=$v[video_name]?>" />
								<input type='radio' name='video_choice' value="<?=$v[video_idx]?>" <?=$checked?> /><?=$v[video_name]?>
							</li>
							<?php } ?>
						</ul>
					</div>
					<?php } ?>
					<div style="width: 100%; margin-bottom: 10px; display: none;" id="curriculum_g" class="curriculums" >
						<ul id="game_search">
							<li class="list-group-item form-inline">
								<input type="text" class="form-control" id="game_search_txt" value="" style="width: 250px;" /> 
								<a class="btn btn-default chg_game">게임검색</a>
							</li>
						</ul>
						<ul class="list-group" id="game_ul">
							<?php foreach (element('game_list', $view) as $k => $v) {?>
								<?php if($k == 0){ $checked = "checked";}else{$checked = "";}?>
							<li class='list-group-item'>
								<input type='hidden' id="game_choice<?=$v[g_sno]?>" value="<?=$v[g_nm]?>" />
								<input type='radio' name='game_choice' value="<?=$v[g_sno]?>" <?=$checked?> /><?=$v[g_nm]?>
							</li>
							<?php } ?>
						</ul>
					</div>
					<div style="width: 100%; height: 100px; margin-bottom: 10px; display: none;" id="curriculum_s" class="curriculums" >
						 <input type="number" class="form-control" id="q_seed" value="1" />개 지급
					</div>
					<div class="table-responsive">
						<table id="tb_uploadBox" class="table table-hover table-striped table-bordered">
							<tr>
								<th style="width: 90px;">순서</th>
								<th style="width: 120px;">종류</th>
								<th>내용</th>
								<th style="width: 90px;">삭제</th>
							</tr>
							<?php
							if(element('p_curriYn', element('data', $view)) == 'y'){
								foreach($view['curri_list'] as $v) {
							?>
							<tr>
								<td><?=$v[c_order]?></th>
								<td><?=$v[c_type]?></th>
								<td><?=$v[c_content]?></th>
								<td>삭불</th>
							</tr>
							<?php
							}}
							?>
						</table>
					</div>
				</div>
			</div>
			
		
		
		
		
<!--
			<div class="form-group">
				<label class="col-sm-2 control-label">템플릿선택</label>
				<div class="col-sm-10">
                    <select class="form-control" id="tp_sno" name="tp_sno"  style="width: 250px;">
						<?php
						foreach (element('template', $view) as $v) {
						?>
						<option value="<?=$v[tp_sno]?>" <?php if(element('tp_sno', element('data', $view)) == $v[tp_sno]){?>selected<?php } ?>><?=$v[tp_nm]?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">게임학습컨텐츠명</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="g_nm" value="<?php echo set_value('g_nm', element('g_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">게임 방법</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="g_method" value="<?php echo set_value('g_method', element('g_method', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">제한 시간</label>
				<div class="col-sm-10">
                    <input type="number" class="form-control" name="g_time" value="<?php echo set_value('g_time', element('g_time', element('data', $view))); ?>" />초
				</div>
			</div>
			
			<div class="form-group gl_div">
				<label class="col-sm-2 control-label">문제추가</label>
				<div class="col-sm-10"  id="uploadBox3">
					
					<?php
					foreach (element('g_question', $view) as $k => $v) {
						$q_num = $k + 1;
						if($v[qtype] == 'o'){
					?>
					<div class="question<?=$k?>"  style="width: 100%; margin-bottom: 10px;">
						( <?=$q_num?> )번 문제 : 
						<input type="text" class="form-control" name="question[]" value="<?=$v[question]?>" style="width: 45%;" />
						<input type="hidden" name="qtype[]" value="o"/>
						<a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm"  data-value="<?=$k?>">삭제</a>
					</div>
					<div class="col-sm-10 form-inline  question<?=$k?>" style="width: 100%; margin-bottom: 10px;">
						1 번 보기 : 
						<input type="text" class="form-control" name="answer_s[<?=$k?>][]" value="<?=$v[ex][0]?>" style="width:15%;" /> 
						<input type="radio" name="correctYn<?=$k?>" value="1" <?php if($v[answer] == '1'){?>checked<?php }?> /> 체크시 멘트 
						<input type="text" class="form-control" name="chk_s[<?=$k?>][]" value="<?=$v[chk_txt][0]?>" style="width:35%;" />
					</div>
					<div class="col-sm-10 form-inline question<?=$k?>" style="width: 100%; margin-bottom: 10px;">
						2 번 보기 : 
						<input type="text" class="form-control" name="answer_s[<?=$k?>][]" value="<?=$v[ex][1]?>" style="width:15%;" /> 
						<input type="radio" name="correctYn<?=$k?>" value="2" <?php if($v[answer] == '2'){?>checked<?php }?>/> 체크시 멘트 
						<input type="text" class="form-control" name="chk_s[<?=$k?>][]" value="<?=$v[chk_txt][1]?>" style="width:35%;" />
					</div>
					<div class="col-sm-10 form-inline question<?=$k?>" style="width: 100%; margin-bottom: 10px;">
						3 번 보기 : 
						<input type="text" class="form-control" name="answer_s[<?=$k?>][]" value="<?=$v[ex][2]?>" style="width:15%;" /> 
						<input type="radio" name="correctYn<?=$k?>" value="3" <?php if($v[answer] == '3'){?>checked<?php }?>/> 체크시 멘트 
						<input type="text" class="form-control" name="chk_s[<?=$k?>][]" value="<?=$v[chk_txt][2]?>" style="width:35%;" />
					</div>
					<div class="col-sm-10 form-inline question<?=$k?>" style="width: 100%; margin-bottom: 10px;">
						4 번 보기 : 
						<input type="text" class="form-control" name="answer_s[<?=$k?>][]" value="<?=$v[ex][3]?>" style="width:15%;" /> 
						<input type="radio" name="correctYn<?=$k?>" value="4" <?php if($v[answer] == '4'){?>checked<?php }?>/> 체크시 멘트 
						<input type="text" class="form-control" name="chk_s[<?=$k?>][]" value="<?=$v[chk_txt][3]?>" style="width:35%;" />
					</div>
					<?php
						}else{
					?>
					<div class="question<?=$k?>" style="width: 100%; margin-bottom: 10px;">
						( <?=$q_num?> )번 문제 : 
						<input type="text" class="form-control" name="question[]" value="<?=$v[question]?>" style="width: 45%;" />
						<input type="hidden" name="qtype[]" value="s"/>
						<a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm" data-value="<?=$k?>">삭제</a>
					</div>
					<div  class="question<?=$k?>"  style="width: 100%; margin-bottom: 10px;">
						주관식 정답 : <input type="text" class="form-control" name="answer[<?=$k?>]" value="<?=$v[answer]?>" style="width: 35%;" />
					</div>
					<div class="question<?=$k?>"  style="width: 100%; margin-bottom: 10px;">
						정답시 멘트 : <input type="text" class="form-control" name="correct_txt[<?=$k?>]" value="<?=$v[correct_txt]?>" style="width: 35%;" />
					</div>
					<div class="question<?=$k?>"  style="width: 100%; margin-bottom: 10px;">
						오답시 멘트 : <input type="text" class="form-control" name="incorrect_txt[<?=$k?>]" value="<?=$v[incorrect_txt]?>" style="width: 35%;" />
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
-->
		
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<a class="btn btn-success btn-sm" href="javascript:save();">저장하기</a>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
	
$(document).ready(function () {	
	
	$('body').on('click', '.addUploadBtn1', function () {

		var uploadBoxCount = $('#uploadBox1').find('input[name="upfiles[]"]').length;
		if (uploadBoxCount >= 20) {
			alert("업로드는 최대 20개만 지원합니다");
			return;
		}

		var addUploadBox = '<div style="width: 100%; margin-bottom: 10px;"><input type="file" name="upfiles[]" class="add_file" style="display: inline-block" /><a class="btn btn-default minusUploadBtn1 btn-sm">삭제</a></div>';
		$('#uploadBox1').append(addUploadBox);
	});

	$('body').on('click', '.minusUploadBtn1', function () {
		index = $(this).prevAll('.add_file').attr('index'); //$('.file-upload button.uploadremove').index(target)+1;
		$("input[name='uploadFileNm[" + index + "]']").remove();
		$(this).closest('div').remove();
	});
	
	$('body').on('click', '.chg_video', function () {
		var pid = $("#video_search_txt").val();

        $.get('/admin/lms/process/get_video/'+encodeURIComponent(pid), function(data){

            $('#video_ul').html(data);
        });
	});
	
	$('body').on('click', '.chg_game', function () {
		var pid = $("#game_search_txt").val();

        $.get('/admin/lms/process/get_game/'+encodeURIComponent(pid), function(data){

            $('#game_ul').html(data);
        });
	});
	
	
	$('body').on('click', '.addUploadBtn', function () {

		var questionCount = $('.question').length;
		if (questionCount >= 20) {
			alert("문제는 최대 20개만 지원합니다");
			return;
		}
		if (questionCount == '') {
            var questionCount = 0;
        }
		var fieldNo = parseInt(questionCount) + 1;
		
		
		var q_type = $("#q_type option:selected").val();
		if(q_type == 'v'){ //주관식일때
			var cur_type = '영상';
			var cur_radio = $(":input:radio[name=video_choice]:checked").val();
			var cur_contents = '<input type="hidden" name="cur_type['+questionCount+']" value="v"/>'+$("#video_choice"+cur_radio).val();
		}else if(q_type == 'g'){ //게임
			var cur_type = '게임';
			var cur_radio = $(":input:radio[name=game_choice]:checked").val();
			var cur_contents = '<input type="hidden" name="cur_type['+questionCount+']" value="g"/>'+$("#game_choice"+cur_radio).val();	 
		
		}else{ //씨앗
			var cur_type = '씨앗';
			var cur_radio = $("#q_seed").val();
			var cur_contents = '<input type="hidden" name="cur_type['+questionCount+']" value="s"/><input type="hidden" name="cur_seed['+questionCount+']" value="'+cur_radio+'"/>'+cur_radio+'개 지급';	
		}
		var addUploadBox = '<tr id="question'+questionCount+'" class="question"><td><input type="number" class="form-control" name="cur_num['+questionCount+']" value="'+fieldNo+'" style="width:60px;" /><input type="hidden" class="form-control" name="cur_sno['+questionCount+']" value="'+cur_radio+'" style="width:60px;" /></td><td>'+cur_type+'</td><td>'+cur_contents+'</td><td><a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm" data-value="'+questionCount+'">삭제</a></td></tr>';
				 
		$('#tb_uploadBox').append(addUploadBox);
	});

	$('body').on('click', '.minusUploadBtn', function () {
		var index = $(this).data('value'); 
		$('#question'+index).remove();
	})	
});
	
    $(function() {
        $('#fadminwrite').validate({
            rules: {
                p_title: { required: true }
            }
        });

        $('#p_sdate').datepicker({format: "yyyy-mm-dd",language : "kr"});
        $('#p_edate').datepicker({format: "yyyy-mm-dd",language : "kr"});

//        $('#state').val('<?php echo set_value('state', element('state', element('data', $view))); ?>');
//        $('#plan_idx').val('<?php echo set_value('plan_idx', element('plan_idx', element('data', $view))); ?>');
//        $('#reg_company_idx').val('<?php echo set_value('reg_company_idx', element('reg_company_idx', element('data', $view))); ?>');
//
//        $("input:checkbox[id='required_flag']").prop('checked',<?php echo set_value('required_flag', element('required_flag', element('data', $view))); ?>);
//        $("input:checkbox[id='propose_flag']").prop('checked',<?php echo set_value('propose_flag', element('propose_flag', element('data', $view))); ?>);
    });

    function save()
    {
        oEditors.getById["p_desc"].exec("UPDATE_CONTENTS_FIELD", []);
		oEditors.getById["p_teacher"].exec("UPDATE_CONTENTS_FIELD", []);
        $('#fadminwrite').submit();
    }
	
	function curriculum_change(arg){
		$(".curriculums").css("display","none");
		$("#curriculum_"+arg).css("display","block");

	}
	
    function category_change()
    {
        var pid = $('#category_sel_1').val();

        $.get('/admin/lms/process/get_category_sub/'+pid, function(data){
            $('#category_sel_2').html(data);
        });
    }

    var category_no = "<?php echo set_value('category_no', element('category_no', element('data', $view))); ?>";
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

    var company_no = "<?php echo set_value('company_no', element('company_no', element('data', $view))); ?>";
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
	
	function p_viewYn1(arg) {
		if (arg === 's') {
			$(".seum_cal").css("display",'block'); 
		} else {
			$(".seum_cal").css("display",'none'); 
		}
	}
	<?php if(element('p_viewYn', element('data', $view))){?>
	var tp_type_arg = '<?=element('p_viewYn', element('data', $view))?>';
	<?php }else{?>
	var tp_type_arg = 'y';
	<?php }?>

	p_viewYn1(tp_type_arg);
	
	
</script>
