<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
			<?php
			ob_start();
			?>
				<div class="btn-group pull-right" role="group" aria-label="...">
					<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
					<button type="button" class="btn btn-outline btn-default btn-sm btn-list-trash btn-list-selected disabled" data-list-trash-url = "<?php echo element('list_trash_url', $view); ?>" >휴지통</button>
					<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
				</div>
			<?php
			$buttons = ob_get_contents();
			ob_end_flush();
			?>
		</div>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><a href="<?php echo element('post_id', element('sort', $view)); ?>">번호</a></th>
							<th>문의유형</th>
							<th>제목</th>
							<th>이미지</th>
							<th>작성자</th>
							<th>기업명</th>
							<th>처리상태</th>
							<th>작성일</th>
							<th><input type="checkbox" name="chkall" id="chkall" /></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td title="번호"><?php echo number_format(element('num', $result)); ?></td>
							<td title="문의유형"><?php echo element('output',element('extra_content', $result)); ?></td>
							<td title="제목">
								<a href="/admin/board/cqna/post/<?php echo element('post_id', $result);?>"><?php echo html_escape(element('post_title', $result)); ?></a>
							</td>
							<td title="이미지">
								<?php if (element('thumb_url', $result)) {?>
									<a href="<?php echo goto_url(element('posturl', $result)); ?>" target="_blank">
										<img src="<?php echo element('thumb_url', $result); ?>" alt="<?php echo html_escape(element('post_title', $result)); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>" class="thumbnail mg0" style="width:80px;" />
									</a>
								<?php } ?>
							</td>
							<td title="작성자"><?php echo element('post_display_name', $result); ?> <?php if (element('post_userid', $result)) { ?> ( <a href="?sfield=mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('post_userid', $result)); ?></a> ) <?php } ?></td>
							<td title="기업명"><?php echo element('company_name', $result); ?></td>
							<td title="처리상태"><?php if(element('post_reply_chk', $result) == 'y'){echo '답변완료';}else{echo '답변대기';} ?></td>
							<td title="작성일"><?php echo display_datetime(element('post_datetime', $result), 'full'); ?></td>
							<td title="관리"><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
						</tr>
						<?php foreach(element('list', element('comment_list', $result)) as $k => $v){ ?>
							<tr>
								<td><?php echo number_format(element('num', $result)); ?>(답변)</td>
								<td title="문의유형"><?php echo element('output',element('extra_content', $v)); ?></td>
								<td title="제목"><a href="/admin/board/cqna/modify/<?php echo element('post_id', $v);?>"><?php echo html_escape(element('post_title', $v)); ?></a></td>
								<td title="이미지">
									<?php if (element('thumb_url', $v)) {?>
										<a href="<?php echo goto_url(element('posturl', $v)); ?>" target="_blank">
											<img src="<?php echo element('thumb_url', $v); ?>" alt="<?php echo html_escape(element('post_title', $v)); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>" class="thumbnail mg0" style="width:80px;" />
										</a>
									<?php } ?>
								</td>
								<td title="작성자"><?php echo element('post_display_name', $v); ?> <?php if (element('post_userid', $v)) { ?> ( <a href="?sfield=mem_id&amp;skeyword=<?php echo element('mem_id', $v); ?>"><?php echo html_escape(element('post_userid', $result)); ?></a> ) <?php } ?></td>
								<td title="기업명"><?php echo element('company_name', $v); ?></td>
								<td title="처리상태"><?php if(element('post_reply_chk', $v) == 'y'){echo '답변완료';}else{echo '답변대기';} ?></td>
								<td title="작성일"><?php echo display_datetime(element('post_datetime', $v), 'full'); ?></td>
								<td title="관리"><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $v); ?>" /></td>
							</tr>
						<?php } ?>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="11" class="nopost">자료가 없습니다</td>
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
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		if($('select[name="sfield"]').val() == 'post_reply_chk'){
			if($('input[name="skeyword"]').val() == 'y'){
				$('input[name="skeyword"]').val('답변완료');
			} else {
				$('input[name="skeyword"]').val('답변대기');
			}
		}
		
	});
</script>