<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<style>
	body {
		background: transparent linear-gradient(180deg, #000000 0%, #3E3E3E 100%);
		background-attachment: fixed;
	}

	header, .navbar { /* 각종메뉴 숨김처리 */
		display:none !important;
	}


	
	footer .container .company_info_box .company li a,
	footer .container .company_info_box  .company li::after,
	footer .container .company_info_box .company_info p,
	.company_info_right_box span,
	.company_info_right_box strong {
		color: rgba(177, 177, 177, 1) !important;
	}

	.cmall_ctg_accordian_content li a.active{
		color:white;
	}
</style>

<!-- asmo sh 231205 shop div#lists 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_cmall">
	<div id="listsitem" class="asmo_cmall_list">
		
		<!-- shop 부분 공통 top box -->
		<div class="cmall_top_wrap">
			<div class="top_left_box">

				<h2><a href="<?php echo site_url('cmall'); ?>">교환소</a></h2>

				<div class="status_box status_box_wrap" id="fruit_popup_open">
					<div class="status_icon">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.svg" alt="fruit">
					</div>
					<div class="status_info">
						<span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?> 개</span>
					</div>
				</div>

				<div class="coin_box status_box_wrap" id="coin_popup_open">
					<div class="status_icon">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/point.svg" alt="point">
					</div>
					<div class="status_info">
						<span id="coin_count"><?php echo html_escape($this->member->item('mem_point')); ?> 개</span>
					</div>
				</div>
			</div>
			<div class="top_right_box">
				<a href="/cmall/cart">장바구니</a>
				<a href="/cmall/orderlist">교환내역</a>
			</div>

		</div>

		<div class="cmall-list">

			<!-- 디자인 상 전체상품 개수, 검색박스, 버튼들 필요하여 div.cmall_list_top_box 생성  -->
			<div class="cmall_list_top_box">
				<strong>컬래버랜드 아이템교환소<!-- 리스트 페이지 제목 들어가야 합니다. --> </strong>
				<div class="list_top_right_box">
					<div class="searchbox_wrap">
						<!-- asmo sh 231205 디자인 상 div.searchbox list 위로 올리고 버튼 추가하여 공지사항 게시판 검색버튼과 동일하게 디자인 -->
						<div class="searchbox">
							<form id="item_list_serach_form" class="navbar-form navbar-right pull-right navbar-form-item-list" action="<?php echo current_url(); ?>" >
								<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
								<div class="form-group">
									<!-- <select class="form-control pull-left px100" name="sfield">
										<option value="cit_both" <?php echo ($this->input->get('sfield') === 'cit_both') ? ' selected="selected" ' : ''; ?>>상품명+내용</option>
										<option value="cit_title" <?php echo ($this->input->get('sfield') === 'cit_title') ? ' selected="selected" ' : ''; ?>>상품명</option>
										<option value="cit_content" <?php echo ($this->input->get('sfield') === 'cit_content') ? ' selected="selected" ' : ''; ?>>내용</option>
									</select> -->
									<input type="text" class="form-control px150" placeholder="검색" name="skeyword" value="<?php echo $this->input->get('skeyword'); ?>" />
									<button class="dn btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i></button>
								</div>
								<input type="hidden" name="search_cate_sno_parent_sno" value="">
								<input type="hidden" name="search_cate_sno" value="">
								<input type="hidden" name="search_set_item" value="">
							</form>
						</div>

						<!-- <div class="searchbuttonbox">
							<button class="btn btn-primary btn-sm pull-right" type="button" onClick="toggleSearchbox();">검색</button>
						</div> -->
					</div>
					<!-- <div class="select_box">
						<select class="form-control" id="findex_select">
							<option value="">기본순</option>
							<option value="cit_hit desc" <?php echo ($this->input->get('findex') === 'cit_hit desc') ? ' selected="selected" ' : ''; ?>>인기순</option>
							<option value="cit_review_count desc, cit_review_average dsec" <?php echo ($this->input->get('findex') === 'cit_review_count desc, cit_review_average dsec') ? ' selected="selected" ' : ''; ?>>추천순</option>
							<option value="cit_datetime desc" <?php echo ($this->input->get('findex') === 'cit_datetime desc') ? ' selected="selected" ' : ''; ?>>최신순</option>
							<option value="cit_price asc" <?php echo ($this->input->get('findex') === 'cit_price asc') ? ' selected="selected" ' : ''; ?>>가격낮은순</option>
						</select>
					</div>
					<div class="top_right_box">
						<a href="/cmall/wishlist">찜하기목록으로 <?=banner('heart_color')?></a>
						<a href="/cmall/cart">장바구니 <?=banner('cart')?></a>
						<a href="/cmall/orderlist">구매내역 <?=banner('purchase_history')?></a>
					</div> -->
				</div>
			</div>

			<div class="cmall_list_wrap">
				<!-- 아이템몰 카테고리 분류 -->
				<div class="cmall_ctg_accordian_box">
					<div class="cmall_ctg_accordian">
						
						<!-- 홈페이지 로드 시 첫 번째 아코디언 메뉴만 노출 -->
						<div class="cmall_ctg_accordian_title <?php echo (!$this->input->get("search_cate_sno_parent_sno") || $this->input->get("search_cate_sno_parent_sno")==5)?"active":"";?>" onClick="goCategory(this,5,5,0);">
							<h3>아바타</h3>
						</div>
						<div class="cmall_ctg_accordian_content <?php echo (!$this->input->get("search_cate_sno_parent_sno") || $this->input->get("search_cate_sno_parent_sno")==5)?"":"dn";?>"">
							<ul>
								<li><a href="#" class="<?php echo ($this->input->get("search_cate_sno") == 5 && $this->input->get("search_set_item")==1)?"active":"";?>" onclick="goCategory(this,5,5,1);">세트</a></li>
								<?php
								if(count(element('item_categorys',element('data',$view))[0]) > 0){
									foreach(element('item_categorys',element('data',$view))[0] as $k=>$v){
										?>
										<li><a href="#" class="<?php echo ($this->input->get("search_cate_sno") == $v['cate_sno'])?"active":"";?>" onClick="goCategory(this,<?php echo $v['cate_parent'];?>,<?php echo $v['cate_sno'];?>,0);"><?php echo $v['cate_kr'];?></a></li>
										<?php
									}
								}
								?>
							</ul>
						</div>
					</div>

					<div class="cmall_ctg_accordian">
						<div class="cmall_ctg_accordian_title <?php echo ($this->input->get("search_cate_sno_parent_sno")==6)?"active":"";?>" onClick="goCategory(this,6,6,0);">
							<h3>랜드(외부)</h3>
						</div>

						<!-- 홈페이지 로드 시 첫 번째 아코디언 메뉴만 노출 -->
						<div class="cmall_ctg_accordian_content <?php echo ($this->input->get("search_cate_sno_parent_sno")==6)?"":"dn";?>" >
							<ul>
							<li><a href="#" class="<?php echo ($this->input->get("search_cate_sno") == 6 && $this->input->get("search_set_item")==1)?"active":"";?>" onclick="goCategory(this,6,6,1);">세트</a></li>
								<?php
								if(count(element('item_categorys',element('data',$view))[1]) > 0){
									foreach(element('item_categorys',element('data',$view))[1] as $k=>$v){
										?>
										<li><a href="#" class="<?php echo ($this->input->get("search_cate_sno") == $v['cate_sno'])?"active":"";?>" onClick="goCategory(this,<?php echo $v['cate_parent'];?>,<?php echo $v['cate_sno'];?>,0);"><?php echo $v['cate_kr'];?></a></li>
										<?php
									}
								}
								?>
							</ul>
						</div>
					</div>

					<div class="cmall_ctg_accordian">
						<div class="cmall_ctg_accordian_title <?php echo ($this->input->get("search_cate_sno_parent_sno")==1)?"active":"";?>" onClick="goCategory(this,1,1,0);">
							<h3>랜드(내부)</h3>
						</div>

						<!-- 홈페이지 로드 시 첫 번째 아코디언 메뉴만 노출 -->
						<div class="cmall_ctg_accordian_content <?php echo ($this->input->get("search_cate_sno_parent_sno")==1)?"":"dn";?>" >
							<ul>
							<li><a href="#" class="<?php echo ($this->input->get("search_cate_sno") == 1 && $this->input->get("search_set_item")==1)?"active":"";?>" onclick="goCategory(this,1,1,1);">세트</a></li>
							<?php
								if(count(element('item_categorys',element('data',$view))[2]) > 0){
									foreach(element('item_categorys',element('data',$view))[2] as $k=>$v){
										?>
										<li><a href="#" class="<?php echo ($this->input->get("search_cate_sno") == $v['cate_sno'])?"active":"";?>" onClick="goCategory(this,<?php echo $v['cate_parent'];?>,<?php echo $v['cate_sno'];?>,0);"><?php echo $v['cate_kr'];?></a></li>
										<?php
									}
								}
								?>
							</ul>
						</div>
					</div>
				</div>

				<ul class="row on">
					<?php
					$k = 0;
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $item) {
					?>
						<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 cmall-list-col">
							<div class="thumbnail" >
								<?php if(soldoutYn(element('cit_id', $item)) == 'y'){?>
									<a onClick="alert('<?php echo cmsg("1103");?>');">
								<?php }else if(cmall_item_one_sale_order($this->member->item('mem_id'),$item['cit_id'])){ ?>
									<a onClick="alert('<?php echo cmsg("1102")?>');">
								<?php }else{ ?>
									<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>">
								<?php } ?>
				
								<!-- 디자인 상 이미지 정방형으로 보이기 위해 이미지 사이즈 삭제 -->
									<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item)); ?>" alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" />
									<?php if(soldoutYn(element('cit_id', $item)) == 'y' || cmall_item_one_sale_order($this->member->item('mem_id'),$item['cit_id'])){?>
									<div class="soldout_mask">
										<span>구매 불가</span>
									</div>
									<?php } ?>

								</a>
								<div class="cont_info">
									<div class="cont_info_title"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><p><?php echo html_escape(element('cit_name', $item)); ?></p></a></div>
									<div class="cont_info_desc">
										<div class="info_desc_right">
										<?php
											echo banner('fruit');
                                            ?>
                                            <?php echo number_format(element('cit_price', $item)); ?>개
                                            <?php
										?>
										</div>
										<!-- //asmo sh 231205 i 태그, 텍스트 삭제 및 아이콘 추가 -->
									</div>
								</div>
							</div>
						</li>
					<?php
						$k++;
						}
					}
					?>

					<!-- 
						빈칸​
						- 아이템몰 상품목록 화면은 16칸을 디폴트​
						- 16개의 상품이 등록되어있지 않더라도, 빈칸으로 표시 
					-->
					<li class="nodata"></li>
				</ul>
			</div>
		</div>
	
		
	</div>
