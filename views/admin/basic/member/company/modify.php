<style>
    .readonly{color: #7f7f7f;}
</style>
<div class="box">
	<div class="box-table">
        <?php
            echo show_alert_message($this->session->flashdata('message1'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminmodify1', 'id' => 'fadminmodify1');
            echo form_open_multipart(admin_url($this->pagedir).'/update'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
        ?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
            <input type="hidden" id="code_chk" value="<?php echo set_value('code_chk', element('code_chk', element('data', $view))); ?>" />
            <input type="hidden" name="mode" value="update1">
            <div class="box-table-header">
                <h4>기업정보</h4>
                <a class="btn btn-success btn-sm" href="javascript:modify(1);" style="float: right;">수정</a>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">기업명</th>
                        <td class="col-sm-4 form-inline readonly"><?php echo set_value('company_name', element('company_name', element('data', $view))); ?></td>
                        <th class="col-sm-2">기업명(영문)</th>
                        <td class="col-sm-4 form-inline readonly"><?php echo set_value('company_code', element('company_code', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">기업로고</th>
                        <td colspan="3" class="col-sm-10 form-inline">
                            <?php
                            if(element('company_logo', element('data', $view)))
                                echo "<img src='".element('company_logo', element('data', $view))."' style='width:100px;height:auto;'/>";
                            ?>
                            <input type="file" name="company_logo_file" id="company_logo_file" />
                            <p class="help-block"></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">주소</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_addr" value="<?php echo set_value('company_addr', element('company_addr', element('data', $view))); ?>" /></td>
                        <th class="col-sm-2">전화번호</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_tel" value="<?php echo set_value('company_tel', element('company_tel', element('data', $view))); ?>" /></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">사업자번호</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_num" value="<?php echo set_value('company_num', element('company_num', element('data', $view))); ?>" /></td>
                        <th class="col-sm-2">세금 계산 메일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_mail" value="<?php echo set_value('company_mail', element('company_mail', element('data', $view))); ?>" /></td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">업종</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_type" value="<?php echo set_value('company_type', element('company_type', element('data', $view))); ?>" /></td>
                        <th class="col-sm-2">업태</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_uptae" value="<?php echo set_value('company_uptae', element('company_uptae', element('data', $view))); ?>" /></td>
                    </tr>
                </tbody>
            </table>
        <?php echo form_close(); ?>
        <?php
            echo show_alert_message($this->session->flashdata('message2'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminmodify2', 'id' => 'fadminmodify2');
            echo form_open_multipart(admin_url($this->pagedir).'/update'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
        ?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
            <input type="hidden" id="code_chk" value="<?php echo set_value('code_chk', element('code_chk', element('data', $view))); ?>" />
            <input type="hidden" name="mode" value="update2">
            <div class="box-table-header">
                <h4>결제정보</h4>
                <a class="btn btn-success btn-sm" href="javascript:modify(2);" style="float: right;">수정</a>
                <a class="btn btn-default btn-sm" href="javascript:void(0);" style="float: right;">플랜 결제</a>
                <a class="btn btn-default btn-sm" href="javascript:void(0);" style="float: right;">결제 내역</a>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">플랜명/상품</th>
                        <td class="col-sm-4 form-inline">
                            <select name="plan_idx" id="plan_idx" class="form-control">
                                <?php  foreach($view['plan_list'] as $l) { echo "<option value='".$l['plan_idx']."'>".$l['plan_name']."</option>";}?>
                            </select> / 
                            <select name="plan_type" id="plan_type" class="form-control">
                                <option value="m" <?php if(element('plan_type', element('data', $view)) == 'm'){ echo 'selected'; } ?>>월간</option>
                                <option value="y" <?php if(element('plan_type', element('data', $view)) == 'y'){ echo 'selected'; } ?>>연간</option>
                            </select>
                        </td>
                        <th class="col-sm-2">상태</th>
                        <td class="col-sm-4 form-inline">
                            <select name="state" id="state" class="form-control">
                                <option value="use">활성화</option>
                                <option value="unuse">비활성화</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">이용 가능 인원</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="use_cnt" value="<?php echo set_value('use_cnt', element('use_cnt', element('data', $view))); ?>" />명</td>
                        <th class="col-sm-2">현재 이용 인원</th>
                        <td class="col-sm-4 form-inline readonly"><?php echo set_value('mem_use_cnt', element('mem_use_cnt', element('data', $view))); ?>명</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">이용시작일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" id="use_sday" name="use_sday" value="<?php echo set_value('use_sday', element('use_sday', element('data', $view))); ?>"  /></td>
                        <th class="col-sm-2">이용종료일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" id="use_eday" name="use_eday" value="<?php echo set_value('use_eday', element('use_eday', element('data', $view))); ?>"  /></td>
                    </tr>
                </tbody>
            </table>
        <?php echo form_close(); ?>
        <?php
            echo show_alert_message($this->session->flashdata('message3'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminmodify3', 'id' => 'fadminmodify3');
            echo form_open_multipart(admin_url($this->pagedir).'/update'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
        ?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
            <input type="hidden" id="code_chk" value="<?php echo set_value('code_chk', element('code_chk', element('data', $view))); ?>" />
            <input type="hidden" name="mode" value="update3">
            <div class="box-table-header">
                <h4>서비스정보</h4>
                <a class="btn btn-success btn-sm" href="javascript:modify(3);" style="float: right;">수정</a>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">적용 템플릿 - 오피스</th>
                        <td class="col-sm-10 form-inline">
                            <select name="template_office" id="template_office" class="form-control">
                            <?php foreach (element('office_list', $view) as $v) { ?>
                                <option value="<?=$v[tp_sno]?>" <?php if(element('template_office', element('data', $view)) == $v[tp_sno]){?>selected<?php } ?>><?php if(!$v['tp_nm_ko']){ echo $v['tp_nm'];} else {echo $v['tp_nm_ko'];}?></option>
                            <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">적용 템플릿 - 교육실</th>
                        <td class="col-sm-10 form-inline">
                            <select name="template_class" id="template_class" class="form-control">
                            <?php foreach (element('class_list', $view) as $v) { ?>
                                <option value="<?=$v[tp_sno]?>" <?php if(element('template_class', element('data', $view)) == $v[tp_sno]){?>selected<?php } ?>><?php if(!$v['tp_nm_ko']){ echo $v['tp_nm'];} else {echo $v['tp_nm_ko'];}?></option>
                            <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">적용 템플릿 - 마이랜드 외부</th>
                        <td class="col-sm-10 form-inline">
                            <select name="template_outer" id="template_outer" class="form-control">
                            <?php foreach (element('outer_list', $view) as $v) { ?>
                                <option value="<?=$v[tp_sno]?>" <?php if(element('template_outer', element('data', $view)) == $v[tp_sno]){?>selected<?php } ?>><?php if(!$v['tp_nm_ko']){ echo $v['tp_nm'];} else {echo $v['tp_nm_ko'];}?></option>
                            <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">적용 템플릿 - 마이랜드 내부</th>
                        <td class="col-sm-10 form-inline">
                            <select name="template_inner" id="template_inner" class="form-control">
                            <?php foreach (element('inner_list', $view) as $v) { ?>
                                <option value="<?=$v[tp_sno]?>" <?php if(element('template_inner', element('data', $view)) == $v[tp_sno]){?>selected<?php } ?>><?php if(!$v['tp_nm_ko']){ echo $v['tp_nm'];} else {echo $v['tp_nm_ko'];}?></option>
                            <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">잔여 예치금</th>
                        <td class="col-sm-10 form-inline">
                            <input type="text" class="form-control" name="company_deposit" value="<?php echo set_value('company_deposit', element('company_deposit', element('data', $view))); ?>" />원
                            <a class="btn btn-default btn-sm" href="/admin/member/company/deposit/<?php echo element(element('primary_key', $view), element('data', $view)); ?>" style="float: right;">예치금 사용 내역</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php echo form_close(); ?>
        <?php
            echo show_alert_message($this->session->flashdata('message4'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminmodify4', 'id' => 'fadminmodify4');
            echo form_open_multipart(admin_url($this->pagedir).'/update'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
        ?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
            <input type="hidden" id="code_chk" value="<?php echo set_value('code_chk', element('code_chk', element('data', $view))); ?>" />
            <input type="hidden" name="mode" value="update4">
            <div class="box-table-header">
                <h4>담당자정보</h4>
                <a class="btn btn-success btn-sm" href="javascript:modify(4);" style="float: right;">수정</a>
            </div>
            <div id="contact-info">
                <?php
                if(element('manage_name_1', element('data', $view))){ 
                    for($i=1;$i<=10;$i++){ 
                        if(element('manage_name_'.$i, element('data', $view))){
                            if(element('manage_name_'.$i, element('data', $view))){ 
                ?>
                <table class="table table-hover table-striped table-bordered add_<?php echo $i;?>">
                    <tbody>
                        <tr>
                            <th class="col-sm-2">이름</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_name_<?php echo $i;?>" value="<?php echo set_value('manage_name_'.$i, element('manage_name_'.$i, element('data', $view))); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">부서 / 직책</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_div_<?php echo $i;?>" value="<?php echo set_value('manage_div_'.$i, element('manage_div_'.$i, element('data', $view))); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">이메일</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_email_<?php echo $i;?>" value="<?php echo set_value('manage_email_'.$i, element('manage_email_'.$i, element('data', $view))); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">전화번호</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_tel_<?php echo $i;?>" value="<?php echo set_value('manage_tel_'.$i, element('manage_tel_'.$i, element('data', $view))); ?>" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php
                            }
                        } 
                    } 
                } else { 
                ?>
                <table class="table table-hover table-striped table-bordered add_1">
                    <tbody>
                        <tr>
                            <th class="col-sm-2">이름</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_name_1" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">부서 / 직책</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_div_1" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">이메일</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_email_1" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">전화번호</th>
                            <td class="col-sm-10 form-inline">
                                <input type="text" class="form-control" name="manage_tel_1" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } ?>
            </div>
            
            <button type="button" onclick="addContactInfo('contact-info', 1);" id="contact-info-add-btn" class="btn btn-default btn-sm">추가</button>
            <button type="button" onclick="delContactInfo('contact-info', 1);" id="contact-info-del-btn" class="btn btn-default btn-sm">삭제</button>
        <?php echo form_close(); ?>
        <?php
            echo show_alert_message($this->session->flashdata('message5'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminmodify5', 'id' => 'fadminmodify5');
            echo form_open_multipart(admin_url($this->pagedir).'/update'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
        ?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
            <input type="hidden" id="code_chk" value="<?php echo set_value('code_chk', element('code_chk', element('data', $view))); ?>" />
            <input type="hidden" name="mode" value="update5">
            <div class="box-table-header">
                <h4>조직정보</h4>
                <a class="btn btn-success btn-sm" href="javascript:modify(5);" style="float: right;">수정</a>
            </div>
            <input type="hidden" name="chart_data" id="chart_data">
            <link href="/assets/css/jquery.orgchart.css" media="all" rel="stylesheet" type="text/css" />
            <div id="orgChartContainer">
                <div id="orgChart"></div>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript" src="/assets/js/jquery.orgchart.js"></script>
<script type="text/javascript">
    document.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        };
    }, true);
    var organData = [
        <?php if(element('organ', element('data', $view))){ ?>
        <?php foreach(element('organ', element('data', $view)) as $k => $v){ ?>
        {id: <?php echo element('oc_id', $v);?>, name: '<?php echo element('oc_name', $v);?>', parent: <?php echo element('oc_parent', $v);?>},
        <?php } ?>
        <?php } else { ?>
        {id: 1, name: '<?php echo set_value('company_name', element('company_name', element('data', $view))); ?>', parent: 0},
        <?php } ?>
    ];
    var org_chart;
    var maxHierarchy = 10; // 최대 노드 계층 수

    $(function(){
        org_chart = $('#orgChart').orgChart({
            data: organData,
            showControls: true,
            allowEdit: true,
            onAddNode: function (node) {
                if (shouldNode() === false) {
                    return false;
                }
                // 현재 노드 계층 수 확인
                var hierarchy = getHierarchy(node.data.id);
                if (hierarchy >= maxHierarchy) {
                    alert('노드 계층 수는 최대 ' + maxHierarchy + '까지만 가능합니다.');
                    return;
                }
                org_chart.newNode(node.data.id);
            },
            onDeleteNode: function(node){
                if (shouldNode() === false) {
                    return false;
                }

                var result = confirm('삭제하시겠습니까?');
                if(result){
                    org_chart.deleteNode(node.data.id);
                }
            }
        });

        $('#fadminmodify5 .node h2').each(function(){
            $(this).on('click', function(){
                if (shouldNode() === false) {
                    return false;
                }
            });
        });
    });

    function shouldNode(){
        if($('#fadminmodify5 .btn-success').text() == '수정'){
            alert('수정 버튼을 클릭해주세요.');
            return false;
        }
    }
</script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
    // 등록된 담당자 정보에 따른 onclick 값 변경
    var tbleng = $('#contact-info table').length;
    $('#contact-info-add-btn').attr('onclick', 'addContactInfo("contact-info",'+tbleng+')');
    $('#contact-info-del-btn').attr('onclick', 'delContactInfo("contact-info",'+tbleng+')');
    $('#fadminmodify1 input[type=text]').attr('readonly', true);
    $('#fadminmodify1 input[type=text]').css('color','#7F7F7F');
    $('#fadminmodify2 input[type=text]').attr('readonly', true);
    $('#fadminmodify2 input[type=text]').css('color','#7F7F7F');
    $('#fadminmodify2 select option').attr('disabled', 'disabled');
    $('#fadminmodify2 select').css('color','#7F7F7F');
    $('#fadminmodify3 input[type=text]').attr('readonly', true);
    $('#fadminmodify3 input[type=text]').css('color','#7F7F7F');
    $('#fadminmodify3 select option').attr('disabled', 'disabled');
    $('#fadminmodify3 select').css('color','#7F7F7F');
    $('#fadminmodify4 input[type=text]').attr('readonly', true);
    $('#fadminmodify4 input[type=text]').css('color','#7F7F7F');
});
$(function() {
	$('#fadminmodify1').validate({
		rules: {
            company_mail: { email :true }
		}
	});

    $('#fadminmodify4').validate({
		rules: {
            manage_email_1: { email:true },
            manage_email_2: { email:true },
            manage_email_3: { email:true },
            manage_email_4: { email:true },
            manage_email_5: { email:true },
            manage_email_6: { email:true },
            manage_email_7: { email:true },
            manage_email_8: { email:true },
            manage_email_9: { email:true },
            manage_email_10: { email:true }
		}
	});

    $('#state').val('<?php echo set_value('state', element('state', element('data', $view))); ?>');
    $('#template_idx').val('<?php echo set_value('template_idx', element('template_idx', element('data', $view))); ?>');
    $('#plan_idx').val('<?php echo set_value('plan_idx', element('plan_idx', element('data', $view))); ?>');
});

function company_code_edit()
{
    $('#code_chk').val('');
}

function modify(num)
{
    $('#fadminmodify'+num+' input[type=text]').attr('readonly', false);
    $('#fadminmodify'+num+' input[type=text]').css('color','#000000');
    $('#fadminmodify'+num+' #use_sday').datepicker({format: "yyyy-mm-dd",language : "kr"});
    $('#fadminmodify'+num+' #use_eday').datepicker({format: "yyyy-mm-dd",language : "kr"});
    $('#fadminmodify'+num+' select option').removeAttr('disabled');
    $('#fadminmodify'+num+' select').css('color','#000000');
    $('#fadminmodify'+num+' .btn-success').attr('href','javascript:save('+num+');');
    $('#fadminmodify'+num+' .btn-success').text('저장');
}

function save(num)
{
    var regex = /^[a-z0-9+]*$/;

    var chk = $('#code_chk').val();
    var company_code = $('#company_code').val();

    if(num == 1){
        if($('input[name="company_addr"]').val() == ''){
            alert('주소를 입력해주세요.');
            return false;
        }

        if($('input[name="company_tel"]').val() == ''){
            alert('전화번호를 입력해주세요.');
            return false;
        }

        if($('input[name="company_num"]').val() == ''){
            alert('사업자번호를 입력해주세요.');
            return false;
        }

        if($('input[name="company_mail"]').val() == ''){
            alert('세금 계산 메일을 입력해주세요.');
            return false;
        }

        if($('input[name="company_type"]').val() == ''){
            alert('업종을 입력해주세요.');
            return false;
        }

        if($('input[name="company_uptae"]').val() == ''){
            alert('업태을 입력해주세요.');
            return false;
        }
    } else if(num == 5){
        var chartDataRe = org_chart.getData();
        $('#chart_data').val(JSON.stringify(chartDataRe));
    }
    
    $('#fadminmodify'+num).submit();
}

function addContactInfo(name, idx){
    if($('#fadminmodify4 .btn-success').text() == '수정'){
        alert('수정 버튼을 클릭해주세요.');
        return false;
    }
    if(idx == 10){
        alert('더 이상 추가할 수 없습니다.');
        return false;
    }
    var index = parseInt(idx) + 1;
    var addName = name + index;
    var msg = "";
    msg += "<table class='table table-hover table-striped table-bordered add_"+index+"'><tbody>";
    msg += "<tr><th class='col-sm-2'>이름</th><td class='col-sm-10 form-inline'>";
    msg += "<input type='text' class='form-control' name='manage_name_"+index+"' value='' />";
    msg += "</td></tr>";
    msg += "<tr><th class='col-sm-2'>부서 / 직책</th><td class='col-sm-10 form-inline'>";
    msg += "<input type='text' class='form-control' name='manage_div_"+index+"' value='' />";
    msg += "</td></tr>";
    msg += "<tr><th class='col-sm-2'>이메일</th><td class='col-sm-10 form-inline'>";
    msg += "<input type='text' class='form-control' name='manage_email_"+index+"' value='' />";
    msg += "</td></tr>";
    msg += "<tr><th class='col-sm-2'>전화번호</th><td class='col-sm-10 form-inline'>";
    msg += "<input type='text' class='form-control' name='manage_tel_"+index+"' value='' />";
    msg += "</td></tr>";
    msg += "</tbody></table>";
    $('#'+name).append(msg);
    $('#'+name+'-add-btn').attr('onclick', 'addContactInfo("'+name+'",'+index+')');
    $('#'+name+'-del-btn').attr('onclick', 'delContactInfo("'+name+'",'+index+')');
}

function delContactInfo(name, idx){
    if($('#fadminmodify4 .btn-success').text() == '수정'){
        alert('수정 버튼을 클릭해주세요.');
        return false;
    }
    if(idx == 1){
        alert('더 이상 삭제할 수 없습니다.');
        return false;
    }
    var index = parseInt(idx) - 1;
    $('#'+name+' .add_'+idx).remove();
    $('#'+name+'-add-btn').attr('onclick', 'addContactInfo("'+name+'",'+index+')');
    $('#'+name+'-del-btn').attr('onclick', 'delContactInfo("'+name+'",'+index+')');
}

// 현재 노드 계층 수를 추적하는 함수
function getHierarchy(nodeId) {
    var hierarchy = 0;
    var currentNodeId = nodeId;
    var chartData = org_chart.getData();

    while (currentNodeId !== 0) {
        var parentNode = findNodeById(currentNodeId, chartData);
        if (parentNode) {
            currentNodeId = parentNode.parent;
            hierarchy++;
        } else {
            break;
        }
    }

    return hierarchy;
}

// id를 기반으로 노드를 찾는 함수
function findNodeById(nodeId, chartData) {
    for (var i = 0; i < chartData.length; i++) {
        if (chartData[i].id === nodeId) {
            return chartData[i];
        }
    }
    return null;
}
//]]>
</script>