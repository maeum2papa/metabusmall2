
<div id="asmo_classroom">
	<div id="asmo_classroom_myClass">
		<div class="myClass_wrap">

			<!-- 게시판이 들어가야 합니다 -->

			<div class="myClass_board_top">
				<div class="board_name_box">
					<a class="selected" href="#" onclick="return false;" >수강중인 과정</a>
					<a href="<?php echo site_url('classroom/complete_class'); ?>">수강완료 과정</a>
				</div>

				<div class="board_select_box">
					<select class="form-control" name="forder" onChange="location.href = '/classroom/my_class?forder='+this.value;">
						<option value="">정렬</option>
						<option value="mp_percent" <?php if($_GET[forder] == 'mp_percent'){?>selected <?php }?>>진도율 순</option>
						<option value="mp_sno" <?php if($_GET[forder] == 'mp_sno'){?>selected <?php }?>>최신순</option>
					</select>
				</div>
			</div>
			<div class="myClass_board_bottom">
				<ul>
					<li class="asmo_table_tit">
						<span class="asmo_table_tit_01"><b>구분</b></span>
						<span class="asmo_table_tit_02"><b>카테고리</b></span>
						<span class="asmo_table_tit_03"><b>제목</b></span>
						<span class="asmo_table_tit_04"><b>수강기간</b></span>
						<span class="asmo_table_tit_05"><b>진도율</b></span>
						<span class="asmo_table_tit_06"><b>강의실 입장</b></span>
					</li>
					<!-- 필수 강의 구분을 위해 selected 클래스 추가 -->
					<?php  
						if(count($view['data']['list'])>0){
							foreach($view['data']['list'] as $k=>$v){ 
					?>
					<li class="asmo_table_data <?php if($v[p_recommendYn] == 'y') echo "selected" ?>">
						<span class="asmo_table_tit_01"><?php if($v[p_recommendYn] == 'y'){?><em>필수</em><?php }else{ ?>-<?php } ?></span>
						<span class="asmo_table_tit_02"><?=$v[category]?></span>
						<span class="asmo_table_tit_03"><i><?=$v[p_title]?></i></span>
						<span class="asmo_table_tit_04"><?=$v[view_time]?></span>
						<span class="asmo_table_tit_05"><?=$v[mp_percent]?>%</span>
						<span class="asmo_table_tit_06"><a href="<?php echo site_url('classroom/player?mp_sno='.$v[mp_sno]); ?>">입장</a></span>
					</li>
					<?php
						}
					}else{
					?>
					<li>
						<p class="nopost">내역이 없습니다</p>
					</li>
					<?php
						}
					?>
				</ul>
			</div>


			<nav><?php echo element('paging', $view); ?></nav>
		</div>
	</div>
</div>


<script type="text/javascript">
	//asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');
</script>