
<style>
/* reset */
html, body,
h1,h2,h3,h4,h5,h6,p, blockquote,address,
span,strong,em,q,sub,sup,del,s,a,img,
div,header,nav,aside,main,footer,article,figure,figcaption,
section,video,
table,thead,tbody,tfoot,tr,th,td,ul,ol,li,dl,dt,dd,
form,fieldset,legend,input,select,option,button,label,textarea {
    font-family: 'NexonLv2Gothic';
    margin:0; padding:0; line-height:1.0;
    font-size:16px; font-style:normal; font-weight:normal;
    text-decoration:none; letter-spacing: -0.02em;
}
th {text-align:left;}
table, tr, th, td {border-collapse:collapse;}
ul,ol,li {list-style:none;}
a {color:#000;}
input {outline:none; border:0;}
button {cursor:pointer; border:0;}
fieldset {border:0;}
.skip {display:none;}

@font-face {
	font-family: 'NexonLv2Gothic';
	src: url(./font/NEXON_Lv2_Gothic_otf.woff) format('woff');
	font-weight: 400; 			
	font-style: normal;
}
@font-face {
	font-family: 'NexonLv2Gothic';
	src: url(./font/NEXON_Lv2_Gothic_Medium_otf.woff) format('woff');
	font-weight: 500;
	font-style: normal;
}
@font-face {
	font-family: 'NexonLv2Gothic';
	src: url(./font/NEXON_Lv2_Gothic_Bold_otf.woff) format('woff');
	font-weight: 700;
	font-style: normal;
}
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font:inherit;
	font-family: 'NexonLv2Gothic', sans-serif;
	letter-spacing: -0.02em;
}
body, th, td, input, select, textarea, button {
	font-family: 'NexonLv2Gothic', sans-serif;

}
html, body, h1, h2, h3, h4, h5, h6, p, blockquote, address, span, strong, em, q, sub, sup, del, s, a, img, div, header, nav, aside, main, footer, article, figure, figcaption, section, video, table, thead, tbody, tfoot, tr, th, td, ul, ol, li, dl, dt, dd, form, fieldset, legend, input, select, option, button, label, textarea {
	line-height: 1.4;
}
header{display: none;}
.navbar{display: none;}
.sidebar{display: none;}
footer{display: none !important;}
button {
	background: none;
    border: 0;
    cursor: pointer;
}

