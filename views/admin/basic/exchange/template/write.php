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
			<div class="box-table-header">
				<h4><a data-toggle="collapse" href="#cmalltab2" aria-expanded="true" aria-controls="cmalltab2">템플릿정보</a></h4>
				<a data-toggle="collapse" href="#cmalltab2" aria-expanded="true" aria-controls="cmalltab2"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
            <div class="collapse in" id="cmalltab2">
				<div class="form-group">
					<label class="col-sm-2 control-label">템플릿상품명</label>
					<div class="col-sm-10 form-inline">
						<input type="text" class="form-control" name="cit_key" value="<?php echo set_value('cit_key', element('cit_key', element('data', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">템플릿상품설명</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="cit_summary" id="cit_summary" rows="1"><?php echo set_value('cit_summary', element('cit_summary', element('data', $view))); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">예치금차감금액</label>
					<div class="col-sm-10 form-inline">
						<input type="number" class="form-control" name="cit_order" value="<?php echo set_value('cit_order', element('cit_order', element('data', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">배송방법</label>
					<div class="col-sm-10 form-inline">
                        <label class="radio-inline" for="cit_view_type_n">
							<input type="radio" name="cit_view_type" id="cit_view_type_n" value="n" checked <?php echo set_radio('cit_view_type', 'n', (element('cit_view_type', element('data', $view)) == 'n' ? true : false)); ?> onclick="view_type('n')" /> 컬래버랜드배송
						</label>
						<label class="radio-inline" for="cit_view_type_s">
							<input type="radio" name="cit_view_type" id="cit_view_type_s" value="s" <?php echo set_radio('cit_view_type', 's', (element('cit_view_type', element('data', $view)) == 's' ? true : false)); ?> onclick="view_type('s')" /> 기프티콘발송
						</label>
                        <label class="radio-inline" for="cit_view_type_s">
							<input type="radio" name="cit_view_type" id="cit_view_type_s" value="s" <?php echo set_radio('cit_view_type', 's', (element('cit_view_type', element('data', $view)) == 's' ? true : false)); ?> onclick="view_type('s')" /> 업체배송
						</label>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-2 control-label">노출여부</label>
					<div class="col-sm-10 form-inline">
                        <label for="cit_type1" class="checkbox-inline">
							<input type="checkbox" name="cit_type1" id="cit_type1" value="1" <?php echo set_checkbox('cit_type1', '1', (element('cit_type1', element('data', $view)) ? true : false)); ?> /> 노출
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
					if (element('cit_file_' . $k, element('data', $view))) {
					?>
						<img src="<?php echo thumb_url('cmallitem', element('cit_file_' . $k, element('data', $view)), 80); ?>" alt="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" title="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" />
						<label for="cit_file_<?php echo $k; ?>_del">
							<input type="checkbox" name="cit_file_<?php echo $k; ?>_del" id="cit_file_<?php echo $k; ?>_del" value="1" <?php echo set_checkbox('cit_file_' . $k . '_del', '1'); ?> /> 삭제
						</label>
					<?php
					}
					?>
						<input type="file" name="cit_file_<?php echo $k; ?>" id="cit_file_<?php echo $k; ?>" />
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
						<?php echo display_dhtml_editor('cit_content', set_value('cit_content', element('cit_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">모바일내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('cit_mobile_content', set_value('cit_mobile_content', element('cit_mobile_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
						
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

