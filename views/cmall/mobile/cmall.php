<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<!-- <h5 class="cmall-main-title">추천상품</h5> -->
<div class="cmall-list" style="display:none;">
	<div class="row">
	<?php
	if (element('type1', $view)) {
		foreach (element('type1', $view) as $item) {
	?>
		<div class="main_box pull-left">
			<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
				<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 180, 180); ?>" alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" class="thumbnail" />
			</a>
			<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
			<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
			<ul class="cmall-detail">
				<li><i class="fa fa-heart"></i> 찜 <?php echo number_format((int) element('cit_wish_count', $item)); ?></li>
				<li><i class="fa fa-shopping-cart"></i> 구매 <?php echo number_format((int) element('cit_sell_count', $item)); ?></li>
				<li class="cmall-price pull-right"> <?php echo number_format((int) element('cit_price', $item)); ?>원</li>
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>

<!-- <div class="clearfix"></div> -->

<!-- <h5 class="cmall-main-title">인기상품</h5> -->
<div class="cmall-list" style="display:none;">
	<div class="row">
	<?php
	if (element('type2', $view)) {
		foreach (element('type2', $view) as $item) {
	?>
		<div class="main_box pull-left">
			<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
				<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 180, 180); ?>" alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" class="thumbnail" />
			</a>
			<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
			<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
			<ul class="cmall-detail">
				<li><i class="fa fa-heart"></i> 찜 <?php echo number_format((int) element('cit_wish_count', $item)); ?></li>
				<li><i class="fa fa-shopping-cart"></i> 구매 <?php echo number_format((int) element('cit_sell_count', $item)); ?></li>
				<li class="cmall-price pull-right"> <?php echo number_format((int) element('cit_price', $item)); ?></li>
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>

<!-- <div class="clearfix"></div> -->

<!-- <h5 class="cmall-main-title">최신상품</h5> -->
<div class="cmall-list" style="display:none;">
	<div class="row">
	<?php
	if (element('type3', $view)) {
		foreach (element('type3', $view) as $item) {
	?>
		<div class="main_box pull-left">
			<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
				<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 170, 170); ?>" alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" class="thumbnail" />
			</a>
			<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
			<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
			<ul class="cmall-detail">
				<li><i class="fa fa-heart"></i> 찜 <?php echo number_format((int) element('cit_wish_count', $item)); ?></li>
				<li><i class="fa fa-shopping-cart"></i> 구매 <?php echo number_format((int) element('cit_sell_count', $item)); ?></li>
				<li class="cmall-price pull-right"> <?php echo number_format((int) element('cit_price', $item)); ?></li>
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>

<!-- <div class="clearfix"></div> -->

<!-- <h5 class="cmall-main-title">할인상품</h5> -->
<div class="cmall-list" style="display:none;">
	<div class="row">
	<?php
	if (element('type4', $view)) {
		foreach (element('type4', $view) as $item) {
	?>
		<div class="main_box pull-left">
			<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
				<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 180, 180); ?>" alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" class="thumbnail" />
			</a>
			<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
			<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
			<ul class="cmall-detail">
				<li><i class="fa fa-heart"></i> 찜 <?php echo number_format((int) element('cit_wish_count', $item)); ?></li>
				<li><i class="fa fa-shopping-cart"></i> 구매 <?php echo number_format((int) element('cit_sell_count', $item)); ?></li>
				<li class="cmall-price pull-right"> <?php echo number_format((int) element('cit_price', $item)); ?></li>
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>

<!-- 컬래버랜드 cmall 요소 시작 -->
<div id="asmo_cmall">
	<div class="asmo_cmall_index">
		<div class="cmall_top_wrap">
			<div class="top_left_box">
				<div class="status_box" class="status_popup_open">
					<div class="status_info asmo_fruit">
						<em></em><span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?> 개</span>
					</div>
				</div>
				<div class="status_box" class="status_popup_open">
					<div class="status_info asmo_point">
						<em></em><span id="coin_count"><?php echo html_escape($this->member->item('mem_point')); ?> 개</span>
					</div>
				</div>
			</div>
			<div class="top_right_box">
				<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
				<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
				<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
			</div>
		</div>

		<div class="swiper-wrap cmall_index_slider_wrap">
			<div class="cmall_index_slide swiper mySwiper swiper-container">
				<ul class="swiper-wrapper">
					<?=banner('shop_adv_mo','','','<li class="swiper-slide">','</li>')?>
				</ul>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-pagination"></div>
		</div>


		<div class="asmo_common_goods_list asmo_itemmall_recom">
			<div class="reco_top_box">
				<strong><span>아이템몰</span> 추천상품</strong>
				<a href="<?php echo site_url('cmall/lists/6'); ?>">더보기</a>
			</div>

			<div class="reco_cont_wrap">

			<?php
			if (element('type1', $view)) {
				foreach (element('type1', $view) as $item) {
			?>
				<div class="reco_cont">
						<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
							<a onClick="alert('베타테스트 기간에는 구매가 불가합니다');">
						<?php }else{ ?>
							<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>">
						<?php } ?>

						<div class="cont_img">
							<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item)); ?>" alt="">

							<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
							<div class="soldout_mask">
								<span>구매 불가</span>
							</div>
							<?php } ?>
								
						</div>
						<div class="cont_info">
							<div class="cont_info_title">
								<p><?php echo html_escape(element('cit_name', $item)); ?></p>
								<span><?php echo element('cit_summary', $item); ?></span>
							</div>
							<div class="cont_info_desc">
								<div class="info_desc_left">
									<div class="info_desc_box">
										<span id="heart_cnt"><?php echo number_format(element('cit_wish_count', $item)); ?></span>
									</div>
									<div class="info_desc_box">
										<span id="buy_cnt"><?php echo number_format(element('cit_sell_count', $item)); ?></span>
									</div>
								</div>

								<div class="info_desc_right">
									<?php
										if($item['cit_money_type']=='f'){
											?>
											<span id="price" class="asmo_price_fruit"><?php echo number_format(element('fruit_cit_price', $item)); ?></span>개
											<?php
										}else{
											?>
											<span id="price" class="asmo_price_coin"><?php echo number_format(element('cit_price', $item)); ?></span>개
											<?php
										}
									?>
								</div>
							</div>
						</div>
					</a>
				</div>
				<?php
					}
				}
				?>
				
			</div>
		</div>
		<div class="asmo_common_goods_list asmo_cmall_bottom_list_wrap">
			<div class="cmall_official cmall_reco">
				<div class="reco_top_box">
					<strong><span>공식몰</span> 추천상품</strong>
					<a href="<?php echo site_url('cmall/lists/1'); ?>">더보기</a>
				</div>

				<div class="reco_cont_wrap">

					<?php
					if (element('type2', $view)) {
						foreach (element('type2', $view) as $item) {
					?>
					<div class="reco_cont">
						<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
							<a onClick="alert('베타테스트 기간에는 구매가 불가합니다');">
						<?php }else{ ?>
							<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>">
						<?php } ?>
							<div class="cont_img">
								<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item)); ?>" alt="">
								
								<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
								<div class="soldout_mask">
									<span>구매 불가</span>
								</div>
								<?php } ?>
								
							</div>
							<div class="cont_info">
								<div class="cont_info_title">
									<p><?php echo html_escape(element('cit_name', $item)); ?></p>
									<span><?php echo element('cit_summary', $item); ?></span>
								</div>
								<div class="cont_info_desc">
									<div class="info_desc_left">
										<div class="info_desc_box">
											<span id="heart_cnt"><?php echo number_format(element('cit_wish_count', $item)); ?></span>
										</div>

										<div class="info_desc_box">
											<span id="buy_cnt"><?php echo number_format(element('cit_sell_count', $item)); ?></span>
										</div>
									</div>

									<div class="info_desc_right">
										<?php
											if($item['cit_money_type']=='f'){
												?>
												<span id="price" class="asmo_price_fruit"><?php echo number_format(element('fruit_cit_price', $item)); ?></span>개
												<?php
											}else{
												?>
												<span id="price" class="asmo_price_coin"><?php echo number_format(element('cit_price', $item)); ?></span>개
												<?php
											}
										?>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php
						}
					}
					?>

				</div>
			</div>
			<div class="cmall_company cmall_reco">
				<div class="reco_top_box">
					<strong><span><?=busiNm($this->member->item('company_idx'))?></span> 추천상품</strong>
					<a href="<?php echo site_url('cmall/lists/2'); ?>">더보기</a>
				</div>

				<div class="reco_cont_wrap">
				<?php
					if (element('type3', $view)) {
						foreach (element('type3', $view) as $item) {
					?>
					<div class="reco_cont">
						<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
							<a onClick="alert('베타테스트 기간에는 구매가 불가합니다');">
						<?php }else{ ?>
							<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>">
						<?php } ?>
							<div class="cont_img">
								<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 420, 300); ?>" alt="">

								<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
								<div class="soldout_mask">
									<span>구매 불가</span>
								</div>
								<?php } ?>
								
							</div>
							<div class="cont_info">
								<div class="cont_info_title">
									<p><?php echo html_escape(element('cit_name', $item)); ?></p>
									<span><?php echo element('cit_summary', $item); ?></span>
								</div>
								<div class="cont_info_desc">
									<div class="info_desc_left">
										<div class="info_desc_box">
											<span id="heart_cnt"><?php echo number_format(element('cit_wish_count', $item)); ?></span>
										</div>

										<div class="info_desc_box">
											<span id="buy_cnt"><?php echo number_format(element('cit_sell_count', $item)); ?></span>
										</div>
									</div>

									<div class="info_desc_right">
										<?php
											if($item['cit_money_type']=='f'){
												?>
												<span id="price" class="asmo_price_fruit"><?php echo number_format(element('fruit_cit_price', $item)); ?></span>개
												<?php
											}else{
												?>
												<span id="price" class="asmo_price_coin"><?php echo number_format(element('cit_price', $item)); ?></span>개
												<?php
											}
										?>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- 컬래버랜드 cmall 요소 끝 -->
<script>
	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');

	
	//asmo lhb 231220 광고배너 스와이퍼 붙이기
	const shop_swiper = new Swiper('.cmall_index_slider_wrap .swiper-container', {
		speed: 200,
		slidesPerView: 2,
		spaceBetween: 16,
		loop: true,
		autoplay: {
        delay: 2500,
			disableOnInteraction: false,
		},
		pagination: {
			el: '.cmall_index_slider_wrap .swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.cmall_index_slider_wrap .swiper-button-next',
			prevEl: '.cmall_index_slider_wrap .swiper-button-prev',
		},
	});
	//asmo lhb 231220 광고배너 스와이퍼 붙이기 끝


	


</script>