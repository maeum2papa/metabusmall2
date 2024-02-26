<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>


<div id="asmo_item_detail_wrap" class="asmo_wish_wrap asmo_cart_wrap">

    <div class="page-header">
        <h4>복지포인트 내역</h4>
        <div class="top_right_box">
            <a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
            <a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
            <a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
        </div>
    </div>

    
    <div class="asmo_fruit_table_container">

        <!-- asmo lhb 231221 thead 대체요소 -->
		<div class="asmo_thead asmo_thead_fruit">
			<span>구매날짜</span>
			<span>유형</span>
			<span>구매내역</span>
			<span>복지포인트 내역</span>
			<span>잔여 복지포인트</span>
		</div>

        <table class="asmo_fruit_table">
            <tbody>
                <?php 
                if(count($view['data']['list'])>0){
                foreach($view['data']['list'] as $k=>$v){
                ?>
                <tr>
                    <td class="asmo_fruit_date"><?php echo substr($v['poi_datetime'],0,10);?></td>
                    <td class="asmo_fruit_type"><?php echo ($v['poi_point']>0)?"획득":"차감";?></td>
                    <td class="asmo_fruit_txt"><?php echo $v['poi_content'];?></td>
                    <td class="asmo_fruit_cnt <?php if( $v['poi_point'] > 0 ){ ?>get<?php } ?>"><?php if( $v['poi_point'] > 0 ){ ?>+<?php } ?><?php echo number_format( $v['poi_point'] );?> 개</td>
                    <td class="asmo_fruit_sum"><?php echo number_format( $v['poi_now_point'] );?> 개</td>
                </tr>
                <?php
                    }
                }else{
                    ?>
                <tr>
                    <td colspan="5" class="nopost">내역이 없습니다</td>
                </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>


        <!-- asmo sh 231214 디자인 상 구매내역 조회할 div 생성  -->
        <div class="purchase_history_wrapper">
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
            <div class="history_type">
                <span>유형</span>
                <div class="asmo_rdo_wrap">
                    <input type="radio" name="asmo_type" id="asmo_all">
                    <label for="asmo_all">전체</label>
                </div>
                <div class="asmo_rdo_wrap">
                    <input type="radio" name="asmo_type" id="asmo_get">
                    <label for="asmo_get">획득</label>
                </div>
                <div class="asmo_rdo_wrap">
                    <input type="radio" name="asmo_type" id="asmo_lose">
                    <label for="asmo_lose">차감</label>
                </div>
            </div>
        </div>
        <nav><?php echo element('paging', $view); ?></nav>

    </div>
	

</div>
<script type="text/javascript">

//asmo lhb 231218 클래스 영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');

</script>

