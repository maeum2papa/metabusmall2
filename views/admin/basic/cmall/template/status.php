<div class="modal-header">
	<h4 class="modal-title">템플릿 사용현황[<?php echo number_format($view['data']['total_rows']);?>]</h4>
</div>
<div class="modal-body">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>기업명</th>
                <th>상품코드</th>
                <th>상품명</th>
                <th>교환 포인트</th>
                <th>교환기간</th>
                <th>노출여부</th>
                <th>교환횟수</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (element('list', element('data', $view))) {
            foreach (element('list', element('data', $view)) as $result) {

                //판매 기간
                if($result['cit_view_type'] == 'n'){
                    if($result[cit_download_days]>0){
                        $after_cit_download_days = substr($result['cit_datetime'], 0, 10);
                        $cit_download_days = date("Y-m-d", strtotime("+".$result['cit_download_days']." day", strtotime($after_cit_download_days)))."까지";
                    }else{
                        $cit_download_days = "무제한";	
                    }
                    
                }else{
                    $cit_download_days = $result['cit_startDt']."~<br>".$result['cit_endDt'];
                }
        ?>
            <tr>
                <td><?php echo $result['company_name']; ?></td>
                <td><?php echo $result['cit_key']; ?></td>
                <td><?php echo $result['cit_name']; ?></td>
                <td><?php echo number_format($result['cit_price']); ?>개</td>
                <td><?php echo $cit_download_days; ?></td>
                <td><?php echo $result['cit_status']; ?></td>
                <td><?php echo number_format($result['cit_template_item_order_count']); ?></td>
            </tr>
        <?php
            }
        }
        if ( ! element('list', element('data', $view))) {
        ?>
            <tr>
                <td colspan="14" class="nopost">자료가 없습니다</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <div class="box-info form-inline">
        <?php echo element('paging', $view); ?>
        <div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
        <?php echo $buttons; ?>
    </div>
</div>
<div class="modal-footer">
	<button type="submit" class="btn btn-black btn-sm" onClick="window.close();">닫기</button>
</div>
