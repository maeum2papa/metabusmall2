<style>
    .flex{display:flex; justify-content: space-between;}

</style>
<div class="modal-header">
	<h4 class="modal-title">템플릿 선택</h4>
</div>
<div class="modal-header">
    <form id="search_form" method="get" enctype="multipart/form-data">
        <div class="flex">
            <div class="form-inline">
                <input type="text" name="search_item_value" value="<?php echo $this->input->get("search_item_value");?>" class="form-control" placeholder="템플릿명"> <button class="btn btn-outline btn-default btn-sm" type="submit">검색</button>
            </div>
            <div class="form-inline">
                <select name="sort" class="form-control per20" onChange=sortChange();>
                    <option value="">최근등록순</option>
                    <option value="citt_name asc" <?php echo ($this->input->get("sort") == "citt_name asc")?"selected":"";?>>상품명순(가나다)</option>
                    <option value="citt_deposit asc" <?php echo ($this->input->get("sort") == "citt_deposit asc")?"selected":"";?>>예치금차감금액순(낮은금액부터)​</option>
                </select>
            </div>
        </div>
    </form>
</div>
<div class="modal-body">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>이미지</th>
                <th>상품명</th>
                <th>상품설명</th>
                <th>예치금차감금액</th>
                <th>상품종류</th>
                <th>선택</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (element('list', element('data', $view))) {
            foreach (element('list', element('data', $view)) as $k => $result) {

                $result['citt_content'] = "";
                $result['citt_mobile_content'] = "";
        ?>
            <tr>
                <td><?php echo element('citt_id', $result); ?></td>
                <td><img src="<?php echo thumb_url('cmallitemtemplate', element('citt_file_1', $result), 80)?>" width="80px"></td>
                <td>
                    <a href="<?php echo admin_url('cmall')."/cmallitem/templateview/".element('citt_id', $result); ?>">
                        <?php echo element('citt_name', $result)?>
                    </a>
                </td>
                <td><?php echo element('citt_summary', $result)?></td>
                <td><?php echo element('citt_deposit', $result)?></td>
                <td><?php echo element('citt_ship_type', $result)?></td>
                <td>
                    <button type="button" class="btn btn-default btn-sm btn-select" data-id=<?php echo $k; ?>>선택</button>
                </td>
            </tr>
        <?php
            }
        }
        if ( ! element('list', element('data', $view))) {
        ?>
            <tr>
                <td colspan="14" class="nopost">자료가 없습니다</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <div class="box-info form-inline">
        <?php echo element('paging', $view); ?>
        <div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
        <?php echo $buttons; ?>
    </div>
</div>
<div class="modal-footer">
	<button type="submit" class="btn btn-black btn-sm" onClick="window.close();">닫기</button>
</div>

<script>

function sortChange(){
    document.querySelector("#search_form").submit();
}


data = [];

<?php 
    if(count(element('list', element('data', $view))) > 0){
        ?>data = <?php echo json_encode(element('list', element('data', $view)),JSON_UNESCAPED_UNICODE)?>;<?php
    }
?>

document.querySelectorAll(".btn-select").forEach(element => {
    element.addEventListener("click",function(){
        //부모창 함수로 호출
        window.opener.setTemplateItem(data[this.dataset.id]);

        self.close();
    });
});


</script>