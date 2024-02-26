<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=1180">
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
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo base_url('assets/js/html5shiv.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>
<?php echo $this->managelayout->display_js(); ?>
</head>
<body <?php echo isset($view) ? element('body_script', $view) : ''; ?>>
<div class="wrapper">

<!-- asmo sh 231201 디자인 상 basic/layout 에서 헤더, nav바, footer가 불필요하여 주석처리 -->
	<!-- header start -->
	<!-- <header class="header">
		<div class="container">
			<ul class="header-top-menu">
				<?php if ($this->member->is_admin() === 'super') { ?>
					<li><i class="fa fa-cog"></i><a href="<?php echo site_url(config_item('uri_segment_admin')); ?>" title="관리자 페이지로 이동">관리자</a></li>
				<?php } ?>
				<?php
				if ($this->member->is_member()) {
					if ($this->cbconfig->item('use_notification')) {
				?>
					<li class="notifications"><i class="fa fa-bell-o"></i>알림 <span class="badge notification_num"><?php echo number_format((int) element('notification_num', $layout)); ?></span>
						<div class="notifications-menu"></div>
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
					<li><i class="fa fa-user"></i><a href="<?php echo site_url('register'); ?>" title="회원가입">회원가입</a></li>
				<?php } ?>
				<?php if ($this->cbconfig->item('open_currentvisitor')) { ?>
					<li><i class="fa fa-link"></i><a href="<?php echo site_url('currentvisitor'); ?>" title="현재접속자">현재접속자</a> <span class="badge"><?php echo element('current_visitor_num', $layout); ?></span></li>
				<?php } ?>
			</ul>
		</div>
	</header> -->
	<!-- header end -->

	<!-- nav start -->
	<!-- <nav class="navbar">
		<div class="container">
			<div class="logo pull-left">
				<a href="<?php echo site_url(); ?>" title="<?php echo html_escape($this->cbconfig->item('site_title'));?>"><?php echo $this->cbconfig->item('site_logo'); ?></a>
			</div>
			<ul class="menu pull-right">
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
								$menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a>
								<ul class="dropdown-menu">';

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
				<li>
					<form name="header_search" id="header_search" action="<?php echo site_url('search'); ?>" onSubmit="return headerSearch(this);">
						<input type="text" placeholder="Search" class="input" name="skeyword" accesskey="s" />
						<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
					</form>
					<script type="text/javascript">
					//<![CDATA[
					$(function() {
						$('.dropdown').hover(function() {
							$(this).addClass('open');
						}, function() {
							$(this).removeClass('open');
						});
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
				</li>
			</ul>
		</div>
	</nav> -->
	<!-- nav end -->

	<!-- main start -->
	<div class="main">
		<div class="container">
			<?php if (element('use_sidebar', $layout)) {?>
				<div class="left">
			<?php } ?>

			<!-- 본문 시작 -->
			<?php if (isset($yield))echo $yield; ?>
			<!-- 본문 끝 -->

			<?php if (element('use_sidebar', $layout)) {?>

				</div>
				<div class="sidebar">
					<?php $this->load->view(element('layout_skin_path', $layout) . '/sidebar'); ?>
				</div>

			<?php } ?>

		</div>
	</div>
	<!-- main end -->

	<!-- footer start -->
	<!-- <footer>
		<div class="container">
			<div>
				<ul class="company">
					<li><a href="<?php echo document_url('aboutus'); ?>" title="회사소개">회사소개</a></li>
					<li><a href="<?php echo document_url('provision'); ?>" title="이용약관">이용약관</a></li>
					<li><a href="<?php echo document_url('privacy'); ?>" title="개인정보 취급방침">개인정보 취급방침</a></li>
					<li><a href="<?php echo site_url('pointranking'); ?>" title="포인트 전체랭킹">포인트 전체랭킹</a></li>
					<li><a href="<?php echo site_url('pointranking/month'); ?>" title="포인트 월별랭킹" >포인트 월별랭킹</a></li>
					<li><a href="<?php echo site_url('levelup'); ?>" title="레벨업">레벨업</a></li>
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
	</footer> -->
	<!-- footer end -->
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

<!-- asmo sh 231213 열매 현황 팝업 추가 -->
<div class="popup_layer_bg" id="status_popup">
	<div class="status_popup">
		<div class="status_box_wrap">
			<div class="status_save_box">
				<div class="status_total_box">
					<div class="status_icon"><?=banner('fruit')?></div>
					<p>보유 열매 : <span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?></span><span>개</span></p>
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

<!-- asmo sh 231221 복지포인트 현황 팝업 추가 -->
<div class="popup_layer_bg" id="coin_popup">
	<div class="status_popup">
		<div class="status_box_wrap">
			<div class="status_save_box">
				<div class="status_total_box">
					<div class="status_icon"><?=banner('coin')?></div>
					<p>보유 복지포인트 : <span id="coin_count"><?php echo html_escape($this->member->item('mem_point')); ?></span><span>개</span></p>
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

<!-- asmo sh 231221 랭킹 현황 팝업 추가 -->
<div class="popup_layer_bg" id="lanking_popup">
	<div class="lanking_popup">
		<div class="lanking_popup_header">
			<p>랭킹 현황</p>
			<button id="lanking_popup_close">취소</button>
		</div>

		<div class="lanking_popup_body">
			<div class="my_lanking">
				<p>나의 랭킹 <strong id="my_lanking_num"><?php echo html_escape($this->member->item('mem_ranking')); ?></strong>위</p>
			</div>

			<div class="my_active_title">
				<div class="my_active_title_header">
					<p>활성된 칭호</p>
					<button id="change_my_active_title">칭호 변경</button>
				</div>
			
				<div class="my_active_title_box">
					<div class="my_active_title_box_header">
						<strong>위대한 선구자</strong>
					</div>

					<div class="my_active_title_box_body">
						<div class="my_active_title_box_img">
							이미지 배너
						</div>

						<div class="my_active_title_box_info">
							<p>[획득 조건]</p>
							<p id="condition_acquire">열매 10개 획득</p>
						</div>
					</div>
				</div>

				<!-- ***** 칭호가 없을 때 ***** -->
				<!-- <div class="my_active_title_box no_active_title">
					<div class="my_active_title_box_header">
						<strong>[-]</strong>
					</div>

					<div class="my_active_title_box_body">
						<p>활성화 된 칭호가 없습니다.</p>
					</div>
				</div> -->
					
			</div>

			<div class="lanking_info_table">
				<ul>
					<li class="lank_fisrt_li">
						<p>순위</p>
						<p>닉네임</p>
						<p>누적열매개수</p>
					</li>
					<div class="lank_scroll_box">
						<li>
							<p id="1st_rank"><span>1</span></p>
							<p id="1st_name">김철수</p>
							<p><span id="1st_fruit_cnt">80</span> 개</p>
						</li>
						<li>
							<p id="2nd_rank"><span>2</span></p>
							<p id="2nd_name">김영희</p>
							<p><span id="2nd_fruit_cnt">72</span> 개</p>
						</li>
						<li>
							<p id="3rd_rank"><span>3</span></p>
							<p id="3rd_name"><?php echo html_escape($this->member->item('mem_nickname')); ?></p>
							<p><span id="3rd_fruit_cnt">72</span> 개</p>
						</li>
						<li>
							<p id="4rd_rank">4</p>
							<p id="4rd_name">김영수</p>
							<p><span id="4rd_fruit_cnt">72</span> 개</p>
						</li>
						<li>
							<p id="5rd_rank">5</p>
							<p id="5rd_name">홍길순</p>
							<p><span id="5rd_fruit_cnt">72</span> 개</p>
						</li>
						<li>
							<p id="6rd_rank">6</p>
							<p id="6rd_name">홍길순</p>
							<p><span id="6rd_fruit_cnt">72</span> 개</p>
						</li>
						<li>
							<p id="7rd_rank">7</p>
							<p id="7rd_name">홍길순</p>
							<p><span id="7rd_fruit_cnt">72</span> 개</p>
						</li>
						<li>
							<p id="8rd_rank">8</p>
							<p id="8rd_name">홍길순</p>
							<p><span id="8rd_fruit_cnt">72</span> 개</p>
						</li>
					</div>
					
				</ul>

			</div>
		</div>

		<div class="lanking_popup_bar"></div>

		
	</div>
</div>

<!-- asmo sh 231221 랭킹 현황 팝업 추가 -->
<div class="popup_layer_bg" id="title_list_popup">
	<div class="lanking_popup">
		<div class="lanking_popup_header">
			<p>칭호 목록</p>
			<button id="title_list_popup_close">취소</button>
		</div>

		<div class="title_list_popup_body">
			<div class="title_list_popup_box_wrap">

				<!-- ********** 비활성화 ********** -->
				<div class="title_list_popup_box">
					<div class="title_list_img">
						이미지 들어갈 곳
					</div>

					<div class="title_list_title">
						<strong>[<span id="title_list_title">위대한 선구자</span>]</strong>
					</div>

					<div class="title_list_date">
						<span id="title_list_date">2023.12.20</span>
					</div>

					<div class="title_list_button">
						<button id="title_list_button">비활성화</button>
					</div>
				</div>

				<!-- ********** 활성화 ********** -->
				<div class="title_list_popup_box">
					<div class="title_list_img">
						이미지 들어갈 곳
					</div>

					<div class="title_list_title">
						<strong>[<span id="title_list_title">위대한 선구자</span>]</strong>
					</div>

					<div class="title_list_date">
						<span id="title_list_date">2023.12.20</span>
					</div>

					<div class="title_list_button">
						<button id="title_list_button" class="active">활성화</button>
					</div>
				</div>


				<!-- ********** 미획득 시 ********** -->
				<div class="title_list_popup_box no_aquire">
					<div class="title_list_img">
						이미지 들어갈 곳
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
							이미지 들어갈 곳
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
							이미지 들어갈 곳
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
							이미지 들어갈 곳
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


<!-- //asmo sh 231201 디자인 상 basic/layout 에서 헤더, nav바, footer가 불필요하여 주석처리 -->


<script type="text/javascript">

	// 열매 현황 팝업창 띄우기 스크립트
	$(document).ready(function() {
		// 열매 박스 클릭 시 열매 팝업창 띄우기
		$('.status_box').on('click', function() {
			$('#status_popup').css('display', 'block');
		});

		// 복지포인트 박스 클릭 시 복지포인트 팝업창 띄우기
		$('.coin_box').on('click', function() {
			$('#coin_popup').css('display', 'block');
		});

		// 랭킹 박스 클릭 시 랭킹 팝업창 띄우기
		$('.lank_box').on('click', function() {
			$('#lanking_popup').css('display', 'block');
		});

		// 칭호 변경 버튼 클릭 시 칭호 목록 팝업창 띄우기
		$('#change_my_active_title').on('click', function() {
			$('#title_list_popup').css('display', 'block');
			$('#lanking_popup').css('display', 'none');
		});

		// 열매 팝업창 닫기
		$('#status_popup_close').on('click', function() {
			$('#status_popup').css('display', 'none');
		});

		// 복지포인트 팝업창 닫기
		$('#coin_popup_close').on('click', function() {
			$('#coin_popup').css('display', 'none');
		});

		// 랭킹 팝업창 닫기
		$('#lanking_popup_close').on('click', function() {
			$('#lanking_popup').css('display', 'none');
		});

		// 칭호 목록 팝업창 닫고 랭킹 팝업창 띄우기
		$('#title_list_popup_close').on('click', function() {
			$('#title_list_popup').css('display', 'none');
			$('#lanking_popup').css('display', 'block');
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

		// 일일 퀘스트 팝업창 스크립트
		$('#quest_menu').click(function() {
			$('#quest').css('display', 'block');
		});

		$('#quest_close').click(function() {
			$('#quest').css('display', 'none');
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
