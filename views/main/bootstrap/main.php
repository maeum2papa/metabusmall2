<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>

	header, .navbar, .sidebar { /* 각종메뉴 숨김처리 */
		display:none !important;
	}

	.main > .container,
	.main > .container .row > div {
		width: 100%;
		padding :0;
	}

	.main > .container .row { margin: 0;}

	#feedback_write_btn { display:none; }

</style>


<!-- 랜딩 페이지 시작 -->
<div id="landing_page">
	<div id="asmo_landing_top">
		<span><i>국내 최초 직원경험(EX) HR 종합 플랫폼<em><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_top_logo.svg" alt=""></em></i><a href="https://forms.gle/JeGHHorqXQPGn6vM9">서비스 소개 받기</a></span>
	</div>
	<section class="landing_sec01">
		<article>
			<p data-aos="fade-up">우리 회사 인재들 떠날까봐 걱정되시죠?</p>
			<h2 data-aos="fade-up">그래서, <b>복지</b>도 <b>교육</b>도<br><b>인사관리</b>도 알아보고 있는데</h2>
			<h3 data-aos="fade-up"><b>예산</b>도 걱정 되시죠?</h3>
			<h4 data-aos="fade-up">그 걱정, <br class="forT"><b>컬래버랜드</b>가 해결합니다.</h4>
		</article>
	</section>
	<section class="landing_sec02">
		<article>
			<p>직원들의 입사부터 퇴사까지의 여정을 성장시키는</p>
			<h5>국내 최초 <strong>직원경험(EX)</strong> 종합 플랫폼</h5>
			<h6 class="asmo_sec02_logo"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_sec02_logo.png" alt="컬래버랜드"></h6>
		</article>
		<article class="landing_sec02_slider_wrap swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide">개인과 기업의<em><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_sec02_logo.svg" alt="컬래버랜드"></em></li>
				<li class="swiper-slide">교육과 게임의<em><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_sec02_logo.svg" alt="컬래버랜드"></em></li>
				<li class="swiper-slide">성장과 보상의<em><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_sec02_logo.svg" alt="컬래버랜드"></em></li>
				<li class="swiper-slide">언택트와 온택트의<em><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_sec02_logo.svg" alt="컬래버랜드"></em></li>
				<li class="swiper-slide">MZ세대와 X세대의<em><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/landing_sec02_logo.svg" alt="컬래버랜드"></em></li>
			</ul>
			<em class="first"></em>
			<em class="prev"></em>
			<em class="next"></em>
			<em class="last"></em>
		</article>
		<article id="running_wrap">
			<div id="running_top">
				<div class="sec03_common_box">
					<div class="tit">-raise</div>
					<div class="sec03_box">
						<b>성장과 개발</b>
						<ol>
							<li>🔸직급별 마이크로 러닝 콘텐츠 탑재</li>
							<li>🔸수강률에 따른 칭호,뱃지 기능</li>
							<li>🔸수강에 따른 아바타 및 랜드 성장</li>
							<li>🔸비대면 학습 기능</li>
						</ol>
					</div>
					<div class="box_sub_txt">*추후 개발 기능<br>기업별 AI 개인 비서 제공</div>
				</div>
				<div class="sec03_common_box">
					<div class="tit">mpensation</div>
					<div class="sec03_box">
						<b>성취와 보상</b>
						<ol>
							<li>🔸교육 수강에 따른 복지몰 기능</li>
							<li>🔸화폐가치 제어 기능</li>
							<li>🔸성장 단계에 따른 특별 아이템 제공 기능</li>
						</ol>
					</div>
					<div class="box_sub_txt">*추후 개발 기능<br>프로젝트 성과에 따른 보상 기능</div>
				</div>
			</div>
			<div id="runnig_mid">
				<div class="sec03_common_box">
					<div class="tit">me with us</div>
					<div class="sec03_box">
						<b>채용부터 온보딩</b>
						<ol>
							<li>🔸입사시 마이랜드, 마이아바타 제공</li>
							<li>🔸신입사원 비대면 교육, 팀빌딩 프로그램</li>
							<li>🔸온보딩 가이드 제공</li>
						</ol>
					</div>
					<div class="box_sub_txt">*추후 개발 기능<br>온보딩 패키지 제공 · 출퇴근 관리 시스템 · 연차, 휴가 관리 시스템</div>
				</div>
				<div id="running_main_wrap">
					<span>
						<div id="man"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/man.png" alt="사람"></div>
						<em></em>
						<em></em>
					</span>
				</div>
				<div class="sec03_common_box">
					<div class="tit">ol ending</div>
					<div class="sec03_box">
						<b>오프보딩 및 스케일업</b>
						<ol>
							<li>🔸오프보딩 가이드 제공</li>
							<li>🔸퇴사자 격려 시스템 기능</li>
						</ol>
					</div>
					<div class="box_sub_txt">*추후 개발 기능<br>퇴사시 정보 이관</div>
				</div>
			</div>
			<div id="running_bottom">
				<div class="sec03_common_box">
					<div class="tit">ngratulation</div>
					<div class="sec03_box">
						<b>와우모먼트</b>
						<ol>
							<li>🔸매일의 날씨 변화에 따라 변화하는 랜드 환경</li>
							<li>🔸낚시, 농사 등의 게이미피케이션 콘텐츠</li>
						</ol>
					</div>
					<div class="box_sub_txt">*추후 개발 기능<br>명절, 기념일 관리 및 와우모먼트 설정 기능 · 입사,승진 축하 기능</div>
				</div>
				<div class="sec03_common_box">
					<div class="tit">operation</div>
					<div class="sec03_box">
						<b>공유와 소통</b>
						<ol>
							<li>🔸사내 메신저, 직원 1:1 채팅 기능 탑재</li>
							<li>🔸임직원 랜드 놀러가기 기능</li>
							<li>🔸기업랜드를 통한 화상 타운홀 기능</li>
							<li>🔸화면공유 및 화상회의 기능</li>
						</ol>
					</div>
					<div class="box_sub_txt">*추후 개발 기능<br>하이브리드 근무를 위한 협업툴 기능 · 랜드 아이템 교환 및 선물하기 기능</div>
				</div>
			</div>
		</article>
	</section>

	<!-- <section class="landig_sec05">
			
			<div class="sec05_content">
					<div class="sec05">
						<div class="s5_1">
								<p class="sec05_p">아바타 꾸미기, 랜드 하우징, 기념일 등
									
								</p>
								<strong class="strong05">디지털 연계</strong><div class="sec05_content_img">
									<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_img4.png" alt="컬래버랜드">
								</div>
						</div>
						<div class="s5_2">
							<p class="sec05_p">교육을 통한 게임 보상과 성장을
								<br>직관적으로 경험할 수 있는
								
							</p>
							<strong class="strong05">팜 기능</strong><div class="sec05_content_img">
								<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_img3.png" alt="컬래버랜드">
							</div>
						</div>
						<div class="s5_3">
							<p class="sec05_p">구성원과 함께 교감하는 
						<br>낚시, 출석체크 등의
								
							</p>
							<strong class="strong05">미션과 보상</strong><div class="sec05_content_img">
								<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_img1.png" alt="컬래버랜드">
							</div>
						</div>
						<div class="s5_4">
							<p class="sec05_p">획득한 작물을 교환할 수 있는
								
							</p>
							<strong class="strong05">기업 및 공식 복지몰</strong><div class="sec05_content_img">
								<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_img2.png" alt="컬래버랜드">
							</div>
						</div>
					</div>
			</div>
        </section> -->

		<section class="landing_sec07">
			<div class="keypoint">
					<div class="key">
					<p>게이미피케이션</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_1.png" alt="컬래버랜드">
				</div>
				<div class="key">
					<p>기업랜드</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_2.png" alt="컬래버랜드">
				</div>
				<div class="key">
					<p>마이랜드</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_3.png" alt="컬래버랜드">
				</div>
				<div class="key">
					<p>커뮤니케이션</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_4.png" alt="컬래버랜드">
				</div>
				<div class="key">
					<p>마이크로러닝</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_5.png" alt="컬래버랜드">
				</div>
				<div class="key">
					<p>복지몰</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_6.png" alt="컬래버랜드">
				</div>
				<div class="key">
					<p>관리통계</p>
					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec05_7.png" alt="컬래버랜드">
				</div>
			</div>
		</section>


	
	<section class="landing_sec03">
		<!-- <p>우리 회사에서 <br class="forT">이런 고민을 하고 있나요?</p> -->
        
		<p>
			<strong class="sec03_double">"</strong><strong>긍정적인 직원경험</strong>이 곧 <strong class="orange">기업의 경쟁력</strong>이다.
		</p>
        <p class="sec03_text">직원 한 사람이 회사와 관계를 맺는 과정 전반에서
            <br><strong class="orange">긍정적 관계를 유지하기 위한 전략</strong>이 필요합니다.
		</p>
		<div class="sec03_swiper_wrap swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/slide01.png" alt="컬래버랜드">
				</li>
				<li class="swiper-slide">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/slide02.png" alt="컬래버랜드">
				</li>
				<li class="swiper-slide">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/slide03.png" alt="컬래버랜드">
				</li>
				<li class="swiper-slide">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/slide04.png" alt="컬래버랜드">
				</li>
				<li class="swiper-slide">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/slide05.png" alt="컬래버랜드">
				</li>
				<li class="swiper-slide">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/slide06.png" alt="컬래버랜드">
				</li>
			</ul>
		</div>
	</section>


	<section class="landing_sec06">
		<p>많은 기업이 <img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/landing_sec02_logo.png" alt="컬래버랜드">와 함께 성장하고 있습니다.</p>
		<div class="text">
			
			<div class="sec06_test1">

				<p class="subtext">1차 클로즈베타 (23.11.01~23.11.30)</p><p class="test1"><strong class="orange">총 30여개 이상 기업</strong>에 종사하는 
                    <strong class="orange">1,000명의 임직원 대상</strong>으로 컬래버랜드 1차 클로즈드베타 진행
                </p>
			</div>
			
            <div class="test1_m1">
        		<p class="subtext">1차 클로즈베타 (23.11.01~23.11.30)</p>
                <p class="test1"><strong class="orange">총 30여개 이상 기업</strong>에 종사하는
                    <br><strong class="orange">1,000명의 임직원 대상</strong>으로
                    </p>
                <p>컬래버랜드 1차 클로즈드베타 진행</p>
			</div>
		</div>

		<div class="fdb_wrap">
			<div class="fdb">
				<div class="chart fdb1">
					<span class="center">ADT</span>
					<span class="text">2시간 이상 체류</span>
				</div>
				<div class="chart fdb2">
					<span class="center">MAU</span>
					<span class="text">75% 이상</span>
				</div>
				<div class="chart fdb3">
					<span class="center">CSAT</span>
					<span class="text">91%</span>
				</div>
			</div>

			<div class="etc">
                <div>
				<p>일 평균 체류시간
                	<br><string>출/퇴근 9시간 기준</string>
   					 <br><string>(07~11시 / 16~21시)</string>
                    </p>
                </div><div>
					<p>
					월 20시간 이상
					<br>접속 인원
					</p>
                </div><div>
					<p>
					1차베타클로즈드
					<br>테스트 만족도
					</p>
                </div>
			</div>
		</div>

		<!-- <div class="sec06_percent">
			<div class="sec06_per"> 
				<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec06_percent2.png" alt="컬래버랜드">
				<p>
					일 평균 체류시간
					<br><string>출/퇴근 9시간 기준 (07~11시 / 16~21시)</string>
				</p>
			</div>
			<div class="sec06_per"> 
			<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec06_percent1.png" alt="컬래버랜드">
			<p>
				월 20시간 이상
				<br>접속 인원
			</p>
			</div>
			<div class="sec06_per"> 
			<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/sec06_percent3.png" alt="컬래버랜드">
			<p>
				1차 클로즈드베타
				<br>만족도
			</p>
			</div>
			
		</div> -->

		<section class="sec06_feedback">
            <div class="sec06_fb">
    			<div class="sec06_fb1">
    				<div class="profile">
    					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile1.png" alt="컬래버랜드">
    					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star4.png" alt="컬래버랜드" class="star">
    				</div>
    					<p>임원분들도 처음에는 어려워 했는데 지금은 
    						<br>직원들 보다 더 좋아하시네요.</p>
    			</div>
    		
    		<div class="sec06_fb1">
    				<div class="profile">
    					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile2.png" alt="컬래버랜드">
    					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star5.png" alt="컬래버랜드" class="star">
    				</div>
    					<p>따로 복지플랫폼을 사용하지 않아도 유연하게
    						<br>복지설계를 할 수 있을 것 같아요.</p>
    			</div>
    
    		<div class="sec06_fb1">
    				<div class="profile">
    					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile3.png" alt="컬래버랜드">
    					<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star4.png" alt="컬래버랜드" class="star">
    				</div>
    					<p>자취방처럼 나만의 공간도 꾸미고 옆자리 
    						<br>동기 랜드에도 놀러갈 수 있어서 재밌었어요😍</p>
    			</div>
    
    			<div class="sec06_fb1">
    					<div class="profile">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile1.png" alt="컬래버랜드">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star3.png" alt="컬래버랜드" class="star">
    					</div>
    						<p>신입사원이 들어오면 해야할 교육들이 많은데
    							<br>시간을 많이 단축시킬 수 있을 것 같아요.</p>
    			</div>
    
    			<div class="sec06_fb1">
    					<div class="profile">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile4.png" alt="컬래버랜드">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star5.png" alt="컬래버랜드" class="star">
    					</div>
    						<p>저희는 이제 줌이나 팀즈같은거 안쓰고 
    						<br>여기서 주간회의, 월간회의 합니다 ㅎㅎ</p>
    			</div>
    
    		<div class="sec06_fb1">
    					<div class="profile">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile5.png" alt="컬래버랜드">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star5.png" alt="컬래버랜드" class="star">
    					</div>
    						<p>영상이 짧은 편이라 출퇴근할 때 잠깐잠깐 보기 좋았는데
    						<br>몇 번 보니까 커피 쿠폰도 얻을 수 있어서 쏠쏠했습니다 :) </p>
    			</div>
    
    		<div class="sec06_fb1">
    					<div class="profile">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile6.png" alt="컬래버랜드">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star4.png" alt="컬래버랜드" class="star">
    					</div>
    						<p>베타테스트인데 너무 열심히 꾸며놔서 
    						<br>끝나기가 아쉬워요ㅠㅠ </p>
    			</div>
    
    		<div class="sec06_fb1">
    					<div class="profile">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/profile3.png" alt="컬래버랜드">
    						<img src="https://collaborland.kr/views/_layout/bootstrap/seum_img/landing/star3.png" alt="컬래버랜드" class="star">
    					</div>
    						<p>회사에 적용할 수 있는 기능이 많아서 앞으로
    						<br>업데이트 될 내용들이 너무 기대됩니다.</p>
    			</div>
    		
			</div>		
		</section>
		
	</section>

	<section class="landing_sec04">
		<p>컬래버랜드 1년 무료 도입을 <br class="forT">할 수 있는 마지막 기회를 잡으세요!</p>
		<strong>2차 클로즈드 <br class="forT">베타테스터 선착순 모집</strong>
		<a href="https://forms.gle/JeGHHorqXQPGn6vM9">서비스 소개 받기</a>
		<p class="p2">이 모든 여정을 함께 할 <br class="forT"><span>마지막</span> 베타테스터 기업을 모집 합니다.</p>
		<p class="sec04_txt">
			<span class="asmo_txt_tit">▸ 신청 기간 : </span><br class="forT">2023년 12월 26일 ~ 2024년 1월 12일<br><br class="forT"><span class="asmo_txt_tit">▸ 신청 방법 : </span><br class="forT">해당 페이지에서 <br class="forT">'서비스 소개 받기' 클릭<em>*베타테스터로 선정된 기업에게는 <br class="forT">개별적으로 메일을 보내드립니다.</em>
		</p>
		<p class="sec04_txt">
			<span class="asmo_txt_tit">▸ 테스트 기간 : </span><br class="forT">2024년 1월 15일 ~ 2024년 2월 7일<br><br class="forT"><span class="asmo_txt_tit">▸ 참여 조건 : </span>5인 이상 중소기업
		</p>
		<div class="sec04_sub">
			<b>▸ 참여 혜택</b>
			<div>★ 미션 참여 전원 스타벅스 커피 쿠폰 증정 ★</div>
			<p>*중복 수령 가능합니다.</p>
			<ul>
				<li>
					<p>- 최고 아이디어 기업 -</p>
					<div class="sec04_box">
						<div class="img_wrap">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/b_01.png" alt="상품권">
						</div>
						<span>30만원 상당 기업 외식 상품권</span>
					</div>
				</li>
				<li>
					<p>- 베타테스트 미션 달성 기업 -</p>
					<div class="sec04_box">
						<div class="img_wrap">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/b_02.png" alt="상품권">
						</div>
						<span>컬래버랜드 1년 무료 이용권</span>
					</div>
				</li>
				<li>
					<p>- 출·퇴근 시간을 가장 많이 활용한 기업 -</p>
					<div class="sec04_box">
						<div class="img_wrap">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/landing/b_03.png" alt="상품권">
						</div>
						<span>한정판 아이템 set 증정</span>
					</div>
				</li>
			</ul>
			<strong>문의 : cs@collaborland.kr / 1877-1630</strong>
		</div>
	</section>




