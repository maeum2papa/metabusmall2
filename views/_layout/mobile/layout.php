<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="format-detection" content="telephone=no"><!-- 사파리 전화번호 인식 차단 -->
<title><?php echo html_escape(element('page_title', $layout)); ?></title>
<?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
<?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
<?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
<?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
<?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" />
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" />
<?php echo $this->managelayout->display_css(); ?>

<!-- asmo sh 231113 seum_custom.css, 폰트 cdn, swiper link cdn 추가 -->
<link href="https://webfontworld.github.io/NexonLv2Gothic/NexonLv2Gothic.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/seum_custom.css" />

<link
	rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<!-- //asmo sh 231113 seum_custom.css, 폰트 cdn, swiper link cdn 추가 -->

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.hoverIntent.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ba-outside-events.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/iscroll.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile.sidemenu.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>

<!-- asmo sh 231113 swiper script cdn 추가 -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- //asmo sh 231113 swiper script cdn 추가 -->

<?php echo $this->managelayout->display_js(); ?>
</head>
<body <?php echo isset($view) ? element('body_script', $view) : ''; ?>>
<!-- asmo lhb 231214 로그인전일 때 asmo_login_wrapper 클래스 지정 -->
<div class="wrapper <?php if  ($this->member->is_member()) { ?>asmo_login_complete<?php }else{ ?>asmo_login_wrapper<?php }?> ">
	<!-- header start -->
	<!-- asmo lhb 231214 헤더라인 미노출영역으로 주석처리 -->
	<!-- <div class="header_line"></div> -->
	<!-- nav start -->
	<!-- asmo lhb 231214 네비바 픽스 메뉴로 구성 변경 로그인 시에만 보이도록 -->
	<?php if ($this->member->is_member()) { ?>
	<nav class="navbar">
		<div class="nav_bar_left">
			<div class="asmo_nav_logo" onclick="location.href='/dashboard';">
				<img src="<?php echo element('layout_skin_url', $layout); ?>/images/logo_top.svg" alt="컬래버랜드">
			</div>
			<div class="asmo_nav_info">
				<p class="asmo_small_profile">
					<!-- 유저 이미지 들어갈 곳 -->
					<img src="<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/<?php echo html_escape($this->member->item('mem_id')); ?>_preview.png?v=<?php echo mt_rand(); ?>" alt="preview_img" onerror="this.onerror=null; this.src='<?php echo element('layout_skin_url', $layout); ?>/../bootstrap/seum_img/preview/character_default.png'">
				</p>
				<div class="asmo_nav_info_txt">
					<p><span><?php echo html_escape($this->member->item('mem_nickname')); ?></span><em><?php echo html_escape($this->member->item('mem_position')); ?></em></p>
					<p><?php echo html_escape($this->member->item('mem_div')); ?></p>
				</div>
			</div>
			<div class="asmo_nav_money_wrap">
				<ul>
					<li class="asmo_nav_money_box fruit asmo_fruit"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?></li>
					<li class="asmo_nav_money_box seed asmo_point"><?php echo html_escape($this->member->item('mem_point')); ?></li>
					<li class="asmo_nav_money_box rank asmo_rank asmo_rank_popup"><?php echo element('myrank', element('ranking', element('data', $view))); ?>위</li>
				</ul>
			</div>
		</div>
		<div class="nav_bar_right">
			<div id="asmo_nav_quset_btn"></div>
			<div id="asmo_nav_qa_btn"><span></span></div>
			<div id="asmo_nav_logout">
			</div>
			<p>
				<!-- 기업관리자 등급일 때만 해당 메뉴 노출  -->
				<?php if($this->member->item('mem_level') == 100 && $this->session->userdata('mem_admin_flag') != '0'){ ?>
				<a class="asmo_admin_menu" href="https://<?=busiCode($this->member->item('company_idx'))?>.collaborland.kr/admin"><span>기업관리</span></a>
				<?php } ?>
				<a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>"><span>로그아웃</span></a>
			</p>
		</div>
	</nav>
	<?php } ?>
	<!-- //asmo lhb 231214 네비바 픽스 메뉴로 구성 변경 로그인 시에만 보이도록 -->



	<?php

		$request_uri = $_SERVER['REQUEST_URI']; // 현재 url

		//asmo lhb 231218 클래스룸 메인이랑 과정목록 페이지에서만 노출
		if( $request_uri == '/classroom' || $request_uri == '/classroom/business_class' ){

	?>
	<div id="asmo_class_nav">
		<ul>
			<li class="dropdown all asmo-depth0">
				<a id="asmo_all_menu"  href="javascript:;">
					전체 카테고리
				</a>
				<ul class="dropdown-menu nav navbar-nav">
				<?php
				$menuhtml = '';
				if (element('menu', $layout)) {
					$menu = element('menu', $layout);
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
								<ul class="asmo_all_menu_wrap">';

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
				$menu = element('menu', $layout);
				if (element(0, $menu)) {
					foreach (element(0, $menu) as $mkey => $mval) {
						if (element(element('men_id', $mval), $menu)) {
							$mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
							$men_name = html_escape(element('men_name', $mval));
							$menuhtml .= '<li class="dropdown asmo-depth0 asmo_other_cate">
							<a href="' . $mlink . '" ' . element('men_custom', $mval);
							if (element('men_target', $mval)) {
								$menuhtml .= ' target="' . element('men_target', $mval) . '"';
							}
							$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a>
							<ul class="dropdown-menu"><span>' . html_escape(element('men_name', $mval)) . '</span><div class="dropdown-menu-wrap asmo_cate_depth01_wrap">';

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
							$menuhtml .= '<li class="asmo-depth0 asmo_other_cate"><a href="' . $mlink . '" ' . element('men_custom', $mval);
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
	</div>
	<?php
	}
	?>

	<!-- nav end -->
	<!-- header end -->

	<!-- main start -->
	<div class="main">
		<div class="container">

			<!-- 본문 시작 -->
			<?php if (isset($yield))echo $yield; ?>
			<!-- 본문 끝 -->

		</div>
	</div>
	<!-- main end -->


	<!-- asmo lhb 231214 로그인 시 하단 퀵바 삽입 -->
	<?php if ($this->member->is_member()) { ?>
	<div id="asmo_fixed_bar">
		<ul>
			<li class="asmo_q_office"><a href="<?php echo site_url('land/office'); ?>"><span><?=busiNm($this->member->item('company_idx'))?>랜드</span></a></li>
			<li class="asmo_q_my"><a href="<?php echo site_url('myland/space'); ?>"><span>마이랜드</span></a></li>
			<li class="asmo_q_class <?php if(  element('view_skin_path', $layout) == 'classroom/mobile' ){ ?>active<?php }?>"><a href="<?php echo site_url('classroom'); ?>"><span>클래스룸</span></a></li>
			<li class="asmo_q_shop <?php if(  element('view_skin_path', $layout) == 'cmall/mobile' ){ ?>active<?php }?>"><a href="<?php echo site_url('cmall'); ?>"><span>SHOP</span></a></li>
		</ul>
	</div>
	<?php } ?>
	<!-- //asmo lhb 231214 로그인 시 하단 퀵바 삽입 -->

	<!-- footer start -->
	<!-- asmo lhb 231214 푸터 미노출 -->
	<!-- 푸터는 회원,랜드,대쉬보드만 미노출임 -->
	<footer>
		<div class="asmo_ft_logo_wrap"><?=banner('ft_logo_m')?></div>
		
		<div class="asmo_ft_container">
			<ul class="company pull-left">
				<li><?php if ($this->cbconfig->item('company_address')) { ?><?php echo $this->cbconfig->item('company_address'); ?><?php if ($this->cbconfig->item('company_zipcode')) { ?>(우편 <?php echo $this->cbconfig->item('company_zipcode'); ?>)<?php } ?><?php } ?><?php if ($this->cbconfig->item('company_name')) { ?><b><?php echo $this->cbconfig->item('company_name'); ?></b><?php } ?></li>
				<li><?php if ($this->cbconfig->item('company_reg_no')) { ?>사업자등록번호 <?php echo $this->cbconfig->item('company_reg_no'); ?><?php } ?></li>
				<li><?php if ($this->cbconfig->item('company_phone')) { ?>대표번호 <?php echo $this->cbconfig->item('company_phone'); ?><?php } ?><?php if ($this->cbconfig->item('company_fax')) { ?><span>FAX <?php echo $this->cbconfig->item('company_fax'); ?></span><?php } ?></li>
			</ul>
			<div class="see_mobile" style="display:none;"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-xs viewpcversion">PC 버전으로 보기</a></div>
		</div>
	</footer>
	<!-- footer end -->
</div>

<div class="menu" id="side_menu">
	<div class="side_wr add_side_wr">
		<div id="isroll_wrap" class="side_inner_rel">
			<div class="side_inner_abs">
				<div class="m_search">
					<form name="mobile_header_search" id="mobile_header_search" action="<?php echo site_url('search'); ?>" onSubmit="return headerSearch(this);">
						<input type="text" placeholder="Search" class="input" name="skeyword" accesskey="s" />
					</form>
				</div>
				<div class="m_login">
					<?php if ($this->member->is_member()) { ?>
						<span><a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>" class="btn btn-primary" title="로그아웃"><i class="fa fa-sign-out"></i> 로그아웃</a></span>
						<span><a href="<?php echo site_url('mypage'); ?>" class="btn btn-primary" title="로그아웃"><i class="fa fa-user"></i> 마이페이지</a></span>
					<?php } else { ?>
						<span><a href="<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>" class="btn btn-primary" title="로그인"><i class="fa fa-sign-in"></i> 로그인</a></span>
						<span><a href="<?php echo site_url('register'); ?>" class="btn btn-primary" title="회원가입"><i class="fa fa-user"></i> 회원가입</a></span>
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
									$mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
									$menuhtml .= '<li class="dropdown">
									<a href="' . $mlink . '" ' . element('men_custom', $mval);
									if (element('men_target', $mval)) {
										$menuhtml .= ' target="' . element('men_target', $mval) . '"';
									}
									$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a><a href="#" style="width:25px;float:right;" class="subopen" data-menu-order="' . $mkey . '"><i class="fa fa-chevron-down"></i></a>
									<ul class="dropdown-menu drop-downorder-' . $mkey . '">';

									foreach (element(element('men_id', $mval), $menu) as $skey => $sval) {
										$menuhtml .= '<li><a href="' . element('men_link', $sval) . '" ' . element('men_custom', $sval);
										if (element('men_target', $sval)) {
											$menuhtml .= ' target="' . element('men_target', $sval) . '"';
										}
										$menuhtml .= ' title="' . html_escape(element('men_name', $sval)) . '">' . html_escape(element('men_name', $sval)) . '</a></li>';
									}
									$menuhtml .= '</ul></li>';

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
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- asmo lhb 231220 레이어 딤 추가 -->
<div id="layer_dim" class="dn"></div>

<!-- asmo lhb 231220 열매, 코인 팝업 추가  -->
<div class="asmo_cmall_main_popup_wrap dn" id="asmo_fruit_popup">
	<div class="asmo_popup_close">닫기</div>
	<div class="asmo_cmall_popup_box">
		<ul>
			<li class="asmo_popup_tit"><em></em><span>보유 열매 : <b><?php echo html_escape($this->member->item('mem_cur_fruit')); ?>개</b></span></li>
			<li>사용한 열매 : <span>100개</span></li>
			<li>총 열매 (보유+사용) : <span>100개</span></li>
		</ul>
		<a href="<?php echo site_url('cmall/fruit'); ?>">열매 내역</a>
	</div>
</div>
<div class="asmo_cmall_main_popup_wrap dn" id="asmo_coin_popup">
	<div class="asmo_popup_close">닫기</div>
	<div class="asmo_cmall_popup_box">
		<ul>
			<li class="asmo_popup_tit"><em></em><span>보유 컬래버 코인 : <b><?php echo html_escape($this->member->item('mem_point')); ?>개</b></span></li>
			<li>사용한 컬래버 코인 : <span>100개</span></li>
			<li>총 컬래버 코인 (보유+사용) : <span>100개</span></li>
		</ul>
		<a href="<?php echo site_url('cmall/point'); ?>">컬래버 코인 내역</a>
	</div>
</div>
<!-- //asmo lhb 231220 열매, 코인 팝업 추가  -->


<!-- asmo lhb 231221 일일퀘스트 팝업 추가  -->
<div class="asmo_cmall_main_popup_wrap dn" id="asmo_quest_popup">
	<div class="asmo_popup_close">닫기</div>
	<div class="asmo_popup_tit">일일 퀘스트</div>
	<div class="asmo_cmall_popup_box">
		<ul>
			<!-- asmo lhb 231221 퀘스트 클리어 시 clear 클래스 추가, 카운팅 1  -->
			<li class="clear"><span>연못에서 물 1회 뜨기</span><em>CLEARED !</em><strong>[1/1]</strong></li>
			<li><span>물고기 1마리 잡기</span><em>CLEARED !</em><strong>[0/1]</strong></li>
			<li><span>동료 랜드 1회 방문하기</span><em>CLEARED !</em><strong>[0/1]</strong></li>
			<li><span>씨앗 1개 획득하기</span><em>CLEARED !</em><strong>[0/1]</strong></li>
			<li><span>씨앗 1번 심기</span><em>CLEARED !</em><strong>[0/1]</strong></li>
		</ul>
	</div>
	<!-- 전체 퀘스트 완료 시 레이어 dn 클래스 삭제하여서 노출 처리하면 됨 -->
	<div class="asmo_quest_end_layer dn">
		<p>일일퀘스트를 완료하였습니다.<br><b>비료 1개</b>가 지급되었습니다</p>
	</div>
</div>
<!-- //asmo lhb 231221 일일퀘스트 팝업 추가 끝 -->

<!-- asmo lhb 231221 랭킹 팝업 추가  -->
<div class="asmo_cmall_main_popup_wrap dn" id="asmo_rank_popup">
	<div class="asmo_popup_close">닫기</div>
	<div class="asmo_popup_tit">랭킹 현황</div>
	<div class="asmo_cmall_popup_box">
		<div class="my_rank_status"><span>나의 랭킹 <strong><?php echo element('myrank', element('ranking', element('data', $view))); ?></strong>위</span></div>
		<div class="my_rank_nickname">
			<div class="asmo_rank_tit">
				<b>활성된칭호</b><div id="change_nickname">칭호 변경</div>
			</div>
			<div class="nickname_box">
				<div class="nick_box_tit">[위대한 선구자]</div>
				<div class="nick_box_cont">
					<div class="nick_left_img">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick01.jpg" alt="위대한선구자">
					</div>
					<div class="nick_right_txt">
						<p>
							<b>[획득 조건]</b><br>
							열매 10개 획득
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="rank_scroll_box">
			<div class="rank_box_tit"><span>순위</span><span>닉네임</span><span>누적 열매</span></div>
			<ul>
				<?php foreach (element('list', element('ranking', element('data', $view))) as $result) { ?>
					<li class="asmo_rank_0<?php echo $result['num']; ?>">
						<em><?php echo $result['num']; ?></em>
						<b><?php if($result['mem_username']){ echo $result['mem_username']; } else { echo $result['mem_nickname']; }?></b>
						<b><?php echo number_format($result['cnt']); ?>개</b>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<div class="asmo_cmall_main_popup_wrap dn" id="asmo_nickname_popup">
	<div class="asmo_popup_close">닫기</div>
	<div class="asmo_popup_tit">칭호 목록</div>
	<div class="asmo_cmall_popup_box">
		<ul class="my_nickname_list">
			<!-- asmo lhb 231221 칭호 활성화 시 active 클래스 추가  -->
			<li class="active">
				<div class="my_nickname_img_box">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick01.jpg" alt="위대한선구자">
				</div>
				<b>[위대한 선구자]</b>
				<em>2023.12.30</em>
				<span class="asmo_nick_btn">활성화</span>
				<div class="asmo_ing_mask dn">
					<p>[준비중]</p>
				</div>
			</li>
			<li>
				<div class="my_nickname_img_box">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick02.jpg" alt="새내기낚시꾼">
				</div>
				<b>[새내기 낚시꾼]</b>
				<em>-</em>
				<span class="asmo_nick_btn">미획득</span>
				<div class="asmo_ing_mask dn">
					<p>[준비중]</p>
				</div>
			</li>
			<li>
				<div class="my_nickname_img_box">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick03.jpg" alt="칭호이미지예시">
				</div>
				<b></b>
				<em></em>
				<span class="asmo_nick_btn"></span>
				<div class="asmo_ing_mask">
					<p>[준비중]</p>
				</div>
			</li>
			<li>
				<div class="my_nickname_img_box">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick04.jpg" alt="칭호이미지예시">
				</div>
				<b></b>
				<em></em>
				<span class="asmo_nick_btn"></span>
				<div class="asmo_ing_mask">
					<p>[준비중]</p>
				</div>
			</li>
			<li>
				<div class="my_nickname_img_box">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick05.jpg" alt="칭호이미지예시">
				</div>
				<b></b>
				<em></em>
				<span class="asmo_nick_btn"></span>
				<div class="asmo_ing_mask">
					<p>[준비중]</p>
				</div>
			</li>
			<li>
				<div class="my_nickname_img_box">
					<img src="<?php echo element('layout_skin_url', $layout); ?>/images/nick06.jpg" alt="칭호이미지예시">
				</div>
				<b></b>
				<em></em>
				<span class="asmo_nick_btn"></span>
				<div class="asmo_ing_mask">
					<p>[준비중]</p>
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- //asmo lhb 231221 랭킹 팝업 추가 끝 -->



<!-- asmo sh 240103 공지사항 팝업 추가 -->
<div class="popup_layer_bg" id="notice_popup">
	<div class="notice_popup">
        <div class="npopTop">
            <h1>
				<!-- <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/notice_icon.svg" alt="notice_icon">  -->
				<?=busiNm($this->member->item('company_idx'))?> 공지사항
			</h1>
            <button id="npopClose"><img src="<?php echo element('layout_skin_url', $layout); ?>/images/npop_close.svg" alt="npop_close"></button>
        </div>
        <div class="npopBtm">
            <div class="notice_contents notice1">
                <!-- 첫번째 공지사항입니다 -->
                <h2>기업랜드 내 규칙 공지</h2> <!-- 제목 -->
                <div class="npopCon">
                    <p class="npop_img"><img src="<?php echo element('layout_skin_url', $layout); ?>/images/npop_itemSet.png" alt="npop_itemSet"></p> <!-- 이미지 공간입니다 -->
                    <div class="npopConBtm">
                        <!-- 내용 -->
                        <p>기업랜드에서 지켜야 할 규칙 공지 안내 드립니다.</p>
                        <p>1. 보이는 사람한테는 인사는 꼭 해주세요!</p>
                    </div>
                    <a href="" class="npop_plus"><img src="<?php echo element('layout_skin_url', $layout); ?>/images/npop_plus.svg" alt="npop_plus"></a>
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

                    <a href="" class="npop_plus"><img src="<?php echo element('layout_skin_url', $layout); ?>/images/npop_plus.svg" alt="npop_plus"></a>
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
                    <a href="" class="npop_plus"><img src="<?php echo element('layout_skin_url', $layout); ?>/images/npop_plus.svg" alt="npop_plus"></a>
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
<!-- asmo sh 240103 공지사항 팝업 추가 끝 -->


<script type="text/javascript">
	

//asmo lhb 231220 열매, 코인 팝업 이벤트

$('.asmo_fruit').click(function(){
	$('#asmo_fruit_popup, #layer_dim').removeClass('dn');
	$('body,html').css({'overflow':'hidden'});
});

$('.asmo_point').click(function(){
	$('body,html').css({'overflow':'hidden'});
	$('#asmo_coin_popup, #layer_dim').removeClass('dn');
});

$('.asmo_popup_close').click(function(){
	$(this).parent().addClass('dn');
	$('#layer_dim').addClass('dn');
	$('body,html').css({'overflow':'initial'});
});

//asmo lhb 231220 열매, 코인 팝업 이벤트 끝

//asmo lhb 231220 일일퀘스트 팝업 이벤트 
$('#asmo_nav_quset_btn').click(function(){
	$('body,html').css({'overflow':'hidden'});
	$('#asmo_quest_popup, #layer_dim').removeClass('dn');
});
//asmo lhb 231220 일일퀘스트 팝업 이벤트  끝


//asmo lhb 231220 랭킹 팝업 이벤트 
$('.asmo_rank_popup').click(function(){
	$('body,html').css({'overflow':'hidden'});
	$('#asmo_rank_popup, #layer_dim').removeClass('dn');
});

$('#change_nickname').click(function(){
	$('body,html').css({'overflow':'hidden'});
	$('#asmo_rank_popup').addClass('dn');
	$('#asmo_nickname_popup, #layer_dim').removeClass('dn');
});

//asmo lhb 231220 랭킹 팝업 이벤트  끝

//asmo lhb 231220 공지사항 팝업 이벤트 
$('#npopClose').click(function(){
	$('#notice_popup').css('display', 'none');
});

//asmo lhb 231220 공지사항 팝업 이벤트  끝



//asmo lhb 231215 로그아웃 토글 이벤트

$('#asmo_nav_logout').click(function(){
	$(this).hasClass('active') ? $(this).removeClass('active') : $(this).addClass('active');
});

//asmo lhb 231215 로그아웃 토글 이벤트 끝




//asmo lhb 231214 모바일웹에서 주소창 고려한 width, height 계산 
// let vh = window.innerHeight * 0.01;

// document.documentElement.style.setProperty("--vh", `${vh}px`);

// let vw = window.innerWidth * 0.01;

// document.documentElement.style.setProperty("--vw", `${vw}px`);






// window.addEventListener("resize", () => {
//   	console.log("resize");
//   	if (window.matchMedia('(orientation: portrait)').matches) { //세로모드일때 계산
// 		console.log("portrait");
// 		let vh = window.innerHeight * 0.01;

// 		document.documentElement.style.setProperty("--vh", `${vh}px`);

// 		let vw = window.innerWidth * 0.01;

// 		document.documentElement.style.setProperty("--vw", `${vw}px`);
// 	}
// });





//asmo lhb 231214 모바일웹에서 주소창 고려한 width, height 계산 


//asmo lhb 231219 클래스룸 상단 카테고리 클릭 이벤트

var asmoClassCate = document.querySelectorAll('.asmo-depth0');

asmoClassCate.forEach((el, index) => {

	el.onclick = () => {

		console.log(el.children[0]);
		console.log(el.children[1]);

		
		el.children[0].classList.toggle('active');
		el.children[1].classList.toggle('active');
		

	}

});





$('.asmo_other_cate').each(function(index,item){
	



	var left = $(this).offset().left;
	var cateWidth = $('#asmo_class_nav > ul').width();
	var myWidth = $(this).width();
	var allCateWidth = $('#asmo_all_menu').width();
	
	var myCateWidth = cateWidth - myWidth - allCateWidth;

	var ul = $(this).children('.dropdown-menu');

	ul.width(cateWidth);

});


//asmo lhb 231219 클래스룸 상단 카테고리 클릭 이벤트 끝



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
