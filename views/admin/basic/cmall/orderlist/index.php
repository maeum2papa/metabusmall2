<style type="text/css">
.cmall-options {background: #F2F3F5;border: 1px solid #DEE3E0;margin: 5px 0;border-bottom: 0;}
.cmall-options li {color: #5A5A5A;border-bottom: 1px solid #DEE3E0;padding: 5px;}
.table.table-border-none td{border:0;}
.status-options {display:flex; align-items: center; justify-content: flex-end;}
.status-options button{border-radius:3px;}
#search_form th{padding:10px;}
#search_form td{padding:10px;}
.order_item_detail{ padding:10px; border-top:1px dashed gray;}
.order_item_detail:nth-child(1){border-top:0;}
</style>

<div class="box">
	<div class="box-table">
	<?php
	echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	echo show_alert_message($this->session->flashdata('dangermessage'), '<div class="alert alert-auto-close alert-dismissible alert-danger"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	?>
		<div class="box-table-header">
			<div class="btn-group btn-group-sm" role="group">
                <?php if($this->session->userdata['mem_admin_flag']==0){?>
                
                    <a href="<?php echo admin_url('cmall/orderlist'); ?>?citt_id_use=1" class="btn btn-sm btn-info">템플릿상품</a>

                <?php }else{ ?>

                    <a href="<?php echo admin_url('cmall/orderlist'); ?>" class="btn btn-sm <?php echo ( $this->input->get('citt_id_use') == "") ? 'btn-success' : 'btn-default';?>">전체내역</a>
                    <a href="<?php echo admin_url('cmall/orderlist'); ?>?citt_id_use=0" class="btn btn-sm <?php echo ($this->input->get('citt_id_use') === '0') ? 'btn-info' : 'btn-default';?>">자체상품</a>
                    <a href="<?php echo admin_url('cmall/orderlist'); ?>?citt_id_use=1" class="btn btn-sm <?php echo ($this->input->get('citt_id_use') === '1') ? 'btn-info' : 'btn-default';?>">템플릿상품</a>

                <?php } ?>
				
			</div>
			<?php
			ob_start();
			?>
				<div class="btn-group pull-right" role="group" aria-label="...">
                    <a class="btn btn-outline btn-success btn-sm export_to_excel" >엑셀시트다운로드</a>
				</div>
			<?php
			$buttons = ob_get_contents();
			ob_end_flush();
			?>
		</div>
        <div>
			<form id="search_form" method="get" enctype="multipart/form-data">
                <input type="hidden" name="citt_id_use" value="<?php echo $this->input->get("citt_id_use")?>">
				<table>
					<tr>
						<th>처리일자</th>
						<td>
							<select name="search_datetime_type" class="form-control change-status px140">
								<option value="cor_datetime" >주문확인일시</option>
                                <option value="cor_ready_datetime" <?php echo ($this->input->get("search_datetime_type")=="cor_ready_datetime")?"selected":"";?>>발송대기일시</option>
								<option value="cor_end_datetime" <?php echo ($this->input->get("search_datetime_type")=="cor_end_datetime")?"selected":"";?>>발송완료일시</option>
								<option value="cor_cancel_datetime" <?php echo ($this->input->get("search_datetime_type")=="cor_cancel_datetime")?"selected":"";?>>주문취소일시</option>
							</select>
							<input type="date" name="search_datetime_start" value="<?php echo substr($this->input->get('search_datetime_start'),0,10);?>" class="form-control px140"> - 
							<input type="date" name="search_datetime_end" value="<?php echo substr($this->input->get('search_datetime_end'),0,10);?>" class="form-control px140">
						</td>
					</tr>
					<tr>
						<th>주문상태</th>
						<td>
							<div class="checkbox-inline">
								<input type="checkbox" name="status[]" value="order" id="status_order" <?php echo (in_array("order",$this->input->get("status")))?"checked":"";?>> <label for="status_order">주문확인</label>
							</div>
                            <div class="checkbox-inline">
								<input type="checkbox" name="status[]" value="ready" id="status_ready" <?php echo (in_array("ready",$this->input->get("status")))?"checked":"";?>> <label for="status_ready">발송대기</label>
							</div>
							<div class="checkbox-inline">
								<input type="checkbox" name="status[]" value="end" id="status_end" <?php echo (in_array("end",$this->input->get("status")))?"checked":"";?>> <label for="status_end">발송완료</label>
							</div>
							<div class="checkbox-inline">
								<input type="checkbox" name="status[]" value="cancel" id="status_cancel" <?php echo (in_array("cancel",$this->input->get("status")))?"checked":"";?>> <label for="status_cancel">주문취소</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>주문자정보</th>
						<td>
							<select class="form-control px140" name="search_order_key">
								<option value="mem_phone" >주문자 연락처</option>
								<option value="mem_email" <?php echo ($this->input->get("search_order_key")=="mem_email")?"selected":"";?>>주문자 이메일</option>
								<option value="mem_realname" <?php echo ($this->input->get("search_order_key")=="mem_realname")?"selected":"";?>>주문자 이름</option>
							</select>
							<input type="text" name="search_order_value" value="<?php echo $this->input->get("search_order_value");?>" class="form-control px300">
						</td>
					</tr>
					<tr>
						<th>주문번호</th>
						<td><input type="text" name="cor_id" value="<?php echo $this->input->get("cor_id");?>" class="form-control"></td>
					</tr>
					<?php if($this->session->userdata['mem_admin_flag']==0){?>
					<tr>
						<th>기업</th>
						<td>
							<?php
								foreach($view['data']['companys'] as $k=>$v){
									?>
									<div class="checkbox-inline">
										<input type="checkbox" name="company_idx[]" value="<?php echo $v['company_idx'];?>" id="company_idx_<?php echo $k+1;?>" <?php echo (in_array($v['company_idx'],$this->input->get("company_idx")))?"checked":"";?>> <label for="company_idx_<?php echo $k+1;?>"><?php echo $v['company_name'];?></label>
									</div>
									<?php
								}
							?>
						</td>
					</tr>
					<?php }?>
				</table>
				<div class="mt10">
					<button class="btn btn-outline btn-default btn-sm" type="submit">검색</button>
				</div>
			</form>
		</div>
		<hr></hr>
        <div class="row">
			
			<table class="table table-border-none mg0">
				<tr>
					<td>전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</td>
					<td class="text-right status-options">
						<div class="pr5">선택한 것을 : </div>
						<select class="form-control per20 change-status">
							<option value="order">주문확인</option>
							<option value="ready">발송대기</option>
							<option value="end">발송완료</option>
							<option value="cancel">주문취소</option>
						</select>
						<div class="px50">
							<button class="btn btn-default btn-sm btn-status-change" type="button">변경</button>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
                        <th>선택</th>
						<th>주문번호</th>
						<th>분류</th>

                        <?php if($this->session->userdata['mem_admin_flag']!=0){?>
                        <th>부서명</th>
                        <th>직책</th>
                        <?php } ?>

                        <?php if($this->session->userdata['mem_admin_flag']==0){?>
						<th>기업명</th>
                        <?php } ?>

						<th>직원명</th>
						<th>주문상품</th>
						<th>주문상태</th>

                        <?php if($this->session->userdata['mem_admin_flag']!=0){?>
                        <th>사용포인트</th>
						<?php } ?>

                        <th>차감예치금</th>
                        <th>보기</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$custom_config = config_item("custom");
				
				if (element('list', element('data', $view))) {
					foreach (element('list', element('data', $view)) as $result) {

                        if(element('citt_id', $result)==0){
                            $type = "자체";
                            $deposit = "0";
                        }else{
                            $type = "템플릿"; //템플릿만 예치금 차감 대상
                            $deposit = "-".number_format(element('cod_point', $result)*100);
                        }

				?>
					<tr>
                        <td>
                        
                            <?php if($this->session->userdata['mem_admin_flag']!=0 && $result['citt_id'] > 0){?>
                                <input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('cod_id', $result); ?>" disabled>     
                            <?php }else{ ?>
                                <input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('cod_id', $result); ?>" >
                            <?php } ?>
                        </td>
						<td><a href="<?php echo site_url('cmall/orderresult/' . element('cor_id', $result)); ?>" target="_blank"><?php echo element('cor_id', $result); ?></a></td>
						<td><?php echo $type; ?></td>

                        <?php if($this->session->userdata['mem_admin_flag']!=0){?>
                        <td><?php echo element('mem_div', $result); ?></td>
                        <td><?php echo element('mem_position', $result); ?></td>
                        <?php } ?>

                        <?php if($this->session->userdata['mem_admin_flag']==0){?>
						<td><?php echo element('company_name', $result); ?></td>
                        <?php } ?>


						<td><?php echo element('mem_username', $result); ?></td>
						<td><?php echo element('cit_name', $result); ?></td>
						<td><?php echo element('cod_status_name', $result); ?></td>

                        <?php if($this->session->userdata['mem_admin_flag']!=0){?>
                        <td class="text-right"><?php echo number_format(element('cod_point', $result)); ?></td>
                        <?php } ?>

						<td class="text-right"><?php echo $deposit; ?></td>
                        <td><a href="<?php echo '/admin/cmall/cmallorder/form/'. element('cor_id', $result); ?>">보기</a></td>
                        
					</tr>
					<?php
					if (element('orderdetail', $result)) {
					?>
						<tr>
							<td colspan="7" >
								<div class="bg-warning">
									<table class="table table-bordered mt20">
										<thead>
											<tr class="success">
												<th>이미지</th>
												<th>상품명</th>
												<th class="text-center">총수량</th>
												<th>판매가</th>
												<th>소계</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$total_price_sum = 0;
											foreach (element('orderdetail', $result) as $row) {
										?>
											<tr>
												<td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>"><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', element('item', $row)), 60, 60); ?>" class="thumbnail" style="margin:0;width:60px;height:60px;" alt="<?php echo html_escape(element('cit_name', element('item', $row))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $row))); ?>" /></a></td>
												<td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>"><?php echo html_escape(element('cit_name', element('item', $row))); ?></a>
													<ul class="cmall-options">
														<?php
														$total_num = 0;
														$total_price = 0;
														foreach (element('itemdetail', $row) as $detail) {
														?>
															<li><?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cod_count', $detail);?>개 
															<?php 
																if(element('cde_price', $detail)!=0){
															?>
															(+<?php echo number_format(element('cde_price', $detail)); ?>
																	
																	<?php
																		if($result['cor_pay_type']=="c"){
																			echo "개";
																		}else{
																			echo "원";
																		}
																	?>
															
															)
															<?php
																}
															?>
															</li>
														<?php
														$total_num += element('cod_count', $detail);
														$total_price += ((int) element('cit_price', element('item', $row)) + (int) element('cde_price', $detail)) * element('cod_count', $detail);
														}
														$total_price_sum += $total_price;
														?>
													</ul>
												</td>
												<td class="text-center"><?php echo number_format($total_num); ?></td>
												<td><?php echo number_format(element('cit_price', element('item', $row))); ?></td>
												<td><?php echo number_format($total_price); ?><input type="hidden" name="total_price[<?php echo element('cit_id', element('item', $row)); ?>]" value="<?php echo $total_price; ?>"></td>
											</tr>
										<?php
										}
										?>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					<?php
							}
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="12" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="box-info">
			<?php echo element('paging', $view); ?>
			<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
			<?php echo $buttons; ?>
		</div>
	</div>
</div>

<script type="text/javascript">

document.querySelector(".btn-status-change").addEventListener('click',function(){
	
	var checkboxs = document.querySelectorAll('[name="chk[]"]:checked');

	if(checkboxs.length == 0){
		alert("자료를 선택해 주세요.");
		return false;
	}

    
	var form = document.createElement('form');

	form.action = '/admin/cmall/orderlist/statuschange'; // 폼의 액션 URL 설정
    form.method = 'POST'; // 폼의 전송 방식 설정
	form.enctype = 'multipart/form-data';

	var csrf_test_name = document.createElement('input');
    csrf_test_name.type = 'hidden';
    csrf_test_name.name = 'csrf_test_name';
    csrf_test_name.value = cb_csrf_hash;

	var change_status = document.createElement('input');
	change_status.type = 'hidden';
    change_status.name = 'change_status';
    change_status.value = document.querySelector(".status-options .change-status").value;

	form.appendChild(csrf_test_name);
	form.appendChild(change_status);

	var change_status = '';
	checkboxs.forEach(element => {
		change_status = document.createElement('input');
		change_status.type = 'hidden';
		change_status.name = 'chk[]';
		change_status.value = element.value;
		form.appendChild(change_status);
	});

	// 동적으로 생성한 폼을 body에 추가
    document.body.appendChild(form);

	// 폼 제출
    form.submit();
    

});

</script>
