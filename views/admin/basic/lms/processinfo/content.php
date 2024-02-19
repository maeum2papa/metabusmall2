<style>
    .info li img.handle { cursor: move; }

    .handle_table tr{border:2px solid #999; font-size:12px;}
    .handle_table td, .handle_table img{vertical-align:middle;text-align:center;}
    .handle_table th{border:1px solid #999;line-height:1.7;vertical-align:middle;padding:2px}
    .handle_table td{border:1px solid #999; background:#fff;line-height:1.7;vertical-align:middle;padding:2px}
</style>
<div class="box">
    <div class="box-header">
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/write'); ?>/<?php echo element('pid', $view); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">과정정보</a></li>
            <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/content'); ?>/<?php echo element('pid', $view); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">커리큘럼</a></li>
        </ul>
    </div>
    <div class="box-table">
    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">컨텐츠 추가</label>
            <div class="col-sm-10 form-inline">
                <select id="curriculum_div" class="form-control" onchange="change_curriculum_div()">
                    <option value="video" selected>동영상</option>
                    <option value="game">게임</option>
                    <option value="item">씨앗</option>
                </select>
                <span id="content_span">
                    <select id="content_div" class="form-control">
                        <?php  foreach($view['video_list'] as $l) { echo "<option value='".$l['video_idx']."'>".$l['video_name']."</option>";}?>
                    </select>
                </span>
                <span id="item_span" style="display: none;">
                    <input type="text" placeholder="씨앗 보상갯수" id="item_cnt" value=""/>
                </span>
                <a href="javascript:add()" class="btn btn-default btn-sm">추가</a>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">커리큘럼</label>
            <div class="col-sm-10">
                <ul id="info" class="box info">
                <?php foreach($view['data'] as $l) {
                    $cur_title = "컨텐츠명";

                    if($l['curriculum_div'] == 'video')
                    {
                        $cur_idx = $l['video_idx'];
                        $cur_name = $l['video_name'];
                    } elseif ($l['curriculum_div'] == 'game') {
                        $cur_idx = $l['game_content_idx'];
                        $cur_name = $l['game_content_name'];
                    } elseif ($l['curriculum_div'] == 'item') {
                        $cur_title = "씨앗 보상갯수";
                        $cur_idx = '';
                        $cur_name = '<input type="text" id="item_cnt_'.$l['curriculum_idx'].'" onchange="change_item_cnt('.$l['curriculum_idx'].')" value="'.$l['item_cnt'].'">';
                    }
                ?>
                    <li id='listItem_<?php echo $l['curriculum_idx']?>'>
                        <input type="hidden" id="chk_<?php echo $l['curriculum_div']?>_<?php echo $cur_idx?>" value="1" />
                        <table cellpadding='0' cellspacing='0' class='handle_table' style='width:100%;margin:0 auto'>
                            <tr style='background-color:white;'>
                                <th rowspan='2' style='width:20px;'><img src='/assets/img/icon_moving.png' class='handle'></th>
                                <th style='text-align:center;width:50px;'>구분</th>
                                <th style='text-align:center;'><?php echo $cur_title?></th>
                                <th style='text-align:center;width:100px;'>활성화여부</th>
                                <th style='text-align:center;width:50px;'>삭제</th>
                            </tr>
                            <tr style='background-color:white;'>
                                <td><?php echo $view['div_str'][$l['curriculum_div']]?></td>
                                <td><?php echo $cur_name?></td>
                                <td id='type_<?php echo $l['curriculum_idx']?>' onclick='clk_edit(this)' style='cursor:pointer'><u><?php echo $view['state_str'][$l['state']]?></u></td>
                                <td><a href="javascript:del(<?php echo $l['curriculum_idx']?>)" class="mb-2 mr-2 fa fa-window-close fa-lg"></a></td>
                            </tr>
                        </table>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <div class="btn-group pull-right" role="group" aria-label="...">
            <a class="btn btn-default btn-sm btn-history-back" href="<?php echo admin_url($this->pagedir); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>">목록</a>
        </div>
    </form>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
    //<![CDATA[
        var pid = <?php echo element('pid', $view); ?>;

        $(function(){

            $("#info").sortable({
                handle : '.handle',
                update : function () {
                    var order = $('#info').sortable('serialize');

                    $.get( "/admin/lms/processinfo/set_order_num/"+pid+"?"+order, function( obj ) {
                        switch(obj) {
                            case '-1' : alert('순서를 변경하는 중 오류가 발생했습니다.');
                                top.location.reload();
                                break;
                            case '-2' : alert('권한이 없습니다.');
                                top.location.reload();
                                break;
                        }
                    });

                }
            });

        });

        function change_curriculum_div()
        {
            var curriculum_value = $('#curriculum_div').val();

            if(curriculum_value == 'item')
            {
                $('#content_div').hide();
                $('#item_span').show();
            } else {
                $.get('/admin/lms/processinfo/get_content_list/'+curriculum_value, function(data){
                    $('#content_div').html(data);
                });

                $('#item_span').hide();
                $('#content_div').show();
            }
        }

        function add()
        {
            var curriculum_value = $('#curriculum_div').val();
            var content_idx = $('#content_div').val();
            var item_cnt = $('#item_cnt').val();

            if(curriculum_value != 'item' && $('#chk_'+curriculum_value+'_'+content_idx).val() == 1)
            {
                alert('이미 등록된 컨텐츠입니다.');
                return false;
            }

            $.get('/admin/lms/processinfo/content_save/'+pid,
                {'curriculum_value':curriculum_value,'content_idx':content_idx,'item_cnt':item_cnt},
                function(data){
                    top.location.reload();
            });
        }

        function del(idx)
        {
            $.get('/admin/lms/processinfo/content_del/'+pid,
                {'curriculum_idx':idx},
                function(data){
                    top.location.reload();
                });
        }

        function change_item_cnt(idx)
        {
            var item_cnt = $('#item_cnt_'+idx).val();

            $.get('/admin/lms/processinfo/item_cnt/'+pid,
                {'curriculum_idx':idx, 'item_cnt':item_cnt},
                function(data){
                    top.location.reload();
                });
        }

        var clk_flag = 0;
        function clk_edit(id)
        {
            if(clk_flag != 0) return;
            clk_flag = 1;

            var value = $(id).html();

            var envid = $(id).attr('id');
            var arr_envid = envid.split('_');

            var idx = arr_envid[1];

            if(value == '<u>활성화</u>') value_flg = 'use';
            else value_flg = 'unuse';

            sel = "<select id='sel' onblur='blur_sel("+idx+")' style='width:90px;line-height:normal;padding:unset;display:unset;float:unset;'>";
            sel += "<option value='use'>활성화</option>";
            sel += "<option value='unuse'>비활성화</option>";
            sel += "</select>";

            $(id).html(sel);
            $('#sel').focus();

            $('#sel').val(value_flg);
        }

        function blur_sel(idx)
        {
            var value = $('#sel').val();
            var value_name = $("#sel option:selected").text();
            var envid = 'type_'+idx;

            value_name = "<u>"+value_name+"</u>";

            $.get("/admin/lms/processinfo/curriculum_use_save", { idx : idx, type_flg : value }, function(obj) {
                switch(obj) {
                    case '0'   :
                        $('#'+envid).html(value_name);
                        clk_flag = 0;
                        break;
                    case '-1'  : alert('error');
                        top.location.reload();
                        break;
                }
            });
        }
    //]]>
</script>
