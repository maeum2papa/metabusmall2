<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
	body {
		background: transparent linear-gradient(180deg, #000000 0%, #3E3E3E 100%);
		background-attachment: fixed;
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

<!-- asmo sh 231204 디자인 상 cmall 전체 주석 처리 후 div#asmo_camll 생성 -->
<!-- <h4>추천상품</h4>
<div class="cmall-list">
	<ul class="row">
	<?php
	if (element('type1', $view)) {
		foreach (element('type1', $view) as $item) {
	?>
		<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 cmall-list-col">
			<div class="thumbnail">
				<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
					<img alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 420, 300); ?>">
				</a>
				<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
				<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
				<ul class="cmall-detail">
					<li><i class="fa fa-heart"></i> <span class="detail-tit">찜</span> <?php echo number_format(element('cit_wish_count', $item)); ?></li>
					<li><i class="fa fa-shopping-cart"></i> <span class="detail-tit">구매</span> <?php echo number_format(element('cit_sell_count', $item)); ?></li>
					<li class="cmall-price pull-right"><span><?php echo number_format(element('cit_price', $item)); ?></span>원</li>
				</ul>
			</div>
		</li>
	<?php
		}
	}
	?>
	</ul>
</div>

<h4>인기상품</h4>
<div class="cmall-list">
	<ul class="row">
	<?php
	if (element('type2', $view)) {
		foreach (element('type2', $view) as $item) {
	?>
		<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 cmall-list-col">
			<div class="thumbnail">
				<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
					<img alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 420, 300); ?>">
				</a>
				<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
				<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
				<ul class="cmall-detail">
					<li><i class="fa fa-heart"></i> <span class="detail-tit">찜</span> <?php echo number_format(element('cit_wish_count', $item)); ?></li>
					<li><i class="fa fa-shopping-cart"></i> <span class="detail-tit">구매</span> <?php echo number_format(element('cit_sell_count', $item)); ?></li>
					<li class="cmall-price pull-right"><span><?php echo number_format(element('cit_price', $item)); ?></span>원</li>
				</ul>
			</div>
		</li>
	<?php
		}
	}
	?>
	</ul>
</div>

<h4>최신상품</h4>
<div class="cmall-list">
	<ul class="row">
	<?php
	if (element('type3', $view)) {
		foreach (element('type3', $view) as $item) {
	?>
		<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 cmall-list-col">
			<div class="thumbnail">
				<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
					<img alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 420, 300); ?>">
				</a>
				<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
				<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
				<ul class="cmall-detail">
					<li><i class="fa fa-heart"></i> <span class="detail-tit">찜</span> <?php echo number_format(element('cit_wish_count', $item)); ?></li>
					<li><i class="fa fa-shopping-cart"></i> <span class="detail-tit">구매</span> <?php echo number_format(element('cit_sell_count', $item)); ?></li>
					<li class="cmall-price pull-right"><span><?php echo number_format(element('cit_price', $item)); ?></span>원</li>
				</ul>
			</div>
		</li>
	<?php
		}
	}
	?>
	</ul>
</div>

<h4>할인상품</h4>
<div class="cmall-list">
	<ul class="row">
	<?php
	if (element('type4', $view)) {
		foreach (element('type4', $view) as $item) {
	?>
		<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 cmall-list-col">
			<div class="thumbnail">
				<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
					<img alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item), 420, 300); ?>">
				</a>
				<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
				<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
				<ul class="cmall-detail">
					<li><i class="fa fa-heart"></i> <span class="detail-tit">찜</span> <?php echo number_format(element('cit_wish_count', $item)); ?></li>
					<li><i class="fa fa-shopping-cart"></i> <span class="detail-tit">구매</span> <?php echo number_format(element('cit_sell_count', $item)); ?></li>
					<li class="cmall-price pull-right"><span><?php echo number_format(element('cit_price', $item)); ?></span>원</li>
				</ul>
			</div>
		</li>
	<?php
		}
	}
	?>
	</ul>
