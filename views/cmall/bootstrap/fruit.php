<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
    header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	}
</style>

<!-- asmo sh 231215 shop div#lists 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_cmall">
	<div id="history_lists">

        <!-- asmo sh 231215 디자인 상 장바구니, 구매내역 버튼 필요하여 div.cmall_orderlist_top_box 생성  -->
		<div class="cmall_orderlist_top_box">
				
            <strong>열매 내역</strong>

            <div class="orderlist_top_flex_box">
                <a href="/cmall/wishlist">찜하기목록으로 <?=banner('heart_color')?></a>
                <a href="/cmall/cart">장바구니 <?=banner('cart')?></a>
                <a href="/cmall/orderlist">구매내역 <?=banner('purchase_history')?></a>
            </div>
            
        </div>

        <!-- asmo sh 231215 디자인 상 구매내역 조회할 div 생성  -->
		<div class="history_box_wrap">
            <div class="history_box">
                <span>조회기간</span>
                <div class="history_btn_box">
                    <a class="selected" href="">전체</a>
                    <a href="">7일</a>
                    <a href="">1개월</a>
                    <a href="">3개월</a>
                </div>
                <div class="history_input_box">
                    <label for="start-date">시작 날짜:</label>
                    <input type="date" id="start-date" name="start-date">
                    <span>-</span>
                    <label for="end-date">종료 날짜:</label>
                    <input type="date" id="end-date" name="end-date">
                    <button type="button">조회하기</button>
                </div>
            </div>

            <div class="history_box">
                <span>유형</span>

                <div class="history_radio">
                    
                    <input type="radio" id="all" name="history" value="all" checked>
                    <label for="all">전체</label>

                    <input type="radio" id="income" name="history" value="income">
                    <label for="income">획득</label>

                    <input type="radio" id="expenditure" name="history" value="expenditure">
                    <label for="expenditure">차감</label>

                </div>
            </div>
        </div>
		
		<div class="cmall-list">

            <!-- asmo sh 231226 디자인 상 table 생성 -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 14%">날짜</th>
                                <th style="width: 12.5%">유형</th>
                                <th style="width: 45.5%">내용</th>
                                <th style="width: 14%">열매 내역</th>
                                <th style="width: 14%">잔여열매</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="blank">
                                <td colspan="4"></td>
                            </tr>

                <?php
                    if(count($view['data']['list'])>0){
                        foreach($view['data']['list'] as $k=>$v){
                            ?>
                            <tr>
                                <td><?php echo substr($v['log_regDt'],0,10);?></td>
                                <td><?php if($v['fru_fruit'] > 0){ echo '획득'; } else { echo '차감'; } ?> </td>
                                <td><?php echo $v['log_txt'];?></td>
                                <td class="<?php if($v['fru_fruit'] > 0){ echo 'asmo_plus'; } ?>"><?php echo $v['fru_fruit'];?>개</td>
                                <td><?php if ($v['fru_now_fruit'] > 0) echo $v['fru_now_fruit'], "개" ?></td>
                            </tr>
                            <?php
                        }
                    }else{
                        echo "<tr><td class=", "nopost" ," colspan='5'>열매 내역이 없습니다.</td></tr>";
                    }
                ?>
                    </tbody>
                </table>
            </div>
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

<nav><?php echo element('paging', $view); ?></nav>
