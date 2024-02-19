<div class="box">
    <div class="box-table">
        <?php
        echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
        $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist', 'method' => 'get');
        echo form_open('/admin/lms/processinfo', $attributes);
        ?>
        <div class="box-table-header">
            <label class="col-sm-1 control-label">플랜</label>
            <div class="btn-group btn-group-sm" role="group">
            <?php  foreach($view['plan_list'] as $l) { ?>
                <label for="chk_plan_<?php echo $l['plan_idx']?>" class="checkbox-inline">
                    <input type="checkbox" id="chk_plan_<?php echo $l['plan_idx']?>" name="chk_plan_<?php echo $l['plan_idx']?>" value="1"> <?php echo $l['plan_name']?>
                </label>
            <?php } ?>
            </div>
            <div class="row"></div>
            <label class="col-sm-1 control-label">기간</label>
            <div class="btn-group btn-group-sm" role="group">
                <select class="form-control" id="sh_span" name="sh_span">
                    <option value="reg_date">등록일</option>
                    <option value="view_sdate">노출시작일</option>
                    <option value="view_edate">노출종료일</option>
                </select>
                <input type="text" class="form-control" name="sday" id="sday" value="<?php echo $this->input->get('sday'); ?>" readonly /> -
                <input type="text" class="form-control" name="eday" id="eday" value="<?php echo $this->input->get('eday'); ?>" readonly /> &nbsp;
                <div class="btn-group pull-right" role="group" aria-label="...">
                    <a href="javascript:clk_day(1);" class="btn btn-outline btn-default btn-sm">오늘</a>
                    <a href="javascript:clk_day(7);" class="btn btn-outline btn-default btn-sm">7일</a>
                    <a href="javascript:clk_day(15);" class="btn btn-outline btn-default btn-sm">15일</a>
                    <a href="javascript:clk_day(30);" class="btn btn-outline btn-default btn-sm">1개월</a>
                    <a href="javascript:clk_day(90);" class="btn btn-outline btn-default btn-sm">3개월</a>
                    <a href="javascript:clk_day(0);" class="btn btn-outline btn-default btn-sm">전체</a>
                </div>
            </div>
            <div class="row"></div>
            <label class="col-sm-1 control-label">카테고리</label>
            <div class="btn-group btn-group-sm" role="group">
                <select class="form-control" name="cate_1" id="cate_1" onchange="category_change()">
                    <option value="">전체</option>
                    <?php foreach($view['category_list'] as $l) { echo "<option value='".$l['cca_id']."'>".$l['cca_value']."</option>";}?>
                </select>
                <select class="form-control" name="cate_2" id="cate_2">
                    <option value="">없음</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
                <label class="control-label">과정명</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="skeyword" value="<?php echo $this->input->get('skeyword'); ?>"/>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" name="search_submit" type="submit">검색</button>
                    </span>
                </div>
            </div>
            <?php
            ob_start();
            ?>
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
                <a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">과정추가</a>
            </div>
            <?php
            $buttons = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>idx</th>
                    <th>플랜명</th>
                    <th><a href="<?php echo element('process_title', element('sort', $view)); ?>">과정명</a></th>
                    <th>필수여부</th>
                    <th>추천여부</th>
                    <th>노출시작일</th>
                    <th>노출종료일</th>
                    <th><a href="<?php echo element('state', element('sort', $view)); ?>">활성화여부</a></th>
                    <th><a href="<?php echo element('reg_date', element('sort', $view)); ?>">등록일시</a></th>
                    <th>수정</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (element('list', element('data', $view))) {
                    foreach (element('list', element('data', $view)) as $result) {
                        ?>
                        <tr>
                            <td><?php echo element('process_idx', $result); ?></td>
                            <td><?php echo element('plan_name', $result); ?></td>
                            <td><?php echo element('process_title', $result); ?></td>
                            <td><?php echo $view['flag_str'][element('required_flag', $result)]; ?></td>
                            <td><?php echo $view['flag_str'][element('propose_flag', $result)]; ?></td>
                            <td><?php echo element('view_sdate', $result); ?></td>
                            <td><?php echo element('view_edate', $result); ?></td>
                            <td><?php echo $view['state_str'][element('state', $result)]; ?></td>
                            <td><?php echo element('reg_date', $result); ?></td>
                            <td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
                        </tr>
                <?php
                    }
                } else echo '<tr><td colspan="10" class="nopost">자료가 없습니다</td></tr>';
                ?>
                </tbody>
            </table>
        </div>
        <div class="box-info">
            <?php echo element('paging', $view); ?>
            <div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
            <?php echo $buttons; ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
    $(function() {
        $('#eday').datepicker({format: "yyyy-mm-dd",language : "kr"});
        $('#sday').datepicker({format: "yyyy-mm-dd",language : "kr"});

        $('#sh_span').val('<?php echo $this->input->get('sh_span'); ?>');

        $('#cate_1').val('<?php echo $this->input->get('cate_1'); ?>');
        category_load();

        <?php  foreach($view['plan_list'] as $l) {
                    $chk_flag = ($view['plan_chkflag'] == 0)? 1 : $this->input->get('chk_plan_'.$l['plan_idx']);
        ?>
            $("input:checkbox[id='chk_plan_<?php echo $l['plan_idx']?>']").prop("checked", <?php echo ($chk_flag == '')? 0 : $chk_flag;?>);
        <?php } ?>
    });

    function category_load()
    {
        var pid = $('#cate_1').val();
        var cate_2 = '<?php echo $this->input->get('cate_2'); ?>';

        if(pid == '')
        {
            data = '<option value="">없음</option>';
            $('#cate_2').html(data);
        } else {
            $.get('/admin/lms/processinfo/get_category_sub/' + pid, function (data) {
                $('#cate_2').html(data);
                if(cate_2 != '') $('#cate_2').val(cate_2);
            });
        }
    }

    function category_change()
    {
        var pid = $('#cate_1').val();
        
        if(pid == '')
        {
            data = '<option value="">없음</option>';
            $('#cate_2').html(data);
        } else {
            $.get('/admin/lms/processinfo/get_category_sub/' + pid, function (data) {
                $('#cate_2').html(data);
            });
        }
    }

    function clk_day(mode)
    {
        var nowday = '<?php echo $view['nowday']?>';
        var weekday = '<?php echo $view['weekday']?>';
        var fiftday = '<?php echo $view['fiftday']?>';
        var month = '<?php echo $view['month']?>';
        var months = '<?php echo $view['months']?>';

        $('#eday').val(nowday);

        switch(mode) {
            case 0:
                $('#eday').val('');
                $('#sday').val('');
                break;
            case 1:
                $('#sday').val(nowday);
                break;
            case 7:
                $('#sday').val(weekday);
                break;
            case 15:
                $('#sday').val(fiftday);
                break;
            case 30:
                $('#sday').val(month);
                break;
            case 90:
                $('#sday').val(months);
                break;
        }
    }
    //]]>
</script>

