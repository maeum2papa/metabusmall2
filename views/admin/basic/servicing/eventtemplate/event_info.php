<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>이벤트명</th>
                        <td><?php echo element('event_name', element('basic', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th>이벤트 내용</th>
                        <td><?php echo element('event_contents', element('basic', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th>이벤트 시작일</th>
                        <td><?php echo element('event_startDt', element('basic', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th>이벤트 종료일</th>
                        <td><?php echo element('event_endDt', element('basic', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th>상태</th>
                        <td><?php echo element('event_showFl', element('basic', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th>템플릿</th>
                        <td><?php echo element('template_name', element('basic', element('data', $view))); ?></td>
                    </tr>
                    <tr>
                        <th>칭호</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>지급 포인트</th>
                        <td><?php echo number_format(element('event_point', element('basic', element('data', $view)))); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
		<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><a href="<?php echo element('event_idx', element('sort', $view)); ?>">번호</a></th>
							<th>소속</th>
							<th>직급</th>
							<th>직원명</th>
							<th>아이디</th>
                            <th>이메일</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td title="번호"><?php echo number_format(element('num', $result)); ?></td>
							<td title="소속"><?php echo element('mem_div', $result); ?></td>
                            <td title="직급"><?php echo element('mem_position', $result); ?></td>
                            <td title="직원명"><?php echo element('mem_username', $result); ?></td>
                            <td title="아이디"><?php echo element('mem_userid', $result); ?></td>
							<td title="이메일"><?php echo element('mem_email', $result); ?></td>
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
			<div class="box-info">
				<?php echo element('paging', $view); ?>
				<?php echo $buttons; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>