<style>
    h4{font-weight:bold;}
    .wrap{margin:20px; display: flex; justify-content:space-between;}
    .wrap > div{width:calc(50% - 10px);}
    .wrap > div > .box{
        height:calc(100vh - 170px);
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
        <h4 class="mb10">아이템 선택</h4>
        <div class="box">
            <table class="table table-hover table-bordered mg0">
                <tbody>
                <tr>
                    <th>분류선택</th>
                    <td>
                        <label for="item_type_a" class="radio-inline"><input type="radio" name="item_type" value="a" id="item_type_a">아바타</label>
                        <label for="item_type_l" class="radio-inline"><input type="radio" name="item_type" value="l" id="item_type_l">랜드</label>
                    </td>
                </tr>
                <tr>
                    <th>검색어</th>
                    <td>
                        <select class="form-control" name="cate_sno"  style="width: 150px;">
                            <?php
                            foreach (element('category1', $view) as $v) {
                            ?>
                            <option value="<?=$v[cate_sno]?>" <?php if(element('cate_sno', element('data', $view)) == $v[cate_sno]){?>selected<?php } ?>><?=$v[cate_kr]?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="text" name="stxt" value="" class="form-control per55">
                    </td>
                </tr>
                <tr>
                    <th>등록기간검색</th>
                    <td>
                    <input type="date" name="start_date" value="" class="form-control px140"> - <input type="date" name="end_date" value="" class="form-control px140">
                    </td>
                </tr>
            </tbody></table>
            <div class="mt10 text-right">
                <button class="btn btn-outline btn-default btn-sm btn-search" type="submit">검색</button>
            </div>

            <div class="mt10">
                <div id="search_list">
                    <!-- <table class="table table-hover table-bordered mg0">
                        <tbody>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>번호</th>
                            <th>카테고리</th>
                            <th>이름</th>
                            <th>등록일</th>
                            <th>인벤토리노출</th>
                        </tr>
                        </tbody>
                    </table>-->
                </div>
            </div>
        </div>
        <div class="mt10 text-right">
            <button class="btn btn-default btn-item-add" type="button">추가</button>
        </div>
    </div>
    <div>
        <h4 class="mb10">아이템 리스트</h4>
        <div class="box" id="item_setting_select_list">
            <!-- <table class="table table-hover table-bordered mg0">
                <tbody>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>번호</th>
                    <th>카테고리</th>
                    <th>이름</th>
                    <th>등록일</th>
                    <th>인벤토리노출</th>
                </tr>
                </tbody>
            </table> -->
        </div>

        <div class="mt10 text-right">
            <button class="btn btn-danger btn-item-delete" type="button">삭제</button>
        </div>
    </div>
</div>
<div class="mt10 text-center mb20">
    <button class="btn btn-default btn-popup-close" type="button">닫기</button>
    <button class="btn btn-success" type="button">완료</button>
</div>

<script>

    var parentWindow = window.opener;
    var search_list = document.getElementById("search_list");
    var item_setting_select_list = document.getElementById("item_setting_select_list");
    var input_all_checked = null;
    var input_item_checkeds = null;
    var input_item_checkeds_checked = null;
    var input_item_checked = null;
    var button_close = null;
    var item_sno_datas = null;
    var button_add = null;
    var button_delete = null;
    var search_form = {
        "item_type":"",
        "cate_sno":"",
        "stxt":"",
        "start_date":"",
        "end_date":"",
    };

    async function page_load(){

        await list_load();
        await select_list_load();

        update();

        //이미 선택된 아이템 disabled
        item_sno_datas.forEach(item_sno=>{
            input_item_checkeds.forEach(element=>{
                if(element.value == item_sno){
                    element.disabled = true;
                    element.parentNode.parentNode.classList.add("on");
                }
            });
        });
        
        //체크박스 전체 클릭 이벤트
        input_all_checked.addEventListener("click",function(){
            
            if(this.checked){
                input_item_checkeds.forEach(element=>{
                    element.checked = true;
                });
            }else{
                input_item_checkeds.forEach(element=>{
                    element.checked = false;
                });
            }
        });

        //체크박스 개별 클릭 이벤트
        input_item_checkeds.forEach(element=>{
            element.addEventListener("change",function(){
                update();
                if(input_item_checkeds_checked.length == 
                    input_item_checkeds.length){
                    input_all_checked.checked = true;
                }else{
                    input_all_checked.checked = false;
                }
            });
        });
        

        //창닫기
        button_close.addEventListener("click",function(){
            window.close();
        });

        //추가 버튼 클릭 이벤트
        button_add.addEventListener("click",function(){

            update();

            if(input_item_checkeds_checked.length == 0){
                alert("선택된 아이템이 없습니다.");
                return false;
            }

            input_item_checkeds_checked.forEach(element=>{
                if(element.disabled == false){
                    item_setting_select_list.querySelector('table > tbody').appendChild(element.parentNode.parentNode.cloneNode(true));
                    element.disabled = true;
                    element.checked = false;
                }
            });

            update();

            var new_item_sno_datas = Array();
            select_input_item_checkeds.forEach(element=>{
                element.checked = false;
                new_item_sno_datas.push(element.value);
            });
            
            document.querySelector('[name="item_sno_data"]').value = new_item_sno_datas.join(",");

            var num = select_input_item_checkeds.length;
            item_setting_select_list.querySelectorAll("tr > td:nth-child(2)").forEach((element,k)=>{
                element.textContent = num - k;
            });

            

        });

        //삭제 이벤트
        button_delete.addEventListener("click",function(){
            
            update();

            select_input_item_checkeds_checked.forEach(select_element=>{
                input_item_checkeds_disabled.forEach(element=>{
                    if(select_element.value === element.value){
                        element.disabled = false;
                        select_element.parentNode.parentNode.remove();
                    }
                });
            });

            update();

            var new_item_sno_datas = Array();
            select_input_item_checkeds.forEach(element=>{
                new_item_sno_datas.push(element.value);
            });
            
            document.querySelector('[name="item_sno_data"]').value = new_item_sno_datas.join(",");

        });

        //선택된 영역에서 젅체 체크박스
        select_input_all_checked.addEventListener("click",function(){
            
            if(this.checked){
                select_input_item_checkeds.forEach(element=>{
                    element.checked = true;
                });
            }else{
                select_input_item_checkeds.forEach(element=>{
                    element.checked = false;
                });
            }

        });

        //체크박스 개별 클릭 이벤트
        select_input_item_checkeds.forEach(element=>{
            element.addEventListener("change",function(){
                update();
                if(select_input_item_checkeds_checked.length == 
                    select_input_item_checkeds.length){
                    select_input_all_checked.checked = true;
                }else{
                    select_input_all_checked.checked = false;
                }
            });
        });
        

        //분류선택 이벤트
        document.querySelectorAll('[name="item_type"]').forEach(element=>{
            element.addEventListener("change",async function(){
                search_form.item_type = document.querySelector('[name="item_type"]:checked').value;
                await cate_sno_list();
            });
        });

        //검색 이벤트
        document.querySelector('.btn-search').addEventListener("click",async function(){
            
            search_form.cate_sno = document.querySelector("[name='cate_sno']").value;
            search_form.stxt = document.querySelector("[name='stxt']").value;
            search_form.start_date = document.querySelector("[name='start_date']").value;
            search_form.end_date = document.querySelector("[name='end_date']").value;
            
            await list_load();
        });
        

        //완료 버튼 이벤트
        document.querySelector('.btn-success').addEventListener("click",async function(){
            parentWindow.update_cit_item_arr(document.querySelector("[name='item_sno_data']").value);
            window.close();
        });
        

        document.querySelector("[name='item_type']:nth-child(1)").click();
        await list_load();
    }

    async function list_load() {
        try {

            search_form_data = new URLSearchParams(search_form).toString();

            const response = await fetch('/admin/cmall/cmallitem/itemsettinglist?'+search_form_data);
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.text();

            search_list.textContent = '';
            search_list.innerHTML = data;
            
        } catch (error) {
            console.error('Error during fetch operation:', error);
        }
    }


    async function select_list_load(){
        try {

            const response = await fetch('/admin/cmall/cmallitem/itemsettingselectlist?item_sno='+document.querySelector('[name="item_sno_data"]').value);

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.text();

            item_setting_select_list.textContent = '';
            item_setting_select_list.innerHTML = data;

        } catch (error) {
            console.error('Error during fetch operation:', error);
        }
    }

    async function cate_sno_list(){
        try {
            
            const response = await fetch('/admin/cmall/cmallitem/catesnolist?item_type='+search_form.item_type);

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.text();

            document.querySelector('[name="cate_sno"]').textContent = "";
            document.querySelector('[name="cate_sno"]').innerHTML = data;

        } catch (error) {
            console.error('Error during fetch operation:', error);
        }
    }


    function update(){

        input_all_checked = document.querySelector("[name='all']");
        input_item_checkeds = search_list.querySelectorAll("[name='item_sno[]']");
        input_item_checkeds_checked = search_list.querySelectorAll("[name='item_sno[]']:checked:not(:disabled)");
        input_item_checkeds_disabled = search_list.querySelectorAll("[name='item_sno[]']:disabled");
        input_item_checked = search_list.querySelector("[name='item_sno[]']");
        button_close = document.querySelector(".btn-popup-close");
        item_sno_datas = document.querySelector('[name="item_sno_data"]').value.split(",");

        select_input_all_checked = item_setting_select_list.querySelector("[name='all']");
        select_input_item_checked = item_setting_select_list.querySelector("[name='item_sno[]']");
        select_input_item_checkeds = item_setting_select_list.querySelectorAll("[name='item_sno[]']");
        select_input_item_checkeds_checked = item_setting_select_list.querySelectorAll("[name='item_sno[]']:checked");

        button_add = document.querySelector('.btn-item-add');
        button_delete = document.querySelector('.btn-item-delete');

    }


    page_load();

    


</script>