<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">부서번호(자동생성)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="seum_sno" value="<?php echo set_value('seum_sno', element('seum_sno', element('data', $view))); ?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">부서명</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="seum_departmentNm" value="<?php echo set_value('seum_departmentNm', element('seum_departmentNm', element('data', $view))); ?>" />
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">사용여부</label>
				<div class="col-sm-10">
                    <select name="seum_yn" id="seum_yn" class="form-control" >
						<option value="y" <?=element('seum_yn', element('data', $view)) == 'y' ? 'selected': ''?>>사용함</option>
						<option value="n" <?=element('seum_yn', element('data', $view)) == 'n' ? 'selected': ''?>>사용안함</option>
					</select>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">순서</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="seum_sort" value="<?php echo set_value('seum_sort', element('seum_sort', element('data', $view))); ?>" />
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
$(function() {
	$('#fadminwrite').validate({
		rules: {
			doc_key: {required:true, minlength:3, maxlength:50, alpha_dash : true},
			doc_title: 'required',
			doc_content : {<?php echo ($this->cbconfig->item('use_document_dhtml')) ? 'required_' . $this->cbconfig->item('document_editor_type') : 'required'; ?> : true },
			doc_mobile_content : {<?php echo ($this->cbconfig->item('use_document_dhtml')) ? 'valid_' . $this->cbconfig->item('document_editor_type') : ''; ?> : true }
		}
	});
});
//]]>
</script>
