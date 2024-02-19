<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="asmo_item_detail_wrap" class="asmo_wish_wrap"> 

	<div class="page-header">
		<h4>찜한 목록</h4>
		<div class="top_right_box">
			<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
			<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
			<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
		</div>
	</div>
	<!-- asmo lhb 231221 기존 테이블 형식 ul li 형식으로 변경 -->
	<ul id="asmo_wish_item_list">
		<?php
		if (element('list', element('data', $view))) {
			foreach (element('list', element('data', $view)) as $result) {
		?>
			<li>
				<div class="cont_img">
					<a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>">
						<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result)); ?>"  alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" />
					</a>
				</div>
				<div class="cont_info">
					<div class="cont_info_title">
						<a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>">
							<p><?php echo html_escape(element('cit_name', $result)); ?></p>
						</a>	
					</div>
					<div class="cont_info_desc">
						<div class="info_desc_left">
							<?php echo display_datetime(element('cwi_datetime', $result), 'full'); ?>
						</div>
						<div class="info_desc_right">
							<button class="btn-one-delete" type="button" data-one-delete-url = "<?php echo element('delete_url', $result); ?>">삭제</button>
						</div>
					</div>
				</div>
			</li>
		<?php
			}
		}
		if ( ! element('list', element('data', $view))) {
		?>
			<p class="asmo_no_data">보관 기록이 없습니다</p>
		<?php
		}
		?>
	</ul>
	<nav><?php echo element('paging', $view); ?></nav>
</div>
<script>
	
//asmo lhb 231218 클래스 영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');

</script>
