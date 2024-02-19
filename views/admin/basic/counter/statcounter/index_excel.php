<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
    <tr>
        <th>최근 접속 시간</th>
        <th>회원명</th>
        <th>총 접속 시간</th>
        <th>최근 접속 기기</th>
        <th>Browser</th>
    </tr>
    <?php
    if (element('board', element('list', $view))) {
        foreach (element('board', element('list', $view)) as $result) {
    ?>
    <tr>
        <td><?php echo element('mem_lastlogin_datetime', $result); ?></td>
        <td><?php echo element('mem_username', $result); ?></td>
        <td><?php echo element('acctime', $result); ?></td>
        <td><?php echo element('device', $result); ?></td>
        <td><?php echo element('browser', $result); ?></td>
    </tr>
    <?php
        }
    }
    ?>
</table>
