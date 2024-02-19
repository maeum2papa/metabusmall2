<?php 
$url = uri_string(); 
$url_arr = explode('/', $url);
?>
<ul class="masterlmscnt-submenu btn-group">
    <li><a href="/admin/counter/masterlmscnt" class="btn btn-sm btn-default <?php if(!$url_arr[3]){ echo 'btn-warning'; } ?>">시간대별 학습통계</a></li>
	<li><a href="/admin/counter/masterlmscnt/apply" class="btn btn-sm btn-default <?php if($url_arr[3] == 'apply_detail'){ echo 'btn-warning'; } ?>">학습 신청 통계</a></li>
	<li><a href="/admin/counter/masterlmscnt/cert" class="btn btn-sm btn-default <?php if($url_arr[3] == 'cert'){ echo 'btn-warning'; } ?>">교육 이수증</a></li>
</ul>
<div class="">
	<a href="./<?php echo element('p_sno', $view); ?>" class="btn btn-outline btn-sm">전체</a>
	<?php foreach(element('filter', $view) as $k => $v){ ?>
		<a href="?company_idx=<?php echo element('company_idx', $v); ?>" class="btn btn-outline btn-sm"><?php echo element('company_name', $v); ?></a>
	<?php } ?>
</div>
<div class="box">
    <div class="box-table">
        <div class="table-responsive">
            <h4>과정 현황 상세</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>과정명</th>
                        <th>플랜</th>
                        <th>등록일</th>
                        <th>신청자 수</th>
                        <th>수료자 수</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo element('p_title', element('board', element('post', $view))); ?></td>
                        <td><?php echo element('plan_name', element('board', element('post', $view))); ?></td>
                        <td><?php echo element('p_regDt', element('board', element('post', $view))); ?></td>
                        <td><?php echo element('plan_apply_cnt', element('board', element('post', $view))); ?></td>
                        <td><?php echo element('plan_end_cnt', element('board', element('post', $view))); ?></td>
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
        <input type="hidden" name="company_idx" value="<?php echo $this->input->get('company_idx'); ?>">
        <div class="table-responsive">
            <h4>과정 학습자 현황</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>아이디</th>
                        <th>이름</th>
                        <th>과정 시간</th>
                        <th>상태</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (element('board', element('list', $view))) {
                    foreach (element('board', element('list', $view)) as $result) {
                ?>
                    <tr>
                        <td><?php echo element('mem_email', $result); ?></td>
                        <td><?php echo element('mem_username', $result); ?></td>
                        <td><?php echo element('p_time', $result); ?></td>
                        <td>
                            <?php if(element('p_status', $result) == 'FINISH'){ ?>
                                <a href="/admin/counter/masterlmscnt/cert?cca_id_fir=<?php echo element('cca_id_fir', element('board', element('post', $view))); ?>&cca_id_sec=<?php echo element('cca_id_sec', element('board', element('post', $view))); ?>&list_skeyword=<?php echo element('p_title', element('board', element('post', $view))); ?>&mem_username=<?php echo element('mem_username', $result); ?>"><?php echo element('p_status', $result); ?></a>
                            <?php } else { ?>
                                <?php echo element('p_status', $result); ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                    }
                }
                if ( ! element('board', element('list', $view))) {
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
        <input type="hidden" name="company_idx" value="<?php echo $this->input->get('company_idx'); ?>">
        <div class="box-search">
            <table>
                <tbody>
                    <tr>
                        <th>상태</th>
                        <td class="row">
                            <select name="mp_endYn" id="mp_endYn" class="form-control">
                                <option value="" <?php if($this->input->get('mp_endYn') == '' || !$this->input->get('mp_endYn')){ echo 'selected'; } ?>>전체</option>
                                <option value="n" <?php if($this->input->get('mp_endYn') == 'n'){ echo 'selected'; } ?>>수강중</option>
                                <option value="y" <?php if($this->input->get('mp_endYn') == 'y'){ echo 'selected'; } ?>>수강완료</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>검색</th>
                        <td class="row">
                            <select name="list_sfield" id="list_sfield" class="form-control">
                                <option value="mem_email" <?php if($this->input->get('list_sfield') == 'mem_email'){ echo 'selected'; } ?>>아이디</option>
                                <option value="mem_username" <?php if($this->input->get('list_sfield') == 'mem_username'){ echo 'selected'; } ?>>이름</option>
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