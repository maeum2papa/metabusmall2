<div class="box">
	<div class="box-table">
    <?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(admin_url($this->pagedir).'/save'. '?' . $this->input->server('QUERY_STRING', null, ''), $attributes);
		
    ?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>" value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
            <input type="hidden" id="code_chk" value="<?php echo set_value('code_chk', element('code_chk', element('data', $view))); ?>" />
            <div class="box-table-header">
                <h4>기업정보</h4>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-sm-2">기업명</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" name="company_name" value="<?php echo set_value('company_name', element('company_name', element('data', $view))); ?>" /></td>
                        <th class="col-sm-2">기업명(영문)</th>
                        <td class="col-sm-4 form-inline">
                            <input type="text" class="form-control" id="company_code" name="company_code" onchange="company_code_edit();" value="<?php echo set_value('company_code', element('company_code', element('data', $view))); ?>" />
                            <a class="btn btn-default btn-sm" href="javascript:chk_code();" >중복확인</a>
                        </td>
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

            <div class="box-table-header">
                <h4>결제정보</h4>
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
                        <td class="col-sm-4 form-inline"><?php echo set_value('mem_use_cnt', element('mem_use_cnt', element('data', $view))); ?>명</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">이용시작일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" id="use_sday" name="use_sday" value="<?php echo set_value('use_sday', element('use_sday', element('data', $view))); ?>" readonly /></td>
                        <th class="col-sm-2">이용종료일</th>
                        <td class="col-sm-4 form-inline"><input type="text" class="form-control" id="use_eday" name="use_eday" value="<?php echo set_value('use_eday', element('use_eday', element('data', $view))); ?>" readonly /></td>
                    </tr>
                </tbody>
            </table>

            <div class="box-table-header">
                <h4>서비스정보</h4>
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
                        <td class="col-sm-10 form-inline"><input type="text" class="form-control" name="company_deposit" value="<?php echo set_value('company_deposit', element('company_deposit', element('data', $view))); ?>" />원</td>
                    </tr>
                </tbody>
            </table>

            <div class="box-table-header">
                <h4>담당자정보</h4>
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

            <div class="box-table-header">
                <h4>조직정보</h4>
            </div>
            <input type="hidden" name="chart_data" id="chart_data">
            <link href="/assets/css/jquery.orgchart.css" media="all" rel="stylesheet" type="text/css" />
            <div id="orgChartContainer">
                <div id="orgChart"></div>
            </div>


            <!-- <div class="form-group">
                <label class="col-sm-2 control-label">재화가치</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="coin_value" value="<?php echo set_value('coin_value', element('coin_value', element('data', $view))); ?>" />
                </div>
            </div> -->
            
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back">취소하기</button>
				<a class="btn btn-success btn-sm" href="javascript:save();">저장하기</a>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript" src="/assets/js/jquery.orgchart.js"></script>
<script type="text/javascript">
    var organData = [
        {id: 1, name: '<?php echo set_value('company_name', element('company_name', element('data', $view))); ?>', parent: 0}
    ];
    var org_chart;
    var maxHierarchy = 10; // 최대 노드 계층 수

    $(function(){
        org_chart = $('#orgChart').orgChart({
            data: organData,
            showControls: true,
            allowEdit: true,
            onAddNode: function (node) {
                // 현재 노드 계층 수 확인
                var hierarchy = getHierarchy(node.data.id);
                if (hierarchy >= maxHierarchy) {
                    alert('노드 계층 수는 최대 ' + maxHierarchy + '까지만 가능합니다.');
                    return;
                }
                org_chart.newNode(node.data.id);
            },
            onDeleteNode: function(node){
                var result = confirm('삭제하시겠습니까?');
                if(result){
                    org_chart.deleteNode(node.data.id);
                }
            }
        });
    });
</script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
    // 등록된 담당자 정보에 따른 onclick 값 변경
    var tbleng = $('#contact-info table').length;
    $('#contact-info-add-btn').attr('onclick', 'addContactInfo("contact-info",'+tbleng+')');
    $('#contact-info-del-btn').attr('onclick', 'delContactInfo("contact-info",'+tbleng+')');
});
$(function() {
	$('#fadminwrite').validate({
		rules: {
            company_name: { required: true },
            company_mail: { email :true },
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

    $('#use_sday').datepicker({format: "yyyy-mm-dd",language : "kr"});
    $('#use_eday').datepicker({format: "yyyy-mm-dd",language : "kr"});

    $('#state').val('<?php echo set_value('state', element('state', element('data', $view))); ?>');
    $('#template_idx').val('<?php echo set_value('template_idx', element('template_idx', element('data', $view))); ?>');
    $('#plan_idx').val('<?php echo set_value('plan_idx', element('plan_idx', element('data', $view))); ?>');

    $('input[name="company_name"]').change(function(){
        $('div[node-id="1"] h2').html($('input[name="company_name"]').val());
    });
});

function company_code_edit()
{
    $('#code_chk').val('');
}

function chk_code()
{
    var regex = /^[a-z0-9+]*$/;

    var company_code = $('#company_code').val();

    if(company_code == '')
    {
        alert('서브도메인명이 입력되지 않았습니다.');
        return false;
    }

    if(company_code != '' && !regex.test(company_code))
    {
        alert('서브도메인명은 소문자/숫자만 사용가능합니다.');
        return false;
    }

    $.get('<?php echo admin_url($this->pagedir).'/chk_code';?>?code='+company_code, function(data){
        if(data > 0)
        {
            $('#code_chk').val('');
            alert('중복된 서브도메인명이 있습니다.');
        } else {
            $('#code_chk').val(1);
            alert('입력된 서브도메인명은 사용가능합니다.');
        }
    });

}

function save()
{
    var regex = /^[a-z0-9+]*$/;

    var chk = $('#code_chk').val();
    var company_code = $('#company_code').val();

    if(company_code != '' && !regex.test(company_code))
    {
        alert('서브도메인명은 소문자/숫자만 사용가능합니다.');
        return false;
    }

    if(company_code != '' && chk == '')
    {
        alert('서브도메인명 중복체크는 필수 입니다.');
        return false;
    }

    if($('input[name="company_name"]').val() == ''){
        alert('기업명을 입력해주세요.');
        return false;
    }

    if($('input[name="company_code"]').val() == ''){
        alert('기업명(영문)을 입력해주세요.');
        return false;
    }

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

    var chartDataRe = org_chart.getData();
    $('#chart_data').val(JSON.stringify(chartDataRe));

    $('#fadminwrite').submit();
}

function addContactInfo(name, idx){
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