</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script type="text/javascript">
// asmo sh 231114 랜딩 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트

$(document).ready(function() {
	$('header').addClass('dn');
	$('.navbar').addClass('dn');
	$('.sidebar').addClass('dn');
	$('footer').addClass('landing_footer');


	// 랜딩 페이지 디자인 상 피드백 버튼 숨김 처리 스크립트
	// $('#feedback_write_btn').addClass('dn');
});


//섹션 2 페이드인 슬라이드
const swiper = new Swiper('.landing_sec02_slider_wrap', {
	speed: 200,
	effect : 'fade',
	loop: true,
	autoplay: {
	delay: 2000,
		disableOnInteraction: false,
	},		
});

//섹션 3 슬라이드
const swiper2 = new Swiper('.sec03_swiper_wrap', {
	speed: 200,
	loop: true,
	centeredSlides: true,
	slidesPerView: 1.1,
	spaceBetween: 20,
	autoplay: {
	delay: 2500,
		disableOnInteraction: false,
	},
	breakpoints : {
		1025 : {
			slidesPerView: 2,
			spaceBetween: 100,
		}
	}		

});

AOS.init();

//사람 달리기 애니메이션 




if( cb_device_type == 'mobile'){
	
	$(window).scroll(function(){

	var sct = $(window).scrollTop();
	var runningPoint = $('#runnig_mid').offset().top;

	if( sct >= runningPoint ){
		$('#man').addClass('active');
	}

	});
}else {
	
	$(window).scroll(function(){

	var sct = $(window).scrollTop();
	var runningPoint = $('#running_top').offset().top;

	if( sct >= runningPoint ){
		$('#man').addClass('active');
	}

	});
}


