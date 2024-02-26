<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_js(base_url('assets/js/cmallitem.js')); ?>
 

<div id="asmo_item_detail_wrap" class="asmo_wish_wrap asmo_cart_wrap">
	<div class="page-header">
		<h4>장바구니</h4>
		<div class="top_right_box">
			<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
			<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
			<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
		</div>
	</div>

	<?php
	$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
	echo form_open(site_url('cmall/cart'), $attributes);
	?>

		<!-- asmo lhb 231222 카트 상단 공통 체크 영역 -->
		<div class="asmo_cart_common_chk">
			<div class="all-chk">
				<input type="checkbox" name="chkallf" id="chkallf" checked="checked" /> <label for="chkallf">열매상품 전체선택</label>
			</div>
			<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택상품 삭제</button>
		</div>
		

		<ul class="prd-list f-area">
			<?php
			$view_data = element('data', $view);
			$total_price_sum = 0;
			if ($view_data['f']) {
				foreach ($view_data['f'] as $result) {
			?>

				<li>

				<!-- asmo sh 231214 디자인 상 li 내 div들 재배치 -->
					<div class="col-xs-12 col-md-9 prd-info">

						<div class="cart_chk_name_box">
							<?php if(soldoutYn($result['cit_id'])=='y'){?>
								<div class="prd-chk">
									<input type="checkbox" name="chk[]" class="list-chkbox" id="<?php echo element('cit_id', $result); ?>" value="<?php echo element('cit_id', $result); ?>" checked="checked" disabled/>
									<label for="<?php echo element('cit_id', $result); ?>"></label>
								</div>
								<!-- <div><h1>품절</h1></div> -->
							<?php }else{ ?>
								<div class="prd-chk">
									<input type="checkbox" name="chk[]" class="list-chkbox" id="<?php echo element('cit_id', $result); ?>" value="<?php echo element('cit_id', $result); ?>" checked="checked"/>
									<label for="<?php echo element('cit_id', $result); ?>"></label>
								</div>
							<?php } ?>
							<a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" ><?php echo html_escape(element('cit_name', $result)); ?></a>
						</div>
						
						<div class="cart_info_box">
							<!-- asmo sh 231214 썸네일 이미지 style 삭제 -->
							<div class="prd-img"><a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" ><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 60, 60); ?>" class="thumbnail" alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" /></a></div>
							<div class="cart_option_box">
								<?php if(soldoutYn($result['cit_id'])=='y'){?>
									<div class="soldout_box"><span><?=banner('error')?>품절</span></div>
								<?php } ?>
								<ul class="cmall-options">
								<?php
								$total_num = 0;
								$total_price = 0;
								foreach (element('detail', $result) as $detail) {
								?>
									<li><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cct_count', $detail);?>개 (+<?php echo number_format(element('cde_price', $detail), $result)); ?>개)</li>
								<?php
									$total_num += element('cct_count', $detail);
									$total_price += ((int) element('cit_price', $result) + (int) element('cde_price', $detail)) * element('cct_count', $detail);
								}
								
								?>
								</ul>
								<div class="col-xs-12 col-md-3 prd-price">
									<div><span>수량 </span> <?php echo number_format($total_num); ?> 개</div>
									<div><span>상품단가  </span> 열매 <?php echo number_format(element('fruit_cit_price', $result)); ?> 개</div>
									<div class="prd-total"><span>합계  </span> 열매 <?php echo number_format($total_price); ?><input type="hidden" name="total_price[<?php echo element('cit_id', $result); ?>]" value="<?php echo $total_price; ?>" /> 개</div>
									<div class="cmall-option-change">
										<button class="change_option btn btn-info btn-xs" type="button" data-cit-id="<?php echo element('cit_id', $result); ?>">옵션 / 수량 변경</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>

			<?php
				}
			}
			if ( ! $view_data['f']) {
			?>
				<li class="nopost">장바구니가 비어있습니다</li>
			<?php
			}
			?>
		</ul>


		<div class="asmo_cart_common_chk asmo_coin_goods_cart">
			<div class="all-chk">
				<input type="checkbox" name="chkallc" id="chkallc" /> <label for="chkallc">복지포인트상품 전체선택</label>
			</div>
			<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택상품 삭제</button>
		</div>

		<ul class="prd-list c-area">
			<?php
			if ($view_data['c']) {
				foreach ($view_data['c'] as $result) {
			?>

			<li>

			<!-- asmo sh 231214 디자인 상 li 내 div들 재배치 -->
				<div class="col-xs-12 col-md-9 prd-info">


					<div class="cart_chk_name_box">
						<?php if(soldoutYn($result['cit_id'])=='y'){?>
							<div class="prd-chk">
								<input type="checkbox" id="<?php echo element('cit_id', $result); ?>" name="chk[]" class="list-chkbox" value="<?php echo element('cit_id', $result); ?>" disabled/>
								<label for="<?php echo element('cit_id', $result); ?>"></label>
							</div>
							<!-- <div><h1>품절</h1></div> -->
						<?php }else{ ?>
							<div class="prd-chk">
								<input type="checkbox" id="<?php echo element('cit_id', $result); ?>" name="chk[]" class="list-chkbox" value="<?php echo element('cit_id', $result); ?>" />
								<label for="<?php echo element('cit_id', $result); ?>"></label>
							</div>
							<?php } ?>
						<a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" ><?php echo html_escape(element('cit_name', $result)); ?></a>
					</div>

					<div class="cart_info_box">
						<!-- asmo sh 231214 썸네일 이미지 style 삭제 -->
						<div class="prd-img"><a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" ><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 60, 60); ?>" class="thumbnail" alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" /></a></div>
						<div class="cart_option_box">

							<?php if(soldoutYn($result['cit_id'])=='y'){?>
								<div class="soldout_box"><span><?=banner('error')?>품절</span></div>
							<?php } ?>

							<ul class="cmall-options">
							<?php
							$total_num = 0;
							$total_price = 0;
							foreach (element('detail', $result) as $detail) {
							?>
								<li><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cct_count', $detail);?>개 (+<?php echo number_format(element('cde_price', $detail)); ?>개)</li>
							<?php
								$total_num += element('cct_count', $detail);
								$total_price += ((int) element('cit_price', $result) + (int) element('cde_price', $detail)) * element('cct_count', $detail);
							}
							// $total_price_sum += $total_price;
							?>
							</ul>
							<div class="col-xs-12 col-md-3 prd-price">
								<div><span>수량</span> <?php echo number_format($total_num); ?> 개</div>
								<div><span>상품단가 </span> 복지포인트 <?php echo number_format(element('cit_price', $result)); ?> 개</div>
								<div class="prd-total"><span>합계 </span> 복지포인트 <?php echo number_format($total_price); ?><input type="hidden" name="total_price[<?php echo element('cit_id', $result); ?>]" value="<?php echo $total_price; ?>" /> 개</div>
								<div class="cmall-option-change">
									<button class="change_option btn btn-info btn-xs" type="button" data-cit-id="<?php echo element('cit_id', $result); ?>">옵션 / 수량 변경</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>

			<?php
				}
			}
			if ( ! $view_data['c']) {
			?>
				<li class="nopost">장바구니가 비어있습니다</li>
			<?php
			}
			?>
		</ul>

		
		<div class="cart_fixed_box_wrap">
			<div class="cart_fixed_box">
				<div class="well well-sm">
					<div class="total_price">총 결제액 <strong><span class="checked_price"><?php echo number_format($total_price_sum); ?></span> 개</strong></div>
				</div>
				<button type="button" class="btn btn-black btn-list-selected pull-right btn-order" >주문하기</button>
			</div>
		</div>


	<?php echo form_close(); ?>

