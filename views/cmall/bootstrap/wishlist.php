<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<!-- asmo sh 231207 shop div#wish-list 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_cmall">
	<div id="wish-list">

		<!-- 디자인 상 장바구니, 구매내역 버튼 필요하여 div.cmall_wish_top_box 생성 및 h3 재배치  -->
		<div class="cmall_wish_top_box">
			<h3>찜한 목록</h3>

			<div class="top_right_box">
				<a href="/cmall/wishlist">찜하기목록으로 <?=banner('heart_color')?></a>
				<a href="/cmall/cart">장바구니 <?=banner('cart')?></a>
				<a href="/cmall/orderlist">구매내역 <?=banner('purchase_history')?></a>
			</div>
		</div>

		<div class="row">
			<ul class="table table-striped">
	
				<?php
				if (element('list', element('data', $view))) {
					foreach (element('list', element('data', $view)) as $result) {
				?>
					<li class="col-xs-6 col-md-3">
						<a href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>"><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 260, 260); ?>" alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" /></a>
						
						<!-- asmo sh 231207 찜한 상품 제목 a 태그에 wish_info_title 클래스 생성 -->
						<a class="wish_info_title" href="<?php echo element('item_url', $result); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" class="prd-tit"><?php echo html_escape(element('cit_name', $result)); ?></a>

						<!-- asmo sh 231207 찜한 시각, 삭제버튼 감싸는 div.wish_info_etc 생성 및 i 태그 display: none 후 새로운 이미지 추가 -->
						<div class="wish_info_etc">
							<span class="prd-date"><i class="dn fa fa-clock-o" aria-hidden="true"></i>
								<?=banner('time')?>
								<?php echo display_datetime(element('cwi_datetime', $result), 'full'); ?>
							</span>
							<button class="btn btn-xs btn-danger btn-one-delete" type="button" data-one-delete-url = "<?php echo element('delete_url', $result); ?>"><i class="dn fa fa-trash"></i>
								
							<svg id="delete_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<rect id="사각형_4082" data-name="사각형 4082" width="24" height="24" fill="#fff" opacity="0"/>
								<rect id="사각형_4083" data-name="사각형 4083" width="18" height="18" transform="translate(3 3)" fill="#ffa7a7" opacity="0"/>
								<g id="합치기_23" data-name="합치기 23" transform="translate(5 5)" fill="none">
									<path d="M3.889,14a1.555,1.555,0,0,1-1.555-1.556L.928,5.42a1.167,1.167,0,0,1,.238-2.308H12.833a1.166,1.166,0,0,1,.238,2.308l-1.4,7.025A1.556,1.556,0,0,1,10.111,14ZM4.278,2.334A1.167,1.167,0,0,1,4.278,0H9.722a1.167,1.167,0,1,1,0,2.334Z" stroke="none"/>
									<path d="M 9.715869903564453 12.00040054321289 L 11.09336853027344 5.111300468444824 L 2.9062340259552 5.111300468444824 L 4.284528732299805 12.00040054321289 L 9.715869903564453 12.00040054321289 M 10.11150074005127 14.00040054321289 L 3.888900279998779 14.00040054321289 C 3.02940034866333 14.00040054321289 2.333700180053711 13.30380058288574 2.333700180053711 12.44430065155029 L 0.9283102750778198 5.419770240783691 C 0.3981902599334717 5.309890270233154 2.716064386731887e-07 4.840490341186523 2.716064386731887e-07 4.277700424194336 C 2.716064386731887e-07 3.633300304412842 0.522000253200531 3.111300230026245 1.16640031337738 3.111300230026245 L 12.83310031890869 3.111300230026245 C 13.47749996185303 3.111300230026245 14.00040054321289 3.633300304412842 14.00040054321289 4.277700424194336 C 14.00040054321289 4.840490341186523 13.60157012939453 5.309880256652832 13.07128047943115 5.419760227203369 L 11.66670036315918 12.44430065155029 C 11.66670036315918 13.30380058288574 10.97010040283203 14.00040054321289 10.11150074005127 14.00040054321289 Z M 9.721799850463867 2.333700180053711 L 4.277700424194336 2.333700180053711 C 3.633300304412842 2.333700180053711 3.111300230026245 1.810800313949585 3.111300230026245 1.16640031337738 C 3.111300230026245 0.522000253200531 3.633300304412842 2.716064386731887e-07 4.277700424194336 2.716064386731887e-07 L 9.721799850463867 2.716064386731887e-07 C 10.36620044708252 2.716064386731887e-07 10.88910007476807 0.522000253200531 10.88910007476807 1.16640031337738 C 10.88910007476807 1.810800313949585 10.36620044708252 2.333700180053711 9.721799850463867 2.333700180053711 Z" stroke="none" fill="rgba(34,34,34,0.2)"/>
								</g>
							</svg>

								삭제
							</button>
						</div>
					</li>
				<?php
					}
				}
				if ( ! element('list', element('data', $view))) {
				?>
					<li class="nopost">보관 기록이 없습니다</li>
				<?php
				}
				?>
			</ul>
			<nav><?php echo element('paging', $view); ?></nav>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		// asmo sh 231205 shop 페이지 디자인 상 헤더, nav바, 숨김 처리 스크립트
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		// $('.sidebar').addClass('dn');
		// $('footer').addClass('dn');

		$('.main').addClass('add');

		// shop 페이지일 때 사이드바 메뉴 활성화
		$('#shop').addClass('selected');
	});
</script>
