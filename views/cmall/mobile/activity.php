<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>



<div id="asmo_item_detail_wrap" class="asmo_wish_wrap asmo_cart_wrap">

    <div class="page-header">
		<h4>활동 내역</h4>
		<div class="top_right_box">
			<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
			<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
			<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
		</div>
	</div>

    <div class="asmo_fruit_table_container">

        <!-- asmo lhb 231221 thead 대체요소 -->
		<div class="asmo_thead asmo_thead_activity">
			<span>날짜</span>
			<span>내용</span>
		</div>

        <table class="asmo_fruit_table">
            <tbody>

                <?php 
                    if(count($view['data']['list'])>0){
                        foreach($view['data']['list'] as $k=>$v){
                            ?>
                            <tr>
                                <td class="asmo_activity_date"><?php echo substr($v['log_regDt'],0,10);?></td>
                                <td class="asmo_activity_txt"><?php echo $v['log_txt'];?></td>
                            </tr>
                            <?php
                        }
                    }else{
                    ?>
                    <tr>
                        <td colspan="2" class="nopost">내역이 없습니다</td>
                    </tr>
                        <?php
                    }
                ?>

            </tbody>
        </table>

                    
    </div>
	
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
	<!-- 페이지네이션 들어가야 합니다. -->
    <div class="pagination_box">
        <ul class="pagination">
            <li class="first">
                <a href=""></a>
            </li>
            
            <li class="prev">
                <a href=""></a>
            </li>

            <li class="active">
                <a href="">1</a>
            </li>

            <li>
                <a href="">2</a>
            </li>

            <li>
                <a href="">3</a>
            </li>

            <li class="next">
                <a href=""></a>
            </li>
            
            <li class="last">
                <a href=""></a>
            </li>
        </ul>
	</div>	
</div>

<script type="text/javascript">


//asmo lhb 231218 클래스 영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');


</script>


