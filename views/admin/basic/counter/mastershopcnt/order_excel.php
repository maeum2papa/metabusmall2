<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
    <tr>
        <th rowspan="2">날짜</th>
        <th colspan="4">전체</th>
        <th colspan="4">PC 쇼핑몰</th>
        <th colspan="4">모바일 쇼핑몰</th>
        <th colspan="4">태블릿 쇼핑몰</th>
    </tr>
    <tr>
        <th>판매금액</th>
        <th>구매건수</th>
        <th>구매자수</th>
        <th>구매개수</th>
        <th>판매금액</th>
        <th>구매건수</th>
        <th>구매자수</th>
        <th>구매개수</th>
        <th>판매금액</th>
        <th>구매건수</th>
        <th>구매자수</th>
        <th>구매개수</th>
        <th>판매금액</th>
        <th>구매건수</th>
        <th>구매자수</th>
        <th>구매개수</th>
    </tr>
    <?php
    if (element('board', element('list', $view))) {
        foreach (element('board', element('list', $view)) as $k => $v) {
    ?>
    <tr>
        <td><?php echo element('cor_datetime', $v); ?></td>
        <td><?php echo number_format(element('cor_total_money_sum', element('total', $v))); ?></td>
        <td><?php echo number_format(element('cor_id_cnt', element('total', $v))); ?></td>
        <td><?php echo number_format(element('mem_id_cnt', element('total', $v))); ?></td>
        <td><?php echo number_format(element('cod_count_sum', element('total', $v))); ?></td>
        <td><?php echo number_format(element('cor_total_money_sum', element('pc', $v))); ?></td>
        <td><?php echo number_format(element('cor_id_cnt', element('pc', $v))); ?></td>
        <td><?php echo number_format(element('mem_id_cnt', element('pc', $v))); ?></td>
        <td><?php echo number_format(element('cod_count_sum', element('pc', $v))); ?></td>
        <td><?php echo number_format(element('cor_total_money_sum', element('mo', $v))); ?></td>
        <td><?php echo number_format(element('cor_id_cnt', element('mo', $v))); ?></td>
        <td><?php echo number_format(element('mem_id_cnt', element('mo', $v))); ?></td>
        <td><?php echo number_format(element('cod_count_sum', element('mo', $v))); ?></td>
        <td><?php echo number_format(element('cor_total_money_sum', element('tb', $v))); ?></td>
        <td><?php echo number_format(element('cor_id_cnt', element('tb', $v))); ?></td>
        <td><?php echo number_format(element('mem_id_cnt', element('tb', $v))); ?></td>
        <td><?php echo number_format(element('cod_count_sum', element('tb', $v))); ?></td>
    </tr>
    <?php
        }
    }
    ?>
</table>
