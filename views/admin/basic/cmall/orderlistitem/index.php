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
        <div>
			<form id="search_form" method="get" enctype="multipart/form-data">
                <input type="hidden" name="citt_id_use" value="<?php echo $this->input->get("citt_id_use")?>">
				<table>
					<tr>
						<th>처리일자</th>
						<td>
                            <input type="hidden" name="search_datetime_type" value="cor_end_datetime">
							<input type="date" name="search_datetime_start" value="<?php echo substr($this->input->get('search_datetime_start'),0,10);?>" class="form-control px140"> - 
							<input type="date" name="search_datetime_end" value="<?php echo substr($this->input->get('search_datetime_end'),0,10);?>" class="form-control px140">
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
					</td>
				</tr>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th>주문번호</th>
                        <th>기업명</th>
                        <th>부서명</th>
                        <th>직책</th>

						<th>직원명</th>
						<th>주문상품</th>
						<th>주문상태</th>

                        <th>사용열매</th>
                        
                        <th>보기</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$custom_config = config_item("custom");
				
				if (element('list', element('data', $view))) {
					foreach (element('list', element('data', $view)) as $result) {
				?>
					<tr>
						<td><a href="<?php echo site_url('cmall/orderresult/' . element('cor_id', $result)); ?>" target="_blank"><?php echo element('cor_id', $result); ?></a></td>
                        <td><?php echo element('company_name', $result); ?></td>
                        <td><?php echo element('mem_div', $result); ?></td>
                        <td><?php echo element('mem_position', $result); ?></td>
						<td><?php echo element('mem_username', $result); ?></td>
						<td><?php echo element('cit_name', $result); ?></td>
						<td><?php echo element('cod_status_name', $result); ?></td>
                        <td class="text-right"><?php echo number_format(element('cod_fruit', $result)); ?></td>
                        <td><a href="<?php echo '/admin/cmall/cmallorder/form/'. element('cor_id', $result); ?>">보기</a></td>
                        
					</tr>
					<?php
							
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

/**
 * 선택한것 상태 변경 클릭 이벤트
 */
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



function export_to_excel(){
	search_form = document.getElementById('search_form');

	var form = document.createElement('form');
	form.action = '/admin/cmall/orderlist/exportexcel'; // 폼의 액션 URL 설정
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
	

	document.body.appendChild(form);

	form.submit();
}

</script>
