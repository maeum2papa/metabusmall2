<div class="box">
    <div class="box-table">
        <div class="table-responsive">
            <h4>과정 현황 상세</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>로그인 아이디</th>
                        <th>이름</th>
                        <th>총 학습 시간</th>
                        <th>신청 과정</th>
                        <th>수료 과정</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo element('mem_email', element('post', $view)); ?></td>
                        <td><?php echo element('mem_username', element('post', $view)); ?></td>
                        <td><?php echo element('acctime', element('post', $view)); ?></td>
                        <td><?php echo element('lms_process_all', element('post', $view)); ?></td>
                        <td><?php echo element('lms_process_complete', element('post', $view)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-table">
        <?php
        $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
        echo form_open(current_full_url(), $attributes);
        ?>
        <div class="table-responsive">
            <h4>과정 학습자 현황</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>수강 신청한 카테고리</th>
                        <th>과정명</th>
                        <th>과정 시간</th>
                        <th>상태</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (element('list', $view)) {
                    foreach (element('list', $view) as $result) {
                ?>
                    <tr>
                        <td><?php echo element('cca_desc', $result); ?></td>
                        <td><?php echo element('p_title', $result); ?></td>
                        <td><?php echo element('acctime', $result); ?></td>
                        <td><?php echo element('p_status', $result); ?></td>
                    </tr>
                <?php
                    }
                }
                else {
                ?>
                    <tr>
                        <td colspan="6" class="nopost">자료가 없습니다</td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="box-info">
            <?php echo element('paging', $view); ?>
            <div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
        <div class="box-search">
            <table>
                <tbody>
                    <tr>
                        <th>검색</th>
                        <td class="row">
                            <select name="list_sfield" id="list_sfield" class="form-control">
                                <option value="lms_category" <?php if($this->input->get('list_sfield') == 'lms_category'){ echo 'selected'; } ?>>카테고리</option>
                                <option value="lms_title" <?php if($this->input->get('list_sfield') == 'lms_title'){ echo 'selected'; } ?>>과정명</option>
                            </select>
                            <div class="input-group">
                                <input type="text" class="form-control" name="list_skeyword" value="<?php echo $this->input->get('list_skeyword'); ?>" placeholder="Search for..." />
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
<script type="text/javascript">
$('select[name="mp_endYn"]').change(function(){
	$('#fsearch').submit();
});
</script>