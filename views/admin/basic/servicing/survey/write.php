
<style>
    .mb-1 {
        margin-bottom:10px;
    },
    .mb-2 {
        margin-bottom:15px;
    }
    .mb-3 {
        margin-bottom:20px;
    }
    .mb-4 {
        margin-bottom:25px;
    }
    .mb-5 {
        margin-bottom:30px;
    }

    .ml-1 {
        margin-left:10px;
    }
    .ml-2 {
        margin-left:15px;
    }
    .ml-3 {
        margin-left:20px;
    }
    .ml-4 {
        margin-left:25px;
    }
    .ml-5 {
        margin-left:30px;
    }

    .mr-1 {
        margin-right:10px;
    }
    .mr-2 {
        margin-right:15px;
    }
    .mr-3 {
        margin-right:20px;
    }
    .mr-4 {
        margin-right:25px;
    }
    .mr-5 {
        margin-right:30px;
    }

    .button-container {
      margin-top: 5px;
    }
    .button-container .btn {
      margin-right: 10px;
      margin-bottom: 5px;
    }

    .horizontal-divider {
        width: 100%;
        border-top: 1px dotted #000; /* 수평 구분선 스타일 */
        margin: 10px 0; /* 위아래 여백 */
    }
</style>

<div class="box">
    <div class="box-table">        
        <h4 class="mb-3 page-title">서베이 생성</h4>

        <div class="row mb-3 survey_load">
            <div class="col-sm-12">
                <div class="form-inline">
                    <label for="survey_list" class="mr-2">서베이 불러오기</label>
                    <select class="form-control" id="survey_list" onchange="handleChange(this)">
                        <option disabled selected>목록</option>
                    </select>
                </div>
            </div>
        </div>

