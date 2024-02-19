<?php

?>
<div id="asmo_classroom">
	<div id="asmo_classroom_player">
		<section class="video_sect">
			<video id="video" src="https://v1.collaborland.kr:8443/<?=$my_process[video_url]?>" disablepictureinpicture controls controlsList="noplaybackrate nodownload nofullscreen " ></video>
		</section>

		<section>
			<div class="playbackRate">
				<button type="button" id="speed08" class="jump-speed btn" data-speed="0.8">배속 0.8</button>
				<button type="button" id="speed10" class="jump-speed btn" data-speed="1.0">배속 1.0</button>
				<button type="button" id="speed12" class="jump-speed btn" data-speed="1.2">배속 1.2</button>
				<button type="button" id="speed15" class="jump-speed btn" data-speed="1.5">배속 1.5</button>
			</div>
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
					<div class="video_period">
						<p><?=$my_process[view_time]?></p>
					</div>
				</div>				
			</div>

			<!-- <div class="video_info_enroll_rate">
				

				<div class="enroll_rate_bar">
					<div class="enroll_rate_bar_fill" style="width: <?=$my_process[mp_percent]?>%;"></div>
				</div>

				<span id="enroll_rate"><?=$my_process[mp_percent]?></span>
			</div> -->

			<section class="video_timeline video_info_enroll_rate">
				<span>수강률</span>
				<div id="video_timeline_wrap" class="enroll_rate_bar">
					<div id="video_timeline_blue" class="enroll_rate_bar_fill"></div>
					<div id="video_timeline_red"></div>
				</div>
			</section>

			<div class="video_info_tab">
				<div class="tab_button_wrap">
					<button class="tab_button selected">
						<strong>강의소개</strong>
					</button>
					<button class="tab_button">
						<strong>강사소개</strong>
					</button>
					<button class="tab_button">
						<strong>강의자료</strong>
					</button>
				</div>
				<div class="tab_contents_wrap">
					<div class="tab_contents tab1 selected">
						<?php foreach (element('list', $curriculum) as $k => $v){?>
						<div class="tab_content asmo_curri_box <?=$v[active]?>">
							<span>섹션 <?=$k?>. <?=$v[title]?>
								<!-- 진행중일때 -->
								<em class="asmo_class_toggle active">진행중</em>
								<!-- 진행완료 및 이동가능할때 -->
								<em class="asmo_class_toggle complete"><a href="<?=$v[moveUrl]?>" >진행완료</a></em>
								<!-- 진행중일때 -->
								<em class="asmo_class_toggle">진행예정</em>	
							</span>
						</div>
						<?php } ?>
					</div>
					<div class="tab_contents tab2">
						<?=$my_process[p_teacher]?>
					</div>

					<div class="tab_contents tab3 ">
						<a href='' download="" class="tab_down_content">
							<p>강의 자료 준비중입니다.</p>
							<span>Download</span>
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

	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');
	//asmo lhb 231218 클래스 영역 구분용 클래스 추가 끝


	//asmo lhb 231218 탭버튼 이벤트
	$('.tab_button_wrap button').click(function(){

		var num = $(this).index();

		$('.tab_button_wrap button').removeClass('selected');
		$(this).addClass('selected');

		$('.tab_contents_wrap .tab_contents').removeClass('selected');
		$('.tab_contents_wrap .tab_contents').eq(num).addClass('selected');


	})
	//asmo lhb 231218 탭버튼 이벤트 끝




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


	function click()
	{
		if ((event.button==2) || (event.button==2)) 
	{alert('[마우스 오른쪽 클릭] / [컨트롤] / [F12] 금지 입니다.');}
	}
	document.onmousedown=click;
	
	const versionMap = document.getElementById('versionMap');

	devtoolsDetector.addListener(function (isOpen, detail) {
		console.log('isOpen', isOpen);

		if (isOpen) {
			location.href = '/';
		} else {
		}
	});

	// devtoolsDetector.launch(); //asmo lhb 231219 작업으로 임시로 주석처리 끝나면 해제

	versionMap.innerText = Object.keys(devtoolsDetector.versionMap)
	.map(function (key) {
	return key + ' : ' + devtoolsDetector.versionMap[key];
	})
	.join('\n');
	
</script>