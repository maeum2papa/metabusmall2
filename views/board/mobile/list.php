<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<?php echo element('headercontent', element('board', element('list', $view))); ?>

<div id="asmo_item_detail_wrap" class="asmo_board_list_wrap">

	<div class="board">
		<!-- 공지사항 리스트 상단 공통 영역 추가, 공지사항일때만 노출 asmo lhb 231227  -->
		<?php if ( (element('brd_key', element('board', element('list', $view)))) == 'notice' || (element('brd_key', element('board', element('list', $view)))) == 'cnotice' ){ ?>
		<section id="asmo_board_list_top_common_wrap"> 
			<article class="asmo_board_tab_wrap">
				<a href="<?php echo site_url('board/notice'); ?>" <?php if ( (element('brd_key', element('board', element('list', $view)))) == 'notice'){ ?>class="active"<?php } ?>>컬래버랜드 공지사항</a>
				<a href="<?php echo site_url('board/cnotice'); ?>" <?php if ( (element('brd_key', element('board', element('list', $view)))) == 'cnotice'){ ?>class="active"<?php } ?>><?=busiNm($this->member->item('company_idx'))?> 공지사항</a>
			</article>
			<article class="asmo_board_search_wrap">
				<div class=" searchbox">
					<div id="asmo_board_search_close" onClick="searchboxClose();">닫기</div>
					<form class="navbar-form navbar-right" action="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>" onSubmit="return postSearch(this);">
						<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
						<input type="hidden" name="category_id" value="<?php echo html_escape($this->input->get('category_id')); ?>" />
						<div class="form-group">
							<select class="input" name="sfield">
								<option value="post_both" <?php echo ($this->input->get('sfield') === 'post_both') ? ' selected="selected" ' : ''; ?>>제목+내용</option>
								<option value="post_title" <?php echo ($this->input->get('sfield') === 'post_title') ? ' selected="selected" ' : ''; ?>>제목</option>
								<option value="post_content" <?php echo ($this->input->get('sfield') === 'post_content') ? ' selected="selected" ' : ''; ?>>내용</option>
								<option value="post_nickname" <?php echo ($this->input->get('sfield') === 'post_nickname') ? ' selected="selected" ' : ''; ?>>회원명</option>
								<option value="post_userid" <?php echo ($this->input->get('sfield') === 'post_userid') ? ' selected="selected" ' : ''; ?>>회원아이디</option>
							</select>
							<div class="asmo_faq_s_input_wrap">
								<input type="text" class="input" placeholder="검색" name="skeyword" value="<?php echo html_escape($this->input->get('skeyword')); ?>" />
								<button class="" type="submit"></button>
							</div>
						</div>
					</form>
				</div>
				<div class="searchbuttonbox">
					<button class="btn btn-primary btn-sm " type="button" onClick="toggleSearchbox();">검색</button>
				</div>
				<?php if (element('point_info', element('list', $view))) { ?>
					<div class="point-info pull-right mr10">
						<button type="button" class="btn-point-info" ><i class="fa fa-info-circle"></i></button>
						<div class="point-info-content alert alert-warning"><strong>포인트안내</strong><br /><?php echo element('point_info', element('list', $view)); ?></div>
					</div>
				<?php } ?>
				<div class="asmo_board_select_wrap">
					<select class="input" onchange="location.href='<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?category_id=<?php echo html_escape($this->input->get('categroy_id')); ?>&amp;findex=' + this.value;">
						<option value="">정렬</option>
						<option value="post_datetime desc" <?php echo $this->input->get('findex') === 'post_datetime desc' ? 'selected="selected"' : '';?>>날짜순</option>
						<option value="post_hit desc" <?php echo $this->input->get('findex') === 'post_hit desc' ? 'selected="selected"' : '';?>>조회수</option>
						<option value="post_comment_count desc" <?php echo $this->input->get('findex') === 'post_comment_count desc' ? 'selected="selected"' : '';?>>댓글수</option>
						<?php if (element('use_post_like', element('board', element('list', $view)))) { ?>
							<option value="post_like desc" <?php echo $this->input->get('findex') === 'post_like desc' ? 'selected="selected"' : '';?>>추천순</option>
						<?php } ?>
					</select>
				</div>
			</article>
		</section>
		<?php }else if (  (element('brd_key', element('board', element('list', $view)))) == 'qna' || (element('brd_key', element('board', element('list', $view)))) == 'cqna' ) { ?>
			<section id="asmo_board_list_top_common_wrap"> 
			<article class="asmo_board_tab_wrap">
				<a href="<?php echo site_url('board/qna'); ?>" <?php if ( (element('brd_key', element('board', element('list', $view)))) == 'qna'){ ?>class="active"<?php } ?>>컬래버랜드 문의하기</a>
				<a href="<?php echo site_url('board/cqna'); ?>" <?php if ( (element('brd_key', element('board', element('list', $view)))) == 'cqna'){ ?>class="active"<?php } ?>><?=busiNm($this->member->item('company_idx'))?> 문의하기</a>
			</article>
			<article class="asmo_board_search_wrap">
				<div class=" searchbox">
					<div id="asmo_board_search_close" onClick="searchboxClose();">닫기</div>
					<form class="navbar-form navbar-right" action="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>" onSubmit="return postSearch(this);">
						<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
						<input type="hidden" name="category_id" value="<?php echo html_escape($this->input->get('category_id')); ?>" />
						<div class="form-group">
							<select class="input" name="sfield">
								<option value="post_both" <?php echo ($this->input->get('sfield') === 'post_both') ? ' selected="selected" ' : ''; ?>>제목+내용</option>
								<option value="post_title" <?php echo ($this->input->get('sfield') === 'post_title') ? ' selected="selected" ' : ''; ?>>제목</option>
								<option value="post_content" <?php echo ($this->input->get('sfield') === 'post_content') ? ' selected="selected" ' : ''; ?>>내용</option>
								<option value="post_nickname" <?php echo ($this->input->get('sfield') === 'post_nickname') ? ' selected="selected" ' : ''; ?>>회원명</option>
								<option value="post_userid" <?php echo ($this->input->get('sfield') === 'post_userid') ? ' selected="selected" ' : ''; ?>>회원아이디</option>
							</select>
							<div class="asmo_faq_s_input_wrap">
								<input type="text" class="input" placeholder="검색" name="skeyword" value="<?php echo html_escape($this->input->get('skeyword')); ?>" />
								<button class="" type="submit"></button>
							</div>
						</div>
					</form>
				</div>
				<div class="searchbuttonbox">
					<button class="btn btn-primary btn-sm " type="button" onClick="toggleSearchbox();">검색</button>
				</div>
				<?php if (element('point_info', element('list', $view))) { ?>
					<div class="point-info pull-right mr10">
						<button type="button" class="btn-point-info" ><i class="fa fa-info-circle"></i></button>
						<div class="point-info-content alert alert-warning"><strong>포인트안내</strong><br /><?php echo element('point_info', element('list', $view)); ?></div>
					</div>
				<?php } ?>
				<div class="asmo_board_select_wrap">
					<select class="input" onchange="location.href='<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?category_id=<?php echo html_escape($this->input->get('categroy_id')); ?>&amp;findex=' + this.value;">
						<option value="">정렬</option>
						<option value="post_datetime desc" <?php echo $this->input->get('findex') === 'post_datetime desc' ? 'selected="selected"' : '';?>>날짜순</option>
						<option value="post_hit desc" <?php echo $this->input->get('findex') === 'post_hit desc' ? 'selected="selected"' : '';?>>조회수</option>
						<option value="post_comment_count desc" <?php echo $this->input->get('findex') === 'post_comment_count desc' ? 'selected="selected"' : '';?>>댓글수</option>
						<?php if (element('use_post_like', element('board', element('list', $view)))) { ?>
							<option value="post_like desc" <?php echo $this->input->get('findex') === 'post_like desc' ? 'selected="selected"' : '';?>>추천순</option>
						<?php } ?>
					</select>
				</div>
			</article>
		</section>
		<?php } ?> 
		<div class="table-top">
			<?php if ( ! element('access_list', element('board', element('list', $view))) && element('use_rss_feed', element('board', element('list', $view)))) { ?>
				<a href="<?php echo rss_url(element('brd_key', element('board', element('list', $view)))); ?>" class="btn btn-default btn-sm" title="<?php echo html_escape(element('board_name', element('board', element('list', $view)))); ?> RSS 보기"><i class="fa fa-rss"></i></a>
			<?php } ?>

			
			<?php if (element('use_category', element('board', element('list', $view))) && ! element('cat_display_style', element('board', element('list', $view)))) { ?>
				<select class="input" onchange="location.href='<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?findex=<?php echo html_escape($this->input->get('findex')); ?>&category_id=' + this.value;">
					<option value="">카테고리선택</option>
					<?php
					$category = element('category', element('board', element('list', $view)));
					function ca_select($p = '', $category = '', $category_id = '') {
						$return = '';
						if ($p && is_array($p)) {
							foreach ($p as $result) {
								$exp = explode('.', element('bca_key', $result));
								$len = (element(1, $exp)) ? strlen(element(1, $exp)) : 0;
								$space = str_repeat('-', $len);
								$return .= '<option value="' . html_escape(element('bca_key', $result)) . '"';
								if (element('bca_key', $result) === $category_id) {
									$return .= 'selected="selected"';
								}
								$return .= '>' . $space . html_escape(element('bca_value', $result)) . '</option>';
								$parent = element('bca_key', $result);
								$return .= ca_select(element($parent, $category), $category, $category_id);
							}
						}
						return $return;
					}

					echo ca_select(element(0, $category), $category, $this->input->get('category_id'));
					?>
				</select>
			<?php } ?>
			
			<script type="text/javascript">
			//<![CDATA[
			function postSearch(f) {
				var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
				if (skeyword.length < 2) {
					alert('2글자 이상으로 검색해 주세요');
					f.skeyword.focus();
					return false;
				}
				return true;
			}
			function toggleSearchbox() {
				$('.searchbox').show();
				$('.searchbuttonbox').hide();
			}
			function searchboxClose() {
				$('.searchbox').hide();
				$('.searchbuttonbox').show();
			}
			<?php
				if ($this->input->get('skeyword')) {
					echo 'toggleSearchbox();';
				}
			?>
			$(document).on('click', '.btn-point-info', function() {
				$('.point-info-content').toggle();
			});
			//]]>
			</script>
		</div>

		<?php
		if (element('use_category', element('board', element('list', $view))) && element('cat_display_style', element('board', element('list', $view))) === 'tab') {
			$category = element('category', element('board', element('list', $view)));
		?>
			<ul class="nav nav-tabs clearfix">
				<li role="presentation" <?php if ( ! $this->input->get('category_id')) { ?>class="active" <?php } ?>><a href="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?findex=<?php echo html_escape($this->input->get('findex')); ?>&category_id=">전체</a></li>
				<?php
				if (element(0, $category)) {
					foreach (element(0, $category) as $ckey => $cval) {
				?>
					<li role="presentation" <?php if ($this->input->get('category_id') === element('bca_key', $cval)) { ?>class="active" <?php } ?>><a href="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?findex=<?php echo html_escape($this->input->get('findex')); ?>&category_id=<?php echo element('bca_key', $cval); ?>"><?php echo html_escape(element('bca_value', $cval)); ?></a></li>
				<?php
					}
				}
				?>
			</ul>
		<?php } ?>

		
		<?php
		$attributes = array('name' => 'fboardlist', 'id' => 'fboardlist');
		echo form_open('', $attributes);
		?>
			<table class="table">
				<thead>
					<tr>
						<?php if (element('is_admin', $view)) { ?><th><input onclick="if (this.checked) all_boardlist_checked(true); else all_boardlist_checked(false);" type="checkbox" /></th><?php } ?>
						<th class="asmo_no_th">NO</th>
						<?php if (element('brd_id', element('board', element('list', $view))) == '3' || element('brd_id', element('board', element('list', $view))) == '4'){?>
						<th class="asmo_type_th">문의유형</th>
						<th class="asmo_status_th">처리상태</th>
						<?php } ?>
						<th>제목</th>
						<th class="asmo_writer_th">작성자</th>
						<th class="asmo_date_th">작성일</th>
						<!-- <th>조회수</th> -->
					</tr>
				</thead>
				<tbody>
				<?php
				if (element('notice_list', element('list', $view))) {
					foreach (element('notice_list', element('list', $view)) as $result) {
				?>
					<tr class="asmo_notice_list_tr">
						<?php if (element('is_admin', $view)) { ?><th scope="row"><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" /></th><?php } ?>
						<td class="asmo_no_td"><span class="label label-primary">필수</span></td>
						<td class="text-left">
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
							<!-- <?php //if (element('is_mobile', $result)) { ?><span class="fa fa-wifi"></span><?php //} ?> -->
							<?php if (element('post_file', $result)) { ?><span class="fa fa-download" style="display:none;"></span><?php } ?>
							<?php if (element('post_secret', $result)) { ?><span class="fa fa-lock"></span><?php } ?>
							<?php if (element('ppo_id', $result)) { ?><i class="fa fa-bar-chart"></i><?php } ?>
							<?php if (element('post_comment_count', $result)) { ?><span class="label label-warning asmo_commnet_cnt">+<?php echo element('post_comment_count', $result); ?></span><?php } ?>
						<td class="asmo_writer_td"><?php echo element('display_name', $result); ?></td>
						<td class="asmo_date_td"><?php echo element('display_datetime', $result); ?></td>
						<!-- <td><?php //echo number_format(element('post_hit', $result)); ?></td> -->
					</tr>
				<?php
					}
				}
				if (element('list', element('data', element('list', $view)))) {
					foreach (element('list', element('data', element('list', $view))) as $result) {
				?>
					<tr>
						<?php if (element('is_admin', $view)) { ?><th scope="row"><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" /></th><?php } ?>
						<td class="asmo_no_td"><?php echo element('num', $result); ?></td>
						<?php if (element('brd_id', element('board', element('list', $view))) == '3' || element('brd_id', element('board', element('list', $view))) == '4'){?>
						<td><?php echo element('output',element('extra_content', $result)); ?></td>
						<td><?php if(element('post_reply_chk', $result) == 'y'){echo '<span class="asmo_reply_comp">답변완료</span>';}else{echo '<span class="asmo_reply_wait">답변대기</span>';} ?></td>
						<?php } ?>
						<td class="text-left">
							<?php if (element('category', $result)) { ?><a href="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?category_id=<?php echo html_escape(element('bca_key', element('category', $result))); ?>"><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $result))); ?></span></a><?php } ?>
							<?php if (element('post_reply', $result)) { ?><span class="label label-primary" style="margin-left:<?php echo strlen(element('post_reply', $result)) * 10; ?>px">Re</span><?php } ?>
							<a href="<?php echo element('post_url', $result); ?>" 
							<?php if(element('brd_id', element('board', element('list', $view))) == '3'){ // 문의게시판(전체)
								if(element('mem_is_admin', element('userdata', $view)) == '1'){ // 최고관리자
									echo 'onclick="adminLink('.element('post_id', $result).', '.element('brd_id', element('board', element('list', $view))).')"';
								}
							}else if(element('brd_id', element('board', element('list', $view))) == '4'){ // 문의게시판(기업)
								if(element('mem_is_admin', element('userdata', $view)) == '1'){ // 최고관리자
									echo 'onclick="adminLink('.element('post_id', $result).', '.element('brd_id', element('board', element('list', $view))).')"';
								} else {
									if(element('mem_level', element('userdata', $view)) == '100'){ // 기업관리자
										echo 'onclick="adminLink('.element('post_id', $result).', '.element('brd_id', element('board', element('list', $view))).')"';
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
							<!-- <?php //if (element('is_mobile', $result)) { ?><span class="fa fa-wifi"></span><?php //} ?> -->
							<?php if (element('post_file', $result)) { ?><span class="fa fa-download" style="display:none;"></span><?php } ?>
							<?php if (element('post_secret', $result)) { ?><span class="fa fa-lock"></span><?php } ?>
							<?php if (element('is_hot', $result)) { ?><span class="label label-danger">Hot</span><?php } ?>
							<?php if (element('is_new', $result)) { ?><span class="label label-warning">New</span><?php } ?>
							<?php if (element('ppo_id', $result)) { ?><i class="fa fa-bar-chart"></i><?php } ?>
							<?php if (element('post_comment_count', $result)) { ?><span class="label label-warning asmo_commnet_cnt">+<?php echo element('post_comment_count', $result); ?></span><?php } ?>
						<td class="asmo_writer_td"><?php echo element('display_name', $result); ?></td>
						<td class="asmo_date_td"><?php echo element('display_datetime', $result); ?></td>
						<!-- <td><?php //echo number_format(element('post_hit', $result)); ?></td> -->
					</tr>
				<?php
					}
				}
				if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
				?>
					<tr>
						<?php if (element('brd_id', element('board', element('list', $view))) == '3' || element('brd_id', element('board', element('list', $view))) == '4'){?>
						<td colspan="6" class="nopost">게시물이 없습니다</td>
						<?php }else { ?>
						<td colspan="5" class="nopost">게시물이 없습니다</td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		<?php echo form_close(); ?>

		<div class="table-bottom mt20">
			<div class="pull-left mr20">
				<!-- <a href="<?php //echo element('list_url', element('list', $view)); ?>" class="btn btn-default btn-sm">목록</a> -->
				<?php if (element('search_list_url', element('list', $view))) { ?>
					<a href="<?php echo element('search_list_url', element('list', $view)); ?>" class="btn btn-default btn-sm">검색목록</a>
				<?php } ?>
			</div>
			<?php if (element('is_admin', $view)) { ?>
				<div class="pull-left">
					<button type="button" class="btn btn-default btn-sm admin-manage-list"><i class="fa fa-cog big-fa"></i>관리</button>
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
							<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm asmo_write">글쓰기</a>
						</div>
					<?php } ?>
				<?php } else if(element('brd_id', element('board', element('list', $view))) == '3') { // 문의게시판(전체) ?>
					<?php if(element('mem_is_admin', element('userdata', $view)) == '0'){ // 최고관리자가 아닌 경우 글쓰기 버튼 노출 ?>
						<div class="pull-right">
							<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm asmo_write">글쓰기</a>
						</div>
					<?php } ?>
				<?php } else { ?>
					<?php if(element('brd_id', element('board', element('list', $view))) != '1' && element('brd_id', element('board', element('list', $view))) != '2'){ ?>
						<div class="pull-right">
							<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm asmo_write">글쓰기</a>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
		<nav><?php echo element('paging', element('list', $view)); ?></nav>
	</div>

</div>

<?php echo element('footercontent', element('board', element('list', $view))); ?>

<?php
if (element('highlight_keyword', element('list', $view))) {
	$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js')); ?>
<script type="text/javascript">
//<![CDATA[
$('#fboardlist').highlight([<?php echo element('highlight_keyword', element('list', $view));?>]);
//]]>
</script>
<?php } ?>
<script type="text/javascript">
	
	//asmo lhb 231218  영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');

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
