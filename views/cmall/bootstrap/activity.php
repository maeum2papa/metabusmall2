<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
    .pagination {
        padding: 0 4.167% 0 calc(320px + 4.167%);

        transition: all 0.3s ease;
    }

    .pagination.active {
        padding: 0 12.5% 0;
    }
</style>

<!-- asmo sh 231215 shop div#lists 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_cmall">
	<div id="history_lists">

        <!-- asmo sh 231215 디자인 상 장바구니, 구매내역 버튼 필요하여 div.cmall_orderlist_top_box 생성  -->
		<div class="cmall_orderlist_top_box">
				
            <strong>활동 내역</strong>

            <div class="orderlist_top_flex_box">
                <a href="/cmall/wishlist">찜하기목록으로 <?=banner('heart_color')?></a>
                <a href="/cmall/cart">장바구니 <?=banner('cart')?></a>
                <a href="/cmall/orderlist">구매내역 <?=banner('purchase_history')?></a>
            </div>
            
        </div>

        <!-- asmo sh 231215 디자인 상 구매내역 조회할 div 생성  -->
        <form name="fsearch" id="fsearch" method="get" action="/cmall/activity">
            <div class="history_box_wrap">
                <div class="history_box">
                    <span>조회기간</span>
                    <div class="history_btn_box">
                        <input type="radio" name="selectDate" value="" id="date-all" <?php if($this->input->get('selectDate') == ''){ echo 'checked';} ?>>
                        <label for="date-all" class="history_btn_select_date">전체</label>
                        <input type="radio" name="selectDate" value="7" id="date-week1" <?php if($this->input->get('selectDate') == '7'){ echo 'checked';} ?>>
                        <label for="date-week1" class="history_btn_select_date">7일</label>
                        <input type="radio" name="selectDate" value="30" id="date-month1" <?php if($this->input->get('selectDate') == '30'){ echo 'checked';} ?>>
                        <label for="date-month1" class="history_btn_select_date">1개월</label>
                        <input type="radio" name="selectDate" value="90" id="date-month3" <?php if($this->input->get('selectDate') == '90'){ echo 'checked';} ?>>
                        <label for="date-month3" class="history_btn_select_date">3개월</label>
                    </div>
                    <div class="history_input_box">
                        <label for="start-date">시작 날짜:</label>
                        <input type="date" id="start-date" name="start-date" value="<?php echo $this->input->get('start-date') ?>">
                        <span>-</span>
                        <label for="end-date">종료 날짜:</label>
                        <input type="date" id="end-date" name="end-date" value="<?php echo $this->input->get('end-date') ?>">
                        <button type="submit">조회하기</button>
                    </div>
                </div>
            </div>
        </form>
		
		<div class="cmall-list">

            <!-- asmo sh 231226 디자인 상 table 생성 -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 14%">날짜</th>
                            
                                <th style="width: 45.5%">내용</th>
                                
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
                                <td class="asmo_activity"><?php echo $v['log_txt'];?></td>
                                
                            </tr>
                            <?php
                        }
                    }else{
                        echo "<tr><td class=", "nopost" ," colspan='5'>활동 내역이 없습니다.</td></tr>";
                    }
                ?>
                    </tbody>
                </table>
            </div>

            <!-- <?php 
                if(count($view['data']['list'])>0){
                    foreach($view['data']['list'] as $k=>$v){
                        ?>
                        <div style="border-top:solid 1px black; padding:20px;">
                            <div style="padding:5px;">날짜 : <?php echo substr($v['log_regDt'],0,10);?></div>
                            <div style="padding:5px;">내용 : <?php echo $v['log_txt'];?></div>
                        </div>
                        <?php
                    }
                }else{
                    echo "내역이 없습니다.";
                }
            ?> -->
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
