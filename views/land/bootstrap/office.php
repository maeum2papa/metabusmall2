<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css');
$currentUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($currentUrl);
$pathParts = explode('/', $parts['path']);
$user_info = $this->member->item('mem_id');
$companyIdx = $this->member->item('company_idx');
?>


<!-- <div style="width: 100%; height: 200px; background-color: #F7B9BA">오피스</div> -->


<!-- <script type="text/javascript">
	// asmo sh 231114 랜딩 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		$('.sidebar').addClass('dn');
		$('footer').addClass('dn');

		$('.main').addClass('add');
	});
</script> -->


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="UTF-8" />
<style>
	header {
		display: none;
	}

	.navbar {
		display: none;
	}

	/* .sidebar {
		display: none;
	} */

	footer {
		display: none !important;
	}
</style>

<body style="margin:0px;padding:0px;overflow:hidden">

	<iframe id="game" allow="camera *;microphone *; display-capture *" src="https://collaborland.kr:8000/" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;
	height:100%;width:100%;
	position:fixed;
	top:0px;left:0px;right:0px;bottom:0px;border:0px;" height="100%" width="100%" frameborder="0" allowfullscreen>
	</iframe>

	<!-- <div id='box' class="box">
		게임맨
	</div> -->

	<script type="text/javascript">


		
		// var user_info = "?= element('mem_id', $view) ?";
		var user_info = <?php echo json_encode($user_info) ?>;
		var company_idx = <?php echo json_encode($companyIdx) ?>;
		var otheruserId = 'office'
		

		var iframe = document.getElementById('game');
		var currentSrc = iframe.src;

		//iframe.src = currentSrc + otheruserId;


		var infoToSend = {
			currentUser: user_info,
			otherUser: otheruserId,
			room: "land_office",			
			companyIdx:company_idx
		};

		iframe.src = currentSrc + otheruserId + `?data=${encodeURIComponent(JSON.stringify(infoToSend))}`;

		window.addEventListener('message', function (e) {
			if (e.data.info === 'onLoad') {				//페이지가 로드 됐다.
				var infoString = JSON.stringify(infoToSend);
				iframe.contentWindow.postMessage({state:"Info", infoString: infoString}, '*');
				iframe.contentWindow.postMessage({state:"sidebar", isOpen: true}, '*');
			} else if(e.data.info === 'pageChange') {	//페이지 이동한다. (다른 룸으로 이동)
				location.href = e.data.href
			} else if(e.data.info === 'preview') {	// 사이드바 프로필 이미지 변경
				var previewImg = document.querySelector(".userInfo_img_wrap img");
				previewImg.src = "<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png" + `?v=${e.data.rand}`;
			} else if(e.data.info === 'fruitCount') {
				var Elecount = document.querySelector('#fruit_count');
				Elecount.innerText = `${e.data.count}`;
			} else if(e.data.info === 'popup') {
				let popup =document.querySelector(`#${e.data.id}`);
				if(popup) {
					popup.style.display = 'block';
				}
			}
		})

		$(document).ready(function () {
			document.getElementById("sidebar_close").addEventListener("click",() => {
				iframe.contentWindow.postMessage({state:"sidebar",isOpen: false}, '*');
			})
			document.getElementById("sidebar_open").addEventListener("click",() => {
				iframe.contentWindow.postMessage({state:"sidebar",isOpen: true}, '*');
			})

			document.querySelector("#officeland a").classList.add("selected");
			
			const arrLayerBtn = document.querySelectorAll(".popup_layer_bg button");

			for(let i = 0; i < arrLayerBtn.length; ++i) {
				arrLayerBtn[i].addEventListener("click", () => {
					iframe.focus();
				});
			}
		});
		
	</script>