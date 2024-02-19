<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>

<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
            <th>주문번호</th>
            <th>주문일</th>
			<?php if($view['data']['mem_admin_flag']==0){?>
				<th>기업명</th>
			<?php } ?>
            <th>회원이메일</th>
            <th>회원명</th>

            <th>전화번호</th>
			<?php if($view['data']['mem_admin_flag']==1){?>
            	<th>배송지</th>
			<?php } ?>
			<th>카테고리</th>
			<th>상품구분</th>
			<th>주문 상품</th>

			<th>개수</th>
			<th>주문 상태</th>
			<th>결제수단</th>
			<?php if($view['data']['mem_admin_flag']==1){?>
				<th>사용열매/코인</th>
			<?php } ?>
			<th>실결제금액</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
                <td height="30" style=mso-number-format:'\@' ><?php echo element('cor_id', $result); ?></td>
                <td><?php echo element('cor_datetime', $result); ?></td>
				<?php if($view['data']['mem_admin_flag']==0){?>
                	<td><?php echo element('company_name', $result); ?></td>
				<?php } ?>
                <td><?php echo element('mem_email', $result); ?></td>
                <td><?php echo element('mem_realname', $result); ?></td>

                <td style=mso-number-format:'\@'><?php echo element('mem_phone', $result); ?></td>
				<?php if($view['data']['mem_admin_flag']==1){?>
                	<td><?php echo element('cor_address', $result); ?></td>
				<?php } ?>
				<td><?php echo element('cca_value', $result); ?></td>
				<td><?php echo element('cit_item_type', $result); ?></td>
                <td><?php echo element('cit_name', $result); ?></td>

                <td><?php echo element('cod_count', $result); ?></td>
                <td><?php echo element('cod_status', $result); ?></td>
                <td><?php echo element('cor_pay_type', $result); ?></td>
				<?php if($view['data']['mem_admin_flag']==1){?>
                	<td><?php echo element('cor_fruit_or_coin_amount', $result); ?></td>
				<?php } ?>
                <td><?php echo element('cod_price', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
