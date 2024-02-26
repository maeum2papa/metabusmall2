<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
				<a href="<?php echo admin_url('cmall/cmallorder'); ?>" class="btn btn-sm <?php echo ( $this->input->get('citt_id_use') == "" || $this->input->get('citt_id_use') == NULL) ? 'btn-success' : 'btn-default';?>">전체내역</a>
                <a href="<?php echo admin_url('cmall/cmallorder'); ?>?citt_id_use=0" class="btn btn-sm <?php echo ($this->input->get('citt_id_use') === '0') ? 'btn-info' : 'btn-default';?>">자체상품</a>
                <a href="<?php echo admin_url('cmall/cmallorder'); ?>?citt_id_use=1" class="btn btn-sm <?php echo ($this->input->get('citt_id_use') === '1') ? 'btn-info' : 'btn-default';?>">템플릿상품</a>
				<!-- <a href="<?php echo admin_url('cmall/cmallorder'); ?>?cor_pay_type=bank" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'bank') ? 'btn-info' : 'btn-default';?>">무통장</a>
				<a href="<?php echo admin_url('cmall/cmallorder'); ?>?cor_pay_type=card" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'card') ? 'btn-info' : 'btn-default';?>">카드</a>
				<a href="<?php echo admin_url('cmall/cmallorder'); ?>?cor_pay_type=realtime" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'realtime') ? 'btn-info' : 'btn-default';?>">실시간</a>
				<a href="<?php echo admin_url('cmall/cmallorder'); ?>?cor_pay_type=vbank" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'vbank') ? 'btn-info' : 'btn-default';?>">가상계좌</a>
				<a href="<?php echo admin_url('cmall/cmallorder'); ?>?cor_pay_type=phone" class="btn btn-sm <?php echo ($this->input->get('cor_pay_type') === 'phone') ? 'btn-info' : 'btn-default';?>">핸드폰</a> -->
			</div>
			<?php
			ob_start();
			?>
				<div class="btn-group pull-right" role="group" aria-label="...">
					<a class="btn btn-outline btn-success btn-sm export_to_excel" >엑셀시트다운로드</a>
					<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
				</div>
			<?php
			$buttons = ob_get_contents();
			ob_end_flush();
			?>
		</div>
		<div>
			<form id="search_form" method="get" enctype="multipart/form-data">
				<table>
					<tr>
						<th>처리일자</th>
						<td>
							<select name="search_datetime_type" class="form-control change-status px140">
								<option value="cor_datetime">주문확인일시</option>
								<option value="cor_end_datetime">발송완료일시</option>
								<option value="cor_cancel_datetime">주문취소일시</option>
							</select>
							<input type="date" name="search_datetime_start" value="<?php echo substr($view['search']['search_datetime_start'],0,10);?>" class="form-control px140"> - 
							<input type="date" name="search_datetime_end" value="<?php echo substr($view['search']['search_datetime_end'],0,10);?>" class="form-control px140">
						</td>
					</tr>
					<tr>
						<th>주문상태</th>
						<td>
							<div class="checkbox-inline">
								<input type="checkbox" name="status[]" value="order" id="status_order" <?php echo (in_array("order",$this->input->get("status")))?"checked":"";?>> <label for="status_order">주문확인</label>
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
						<th><input type="checkbox" name="chkall" id="chkall"></th>
						<th>주문번호</th>
                        <th>기업명</th>
						<th>회원아이디</th>
						<th>회원명/실명</th>
						<th>주문상태</th>
						<th>전화번호</th>
                        <th>주문상품수</th>
						<th>결제수단</th>
						<th>주문합계</th>
						<th>입금합계</th>
						<th>주문취소</th>
						<th>보기</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if (element('list', element('data', $view))) {
					foreach (element('list', element('data', $view)) as $result) {

						$order_detail = element('orderdetail', $result);
						
						$input_chk_flag = "";
						foreach($order_detail as $k=>$v){
							if($v['item']['cit_item_type'] == 'i'){
								$input_chk_flag = "disabled";
								continue;
							}else{
								
								foreach($v['itemdetail'] as $k2=>$v2){
									if($result['status']!=$v2['cod_status'] || $v2['cod_status']=='cancel'){
										$input_chk_flag = "disabled";
									}
								}

							}
						}
				?>
					<tr>
						<td>
							<input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('cor_id', $result); ?>" <?php echo $input_chk_flag;?>>
						</td>
						<td><a href="<?php echo site_url('cmall/orderresult/' . element('cor_id', $result)); ?>" target="_blank"><?php echo element('cor_id', $result); ?></a>
						<?php if( element('is_test', $result) ){ ?>
							<span class="btn btn-xs btn-warning">테스트 결제</span>
						<?php } ?>
						</td>
                        <td>
                            <?php echo $result['company_name']; ?>
                        </td>
						<td><a href="?sfield=deposit.mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('mem_userid', $result)); ?></a></td>
						<td><?php echo element('display_name', $result); ?> / <?php echo html_escape(element('mem_realname', $result)); ?></td>
						<td><?php echo element('order_status', $result);	 //주문상태 ?></td>
						<td>
                            <?php
                                echo preg_replace('/(\d{3})(\d{4})(\d{4})/', '$1-$2-$3', $result['mem_phone']);
                            ?>
                        </td>
                        <td>
                            <?php 

                                foreach($result['orderdetail'] as $k => $v){
                                    foreach($v['itemdetail'] as $k2 =>$v2){
										$disabled = '';
                                        $ea = '';

                                        if($v2['cod_count'] > 1){
                                            $ea = 'X'.$v2['cod_count'];
                                        }

										if($this->session->userdata['mem_admin_flag']!=0){
											if($this->session->userdata['company_idx'] == $v['item']['company_idx']){
												$disabled="style='color:gray'";
											}
										}
										$cca_id = cmall_item_parent_category($v['cit_id']);
                                        ?>
                                        <div <?php echo $disabled?> class="order_item_detail">

											[
											<?php 
												if($config_item['category']['basic'] == $cca_id){
													echo "공용몰";
												}else if($config_item['category']['item'] == $cca_id){
													echo "아이템몰";
												}else if($config_item['category']['company'] == $cca_id){
													echo "기업몰";
												}
											?>
											]

                                            <?php echo $v['item']['cit_name']; ?>
                                            [옵션 : <?php echo $v2['cde_title']; ?>]
                                            <?php echo $ea; ?>
                                        </div><?php
                                    }
                                }
                                // debug($result['orderdetail']);
                            ?>
                        </td>
						<?php /* echo display_datetime(element('cor_datetime', $result), 'full') */ ?>
						<td>
                            <?php 
                                if(element('pay_method', $result) == 'f'){
                                    echo "열매";
                                }else if(element('pay_method', $result) == 'c'){
                                    echo "복지포인트";
                                }else{
                                    echo element('pay_method', $result);
                                }
                            ?>
                        </td>
						<td class="text-right">
                            <?php echo number_format(element('cor_total_money', $result)); ?>

                            <?php
                                if($result['cor_pay_type']=='f'){
                                    echo '원';
                                }else if($result['cor_pay_type']=='c'){
                                    echo '개';
                                }
                            ?>
                            
                        </td>
						<td class="text-right">
                            <?php echo number_format(element('cor_cash', $result)); ?>
                            
                            <?php
                                if($result['cor_pay_type']=='f'){
                                    echo '원';
                                }else if($result['cor_pay_type']=='c'){
                                    echo '개';
                                }
                            ?>

                        </td>
						<td class="text-right">
                            <?php echo number_format(element('cor_refund_price', $result)); ?>
                            
                            <?php
                                if($result['cor_pay_type']=='f'){
                                    echo '원';
                                }else if($result['cor_pay_type']=='c'){
                                    echo '개';
                                }
                            ?>
                        </td>
						<td><a href="<?php echo element('form_url', $view) .'/'. element('cor_id', $result); ?>">보기</a></td>
					</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="13" class="nopost">자료가 없습니다</td>
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
//<![CDATA[
$(document).on('click', '.btn-download-days-modify', function() {
	$('.cor-id-cit-id-' + $(this).attr('data-cor-id-cit-id')).toggle();
});
//]]>

//상태 변경
document.querySelector(".btn-status-change").addEventListener('click',function(){
	
	var checkboxs = document.querySelectorAll('[name="chk[]"]:checked');

	if(checkboxs.length == 0){
		alert("주문을 선택해 주세요.");
		return false;
	}


	var form = document.createElement('form');

	form.action = '/admin/cmall/cmallorder/statuschange'; // 폼의 액션 URL 설정
    form.method = 'POST'; // 폼의 전송 방식 설정
	form.enctype = 'multipart/form-data';
	

	var csrf_test_name = document.createElement('input');
    csrf_test_name.type = 'hidden';
    csrf_test_name.name = 'csrf_test_name';
    csrf_test_name.value = cb_csrf_hash;

	var change_status = document.createElement('input');
	change_status.type = 'hidden';
    change_status.name = 'change_status';
    change_status.value = document.querySelector(".change-status").value;

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


function export_to_excel(){
	search_form = document.getElementById('search_form');

	var form = document.createElement('form');
	form.action = '/admin/cmall/cmallorder/exportexcel'; // 폼의 액션 URL 설정
    form.method = 'GET'; // 폼의 전송 방식 설정
	form.enctype = 'multipart/form-data';

	var search_datetime_type = document.createElement('input');
    search_datetime_type.type = 'hidden';
    search_datetime_type.name = 'search_datetime_type';
    search_datetime_type.value = search_form.search_datetime_type.value;
	form.appendChild(search_datetime_type);

	var search_datetime_start = document.createElement('input');
    search_datetime_start.type = 'hidden';
    search_datetime_start.name = 'search_datetime_start';
    search_datetime_start.value = search_form.search_datetime_start.value;
	form.appendChild(search_datetime_start);

	var search_datetime_end = document.createElement('input');
    search_datetime_end.type = 'hidden';
    search_datetime_end.name = 'search_datetime_end';
    search_datetime_end.value = search_form.search_datetime_end.value;
	form.appendChild(search_datetime_end);

	document.querySelectorAll("[name='status[]']:checked").forEach(element=>{
		var search_status = document.createElement('input');
		search_status.type = 'hidden';
		search_status.name = 'status[]';
		search_status.value = element.value;
		form.appendChild(search_status);
	});

	var search_order_key = document.createElement('input');
    search_order_key.type = 'hidden';
    search_order_key.name = 'search_order_key';
    search_order_key.value = search_form.search_order_key.value;
	form.appendChild(search_order_key);

	var search_order_value = document.createElement('input');
    search_order_value.type = 'hidden';
    search_order_value.name = 'search_order_value';
    search_order_value.value = search_form.search_order_value.value;
	form.appendChild(search_order_value);

	var cor_id = document.createElement('input');
    cor_id.type = 'hidden';
    cor_id.name = 'cor_id';
    cor_id.value = search_form.cor_id.value;
	form.appendChild(cor_id);

	document.querySelectorAll("[name='company_idx[]']:checked").forEach(element=>{
		var company_idx = document.createElement('input');
		company_idx.type = 'hidden';
		company_idx.name = 'company_idx[]';
		company_idx.value = element.value;
		form.appendChild(company_idx);
	});

	document.querySelectorAll("[name='cmall_category[]']:checked").forEach(element=>{
		var cmall_categorys = document.createElement('input');
		cmall_categorys.type = 'hidden';
		cmall_categorys.name = 'cmall_category[]';
		cmall_categorys.value = element.value;
		form.appendChild(cmall_categorys);
	});
	

	document.body.appendChild(form);

	form.submit();
}

document.querySelectorAll('.export_to_excel').forEach(element=>{
	element.addEventListener("click",function(){
		export_to_excel();
	});
});
</script>
