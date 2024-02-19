<style>
    h4{font-weight:bold;}
    .wrap{margin:20px; justify-content:space-between;}
    /*.wrap > div{width:calc(50% - 10px);}*/
    .wrap > div {
        border:1px solid gray;
        overflow-y:scroll;
        padding:10px;
        float:none;
        margin: auto
    }
    
    .wrap > div > .box{
        border:1px solid gray;
        overflow-y:scroll;
        padding:10px;
        float:none;
    }
    .listnum select{
        width:84px;
    }

    #search_list tr.on > td{
        color:gray;
    }
</style>

<input type="hidden" name="item_sno_data" value="<?php echo $this->input->get('item_sno_data');?>">
<div class="wrap">
    <div>
        <h4 class="mb10">응답자 선택</h4>
        
        <table class="table table-hover table-bordered mg0">
            <tbody>                
            <tr>
                <th>부서 검색</th>
                <td>    
                    
                    <?php echo element('level_1', element('data', $view)); ?>

                    <!--<select class="form-control" name="2depth"  style="width: 150px;">                        
                        <option value="" selected disabled>2depth</option>                        
                    </select>-->
                    <select class="form-control" name="3depth"  style="width: 150px;">                        
                        <option value="" selected disabled>3depth</option>                        
                    </select>
                    <select class="form-control" name="etc"  style="width: 150px;">                        
                        <option value="" selected disabled>etc</option>                        
                    </select>
                </td>
            </tr>
            <tr>
                <th>입사일 검색</th>
                <td>
                <input type="date" name="search_start_date" value="" class="form-control px140"> - <input type="date" name="end_date" value="" class="form-control px140">
                </td>
            </tr>
            <tr>
                <th>생일 검색</th>
                <td>
                <input type="date" name="search_end_date" value="" class="form-control px140"> - <input type="date" name="end_date" value="" class="form-control px140">
                </td>
            </tr>
            <tr>
                <th>직원명</th>
                <td>                        
                    <input type="text" id="search_username" name="search_username" value="" class="form-control per55">
                </td>
            </tr>
        </tbody></table>

        <div class="mt10 text-right">
        <button class="btn btn-outline btn-default btn-sm btn-search" type="button" onclick="search(true)">전체보기</button>
            <button class="btn btn-outline btn-default btn-sm btn-search" type="button" onclick="search()">검색</button>
        </div>

        <input type="checkbox" class="form-check-input" id="check_all_member" name="check_all_member">
        <label class="form-check-label" for="check_all_member">  전체 선택</label>
        
        <div class="mt10">
            <div id="search_list">
                
            </div>
        </div>
        <div class="mt10 text-center mb20">
                <button class="btn btn-default btn-popup-close" type="button">닫기</button>
                <button class="btn btn-success" type="button">완료</button>
        </div>
    </div>
        
</div>


<script>

    let parentWindow = window.opener;
    let search_list = document.getElementById("search_list");
    //var input_all_checked = null;
    let input_item_checkeds = null;
    let input_item_checkeds_checked = null;
    let input_item_checked = null;
    let button_close = document.getElementsByClassName("btn-popup-close")[0];
    let item_sno_datas = null;
    let button_add = null;

    let selected_members = new Map();

    let search_option = "";


    document.getElementById("check_all_member").addEventListener("click", function() {
        let check_all = document.getElementById("check_all_member");
        let members = document.getElementsByName("mem_id[]");

        let mem_ids = document.getElementsByName("mem_id[]");
        let mem_ocname = document.getElementsByName("mem_ocname[]");
        let mem_position = document.getElementsByName("mem_position[]");
        let mem_username = document.getElementsByName("mem_username[]");
        let mem_userid = document.getElementsByName("mem_userid[]");
        let mem_email = document.getElementsByName("mem_email[]");


        for (let i = 0; i < members.length; ++i) {                    
            if (check_all.checked) {
                members[i].checked = true;           
                
                let obj = {};
                obj['mem_ocname'] = mem_ocname[i].textContent;
                obj['mem_position'] = mem_position[i].textContent;
                obj['mem_username'] = mem_username[i].textContent;
                obj['mem_userid'] = mem_userid[i].textContent;
                obj['mem_email'] = mem_email[i].textContent;
                selected_members.set(mem_ids[i].value, obj);

            } else {
                members[i].checked = false;
            }

        }
    })

    // 기존 거 가져오기
    window.addEventListener("message", function(event) {        
        if (event.source != window.opener) return;
        let receivedData = event.data;
        if (receivedData.type === "mapData") {
            let receivedMap = receivedData.data;
            if (receivedMap !== null) {
                selected_members = new Map(receivedMap);
            }

            page_load();
        }
    }, false);



    async function page_load(){

        await list_load();


        //창닫기
        button_close.addEventListener("click",function(){
            window.close();
        });
        
        //완료 버튼 이벤트
        document.querySelector('.btn-success').addEventListener("click",async function(){
            parentWindow.update_cit_members_arr(selected_members);
            window.close();
        });
        

        await list_load();
    }

    async function list_load(page = 1) {
        let check_all = document.getElementById("check_all_member");
        check_all.checked = false;
        
        try {

           // search_form_data = new URLSearchParams(search_form).toString();

            const response = await fetch(`/admin/servicing/survey/getMemberList?page=${page}&&${search_option}`);
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.text();

            search_list.textContent = '';
            search_list.innerHTML = data;

            let mem_ids = document.getElementsByName("mem_id[]");
            let mem_ocname = document.getElementsByName("mem_ocname[]");
            let mem_position = document.getElementsByName("mem_position[]");
            let mem_username = document.getElementsByName("mem_username[]");
            let mem_userid = document.getElementsByName("mem_userid[]");
            let mem_email = document.getElementsByName("mem_email[]");

            let check_all = document.getElementById("check_all_member");


            // 각 요소에 이벤트 리스너 추가
            for (let i = 0; i < mem_ids.length; i++) {
                if (selected_members.has(mem_ids[i].value)) {
                    mem_ids[i].checked = true;                
                }

                mem_ids[i].addEventListener("change", function() {
                    if (mem_ids[i].checked) {
                        let obj = {};
                        obj['mem_ocname'] = mem_ocname[i].textContent;
                        obj['mem_position'] = mem_position[i].textContent;
                        obj['mem_username'] = mem_username[i].textContent;
                        obj['mem_userid'] = mem_userid[i].textContent;
                        obj['mem_email'] = mem_email[i].textContent;

                        selected_members.set(mem_ids[i].value, obj);

                        let selected_count = document.querySelectorAll('.mem_id\\[\\]:checked').length;
                        if (selected_count === 5) {
                            check_all.checked = true;
                        }        
                    } else {                        
                        selected_members.delete(mem_ids[i].value);
                        check_all.checked = false;
                    }
                });


            }
            
        } catch (error) {
            console.error('Error during fetch operation:', error);
        }
    }

    function search(isReset = false) {
        if (isReset) {
            search_option = "";
            list_load();
            return;
        }

        let username = document.getElementById("search_username").value;
        let array = [];
        search_option = "";

        if (trim(username).length !== 0) {
            search_option = `${search_option}username=${username}&&`;
        }
        list_load();
    }

    // 페이지네이션 링크 이동 막기
    document.addEventListener('click', function (e) {                
        if (e.target.parentElement.parentElement.classList.contains("pagination")) {
            e.preventDefault();
            if (e.target.dataset.ciPaginationPage) {                   
                list_load(e.target.dataset.ciPaginationPage);  
            } else {
                list_load(1); 
            }                
        }                
    }); 
    

</script>