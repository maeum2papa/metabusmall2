<?php

?>
<div id="asmo_classroom">
	<div id="asmo_classroom_player">
		<section class="video_sect">
			<video id="video" src="https://v1.collaborland.kr:8443/<?=$my_process[video_url]?>" disablepictureinpicture controls controlsList="noplaybackrate nodownload nofullscreen " ></video>
		</section>

		<section>
			<div class="timeline"></div>
		</section>

		<section class="video_info">
			<div class="video_info_top">
				<div class="video_category">
					<?php foreach (element('list', $category) as $k => $v){?>
					<span><?=$v[cca_value]?></span>
					<?php } ?>
				</div>

				<div class="video_title">
					<strong><?=$my_process[p_title]?></strong>
					<p><?=$my_process[p_subtitle]?></p>
				</div>

				<div class="video_period">
					<p><?=$my_process[view_time]?></p>
				</div>
			</div>

			<div class="video_info_enroll_rate">
				<span>수강률</span>

				<div class="enroll_rate_bar">
					<div class="enroll_rate_bar_fill" style="width: <?=$my_process[mp_percent]?>%;"></div>
				</div>

				<span id="enroll_rate"><?=$my_process[mp_percent]?></span>%
			</div>

			<div class="video_info_tab">
				<div class="tab_button_wrap">
					<button class="tab_button selected" data-tab="tab1">
						<strong>커리큘럼</strong>

						<svg id="tap_arrow_icon" data-name="tap arrow_icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
							<rect id="사각형_3874" data-name="사각형 3874" width="18" height="18" fill="#00a8fa" opacity="0"/>
							<rect id="사각형_3875" data-name="사각형 3875" width="12" height="12" transform="translate(3 3)" fill="#00a8fa" opacity="0"/>
							<path id="패스_1182" data-name="패스 1182" d="M6.422.319a.524.524,0,0,1,.711,0l5.475,5.054a.524.524,0,0,1-.356.91H1.3a.524.524,0,0,1-.356-.91Z" transform="translate(15.777 12.283) rotate(180)" fill="#00a8fa"/>
						</svg>

					</button>
					<button class="tab_button" data-tab="tab2">
						<strong>강사소개</strong>

						<svg id="tap_arrow_icon" data-name="tap arrow_icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
							<rect id="사각형_3874" data-name="사각형 3874" width="18" height="18" fill="#00a8fa" opacity="0"/>
							<rect id="사각형_3875" data-name="사각형 3875" width="12" height="12" transform="translate(3 3)" fill="#00a8fa" opacity="0"/>
							<path id="패스_1182" data-name="패스 1182" d="M6.422.319a.524.524,0,0,1,.711,0l5.475,5.054a.524.524,0,0,1-.356.91H1.3a.524.524,0,0,1-.356-.91Z" transform="translate(15.777 12.283) rotate(180)" fill="#00a8fa"/>
						</svg>

					</button>
					<button class="tab_button" data-tab="tab3">
						<strong>강의자료</strong>

						<svg id="tap_arrow_icon" data-name="tap arrow_icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
							<rect id="사각형_3874" data-name="사각형 3874" width="18" height="18" fill="#00a8fa" opacity="0"/>
							<rect id="사각형_3875" data-name="사각형 3875" width="12" height="12" transform="translate(3 3)" fill="#00a8fa" opacity="0"/>
							<path id="패스_1182" data-name="패스 1182" d="M6.422.319a.524.524,0,0,1,.711,0l5.475,5.054a.524.524,0,0,1-.356.91H1.3a.524.524,0,0,1-.356-.91Z" transform="translate(15.777 12.283) rotate(180)" fill="#00a8fa"/>
						</svg>

					</button>
				</div>

				<div class="tab_contents_wrap">
					<div class="tab_contents tab1 selected">
						<?php foreach (element('list', $curriculum) as $k => $v){?>
						<div class="tab_content <?=$v[active]?>">
							<span>섹션 <?=$k?>. <?=$v[title]?></span>
						</div>
						<?php } ?>
					</div>

					<div class="tab_contents tab2">
						<div id="post-content"><?=$my_process[p_teacher]?></div>
					</div>

					<div class="tab_contents tab3 ">
						<a href='' download="" class="tab_down_content">

							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<g id="file_icon" opacity="0.4">
									<rect id="사각형_3889" data-name="사각형 3889" width="24" height="24" fill="#222" opacity="0"/>
									<rect id="사각형_3890" data-name="사각형 3890" width="18" height="18" transform="translate(3 3)" fill="#222" opacity="0"/>
									<path id="패스_1183" data-name="패스 1183" d="M-19419-7554.5a2.006,2.006,0,0,1-2-2v-8c0-.044.006-.083.006-.126V-7565h-.006v-3a2.006,2.006,0,0,1,2-2h4.406a1.837,1.837,0,0,1,1.891,1h7.7a2,2,0,0,1,2,2v1.5h.006v2h-.006v7a2,2,0,0,1-2,2Zm-.512-9.343h.01v7.345a.5.5,0,0,0,.5.5h14a.5.5,0,0,0,.5-.5v-8a.5.5,0,0,0-.5-.5h-6.809c.01,0,.01-.01.01-.01s-.006,0-.049,0h-.035c-.861,0-1.311-1.365-1.4-1.638v0h-.014l-.3-.75-.049-.107-.029-.068a3.786,3.786,0,0,0-.463-.863,1.116,1.116,0,0,0-.453-.054H-19419a.5.5,0,0,0-.5.5v1.141h-.01Zm8.086-2.656h6.926v-.5a.5.5,0,0,0-.5-.5h-6.926Z" transform="translate(19423.996 7574.25)" fill="#222"/>
								</g>
							</svg>


							<p>강의 자료 준비중입니다.</p>

							<span>Download</span>
						</a>

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
-->
						</a>
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


	const video = document.getElementById('video');
	let hasFuncExcuted = false;

	video.ontimeupdate = () => {
		if (!hasFuncExcuted && video.currentTime > 0) {
			console.log('비디오 시작');
			hasFuncExcuted = true;
			
			// 구간 시간 초기화
			$.ajax({
				method: "POST",
				url: "/classroom_test/setPlayerStart",
				data: {
					mode: 'chkPlayStart',
					mps_sno : '31',
					maxduration : parseInt(video.duration),
					csrf_test_name : cb_csrf_hash
				},
			}).success(function(data){
				var json = $.parseJSON(data);
				//console.log(json);
			}).error(function(e){
				console.log(e.responseText);
			});
		}
	};
	
	video.addEventListener('ended', () => {
		console.log('비디오 끝');
	});

	// asmo sh 231114 랜딩 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		// $('.sidebar').addClass('dn');
		// $('footer').addClass('dn');

		$('.main').addClass('add');


		// 탭메뉴 스크립트
		$('.tab_button').click(function() {
			$('.tab_button').removeClass('selected');
			$(this).addClass('selected');

			$('.tab_contents').removeClass('selected');
			$('.tab_contents').eq($(this).index()).addClass('selected');
		});

		// 클래스룸 페이지일 때 사이드바 메뉴 활성화
		$('#classroom a').addClass('selected');

		let supposedCurrentTime = 0;

		$('.jump-time').click(function(){
			video.pause();
			video.currentTime = parseInt($(this).data('time')) * 60;
			supposedCurrentTime = parseInt($(this).data('time')) * 60;
			
			var timer = setInterval(function() {
				if (video.paused && video.readyState ==4 || !video.paused) {
					video.play();
					clearInterval(timer);
				}       
			}, 50);	
		});

		video.addEventListener('timeupdate', function() {
			if (!video.seeking) {
				supposedCurrentTime = video.currentTime;
			}

			var currentPos = parseInt(video.currentTime); // 현재 재생시간(초)
			var maxduration = parseInt(video.duration); // 총 재생시간(초)
			var percentage = 100 * currentPos / maxduration; // 영상 진행률
			var minute = Math.floor(currentPos / 60); // 현재 재생시간(분)

			// $('.time_bar').css('width', percentage + '%');

			// if(minute > 0){
			// 	$('.time_now').html(minute + '분 ' + Math.floor(currentPos % (60 * minute)) + '초');
			// } else {
			// 	$('.time_now').html(minute + '분 ' + Math.floor(currentPos % 60) + '초');
			// }

			// 현재 재생시간을 60으로 나눴을 때 나머지값이 없이 딱 떨어지는 경우 => 분
			if(Math.floor(currentPos % 60) === 0){
				if(minute > 0){
					// console.log(minute);
					$.ajax({
						type: "POST",
						url: "/classroom_test/setPlayerTime",
						data: {
							mode: 'chkPlayTime',
							mps_sno : '31',
							mps_sectionTime: minute,
							maxduration : maxduration,
							csrf_test_name : cb_csrf_hash
						},
					}).success(function(data){
						var json = $.parseJSON(data);
						//console.log(json);
						if(json.code == 'ok'){
							//console.log($('#jump'+minute).length);
							if($('#jump'+minute).length == 0){
								var html = "";
								html += "<button type='button' id='jump"+minute+"' class='jump-time btn' data-time='"+minute+"'>"+minute+"분</button>";
								$('.timeline').append(html);
								$('.jump-time').click(function(){
									video.pause();
									video.currentTime = parseInt($(this).data('time')) * 60;
									supposedCurrentTime = parseInt($(this).data('time')) * 60;
									
									var timer = setInterval(function() {
										if (video.paused && video.readyState ==4 || !video.paused) {
											video.play();
											clearInterval(timer);
										}       
									}, 50);	
								});
								
							}
						}
					}).error(function(e){
						console.log(e.responseText);
					});
				}		
			}

			// 영상 90% 이상 시청 시 완료처리
			if(percentage == 90){
				$.ajax({
					type: "POST",
					url: "/classroom_test/setPlayerComplete",
					data: {
						mode: 'chkPlayComplete',
						mps_sno : '31',
						mps_endYn: 'y',
						csrf_test_name : cb_csrf_hash
					},
				}).success(function(data){
					var json = $.parseJSON(data);
					//console.log(json);
				}).error(function(e){
					console.log(e.responseText);
				});
			}

			// 100% 가 되면 남은 초만 저장
			if(percentage == 100){
				$.ajax({
					type: "POST",
					url: "/classroom_test/setPlayerEnd",
					data: {
						mode: 'chkPlayEnd',
						mps_sno : '31',
						remainTime: Math.floor(maxduration % 60),
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
		
		video.addEventListener('seeking', function() {
			var delta = video.currentTime - supposedCurrentTime;
			if (Math.abs(delta) > 0.01) {
				console.log("Seeking is disabled");
				video.currentTime = supposedCurrentTime;
			}
			$('.jump-time').click(function(){
				video.pause();
				video.currentTime = parseInt($(this).data('time')) * 60;
				supposedCurrentTime = parseInt($(this).data('time')) * 60;
				
				var timer = setInterval(function() {
					if (video.paused && video.readyState ==4 || !video.paused) {
						video.play();
						clearInterval(timer);
					}       
				}, 50);	
			});
		});

		$(window).on('unload',function(){
			var currentPos = parseInt(video.currentTime); // 현재 재생시간(초)
			var minute = Math.floor(currentPos / 60); // 현재 재생시간(분)

			if(minute > 0){
				var seconds = Math.floor(currentPos % (60 * minute));
			} else {
				var seconds = currentPos;
			}

			$.ajax({
				type: "POST",
				url: "/classroom_test/setPlayerOut",
				data: {
					mode: 'chkPlayOut',
					mps_sno: '31',
					seconds: seconds,
					csrf_test_name : cb_csrf_hash
				},
			}).success(function(data){
				var json = $.parseJSON(data);
				//console.log(json);
			}).error(function(e){
				console.log(e.responseText);
			});
		});

		// $(window).unload(function(){
		// 	$.post('/classroom_test/setPlayerOut')
		// });

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


	//  function click()
	//  {
	//  	if ((event.button==2) || (event.button==2)) 
	//  {alert('[마우스 오른쪽 클릭] / [컨트롤] / [F12] 금지 입니다.');}
	//  }
	//  document.onmousedown=click;
	
	const versionMap = document.getElementById('versionMap');

	// devtoolsDetector.addListener(function (isOpen, detail) {
	// 	console.log('isOpen', isOpen);

	// 	if (isOpen) {
	// 		location.href = '/';
	// 	} else {
	// 	}
	// });

	// devtoolsDetector.launch();

	// versionMap.innerText = Object.keys(devtoolsDetector.versionMap)
	// .map(function (key) {
	// return key + ' : ' + devtoolsDetector.versionMap[key];
	// })
	// .join('\n');
	
</script>