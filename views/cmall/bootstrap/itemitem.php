<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_js(base_url('assets/js/cmallitem.js')); ?>

<style>
	body {
		background: transparent linear-gradient(180deg, #000000 0%, #3E3E3E 100%);
		background-attachment: fixed;
		color: #fff;
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

    a{
        color:white;
    }
    a:hover{
        color:orange;
    }
</style>

<!-- asmo sh 231205 shop div#item 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_cmall">
	<div class="asmo_cmall_market" id="itemitem">

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

		<div class="product_box_wrap_top">
			<strong>컬래버랜드 아이템교환소<!-- 리스트 페이지 제목 들어가야 합니다. --> </strong>
		</div>

		<?php if (element('header_content', element('data', $view))) { ?>

			<!-- asmo sh 231206 디자인 상 header-content 불필요하여 주석 처리 -->
			<!-- <div class="product-detail"><?php echo element('header_content', element('data', $view)); ?></div> -->
		<?php } ?>
		<div class="product_box_wrap">
			
			<div class="product-box mb20">
				<div class="product-left col-xs-12 col-lg-6">
					<div class="prd-slide">
						<div class="item_slider">
							<?php
							for ($i =1; $i <=10; $i++) {
								if ( ! element('cit_file_' . $i, element('data', $view))) {
									continue;
								}
							?>
								<div><img src="<?php echo thumb_url('cmallitem', element('cit_file_' . $i, element('data', $view)), 450, 450); ?>" alt="<?php echo html_escape(element('cit_name', element('data', $view))); ?>" title="<?php echo html_escape(element('cit_name', element('data', $view))); ?>" onClick="window.open('<?php echo site_url('cmall/itemimage/' . html_escape(element('cit_key', element('data', $view)))); ?>', 'win_image', 'left=100,top=100,width=730,height=700,scrollbars=1');" /></div>
							<?php } ?>
						</div>
						<span class="prev" id="slider-prev"></span>
						<span class="next" id="slider-next"></span>
					</div>
					<?php if (element('demo_user_link', element('meta', element('data', $view))) OR element('demo_admin_link', element('meta', element('data', $view)))) { ?>
					<div class="prduct-demo">
						<?php if (element('demo_user_link', element('meta', element('data', $view)))) { ?>
							<a href="<?php echo site_url('cmallact/link/user/' . element('cit_id', element('data', $view))); ?>" target="_blank"><span class="btn-default btn-sm btn">샘플사이트</span></a>
						<?php } ?>
						<?php if (element('demo_admin_link', element('meta', element('data', $view)))) { ?>
							<a href="<?php echo site_url('cmallact/link/admin/' . element('cit_id', element('data', $view))); ?>" target="_blank"><span class="btn-default btn-sm btn">관리자사이트</span></a>
						<?php } ?>
					</div>
					<?php } ?>
				</div>

				<!-- asmo sh 231206 디자인 상 상품 제목 제외하고 주석처리 및 fixed div로 재배치 -->
				<div class="product-right col-xs-12 col-lg-6">

                    <!-- 네비게이터 -->
                    <div class="item_navi">
                        <a href="<?php echo site_url('cmall/lists/6?search_cate_sno_parent_sno='.element('depth', element('data', $view))[0]["cate_parent"].'&search_cate_sno='.element('depth', element('data', $view))[0]["cate_sno"].'&search_set_item=0'); ?>"><?php echo element('depth', element('data', $view))[0]["text"]; ?></a>
                        > 
                        <a href="<?php echo site_url('cmall/lists/6?search_cate_sno_parent_sno='.element('depth', element('data', $view))[1]["cate_parent"].'&search_cate_sno='.element('depth', element('data', $view))[1]["cate_sno"].'&search_set_item='.element('depth', element('data', $view))[1]["set"]); ?>"><?php echo element('depth', element('data', $view))[1]["text"]; ?></a>
                    </div>
                    
					<div class="product-title"><?php echo html_escape(element('cit_name', element('data', $view))); ?></div>

					<div class="cart_total_price">
						<div class="total_price_type">
							<?php echo banner('fruit'); ?>
						</div>
						<div class="total_order_price_box"><span id="total_order_price">0</span>개</div>
					</div>

					<div class="product-intro">
						<p><?php echo nl2br(element('cit_summary', element('data', $view))); ?></p>
					</div>

					<?php
					if (element('detail', element('data', $view))) {
						$attributes = array('class' => 'form-horizontal', 'name' => 'fitem', 'id' => 'fitem', 'onSubmit' => 'return fitem_submit(this)');
						echo form_open(current_full_url(), $attributes);
					?>
						<input type="hidden" name="stype" id="stype" value="" />
						<input type="hidden" name="cit_id" value="<?php echo element('cit_id', element('data', $view)); ?>" />
						<div class="product-option dn">
							<ul>
							<?php
							foreach (element('detail', element('data', $view)) as $detail) {
								$price = element('cit_price', element('data', $view)) + element('cde_price', $detail);
							?>
								<li>
									<div class="opt-name">
										<span class="span-chk">

											<!-- asmo sh 231214 디자인 상 체크박스 커스텀 위해 input에 id 추가 및 label 생성 -->
											<input type="checkbox" name="chk_detail[]" id="<?php echo element('cde_id', $detail); ?>" value="<?php echo element('cde_id', $detail); ?>" />
											<label for="<?php echo element('cde_id', $detail); ?>"></label>

											
										</span>

										<!-- asmo sh 231219 디자인 상 최종 가격에 옵션가격이 들어가는 것이 아닌 상품 제목 옆에 옵션가격 추가 -->
										<?php echo html_escape(element('cde_title', $detail)); ?> (+<?php echo (int) element('cde_price', $detail); ?>개)
									</div>
									<div>
										<span class="span-qty">
											<?php 
												$button_disabled = "";
												$button_readonly = "";
												if($view['data']['cit_one_sale'] == "y"){
													$button_disabled = "disabled";
													$button_readonly = "readonly";
												}
											?>
											<div class="btn-group" role="group" aria-label="...">
												<button type="button" class="btn btn-default btn-xs btn-change-qty" data-change-type="minus" <?php echo $button_disabled;?>>-</button>
												<input type="text" name="detail_qty[<?php echo element('cde_id', $detail); ?>]" class="btn btn-default btn-xs detail_qty" value="1" <?php echo $button_readonly;?>/>
												<button type="button" class="btn btn-default btn-xs btn-change-qty" data-change-type="plus" <?php echo $button_disabled;?>>+</button>
											</div>
										</span>
										<span class="detail_price">
											<input type="hidden" name="item_price[<?php echo element('cde_id', $detail); ?>]" value="<?php echo $price; ?>" />
											<span><?php echo number_format($price - element('cde_price', $detail)); ?> </span>개
										</span>
									</div>
								</li>
							<?php } ?>
							</ul>
							<div class="cart_total_price">총금액 : <div class="total_order_price_box"><span id="total_order_price">0</span>개</div></div>
						</div>
						<div class="item-btn">

							<?php 
								if(soldoutYn($view['data']['cit_id'])=='y'){
							?>
							<div>
								<h1><?php echo cmsg("1101");?></h1>
							</div>
							<?php
								}else{
							?>
								
								<?php
									if($view['data']['cit_one_sale']=="y"){
										?>
										<a href="javascript:void(0);" class="btn btn-cart btn-border" disabled>장바구니</a>
										<?php
									}else{
										?>
										<a href="javascript:;" id="cart_layer_open_btn" class="btn btn-cart btn-border">장바구니</a>
										<?php
									}
									?>
								
								<!-- asmo sh 231207 구매하기, 장바구니 버튼 클릭 시 팝업 레이어 생성하는 버튼으로 변경 -->
								<a href="javascript:;" id="order_layer_open_btn" class="btn btn-order">교환하기</a>
							<?php
								}
							?>


						</div>

						<!-- asmo sh 231207 구매하기 팝업 레이어 생성 -->
						<div class="popup_layer_bg" id="order_layer">
							<div class="order_layer_wrap">
								<div class="order_layer_box">
									<span>교환 하시겠습니까?</span>
									<div class="order_btn_box">
										<button type="submit" onClick="$('#stype').val('order');" class="btn btn-order">확인</button>
										<button type="button" id="order_layer_close_btn" class="btn btn-default">취소</button>
									</div>
								</div>
							</div>
						</div>

						<!-- asmo sh 231207 장바구니 팝업 레이어 생성 -->
						<div class="popup_layer_bg" id="cart_layer">
							<div class="order_layer_wrap">
								<div class="order_layer_box">
									<span>장바구니에 담으시겠습니까?</span>
									<div class="order_btn_box">
										<button type="submit" onClick="$('#stype').val('cart');" class="btn btn-order">확인</button>
										<button type="button" id="cart_layer_close_btn" class="btn btn-default">취소</button>
									</div>
								</div>
							</div>
						</div>
					<?php
						echo form_close();
					}
					?>
					
				</div>
			</div>
				
			<div class="product-info mb20 selected">
				<ul class="product-info-top" id="itemtabmenu1">
					<li class="current">
						<a href="#itemtabmenu1">
						
						상세설명

						
						
						</a>
					</li>
					<li>
						<a href="#itemtabmenu2">
							<div>상품후기 <span class="item_review_count"><?php echo number_format(element('cit_review_count', element('data', $view)));?></span></div>
							
							
						</a>
					</li>
					<li>
						<a href="#itemtabmenu3">
							<div>상품문의 <span class="item_qna_count"><?php echo number_format(element('cit_qna_count', element('data', $view)));?></span></div>

							
						</a>
					</li>
				</ul>
				<div class="product-detail"><?php echo element('content', element('data', $view)); ?></div>
			</div>
			<div class="product-info mb40">
				<ul class="product-info-top" id="itemtabmenu2">
					<li>
						<a href="#itemtabmenu1">
							상세설명
							
							
						</a>
					</li>
					<li class="current">
						<a href="#itemtabmenu2">
							
						<div>상품후기 <span class="item_review_count"><?php echo number_format(element('cit_review_count', element('data', $view)));?></span></div>

						
					
						</a>
					</li>
					<li>
						<a href="#itemtabmenu3">
							<div>상품문의 <span class="item_qna_count"><?php echo number_format(element('cit_qna_count', element('data', $view)));?></span></div>
							
							
						</a>
					</li>
				</ul>

				<!-- asmo sh 231207 디자인 상 버튼 div.btn-wr 위치를 컨텐츠 위로 옮기고 div.view_detail_wrap 생성 후 감싸기 -->
				<div class="view_detail_wrap">
					<div class="btn-wr">

						<!-- asmo sh 231207 작성하기 버튼 텍스트 변경 및 배너 이미지 추가 -->
						<!-- asmo sh 231207 작성하기 팝업 레이어창으로 바꾸기위해 onClick 함수 변경 -->
						<!-- <a href="javascript:;" class="btn btn-primary" onClick="loadIntoIframe('<?php echo site_url('cmall/review_write/' . element('cit_id', element('data', $view))); ?>', 600, 770); return false;">작성하기 <?=banner('write')?></a> -->
						<a href="javascript:;" class="btn btn-primary" id="review_write_btn">작성하기 <?=banner('write')?></a>
					</div>
					<div id="viewitemreview"></div>
				</div>
			</div>
			<div class="product-info mb40">
				<ul class="product-info-top" id="itemtabmenu3">
					<li>
						<a href="#itemtabmenu1">
							상세설명
							
						</a>
					</li>
					<li>
						<a href="#itemtabmenu2">
							<div>상품후기 <span class="item_review_count"><?php echo number_format(element('cit_review_count', element('data', $view)));?></span></div>
							
							
						</a>
					</li>
					<li class="current">
						<a href="#itemtabmenu3">
							<div>상품문의 <span class="item_qna_count"><?php echo number_format(element('cit_qna_count', element('data', $view)));?></span></div>

							

						</a>
					</li>
				</ul>

				<!-- asmo sh 231207 디자인 상 버튼 div.btn-wr 위치를 컨텐츠 위로 옮기고 div.view_detail_wrap 생성 후 감싸기 -->
				<div class="view_detail_wrap">
					<div class="btn-wr">

						<!-- asmo sh 231207 작성하기 버튼 텍스트 변경 및 배너 이미지 추가 -->
						<!-- <a href="javascript:;" class="btn btn-primary " onClick="window.open('<?php echo site_url('cmall/qna_write/' . element('cit_id', element('data', $view))); ?>', 'qna_popup', 'width=750,height=770,scrollbars=1'); return false;">작성하기 <?=banner('write')?></a> -->
						<a href="javascript:;" class="btn btn-primary " id="qna_write_btn">작성하기 <?=banner('write')?></a>
					</div>
					<div id="viewitemqna"></div>
				</div>
			</div>
			<?php if (element('footer_content', element('data', $view))) { ?>
				<div class="product-detail"><?php echo element('footer_content', element('data', $view)); ?></div>
			<?php } ?>
		</div>

	</div>
</div>

<!-- asmo sh 231207 상품후기 팝업 레이어 생성 -->
<div class="popup_layer_bg" id="review_write">
	<iframe style="width: 600px; height: 660px; position:absolute; top:50%; left:50%; transform: translate(-50%, -50%);" src="" frameborder="0"></iframe>
</div>

<!-- asmo sh 231207 상품문의 팝업 레이어 생성 -->
<div class="popup_layer_bg" id="qna_write">
	<iframe style="width: 600px; height: 660px; position:absolute; top:50%; left:50%; transform: translate(-50%, -50%);" src="" frameborder="0"></iframe>
</div>






<script type="text/javascript" src="<?php echo base_url('assets/js/bxslider/jquery.bxslider.min.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function() {

		$(".product-info-top li a").click(function(event) {
			event.preventDefault(); // 기본 이벤트 동작 방지

			// 모든 product-info 요소에서 selected 클래스 제거
			$(".product-info").removeClass("selected");
			
			// 클릭된 탭에 해당하는 product-info의 ID를 가져옴
			var targetId = $(this).attr("href");

			// 가져온 ID를 이용하여 해당 product-info를 선택
			$(targetId).parent().addClass("selected");
		});
			
		if ($('.asmo_cmall .asmo_cmall_market .product-right > form .product-option li').length > 0) {
			setTimeout(() => {
				
				$('.asmo_cmall .asmo_cmall_market .product-right > form .product-option li .opt-name input[type=checkbox]').trigger('click');

				console.log('triggered');
			}, 10);

			$('.asmo_cmall .asmo_cmall_market .product-right > form .product-option li .opt-name .span-chk label').addClass('dn');
		}

		$('#order_layer_open_btn').click(function() {
			$('#order_layer').css('display', 'flex');
			$('body,html').css({'overflow':'hidden'});
		});

		$('#order_layer_close_btn').click(function() {
			$('#order_layer').css('display', 'none');
			$('body,html').css({'overflow':'initial'});
		});

		$('#cart_layer_open_btn').click(function() {
			$('#cart_layer').css('display', 'flex');
			$('body,html').css({'overflow':'hidden'});
		});

		$('#cart_layer_close_btn').click(function() {
			$('#cart_layer').css('display', 'none');
			$('body,html').css({'overflow':'initial'});
		});
		
		$('#review_write_btn').click(function() {
			let iframeSrc = '<?php echo site_url('cmall/review_write/' . element('cit_id', element('data', $view))); ?>';
			$('#review_write iframe').attr('src', iframeSrc);
			
			$('#review_write').css('display', 'block');
		});

		$('#qna_write_btn').click(function() {
			let iframeSrc = '<?php echo site_url('cmall/qna_write/' . element('cit_id', element('data', $view))); ?>';
			$('#qna_write iframe').attr('src', iframeSrc);
			
			$('#qna_write').css('display', 'block');
		});

		$("#review_write iframe, #qna_write iframe").load(function() {
			let dimCloseBtn = $("#review_write iframe, #qna_write iframe").contents().find(".btn-default");
			let dimSubmitBtn = $("#review_write iframe, #qna_write iframe").contents().find(".btn-primary");
			
			dimCloseBtn.click(function() {
				$('#review_write').css('display', 'none');
				$('#qna_write').css('display', 'none');
			});
			
		})
		

		$('.main').addClass('add');

		// shop 페이지일 때 사이드바 메뉴 활성화
		$('#shop').addClass('selected');
	});