</div>	

<script type="text/javascript">


//asmo lhb 231218 클래스 영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');


//<![CDATA[

	jQuery(function($) {
	var close_btn_idx;

	function item_sum(){
		var sum = 0;
		$('.list-chkbox:checked').each(function () {
			sum += parseInt($("input[name='total_price[" + $(this).val() + "]']").val());
		});
		$('.checked_price').text(number_format(sum.toString()));
	}

	$(document).on('change', '.list-chkbox', function() {
		item_sum();
	});

	item_sum();

	// 선택사항수정
	$(document).on('click', '.change_option', function() {
		var cit_id = $(this).attr('data-cit-id');
		var $this = $(this);
		close_btn_idx = $('.change_option').index($(this));

		$.post(
			cb_url + '/cmall/cartoption',
			{ cit_id: cit_id, csrf_test_name: cb_csrf_hash },
			function(data) {
				$('#cart_option_modify').remove();
				$this.after("<div id=\"cart_option_modify\"></div>");
				$('#cart_option_modify').html(data);
			}
		);
	});

	// 모두선택
	$(document).on('click', 'input[name=ct_all]', function() {
		if ($(this).is(':checked')) {
			$('input[name^=ct_chk]').attr('checked', true);
		} else {
			$('input[name^=ct_chk]').attr('checked', false);
		}
	});

	// 옵션수정 닫기
	$(document).on('click', '#mod_option_close', function() {
		$('#cart_option_modify').remove();
		$('.change_option').eq(close_btn_idx).focus();
	});


	$('#chkallf').on('click',function(){

		if ($(this).is(':checked')) {
			$('.f-area input[name="chk[]"]').attr('checked', true);
			$('.c-area input[name="chk[]"]').attr('checked', false);
			$('#chkallc').attr('checked',false);
		} else {
			$('.f-area input[name="chk[]"]').attr('checked', false);
		}

	});


	$('#chkallc').on('click',function(){

		if ($(this).is(':checked')) {
			$('.c-area input[name="chk[]"]').attr('checked', true);
			$('.f-area input[name="chk[]"]').attr('checked', false);
			$('#chkallf').attr('checked',false);
		} else {
			$('.c-area input[name="chk[]"]').attr('checked', false);
		}
		
	});


	$('.f-area input[name="chk[]"]').click(function(){
		if ($(this).is(':checked')) {
			$('.c-area input[name="chk[]"]').attr('checked', false);
		}
	});

	$('.c-area input[name="chk[]"]').click(function(){
		if ($(this).is(':checked')) {
			$('.f-area input[name="chk[]"]').attr('checked', false);
		}
	});


	$(".btn-order").click(function(){

		fcount = $('.f-area input[name="chk[]"]:checked').length;

		ccount = $('.c-area input[name="chk[]"]:checked').length;


		if(fcount == 0 && ccount == 0){
			alert('주문할 상품을 선택해주세요.');
			return;
		}

		if(fcount > 0 && ccount > 0){
			alert('열매상품 또는 복지포인트상품 한 종류만 선택해주세요.');
			return;
		}

		if(fcount > 0 && ccount == 0){
			$('#flist').submit();
			return;
		}

		if(fcount == 0 && ccount > 0){
			$('#flist').submit();
			return;
		}

	});
});
//]]>
</script>
