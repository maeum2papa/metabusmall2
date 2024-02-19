<!-- 장바구니 옵션 시작 { -->

<?php
$attributes = array('class' => 'form-inline', 'name' => 'foption', 'id' => 'foption', 'onsubmit' => 'return fcart_submit(this)');
echo form_open(site_url('cmallact/optionupdate'), $attributes);
?>
	<input type="hidden" name="cit_id" value="<?php echo element('cit_id', element('item', $view)); ?>" />
	<div class="popup-cart">
		<p>상품옵션</p>
		<div class="product-option table-responsive">
			<table class="table table-bordered">
				<tbody>
					<!-- asmo lhb 231222 첫번째 tr 미노출  -->
					<tr class="warning" style="display:none;">
						<th>옵션</th>
						<th><input type="checkbox" id="chk_all_item" /></th>
						<th>수량</th>
						<th>판매가</th>
					</tr>
					<?php
					if (element('detail', $view)) {
						foreach (element('detail', $view) as $key => $value) {
							$price = element('cit_price', element('item', $view)) + element('cde_price', $value);
					?>
						<tr>
							<td>
								<div class="asmo_cart_opt_layer_name">
									<?php echo html_escape(element('cde_title', $value)); ?>
								</div>
								<input type="checkbox" name="chk_detail[]" value="<?php echo element('cde_id', $value); ?>" <?php echo (element('cct_id', element('cart', $value))) ? 'checked="checked" ' : '';?> />
								<div class="cart_opt_bottom_box">
									<div class="btn-group asmo_cnt" role="group" aria-label="...">
										<button type="button" class="btn btn-default btn-xs btn-change-qty" data-change-type="minus">-</button>
										<input type="text" name="detail_qty[<?php echo element('cde_id', $value); ?>]" class="btn btn-default btn-xs detail_qty" value="<?php echo element('cct_count', element('cart', $value)) ? element('cct_count', element('cart', $value)) : 1; ?>" />
										<button type="button" class="btn btn-default btn-xs btn-change-qty" data-change-type="plus">+</button>
									</div>
									<div class="asmo_opt_price_box">
										<input type="hidden" name="item_price[<?php echo element('cde_id', $value); ?>]" value="<?php echo $price; ?>" />
										<?php echo number_format($price); ?>개 
									</div>
								</div>
							</td>
						</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
			<div class="asmo_cart_opt_layer_total_box">
				총 결제금액<span class="product-title"><span id="total_order_price">0</span>원</span>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="submit" class="btn btn-success btn-sm">확인</button>
		</div>
		<button type="button" id="mod_option_close">취소</button>
	</div>
<?php echo form_close(); ?>

<script type="text/javascript">
//<![CDATA[

// 구매금액 계산
item_price_calculate();

function fcart_submit(f)
{
	var $el_chk = $('input[name^=chk_detail]:checked');

	if ($el_chk.size() < 1) {
		alert('상품의 옵션을 하나이상 선택해 주십시오.');
		return false;
	}

	// 수량체크
	var is_qty = true;
	var ct_qty = 0;
	$el_chk.each(function() {
		ct_qty = parseInt($(this).closest('tr').find('input[name^=ct_qty]').val().replace(/[^0-9]/g, ""));
		if (isNaN(ct_qty)) {
			ct_qty = 0;
		}

		if (ct_qty < 1) {
			is_qty = false;
			return false;
		}
	});

	if ( ! is_qty) {
		alert('수량을 1이상 입력해 주십시오.');
		return false;
	}

	return true;
}
//]]>
</script>
<!-- } 장바구니 옵션 끝 -->