//섹션 6 퍼센트

 		const chart1 = document.querySelector('.fdb1');
         const chart2 = document.querySelector('.fdb2');
         const chart3 = document.querySelector('.fdb3');
         const makeChart = (percent, classname, color) => {
           let i = 1;
           let chartFn = setInterval(function() {
             if (i < percent) {
               colorFn(i, classname, color);
               i++;
             } else {
               clearInterval(chartFn);
             }
           }, 10);
         }
         const colorFn = (i, classname, color) => {
           classname.style.background = "conic-gradient(" + color + " 0% " + i + "%, #000 " + i + "% 100%)";
         }
      
 var isVisible = false;
         window.addEventListener("scroll", () => {
			
              if (checkVisible(document.querySelector('.fdb'))&& !isVisible) {
         isVisible=true;
		 console.log(isVisible);
                  if(isVisible) {
                      makeChart(60, chart1, '#ff7f00');
           makeChart(75, chart2, '#ff7f00');
           makeChart(88, chart3, '#ff7f00');
                     }
      
     }
         })
  checkVisible = (elm, eval ) => {
	
     eval = eval || "object visible";
     var viewportHeight = window.innerHeight, // Viewport Height
         scrolltop = document.documentElement.scrollTop, // Scroll Top
        //  y = elm.offsetTop + elm.offsetHeight - scrolltop,			//540 180
        y = elm.getBoundingClientRect().top + scrolltop, 
		elementHeight = elm.offsetHeight;   
		 
	
     if (eval == "object visible") return ((y < (viewportHeight + scrolltop)) && (y > (scrolltop - elementHeight)));
     if (eval == "above") return ((y < (viewportHeight + scrolltop)));
 }




</script>


