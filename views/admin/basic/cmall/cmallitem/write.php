<style>
	#item-selector .item-selector-header{display: flex; justify-content:space-between;}
	#select_item_list.is-avata tr.item_type_a{display: table-tr;}
	#select_item_list.is-avata tr.item_type_l{display: none;}
	#select_item_list.is-land tr.item_type_l{display: table-tr;}
	#select_item_list.is-land tr.item_type_a{display: none;}
	#item-selector.dn{display:none;}
	#template-selecter.dn{display:none;}
	#citt_deposit_viewer.dn{display:none;}
	.citt_id_viewer{line-height:30px;}
</style>
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
				<h4><a data-toggle="collapse" href="#cmalltab0" aria-expanded="true" aria-controls="cmalltab0">
						<?php if($this->session->userdata['mem_admin_flag']==0){?>
							상품구분
						<?php }else{ ?>
							상품선택
						<?php } ?>
				</a></h4>
				<a data-toggle="collapse" href="#cmalltab0" aria-expanded="true" aria-controls="cmalltab0"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
			<div class="collapse in" id="cmalltab0">
				<div class="form-group">
					<label class="col-sm-2 control-label">
						<?php if($this->session->userdata['mem_admin_flag']==0){?>
							상품구분
						<?php }else{ ?>
							상품선택
						<?php } ?>
					</label>
					<div class="col-sm-10">
						<?php if($this->session->userdata['mem_admin_flag']==0){?>
							<input type="hidden" name="cit_item_type" value="i">
							<label class="inline-label">
								<input type="radio" checked disabled>
								아이템
							</label>
						<?php }else{ ?>
							<input type="hidden" name="cit_item_type" value="b"/>
							<?php if(!element("cit_id", element('data',$view))){ ?>
								<label class="inline-label">
									<input type="radio" name="citt_id_use" value="1" checked>
									템플릿상품
								</label>
								<label class="inline-label">
									<input type="radio" name="citt_id_use" value="0">
									자체상품
								</label>
							<?php }else{ ?>
								<!-- 비주얼적으로 보여주기 위한 영역 -->
								<input type="hidden" name="citt_id_use" value="<?php echo (element('citt_id',element('data',$view)))?"1":"0";?>"/>
								<label class="inline-label">
									<input type="radio" disabled <?php echo (element('citt_id',element('data',$view)))?"checked":"";?>>
									템플릿상품
								</label>
								<label class="inline-label">
									<input type="radio" disabled <?php echo (!element('citt_id',element('data',$view)))?"checked":"";?>>
									자체상품
								</label>
							<?php } ?>
							
						<?php } ?>
						<script type="text/javascript">
						//<![CDATA[
						function display_cmall_category2(check, idname) {
							if (check === true) {
								$('#' + idname).show();
							} else {
								$('#' + idname).hide();
								$('#' + idname).find('input:checkbox').attr('checked', false);
							}
						}
						//]]>
						</script>
					</div>
				</div>
				<?php if($this->session->userdata['mem_admin_flag']==0){?>
				<?php }else{ ?>
					<div class="form-group" id="template-selecter">
						<label class="col-sm-2 control-label">
							<?php if(!element("cit_id", element('data',$view))){ ?>
								템플릿선택
							<?php }else{ ?>
								템플릿번호
							<?php } ?>
						</label>
						<div class="col-sm-10">
							<?php if(!element("cit_id", element('data',$view))){ ?>
								<button type="button" class="btn btn-default btn-sm btn-template-selector" >선택</button>
							<?php } ?>
							<input type="hidden" name="citt_id" value="<?php echo element('citt_id', element('data', $view));?>">
							<span class="citt_id_viewer"><?php echo element('citt_id', element('data', $view));?></span>
						</div>
					</div>
				<?php } ?>
			</div>


			<?php if($this->session->userdata['mem_admin_flag']==0){?>
				<input type="hidden" name="cmall_category[]" value="6">
			<?php }else{ ?>
				<input type="hidden" name="cmall_category[]" value="2">
			<?php } ?>
			
			
			<div class="box-table-header">
				<h4><a data-toggle="collapse" href="#cmalltab2" aria-expanded="true" aria-controls="cmalltab2">기본정보</a></h4>
				<a data-toggle="collapse" href="#cmalltab2" aria-expanded="true" aria-controls="cmalltab2"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
			<div class="collapse in" id="cmalltab2">
				<div class="form-group">
					<label class="col-sm-2 control-label">상품페이지주소</label>
					<div class="col-sm-10 form-inline">
					<?php 
					echo cmall_item_url();
					if($this->session->userdata['mem_admin_flag']==0){?>
						<input type="text" class="form-control" name="cit_key" value="<?php echo set_value('cit_key', element('cit_key', element('data', $view))); ?>" />
					<?php }else{ ?>
						<input type="text" class="form-control" name="cit_key" value="<?php echo set_value('cit_key', element('cit_key', element('data', $view))); ?>" readonly/> 
					<?php } ?>
					페이지주소를 입력해주세요
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">상품명</label>
					<div class="col-sm-10 form-inline">
						<input type="text" class="form-control" name="cit_name" value="<?php echo set_value('cit_name', element('cit_name', element('data', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">정렬순서</label>
					<div class="col-sm-10 form-inline">
						<input type="number" class="form-control" name="cit_order" value="<?php echo set_value('cit_order', element('cit_order', element('data', $view))); ?>" />
						<div class="help-inline">정렬순서가 낮은 상품이 먼저 나옵니다</div>
					</div>
				</div>
				<input type="hidden" name="item_layout" value="">
				<input type="hidden" name="item_sidebar" value="">
				<input type="hidden" name="item_skin" value="">
				
				<input type="hidden" name="item_mobile_layout" value="">
				<input type="hidden" name="item_mobile_sidebar" value="">
				<input type="hidden" name="item_mobile_skin" value="">
			</div>
			<div class="box-table-header">
				<h4><a data-toggle="collapse" href="#cmalltab3" aria-expanded="true" aria-controls="cmalltab3">세부정보</a></h4>
				<a data-toggle="collapse" href="#cmalltab3" aria-expanded="true" aria-controls="cmalltab3"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
			<div class="collapse in" id="cmalltab3">
				<?php if($this->session->userdata['mem_admin_flag']==0){?>
					<input type="hidden" name="cit_money_type" value="f">
				<?php }else{ ?>
					<input type="hidden" name="cit_money_type" value="c">
				<?php } ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">
						<?php if($this->session->userdata['mem_admin_flag']==0){?>
							교환 열매
						<?php }else{ ?>
							교환 포인트
						<?php } ?>
					</label>
					<div class="col-sm-10 form-inline">
						<input type="number" class="form-control" name="cit_price" value="<?php echo set_value('cit_price', element('cit_price', element('data', $view))); ?>" <?php echo ($this->session->userdata['mem_admin_flag']==0)?"":"readonly";?>/>
						<span id="seum_money_txt">
							개
						</span>
						
						<span class="help-inline">
							<input type="hidden" name="citt_deposit" value="<?php echo element('citt_deposit',element('data',$view));?>">
							<div id="citt_deposit_viewer" class="<?php echo (element('citt_deposit',element('data',$view)) > 0)?"":"dn"; ?>">
								예치금차감금액 : <span id="citt_deposit" ><?php echo "-".number_format(element('citt_deposit',element('data',$view)));?></span>
							</div>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">요약설명</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="cit_summary" id="cit_summary" rows="1"><?php echo set_value('cit_summary', element('cit_summary', element('data', $view))); ?></textarea>
					</div>
				</div>
				<div class="form-group" style="display: none">
					<label class="col-sm-2 control-label">기본정보</label>
					<div class="col-sm-10">
						<?php for ($k= 1; $k<= 10; $k++) { ?>
							<div class="form-group form-inline">
								기본정보 <?php echo $k; ?> 제목 <input type="text" class="form-control" name="info_title_<?php echo $k; ?>" value="<?php echo set_value('info_title_' . $k, element('info_title_' . $k, element('data', $view))); ?>" />
								기본정보 <?php echo $k; ?> 값 <input type="text" class="form-control" name="info_content_<?php echo $k; ?>" value="<?php echo set_value('info_content_' . $k, element('info_content_' . $k, element('data', $view))); ?>" />
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group" style="display: none">
					<label class="col-sm-2 control-label">사용자데모</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="demo_user_link" value="<?php echo set_value('demo_user_link', element('demo_user_link', element('data', $view))); ?>" />
					</div>
				</div>
				<div class="form-group" style="display: none">
					<label class="col-sm-2 control-label">관리자데모</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="demo_admin_link" value="<?php echo set_value('demo_admin_link', element('demo_admin_link', element('data', $view))); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">상품유형</label>
					<div class="col-sm-10">
						<label for="cit_type1" class="checkbox-inline">
							<input type="checkbox" name="cit_type1" id="cit_type1" value="1" <?php echo set_checkbox('cit_type1', '1', (element('cit_type1', element('data', $view)) ? true : false)); ?> /> 추천
						</label>
						<label for="cit_type2" class="checkbox-inline">
							<input type="checkbox" name="cit_type2" id="cit_type2" value="1" <?php echo set_checkbox('cit_type2', '1', (element('cit_type2', element('data', $view)) ? true : false)); ?> /> 인기
						</label>
						<label for="cit_type3" class="checkbox-inline">
							<input type="checkbox" name="cit_type3" id="cit_type3" value="1" <?php echo set_checkbox('cit_type3', '1', (element('cit_type3', element('data', $view)) ? true : false)); ?> /> 신상품
						</label>
						<label for="cit_type4" class="checkbox-inline">
							<input type="checkbox" name="cit_type4" id="cit_type4" value="1" <?php echo set_checkbox('cit_type4', '1', (element('cit_type4', element('data', $view)) ? true : false)); ?> /> 할인
						</label>
						<div class="help-inline" >체크하시면, 메인페이지에 각 카테고리에 출력됩니다</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">교환여부</label>
					<div class="col-sm-10">
						<label for="cit_status" class="checkbox-inline">
							<input type="checkbox" name="cit_status" id="cit_status" value="1" <?php echo set_checkbox('cit_status', '1', (element('cit_status', element('data', $view)) ? true : false)); ?> /> 교환합니다
						</label>
						<div class="help-inline" >체크를 해제하시면 상품리스트에서 사라지며, 교환할 수 없습니다.​</div>
					</div>
				</div>

				<?php if($this->session->userdata['mem_admin_flag']==0){?>
					
				<?php }else{ ?>
					<div class="form-group">
						<label class="col-sm-2 control-label">1회 교환제한​</label>
						<div class="col-sm-10">
							<label for="cit_one_sale" class="checkbox-inline">
								<input type="checkbox" name="cit_one_sale" id="cit_one_sale" value="y" <?php echo ($view['data']['cit_one_sale']=="y")?"checked":""; ?> /> 사용
							</label>
							<div class="help-inline" >직원당 해당 상품을 한번만 교환할 수 있습니다.​</div>
						</div>
					</div>
				<?php } ?>
				
				
				<?php if($this->session->userdata['mem_admin_flag']==0){?>

					<input type="hidden" name="cit_stock_type" value="i"/>
					<input type="hidden" name="cit_stock_cnt" value="0" />


				<?php }else{ ?>

					<div class="form-group">
						<label class="col-sm-2 control-label">한정수량</label>
						<div class="col-sm-10 form-inline">
							<label class="radio-inline" for="cit_stock_type_i">
								<input type="radio" name="cit_stock_type" id="cit_stock_type_i" value="i" checked <?php echo set_radio('cit_stock_type', 'i', (element('cit_stock_type', element('data', $view)) == 'i' ? true : false)); ?> onclick="stock_type('i')" /> 무제한 판매
							</label>
							<label class="radio-inline" for="cit_stock_type_s">
								<input type="radio" name="cit_stock_type" id="cit_stock_type_s" value="s" <?php echo set_radio('cit_stock_type', 's', (element('cit_stock_type', element('data', $view)) == 's' ? true : false)); ?> onclick="stock_type('s')" /> 재고량에 따름
							</label> &nbsp;  &nbsp; 
							상품재고 :  <input type="number" class="form-control" id="cit_stock_cnt" name="cit_stock_cnt" value="<?php echo set_value('cit_stock_cnt', element('cit_stock_cnt', element('data', $view))); ?>" /> 개
							<script type="text/javascript">
							//<![CDATA[
							function stock_type(arg) {
								if (arg === 'i') {
									$("#cit_stock_cnt").attr("readonly",true); 
								} else {
									$("#cit_stock_cnt").removeAttr("readonly"); 
								}
							}
							<?php if(element('cit_stock_type', element('data', $view))){?>
							var stock_type_arg = '<?=element('cit_stock_type', element('data', $view))?>';
							<?php }else{?>
							var stock_type_arg = 'i';
							<?php }?>
							//]]>
							stock_type(stock_type_arg);
							</script>
						</div>
					</div>

				<?php } ?>
				
				<?php if($this->session->userdata['mem_admin_flag']==0){?>

					<input type="hidden" name="cit_view_type" value="n">
					<input type="hidden" name="cit_download_days" value="0" />

				<?php }else{ ?>

					<div class="form-group">
						<label class="col-sm-2 control-label">노출방식</label>
						<div class="col-sm-10 form-inline">
							<label class="radio-inline" for="cit_view_type_n">
								<input type="radio" name="cit_view_type" id="cit_view_type_n" value="n" checked <?php echo set_radio('cit_view_type', 'n', (element('cit_view_type', element('data', $view)) == 'n' ? true : false)); ?> onclick="view_type('n')" /> 등록일로부터 N일
							</label>
							<label class="radio-inline" for="cit_view_type_s">
								<input type="radio" name="cit_view_type" id="cit_view_type_s" value="s" <?php echo set_radio('cit_view_type', 's', (element('cit_view_type', element('data', $view)) == 's' ? true : false)); ?> onclick="view_type('s')" /> 기간설정
							</label>
						</div>
					</div>
					
					<div class="form-group" id="view_type_n">
						<label class="col-sm-2 control-label">노출기간</label>
						<div class="col-sm-10 form-inline">
							<input type="number" class="form-control" name="cit_download_days" value="<?php echo set_value('cit_download_days', (int) element('cit_download_days', element('data', $view))); ?>" />일
							<div class="help-inline" >해당기간동안 계속 노출 됩니다. 0 이면 무제한으로 노출 됩니다.</div>
						</div>
					</div>
					<div class="form-group" id="view_type_s">
						<label class="col-sm-2 control-label">노출기간</label>
						<div class="col-sm-10 form-inline">
							<input type="text" class="form-control" name="cit_startDt" id="cit_startDt" value="<?=element('cit_startDt', element('data', $view)); ?>" readonly /> -
							<input type="text" class="form-control" name="cit_endDt" id="cit_endDt" value="<?=element('cit_endDt', element('data', $view)); ?>" readonly /> &nbsp;
						</div>
					</div>

				<?php } ?>
				
				<?php if($this->session->userdata['mem_admin_flag']==0){?>
					<div class="form-group">
						<label class="col-sm-2 control-label">아이템번호</label>
						<div class="col-sm-10 form-inline">
							<input type="text" class="form-control" name="cit_item_arr" value="<?php echo set_value('cit_item_arr', element('cit_item_arr', element('data', $view))); ?>" readonly/>
							<div class="help-inline" ><a href="#item-selector">아이템선택</a>에서 설정해 주세요.</div>
						</div>
					</div>
				<?php }else{ ?>
					<input type="hidden" class="form-control" name="cit_item_arr" value=""/>
				<?php } ?>
				<div class="form-group" style="display: none">
					<label class="col-sm-2 control-label">판매자 회원아이디</label>
					<div class="col-sm-10 form-inline">
						<input type="text" class="form-control" name="seller_mem_userid" value="<?php echo set_value('seller_mem_userid', element('seller_mem_userid', element('data', $view))); ?>" />
					</div>
				</div>
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
						모바일 내용이 일반웹페이지 내용과 다를 경우에 입력합니다. 같은 경우는 입력하지 않으셔도 됩니다
					</div>
				</div>
			</div>
			

			<?php if(element('cit_id', element('data', $view))){?>

				<?php
					if (element('item_detail', element('data', $view))) {
						foreach (element('item_detail', element('data', $view)) as $detail) {
					?>
						<input type="hidden" name="cde_title_update[<?php echo html_escape(element('cde_id', $detail)); ?>]" value="<?php echo html_escape(element('cde_title', $detail)); ?>" />
						<!-- <input type="file" class="form-control" name="cde_file_update[<?php echo html_escape(element('cde_id', $detail)); ?>]" /> -->
						<input type="hidden" class="form-control" name="cde_price_update[<?php echo html_escape(element('cde_id', $detail)); ?>]" value="<?php echo (int) element('cde_price', $detail); ?>" />
						<input type="hidden" name="cde_status_update[<?php echo html_escape(element('cde_id', $detail)); ?>]" value="1" />
					<?php
						}
					}
				?>

			<?php }else{ ?>
				<input type="hidden" name="cde_title[]" value="0">
				<!-- <input type="file" class="form-control" name="cde_file[]"> -->
				<input type="hidden" name="cde_price[]" value="0" >
				<input type="hidden" name="cde_status[]" value="1" checked="checked">
			<?php } ?>
			

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
						<img id="cit_file_<?php echo $k;?>_img" src="<?php echo thumb_url('cmallitem', element('cit_file_' . $k, element('data', $view)), 80); ?>" alt="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" title="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" />
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
			<div class="box-table-header"  style="display: none">
				<h4><a data-toggle="collapse" href="#cmalltab4" aria-expanded="true" aria-controls="cmalltab4">상/하단 내용</a></h4>
				<a data-toggle="collapse" href="#cmalltab4" aria-expanded="true" aria-controls="cmalltab4"><i class="fa fa-chevron-up pull-right"></i></a>
			</div>
			<div class="collapse in" id="cmalltab4"  style="display: none">
				<div class="form-group">
					<label class="col-sm-2 control-label">일반 상단 내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('header_content', set_value('header_content', element('header_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = true, $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">일반 하단 내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('footer_content', set_value('footer_content', element('footer_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = true, $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">모바일 상단 내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('mobile_header_content', set_value('mobile_header_content', element('mobile_header_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = true, $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">모바일 하단 내용</label>
					<div class="col-sm-10">
						<?php echo display_dhtml_editor('mobile_footer_content', set_value('mobile_footer_content', element('mobile_footer_content', element('data', $view))), $classname = 'form-control dhtmleditor', $is_dhtml_editor = true, $editor_type = $this->cbconfig->item('cmall_product_editor_type')); ?>
					</div>
				</div>
			</div>


			<div id="item-selector" class="dn">
				<div class="box-table-header">
					<h4><a data-toggle="collapse" href="#cmalltab7" aria-expanded="true" aria-controls="cmalltab7">아이템선택</a></h4>
					<a data-toggle="collapse" href="#cmalltab7" aria-expanded="true" aria-controls="cmalltab7"><i class="fa fa-chevron-up pull-right"></i></a>
				</div>
				<div>
					
					<div class="item-selector-header mb10">
						<div>
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-success btn-sm btn-item-selector-avata">아바타</button>
								<button type="button" class="btn btn-default btn-sm btn-item-selector-land">랜드</button>
							</div>	
						</div>
						<div class="text-right">
							<button type="button" class="btn btn-danger btn-sm btn-item-selector-delete">선택삭제</button>
							<button type="button" class="btn btn-default btn-sm btn-item-setting-popup">아이템설정</button>
						</div>
					</div>

					<div class="table-responsive is-avata" id="select_item_list">
						<table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th><input type="checkbox" ></th>
									<th>번호</th>
									<th>이미지</th>
									<th>카테고리</th>
									<th>이름</th>
									<th>등록일</th>
									<th>인벤토리노출</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="checkbox" ></td>
									<td class="form-inline"></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
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

var custom_config_company_category = <?php echo $custom_config['category']['company'];?>;


function chk_company_item_setting(){
	if(document.querySelector("#cit_money_type").value != "f"){
		return false;
	}
	return true;
}

function setTemplateItem(data){

	document.querySelector("[name='citt_id']").value = data.citt_id;
	document.querySelector(".citt_id_viewer").textContent = data.citt_id;

	document.querySelector("[name='cit_name']").value = data.citt_name;
	document.querySelector("#citt_deposit_viewer").classList.remove("dn");
	document.querySelector("#citt_deposit").textContent = (data.citt_deposit*(-1)).toLocaleString()+"원";
	document.querySelector("[name='citt_deposit']").value = data.citt_deposit;
	document.querySelector("[name='cit_price']").value = Math.round(data.citt_deposit/100);
	document.querySelector("[name='cit_summary']").value = data.citt_summary;
	oEditors.getById.cit_content.exec("PASTE_HTML", [data.citt_content]);
	oEditors.getById.cit_mobile_content.exec("PASTE_HTML", [data.citt_mobile_content]);

	if(data.citt_file_1!=""){

		targetElement = document.querySelector("[name='cit_file_1']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_1_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_1_del" id="cit_file_1_del" value="1"> 삭제 <input type="hidden" name="citt_file_1" value="'+data.citt_file_1+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_1_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_1_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_1);

		targetElement.parentNode.insertBefore(img, targetElement);
		
	}

	if(data.citt_file_2!=""){

		targetElement = document.querySelector("[name='cit_file_2']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_2_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_2_del" id="cit_file_2_del" value="1"> 삭제 <input type="hidden" name="citt_file_2" value="'+data.citt_file_2+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_2_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_2_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_2);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_3!=""){

		targetElement = document.querySelector("[name='cit_file_3']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_3_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_3_del" id="cit_file_3_del" value="1"> 삭제 <input type="hidden" name="citt_file_3" value="'+data.citt_file_3+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_3_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_3_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_3);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_4!=""){

		targetElement = document.querySelector("[name='cit_file_4']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_4_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_4_del" id="cit_file_4_del" value="1"> 삭제 <input type="hidden" name="citt_file_4" value="'+data.citt_file_4+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_4_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_4_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_4);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_5!=""){

		targetElement = document.querySelector("[name='cit_file_5']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_5_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_5_del" id="cit_file_5_del" value="1"> 삭제 <input type="hidden" name="citt_file_5" value="'+data.citt_file_5+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_5_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_5_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_5);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_6!=""){

		targetElement = document.querySelector("[name='cit_file_6']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_6_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_6_del" id="cit_file_6_del" value="1"> 삭제 <input type="hidden" name="citt_file_6" value="'+data.citt_file_6+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_6_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_6_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_6);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_7!=""){

		targetElement = document.querySelector("[name='cit_file_7']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_7_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_7_del" id="cit_file_7_del" value="1"> 삭제 <input type="hidden" name="citt_file_7" value="'+data.citt_file_7+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_7_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_7_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_7);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_8!=""){

		targetElement = document.querySelector("[name='cit_file_8']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_8_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_8_del" id="cit_file_8_del" value="1"> 삭제 <input type="hidden" name="citt_file_8" value="'+data.citt_file_8+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_8_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_8_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_8);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_9!=""){

		targetElement = document.querySelector("[name='cit_file_9']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_9_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_9_del" id="cit_file_9_del" value="1"> 삭제 <input type="hidden" name="citt_file_9" value="'+data.citt_file_9+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_9_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_9_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_9);

		targetElement.parentNode.insertBefore(img, targetElement);

	}

	if(data.citt_file_10!=""){

		targetElement = document.querySelector("[name='cit_file_9']");

		label = document.createElement("label");
		label.setAttribute("for", "cit_file_10_del");
		label.innerHTML = '<input type="checkbox" name="cit_file_10_del" id="cit_file_10_del" value="1"> 삭제 <input type="hidden" name="citt_file_10" value="'+data.citt_file_10+'">';

		targetElement.parentNode.insertBefore(label, targetElement);

		targetElement = document.querySelector("[for='cit_file_10_del']");

		img = document.createElement("img");
		img.setAttribute("id", "cit_file_10_img");
		img.setAttribute("width", "80px");
		img.setAttribute("src", "/uploads/cmallitemtemplate/"+data.citt_file_10);

		targetElement.parentNode.insertBefore(img, targetElement);

	}
	
}

function clearTemplateItem(){
	document.querySelector("[name='citt_id']").value = "";
	document.querySelector(".citt_id_viewer").textContent = "";

	document.querySelector("[name='cit_name']").value = "";
	document.querySelector("#citt_deposit_viewer").classList.add("dn");
	document.querySelector("#citt_deposit").textContent = "";
	document.querySelector("[name='citt_deposit']").value = 0;
	document.querySelector("[name='cit_price']").value = 0;
	document.querySelector("[name='cit_summary']").value = "";
	oEditors.getById.cit_content.exec("SET_CONTENTS", [""]);
	oEditors.getById.cit_mobile_content.exec("SET_CONTENTS", [""]);

	for(i = 1; i<11; i++){
		if(document.querySelector("#cit_file_"+i+"_img")){
			document.querySelector("[for='cit_file_"+i+"_del']").remove();
			document.querySelector("#cit_file_"+i+"_img").remove();
		}
		
		if(document.querySelector("[name='cit_file_"+i+"']").value){
			document.querySelector("[name='cit_file_"+i+"']").value = "";
		}
		
	}
}

//cit_file_* 파일 업로드를 시도 이벤트
var cit_files  = document.querySelectorAll("[name^='cit_file_']");
cit_files.forEach(element => {
	element.addEventListener("change",function(){

		key = this.id;
		key = key.replace("cit_file_","");
		
		if(document.querySelector("[for='cit_file_"+key+"_del']")){
			document.querySelector("[for='cit_file_"+key+"_del']").remove();
			document.querySelector("#cit_file_"+key+"_img").remove();
		}

	});
});


//템플릿상품, 자체상품 선택 이벤트
document.querySelectorAll('[name="citt_id_use"]').forEach( element => {
	element.addEventListener("change",function(){
		if(this.value == 1){ //템플릿 상품
			document.querySelector('#template-selecter').classList.remove('dn');
			document.querySelector("[name='cit_price']").setAttribute("readonly", "");
		}else{
			//자체상품
			clearTemplateItem();
			document.querySelector('#template-selecter').classList.add('dn');
			document.querySelector("[name='cit_price']").removeAttribute("readonly");
		}
	});
});

// 템플릿 선택 버튼 이벤트
if(document.querySelector(".btn-template-selector")){
	document.querySelector(".btn-template-selector").addEventListener("click",function(){

		clearTemplateItem();

		window.open('/admin/cmall/cmallitem/templateselecter', 'template-select-popup', 'width=1200px, height=630px, menubar=no, toolbar=no, location=no, status=no, scrollbars=no');

	});
}

document.querySelector(".btn-item-setting-popup").addEventListener("click",function(){
	ewWindow = window.open('/admin/cmall/cmallitem/itemsetting?item_sno_data='+document.querySelector('[name="cit_item_arr"]').value, 'item-setting-popup', 'width=1200px, height=630px, menubar=no, toolbar=no, location=no, status=no, scrollbars=no');
});


//<![CDATA[
jQuery(function($) {
	$('#fadminwrite').validate({
		rules: {
			cit_key: {required:true, minlength:3, maxlength:50, alpha_dash : true},
			cit_name: 'required',
			cit_order: 'required',
			cit_price: { required:true, number:true },
			cit_content : {<?php echo ($this->cbconfig->item('use_cmall_product_dhtml')) ? 'required_' . $this->cbconfig->item('cmall_product_editor_type') : 'required'; ?> : true },
			cit_mobile_content : {<?php echo ($this->cbconfig->item('use_cmall_product_dhtml')) ? 'valid_' . $this->cbconfig->item('cmall_product_editor_type') : ''; ?> : true },
			header_content : { valid_<?php echo $this->cbconfig->item('cmall_product_editor_type'); ?> : true },
			footer_content : { valid_<?php echo $this->cbconfig->item('cmall_product_editor_type'); ?> : true },
			mobile_header_content : { valid_<?php echo $this->cbconfig->item('cmall_product_editor_type'); ?> : true },
			mobile_footer_content : { valid_<?php echo $this->cbconfig->item('cmall_product_editor_type'); ?> : true }
		},
		submitHandler: function(form) {

			// 옵션 입력 체크
			var option_count = 0;
			var option_file  = 0;
			var io_price	 = 0;
			var max_io_price = 0;
			var is_price_chk = false;

			$("input[name^=cde_title]").each(function(index) {
				if($.trim($(this).val()).length > 0) {
					option_count++;
					is_price_chk = false;

					if(!form.cit_id.value) {
						if($.trim($("input[name^=cde_file]").eq(index).val()).length > 0) {
							option_file++;
							is_price_chk = true;
						}
					} else {
						if($(".ct_file_name").eq(index).length > 0) {
							option_file++;
							is_price_chk = true;
						} else {
							if($.trim($("input[name^=cde_file]").eq(index).val()).length > 0) {
								option_file++;
								is_price_chk = true;
							}
						}
					}

					if(is_price_chk) {
						io_price = parseInt($.trim($("input[name^=cde_price_update]").eq(index).val()));
						if(max_io_price < io_price)
							max_io_price = io_price;
					}
				}
			});


			form.submit();
		}
	});
});
$(function() {
	$('#cit_startDt').datepicker({format: "yyyymmdd",language : "kr"});
	$('#cit_endDt').datepicker({format: "yyyymmdd",language : "kr"});
});
	
function view_type(arg) {
	if (arg === 'n') {
		$("#view_type_n").css("display","block");
		$("#view_type_s").css("display","none");
	} else {
		$("#view_type_s").css("display","block");
		$("#view_type_n").css("display","none");
	}
}


//아이템선택 팝업 완료 처리 이벤트
async function update_cit_item_arr(data){
	document.querySelector("[name='cit_item_arr']").value = data;
	await get_item_selector();
}

//아이템선택 데이터 가져오기
async function get_item_selector(){
	try {

		const response = await fetch('/admin/cmall/cmallitem/itemsettingselectlist?item_sno='+document.querySelector("[name='cit_item_arr']").value);

		if (!response.ok) {
			throw new Error('Network response was not ok');
		}

		const data = await response.text();

		document.querySelector('#select_item_list').textContent = '';
		document.querySelector('#select_item_list').innerHTML = data;

	} catch (error) {
		console.error('Error during fetch operation:', error);
	}
}

async function page_load(){

	await get_item_selector();

	if(document.querySelector('[name="cit_item_type"]').value=='i'){
		document.querySelector('#item-selector').classList.remove('dn');
	}else{

	}
	
	//아이템선택 아바타 클릭 이벤트
	document.querySelector('.btn-item-selector-avata').addEventListener("click",function(){
		this.classList.remove("btn-default");
		this.classList.add("btn-success");

		document.querySelector('.btn-item-selector-land').classList.add("btn-default");
		document.querySelector('.btn-item-selector-land').classList.remove("btn-success");

		document.querySelector('#select_item_list').classList.add('is-avata');
		document.querySelector('#select_item_list').classList.remove('is-land');

		document.querySelectorAll('[name="item_sno[]"]').forEach(element=>{
			element.checked = false;
		});

	});


	//아이템선택 랜드 클릭 이벤트
	document.querySelector('.btn-item-selector-land').addEventListener("click",function(){

		this.classList.remove("btn-default");
		this.classList.add("btn-success");
		
		document.querySelector('.btn-item-selector-avata').classList.add("btn-default");
		document.querySelector('.btn-item-selector-avata').classList.remove("btn-success");

		document.querySelector('#select_item_list').classList.remove('is-avata');
		document.querySelector('#select_item_list').classList.add('is-land');

		document.querySelectorAll('[name="item_sno[]"]').forEach(element=>{
			element.checked = false;
		});
	});

	//아이템선택 선택삭제 클릭 이벤트
	document.querySelector('.btn-item-selector-delete').addEventListener("click",function(){

		if(document.querySelectorAll('[name="item_sno[]"]:checked').length==0){
			alert("선택된 데이터가 없습니다.");
			return false;
		}

		document.querySelectorAll('[name="item_sno[]"]:checked').forEach(element=>{
			element.parentNode.parentNode.remove();
		});

		var item_sno_datas = Array();
		document.querySelectorAll('[name="item_sno[]"]').forEach(element=>{
			item_sno_datas.push(element.value);
		});

		document.querySelector('[name="cit_item_arr"]').value = item_sno_datas.join(",");

	});

}

page_load();


<?php if(element('cit_view_type', element('data', $view))){?>
var stock_view_arg = '<?=element('cit_view_type', element('data', $view))?>';
<?php }else{?>
var stock_view_arg = 'n';
<?php }?>
//]]>
view_type(stock_view_arg);	
	
//]]>
</script>

