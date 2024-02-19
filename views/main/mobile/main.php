<?php
// if (element('board_list', $view)) {
// 	foreach (element('board_list', $view) as $key => $board) {
// 		$config = array(
// 			'skin' => 'mobile',
// 			'brd_key' => element('brd_key', $board),
// 			'limit' => 5,
// 			'length' => 40,
// 			'is_gallery' => '',
// 			'image_width' => '',
// 			'image_height' => '',
// 			'cache_minute' => 1,
// 		);
// 		echo $this->board->latest($config);
// 	}
// }
?>

<style>
	/* 푸터 미노출 처리 */
	footer { display:none; }
</style>

<!-- 랜딩 페이지 시작 -->
<div id="landing_page">
	<h1>랜딩페이지 입니다.</h1>


	<?php
	if ($this->member->is_member()) {
	?>
		<a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>" title="로그아웃">로그아웃</a>
	<?php
	}else{
	?>

	<a href="https://collaborland.kr/login">로그인</a>
	<?php
	}
	?>	
</div>
