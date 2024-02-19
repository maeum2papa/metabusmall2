<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($this->cbconfig->get_device_view_type() === 'desktop' && $this->cbconfig->get_device_type() === 'mobile') { ?>
<meta name="viewport" content="width=1000">
<?php } else { ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php } ?>
<title><?php echo html_escape(element('page_title', $layout)); ?></title>
<?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
<?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
<?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
<?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
<?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" />
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" />


<!-- asmo sh 231113 seum_custom.css, 폰트 cdn, swiper link cdn 추가 -->
<link href="https://webfontworld.github.io/NexonLv2Gothic/NexonLv2Gothic.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/seum_custom.css" />

<link
	rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<!-- //asmo sh 231113 seum_custom.css, 폰트 cdn, swiper link cdn 추가 -->


<?php echo $this->managelayout->display_css(); ?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
// 자바스크립트에서 사용하는 전역변수 선언
var cb_url = "<?php echo trim(site_url(), '/'); ?>";
var cb_cookie_domain = "<?php echo config_item('cookie_domain'); ?>";
var cb_charset = "<?php echo config_item('charset'); ?>";
var cb_time_ymd = "<?php echo cdate('Y-m-d'); ?>";
var cb_time_ymdhis = "<?php echo cdate('Y-m-d H:i:s'); ?>";
var layout_skin_path = "<?php echo element('layout_skin_path', $layout); ?>";
var view_skin_path = "<?php echo element('view_skin_path', $layout); ?>";
var is_member = "<?php echo $this->member->is_member() ? '1' : ''; ?>";
var is_admin = "<?php echo $this->member->is_admin(); ?>";
var cb_admin_url = <?php echo $this->member->is_admin() === 'super' ? 'cb_url + "/' . config_item('uri_segment_admin') . '"' : '""'; ?>;
var cb_board = "<?php echo isset($view) ? element('board_key', $view) : ''; ?>";
var cb_board_url = <?php echo ( isset($view) && element('board_key', $view)) ? 'cb_url + "/' . config_item('uri_segment_board') . '/' . element('board_key', $view) . '"' : '""'; ?>;
var cb_device_type = "<?php echo $this->cbconfig->get_device_type() === 'mobile' ? 'mobile' : 'desktop' ?>";
var cb_csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
var cookie_prefix = "<?php echo config_item('cookie_prefix'); ?>";
</script>
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo base_url('assets/js/html5shiv.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>


<!-- asmo sh 231113 swiper script cdn 추가 -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- //asmo sh 231113 swiper script cdn 추가 -->


<?php echo $this->managelayout->display_js(); ?>
</head>
<body <?php echo isset($view) ? element('body_script', $view) : ''; ?>>
<div class="wrapper">


<!-- asmo sh 231213 디자인 상 bootstrap/layout 에서 헤더가 불필요하여 주석처리 -->
	<!-- <?php if ($this->cbconfig->get_device_view_type() !== 'mobile') {?>
		
		<header class="header">

			<div class="container">
				<ul class="header-top-menu">
					<?php if ($this->member->is_admin() === 'super' || $this->session->userdata['mem_admin_flag'] == 1) { ?>
						<li><i class="fa fa-cog"></i><a href="<?php echo site_url(config_item('uri_segment_admin')); ?>" title="관리자 페이지로 이동">관리자</a></li>
					<?php } ?>
					<?php
					if ($this->member->is_member()) {
						if ($this->cbconfig->item('use_notification')) {
					?>
						<li class="notifications"><i class="fa fa-bell-o"></i>알림 <span class="badge notification_num"><?php echo number_format((int) element('notification_num', $layout)); ?></span>
							<div class="notifications-menu"> </div>
						</li>
						<script type="text/javascript">
						//<![CDATA[
						$(document).mouseup(function (e)
						{
							var noticontainer = $('.notifications-menu');

							if ( ! noticontainer.is(e.target) // if the target of the click isn't the container...
								&& noticontainer.has(e.target).length === 0) // ... nor a descendant of the container
							{
								noticontainer.hide();
							}
						});
						//]]>
						</script>
					<?php
						}
					?>
						<li><i class="fa fa-sign-out"></i><a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>" title="로그아웃">로그아웃</a></li>
						<li><i class="fa fa-user"></i><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
					<?php } else { ?>
						<li><i class="fa fa-sign-in"></i><a href="<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>" title="로그인">로그인</a></li>
						
					<?php } ?>
					<?php if ($this->cbconfig->item('open_currentvisitor')) { ?>
						<li><i class="fa fa-link"></i><a href="<?php echo site_url('currentvisitor'); ?>" title="현재접속자">현재접속자</a> <span class="badge"><?php echo element('current_visitor_num', $layout); ?></span></li>
					<?php } ?>
				</ul>
			</div>
		
		</header>

<?php } else {?>

	<div class="header_line"></div>

<?php } ?> -->

	<!-- nav start -->
	<nav class="dn navbar navbar-default">
		<div class="container">

		<!-- asmo sh 231122 디자인 상 div.navbar-header 불필여하여 dn 처리 -->
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header dn">
				<button type="button" class="navbar-toggle collapsed" <?php if ($this->cbconfig->get_device_view_type() !== 'mobile') {?>data-toggle="collapse" data-target="#topmenu-navbar-collapse" <?php } ?> id="btn_side">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="<?php echo site_url(); ?>" class="navbar-brand" title="<?php echo html_escape($this->cbconfig->item('site_title'));?>"><?php echo $this->cbconfig->item('site_logo'); ?></a>
			</div>
		<!-- //asmo sh 231122 디자인 상 div.navbar-header 불필여하여 dn 처리 -->

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="topmenu-navbar-collapse">
				<ul class="nav navbar-nav navbar-right">	

					<!-- asmo sh 231122 전체 카테고리 nav 바 생성 -->
					<li class="dropdown all">
						<a href="javascript:;">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/category.svg" alt="category">
							전체 카테고리
						</a>
						<ul class="dropdown-menu nav navbar-nav">
						<?php
						$menuhtml = '';
						if (element('menu', $layout)) {
							//$menu = element('menu', $layout);
							$menu = seum_menu();
							$rank = seum_rank($this->member->item('company_idx'),$this->member->item('mem_id'));
							
							if (element(0, $menu)) {
								foreach (element(0, $menu) as $mkey => $mval) {
									if (element(element('men_id', $mval), $menu)) {
										$mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
										$menuhtml .= '<li>
										<span ' . element('men_custom', $mval);
										if (element('men_target', $mval)) {
											$menuhtml .= ' target="' . element('men_target', $mval) . '"';
										}
										$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</span>
										<ul>';

										foreach (element(element('men_id', $mval), $menu) as $skey => $sval) {
											$slink = element('men_link', $sval) ? element('men_link', $sval) : 'javascript:;';
											$menuhtml .= '<li><a href="' . $slink . '" ' . element('men_custom', $sval);
											if (element('men_target', $sval)) {
												$menuhtml .= ' target="' . element('men_target', $sval) . '"';
											}
											$menuhtml .= ' title="' . html_escape(element('men_name', $sval)) . '">' . html_escape(element('men_name', $sval)) . '</a></li>';
										}
										$menuhtml .= '</ul></li>';

									} else {
										$mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
										$menuhtml .= '<li><span ' . element('men_custom', $mval);
										if (element('men_target', $mval)) {
											$menuhtml .= ' target="' . element('men_target', $mval) . '"';
										}
										$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</span></li>';
									}
								}
							}
						}
						echo $menuhtml;
						?>
						</ul>
					</li>		
					<!-- //asmo sh 231122 전체 카테고리 nav 바 생성 -->


					<!-- asmo sh 231123 디자인 상 커스텀 필요하여 nav 바 탑 메뉴 생성 및 div.dropdown-menu-wrap 생성 -->
					<?php
					$menuhtml = '';
					if (element('menu', $layout)) {
						//$menu = element('menu', $layout);
						$menu = seum_menu();
						if (element(0, $menu)) {
							foreach (element(0, $menu) as $mkey => $mval) {
								if (element(element('men_id', $mval), $menu)) {
									$mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
									$men_name = html_escape(element('men_name', $mval));
									$menuhtml .= '<li class="dropdown">
									<a href="' . $mlink . '" ' . element('men_custom', $mval);
									if (element('men_target', $mval)) {
										$menuhtml .= ' target="' . element('men_target', $mval) . '"';
									}
									$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a>
									<ul class="dropdown-menu"><span>' . html_escape(element('men_name', $mval)) . '</span><div class="dropdown-menu-wrap">';

									foreach (element(element('men_id', $mval), $menu) as $skey => $sval) {
										$slink = element('men_link', $sval) ? element('men_link', $sval) : 'javascript:;';
										$menuhtml .= '<li><a href="' . $slink . '" ' . element('men_custom', $sval);
										if (element('men_target', $sval)) {
											$menuhtml .= ' target="' . element('men_target', $sval) . '"';
										}
										$menuhtml .= ' title="' . html_escape(element('men_name', $sval)) . '">' . html_escape(element('men_name', $sval)) . '</a></li>';
									}
									$menuhtml .= '</div></ul></li>';

								} else {
									$mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
									$menuhtml .= '<li><a href="' . $mlink . '" ' . element('men_custom', $mval);
									if (element('men_target', $mval)) {
										$menuhtml .= ' target="' . element('men_target', $mval) . '"';
									}
									$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a></li>';
								}
							}
						}
					}
					echo $menuhtml;
					?>
					<!-- //asmo sh 231123 디자인 상 커스텀 필요하여 nav 바 탑 메뉴 생성 및 div.dropdown-menu-wrap 생성 -->

				</ul>

				<!-- asmo sh 231122 디자인 상 nav바 검색버튼 ul 옆으로 재배치 및 검색창 삭제 후 검색 버튼 생성 -->
				<div class="nav_search_box">
					<button><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/search.svg" alt="search"></button>
					<script type="text/javascript">
					//<![CDATA[
					$(function() {
						$('#topmenu-navbar-collapse .dropdown').hover(function() {
							$(this).addClass('open');
						}, function() {
							$(this).removeClass('open');
						});


						// 검색 버튼
						$('.nav_search_box button').click(function() {
							$('#search_layer').fadeIn();
						});

						// 취소 버튼
						$('#search_layer button').click(function() {
							$('#search_layer').fadeOut();
						});

						// 검색창 외 영역 클릭 시 검색창 닫기

						
					});
					function headerSearch(f) {
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
				</div>
				<!-- //asmo sh 231122 디자인 상 nav바 검색버튼 ul 옆으로 재배치 -->

			</div><!-- /.navbar-collapse -->
		</div>

		<!-- asmo sh 231123 검색 버튼 누르면 나오는 검색창 레이어 팝업 -->
		<div class="search_layer" id="search_layer">
			<div class="search_layer_wrap">
				<div class="search_layer_header">
					<form class="navbar-form navbar-right" name="header_search" id="header_search" action="<?php echo site_url('search'); ?>" onSubmit="return headerSearch(this);">
						<div class="form-group">
							<input type="text" class="form-control px150" placeholder="어떤 강의를 찾으시나요?" name="skeyword" accesskey="s" />
							
						</div>
					</form>
					<button><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/cancel.svg" alt="cancel"></button>
				</div>
				<div class="search_layer_body">
					<div class="layer_body_box">
						<span>추천 검색어</span>
						<div class="reco_word">
							<a href="<?php echo site_url('classroom/business_class'); ?>">블렌더</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">4차 산업</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">금융경제</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">CS</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">성과관리</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">마케팅</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">직무역량 기타</a>
							<a href="<?php echo site_url('classroom/business_class'); ?>">유통/물류</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<!-- nav end --> <!-- header end -->

	<!-- main start -->
	<div class="main add">
		<div class="container">
			<div class="row">

				<?php if (element('use_sidebar', $layout)) {?>
					<div class="col-md-9 col-sm-8 col-xs-12 mb20">
				<?php } ?>

				<!-- 본문 시작 -->
				<?php if (isset($yield))echo $yield; ?>
				<!-- 본문 끝 -->

				<?php if (element('use_sidebar', $layout)) {?>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-12">
						<div class="sidebar">
							<!-- 사이드바 시작 -->
							<?php $this->load->view(element('layout_skin_path', $layout) . '/sidebar'); ?>
							<!-- 사이드바 끝 -->
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- main end -->

	<!-- footer start -->
	<footer>
		
		
		<!-- asmo sh 231121 footer 내 div.container dn 처리 후 디자인에 맞게 재배치 및 일단 하드코딩으로 관리 -->

		<div class="container">
			<div class="footer_logo">
				<a href=""><?=banner('login_logo')?></a>
			</div>

			<div class="company_info_box">
				<div class="company_info">
					<b><?php echo $this->cbconfig->item('company_name'); ?></b>
					<span><?php echo $this->cbconfig->item('company_address'); ?></span>
				</div>

				<div class="company_info">
					<span>사업자등록번호 <?php echo $this->cbconfig->item('company_reg_no'); ?></span>
				</div>

				<div class="company_info">
					<span>대표번호 <?php echo $this->cbconfig->item('company_phone'); ?> | </span>
					<span>FAX <?php echo $this->cbconfig->item('company_fax'); ?></span>
				</div>
			</div>
		</div>

		<div class="container dn">
			<div>
				<ul class="company">
					<li><a href="<?php echo document_url('aboutus'); ?>" title="회사소개">회사소개</a></li>
					<li><a href="<?php echo document_url('provision'); ?>" title="이용약관">이용약관</a></li>
					<li><a href="<?php echo document_url('privacy'); ?>" title="개인정보 취급방침">개인정보 취급방침</a></li>
					<!--li><a href="<?php echo site_url('pointranking'); ?>" title="포인트 전체랭킹">포인트 전체랭킹</a></li>
					<li><a href="<?php echo site_url('pointranking/month'); ?>" title="포인트 월별랭킹">포인트 월별랭킹</a></li>
					<li><a href="<?php echo site_url('levelup'); ?>" title="레벨업">레벨업</a></li-->
				</ul>
			</div>
			<div class="copyright">
				<?php if ($this->cbconfig->item('company_address')) { ?>
					<span><?php echo $this->cbconfig->item('company_address'); ?>
						<?php if ($this->cbconfig->item('company_zipcode')) { ?>(우편 <?php echo $this->cbconfig->item('company_zipcode'); ?>)<?php } ?>
					</span>
				<?php } ?>
				<?php if ($this->cbconfig->item('company_owner')) { ?><span><b>대표</b> <?php echo $this->cbconfig->item('company_owner'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_phone')) { ?><span><b>전화</b> <?php echo $this->cbconfig->item('company_phone'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_fax')) { ?><span><b>팩스</b> <?php echo $this->cbconfig->item('company_fax'); ?></span><?php } ?>
			</div>
			<div class="copyright">
				<?php if ($this->cbconfig->item('company_reg_no')) { ?><span><b>사업자</b> <?php echo $this->cbconfig->item('company_reg_no'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_retail_sale_no')) { ?><span><b>통신판매</b> <?php echo $this->cbconfig->item('company_retail_sale_no'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_added_sale_no')) { ?><span><b>부가통신</b> <?php echo $this->cbconfig->item('company_added_sale_no'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_admin_name')) { ?><span><b>정보관리책임자명</b> <?php echo $this->cbconfig->item('company_admin_name'); ?></span><?php } ?>
				<span>Copyright&copy; <?php echo html_escape($this->cbconfig->item('site_title')); ?>. All Rights Reserved.</span>
			</div>
			<?php
			if ($this->cbconfig->get_device_view_type() === 'mobile') {
			?>
				<div class="see_mobile"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-xs viewpcversion">PC 버전으로 보기</a></div>
			<?php
			} else {
				if ($this->cbconfig->get_device_type() === 'mobile') {
			?>
				<div class="see_mobile"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-lg viewmobileversion" style="width:100%;font-size:5em;">모바일 버전으로 보기</a></div>
			<?php
				} else {
			?>
				<div class="see_mobile"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-xs viewmobileversion">모바일 버전으로 보기</a></div>
			<?php
				}
			}
			?>
		</div>
	</footer>
	<!-- footer end -->
</div>

<!-- 클래스룸 사이드바 -->
<div id="class_sideBar" class="dn">
	<div class="BarTop">
		<h2>MENU</h2>
		<a href="<?php echo site_url('classroom/my_class'); ?>" id="myclassroom">나의 수강목록</a> <!-- 수강목록 버튼입니다 -->
	</div>
	<div class="BarCon">
		<div class="barToggle_bg">
			<div class="barToggle_menu">
				<!-- 기업강의 토글 버튼입니다 -->
				<p class="collClass"> <span>컬래버랜드 강의</span></p>
				<p class="cpnClass"><span>기업강의</span></p>
				<div id="barToggle"></div>
			</div>
		</div>
		<!-- 컬래버랜드 강의 -->
		<ul class="col_barTitle" style="display: none;">
			<li class="col_title_li" onClick="location.href='<?php echo site_url('classroom/business_class?menu=채용부터 온보딩');?>'">
				<p class="col_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/mwu_icon.png" alt="mwu_icon"></p>
				<div class="col_title_con">
					<p>come with us<br><span>채용부터 온보딩</span></p>
				</div>
				
			</li>
			<li class="col_title_li" onClick="location.href='<?php echo site_url('classroom/business_class?menu=성장과 개발');?>'">
				<p class="col_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/raise_icon.png" alt="raise_icon"></p>
				<div class="col_title_con">
					<p>co-raise<br><span>성장과 개발</span></p>
				</div>
				
			</li>
			<li class="col_title_li" onClick="location.href='<?php echo site_url('classroom/business_class?menu=와우모먼트');?>'">
				<p class="col_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/wow_icon.png" alt="wow_icon"></p>
				<div class="col_title_con">
					<p>congratulation<br><span>와우모먼트</span></p>
				</div>
				
			</li>
			<li class="col_title_li" onClick="location.href='<?php echo site_url('classroom/business_class?menu=공유와 소통');?>'">
				<p class="col_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/operation_icon.png" alt="operation_icon"></p>
				<div class="col_title_con">
					<p>cooperation<br><span>공유와 소통</span></p>
				</div>
				
			</li>
			<li class="col_title_li" onClick="location.href='<?php echo site_url('classroom/business_class?menu=성취와 보상');?>'">
				<p class="col_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/mpen_icon.png" alt="mpen_icon"></p>
				<div class="col_title_con">
					<p>compenseation<br><span>성취와 보상</span></p>
				</div>
				
			</li>
			<li class="col_title_li" onClick="location.href='<?php echo site_url('classroom/business_class?menu=오프보딩 및 스케일업');?>'">
				<p class="col_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/ending_icon.png" alt="ending_icon"></p>
				<div class="col_title_con">
					<p>cool ending<br><span>오프보딩 및 스케일업</span></p>
				</div>
				
			</li>
			
		</ul>
		<!-- 기업강의 -->
		<ul class="cpn_barTitle">
			<li class="cpn_title_li">
				<p class="cpn_title_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/classroom/company_icon.png" alt="company_icon"></p>
				<p class="cpn_title_con">기업 강의</p>
			</li>
		</ul>
		<!-- 전체보기 버튼입니다 -->
		<a href="<?php echo site_url('classroom/business_class'); ?>" class="classBar_all"><span>전체보기</span></a>
	</div>
</div>

<!-- asmo sh 240103 공지사항 팝업 추가 -->
<div class="popup_layer_bg" id="notice_popup">
	<div class="notice_popup">
        <div class="npopTop">
            <h1>
				<!-- <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/notice_icon.svg" alt="notice_icon">  -->
				<?=busiNm($this->member->item('company_idx'))?> 공지사항
			</h1>
            <button id="npopClose"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/npop_close.svg" alt="npop_close"></button>
        </div>
        <div class="npopBtm">
            <div class="notice_contents notice1">
                <!-- 첫번째 공지사항입니다 -->
                <h2>기업랜드 내 규칙 공지</h2> <!-- 제목 -->
                <div class="npopCon">
                    <p class="npop_img"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/npop_itemSet.png" alt="npop_itemSet"></p> <!-- 이미지 공간입니다 -->
                    <div class="npopConBtm">
                        <!-- 내용 -->
                        <p>기업랜드에서 지켜야 할 규칙 공지 안내 드립니다.</p>
                        <p>1. 보이는 사람한테는 인사는 꼭 해주세요!</p>
                    </div>
                    <a href="https://seum.collaborland.kr/post/58" class="npop_plus"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/npop_plus.svg" alt="npop_plus"></a>
                </div>
            </div>
            <div class="notice_contents notice2">
                <!-- 두번째 공지사항입니다 -->
                <h2>팀메타 필수 교육 영상 시청 공유 드립니다.</h2> <!-- 제목 -->
                <div class="npopCon">
                    <div class="npopConBtm">
                        <!-- 내용 -->
                        <p>기업랜드에서 지켜야할 규칙 공지 안내드립니다.기업랜드에서 지켜야할 규칙 공지 안내드립니다.기업랜드에서 지켜야할 규칙 공지 안내드립니다.기업랜드에서 지켜야할 규칙 공지 안내드립니다.기업랜드에서 지켜야할 규칙 공지 안내드립니다.기업랜드에서 지켜야할 규칙 공지 안내드립니다.</p>
                        <p>
                            <span>1. 보이는 사람한테는 인사는 꼭 해주세요!</span> <br>
                            <span>2. 열매 수확 후에는 씨앗을 심어 주세요.</span> <br>
                            <span>3. 비매너 안 돼요! 예쁜 말만 쓰도록 합시다.</span> <br>
                        </p>
                        
                    </div>

					<!-- 링크 있을 때 입니다. -->
					<a href="#" class="npopCon_link">
						https://www.naver.com/
					</a>
					<!-- 링크 있을 때 입니다. -->

                    <a href="https://seum.collaborland.kr/post/58" class="npop_plus"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/npop_plus.svg" alt="npop_plus"></a>
                </div>
            </div>
            <div class="notice_contents notice3">
                <!-- 세번째 공지사항입니다 -->
                <h2>기업몰 판매 공지</h2> <!-- 제목 -->
                <div class="npopCon">
                    <div class="npopConBtm">
                        <!-- 내용 -->
                        <p>이번 저희 기업에서 새로운 상품이 판매될 예정입니다.</p>
                        <p>
                            많은 임직원 분들이 요청해 주셨던 문구류와 간식류를 대량으로 준비 중이오니, <br>
                            임직원 분들의 많은 관심 부탁 드리겠습니다. <br>
                        </p>
                        <p>감사합니다.</p>
                    </div>
                    <a href="https://seum.collaborland.kr/post/58" class="npop_plus"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/npop_plus.svg" alt="npop_plus"></a>
                </div>
            </div>


			
			<!-- 공지사항이 없을 때 입니다. -->
			<!-- <div class="nopost" style="line-height: 200px;">
				<p>등록된 공지사항이 없습니다.</p>
			</div> -->
			<!-- 공지사항이 없을 때 입니다. -->


        </div>



    </div>
</div>

<!-- asmo sh 231228 직원 목록 팝업 추가 -->
<div class="dn" id="staff_list">
	<div class="staff_list">
		<div class="staff_list_header">
			<p>직원 목록</p>
			<button id="staff_list_close">취소</button>
		</div>

		<div class="staff_list_body">
			<div class="staff_list_my_profile">
				<span><?php echo html_escape($this->member->item('mem_div')); ?></span>
				<p><?php echo html_escape($this->member->item('mem_nickname')); ?></p>
			</div>

			<div class="staff_list_box_wrap">
				<div class="staff_list_box">
					<div class="staff_list_box_left">

						<!-- 부서명 들어올 자리입니다. -->
						<span>개발1팀 / 사업본부</span>
						<!-- 부서명 들어올 자리입니다. -->

						<div class="staff_list_flex_box">

							<!-- 닉네임 들어올 자리입니다. -->
							<p>김철수</p>
							<!-- 닉네임 들어올 자리입니다. -->

							<!-- 랜드 경로입니다. -->
							<a href="">랜드 바로가기</a>
							<!-- 랜드 경로입니다. -->

						</div>
					</div>

					<button class="staff_talk_btn">대화</button>
				</div>
			</div>
		</div>

	</div>
</div>



<!-- asmo sh 231213 열매 현황 팝업 추가 -->
<div class="popup_layer_bg" id="status_popup">
	<div class="status_popup">
		<div class="status_box_wrap">
			<div class="status_save_box">
				<div class="status_total_box">
					<p>보유 컬래버 열매 : <span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?></span><span>개</span></p>
				</div>
			</div>
			<div class="status_save">
				<p>사용한 열매 : <span id="fruit_used_count">4000</span>개</p>
			</div>
			
			<div class="status_save">
				<p>총 열매 (보유+사용) : <span id="fruit_total_count">5000</span>개</p>
			</div>
			<a href="<?php echo site_url('cmall/fruit'); ?>">열매 내역</a>
		</div>
		<button id="status_popup_close">
			<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
				<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
				<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
					<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
					<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
				</g>
			</svg>
		</button>
	</div>
</div>

<!-- asmo sh 231221 코인 현황 팝업 추가 -->
<div class="popup_layer_bg" id="coin_popup">
	<div class="status_popup">
		<div class="status_box_wrap">
			<div class="status_save_box">
				<div class="status_total_box">
					<p>보유 <?=busiNm($this->member->item('company_idx'))?> 복지포인트 : <span id="coin_count"><?php echo html_escape($this->member->item('mem_point')); ?></span><span>개</span></p>
				</div>
			</div>
			<div class="status_save">
				<p>사용한 복지포인트 : <span id="coin_used_count">4000</span>개</p>
			</div>
			
			<div class="status_save">
				<p>총 복지포인트 (보유+사용) : <span id="coin_total_count">5000</span>개</p>
			</div>
			<a href="<?php echo site_url('cmall/point'); ?>">복지포인트 내역</a>
		</div>
		<button id="coin_popup_close">
			<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
				<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
				<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
					<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
					<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
				</g>
			</svg>
		</button>
	</div>
</div>



<!-- asmo sh 231221 랭킹 현황 팝업 추가 -->
<div class="popup_layer_bg" id="ranking_popup">
	<div class="ranking_popup">
		<div class="ranking_popup_header">
			<p>랭킹 현황</p>
			<button id="ranking_popup_close">취소</button>
		</div>

		<div class="ranking_popup_body">
			<div class="my_ranking">
				<p>나의 랭킹 <strong id="my_ranking_num"><?=$rank[my_rank]?></strong>위</p>
			</div>

			

			<div class="ranking_info_table">
				<ul>
					<li class="rank_fisrt_li">
						<p>순위</p>
						<p>직원명</p>
						<p>누적열매개수</p>
					</li>
					<div class="rank_scroll_box">
					<?php
					$current_rank = 1; // 초기 순위 설정

					// 이전 순위의 cnt 값
					$prev_cnt = null;
					foreach ($rank['list'] as $result) { 
						// 현재 result의 cnt 값
						$current_cnt = $result['cnt'];
						
						// 이전 순위의 cnt 값과 현재 cnt 값이 다르면 현재 순위를 증가시킴
						if ($prev_cnt !== null && $current_cnt != $prev_cnt) {
							$current_rank++;
						}
					?>
						<li>
							<p class="asmo_<?php echo $current_rank; ?>_rank"><span><?php echo $current_rank; ?></span></p>
							<p class="asmo_<?php echo $current_rank; ?>_name"><?php if($result['mem_nickname']){ echo $result['mem_nickname']; } else { echo $result['mem_username']; }?></p>
							<p><span class="asmo_<?php echo $current_rank; ?>_fruit_cnt"><?php echo number_format($current_cnt); ?></span> 개</p>

							<!-- 랜드 방문하기 -->
							<a href=""><b>방문하기</b></a>
							<!-- 랜드 방문하기 -->
						</li>
					<?php 
						// 이전 순위의 cnt 값을 갱신
						$prev_cnt = $current_cnt;
					} 
					?>
					</div>
					
				</ul>

			</div>
		</div>

		<div class="ranking_popup_bar"></div>

		
	</div>
</div>

<!-- asmo sh 231221 랭킹 현황 팝업 추가 -->
<div class="popup_layer_bg" id="title_list_popup">
	<div class="ranking_popup">
		<div class="ranking_popup_header">
			<p>칭호 목록</p>
			<button id="title_list_popup_close">취소</button>
		</div>

		<div class="title_list_popup_body">
			<div class="my_active_title">
				<div class="my_active_title_header">
					<p>활성된 칭호</p>
					
				</div>
				<?php if($this->member->item('mem_title_no') > 0){?>
				<div class="my_active_title_box">
					<div class="my_active_title_box_header">
						<strong><?=$this->member->item('mem_title')?></strong>
					</div>

					<div class="my_active_title_box_body">
						<div class="my_active_title_box_img">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/farming_king_title.jpg" alt="farming_king_title">
						</div>

						<div class="my_active_title_box_info">
							<p>[획득 조건] <span id="condition_acquire">열매 10개 획득</span></p>
							<p>[획득 일시] <span id="date_acquire">2023-12-20</span></p>
						</div>
					</div>
				</div>
				<?php }else{?>
				<!-- ***** 칭호가 없을 때 ***** -->
				<div class="my_active_title_box no_active_title">
					<div class="my_active_title_box_header">
						<strong>[-]</strong>
					</div>

					<div class="my_active_title_box_body">
						<p>활성화 된 칭호가 없습니다.</p>
					</div>
				</div>
				<?php }?>
			</div>

			<div class="title_list_popup_box_wrap">

				<!-- ********** 활성화 ********** -->
				<div class="title_list_popup_box">
					<div class="title_list_img">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/farming_king_title.jpg" alt="farming_king_title">
					</div>

					<div class="title_list_title">
						<strong>[<span id="title_list_title">위대한 선구자</span>]</strong>
					</div>

					<div class="title_list_date">
						<span id="title_list_date">2023-12-20</span>
					</div>

					<div class="title_list_button">
						<button id="title_list_button" class="active">활성화</button>
					</div>
				</div>


				<!-- ********** 미획득 시 ********** -->
				<div class="title_list_popup_box no_aquire">
					<div class="title_list_img">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/farming_new_title.jpg" alt="farming_new_title">
					</div>

					<div class="title_list_title">
						<strong>[<span id="title_list_title">새내기 낚시꾼</span>]</strong>
					</div>

					<div class="title_list_date">
						<span id="title_list_date">-</span>
					</div>

					<div class="title_list_button">
						<button id="title_list_button">미획득</button>
					</div>
				</div>

				<!-- ********** 준비 중일 때 ********** -->
				<div class="title_list_popup_box ready_title_list_box">
					
						<div class="title_list_img">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/bronze_title.jpg" alt="bronze_title">
						</div>
						<div class="title_list_title">
							<strong>준비중</strong>
						</div>
						<div class="ready_title_list_box_bg">
							
								<strong>[준비중]</strong>
							
						</div>
				</div>

				<!-- ********** 준비 중일 때 ********** -->
				<div class="title_list_popup_box ready_title_list_box">
					
						<div class="title_list_img">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/silver_title.jpg" alt="silver_title">
						</div>
						<div class="title_list_title">
							<strong>준비중</strong>
						</div>
						<div class="ready_title_list_box_bg">
							
								<strong>[준비중]</strong>
							
						</div>
				</div>

				<!-- ********** 준비 중일 때 ********** -->
				<div class="title_list_popup_box ready_title_list_box">
					
						<div class="title_list_img">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/gold_title.jpg" alt="gold_title">
						</div>
						<div class="title_list_title">
							<strong>준비중</strong>
						</div>
						<div class="ready_title_list_box_bg">
							
								<strong>[준비중]</strong>
							
						</div>
				</div>

				<!-- ********** 준비 중일 때 ********** -->
				<div class="title_list_popup_box ready_title_list_box">
					
						<div class="title_list_img">
							<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/diamond_title.jpg" alt="diamond_title">
						</div>
						<div class="title_list_title">
							<strong>준비중</strong>
						</div>
						<div class="ready_title_list_box_bg">
							
								<strong>[준비중]</strong>
							
						</div>
				</div>
			</div>
		</div>

		

		
	</div>
</div>

<!-- asmo sh 231219 feedback iframe 가져오기 -->
<?php if($this->member->item('mem_is_admin') == '0'){ // 최고관리자가 아닌 경우에 노출 ?>
	<a href="javascript:;" class="btn btn-primary " id="feedback_write_btn">
		<p>피드백 남기기</p>
		<div class="feedback_icon_bg"><?=banner('feedback')?></div>
	</a>
<?php } ?>

<div class="popup_layer_bg" id="feedback">
	<iframe style="width: 600px; height: 660px; position:absolute; top:50%; left:50%; transform: translate(-50%, -50%);" src="" frameborder="0"></iframe>
</div>


<!-- asmo sh 231220 일일 퀘스트 팝업창 -->
<div class="popup_layer_bg" id="quest">
	<div class="quest">
		<div class="quest_header">
			<div class="quest_header_left">
				<p>일일 퀘스트</p>
			</div>

			<div class="quest_header_right">
				<button id="quest_close"></button>
			</div>
		</div>
		<div class="quest_main">
			<div class="quest_box_wrap">
				<div class="quest_box quest_complete">
					<div class="quest_text">
						<p id="quest_title">연못에서 1회 물 뜨기</p>
						<strong>[<span id="quest_num">0</span>/<span id="quest_entire_num">1</span>]</strong>
					</div>

					<div class="quest_complete_box_wrap">
						<div class="quest_complete_box">
							<strong>CLEARED !</strong>
						</div>
					</div>
				</div>

				<div class="quest_box">
					<div class="quest_text">
						<p id="quest_title">물고기 1마리 잡기</p>
						<strong>[<span id="quest_num">0</span>/<span id="quest_entire_num">1</span>]</strong>
					</div>

					<div class="quest_complete_box_wrap">
						<div class="quest_complete_box">
							<strong>CLEARED !</strong>
						</div>
					</div>
				</div>

				<div class="quest_box">
					<div class="quest_text">
						<p id="quest_title">동료 랜드 1회 방문하기</p>
						<strong>[<span id="quest_num">0</span>/<span id="quest_entire_num">1</span>]</strong>
					</div>

					<div class="quest_complete_box_wrap">
						<div class="quest_complete_box">
							<strong>CLEARED !</strong>
						</div>
					</div>
				</div>

				<div class="quest_box">
					<div class="quest_text">
						<p id="quest_title">씨앗 1개 획득하기</p>
						<strong>[<span id="quest_num">0</span>/<span id="quest_entire_num">1</span>]</strong>
					</div>

					<div class="quest_complete_box_wrap">
						<div class="quest_complete_box">
							<strong>CLEARED !</strong>
						</div>
					</div>
				</div>

				<div class="quest_box">
					<div class="quest_text">
						<p id="quest_title">씨앗 1번 심기</p>
						<strong>[<span id="quest_num">0</span>/<span id="quest_entire_num">1</span>]</strong>
					</div>

					<div class="quest_complete_box_wrap">
						<div class="quest_complete_box">
							<strong>CLEARED !</strong>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php if ($this->cbconfig->get_device_view_type() === 'mobile') {?>
<div id="side_menu">
	<div class="side_wr add_side_wr">
		<div id="isroll_wrap" class="side_inner_rel">
			<div class="side_inner_abs">
				<div class="m_search">
					<form name="mobile_header_search" id="mobile_header_search" action="<?php echo site_url('search'); ?>" onSubmit="return headerSearch(this);">
						<input type="text" placeholder="Search" class="form-control per80" name="skeyword" accesskey="s" />
					</form>
				</div>
				<div class="m_login">
					<?php if ($this->member->is_member()) { ?>
						<span><a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>" class="btn btn-primary btn-xs" title="로그아웃"> <i class="fa fa-sign-out"></i> 로그아웃 </a></span>
						<span><a href="<?php echo site_url('mypage'); ?>" class="btn btn-primary btn-xs" title="마이페이지"> <i class="fa fa-user"></i> 마이페이지 </a></span>
					<?php } else { ?>
						<span><a href="<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>" class="btn btn-primary btn-xs" title="로그인"> <i class="fa fa-sign-in"></i> 로그인 </a></span>
						<span><a href="<?php echo site_url('register'); ?>" class="btn btn-primary btn-xs" title="회원가입"> <i class="fa fa-user"></i> 회원가입 </a></span>
					<?php } ?>
				</div>
				<ul class="m_board">
					<?php if ($this->cbconfig->item('open_currentvisitor')) { ?>
						<li><a href="<?php echo site_url('currentvisitor'); ?>" title="현재 접속자"><span class="fa fa-link"></span> 현재 접속자</a></li>
					<?php } ?>
					<?php if ($this->member->is_member()) { ?>
						<li><a href="<?php echo site_url('notification'); ?>" title="나의 알림"><span class="fa fa-bell-o"></span>알림 : <?php echo number_format((int) element('notification_num', $layout)); ?> 개</a></li>
						<?php if ($this->cbconfig->item('use_note') && $this->member->item('mem_use_note')) { ?>
							<li><a href="javascript:;" onClick="note_list();" title="나의 쪽지"><span class="fa fa-envelope"></span> 쪽지 : <?php echo number_format((int) $this->member->item('meta_unread_note_num')); ?> 개</a></li>
						<?php } ?>
						<?php if ($this->cbconfig->item('use_point')) { ?>
							<li><a href="<?php echo site_url('mypage/point'); ?>" title="나의 포인트"><span class="fa fa-gift"></span> 포인트 : <?php echo number_format((int) $this->member->item('mem_point')); ?> 점</a></li>
						<?php } ?>
					<?php } ?>
				</ul>
				<ul class="m_menu">
					<?php
					$menuhtml = '';
					if (element('menu', $layout)) {
						$menu = element('menu', $layout);
						if (element(0, $menu)) {
							foreach (element(0, $menu) as $mkey => $mval) {
								if (element(element('men_id', $mval), $menu)) {
									$menuhtml .= '<li class="dropdown">
									<a href="' . element('men_link', $mval) . '" ' . element('men_custom', $mval);
									if (element('men_target', $mval)) {
										$menuhtml .= ' target="' . element('men_target', $mval) . '"';
									}
									$menuhtml .= ' class="text_link" title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a><a href="#" style="width:25px;float:right;" class="subopen" data-menu-order="' . $mkey . '"><i class="fa fa-caret-down"></i></a>
									<ul class="dropdown-custom-menu drop-downorder-' . $mkey . '">';

									foreach (element(element('men_id', $mval), $menu) as $skey => $sval) {
										$menuhtml .= '<li><a href="' . element('men_link', $sval) . '" ' . element('men_custom', $sval);
										if (element('men_target', $sval)) {
											$menuhtml .= ' target="' . element('men_target', $sval) . '"';
										}
										$menuhtml .= ' title="' . html_escape(element('men_name', $sval)) . '">' . html_escape(element('men_name', $sval)) . '</a></li>';
									}
									$menuhtml .= '</ul></li>';

								} else {
									$menuhtml .= '<li><a class="text_link" href="' . element('men_link', $mval) . '" ' . element('men_custom', $mval);
									if (element('men_target', $mval)) {
										$menuhtml .= ' target="' . element('men_target', $mval) . '"';
									}
									$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a></li>';
								}
							}
						}
					}
					echo $menuhtml;
					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.hoverIntent.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ba-outside-events.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/iscroll.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile.sidemenu.js'); ?>"></script>

<?php } ?>

<script type="text/javascript">

	// 사이드바 토글
	const  barToggle_menu = document.querySelectorAll ('#class_sideBar > .BarCon > .barToggle_bg > .barToggle_menu > p')
	const barCon = document.querySelectorAll ('#class_sideBar > .BarCon > ul ')

	barCon[0].classList.toggle('toggleSidebarA')
	barCon[1].style.display = 'none'
	barToggle_menu.forEach(function(t,i){
		t.addEventListener('click',function(){
			for(let j of barCon){j.classList.remove('toggleSidebarA')}
			barCon[i].classList.toggle('toggleSidebarA')
		})
	});
	const barToggle = document.getElementById('barToggle')
	// console.log (barToggle)
	barToggle_menu.forEach(function(t,i){
		t.addEventListener('click',function(){
			barToggle.classList.toggle('toggleBgColor')
			barToggle.classList.toggle('toggleX')
		})
	});
	
	// 열매 현황 팝업창 띄우기 스크립트
	$(document).ready(function() {
		// 열매 박스 클릭 시 열매 팝업창 띄우기
		$('.status_box').on('click', function() {
			$('#status_popup').css('display', 'block');
			$('body,html').css({'overflow':'hidden'});
		});

		// 코인 박스 클릭 시 코인 팝업창 띄우기
		$('.coin_box').on('click', function() {
			$('#coin_popup').css('display', 'block');
			$('body,html').css({'overflow':'hidden'});
		});

		// 랭킹 박스 클릭 시 랭킹 팝업창 띄우기
		$('.rank_box').on('click', function() {
			$('#ranking_popup').css('display', 'block');
			$('body,html').css({'overflow':'hidden'});
		});

		// 칭호 변경 버튼 클릭 시 칭호 목록 팝업창 띄우기
		$('#titleButton').on('click', function() {
			$('#title_list_popup').css('display', 'block');
			$('body,html').css({'overflow':'hidden'});
		});

		// 열매 팝업창 닫기
		$('#status_popup_close').on('click', function() {
			$('#status_popup').css('display', 'none');
			$('body,html').css({'overflow':'initial'});
		});

		// 코인 팝업창 닫기
		$('#coin_popup_close').on('click', function() {
			$('#coin_popup').css('display', 'none');
			$('body,html').css({'overflow':'initial'});
		});

		// 랭킹 팝업창 닫기
		$('#ranking_popup_close').on('click', function() {
			$('#ranking_popup').css('display', 'none');
			$('body,html').css({'overflow':'initial'});
		});

		// 칭호 목록 팝업창 닫고 랭킹 팝업창 띄우기
		$('#title_list_popup_close').on('click', function() {
			$('#title_list_popup').css('display', 'none');
			$('body,html').css({'overflow':'initial'});
		});



		$('#feedback_write_btn').click(function() {
			let iframeSrc = '<?php echo site_url('/feedback/write'); ?>';
			$('#feedback iframe').attr('src', iframeSrc);
			
			$('#feedback').css('display', 'block');
		});

		$("#feedback iframe").load(function() {
			let dimCloseBtn = $("#feedback iframe").contents().find(".btn-default");
			let dimSubmitBtn = $("#feedback iframe").contents().find(".btn-primary");
			
			dimCloseBtn.click(function() {
				$('#feedback').css('display', 'none');
			});
			
		});

		$('.quest_menu_btn').click(function() {
			$('#quest').css('display', 'block');
			$('body,html').css({'overflow':'hidden'});
		});

		$('#quest_close').click(function() {
			$('#quest').css('display', 'none');
			$('body,html').css({'overflow':'initial'});

		});

		$('.notice_menu_btn').click(function() {
			$('#notice_popup').css('display', 'block');
			$('body,html').css({'overflow':'hidden'});
		});

		$('#npopClose').click(function() {
			$('#notice_popup').css('display', 'none');
			$('body,html').css({'overflow':'initial'});

		});
	});



$(document).on('click', '.viewpcversion', function(){
	Cookies.set('device_view_type', 'desktop', { expires: 1 });
});
$(document).on('click', '.viewmobileversion', function(){
	Cookies.set('device_view_type', 'mobile', { expires: 1 });
});



</script>
<?php echo element('popup', $layout); ?>
<?php echo $this->cbconfig->item('footer_script'); ?>
<!--
Layout Directory : <?php echo element('layout_skin_path', $layout); ?>,
Layout URL : <?php echo element('layout_skin_url', $layout); ?>,
Skin Directory : <?php echo element('view_skin_path', $layout); ?>,
Skin URL : <?php echo element('view_skin_url', $layout); ?>,
-->
</body>
</html>