//<![CDATA[
jQuery(function($){

	$('.item_slider').bxSlider({
		pager : false,
		nextSelector: '#slider-next',
		prevSelector: '#slider-prev',

		// bxslider 버튼 이미지 변경
		// nextText: '<img src="<?php echo element('view_skin_url', $layout); ?>/images/btn_next.png" alt="다음" title="다음" />',
		// prevText: '<img src="<?php echo element('view_skin_url', $layout); ?>/images/btn_prev.png" alt="이전" title="이전" />'

		nextText: '<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/cmall/shop_arrow_R.svg" alt="다음" title="다음" />',
		prevText: '<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/cmall/shop_arrow_L.svg" alt="이전" title="이전" />'
	});

	$(document).ready(function($) {
		view_cmall_review('viewitemreview', '<?php echo element('cit_id', element('data', $view)); ?>', '', '');
		view_cmall_qna('viewitemqna', '<?php echo element('cit_id', element('data', $view)); ?>', '', '');
	});


	$('#total_order_price').on("item_total_order_price", function(e){

		var tot_price = 0,
			price = 0,
			qty = 0,
			$sel = jQuery('input[name^=chk_detail]:checked'),
			$total_order_price = $(this);

        if($sel.size() == 0){
            jQuery('input[name="chk_detail[]"]:eq(0)').prop( "checked", true );
            $sel = jQuery('input[name^=chk_detail]:checked');
        }

		if ($sel.size() > 0) {
			$sel.each(function() {

				price = parseInt($(this).closest('li').find('input[name^=item_price]').val());
				qty = parseInt($(this).closest('li').find('input[name^=detail_qty]').val());
				
				tot_price += (price * qty);
			});
		}

		$total_order_price.text(number_format(String(tot_price)));

		return false;
	});

	$("button.btn-change-qty").on("item_change_qty", function(e){
		var change_type = $(this).attr('data-change-type');
		var $qty = $(this).closest('li').find('input[name^=detail_qty]');
		var qty = parseInt($qty.val().replace(/[^0-9]/g, ""));
		if (isNaN(qty)) {
			qty = 1;
		}

		if (change_type === 'plus') {
			qty++;
			$qty.val(qty);
		} else if (change_type === 'minus') {
			qty--;
			if (qty < 1) {
				alert('수량은 1이상 입력해 주십시오.');
				$qty.val(1);
				return false;
			}

			$qty.val(qty);
		}

		item_price_calculate();

		return false;
	});

	$("#fitem").on("item_form_submit", function(e){

		// 수량체크
		var is_qty = true;
		var detail_qty = 0;
		var $el_chk = jQuery('input[name^=chk_detail]:checked');

		$el_chk.each(function() {
			detail_qty = parseInt($(this).closest('li').find('input[name^=detail_qty]').val().replace(/[^0-9]/g, ""));
			if (isNaN(detail_qty)) {
				detail_qty = 0;
			}

			if (detail_qty < 1) {
				is_qty = false;
				return false;
			}
		});

		if ( ! is_qty) {
			alert('수량을 1이상 입력해 주십시오.');
			return false;
		}

		return false;
	});
});
//]]>
</script>
