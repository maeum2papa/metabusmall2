<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css');

$currentUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($currentUrl);
$pathParts = explode('/', $parts['path']);
$user_info = $this->member->item('mem_id');
$companyIdx = $this->member->item('company_idx');
$otherUserId = $_GET[room];

$domain =  "https://".$_SERVER[HTTP_HOST];

if($otherUserId){
	$otherUserId  = base64_decode($otherUserId);
}

if(!$otherUserId || $otherUserId == ''){
	
	$otherUserId = $user_info;
	$otherUserId  = base64_encode($otherUserId);
	
	echo "<script>window.top.location.href = '".$domain."/chat/space?room=".$otherUserId."';</script>";
}

//if (!is_numeric($otherUserId)) {
//	$otherUserId = $user_info;
//	$otherUserId  = base64_encode($otherUserId);
//	echo "<script>window.top.location.href = '$currentUrl/$otherUserId';</script>";
//}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="UTF-8" />
<style>

	header {
		display: none !important;
	}

	.navbar.navbar-default {
		display: none !important;
	}

	/* .sidebar {
		display: none;
	} */

	footer {
		display: none !important;
	}

	/* iframe html body > div:first-child {
		height: 0;
	} */

</style>

<body style="margin:0px;padding:0px;overflow:hidden">

	<iframe id="game" allow="camera *;microphone *; display-capture *" src="https://collaborland.kr:8000/" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;
	height:100%;width:100%;
	position:fixed;
	top:0px;left:0px;right:0px;bottom:0px;border:0px;" height="100%" width="100%">
	</iframe>

	<!-- <div id='box' class="box">
		게임맨
	</div> -->

	<script type="text/javascript">
	
		//let user_info = "?= element('mem_id', $view) ?";
		//let user_info = <?php echo json_encode($user_info) ?>;
		//let otheruserId = <?php echo json_encode($otherUserId); ?>;
		//let company_idx = <?php echo json_encode($companyIdx) ?>;
		//let type = "<?php echo html_escape($this->cbconfig->get_device_view_type()); ?>"

		let iframe = document.getElementById('game');
		let currentSrc = iframe.src;

		//iframe.src = currentSrc + otheruserId;

		let infoToSend = {
			currentUser: 43,
			otherUser: 43,
			room: "myland_outer",
			type:"desktop",
			companyIdx: 1
		};

		iframe.src = "https://collaborland.kr:8000/43?data=%7B%22currentUser%22%3A%2243%22%2C%22otherUser%22%3A%2243%22%2C%22room%22%3A%22myland_outer%22%2C%22type%22%3A%22desktop%22%2C%22companyIdx%22%3A%221%22%7D"
		
		
		//currentSrc + infoToSend.otherUser; //+ `?data=${encodeURIComponent(JSON.stringify(infoToSend))}`;
		
		window.addEventListener('message', (e)=> {
			if (e.data.info === 'onLoad') {				//페이지가 로드 됐다.
				let infoString = JSON.stringify(infoToSend);
				iframe.contentWindow.postMessage({state:"Info", infoString: infoString}, '*');
				iframe.contentWindow.postMessage({state:"sidebar", isOpen: true}, '*');
			} else if(e.data.info === 'pageChange') {	//페이지 이동한다. (다른 룸으로 이동)
				location.href = e.data.href
			} else if(e.data.info === 'preview') {	// 사이드바 프로필 이미지 변경
				let previewImg = document.querySelector(".userInfo_img_wrap img");
				previewImg.src = "<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png" + `?v=${e.data.rand}`;
			} else if(e.data.info === 'fruitCount') {
				let Elecount = document.querySelector('#fruit_count');
				Elecount.innerText = `${e.data.count}`;
			} else if(e.data.info === 'popup') {
				let popup =document.querySelector(`#${e.data.id}`);
				if(popup) {
					popup.style.display = 'block';
				}
			} else if (e.data.info === 'flutter_js_handler') {  //TODO flutter_engine 테스트
				let handlerName = e.data.handler;
				let requestType = e.data.requestType;
				let data = e.data.data;
				if (window.flutter_inappwebview !== undefined) {
					window.flutter_inappwebview.callHandler(handlerName, requestType, data);
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

			document.querySelector("#myland a").classList.add("selected");

			const arrLayerBtn = document.querySelectorAll(".popup_layer_bg button");

			for(let i = 0; i < arrLayerBtn.length; ++i) {
				arrLayerBtn[i].addEventListener("click", () => {
					iframe.focus();
				});
			}
		});
	</script>