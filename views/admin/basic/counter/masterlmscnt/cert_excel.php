<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
    <tr>
        <th>부서명</th>
        <th>회원명</th>
        <th>수료일자</th>
        <th>카테고리</th>
        <th>세부카테고리</th>
        <th>과정명</th>
        <th>수료증출력</th>
    </tr>
    <?php
    if (element('board', element('list', $view))) {
        foreach (element('board', element('list', $view)) as $result) {
    ?>
    <tr>
        <td><?php echo element('mem_div', $result); ?></td>
        <td><?php echo element('mem_username', $result); ?></td>
        <td><?php echo element('mp_endDt', $result); ?></td>
        <td><?php echo element('cca_parent_value', $result); ?></td>
        <td><?php echo element('cca_value', $result); ?></td>
        <td><?php echo element('p_title', $result); ?></td>
        <td><?php if(element('mp_endYn', $result) == 'y'){ echo '출력'; } else { echo '미출력'; } ?></td>
    </tr>
    <?php
        }
    }
    ?>
</table>