</div> -->

<div class="asmo_cmall">
	<div class="asmo_cmall_index">
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

		<div class="cmall_main_wrap">
			<div class="swiper-wrap">
				<div class="cmall_index_slide swiper">
					<div class="swiper-wrapper">
							<?=banner('shop_slide_banner','','','<li class="swiper-slide">','</li>')?>
					</div>
			
				</div>
				<div class="ctrl_wrap">
					<div class="asmo_pause_btn">
						<span class="pause_btn"></span>
					</div>
					<div class="prev_btn "></div>
					<div class="pagingInfo">
						<i>1</i>
						/
						<span>5</span>
					</div>
					<div class="next_btn "></div>
				</div>
			</div>
			<div class="cmall_guide">
				<div class="cmall_guide_box"><?=banner('cmall_guide_top')?></div>
				<div class="cmall_guide_box"><?=banner('cmall_guide_bottom')?></div>
			</div>
		</div>

		<div class="asmo_cmall_reco_wrap">
			<div class="cmall_itemmall cmall_reco">
				<div class="reco_top_box">
					<strong>컬래버랜드 아이템교환소</strong>
					<a href="<?php echo site_url('cmall/lists/6'); ?>">더보기 <span></span></a>
				</div>

				<div class="reco_cont_wrap">

				<?php
				if (element('type1', $view)) {
					foreach (element('type1', $view) as $item) {
				?>
					<div class="reco_cont">
							<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
								<a onClick="alert('<?php echo cmsg("1103");?>');">
							<?php }else if(cmall_item_one_sale_order($this->member->item('mem_id'),$item['cit_id'])){ ?>
								<a onClick="alert('<?php echo cmsg("1102")?>');">
							<?php }else{ ?>
								<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>">
							<?php } ?>

							<div class="cont_img">
								<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item)); ?>" alt="">

								<?php if(soldoutYn(element('cit_id', $item)) == 'y' || cmall_item_one_sale_order($this->member->item('mem_id'),$item['cit_id'])){?>
								<div class="soldout_mask">
									<span>구매 불가</span>
								</div>
								<?php } ?>
									
							</div>
							<div class="cont_info">
								<div class="cont_info_title">
									<p><?php echo html_escape(element('cit_name', $item)); ?></p>
									<!-- <span><?php echo element('cit_summary', $item); ?></span> -->
								</div>
								<div class="cont_info_desc">
									<!-- <div class="info_desc_left">
										<div class="info_desc_box">
											<?=banner('heart')?>
											<span id="heart_cnt"><?php echo number_format(element('cit_wish_count', $item)); ?></span>
										</div>

										<div class="info_desc_box">
											<?=banner('cart_2')?>
											<span id="buy_cnt"><?php echo number_format(element('cit_sell_count', $item)); ?></span>
										</div>
									</div> -->

									<div class="info_desc_right">
											<?php
												echo banner('fruit');
												?>
												<span id="price"><?php echo number_format(element('cit_price', $item)); ?></span>개
												<?php
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
			<div class="cmall_reco_wrap">
				<div class="cmall_official cmall_reco">
					<div class="reco_top_box">
						<strong><span><?=busiNm($this->member->item('company_idx'))?></span> 복지교환소</strong>
						<a href="<?php echo site_url('cmall/lists/2'); ?>">더보기 <span></span></a>
					</div>

					<div class="reco_cont_wrap">

						<?php
						if (element('type3', $view)) {
							foreach (element('type3', $view) as $item) {
						?>
						<div class="reco_cont">
							<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
								<a onClick="alert('<?php echo cmsg("1103");?>');">
							<?php }else if(cmall_item_one_sale_order($this->member->item('mem_id'),$item['cit_id'])){ ?>
								<a onClick="alert('<?php echo cmsg("1102")?>');">
							<?php }else{ ?>
								<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>">
							<?php } ?>
								<div class="cont_img">
									<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item)); ?>" alt="">
									
									<?php if(soldoutYn(element('cit_id', $item)) == 'y' || cmall_item_one_sale_order($this->member->item('mem_id'),$item['cit_id'])){?>
									<div class="soldout_mask">
										<span>구매 불가</span>
									</div>
									<?php } ?>
									
								</div>
								<div class="cont_info">
									<div class="cont_info_title">
										<p><?php echo html_escape(element('cit_name', $item)); ?></p>
										<!-- <span><?php echo element('cit_summary', $item); ?></span> -->
									</div>
									<div class="cont_info_desc">
										<!-- <div class="info_desc_left">
											<div class="info_desc_box">
												<?=banner('heart')?>
												<span id="heart_cnt"><?php echo number_format(element('cit_wish_count', $item)); ?></span>
											</div>

											<div class="info_desc_box">
												<?=banner('cart_2')?>
												<span id="buy_cnt"><?php echo number_format(element('cit_sell_count', $item)); ?></span>
											</div>
										</div> -->

										<div class="info_desc_right">
											<?php
												echo banner('coin');
												?>
												<span id="price"><?php echo number_format(element('cit_price', $item)); ?></span>개
												<?php
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

	<!-- <div class="status_popup_bg">
		<div id="status_popup">
			<div class="status_box">
				<div class="status_save_box">
					<div class="status_save">
						<div class="status_icon"><?=banner('fruit')?></div>
						<p>보유 열매 : <span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?></span>개</p>
					</div>
					<div class="status_save">
						<div class="status_icon"><?=banner('seed')?></div>
						<p>보유 씨앗 : <span id="seed_count"><?php echo html_escape($this->member->item('mem_cur_seed')); ?></span>개 (<?php echo html_escape($this->member->item('mem_cur_seed')); ?>개 수확 중)</p>
					</div>
				</div>
				<div class="status_total_box">
					<p>현재까지 모은 열매/씨앗 : <span><?php echo html_escape($this->member->item('mem_cur_fruit')); ?>개 / <?php echo html_escape($this->member->item('mem_cur_seed')); ?>개</span></span></p>
				</div>
				<a href="<?php echo site_url('cmall/orderlist'); ?>">열매 사용 내역</a>
			</div>
			<button id="status_popup_close">
				<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
					<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
					<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
						<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
						<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
					</g>
				</svg>
			</button>
		</div>
	</div> -->
