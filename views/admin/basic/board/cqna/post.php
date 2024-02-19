<div class="board">
	<table class="table">
		<colgroup>
			<col width="10%">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th>회원정보</th>
				<td>
					<ul>
						<li>소속 : <?php echo element('company_name', element('mem_company', element('post', $view))); ?></li>
						<li>부서 : <?php echo element('mem_div', element('mem_company', element('post', $view))); ?></li>
						<li>직책 : <?php echo element('mem_position', element('mem_company', element('post', $view))); ?></li>
						<li>이름 : <?php echo element('post_username', element('post', $view)); ?></li>
					</ul>
				</td>
			</tr>
			<tr>
				<th>문의유형</th>
				<td><?php echo element('output', element('extra_content', element('post', $view))); ?></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><?php echo html_escape(element('post_title', element('post', $view))); ?></td>
			</tr>
			<tr>
				<th>내용</th>
				<td>
					<div class="contents-view">
						<div class="contents-view-img">
						<?php
						if (element('file_image', $view)) {
							foreach (element('file_image', $view) as $key => $value) {
						?>
							<img src="<?php echo element('thumb_image_url', $value); ?>" alt="<?php echo html_escape(element('pfi_originname', $value)); ?>" title="<?php echo html_escape(element('pfi_originname', $value)); ?>" class="view_full_image" data-origin-image-url="<?php echo element('origin_image_url', $value); ?>" style="max-width:100%;" />
						<?php
							}
						}
						?>
						</div>

						<!-- 본문 내용 시작 -->
						<div id="post-content"><?php echo element('post_content', element('post', $view)); ?></div>
						<!-- 본문 내용 끝 -->
					</div>
				</td>
			</tr>
			<?php if (element('link_count', $view) > 0) { ?>
			<tr>
				<th>링크</th>
				<?php foreach (element('link', $view) as $key => $value) { ?>
				<td>
					<i class="fa fa-link"></i> <a href="<?php echo element('link_link', $value); ?>" target="_blank"><?php echo html_escape(element('pln_url', $value)); ?></a><span class="badge"><?php echo number_format(element('pln_hit', $value)); ?></span>
					<?php if (element('show_url_qrcode', element('board', $view))) { ?>
						<span class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('pln_url', $value)); ?>"><i class="fa fa-qrcode"></i></span>
					<?php } ?>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
			<?php if (element('file_download_count', $view) > 0) { ?>
			<tr>
				<th>파일</th>
				<?php foreach (element('file_download', $view) as $key => $value){ ?>
				<td><i class="fa fa-download"></i> <a href="javascript:file_download('<?php echo element('download_link', $value); ?>')"><?php echo html_escape(element('pfi_originname', $value)); ?>(<?php echo byte_format(element('pfi_filesize', $value)); ?>)</a> <span class="time"><i class="fa fa-clock-o"></i> <?php echo display_datetime(element('pfi_datetime', $value), 'full'); ?></span><span class="badge"><?php echo number_format(element('pfi_download', $value)); ?></span></td>
				<?php } ?>
			</tr>
			<?php } ?>
			<?php if(count(element('list', element('comment_list', $view))) > 0){ ?>
			<tr>
				<th>답변</th>
				<td>
					<ul>
						<?php foreach(element('list', element('comment_list', $view)) as $k => $v){ ?>
						<li>
							<span><?php echo html_escape(element('post_title', $v)); ?></span>
							<div class="contents-view">
								<div class="contents-view-img">
								<?php
								if (element('file_image', $v)) {
									foreach (element('file_image', $v) as $key => $value) {
								?>
									<img src="<?php echo element('thumb_image_url', $value); ?>" alt="<?php echo html_escape(element('pfi_originname', $value)); ?>" title="<?php echo html_escape(element('pfi_originname', $value)); ?>" class="view_full_image" data-origin-image-url="<?php echo element('origin_image_url', $value); ?>" style="max-width:100%;" />
								<?php
									}
								}
								?>
								</div>

								<!-- 본문 내용 시작 -->
								<div id="post-content"><?php echo element('post_content', $v); ?></div>
								<!-- 본문 내용 끝 -->
							</div>
							<?php if (element('link_count', $v) > 0) { ?>
							<div class="link-view">
							<?php foreach (element('link', $v) as $kk => $vv) { ?>
							<p>
								<i class="fa fa-link"></i> <a href="<?php echo element('link_link', $vv); ?>" target="_blank"><?php echo html_escape(element('pln_url', $vv)); ?></a><span class="badge"><?php echo number_format(element('pln_hit', $vv)); ?></span>
								<?php if (element('show_url_qrcode', element('board', $v))) { ?>
									<span class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('pln_url', $vv)); ?>"><i class="fa fa-qrcode"></i></span>
								<?php } ?>
							</p>
							<?php } ?>
							</div>
							<?php } ?>
							<?php if (element('file_download_count', $v) > 0) { ?>
							<div class="file-view">
							<?php foreach (element('file_download', $v) as $kk => $vv){ ?>
								<p><i class="fa fa-download"></i> <a href="javascript:file_download('<?php echo element('download_link', $vv); ?>')"><?php echo html_escape(element('pfi_originname', $vv)); ?>(<?php echo byte_format(element('pfi_filesize', $vv)); ?>)</a> <span class="time"><i class="fa fa-clock-o"></i> <?php echo display_datetime(element('pfi_datetime', $vv), 'full'); ?></span><span class="badge"><?php echo number_format(element('pfi_download', $vv)); ?></span></p>
							<?php } ?>
							</div>
							<?php } ?>
						</li>
						<?php } ?>
					</ul>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<th>답변작성</th>
				<td>
					<div id="viewcomment"></div>
					<?php $this->load->view(element('view_skin_path', $layout) . '/write');?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
