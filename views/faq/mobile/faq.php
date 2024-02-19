<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="asmo_item_detail_wrap" class="asmo_faq_wrap">
	<!-- asmo lhb 231227 타이틀 미노출 -->
	<h3 style="display:none;"><?php echo element('fgr_title', element('faqgroup', $view)); ?></h3>
	<div class="asmo_faq_search_warp">
		<form class="search_box text-center" action="<?php echo current_url(); ?>" onSubmit="return faqSearch(this)">
			<div class="asmo_faq_s_input_wrap">
				<input type="text" name="skeyword" value="<?php echo html_escape($this->input->get('skeyword')); ?>" class="input" placeholder="검색" />
				<button class="" type="submit"></button>
			</div>
		</form>
	</div>

	<script type="text/javascript">
	//<![CDATA[
	function faqSearch(f) {
		var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
		if (skeyword.length < 2) {
			alert('2글자 이상으로 검색해 주세요');
			f.skeyword.focus();
			return false;
		}
		return true;
	}
	//]]>
	</script>

	<?php
	$i = 0;
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
		<div class="table-box">
			<div class="table-heading" id="heading_<?php echo $i; ?>" onclick="return faq_open(this);">
				<em></em><span><?php echo element('title', $result); ?></span>
			</div>
			<div class="table-answer answer" id="answer_<?php echo $i; ?>">
				<!-- br태그만 남기고 나머지 삭제 -->
				<?php echo strip_tags(element('content', $result),'<br>'); ?>
			</div>
		</div>
	<?php
			$i++;
		}
	}
	if ( ! element('list', element('data', $view))) {
	?>
		<div class="table-answer nopost">내용이 없습니다</div>
	<?php
	}
	?>
		<nav><?php echo element('paging', $view); ?></nav>
	<?php
	if ($this->member->is_admin() === 'super') {
	?>
		<div class="text-center mb20">
			<a href="<?php echo admin_url('page/faq'); ?>?fgr_id=<?php echo element('fgr_id', element('faqgroup', $view)); ?>" class="btn btn-black btn-sm" target="_blank" title="FAQ 수정">FAQ 수정</a>
		</div>
	<?php
	}
	?>

</div>

<script type="text/javascript">

//asmo lhb 231218  영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');


//<![CDATA[
function faq_open(el)
{
	var $con = $(el).closest('.table-box').find('.answer');

	if ($con.is(':visible')) {
		$con.slideUp();
		$(el).removeClass('on');
	} else {
		$('.answer:visible').css('display', 'none');
		$con.slideDown();
		$('.table-heading').removeClass('on');
		$(el).addClass('on');
	}
	return false;
}
//]]>
</script>
