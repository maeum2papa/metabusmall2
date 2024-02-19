<div class="box">
	<div class="box-table">
		<?php        
            $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
        ?>

        <div class="box-table-header">
            <?php
            ob_start();
            ?>
            
            <div class="btn-group pull-right" role="group" aria-label="...">                
                <a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">서베이 생성</a>
            </div>
            <?php
            $buttons = ob_get_contents();
            ob_end_flush();
            ?>
        </div>

        <h3>| 서베이 검색</h3>

        <form id="search_form" method="get" enctype="multipart/form-data">
				<table>
					<tr>
						<th>제목</th>
						<td>
                        <input type="text" class="form-control" name="survey_title" placeholder="제목" style="width:auto"/>
						</td>
                        <td>
					        <button class="btn btn-outline btn-default btn-sm" type="submit">검색</button>
                        </td>
					</tr>
					<tr>
						<th>서베이시작일</th>
						<td>
                            <input type="date" class="form-control" id="survey_start_date" name="survey_start_date_start" style="width:auto"/>
						</td>
                        <td>
                        ~
                        </td>
                        <td>
                            <input type="date" class="form-control" id="survey_start_date" name="survey_start_date_end" style="width:auto"/>
						</td>
					</tr>
					<tr>
						<th>서베이종료일</th>
						<td>
                        <input type="date" class="form-control" id="survey_end_date" name="survey_end_date_start" style="width:auto"/>
                        </td>
                        <td>
                        ~
                        </td>
                        <td>
                        <input type="date" class="form-control" id="survey_end_date" name="survey_end_date_end" style="width:auto"/>
                        </td>
                        
					</tr>
					<tr>
						<th>상태</th>
						<td>
                        <input type="checkbox" class="form-control" name="is_enabled_survey" style="width:auto"/>노출 서베이만                
						</td>
					</tr>					
				</table>
		
			</form>

        <h3>| 서베이 목록</h3>


        <?php
		    $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		    echo form_open(current_full_url(), $attributes);
        ?>
            <div class="form-group">
                <input type="hidden" name="actived">
                <div class="col-1" style="display:inline-block">                
                    선택한 서베이를
                </div>
                <select id="active" name="change_active" class="form-control col-1" name="sort" style="width: auto" onchange="handleChange(this)">                    
                    <option value="use">노출</option>
                    <option value="unuse">미노출</option>
                </select>

                <button type="button" class="btn-list-update" data-list-update-url="<?php echo element('list_update_url', $view); ?>" >변경</button>
                
                <select class="form-control" name="sfield" style="width: auto" onchange="sortHandleChange(this)">                    
                    <option value="title">제목순</option>
                    <option value="reg_date" selected>등록순</option>
                    <option value="end_date">종료일순</option>
                    <option value="real_participants_count">참여순</option>
                </select>
            </div>


            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>전체 선택 <input type="checkbox" name="chkall" id="chkall" /></th>
                            <th>NO</th>
                            <th>제목</th>
                            <th>등록일</th>
                            <th>기간</th>
                            <th>상태</th>
                            <th>노출 여부</th>
                            <th>참여</th>
                            <th>수정</th>
                            <th>결과</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (element('list', element('data', $view))) {
                                foreach (element('list', element('data', $view)) as $result) {
                        ?>
                            <tr>
                            <td>선택 <input type="checkbox" name="chk[]" class="list-chkbox" value = <?php echo element('survey_id', $result); ?> /></td>
                            <td><?php echo element('order_column', $result); ?></td>
                            <td><?php echo element('title', $result); ?></td>
                            <td><?php echo element('reg_date', $result); ?></td>
                            <?php
                            
                            if (element('start_date', $result) != "0000-00-00" && element('end_date', $result)) {
                                $date = element('start_date', $result)." ~ ".element('end_date', $result);
                            } else {
                                $date = "등록된 날짜 없음";
                            }

                            ?>

                            <td><?php echo $date; ?></td>
                            <td><?php echo element('date_status', $result); ?></td>
                            <td><?php echo element('state', $result) == "use"? "노출" : "미노출"; ?></td>
                            <td><?php echo element('real_participants_count', $result); ?></td>
                            <td><?php
                                if (element('can_editable', $result) === "y") { ?>
                                    <a href="#" value="<?php echo element('survey_id', $result); ?>" class="link_update btn btn-outline btn-default"><span>수정</span></a>                             
                                <?php } else {
                                    echo "<span>수정불가</span>";                                    
                                }
                            ?></td>                                                  

                            <td>결과</td>                        
                            </tr>
                            <?php                            
                                }                        
                            } else {
                            ?>
                                <tr>
                                    <td colspan="10" class="nopost">자료가 없습니다</td>
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
                <?php echo $buttons; ?>
            </div>
        </form>


        <?php echo form_close(); ?>
    
    <?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
        echo show_alert_message($this->session->flashdata('warning'), '<div class="alert alert-dismissible alert-warning"><button type="button" class="close alertclose" >&times;</button>', '</div>');
        
        /*$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist', 'method' => 'get');
		echo form_open(current_full_url(), $attributes);*/
		?>


    </div>
    <script>
        let params = new URLSearchParams(window.location.search);      
        let sort_select = document.getElementsByName("sfield")[0].getElementsByTagName("option");
        
        if (params.has('sort_option')) {
            switch (params.get("sort_option")) {
                case "title":
                    sort_select[1].removeAttribute("selected");
                    sort_select[0].setAttribute("selected", true);
                    break;
                case "reg_date":
                    break;
                case "end_date":
                    sort_select[1].removeAttribute("selected");
                    sort_select[2].setAttribute("selected", true);
                    break;
                case "real_participants_count":
                    sort_select[1].removeAttribute("selected");
                    sort_select[3].setAttribute("selected", true);
                    break;
            }
        }
                
    


        function sortHandleChange(selectElement) {
                let currentUrl = window.location.href;
                // URL에서 쿼리 문자열을 추출합니다.
                let queryString = currentUrl.split('?')[1];

                let form = document.createElement("Form");

                let params = new URLSearchParams(window.location.search);
                params.forEach(function(value, key) {
                    if (key !== "sort_option") {                                            
                        let inputField = document.createElement("input");
                        inputField.type = "hidden";
                        inputField.name = key;
                        inputField.value = encodeURIComponent(value);
                        form.appendChild(inputField);
                    }
                });

                let inputField = document.createElement("input");
                inputField.type = "hidden";
                inputField.name = "sort_option";
                inputField.value = selectElement.value;                

                form.appendChild(inputField);

                form.setAttribute("action", `<?php echo element('current_url', $view); ?>`);
                form.setAttribute("method", "GET");

                document.body.appendChild(form);

                // 폼을 제출합니다.
                form.submit();

            }

        function handleChange(selectElement) {
            document.getElementById("active").value = selectElement.value;
        }

        let update_array = document.querySelectorAll(".link_update");
            update_array.forEach(function(element) {
                element.addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.createElement("form");
                form.method = "POST";

                form.action = "<?php echo element('write_url', $view) ?>";

                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "csrf_test_name";
                input.value = cb_csrf_hash;

                form.appendChild(input);


                // 데이터를 담을 hidden input 엘리먼트 생성
                let input2 = document.createElement("input");
                input2.type = "hidden";
                input2.name = "survey_id"; // 전송할 변수의 이름
                input2.value = parseInt(this.getAttribute('value'), 0) || 0;

                // 폼에 hidden input 추가
                form.appendChild(input2);

                // 폼을 문서에 추가하고 전송
                document.body.appendChild(form);
                form.submit();

            })
        })
            

        /*let startDay = new Date();
        startDay.setDate(startDay.getDate() + 1);

        document.getElementById('survey_start_date').value = startDay.toISOString().substring(0, 10);

        let endDay = new Date();
        endDay.setDate(endDay.getDate() + 2);
        document.getElementById('survey_end_date').value = endDay.toISOString().substring(0, 10);;*/




    </script>
</div>