</div>


<script type="text/javascript">

	const mySwiper = new Swiper('.cmall_index_slide', {
		speed: 500,
		// effect: 'fade',
		loop: true,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.next_btn',
			prevEl: '.prev_btn',
		},
	});

	let sw = 0;

	$('.asmo_pause_btn').click(function() {
		if (sw == 0) {
			mySwiper.autoplay.stop();
			$('.asmo_pause_btn').addClass('on');
			sw = 1;
		} else {
			mySwiper.autoplay.start();
			$('.asmo_pause_btn').removeClass('on');
			sw = 0;
		}
	});

	// mySwiper의 슬라이드 개수를 가져와서 pagingInfo에 넣어주기
	$('.pagingInfo span').text(mySwiper.slides.length);

	// mySwiper의 슬라이드가 바뀔 때마다 pagingInfo에 현재 슬라이드 번호 넣어주기
	mySwiper.on('slideChange', function() {
		$('.pagingInfo i').text(mySwiper.realIndex + 1);
	});


	// asmo sh 231201 shop 페이지 디자인 상 헤더, nav바, 숨김 처리 스크립트
	$(document).ready(function() {
		

		$('.main').addClass('add');

		// shop 페이지일 때 사이드바 메뉴 활성화
		$('#shop').addClass('selected');

		// 열매 박스 클릭 시 열매 팝업창 띄우기
		// $('#status_popup_open').on('click', function() {
		// 	$('.status_popup_bg').css('display', 'block');
		// });

		// // 열매 팝업창 닫기
		// $('#cancel_icon').on('click', function() {
		// 	$('.status_popup_bg').css('display', 'none');
		// });
	});
</script>