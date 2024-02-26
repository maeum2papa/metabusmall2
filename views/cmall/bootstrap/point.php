<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
    header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	}

    body {
        background-color: #F1F1F1;
    }
</style>

<!-- asmo sh 231215 shop div#lists 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_history_list">
	<div class="history_lists" id="point_history">

        <!-- asmo sh 231215 디자인 상 장바구니, 구매내역 버튼 필요하여 div.cmall_orderlist_top_box 생성  -->
		<div class="history_list_top_box">
				
            <strong>복지포인트 내역</strong>
            
        </div>

        <!-- asmo sh 231215 디자인 상 구매내역 조회할 div 생성  -->
		<div class="history_box_wrap">
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

            <div class="history_box">
                <div class="history_input_box">
                    <label for="start-date">시작 날짜:</label>
                    <input type="date" id="start-date" name="start-date">
                    <span>-</span>
                    <label for="end-date">종료 날짜:</label>
                    <input type="date" id="end-date" name="end-date">
                    <button type="button">조회하기</button>
                </div>
            </div>
        </div>

        
		
		<div class="cmall-list">

            <!-- asmo sh 231226 디자인 상 table 생성 -->
            <div class="table-responsive">
                <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 230px">일시</th>
                                <th>내용</th>
                                <th style="width: 160px">구분</th>
                                <th style="width: 160px">개수</th>
                                <th style="width: 160px">합계</th>
                            </tr>
                        </thead>
                        <tbody>

                <?php
                    if(count($view['data']['list'])>0){
                        foreach($view['data']['list'] as $k=>$v){
                            ?>
                            <tr>
                                <td><?php echo substr($v['poi_datetime'],0,10);?></td>
                                <td style="padding-left: 35px;"><?php echo $v['poi_content'];?></td>
                                <td><?php if($v['poi_point'] > 0){ echo '획득'; } else { echo '차감'; } ?> </td>
                                <td class="<?php if($v['poi_point'] > 0){ echo 'asmo_plus'; } ?>"><?php echo $v['poi_point'];?>개</td>
                                <td><?php if ($v['poi_now_point'] > 0) echo $v['poi_now_point'], " 개" ?></td>
                            </tr>
                            <?php
                        }
                    }else{
                        echo "<tr><td class=", "nopost" ," colspan='5'>복지포인트 내역이 없습니다.</td></tr>";
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
                            <div style="padding:5px;">날짜 : <?php echo substr($v['poi_datetime'],0,10);?></div>
                            <div style="padding:5px;">유형 : <?php echo ($v['poi_point']>0)?"획득":"차감";?></div>
                            <div style="padding:5px;">내용 : <?php echo $v['poi_content'];?></div>
                            <div style="padding:5px;">코인내역 : <?php echo $v['poi_point'];?></div>
                            <div style="padding:5px;">잔여코인 : <?php echo $v['poi_now_point'];?></div>
                        </div>
                        <?php
                    }
                }else{
                    echo "내역이 없습니다.";
                }
            ?> -->
		</div>
	
        <nav><?php echo element('paging', $view); ?></nav>
		
	</div>
</div>
<script type="text/javascript">

    $(document).ready(function() {

		$('.main').addClass('add');

		// shop 페이지일 때 사이드바 메뉴 활성화
		$('#shop').addClass('selected');
    });
</script>