<?php
			/*echo "<pre>";
		    var_dump(element('data', $view));; // 모든 데이터를 print_r로 출력
			echo "</pre>";*/


		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>

        <h4 class="mb-3"><a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">| 서베이 설정<i class="fa fa-chevron-up pull-right"></i></a></h4>     
        <input type="hidden" name="survey_id">

        <div class="collapse in" id="collapse1">
            <div class="ml-1">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-inline">
                        <label class="form-check-label mr-5" for="surveyDate[]">서베이기간</label>

                        <span class="mr-2"> 시작일 </span>
                        <input class="mr-4" type="date" class="form-check-input" name="surveyStart" id="survey_start">
                        <span class="mr-2"> 종료일 </span>
                        <input class="mr-4" type="date" class="form-check-input" name="surveyEnd" id="survey_end">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-inline">
                        <input type="checkbox" class="form-check-input" id="shareResults" name="shareResults">
                        <label class="form-check-label" for="shareResults">서베이 결과 응답자에게 공유하기</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-inline">
                        <input type="checkbox" class="form-check-input" id="anonymousResponses" name="anonymousResponses">
                        <label class="form-check-label" for="anonymousResponses">익명으로 응답 받기</label>
                        </div>
                    </div>
                </div>            
                <div class="row ml-5 mb-3 mr-5">
                    <h5 class="mb-2">응답자</h5>
                    <div class="text-right mb-2">
                        <button type="button" class="btn btn-primary mb-2 btn-member-setting-popup">추가</button>
                    </div>

                    <input type="checkbox" class="form-check-input" id="check_all_member">
                    <label class="form-check-label" for="check_all_member">  전체 선택</label>

                    <table class="table">
                    <thead>
                        <tr>
                        <th>선택</th>
                        <th>번호</th>
                        <th>소속</th>
                        <th>직급</th>
                        <th>직원명</th>
                        <th>아이디</th>
                        <th>이메일</th>
                        </tr>
                    </thead>
                    <tbody>        
                    </tbody>
                    </table>
                    <div class="row text-left">
                        <button type="button" class="btn btn-danger mb-2 ml-2" onclick="delete_select_members()">선택 삭제</a>
                    </div>    
                </div>    
                
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-inline">
                            <label for="surveyReward" class="mr-2">포인트 지급</label>
                            <input type="number" class="form-control" id="surveyReward" name="surveyReward" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3"><a data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2">| 서베이 정보<i class="fa fa-chevron-up pull-right"></i></a></h4>
            <div class="collapse in" id="collapse2">
            <div class="ml-1">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-inline">
                            <label for="surveyName" class="mr-2">제목</label>
                            <input type="text" class="form-control" id="surveyName" name="surveyName" placeholder="서베이 제목을 입력하세요" style="width:300px">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-inline">
                            <label for="surveyDescript" class="mr-2">설명</label>
                            <textarea class="form-control" name="surveyDescript" id="surveyDescript" placeholder="서베이의 설명을 입력해주세요." style="width:95%"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <h4 class="mb-3"><a data-toggle="collapse" href="#collapse3" aria-expanded="true" aria-controls="collapse3">| 서베이 항목<i class="fa fa-chevron-up pull-right"></i></a></h4>
            <div class="collapse in" id="collapse3">

            <div class="ml-1">
                <!-- Survey 등록 -->
                <div id="content">

                </div>

                <div id="survey_editor" style="background-color:#F0F0F0">
                    <div class="row">
                        <h4 style="margin:5px">서베이 항목 추가</h4>
                    </div>
                    <div class="row">
                        <input type="hidden" name="question_count" value= 0>
                        <div class="col-xs-12">
                            <div class="button-container" role="group">
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.SUBTITLE)">소제목</button>
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.DESC_FIELD)">설명</button>
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.DIVISION_LINE)">구분선</button>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="button-container" role="group">
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.FREE_TEXT)">객관식</button>
                                <button type="button" class="btn btn-default">객관식-이미지</button>
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.OEQ)">주관식</button>                            
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.FIVE_STAR)">별점</button>
                                <button type="button" class="btn btn-default" onclick="Element_makeElementBox(ElementType.PERCENTAGE)">퍼센테이지</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Survey 항목 고정 -->
            </div>
        </div>

        <div class="text-right mb-2">
            <div class="row">
                <label class="form-check-label" for="surveyNotify">서베이 시작 시 응답자 우편함으로 서베이참여 메세지 전송</label>
                <input type="checkbox" class="form-check-input" name="surveyNotify" id="surveyNotify">                       
            </div>    
            <div class="row">
                <button type="button" class="btn btn-primary mb-2" onclick="save()" id="btn_save">저장하기</button>
            </div>
        </div>
        <?php echo form_close(); ?>

        <script>
            $(function() {            
            });

            // survey_end input 요소
            let surveyStartInput = document.getElementById("survey_start");            
            let surveyEndInput = document.getElementById("survey_end");

            surveyStartInput.addEventListener("change", function() {
                let today = new Date(); // 현재 날짜를 가져옴
                let startDate = new Date(this.value); // survey_start input의 값
                let endDate = new Date(surveyEndInput.value); // survey_end input의 값

                // 날짜 삭제가 아닌 경우에만 실행
                if (startDate) {
                    // survey_start가 오늘 날짜 이전인 경우
                    if (startDate <= today) {
                        startDate.setDate(today.getDate() + 1);
                        this.valueAsDate = startDate;
                        
                    }

                    // survey_end가 survey_start보다 이전인 경우
                    if (endDate <= startDate) {
                        // survey_end를 survey_start에 하루를 더한 값으로 설정
                        endDate.setDate(startDate.getDate() + 1);
                        surveyEndInput.valueAsDate = endDate;
                    }
                }
            });

            // survey_end input 값이 변경될 때 실행되는 이벤트 리스너
            surveyEndInput.addEventListener("change", function() {
                let today = new Date(); // 현재 날짜를 가져옴
                let startDate = new Date(surveyStartInput.value); // survey_start input의 값
                let endDate = new Date(this.value); // survey_end input의 값

                // 날짜 삭제가 아닌 경우에만 실행
                if (endDate) {
                    if (endDate <= today) {
                        endDate.setDate(today.getDate() + 1);
                        this.valueAsDate = endDate;
                        
                    }

                    // survey_end가 survey_start와 동일하거나 이전인 경우
                    if (endDate <= startDate) {
                        // survey_end를 survey_start에 하루를 더한 값으로 설정
                        endDate.setDate(startDate.getDate() + 1);
                        this.valueAsDate = endDate;
                    }
                }
            });


            
            function NotEmptyString(element) {
                if (typeof element !== 'string') {
                    return false;
                }

                return element.trim().length !== 0;
            }

            let previous_select = 0;

            function handleChange(selectElement) {
                
                let answer = confirm("작성 중인 내용이 있는 경우 해당 내용이 소실됩니다.\n불러오시겠습니까?");
                if (!answer) {
                    if (previous_select !== null) {
                        selectElement.selectedIndex = previous_select;
                    }
                    return;
                }

                previous_select = selectElement.selectedIndex;

                let xhr = new XMLHttpRequest();
                let url = `<?php echo element('load_url', $view); ?>/${selectElement.value}`;
                xhr.addEventListener("load", function() {
                    if (xhr.status == 200) {
                        let responseData = JSON.parse(xhr.responseText);                    
                        info = responseData.info[0];
                        element = responseData.element;
                        participants = responseData.participants;


                        loadData();

                    } else {
                        console.error('Request failed with status:', xhr.status);
                    }
                });

                xhr.addEventListener("error", function() {
                    alert('유효하지 않는 서베이 입니다.');
                });


                xhr.open("GET", url, true);
                xhr.send();

            }

            let members_selected = null;

            var info = <?php echo json_encode(element('info', element('data', $view))[0]) ?>;
            var element = <?php echo json_encode(element('element', element('data', $view))) ?>;
            var participants = <?php echo json_encode(element('participants', element('data', $view))) ?>;

            let survey_id = info !== null ? Number(info.survey_id) : 0;

            if (survey_id !== 0) {
                document.querySelector(".survey_load").remove();
                document.querySelector(".page-title").innerText = "서베이 수정";
                document.getElementsByName("survey_id")[0].value = survey_id;
                document.querySelector("#btn_save").innerText = "수정하기";
            } else {
                let survey_list = <?php echo json_encode(element('survey_list', element('data', $view))) ?>;

                let list = document.querySelector("#survey_list");
                list.innerHTML = "<option disabled selected>목록</option>";

                for (let i = 0; i < survey_list.length; ++i) {
                    let option = document.createElement("option");
                    option.value = survey_list[i].survey_id;
                    option.innerText = survey_list[i].title;
                    list.appendChild(option);
                }

                previous_select = list.innerHTML;
            }

            function makeToolTipAndShow(tag, title_txt, position = "top") {
                $(tag).tooltip({
                    title: title_txt, // 툴팁 내용
                    trigger: "manual", // 툴팁을 수동으로 트리거하도록 설정
                    placement: position
                });

                $(tag).tooltip("show");
            }

            function hideToolTip(tag) {
                $(tag).tooltip("hide");
            }


            function validateCheck() {
                let result = true;

                if (!NotEmptyString(document.getElementsByName("surveyName")[0].value)) {
                    result = false;

                    // 제목 빔을 알림
                    makeToolTipAndShow(document.getElementsByName("surveyName")[0], "필수항목입니다.");
                } else {
                    hideToolTip(document.getElementsByName("surveyName")[0]);
                }

                if (!NotEmptyString(document.getElementsByName("surveyDescript")[0].value)) {
                    result = false;

                    makeToolTipAndShow(document.getElementsByName("surveyDescript")[0], "서베이 설명을 입력해주세요.");
                } else {
                    hideToolTip(document.getElementsByName("surveyDescript")[0]);
                }

                if (members_selected === null || members_selected.size === 0) {
                    result = false;

                    makeToolTipAndShow(document.getElementById("check_all_member").parentNode, "한명 이상의 응답자를 설정해주세요.", "auto");
                } else {
                    hideToolTip(document.getElementById("check_all_member").parentNode);
                }


                let real_question = 0;
                let content = document.getElementById("content");
                let list = content.querySelectorAll('[name^="survey["][name$="][type]"]');

                if (list.length === 0) {
                    result = false;

                    makeToolTipAndShow(content, "최소 하나 이상의 문항이 추가되어야 합니다.");

                } else {
                    hideToolTip(content);


                    list.forEach(function(element) {
                        number = Number(element.name.match(/\[(\d+)\]/)[1]);
                        let txt = "내용을 입력하세요.";

                        switch (element.value) {
                            case "FreeText":
                                let div = element.parentNode;
                                let answer = div.querySelectorAll('.row').length > 2 ? div.querySelectorAll('.row')[2] : null;
                                if (answer === null || answer === undefined || answer.length === 0 || element.parentNode.querySelectorAll('.row')[2].childNodes.length === 0) {
                                    result = false;                                    
                                    // TODO 답변이 없음
                                    makeToolTipAndShow(element.parentNode, "객관식 항목은 최소 1개 이상의 답변이 추가되어야 합니다.");
                                } else {
                                    hideToolTip(element.parentNode);
                                    
                                    let answer_list = answer.querySelectorAll('[name^="survey["][name$="][answer][]"]');
                                    answer_list.forEach(function(element) {
                                        if (!NotEmptyString(element.value)) {
                                            result = false;

                                            makeToolTipAndShow(element, "답변을 입력하세요.");
                                        } else {
                                            hideToolTip(element);
                                        }
                                    });
                                }

                            case "fiveStar": 
                                /* INTERNATIONAL FALLTHROUGH */
                            case "Percentage": 
                                /* INTERNATIONAL FALLTHROUGH */
                            case "OEQ":
                                txt = "질문을 입력하세요."
                                /* INTERNATIONAL FALLTHROUGH */
                                real_question += 1;

                            case "desc_field":
                                /* INTERNATIONAL FALLTHROUGH */

                                if (txt === "내용을 입력하세요.") {
                                    txt = "설명을 입력하세요.";
                                }

                            case "sub_title":
                                if (txt === "내용을 입력하세요.") {
                                    txt = "소제목을 입력하세요.";
                                }
                                let question_title = content.querySelector(`[name^="survey[${number}][title]"]`);
                                if (!NotEmptyString(question_title.value)) {
                                    result = false;

                                    makeToolTipAndShow(question_title, txt);
                                } else {
                                    hideToolTip(question_title);
                                }


                                break;

                            case "division_line":
                                /* INTERNATIONAL FALLTHROUGH */

                                break;
                            default:
                                break;
                        }

                    });


                    if (real_question === 0) {
                        makeToolTipAndShow(content, "최소 하나 이상의 문항이 추가되어야 합니다.");
                        result = false;
                    }

                }

                // 문항 검증하기
                // 설명 제외 1개 이상일 것.
                // 반드시 질문이 달려있을 것.
                // 객관식에는 반드시 한개 이상 답 (기타 제외)가 있을 것.
                // 객관식에서 답변은 텍스트가 전부 채워져 있을 것.




                return result;
            }
            


            function loadData() {
                if (info === null) {
                    return;
                }

                let id = document.getElementsByName("survey_id")[0].value;
                
                // 수정시에만 날짜 로드

                if (id && id !== 0) {
                    document.getElementById("survey_start").value = info.start_date !== "0000-00-00" ? info.start_date : null;
                    document.getElementById("survey_end").value = info.end_date !== "0000-00-00" ? info.end_date : null;

                    let today = new Date(); // 현재 날짜를 가져옴
                    let startDate = new Date(document.getElementById("survey_start").value); // survey_start input의 값

                    // 날짜 삭제가 아닌 경우에만 실행
                    if (startDate) {
                        // survey_start가 오늘 날짜 이전인 경우
                        if (startDate <= today) {                        
                            document.getElementById("survey_start").value = null;
                            
                        }
                    }

                    let endDate = new Date(document.getElementById("survey_end").value); // survey_start input의 값
                    
                    if (endDate <= startDate) {                    
                        document.getElementById("survey_end").value = null;
                    }
                }



                if (info.expose_status === "y") {
                    document.getElementById("shareResults").checked = true;
                } else {
                    document.getElementById("shareResults").checked = false;
                }

                if (info.is_anonymous === "y") {
                    document.getElementById("anonymousResponses").checked = true;
                } else {
                    document.getElementById("anonymousResponses").checked = false;
                }

                if (info.noti_enabled === "y") {
                    document.getElementById("surveyNotify").checked = true;
                } else {
                    document.getElementById("surveyNotify").checked = false;
                }

                
                document.getElementById("surveyReward").value = info.reward_point;
                document.getElementById("surveyName").value = info.title;
                document.getElementById("surveyDescript").innerText = info.description;

                // 유저 정보 불러오기
                if (participants !== null) {

                    let length = participants.length;
                    let data = new Map();


                    for (let i = 0; i < length; ++i) {
                        let obj = {};
                        obj['mem_ocname'] = participants[i].textContent;
                        obj['mem_position'] = participants[i].mem_position;
                        obj['mem_username'] = participants[i].mem_username;
                        obj['mem_userid'] = participants[i].mem_userid;
                        obj['mem_email'] = participants[i].mem_email;

                        data.set(participants[i].mem_id, obj);
                    }

                    update_cit_members_arr(data);
                }



                // 서베이 정보 불러오기
                if (element !== null) {
                 
                    let content = document.getElementById("content");
                    content.innerText = "";

                    for (let i = 0; i < element.length; ++i) {
                        // 타입확인
                        // 뷰 생성
                        let type = element[i].survey_element_type;
                        let tag_question;
                        let number = -1;

                        switch (type) {
                            case "free_text":
                                tag_question = Element_makeElementBox(ElementType.FREE_TEXT);        
                                number = Number(tag_question.childNodes[0].name.match(/\[(\d+)\]/)[1]);


                                let options = tag_question.querySelectorAll(`[name^="survey[${number}][questionType][can_multiple_choice]`);
                                options[0].checked = element[i].can_multiple_choice === "y";

                                options = tag_question.querySelectorAll(`[name^="survey[${number}][questionType][can_etc_answer]`);
                                options[0].checked = element[i].can_etc_answer === "y";


                                // 답변추가
                                let answer_set = tag_question.getElementsByClassName("row")[2];

                                let answer_sets = element[i].option_descriptions.split("|");
                                let length = Math.min(element[i].option_counts, answer_sets.length);

                                for (let i = 0; i < length; ++i) {
                                    let div = document.createElement("div");

                                    let input = document.createElement("input");
                                    input.type = "text";
                                    input.classList = "form-control";
                                    input.placeholder = "답변을 입력하세요.";
                                    input.value = answer_sets[i];
                                    input.style.width = "85%";
                                    input.style.marginLeft = "10%";
                                    input.name = `survey[${number}][answer][]`

                                    let rv_btn = document.createElement("i");
                                    rv_btn.classList = "fa fa-trash aria-hidden='true' ml-2";
                                    rv_btn.setAttribute("aria-hidden", true);
                                    rv_btn.onclick = () => {        
                                        answer_set.removeChild(div);
                                    }                            

                                    div.appendChild(input);
                                    div.appendChild(rv_btn);
                                    answer_set.append(div);
                                }

                                // 기타항목시 하단에 추가
                                let answer_etc = tag_question.getElementsByClassName("row")[3];
                                if (answer_etc === null) {
                                    answer_etc = document.createElement("div");
                                    answer_etc.classList = "row";
                                    tag_question.appendChild(answer_etc);
                                }

                                if (element[i].can_etc_answer === "y") {
                                    let input = document.createElement("span");
                                    input.type = "text";
                                    input.classList = "form-control";
                                    input.innerText = "기타";
                                    input.style.width = "85%";
                                    input.style.marginLeft = "10%";
                                    input.setAttribute("readonly", true);
                                    input.name = `survey[${number}][answer][]`;
                                    answer_etc.appendChild(input);
                                }

                                break;
                            case "free_image":
                                break;
                            case "5star": 
                                tag_question = Element_makeElementBox(ElementType.FIVE_STAR);
                                number = Number(tag_question.childNodes[2].name.match(/\[(\d+)\]/)[1]);
                                break;
                            case "percentage": 
                                tag_question = Element_makeElementBox(ElementType.PERCENTAGE);
                                number = Number(tag_question.childNodes[2].name.match(/\[(\d+)\]/)[1]);
                                break;
                            case "oeq":
                                tag_question = Element_makeElementBox(ElementType.OEQ);
                                number = Number(tag_question.childNodes[2].name.match(/\[(\d+)\]/)[1]);
                                break;
                            case "subtitle":
                                tag_question = Element_makeElementBox(ElementType.SUBTITLE);
                                number = Number(tag_question.childNodes[1].name.match(/\[(\d+)\]/)[1]);
                                break;
                            case "desc_field":
                                tag_question = Element_makeElementBox(ElementType.DESC_FIELD);
                                number = Number(tag_question.childNodes[1].name.match(/\[(\d+)\]/)[1]);
                                break;
                            case "division-line":
                                tag_question = Element_makeElementBox(ElementType.DIVISION_LINE);
                                break;
                        }

                        let title = tag_question.querySelectorAll(`[name^="survey[${number}][title]"]`);

                        if (title != null && title.length !== 0)  {
                            title[0].value = element[i].content;
                        }

                        let is_essential = tag_question.querySelectorAll(`[name^="survey[${number}][questionType][is_essential]`);

                        if (is_essential != null && is_essential.length !== 0) {
                            is_essential[0].checked = element[i].is_essential === "y";
                        }                        

                    }

                }


            }

            async function save() {
                let selected_members = document.getElementsByClassName("members_id[]");

                // form 기준 체크된 것만 가져오므로, 전체 참석자를 체크함.
                for (let i = 0; i < selected_members.length; ++i) {                    
                    selected_members[i].checked = true;      
                }

                let content = document.getElementById("content");

                // 문항 수 확인
                let htmlChildren = Array.from(content.children).filter(function(child) {
                    return child.nodeType === 1; // ELEMENT_NODE
                });                
                        
                if (!validateCheck()) {
                    return;
                }


                $('#fadminwrite').submit();
            }


            const ElementType = {
                DIVISION_LINE: "division-line",
                SUBTITLE: "subtitle",
                DESC_FIELD:"descript_field",
                OEQ: "open_ended_question",
                FIVE_STAR: "five_star",
                PERCENTAGE: "percentage",
                FREE_TEXT: "free_text"

            }

            let content = document.getElementById("content");

            function Element_makeElementBox(type) {         

                let element = null; // 실제 추가되는 element
                let controller_element = null; // 위치 수정 & 삭제 UI가 추가되는 element

                let htmlChildren = Array.from(content.children).filter(function(child) {
                    return child.nodeType === 1; // ELEMENT_NODE
                });

                if (htmlChildren.length > 49) {
                    alert("서베이 항목은 50개를 초과할 수 없습니다.");
                    return;
                }

                
                switch (type) {
                    case ElementType.DIVISION_LINE: {                    
                        let div = document.createElement("div");
                        div.classList = "horizontal-divider";

                        element = document.createElement("div");                        
                        element.style.display = "flex";

                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "division_line";

                        element.appendChild(input_type);
                        
                        element.appendChild(div);
                        controller_element = element;
                    }
                    break;
                    case ElementType.SUBTITLE: {
                        let label = document.createElement("label");
                        label.classList = "mr-2";
                        label.style.width = "5%";
                        label.innerText = "소제목";
                        let input = document.createElement("input");
                        input.type = "text";
                        input.classList = "form-control";
                        input.placeholder = "소제목을 입력해주세요.";
                        input.name = `survey[${htmlChildren.length}][title]`;
                        element = document.createElement("div");                        
                        element.style.display = "flex";     

                        element.appendChild(label);
                        element.appendChild(input);     
                        controller_element = element;   


                        
                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "sub_title";
                        element.appendChild(input_type);

                    }
                    break;
                    case ElementType.DESC_FIELD: {
                        let label = document.createElement("label");
                        label.classList = "mr-2";
                        label.style.width = "5%";
                        label.innerText = "설명";
                        let input = document.createElement("input");
                        input.type = "text";
                        input.classList = "form-control";                        
                        input.placeholder = "설명을 입력해주세요.";
                        input.name = `survey[${htmlChildren.length}][title]`;

                        element = document.createElement("div");                        
                        element.style.display = "flex";     

                        element.appendChild(label);
                        element.appendChild(input);   
                        controller_element = element;      
                        
                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "desc_field";
                        element.appendChild(input_type);
                    }
                    break;
                    case ElementType.OEQ:  {
                        let label = document.createElement("label");
                        label.classList = "mr-2";
                        label.style.width = "5%";
                        label.innerText = "주관식";

                        let labelElement = document.createElement("label");
                        let checkbox = document.createElement("input");
                        checkbox.type = "checkbox";                        
                        checkbox.classList = "form-check-input";                        
                        checkbox.name = `survey[${htmlChildren.length}][questionType][is_essential]`;
                        let textNode = document.createTextNode("  필수항목");
                        labelElement.appendChild(checkbox);                             
                        labelElement.appendChild(textNode);
                        labelElement.style.width = "100%"                       

                        let row1 = document.createElement("div");
                        row1.classList = "row";
                        row1.style.display = "flex";
                        row1.appendChild(label);
                        row1.appendChild(labelElement);

                        let row2 = document.createElement("div");
                        row2.classList = "row";

                        let input = document.createElement("input");
                        input.type = "text";
                        input.classList = "form-control";
                        input.placeholder = "주관식 질문을 입력해주세요.";
                        input.name = `survey[${htmlChildren.length}][title]`;

                        element = document.createElement("div");                        

                        row1.appendChild(label);
                        row1.appendChild(labelElement);
                        row2.appendChild(input);
                        element.appendChild(row1);
                        element.appendChild(row2);
                                                
                        controller_element = row1;       
                        
                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "OEQ";
                        element.appendChild(input_type);
                    }                  
                    break;
                    case ElementType.FIVE_STAR: {
                        let label = document.createElement("label");
                        label.classList = "mr-2";
                        label.style.width = "5%";
                        label.innerText = "별점";

                        let labelElement = document.createElement("label");
                        let checkbox = document.createElement("input");
                        checkbox.type = "checkbox";                        
                        checkbox.classList = "form-check-input";                        
                        checkbox.name = `survey[${htmlChildren.length}][questionType][is_essential]`;
                        let textNode = document.createTextNode("  필수항목");
                        labelElement.appendChild(checkbox);                             
                        labelElement.appendChild(textNode);
                        labelElement.style.width = "100%"                                               

                        let row1 = document.createElement("div");
                        row1.classList = "row";
                        row1.style.display = "flex";
                        row1.appendChild(label);
                        row1.appendChild(labelElement);

                        let row2 = document.createElement("div");
                        row2.classList = "row";

                        let input = document.createElement("input");
                        input.type = "text";
                        input.classList = "form-control";
                        input.placeholder = "별점 질문을 입력해주세요.";
                        input.name = `survey[${htmlChildren.length}][title]`;


                        element = document.createElement("div");                        

                        row1.appendChild(label);
                        row1.appendChild(labelElement);
                        row2.appendChild(input);
                        element.appendChild(row1);
                        element.appendChild(row2);
                                                
                        controller_element = row1;       
                        
                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "fiveStar";
                        element.appendChild(input_type);
                    }                                                          
                    break;
                    case ElementType.PERCENTAGE: {
                        let label = document.createElement("label");
                        label.classList = "mr-2";
                        label.style.width = "10%";
                        label.innerText = "퍼센테이지";

                        let labelElement = document.createElement("label");
                        let checkbox = document.createElement("input");
                        checkbox.type = "checkbox";                        
                        checkbox.classList = "form-check-input";  
                        checkbox.name = `survey[${htmlChildren.length}][questionType][is_essential]`;                     
                        let textNode = document.createTextNode("  필수항목");
                        labelElement.appendChild(checkbox);                             
                        labelElement.appendChild(textNode);
                        labelElement.style.width = "100%"                                            

                        let row1 = document.createElement("div");
                        row1.classList = "row";
                        row1.style.display = "flex";
                        row1.appendChild(label);
                        row1.appendChild(labelElement);

                        let row2 = document.createElement("div");
                        row2.classList = "row";

                        let input = document.createElement("input");
                        input.type = "text";
                        input.classList = "form-control";
                        input.placeholder = "퍼센테이지 질문을 입력해주세요.";
                        input.name = `survey[${htmlChildren.length}][title]`;

                        element = document.createElement("div");                        

                        row1.appendChild(label);
                        row1.appendChild(labelElement);
                        row2.appendChild(input);
                        element.appendChild(row1);
                        element.appendChild(row2);
                                                
                        controller_element = row1;

                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "Percentage";
                        element.appendChild(input_type);
                    }                    
                    break;
                    case ElementType.FREE_TEXT: {
                        let label = document.createElement("label");
                        label.classList = "mr-2";
                        label.style.width = "5%";
                        label.innerText = "객관식";

                        let labelElement1 = document.createElement("label");
                        labelElement1.style.width = "10%"
                        let checkbox1 = document.createElement("input");
                        checkbox1.type = "checkbox";                        
                        checkbox1.classList = "form-check-input";  
                        checkbox1.name = `survey[${htmlChildren.length}][questionType][is_essential]`;
                        let textNode1 = document.createTextNode("  필수항목");
                        labelElement1.appendChild(checkbox1);                             
                        labelElement1.appendChild(textNode1);

                        let labelElement2 = document.createElement("label");
                        labelElement2.style.width = "13%"
                        let checkbox2 = document.createElement("input");
                        checkbox2.type = "checkbox";                        
                        checkbox2.classList = "form-check-input";                  
                        checkbox2.name = `survey[${htmlChildren.length}][questionType][can_multiple_choice]`;
                        let textNode2 = document.createTextNode("  복수응답 가능");
                        labelElement2.appendChild(checkbox2);                             
                        labelElement2.appendChild(textNode2);

                        let labelElement3 = document.createElement("label");
                        let checkbox3 = document.createElement("input");
                        checkbox3.type = "checkbox";                        
                        checkbox3.classList = "form-check-input";         
                        checkbox3.name = `survey[${htmlChildren.length}][questionType][can_etc_answer]`;
                        let textNode3 = document.createTextNode("  '기타' 항목 추가");
                        labelElement3.appendChild(checkbox3);                             
                        labelElement3.appendChild(textNode3);
                        labelElement3.style.width = "100%";

                        let row4 = document.createElement("div");
                        row4.classList = "row";

                        let index = `${htmlChildren.length}`;
                        
                        checkbox3.onclick = () => {
                            if (checkbox3.checked) {
                                let input = document.createElement("span");
                                input.type = "text";
                                input.classList = "form-control";
                                input.innerText = "기타";
                                input.style.width = "85%";
                                input.style.marginLeft = "10%";
                                input.setAttribute("readonly", true);
                                input.name = `survey[${index}][answer][]`;
                                row4.appendChild(input);
                            } else {
                                row4.innerHTML = "";
                            }
                        }
                                                                      
                        let row1 = document.createElement("div");
                        row1.classList = "row";
                        row1.style.display = "flex";
                        row1.appendChild(label);
                        row1.appendChild(labelElement1);
                        row1.appendChild(labelElement2);
                        row1.appendChild(labelElement3);

                        let row2 = document.createElement("div");
                        row2.classList = "row";

                        let input = document.createElement("input");
                        input.type = "text";
                        input.classList = "form-control";
                        input.placeholder = "객관식 질문을 입력해주세요.";
                        input.style.width = "90%";
                        input.style.marginLeft = "5%";
                        input.name = `survey[${htmlChildren.length}][title]`;


                        let row3 = document.createElement("div");
                        row3.classList = "row";

                        let add_btn = document.createElement("button");
                        add_btn.type = "button";
                        add_btn.textContent = "답변추가";

                        add_btn.onclick = () => {
                            let htmlChildren = Array.from(row3.children).filter(function(child) {
                                return child.nodeType === 1; // ELEMENT_NODE
                            });

                            if (htmlChildren.length > 9) {
                                alert("주관식 답변은 10개를 초과할 수 없습니다.");
                                return;
                            }

                            let div = document.createElement("div");

                            let input = document.createElement("input");
                            input.type = "text";
                            input.classList = "form-control";
                            input.placeholder = "답변을 입력하세요.";
                            input.style.width = "85%";
                            input.style.marginLeft = "10%";
                            input.name = `survey[${index}][answer][]`

                            let rv_btn = document.createElement("i");
                            rv_btn.classList = "fa fa-trash aria-hidden='true' ml-2";
                            rv_btn.setAttribute("aria-hidden", true);
                            rv_btn.onclick = () => {        
                                row3.removeChild(div);
                            }                            

                            div.appendChild(input);
                            div.appendChild(rv_btn);
                            row3.append(div);
                        }

                        row2.appendChild(input);
                        row2.appendChild(add_btn);
  
                        element = document.createElement("div");                        

                        let input_type = document.createElement("input");
                        input_type.type = "hidden";
                        input_type.name = `survey[${htmlChildren.length}][type]`;
                        input_type.value = "FreeText";
                        element.appendChild(input_type);

                        element.appendChild(row1);
                        element.appendChild(row2);
                        element.appendChild(row3);
                        element.appendChild(row4);
                                                
                        controller_element = row1;                                        
                    }
                    break;
                    default:
                    break;
                }

                if (element !== null && controller_element !== null) {
                    // 바깥 아이템 생성
                    let div_row = document.createElement("div");
                    div_row.classList = "row mb-3";

                    let div_content = document.createElement("div");
                    div_content.classList = "col-sm-12";
                    div_content.appendChild(element);

                    // 삭제, 위 아래 순서 변경 추가     

                    let bottom_btn = document.createElement("i");
                    bottom_btn.classList = "fa fa-chevron-down ml-2";
                    bottom_btn.setAttribute("aria-hidden", true);
                    bottom_btn.onclick = () => {                                                    

                        let htmlChildren = Array.from(content.children).filter(function(child) {
                            return child.nodeType === 1; // ELEMENT_NODE
                        });

                        let i = htmlChildren.indexOf(div_row);                      


                        let targetChild = htmlChildren[i];
                        let afterChild = htmlChildren[i + 1];
                        
                        if (afterChild === null || afterChild === undefined) {
                            return;
                        }

                        afterChild.insertAdjacentElement('afterend', targetChild);
                    }


                    let up_btn = document.createElement("i");
                    up_btn.classList = "fa fa-chevron-up ml-2";
                    up_btn.setAttribute("aria-hidden", true);
                    up_btn.onclick = () => {
                        let htmlChildren = Array.from(content.children).filter(function(child) {
                            return child.nodeType === 1; // ELEMENT_NODE
                        });

                        let i = htmlChildren.indexOf(div_row); 

                        if (i === 0) {
                            return;
                        }                     

                        let targetChild = htmlChildren[i];
                        let beforeChild = htmlChildren[i - 1];                                                

                        beforeChild.insertAdjacentElement('beforebegin', targetChild);
                    }               
                    
                    // 삭제버튼
                    let rv_btn = document.createElement("i");
                    rv_btn.classList = "fa fa-trash aria-hidden='true' ml-2";
                    rv_btn.setAttribute("aria-hidden", true);
                    rv_btn.onclick = () => {        
                        content.removeChild(div_row);
                    }         

                    controller_element.appendChild(bottom_btn);
                    controller_element.appendChild(up_btn);
                    controller_element.appendChild(rv_btn);

                    div_content.appendChild(element);
                    div_row.appendChild(div_content);
                    content.appendChild(div_row);

                }

                return element;
            }            

            // 직원등록 팝업 추가
            document.querySelector(".btn-member-setting-popup").addEventListener("click",function(){
	            if (window.firstPopup && !window.firstPopup.closed) {
                   window.firstPopup.close();
                }
                
                window.firstPopup = window.open('/admin/servicing/survey/memberList?', '응답자 선택', 'width=1500px, height=750px, menubar=no, toolbar=no, location=no, status=no, scrollbars=no');
                
                window.firstPopup.addEventListener("load", () => {
                    window.firstPopup.postMessage({ type: "mapData", data: members_selected !== null ? Array.from(members_selected) : null }, "*");
                })                      
            });

            document.getElementById("check_all_member").addEventListener("click", function() {
                let check_all = document.getElementById("check_all_member");
                let selected_members = document.getElementsByClassName("members_id[]");

                for (let i = 0; i < selected_members.length; ++i) {                    
                    if (check_all.checked) {
                        selected_members[i].checked = true;                        
                    } else {
                        selected_members[i].checked = false;
                    }
                }
            })

            function delete_select_members() {                
                let selected_members = document.getElementsByClassName("members_id[]");
                let delete_target = [];
                for (let i = 0; i < selected_members.length; ++i) {
                    if (selected_members[i].checked) {
                        members_selected.delete(selected_members[i].value);
                        delete_target.push(document.getElementsByClassName(`mem_row[${selected_members[i].value}]`)[0]);        
                
                    }
                }

                for (let i = 0; i < delete_target.length; ++i) {                    
                    delete_target[i].remove();
                }
            }


            function update_cit_members_arr(data) {
                // 추가하기                
                let tbody = document.getElementsByClassName("table")[0].getElementsByTagName("tbody")[0];                
                tbody.innerHTML = "";                

                let check_all = document.getElementById("check_all_member");
                check_all.checked = false;

                let map = new Map(Array.from(data).sort((a, b) => b[0] - a[0]));
                members_selected = map;

                map.forEach((value, key) => {
                    let tr = document.createElement("tr");
                    tr.classList = `mem_row[${key}]`
                    let td1 = document.createElement("td");
                    let checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.classList = "members_id[]"
                    checkbox.name = "members_id[]"
                    checkbox.value = key;
                    checkbox.addEventListener("change", () => {
                        let selected_members = document.getElementsByClassName("members_id[]");

                        if (!checkbox.checked) {
                            check_all.checked = false;
                        } else {
                            let selected_count = document.querySelectorAll('.members_id\\[\\]:checked').length;
                            if (selected_count === selected_members.length) {
                                check_all.checked = true;
                            }
                        }
                    })

                    td1.appendChild(checkbox);

                    let prevtd2 = document.createElement("td"); 
                    prevtd2.textContent = key;
                    
                    let td2 = document.createElement("td");
                    td2.textContent = value['mem_ocname'];

                    let td3 = document.createElement("td");
                    td3.textContent = value['mem_position'];

                    let td4 = document.createElement("td");
                    td4.textContent = value['mem_username'];

                    let td5 = document.createElement("td");
                    td5.textContent = value['mem_userid'];

                    let td6 = document.createElement("td");
                    td6.textContent = value['mem_email'];
                    
                    tr.appendChild(td1);
                    tr.appendChild(prevtd2);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    tr.appendChild(td5);
                    tr.appendChild(td6);

                    tbody.appendChild(tr);
                });
            }
            
            loadData();


        </script>           
    </div>
    
</div>