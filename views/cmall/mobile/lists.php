<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>


<div id="asmo_item_detail_wrap"> 

	<?php if (element('category_nav', $view)) { ?>
		<ol class="breadcrumb asmo_item_list_nav">
			<li><a href="<?php echo site_url('cmall');?>">교환소</a></li>
			<li><a href="<?php echo site_url('cmall/lists/2');?>"><?=busiNm($this->member->item('company_idx'))?> 복지교환소</a></li>
		</ol>
		<?php if (element('category_all', $view) && element(element('category_id', $view), element('category_all', $view))) { ?>
			<div class="cmall-category-nav">
				<div class="cmall-category-nav-body">
					<?php foreach (element(element('category_id', $view), element('category_all', $view)) as $result) { ?>
						<div class="pull-left ml20"><i class="fa fa-caret-right"></i> <a href="<?php echo site_url('cmall/lists/' . element('cca_id', $result));?>" title="<?php echo html_escape(element('cca_value', $result));?>"><?php echo html_escape(element('cca_value', $result));?></a></div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
	<?php } else { ?>
		<h3>전체상품</h3>
	<?php } ?>

	<div class="searchbox" id="asmo_search_wrap">
		
		<div class="asmo_search_left">
			전체 상품 <strong>40</strong>개
		</div>

		<div class="asmo_search_right">
			<div id="asmo_goods_search_btn">검색</div>
			<div class="board_select_box">
				<select class="form-control">
					<option value="">정렬</option>
					<option value="">인기순</option>
					<option value="">추천순</option>
					<option value="">최신순</option>
					<option value="">가격낮은순</option>
				</select>
			</div>
			<div class="top_right_box">
				<a class="asmo_top_wish" href="/cmall/wishlist">찜하기목록으로</a>
				<a class="asmo_top_cart_btn" href="/cmall/cart">장바구니<em></em></a>
				<a class="asmo_top_order_list_btn" href="/cmall/orderlist">구매내역<em></em></a>
			</div>
		</div>

		<div id="asmo_serach_layer_item" class="dn">
			<div id="asmo_goods_search_close">닫기</div>
			<form class="navbar-form navbar-right pull-right" action="<?php echo current_url(); ?>" onSubmit="return itemSearch(this);">
				<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
				<div class="form-group">
					<select class="input pull-left px100" name="sfield">
						<option value="cit_both" <?php echo ($this->input->get('sfield') === 'cit_both') ? ' selected="selected" ' : ''; ?>>상품명+내용</option>
						<option value="cit_title" <?php echo ($this->input->get('sfield') === 'cit_title') ? ' selected="selected" ' : ''; ?>>상품명</option>
						<option value="cit_content" <?php echo ($this->input->get('sfield') === 'cit_content') ? ' selected="selected" ' : ''; ?>>내용</option>
					</select>
					<div class="asmo_search_input_wrap">
						<input type="text" class="input px100" placeholder="검색" name="skeyword" value="<?php echo $this->input->get('skeyword'); ?>" />
						<button class="btn btn-primary" type="submit"></button>
					</div>
				</div>
			</form>
		</div>
	</div>


	<ul class="table-image" id="asmo_item_list_goods_wrap">
	<?php
	$k = 0;
	$open = false;
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $item) {
			if ( ! $open) {
				//echo '<ul class="mb20">';
				$open = true;
			}

			$condition_mask = "";
			
			if($item['cit_download_days'] > 0 || ($item['cit_startDt']!=0 && $item['cit_endDt']!=0)){
				$condition_mask = "기간한정";
			}else if($item['cit_one_sale']=='y'){
				$condition_mask = "1인1회";
			}else if($item['cit_stock_type']=='s'){
				$condition_mask = "한정수량";
			}
	?>
		<li class="table-list-item">
			<a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" class="thumbnail" title="<?php echo html_escape(element('cit_name', $item)); ?>">
				<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $item)); ?>" alt="<?php echo html_escape(element('cit_name', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>" style="width: 100%; display: block;" />
			</a>
			<div class="cont_info">

				<?php
					if($condition_mask!=""){
						?>
							<!-- 상품등록시 설정한 조건 표시 (한정수량/1인1회/기간한정) -->
							<div class="condition_mask">
								<span><?php echo $condition_mask;?></span>
							</div>
						<?php
					}
				?>

				<div class="cont_info_title">
					<p class="cmall-tit"><a href="<?php echo cmall_item_url(element('cit_key', $item)); ?>" title="<?php echo html_escape(element('cit_name', $item)); ?>"><?php echo html_escape(element('cit_name', $item)); ?></a></p>
					<p class="cmall-txt"><?php echo element('cit_summary', $item); ?></p>
				</div>
				<ul class="cmall-detail">
					<div class="info_desc_left">
						<li class="asmo_wish_cnt_li"><?php echo number_format(element('cit_wish_count', $item)); ?></li>
						<li class="asmo_sell_cnt_li"><?php echo number_format(element('cit_sell_count', $item)); ?></li>
					</div>
					<div class="info_desc_right">
						<?php
							if($item['cit_money_type']=='f'){
								?>
								<span id="price" class="asmo_price_fruit"><?php echo number_format(element('fruit_cit_price', $item)); ?></span>개
								<?php
							}else{
								?>
								<span id="price" class="asmo_price_coin"><?php echo number_format(element('cit_price', $item)); ?></span>개
								<?php
							}
						?>
					</div>
				</ul>
			</div>
		</li>
	<?php
			if ($k % 2 === 1 && $open) {
				//echo '</ul>';
				$open = false;
			}

		$k++;
		}
	}
	if ($open) {
		//echo '</ul>';
		$open = false;
	}
	?>
	</ul>


</div>

<script type="text/javascript">

//asmo lhb 231218 클래스 영역 구분용 클래스 추가
document.querySelector('.main').classList.add('asmo_m_layout');

//asmo lhb 231221 검색버튼 클릭 이벤트 
$('#asmo_goods_search_btn').click(function(){
	$('#asmo_serach_layer_item').removeClass('dn');
});

$('#asmo_goods_search_close').click(function(){
	$('#asmo_serach_layer_item').addClass('dn');
});



//asmo lhb 231221 검색버튼 클릭 이벤트 끝



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

<!-- <a href="<?php //echo current_url(); ?>" class="btn btn-default">목록</a> -->
<nav><?php echo element('paging', $view); ?></nav>
