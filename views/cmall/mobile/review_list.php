<div class="alert alert-auto-close alert-dismissible alert-cmall-review-list-message" style="display:none;"><button type="button" class="close alertclose">×</button><span class="alert-cmall-review-list-message-content"></span></div>

<?php
$i = 0;
if (element('list', element('data', $view))) {
	foreach (element('list', element('data', $view)) as $result) {
?>
	<div class="product-feedback">
		<div class="asmo_review_top" onclick="return review_open(this);">
			<p class="item_review_title" ><i class="fa fa-comments-o"></i> <?php echo html_escape(element('cre_title', $result)); ?></p>
			<ul>
				<li>
					<?php
					if(cmall_item_parent_category($view['cit_id'])==2){
						?>
							<?php echo $result['mem_div'];?>
							<?php echo $result['mem_username'];?>
							<?php echo $result['mem_position'];?>
						<?php
					}else if(cmall_item_parent_category($view['cit_id'])==6){
						
						?>
							<?php echo mb_substr($result['mem_username'],0,2)."*";?>
						<?php
					}
					?>
				</li>
				<li class="asmo_time"><?php echo element('display_datetime', $result); ?></li>
				<?php if (element('cre_score', $result) >=1 && element('cre_score', $result) <=5) { ?>
					<li class="asmo_review_star">
						<span class="asmo_star_wrap">
							<span class="asmo_star_inner" style="width:<?php echo element('cre_score', $result) * 20; ?>%"></span>
						</span>
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="feedback-box review-content">
			<?php echo element('content', $result); ?>
			<div class="asmo_board_btn_wrap">
				<?php if (element('can_update', $result)) { ?>
					<a href="javascript:;" class="btn btn-xs btn-success" onClick="window.open('<?php echo site_url('cmall/review_write/' . element('cit_id', $view) . '/' . element('cre_id', $result) . '?page=' . $this->input->get('page')); ?>', 'review_popup', 'width=750,height=770,scrollbars=1'); return false;">수정</a>
				<?php } ?>
				<?php if (element('can_delete', $result)) { ?>
					<a href="javascript:;" class="btn btn-xs btn-danger" onClick="delete_cmall_review('<?php echo element('cre_id', $result); ?>', '<?php echo element('cit_id', $result); ?>', '<?php echo element('page', $view); ?>');">삭제</a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
	}
} else {
?>
<div class="product-feedback">아직 등록된 상품후기가 없습니다</div>
<?php } ?>

<nav><?php echo element('paging', $view); ?></nav>
