<div class="box">
	<div class="box-table">
		<?php echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>'); ?>
		<div class="box-table-header">
			<h4><a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">기업 예치금 추가</a></h4>
			<a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1"><i class="fa fa-chevron-up pull-right"></i></a>
		</div>
		<div class="collapse in" id="collapse1">
            <form action="/admin/deposit/companydeposit/save" class="form-horizontal" id="fadminwrite" method="post" accept-charset="utf-8" novalidate="">
				<input type="hidden" name="csrf_test_name" value="">
				<div class="form-group">
					<label class="col-sm-2 control-label">기업</label>
					<div class="col-sm-10 form-inline">
						<select name="company_idx" class="form-control">
                            <?php
                                foreach($view['data']['companys'] as $k=>$v){
                                    ?>
                                    <option value="<?php echo $v['company_idx'];?>" ><?php echo $v['company_name'];?> (code : <?php echo $v['company_idx'];?>)</option>
                                    <?php
                                }
                            ?>
                        </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">예치금</label>
					<div class="col-sm-10">
						<input type="number" name="ccd_deposit" value="0" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">내용</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="ccd_content" value="<?php echo set_value('poi_content'); ?>" />
					</div>
				</div>
				<div class="btn-group pull-right" role="group" aria-label="...">
					<button type="submit" class="btn btn-outline btn-success btn-sm">기업 예치금 추가하기</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.querySelector('[name="csrf_test_name"]').value = cb_csrf_hash;
</script>
