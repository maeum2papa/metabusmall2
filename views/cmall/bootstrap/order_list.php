<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

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
</style>

<!-- asmo sh 231214 shop div#orderlist 감싸는 div#asmo_cmall 생성  -->
<div class= "asmo_cmall">
	<div id="orderlist">

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

		<!-- asmo sh 231214 디자인 상 장바구니, 구매내역 버튼 필요하여 div.cmall_orderlist_top_box 생성  -->
		

		<!-- asmo sh 231214 디자인 상 구매내역 조회할 div 생성  -->
		<form>
			<div class="cmall_orderlist_top_box">
				
				<strong>교환내역</strong>
	
				<div class="purchase_history">
					<span>조회기간</span>
					<div class="history_btn_box">
						<a class="selected" data="">전체</a>
						<a data="7d">7일</a>
						<a data="1m">1개월</a>
						<a data="3m">3개월</a>
					</div>
	
					<div class="history_input_box">
						<label for="start-date">시작 날짜:</label>
						<input type="date" id="start-date" name="start-date" value="<?php echo $this->input->get("start-date");?>">
	
						<span>~</span>
	
						<label for="end-date">종료 날짜:</label>
						<input type="date" id="end-date" name="end-date" value="<?php echo $this->input->get("end-date");?>">
	
						<button type="submit">조회</button>
					</div>
				</div>
				
			</div>
			
		</form>
	
		<!-- asmo sh 240221 교환소 조건 추가 -->
		<div class="credit table-responsive">
			<span class="list-total">전체 <?php echo number_format(element('total_rows', element('data', $view), 0)); ?> 건</span>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>교환날짜</th>
						<th>교환소</th>
						<th>내용</th>
						<th class="text-center">차감내역</th>
						<th>상태</th>
					</tr>
				</thead>
				<tbody>
				
				<?php
				if (element('list', element('data', $view))) {
					foreach (element('list', element('data', $view)) as $result) {
						unset($order_detail,$thumnail,$order_name);
				?>
					<tr>
						<td><?php echo str_replace('-','.',substr($result['cor_datetime'],0,10)); ?></td>
						<td>
						<?php if($result['cor_pay_type']=='f'){ ?>
							컬래버랜드 아이템몰
						<?php }else{ ?>
							<?php echo busiNm($this->member->item('company_idx')); ?> 복지교환소
						<?php } ?>
							
						</td>
						<td>

						<!-- asmo sh 231215 a 태그 링크 /orderview로 변경 -->
							<a href="<?php echo site_url('cmall/orderview/' . element('cor_id', $result)); ?>" class="bold">
								<?php
									$order_detail = $result['orderdetail'];
									$thumnail = '';
									$order_name = [];
	
									foreach($order_detail as $k => $v){
										if($k==0) $thumnail = $v['item']['cit_file_1'];
										foreach($v['itemdetail'] as $k2=>$v2){
											$order_name[] = $v['item']['cit_name']."(".$v2['cde_title'].")";
										}
									}
	
								?>
								<img src="<?php echo thumb_url('cmallitem', $thumnail, 60, 60); ?>" class="thumbnail" style="margin:0;width:60px;height:60px;" alt="<?php echo html_escape($order_detail[0]['cit_name']); ?>" title="<?php echo html_escape($order_detail[0]['cit_name']); ?>" />

								<!-- asmo sh 231215 구매내역 상품명 감싸는 span 태그 생성 -->
								<span><?php echo implode(" + ",$order_name); ?></span>
								
							</a>
	
						</td>
						<td class="text-right">
							<div class="order_list_total_money">
								<?php
									if($result['cor_pay_type']=='f'){
										echo banner('fruit').number_format((int) element('cor_total_money', $result));
									}else{
										echo banner('coin').number_format((int) element('cor_total_money', $result));
									}
								?>개
							</div>
						</td>
						<td class="text-center">
							<?php
							// asmo sh 240221 구매내역 상태​ 업데이트
							// - 주문확인 / 발송대기 / 발송완료

							if($result['status']=='cancel'){
								echo '<span id="cancel">주문취소</span>';
							}elseif($result['status']=='order'){
								?>
								주문확인<br/>
								<button type="button" onClick="order_cancel('<?php echo element('cor_id', $result);?>')">주문취소</button>
								<?php
	
							}elseif($result['status']=='end'){
								echo '<span id="end">발송완료</span>';
							}elseif($result['status']=='ready'){
								echo '<span id="ready">발송대기</span>';
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
						<td colspan="5" class="nopost">회원님이 주문 내역이 없습니다</td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
			<nav><?php echo element('paging', $view); ?></nav>
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

function order_cancel(cor_id){
	$.post(
		cb_url + "/cmall/ordercancel",
		{cor_id:cor_id, csrf_test_name: cb_csrf_hash },
		function(res){
		if(res=='false'){
			alert("<?php echo cmsg("4100"); ?>");
		}else if(res=='false_status'){
			alert("<?php echo cmsg("4101"); ?>");
		}else if(res=='true'){
			alert("<?php echo cmsg("4000"); ?>");
			location.reload();
		}
	});
}


function zero_number(number){
	return ('0' + number).slice(-2);
}

function history_btn_box_a_reset(){
	document.querySelectorAll(".history_btn_box a").forEach(element => {
		element.classList.remove("selected");
	});
}

document.querySelectorAll(".history_btn_box a").forEach(element=>{
	element.addEventListener("click",event=>{
		today = new Date();
		data = element.getAttribute("data");
		start_date = "";
		end_date = "";

		year = today.getFullYear();
		month = zero_number((today.getMonth() + 1));
		day = zero_number(today.getDate());
		end_date = year+"-"+month+"-"+day;

		history_btn_box_a_reset();

		if(data == "7d"){
			sevenDaysAgo = new Date(today);
			sevenDaysAgo.setDate(today.getDate() - 7);

			start_date = sevenDaysAgo.getFullYear()+"-"+zero_number(sevenDaysAgo.getMonth()+1)+"-"+zero_number(sevenDaysAgo.getDate());

		}else if(data == "1m"){
			oneMonthAgo = new Date(today);
			oneMonthAgo.setMonth(today.getMonth() - 1);

			start_date = oneMonthAgo.getFullYear()+"-"+zero_number(oneMonthAgo.getMonth()+1)+"-"+zero_number(oneMonthAgo.getDate());

		}else if(data == "3m"){
			threeMonthAgo = new Date(today);
			threeMonthAgo.setMonth(today.getMonth() - 3);

			start_date = threeMonthAgo.getFullYear()+"-"+zero_number(threeMonthAgo.getMonth()+1)+"-"+zero_number(threeMonthAgo.getDate());

		}else{//전체
			start_date = "";
			end_date = "";
		}

		element.classList.add("selected");

		document.querySelector("[name='start-date']").value = start_date;
		document.querySelector("[name='end-date']").value = end_date;
	});
});
</script>