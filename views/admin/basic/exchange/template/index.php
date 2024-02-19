<style type="text/css">
#search_form th{padding:10px;}
#search_form td{padding:10px;}
.flex{display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;}
.flex > div{width:100%;}
</style>

<div class="box">
	<div class="box-table">
		
			<div class="box-table-header">
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
						<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">템플릿추가</a>
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
						<th>템플릿등록일</th>
						<td>
							<input type="date" name="search_datetime_start" value="<?php echo substr($this->input->get('search_datetime_start'),0,10);?>" class="form-control px140"> - 
							<input type="date" name="search_datetime_end" value="<?php echo substr($this->input->get('search_datetime_end'),0,10);?>" class="form-control px140">
						</td>
					</tr>
					<tr>
						<th>노출여부</th>
						<td>
                            <div class="checkbox-inline">
                                <input type="checkbox" name="useyn" value="y" id="useyn" > <label for="useyn">노출중인 템플릿만 보기</label>
                            </div>
						</td>
					</tr>
                    <tr>
						<th>템플릿명</th>
						<td>
							<input type="text" name="search_item_value" value="<?php echo $this->input->get("search_item_value");?>" class="form-control px300">
						</td>
					</tr>
				</table>
				<div class="mt10">
					<button class="btn btn-outline btn-default btn-sm" type="submit">검색</button>
				</div>
			</form>
			</div>
			<hr></hr>

		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
            <div class="row flex">
                <div>전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
                <div class="text-right">
                    <select name="" class="form-control px140">
                        <option value="">미노출</option>
                        <option value="">노출</option>
                    </select>
                    <button type="button" class="btn btn-outline btn-default btn-sm btn-list-update btn-list-selected" data-list-update-url = "<?php echo element('list_update_url', $view); ?>" >변경</button>
                </div>
            </div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
                            <th><input type="checkbox" name="chkall" id="chkall" /></th>
                            <th>NO</th>
                            <th>이미지</th>
							<th><a href="">상품명</a></th>
                            <th>상품설명</th>
                            <th>예치금 차감 금액</th>
                            <th>노출여부</th>
                            <th>상품종류</th>
							<th>사용현황</th>
							<th>수정</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
							
					?>
						<tr>
                        <td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
							<td><a href="<?php echo goto_url(cmall_item_url(html_escape(element('cit_key', $result)))); ?>" target="_blank"><?php echo html_escape(element('cit_key', $result)); ?></a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><a href="<?php echo admin_url($this->pagedir); ?>/status/111" target="_blank"></a></td>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
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
			</div>
			<div class="box-info">
				<?php echo element('paging', $view); ?>
				<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
				<?php echo $buttons; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
