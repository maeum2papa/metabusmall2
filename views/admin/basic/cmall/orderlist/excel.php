<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>

<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
            <th>주문번호</th>
            <th>분류</th>

			<?php if($view['data']['mem_admin_flag']==0){?>
				<th>기업명</th>
			<?php } ?>

            <th>부서명</th>
            <th>직책</th>
            <th>직원명</th>
            <th>연락처</th>
			<th>주소</th>
			<th>주문상품</th>
			<th>주문수량</th>
			<th>주문상태</th>

            <?php if($view['data']['mem_admin_flag']!=0){?>
			    <th>사용포인트</th>
            <?php }else{ ?>
                <th>차감예치금</th>
            <?php } ?>

		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
                <td height="30" style=mso-number-format:'\@' ><?php echo element('cor_id', $result); ?></td>
                <td><?php echo (element('citt_id', $result) > 0)?"템플릿":"자체"; ?></td>

				<?php if($view['data']['mem_admin_flag']==0){?>
                	<td><?php echo element('company_name', $result); ?></td>
				<?php } ?>

                <td><?php echo element('mem_div', $result); ?></td>
                <td><?php echo element('mem_position', $result); ?></td>
                <td><?php echo element('mem_username', $result); ?></td>
                <td style=mso-number-format:'\@'><?php echo element('mem_phone', $result); ?></td>
				<td>[<?php echo element('cor_ship_zipcode', $result); ?>] <?php echo element('cor_ship_address', $result)." ".element('cor_ship_address_detail', $result); ?></td>
				<td><?php echo element('cit_name', $result); ?></td>
                <td><?php echo element('cod_count', $result); ?></td>
                <td><?php echo element('status_name', $result); ?></td>

                <?php if($view['data']['mem_admin_flag']!=0){?>
                    <td><?php echo element('cod_point', $result); ?></td>
                <?php }else{ ?>
                    <td><?php echo (element('citt_id', $result) > 0)?element('cod_point', $result)*(-100):0; ?></td>
                <?php } ?>

			</tr>
		<?php
			}
		}
		?>
</table>
