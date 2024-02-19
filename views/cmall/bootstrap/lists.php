<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<!-- asmo sh 231205 shop div#lists 감싸는 div#asmo_cmall 생성 -->
<div class="asmo_cmall">
	<div id="lists">
		<?php if (element('category_nav', $view)) { ?>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('cmall/lists');?>">상품목록</a></li>
				<?php foreach (element('category_nav', $view) as $result) { ?>
					<li><a href="<?php echo site_url('cmall/lists/' . element('cca_id', $result));?>" title="<?php echo html_escape(element('cca_value', $result)); ?>"><?php echo html_escape(element('cca_value', $result)); ?></a></li>
				<?php } ?>
			</ol>
			<?php if (element('category_all', $view) && element(element('category_id', $view), element('category_all', $view))) { ?>
				<div class="panel panel-default">
					<div class="panel-body">
						<?php foreach (element(element('category_id', $view), element('category_all', $view)) as $result) { ?>
							<div class="pull-left ml20"><i class="fa fa-caret-right"></i> <a href="<?php echo site_url('cmall/lists/' . element('cca_id', $result));?>" title="<?php echo html_escape(element('cca_value', $result));?>"><?php echo html_escape(element('cca_value', $result));?></a></div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<h3>전체상품</h3>
		<?php } ?>
	
		<div class="cmall-list">

			<!-- 디자인 상 전체상품 개수, 검색박스, 버튼들 필요하여 div.cmall_list_top_box 생성  -->
			<div class="cmall_list_top_box">
				<strong><?php echo html_escape(element('cca_value', $result)); ?> 상품 
				<span>
					<?php
						if (element('list', element('data', $view))) {
							$data = count(element('data', $view));

						echo $data; }
					?>
				</span>개</strong>
				<div class="list_top_right_box">
					<div class="searchbox_wrap">
						<!-- asmo sh 231205 디자인 상 div.searchbox list 위로 올리고 버튼 추가하여 공지사항 게시판 검색버튼과 동일하게 디자인 -->
						<div class="searchbox">
							<form class="navbar-form navbar-right pull-right navbar-form-item-list" action="<?php echo current_url(); ?>" >
								<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
								<div class="form-group">
									<select class="form-control pull-left px100" name="sfield">
										<option value="cit_both" <?php echo ($this->input->get('sfield') === 'cit_both') ? ' selected="selected" ' : ''; ?>>상품명+내용</option>
										<option value="cit_title" <?php echo ($this->input->get('sfield') === 'cit_title') ? ' selected="selected" ' : ''; ?>>상품명</option>
										<option value="cit_content" <?php echo ($this->input->get('sfield') === 'cit_content') ? ' selected="selected" ' : ''; ?>>내용</option>
									</select>
									<input type="text" class="form-control px150" placeholder="검색" name="skeyword" value="<?php echo $this->input->get('skeyword'); ?>" />
									<button class="dn btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i></button>
								</div>
							</form>
						</div>

						<div class="searchbuttonbox">
							<button class="btn btn-primary btn-sm pull-right" type="button" onClick="toggleSearchbox();">검색</button>
						</div>
					</div>
					<div class="select_box">
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
					</div>
				</div>
			</div>

			<ul class="row">
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
							<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
							<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
							<ul class="cmall-detail">

								<!-- asmo sh 231205 i 태그, 텍스트 삭제 및 아이콘 추가 -->
								<li><?=banner('heart')?><?php echo number_format(element('cit_wish_count', $item)); ?></li>
								<li><?=banner('cart_2')?><?php echo number_format(element('cit_sell_count', $item)); ?></li>
								<li class="cmall-price pull-right">
								<?php
											if($item['cit_money_type']=='f'){
												echo banner('fruit');
												?>
												<?php echo number_format(element('fruit_cit_price', $item)); ?>개
												<?php
											}else{
												echo banner('coin');
												?>
												<?php echo number_format(element('cit_price', $item)); ?>개
												<?php
											}
										?>
								</li>
								<!-- //asmo sh 231205 i 태그, 텍스트 삭제 및 아이콘 추가 -->

							</ul>
						</div>
					</li>
				<?php
	
	
					$k++;
					}
				}
				?>
			</ul>
		</div>
	
		
	</div>
</div>
<script type="text/javascript">

	// asmo sh 231205 shop 페이지 디자인 상 헤더, nav바, 숨김 처리 스크립트
	$(document).ready(function() {
		$('header').addClass('dn');
		$('.navbar').addClass('dn');
		// $('.sidebar').addClass('dn');
		// $('footer').addClass('dn');

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
	//]]>
</script>

<a href="<?php echo current_url(); ?>" class="btn btn-default btn-sm">목록</a>
<nav><?php echo element('paging', $view); ?></nav>
