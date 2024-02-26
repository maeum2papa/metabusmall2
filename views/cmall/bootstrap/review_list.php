<div class="alert alert-auto-close alert-dismissible alert-cmall-review-list-message" style="display:none;"><button type="button" class="close alertclose">×</button><span class="alert-cmall-review-list-message-content"></span></div>

<?php
$i = 0;
if (element('list', element('data', $view))) {
	foreach (element('list', element('data', $view)) as $result) {
?>
	<div class="product-feedback">
		<div class="review-wr">

			<!-- asmo sh 231207 디자인 상 아이콘 display: none 처리  -->
			<p class="item_review_title col-lg-8" onclick="return review_open(this);"><i class="dn fa fa-comments-o"></i> <?php echo html_escape(element('cre_title', $result)); ?></p>
			<ul class="col-lg-4 review-info">

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
				<li><span class="asmo_dateTime"><?php $datetime = new DateTime(element('cre_datetime', $result)); echo $datetime->format('Y-m-d'); ?></span></li>
				<!-- //asmo sh 240222 작성 시각 Y-m-d로 변경 -->
				
				<?php if (element('cre_score', $result) >=1 && element('cre_score', $result) <=5) { ?>
					<li><span class="sd-only">평점</span> <img src="<?php echo element('view_skin_url', $view); ?>/images/star<?php echo element('cre_score', $result); ?>.png" alt="평점" title="평점" /></li>
				<?php } ?>
			</ul>
		</div>
		<div class="feedback-box review-content">
			<?php echo element('content', $result); ?>

			<!-- asmo sh 231207 수정, 삭제 버튼 감싸는 div.button_box_wrap 생성 -->
			<div class="button_box_wrap">

			<!-- asmo sh 240221 수정 버튼을 팝업 버튼으로 변경 및 팝업 스크립트 추가 -->
				<?php if (element('can_update', $result)) { ?>
					<!-- asmo sh 231207 디자인 상 아이콘 display: none 처리 -->
					<a href="javascript:;" class="btn btn-xs btn-default review_edit_btn" data-cit-id="<?php echo element('cit_id', $view); ?>" data-cre-id="<?php echo element('cre_id', $result); ?>" data-page="<?php echo $this->input->get('page'); ?>">
        				<i class="dn fa fa-pencil-square-o" aria-hidden="true"></i> 수정
    				</a>
				<?php } ?>
				<?php if (element('can_delete', $result)) { ?>
					<!-- asmo sh 231207 디자인 상 아이콘 display: none 처리 -->
					<a href="javascript:;" class="btn btn-xs btn-default" onClick="delete_cmall_review('<?php echo element('cre_id', $result); ?>', '<?php echo element('cit_id', $result); ?>', '<?php echo element('page', $view); ?>');"><i class="dn fa fa-trash-o" aria-hidden="true"></i> 삭제</a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
	}
}
?>
<nav><?php echo element('paging', $view); ?></nav>


<script>

	// asmo sh 240221 수정 버튼을 팝업 버튼으로 변경 및 팝업 스크립트 추가
	$(document).ready(function() {
		$('.review_edit_btn').click(function() {
			let citId = $(this).data('cit-id');
			let creId = $(this).data('cre-id');
			let page = $(this).data('page');
			let iframeSrc = '<?php echo site_url('cmall/review_write/'); ?>' + citId + '/' + creId + '?page=' + page;

			$('#review_write iframe').attr('src', iframeSrc);
			$('#review_write').css('display', 'block');
		});

		$("#review_write iframe, #qna_write iframe").load(function() {
			let dimCloseBtn = $("#review_write iframe, #qna_write iframe").contents().find(".btn-default");
			let dimSubmitBtn = $("#review_write iframe, #qna_write iframe").contents().find(".btn-primary");

			dimCloseBtn.click(function() {
				$('#review_write').css('display', 'none');
				$('#qna_write').css('display', 'none');
			});
		});
	});

	// 마스킹 함수 추가
	function maskText() {
		// itemMall_span 클래스를 가진 요소를 선택합니다.
		var itemMallElements = document.getElementsByClassName("itemMall_span");
		// asmo_sh_writer 클래스를 가진 요소를 선택합니다.
		var asmoWriterElements = document.getElementsByClassName("asmo_sh_writer");

		// 각 요소에 대해 반복하여 텍스트 값을 마스킹합니다.
		for (var i = 0; i < itemMallElements.length; i++) {
			var text = itemMallElements[i].textContent;
			var maskedText = maskString(text);
			itemMallElements[i].textContent = maskedText;
		}

		for (var i = 0; i < asmoWriterElements.length; i++) {
			var text = asmoWriterElements[i].textContent;
			var maskedText = maskString(text);
			asmoWriterElements[i].textContent = maskedText;
		}
	}

	// 문자열을 주어진 비율만큼 마스킹하는 함수
	function maskString(str) {
		// 마스킹할 길이를 계산합니다. (반올림)
		var maskLength = Math.round(str.length / 3);
		// 마스킹할 부분을 "*"로 채웁니다.
		var maskedPart = "*".repeat(maskLength);
		// 뒤에서부터 마스킹할 길이까지의 문자열을 마스킹된 문자열로 대체합니다.
		return str.substring(0, str.length - maskLength) + maskedPart;
	}

	// 함수 호출
	maskText();


</script>