
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
					<input type="text" class="form-control" name="g_sno" value="<?php echo set_value('g_sno', element('g_sno', element('data', $view))); ?>" readonly/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">템플릿선택</label>
				<div class="col-sm-10">
                    <select class="form-control" id="tp_sno" name="tp_sno"  style="width: 250px;" onchange="handleChange(this)">
						<?php
						foreach (element('template', $view) as $v) {
						?>
						<option value="<?=$v[tp_sno]?>" qcount="<?=$v[tp_qcount]?>" <?php if(element('tp_sno', element('data', $view)) == $v[tp_sno]){?>selected<?php } ?>><?=!empty($v[tp_nm_ko])?$v[tp_nm_ko]:$v[tp_nm]?></option>
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
				<div class="col-sm-10"  id="uploadBox">
					<div style="width: 100%; margin-bottom: 10px;">
						<select class="form-control" id="q_type" name="q_type"  style="width: 150px;">
							<option value="o" selected>객관식</option>
							<option value="s">주관식</option>
						</select>
						<a class="btn btn-white btn-icon-plus addUploadBtn btn-sm">추가</a>
					</div>
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
		
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
	
	function handleChange(selectElement) {
        let currentLength = document.querySelectorAll("[class^='question']").length;
		let qcount = parseInt(selectElement[selectElement.selectedIndex].getAttribute("qcount"));
		qcount = isNaN(qcount) ? 0 : qcount;

		if (qcount > currentLength) {
			let diff = qcount - currentLength;			

			for (let i = 0; i < diff; ++i) {
				let questionCount = $('#uploadBox').find('input[name="question[]"]').length;
				let fieldNo = parseInt(questionCount) + 1;
				let addUploadBox = '<div class="question'+questionCount+'"  style="width: 100%; margin-bottom: 10px;">( '+fieldNo+' )번 문제 : <input type="text" class="form-control" name="question[]" value="" style="width: 45%;" /><input type="hidden" name="qtype[]" value="o"/><a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm"  data-value="'+questionCount+'">삭제</a></div><div class="col-sm-10 form-inline  question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">1 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="1" checked  /> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div><div class="col-sm-10 form-inline question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">2 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="2"/> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div><div class="col-sm-10 form-inline question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">3 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="3"/> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div><div class="col-sm-10 form-inline question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">4 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="4"/> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div>';
				$('#uploadBox').append(addUploadBox);
			}
		}
	}

$(document).ready(function () {	

	$('body').on('click', '.addUploadBtn', function () {

		var questionCount = $('#uploadBox').find('input[name="question[]"]').length;
		if (questionCount >= 20) {
			alert("문제는 최대 20개만 지원합니다");
			return;
		}
		if (questionCount == '') {
            var questionCount = 0;
        }
		var fieldNo = parseInt(questionCount) + 1;
		
		
		var q_type = $("#q_type option:selected").val();
		if(q_type == 's'){ //주관식일때
		   var addUploadBox = '<div class="question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">( '+fieldNo+' )번 문제 : <input type="text" class="form-control" name="question[]" value="" style="width: 45%;" /><input type="hidden" name="qtype[]" value="s"/><a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm" data-value="'+questionCount+'">삭제</a></div><div  class="question'+questionCount+'"  style="width: 100%; margin-bottom: 10px;">주관식 정답 : <input type="text" class="form-control" name="answer['+questionCount+']" value="" style="width: 35%;" /></div><div class="question'+questionCount+'"  style="width: 100%; margin-bottom: 10px;">정답시 멘트 : <input type="text" class="form-control" name="correct_txt['+questionCount+']" value="" style="width: 35%;" /></div><div class="question'+questionCount+'"  style="width: 100%; margin-bottom: 10px;">오답시 멘트 : <input type="text" class="form-control" name="incorrect_txt['+questionCount+']" value="" style="width: 35%;" /></div>';
		}else{
		   var addUploadBox = '<div class="question'+questionCount+'"  style="width: 100%; margin-bottom: 10px;">( '+fieldNo+' )번 문제 : <input type="text" class="form-control" name="question[]" value="" style="width: 45%;" /><input type="hidden" name="qtype[]" value="o"/><a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm"  data-value="'+questionCount+'">삭제</a></div><div class="col-sm-10 form-inline  question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">1 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="1" checked  /> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div><div class="col-sm-10 form-inline question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">2 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="2"/> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div><div class="col-sm-10 form-inline question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">3 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="3"/> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div><div class="col-sm-10 form-inline question'+questionCount+'" style="width: 100%; margin-bottom: 10px;">4 번 보기 : <input type="text" class="form-control" name="answer_s['+questionCount+'][]" value="" style="width:15%;" /> <input type="radio" name="correctYn'+questionCount+'" value="4"/> 체크시 멘트 <input type="text" class="form-control" name="chk_s['+questionCount+'][]" value="" style="width:35%;" /></div>';
		}
		
		$('#uploadBox').append(addUploadBox);
	});

	$('body').on('click', '.minusUploadBtn', function () {
		var index = $(this).data('value'); 
		$('.question'+index).remove();
	})	
});
</script>
