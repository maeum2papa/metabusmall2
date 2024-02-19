<h2><?php echo element('menu_title', element('layout', $view)); ?></h2>
<div class="box">
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
        <div class="box-search">
            <table class="table table-hover table-striped table-bordered" style="text-align: left;">
                <colgroup>
                    <col width="15%">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th>부서 검색</th>
                        <td colspan="3"><input type="text" name="mem_div" value="<?php echo $this->input->get('mem_div'); ?>" class="form-control input-small"></td>
                    </tr>
                    <tr>
                        <th>입사일 검색</th>
                        <td colspan="3" class="form-inline">
							<input type="text" class="form-control input-small datepicker" name="mem_employ_1" value="<?php echo $this->input->get('mem_employ_1'); ?>" readonly="readonly" />
							 - 
							<input type="text" class="form-control input-small datepicker" name="mem_employ_2" value="<?php echo $this->input->get('mem_employ_2'); ?>" readonly="readonly" />
						</td>
                    </tr>
                    <tr>
                        <th>생일 검색</th>
                        <td colspan="3" class="form-inline">
							<input type="text" class="form-control input-small datepicker" name="mem_birthday_1" value="<?php echo $this->input->get('mem_birthday_1'); ?>" readonly="readonly" />
							 - 
							<input type="text" class="form-control input-small datepicker" name="mem_birthday_2" value="<?php echo $this->input->get('mem_birthday_2'); ?>" readonly="readonly" />
						</td>
                    </tr>
                    <tr>
                        <th>직원명</th>
                        <td colspan="3" class="form-inline">
                            <input type="text" class="form-control input-small" name="mem_username" value="<?php echo $this->input->get('mem_username'); ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <span class="input-group-btn">
                <button class="btn btn-default btn-sm" name="search_submit" type="submit">검색</button>
            </span>
        </div>
    </form>
</div>
<div class="box">
	<div class="box-table" style="max-height: 350px;overflow-y:scroll;">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="chkall" id="chkall" /></th>
                        <th>번호</th>
                        <th>소속</th>
                        <th>직급</th>
                        <th>직원명</th>
                        <th>아이디</th>
                        <th>이메일</th>
                        <th>입사일</th>
                        <th>생일</th>
                        <th>상태</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (element('list', element('data', $view))) {
                    foreach (element('list', element('data', $view)) as $result) {
                ?>
                    <tr>
                        <td title="관리"><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element('mem_id', $result); ?>" /></td>
                        <td title="번호"><?php echo number_format(element('num', $result)); ?></td>
                        <td title="소속"><?php echo element('mem_div', $result); ?></td>
                        <td title="직급"><?php echo element('mem_position', $result); ?></td>
                        <td title="직원명"><?php echo element('mem_username', $result); ?></td>
                        <td title="아이디"><?php echo element('mem_userid', $result); ?></td>
                        <td title="이메일"><?php echo element('mem_email', $result); ?></td>
                        <td title="입사일"><?php echo element('mem_employ', $result); ?></td>
                        <td title="생일"><?php echo element('mem_birthday', $result); ?></td>
                        <td title="상태"><?php echo element('mem_useYn', $result); ?></td>
                    </tr>
                <?php
                    }
                }
                if ( ! element('list', element('data', $view))) {
                ?>
                    <tr>
                        <td colspan="11" class="nopost">자료가 없습니다</td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
		<?php echo form_close(); ?>
	</div>
    <button type="button" class="btn" onclick="passValueToParent()">추가</button>
</div>
<script>
    function passValueToParent(){
        var selectedValues = [];
        // 모든 체크박스를 확인하고 선택된 값을 배열에 추가
        var checkboxes = document.getElementsByName('chk[]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedValues.push(checkboxes[i].value);
            }
        }
        
        // 선택된 값들을 부모 페이지로 전달
        parent.applyValues(selectedValues);
    }
</script>