
<style>
	header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	} 

	body {
		background: linear-gradient(160deg, #333 11%, #222 42.7%, #000 75%);
		background-attachment: fixed;
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
	<div class="asmo_classroom_myClass">
		<div class="myClass_wrap">

			<!-- 게시판이 들어가야 합니다 -->
			<h2>나의 수강목록</h2>
			<div class="myClass_board_top">
				<div class="board_name_box">
					<a href="<?php echo site_url('classroom/my_class')?>">수강중인 과정</a>
					<a class="selected" href="#" onclick="return false;">수강완료 과정</a>

					<div class="mcr-underline selected"></div>

				</div>

				<div class="board_select_box">
					<select class="form-control" name="forder" onChange="location.href = '/classroom/complete_class?forder='+this.value;">
						<option value="">정렬</option>
						<option value="mp_percent" <?php if($_GET[forder] == 'mp_percent'){?>selected <?php }?>>진도율 순</option>
						<option value="mp_sno" <?php if($_GET[forder] == 'mp_sno'){?>selected <?php }?>>최신순</option>
					</select>
				</div>
			</div>
			<div class="msFrm_flex">
				<form action="#" method="get" id="completeSearchFrm"><!-- 검색창 -->
					<fieldset>
						<legend class="dn">검색양식</legend>
						<button type="button" id="completeBtn"></button>
						<input type="text" name="search" id="completeTxt">
					</fieldset>
				</form>
			</div>

			<div class="myClass_list_wrap">

				<ul class="myClass_list_top">
					<li class="mcl_Top_ctg"><span>카테고리</span></li>
					<li class="mcl_Top_title"><span>제목</span></li>
					<li class="mcl_Top_result"><span>결과</span></li>
				</ul>

				<ul class="myClass_list complete_list">
					<?php
						if(count($view['data']['list'])>0){
							foreach($view['data']['list'] as $k=>$v){
					?>
					<li class="myClass_list_box">
						<p class="mcl_ctg" title="<?=$v[category]?>"><?=$v[category]?></p> <!-- 카테고리 -->
						<p class="mcl_title" title="<?=$v[p_title]?>"><?=$v[p_title]?></p> <!-- 제목 -->
						<p class="mcl_result">완료</p> <!-- 완료 -->
						<a href="/classroom/cert_export/<?=$v[mp_sno]?>" class="asmo_certification"><span>수료증 출력</span></a> <!-- 수료증 출력 -->
					</li>
						
					<?php
							}
						}else{
					?>
					<li class="myClass_list_box nopost">
						<p>내역이 없습니다</p>
					</li>
					<?php
						}
					?>
				</ul>

				
				<nav><?php echo element('paging', $view); ?></nav>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	// asmo sh 231114 랜딩 페이지 디자인 상 헤더, 사이드바, 푸터 숨김 처리 스크립트
	$(document).ready(function() {

		$('.main').addClass('add');

		// 클래스룸 페이지일 때 사이드바 메뉴 활성화
		$('#classroom').addClass('selected');
	});
</script>