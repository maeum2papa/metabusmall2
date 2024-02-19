<div class="modal-header">
	<h4 class="modal-title">템플리 사용현황[5]</h4>
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
                
        ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>0</td>
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
