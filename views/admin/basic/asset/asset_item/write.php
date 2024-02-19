
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
				<label class="col-sm-2 control-label">템플릿번호(자동생성)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="item_sno" value="<?php echo set_value('item_sno', element('item_sno', element('data', $view))); ?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">종류</label>
				<div class="col-sm-10">
                    <select class="form-control" name="item_type"  style="width: 150px;" onchange="category_change(this.value)" >
						<option value="a" <?php if(element('item_type', element('data', $view)) == 'a'){?>selected<?php } ?>>아바타</option>
						<option value="l" <?php if(element('item_type', element('data', $view)) == 'l'){?>selected<?php } ?>>랜드</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">카테고리</label>
				<div class="col-sm-10">
                    <select class="form-control" id="cate_sno" name="cate_sno"  style="width: 150px;">
						<?php
						foreach (element('category', $view) as $v) {
						?>
						<option value="<?=$v[cate_sno]?>" <?php if(element('cate_sno', element('data', $view)) == $v[cate_sno]){?>selected<?php } ?>><?=$v[cate_kr]?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">아이템명(영문)</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="item_nm" value="<?php echo set_value('item_nm', element('item_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">아이템명(한글)</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="item_kr" value="<?php echo set_value('item_kr', element('item_kr', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">인벤썸네일</label>
				<div class="col-sm-10">
					<?php
					if(element('item_img_th', element('data', $view)))
						echo "<img src='".element('item_img_th', element('data', $view))."' style='width:100px;height:auto;'/>";
					?>
					<input type="file" name="item_img_th_file" id="item_img_th_file" />
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group ga_div">
				<label class="col-sm-2 control-label">인게임적용이미지</label>
				<div class="col-sm-10">
					<?php
					if(element('item_img_in', element('data', $view)))
						echo "<img src='".element('item_img_in', element('data', $view))."' style='width:100px;height:auto;'/>";
					?>
					<input type="file" name="item_img_in_file" id="item_img_in_file"  style="display: inline-block"  />
					<input type="text" class="form-control" name="item_img_in_txt" value="<?=element('item_img_in_txt', element('data', $view))?>" style="width: 25%;" />
				</div>
			</div>
			<div class="form-group ga_div" >
				<label class="col-sm-2 control-label">인벤착용샷</label>
				<div class="col-sm-10">
					<?php
					if(element('item_img_ch', element('data', $view)))
						echo "<img src='".element('item_img_ch', element('data', $view))."' style='width:100px;height:auto;'/>";
					?>
					<input type="file" name="item_img_ch_file" id="item_img_ch_file" />
				</div>
			</div>
			<div class="form-group gl_div">
				<label class="col-sm-2 control-label">인게임적용이미지</label>
				<div class="col-sm-10"  id="uploadBox">
					<div style="width: 100%; margin-bottom: 10px;">
						<img src='<?=element('img', element('img_in_first', $view))?>' style='width:100px;height:auto;'/>
						<input type="file" name="upfiles[]" style="display: inline-block" />

						<input type="text" class="form-control" name="upfiles_text[]" value="<?=element('txt', element('img_in_first', $view))?>" style="width: 25%;" />
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

						<input type="text" class="form-control" name="upfiles_text[]" value="<?=$v[txt]?>" style="width: 25%;" />
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
				<label class="col-sm-2 control-label">인벤기본노출여부</label>
				<div class="col-sm-10">
					<label class="radio-inline" for="item_basicYn_n">
						<input type="radio" name="item_basicYn" id="item_basicYn_n" value="n" checked <?php echo set_radio('item_basicYn', 'n', (element('item_basicYn', element('data', $view)) == 'n' ? true : false)); ?> /> 노출안함
					</label>
					<label class="radio-inline" for="item_basicYn_y">
						<input type="radio" name="item_basicYn" id="item_basicYn_y" value="y" <?php echo set_radio('item_basicYn', 'y', (element('item_basicYn', element('data', $view)) == 'y' ? true : false)); ?> /> 기본노출
					</label>
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
//<![CDATA[
//$(function() {
//	$('#fadminwrite').validate({
//		rules: {
//			doc_key: {required:true, minlength:3, maxlength:50, alpha_dash : true},
//			doc_title: 'required',
//			doc_content : {<?php echo ($this->cbconfig->item('use_document_dhtml')) ? 'required_' . $this->cbconfig->item('document_editor_type') : 'required'; ?> : true },
//			doc_mobile_content : {<?php echo ($this->cbconfig->item('use_document_dhtml')) ? 'valid_' . $this->cbconfig->item('document_editor_type') : ''; ?> : true }
//		}
//	});
//});
//]]>
function category_change(arg)
{
	
	$.get('/admin/asset/asset_item/category?val='+arg, function(data){
		$('#cate_sno').html(data);
	});
	
	if(arg == 'a'){
		$('.ga_div').css("display","block");
		$('.gl_div').css("display","none");
	}else{
		$('.gl_div').css("display","block");
		$('.ga_div').css("display","none");
	}
	
}
	
	
$(document).ready(function () {	
	<?php
	if(element('item_type', element('data', $view)) == 'l' ){
	?>
	$('.gl_div').css("display","block");
	$('.ga_div').css("display","none");
	<?php
	}else{
	?>
	$('.ga_div').css("display","block");
	$('.gl_div').css("display","none");
	<?php	
	}
	?>
	$('body').on('click', '.addUploadBtn', function () {

		var uploadBoxCount = $('#uploadBox').find('input[name="upfiles[]"]').length;
		if (uploadBoxCount >= 20) {
			alert("업로드는 최대 20개만 지원합니다");
			return;
		}

		var addUploadBox = '<div style="width: 100%; margin-bottom: 10px;"><input type="file" name="upfiles[]" style="display: inline-block" /><input type="text" class="form-control" name="upfiles_text[]" value="" style="width: 25%;" /><a class="btn btn-white btn-icon-minus minusUploadBtn btn-sm">삭제</a></div>';
		$('#uploadBox').append(addUploadBox);
	});

	$('body').on('click', '.minusUploadBtn', function () {
		index = $(this).prevAll('input:file').attr('index'); //$('.file-upload button.uploadremove').index(target)+1;
		$("input[name='uploadFileNm[" + index + "]']").remove();
		$(this).closest('div').remove();
	})	
});
</script>
