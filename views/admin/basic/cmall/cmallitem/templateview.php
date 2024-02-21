<style>
    .form-group{overflow:hidden;}
</style>
<div class="box">
    <h4 class="mt10">템플릿 상품 상세</h4>
    <div class="btn-group pull-right" role="group" aria-label="...">
        <button type="button" class="btn btn-default btn-sm btn-history-back" >목록으로</button>
    </div>
	<div class="box-table">
            
            <div class="collapse in">
                <div class="form-group">
                    <label class="col-sm-2 control-label">상품이미지</label>
                    <div class="col-sm-10 form-inline">
                        <?php for ($k = 1; $k<= 10; $k++) { ?>
                            <?php
                            if (element('citt_file_' . $k, element('data', $view))) {
                            ?>
                                <img src="<?php echo thumb_url('cmallitemtemplate', element('citt_file_' . $k, element('data', $view)), 80)?>" width="80px" alt="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" title="<?php echo isset($detail) ? html_escape(element('cde_title', $detail)) : ''; ?>" />
                            <?php
                            }
                            ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">상품명</label>
                    <div class="col-sm-10 form-inline">
                        <?php echo element('citt_name', element('data', $view)); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">상품설명</label>
                    <div class="col-sm-10 form-inline">
                        <?php echo element('citt_summary', element('data', $view)); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">배송방법</label>
                    <div class="col-sm-10 form-inline">
                        <?php echo element('citt_ship_type', element('data', $view));?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">예치금차감금액</label>
                    <div class="col-sm-10 form-inline">
                        - <?php echo element('citt_deposit', element('data', $view));?> 원
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">상품내용</label>
                    <div class="col-sm-10 form-inline">
                            <div>
                                <?php echo element('citt_content', element('data', $view));?>
                            </div>
                    </div>
                </div>

            </div>
            
	</div>

    <div class="btn-group pull-right mt10 mb20" role="group" aria-label="...">
        <button type="button" class="btn btn-default btn-sm btn-history-back" >목록으로</button>
    </div>
</div>