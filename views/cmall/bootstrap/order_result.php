<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css');
?>

<style>
	body {
		background: transparent linear-gradient(180deg, #000000 0%, #3E3E3E 100%);
		background-attachment: fixed;
		color: #f1f1f1;
	}

	header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	}


	
	footer .container .company_info_box .company li a,
	footer .container .company_info_box  .company li::after,
	footer .container .company_info_box .company_info p,
	.company_info_right_box span,
	.company_info_right_box strong {
		color: rgba(177, 177, 177, 1) !important;
	}
</style>

<!-- asmo sh 231215 shop div#order-result 감싸는 div#asmo_cmall 생성  -->

<div class="asmo_cmall">
	<div id="order-result">

		<!-- shop 부분 공통 top box -->
		<div class="cmall_top_wrap">
			<div class="top_left_box">

				<h2><a href="<?php echo site_url('cmall'); ?>">교환소</a></h2>

				<div class="status_box status_box_wrap" id="fruit_popup_open">
					<div class="status_icon">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.svg" alt="fruit">
					</div>
					<div class="status_info">
						<span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?> 개</span>
					</div>
				</div>

				<div class="coin_box status_box_wrap" id="coin_popup_open">
					<div class="status_icon">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/point.svg" alt="point">
					</div>
					<div class="status_info">
						<span id="coin_count"><?php echo html_escape($this->member->item('mem_point')); ?> 개</span>
					</div>
				</div>
			</div>
			<div class="top_right_box">
				<a href="/cmall/cart">장바구니</a>
				<a href="/cmall/orderlist">교환내역</a>
			</div>

		</div>

		<!-- asmo sh 231215 디자인 상 장바구니, 구매내역 버튼 필요하여 div.cmall_orderlist_top_box 생성  -->
		<div class="cmall_orderlist_top_box">
				
			<strong>교환정보</strong>

			<a href="/cmall/orderlist">목록으로</a>
			
		</div>
	

		<!-- asmo sh 240222 asmo_order_box 생성 및 디자인 변경 -->
		<div class="asmo_order_box">

			<div class="asmo_order_box_top_box">
		
				<p>교환번호 : <?php echo element('cor_id', element('data', $view)); ?></p>

				<!-- // asmo sh 240221 구매내역 상태​ 업데이트
				// - 주문확인 / 발송대기 / 발송완료 -->
				<span><?php echo $view['data']['status_name'];?></span>
				
				
			</div>

			<div class="prd-list_wrap">
				<p class="asmo_order_info">상품 정보</p>
				<ul class="prd-list">
					<!-- 주문번호, 결제시간 포함된 div 생성 -->
				
					<?php
					$total_price_sum = 0;
					if (element('orderdetail', $view)) {
						foreach (element('orderdetail', $view) as $result) {
					?>
					
						<li>
							<!-- asmo sh 231215 디자인 상 li 내 div들 재배치 -->
							<div class="prd-info">
								<!-- <a href="<?php echo cmall_item_url(element('cit_key', element('item', $result))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $result))); ?>"><?php echo html_escape(element('cit_name', element('item', $result))); ?></a> -->
								<div class="order_info_box">
									<!-- asmo sh 231215 썸네일 이미지 style 삭제 -->
									<div class="prd-img"><a href="<?php echo cmall_item_url(element('cit_key', element('item', $result))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $result))); ?>" ><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', element('item', $result)), 100, 100); ?>" class="thumbnail"  alt="<?php echo html_escape(element('cit_name', element('item', $result))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $result))); ?>" /></a></div>
				
									<div class="order_option_box">

										<?php if($view['data']['cor_pay_type'] == 'f'){ ?>
										<span class="order_prd_type">컬래버랜드 아이템몰</span>
										<?php	}else if($view['data']['cor_pay_type'] == 'c'){ ?>
										<span class="order_prd_type"><?php echo busiNm($this->member->item('company_idx')); ?> 복지교환소</span>
										<?php	}?>
										
										<p class="order_prd_name"><?php echo html_escape(element('cit_name', element('item', $result))); ?></p>

										<ul class="cmall-options dn">
											<?php
											$total_num = 0;
											$total_price = 0;
											foreach (element('itemdetail', $result) as $detail) {
											?>
												<li>
													<i class="fa fa-angle-right" aria-hidden="true"></i>
													<?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cod_count', $detail);?>개 (+<?php
													if($view['data']['cor_pay_type'] == 'f'){
														echo number_format(element('cde_price', $detail));
													}else if($view['data']['cor_pay_type'] == 'c'){
														echo number_format(element('cde_price', $detail));
													}
													?>개)
												</li>
											<?php
												$total_num += element('cod_count', $detail);
												$total_price += ((int) element('cit_price', element('item', $result)) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
											}
											$total_price_sum += $total_price;
											?>
										</ul>
										<!-- 디자인 상 다운로드 관련 텍스트 불필요하여 주석 처리 -->
										<!-- <div class="order_download_info">
											<span>다운로드 :</span>
											<?php
											if (element('cod_download_days', $detail)) {
												echo '구매후 <strong>' . element('cod_download_days', $detail) . '</strong>일간';
												if( element('download_end_date', element('item', $result)) ){
													echo '<br>(~' . element('download_end_date', element('item', $result)) . ' 까지)';
												}
											} else {
												echo '기간제한없음';
											}
											?>
										</div> -->
										<div class="prd-price">
											<div class="dn"><span>수량 :</span> <?php echo number_format($total_num); ?> 개</div>
											<div class="order_prd_price"> 
												<p>
													<?php
													if($view['data']['cor_pay_type'] == 'f'){
														echo banner('fruit').number_format(element('cit_price', $detail));
													}else if($view['data']['cor_pay_type'] == 'c'){
														echo banner('coin').number_format(element('cit_price', $detail));
													}
													?> 개
												</p>
											</div>
											<div class="dn"><p><?php
												if($view['data']['cor_pay_type'] == 'f'){
													echo banner('fruit').number_format($total_price);
												}else if($view['data']['cor_pay_type'] == 'c'){
													echo banner('coin').number_format($total_price);
												}
											?><input type="hidden" name="total_price[<?php echo element('cit_id', element('item', $result)); ?>]" value="<?php echo $total_price; ?>" />개</p></div>
				
										</div>
									</div>
								</div>
							</div>
						</li>
					<?php
						}
					}
					?>
				</ul>
			</div>

			<div class="prd_exchange_info_wrap">
				<p class="asmo_order_info">교환 정보</p>
				<div class="prd_exchange_info">
					<p>교환 일시 : <?php echo element('cor_approve_datetime', element('data', $view)); ?></p>
					<p>교환 수단 : 
						<?php if($view['data']['cor_pay_type'] == 'f'){
							echo "열매";
						}else if($view['data']['cor_pay_type'] == 'c'){
							echo "복지포인트";
						} ?>
					</p>
					<p>차감 개수 : 
						<?php
						if($view['data']['cor_pay_type']=='f'){
							echo number_format(abs(element('cor_cash_request', element('data', $view))));
						}else if($view['data']['cor_pay_type']=='c'){
							echo number_format(abs(element('cor_cash_request', element('data', $view))));
						}
						?> 개
					</p>
				</div>
			</div>

			<div class="order_customer_box_wrap">
				<p class="asmo_order_info">주문자 정보</p>
				<div class="order_customer_box">
					
					<p><!-- 주문자 부서명 들어가야 합니다 --></p>
					<p><?php echo html_escape(element('mem_realname', element('data', $view))); ?></p>
					<p><!-- 주문자 직책 들어가야 합니다 --></p>
				</div>
				
				<!-- 주문자 정보 div 생성 -->
				<div class="order_bottom_box dn">
					<div class="customer_info_box">
						<h5>주문자 정보</h5>
						<div class="customer_info_flex_box">
							<div class="customer_info">
								<span class="customer_info_title">주문자명</span>
								<span class="customer_info_content"><?php echo html_escape(element('mem_realname', element('data', $view))); ?></span>
							</div>
							<?php if($view['data']['mem_phone']!=''){?>
							<div class="customer_info">
								<span class="customer_info_title">휴대폰번호</span>
								<span class="customer_info_content"><?php echo html_escape(element('mem_phone', element('data', $view))); ?></span>
							</div>
							<?php } ?>
							<div class="customer_info">
								<span class="customer_info_title">이메일</span>
								<span class="customer_info_content"><?php echo html_escape(element('mem_email', element('data', $view))); ?></span>
							</div>
						</div>
					</div>
				</div>
				<!-- 배송지 정보 박스 내 컨텐츠 재배치 -->
				<?php if($view['data']['cor_ship_zipcode']!=''){
					?>
					<div class="order_bottom_box dn">
						<div style="clear:both;">
							<h5>배송지 정보</h5>
							<div class="deliver_info_box">
								<div class="deliver_info">
									<p>(<?php echo $view['data']['cor_ship_zipcode'] ?>)</p>
									<p><?php echo $view['data']['cor_ship_address'] ?> <?php echo $view['data']['cor_ship_address_detail'] ?></p>
								</div>
			
								<div class="deliver_memo">
									<p>주문메모</p>
									<p><?php echo $view['data']['cor_content']; ?></p>
								</div>
							</div>
						</div>
					</div>
					<?php
				}?>
			</div>

			<?php if($view['data']['cor_pay_type']=='c'){?>

			<div class="order_delivery_box_wrap">
				<p class="asmo_order_info">배송 정보</p>
				<div class="order_delivery_box">
					<p>받는 사람 : <?php echo html_escape(element('mem_realname', element('data', $view))); ?></p>
					<p>연락처 : <?php echo html_escape(element('mem_phone', element('data', $view))); ?></p>
					<p>주소 : <?php echo $view['data']['cor_ship_address'] ?> <?php echo $view['data']['cor_ship_address_detail'] ?></p>
				</div>
			</div>

			<?php } ?>

			<!-- asmo sh 231215 결제정보, 주문자 정보, 배송지 정보 감싸는 div 생성 및 디자인 상 컨텐츠 재배치 -->
			<!-- 미노출 처리 -->
			<div class="order_fixed_box dn">
				<div class="credit row">
					<div class="col-xs-12 col-md-6">
						<div class="ord-info">
							<h5>결제정보</h5>
							<table class="table">
								<tbody>
									<tr>
										<th>주문번호</th>
										<td><?php echo element('cor_id', element('data', $view)); ?></td>
									</tr>
									<?php if (element('cor_approve_datetime', element('data', $view)) > '0000-00-00 00:00:00') { ?>
										<tr>
											<th>결제일시</th>
											<td><?php echo element('cor_approve_datetime', element('data', $view)); ?></td>
										</tr>
									<?php } ?>
									<?php if (element('cor_pay_type', element('data', $view)) === 'bank') {?>
										<tr>
											<th>입금자명</th>
											<td><?php echo html_escape(element('mem_realname', element('data', $view))); ?></td>
										</tr>
										<tr>
											<th>입금계좌</th>
											<td><?php echo nl2br(html_escape($this->cbconfig->item('payment_bank_info'))); ?></td>
										</tr>
									<?php } ?>
									<?php if (element('cor_pay_type', element('data', $view)) === 'card') {?>
										<tr>
											<th>승인번호</th>
											<td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
										</tr>
									<?php } ?>
									<?php if (element('cor_pay_type', element('data', $view)) === 'phone') {?>
										<tr>
											<th>휴대폰번호</th>
											<td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
										</tr>
									<?php } ?>
									<?php if (element('cor_pay_type', element('data', $view)) === 'vbank' OR element('cor_pay_type', element('data', $view)) === 'realtime') {?>
										<tr>
											<th>거래번호</th>
											<td><?php echo html_escape(element('cor_tno', element('data', $view))); ?></td>
										</tr>
									<?php } ?>
									<?php if (element('cor_pay_type', element('data', $view)) === 'card' OR element('cor_pay_type', element('data', $view)) === 'phone') {?>
										<tr>
											<th>영수증</th>
											<td>
											<?php if( $receipt_link_js = element('card_receipt_js', element('data', $view)) ){ ?>
											<script language="JavaScript" src="<?php echo $receipt_link_js; ?>"></script>
											<?php } ?>
											<a href="#" onclick="<?php echo element('card_receipt_script', element('data', $view)); ?>">영수증 출력</a>
										</td>
									</tr>
									<?php } ?>
									<?php if ( element('cor_pay_type', element('data', $view)) === 'vbank' ){	//가상계좌이면 ?>
										<tr>
											<th>입금계좌</th>
											<td><?php echo element('cor_bank_info', element('data', $view)); ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 ">
						<div class="pay-info">
						<?php if($view['data']['cor_pay_type']=='f'){?>
							<h5>열매 결제합계</h5>
						<?php }else if($view['data']['cor_pay_type']=='c'){?>
							<h5>복지포인트 결제상품</h5>
						<?php }?>
							<ul>
								<li>
									<span class="info-tit">총 주문액</span>
									<?php
									if($view['data']['cor_pay_type']=='f'){
										echo number_format(abs(element('cor_cash_request', element('data', $view))));
									}else if($view['data']['cor_pay_type']=='c'){
										echo number_format(abs(element('cor_cash_request', element('data', $view))));
									}
									?> 개
								</li>
								<li>
									<span class="info-tit">미결제액</span>
									<?php
									$notyet = abs(element('cor_cash_request', element('data', $view))) - abs(element('cor_cash', element('data', $view)));
									if($view['data']['cor_pay_type']=='f'){
										echo number_format($notyet);
									}else if($view['data']['cor_pay_type']=='c'){
										echo number_format($notyet);
									}
									?> 개
								</li>
								<li>
									<span class="info-tit">결제액</span>
									<strong><?php
									if($view['data']['cor_pay_type']=='f'){
										echo number_format(abs(element('cor_cash', element('data', $view))));
									}else if($view['data']['cor_pay_type']=='c'){
										echo number_format(abs(element('cor_cash', element('data', $view))));
									}
									?></strong> 개
								</li>
							</ul>
						</div>
					</div>
					<!-- 디자인 상 배송정보 div 불필요하여 주석처리 -->
					<!-- <?php if($view['data']['cor_ship_zipcode']!=''){
						?>
						<div style="clear:both;">
							<h5>배송정보</h5>
							<div><?php echo $view['data']['cor_ship_zipcode'] ?></div>
							<div><?php echo $view['data']['cor_ship_address'] ?></div>
							<div><?php echo $view['data']['cor_ship_address_detail'] ?></div>
							<div><?php echo $view['data']['cor_content']; ?></div>
						</div>
						<?php
					}?> -->
				</div>
			</div>
		</div>
	</div>
</div>



<script>
$(document).ready(function() {
	// asmo sh 231214 shop 페이지 디자인 상 헤더, nav바, 숨김 처리 스크립트
	$('header').addClass('dn');
	$('.navbar').addClass('dn');
	// $('.sidebar').addClass('dn');
	// $('footer').addClass('dn');

	$('.main').addClass('add');

	// shop 페이지일 때 사이드바 메뉴 활성화
	$('#shop').addClass('selected');
});
</script>