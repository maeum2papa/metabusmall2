<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	.dn{display:none;}
</style>
<script type="text/javascript" src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>

<div class="box">
	<div class="box-table">
	<ul class="prd-list">

		<?php
		$custom_config = config_item("custom");
		$result = element('data', $view);
		if (element('orderdetail', $view)) {

			$status_cancel_cnt = 0;
			$cod_cnt = 0;
			$item_cnt = 0;
			
			$all_checkbox_disabled = '';
			foreach (element('orderdetail', $view) as $k=>$row) {
				$checkbox_disabled = '';
				
				if($row['item']['cit_item_type'] == 'i'){
					$checkbox_disabled = 'disabled';
					$all_checkbox_disabled = 'disabled';
				}

				foreach($row['itemdetail'] as $k2=>$v2){
					if($v2['cod_status']=='cancel'){
						$checkbox_disabled = 'disabled';
						$all_checkbox_disabled = 'disabled';
					}

					if($v2['cod_status'] == 'cancel'){
						$status_cancel_cnt++;
					}
					
					$cod_cnt++;
				}

				if($row['item']['cit_item_type'] == 'i'){
					$item_cnt++;
				}

				if($this->session->userdata['mem_admin_flag']!=0){
					if($this->session->userdata['company_idx']!=$row['item']['company_idx']){
						$checkbox_disabled = 'disabled';
						$all_checkbox_disabled = 'disabled';
					}
				}

				$view['orderdetail'][$k]['checkbox_disabled'] = $checkbox_disabled;
			}
		?>
		<li>
			<h4 class="h2_frm">아이템교환소 상세 주문내역</h4>

			<div class="text-right"><button class="btn btn-outline btn-sm btn-history-back">목록으로</button></div>

			<h5 class="mt10">주문자 정보</h5>
			<table class="table table-bordered mt10">
				<tbody>
					</tr>

						<?php if($this->session->userdata['mem_admin_flag']==0){?>
						<th>기업명</th>
						<td><?php echo $view['company_info']['company_name'];?></td>
						<?php } ?>
						
						<th>소속</th>
						<td><?php echo $view['order_member']['mem_div'];?></td>

						<th>직책</th>
						<td><?php echo $view['order_member']['mem_position'];?></td>

						<th>이름</th>
						<td><?php echo $view['order_member']['mem_username'];?></td>
					</tr>
					</tbody>
			</table>
			
			<?php
			$attributes = array('class' => 'frmorderform', 'name' => 'frmorderform', 'onsubmit'=> 'return form_submit(this)');
			echo form_open(current_full_url(), $attributes);
			?>
			<input type="hidden" name="cor_pay_type" id="cor_pay_type" value="<?php echo element('cor_pay_type', $result); ?>">
			<input type="hidden" name="cor_id" value="<?php echo element('cor_id', $result); ?>">
			<input type="hidden" name="mem_id" value="<?php echo element('mem_id', $result); ?>">
			<input type="hidden" name="pcase" value="product">
			<input type="hidden" name="pg_cancel" value="0">
			
			<h5 class="mt10">주문 정보</h5>
			
			<div>
			<table class="table table-bordered mt10">
				<thead>
					<tr class="success">
						<th>
							<input type="checkbox" name="chkall" id="chkall" <?php echo $all_checkbox_disabled;?>>
						</th>
						
						<?php if($view['is_item']!=1){?>
						<th>상품분류</th>
						<?php } ?>

						<th class="text-center">상태</th>
						<th>이미지</th>
						<th>상품명</th>
						<th class="text-center">총수량</th>
						<th>교환<?php echo ($view['is_item']!=1)?"포인트":"열매";?></th>
						<th>소계</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$i = 0;
					foreach (element('orderdetail', $view) as $row) {
				?>
					<tr>
						<td>
						
						<input type="checkbox" id="ct_chk_<?php echo $i; ?>" class="product_chk" name="chk[]" value="<?php echo $i; ?>" <?php echo $row['checkbox_disabled'];?>>

						<input type="hidden" name="cit_id[]" value="<?php echo element('cit_id', element('item', $row)); ?>">
						</td>

						<?php if($view['is_item']!=1){?>
						<td>
							<?php				
							echo ($row['item']['citt_id']>0)?"템플릿":"자체";
							?>
						</td>
						<?php } ?>

						<td class="text-center">
							<?php 
							if($row['cod_status']=="order"){
								echo "주문확인";
							}elseif($row['cod_status']=="ready"){
								echo "발송대기";
							}elseif($row['cod_status']=="end"){
								echo "발송완료";
							}elseif($row['cod_status']=="cancel"){
								echo "주문취소";
							}
							?>
						</td>
						<td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>" target="_blank"><img src="<?php echo thumb_url('cmallitem', element('cit_file_1', element('item', $row)), 60, 60); ?>" class="thumbnail" style="margin:0;width:60px;height:60px;" alt="<?php echo html_escape(element('cit_name', element('item', $row))); ?>" title="<?php echo html_escape(element('cit_name', element('item', $row))); ?>" /></a></td>
						<td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>" target="_blank"><?php echo html_escape(element('cit_name', element('item', $row))); ?></a></td>
						<td class="text-center">
							<?php echo $row['cod_count']; ?>
						</td>

						<?php if($view['is_item']!=1){?>
							<td><?php echo number_format($row['cod_point']); $total_price = $row['cod_point'];?></td>
						<?php }else{ ?>
							<td><?php echo number_format($row['cod_fruit']); $total_price = $row['cod_fruit'];?></td>
						<?php } ?>

						<td><?php echo number_format($total_price); ?><input type="hidden" name="total_price[<?php echo element('cit_id', element('item', $row)); ?>]" value="<?php echo $total_price; ?>"></td>
						
					</tr>
				<?php
				$i++;
				} //end foreach
				?>
				</tbody>
			</table>
			</div>
			<?php 
				$ct_status_order_disabled = '';
				$ct_status_ready_disabled = '';
				$ct_status_end_disabled = '';
				$ct_status_cancel_disabled = '';

				//상태가 주문취소인 상품 수와 상품 수가 일치 = 모두 취소된 것으로 버튼 비활성화
				//주문상품 종류 수와 주문상품중 아이템인 상품 수가 일치 = 모두 취소된 것으로 버튼 비활성화
				if($status_cancel_cnt == $cod_cnt || count($view['orderdetail']) == $item_cnt){
					$ct_status_order_disabled = 'disabled';
					$ct_status_ready_disabled = 'disabled';
					$ct_status_end_disabled = 'disabled';
					$ct_status_cancel_disabled = 'disabled';
				}
			?>
			<div class="btn_list02 btn_list">
				<p>
					<input type="hidden" name="chk_cnt" value="<?php echo $i; ?>">
					<strong>주문상품 상태 변경</strong>
					<input type="submit" name="ct_status" value="주문확인" onclick="document.pressed=this.value" class="btn btn-sm" <?php echo $ct_status_order_disabled;?>>
					<input type="submit" name="ct_status" value="발송대기" onclick="document.pressed=this.value" class="btn btn-sm" <?php echo $ct_status_ready_disabled;?>>
					<input type="submit" name="ct_status" value="발송완료" onclick="document.pressed=this.value" class="btn btn-sm" <?php echo $ct_status_end_disabled;?>>
					<input type="submit" name="ct_status" value="주문취소" onclick="document.pressed=this.value" class="btn btn-sm" <?php echo $ct_status_cancel_disabled;?>>
				</p>
			</div>
		<?php echo form_close(); ?>
		<?php
		} //end if
		?>
	</ul>

	<hr></hr>
	<!-- <div class="alert alert-success">
		<p>주문, 입금, 준비, 배송, 완료는 장바구니와 주문서 상태를 모두 변경하지만, 취소, 반품, 품절은 장바구니의 상태만 변경하며, 주문서 상태는 변경하지 않습니다.</p>
		<p>개별적인(이곳에서의) 상태 변경은 모든 작업을 수동으로 처리합니다. 예를 들어 주문에서 입금으로 상태 변경시 입금액(결제금액)을 포함한 모든 정보는 수동 입력으로 처리하셔야 합니다.</p>
	</div> -->

	<?php if ( element('is_test', element('data', $view)) ) { ?>
	<div class="bg-classes">
		<p class="bg-danger">주의) 이 주문은 테스트용으로 실제 결제가 이루어지지 않았습니다.</p>
	</div>
	<?php } ?>

	<?php if ( element('cor_order_history', element('data', $view)) ) { ?>
	<section class="bs-callout bs-callout-warning">
		<h4>주문 수량변경 및 주문 전체취소 처리 내역</h4>
		<div>
			<?php echo nl2br(element('cor_order_history', element('data', $view))); ?>
		</div>
	</section>
	<?php } ?>

	<div class="credit row">
	<?php
	$attributes = array('class' => 'frm_orderinfo', 'name' => 'frm_orderinfo');
	echo form_open(current_full_url(), $attributes);
	?>
	<input type="hidden" name="cor_id" value="<?php echo element('cor_id', $result); ?>">
	<input type="hidden" name="mem_id" value="<?php echo element('mem_id', $result); ?>">
	<input type="hidden" name="pcase" value="info">
		
		<div class="clearfix">
		<div class="col-xs-12 col-md-6">
			<div class="ord-info">
				<h5 class="ord_info_title mb10">결제정보</h5>
				<table class="table">
					<tbody>
						<tr>
							<th>주문번호</th>
							<td><?php echo element('cor_id', element('data', $view)); ?></td>
						</tr>
						<?php if($view['is_item']!=1){?>
						<tr>
							<th>사용포인트</th>
							<td>
								<?php
									$total_point = 0;
									foreach($view['orderdetail'] as $orderdetail){
										
										$total_point += $orderdetail['cod_point'];
									}
									echo number_format($total_point);
								?>
								개
							</td>
						</tr>
						<?php }else{?>
							<tr>
							<th>사용열매</th>
							<td>
								<?php
									$total_point = 0;
									foreach($view['orderdetail'] as $orderdetail){
										
										$total_point += $orderdetail['cod_fruit'];
									}
									echo number_format($total_point);
								?>
								개
							</td>
						</tr>
						<?php }?>
						<?php if($view['is_item']!=1){?>
						<tr>
							<th>예치금차감금액</th>
							<td class="text-danger">
								<?php echo number_format($total_point*(-100))?> 원
								<?php 
									if($view['data']['status']=="order"){
										echo "(대기)";
									}elseif($view['data']['status']=="ready" || $view['data']['status']=="end"){
										echo "(차감완료)";
									}elseif($view['data']['status']=="cancel"){
										echo "(취소)";
									}
								?>
								
							</td>
						</tr>
						<?php }?>
						<?php if (element('cor_approve_datetime', element('data', $view)) > '0000-00-00 00:00:00') { ?>
							<tr>
								<th>주문일시</th>
								<td><?php echo element('cor_approve_datetime', element('data', $view)); ?></td>
							</tr>
						<?php } ?>
						<?php if (element('cor_pay_type', element('data', $view)) === 'bank') {?>
							<tr>
								<th>입금자명</th>
								<td><?php echo html_escape(element('mem_realname', element('data', $view))); ?></td>
							</tr>
							<tr>
								<th>입금계좌</th>
								<td><?php echo nl2br(html_escape($this->cbconfig->item('payment_bank_info'))); ?></td>
							</tr>
						<?php } ?>
						<?php if (element('cor_pay_type', element('data', $view)) === 'card') {?>
							<tr>
								<th>승인번호</th>
								<td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
							</tr>
						<?php } ?>
						<?php if (element('cor_pay_type', element('data', $view)) === 'phone') {?>
							<tr>
								<th>휴대폰번호</th>
								<td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
							</tr>
						<?php } ?>
						<?php if (element('cor_pay_type', element('data', $view)) === 'vbank' OR element('cor_pay_type', element('data', $view)) === 'realtime') {?>
							<tr>
								<th>거래번호</th>
								<td><?php echo html_escape(element('cor_tno', element('data', $view))); ?></td>
							</tr>
						<?php } ?>
						<?php if ( element('cor_pay_type', element('data', $view)) === 'vbank' ){	//가상계좌이면 ?>
							<tr>
								<th>입금계좌</th>
								<td><?php echo element('cor_bank_info', element('data', $view)); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 ">

			<?php if($view['data']['cor_ship_zipcode']!=''){ ?>
			<div>
				<h5 class="mb10">배송 정보</h5>
				<table class="table">
					<colgroup>
						<col class="grid_3">
						<col>
					</colgroup>
					<tbody>
					<tr>
						<th>주문자 이름</th>
						<td>
							<?php echo $view['order_member']['mem_username'];?>
						</td>
					</tr>
					<tr>
						<th>연락처</th>
						<td>
							<?php echo $view['data']['mem_phone'];?>
						</td>
					</tr>
					<tr>
						<th>배송지</th>
						<td>
							
							<table class="table">
								<tr>
									<th>우편번호</th>
									<td>
										<input type="" class="form-control per50" name="cor_ship_zipcode" value="<?php echo $view['data']['cor_ship_zipcode'];?>">

										<button type="button" class="btn btn-black btn-sm" style="margin-top:0px;" onclick="win_zip('frm_orderinfo', 'cor_ship_zipcode', 'cor_ship_address', 'cor_ship_address_detail', 'cor_ship_address_detail', 'cor_ship_address4');">주소 검색</button>
									</td>
								</tr>
								<tr>
									<th>주소</th>
									<td><input type="" class="form-control per100" name="cor_ship_address" value="<?php echo $view['data']['cor_ship_address'];?>"></td>
								</tr>
								<tr>
									<th>주소상세</th>
									<td><input type="" class="form-control per100" name="cor_ship_address_detail" value="<?php echo $view['data']['cor_ship_address_detail'];?>"></td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th>주문메모</th>
						<td>
						<textarea class="form-control per100" rows=5 disabled><?php echo $view['data']['cor_content'];?></textarea>
						</td>
					</tr>
					
					</tbody>
				</table>
				<input type="hidden" name="cor_ship_address4" value="">
			</div>
			<?php }?>

			<div class="pay-info dn">
				<h5 class="ord_info_title mb10">결제상세정보</h5>
				<table class="table">
					<colgroup>
						<col class="grid_3">
						<col>
					</colgroup>
					<tbody>
					<?php
					$html_receipt_chk = '<input type="checkbox" id="od_receipt_chk" value="'.$notyet.'" onclick="chk_receipt_price()"><label for="od_receipt_chk">결제금액 입력</label><br>';

					$cor_pay_type = element('cor_pay_type', element('data', $view));
					$cor_bank_info = element('cor_bank_info', element('data', $view));

					if ( in_array($cor_pay_type, array('vbank', 'bank', 'realtime')) ) { ########## 시작

						if ($cor_pay_type === 'bank')  //무통장
						{
							// 은행계좌를 배열로 만든후
							$str = explode("\n", $this->cbconfig->item('payment_bank_info'));
							$bank_account .= '<select name="cor_bank_info" id="cor_bank_info">'.PHP_EOL;
							$bank_account .= '<option value="">선택하십시오</option>'.PHP_EOL;
							for ($i=0; $i<count($str); $i++) {
								$str[$i] = str_replace("\r", "", $str[$i]);

								$selected = ($cor_bank_info == $str[$i]) ? ' selected="selected"' : '';
								$bank_account .= '<option value="'.$str[$i].'" '.$selected.'>'.$str[$i].'</option>'.PHP_EOL;
							}
							$bank_account .= '</select> ';
						} else if ($cor_pay_type === 'vbank') {

							$bank_account = $cor_bank_info.'<input type="hidden" name="cor_bank_info" value="'.$cor_bank_info.'">';

						} else if ($cor_pay_type === 'realtime') {

							$bank_account = $this->cmalllib->get_paymethodtype(element('cor_pay_type', element('data', $view)));

						}
						
						if ( in_array($cor_pay_type, array('vbank')) ) { ?>
						<tr>
							<th scope="row"><label for="cor_bank_info">계좌번호</label></th>
							<td><?php echo $bank_account; ?></td>
						</tr>
						<?php } ?>

						<tr>
							<th scope="row"><label for="cor_cash"><?php echo $this->cmalllib->get_paymethodtype($cor_pay_type); ?> 입금액</label></th>
							<td>
								<?php echo $html_receipt_chk; ?>
								<input type="text" name="cor_cash" value="<?php echo element('cor_cash', element('data', $view)); ?>" id="cor_cash" class="frm_input"> 원
							</td>
						</tr>

						<tr>
							<th scope="row"><label for="mem_realname">입금자명</label></th>
							<td>
								<input type="text" name="mem_realname" value="<?php echo element('mem_realname', element('data', $view)); ?>" id="mem_realname">
							</td>
						</tr>

						<tr>
							<th scope="row"><label for="cor_approve_datetime">입금 확인일시</label></th>
							<td>

								<input type="text" name="cor_approve_datetime" value="<?php echo element('cor_approve_datetime', element('data', $view)); ?>" id="cor_approve_datetime" maxlength="19">
							</td>
						</tr>

					<?php } ?>

					<?php if ($cor_pay_type === 'phone') { //휴대폰 ?>
					<tr>
						<th scope="row">휴대폰번호</th>
						<td><?php echo $cor_bank_info; ?></td>
					</tr>
					<tr>
						<th scope="row"><label for="cor_cash"><?php echo $this->cmalllib->get_paymethodtype($cor_pay_type); ?> 입금액</label></th>
						<td>
							<?php echo $html_receipt_chk; ?>
							<input type="text" name="cor_cash" value="<?php echo element('cor_cash', element('data', $view)); ?>" id="cor_cash" class="frm_input"> 원
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="cor_approve_datetime">휴대폰 결제일시</label></th>
						<td>
							<input type="checkbox" name="od_bank_chk" id="od_bank_chk" value="<?php echo date("Y-m-d H:i:s", time()); ?>" onclick="if (this.checked == true) this.form.cor_approve_datetime.value=this.form.od_bank_chk.value; else this.form.cor_approve_datetime.value = this.form.cor_approve_datetime.defaultValue;">
							<label for="od_bank_chk">현재 시간으로 설정</label><br>
							<input type="text" name="cor_approve_datetime" value="<?php echo element('cor_approve_datetime', element('data', $view)); ?>" id="cor_approve_datetime" maxlength="19">
						</td>
					</tr>
					<?php } ?>

					<?php if ($cor_pay_type === 'card') { //신용카드 ?>
					<tr>
						<th>신용카드</th>
						<td><?php echo $cor_bank_info; ?></td>
					</tr>
					<tr>
						<th scope="row" class="sodr_sppay"><label for="cor_cash">신용카드 결제금액</label></th>
						<td>
							<?php echo $html_receipt_chk; ?>
							<input type="text" name="cor_cash" id="cor_cash" value="<?php echo element('cor_cash', element('data', $view)); ?>" size="10"> 원
						</td>
					</tr>
					<tr>
						<th scope="row" class="sodr_sppay"><label for="od_receipt_time">카드 승인일시</label></th>
						<td>
							<input type="checkbox" name="od_bank_chk" id="od_bank_chk" value="<?php echo date("Y-m-d H:i:s", time()); ?>" onclick="if (this.checked == true) this.form.cor_approve_datetime.value=this.form.od_bank_chk.value; else this.form.cor_approve_datetime.value = this.form.cor_approve_datetime.defaultValue;">
							<label for="od_bank_chk">현재 시간으로 설정</label><br>
							<input type="text" name="cor_approve_datetime" value="<?php echo element('cor_approve_datetime', element('data', $view)); ?>" id="cor_approve_datetime" maxlength="19">
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th><label for="cor_cash">결제 금액</label></th>
						<td>
							<input type="text" class="form-control per50" name="cor_cash" value="<?php echo element('cor_cash', element('data', $view)); ?>" id="cor_cash" disabled> 원
							
						</td>
					</tr>
					<tr>
						<th><label for="cor_approve_datetime">결제일시</label></th>
						<td>
							<input type="text" class="form-control per50" name="cor_approve_datetime" value="<?php echo element('cor_approve_datetime', element('data', $view)); ?>" id="cor_approve_datetime" maxlength="19" disabled>
						</td>
					</tr>
					<tr>
						<th><label for="cor_company_deposit">예치금 결제액</label></th>
						<td><input type="text" class="form-control per50" name="cor_company_deposit" value="<?php echo element('cor_company_deposit', element('data', $view)); ?>" id="cor_company_deposit" disabled> 원</td>
					</tr>
					<tr>
						<th><label for="cor_refund_price">결제취소/환불 금액</label></th>
						<td>
							<input type="text" class="form-control per50" name="cor_refund_price" value="<?php echo element('cor_refund_price', element('data', $view)); ?>" disabled> 원
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		</div>
		
		
		

		<div class="cor_admin_memo_box">
			<h4>관리자메모</h4>

			<div class="bg-classes">
				<p class="bg-warning">
					현재 열람 중인 주문에 대한 내용을 메모하는곳입니다.
				</p>
			</div>

			<div class="tbl_wrap">
				<label for="cor_admin_memo" class="sound_only">관리자메모</label>
				<textarea name="cor_admin_memo" id="cor_admin_memo" rows="8" class="form-control"><?php echo stripslashes(element('cor_admin_memo', element('data', $view))); ?></textarea>
			</div>
		</div>

		<div class="btn-group pull-right" role="group" aria-label="...">
			<button type="submit" class="btn btn-success btn-lg">저장하기</button>
		</div>
		
		<?php echo form_close(); ?>
	</div> <!-- end credit row class -->

	</div> <!-- end class box-table -->
</div> <!-- end class box -->

<script>
function form_submit(f){

	var check = false;
	var status = document.pressed;

	for (i=0; i<f.chk_cnt.value; i++) {
		if (document.getElementById('ct_chk_'+i).checked == true)
			check = true;
	}

	if (check == false) {
		alert("처리할 자료를 하나 이상 선택해 주십시오.");
		return false;
	}

	var msg = "";
	var cor_pay_type = document.getElementById("cor_pay_type").value;

		if(status == "취소") {
		var $ct_chk = jQuery("input.product_chk:checkbox");
		var chk_cnt = $ct_chk.size();
		var chked_cnt = $ct_chk.filter(":checked").size();
		var cancel_pg = "PG사의 ";

		if( (chk_cnt == chked_cnt) && (cor_pay_type == 'card' || cor_pay_type == 'easy') ) {
			if(confirm(cancel_pg+" 결제를 함께 취소하시겠습니까?\n\n한번 취소한 결제는 다시 복구할 수 없습니다.")) {
				f.pg_cancel.value = 1;
				msg = " 결제 취소와 함께 ";
			} else {
				f.pg_cancel.value = 0;
				msg = "";
			}
		}
	}
	
	if (confirm(msg+"\'" + status + "\' 상태를 선택하셨습니다.\n\n선택하신대로 처리하시겠습니까?")) {
		return true;
	} else {
		return false;
	}
}

// 결제금액 수동 설정
function chk_receipt_price()
{
	var chk = document.getElementById("od_receipt_chk");
	var price = document.getElementById("cor_cash");

	price.value = chk.checked ? (parseInt(chk.value) + parseInt(price.defaultValue)) : price.defaultValue;
}

</script>