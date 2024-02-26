<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_js(base_url('assets/js/cmallitem.js')); ?>
<script type="text/javascript" src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>

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


<!-- asmo sh 231215 shop div#order 감싸는 div#asmo_cmall 생성  -->
<div class="asmo_cmall">
	<div id="order">

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
		<!-- <h3>주문하기</h3> -->
		<div class="cmall_orderlist_top_box">
				
			<strong>교환하기</strong>

		</div>
	
		<!-- asmo sh 240222 디자인 상 form 내로 컨텐츠 이동 및 재배치 -->
		<?php
		$sform['view'] = $view;
		if ($this->cbconfig->item('use_payment_pg') && element('use_pg', $view)) {
			$this->load->view('paymentlib/' . $this->cbconfig->item('use_payment_pg') . '/' . element('form1name', $view), $sform);
		}
		$attributes = array('class' => 'form-horizontal', 'name' => 'fpayment', 'id' => 'fpayment', 'autocomplete' => 'off');
		echo form_open(site_url('cmall/orderupdate'), $attributes);
		if ($this->cbconfig->item('use_payment_pg') && element('use_pg', $view)) {
			$this->load->view('paymentlib/' . $this->cbconfig->item('use_payment_pg') . '/' . element('form2name', $view), $sform);
		}
		?>
		<div class="asmo_flex_box">
			<div id="order_box">
				<div class="prd-list_wrap">
					<p class="asmo_order_info">상품 정보</p>
					<ul class="prd-list">
					<!-- asmo sh 231215 디자인 상 열매상품, 복지포인트상품 나타내는 함수 생성 -->
					<!-- 미노출 처리 -->
					<!-- <?php if(element('cor_pay_type',$view)=='f'){?>
						<h3>열매상품</h3>
					<?php }else if(element('cor_pay_type',$view)=='c'){?>
						<h3>복지포인트상품</h3>
					<?php }?> -->
					<?php
					$total_price_sum = 0;
					$item_item_count = 0;
					if (element('data', $view)) {
						foreach (element('data', $view) as $result) {
							if($result['cit_item_type'] == "i"){
								$item_item_count++;
							}
					?>
						<li>
							<!-- asmo sh 231215 디자인 상 li 내 div들 재배치 -->
							<div class="prd-info">
								<!-- <a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>"><?php echo html_escape(element('cit_name', $result)); ?></a> -->
								<div class="order_info_box">
									<!-- asmo sh 231215 썸네일 이미지 style 삭제 -->
									<div class="prd-img"><a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>"><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 100, 100); ?>" class="thumbnail" alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" /></a></div>
					
									<div class="order_option_box">

										<?php if(element('cor_pay_type',$view) == 'f'){ ?>
										<span class="order_prd_type">컬래버랜드 아이템몰</span>
										<?php	}else if(element('cor_pay_type',$view) == 'c'){ ?>
										<span class="order_prd_type"><?php echo busiNm($this->member->item('company_idx')); ?> 복지교환소</span>
										<?php	}?>

										<p class="order_prd_name"><?php echo html_escape(element('cit_name', $result)); ?></p>

										<ul class="cmall-options dn">
											<?php
											$total_num = 0;
											$total_price = 0;
											foreach (element('detail', $result) as $detail) {
											?>
												<li><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cct_count', $detail);?>개 (+<?php
												if(element('cor_pay_type',$view) == 'f'){
													echo number_format(element('cde_price', $detail)/element('company_coin_value', $result));
												}else{
													echo number_format(element('cde_price', $detail));
												}
												?>개)</li>
											<?php
												$total_num += element('cct_count', $detail);
												$total_price += ((int) element('cit_price', $result) + (int) element('cde_price', $detail)) * element('cct_count', $detail);
											}
											$total_price_sum += $total_price;
											?>
										</ul>
										<div class="prd-price">
											<div class="dn"><span>수량 :</span> <?php echo number_format($total_num); ?> 개</div>
											<div class="order_prd_price"> 
												<p>
													<?php
													if(element('cor_pay_type',$view) == 'f'){
														echo banner('fruit').number_format($total_price_sum / element('company_coin_value',$view));
													}else if(element('cor_pay_type',$view) == 'c'){
														echo banner('coin').number_format($total_price_sum);
													}
													?> 개
												</p>
											</div>
											<div class="prd-total dn"><span>합계 : </span> <strong>
												<?php
												if(element('cor_pay_type',$view) == 'f'){
													echo "열매 ".number_format($total_price/element('company_coin_value', $result));
												}else{
													echo "복지포인트 ".number_format($total_price);
												}
												?>
											<input type="hidden" name="total_price[<?php echo element('cit_id', $result); ?>]" value="<?php echo $total_price; ?>" /></strong> 개</div>
											<!-- 디자인 상 다운로드 관련 텍스트 불필요하여 주석 처리 -->
											<!-- <div><span>다운로드 : </span><?php echo (element('cit_download_days', $result)) ? '구매후 <strong>' . element('cit_download_days', $result) . '</strong> 일간 ' : ' 기간제한없음'; ?></div> -->
										</div>
									</div>
								</div>
							</div>
						</li>
					<?php
						}
					}
					if ( ! element('data', $view)) {
					?>
						<li class="nopost">주문내역이 비어있습니다</li>
					<?php
					}
					?>
					</ul>
				</div>

				<div class="asmo_delivery_info_box">
					<p class="asmo_order_info">배송 정보</p>
					<div class="asmo_delivery_info">
						<input type="hidden" name="unique_id" value="<?php echo element('unique_id', $view); ?>" />
						<input type="hidden" name="total_price_sum" id="total_price_sum" value="<?php echo $total_price_sum; ?>" />
						<input type="hidden" name="good_mny" value="0" />
						<div class="info-wr">
							<div class="ord-info">
								
										<div class="form-group">
											<label class="control-label">연락처</label>
											<input type="text" name="mem_phone" class="form-control" value="<?php echo $this->member->item('mem_phone'); ?>" placeholder="휴대폰 번호를 입력하세요." />
										</div>
										
								<div class="form-group">
									<label class=" control-label">배송</label>
									
									<!-- 배송지 입력인지 회사로 배송인지 선택하기 -->
									<div class="input_address_box">
										<input type="radio" name="input_address" id="input_address_y" value="y" checked="checked" />
										<label for="input_address_y" class="radio-inline">배송지 입력</label>
											
										<input type="radio" name="input_address" id="input_address_n" value="n" /> 
										<label for="input_address_n" class="radio-inline">회사로 배송</label>
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="control-label">배송지</label>

									<!-- 디자인 상 배송지 관련 div 필요하여 생성 -->
									<div class="form_input_address">
										<input type="text" name="cor_ship_zipcode" class="form-control" value="" placeholder="우편번호">
										<button type='button' class="btn" onclick="win_zip('fpayment', 'cor_ship_zipcode', 'cor_ship_address', 'cor_ship_address_detail', 'cor_ship_address_detail', 'cor_ship_address4');">검색</button>
										<input type="text" name="cor_ship_address" class="form-control" value="" placeholder="주소">
										<input type="text" name="cor_ship_address_detail" class="form-control" value="" placeholder="주소상세">
										<input type="hidden" name="cor_ship_address4" value="" readonly>
									</div>

								</div>
								
								<div class="form-group">
									<label class="control-label">배송메모</label>
									<textarea name="cor_content" class="form-control " cols="5"></textarea>
								</div>
							</div>
						</div>
						<div class="info-wr dn">
							<div class="pay-info">
								<?php
									if(element('cor_pay_type',$view)=='f'){
										?>
										<div>
										<h5 class="market-title">열매상품 결제정보</h5>
										<ul>
											<li>
												<span class="info-tit">총 주문 열매</span>
												<strong><?php echo number_format($total_price_sum / element('company_coin_value',$view)); ?>개</strong>
											</li>
											<li>

											<!-- asmo sh 231215 br 및 span 태그 생성 -->
												<span class="info-tit">보유 열매 </span> <?php echo number_format((int) $this->member->item('mem_cur_fruit'));?> 개 <br>
													<span>
														( 최대
														<?php
														$max_f = min((int) $this->member->item('mem_cur_fruit') * element('company_coin_value',$view), $total_price_sum);
														echo number_format($max_f / element('company_coin_value',$view));
														?>
														개 까지 사용 가능 )
													</span>
											</li>
											<li>
												<?php
													if(($total_price_sum / element('company_coin_value',$view)) <= $this->member->item('mem_cur_fruit')){
														?>
														<span class="info-tit">사용 열매 </span> <input type="text" class="form-control px100" value="<?php echo $max_f / element('company_coin_value',$view); ?>"  readonly/>개
														<input type="hidden" name="order_fruit" id="order_fruit" class="form-control px100" value="<?php echo $max_f; ?>" />
														<?php
													}
												?>
											</li>
										</ul>
										</div>
										<?php
									}else if(element('cor_pay_type',$view)=='c'){
										?>
										<div>
										<h5 class="market-title">복지포인트 상품 결제정보</h5>
										<ul>
											<li>
												<span class="info-tit">총 주문 복지포인트</span>
												<strong><?php echo number_format($total_price_sum); ?>개</strong>
											</li>
											<li>

											<!-- asmo sh 231215 br 및 span 태그 생성 -->
												<span class="info-tit">보유 복지포인트 </span> <?php echo number_format((int) $this->member->item('mem_point'));?> 개 <br>
													<span>
														( 최대
														<?php
														$max_c = min((int) $this->member->item('mem_point'), $total_price_sum);
														echo number_format($max_c);
														?>
														개 까지 사용 가능 )
													</span>
											</li>
											<li>
												<?php
													if($total_price_sum <= $this->member->item('mem_point')){
														?>
														<span class="info-tit">사용 복지포인트 </span> <input type="text" name="order_coin" id="order_coin" class="form-control px100" value="<?php echo $max_c; ?>"  readonly/> 개
														<?php
													}
												?>
											</li>
										</ul>
										</div>
										<?php
									}
								?>
								<div style="display:none">
									<h5 class="market-title">결제정보</h5>
									<ul>
										<li>
											<span class="info-tit">총 주문</span>
											<strong><?php echo number_format($total_price_sum); ?>원</strong>
										</li>
										<li>
											<?php
											if ($this->cbconfig->item('use_deposit')) {
											?>
												<span class="info-tit">보유<?php echo html_escape($this->cbconfig->item('deposit_name')); ?> </span> <?php echo number_format((int) $this->member->item('total_deposit'));?> <?php echo html_escape($this->cbconfig->item('deposit_unit')); ?>
												( 최대
												<?php
												$max_deposit = min((int) $this->member->item('total_deposit'), $total_price_sum);
												echo number_format($max_deposit);
												echo html_escape($this->cbconfig->item('deposit_unit'));
												?>
												까지 사용 가능 )
											</li>
											<li>
												<input type="hidden" name="max_deposit" id="max_deposit" value="<?php echo $max_deposit; ?>" />
												<span class="info-tit">사용
												<?php echo html_escape($this->cbconfig->item('deposit_name')); ?> </span> <input type="text" name="order_deposit" id="order_deposit" class="form-control px100" value="0" /> 원
											<?php } else { ?>
												<input type="hidden" name="order_deposit" id="order_deposit" class="input" value="0" />
											<?php }?>
										</li>
									</ul>
								</div>
					
					
								<div class="feedback-box" style="display:none">
									<h5>결제수단</h5>
									<?php if ($this->cbconfig->item('use_payment_bank')) { ?>
										<label for="pay_type_bank" >
											<input type="radio" name="pay_type" value="bank" id="pay_type_bank" /> 무통장입금
										</label>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_payment_card')) { ?>
										<label for="pay_type_card" >
											<input type="radio" name="pay_type" value="card" id="pay_type_card" /> 신용카드
										</label>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_payment_realtime')) { ?>
										<label for="pay_type_realtime" >
											<input type="radio" name="pay_type" value="realtime" id="pay_type_realtime" /> 계좌이체
										</label>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_payment_vbank')) { ?>
										<label for="pay_type_vbank" >
											<input type="radio" name="pay_type" value="vbank" id="pay_type_vbank" /> 가상계좌
										</label>
									<?php } ?>
									<?php if ($this->cbconfig->item('use_payment_phone')) { ?>
										<label for="pay_type_phone" >
											<input type="radio" name="pay_type" value="phone" id="pay_type_phone" /> 휴대폰결제
										</label>
									<?php } ?>
										<label for="pay_type_f" >
											<input type="radio" name="pay_type" value="f" id="pay_type_f" /> 열매
										</label>
					
										<label for="pay_type_c" >
											<input type="radio" name="pay_type" value="c" id="pay_type_c" /> 복지포인트
										</label>
					
									</div>
									<?php
									if ($this->cbconfig->item('use_payment_pg')) {
										
										if(element('cor_pay_type',$view)=='f'){
											if(($total_price_sum / element('company_coin_value',$view)) > $this->member->item('mem_cur_fruit')){
												?><h5><?php echo cmsg("2103");?></h5><?php
											}else{
												$this->load->view('paymentlib/' . $this->cbconfig->item('use_payment_pg') . '/' . element('form3name', $view), $sform);
											}
										}else if(element('cor_pay_type',$view)=='c'){
											if($total_price_sum > $this->member->item('mem_point')){
												?><h5><?php echo cmsg("2104");?></h5><?php
											}else{
												$this->load->view('paymentlib/' . $this->cbconfig->item('use_payment_pg') . '/' . element('form3name', $view), $sform);
											}
										}else{
											$this->load->view('paymentlib/' . $this->cbconfig->item('use_payment_pg') . '/' . element('form3name', $view), $sform);
										}
					
									} ?>
								</div>
							</div>
						</div>
					
						
					</div>
			
				</div>
				<div class="asmo_cmall_fixed_box">
					<div class="well well-sm">
						<!-- 열매일 때 -->
						<p>필요한 <?php
									if(element('cor_pay_type',$view) == 'f'){
										echo '열매';
									}else{
										echo '포인트';
									}
									?> 합계</p>
						<div class="total_price">
							<strong>
								<span class="checked_price">
									<?php
									if(element('cor_pay_type',$view) == 'f'){
										echo number_format($total_price_sum / element('company_coin_value',$view));
									}else{
										echo number_format($total_price_sum);
									}
									?>
								</span> 개
							</strong>
						</div>
						<!-- //열매일 때 -->
		
						<!-- 포인트일 때 -->
						<!-- <p>필요한 포인트 합계</p>
						<div class="total_price">
							<strong>
								<span class="checked_price">0</span> 개
							</strong>
						</div> -->
						<!-- //포인트일 때 -->
		
					</div>
					<div class="asmo_fixed_btn_box"><button onClick="fpayment_check();" type="button" class="btn btn-order" ><span>교환하기</span></button></div>
				</div>
			</div>
			

			<?php echo form_close(); ?>
		</div>
	</div>
