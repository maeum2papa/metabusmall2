<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="asmo_item_detail_wrap" class="asmo_wish_wrap"> 
	<div class="page-header">
		<h4>구매내역</h4>
		<div class="top_right_box">
			<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
			<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
			<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
		</div>
	</div>
	<div class="credit" id="asmo_order_list_table_wrap">
		<div class="credit_info" style="display:none;">
			<span class="pull-right">전체 <?php echo number_format(element('total_rows', element('data', $view), 0)); ?> 건</span>
		</div>
		<!-- asmo lhb 231221 thead 대체요소 -->
		<div class="asmo_thead">
			<span>구매날짜</span>
			<span>구매내역</span>
			<span>입금내역</span>
			<span>상태</span>
		</div>
		<table class="table table-striped table-hover">
			<!-- <thead>
				<tr>
					<th class="text-center">구매날짜</th>
					<th class="text-center">구매내역</th>
					<th class="text-center">입금내역</th>
					<th class="text-center">상태</th>
				</tr>
			</thead> -->
			<tbody>
			<?php
			if (element('list', element('data', $view))) {
				foreach (element('list', element('data', $view)) as $result) {
			?>
				<tr>
					
					<td class="text-center"><?php echo display_datetime(element('cor_datetime', $result), 'full'); ?></td>
					<td class="text-left asmo_order_list_td">
						<!-- asmo sh 231215 a 태그 링크 /orderview로 변경 -->
						<a href="<?php echo site_url('cmall/orderview/' . element('cor_id', $result)); ?>">
							<div class="asmo_order_thumb">
								<!-- 구매상품 이미지 들어가야함 -->
								<img src="<?php echo thumb_url('cmallitem', $thumnail); ?>"  alt="<?php echo html_escape($order_detail[0]['cit_name']); ?>" title="<?php echo html_escape($order_detail[0]['cit_name']); ?>" />
							</div>
							<div class="asmo_order_right_cont">
								<div class="asmo_order_num"><?php echo html_escape(element('cor_id', $result)); ?></div>
								<div class="asmo_order_item">구매상품명들어가야함</div> 
							</div>
						</a>
					</td>
					<td class="text-center asmo_order_cnt_td">
						<?php
							if($result['cor_pay_type']=='f'){
								echo '열매 '.number_format((int) element('cor_total_money', $result) / $result['company_coin_value']);
							}else{
								echo '컬래버 코인 '.number_format((int) element('cor_total_money', $result));
							}
						?>개
					</td>
					<td class="text-center asmo_order_status_td">
						<?php

						// asmo sh 231215 구매내역 상태에 따라 span 태그에 id 부여 

						if($result['status']=='cancel'){
							echo '<span id="cancel">주문취소</span>';
						}elseif($result['status']=='order'){
							?>
							주문확인<br/>
							<button type="button" onClick="order_cancel('<?php echo element('cor_id', $result);?>')">주문취소</button>
							<?php

						}elseif($result['status']=='end'){
							echo '<span id="end">발송완료</span>';
						}

						?>
					</td>
				</tr>
			<?php
				}
			}
			if ( ! element('list', element('data', $view))) {
			?>
				<tr>
					<td colspan="4" class="nopost">회원님의 주문 내역이 없습니다</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
		<!-- asmo sh 231214 디자인 상 구매내역 조회할 div 생성  -->
		<div class="purchase_history">
			<span>조회기간</span>
			<div class="history_btn_box">
				<a class="selected" href="">전체</a>
				<a href="">7일</a>
				<a href="">1개월</a>
				<a href="">3개월</a>
			</div>

			<div class="history_input_box">
				<input type="date" id="start-date" name="start-date">
				<span>-</span>
				<input type="date" id="end-date" name="end-date">
				<button type="button">조회하기</button>
			</div>
		</div>
		<nav><?php echo element('paging', $view); ?></nav>
	</div>
</div>
<script>
	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');
</script>