</div>
<script type="text/javascript">

	// cmall_ctg_accordian_box 클릭시 해당 리스트 보이게 하는 스크립트
	// $(document).ready(function(){
	// 	$('.cmall_ctg_accordian_title').click(function(){
	// 		$(this).parent().toggleClass('on');
	// 	});
	// });


	// asmo sh 231205 shop 페이지 디자인 상 헤더, nav바, 숨김 처리 스크립트
	$(document).ready(function() {

		// $(".cmall_ctg_accordian_title").click(function(){
		// 	$(this).next(".cmall_ctg_accordian_content").slideToggle();
		// 	$(this).toggleClass("active");
		// });

		$('.main').addClass('add');

		// shop 페이지일 때 사이드바 메뉴 활성화
		$('#shop').addClass('selected');

		//정렬 변경 후 자동 검색
		$('#findex_select').change(function(){
			$("input[name='findex']").val($(this).val());
			$(".navbar-form-item-list").submit();
		});
	});

	// 검색버튼 토글 함수
	function toggleSearchbox() {
		$('.searchbox').show();
		$('.searchbuttonbox').hide();
	}

	//<![CDATA[
	function itemSearch(f) {
		var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
		if (skeyword.length < 2) {
			alert('2글자 이상으로 검색해 주세요');
			f.skeyword.focus();
			return false;
		}
		return true;
	}

	//카테고리 클릭 이벤트
	function goCategory(element,cate_sno_parent_sno,cate_sno,set_item){

		document.querySelector("#item_list_serach_form [name='skeyword']").value = "";
		document.querySelector("[name='search_cate_sno']").value = cate_sno;
		document.querySelector("[name='search_cate_sno_parent_sno']").value = cate_sno_parent_sno;
		document.querySelector("[name='search_set_item']").value = set_item;
		document.querySelector("#item_list_serach_form").submit();

	}
	//]]>
</script>

<a href="<?php echo current_url(); ?>" class="btn btn-default btn-sm">목록</a>
<nav><?php echo element('paging', $view); ?></nav>