</div>



<?php
	if(element('cor_pay_type',$view)=='f' || element('cor_pay_type',$view)=='c'){
		?>
		<script type="text/javascript">

			function paytypefc(type){
				var genderRadios = document.getElementsByName("pay_type");

				// 라디오 버튼을 반복하면서 'f' or 'c' 값을 가진 것을 찾아 체크하기
				for (var i = 0; i < genderRadios.length; i++) {
					if (genderRadios[i].value == type) {
						genderRadios[i].checked = true;
						break; // 'f' 값을 찾으면 루프를 종료
					}
				}
			}
			
			paytypefc('<?php echo element('cor_pay_type',$view);?>');

		</script>
		<?php	
	}
?>


<script type="text/javascript">

$(document).ready(function() {

	$('.main').addClass('add');

	// shop 페이지일 때 사이드바 메뉴 활성화
	$('#shop').addClass('selected');
});

//<![CDATA[
$(document).on('change', 'input[name= pay_type]', function() {
	if ($("input[name='pay_type']:checked").val() === 'bank') {
		$('.bank-info').show();
	} else {
		$('.bank-info').hide();
	}
});
//]]>
</script>

<script type="text/javascript">
var use_pg = '<?php echo element('use_pg', $view) ? '1' : ''; ?>';
var pg_type = '<?php echo $this->cbconfig->item('use_payment_pg'); ?>';
var payment_unique_id = '<?php echo element('unique_id', $view); ?>';
var good_name = '<?php echo html_escape(element('good_name', $view)); ?>';
var ptype = 'cmall';
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/payment.js'); ?>"></script>
<?php
if ($this->cbconfig->item('use_payment_pg') && element('use_pg', $view)) {
	$this->load->view('paymentlib/' . $this->cbconfig->item('use_payment_pg') . '/' . element('form4name', $view), $sform);
}
