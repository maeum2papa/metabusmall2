
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
				<label class="col-sm-2 control-label">동영상번호(자동생성)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="video_idx" value="<?=element('video_idx', element('data', $view))?>" readonly/>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label">동영상이름</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="video_name" value="<?=element('video_name', element('data', $view))?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">파일명(확장자포함)</label>
				<div class="col-sm-10 form-inline " >
					https://v.collaborland.kr:8443/
                    <input type="text" class="form-control" name="video_url" value="<?=element('video_url', element('data', $view))?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">영상설명(확인용)</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" name="video_desc" value="<?=element('video_desc', element('data', $view))?>" />
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
	
$(document).ready(function () {	

	
});
</script>
