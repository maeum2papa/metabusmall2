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

<!-- asmo sh 231130 post 페이지 감싸는 div#asmo_post_wrapper, #asmo_board_wrap 생성 -->
<div id="asmo_post_wrapper">
	<div id="asmo_board_wrap">
		<div class="asmo_board_preview_box">
			<div class="board">
				<?php echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>'); ?>
				<!-- asmo sh 231130 어느 페이지 소속인지 알려주는 h1 태그 생성 -->
				<h1>
					<?php
						if(element('brd_id', element('post', $view)) == '1') echo '컬래버랜드 공지사항';
					?>
					<?php
						if(element('brd_id', element('post', $view)) == '2') {
					?> <?=busiNm($this->member->item('company_idx'))?> 공지사항
					<?php
						}
					?>
					<?php
						if(element('brd_id', element('post', $view)) == '3') echo '컬래버랜드 문의하기';
					?>
					<?php
						if(element('brd_id', element('post', $view)) == '4') {
					?> <?=busiNm($this->member->item('company_idx'))?> 문의하기
					<?php
						}
					?>
			
				</h1>
				<!-- //asmo sh 231130 어느 페이지 소속인지 알려주는 h1 태그 생성 -->
				<div id="asmo_post_box">
					<h3>
						<?php if (element('category', element('post', $view))) { ?>[<?php echo html_escape(element('bca_value', element('category', element('post', $view)))); ?>] <?php } ?>
						<!-- asmo sh 231218 문의 페이지일 경우, 문의 유형 가져오기 -->
						<?php
							if(element('brd_id', element('post', $view)) == '3' || element('brd_id', element('post', $view)) == '4') {
						?>
						<!-- <div class="asmo_ask_type"> -->
						<?php foreach (element('extra_content', $view) as $key => $value) { ?>
								<div class="list-group-item-text" style="min-height:20px;"><?php echo nl2br(html_escape(element('output', $value))); ?></div>
						<?php } ?>
						<!-- </div> -->
						<?php
							}
						?>
						<?php echo html_escape(element('post_title', element('post', $view))); ?>
					</h3>
					<ul class="info">
					<!-- asmo sh 231218 디자인 상 닉네임, 작성시간, 댓글 수, 노출종료일만 필요하여 다른 컨텐츠들 주석처리 -->
					<!-- <?php if(element('is_admin', $view)) { ?>
						<li><?php echo $view['post']['mem_company']['company_name']; ?></li>
					<?php } ?> -->
						<!-- <li><?php echo $view['post']['mem_company']['mem_div']; ?></li> -->
						<!-- <li><?php echo $view['post']['mem_company']['mem_position']; ?></li> -->
						<li><?=banner('writer')?><?php echo element('display_name', element('post', $view)); ?></li>
						<!-- asmo sh 231218 작성시간 li를 댓글 수 li 앞으로 배치 후 주석 처리 -->
						<li class="pull-right time"><i class="dn fa fa-clock-o"></i><?=banner('post_time')?> <?php echo element('display_datetime', element('post', $view)); ?></li>
						<!-- asmo sh 231218 공지사항에서만 노출 되게 -->
						<?php
							if(element('brd_id', element('post', $view)) == '1' || element('brd_id', element('post', $view)) == '2') {
						?>
						<li><i class="dn fa fa-comments"></i><?=banner('comments')?><?php echo number_format(element('post_comment_count', element('post', $view))); ?></li>
						<?php
							}
						?>
						<!-- <li><i class="fa fa-eye"></i> <?php echo number_format(element('post_hit', element('post', $view))); ?></li> -->
						<!-- <?php if (element('use_post_like', element('board', $view))) { ?>
							<li><i class="fa fa-thumbs-up"></i> <span class="post-like"><?php echo number_format(element('post_like', element('post', $view))); ?></span></li>
						<?php } ?>
						<?php if (element('use_post_dislike', element('board', $view))) { ?>
							<li><i class="fa fa-thumbs-down"></i> <span class="post-dislike"><?php echo number_format(element('post_dislike', element('post', $view))); ?></span></li>
						<?php } ?> -->
						<!-- <?php if (element('use_print', element('board', $view))) { ?>
							<li><a href="javascript:;" id="btn-print" onClick="post_print('<?php echo element('post_id', element('post', $view)); ?>', 'post-print');" title="이 글을 프린트하기"><i class="fa fa-print"></i> <span class="post-print">Print</span></a></li>
						<?php } ?>
						<li class="copy_post_url" data-clipboard-text="<?php echo element('short_url', $view); ?>"><span><i class="fa fa-link"></i> 글주소</span></li>
						<?php if (element('show_url_qrcode', element('board', $view))) { ?>
							<li class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('short_url', $view)); ?>"><i class="fa fa-qrcode"></i></li>
						<?php } ?> -->
						<!-- asmo sh 231218 작성시간 li를 댓글 수 li 앞으로 배치 후 주석 처리 -->
						<!-- <li class="pull-right time"><i class="dn fa fa-clock-o"></i><?=banner('post_time')?> <?php echo element('display_datetime', element('post', $view)); ?></li> -->
						<!-- <?php if (element('display_ip', element('post', $view))) { ?>
							<li class="pull-right time"><i class="fa fa-map-marker"></i> <?php echo element('display_ip', element('post', $view)); ?></li>
						<?php } ?>
						<?php if (element('is_mobile', element('post', $view))) { ?>
							<li class="pull-right time"><i class="fa fa-wifi"></i></li>
						<?php } ?> -->
						<!-- asmo sh 231218 공지사항에서만 노출되도록 처리 -->
						<?php
							if(element('brd_id', element('post', $view)) == '1' || element('brd_id', element('post', $view)) == '2') {
						?>
						<!-- asmo sh 231218 디자인 상 노출종료일 li를 주석 처리 후 ul.info 내로 배치 -->
						<!-- 만약 <?php echo nl2br(html_escape(element('output', $value))); ?>의 값이 없다면 <li class="list-group-item">를 노출 안되게 하는 코드를 작성해줘 -->
						<?php foreach (element('extra_content', $view) as $key => $value) { ?>
							<?php if (!empty(element('output', $value))) { ?>
								<li class="list-group-item">
									<div class="col-sm-2"><?= banner('enddate') ?> <strong><?php echo html_escape(element('display_name', $value)); ?></strong></div>
									<div class="list-group-item-text" style="min-height:20px;"><?php echo nl2br(html_escape(element('output', $value))); ?></div>
								</li>
							<?php } ?>
						<?php } ?>
						<?php
							}
						?>
					</ul>
					<!-- asmo sh 231220 디자인 상 div.contents-view dn 처리 후 ul.info 밑으로 재배치 -->
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
					<!-- asmo sh 231220 디자인 상 list-group-item-info, span.time, span.badge 삭제 및 list-group-item 감싸는 .list-group-item_wrap 생성 후 i 태그 이미지로 변경 -->
					<?php if (element('link_count', $view) > 0 OR element('file_download_count', $view) > 0) { ?>
						<ul class="list-group">
							<?php if (element('file_download_count', $view) > 0) { ?>
									<div class="list-group-item_wrap">
										<?php	foreach (element('file_download', $view) as $key => $value) { ?>
											<li class="list-group-item"><?=banner('download')?></i> <a href="javascript:file_download('<?php echo element('download_link', $value); ?>')"><?php echo html_escape(element('pfi_originname', $value)); ?>(<?php echo byte_format(element('pfi_filesize', $value)); ?>)</a> </li>
										<?php
											}
										?>
									</div>
							<?php
							}
							if (element('link_count', $view) > 0) { ?>
							<div class="list-group-item_wrap">
								<?php
								foreach (element('link', $view) as $key => $value) {
								?>
									<li class="list-group-item"><?=banner('link')?> <a href="<?php echo element('link_link', $value); ?>" target="_blank"><?php echo html_escape(element('pln_url', $value)); ?></a>
										<?php if (element('show_url_qrcode', element('board', $view))) { ?>
											<span class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('pln_url', $value)); ?>"><i class="fa fa-qrcode"></i></span>
										<?php } ?>
									</li>
								<?php
										}
								?>
							</div>
							<?php
			
								}
							?>
						</ul>
					<?php
					}
					?>
					<script type="text/javascript">
					//<![CDATA[
					function file_download(link) {
						<?php if (element('point_filedownload', element('board', $view)) < 0) { ?>if ( ! confirm("파일을 다운로드 하시면 포인트가 차감(<?php echo number_format(element('point_filedownload', element('board', $view))); ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?")) { return; }<?php }?>
						document.location.href = link;
					}
					//]]>
					</script>
					<!-- asmo sh 231218 디자인 상 노출종료일 li를 주석 처리 후 ul.info 내로 배치 -->
					<!-- <?php if (element('extra_content', $view)) { ?>
						<ul class="list-group">
							<?php foreach (element('extra_content', $view) as $key => $value) { ?>
								<li class="list-group-item">
									<div class="col-sm-2"> <strong><?php echo html_escape(element('display_name', $value)); ?></strong></div>
									<div class="list-group-item-text" style="min-height:20px;"><?php echo nl2br(html_escape(element('output', $value))); ?></div></li>
							<?php } ?>
						</ul>
					<?php } ?> -->
					<!-- asmo sh 231220 디자인 상 div.contents-view dn 처리 후 ul.info 밑으로 재배치 -->
					<div class="dn contents-view">
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
					<!-- asmo sh 231218 디자인 상 문의게시판 reply-contents dn 처리 후 #asmo_post_box 밖으로 재배치-->
					<?php if(count(element('list', element('reply_list', $view))) > 0){ ?>
					<div class="dn reply-contents">
						<ul>
							<?php foreach(element('list', element('reply_list', $view)) as $k => $v){ ?>
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
								<div>
								<?php echo element('post_display_name', $v); ?>
								</div>
								<div>
								<?php echo display_datetime(element('post_datetime', $v), 'full'); ?>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
					<?php } ?>
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
										<span class="help-block">
											답변 <?php echo element('ppo_choose_count', $poll); ?> 개 선택 가능, 현재 <?php echo element('ppo_count', $poll); ?>명이 참여함, 설문기간 : <?php echo html_escape(element('poll_period', $poll)); ?>
											<?php if (element('ppo_point', $poll)) { echo '참여시' . number_format(element('ppo_point', $poll)) . '포인트 지급'; } ?>
										</span>
									</div>
								<?php echo form_close(); ?>
							</div>
							<?php
							}
							?>
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
								href = cb_url + '/poll/post_poll_result/' + post_id + '/' + ppo_id;
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
					<?php
					}
					?>
					<!-- 231220 디자인 상 작성자 혹은 관리자일 때 나오는 버튼 div #asmo_post_box 밖으로 재배치 -->
					<!-- <div class="pull-right mb20">
						<?php if ( ! element('post_del', element('post', $view)) && element('use_scrap', element('board', $view))) { ?>
							<button type="button" class="btn btn-black btn-sm" id="btn-scrap" onClick="post_scrap('<?php echo element('post_id', element('post', $view)); ?>', 'post-scrap');">스크랩 <span class="post-scrap"><?php echo element('scrap_count', element('post', $view)) ? '+' . number_format(element('scrap_count', element('post', $view))) : ''; ?></span></button>
						<?php } ?>
						<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
							<button type="button" class="btn btn-black btn-sm" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
						<?php } ?>
						<?php if ( ! element('post_del', element('post', $view)) && element('is_admin', $view)) { ?>
							<button type="button" class="btn btn-default btn-sm admin-manage-post"><i class="fa fa-cog big-fa"></i> 관리</button>
							<div class="btn-admin-manage-layer admin-manage-post-layer">
							<?php if (element('is_admin', $view) === 'super') { ?>
								<div class="item" onClick="post_copy('copy', '<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-files-o"></i> 복사하기</div>
								<div class="item" onClick="post_copy('move', '<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-arrow-right"></i> 이동하기</div>
								<?php if (element('use_category', element('board', $view))) { ?>
									<div class="item" onClick="post_change_category('<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-tags"></i> 카테고리변경</div>
								<?php
									}
								}
								if (element('use_post_secret', element('board', $view))) {
									if (element('post_secret', element('post', $view))) {
								?>
									<div class="item" onClick="post_action('post_secret', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-unlock"></i> 비밀글해제</div>
								<?php } else { ?>
									<div class="item" onClick="post_action('post_secret', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-lock"></i> 비밀글로</div>
								<?php
									}
								}
								if (element('post_hide_comment', element('post', $view))) {
								?>
									<div class="item" onClick="post_action('post_hide_comment', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-comments"></i> 댓글감춤해제</div>
								<?php } else { ?>
									<div class="item" onClick="post_action('post_hide_comment', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-comments"></i> 댓글감춤</div>
								<?php } ?>
								<?php if (element('post_notice', element('post', $view))) { ?>
									<div class="item" onClick="post_action('post_notice', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-bullhorn"></i> 공지내림</div>
								<?php } else { ?>
									<div class="item" onClick="post_action('post_notice', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-bullhorn"></i> 공지올림</div>
								<?php } ?>
								<?php if (element('post_blame', element('post', $view)) >= element('blame_blind_count', element('board', $view))) { ?>
									<div class="item" onClick="post_action('post_blame_blind', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-exclamation-circle"></i> 블라인드해제</div>
								<?php } else { ?>
									<div class="item" onClick="post_action('post_blame_blind', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-exclamation-circle"></i> 블라인드처리</div>
								<?php } ?>
								<?php if (element('use_posthistory', element('board', $view))) { ?>
									<div class="item" onClick="post_history('<?php echo element('post_id', element('post', $view)); ?>');" ><i class="fa fa-history"></i> 글변경로그</div>
								<?php } ?>
								<?php if (element('use_download_log', element('board', $view))) { ?>
									<div class="item" onClick="download_log('<?php echo element('post_id', element('post', $view)); ?>');" ><i class="fa fa-download"></i> 다운로드로그</div>
								<?php } ?>
								<?php	if (element('use_link_click_log', element('board', $view))) { ?>
									<div class="item" onClick="link_click_log('<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-link"></i> 링크클릭로그</div>
								<?php } ?>
								<div class="item" onClick="post_action('post_trash', '<?php echo element('post_id', element('post', $view)); ?>', '', '이 글을 휴지통으로 이동하시겠습니까?');"><i class="fa fa-trash"></i> 휴지통으로</div>
							</div>
						<?php } ?>
					</div> -->
					<?php
					if (element('use_sns_button', $view)) {
						$this->managelayout->add_js(base_url('assets/js/sns.js'));
						if ($this->cbconfig->item('kakao_apikey')) {
							$this->managelayout->add_js('https://developers.kakao.com/sdk/js/kakao.min.js');
					?>
						<script type="text/javascript">Kakao.init('<?php echo $this->cbconfig->item('kakao_apikey'); ?>');</script>
					<?php } ?>
						<div class="sns_button">
							<a href="javascript:;" onClick="sendSns('facebook', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(html_escape(element('post_title', element('post', $view))));?>');" title="이 글을 페이스북으로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_facebook.png" width="22" height="22" alt="이 글을 페이스북으로 퍼가기" title="이 글을 페이스북으로 퍼가기" /></a>
							<a href="javascript:;" onClick="sendSns('twitter', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(html_escape(element('post_title', element('post', $view))));?>');" title="이 글을 트위터로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_twitter.png" width="22" height="22" alt="이 글을 트위터로 퍼가기" title="이 글을 트위터로 퍼가기" /></a>
							<?php if ($this->cbconfig->item('kakao_apikey')) { ?>
								<a href="javascript:;" onClick="kakaolink_send('<?php echo html_escape(html_escape(element('post_title', element('post', $view))));?>', '<?php echo element('short_url', $view); ?>');" title="이 글을 카카오톡으로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_kakaotalk.png" width="22" height="22" alt="이 글을 카카오톡으로 퍼가기" title="이 글을 카카오톡으로 퍼가기" /></a>
							<?php } ?>
							<a href="javascript:;" onClick="sendSns('kakaostory', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(html_escape(element('post_title', element('post', $view))));?>');" title="이 글을 카카오스토리로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_kakaostory.png" width="22" height="22" alt="이 글을 카카오스토리로 퍼가기" title="이 글을 카카오스토리로 퍼가기" /></a>
							<a href="javascript:;" onClick="sendSns('band', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(html_escape(element('post_title', element('post', $view))));?>');" title="이 글을 밴드로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_band.png" width="22" height="22" alt="이 글을 밴드로 퍼가기" title="이 글을 밴드로 퍼가기" /></a>
						</div>
					<?php } ?>
				</div>
				<!-- 231220 디자인 상 작성자 혹은 관리자일 때 나오는 버튼 div #asmo_post_box 밖으로 재배치 -->
				<div class="pull-right mb20">
					<?php if ( ! element('post_del', element('post', $view)) && element('use_scrap', element('board', $view))) { ?>
						<button type="button" class="btn btn-black btn-sm" id="btn-scrap" onClick="post_scrap('<?php echo element('post_id', element('post', $view)); ?>', 'post-scrap');">스크랩 <span class="post-scrap"><?php echo element('scrap_count', element('post', $view)) ? '+' . number_format(element('scrap_count', element('post', $view))) : ''; ?></span></button>
					<?php } ?>
					<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
						<button type="button" class="btn btn-black btn-sm" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
					<?php } ?>
					<?php if ( ! element('post_del', element('post', $view)) && element('is_admin', $view)) { ?>
						<button type="button" class="btn btn-default btn-sm admin-manage-post"><i class="fa fa-cog big-fa"></i> 관리</button>
						<div class="btn-admin-manage-layer admin-manage-post-layer">
						<?php if (element('is_admin', $view) === 'super') { ?>
							<div class="item" onClick="post_copy('copy', '<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-files-o"></i> 복사하기</div>
							<div class="item" onClick="post_copy('move', '<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-arrow-right"></i> 이동하기</div>
							<?php if (element('use_category', element('board', $view))) { ?>
								<div class="item" onClick="post_change_category('<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-tags"></i> 카테고리변경</div>
							<?php
								}
							}
							if (element('use_post_secret', element('board', $view))) {
								if (element('post_secret', element('post', $view))) {
							?>
								<div class="item" onClick="post_action('post_secret', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-unlock"></i> 비밀글해제</div>
							<?php } else { ?>
								<div class="item" onClick="post_action('post_secret', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-lock"></i> 비밀글로</div>
							<?php
								}
							}
							if (element('post_hide_comment', element('post', $view))) {
							?>
								<div class="item" onClick="post_action('post_hide_comment', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-comments"></i> 댓글감춤해제</div>
							<?php } else { ?>
								<div class="item" onClick="post_action('post_hide_comment', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-comments"></i> 댓글감춤</div>
							<?php } ?>
							<?php if (element('post_notice', element('post', $view))) { ?>
								<div class="item" onClick="post_action('post_notice', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-bullhorn"></i> 공지내림</div>
							<?php } else { ?>
								<div class="item" onClick="post_action('post_notice', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-bullhorn"></i> 공지올림</div>
							<?php } ?>
							<?php if (element('post_blame', element('post', $view)) >= element('blame_blind_count', element('board', $view))) { ?>
								<div class="item" onClick="post_action('post_blame_blind', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-exclamation-circle"></i> 블라인드해제</div>
							<?php } else { ?>
								<div class="item" onClick="post_action('post_blame_blind', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-exclamation-circle"></i> 블라인드처리</div>
							<?php } ?>
							<?php if (element('use_posthistory', element('board', $view))) { ?>
								<div class="item" onClick="post_history('<?php echo element('post_id', element('post', $view)); ?>');" ><i class="fa fa-history"></i> 글변경로그</div>
							<?php } ?>
							<?php if (element('use_download_log', element('board', $view))) { ?>
								<div class="item" onClick="download_log('<?php echo element('post_id', element('post', $view)); ?>');" ><i class="fa fa-download"></i> 다운로드로그</div>
							<?php } ?>
							<?php	if (element('use_link_click_log', element('board', $view))) { ?>
								<div class="item" onClick="link_click_log('<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-link"></i> 링크클릭로그</div>
							<?php } ?>
							<div class="item" onClick="post_action('post_trash', '<?php echo element('post_id', element('post', $view)); ?>', '', '이 글을 휴지통으로 이동하시겠습니까?');"><i class="fa fa-trash"></i> 휴지통으로</div>
						</div>
					<?php } ?>
				</div>
				<!-- asmo sh 231218 디자인 상 문의게시판 reply-contents dn 처리 후 #asmo_post_box 밖으로 재배치-->
				<?php if(count(element('list', element('reply_list', $view))) > 0){ ?>
					<div class="reply-contents">
						<ul>
							<?php foreach(element('list', element('reply_list', $view)) as $k => $v){ ?>
							<li>
								<div class="asmo_reply_top_box">
									<p><?php echo element('post_display_name', $v); ?></p>
									<div class="asmo_reply_top_right">
										<?=banner('post_time')?>
										<span><?php echo display_datetime(element('post_datetime', $v), 'full'); ?></span>
									</div>
								</div>
								<!-- <span><?php echo html_escape(element('post_title', $v)); ?></span> -->
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
								<!-- <div>
								<?php echo element('post_display_name', $v); ?>
								</div>
								<div>
								<?php echo display_datetime(element('post_datetime', $v), 'full'); ?>
								</div> -->
								<!-- asmo sh 231221 디자인 상 링크, 다운로드 횟수 불필요하여 주석 처리 -->
								<!-- <?php if (element('link_count', $v) > 0) { ?>
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
								<?php } ?> -->
							</li>
							<?php } ?>
						</ul>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
				<?php if (element('tag', element('post', $view))) { ?>
					<div class="tags mt20">
						<i class="fa fa-tags"></i>
						<?php
						foreach (element('tag', element('post', $view)) as $key => $value) {
						?>
							<a href="<?php echo site_url('tags/?tag=' . html_escape(element('pta_tag', $value))); ?>" title="<?php echo html_escape(element('pta_tag', $value)); ?> 태그 목록"><?php echo html_escape(element('pta_tag', $value)); ?></a>,
						<?php	} ?>
					</div>
				<?php } ?>
			
				<?php
				if ( ! element('post_hide_comment', element('post', $view))) {
				?>
				<?php
					$this->load->view(element('view_skin_path', $layout) . '/comment_write');
				}
				?>
				<!-- asmo sh 231218 디자인 상 댓글창과 댓글 등록창 자리 바꾸기 -->
				<div id="viewcomment"></div>
			
				<!-- asmo sh 231218 디자인 상 불필요하여 주석 처리 -->
			
				<!-- <div class="border_button mt20 mb20">
					<div class="btn-group pull-left" role="group" aria-label="...">
						<?php if (element('modify_url', $view)) { ?>
							<a href="<?php echo element('modify_url', $view); ?>" class="btn btn-default btn-sm">수정</a>
						<?php } ?>
						<?php	if (element('delete_url', $view)) { ?>
							<button type="button" class="btn btn-default btn-sm btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>">삭제</button>
						<?php } ?>
							<a href="<?php echo element('list_url', $view); ?>" class="btn btn-default btn-sm">목록</a>
						<?php if (element('search_list_url', $view)) { ?>
								<a href="<?php echo element('search_list_url', $view); ?>" class="btn btn-default btn-sm">검색목록</a>
						<?php } ?>
						<?php if (element('reply_url', $view)) { ?>
							<a href="<?php echo element('reply_url', $view); ?>" class="btn btn-default btn-sm">답변</a>
						<?php } ?>
						<?php if (element('prev_post', $view)) { ?>
							<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="btn btn-default btn-sm">이전글</a>
						<?php } ?>
						<?php if (element('next_post', $view)) { ?>
							<a href="<?php echo element('url', element('next_post', $view)); ?>" class="btn btn-default btn-sm">다음글</a>
						<?php } ?>
						</div>
					<?php if (element('write_url', $view)) { ?>
						<div class="pull-right">
							<a href="<?php echo element('write_url', $view); ?>" class="btn btn-success btn-sm">글쓰기</a>
						</div>
					<?php } ?>
				</div> -->
			
			</div>
			
			<!-- asmo lkt 231220 게시판 미리보기 추가 -->
			<div class="preview">
					<?php
					$attributes = array('name' => 'fboardlistPreview', 'id' => 'fboardlistPreview');
					echo form_open('', $attributes);
					?>
						<!-- asmo sh 231218 테이블 내 컨텐츠들 디자인처럼 재배치 -->
						<table class="table table-hover">
							<thead>
								<tr>
									<?php if (element('is_admin', $view)) { ?><th style="width : 3%"><input onclick="if (this.checked) all_boardlist_checked(true); else all_boardlist_checked(false);" type="checkbox" /></th><?php } ?>
									<th style="width : 5%">NO</th>
									<?php if (element('brd_id', element('board', element('listPreview', $view))) == '3' || element('brd_id', element('board', element('listPreview', $view))) == '4'){?>
										<th style="width : 10%">문의유형</th>
										<th style="width : 10%">처리상태</th>
									<?php } ?>
									<th style="width : 48%">제목</th>
									<?php if (element('brd_id', element('board', element('listPreview', $view))) == '3' || element('brd_id', element('board', element('listPreview', $view))) == '4'){?>
									<?php if (element('is_admin', $view)) { ?><th style="width : 10%">기업명</th><?php } ?>
									<?php } ?>
									<th style="width : 10%">글쓴이</th>
									<th style="width : 10%">날짜</th>
									<!-- asmo sh 231121 디자인 상 조회수 불필요하여 주석 처리 -->
									<!-- <th>조회수</th> -->
									<!-- //asmo sh 231121 디자인 상 조회수 불필요하여 주석 처리 -->
								</tr>
							</thead>
							<tbody>
							<!-- asmo sh 231218 공지일 경우 td 태그에 asmo_notice 라는 클래스 추가 및 제목에 asmo_list_flex_box 클래스 추가 -->
							<?php
							if (element('notice_list', element('listPreview', $view))) {
								foreach (element('notice_list', element('listPreview', $view)) as $result) {
							?>
								<tr>
									<?php if (element('is_admin', $view)) { ?>
										<th class="asmo_notice" scope="row"><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" /></th>
									<?php } ?>
									<td class="asmo_notice"><span class="label label-primary">공지</span></td>
									<?php if (element('brd_id', element('board', element('listPreview', $view))) == '3' || element('brd_id', element('board', element('listPreview', $view))) == '4'){?>
									<?php if (element('is_admin', $view)) { ?><td><?php echo element('company_name', $result); ?></td><?php } ?>
									<?php } ?>
									<td class="asmo_notice asmo_list_flex_box">
										<?php if (element('post_reply', $result)) { ?><span class="label label-primary" style="margin-left:<?php echo strlen(element('post_reply', $result)) * 10; ?>px">Re</span><?php } ?>
										<a href="<?php echo element('post_url', $result); ?>" style="
											<?php
											if (element('title_color', $result)) {
												echo 'color:' . element('title_color', $result) . ';';
											}
											if (element('title_font', $result)) {
												echo 'font-family:' . element('title_font', $result) . ';';
											}
											if (element('title_bold', $result)) {
												echo 'font-weight:bold;';
											}
											if (element('post_id', element('post', $view)) === element('post_id', $result)) {
												echo 'font-weight:bold;';
											}
											?>
										" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a>
										<?php if (element('is_mobile', $result)) { ?><span class="fa fa-wifi"></span><?php } ?>
										<!-- asmo sh 231218 디자인 상 다운로드 있는 글일 때 이미지 변경 필요하여 span 태그 dn 처리 후 아이콘 추가 -->
										<?php if (element('post_file', $result)) { ?><span class="dn fa fa-download"></span><?=banner('download')?><?php } ?>
										<!-- asmo sh 231218 디자인 상 비밀글일 때 이미지 변경 필요하여 span 태그 dn 처리 후 아이콘 추가 -->
										<?php if (element('post_secret', $result)) { ?><span class="dn fa fa-lock"></span><?=banner('lock')?><?php } ?>
										<?php if (element('ppo_id', $result)) { ?><i class="fa fa-bar-chart"></i><?php } ?>
										<!-- + 텍스트 불 필요하여 삭제 -->
										<?php if (element('post_comment_count', $result)) { ?><span class="label label-warning"><?php echo element('post_comment_count', $result); ?></span><?php } ?>
			
									<td class="asmo_notice"><?php echo element('display_name', $result); ?></td>
									<td class="asmo_notice"><?php echo element('display_datetime', $result); ?></td>
									<!-- asmo sh 231121 디자인 상 조회수 불필요하여 주석 처리 -->
									<!-- <td><?php echo number_format(element('post_hit', $result)); ?></td> -->
									<!-- //asmo sh 231121 디자인 상 조회수 불필요하여 주석 처리 -->
								</tr>
							<?php
								}
							}
							if (element('list', element('data', element('listPreview', $view)))) {
								foreach (element('list', element('data', element('listPreview', $view))) as $result) {
							?>
								<tr>
									<?php if (element('is_admin', $view)) { ?><th scope="row"><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" /></th><?php } ?>
									<td><?php echo element('num', $result); ?></td>
									<?php if (element('brd_id', element('board', element('listPreview', $view))) == '3' || element('brd_id', element('board', element('listPreview', $view))) == '4'){?>
									<td><?php echo element('output',element('extra_content', $result)); ?></td>
									<td><?php if(element('post_reply_chk', $result) == 'y'){echo '<span class="asmo_reply_wait">답변완료</span>';}else{echo '<span class="asmo_reply_comp">답변대기</span>';} ?></td>
									<?php } ?>
			
									<!-- <?php //if (element('is_admin', $view)) { ?><td><?php //echo element('company_name', $result); ?></td><?php //} ?> -->
									<td class="asmo_list_flex_box">
										<?php if (element('category', $result)) { ?><a href="<?php echo board_url(element('brd_key', element('board', element('listPreview', $view)))); ?>?category_id=<?php echo html_escape(element('bca_key', element('category', $result))); ?>"><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $result))); ?></span></a><?php } ?>
										<?php if (element('post_reply', $result)) { ?><span class="label label-primary" style="margin-left:<?php echo strlen(element('post_reply', $result)) * 10; ?>px">Re</span><?php } ?>
										<a href="<?php echo element('post_url', $result); ?>"
										<?php if(element('brd_id', element('board', element('listPreview', $view))) == '3'){ // 문의게시판(전체)
											if(element('mem_is_admin', element('userdata', $view)) == '1'){ // 최고관리자
												echo 'onclick="adminLink('.element('post_id', $result).', '.element('brd_id', element('board', element('listPreview', $view))).')"';
											}
										}else if(element('brd_id', element('board', element('listPreview', $view))) == '4'){ // 문의게시판(기업)
											if(element('mem_is_admin', element('userdata', $view)) == '1'){ // 최고관리자
												echo 'onclick="adminLink('.element('post_id', $result).', '.element('brd_id', element('board', element('listPreview', $view))).')"';
											} else {
												if(element('mem_level', element('userdata', $view)) == '100'){ // 기업관리자
													echo 'onclick="adminLink('.element('post_id', $result).', '.element('brd_id', element('board', element('listPreview', $view))).')"';
												}
											}
										}?>
										style="
											<?php
											if (element('title_color', $result)) {
												echo 'color:' . element('title_color', $result) . ';';
											}
											if (element('title_font', $result)) {
												echo 'font-family:' . element('title_font', $result) . ';';
											}
											if (element('title_bold', $result)) {
												echo 'font-weight:bold;';
											}
											if (element('post_id', element('post', $view)) === element('post_id', $result)) {
												echo 'font-weight:bold;';
											}
											?>
										" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a>
										<?php if (element('is_mobile', $result)) { ?><span class="fa fa-wifi"></span><?php } ?>
										<!-- asmo sh 231218 디자인 상 다운로드 있는 글일 때 이미지 변경 필요하여 span 태그 dn 처리 후 아이콘 추가 -->
										<?php if (element('post_file', $result)) { ?><span class="dn fa fa-download"></span><?=banner('download')?><?php } ?>
										<!-- asmo sh 231218 디자인 상 비밀글일 때 이미지 변경 필요하여 span 태그 dn 처리 후 아이콘 추가 -->
										<?php if (element('post_secret', $result)) { ?><span class="dn fa fa-lock"></span><?=banner('lock')?><?php } ?>
										<?php if (element('is_hot', $result)) { ?><span class="label label-danger">Hot</span><?php } ?>
										<!-- asmo sh 231218 디자인 상 새로운 글이 등록됐을 때 나오는 new span 태그에 asmo_label-new 클래스 추가 후 텍스트 변경 -->
										<?php if (element('is_new', $result)) { ?><span class="label label-warning asmo_label-new"><?=banner('new')?></span><?php } ?>
										<?php if (element('ppo_id', $result)) { ?><i class="fa fa-bar-chart"></i><?php } ?>
										<!-- + 텍스트 불 필요하여 삭제 -->
										<?php if (element('post_comment_count', $result)) { ?><span class="label label-warning"><?php echo element('post_comment_count', $result); ?></span><?php } ?>
										<?php if (element('brd_id', element('board', element('listPreview', $view))) == '3' || element('brd_id', element('board', element('listPreview', $view))) == '4'){?>
										<?php if (element('is_admin', $view)) { ?><td><?php echo element('company_name', $result); ?></td><?php } ?>
										<?php } ?>
									<td><?php echo element('display_name', $result); ?></td>
									<td><?php echo element('display_datetime', $result); ?></td>
									<!-- asmo sh 231121 디자인 상 조회수 불필요하여 주석 처리 -->
									<!-- <td><?php echo number_format(element('post_hit', $result)); ?></td> -->
									<!-- //asmo sh 231121 디자인 상 조회수 불필요하여 주석 처리 -->
								</tr>
							<?php
								}
							}
							if ( ! element('notice_list', element('listPreview', $view)) && ! element('list', element('data', element('listPreview', $view)))) {
							?>
								<tr>
									<td colspan="7" class="nopost">게시물이 없습니다</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					<?php echo form_close(); ?>
					<!-- asmo sh 231220 디자인 상 border_button 불필요 하여 주석 처리 -->
					<!-- <div class="border_button">
						<div class="pull-left mr10">
							<a href="<?php echo element('list_url', element('list', $view)); ?>" class="btn btn-default btn-sm">목록</a>
							<?php if (element('search_list_url', element('list', $view))) { ?>
								<a href="<?php echo element('search_list_url', element('list', $view)); ?>" class="btn btn-default btn-sm">검색목록</a>
							<?php } ?>
						</div>
						<?php if (element('is_admin', $view)) { ?>
							<div class="pull-left">
								<button type="button" class="btn btn-default btn-sm admin-manage-list"><i class="fa fa-cog big-fa"></i> 관리</button>
								<div class="btn-admin-manage-layer admin-manage-layer-list">
									<?php if (element('is_admin', $view) === 'super') { ?>
										<div class="item" onClick="document.location.href='<?php echo admin_url('board/boards/write/' . element('brd_id', element('board', element('list', $view)))); ?>';"><i class="fa fa-cog"></i> 게시판설정</div>
										<div class="item" onClick="post_multi_copy('copy');"><i class="fa fa-files-o"></i> 복사하기</div>
										<div class="item" onClick="post_multi_copy('move');"><i class="fa fa-arrow-right"></i> 이동하기</div>
										<div class="item" onClick="post_multi_change_category();"><i class="fa fa-tags"></i> 카테고리변경</div>
									<?php } ?>
									<div class="item" onClick="post_multi_action('multi_delete', '0', '선택하신 글들을 완전삭제하시겠습니까?');"><i class="fa fa-trash-o"></i> 선택삭제하기</div>
									<div class="item" onClick="post_multi_action('post_multi_secret', '0', '선택하신 글들을 비밀글을 해제하시겠습니까?');"><i class="fa fa-unlock"></i> 비밀글해제</div>
									<div class="item" onClick="post_multi_action('post_multi_secret', '1', '선택하신 글들을 비밀글로 설정하시겠습니까?');"><i class="fa fa-lock"></i> 비밀글로</div>
									<div class="item" onClick="post_multi_action('post_multi_notice', '0', '선택하신 글들을 공지를 내리시겠습니까?');"><i class="fa fa-bullhorn"></i> 공지내림</div>
									<div class="item" onClick="post_multi_action('post_multi_notice', '1', '선택하신 글들을 공지로 등록 하시겠습니까?');"><i class="fa fa-bullhorn"></i> 공지올림</div>
									<div class="item" onClick="post_multi_action('post_multi_blame_blind', '0', '선택하신 글들을 블라인드 해제 하시겠습니까?');"><i class="fa fa-exclamation-circle"></i> 블라인드해제</div>
									<div class="item" onClick="post_multi_action('post_multi_blame_blind', '1', '선택하신 글들을 블라인드 처리 하시겠습니까?');"><i class="fa fa-exclamation-circle"></i> 블라인드처리</div>
									<div class="item" onClick="post_multi_action('post_multi_trash', '', '선택하신 글들을 휴지통으로 이동하시겠습니까?');"><i class="fa fa-trash"></i> 휴지통으로</div>
								</div>
							</div>
						<?php } ?>
						<?php if (element('write_url', element('list', $view))) { ?>
							<?php if(element('brd_id', element('board', element('list', $view))) == '4'){ // 문의게시판(기업) ?>
								<?php if(element('mem_is_admin', element('userdata', $view)) == '0' && element('mem_level', element('userdata', $view)) == '1'){ // 최고관리자가 아니고 회원레벨이 1인 경우에만 글쓰기 버튼 노출 ?>
									<div class="pull-right">
										<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm">글쓰기</a>
									</div>
								<?php } ?>
							<?php } else if(element('brd_id', element('board', element('list', $view))) == '3') { // 문의게시판(전체) ?>
								<?php if(element('mem_is_admin', element('userdata', $view)) == '0'){ // 최고관리자가 아닌 경우 글쓰기 버튼 노출 ?>
									<div class="pull-right">
										<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm">글쓰기</a>
									</div>
								<?php } ?>
							<?php } else { ?>
								<?php if(element('brd_id', element('board', element('list', $view))) != '1' && element('brd_id', element('board', element('list', $view))) != '2'){ ?>
									<div class="pull-right">
										<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm">글쓰기</a>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</div> -->
					<nav><?php echo element('paging', element('list', $view)); ?></nav>
			
			</div>
			<!--// asmo lkt 231220 게시판 미리보기 추가 -->
		</div>

		<!-- asmo sh 231218 fixed된 div 생성 후 공지사항인지 문의게시판인지에 따라 다른 컨텐츠 재배치 -->
		<div class="post_fixed_box_wrap">
			<div class="post_fixed_box">
		
				<?php if (element('brd_id', element('post', $view)) == '3' || element('brd_id', element('post', $view)) == '4'){ ?>
					<div class="post_fixed_top">
					
						<?php if (element('modify_url', $view)) { ?>
							<a href="<?php echo element('modify_url', $view); ?>" class="btn btn-default btn-sm">수정하기</a>
						<?php } ?>
						<?php if (element('delete_url', $view)) { ?>
							<button type="button" class="btn btn-default btn-sm btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>">삭제하기</button>
						<?php } ?>

					</div>
					<?php } else { ?>

						<?php if (element('prev_post', $view) || element('next_post', $view) ) { ?>
						
							<div class="notice_fixed_top">
								<?php if (element('prev_post', $view)) { ?>
									<div class="notice_post_wrap">
										<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="btn btn-default btn-sm">
											<div class="prev_post_img"></div>

											<p><span>이전</span> <?php echo element('post_title', element('prev_post', $view)); ?></p>
										</a>
									</div>
								<?php } ?>

								<?php if (element('next_post', $view)) { ?>
									<div class="notice_post_wrap">
										<a href="<?php echo element('url', element('next_post', $view)); ?>" class="btn btn-default btn-sm">

											<div class="next_post_img"></div>

											<p><span>다음</span> <?php echo element('post_title', element('next_post', $view)); ?></p>
										</a>
									</div>

								<?php } ?>

							</div>

						<?php } ?>

					<?php } ?>
				
		
				<div class="post_fixed_bottom">
					<a href="<?php echo element('list_url', $view); ?>" class="btn btn-default btn-sm">목록으로 가기</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //asmo sh 231130 post 페이지 감싸는 div#asmo_post_wrapper 생성 -->



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
client.on('ready', function( readyEvent ) {
	client.on('aftercopy', function( event ) {
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


<script type="text/javascript">
	$(document).ready(function() {

		// asmo sh 231130 post 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		// $('.sidebar').addClass('dn');
		// $('footer').addClass('dn');

		$('.main').addClass('add');

		$('.wrapper').addClass('bg');
		
	});

	// 최고관리자 및 기업관리자 문의게시판(전체, 기업)에서 관리자페이지로 이동
	function adminLink(post_id, brd_id){
		if(brd_id == '3'){
			var url = '/admin/board/qna/post/'+post_id;
		} else if(brd_id == '4'){
			var url = '/admin/board/cqna/post/'+post_id;
		}
		//console.log(url);
		alert('관리자에서 확인하실 수 있습니다.');
		setTimeout(function(){
			location.href=url;
		}, 1000);
	}
</script>