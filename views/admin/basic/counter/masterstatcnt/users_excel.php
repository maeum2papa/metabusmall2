<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
    <tr>
        <th><?php if($this->input->get('ymd') == 'day' || $this->input->get('ymd') == ''){ echo '시간'; } else { echo '날짜'; } ?></th>
        <th>방문 수</th>
        <th>누적 방문 수</th>
    </tr>
    <?php
    if (element('board', element('list', $view))) {
        foreach (element('board', element('list', $view)) as $result) {
    ?>
    <tr>
        <td><?php echo element('mll_datetime', $result); ?></td>
        <td><?php echo element('visit_count', $result); ?></td>
        <td><?php echo element('acc_visit_count', $result); ?></td>
    </tr>
    <?php
        }
    }
    ?>
</table>
