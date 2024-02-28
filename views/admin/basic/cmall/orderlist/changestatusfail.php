<style>
    h4{font-weight:bold;}
    .wrap{margin:20px;}
    th{text-align:center;}
</style>

<div class="wrap text-center">
    <h2 class="mb20">아래 주문건은 기업예치금이 부족하여​<br/>주문상태 변경이 불가합니다.​</h2>
    <div>
        <table class="table table-hover table-bordered mg0">
            <tbody>
                <tr>
                    <th>주문번호</th>
                    <th>주문상품</th>
                    <th>기업명</th>
                    <th>보유예치금</th>
                    <th>필요예치금</th>
                </tr>
                <?php
                    foreach($view['data'] as $company_idx=>$v){

                        foreach($v['detail'] as $k2=>$detail){
                ?>
                <tr>
                    <td><?php echo $detail['cor_id'];?></td>
                    <td><?php echo $detail['cit_name'];?></td>

                    <?php if($k2==0){ ?>
                    <td rowspan=<?php echo count($v['detail']);?>><?php echo $v['company_name'];?></td>
                    <td rowspan=<?php echo count($v['detail']);?>><?php echo $v['company_deposit'];?></td>
                    <?php } ?>
                    
                    <td><?php echo number_format($detail['amount']);?></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt20 text-center mb20">
    <button class="btn btn-default btn_history_back" type="button">확인</button>
</div>

<script>
document.querySelector(".btn_history_back").addEventListener("click",function(){
   location.replace("<?php echo $view['return_url'];?>");
});

</script>