/* statusBox */
.statusBox {
    background-color: #fff;
    width:390px; height:362px;
    border-radius: 15px;
    position: relative;
    border: 2px solid rgba(0, 168, 250, 1);
    position:relative;
    top:-36%;  /* 12/27 고침 */
    left:50%; transform:translate(-50%,50%); /* 12/27 고침 */
    z-index: 1;
}
.statusBox .status_save_box {}
.statusBox h1 {padding:21px 0 20px 0; text-align: center; font-weight: 700;}
/* 아래 닫기버튼 요기 수정했습니다!!!!!! .statusBox #status_popup_close */
.statusBox #status_popup_close {
    background-color:transparent;
    width:43px; height: 40px;
    background-color: rgba(255, 255, 255, 0.90);
    position: absolute; top:-42px; right:34px;
    border-radius:8px 8px 0 0;
    border:2px solid #00A8FA;
    border-bottom: 0;
    
}
.statusBox #status_popup_close img{
    position: absolute;
    right: 50%;
    left: 50%;
    transform: translate(-50%,-50%);    
}
.statusBox .status_save_box .status_icon {
    /* padding-top: 20px; */
    margin: 0 auto;
    display: flex; flex-flow: column wrap;
    width:282px; height: 100%;
    padding-bottom: 15.5px;
}
.statusBox .status_save_box .status_icon .status_iconTop {
    display: flex; flex-flow: row nowrap; justify-content: space-between;
}
.statusBox .status_save_box .status_icon .status_iconBtm {
    margin: 0 auto; width:181px; 
    margin-top:15px;
    display:flex; flex-flow: row nowrap;
}
.statusBox .status_save_box .status_icon .status_iconTop .icon_g {
    display:flex; flex-flow: column nowrap; align-items: center;
}
.statusBox .status_save_box .status_icon .status_iconBtm .icon_g {
    display: flex; flex-flow: column nowrap; align-items: center;
}
.statusBox .status_save_box .status_icon .status_iconBtm .earthworm {padding-left:21px;}
.statusBox .status_save_box .status_icon .icon_g p {font-weight: 700;}
.statusBox .status_save_box .status_icon .Fruit p:first-child {padding-top: 7px;}
.statusBox .status_save_box .status_icon .Seed p:first-child {padding-top: 10px;}
.statusBox .status_save_box .status_icon .Water p:first-child {padding-top: 5px;}
.statusBox .status_save_box .status_icon .fertilizer p:first-child {padding-top: 7px;}
.statusBox .status_save_box .status_icon .earthworm p:first-child {padding-top: 8px;}
.statusBox .status_save_box .status_icon .icon_g p:first-child {}
.statusBox .status_save_box .status_icon .icon_g p:first-child:hover::after {opacity: 1;}
.statusBox .status_save_box .status_icon .icon_g p:first-child::after {
    content:'';
    z-index: 10; display: block; 
    width:80px; height: 80px; border-radius: 5px;
    opacity:0;
    position:absolute; transition: all 0.3s linear;
    background: rgba(0,0,0,0.5);
    /* border:1.5px solid #FB8C00; */
    top:0.1px; left: 0.5px;
}
.statusBox .status_save_box .status_icon .icon_g p:first-child {
    z-index: 9;
    width:80px; height: 80px;
    border-radius: 5px;
    /* border:1.5px solid #FB8C00; */
    text-align: center;
    position: relative;
    cursor: pointer;
    background-color:rgba(251, 140, 0, 0.1);
}
.statusBox .status_save_box .status_icon .Fruit img {
    position:absolute; top:7px; left:7px;
}
.statusBox .status_save_box .status_icon .Seed img {
    position:absolute; top:10px; left:10px;
}
.statusBox .status_save_box .status_icon .Water img {
    position:absolute; top:5px; left:5px;
}
.statusBox .status_save_box .status_icon .fertilizer img {
    position:absolute; top:7px; left:7px;
}
.statusBox .status_save_box .status_icon .earthworm img {
    position:absolute; top:8px; left:7px;
}
.statusBox .status_save_box .status_icon .icon_g p:first-child:hover span {opacity: 1;}
.statusBox .status_save_box .status_icon .icon_g p:first-child span {position: absolute; top:31px; left:26px; font-weight: 500; opacity: 0; color:#fff; z-index: 12; transition: all 0.3s linear;}
.statusBox .status_save_box .status_icon .icon_g:nth-of-type(3) p:first-child span {position: absolute; left:33px;}
.statusBox .status_save_box .status_icon .earthworm p:first-child span {position: absolute; left:19px;}
.statusBox .status_save_box .status_icon .icon_g p:last-child {padding-top: 10px;}
.statusBox .status_save_box .status_icon .icon_g p:last-child span {font-weight: 700; color:#00A8FA;}
.statusBox a {display: block; color:#fff; font-weight: 700;
    position: relative;
    width:342px; height:40px;
    text-align: center; padding-top:13.5px ; margin: 0 auto; border-radius: 8px;
    background: transparent linear-gradient(90deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;
    background-size: 100%;
    transition:background 0.5s;
    overflow: hidden;
}
.statusBox a:hover {background: transparent linear-gradient(270deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;}
.statusBox a::after {
    content: '';
    position: absolute;
    top: 0;
    left: -30%;
    width: 50px;
    height: 40px;
    background: transparent linear-gradient(89deg, #FFFFFF00 0%, #FFFFFF80 46%, #FFFFFF00 100%) 0% 0% no-repeat padding-box;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
}
.statusBox a:hover::after {left:100%;}

/* WaterFBox */
/* /seum_img/waterF_bg.png */
* {letter-spacing: -0.02em;}
.waterF_box_bg {
    width:529px; height: 300px;
    background-image: url(<?php echo element('layout_skin_url', $layout); ?>/seum_img//waterF_bg.png);
    background-repeat: no-repeat;
    background-size: 100%;
    position:relative;
    top:150px;
    left:50%; transform:translateX(-50%);
}
.waterF_box_bg #waterF_popup_close {background-color:transparent; position: absolute; top:23px; right:25px;}
.waterF_box_bg .waterF_box {
    width:451px; height:97px;
    background-color: #fff;
    border-radius: 50px;
    border:1px solid rgba(149,97, 52, 0.5); 
    position: absolute; top:45px; left:39px;
    box-shadow: 1px -1px 4px 0px rgba(0, 0, 0, 0.25) inset;
    margin-left:-1px;
}
/* 닫기버튼 */
.waterF_box_bg .waterF_box #waterF_popup_close img {width: 100%;}
/* 물 */
.waterF_box_bg .waterF_box .waterBox {
    /* background-color:rgba(0,0,0,0.25); */
    display: flex; flex-flow: row nowrap; align-items: center;
    padding:7.5px 1px 0 9px; 
    
}
.waterF_box_bg .waterF_box .waterBox p img {}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop {margin-left:14px;}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content {margin-right: 30px;}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conTop {}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conTop p {
    font-size: 25px; font-weight: 500;
}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conTop p span {
    padding:0 65px 0 10px; letter-spacing: -0.05em; font-size: 16px; font-weight: 400;
}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conTop p:last-child em {font-weight: 500; font-size: 25px;}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conTop p:last-child {position:absolute; top:13px; right:160px;}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conTop p:last-child #waterBox_count {
    font-size: 25px; color:#00A8FA;
}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .conVar {border-bottom:1px solid rgba(221, 221, 221, 0.87); display: block; width:190px; margin:33px 0 6px 0;
    /* position:absolute; top:43px; */
}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conBtm {}
.waterF_box_bg .waterF_box .waterBox .waterBoxTop .waterBox_content .waterBox_conBtm p {font-size:0.8rem; line-height: 18px;}

/* 물 사용하기 버튼 */
.waterF_box_bg .waterF_box .waterBox .useBox {position:relative; width:110px; height: 43px; cursor: pointer; top:-3px;}
.waterF_box_bg .waterF_box .waterBox .useBox {}
.waterF_box_bg .waterF_box .waterBox .useBox img {position:absolute; width:100%; height: 100%; left:-7px;}
.waterF_box_bg .waterF_box .waterBox .useBox #W_none_icon {opacity:1;}
.waterF_box_bg .waterF_box .waterBox .useBox #W_use_icon:hover {opacity: 1;}
.waterF_box_bg .waterF_box .waterBox .useBox #W_use_icon {opacity:0;}
.waterF_box_bg .waterF_box .waterBox .useBox #W_use_icon-hover {opacity:0;}
/* 비료 */
.waterF_box_bg .waterF_box .fertilizerBox_bg {
    width:451px; height:97px;
    background-color: #fff;
    border-radius: 50px;
    border:1px solid rgba(149,97, 52, 0.5);
    position:relative;
    margin-top:23px; margin-left:-1px;
    box-shadow: 1px -1px 4px 0px rgba(0, 0, 0, 0.25) inset;
}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox {
    /* background-color: rgba(5,5,5,0.5); */
    display: flex; flex-flow: row nowrap; align-items: center;
    position:absolute; top:8px; left:8px;
}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop {
    margin:0 -5px 0 15px;
}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content {
    width:225px;
}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conTop {/* background-color: red; */}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conTop p {font-size: 1.5rem; font-weight: 500; letter-spacing: -0.05em;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox p img {}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conTop p span {padding:0 46px 0 10px; font-size:16px; font-weight: 400;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conTop p:last-child em {font-weight: 500; font-size: 1.5rem;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conTop p:last-child {position:absolute; top:5px; right:143px;} /* 카운트 */
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conTop p #fertilizerBox_count {font-size: 25px; color:#00A8FA;}
.fertilizerBox_bg .fertilizerBox .fertilizerBox_content .conVar {border-bottom:1px solid rgba(221, 221, 221, 0.87); display: block; width:190px;
    margin:28px 0 6px 0; /*12/27 고침 */
}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conBtm {/* margin-top:40px; */}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .fertilizerBoxTop .fertilizerBox_content .fertilizerBox_conBtm p{font-size:0.8rem; line-height: 18px;}
/* 비료 사용하기 버튼 */
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox {position:relative; width:110px; height: 43px; cursor: pointer; top:-3px;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox {}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox img {position:absolute; width:100%; height: 100%; left:-6.5px;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox #W_none_icon {opacity: 1;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox #W_use_icon:hover {opacity: 0;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox #W_use_icon {opacity: 0;}
.waterF_box_bg .waterF_box .fertilizerBox_bg .fertilizerBox .useBox #W_use_icon-hover {opacity:0;}
</style>

<!-- html -->
	<div id='box' class="box" style="width: 500px; height: 500px; font-size:20px;">
		<!-- 내용넣기 -->
        <!-- waterFBox -->
		<div class="waterF_box_bg">
            <button id="waterF_popup_close"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/close_icon.svg" alt="닫기"></button>
            <div class="waterF_box">
                <div class="waterBox_bg">
                    <div class="waterBox">
                        <p><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/box_water2_icon.png" alt=""></p>
                        <div class="waterBoxTop">
                            <div class="waterBox_content">
                                <div class="waterBox_conTop">
                                    <p>물<span>남은 개수</span></p>
                                    <p><em id="waterBox_count">0</em>개</p> <!-- 카운트 -->
                                </div>
                                <p class="conVar"></p>
                                <div class="waterBox_conBtm">
                                    <p>아이템을 사용하면<br>열매수확시간이 1시간 줄어들어요.</p>
                                </div>
                            </div>
                        </div>
                        <!-- 물 사용하기 버튼 -->
                        <div class="useBox">
                            <img id="W_none_icon" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/use_n_icon.png" alt=""> <!-- 회색버튼 -->
                            <img id="W_use_icon" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/use_o_icon.png" alt=""> <!-- 사용(파랑)버튼 -->
                            <img id="W_use_icon-hover" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/use_h_icon.png" alt=""> <!-- 눌렀을때 효과 -->
                        </div>
                    </div>
                </div>
                <div class="fertilizerBox_bg">
                    <div class="fertilizerBox">
                        <p><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/box_fertilizer2_icon.png" alt=""></p>
                        <div class="fertilizerBoxTop">
                            <div class="fertilizerBox_content">
                                <div class="fertilizerBox_conTop">
                                    <p>비료<span>남은 개수</span></p>
                                    <p><em id="fertilizerBox_count">0</em>개</p> <!-- 카운트 -->
                                </div>
                                <p class="conVar"></p>
                                <div class="fertilizerBox_conBtm">
                                    <p>아이템을 사용하면<br>남은 열매 수확 시간의 50%가 감소해요.</p>
                                </div>
                            </div>
                        </div>
                        <!-- 비료 사용하기 버튼 -->
                        <div class="useBox">
                            <img id="W_none_icon" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/use_n_icon.png" alt=""> <!-- 회색버튼 -->
                            <img id="W_use_icon" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/use_o_icon.png" alt=""> <!-- 사용(파랑)버튼 -->
                            <img id="W_use_icon-hover" src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/use_h_icon.png" alt=""> <!-- 눌렀을때 효과 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- statsBox -->
        <div class="statusBox">
            <h1>현재 보유한 아이템</h1>
            <!-- 닫기버튼 디자인 수정 -->
            <button id="status_popup_close"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/statusBox_close_icon.svg" alt="닫기"></button>
            <div class="status_save_box">
                <div class="status_icon">
                    <div class="status_iconTop">
                        <div class="icon_g Fruit">
                            <p>
                                <span>열매</span>
                                <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/st_fruit_05.png" alt="열매">
                            </p>
                            <p><span id="fruit_count">0</span>개</p>
                        </div>
                        <div class="icon_g Seed">
                            <p>
                                <span>씨앗</span>
                                <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/st_seed_03.png" alt="씨앗">
                            </p>
                            <p><span id="seed_count">0</span>개</p>
                        </div>
                        <div class="icon_g Water">
                            <p>
                                <span>물</span>
                                <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/st_water_01.png" alt="물">
                            </p>
                            <p><span id="water_count">0</span>개</p>
                        </div>
                    </div>
                    <div class="status_iconBtm">
                        <div class="icon_g fertilizer">
                            <p>
                                <span>비료</span>
                                <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/st_fertilizer_02.png" alt="비료">
                            </p>
                            <p><span id="fertilizer_count">0</span>개</p>
                        </div>
                        <div class="icon_g earthworm">
                            <p>
                                <span>지렁이</span>
                                <img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/st_earthworm_04.png" alt="지렁이">
                            </p>
                            <p><span id="earthworm_count">0</span>개</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#">활동 내역</a>
        </div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
	var map = window.top.map_url;
	var user_info = window.top.user_info;
});
</script>
<script>
    // WaterFBox
    const waterbox = document.querySelector('#W_use_icon-hover');
        waterbox.addEventListener('mousedown' ,(e) => {
            waterbox.style.opacity = '1';
        })
        waterbox.addEventListener('mouseup' ,(e) => {
            const waterbox = document.querySelector('#W_use_icon-hover');
            waterbox.style.opacity = '0';
        })
        waterbox.addEventListener('mouseover',function(){
            const waterbox = document.querySelector('#W_use_icon');
            waterbox.style.opacity= '1';
        })
        waterbox.addEventListener('mouseout',function(){
            const waterbox = document.querySelector('#W_use_icon');
            waterbox.style.opacity= '0';
        })
</script>