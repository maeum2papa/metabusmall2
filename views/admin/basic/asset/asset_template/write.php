<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite', 'onsubmit' => 'return submitContents(this)');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">템플릿번호(자동생성)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="tp_sno" value="<?php echo set_value('tp_sno', element('tp_sno', element('data', $view))); ?>" readonly/>
				</div>
			</div>
			<div class="form-group" id="tp_type1">
				<label class="col-sm-2 control-label">카테고리</label>
				<div class="col-sm-10">
                    <select class="form-control" name="cate_sno1"  style="width: 250px;">
						<?php
						foreach (element('category1', $view) as $v) {
						?>
						<option value="<?=$v[cate_sno]?>" <?php if(element('cate_sno', element('data', $view)) == $v[cate_sno]){?>selected<?php } ?>><?=$v[cate_kr]?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group" id="tp_type2">
				<label class="col-sm-2 control-label">카테고리</label>
				<div class="col-sm-10">
                    <select class="form-control" name="cate_sno2"  style="width: 250px;">
						<?php
						foreach (element('category2', $view) as $v) {
						?>
						<option value="<?=$v[cate_sno]?>" <?php if(element('cate_sno', element('data', $view)) == $v[cate_sno]){?>selected<?php } ?>><?=$v[cate_kr]?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">템플릿명</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="tp_nm" value="<?php echo set_value('tp_nm', element('tp_nm', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">한글 템플릿명</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="tp_nm_ko" value="<?php echo set_value('tp_nm_ko', element('tp_nm_ko', element('data', $view))); ?>"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">템플릿 노출</label>
				<div class="col-sm-10">
					<label for="showy" class="radio-inline">
						<input type="radio" name="template_showFl" value="y" id="showy">노출
					</label>
					<label for="shown" class="radio-inline">
						<input type="radio" name="template_showFl" value="n" id="shown" checked>미노출
					</label>
					<label for="shows" class="radio-inline">
						<input type="radio" name="template_showFl" value="s" id="shows">특정기업 노출
					</label>
					
					<select name="template_show_company" id="template_show_company">
						<option value="" selected disabled>목록</option>
						<?php foreach(element('com_list', $view) as $k => $v){ ?>
						<option value="<?php echo element('company_idx', $v);?>"><?php echo element('company_name', $v);?></option>
						<?php } ?>
					</select>
					<div id="selectedOptions"></div>
					<input type="hidden" name="selectedOptions" value="">
				</div>
			</div>			

			<div class="form-group">
				<label class="col-sm-2 control-label">종류</label>
				<div class="col-sm-10">
					<label class="radio-inline" for="tp_type_g">
						<input type="radio" name="tp_type" id="tp_type_g" value="g" checked <?php echo set_radio('tp_type', 'g', (element('tp_type', element('data', $view)) == 'g' ? true : false)); ?>  onclick="tp_type1('g')" /> 게임
					</label>
					<label class="radio-inline" for="tp_type_l">
						<input type="radio" name="tp_type" id="tp_type_l" value="l" <?php echo set_radio('tp_type', 'l', (element('tp_type', element('data', $view)) == 'l' ? true : false)); ?> onclick="tp_type1('l')" /> 랜드
					</label>
				</div>
			</div>

			<?php
			if (element('tp_type', element('data', $view)) == 'g') {
			?>
			<div class="form-group" id="tp_g_qcount">
				<label class="col-sm-2 control-label">문항 수</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="tp_g_qcount" value=<?php $tp_data = element('tp_data', element('data', $view)); $tp_data_json = json_decode($tp_data, true); echo count($tp_data_json["object"]["landetc_Quizbox"]["obj"]); ?>
					readonly />
				</div>
			</div>
			
			<?php
			}
			?>
			 
			</div>

			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">

let show_type = "<?php echo element('tp_show_type', element('data', $view));?>"
let radio_btn_show_type = document.getElementsByName("template_showFl");

let selectedValues = [];

$('#template_show_company option').attr('disabled', true);

if (show_type === "s") {
	radio_btn_show_type[2].setAttribute("checked", true);	
	$('#template_show_company option').attr('disabled', false);	
	let buttonHtml;
	
	<?php 
	 $com_list = explode(',', element('tp_show_company', element('data', $view)));
	 $com_map = element('com_list_map', $view);

	 foreach ($com_list as $k => $v) { 
	if (!empty($v)) { ?>
		selectedValues.push("<?php echo $v; ?>");
	<?php } ?>
	buttonHtml = '<button type="button" class="btn" data-value="' + <?php echo $v; ?> + '">' + "<?php echo $com_map[$v]; ?>" + ' X</button>';	
	$('#selectedOptions').append(buttonHtml);
	 
<?php } ?>

} else if (show_type === "y") {
	radio_btn_show_type[0].setAttribute("checked", true);
	$('#template_show_company option').attr('disabled', true);
} else if (show_type === "n") {
	radio_btn_show_type[1].setAttribute("checked", true);
	$('#template_show_company option').attr('disabled', true);
}

if ($('input[name="tp_sno"]').val() !== '') {
	$('input[name="tp_type"]')[0].setAttribute("onclick", "return false");
	$('input[name="tp_type"]')[1].setAttribute("onclick", "return false");
}


$(document).ready(function(){
	$('input[name="template_showFl"]').click(function(){
		if($(this).val() == 's'){
			$('#template_show_company option').attr('disabled', false);
		} else {
			$('#template_show_company option').attr('disabled', true);
		}
	});
});


$('#template_show_company').on('change', function(){
	$('#template_show_company option:selected').each(function(){
		if($(this).val() != ''){
			let selectedValue = $(this).val();
			let selectedText = $(this).text();
			if(selectedValues.indexOf(selectedValue) === -1) {
				selectedValues.push(selectedValue);
				let buttonHtml = '<button type="button" class="btn" data-value="' + selectedValue + '">' + selectedText + ' X</button>';
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


function submitContents(f){

	selectedValues = selectedValues.sort((a, b) => parseInt(a, 0) - parseInt(b, 0));

	$('input[name="selectedOptions"]').val(selectedValues);
	try {
			f.form.submit();
	} catch(e) {

	}
}

//<![CDATA[
function tp_type1(arg) {
	if (arg === 'g') {
		$("#tp_type1").css("display",'block'); 
		$("#tp_type2").css("display",'none'); 
		$("#tp_g_qcount").css("display",'block'); 

	} else {
		$("#tp_type2").css("display",'block'); 
		$("#tp_type1").css("display",'none'); 
		$("#tp_g_qcount").css("display",'none'); 
	}
}
<?php if(element('tp_type', element('data', $view))){?>
var tp_type_arg = '<?=element('tp_type', element('data', $view))?>';
<?php }else{?>
var tp_type_arg = 'g';
<?php }?>
//]]>
tp_type1(tp_type_arg);
</script>
