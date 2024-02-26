<style type="text/css">
.cmall-options {background: #F2F3F5;border: 1px solid #DEE3E0;margin: 5px 0;border-bottom: 0;}
.cmall-options li {color: #5A5A5A;border-bottom: 1px solid #DEE3E0;padding: 5px;}
</style>

<div class="box">
	<div class="box-table">
	<?php
	echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	echo show_alert_message($this->session->flashdata('dangermessage'), '<div class="alert alert-auto-close alert-dismissible alert-danger"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	?>
		<div class="box-table-header">
			<div class="btn-group btn-group-sm" role="group">
				<a href="<?php echo admin_url('cmall/orderlist'); ?>" class="btn btn-sm <?php echo ( ! $this->input->get('cor_pay_type')) ? 'btn-success' : 'btn-default';?>">전체내역</a>
				<a href="<?php echo admin_url('cmall/orderlist'); ?>?cor_pay_type=f" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'f') ? 'btn-info' : 'btn-default';?>">열매</a>
				<a href="<?php echo admin_url('cmall/orderlist'); ?>?cor_pay_type=c" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'c') ? 'btn-info' : 'btn-default';?>">복지포인트</a>
			</div>
			<?php
			ob_start();
			?>
				<div class="btn-group pull-right" role="group" aria-label="...">
					<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
				</div>
			<?php
			$buttons = ob_get_contents();
			ob_end_flush();
			?>
		</div>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th>주문번호</th>
						<th>회원아이디</th>
						<th>회원명/실명</th>
						<th>일시</th>
						<th>결제수단</th>
						<th>하고싶은 말</th>
						<th>결제금액</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$custom_config = config_item("custom");
				
				if (element('list', element('data', $view))) {
					foreach (element('list', element('data', $view)) as $result) {
				?>
					<tr>
						<td><a href="<?php echo site_url('cmall/orderresult/' . element('cor_id', $result)); ?>" target="_blank"><?php echo element('cor_id', $result); ?></a>
						<?php if( element('is_test', $result) ){ ?>
							<span class="btn btn-xs btn-warning">테스트 결제</span>
						<?php } ?>
						</td>
						<td><a href="?sfield=deposit.mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('mem_userid', $result)); ?></a></td>
						<td><?php echo element('display_name', $result); ?> / <?php echo html_escape(element('mem_realname', $result)); ?></td>
						<td><?php echo display_datetime(element('cor_datetime', $result), 'full'); ?></td>
						<td>
							<?php echo ($result['cor_pay_type']=="f")?"열매":"복지포인트"; ?>
						</td>
						<td><?php echo nl2br(html_escape(element('cor_content', $result))); ?></td>
						<td class="text-right">
							<?php echo number_format(element('cor_total_money', $result)); ?>
							<?php
								if($result['cor_pay_type']=="c"){
									echo "개";
								}else{
									echo "원";
								}
							?>

						</td>
					</tr>
					<?php
					if (element('orderdetail', $result)) {
					?>
						<tr>
							<td colspan="7" >
								<div class="bg-warning">
									<table class="table table-bordered mt20">
										<thead>
											<tr class="success">
												<th>이미지</th>
												<th>상품명</th>
												<th class="text-center">총수량</th>
												<th>판매가</th>
												<th>소계</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$total_price_sum = 0;
											foreach (element('orderdetail', $result) as $row) {
										?>
											<tr>
												<td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>"><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', element('item', $row)), 60, 60); ?>" class="thumbnail" style="margin:0;width:60px;height:60px;" alt="<?php echo html_escape(element('cit_name', element('item', $row))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $row))); ?>" /></a></td>
												<td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>"><?php echo html_escape(element('cit_name', element('item', $row))); ?></a>
													<ul class="cmall-options">
														<?php
														$total_num = 0;
														$total_price = 0;
														foreach (element('itemdetail', $row) as $detail) {
														?>
															<li><?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cod_count', $detail);?>개 
															<?php 
																if(element('cde_price', $detail)!=0){
															?>
															(+<?php echo number_format(element('cde_price', $detail)); ?>
																	
																	<?php
																		if($result['cor_pay_type']=="c"){
																			echo "개";
																		}else{
																			echo "원";
																		}
																	?>
															
															)
															<?php
																}
															?>
															</li>
														<?php
														$total_num += element('cod_count', $detail);
														$total_price += ((int) element('cit_price', element('item', $row)) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
														}
														$total_price_sum += $total_price;
														?>
													</ul>
												</td>
												<td class="text-center"><?php echo number_format($total_num); ?></td>
												<td><?php echo number_format(element('cit_price', element('item', $row))); ?></td>
												<td><?php echo number_format($total_price); ?><input type="hidden" name="total_price[<?php echo element('cit_id', element('item', $row)); ?>]" value="<?php echo $total_price; ?>"></td>
											</tr>
										<?php
										}
										?>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					<?php
							}
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="8" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="box-info">
			<?php echo element('paging', $view); ?>
			<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
			<?php echo $buttons; ?>
		</div>
	</div>
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).on('click', '.btn-download-days-modify', function() {
	$('.cor-id-cit-id-' + $(this).attr('data-cor-id-cit-id')).toggle();
});
//]]>
</script>
