<div class="alert alert-auto-close alert-dismissible alert-cmall-qna-list-message" style="display:none;"><button type="button" class="close alertclose">×</button><span class="alert-cmall-qna-list-message-content"></span></div>

<?php
$i = 0;
if (element('list', element('data', $view))) {
	foreach (element('list', element('data', $view)) as $result) {
?>

	<!-- 비밀글일 때 div.product-feedback에 secret_feedback 클래스 추가 -->
	<div class="product-feedback">
	<!-- //비밀글일 때 div.product-feedback에 secret_feedback 클래스 추가 -->

		<div class="qna-wr">
			
			<!-- asmo sh 231207 디자인 상 아이콘 display: none 처리 -->
			<p class="item_qna_title col-lg-8" onclick="return qna_open(this);"><i class="dn fa fa-comments-o"></i> <?php echo html_escape(element('cqa_title', $result)); ?></p>
			<ul class="col-lg-4 qna-info">

				<!-- 아이템몰일 때 -->
				<li><span class="sd-only">작성자</span> <span class="itemMall_span"><?=busiNm($this->member->item('company_idx'))?></span><span class="asmo_sh_writer">
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
				</span></li>
				<!-- //아이템몰일 때 -->

				<!-- 복지교환소일 때 -->
				<!-- <li><span class="sd-only">작성자</span> <span class="exchange_span">소속 들어와야합니다.</span><span class="asmo_sh_writer"><?php echo element('display_name', $result); ?></span><span class="exchange_span">직급 들어와야합니다.</span> </li> -->
				<!-- //복지교환소일 때 -->

				<!-- asmo sh 240222 작성 시각 Y-m-d로 변경 -->
				<li><span class="asmo_dateTime"><?php $datetime = new DateTime(element('cqa_datetime', $result)); echo $datetime->format('Y-m-d'); ?></span></li>
				<!-- //asmo sh 240222 작성 시각 Y-m-d로 변경 -->

				<li><?php echo (element('cqa_reply_mem_id', $result)) ? '<span class="qna-done">답변완료</span>' : '<span class="qna-yet">답변대기</span>';?></li>
			</ul>
		</div>
		<div class="feedback-box qna-content ">
			<div class="mb10">
				<?php echo element('content', $result); ?>

				<!-- 수정, 삭제 버튼 자리 옮김 -->
				<div class="button_box_wrap">

				<!-- asmo sh 240221 수정 버튼을 팝업 버튼으로 변경 및 팝업 스크립트 추가 -->
				<?php if (element('can_update', $result)) { ?>

					<!-- asmo sh 231207 디자인 상 아이콘 display: none 처리 -->
					<a href="javascript:;" class="btn btn-xs btn-default qna_edit_btn" data-cit-id="<?php echo element('cit_id', $view); ?>" data-cqa-id="<?php echo element('cqa_id', $result); ?>" data-page="<?php echo $this->input->get('page'); ?>">
						<i class="dn fa fa-pencil-square-o" aria-hidden="true"></i> 수정
					</a>
				<?php } ?>
				<?php if (element('can_delete', $result)) { ?>

					<!-- asmo sh 231207 디자인 상 아이콘 display: none 처리 -->
					<a href="javascript:;" class="btn btn-xs btn-default" onClick="delete_cmall_qna('<?php echo element('cqa_id', $result); ?>', '<?php echo element('cit_id', $result); ?>', '<?php echo element('page', $view); ?>');"><i class="dn fa fa-trash-o" aria-hidden="true"></i> 삭제</a>

				<?php } ?>
				</div>
			</div>
			<!-- <div class="qa-ans"><div class="bold">답변내용</div> <?php echo (element('cqa_reply_mem_id', $result)) ? element('reply_content', $result) : '답변 대기중입니다.';?></div> -->

			<?php if (element('cqa_reply_mem_id', $result)){ ?>
				<div class="qa-ans"><div class="bold">답변내용</div><p><?php echo (element('reply_content', $result))?></p></div>

			<?php } ?>
			
		</div>
	</div>
<?php
	}
}
?>
<nav><?php echo element('paging', $view); ?></nav>


<script>

	// asmo sh 240221 수정 버튼을 팝업 버튼으로 변경 및 팝업 스크립트 추가
    $('.qna_edit_btn').click(function() {
        let citId = $(this).data('cit-id');
        let cqaId = $(this).data('cqa-id');
        let page = $(this).data('page');
        let iframeSrc = '<?php echo site_url('cmall/qna_write/'); ?>' + citId + '/' + cqaId + '?page=' + page;

        $('#qna_write iframe').attr('src', iframeSrc);
        $('#qna_write').css('display', 'block');
    });

    $("#review_write iframe, #qna_write iframe").load(function() {
        let dimCloseBtn = $("#review_write iframe, #qna_write iframe").contents().find(".btn-default");
        let dimSubmitBtn = $("#review_write iframe, #qna_write iframe").contents().find(".btn-primary");

        dimCloseBtn.click(function() {
            $('#review_write').css('display', 'none');
            $('#qna_write').css('display', 'none');
        });
    });
</script>