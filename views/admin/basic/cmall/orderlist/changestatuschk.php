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
</div>
<div class="mt10 text-center mb20">
    <button class="btn btn-default btn-popup-close" type="button">닫기</button>
    <button class="btn btn-success" type="button">완료</button>
</div>

<script>


</script>