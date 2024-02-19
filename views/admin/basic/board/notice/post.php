<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php	$this->managelayout->add_js(base_url('plugin/zeroclipboard/ZeroClipboard.js')); ?>

<?php
if (element('syntax_highlighter', element('board', $view)) OR element('comment_syntax_highlighter', element('board', $view))) {
	$this->managelayout->add_css(base_url('assets/js/syntaxhighlighter/styles/shCore.css'));
	$this->managelayout->add_css(base_url('assets/js/syntaxhighlighter/styles/shThemeMidnight.css'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shCore.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushJScript.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushPhp.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushCss.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushXml.js'));
?>
	<script type="text/javascript">
	SyntaxHighlighter.config.clipboardSwf = '<?php echo base_url('assets/js/syntaxhighlighter/scripts/clipboard.swf'); ?>';
	var is_SyntaxHighlighter = true;
	SyntaxHighlighter.all();
	</script>
<?php } ?>

<?php echo element('headercontent', element('board', $view)); ?>

<div class="board">
	<?php echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>'); ?>
	<table class="table table-hover table-striped table-bordered">
		<colgroup>
			<col width="10%">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th>제목</th>
				<td>
					<?php if (element('category', element('post', $view))) { ?>[<?php echo html_escape(element('bca_value', element('category', element('post', $view)))); ?>] <?php } ?>
					<?php echo html_escape(element('post_title', element('post', $view))); ?>
				</td>
			</tr>
			<tr>
				<th>상세정보</th>
				<td>
					<ul class="information mb20">
						<li>작성자 : <?php echo element('display_name', element('post', $view)); ?></li>
						<li>댓글 : <i class="fa fa-comments"></i> <?php echo number_format(element('post_comment_count', element('post', $view))); ?></li>
						<li>조회 : <i class="fa fa-eye"></i> <?php echo number_format(element('post_hit', element('post', $view))); ?></li>
						<?php if (element('use_post_like', element('board', $view))) { ?>
							<li>좋아요 : <i class="fa fa-thumbs-up"></i> <span class="post-like"><?php echo number_format(element('post_like', element('post', $view))); ?></span></li>
						<?php } ?>
						<?php	if (element('use_post_dislike', element('board', $view))) { ?>
							<li>싫어요 : <i class="fa fa-thumbs-down"></i> <span class="post-dislike"><?php echo number_format(element('post_dislike', element('post', $view))); ?></span></li>
						<?php	} ?>
						<?php if (element('use_print', element('board', $view))) { ?>
							<li><a href="javascript:;" id="btn-print" onClick="post_print('<?php echo element('post_id', element('post', $view)); ?>', 'post-print');" title="이 글을 프린트하기"><i class="fa fa-print"></i> <span class="post-print">Print</span></a></li>
						<?php } ?>
						<?php if (element('show_url_qrcode', element('board', $view))) { ?>
							<li class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('short_url', $view)); ?>"><i class="fa fa-qrcode"></i></li>
						<?php } ?>
						<li class="time">작성일 : <i class="fa fa-clock-o"></i> <?php echo element('display_datetime', element('post', $view)); ?></li>
					</ul>
				</td>
			</tr>
			<tr>
				<th>링크</th>
				<td>
					<?php if (element('link_count', $view) > 0) { ?>
						<div class="table-box">
							<table class="table-body">
								<tbody>
								<?php
								if (element('link_count', $view) > 0) {
									foreach (element('link', $view) as $key => $value) {
								?>
									<tr>
										<td><i class="fa fa-link"></i> <a href="<?php echo element('link_link', $value); ?>" target="_blank"><?php echo html_escape(element('pln_url', $value)); ?></a><span class="badge"><?php echo number_format(element('pln_hit', $value)); ?></span>
											<?php if (element('show_url_qrcode', element('board', $view))) { ?>
												<span class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('pln_url', $value)); ?>"><i class="fa fa-qrcode"></i></span>
											<?php } ?>
										</td>
									</tr>
								<?php
									}
								}
								?>
								</tbody>
							</table>
						</div>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th>파일</th>
				<td>
					<?php if (element('file_download_count', $view) > 0) { ?>
						<div class="table-box">
							<table class="table-body">
								<tbody>
								<?php
								if (element('file_download_count', $view) > 0) {
									foreach (element('file_download', $view) as $key => $value) {
								?>
									<tr>
										<td><i class="fa fa-download"></i> <a href="javascript:file_download('<?php echo element('download_link', $value); ?>')"><?php echo html_escape(element('pfi_originname', $value)); ?>(<?php echo element('pfi_filesize', $value); ?>)</a> <span class="time"><i class="fa fa-clock-o"></i> <?php echo display_datetime(element('pfi_datetime', $value), 'full'); ?></span><span class="badge"><?php echo number_format(element('pfi_download', $value)); ?></span></td>
									</tr>
								<?php
									}
								}
								?>
								</tbody>
							</table>
						</div>
					<?php } ?>
				</td>
			</tr>
			<?php if (element('extra_content', $view)) { ?>
				<?php foreach (element('extra_content', $view) as $key => $value) { ?>
				<tr>
					<th><?php echo html_escape(element('display_name', $value)); ?></th>
					<td><?php echo nl2br(html_escape(element('output', $value))); ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
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
						<div id="post-content"><?php echo element('content', element('post', $view)); ?></div>
						<!-- 본문 내용 끝 -->
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	
	
	

	<script type="text/javascript">
	//<![CDATA[
	function file_download(link) {
		<?php if (element('point_filedownload', element('board', $view)) < 0) { ?>if ( ! confirm("파일을 다운로드 하시면 포인트가 차감(<?php echo number_format(element('point_filedownload', element('board', $view))); ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?")) { return; }<?php }?>
		document.location.href = link;
	}
	//]]>
	</script>

	

	<?php if ( ! element('post_del', element('post', $view)) && (element('use_post_like', element('board', $view)) OR element('use_post_dislike', element('board', $view)))) { ?>
		<div class="recommand">
			<?php if (element('use_post_like', element('board', $view))) { ?>
				<a class="good" href="javascript:;" id="btn-post-like" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like');" title="추천하기"><span class="post-like"><?php echo number_format(element('post_like', element('post', $view))); ?></span><br /><i class="fa fa-thumbs-o-up fa-lg"></i></a>
			<?php } ?>
			<?php if (element('use_post_dislike', element('board', $view))) { ?>
				<a class="bad" href="javascript:;" id="btn-post-dislike" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '2', 'post-dislike');" title="비추하기"><span class="post-dislike"><?php echo number_format(element('post_dislike', element('post', $view))); ?></span><br /><i class="fa fa-thumbs-o-down fa-lg"></i></a>
			<?php } ?>
		</div>
	<?php } ?>

	<?php
	if (element('poll', $view)) {
		$poll = element('poll', $view);
		$poll_item = element('poll_item', $view);
	?>
		<div class="poll mb30 mt20">
			<div class="headline">
				<h5>[설문조사] <?php echo html_escape(element('ppo_title', $poll)); ?></h5>
			</div>
			<?php
			if (element('attended', $poll) OR element('ended_poll', $poll)) {
				if ($poll_item) {
					$i = 1;
					foreach ($poll_item as $pkey => $pval) {
			?>
				<div class="poll-result"><?php echo $i;?>. <?php echo html_escape(element('ppi_item', $pval)); ?> <div class="pull-right"><?php echo number_format(element('ppi_count', $pval)); ?>표, <?php echo element('s_rate', $pval); ?>%</div></div>
				<div class="progress" style="height:5px;">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo element('s_rate', $pval); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo element('bar', $pval); ?>%;">
						<span class="sr-only"><?php echo element('s_rate', $pval); ?>% Complete</span>
					</div>
				</div>
			<?php
					$i++;
					}
				}
			} else {
			?>
				<div id="poll_write_form">
					<?php
					$attributes = array('name' => 'fpostpoll', 'id' => 'fpostpoll');
					echo form_open('', $attributes);
						if ($poll_item) {
							foreach ($poll_item as $pkey => $pval) {
					?>
							<div class="checkbox">
								<label for="ppi_item_<?php echo html_escape(element('ppi_id', $pval)); ?>">
									<input type="checkbox" name="ppi_item[]" class="poll_item_chk" id="ppi_item_<?php echo html_escape(element('ppi_id', $pval)); ?>" value="<?php echo html_escape(element('ppi_id', $pval)); ?>" />
									<?php echo html_escape(element('ppi_item', $pval)); ?>
								</label>
							</div>
						<?php
							}
						}
						?>
						<div class="form-group mt10">
							<button type="button" class="btn btn-default btn-xs" onClick="post_poll('<?php echo element('post_id', element('post', $view)); ?>', '<?php echo element('ppo_id', element('poll', $view)); ?>');">투표하기</button>
							<button type="button" class="btn btn-default btn-xs" onClick="post_poll_result('<?php echo element('post_id', element('post', $view)); ?>', '<?php echo element('ppo_id', element('poll', $view)); ?>');">결과보기</button>
							<span class="help-block">답변 <?php echo element('ppo_choose_count', $poll); ?> 개 선택 가능, 현재 <?php echo element('ppo_count', $poll); ?>명이 참여함, 설문기간 : <?php echo html_escape(element('poll_period', $poll)); ?>
								<?php if (element('ppo_point', $poll)) { echo '참여시' . number_format(element('ppo_point', $poll)) . '포인트 지급'; } ?>
							</span>
						</div>
					<?php echo form_close(); ?>
				</div>
			<?php } ?>
			<div id="poll_result_ajax"></div>

			<script type="text/javascript">
			//<![CDATA[
			var chklimit = <?php echo element('ppo_choose_count', $poll); ?>;
			$('input.poll_item_chk').on('change', function(evt) {
			if ($('input.poll_item_chk:checked').length > chklimit) {
				this.checked = false;
				alert('답변은 ' + chklimit + '개까지만 선택이 가능합니다.');
			}
			});
			function post_poll(post_id, ppo_id) {
				var href;
				href = cb_url + '/poll/post_poll/' + post_id + '/' + ppo_id;
				var $that = $(this);
				$.ajax({
					url : href,
					type : 'post',
					data : $('#fpostpoll').serialize() + '&csrf_test_name=' + cb_csrf_hash,
					dataType : 'json',
					success : function(data) {
						if (data.error) {
							alert(data.error);
							return false;
						} else if (data.success) {
							post_poll_result(post_id, ppo_id);
							$('#poll_write_form').hide();

						}

					}
				});
			}

			function post_poll_result(post_id, ppo_id) {
				var href;
				var result = '';
				href = cb_url + '/poll/post_poll_result/' + post_id + "/" + ppo_id;
				var $that = $(this);
				$.ajax({
					url : href,
					type : 'post',
					data : {csrf_test_name : cb_csrf_hash},
					dataType : 'json',
					success : function(data) {
						if (data.error) {
							alert(data.error);
							return false;
						} else if (data.success) {
							var i = 1;
							for (var key in data.poll_item) {
								obj = data.poll_item[key];
								result += '<div class="poll-result">' + i + '. ' + obj.ppi_item + '<div class="pull-right">' + obj.ppi_count + '표, ' + obj.s_rate + '%</div></div><div class="progress" style="height:5px;"><div class="progress-bar" role="progressbar" aria-valuenow="' + obj.s_rate + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + obj.bar + '%;"></div></div>';
								i++;
							}
							$('#poll_result_ajax').html(result);
						}

					}
				});
			}
			//]]>
			</script>
		</div>
	<?php } ?>

	<div class="clearfix"></div>

	<?php if (element('tag', element('post', $view))) { ?>
		<div class="tags mt20">
			<i class="fa fa-tags"></i>
			<?php foreach (element('tag', element('post', $view)) as $key => $value) { ?>
				<a href="<?php echo site_url('tags/?tag=' . html_escape(element('pta_tag', $value))); ?>" title="<?php echo html_escape(element('pta_tag', $value)); ?> 태그 목록"><?php echo html_escape(element('pta_tag', $value)); ?></a>,
			<?php	} ?>
		</div>
	<?php } ?>

	<div class="border_button mt20 mb20">
		<div class="btn-group pull-left" role="group" aria-label="...">
			<a href="/admin/board/notice/modify/<?php echo element('post_id', element('post', $view));?>" class="btn btn-default btn-sm">수정</a>
			<a href="/admin/board/notice" class="btn btn-default btn-sm">목록</a>
		</div>
	</div>
</div>

<?php echo element('footercontent', element('board', $view)); ?>

<?php if (element('target_blank', element('board', $view))) { ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	$("#post-content a[href^='http']").attr('target', '_blank');
});
//]]>
</script>
<?php } ?>

<script type="text/javascript">
//<![CDATA[
var client = new ZeroClipboard($('.copy_post_url'));
client.on('ready', function(readyEvent) {
	client.on('aftercopy', function(event) {
		alert('게시글 주소가 복사되었습니다. \'Ctrl+V\'를 눌러 붙여넣기 해주세요.');
	});
});
//]]>
</script>
<?php
if (element('highlight_keyword', $view)) {
	$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js'));
?>
	<script type="text/javascript">
	//<![CDATA[
	$('#post-content').highlight([<?php echo element('highlight_keyword', $view);?>]);
	//]]>
	</script>
<?php } ?>
