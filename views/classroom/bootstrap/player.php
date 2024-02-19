
<style>
	header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	} 

	body {
		background: linear-gradient(160deg, #333 11%, #222 42.7%, #000 75%);
		background-attachment: fixed;
		color: #fff;
	}

	footer .container {
		background: transparent;
	}

	footer .container .company_info_box .company_info b {
		display: block;
		margin: 0 0 20px;
		font-size: 1.6rem;
		color: #fff;
	}

	footer .container .company_info_box .company_info span {
		font-size: 1.6rem;
		color: #fff;
	}
</style> 

<div class="asmo_classroom">
	<div id="asmo_classroom_player">
		<section class="video_top">
			<a href="">강의실 나가기</a>
		</section>
		<section class="video_sect">
			<video id="video" src="https://v1.collaborland.kr:8443/<?=$my_process[video_url]?>" disablepictureinpicture controls controlsList="noplaybackrate nodownload nofullscreen " ></video>
		</section>

		<!-- <section>
			<div class="playbackRate">
				<button type="button" id="speed08" class="jump-speed btn" data-speed="0.8">배속 0.8</button>
				<button type="button" id="speed10" class="jump-speed btn" data-speed="1.0">배속 1.0</button>
				<button type="button" id="speed12" class="jump-speed btn" data-speed="1.2">배속 1.2</button>
				<button type="button" id="speed15" class="jump-speed btn" data-speed="1.5">배속 1.5</button>
			</div>
		</section> -->

		<!-- <section class="video_timeline">
			<div id="video_timeline_wrap" style="background-color: gray;height: 30px;">
				<div id="video_timeline_blue" style="background-color: blue;height: 15px;width: 0%"></div>
				<div id="video_timeline_red" style="background-color: red;height: 15px;width: 0%"></div>
			</div>
		</section> -->

		<section class="video_info">
			<div class="video_info_top">
				<div class="video_period">
					<p><?=$my_process[view_time]?></p>
				</div>
				

				<div class="video_title">
					<strong><?=$my_process[p_title]?></strong>
					<div class="video_ctg">
					<?php foreach (element('list', $category) as $k => $v){?>
						<span><?=$v[cca_value]?></span>
					<?php } ?>
				</div>
				</div>
				
				<p class="video_subtitle"><?=$my_process[p_subtitle]?></p>
			</div>

			<div class="video_jump_speed_btn_wrap">
				<button type="button" id="speed08" class="jump-speed btn" data-speed="0.8">배속0.8</button>
				<button type="button" id="speed10" class="jump-speed btn active" data-speed="1.0">배속1.0</button>
				<button type="button" id="speed12" class="jump-speed btn" data-speed="1.2">배속1.2</button>
				<button type="button" id="speed15" class="jump-speed btn" data-speed="1.5">배속1.5</button>
			</div>

			<div class="video_info_enroll_rate">
				<span>수강률</span>

				<div id="video_timeline_wrap" class="enroll_rate_bar">
					<div id="video_timeline_blue" class="enroll_rate_bar_fill"></div>
					<div id="video_timeline_red"></div>
				</div>

				<!-- <div class="enroll_rate_bar">
					<div class="enroll_rate_bar_fill" style="width: <?=$my_process[mp_percent]?>%;"></div>
				</div> -->

				<!-- <span id="enroll_rate"><?=$my_process[mp_percent]?></span>% -->
			</div>

			<div class="video_info_tab">
				<div class="tab_button_wrap">
					<button class="tab_button selected" data-tab="tab1">
						<strong>커리큘럼</strong>
					</button>
					<button class="tab_button" data-tab="tab2">
						<strong>강사소개</strong>
					</button>
					<button class="tab_button" data-tab="tab3">
						<strong>강의자료</strong>
					</button>

					<div id="tab_button_underLine"></div>
				</div>

				<div class="tab_contents_wrap">
					<div class="tab_contents tab1 selected">
						<?php foreach (element('list', $curriculum) as $k => $v){?>
						<div class="tab_content <?=$v[active]?>">
							<span>섹션 <?=$k?>. <?=$v[title]?></span>
							
							<!-- <?php if($v[moveYn] == 'y' && $v[moveUrl] != 'n'){ //이동가능일때 링크를 걸어줄 수 있음?>
							<span class="asmo_tab_content"><a href="<?=$v[moveUrl]?>" >이동하기</a></span>
							<?php } ?>
							<?php if($v[mps_endYn] == 'y'){?>
							<span class="asmo_tab_content">진행완료</span>
							<?php } ?> -->


							<!-- 240215 컬래버랜드 시연 일정으로 asmo_tab_content 미노출 처리 -->
							<!-- 진행예정일 때 -->
							<span class="asmo_tab_content">진행예정</span> 

							<!-- 진행중일 때 -->
							<span class="asmo_tab_content active">진행중</span> 

							<!-- 진행완료 및 이동가능할때 -->
							<span class="asmo_tab_content complete"><a href="<?=$v[moveUrl]?>" >진행완료</a></span> 
							<!-- //240215 컬래버랜드 시연 일정으로 asmo_tab_content 미노출 처리 -->

						</div>
						<?php } ?>
					</div>

					<div class="tab_contents tab2">
						<div id="post-content"><?=$my_process[p_teacher]?></div>
					</div>

					<div class="tab_contents tab3 ">

						<div class="tab_down_content">
							<p>피피티 실습 예제 자료.zip</p>
							<a href='' download="">다운로드</a>
						</div>

<!--
						<a href='' download="" class="tab_down_content">

							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<g id="file_icon" opacity="0.4">
									<rect id="사각형_3889" data-name="사각형 3889" width="24" height="24" fill="#222" opacity="0"/>
									<rect id="사각형_3890" data-name="사각형 3890" width="18" height="18" transform="translate(3 3)" fill="#222" opacity="0"/>
									<path id="패스_1183" data-name="패스 1183" d="M-19419-7554.5a2.006,2.006,0,0,1-2-2v-8c0-.044.006-.083.006-.126V-7565h-.006v-3a2.006,2.006,0,0,1,2-2h4.406a1.837,1.837,0,0,1,1.891,1h7.7a2,2,0,0,1,2,2v1.5h.006v2h-.006v7a2,2,0,0,1-2,2Zm-.512-9.343h.01v7.345a.5.5,0,0,0,.5.5h14a.5.5,0,0,0,.5-.5v-8a.5.5,0,0,0-.5-.5h-6.809c.01,0,.01-.01.01-.01s-.006,0-.049,0h-.035c-.861,0-1.311-1.365-1.4-1.638v0h-.014l-.3-.75-.049-.107-.029-.068a3.786,3.786,0,0,0-.463-.863,1.116,1.116,0,0,0-.453-.054H-19419a.5.5,0,0,0-.5.5v1.141h-.01Zm8.086-2.656h6.926v-.5a.5.5,0,0,0-.5-.5h-6.926Z" transform="translate(19423.996 7574.25)" fill="#222"/>
								</g>
							</svg>


							<p>강의 영상 자료.zip</p>

							<span>Download</span>
						</a>

						<a  href='' download="" class="tab_down_content">

							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<g id="file_icon" opacity="0.4">
									<rect id="사각형_3889" data-name="사각형 3889" width="24" height="24" fill="#222" opacity="0"/>
									<rect id="사각형_3890" data-name="사각형 3890" width="18" height="18" transform="translate(3 3)" fill="#222" opacity="0"/>
									<path id="패스_1183" data-name="패스 1183" d="M-19419-7554.5a2.006,2.006,0,0,1-2-2v-8c0-.044.006-.083.006-.126V-7565h-.006v-3a2.006,2.006,0,0,1,2-2h4.406a1.837,1.837,0,0,1,1.891,1h7.7a2,2,0,0,1,2,2v1.5h.006v2h-.006v7a2,2,0,0,1-2,2Zm-.512-9.343h.01v7.345a.5.5,0,0,0,.5.5h14a.5.5,0,0,0,.5-.5v-8a.5.5,0,0,0-.5-.5h-6.809c.01,0,.01-.01.01-.01s-.006,0-.049,0h-.035c-.861,0-1.311-1.365-1.4-1.638v0h-.014l-.3-.75-.049-.107-.029-.068a3.786,3.786,0,0,0-.463-.863,1.116,1.116,0,0,0-.453-.054H-19419a.5.5,0,0,0-.5.5v1.141h-.01Zm8.086-2.656h6.926v-.5a.5.5,0,0,0-.5-.5h-6.926Z" transform="translate(19423.996 7574.25)" fill="#222"/>
								</g>
							</svg>


							<p>피피티 실습 예제 자료입니다. 피피티 실습 예제 자료입니다. 피피티 실습 예제 자료입니다. 피피티 실습 예제 자료입니다. 피피티 실습 예제 자료입니다. 피피티 실습 예제 자료입니다. 피피티 실습 예제 자료입니다.피피티 실습 예제 자료입니다.피피티 실습 예제 자료입니다.</p>

							<span>Download</span>
						</a>

						<a href='' download="" class="tab_down_content">

							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<g id="file_icon" opacity="0.4">
									<rect id="사각형_3889" data-name="사각형 3889" width="24" height="24" fill="#222" opacity="0"/>
									<rect id="사각형_3890" data-name="사각형 3890" width="18" height="18" transform="translate(3 3)" fill="#222" opacity="0"/>
									<path id="패스_1183" data-name="패스 1183" d="M-19419-7554.5a2.006,2.006,0,0,1-2-2v-8c0-.044.006-.083.006-.126V-7565h-.006v-3a2.006,2.006,0,0,1,2-2h4.406a1.837,1.837,0,0,1,1.891,1h7.7a2,2,0,0,1,2,2v1.5h.006v2h-.006v7a2,2,0,0,1-2,2Zm-.512-9.343h.01v7.345a.5.5,0,0,0,.5.5h14a.5.5,0,0,0,.5-.5v-8a.5.5,0,0,0-.5-.5h-6.809c.01,0,.01-.01.01-.01s-.006,0-.049,0h-.035c-.861,0-1.311-1.365-1.4-1.638v0h-.014l-.3-.75-.049-.107-.029-.068a3.786,3.786,0,0,0-.463-.863,1.116,1.116,0,0,0-.453-.054H-19419a.5.5,0,0,0-.5.5v1.141h-.01Zm8.086-2.656h6.926v-.5a.5.5,0,0,0-.5-.5h-6.926Z" transform="translate(19423.996 7574.25)" fill="#222"/>
								</g>
							</svg>


							<p>강의 영상 자료.zip</p>

							<span>Download</span>

						</a>-->
					</div>
				</div>
			</div>

		</section>
	</div>
</div>
<div id="versionMap" class="line"></div>
<script src="/assets/js/promise-polyfill.js"></script>
<script src="/assets/js/devtools-detector.js"></script>
<script type="text/javascript">
	const intervalID = setInterval(myCallback, 10000, "<?=$this->member->item('mem_id')?>");

	function myCallback(mem_id,mem_login_chk) {
		$.ajax({
			method: "POST",
			url: "/classroom/chk",
			data: {
				mem_id: mem_id,
				csrf_test_name : cb_csrf_hash
			},
		}).success(function(data){
			var json = $.parseJSON(data);
			console.log(json);
			var json_code = json.code;
			if(json_code == 'n'){
				if(confirm("중복 로그인이 감지되었습니다. ")){
					location.href = "/login/logout";
				}else{
					location.href = "/login/logout";
				}
				
			}else if(json_code == 's'){
				alert('브라우저내의 중복입니다.'); 
				location.href = "/classroom";
			}
			console.log(json_code);
		}).error(function(e){
			var rurl = "/login/logout";
			if(confirm("서버와 연결에 실패하였습니다.. ")){
				location.href = rurl;
			}else{
				location.href = rurl;
			}
		});
	}

	const video = document.getElementById('video');
	let hasFuncExcuted = false;
	let videoEnded = false;

	// 수강률 불러오기
	const timingWrap = document.getElementById('video_timeline_wrap');
	const timing = document.getElementById('video_timeline_blue');
	video.addEventListener('loadedmetadata', function(){
		var loadendfl = '<?=$timeline['list'][0]['mps_endYn'];?>';
		var loadtimeline = '<?=$timeline['list'][0]['mps_timeline'];?>';
		if(loadendfl == 'y'){
			var timeline = 100;
		} else {
			var timeline = loadtimeline * 60 / parseInt(video.duration) * 100;
		}
		
		$('#video_timeline_blue').css('width', timeline+'%');

		timing.addEventListener('click', (e)=>{
			var per = e.offsetX / timingWrap.clientWidth * 100;
			$('#video_timeline_red').css('width', per+'%');
			video.pause();
			video.currentTime = e.offsetX / timingWrap.clientWidth * parseInt(video.duration);
			supposedCurrentTime = e.offsetX / timingWrap.clientWidth * parseInt(video.duration);

			var timer = setInterval(function() {
				if (video.paused && video.readyState ==4 || !video.paused) {
					video.play();
					clearInterval(timer);
				}       
			}, 50);	
		});
	});

	video.ontimeupdate = () => {
		if (!hasFuncExcuted && video.currentTime > 0) {
			console.log('비디오 시작');
			hasFuncExcuted = true;
			videoEnded = false;

			$.ajax({
				method: "POST",
				url: "/classroom/setStartDt",
				data: {
					mode: 'setStartDt',
					mem_id: <?=$this->member->item('mem_id');?>,
					csrf_test_name : cb_csrf_hash
				},
			}).success(function(data){
				var json = $.parseJSON(data);
			}).error(function(e){
				console.log(e.responseText);
			});
		}
	};
	
	$(document).ready(function() {
		$('.main').addClass('add');

		let crTab_underline = $("#tab_button_underLine");
		let crTab = $(".tab_button");

		crTab.each(function() {
			$(this).on("click", function(e) {
				horizontalIndicator(e);

				$('.tab_button').removeClass('selected');
				$(this).addClass('selected');

				$('.tab_contents').removeClass('selected');
				$('.tab_contents').eq($(this).index()).addClass('selected');
			});
		});

		function horizontalIndicator(e) {
			crTab_underline.css("left", $(e.currentTarget).position().left + "px");
			crTab_underline.css("width", $(e.currentTarget).outerWidth() + "px");
			// crTab_underline.css("top", $(e.currentTarget).offset().top + $(e.currentTarget).outerHeight() + "px");
		}

		// 클래스룸 페이지일 때 사이드바 메뉴 활성화
		$('#classroom').addClass('selected');


		// 배속 버튼 클릭 시 배속 변경 class 토글
		$('.video_jump_speed_btn_wrap button').click(function() {
			$('.video_jump_speed_btn_wrap button').removeClass('active');
			$(this).addClass('active');
		});
	
		let supposedCurrentTime = 0;

		$('.jump-speed').click(function(){
			video.pause();
			video.playbackRate = $(this).data('speed');
			video.play();
		});

		var currentPos = null;

		video.addEventListener('timeupdate', function() {
			if (!video.seeking) {
				supposedCurrentTime = video.currentTime;
			}

			var prevTime = parseInt(video.currentTime); // 현재 재생시간(초) = 영상재생시간 / 영상배속
			if(currentPos == prevTime){
				return;
			} else {
				currentPos = prevTime;
			}
			var maxduration = parseInt(video.duration); // 총 재생시간(초)
			var percentage = 100 * currentPos / maxduration; // 영상 진행률
			$('#video_timeline_red').css('width', percentage+'%');
			var minute = Math.floor(currentPos / 60); // 현재 재생시간(분)

			timing.addEventListener('click', (e)=>{
				var per = e.offsetX / timingWrap.clientWidth * 100;
				console.log(per);
				$('#video_timeline_red').css('width', per+'%');
				video.pause();
				video.currentTime = e.offsetX / timingWrap.clientWidth * parseInt(video.duration);
				supposedCurrentTime = e.offsetX / timingWrap.clientWidth * parseInt(video.duration);

				var timer = setInterval(function() {
					if (video.paused && video.readyState ==4 || !video.paused) {
						video.play();
						clearInterval(timer);
					}       
				}, 50);	
			});

			// 현재 재생시간을 60으로 나눴을 때 나머지값이 없이 딱 떨어지는 경우 => 분
			if(Math.floor(currentPos % 60) === 0){
				if(minute > 0){
					// console.log(minute);
					$.ajax({
						method: "POST",
						url: "/classroom/setPlayerTime",
						data: {
							mode: 'chkPlayTime',
							mps_sno : '<?=$my_process[mps_sno]?>',
							mps_sectionTime: minute,
							maxduration : maxduration,
							playbackRate : video.playbackRate, 
							csrf_test_name : cb_csrf_hash
						},
					}).success(function(data){
						var json = $.parseJSON(data);
					}).error(function(e){
						console.log(e.responseText);
					});
				}		
			}

			if(percentage >= timing.clientWidth / timingWrap.clientWidth * 100){
				$('#video_timeline_blue').css('width', percentage+'%');
			}

			// 영상 90% 이상 시청 시 완료처리
			if(currentPos >= parseInt(maxduration * 0.9)){
				$.ajax({
					method: "POST",
					url: "/classroom/getEndYn",
					data: {
						mode: 'chkEndYn',
						mps_sno : '<?=$my_process[mps_sno]?>',
						maxduration : maxduration,
						csrf_test_name : cb_csrf_hash
					},
				}).success(function(data){
					var json = $.parseJSON(data);
					if(json.endfl == 'n' && currentPos / video.playbackRate >= parseInt(maxduration * 0.9)){
						$.ajax({
							method: "POST",
							url: "/classroom/setPlayerComplete",
							data: {
								mode: 'chkPlayComplete',
								mps_sno : '<?=$my_process[mps_sno]?>',
								mps_endYn: 'y',
								csrf_test_name : cb_csrf_hash
							},
						}).success(function(data){
							var json = $.parseJSON(data);
						}).error(function(e){
							console.log(e.responseText);
						});
					}
				}).error(function(e){
					console.log(e.responseText);
				});
				
			}

			// 100% 가 되면 남은 초만 저장
			if(currentPos == maxduration){
				$.ajax({
					method: "POST",
					url: "/classroom/setPlayerEnd",
					data: {
						mode: 'chkPlayEnd',
						mps_sno : '<?=$my_process[mps_sno]?>',
						remainTime: Math.floor((maxduration % 60) / video.playbackRate),
						csrf_test_name : cb_csrf_hash
					},
				}).success(function(data){
					var json = $.parseJSON(data);
				}).error(function(e){
					console.log(e.responseText);
				});
			}

		});

		
		video.addEventListener('seeking', function() {
			var delta = video.currentTime - supposedCurrentTime;
			if (Math.abs(delta) > 0.01) {
				console.log("Seeking is disabled");
				video.currentTime = supposedCurrentTime;
			}

			timing.addEventListener('click', (e)=>{
				var per = e.offsetX / timingWrap.clientWidth * 100;
				console.log(per);
				$('#video_timeline_red').css('width', per+'%');
				video.pause();
				video.currentTime = e.offsetX / timingWrap.clientWidth * parseInt(video.duration);
				supposedCurrentTime = e.offsetX / timingWrap.clientWidth * parseInt(video.duration);

				var timer = setInterval(function() {
					if (video.paused && video.readyState ==4 || !video.paused) {
						video.play();
						clearInterval(timer);
					}       
				}, 50);	
			});
		});

		$(window).on('unload',function(){
			var currentPos = parseInt(video.currentTime / video.playbackRate); // 현재 재생시간(초)
			var minute = Math.floor(currentPos / 60); // 현재 재생시간(분)

			if(minute > 0){
				var seconds = Math.floor(currentPos % (60 * minute));
			} else {
				var seconds = currentPos;
			}

			if(currentPos != maxduration){
				$.ajax({
					method: "POST",
					url: "/classroom/setPlayerOut",
					data: {
						mode: 'chkPlayOut',
						mps_sno: '<?=$my_process[mps_sno]?>',
						seconds: seconds,
						csrf_test_name : cb_csrf_hash
					},
				}).success(function(data){
					var json = $.parseJSON(data);
					//console.log(json);
				}).error(function(e){
					console.log(e.responseText);
				});
			}
		});
	});

	video.addEventListener('ended', () => {
		console.log('비디오 끝');
		videoEnded = true;
		//영상 종료시 처리
		$.ajax({
			method: "POST",
			url: "/classroom/endYn",
			data: {
				mode: 'chk',
				mps_sno : '<?=$my_process[mps_sno]?>',
				csrf_test_name : cb_csrf_hash
			},
		}).success(function(data){
			var json = $.parseJSON(data);
			var json_code = json.code;
			if(json_code == 'y'){
				if(confirm("시청이 완료되었습니다. 다음 단계로 이동하시겠습니까?")){
					var rurl = "/classroom/process_ps?mode=v&&mp_sno="+<?=$_GET[mp_sno]?>+"&&mps_sno="+<?=$my_process[mps_sno]?>;
					location.href = rurl;
				}else{
					alert("제출실패");
				}
			}else{
			
			}
			console.log(json);
		}).error(function(e){
			console.log(e.responseText);
		});
	});

	// 다른 탭 갔다가 돌아왔을때 영상이 종료되어있으면 다음 순서 진행
	document.addEventListener('visibilitychange', function(){
		if(document.visibilityState === 'visible' && videoEnded){
			//영상 종료시 처리
			$.ajax({
				method: "POST",
				url: "/classroom/endYn",
				data: {
					mode: 'chk',
					mps_sno : '<?=$my_process[mps_sno]?>',
					csrf_test_name : cb_csrf_hash
				},
			}).success(function(data){
				var json = $.parseJSON(data);
				var json_code = json.code;
				if(json_code == 'y'){
					if(confirm("시청이 완료되었습니다. 다음 단계로 이동하시겠습니까?")){
						var rurl = "/classroom/process_ps?mode=v&&mp_sno="+<?=$_GET[mp_sno]?>+"&&mps_sno="+<?=$my_process[mps_sno]?>;
						location.href = rurl;
					}else{
						alert("제출실패");
					}
				}else{
				
				}
				console.log(json);
			}).error(function(e){
				console.log(e.responseText);
			});
		}
	});
	
	
	var keydownCtrl = 0;
	var keydownShift = 0;


	document.onkeydown=keycheck;
	document.onkeyup=uncheckCtrlShift;


	function keycheck()
	{
		  switch(event.keyCode){ 
			case 123:event.keyCode='';return false; break; //F12
			case 17:event.keyCode='';keydownCtrl=1;return false; break; //컨트롤키
		  }


		  if(keydownCtrl) return false;
	}


	function uncheckCtrlShift()
	{
		  if(event.keyCode==17)      keydownCtrl=0;
		  if(event.keyCode==16)      keydownShift=0;
	}


    // function click(){
    // 	if((event.button==2) || (event.button==2)){
	// 		alert('[마우스 오른쪽 클릭] / [컨트롤] / [F12] 금지 입니다.');
	// 	}
	// }
	// document.onmousedown=click;
	
//	const versionMap = document.getElementById('versionMap');
//
//	 devtoolsDetector.addListener(function (isOpen, detail) {
//	 	console.log('isOpen', isOpen);
//
//	 	if (isOpen) {
//	 		location.href = '/';
//	 	} else {
//	 	}
//	 });
//
//	 devtoolsDetector.launch();

	
</script>