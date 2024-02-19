<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		?>
		<ul class="list-group">
			<?php
			$data = element('data', $view);
			function asset_ca_list($p, $data, $len)
			{
				$return = '';
				$nextlen = $len + 1;
				if ($p && is_array($p)) {
					foreach ($p as $result) {
						//debug($result);
						if($result[cate_type] == 'tl'){
							$cate_type = '랜드템플릿';
							$tl_selected = 'selected';
						}else if($result[cate_type] == 'tg'){
							$cate_type = '게임템플릿';
							$tg_selected = 'selected';
						}else{
							$cate_type = '아이템';
							$item_selected = 'selected';
						}
						$margin = 20 * $len;
						$attributes = array('class' => 'form-inline', 'name' => 'fcategory');
						$return .= '<li class="list-group-item">
											<div class="form-horizontal">
												<div class="form-group" style="margin-bottom:0;">';
						if ($len) {
							$return .= '<div style="width:10px;float:left;margin-left:' . $margin . 'px;margin-right:10px;"><span class="fa fa-arrow-right"></span></div>';
						}
						$return .= '<div class="pl10">
							<div class="cat-cca-id-' . element('cate_sno', $result) . '">
								' . ' [' .html_escape($cate_type). '] ' . html_escape(element('cate_kr', $result)) . ' (' . html_escape(element('cate_order', $result)) . ')
								<button class="btn btn-primary btn-xs" onClick="cat_modify(\'' . element('cate_sno', $result) . '\')"><span class="glyphicon glyphicon-edit"></span></button>';
						if ( ! element(element('cate_sno', $result), $data)) {
							$return .= '					<button class="btn btn-danger btn-xs btn-one-delete" data-one-delete-url = "' . admin_url('asset/asset_category/delete/' . element('cate_sno', $result)) . '"><span class="glyphicon glyphicon-trash"></span></button>';
						}
						$return .= '	</div><div class="form-inline mod-cca-id-' . element('cate_sno', $result) . '" style="display:none;">';
						$return .= form_open(current_full_url(), $attributes);
						$return .= '<input type="hidden" name="cate_sno"	value="' . element('cate_sno', $result) . '" />
															<input type="hidden" name="type" value="modify" />
															<div class="form-group" style="margin-left:0;">
																<select name="cate_type" class="form-control">
																	<option value="tl" '.html_escape($tl_selected).'>랜드템플릿</option>
																	<option value="tg" '.html_escape($tg_selected).'>게임템플릿</option>
																	<option value="i"  '.html_escape($item_selected).'>아이템</option>
																</select>
																
																카테고리 영문 <input type="text" class="form-control" name="cate_value" value="' . html_escape(element('cate_value', $result)) . '" />
																카테고리 한글 <input type="text" class="form-control" name="cate_kr" value="' . html_escape(element('cate_kr', $result)) . '" />
																정렬순서 <input type="number" class="form-control" name="cate_order" value="' . html_escape(element('cate_order', $result)) . '"/>
																<button class="btn btn-primary btn-xs" type="submit" >저장</button>
																<a href="javascript:;" class="btn btn-default btn-xs" onClick="cat_cancel(\'' . element('cate_sno', $result) . '\')">취소</a>
															</div>';
						$return .= form_close();
						$return .= '</div>
													</div>
													</div>
												</div>
											</li>';
						$parent = element('cate_sno', $result);
						$return .= asset_ca_list(element($parent, $data), $data, $nextlen);
					}
				}
				return $return;
			}
			echo asset_ca_list(element(0, $data), $data, 0);
			?>
		</ul>
	<div>
		<div class="box-table">
			<?php
			$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
			echo form_open(current_full_url(), $attributes);
			?>
				<input type="hidden" name="is_submit" value="1" />
				<input type="hidden" name="type" value="add" />
				<div class="form-group">
					<label class="col-sm-2 control-label">카테고리 추가</label>
					<div class="col-sm-8 form-inline">
						<select name="cate_parent" class="form-control">
							<option value="0">최상위카테고리</option>
							<?php
							$data = element('data', $view);
							function asset_ca_select($p, $data)
							{
								$return = '';
								if ($p && is_array($p)) {
									foreach ($p as $result) {
										$return .= '<option value="' . html_escape(element('cate_sno', $result)) . '">' . html_escape(element('cate_kr', $result)) . '의 하위카테고리</option>';
										$parent = element('cate_sno', $result);
										$return .= asset_ca_select(element($parent, $data), $data);
									}
								}
								return $return;
							}
							echo asset_ca_select(element(0, $data), $data);
							?>
						</select>
						<select name="cate_type" class="form-control">
							<option value="tl">랜드템플릿</option>
							<option value="tg">게임템플릿</option>
							<option value="i">아이템</option>
						</select>
						<input type="text" name="cate_value" class="form-control" value="" placeholder="카테고리명 영문" />
						<input type="text" name="cate_kr" class="form-control" value="" placeholder="카테고리명 한글" />
						<input type="number" name="cate_order" class="form-control" value="0" placeholder="정렬순서" />
						<button type="submit" class="btn btn-success btn-sm">추가하기</button>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite', 'input[name=fcategory]').validate({
		rules: {
			cate_value: {required :true},
			cate_order: {required :true, numeric:true},
		}
	});
});

function cat_modify(cate_sno) {
	$('.cat-cca-id-' + cate_sno).hide();
	$('.mod-cca-id-' + cate_sno).show();
}
function cat_cancel(cate_sno) {
	$('.cat-cca-id-' + cate_sno).show();
	$('.mod-cca-id-' + cate_sno).hide();
}
//]]>
</script>
