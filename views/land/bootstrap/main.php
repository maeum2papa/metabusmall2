<?php
/*
$k = 0;
$is_open = false;
if (element('board_list', $view)) {
	foreach (element('board_list', $view) as $key => $board) {
		$config = array(
			'skin' => 'bootstrap',
			'brd_key' => element('brd_key', $board),
			'limit' => 5,
			'length' => 40,
			'is_gallery' => '',
			'image_width' => '',
			'image_height' => '',
			'cache_minute' => 1,
		);
		if ($k % 2 === 0) {
			echo '<div class="row">';
			$is_open = true;
		}
		echo $this->board->latest($config);
		if ($k % 2 === 1) {
			echo '</div>';
			$is_open = false;
		}
		$k++;
	}
}
if ($is_open) {
	echo '</div>';
	$is_open = false;
}
*/
?>
<div style="width: 100%; height: 200px; background-color: #F7B9BA">대시보드</div>


<script type="text/javascript">
	// asmo sh 231114 랜딩 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		$('.sidebar').addClass('dn');
		$('footer').addClass('dn');

		$('.main').addClass('add');
	});
</script>