<?php $custom_config = config_item("custom"); ?>
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />

			<div class="box-table-header">
				<h4><a data-toggle="collapse" href="#cmalltab2" aria-expanded="true" aria-controls="cmalltab2">템플릿정보</a></h4>
				<a data-toggle="collapse" href="#cmalltab2" aria-expanded="true" aria-controls="cmalltab2"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
            <div class="collapse in" id="cmalltab2">
				<div class="form-group">
					<label class="col-sm-2 control-label">템플릿상품명</label>
					<div class="col-sm-10 form-inline">
						<input type="text" class="form-control" name="citt_name" value="<?php echo set_value('citt_name', element('citt_name', element('data', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">템플릿상품설명</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="citt_summary" id="citt_summary" rows="1"><?php echo set_value('citt_summary', element('citt_summary', element('data', $view))); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">예치금차감금액</label>
					<div class="col-sm-10 form-inline">
						<input type="number" class="form-control" name="citt_deposit" value="<?php echo set_value('citt_deposit', element('citt_deposit', element('data', $view))); ?>" min="100"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">배송방법</label>
					<div class="col-sm-10 form-inline">
                        <label class="radio-inline" for="citt_ship_type_1">
							<input type="radio" name="citt_ship_type" id="citt_ship_type_1" value="1" checked <?php echo set_radio('citt_ship_type', '1', (element('citt_ship_type', element('data', $view)) == 1 ? true : false)); ?>  /> 컬래버랜드배송
						</label>
						<label class="radio-inline" for="citt_ship_type_2">
							<input type="radio" name="citt_ship_type" id="citt_ship_type_2" value="2" <?php echo set_radio('citt_ship_type', '2', (element('citt_ship_type', element('data', $view)) == 2 ? true : false)); ?>  /> 기프티콘발송
						</label>
                        <label class="radio-inline" for="citt_ship_type_3">
							<input type="radio" name="citt_ship_type" id="citt_ship_type_3" value="3" <?php echo set_radio('citt_ship_type', '3', (element('citt_ship_type', element('data', $view)) == 3 ? true : false)); ?> /> 업체배송
						</label>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-2 control-label">노출여부</label>
					<div class="col-sm-10 form-inline">
                        <label for="citt_status" class="checkbox-inline">
							<input type="checkbox" name="citt_status" id="citt_status" value="1" <?php echo set_checkbox('citt_status', '1', (element('citt_status', element('data', $view)) ? true : false)); ?> /> 노출
						</label>
					</div>
				</div>
			</div>


            <div class="box-table-header">
				<h4><a data-toggle="collapse" href="#cmalltab6" aria-expanded="true" aria-controls="cmalltab6">이미지</a></h4>
				<a data-toggle="collapse" href="#cmalltab6" aria-expanded="true" aria-controls="cmalltab6"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
            <div class="collapse in" id="cmalltab6">
			<?php for ($k = 1; $k<= 10; $k++) { ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">이미지 <?php echo $k; ?></label>
					<div class="col-sm-10 form-inline">
					<?php
					if (element('citt_file_' . $k, element('data', $view))) {
					?>
						<img src="<?php echo thumb_url('cmallitemtemplate', element('citt_file_' . $k, element('data', $view)), 80)?>" width="80px" alt="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" title="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" />
						<label for="citt_file_<?php echo $k; ?>_del">
							<input type="checkbox" name="citt_file_<?php echo $k; ?>_del" id="citt_file_<?php echo $k; ?>_del" value="1" <?php echo set_checkbox('citt_file_' . $k . '_del', '1'); ?> /> 삭제
						</label>
						<input type="hidden" name="citt_file_<?php echo $k; ?>" value="<?php echo element('citt_file_' . $k, element('data', $view))?>"/>
					<?php
					}
					?>
						<input type="file" name="citt_file_<?php echo $k; ?>_upload" id="citt_file_<?php echo $k; ?>_upload"/>
					</div>
				</div>
			<?php } ?>
			</div>


            <div class="box-table-header">
				<h4><a data-toggle="collapse" href="#cmalltab4" aria-expanded="true" aria-controls="cmalltab4">상품내용</a></h4>
				<a data-toggle="collapse" href="#cmalltab4" aria-expanded="true" aria-controls="cmalltab4"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
			<div class="collapse in" id="cmalltab4">
				<div class="form-group">
					<label class="col-sm-2 control-label">내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('citt_content', set_value('citt_content', element('citt_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">모바일내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('citt_mobile_content', set_value('citt_mobile_content', element('citt_mobile_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
						
                        <div class="help-inline">모바일 내용이 일반웹페이지 내용과 다를 경우에 입력합니다. 같은 경우는 입력하지 않으셔도 됩니다</div>
					</div>
				</div>
			</div>


			<div class="btn-group pull-right mt10" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >목록으로</button>
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	$('#fadminwrite').validate({
		rules: {
			citt_name: 'required',
			citt_deposit: { required:true, number:true },
			citt_content : {<?php echo ($this->cbconfig->item('use_cmall_product_dhtml')) ? 'required_' . $this->cbconfig->item('cmall_product_editor_type') : 'required'; ?> : true },
			// citt_mobile_content : {<?php echo ($this->cbconfig->item('use_cmall_product_dhtml')) ? 'required_' . $this->cbconfig->item('cmall_product_editor_type') : 'required'; ?> : true }
		},
		submitHandler: function (form) {

			if(!oEditors.getById["citt_mobile_content"].getContents() || oEditors.getById["citt_mobile_content"].getContents() == "<p><br></p>"){
				document.querySelector("#citt_mobile_content").value = "";
			}else{
				document.querySelector("#citt_mobile_content").value = oEditors.getById["citt_mobile_content"].getContents();
			}

			form.submit();
		},
	});
});
</script>