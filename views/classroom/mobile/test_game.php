<?php
$currentUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($currentUrl);
$pathParts = explode('/', $parts['path']);
$user_info = $this->member->item('mem_id');
$companyIdx = $this->member->item('company_idx');
$otherUserId = end($pathParts);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="UTF-8" />
<style>
	header {
		display: none;
	}

	/* .sidebar {
		display: none;
	} */

	footer {
		display: none !important;
	}

	/* .navbar {
		transition: all .3s ease;
		top : 0;
	}
	.navbar.down {
		top: -40px;
	}

	#asmo_fixed_bar {
		transition: all 0.3s ease;
	}
	#asmo_fixed_bar.down {
		bottom: -45px;
	} */

</style>



<body style="margin:0px;padding:0px;overflow:hidden">



<iframe id="game" src="https://collaborland.kr:8000/" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;
	height:100%;width:100%;						
	position:fixed;
	top:0px;left:0px;right:0px;bottom:0px;border:0px;" height="100%" width="100%">
				</iframe>

	<!-- <div id="asmo_classroom"> -->
		<!-- <div id="asmo_classroom_myClass"> -->
			<!-- <div class="myClass_wrap"> -->
				<!-- <div id="testvideo" style="width:1080px; height: 500px;"> -->
				
			<!-- </div> -->
				<!-- position:relative; -->
			<!-- </div> -->
		<!-- </div> -->
	<!-- </div> -->

	

	<script type="text/javascript">
		

		//var user_info = "?= element('mem_id', $view) ?";
		var user_info = <?php echo json_encode($user_info) ?>;
		var otheruserId = <?php echo json_encode($otherUserId); ?>;
		var company_idx = <?php echo json_encode($companyIdx) ?>;
		var type = "<?php echo html_escape($this->cbconfig->get_device_view_type()); ?>"

		var mps_snoUrl = <?php echo json_encode($currentUrl) ?>;
		const startIndex = mps_snoUrl.indexOf("mps_sno=") + 1;
		const mps_sub = mps_snoUrl.substring(startIndex,mps_snoUrl.length);
		const masIndex = mps_sub.indexOf('=') + 1;
		const mps_sno = mps_sub.substring(masIndex,mps_sub.length);
		var iframe = document.getElementById('game');
		var currentSrc = iframe.src;

		//iframe.src = currentSrc + otheruserId;

		var infoToSend = {
			currentUser: user_info,
			otherUser: otheruserId,
			room: "gameeducation",
			companyIdx: company_idx,
			type:type,
			mps_sno:mps_sno
		};

		iframe.src = currentSrc + otheruserId + `?data=${encodeURIComponent(JSON.stringify(infoToSend))}`;

		window.addEventListener('message', (e) => {
			if (e.data.info === 'onLoad') {				//페이지가 로드 됐다.
				var infoString = JSON.stringify(infoToSend);
				iframe.contentWindow.postMessage({ state: "Info", infoString: infoString }, '*');
				iframe.contentWindow.postMessage({ state: "sidebar", isOpen: true }, '*');
			} else if (e.data.info === 'pageChange') {	//페이지 이동한다. (다른 룸으로 이동)
				location.href = e.data.href
			} else if (e.data.info === 'preview') {	// 사이드바 프로필 이미지 변경
				var previewImg = document.querySelector(".userInfo_img_wrap img");
				previewImg.src = "<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png" + `?v=${e.data.rand}`;
			} else if (e.data.info === 'fruitCount') {
				var Elecount = document.querySelector('#fruit_count');
				Elecount.innerText = `${e.data.count}`;
			 } //else if(e.data.info === 'mobileShow') {
			// 	//isShow
			// 	if(e.data.isShow) {
			// 		document.querySelector(".navbar").classList.remove('down');
			// 		document.querySelector("#asmo_fixed_bar").classList.remove('down');
			// 	} else {
			// 		document.querySelector(".navbar").classList.add('down');
			// 		document.querySelector("#asmo_fixed_bar").classList.add('down');
			// 	} 
			// }
		})

		// asmo sh 231114 랜딩 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
		$(document).ready(function () {
			// document.querySelector(".navbar").classList.add('down');
			// document.querySelector("#asmo_fixed_bar").classList.add('down');

			// $('header').addClass('dn');
			// $('.navbar').addClass('dn');
			// $('.sidebar').addClass('dn');
			// $('footer').addClass('dn');

			//$('.main').addClass('add');

			// 클래스룸 페이지일 때 사이드바 메뉴 활성화
			//$('#classroom a').addClass('selected');
		});
	</script>