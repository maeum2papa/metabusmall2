<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>


<div id="asmo_item_detail_wrap" class="asmo_wish_wrap asmo_order_result">

	<div class="page-header">
		<h4>주문상세내역</h4>
		<div class="top_right_box">
			<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
			<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
			<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
		</div>
	</div>

	<div class="asmo_order_goods_wrap">
		<?php if($view['data']['cor_pay_type']=='f'){?>
			<h4>열매상품</h4>
		<?php }else if($view['data']['cor_pay_type']=='c'){?>
			<h4>코인상품</h4>
		<?php }?>
		<!-- asmo lhb 231221 기존 테이블 형식 ul li 형식으로 변경 -->
		<ul class="prd-list">
		<?php
		$total_price_sum = 0;
		if (element('orderdetail', $view)) {
			foreach (element('orderdetail', $view) as $result) {
		?>
			<li>
				<a class="asmo_cit_name" href="<?php echo cmall_item_url(element('cit_key', element('item', $result))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $result))); ?>"><?php echo html_escape(element('cit_name', element('item', $result))); ?></a>
				<div class="order_info_box">
					<div class="prd-img">
						<a href="<?php echo cmall_item_url(element('cit_key', element('item', $result))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $result))); ?>"><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', element('item', $result))); ?>"  alt="<?php echo html_escape(element('cit_name', element('item', $result))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $result))); ?>" /></a>
					</div>
					<div class="order_option_box">
						<ul class="cmall-options">
							<?php
							$total_num = 0;
							$total_price = 0;
							foreach (element('itemdetail', $result) as $detail) {
							?>
								<li><?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cod_count', $detail);?>개 (+<?php echo number_format(element('cde_price', $detail)); ?>원)
									<?php
									if (element('cor_status', element('data', $view)) === '1') {
										if (element('possible_download', element('item', $result))) {
									?>
										<a style="display:none;" href="<?php echo site_url('cmallact/download/' . element('cor_id', element('data', $view)) . '/' . element('cde_id', $detail));?>" type="button" name="download" class="btn btn-xs btn-black pull-right">다운로드</a>
									<?php } else { ?>
										<!-- <button type="button" class="btn btn-xs btn-danger pull-right">다운로드 기간 완료</button> -->
									<?php
										}
									} else {
									?>
										<button type="button" class="btn btn-xs btn-danger pull-right">입금확인중</button>
									<?php
									}
									?>
								</li>
							<?php
								$total_num += element('cod_count', $detail);
								$total_price += ((int) element('cit_price', element('item', $result)) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
							}
							$total_price_sum += $total_price;
							?>
						</ul>
						<div class="prd-price">
							<div>
								<span>상품수량</span> <?php echo number_format($total_num); ?> 개
							</div>
							<div>
								<span>상품단가</span>
								<?php if($view['data']['cor_pay_type']=='f'){?>
								열매
								<?php }else if($view['data']['cor_pay_type']=='c'){?>
									코인
								<?php }?><?php echo number_format(element('cit_price', element('item', $result))); ?> 개
							</div>
							<div class="prd-total">
								<span>합계</span>
								<?php if($view['data']['cor_pay_type']=='f'){?>
								열매
								<?php }else if($view['data']['cor_pay_type']=='c'){?>
									코인
								<?php }?><?php echo number_format($total_price); ?><input type="hidden" name="total_price[<?php echo element('cit_id', element('item', $result)); ?>]" value="<?php echo $total_price; ?>" /> 개
							</div>
						</div>
					</div>
				</div>
				
				<!-- <span> -->
					<?php
					// if (element('cod_download_days', $detail)) {
					// 	echo '구매후 ' . element('cod_download_days', $detail) . '일간 ( ~ ' . element('download_end_date', element('item', $result)) . ' 까지)';
					// } else {
					// 	echo '기간제한없음';
					// }
					?>
				<!-- </span> -->
			</li>
		<?php
			}
		}
		?>
		</ul>
	</div>
	<div class="credit asmo_info_container">
		<div class="asmo_order_info_wrap">
			<h4 class="market-title">결제정보</h4>
			<table class="table table-striped table-bordered table-hover">
				<tbody>
					<tr>
						<td class="text-center col-md-3">주문번호</td>
						<td><?php echo element('cor_id', element('data', $view)); ?></td>
					</tr>
					<tr>
						<td class="text-center">결제방식</td>
						<td><?php echo $this->cmalllib->paymethodtype[element('cor_pay_type', element('data', $view))];?></td>
					</tr>
					<tr style="display:none;">
						<td class="text-center">결제금액</td>
						<td><?php echo (element('cor_cash', element('data', $view))) ? number_format(abs(element('cor_cash', element('data', $view)))) : '아직 입금되지 않았습니다'; ?></td>
					</tr>
					<?php if (element('cor_approve_datetime', element('data', $view)) > '0000-00-00 00:00:00') { ?>
						<tr>
							<td class="text-center">결제일시</td>
							<td><?php echo element('cor_approve_datetime', element('data', $view)); ?></td>
						</tr>
					<?php } ?>
					<?php if (element('cor_pay_type', element('data', $view)) === 'bank') {?>
						<tr>
							<td class="text-center">입금자명</td>
							<td><?php echo html_escape(element('mem_realname', element('data', $view))); ?></td>
						</tr>
						<tr>
							<td class="text-center">입금계좌</td>
							<td><?php echo nl2br(html_escape($this->cbconfig->item('payment_bank_info'))); ?></td>
						</tr>
					<?php } ?>
					<?php if (element('cor_pay_type', element('data', $view)) === 'card') {?>
						<tr>
							<td class="text-center">승인번호</td>
							<td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
						</tr>
					<?php } ?>
					<?php if (element('cor_pay_type', element('data', $view)) === 'phone') {?>
						<tr>
							<td class="text-center">휴대폰번호</td>
							<td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
						</tr>
					<?php } ?>
					<?php if (element('cor_pay_type', element('data', $view)) === 'vbank' OR element('cor_pay_type', element('data', $view)) === 'realtime') {?>
						<tr>
							<td class="text-center">거래번호</td>
							<td><?php echo html_escape(element('cor_tno', element('data', $view))); ?></td>
						</tr>
					<?php } ?>
					<?php if (element('cor_pay_type', element('data', $view)) === 'card' OR element('cor_pay_type', element('data', $view)) === 'phone') {?>
					<tr>
						<td class="text-center">영수증</td>
						<td>
							<?php
							if (element('cor_pay_type', element('data', $view)) === 'card') {
								if ($this->cbconfig->item('use_pg_test')) {
									$receipturl = 'https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=';
								} else {
									$receipturl = 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=';
								}
							?>
								<a href="javascript:;" onclick="window.open('<?php echo $receipturl; ?>card_bill&tno=<?php echo element('cor_tno', element('data', $view)); ?>&amp;order_no=<?php echo element('cor_id', element('data', $view)); ?>&trade_mony=<?php echo element('cor_cash', element('data', $view)); ?>', 'winreceipt', 'width=500,height=690,scrollbars=yes,resizable=yes');" title="영수증 출력">영수증 출력</a>
							<?php } ?>
							<?php
							if (element('cor_pay_type', element('data', $view)) === 'phone') {
								if ($this->cbconfig->item('use_pg_test')) {
									$receipturl = 'https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=';
								} else {
									$receipturl = 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=';
								}
							?>
								<a href="javascript:;" onclick="window.open('<?php echo $receipturl; ?>mcash_bill&tno=<?php echo element('cor_tno', element('data', $view)); ?>&amp;order_no=<?php echo element('cor_id', element('data', $view)); ?>&trade_mony=<?php echo element('cor_cash', element('data', $view)); ?>', 'winreceipt', 'width=500,height=690,scrollbars=yes,resizable=yes');" title="영수증 출력">영수증 출력</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="asmo_order_info_wrap asmo_payment_info">
		
			<h4 class="market-title">
				<?php if($view['data']['cor_pay_type']=='f'){?>
				열매
				<?php }else if($view['data']['cor_pay_type']=='c'){?>
					코인
				<?php }?> 결제합계
			</h4>
			<table class="table table-striped table-bordered table-hover">
				<tbody>
					<tr>
						<td class="table-left">총 주문액</td>
						<td><?php echo number_format(abs(element('cor_cash_request', element('data', $view))));?> 개</td>
					</tr>
					<tr>
						<td class="table-left">미결제액</td>
						<td>
							<?php
								$notyet = abs(element('cor_cash_request', element('data', $view))) - abs(element('cor_cash', element('data', $view)));
								echo number_format($notyet);
							?> 개
						</td>
					</tr>
					<tr class="info">
						<td class="table-left">결제액</td>
						<td><?php echo number_format(abs(element('cor_cash', element('data', $view))));?> 개</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>	

<script>

	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');
</script>