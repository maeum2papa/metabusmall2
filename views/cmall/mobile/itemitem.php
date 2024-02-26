<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_js(base_url('assets/js/cmallitem.js')); ?>

<style>
/* 주문 테스트를 위한 임시 스타일로 모바일 퍼블리싱 시 삭제해도 됨 20231222*/
@media(max-width:375px){
	#asmo_item_detail_wrap .market .product-box{
		display:block;
	}

	#asmo_item_detail_wrap .product-right{
		width:auto;
	}
}
</style>

<div class="market" id="asmo_item_detail_wrap">
	
	<!-- 몰 상단 공통 요소  -->
	<div class="cmall_top_wrap no_left">
		<div class="top_right_box">
			<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
			<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
		</div>
	</div>
	<!-- //몰 상단 공통 요소  -->

    <!-- 네비게이터 -->
    <div>
        <a href="<?php echo site_url('cmall/lists/6?search_cate_sno_parent_sno='.element('depth', element('data', $view))[0]["cate_parent"].'&search_cate_sno='.element('depth', element('data', $view))[0]["cate_sno"].'&search_set_item=0'); ?>"><?php echo element('depth', element('data', $view))[0]["text"]; ?></a>
        > 
        <a href="<?php echo site_url('cmall/lists/6?search_cate_sno_parent_sno='.element('depth', element('data', $view))[1]["cate_parent"].'&search_cate_sno='.element('depth', element('data', $view))[1]["cate_sno"].'&search_set_item='.element('depth', element('data', $view))[1]["set"]); ?>"><?php echo element('depth', element('data', $view))[1]["text"]; ?></a>
    </div>

	<!-- <h3>상품안내</h3> -->
	<?php if ($this->member->is_admin()) { ?>
		<a href="<?php echo admin_url('cmall/cmallitem/write/' . element('cit_id', element('data', $view))); ?>" target="_blank" class="btn-sm btn btn-danger pull-right">상품내용수정</a>
	<?php } ?>
	<?php if (element('header_content', element('data', $view))) { ?>
		<div class="product-detail"><?php echo element('header_content', element('data', $view)); ?></div>
	<?php } ?>
	<div class="market">
		<div class="product-box">
			<div class="product-left">
				<div class="item_slider">
					<?php
					for ($i =1; $i <=10; $i++) {
					if ( ! element('cit_file_' . $i, element('data', $view))) {
						continue;
					}
					?>
						<div><img src="<?php echo thumb_url('cmallitem', element('cit_file_' . $i, element('data', $view))); ?>" alt="<?php echo html_escape(element('cit_name', element('data', $view))); ?>" title="<?php echo html_escape(element('cit_name', element('data', $view))); ?>" onClick="window.open('<?php echo site_url('cmall/itemimage/' . html_escape(element('cit_key', element('data', $view)))); ?>', 'win_image', 'left=100,top=100,width=730,height=700,scrollbars=1');" /></div>
					<?php } ?>
				</div>
				<span class="prev" id="slider-prev"></span>
				<span class="next" id="slider-next"></span>
			</div>
			<div class="product-right">
				<div class="product-title"><?php echo html_escape(element('cit_name', element('data', $view))); ?></div>
				<!-- asmo lhb 231221 상품정보 테이블 미노출  -->
				<table class="product-no table table-bordered" style="display:none;">
					<tbody>
						<tr>
							<td>상품코드</td>
							<td><?php echo html_escape(element('cit_key', element('data', $view))); ?></td>
						</tr>
						<?php
						for ($k=1; $k<=10; $k++) {
							if (element('info_title_' . $k, element('meta', element('data', $view)))) {
						?>
							<tr>
								<td><?php echo html_escape(element('info_title_' . $k, element('meta', element('data', $view)))); ?></td>
								<td><?php echo html_escape(element('info_content_' . $k, element('meta', element('data', $view)))); ?></td>
							</tr>
						<?php
								}
							}
						?>
						<?php if (element('demo_user_link', element('meta', element('data', $view))) OR element('demo_admin_link', element('meta', element('data', $view)))) { ?>
							<tr>
								<td>샘플보기</td>
								<td>
								<?php if (element('demo_user_link', element('meta', element('data', $view)))) { ?>
									<a href="<?php echo site_url('cmallact/link/user/' . element('cit_id', element('data', $view))); ?>" target="_blank"><span class="label label-primary">샘플사이트</span></a>
								<?php } ?>
								<?php if (element('demo_admin_link', element('meta', element('data', $view)))) { ?>
									<a href="<?php echo site_url('cmallact/link/admin/' . element('cit_id', element('data', $view))); ?>" target="_blank"><span class="label label-success">관리자사이트</span></a>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td>다운로드 가능기간</td>
							<td><?php echo (element('cit_download_days', element('data', $view))) ? '구매후 ' . element('cit_download_days', element('data', $view)) . '일 동안 언제든지 다운로드 가능' : '구매후 기간제한없이 언제나 가능'; ?></td>
						</tr>
					</tbody>
				</table>

				<!-- asmo lhb 231221 옵션 폼 위치 이동 -->
				<?php
				if (element('detail', element('data', $view))) {
					$attributes = array('class' => 'form-horizontal', 'name' => 'fitem', 'id' => 'fitem', 'onSubmit' => 'return fitem_submit(this)');
					echo form_open(current_full_url(), $attributes);
				?>
					<input type="hidden" name="stype" id="stype" value="" />
					<input type="hidden" name="cit_id" value="<?php echo element('cit_id', element('data', $view)); ?>" />
					<div class="product-option dn">
						<table class="table table-bordered item_detail_table">
							<tbody>
								<tr class="danger" style="display:none;">
									<th style="display:none;"><input type="checkbox" id="chk_all_item" /></th>
									<th>수량</th>
									<th>판매가</th>
								</tr>
								<?php
								foreach (element('detail', element('data', $view)) as $detail) {
									$price = element('cit_price', element('data', $view)) + element('cde_price', $detail);
								?>
									<tr>
										<td class="asmo_opt_chk_td" style="display:none;"><input type="checkbox" name="chk_detail[]" value="<?php echo element('cde_id', $detail); ?>" /></td>
										<td colspan="2">
											<!-- asmo lhb 231221 옵션명 위치 이동  -->
											<div class="asmo_opt_tit_td_box">
												<?php echo html_escape(element('cde_title', $detail)); ?>
											</div>
											<!-- //asmo lhb 231221 옵션명 위치 이동  -->
											<div class="btn-group asmo_cnt" role="group" aria-label="...">
												<button type="button" class="btn btn-default btn-xs btn-change-qty" data-change-type="minus">-</button>
												<input type="text" name="detail_qty[<?php echo element('cde_id', $detail); ?>]" class="btn btn-default btn-xs detail_qty" value="1" />
												<button type="button" class="btn btn-default btn-xs btn-change-qty" data-change-type="plus">+</button>
											</div>
										</td>
										<td class="detail_price">
											<input type="hidden" name="item_price[<?php echo element('cde_id', $detail); ?>]" value="<?php echo $price; ?>" />
											<?php echo number_format($price); ?>원
										</td>
									</tr>
								<?php } ?>
								<tr class="success">
									<td colspan="2">총 결제 열매</td>
									<td class="cart_total_price"><span id="total_order_price">0</span>원</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="asmo_item_btn_wrap">
						<button type="submit" onClick="$('#stype').val('order');" class="btn btn-black">구매하기</button>
						<div class="asmo_item_btn_bottom_wrap">
							<button type="submit" onClick="$('#stype').val('cart');"class="btn btn-black">장바구니</button>
							<button>목록으로</button>
						</div>
					</div>
				<?php
					echo form_close();
				}
				?>
				<!-- //asmo lhb 231221 옵션 폼 위치 이동 -->
			</div>
		</div>

		
		<div class="product-info asmo_item_info_common_box">
			<ul class="product-info-top asmo_common_item_tab" id="itemtabmenu1">
				<li class="current"><a href="#itemtabmenu1">상세설명</a></li>
				<li><a href="#itemtabmenu2">사용후기 <span class="item_review_count"><?php echo number_format(element('cit_review_count', element('data', $view)));?></span></a></li>
				<li><a href="#itemtabmenu3">상품문의 <span class="item_qna_count"><?php echo number_format(element('cit_qna_count', element('data', $view)));?></span></a></li>
			</ul>
			<div class="product-detail asmo_item_common_content_box"><?php echo element('content', element('data', $view)); ?></div>
		</div>
		<div class="product-info asmo_item_info_common_box">
			<ul class="product-info-top asmo_common_item_tab" id="itemtabmenu2">
				<li><a href="#itemtabmenu1">상세설명</a></li>
				<li class="current"><a href="#itemtabmenu2">사용후기 <span class="item_review_count"><?php echo number_format(element('cit_review_count', element('data', $view)));?></span></a></li>
				<li><a href="#itemtabmenu3">상품문의 <span class="item_qna_count"><?php echo number_format(element('cit_qna_count', element('data', $view)));?></span></a></li>
			</ul>
			<div id="viewitemreview" class="asmo_item_common_content_box asmo_item_board_list"></div>
			<div class="asmo_item_common_write_btn">
				<a href="javascript:;" class="btn btn-default btn-sm" onClick="window.open('<?php echo site_url('cmall/review_write/' . element('cit_id', element('data', $view))); ?>', 'review_popup', 'width=750,height=770,scrollbars=1'); return false;">작성하기<em></em></a>
			</div>
		</div>
		<div class="product-info asmo_item_info_common_box">
			<ul class="product-info-top asmo_common_item_tab" id="itemtabmenu3">
				<li><a href="#itemtabmenu1">상세설명</a></li>
				<li><a href="#itemtabmenu2">사용후기 <span class="item_review_count"><?php echo number_format(element('cit_review_count', element('data', $view)));?></span></a></li>
				<li class="current"><a href="#itemtabmenu3">상품문의 <span class="item_qna_count"><?php echo number_format(element('cit_qna_count', element('data', $view)));?></span></a></li>
			</ul>
			<div id="viewitemqna" class="asmo_item_common_content_box asmo_item_board_list"></div>
			<div class="asmo_item_common_write_btn">
				<a href="javascript:;" class="btn btn-sm btn-default" onClick="window.open('<?php echo site_url('cmall/qna_write/' . element('cit_id', element('data', $view))); ?>', 'qna_popup', 'width=750,height=770,scrollbars=1'); return false;">작성하기<em></em></a>
			</div>
		</div>
		<?php if (element('footer_content', element('data', $view))) { ?><div class="product-detail"><?php echo element('footer_content', element('data', $view)); ?></div><?php } ?>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/bxslider/jquery.bxslider.min.js'); ?>"></script>
<script type="text/javascript">
		
//asmo lhb 231218 클래스 영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');


//asmo lhb 231221 옵션 체크박스 체크 시키기
$('.product-option .asmo_opt_chk_td input[type="checkbox"]').trigger('click');
$('.product-option .asmo_opt_chk_td input[type="checkbox"]').prop('checked',true);
//asmo lhb 231221 옵션 체크박스 체크 시키기 끝


//<![CDATA[
$('.item_slider').bxSlider({
	pager : false,
	nextSelector: '#slider-next',
	prevSelector: '#slider-prev',
	nextText: '<img src="<?php echo element('layout_skin_url', $layout); ?>/images/arrow_R.svg" alt="다음" title="다음" />',
	prevText: '<img src="<?php echo element('layout_skin_url', $layout); ?>/images/arrow_L.svg" alt="이전" title="이전" />'
});
$(document).ready(function($) {
	view_cmall_review('viewitemreview', '<?php echo element('cit_id', element('data', $view)); ?>', '', '');
	view_cmall_qna('viewitemqna', '<?php echo element('cit_id', element('data', $view)); ?>', '', '');
});
//]]>
</script>
