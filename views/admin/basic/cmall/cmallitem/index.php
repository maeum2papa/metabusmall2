<style type="text/css">
#search_form th{padding:10px;}
#search_form td{padding:10px;}
</style>

<div class="box">
	<div class="box-table">
		
			<div class="box-table-header">
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-update btn-list-selected disabled" data-list-update-url = "<?php echo element('list_update_url', $view); ?>" >선택수정</button>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
						<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">상품추가</a>
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
						<th>등록일자</th>
						<td>
							<input type="date" name="search_datetime_start" value="<?php echo substr($this->input->get('search_datetime_start'),0,10);?>" class="form-control px140"> - 
							<input type="date" name="search_datetime_end" value="<?php echo substr($this->input->get('search_datetime_end'),0,10);?>" class="form-control px140">
						</td>
					</tr>
					<tr>
						<th>추천상품</th>
						<td>
							<div class="radio-inline">
								<input type="radio" name="cit_type1" value="" id="cit_type1_null" <?php echo ($this->input->get("cit_type1") == "" || !$this->input->get("cit_type1"))?"checked":"";?>> <label for="cit_type1_null">전체</label>
							</div>
							<div class="radio-inline">
								<input type="radio" name="cit_type1" value="1" id="cit_type1_1" <?php echo ($this->input->get("cit_type1") == 1)?"checked":"";?>> <label for="cit_type1_1">사용</label>
							</div>
							<div class="radio-inline">
								<input type="radio" name="cit_type1" value="2" id="cit_type1_2" <?php echo ($this->input->get("cit_type1") == 2)?"checked":"";?>> <label for="cit_type1_2">미사용</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>판매여부</th>
						<td>
						<div class="radio-inline">
								<input type="radio" name="cit_status" value="" id="cit_status_null" <?php echo ($this->input->get("cit_status") == "" || !$this->input->get("cit_type1"))?"checked":"";?>> <label for="cit_status_null">전체</label>
							</div>
							<div class="radio-inline">
								<input type="radio" name="cit_status" value="1" id="cit_status_1" <?php echo ($this->input->get("cit_status") == 1)?"checked":"";?>> <label for="cit_status_1">판매중</label>
							</div>
							<div class="radio-inline">
								<input type="radio" name="cit_status" value="2" id="cit_status_2" <?php echo ($this->input->get("cit_status") == 2)?"checked":"";?>> <label for="cit_status_2">미판매중</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>상품명</th>
						<td>
							<!-- <select class="form-control px140" name="search_item_key">
								<option value="cit_name" >상품명</option>
								<option value="cit_key" <?php echo ($this->input->get("search_item_key")=="cit_key")?"selected":"";?>>상품코드</option>
							</select> -->
							<input type="hidden" name="search_item_key" value="cit_name"/>
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
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><a href="<?php echo element('cit_key', element('sort', $view)); ?>">상품코드</a></th>
							<?php if($this->session->userdata['mem_admin_flag']==0){?>
								<th>카테고리/유형</th>
							<?php }else{ ?>
								<th>상품분류</th>
							<?php } ?>
							<th>이미지</th>
							<th><a href="<?php echo element('cit_name', element('sort', $view)); ?>">상품명</a></th>
							<th>
								<a href="<?php echo element('cit_price', element('sort', $view)); ?>">
								<?php if($this->session->userdata['mem_admin_flag']==0){?>
									교환열매
								<?php }else{ ?>
									교환포인트
								<?php } ?>
								</a>
							</th>
							<th><a href="<?php echo element('cit_download_days', element('sort', $view)); ?>">교환기간</a></th>
							<th><a href="<?php echo element('cit_order', element('sort', $view)); ?>">정렬순서</a></th>
							<th><a href="<?php echo element('cit_status', element('sort', $view)); ?>">노출여부</a></th>
							<th><a href="<?php echo element('cit_sell_count', element('sort', $view)); ?>">교환횟수</a></th>
							<?php if($this->session->userdata['mem_admin_flag']==0){?>
								<th><a href="<?php echo element('cit_hit', element('sort', $view)); ?>">조회수</a></th>
							<?php }else{ ?>
							<?php } ?>
							<th>수정</th>
							<th><input type="checkbox" name="chkall" id="chkall" /></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
                            
                            //상품과 연동된 아이템 카테고리
                            $cit_item_arr = cmall_item_asset_category_link(explode(",",$result['cit_item_arr']));
                            

							//판매 기간
							if($result[cit_view_type] == 'n'){
								if($result[cit_download_days]>0){
									$after_cit_download_days = substr($result[cit_datetime], 0, 10);
									$cit_download_days = date("Ymd", strtotime("+".$result[cit_download_days]." day", strtotime($after_cit_download_days)))."까지";
								}else{
									$cit_download_days = "무제한";	
								}
								
							}else{
								$cit_download_days = $result[cit_startDt]."~<br>".$result[cit_endDt];
							}
					?>
						<tr>
							<td><a href="<?php echo goto_url(cmall_item_url(html_escape(element('cit_key', $result)))); ?>" target="_blank"><?php echo html_escape(element('cit_key', $result)); ?></a></td>

							<?php if($this->session->userdata['mem_admin_flag']==0){?>
								<td style="width:130px;">
                                    
                                    <?php if(count($cit_item_arr)>0){
                                        foreach($cit_item_arr as $v){
                                            ?>
                                            <label class="label label-info"><?php echo $v['cate_kr']?></label>
                                        <?php
                                        }
                                    }?>
									<?php if (element('cit_type1', $result)) { ?><label class="label label-danger">추천</label> <?php } ?>
									<?php if (element('cit_type2', $result)) { ?><label class="label label-warning">인기</label> <?php } ?>
									<?php if (element('cit_type3', $result)) { ?><label class="label label-default">신상품</label> <?php } ?>
									<?php if (element('cit_type4', $result)) { ?><label class="label label-primary">할인</label> <?php } ?>
								</td>
							<?php }else{ ?>
								<td style="width:130px;">
									<?php echo (element('citt_id', $result))?"템플릿":"자체";?>
								</td>
							<?php } ?>
							
							<td>
								<?php if (element('cit_file_1', $result)) {?>
									<a href="<?php echo goto_url(cmall_item_url(html_escape(element('cit_key', $result)))); ?>" target="_blank">
										<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 80); ?>" alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" class="thumbnail mg0" style="width:80px;" />
									</a>
								<?php } ?>
							</td>
							<td><input type="text" name="cit_name[<?php echo element(element('primary_key', $view), $result); ?>]" class="form-control" value="<?php echo html_escape(element('cit_name', $result)); ?>" /></td>
							<td style="padding: 0; width:130px;"><input type="number" name="cit_price[<?php echo element(element('primary_key', $view), $result); ?>]" class="form-control" value="<?php echo html_escape(element('cit_price', $result)); ?>" /></td>
							<td><?=$cit_download_days?></td>
							<td><input type="number" name="cit_order[<?php echo element(element('primary_key', $view), $result); ?>]" class="form-control" value="<?php echo html_escape(element('cit_order', $result)); ?>" style="width: 50px;" /></td>
							<td><input type="checkbox" name="cit_status[<?php echo element(element('primary_key', $view), $result); ?>]" value="1" <?php echo set_checkbox('cit_status', '1', (element('cit_status', $result) ? true : false)); ?> /></td>
							<td class="text-right"><?php echo number_format(element('cit_sell_count', $result)); ?></td>
							<?php if($this->session->userdata['mem_admin_flag']==0){?>
								<td class="text-right"><?php echo number_format(element('cit_hit', $result)); ?></td>
							<?php }else{ ?>
							<?php } ?>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
							<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
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
