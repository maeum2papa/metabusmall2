<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
    <tr>
        <th rowspan="2">순위</th>
        <th rowspan="2">상품코드</th>
        <th rowspan="2">상품명</th>
        <th colspan="3">상품금액</th>
        <th rowspan="2">합계</th>
        <th colspan="3">구매수량</th>
        <th rowspan="2">합계</th>
        <th colspan="3">구매건수</th>
        <th rowspan="2">합계</th>
    </tr>
    <tr>
        <th>PC</th>
        <th>모바일</th>
        <th>태블릿</th>
        <th>PC</th>
        <th>모바일</th>
        <th>태블릿</th>
        <th>PC</th>
        <th>모바일</th>
        <th>태블릿</th>
    </tr>
    <?php
    if (element('board', element('list', $view))) {
        foreach (element('board', element('list', $view)) as $k => $v) {
    ?>
    <tr>
        <td><?php echo element('num', $v); ?></td>
        <td><?php echo element('cit_id', $v); ?></td>
        <td><?php echo element('cit_name', $v); ?></td>
        <?php foreach(element('device1', $v) as $k2 => $v2){ ?>
            <td><?php echo number_format(element('pcsum', $v2)); ?></td>
            <td><?php echo number_format(element('mosum', $v2)); ?></td>
            <td><?php echo number_format(element('tbsum', $v2)); ?></td>
            <td><?php echo number_format(element('sum', $v2)); ?></td>
        <?php } ?>
        <?php foreach(element('device2', $v) as $k2 => $v2){ ?>
            <td><?php echo number_format(element('pcsum', $v2)); ?></td>
            <td><?php echo number_format(element('mosum', $v2)); ?></td>
            <td><?php echo number_format(element('tbsum', $v2)); ?></td>
            <td><?php echo number_format(element('sum', $v2)); ?></td>
        <?php } ?>
        <?php foreach(element('device3', $v) as $k2 => $v2){ ?>
            <td><?php echo number_format(element('pcsum', $v2)); ?></td>
            <td><?php echo number_format(element('mosum', $v2)); ?></td>
            <td><?php echo number_format(element('tbsum', $v2)); ?></td>
            <td><?php echo number_format(element('sum', $v2)); ?></td>
        <?php } ?>
    </tr>
    <?php
        }
    }
    ?>
</table>
