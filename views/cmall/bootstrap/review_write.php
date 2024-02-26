<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div class="modal-header">

	<!-- asmo sh 231207 modal-title에 svg 추가 -->
	<h4 class="modal-title">
	<svg id="pencil_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
		<g id="사각형_4167" data-name="사각형 4167" fill="#222" stroke="#707070" stroke-width="1" opacity="0">
			<rect width="24" height="24" stroke="none"/>
			<rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
		</g>
		<g id="레이어_1" data-name="레이어 1" transform="translate(4.544 4.536)">
			<path id="패스_1230" data-name="패스 1230" d="M.183,16.5a1.678,1.678,0,0,1-1.23-.521,1.711,1.711,0,0,1-.461-1.282,1.286,1.286,0,0,1,.045-.279l.049-.2c.064-.261.131-.535.2-.808l.268-1.075q.3-1.2.6-2.391a1.957,1.957,0,0,1,.523-.928c3.9-3.9,7.1-7.1,10.05-10.059A1.434,1.434,0,0,1,11.259-1.5a1.436,1.436,0,0,1,1.036.453c1.187,1.2,2.411,2.421,3.743,3.745a1.4,1.4,0,0,1,0,2.061C12.6,8.192,9.174,11.62,5.983,14.813a1.955,1.955,0,0,1-.926.528l-2.41.6-2.022.5A1.84,1.84,0,0,1,.183,16.5Zm1.923-5.781q-.277,1.118-.558,2.239l-.162.649.64-.159,2.247-.558C7.188,9.969,10.3,6.859,13.43,3.728c-.751-.749-1.47-1.468-2.172-2.173C8.552,4.267,5.616,7.205,2.106,10.715Z" transform="translate(0 0)" fill="#222"/>
		</g>
	</svg>

		상품후기 작성
	</h4>
</div>
<div class="modal-body">
	<div class="form-horizontal ">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fwrite', 'id' => 'fwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="form-group">
				<label for="cre_title" class="col-sm-2 control-label">제목</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cre_title" id="cre_title" value="<?php echo set_value('cre_title', element('cre_title', element('data', $view))); ?>" placeholder="제목을 입력해주세요" />
				</div>
			</div>
			<div class="form-group mt20">
				<label for="cre_content" class="col-sm-2 control-label">내용</label>
				<div class="col-sm-10">
					<?php echo display_dhtml_editor('cre_content', set_value('cre_content', element('cre_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = $this->cbconfig->item('use_cmall_product_review_dhtml'), $editor_type = $this->cbconfig->item('cmall_product_review_editor_type')); ?>
				</div>
			</div>
			<div class="form-group mt20">
				<label for="cre_title" class="col-sm-2 control-label">평점</label>
				<div class="col-sm-10 review-score">

				<!-- asmo sh 240221 평점 이미지 변경 -->
					<label for="cre_score_5" class="col-xs-6 col-sm-4"><input type="radio" name="cre_score" id="cre_score_5" value="5" <?php echo set_radio('cre_score', '5', ((element('cre_score', element('data', $view)) === '5' OR ! element('cre_score', element('data', $view))) ? true : false)); ?> /> <img src="<?php echo element('view_skin_url', $layout); ?>/images/old_star5.png" alt="매우만족" title="매우만족" style="vertical-align:top;" /></label>
					<label for="cre_score_4" class="col-xs-6 col-sm-4"><input type="radio" name="cre_score" id="cre_score_4" value="4" <?php echo set_radio('cre_score', '4', (element('cre_score', element('data', $view)) === '4' ? true : false)); ?> /> <img src="<?php echo element('view_skin_url', $layout); ?>/images/old_star4.png" alt="만족" title="만족" style="vertical-align:top;" /></label>
					<label for="cre_score_3" class="col-xs-6 col-sm-4"><input type="radio" name="cre_score" id="cre_score_3" value="3" <?php echo set_radio('cre_score', '3', (element('cre_score', element('data', $view)) === '3' ? true : false)); ?> /> <img src="<?php echo element('view_skin_url', $layout); ?>/images/old_star3.png" alt="보통" title="보통" style="vertical-align:top;" /></label>
					<label for="cre_score_2" class="col-xs-6 col-sm-4"><input type="radio" name="cre_score" id="cre_score_2" value="2" <?php echo set_radio('cre_score', '2', (element('cre_score', element('data', $view)) === '2' ? true : false)); ?> /> <img src="<?php echo element('view_skin_url', $layout); ?>/images/old_star2.png" alt="불만" title="불만" style="vertical-align:top;" /></label>
					<label for="cre_score_1" class="col-xs-6 col-sm-4"><input type="radio" name="cre_score" id="cre_score_1" value="1" <?php echo set_radio('cre_score', '1', (element('cre_score', element('data', $view)) === '1' ? true : false)); ?> /> <img src="<?php echo element('view_skin_url', $layout); ?>/images/old_star1.png" alt="매우불만" title="매우불만" style="vertical-align:top;" /></label>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="pull-right">

				<!-- asmo sh 231207 디자인 상 두 버튼 자리 바꿈 -->
					<button type="submit" class="btn btn-primary">작성완료</button>
					<a href="javascript:;" class="btn btn-default" onClick="window.close();">취소</a>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fwrite').validate({
		rules: {
			cre_title : { required:true},
			cre_content : {<?php echo ($this->cbconfig->item('use_cmall_product_review_dhtml')) ? 'required_' . $this->cbconfig->item('cmall_product_review_editor_type') : 'required'; ?> : true }
		}
	});
});
//]]>
</script>
