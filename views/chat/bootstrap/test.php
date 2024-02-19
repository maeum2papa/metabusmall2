<!-- asmo sh 231113 인벤토리 팝업 작업 시작 -->

<style>

@font-face {
    font-family: 'NEXON_Lv2_Gothic';
    src: url(./font/NEXON_Lv2_Gothic.woff) format('woff');
    font-weight: 400;
    font-style: normal;
}

@font-face {
    font-family: 'NEXON_Lv2_Gothic';
    src: url(./font/NEXON_Lv2_Gothic_bold.woff) format('woff');
    font-weight: 700;
    font-style: normal;
}

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;

	font-family: 'NexonLv2Gothic', sans-serif;
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


#box .box_wrap {
	/* width: 100%; */
	width: 699px;
	height: 100%;
}

#box .box_wrap .box_top {
	width: 100%;
	height: 40px;
	background-color: #fff;

	display: flex;
	justify-content: space-between;
	padding: 0 31px;
    align-items: center;
}

#box .box_wrap .box_top .box_btn_wrap {
	height: 100%;
	display: flex;
}

#box .box_wrap .box_top .box_btn_wrap button {
	width: 100px;
	height: 100%;
	text-align: center;
	border: 2px solid #00A8FA;
	border-radius: 8px 8px 0px 0px;
	font-size: 18px;
	font-weight: 700;

	background-color: #FFFFFFCC;
	color: #00A8FA;

	position: relative;

	border-bottom: none;

    cursor: pointer;
}

#box .box_wrap .box_top .box_btn_wrap button::after {
	content: '';
	position: absolute;
	top: 4px;
	left: 2px;
	width: 11px;
	height: 7px;
	background-color: rgba(255, 255, 255, .9);
	opacity: 0;
	transition: opacity 0.1s;

	border-radius:50% / 50%;
    transform: rotate(330deg);
}

#box .box_wrap .box_top .box_btn_wrap button:hover, 
#box .box_wrap .box_top .box_btn_wrap button.selected {
	background: linear-gradient(to bottom, #6dc3e5 50%, #2baeea 50%);;
	color: #FFFFFF;
}

#box .box_wrap .box_top .box_btn_wrap button:hover::after,
#box .box_wrap .box_top .box_btn_wrap button.selected::after {
	opacity: 1;
}

#box .box_wrap .box_top .cancle_box {
	width: 48px;
	height: 100%;
	position: relative;

	text-align: center;
    border: 2px solid #00A8FA;
    border-radius: 8px 8px 0px 0px;
    font-size: 20px;
    font-weight: 700;

	background-color: #FFFFFFCC;
	color: #00A8FA;

	border-bottom: none;
}

#box .box_wrap .box_top .cancle_box::after {
	content: '';
	position: absolute;
	top: 4px;
	left: 2px;
	width: 11px;
	height: 7px;
	background-color: rgba(255, 255, 255, .9);
	opacity: 0;
	transition: opacity 0.1s;

	border-radius:50% / 50%;
	transform: rotate(330deg);
}

#box .box_wrap .box_top .cancle_box:hover {
	background-color: #00A8FA99;
	color: #FFFFFF;
}

#box .box_wrap .box_top .cancle_box:hover::after {
	opacity: 1;
}

#box .box_wrap .box_top .cancle_box button {
	width: 100%;
	height: 100%;

	display: flex;
    justify-content: center;
    align-items: center;

	border: 0 none;
    background-color: transparent;
    cursor: pointer;
}

#box .box_wrap .box_top .cancle_box:hover button svg path {
	stroke: #FFFFFF;
}


#box .box_wrap .box_bot {
	border-radius: 15px;
    background-color: rgba(251, 251, 251, 0.9);
    border: 2px solid rgba(0, 168, 250, 1);
    opacity: 0.9;

	padding: 18px 10px 24px 32px;
}

#box .box_wrap .box_bot .selection_box  {
	width: 100%;
	height: 36px;

	display: flex;

	align-items: center;

	margin-bottom: 24px;
}

#box .box_wrap .box_bot .selection_box ul {
	display: flex;
	height: 100%;
}

#box .box_wrap .box_bot .selection_box ul li {
	/* width: 60px; */
    height: 100%;
    background: rgba(34, 34, 34, 0);
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
	text-align: center;
	color: rgba(34, 34, 34, 1);

	padding: 0 16px;

	display: flex;
    align-items: center;
    justify-content: center;

	cursor: pointer;
}

#box .box_wrap .box_bot .selection_box ul li:hover {
	background: rgba(34, 34, 34, 0.1);
}

#box .box_wrap .box_bot .selection_box ul li.selected {

    background: rgba(34, 34, 34, 0.1);
}

#box .box_wrap .box_bot .character_info_box {
	display: flex;
    align-items: center;

	position: relative;
}

#box .box_wrap .box_bot .character_info_box .product_wrap_bottom_bar {
	position: absolute;
    width: 478px;
    height: 25px;
    right: 6px;
    background: transparent linear-gradient(180deg, #FFFFFF00 0%, #FFFFFFE6 100%) 0% 0% no-repeat padding-box;
    bottom: 0;
    z-index: 1;
}

#box .box_wrap .box_bot .character_info_box .product_wrap_bottom_bar.land {
	width: calc(100% - 6px);
}

#box .box_wrap .box_bot .character_info_box .fixed_info {
	width: 144px;
    /* background: aqua; */
}

#box .box_wrap .box_bot .character_info_box .fixed_info .character_img {
	width: 100%;
    height: 186px;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: center;

	border-radius: 15px;

	
	position: relative;

	/* background: linear-gradient(0deg, rgba(0, 168, 249,0.2) 0.41796875%,rgba(53, 186, 251,0.2) 8.510199652777777%,rgba(70, 191, 251,0.2) 11.15256076388889%,rgba(255, 255, 255,0.2) 40.053385416666664%); */
	background: #f6f6f6;
}

#box .box_wrap .box_bot .character_info_box .fixed_info .character_img img {
	/* width: 96px;
	height: 96px; */
	width: 150px;
	height: 150px;
}



#box .box_wrap .box_bot .character_info_box .fixed_info .character_button {
	display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

#box .box_wrap .box_bot .character_info_box .fixed_info .character_button button {
	width: 40px;
	height: 40px;
	border-radius: 10px;
	background: linear-gradient(0deg, rgba(0, 168, 249,0.2) 0.41796875%,rgba(53, 186, 251,0.2) 8.510199652777777%,rgba(70, 191, 251,0.2) 11.15256076388889%,rgba(255, 255, 255,0.2) 40.053385416666664%);
	border: 1px solid rgba(0, 168, 250, 1);

	padding: 3px;
}

#box .box_wrap .box_bot .character_info_box .fixed_info .character_button button:hover {
	background: rgba(0, 168, 250, 0.1);
}

#box .box_wrap .box_bot .character_info_box .fixed_info .character_button button img {
	width: 100%;
	height: 100%;
}

#box .box_wrap .box_bot .character_info_box .product_wrap {
	display: flex;
    flex-wrap: wrap;
    gap: 20px;
    /* width: 588px; */
	width: auto;
	height: 340px;
	overflow: auto;
	align-content: flex-start;

	padding-left: 25px;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .product_box {
	width: 144px;
    height: 144px;
    border-radius: 9px;
    border: 1px solid rgba(34, 34, 34, 0.6);
    
	display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

	cursor: pointer;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .product_box .box_border {
	width: 142px;
    height: 142px;
    border-radius: 9px;
    border: 1px solid rgba(34, 34, 34, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .product_box .product_img {
	width: 96px;
    height: 96px;
    border-radius: 10px;
    border: 1px solid #FB8C0099;

	margin-bottom: 12px;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .product_box .product_img .img_border {
	width: 94px;
    height: 94px;
    border-radius: 9px;
    border: 1px solid rgba(251, 140, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .product_box .product_img .img_border img {
	width: 100%;
	height: 100%;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .product_box .product_name p {
	color: rgba(34, 34, 34, 1);
    font-size: 14px;
    font-weight: 500;

	letter-spacing: -0.16px;
}


/* 아이템이 없을 때 */
#box .box_wrap .box_bot .character_info_box .product_wrap .nodata {
	width: 100%;
	height: 100%;

	display: flex;
	justify-content: center;
	align-items: center;
}

#box .box_wrap .box_bot .character_info_box .product_wrap .nodata p {
	color: rgba(34, 34, 34, .6);
	font-size: 18px;
	font-weight: 600;

	letter-spacing: -0.18px;


}


/* 아래의 모든 코드는 영역::코드로 사용 */
#box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar {
    width: 6px;
}

#box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar-thumb {
    /* height: 90%;  */
    background: linear-gradient(to bottom, #55bdea 50%, #3abaf5 50%);


	border: 1px solid #00A8FA;
    
    border-radius: 4px;

	position: relative;
}

#box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar-thumb::after {
	content: '';

	width: 3px;
	height: 1px;
	position: absolute;
	top: 4px;
	left: 2px;
	width: 30px;
	height: 15px;
	background-color: rgba(255, 255, 255, .9);
	opacity: 0;
	transition: opacity 0.1s;

	border-radius:50% / 50%;
    transform: rotate(330deg);

}

#box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar-track {
    background: #2222221A; 
}



/* #box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

#box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar
{
	width: 6px;
	background-color: #F5F5F5;

	border: 1px solid #00A8FA;
    
	border-radius: 10px;
}

#box .box_wrap .box_bot .character_info_box .product_wrap::-webkit-scrollbar-thumb
{
	background-color: #0ae;
	
	background-image: -webkit-gradient(linear, 0 0, 0 100%,
						color-stop(.5, rgba(255, 255, 255, .2)),
				color-stop(.5, transparent), to(transparent));

	border: 1px solid #00A8FA;
    
	border-radius: 10px;
} */

#box .box_wrap .box_bot.land {
	display: none;
}


#box .box_wrap .box_bot.land .character_info_box .product_wrap {
	padding-left: 0;
}



/* ******************* 채팅 박스 ******************* */
.chatbox {
	width: 550px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 45px;
}

.chatbox .chatbox_wrap {
	background-color: rgba(34, 34, 34, 0.65);
    border-radius: 15px;
}

/* 채팅 박스 헤더 */
.chatbox .chatbox_wrap .chatbox_header {
	width: 100%;
    height: 24px;
    border-bottom: 1px solid rgba(255, 255, 255, .2);
    padding: 0 14px;
}

.chatbox .chatbox_wrap .chatbox_header .chatbox_header_icon {
	height: 100%;
	float: right;

	display: flex;
	align-items: center;
}

.chatbox .chatbox_wrap .chatbox_header .chatbox_header_icon button {
	width: 16px;
    height: 16px;

	
}

#chatbox_size_btn {
background: url("data:image/svg+xml,%3Csvg id='scale_icon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='16' height='16' viewBox='0 0 16 16'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4148' data-name='사각형 4148' width='16' height='16' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='scale_icon-2' data-name='scale_icon' opacity='0.8'%3E%3Crect id='사각형_4147' data-name='사각형 4147' width='16' height='16' fill='none'/%3E%3Cg id='그룹_782' data-name='그룹 782'%3E%3Cg id='그룹_781' data-name='그룹 781' clip-path='url(%23clip-path)'%3E%3Cpath id='합치기_25' data-name='합치기 25' d='M-11433.578-4521.8a.234.234,0,0,1-.045-.007.64.64,0,0,1-.367-.371.1.1,0,0,1-.01-.045v-5.77a.084.084,0,0,1,.01-.044.622.622,0,0,1,.229-.295.469.469,0,0,1,.1-.035.043.043,0,0,0,.021,0,.117.117,0,0,0,.034-.014.427.427,0,0,1,.168-.038.432.432,0,0,1,.065,0h.008c.044,0,.1,0,.161,0v-4.98a.528.528,0,0,1,.6-.6h10.208a.689.689,0,0,1,.351.086.542.542,0,0,1,.247.508v10.207a.546.546,0,0,1-.251.515.687.687,0,0,1-.354.086h-4.979a1.232,1.232,0,0,0,0,.161.574.574,0,0,1-.381.628.2.2,0,0,1-.045.007Zm.625-1.037h4.527v-4.538h-4.527Zm.795-5.581h4.185a.2.2,0,0,1,.1.027h0a.508.508,0,0,1,.485.56v4.187h4.54v-9.312h-9.315Zm5.311-.182a.527.527,0,0,1-.348-.333.52.52,0,0,1,.072-.466,1.312,1.312,0,0,1,.106-.117l.653-.652,1.2-1.2h-.7a.525.525,0,0,1-.559-.515.505.505,0,0,1,.414-.5l.024-.007a.494.494,0,0,1,.12-.017h2.272l.078,0a.118.118,0,0,1,.109.1l0,.014v.014a.05.05,0,0,1,0,.021.158.158,0,0,1,.008.048v.655c0,.536,0,1.091,0,1.633a.536.536,0,0,1-.134.354.013.013,0,0,0,0,.007c-.007.006-.018.02-.032.034a.466.466,0,0,1-.288.134.125.125,0,0,1-.055.014.592.592,0,0,1-.147-.021.489.489,0,0,1-.333-.344.2.2,0,0,0-.011-.031.365.365,0,0,1-.033-.13c0-.213,0-.429,0-.635v-.1l-1.137,1.137c-.246.247-.49.494-.734.738a.66.66,0,0,1-.217.144.271.271,0,0,1-.065.017.024.024,0,0,0-.013,0l-.014,0a.285.285,0,0,1-.09.017A.565.565,0,0,1-11426.848-4528.6Z' transform='translate(11435.899 4535.9)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") no-repeat center center;
}

#chatbox_size_btn.click {
	background: url("data:image/svg+xml,%3Csvg id='축소_icon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='16' height='16' viewBox='0 0 16 16'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4148' data-name='사각형 4148' width='16' height='16' transform='translate(0 -0.368)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='축소_icon-2' data-name='축소_icon' transform='translate(0 0.368)' opacity='0.8'%3E%3Crect id='사각형_4147' data-name='사각형 4147' width='16' height='16' transform='translate(0 -0.368)' fill='none'/%3E%3Cg id='그룹_782' data-name='그룹 782'%3E%3Cg id='그룹_781' data-name='그룹 781' clip-path='url(%23clip-path)'%3E%3Cpath id='합치기_25' data-name='합치기 25' d='M.423,12.2a.123.123,0,0,1-.044-.008.638.638,0,0,1-.371-.371A.123.123,0,0,1,0,11.776V6.006a.128.128,0,0,1,.008-.045A.617.617,0,0,1,.24,5.668a.258.258,0,0,1,.1-.034l.021,0,.033-.013a.4.4,0,0,1,.167-.04l.066,0H.634a1.337,1.337,0,0,0,.163,0V.6A.53.53,0,0,1,1.4,0H11.6a.67.67,0,0,1,.348.088A.539.539,0,0,1,12.2.594V10.8a.536.536,0,0,1-.252.514.683.683,0,0,1-.354.086H6.617a1.375,1.375,0,0,0,0,.163.57.57,0,0,1-.382.625.12.12,0,0,1-.044.008Zm.622-1.038h4.53V6.624H1.045Zm.8-5.58H6.026a.209.209,0,0,1,.1.028l0,0a.506.506,0,0,1,.485.559v4.188h4.538V1.044H1.841Zm5.147-.16H6.98l-.076,0a.12.12,0,0,1-.11-.1l0-.014s0-.009,0-.014a.085.085,0,0,1,0-.021.215.215,0,0,1-.006-.049V4.566c0-.536,0-1.091,0-1.636a.542.542,0,0,1,.132-.353s0,0,0,0a.267.267,0,0,1,.031-.038A.489.489,0,0,1,7.235,2.4a.139.139,0,0,1,.057-.013.544.544,0,0,1,.147.021.482.482,0,0,1,.331.345c0,.012.008.021.012.031a.318.318,0,0,1,.033.13c0,.213,0,.428,0,.636v.1q.567-.571,1.135-1.137l.737-.737A.628.628,0,0,1,9.9,1.634a.271.271,0,0,1,.066-.018l.014,0A.068.068,0,0,0,10,1.608a.268.268,0,0,1,.088-.017.583.583,0,0,1,.153.023.52.52,0,0,1,.344.331.507.507,0,0,1-.072.467,1.03,1.03,0,0,1-.105.117l-.653.653-1.2,1.2h.364c.114,0,.227,0,.34,0a.522.522,0,0,1,.559.514.5.5,0,0,1-.412.5L9.374,5.4a.48.48,0,0,1-.12.018Z' transform='translate(1.899 1.533)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") no-repeat center center;
}


.chatbox .chatbox_wrap .chatbox_header .chatbox_header_icon button:last-child {
	margin-left: 8px;
}


/* 채팅 박스 메인 */

.chatbox .chatbox_wrap #tbox {
	width: calc(100% - 11px);
	padding: 0 16px 5px;
	height: 116px;
	overflow: hidden;
    overflow-y: auto;
    word-break: break-all;

	margin: 12px 0 0;

	max-height: 600px;
}

.chatbox .chatbox_wrap #tbox.size {
	height: auto;
}

.chatbox .chatbox_wrap #tbox > div > div {
	margin: 0 0 4px;
}

.chatbox .chatbox_wrap #tbox > div > div:last-child {
	margin: 0;
}

.chatbox .chatbox_wrap #tbox .chat_myself h3 {
	display: inline;
	font-size: 16px;
    color: #FB8C00;
    font-weight: 700;
	padding: 0;
	margin: 0 6px 0 0;
	border: none;
}

.chatbox .chatbox_wrap #tbox .activity_other h3 {
	display: inline;
	font-size: 16px;
    color: #fff;
    font-weight: 500;
	padding: 0;
	margin: 0 6px 0 0;
	border: none;
}

.chatbox .chatbox_wrap #tbox .chat_myself p,
.chatbox .chatbox_wrap #tbox .chat_other p  {
	display: inline; 
	white-space: pre-line;
	font-size: 16px;
    color: #FFF;
    font-weight: 400;

}

.chatbox .chatbox_wrap #tbox .chat_other h3 {
	display: inline;
	font-size: 16px;
	color: #FFF;
    font-weight: 700;
	padding: 0;
	margin: 0 6px 0 0;
	border: none;
}


.chatbox .chatbox_wrap #tbox .activity_farm h3 {
	display: inline;
	font-size: 16px;
	color: #FB8C00;
    font-weight: 500;
	padding: 0;
	margin: 0 6px 0 0;
	border: none;
}


.chatbox .chatbox_wrap .chatbox_button_wrap {
	padding: 11px 16px;
}

.chatbox .chatbox_wrap .chatbox_button_wrap button {
	width: 98px;
	height: 28px;
	margin: 0 6px 0 0;
	background-color: rgba(255, 255, 255, 0.8);
	border-radius: 8px;
	border: 1px solid rgba(0, 168, 250, 1);
	font-size: 16px;
	font-weight: 500;
	color: rgba(0, 168, 250, 1);

	position: relative;


}

.chatbox .chatbox_wrap .chatbox_button_wrap button::after {
	content: '';
	position: absolute;
	top: 4px;
	left: 2px;
	width: 11px;
	height: 7px;
	background-color: rgba(255, 255, 255, .9);
	opacity: 0;
	transition: opacity 0.1s;

	border-radius:50% / 50%;
    transform: rotate(330deg);
}

.chatbox .chatbox_wrap .chatbox_button_wrap button:hover, 
.chatbox .chatbox_wrap .chatbox_button_wrap button.selected {
	background: linear-gradient(to bottom, #6dc3e5 50%, #2baeea 50%);;
	color: #FFFFFF;
}

.chatbox .chatbox_wrap .chatbox_button_wrap button:hover::after,
.chatbox .chatbox_wrap .chatbox_button_wrap button.selected::after {
	opacity: 1;
}


/* 채팅 박스 메인 스크롤바 디자인 */
.chatbox .chatbox_wrap #tbox::-webkit-scrollbar {
    width: 6px;
}

.chatbox .chatbox_wrap #tbox::-webkit-scrollbar-thumb {
    /* height: 90%;  */
    background: linear-gradient(to bottom, #55bdea 50%, #3abaf5 50%);


	border: 1px solid #00A8FA;
    
    border-radius: 4px;

	position: relative;
}

.chatbox .chatbox_wrap #tbox::-webkit-scrollbar-thumb::after {
	content: '';

	width: 3px;
	height: 1px;
	position: absolute;
	top: 4px;
	left: 2px;
	width: 30px;
	height: 15px;
	background-color: rgba(255, 255, 255, .9);
	opacity: 0;
	transition: opacity 0.1s;

	border-radius:50% / 50%;
    transform: rotate(330deg);

}

.chatbox .chatbox_wrap #tbox::-webkit-scrollbar-track {
    background: #2222221A; 
}



/* 채팅 박스 푸터 */
.chatbox .chatbox_footer {
	height: 40px;
    background-color: rgba(34, 34, 34, 0.65);
    border-radius: 15px;
    margin: 6px 0 0;
}

.chatbox .chatbox_footer .chatbox_footer_input {
	height: 100%;
}


.chatbox .chatbox_footer .chatbox_footer_input input {
	height: 100%;
    width: 100%;
    background: transparent;
    outline: none;
    border: none;
    color: rgba(255, 255, 255, 1);
    padding: 0 0 0 16px;
    font-size: 16px;
}

.chatbox .chatbox_footer .chatbox_footer_input input::placeholder {
	color: rgba(255, 255, 255, .6);
    font-size: 16px;
}

#chatbox_open_btn {
	width: 130px;
    height: 36px;
    border: 1px solid rgba(251, 140, 0, 1);
    background-color: #fff;
    border-radius: 8px;
    
    color: rgba(251, 140, 0, 1);
    font-size: 16px;
    font-weight: 500;
	

	position: absolute;
    right: 0;
    bottom: 46px;

}

#chatbox_open_btn:hover {
	background-color: rgba(255, 246, 235, 1)
}

#chatbox_open_btn svg {
	top: 3px;
    position: relative;
	display: inline-block;
}


/* ******************* 열매 버튼 ******************* */

#fruit_btn {
	height: 48px;
    width: 48px;
    cursor: pointer;

	position: absolute;
	top: 64px;
    left: 250px;
}

#fruit_btn .fruit_icon {
	width: 48px;
	height: 48px;

	background: rgba(0, 168, 250, 0.5);
	border: 1px solid #FFFFFFCC;
	border-radius: 50%;
	opacity: 1;
	backdrop-filter: blur(8px);
	-webkit-backdrop-filter: blur(8px);

	padding: 8px;
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;

}

/* ******************* 인벤토리 버튼 ******************* */
#inventory_btn {
	height: 48px;
    width: 48px;
    cursor: pointer;

	position: absolute;
	top: 64px;
    left: 312px;
}

#inventory_btn .inventory_icon {
	width: 48px;
	height: 48px;

	background: rgba(0, 168, 250, 0.5);
	border: 1px solid #FFFFFFCC;
	border-radius: 50%;
	opacity: 1;
	backdrop-filter: blur(8px);
	-webkit-backdrop-filter: blur(8px);

	padding: 8px;
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;

}

/* asmo sh 231204 인벤토리 랜드 적용 완료 팝업  */
#save_land_popup {
	width: 340px;
	height: 176px;
	background-color: #FFFFFF;

	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);

	box-shadow: 0px 3px 20px #00A8FA14;
	border-radius: 15px;

	z-index: 100;

	display: none;
}

#save_land_popup .save_land_box {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	height: 100%;

	padding: 44px 24px 24px;
}

#save_land_popup .save_land_box p {
	font-size: 18px;
	font-weight: 500;
}

#save_land_popup .save_land_box button {
	margin-top: auto;
	width: 100%;
	height: 40px;
	background-color: #FFFFFF;
	border: 1px solid #22222233;
	border-radius: 8px;

	font-size: 16px;
	font-weight: 500;
	color: rgba(34, 34, 34, .6)
}

#save_land_popup .save_land_box button:hover {
	background-color: rgba(34, 34, 34, 0.03);
}



/* asmo sh 231204 인벤토리 캐릭터 적용 완료 팝업 */
#save_char_popup {
	width: 250px;
    height: 80px;
    background: linear-gradient(to bottom, #6dc3e5 50%, #2baeea 50%);
    border: 2px solid #00A8FA;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 15px;
    z-index: 100;

	display: none;
}

#save_char_popup .save_char_box {
	width: 246px;
    height: 76px;
    border: 1px solid #fff;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#save_char_popup .save_char_box p {
	font-size: 18px;
    font-weight: 500;
    color: #fff;
}



/* asmo sh 231204 열매현황 팝업 */
#status_popup {
	box-shadow: 0px 3px 20px #00A8FA14;
    border-radius: 15px;
    position: absolute;
    z-index: 1000;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-width: 390px;
    background-color: #fff;

	display: none;
}

#status_popup .status_box {
	padding: 44px 24px 24px;
}

#status_popup .status_box .status_save_box {
	margin: 0 0 20px;
}

#status_popup .status_box .status_save_box .status_save {
	display: flex;
    align-items: center;

	gap: 4px;
    margin: 0 0 16px;
}

#status_popup .status_box .status_save_box .status_save:last-child {
	margin: 0;
}

#status_popup .status_box .status_save_box .status_save .status_icon {
	width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #00A8FA4D;
    padding: 2px;
}

#status_popup .status_box .status_save_box .status_save p {
	font-size: 18px;
    font-weight: 500;
}

#status_popup .status_box .status_save_box .status_save p span {
	color: #00A8FA;
}

#status_popup .status_box .status_total_box {
	width: 100%;
	height: 40px;

	display: flex;
	justify-content: center;
	align-items: center;

	background: #00A8FA80 0% 0% no-repeat padding-box;
	border: 1px solid #00A8FA1A;
	border-radius: 8px;
	opacity: 1;
	backdrop-filter: blur(8px);
	-webkit-backdrop-filter: blur(8px);

	margin: 0 0 38px;
}

#status_popup .status_box .status_total_box p {
	font-size: 18px;
	font-weight: 500;
}

#status_popup .status_box .status_total_box p span {
	color: #00A8FA;
}

#status_popup .status_box a {
	width: 100%;
	height: 40px;

	background: transparent linear-gradient(90deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;
	border-radius: 8px;

	font-size: 16px;
	font-weight: 500;
	color: #FFFFFF;

	display: flex;
	justify-content: center;
	align-items: center;

	position: relative;
	
}

#status_popup .status_box a:hover {
	background: transparent linear-gradient(270deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;
}


#status_popup .status_box a::after {
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

#status_popup .status_box a:hover::after {
    left: 100%;

}


#status_popup #status_popup_close {
	position:absolute;
	top:16px;
	right:16px;

	width: 24px;
	height: 24px;
	/* font-size: 0; */

}

#status_popup #status_popup_close svg path {
	stroke: #000;
}


/* asmo sh 231204 프로필 카드 팝업 */
.profile_card {
	width: 390px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.profile_card .card_top {
	display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding: 24px 24px 0;
    background: transparent linear-gradient(130deg, #FB8C00 0%, #FDD199 100%) 0% 0% no-repeat padding-box;
    border-radius: 15px 15px 0px 0px;
}

.profile_card .card_top .card_top_flex_box {
	display: flex;
    width: 100%;
}

.profile_card .card_top .card_top_flex_box .card_top_left {
	display: flex;
    align-items: center;
    gap: 4px;
}

.profile_card .card_top .card_top_flex_box .card_top_left p {
	font-size: 18px;
    font-weight: 500;
    color: #fff;
}

.profile_card .card_top .card_top_flex_box .card_top_right {
	margin-left: auto;
}

.profile_card .card_top .card_top_flex_box .card_top_right svg path {
	stroke: #fff;
}

.profile_card .card_top .card_char_img {
	width: 150px;
    height: 150px;
    /* border: 5px solid #fff; */
    box-shadow: 2px 3px 20px #FB8C0014;
    background: #f6f6f6;
    border-radius: 50%;
    margin: 32px 0 16px;
} 

.profile_card .card_top .card_char_img img {
	width: 100%;
	height: 100%;
	border-radius: 50%;
}

.profile_card .card_top .card_char_info .card_char_info_name {
	margin: 0 0 10px;
	text-align: center;
}

.profile_card .card_top .card_char_info .card_char_info_name #card_info_name {
	font-size: 24px;
    color: #fff;
    font-weight: 700;
}

.profile_card .card_top .card_char_info .card_char_info_name #card_info_position {
	font-size: 15px;
    color: #fff;
    font-weight: 700;
}

.profile_card .card_top .card_char_info .card_char_info_department #info_department {
	font-size: 16px;
    color: #fff;
}

.profile_card .card_top > a {
	font-size: 16px;
    font-weight: 500;
    color: #FB8C00;
    width: 212px;
    height: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 2px 3px 20px #FB8C003D;
    border: 1px solid #FB8C00;
    border-radius: 24px;
    background-color: #fff;
    position: relative;
    bottom: -19px;
}

.profile_card .card_bottom {
	width: 100%;
    height: 128px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    border-radius: 0px 0px 15px 15px;
}

.profile_card .card_bottom p {
	font-size: 16px;
    color: rgba(34, 34, 34, .8);
}


/* <!-- asmo sh 231205 말풍선 퍼블리싱 --> */
#speech {
	max-width: 200px;
    padding: 10px 15px;
    border: 1px solid #000;
    border-radius: 8px;
    background-color: #fff;
	display: flex;
	justify-content: center;
	align-items: center;	
}

#speech #speech_text {
	font-size: 14px;
	font-weight: 400;
	color: #000;
	text-align: center;
}



/* <!-- asmo sh 231206 랜드 우측 버튼 및 화상 박스 퍼블리싱 --> */
#land_rtc_wrap {
	width: 200px;
    position: absolute;
    right: 80px;
    top: 88px;
}

#land_rtc_wrap .setting_btn_box {
	display: flex;
    gap: 12px;
    margin: 0 0 20px;
}

#land_rtc_wrap .setting_btn_box button#employee_list_btn {
	width: 114px;
    height: 40px;
    background: #FB8C00 0% 0% no-repeat padding-box;
    box-shadow: 2px 3px 20px #FB8C0014;
    border-radius: 15px;
    color: #fff;
    font-size: 15px;
    font-weight: 500;
}

#land_rtc_wrap .setting_btn_box button#employee_list_btn:hover {
	color: #FB8C00;
	background: #fff;
}


#land_rtc_wrap .setting_btn_box button#device_setting_btn {
	width: 114px;
    height: 40px;
    background: #fff;
    box-shadow: 2px 3px 20px #FB8C0014;
    border: 1px solid #FB8C00;
    border-radius: 15px;
    color: #FB8C00;
    font-size: 16px;
    font-weight: 500;
}

#land_rtc_wrap .setting_btn_box button#device_setting_btn:hover {
	background: rgba(255, 246, 235, 1);
}



#land_rtc_wrap .video_setting_box {
	width: 100%;
    height: 48px;
    background: #6F6A65 0% 0% no-repeat padding-box;
    border-radius: 10px;
    display: flex;
    margin: 0 0 15px;
}

#land_rtc_wrap .video_setting_box button {
	width: 25%;
    font-size: 9px;
    color: #fff;

	display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#land_rtc_wrap .video_setting_box button#toggle_camera .camera_off_box,
#land_rtc_wrap .video_setting_box button#toggle_mic .mic_off_box {
	display: none;
}

#land_rtc_wrap .video_setting_box button#toggle_camera.off .camera_off_box,
#land_rtc_wrap .video_setting_box button#toggle_mic.off .mic_off_box {
	display: block;
}

#land_rtc_wrap .video_setting_box button#toggle_camera.off .camera_on_box,
#land_rtc_wrap .video_setting_box button#toggle_mic.off .mic_on_box {
	display: none;
}

#land_rtc_wrap .video_setting_box button .camera_on,
#land_rtc_wrap .video_setting_box button .mic_on {
	display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#land_rtc_wrap .video_setting_box button .camera_off,
#land_rtc_wrap .video_setting_box button .mic_off {
	display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

	color: red;
}

#land_rtc_wrap .video_setting_box button img {
	width: 25px;
	height: 25px;
}


#land_rtc_wrap .video_call_box_wrap {
	width: 100%;
    
	max-height: 570px;
	overflow: auto;
}

#land_rtc_wrap .video_call_box_wrap::-webkit-scrollbar {
	display: none;
}

#land_rtc_wrap .video_call_box_wrap .video_call_box {
	background: rgba(34, 34, 34, .5);
    border-radius: 15px;
    width: 100%;
    height: 120px;
    display: flex;
    justify-content: center;
    align-items: center;


	margin: 0 0 15px;

	border: 2px solid transparent;
	position: relative;
	cursor: pointer;
}

#land_rtc_wrap .video_call_box_wrap .video_call_box.mic_on {
	border: 2px solid red;
}

#land_rtc_wrap .video_call_box_wrap .video_call_box:last-child {
	margin: 0;
}

#land_rtc_wrap .video_call_box_wrap .video_call_box span {
	position: absolute;
    inset: 8px 0 0 8px;
    font-size: 12px;
    color: #fff;
    font-weight: 500;
}

#land_rtc_wrap .video_call_box_wrap .video_call_box img {
	width: 75px;
    height: 75px;
}

/* <!-- asmo sh 231213 rtc 박스 클릭 시 노출되는 팝업 --> */
#land_rtc_popup {
	position: fixed;
    inset: 0 300px 0 0;
    display: flex;
    z-index: 30;
    justify-content: center;
    background-color: rgba(39,38,46,.9);
    cursor: pointer;
    pointer-events: auto;

	left: 332px;
	transition: left 0.3s ease-in-out;

	/* 사이드 바 클릭 시 left : 0px; */
	/* left: 0px */

	display: none;
}

#land_rtc_popup .land_rtc_popup_wrap {
	display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

#land_rtc_popup video {
	width: 100%;
    touch-action: none;
}

#land_rtc_popup .rtc_popup_button {
	position: absolute;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: row-reverse;
    justify-content: space-between;
    width: 100%;
    padding: 20px;
    pointer-events: auto;
}

#land_rtc_popup .rtc_popup_button button {
	background-color: rgb(255, 255, 255);
    height: 30px;
    padding: 0 10px;
    border-radius: 15px;
}

#land_rtc_popup .rtc_popup_button button:hover {
	background-color: #e9eaf0;
}

#land_rtc_popup .rtc_popup_button button span {
	font-size: 12px;
    color: #222;
}


/* <!-- asmo sh 231213 기기 설정 버튼 클릭 시 노출되는 팝업 --> */
#device_setting_bg {
	position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #22222233;
    z-index: 100000;

	display: none;
}

.device_setting {
	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    border-radius: 15px;
    background: #fff;
}

.device_setting .setting_header {
	display: flex;
    height: 64px;
    align-items: center;
    padding: 0 24px;
    border-bottom: 1px solid rgba(169, 169, 169, .5);
}

.device_setting .setting_header .setting_header_left {
	display: flex;
    align-items: center;
}


.device_setting .setting_header .setting_header_left p {
	font-size: 18px;
    color: rgba(0, 0, 0, 1);
    font-weight: 500;
}

.device_setting .setting_header .setting_header_right {
	margin-left: auto;
	height: 20px;
}

.device_setting .setting_header .setting_header_right svg path {
	stroke: #000;
}

.device_setting .setting_main {
	padding: 20px 24px 40px;
}

.device_setting .setting_main .setting_main_top p {
	color: #000000;
    font-size: 16px;
    font-weight: 500;
}

.device_setting .setting_main .setting_main_top span {
	color: rgba(0, 0, 0, .6);
    font-size: 14px;
}

.device_setting .setting_main .setting_main_mid {
	margin: 20px 0;
    padding: 0 24px;
    width: 100%;
    border-radius: 10px;
    background: rgba(246, 246, 246, 1);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.device_setting .setting_main .setting_main_mid .setting_video {
	width: 300px;
    height: 180px;
    border-radius: 8px;
	margin: 12px 0;
    background: aqua;
}

.device_setting .setting_main .setting_main_mid .setting_video video {
	width: 100%;
    touch-action: none;
}

.device_setting .setting_main .setting_main_mid .setting_video_reversal {
	display: flex;
    align-items: center;
    padding: 0 0 12px;
    width: 300px;
    justify-content: space-between;
}

.device_setting .setting_main .setting_main_mid .setting_video_reversal > span {
	font-size: 14px;
    color: rgba(0, 0, 0, 1);
}

.toggleSwitch {
	width: 50px;
    height: 26px;
    display: block;
    position: relative;
    border-radius: 15px;
    background-color: rgba(209, 209, 209, 1);
    cursor: pointer;
    box-shadow: inset 0px 0px 8px rgba(34, 34, 34, 0.08);

	transition: all 0.2s ease-in;
}

.toggleButton {
	width: 20px;
    height: 20px;
    position: absolute;
    top: 50%;
    left: 4px;
    transform: translateY(-50%);
    background: #fff;
    box-shadow: 2px 3px 10px rgba(34, 34, 34, 0.08);
    border-radius: 15px;

	transition: all 0.2s ease-in;
}

#reversal:checked ~ .toggleSwitch {
	background: rgba(251, 140, 0, 1);
}

#reversal:checked ~ .toggleSwitch .toggleButton {
	left: calc(100% - 24px);
	background: #fff;
}

.toggleSwitch, .toggleButton {
	transition: all 0.2s ease-in;
}

.device_setting .setting_main .setting_main_bot {
	display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.device_setting .setting_main .setting_main_bot > div {
	display: flex;
    justify-content: space-between;
    align-items: center;

	margin: 0 0 15px;

	width: 100%;
}

.device_setting .setting_main .setting_main_bot > div:last-child {
	margin: 0;
}

.device_setting .setting_main .setting_main_bot > div.mic_test {
	width: 50%;
}

.device_setting .setting_main .setting_main_bot > div.mic_test span {
	font-size: 14px;
    color: rgba(34, 34, 34, .6);
}

.device_setting .setting_main .setting_main_bot > div.mic_test .mic_test_bar_bg {
	width: 180px;
    height: 4px;
    background: rgba(238, 238, 238, 1);
    border-radius: 2px;
}

.device_setting .setting_main .setting_main_bot > div.mic_test .mic_test_bar_bg .mic_test_bar {
	height: 4px;
    background: transparent linear-gradient(90deg, rgba(251, 140, 0, 1) 0%, rgba(254, 227, 194, 1) 100%) 0% 0% no-repeat padding-box;
    border-radius: 2px;


	width: 50px;

}

.device_setting .setting_main .setting_main_bot > div span {
	font-size: 16px;
    color: #000;
}

.device_setting .setting_main .setting_main_bot > div select {
	width: 50%;
    height: 36px;
    outline: none;
    border: 1px solid rgba(34, 34, 34, 0.2);
    border-radius: 8px;
    color: rgba(34, 34, 34, 1);
    font-size: 16px;
    padding: 0 0 0 8px;
}


/* <!-- 클래스룸 게임 팝업 --> */
.game_popup_bg {
	position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #22222233;
    z-index: 100000;

}

.game_popup {
	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, .9);
    border: 1px solid rgba(34, 34, 34, 1);
    border-radius: 15px;
}

.game_start_popup {
	width: 452px;
}

.game_popup_header {
	height: 40px;
    background: linear-gradient(180deg, rgba(0, 168, 250, 1) 0%, rgba(126, 213, 255, 1) 100%);
    border-radius: 15px 15px 0px 0px;
    display: flex;
    align-items: center;
    justify-content: center;

	padding: 0 24px;
}

.game_popup_header strong {
	color: #fff;
    font-size: 18px;

	font-weight: 700;
}

.game_popup_main {
	padding: 20px 24px 40px;

	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;


}

.game_popup_main_cont {
	background: rgba(0, 168, 250, .3);
    border-radius: 15px;
    padding: 20px 24px;
	text-align: center;
    margin: 0 0 30px;

	width: 100%;
}

.game_popup_main_cont p {
	color: rgba(34, 34, 34, 1);
	font-size: 18px;
}

#game_start_btn {
	border: 1px solid rgba(34, 34, 34, 1);
    background: linear-gradient(180deg, rgba(255, 255, 255, .9) 0%, rgba(235, 235, 235, .9) 100%);
    border-radius: 8px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(0, 0, 0, 1);
    font-size: 20px;
    font-weight: 700;

	width: 318px;

	transition: all 0.3s ease;
}

#game_start_btn:hover {
	background: transparent linear-gradient(180deg, rgba(0, 168, 250, 0) 50%, rgba(0, 168, 250, .9) 105%);
	color: rgba(0, 168, 250, 1);
}

#game_wait_popup,
#game_wait_popup_mo {

	position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
	z-index: 1111111111;
}

.game_wait_popup {
	width: 400px;
    background: linear-gradient(90deg, rgba(34, 34, 34, 0) 0%, rgba(34, 34, 34, 0.8) 25%, rgba(34, 34, 34, 0.8) 77%, rgba(34, 34, 34, 0) 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 16px 0;
}

.game_wait_popup_bg {
	margin: 0 0 8px;
    width: 200px;
    height: 50px;
    background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, rgba(0, 168, 250, 1) 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    background-clip: text;
    -webkit-background-clip: text;
    text-align: center;
}

.game_wait_popup_bg #game_wait_num {
	font-size: 33px;
    color: transparent;
}

.game_wait_popup_bottom {
	width: 242px;
    height: 52px;
    background: rgba(34, 34, 34, .6);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.game_wait_popup_bottom p {
	color: #fff;
    font-size: 16px;
}


.game_test_popup {
	width: 700px;
}

.game_test_popup .game_popup_header {
	padding: 0 24px;
    justify-content: flex-start;
}

.game_test_answer_wrap {
	display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 22px;
    width: 100%;

	grid-auto-rows: 1fr;
}

.game_test_answer_box {
	/* height: 78px; */
    border: 1px solid rgba(34, 34, 34, .9);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(0, 0, 0, 1);


	transition: all 0.3s ease;
}


.game_test_answer_btn {
	width: 100%;
    height: 100%;
    font-size: 18px;
    color: rgba(0, 0, 0, 1);
    font-weight: 700;

	background: #fff;
    border-radius: 15px;

	padding: 30px;

	transition: all 0.3s ease;

	line-height: 1.4;
}

.game_test_answer_btn:hover {
	background: linear-gradient(180deg, rgba(0, 168, 250, 0) 50%, rgba(0, 168, 250, .9) 105%);
	color: rgba(0, 168, 250, 1);
}


/* <!-- ********* #game_test_input_popup ********* --> */
.game_test_input_wrap {
	width: 520px;
    height: 80px;
    border: 1px solid rgba(34, 34, 34, .9);
    border-radius: 15px;
    position: relative;
    display: flex;
    align-items: center;
    padding: 0 24px;
    background: linear-gradient(180deg, #FFFFFF 0%, #EBEBEB 100%);
    opacity: 0.9;

	justify-content: space-between;
}

.game_test_input_wrap .game_test_input_box {
	width: 420px;
    height: 30px;
}

.game_test_input_wrap .game_test_input_box input {
	width: 100%;
    height: 100%;
    font-size: 24px;
    font-weight: 500;
    color: #000;
    border: none;
    background: none;
}

.game_test_input_wrap .game_test_input_box input:active,
.game_test_input_wrap .game_test_input_box input:focus {
	outline: none;
}

.game_test_input_wrap .game_test_input_btn_box {
	width: 48px;
    height: 48px;
    border: 1px solid rgba(34, 34, 34, 1);
    background: linear-gradient(180deg, #FFFFFF 0%, #EBEBEB 100%);

	border-radius: 8px;
}

.game_test_input_wrap .game_test_input_btn_box button {
	width: 100%;
    height: 100%;
    font-size: 0;

	background: url("data:image/svg+xml,%3Csvg id='enter' xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Crect id='사각형_4218' data-name='사각형 4218' width='32' height='32' fill='none'/%3E%3Cpath id='패스_1504' data-name='패스 1504' d='M9.477,22c.682.674,1.376,1.337,2.042,2.027a1.573,1.573,0,0,1-.341,2.526A1.541,1.541,0,0,1,9.261,26.3c-.494-.473-.969-.965-1.453-1.448q-1.7-1.7-3.41-3.41a1.647,1.647,0,0,1,0-2.289Q6.8,16.74,9.206,14.34a1.547,1.547,0,0,1,1.592-.465,1.584,1.584,0,0,1,1.166,1.231,1.525,1.525,0,0,1-.472,1.485c-.578.585-1.163,1.165-1.744,1.747-.087.088-.169.18-.294.315.16.011.265.026.371.026q7.482,0,14.962,0a1.586,1.586,0,0,0,1.805-1.825c0-2.1,0-4.2,0-6.305A1.5,1.5,0,0,1,27.748,9a1.626,1.626,0,0,1,1.878.794,2.072,2.072,0,0,1,.206.873c.017,2.127.027,4.254,0,6.381A4.751,4.751,0,0,1,24.9,21.906q-7.481.015-14.962,0H9.529c-.018.031-.035.062-.052.093' transform='translate(-0.894 -1.862)' fill='%23222'/%3E%3C/svg%3E%0A") center center no-repeat;
}

/* <!-- ********* #game_top_fixed_box ********* --> */
#game_top_fixed_box {
	position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
}

.game_top_fixed_box {
	width: 220px;
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 13px 0;

	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='224' height='102' viewBox='0 0 224 102'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.5' x2='0.5' y2='1' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%235400ff' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%235400ff'/%3E%3C/linearGradient%3E%3ClinearGradient id='linear-gradient-2' x1='0.608' y1='-0.051' x2='0.276' y2='1.166' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%237734ff' stop-opacity='0.6'/%3E%3Cstop offset='1' stop-color='%23747bfe' stop-opacity='0.6'/%3E%3C/linearGradient%3E%3ClinearGradient id='linear-gradient-3' x1='0.204' y1='1.027' x2='0.465' y2='0.381' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%235120ff'/%3E%3Cstop offset='1' stop-color='%237c3bff'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg id='그룹_858' data-name='그룹 858' transform='translate(-578 -95)'%3E%3Cpath id='_1_맨_아래' data-name='1 맨 아래' d='M0,0H220a0,0,0,0,1,0,0V40a10,10,0,0,1-10,10H10A10,10,0,0,1,0,40V0A0,0,0,0,1,0,0Z' transform='translate(580 145)' fill='url(%23linear-gradient)'/%3E%3Cpath id='_2_' data-name='2 ' d='M0,0H220a0,0,0,0,1,0,0V90a10,10,0,0,1-10,10H10A10,10,0,0,1,0,90V0A0,0,0,0,1,0,0Z' transform='translate(580 95)' fill='url(%23linear-gradient-2)'/%3E%3Cpath id='_3_선_그라데이션_' data-name='3 선 그라데이션 ' d='M2,2V90a10.011,10.011,0,0,0,10,10H212a10.011,10.011,0,0,0,10-10V2H2M0,0H224V90a12,12,0,0,1-12,12H12A12,12,0,0,1,0,90Z' transform='translate(578 95)' fill='url(%23linear-gradient-3)'/%3E%3Cg id='_4_흰색_선' data-name='4 흰색 선' transform='translate(580 97)' fill='none' stroke='%23fff' stroke-width='2' opacity='0.5'%3E%3Cpath d='M0,0H220a0,0,0,0,1,0,0V88a10,10,0,0,1-10,10H10A10,10,0,0,1,0,88V0A0,0,0,0,1,0,0Z' stroke='none'/%3E%3Cpath d='M1,1H219a0,0,0,0,1,0,0V88a9,9,0,0,1-9,9H10a9,9,0,0,1-9-9V1A0,0,0,0,1,1,1Z' fill='none'/%3E%3C/g%3E%3Cellipse id='타원_109' data-name='타원 109' cx='4' cy='2' rx='4' ry='2' transform='matrix(0.966, -0.259, 0.259, 0.966, 584.619, 103.104)' fill='%23fff' opacity='0.4'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;

	background-size: cover;
	justify-content: space-between;

	z-index: 1;
    position: relative;
}

.game_top_fixed_test_num_box {
	width: 80px;
    height: 24px;
    background: rgba(255, 255, 255, .2);
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.game_top_fixed_test_num {
	color: rgba(255, 255, 255, .9);
    font-size: 16px;
    font-weight: 500;
}

.game_top_fixed_test_time_box {
	background: rgba(34, 34, 34, .4);
    width: 160px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.game_top_fixed_test_time {
	color: #fff;
    font-size: 32px;
    font-weight: 700;
}

.game_top_fixed_box_bg {

	width: 220px;
    height: 100px;
    position: absolute;
    top: 5px;
    right: 5px;
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='220' height='98' viewBox='0 0 220 98'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.221' y1='0.468' x2='0.105' y2='0.985' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23fff' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%23fff'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath id='그래픽' d='M2,2V88a8.009,8.009,0,0,0,8,8H210a8.009,8.009,0,0,0,8-8V2H2M0,0H220V88a10,10,0,0,1-10,10H10A10,10,0,0,1,0,88Z' opacity='0.5' fill='url(%23linear-gradient)'/%3E%3C/svg%3E%0A") center center no-repeat;
}

.game_top_fixed_box_bg_2 {

	width: 220px;
    height: 100px;
    position: absolute;
    top: 9px;
    right: 9px;
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='220' height='98' viewBox='0 0 220 98'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.304' y1='0.5' x2='0.145' y2='1.133' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23fff' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%23fff'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath id='그래픽' d='M2,2V84A12,12,0,0,0,14,96H206a12,12,0,0,0,12-12V2H2M0,0H220V84a14,14,0,0,1-14,14H14A14,14,0,0,1,0,84Z' opacity='0.5' fill='url(%23linear-gradient)'/%3E%3C/svg%3E%0A") center center no-repeat;
}


/* <!-- ********* #game_over_box ********* --> */
.border_box {
	border: none;
    box-shadow: 0px 3px 20px rgba(0, 168, 250, 0.08);

	background: #fff;
}

.game_over_box {
	width: 340px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 24px 24px;
}

.game_over_box p {
	text-align: center;
    color: rgba(34, 34, 34, 1);
    font-size: 18px;
    font-weight: 500;
    margin: 0 0 24px;
}

.game_over_box_btn {
	width: 100%;
    display: flex;
	height: 40px;

	justify-content: center;
}

.game_over_box_btn > * + * {
	margin-left: 10px;
}


.game_over_box_btn button.game_over_box_btn1 {
	width: 140px;
	text-shadow: none;
    box-shadow: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;

	color: rgba(255, 255, 255, 1);


    background: transparent linear-gradient(90deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;

    overflow: hidden;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    position: relative;
}

.game_over_box_btn button.game_over_box_btn1:hover {
    background: transparent linear-gradient(270deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;
}

.game_over_box_btn button.game_over_box_btn1::after {
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

.game_over_box_btn button.game_over_box_btn1:hover::after {
    left: 100%;

}

.game_over_box_btn button.game_over_box_btn2 {
    width: 140px;
    height: 40px;
    text-shadow: none;
    background: #fff;
    box-shadow: none;
    border: 1px solid rgba(34, 34, 34, 0.2);
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    color: rgba(34, 34, 34, .6);
}

.game_over_box_btn button.game_over_box_btn2:hover {
    background: rgba(34, 34, 34, 0.03);
}

/* <!-- ********* #game_ing_box ********* --> */
.game_over_box .game_ing_box_p
 {
	margin: 0 0 40px;
}

.game_ing_box_btn button {
    width: 290px;
    height: 40px;
    text-shadow: none;
    background: #fff;
    box-shadow: none;
    border: 1px solid rgba(34, 34, 34, 0.2);
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    color: rgba(34, 34, 34, .6);
}

.game_ing_box_btn button:hover {
    background: rgba(34, 34, 34, 0.03);
}


/* <!-- ********* #game_complete_box ********* --> */

.game_complete_box_btn button {
	width: 290px;
	height: 40px;
	text-shadow: none;
    box-shadow: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;

	color: rgba(255, 255, 255, 1);

    background: transparent linear-gradient(90deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;

    overflow: hidden;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    position: relative;
}

.game_complete_box_btn button:hover {
    background: transparent linear-gradient(270deg, #006CFA 0%, #00A8FA 100%) 0% 0% no-repeat padding-box;
}

.game_complete_box_btn button::after {
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

.game_complete_box_btn button:hover::after {
    left: 100%;

}

/* <!-- ********* #game_correct_answer_popup ********* --> */
.game_answer_popup {
	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 500px;
    height: 330px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#game_correct_answer_popup {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='382' height='382' viewBox='0 0 382 382'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.511' y1='0.072' x2='0.5' y2='0.952' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%2300c2ff'/%3E%3Cstop offset='1' stop-color='%232930ff' stop-opacity='0.8'/%3E%3C/linearGradient%3E%3Cfilter id='타원_110' x='0' y='0' width='382' height='382' filterUnits='userSpaceOnUse'%3E%3CfeOffset dx='2' dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='10' result='blur'/%3E%3CfeFlood flood-color='%2378fff4' flood-opacity='0.502'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='O_icon' transform='translate(-864 -329)'%3E%3Cg transform='matrix(1, 0, 0, 1, 864, 329)' filter='url(%23타원_110)'%3E%3Cpath id='타원_110-2' data-name='타원 110' d='M160,40A120,120,0,1,0,280,160,120.136,120.136,0,0,0,160,40m0-40A160,160,0,1,1,0,160,160,160,0,0,1,160,0Z' transform='translate(29 30)' stroke='%2300a8fa' stroke-width='2' fill='url(%23linear-gradient)'/%3E%3C/g%3E%3Cg id='타원_111' data-name='타원 111' transform='translate(893 359)' fill='none' stroke='%2378fff4' stroke-width='6' opacity='0.6'%3E%3Ccircle cx='159.5' cy='159.5' r='159.5' stroke='none'/%3E%3Ccircle cx='159.5' cy='159.5' r='156.5' fill='none'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
	/* background-size: cover; */
}

.game_answer_popup_box  {
	width: 480px;
    background: linear-gradient(90deg, rgba(34, 34, 34, 0) 0%, rgba(34, 34, 34, 0.8) 25%, rgba(34, 34, 34, 0.8) 77%, rgba(34, 34, 34, 0) 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 16px 0;
}

.correct_answer .game_answer_popup_img {
	width: 70px;
	height: 36px;

	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='70' height='36' viewBox='0 0 70 36'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.472' y1='0.973' x2='0.468' y2='0.191' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%2300c2ff'/%3E%3Cstop offset='1' stop-color='%23fff'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg id='그룹_809' data-name='그룹 809' transform='translate(-1018 -446)'%3E%3Crect id='사각형_4191' data-name='사각형 4191' width='70' height='36' transform='translate(1018 446)' fill='none'/%3E%3Cpath id='패스_1498' data-name='패스 1498' d='M15.264,5.152c6.5,0,10.656-2.24,10.656-6.4s-4.16-6.4-10.656-6.4S4.608-5.408,4.608-1.248,8.768,5.152,15.264,5.152ZM18.048-23.36H2.176v3.584h5.7C7.68-16.8,4.768-12.96.256-10.656L2.848-7.808a18.653,18.653,0,0,0,7.36-6.912,17.178,17.178,0,0,0,6.88,5.888L19.264-11.9c-3.9-1.856-6.752-4.672-6.912-7.872h5.7Zm-1.216,8.7h4.224v6.848h4.288v-16.48H21.056v6.048H16.832ZM15.264-4.064c4.256,0,6.24,1.024,6.24,2.816s-1.984,2.816-6.24,2.816S9.024.544,9.024-1.248,11.008-4.064,15.264-4.064Zm23.712-4.32H34.688V4.192h19.2V-8.384H49.6v3.008H38.976ZM35.9-19.84H45.952v-3.52H31.616v12.544h6.752a68.379,68.379,0,0,0,10.176-.608v-3.392a72.693,72.693,0,0,1-10.176.48H35.9ZM53.952-9.6v-6.144h3.712v-3.712H53.952v-4.832H49.664V-9.6ZM38.976.608V-1.92H49.6V.608Zm23.232-24.16.64,19.36h3.968l.64-19.36ZM67.744,1.056a2.912,2.912,0,0,0-5.824,0,2.912,2.912,0,0,0,5.824,0Z' transform='translate(1018 473)' fill='url(%23linear-gradient)'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;

	margin: 0 0 12px;
}

.game_answer_popup_bottom {
    border-radius: 10px;
    width: 400px;
    /* height: 95px; */
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(34, 34, 34, .6);
    padding: 12px 24px;
}

.game_answer_popup_bottom p {
	color: #fff;
    font-size: 16px;
    text-align: center;
    word-break: keep-all;
}

.correct_answer_bg {
	width: 500px;
    height: 330px;

	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='515' height='343.573' viewBox='0 0 515 343.573'%3E%3Cdefs%3E%3Cfilter id='패스_1508' x='72.425' y='0' width='69.149' height='78.454' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1509' x='375.155' y='261.573' width='69.149' height='78.454' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-2'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-2'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1495' x='52.311' y='262.353' width='50.114' height='54.894' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-3'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-3'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1496' x='34.367' y='247.573' width='50.114' height='54.894' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-4'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-4'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1510' x='0' y='41.227' width='88.734' height='102.693' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-5'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-5'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1492' x='383.425' y='44' width='69.149' height='78.454' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-6'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-6'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1493' x='408.816' y='33.921' width='54.367' height='60.159' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-7'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-7'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='반짝이' transform='translate(-765 -337.427)'%3E%3Crect id='사각형_4221' data-name='사각형 4221' width='500' height='330' transform='translate(780 351)' fill='none'/%3E%3Cg transform='matrix(1, 0, 0, 1, 765, 337.43)' filter='url(%23패스_1508)'%3E%3Cpath id='패스_1508-2' data-name='패스 1508' d='M45.447,24.227c-18.544.7-19.006,1.275-19.575,24.227C25.3,25.5,24.842,24.931,6.3,24.227,24.842,23.523,25.3,22.952,25.873,0c.569,22.952,1.03,23.523,19.575,24.227' transform='translate(81.13 14)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 765, 337.43)' filter='url(%23패스_1509)'%3E%3Cpath id='패스_1509-2' data-name='패스 1509' d='M45.447,24.227c-18.544.7-19.006,1.275-19.575,24.227C25.3,25.5,24.842,24.931,6.3,24.227,24.842,23.523,25.3,22.952,25.873,0c.569,22.952,1.03,23.523,19.575,24.227' transform='translate(383.86 275.57)' fill='%23fff'/%3E%3C/g%3E%3Cg id='그룹_858' data-name='그룹 858' transform='translate(-33)'%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1495)'%3E%3Cpath id='패스_1495-2' data-name='패스 1495' d='M26.412,12.447c-9.528.362-9.765.655-10.057,12.447C16.063,13.1,15.826,12.809,6.3,12.447c9.528-.362,9.765-.655,10.057-12.447.292,11.792.529,12.085,10.057,12.447' transform='translate(61.01 276.35)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1496)'%3E%3Cpath id='패스_1496-2' data-name='패스 1496' d='M26.412,12.447c-9.528.362-9.765.655-10.057,12.447C16.063,13.1,15.826,12.809,6.3,12.447c9.528-.362,9.765-.655,10.057-12.447.292,11.792.529,12.085,10.057,12.447' transform='translate(43.07 261.57)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 765, 337.43)' filter='url(%23패스_1510)'%3E%3Cpath id='패스_1510-2' data-name='패스 1510' d='M65.032,36.346C37.211,37.4,36.519,38.259,35.665,72.693,34.811,38.259,34.119,37.4,6.3,36.346,34.119,35.29,34.811,34.434,35.665,0c.854,34.434,1.546,35.29,29.367,36.346' transform='translate(8.7 55.23)' fill='%23fff'/%3E%3C/g%3E%3Cg id='그룹_859' data-name='그룹 859' transform='translate(-33)'%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1492)'%3E%3Cpath id='패스_1492-2' data-name='패스 1492' d='M45.447,24.227c-18.544.7-19.006,1.275-19.575,24.227C25.3,25.5,24.842,24.931,6.3,24.227,24.842,23.523,25.3,22.952,25.873,0c.569,22.952,1.03,23.523,19.575,24.227' transform='translate(392.13 58)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1493)'%3E%3Cpath id='패스_1493-2' data-name='패스 1493' d='M30.665,15.079c-11.542.438-11.829.794-12.184,15.079C18.127,15.873,17.84,15.518,6.3,15.079,17.84,14.641,18.127,14.286,18.482,0c.354,14.286.641,14.641,12.184,15.079' transform='translate(417.52 47.92)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;

	position: absolute;
    top: 0;
    left: 0;
}

.answer_btn {
	position: absolute;
	right: 0;
    top: 80px;

	width: 40px;
	height: 40px;

	/* border: 2px solid rgba(0, 168, 250, 1);

	border-radius: 50%; */
	/* background: #fff; */
}

.answer_btn #correct_answer_btn {
	font-size: 0;

	width: 100%;
    height: 100%;

	background: #fff;

	background-image: url("data:image/svg+xml,%3Csvg id='cancel_icon' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_3929' data-name='사각형 3929' width='24' height='24' fill='none'/%3E%3Cg id='그룹_561' data-name='그룹 561' transform='translate(5 5.033)'%3E%3Cpath id='패스_1187' data-name='패스 1187' d='M0,0,.046,19.752' transform='translate(0 0) rotate(-45)' fill='none' stroke='%2300a8fa' stroke-linecap='round' stroke-width='3'/%3E%3Cpath id='패스_1188' data-name='패스 1188' d='M.046,0,0,19.752' transform='translate(13.967 -0.032) rotate(45)' fill='none' stroke='%2300a8fa' stroke-linecap='round' stroke-width='3'/%3E%3C/g%3E%3C/svg%3E%0A");


	background-repeat: no-repeat;
	background-position: center center;


	border: 2px solid rgba(0, 168, 250, 1);

	border-radius: 50%;
}


.answer_btn #correct_answer_btn:hover {

	background-image: url("data:image/svg+xml,%3Csvg id='구성_요소_548_33' data-name='구성 요소 548 – 33' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='40' height='40' viewBox='0 0 40 40'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Ccircle id='타원_114' data-name='타원 114' cx='20' cy='20' r='20' transform='translate(1253 409)' fill='rgba(255,255,255,0.8)' stroke='%2300a8fa' stroke-width='1'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='마스크_그룹_48' data-name='마스크 그룹 48' transform='translate(-1253 -409)' opacity='0.4' clip-path='url(%23clip-path)'%3E%3Crect id='사각형_4192' data-name='사각형 4192' width='40' height='21' transform='translate(1253 429)' fill='%2300a8fa'/%3E%3C/g%3E%3Cg id='타원_112' data-name='타원 112' fill='rgba(0,168,250,0.6)' stroke='%2300a8fa' stroke-width='2'%3E%3Ccircle cx='20' cy='20' r='20' stroke='none'/%3E%3Ccircle cx='20' cy='20' r='19' fill='none'/%3E%3C/g%3E%3Cg id='cancel_icon' transform='translate(8 8)'%3E%3Crect id='사각형_3929' data-name='사각형 3929' width='24' height='24' fill='none'/%3E%3Cg id='그룹_561' data-name='그룹 561' transform='translate(5 5.033)'%3E%3Cpath id='패스_1187' data-name='패스 1187' d='M0,0,.046,19.752' transform='translate(0 0) rotate(-45)' fill='none' stroke='%23fff' stroke-linecap='round' stroke-width='3'/%3E%3Cpath id='패스_1188' data-name='패스 1188' d='M.046,0,0,19.752' transform='translate(13.967 -0.032) rotate(45)' fill='none' stroke='%23fff' stroke-linecap='round' stroke-width='3'/%3E%3C/g%3E%3C/g%3E%3Cg id='타원_113' data-name='타원 113' transform='translate(1 1)' fill='none' stroke='%23fff' stroke-width='1' opacity='0.2'%3E%3Ccircle cx='19' cy='19' r='19' stroke='none'/%3E%3Ccircle cx='19' cy='19' r='18.5' fill='none'/%3E%3C/g%3E%3C/svg%3E%0A");

	background-repeat: no-repeat;
	background-position: center center;
}

/* <!-- ********* #game_incorrect_answer_popup ********* --> */

#game_incorrect_answer_popup {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='328.275' height='328.277' viewBox='0 0 328.275 328.277'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.5' y1='1.013' x2='0.5' y2='-0.015' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23ff3434' stop-opacity='0.8'/%3E%3Cstop offset='1' stop-color='%23fb8c00'/%3E%3C/linearGradient%3E%3Cfilter id='합치기_26' x='0' y='0' width='328.275' height='328.277' filterUnits='userSpaceOnUse'%3E%3CfeOffset dx='2' dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='10' result='blur'/%3E%3CfeFlood flood-color='%23ff3434' flood-opacity='0.502'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='그룹_814' data-name='그룹 814' transform='translate(-425.862 -429.862)'%3E%3Cg id='그룹_812' data-name='그룹 812' transform='translate(-99 -329)'%3E%3Cg id='그룹_810' data-name='그룹 810' transform='translate(-325.922 49.179)'%3E%3Cg transform='matrix(1, 0, 0, 1, 850.78, 709.68)' filter='url(%23합치기_26)'%3E%3Cpath id='합치기_26-2' data-name='합치기 26' d='M-11885.661-9796.476l-99-99-98.994,98.994a20,20,0,0,1-28.284,0,20,20,0,0,1,0-28.284l98.994-98.993-98.994-98.994a20,20,0,0,1,0-28.285,20,20,0,0,1,28.284,0l99,98.994,99-98.994a20,20,0,0,1,28.284,0,20,20,0,0,1,0,28.282l-99,99,99,99a20,20,0,0,1,0,28.287,19.939,19.939,0,0,1-14.143,5.858A19.934,19.934,0,0,1-11885.661-9796.476Z' transform='translate(12146.79 10086.89)' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2' fill='url(%23linear-gradient)'/%3E%3C/g%3E%3C/g%3E%3Crect id='사각형_4193' data-name='사각형 4193' width='320' height='320' transform='translate(527 762)' fill='none'/%3E%3C/g%3E%3Cg id='그룹_813' data-name='그룹 813' transform='translate(-99 -329)'%3E%3Cg id='그룹_810-2' data-name='그룹 810' transform='translate(-325.922 49.179)'%3E%3Cg id='합치기_26-3' data-name='합치기 26' transform='translate(12997.578 10796.578)' fill='none' stroke-linecap='round' opacity='0.6'%3E%3Cpath d='M-11885.717-9797.539l-98.989-98.989-98.919,98.919c-7.768,7.768-20.149,7.978-27.653.472s-7.3-19.888.469-27.655l98.92-98.92-98.975-98.974c-7.773-7.771-7.975-20.174-.447-27.7s19.928-7.327,27.7.443l98.975,98.975,98.84-98.841c7.765-7.765,20.146-7.978,27.656-.471s7.293,19.891-.472,27.655l-98.84,98.84,98.989,98.99c7.771,7.773,7.968,20.173.443,27.7a18.9,18.9,0,0,1-13.441,5.519A20.154,20.154,0,0,1-11885.717-9797.539Z' stroke='none'/%3E%3Cpath d='M -11871.4599609375 -9795.576171875 L -11871.4609375 -9795.576171875 C -11867.4169921875 -9795.5771484375 -11863.6484375 -9797.1201171875 -11860.84765625 -9799.9228515625 C -11857.98046875 -9802.7900390625 -11856.4384765625 -9806.6484375 -11856.50390625 -9810.787109375 C -11856.5712890625 -9814.974609375 -11858.2705078125 -9818.9443359375 -11861.2900390625 -9821.96484375 L -11963.1083984375 -9923.783203125 L -11960.279296875 -9926.611328125 L -11861.439453125 -10025.451171875 C -11858.421875 -10028.4697265625 -11856.7197265625 -10032.4345703125 -11856.6484375 -10036.615234375 C -11856.578125 -10040.7451171875 -11858.1123046875 -10044.5927734375 -11860.9677734375 -10047.44921875 C -11863.7568359375 -10050.2373046875 -11867.509765625 -10051.7724609375 -11871.5361328125 -10051.7724609375 C -11873.609375 -10051.7724609375 -11875.642578125 -10051.3701171875 -11877.5791015625 -10050.5771484375 C -11879.591796875 -10049.7529296875 -11881.404296875 -10048.5419921875 -11882.9677734375 -10046.9794921875 L -11984.6357421875 -9945.3095703125 L -11987.4638671875 -9948.138671875 L -12086.4384765625 -10047.1123046875 C -12088.0009765625 -10048.6748046875 -12089.8134765625 -10049.884765625 -12091.8251953125 -10050.7080078125 C -12093.7626953125 -10051.5009765625 -12095.7958984375 -10051.90234375 -12097.87109375 -10051.90234375 C -12101.9130859375 -10051.90234375 -12105.681640625 -10050.359375 -12108.4833984375 -10047.5556640625 C -12111.3505859375 -10044.689453125 -12112.8935546875 -10040.83203125 -12112.826171875 -10036.693359375 C -12112.7587890625 -10032.5048828125 -12111.0576171875 -10028.5361328125 -12108.0361328125 -10025.5146484375 L -12006.232421875 -9923.712890625 L -12009.0615234375 -9920.884765625 L -12107.9814453125 -9821.96484375 C -12111 -9818.9453125 -12112.7021484375 -9814.98046875 -12112.7734375 -9810.80078125 C -12112.8427734375 -9806.671875 -12111.3076171875 -9802.82421875 -12108.44921875 -9799.9658203125 C -12105.662109375 -9797.177734375 -12101.9111328125 -9795.642578125 -12097.8857421875 -9795.6435546875 C -12095.8125 -9795.6435546875 -12093.779296875 -9796.0458984375 -12091.8427734375 -9796.8388671875 C -12089.830078125 -9797.6630859375 -12088.0166015625 -9798.8740234375 -12086.453125 -9800.4375 L -11984.7060546875 -9902.185546875 L -11981.8779296875 -9899.3564453125 L -11882.8876953125 -9800.3671875 C -11881.3251953125 -9798.8046875 -11879.513671875 -9797.5947265625 -11877.5029296875 -9796.7705078125 C -11875.5673828125 -9795.978515625 -11873.5341796875 -9795.576171875 -11871.4599609375 -9795.576171875 M -11871.4599609375 -9791.576171875 C -11876.576171875 -9791.576171875 -11881.7490234375 -9793.5703125 -11885.716796875 -9797.5390625 L -11984.7060546875 -9896.5283203125 L -12083.625 -9797.609375 C -12091.3916015625 -9789.8427734375 -12103.7724609375 -9789.6298828125 -12111.2783203125 -9797.1376953125 C -12118.787109375 -9804.6474609375 -12118.5771484375 -9817.025390625 -12110.8095703125 -9824.79296875 L -12011.8896484375 -9923.712890625 L -12110.8642578125 -10022.6865234375 C -12118.6376953125 -10030.4580078125 -12118.8388671875 -10042.8603515625 -12111.3115234375 -10050.384765625 C -12103.7880859375 -10057.9130859375 -12091.3837890625 -10057.712890625 -12083.6103515625 -10049.94140625 L -11984.6357421875 -9950.966796875 L -11885.7958984375 -10049.8076171875 C -11878.0322265625 -10057.5712890625 -11865.6484375 -10057.7861328125 -11858.1396484375 -10050.2783203125 C -11850.6337890625 -10042.76953125 -11850.8466796875 -10030.3876953125 -11858.611328125 -10022.623046875 L -11957.451171875 -9923.783203125 L -11858.4619140625 -9824.79296875 C -11850.69140625 -9817.01953125 -11850.494140625 -9804.6201171875 -11858.0185546875 -9797.0947265625 C -11861.701171875 -9793.41015625 -11866.5537109375 -9791.5771484375 -11871.4599609375 -9791.576171875 Z' stroke='none' fill='%23faa'/%3E%3C/g%3E%3C/g%3E%3Crect id='사각형_4193-2' data-name='사각형 4193' width='320' height='320' transform='translate(527 762)' fill='none'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
	/* background-size: cover; */
}

.correct_answer_bg {
	width: 500px;
    height: 330px;

	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='515' height='343.573' viewBox='0 0 515 343.573'%3E%3Cdefs%3E%3Cfilter id='패스_1508' x='72.425' y='0' width='69.149' height='78.454' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1509' x='375.155' y='261.573' width='69.149' height='78.454' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-2'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-2'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1495' x='52.311' y='262.353' width='50.114' height='54.894' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-3'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-3'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1496' x='34.367' y='247.573' width='50.114' height='54.894' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-4'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-4'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1510' x='0' y='41.227' width='88.734' height='102.693' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-5'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-5'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1492' x='383.425' y='44' width='69.149' height='78.454' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-6'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-6'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1493' x='408.816' y='33.921' width='54.367' height='60.159' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-7'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-7'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='반짝이' transform='translate(-765 -337.427)'%3E%3Crect id='사각형_4221' data-name='사각형 4221' width='500' height='330' transform='translate(780 351)' fill='none'/%3E%3Cg transform='matrix(1, 0, 0, 1, 765, 337.43)' filter='url(%23패스_1508)'%3E%3Cpath id='패스_1508-2' data-name='패스 1508' d='M45.447,24.227c-18.544.7-19.006,1.275-19.575,24.227C25.3,25.5,24.842,24.931,6.3,24.227,24.842,23.523,25.3,22.952,25.873,0c.569,22.952,1.03,23.523,19.575,24.227' transform='translate(81.13 14)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 765, 337.43)' filter='url(%23패스_1509)'%3E%3Cpath id='패스_1509-2' data-name='패스 1509' d='M45.447,24.227c-18.544.7-19.006,1.275-19.575,24.227C25.3,25.5,24.842,24.931,6.3,24.227,24.842,23.523,25.3,22.952,25.873,0c.569,22.952,1.03,23.523,19.575,24.227' transform='translate(383.86 275.57)' fill='%23fff'/%3E%3C/g%3E%3Cg id='그룹_858' data-name='그룹 858' transform='translate(-33)'%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1495)'%3E%3Cpath id='패스_1495-2' data-name='패스 1495' d='M26.412,12.447c-9.528.362-9.765.655-10.057,12.447C16.063,13.1,15.826,12.809,6.3,12.447c9.528-.362,9.765-.655,10.057-12.447.292,11.792.529,12.085,10.057,12.447' transform='translate(61.01 276.35)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1496)'%3E%3Cpath id='패스_1496-2' data-name='패스 1496' d='M26.412,12.447c-9.528.362-9.765.655-10.057,12.447C16.063,13.1,15.826,12.809,6.3,12.447c9.528-.362,9.765-.655,10.057-12.447.292,11.792.529,12.085,10.057,12.447' transform='translate(43.07 261.57)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 765, 337.43)' filter='url(%23패스_1510)'%3E%3Cpath id='패스_1510-2' data-name='패스 1510' d='M65.032,36.346C37.211,37.4,36.519,38.259,35.665,72.693,34.811,38.259,34.119,37.4,6.3,36.346,34.119,35.29,34.811,34.434,35.665,0c.854,34.434,1.546,35.29,29.367,36.346' transform='translate(8.7 55.23)' fill='%23fff'/%3E%3C/g%3E%3Cg id='그룹_859' data-name='그룹 859' transform='translate(-33)'%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1492)'%3E%3Cpath id='패스_1492-2' data-name='패스 1492' d='M45.447,24.227c-18.544.7-19.006,1.275-19.575,24.227C25.3,25.5,24.842,24.931,6.3,24.227,24.842,23.523,25.3,22.952,25.873,0c.569,22.952,1.03,23.523,19.575,24.227' transform='translate(392.13 58)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 798, 337.43)' filter='url(%23패스_1493)'%3E%3Cpath id='패스_1493-2' data-name='패스 1493' d='M30.665,15.079c-11.542.438-11.829.794-12.184,15.079C18.127,15.873,17.84,15.518,6.3,15.079,17.84,14.641,18.127,14.286,18.482,0c.354,14.286.641,14.641,12.184,15.079' transform='translate(417.52 47.92)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;

	position: absolute;
    top: 0;
    left: 0;
}

.incorrect_answer .game_answer_popup_img {
	width: 70px;
	height: 36px;

	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='70' height='36' viewBox='0 0 70 36'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.5' y1='0.305' x2='0.5' y2='1' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23fff'/%3E%3Cstop offset='1' stop-color='%23fb8c00'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg id='그룹_815' data-name='그룹 815' transform='translate(-1018 -446)'%3E%3Cpath id='패스_1499' data-name='패스 1499' d='M27.2,1.632V-2.016H16.192v-5.44c5.12-.7,8.48-3.9,8.48-8.256,0-4.928-4.32-8.384-10.688-8.384S3.3-20.64,3.3-15.712c0,4.352,3.328,7.552,8.48,8.256v5.44H.768V1.632ZM13.984-20.448c3.9,0,6.272,1.824,6.272,4.736s-2.368,4.736-6.272,4.736S7.712-12.8,7.712-15.712,10.08-20.448,13.984-20.448ZM38.976-8.384H34.688V4.192h19.2V-8.384H49.6v3.008H38.976ZM35.9-19.84H45.952v-3.52H31.616v12.544h6.752a68.379,68.379,0,0,0,10.176-.608v-3.392a72.693,72.693,0,0,1-10.176.48H35.9ZM53.952-9.6v-6.144h3.712v-3.712H53.952v-4.832H49.664V-9.6ZM38.976.608V-1.92H49.6V.608Zm23.232-24.16.64,19.36h3.968l.64-19.36ZM67.744,1.056a2.912,2.912,0,0,0-5.824,0,2.912,2.912,0,0,0,5.824,0Z' transform='translate(1018.744 473)' fill='url(%23linear-gradient)'/%3E%3Crect id='사각형_4194' data-name='사각형 4194' width='70' height='36' transform='translate(1018 446)' fill='none'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;

	margin: 0 0 12px;
}

.answer_btn #game_incorrect_answer_btn {
	font-size: 0;

	width: 100%;
    height: 100%;

	background: #fff;

	background-image: url("data:image/svg+xml,%3Csvg id='replay_icon' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_3984' data-name='사각형 3984' width='24' height='24' fill='none'/%3E%3Cpath id='패스_1207' data-name='패스 1207' d='M18.93,12.677c.181.205.351.381.5.572a1.587,1.587,0,0,1-.12,2.15,1.543,1.543,0,0,1-2.145.078Q15.2,13.6,13.323,11.633a1.465,1.465,0,0,1,.048-2.09Q15.263,7.59,17.217,5.7a1.589,1.589,0,0,1,2.245,2.245,11.411,11.411,0,0,1-1.119.94l.131.189c.157.043.311.09.469.129a8.776,8.776,0,0,1-1.958,17.321c-2.472.053-2.584.019-5.057.008a1.6,1.6,0,0,1-1.8-1.634,1.588,1.588,0,0,1,1.783-1.582c2.43-.013,2.5.021,4.929-.012a5.532,5.532,0,0,0,5.654-5.732,5.43,5.43,0,0,0-3.036-4.78,2.428,2.428,0,0,0-.352-.147c-.033-.011-.079.012-.174.03' transform='translate(-5.186 -4.019)' fill='%2300a8fa'/%3E%3C/svg%3E%0A");


	background-repeat: no-repeat;
	background-position: center center;


	border: 2px solid rgba(0, 168, 250, 1);

	border-radius: 50%;
}


.answer_btn #game_incorrect_answer_btn:hover {

	background-image: url("data:image/svg+xml,%3Csvg id='구성_요소_549_13' data-name='구성 요소 549 – 13' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='40' height='40' viewBox='0 0 40 40'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Ccircle id='타원_114' data-name='타원 114' cx='20' cy='20' r='20' transform='translate(1253 409)' fill='rgba(255,255,255,0.8)' stroke='%2300a8fa' stroke-width='1'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='마스크_그룹_48' data-name='마스크 그룹 48' transform='translate(-1253 -409)' opacity='0.4' clip-path='url(%23clip-path)'%3E%3Crect id='사각형_4192' data-name='사각형 4192' width='40' height='21' transform='translate(1253 429)' fill='%2300a8fa'/%3E%3C/g%3E%3Cg id='타원_112' data-name='타원 112' fill='rgba(0,168,250,0.6)' stroke='%2300a8fa' stroke-width='2'%3E%3Ccircle cx='20' cy='20' r='20' stroke='none'/%3E%3Ccircle cx='20' cy='20' r='19' fill='none'/%3E%3C/g%3E%3Cg id='타원_113' data-name='타원 113' transform='translate(1 1)' fill='none' stroke='%23fff' stroke-width='1' opacity='0.2'%3E%3Ccircle cx='19' cy='19' r='19' stroke='none'/%3E%3Ccircle cx='19' cy='19' r='18.5' fill='none'/%3E%3C/g%3E%3Cg id='replay_icon' transform='translate(8 8)'%3E%3Crect id='사각형_3984' data-name='사각형 3984' width='24' height='24' fill='none'/%3E%3Cpath id='패스_1207' data-name='패스 1207' d='M18.93,12.677c.181.205.351.381.5.572a1.587,1.587,0,0,1-.12,2.15,1.543,1.543,0,0,1-2.145.078Q15.2,13.6,13.323,11.633a1.465,1.465,0,0,1,.048-2.09Q15.263,7.59,17.217,5.7a1.589,1.589,0,0,1,2.245,2.245,11.411,11.411,0,0,1-1.119.94l.131.189c.157.043.311.09.469.129a8.776,8.776,0,0,1-1.958,17.321c-2.472.053-2.584.019-5.057.008a1.6,1.6,0,0,1-1.8-1.634,1.588,1.588,0,0,1,1.783-1.582c2.43-.013,2.5.021,4.929-.012a5.532,5.532,0,0,0,5.654-5.732,5.43,5.43,0,0,0-3.036-4.78,2.428,2.428,0,0,0-.352-.147c-.033-.011-.079.012-.174.03' transform='translate(-5.186 -4.019)' fill='%23fff'/%3E%3C/g%3E%3C/svg%3E%0A");

	background-repeat: no-repeat;
	background-position: center center;
}


/* ****** #game_start_popup_mo ****** */

#game_start_popup_mo .game_start_popup {
	width: 370px;
}

#game_start_popup_mo .game_start_popup .game_popup_header {
	height: 30px;
}

#game_start_popup_mo .game_start_popup .game_popup_header strong {
	font-size: 16px;
}

#game_start_popup_mo .game_popup_main_cont {
	padding: 10px 20px;
    margin: 0 0 20px;
}

#game_start_popup_mo .game_popup_main_cont p {
	font-size: 14px;
}

#game_start_popup_mo #game_start_btn {
	width: 180px;
    height: 38px;
    font-size: 16px;
}


/* ****** #game_wait_popup_mo ****** */

#game_wait_popup_mo .game_wait_popup {
	width: 290px;
}

#game_wait_popup_mo .game_wait_popup_bg {
	height: 40px;
}

#game_wait_popup_mo .game_wait_popup_bg #game_wait_num {
	font-size: 26px;
}

#game_wait_popup_mo ..game_wait_popup_bottom {
	width: 220px;
    height: 40px;
}

/* ****** #game_test_btn_popup_mo ****** */
#game_test_btn_popup_mo .game_test_popup {
	width: 400px;
}

#game_test_btn_popup_mo .game_popup_header {
	padding: 0 16px;
    height: 30px;
}

#game_test_btn_popup_mo .game_popup_header strong {
	font-size: 14px;
}

#game_test_btn_popup_mo .game_popup_main_cont {
	margin: 0 0 16px;
}

#game_test_btn_popup_mo .game_popup_main_cont p {
	font-size: 14px;
}

#game_test_btn_popup_mo .game_test_answer_wrap {
	gap: 16px;
}

#game_test_btn_popup_mo .game_test_answer_box {
	border-radius: 7px;
}

#game_test_btn_popup_mo .game_test_answer_box .game_test_answer_btn {
	font-size: 14px;
    padding: 14px;
	border-radius: 7px;
}

/* ****** #game_test_input_popup_mo ****** */

#game_test_input_popup_mo .game_test_popup {
	width: 380px;
}

#game_test_input_popup_mo .game_popup_header {
	padding: 0 16px;
    height: 30px;
}

#game_test_input_popup_mo .game_popup_header strong {
	font-size: 14px;
}

#game_test_input_popup_mo .game_popup_main_cont {
	margin: 0 0 16px;
}

#game_test_input_popup_mo .game_popup_main_cont p {
	font-size: 14px;
}


#game_test_input_popup_mo .game_test_input_wrap {
	padding: 0 12px;
    width: 100%;
    height: 44px;
}

#game_test_input_popup_mo .game_test_input_wrap .game_test_input_box {
	width: 270px;
    height: 16px;
}

#game_test_input_popup_mo .game_test_input_wrap .game_test_input_box input {
	font-size: 16px;
}

#game_test_input_popup_mo .game_test_input_wrap .game_test_input_box input::placeholder {
	font-size: 16px;
}

#game_test_input_popup_mo .game_test_input_wrap .game_test_input_btn_box {
	width: 32px;
    height: 32px;
}

#game_test_input_popup_mo .game_test_input_wrap .game_test_input_btn_box button {
	background-size: 24px;
}



/* ****** #game_top_fixed_box_mo ****** */
#game_top_fixed_box_mo {
	right: 0;
	position: fixed;
	top: 60px;
	z-index: 9999;
}

#game_top_fixed_box_mo .game_top_fixed_box {
	width: 180px;
    height: auto;
    justify-content: normal;
    padding: 15px 0;

	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='202' height='82' viewBox='0 0 202 82'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.5' x2='0.5' y2='1' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%235400ff' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%235400ff'/%3E%3C/linearGradient%3E%3ClinearGradient id='linear-gradient-2' x1='0.608' y1='-0.051' x2='0.276' y2='1.166' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%237734ff' stop-opacity='0.6'/%3E%3Cstop offset='1' stop-color='%23747bfe' stop-opacity='0.6'/%3E%3C/linearGradient%3E%3ClinearGradient id='linear-gradient-3' x1='0.197' y1='1.061' x2='0.69' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%235120ff'/%3E%3Cstop offset='1' stop-color='%237c3bff'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg id='그룹_1468' data-name='그룹 1468' transform='translate(-10332 -2670)'%3E%3Cpath id='사각형_4326' data-name='사각형 4326' d='M0,0H200a0,0,0,0,1,0,0V40a0,0,0,0,1,0,0H10A10,10,0,0,1,0,30V0A0,0,0,0,1,0,0Z' transform='translate(10333 2711)' fill='url(%23linear-gradient)'/%3E%3Cg id='그룹_1467' data-name='그룹 1467' transform='translate(9510 2585)'%3E%3Cpath id='사각형_4230' data-name='사각형 4230' d='M10,0H200a0,0,0,0,1,0,0V80a0,0,0,0,1,0,0H10A10,10,0,0,1,0,70V10A10,10,0,0,1,10,0Z' transform='translate(823 86)' fill='url(%23linear-gradient-2)'/%3E%3Cg id='사각형_4262' data-name='사각형 4262' transform='translate(823 86)' fill='none' stroke='%23fff' stroke-width='1' opacity='0.6'%3E%3Cpath d='M10,0H200a0,0,0,0,1,0,0V80a0,0,0,0,1,0,0H10A10,10,0,0,1,0,70V10A10,10,0,0,1,10,0Z' stroke='none'/%3E%3Cpath d='M10,.5H199.5a0,0,0,0,1,0,0v79a0,0,0,0,1,0,0H10A9.5,9.5,0,0,1,.5,70V10A9.5,9.5,0,0,1,10,.5Z' fill='none'/%3E%3C/g%3E%3Cpath id='사각형_4262-2' data-name='사각형 4262' d='M11,1A10.011,10.011,0,0,0,1,11V71A10.011,10.011,0,0,0,11,81H201V1H11m0-1H202V82H11A11,11,0,0,1,0,71V11A11,11,0,0,1,11,0Z' transform='translate(822 85)' fill='url(%23linear-gradient-3)'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
    background-size: contain;

}

#game_top_fixed_box_mo .game_top_fixed_test_num_box {
	height: 18px;
    width: 60px;
    margin: 0 0 10px;
}

#game_top_fixed_box_mo .game_top_fixed_test_num_box p {
	font-size: 13px;
}

#game_top_fixed_box_mo .game_top_fixed_test_time_box {
	width: 100px;
    height: 24px;
}

#game_top_fixed_box_mo .game_top_fixed_test_time_box p {
	font-size: 18px;
}

#game_top_fixed_box_mo .game_top_fixed_box_bg {

width: 180px;
height: 82px;
position: absolute;
top: 5px;
right: 5px;
background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='205' height='85' viewBox='0 0 205 85'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.233' y1='0.274' x2='0.106' y2='1.12' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23fff' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%23fff'/%3E%3C/linearGradient%3E%3ClinearGradient id='linear-gradient-2' x1='0.167' y1='0.45' x2='0.084' y2='1.127' xlink:href='%23linear-gradient'/%3E%3C/defs%3E%3Cg id='그룹_1276' data-name='그룹 1276' transform='translate(-814 -90)'%3E%3Cpath id='사각형_4262' data-name='사각형 4262' d='M14,1A13,13,0,0,0,1,14V68A13,13,0,0,0,14,81H188a13,13,0,0,0,13-13V14A13,13,0,0,0,188,1H14m0-1H188a14,14,0,0,1,14,14V68a14,14,0,0,1-14,14H14A14,14,0,0,1,0,68V14A14,14,0,0,1,14,0Z' transform='translate(817 90)' opacity='0.5' fill='url(%23linear-gradient)'/%3E%3Cpath id='사각형_4263' data-name='사각형 4263' d='M16,1A15,15,0,0,0,1,16V66A15,15,0,0,0,16,81H186a15,15,0,0,0,15-15V16A15,15,0,0,0,186,1H16m0-1H186a16,16,0,0,1,16,16V66a16,16,0,0,1-16,16H16A16,16,0,0,1,0,66V16A16,16,0,0,1,16,0Z' transform='translate(814 93)' opacity='0.5' fill='url(%23linear-gradient-2)'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;

background-size: contain;
}

#game_top_fixed_box_mo .game_top_fixed_box_bg_2 {

display: none;
}

/* ****** #game_over_box_mo, #game_ing_box_mo, #game_complete_box_mo ****** */
.asmo_mo .game_over_box {
	width: 250px;
    padding: 35px 20px 16px;
}

.asmo_mo .game_over_box p {
	font-size: 14px;
}


.asmo_mo .game_over_box .game_ing_box_p {
	margin: 0 0 30px;
}

.asmo_mo .game_over_box_btn {
	height: 30px;
}

.asmo_mo .game_over_box_btn button {
	height: 100%;
	font-size: 14px;
}

.asmo_mo .game_over_box_btn .game_over_box_btn1,
.asmo_mo .game_over_box_btn .game_over_box_btn2 {
	width: 100px;
}

.asmo_mo .game_over_box_btn button.game_over_box_btn1::after {
	height: 100%;
	width: 30px;
}

/* #game_correct_answer_popup_mo, #game_incorrect_answer_popup_mo */
.asmo_mo.game_answer_popup {
	width: 340px;
    height: 210px;
}

.asmo_mo .game_answer_popup_box {
	width: 340px;
    padding: 12px 0;
}

.asmo_mo .game_answer_popup_box .game_answer_popup_img {
	width: 50px;
    height: 25px;
    background-size: contain;
}

.asmo_mo .game_answer_popup_bottom {
	width: 280px;
    padding: 12px;
}

.asmo_mo .game_answer_popup_bottom p {
	font-size: 14px;
}

.asmo_mo .answer_btn {
	width: 32px;
    height: 32px;
	right: -12px;
    top: 16px;
}

/* .asmo_mo .answer_btn #correct_answer_btn {
	background-size: contain;
} */

#game_correct_answer_popup_mo {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='262' height='262' viewBox='0 0 262 262'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.511' y1='0.072' x2='0.5' y2='0.952' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%2300c2ff'/%3E%3Cstop offset='1' stop-color='%232930ff' stop-opacity='0.8'/%3E%3C/linearGradient%3E%3Cfilter id='타원_110' x='0' y='0' width='262' height='262' filterUnits='userSpaceOnUse'%3E%3CfeOffset dx='2' dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='10' result='blur'/%3E%3CfeFlood flood-color='%2378fff4' flood-opacity='0.502'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='O_icon' transform='translate(-864 -329)'%3E%3Cg transform='matrix(1, 0, 0, 1, 864, 329)' filter='url(%23타원_110)'%3E%3Cpath id='타원_110-2' data-name='타원 110' d='M100,25a75,75,0,1,0,75,75,75.085,75.085,0,0,0-75-75m0-25A100,100,0,1,1,0,100,100,100,0,0,1,100,0Z' transform='translate(29 30)' stroke='%2300a8fa' stroke-width='2' fill='url(%23linear-gradient)'/%3E%3C/g%3E%3Cg id='타원_111' data-name='타원 111' transform='translate(893.625 359.626)' fill='none' stroke='%2378fff4' stroke-width='3' opacity='0.6'%3E%3Ccircle cx='99.375' cy='99.375' r='99.375' stroke='none'/%3E%3Ccircle cx='99.375' cy='99.375' r='97.875' fill='none'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
	/* background-size: contain; */
}

#game_incorrect_answer_popup_mo {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='228.422' height='228.423' viewBox='0 0 228.422 228.423'%3E%3Cdefs%3E%3ClinearGradient id='linear-gradient' x1='0.5' y1='1.013' x2='0.5' y2='-0.015' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23ff3434' stop-opacity='0.8'/%3E%3Cstop offset='1' stop-color='%23fb8c00'/%3E%3C/linearGradient%3E%3Cfilter id='합치기_26' x='0' y='0' width='228.422' height='228.423' filterUnits='userSpaceOnUse'%3E%3CfeOffset dx='2' dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='10' result='blur'/%3E%3CfeFlood flood-color='%23ff3434' flood-opacity='0.502'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='그룹_814' data-name='그룹 814' transform='translate(-415.789 -419.789)'%3E%3Cg id='그룹_812' data-name='그룹 812' transform='translate(428 433)'%3E%3Cg id='그룹_810' data-name='그룹 810' transform='translate(16.789 16.789)'%3E%3Cg transform='matrix(1, 0, 0, 1, -29, -30)' filter='url(%23합치기_26)'%3E%3Cpath id='합치기_26-2' data-name='합치기 26' d='M145.083,162.762,83.21,100.889,21.339,162.76A12.5,12.5,0,0,1,3.661,145.083L65.533,83.211,3.661,21.34A12.5,12.5,0,0,1,21.339,3.662L83.211,65.534,145.083,3.662a12.5,12.5,0,0,1,17.678,17.676L100.889,83.21l61.872,61.872a12.5,12.5,0,1,1-17.678,17.679Z' transform='translate(29 30)' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2' fill='url(%23linear-gradient)'/%3E%3C/g%3E%3C/g%3E%3Crect id='사각형_4193' data-name='사각형 4193' width='200' height='200' fill='none'/%3E%3C/g%3E%3Cg id='그룹_813' data-name='그룹 813' transform='translate(428 433)'%3E%3Cg id='그룹_810-2' data-name='그룹 810' transform='translate(17.393 17.409)'%3E%3Cg id='합치기_26-3' data-name='합치기 26' fill='none' stroke-linecap='round' opacity='0.6'%3E%3Cpath d='M144.444,161.477,82.576,99.609,20.752,161.433a12.226,12.226,0,0,1-17.283.295,12.225,12.225,0,0,1,.293-17.285L65.586,82.619,3.728,20.76a12.243,12.243,0,0,1-.28-17.311,12.247,12.247,0,0,1,17.313.277L82.62,65.584,144.4,3.809a12.229,12.229,0,0,1,17.285-.294,12.229,12.229,0,0,1-.294,17.284L99.61,82.575l61.869,61.869a12.247,12.247,0,0,1,.277,17.312,11.81,11.81,0,0,1-8.4,3.449A12.6,12.6,0,0,1,144.444,161.477Z' stroke='none'/%3E%3Cpath d='M 153.3547058105469 162.2036285400391 C 155.7480621337891 162.2031402587891 157.9782409667969 161.2905731201172 159.6344299316406 159.6336669921875 C 163.1603393554688 156.1073913574219 163.0359954833984 150.2444763183594 159.3576965332031 146.5646667480469 L 95.36771392822266 82.57469940185547 L 159.2644348144531 18.67800712585449 C 162.9406280517578 15.00181674957275 163.0725555419922 9.1512451171875 159.5591735839844 5.636792659759521 C 157.9106292724609 3.988769054412842 155.6903839111328 3.081149816513062 153.3074340820312 3.081149816513062 C 150.7656860351562 3.081149816513062 148.3538665771484 4.09307861328125 146.516357421875 5.9303879737854 L 82.62012481689453 69.82712554931641 L 18.64035987854004 5.847316741943359 C 16.80335998535156 4.011078357696533 14.39116954803467 2.999816656112671 11.84814548492432 2.999816656112671 C 9.45543098449707 2.999816656112671 7.225717067718506 3.91238808631897 5.568645477294922 5.570507049560547 C 3.87328839302063 7.26515007019043 2.96147894859314 9.547744750976562 3.001145601272583 11.99781703948975 C 3.041407585144043 14.48450660705566 4.052621841430664 16.84274482727051 5.848859786987305 18.63846015930176 L 69.82907104492188 82.61865234375 L 5.883026599884033 146.5646667480469 C 2.206740856170654 150.2409820556641 2.07538366317749 156.0916442871094 5.590312480926514 159.60693359375 C 7.237740993499756 161.2547149658203 9.456883430480957 162.162109375 11.83895492553711 162.1618804931641 C 14.38093090057373 162.1616668701172 16.79293060302734 161.1494903564453 18.63064575195312 159.3117980957031 L 82.576171875 95.36624145507812 L 146.5658569335938 159.35595703125 C 148.4017486572266 161.1921844482422 150.8128356933594 162.2035064697266 153.3547058105469 162.2036285400391 M 153.35498046875 165.2036285400391 C 150.1572418212891 165.2036285400391 146.92431640625 163.9575347900391 144.4443359375 161.47705078125 L 82.576171875 99.60888671875 L 20.75195503234863 161.43310546875 C 15.89745426177979 166.28759765625 8.158693313598633 166.4189758300781 3.468764781951904 161.72802734375 C -1.224616289138794 157.0341796875 -1.09325909614563 149.29833984375 3.761717081069946 144.443359375 L 65.58643341064453 82.61865234375 L 3.727550506591797 20.75976943969727 C -1.130854368209839 15.90284061431885 -1.25683057308197 8.151364326477051 3.44776463508606 3.448745250701904 C 8.150382995605469 -1.256825685501099 15.9028377532959 -1.130850672721863 20.76124000549316 3.725578546524048 L 82.62012481689453 65.58448028564453 L 144.39501953125 3.809078454971313 C 149.2480773925781 -1.043446183204651 156.98681640625 -1.176753520965576 161.68017578125 3.515149831771851 C 166.3715667724609 8.208006858825684 166.23828125 15.94676876068115 161.3857421875 20.79931640625 L 99.61035919189453 82.57469940185547 L 161.47900390625 144.443359375 C 166.33544921875 149.3017730712891 166.458984375 157.05126953125 161.755859375 161.7548828125 C 159.4541015625 164.0576324462891 156.42138671875 165.203125 153.35498046875 165.2036285400391 Z' stroke='none' fill='%23faa'/%3E%3C/g%3E%3C/g%3E%3Crect id='사각형_4193-2' data-name='사각형 4193' width='200' height='200' fill='none'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
	/* background-size: contain; */
}

#game_correct_answer_popup_mo  .correct_answer_bg {
	width: 250px;
    height: 200px;

	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

	background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='285.266' height='217.366' viewBox='0 0 285.266 217.366'%3E%3Cdefs%3E%3Cfilter id='패스_1492' x='217.279' y='8.029' width='59.887' height='66.99' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1493' x='236.664' y='0.334' width='48.603' height='53.024' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-2'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-2'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1497' x='200.518' y='151.77' width='58.761' height='65.597' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-3'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-3'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1491' x='20.043' y='0' width='52.639' height='58.019' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-4'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-4'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1494' x='0' y='18.363' width='63.225' height='71.122' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-5'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-5'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1495' x='32.818' y='163.607' width='46.969' height='51.002' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-6'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-6'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3Cfilter id='패스_1496' x='17.681' y='151.139' width='46.969' height='51.002' filterUnits='userSpaceOnUse'%3E%3CfeOffset dy='1' input='SourceAlpha'/%3E%3CfeGaussianBlur stdDeviation='5' result='blur-7'/%3E%3CfeFlood flood-color='%2378fff4'/%3E%3CfeComposite operator='in' in2='blur-7'/%3E%3CfeComposite in='SourceGraphic'/%3E%3C/filter%3E%3C/defs%3E%3Cg id='그룹_1269' data-name='그룹 1269' transform='translate(-286.637 -87.861)'%3E%3Cg id='그룹_807' data-name='그룹 807' transform='translate(-677.508 -283.152)'%3E%3Cg transform='matrix(1, 0, 0, 1, 964.15, 371.01)' filter='url(%23패스_1492)'%3E%3Cpath id='패스_1492-2' data-name='패스 1492' d='M36.185,18.5c-14.157.538-14.509.973-14.944,18.5C20.807,19.469,20.455,19.033,6.3,18.5c14.157-.537,14.509-.973,14.944-18.5.434,17.522.787,17.958,14.944,18.5' transform='translate(225.98 22.03)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 964.15, 371.01)' filter='url(%23패스_1493)'%3E%3Cpath id='패스_1493-2' data-name='패스 1493' d='M24.9,11.512c-8.812.335-9.031.606-9.3,11.512-.27-10.906-.49-11.177-9.3-11.512,8.812-.335,9.031-.606,9.3-11.512.27,10.906.49,11.177,9.3,11.512' transform='translate(245.37 14.33)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 286.64, 87.86)' filter='url(%23패스_1497)'%3E%3Cpath id='패스_1497-2' data-name='패스 1497' d='M35.059,17.8c-13.624.518-13.962.937-14.381,17.8C20.26,18.735,19.922,18.316,6.3,17.8,19.922,17.281,20.26,16.862,20.679,0c.418,16.862.757,17.281,14.381,17.8' transform='translate(209.22 165.77)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 286.64, 87.86)' filter='url(%23패스_1491)'%3E%3Cpath id='패스_1491-2' data-name='패스 1491' d='M28.937,14.01c-10.724.407-10.99.737-11.319,14.01-.329-13.272-.6-13.6-11.319-14.01C17.022,13.6,17.288,13.272,17.617,0c.329,13.272.6,13.6,11.319,14.01' transform='translate(28.75 14)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 286.64, 87.86)' filter='url(%23패스_1494)'%3E%3Cpath id='패스_1494-2' data-name='패스 1494' d='M39.523,20.561c-15.738.6-16.13,1.082-16.613,20.561C22.428,21.643,22.036,21.159,6.3,20.561c15.738-.6,16.13-1.082,16.613-20.561.483,19.479.874,19.963,16.613,20.561' transform='translate(8.7 32.36)' fill='%23fff'/%3E%3C/g%3E%3Cg id='그룹_808' data-name='그룹 808' transform='translate(-528.049 -346)'%3E%3Cg transform='matrix(1, 0, 0, 1, 814.69, 433.86)' filter='url(%23패스_1495)'%3E%3Cpath id='패스_1495-2' data-name='패스 1495' d='M23.267,10.5c-8.038.305-8.238.553-8.484,10.5-.247-9.948-.447-10.2-8.484-10.5,8.038-.305,8.238-.553,8.484-10.5.247,9.948.447,10.2,8.484,10.5' transform='translate(41.52 177.61)' fill='%23fff'/%3E%3C/g%3E%3Cg transform='matrix(1, 0, 0, 1, 814.69, 433.86)' filter='url(%23패스_1496)'%3E%3Cpath id='패스_1496-2' data-name='패스 1496' d='M23.267,10.5c-8.038.305-8.238.553-8.484,10.5-.247-9.948-.447-10.2-8.484-10.5,8.038-.305,8.238-.553,8.484-10.5.247,9.948.447,10.2,8.484,10.5' transform='translate(26.38 165.14)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}


/* <!-- ****************** 모바일, tablet 랜드 퍼블리싱 위쪽 ****************** --> */
/* #land_top_box_wrap */
#land_top_box_wrap {
	position: fixed;
    top: 20px;
    width: 100%;
    padding: 0 20px;

	transition: all .3s ease;

	display: none;
}

#land_top_box_wrap.show {
	top: 60px;
}

#land_top_box_wrap .land_top_box {
	display: flex;
    align-items: flex-start;
}

#land_top_box_wrap .land_top_box .land_top_left_box {
	max-width: 300px;
    overflow: hidden;
}

@media all and (min-width: 1024px){
	#land_top_box_wrap .land_top_box .land_top_left_box {
		max-width: 440px;
    
	}
}

#land_top_box_wrap .land_top_box .video_call_box_wrap {
	display: flex;
    align-items: center;
}


#land_top_box_wrap .land_top_box .video_call_box_wrap > * + * {
	margin-left: 10px;
}

#land_top_box_wrap .land_top_box .video_call_box {
	background: rgba(34, 34, 34, .5);
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 80px;
    height: 80px;
    border: 2px solid transparent;
    position: relative;
    cursor: pointer;
}

@media all and (min-width: 1024px){
	#land_top_box_wrap .land_top_box .video_call_box {
		width: 120px;
		height: 120px;
	}
}

#land_top_box_wrap .land_top_box .video_call_box.mic_on {
	border: 2px solid red;

}

#land_top_box_wrap .land_top_box .video_call_box span {
	position: absolute;
    inset: 5px 0 0 5px;
    font-size: 10px;
    color: #fff;
    font-weight: 500;
}

#land_top_box_wrap .land_top_box .video_call_box video {
	position: absolute;
    border-radius: 15px;
    object-fit: cover;
    width: 100%;
    height: 100%;
}

#land_top_box_wrap .land_top_right_box {
	margin-left: auto;
	display: flex;
    align-items: center;

	height: 40px;
}

#land_top_box_wrap .land_top_right_box > * + * {
	margin-left: 10px;
}

#land_top_box_wrap .land_top_right_box .video_setting_box {
	height: 100%;
    width: 77px;
    background: rgba(34, 34, 34, .8);
    border-radius: 20px;
    display: flex;
    align-items: center;

	justify-content: space-evenly;
}

#land_top_box_wrap .land_top_right_box .video_setting_box button {
	width: 24px;
    height: 24px;
}


#land_top_box_wrap .land_top_right_box .video_setting_box button#mo_toggle_camera {
	background: url("data:image/svg+xml,%3Csvg id='camera' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24' height='24' viewBox='0 0 24 24'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4334' data-name='사각형 4334' width='24' height='24' transform='translate(0 -0.293)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='그룹_1501' data-name='그룹 1501' transform='translate(0 0.293)' clip-path='url(%23clip-path)'%3E%3Cpath id='패스_1515' data-name='패스 1515' d='M3,6.918c.037-.119.065-.239.11-.354a1.532,1.532,0,0,1,1.47-.971q4.153-.007,8.3,0a1.526,1.526,0,0,1,1.578,1.592c0,.429,0,.858,0,1.313.073-.025.128-.043.18-.063l4.31-1.724c.446-.178.756.034.756.517v7.147c0,.482-.309.7-.756.518l-4.309-1.724-.17-.062c0,.066-.011.117-.011.168,0,.382,0,.762,0,1.143a1.526,1.526,0,0,1-1.578,1.592q-4.152.011-8.3,0a1.523,1.523,0,0,1-1.554-1.268A.278.278,0,0,0,3,14.687Zm5.729-.348H4.667c-.482,0-.688.2-.688.68v7.1c0,.482.2.688.68.688q4.077,0,8.154,0c.462,0,.67-.205.67-.664q0-3.565,0-7.129c0-.469-.2-.671-.678-.672H8.729m10,1.3a.658.658,0,0,0-.065.018q-2.05.818-4.1,1.636c-.095.038-.1.094-.1.174,0,.734,0,1.469,0,2.2a.18.18,0,0,0,.138.2q2,.795,3.992,1.594c.041.017.087.028.136.044Z' transform='translate(0.556 1.036)' fill='%23fff'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

/* 카메라 버튼 클릭 시 */
#land_top_box_wrap .land_top_right_box .video_setting_box button#mo_toggle_camera.toggle {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24' height='24' viewBox='0 0 24 24'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4337' data-name='사각형 4337' width='24' height='24' transform='translate(0 -0.071)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='camera_off' transform='translate(0 0.071)'%3E%3Cg id='그룹_1506' data-name='그룹 1506' clip-path='url(%23clip-path)'%3E%3Cpath id='패스_1523' data-name='패스 1523' d='M3.1,18.149a.6.6,0,0,1-.424-1.022L15.319,4.485a.6.6,0,0,1,.846.846L3.522,17.974a.6.6,0,0,1-.424.175' transform='translate(0.491 0.847)' fill='%23ff5353'/%3E%3Cpath id='패스_1524' data-name='패스 1524' d='M3.238,15.371,4.01,14.6a1.191,1.191,0,0,1-.022-.171V7.266c0-.482.207-.687.7-.687h7.346l.98-.98c-.012,0-.02-.006-.032-.006q-4.19-.011-8.381,0a1.547,1.547,0,0,0-1.485.98c-.045.116-.074.239-.111.359v7.84a.29.29,0,0,1,.028.059,1.758,1.758,0,0,0,.211.541' transform='translate(0.589 1.098)' fill='%23ff5353'/%3E%3Cpath id='패스_1525' data-name='패스 1525' d='M18.628,6.546l-4.35,1.738c-.053.022-.108.038-.182.065,0-.383,0-.742,0-1.1l-.988.988q0,3.02,0,6.042c0,.462-.209.67-.676.67H6.4l-.986.986q3.546.005,7.094,0A1.541,1.541,0,0,0,14.1,14.326c0-.385,0-.769,0-1.153,0-.051.006-.1.011-.171.071.026.121.043.171.063q2.175.869,4.349,1.738c.451.181.763-.035.763-.522V7.067c0-.487-.313-.7-.763-.52m-.229,7.09c-.05-.017-.1-.028-.139-.044q-2.014-.806-4.028-1.609a.182.182,0,0,1-.139-.2c.006-.742,0-1.482,0-2.223,0-.081,0-.139.1-.177q2.071-.82,4.137-1.651a.485.485,0,0,1,.066-.017Z' transform='translate(1.063 1.273)' fill='%23ff5353'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#land_top_box_wrap .land_top_right_box .video_setting_box button#mo_toggle_mic {
	background: url("data:image/svg+xml,%3Csvg id='mic' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24' height='24' viewBox='0 0 24 24'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4335' data-name='사각형 4335' width='24' height='24' transform='translate(0 -0.293)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='그룹_1503' data-name='그룹 1503' transform='translate(0 0.293)' clip-path='url(%23clip-path)'%3E%3Cpath id='패스_1516' data-name='패스 1516' d='M14.157,9.188c0,.887,0,1.772,0,2.658A3.592,3.592,0,0,1,6.974,12q-.028-2.816,0-5.633a3.59,3.59,0,0,1,7.123-.5,3.92,3.92,0,0,1,.058.688c.006.88,0,1.759,0,2.639m-1.2,0c0-.885,0-1.771,0-2.656a2.642,2.642,0,0,0-.057-.556,2.393,2.393,0,0,0-4.732.535q-.005,2.674,0,5.35a2.468,2.468,0,0,0,.059.537,2.393,2.393,0,0,0,4.73-.533c0-.891,0-1.784,0-2.675' transform='translate(1.29 0.538)' fill='%23fff'/%3E%3Cpath id='패스_1517' data-name='패스 1517' d='M11.535,16.609c0,.384,0,.752,0,1.119a.6.6,0,1,1-1.2,0V16.563c-.321-.068-.644-.109-.948-.205A5.942,5.942,0,0,1,5,11.426a4.631,4.631,0,0,1-.051-.727.569.569,0,0,1,.589-.628.572.572,0,0,1,.606.613A4.634,4.634,0,0,0,7.825,14.3a4.551,4.551,0,0,0,4.76.858,4.633,4.633,0,0,0,3.069-3.685,5.1,5.1,0,0,0,.071-.762.584.584,0,0,1,.6-.637.573.573,0,0,1,.594.66A5.922,5.922,0,0,1,13.8,15.889a5.413,5.413,0,0,1-2.136.695c-.037,0-.072.014-.129.026' transform='translate(0.917 1.867)' fill='%23fff'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

/* 마이크 버튼 클릭 시 */
#land_top_box_wrap .land_top_right_box .video_setting_box button#mo_toggle_mic.toggle {
	background: url("data:image/svg+xml,%3Csvg id='mic' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24' height='24' viewBox='0 0 24 24'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4336' data-name='사각형 4336' width='24' height='24' transform='translate(0 -0.182)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='mic_off' transform='translate(0 0.182)'%3E%3Cg id='그룹_1504' data-name='그룹 1504' clip-path='url(%23clip-path)'%3E%3Cpath id='패스_1518' data-name='패스 1518' d='M5.346,12.678l.927-.927a5.4,5.4,0,0,1-.124-1.063.575.575,0,0,0-.609-.617.572.572,0,0,0-.592.632,4.672,4.672,0,0,0,.051.73,7.492,7.492,0,0,0,.347,1.244' transform='translate(0.945 1.923)' fill='%23ff5353'/%3E%3Cpath id='패스_1519' data-name='패스 1519' d='M16.112,10.071a.587.587,0,0,0-.606.641,5.308,5.308,0,0,1-.073.766,4.652,4.652,0,0,1-3.082,3.7,4.574,4.574,0,0,1-4.784-.861,5.008,5.008,0,0,1-.375-.389l-.826.828a6.5,6.5,0,0,0,2.772,1.633c.307.1.63.137.954.206,0,.391,0,.779,0,1.167a.605.605,0,1,0,1.2,0c0-.369,0-.738,0-1.124.056-.012.093-.021.129-.026a5.432,5.432,0,0,0,2.146-.7,5.945,5.945,0,0,0,3.138-5.182.575.575,0,0,0-.6-.663' transform='translate(1.215 1.923)' fill='%23ff5353'/%3E%3Cpath id='패스_1520' data-name='패스 1520' d='M8.175,10.832q0-2.151,0-4.3a2.4,2.4,0,0,1,4.753-.537c.006.025,0,.052.008.077l.959-.959A3.6,3.6,0,0,0,6.974,6.381q-.029,2.824,0,5.651Z' transform='translate(1.329 0.554)' fill='%23ff5353'/%3E%3Cpath id='패스_1521' data-name='패스 1521' d='M12.825,8.541c0,.841,0,1.68,0,2.521a2.418,2.418,0,0,1-2.183,2.413,2.363,2.363,0,0,1-1.98-.769l-.853.853a3.578,3.578,0,0,0,2.47,1.127,3.618,3.618,0,0,0,3.749-3.644c0-.89,0-1.779,0-2.67,0-.344,0-.688,0-1.033Z' transform='translate(1.491 1.401)' fill='%23ff5353'/%3E%3Cpath id='패스_1522' data-name='패스 1522' d='M4.405,17.354a.6.6,0,0,1-.422-1.017L16.568,3.753a.6.6,0,0,1,.842.842L4.827,17.18a.6.6,0,0,1-.422.174' transform='translate(0.727 0.683)' fill='%23ff5353'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#land_top_box_wrap .land_top_right_box .video_setting_box button#mo_share_screen {
	background: url("data:image/svg+xml,%3Csvg id='화면_공유' data-name='화면 공유' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24' height='24' viewBox='0 0 24 24'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4332' data-name='사각형 4332' width='24' height='24' transform='translate(0.364)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='그룹_1497' data-name='그룹 1497' transform='translate(-0.364)' clip-path='url(%23clip-path)'%3E%3Cpath id='패스_1511' data-name='패스 1511' d='M7.258,16.067H7.034c-.715,0-1.429,0-2.143,0A1.816,1.816,0,0,1,3,14.176Q3,10.3,3,6.431A1.818,1.818,0,0,1,4.928,4.5q4.81,0,9.62,0c1.2,0,2.41,0,3.614,0a1.806,1.806,0,0,1,1.843,1.439,2.311,2.311,0,0,1,.046.493q0,3.854,0,7.706a1.827,1.827,0,0,1-1.575,1.908,2.2,2.2,0,0,1-.324.018c-.714,0-1.428,0-2.142,0h-.228c0,.157,0,.295,0,.434a1.349,1.349,0,0,1-1.4,1.4c-1.129,0-2.257,0-3.385,0-.765,0-1.53,0-2.3,0a1.364,1.364,0,0,1-1.446-1.453c0-.119,0-.239,0-.378m4.267-1.218h6.56c.535,0,.752-.217.752-.755V6.483c0-.551-.216-.767-.761-.767H4.975c-.54,0-.755.214-.755.749v7.628c0,.552.206.755.765.755h6.541m3.024,1.234H8.477v.283c0,.307,0,.312.308.312h5.277c.557,0,.568-.012.486-.594' transform='translate(0.655 0.982)' fill='%23fff'/%3E%3Cpath id='패스_1512' data-name='패스 1512' d='M11.028,9.146q0,1.281,0,2.561a1.611,1.611,0,0,1-.015.266.6.6,0,0,1-1.2-.09c0-.847,0-1.695,0-2.542V9.079l-.663.661a.6.6,0,0,1-.61.175.593.593,0,0,1-.3-.973c.585-.613,1.189-1.207,1.8-1.8a.562.562,0,0,1,.785.012q.9.873,1.771,1.77a.605.605,0,0,1-.873.837c-.217-.211-.42-.437-.63-.657l-.056.039' transform='translate(1.763 1.526)' fill='%23fff'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}


#land_top_box_wrap .land_top_right_box .video_setting_box button#mo_add_media {
	background: url("data:image/svg+xml,%3Csvg id='미디어_추가' data-name='미디어 추가' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24' height='24' viewBox='0 0 24 24'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4333' data-name='사각형 4333' width='24' height='24' transform='translate(0 0.183)' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='그룹_1499' data-name='그룹 1499' transform='translate(0 -0.183)' clip-path='url(%23clip-path)'%3E%3Cpath id='패스_1513' data-name='패스 1513' d='M17.874,4.3H4.644a.664.664,0,0,0-.664.665V18.2a.664.664,0,0,0,.664.665h13.23a.665.665,0,0,0,.665-.665V4.968a.665.665,0,0,0-.665-.665m-.665,13.229H5.309V5.633h11.9Z' transform='translate(0.832 0.9)' fill='%23fff'/%3E%3Cpath id='패스_1514' data-name='패스 1514' d='M8.351,11.472H9.819v1.469a.664.664,0,1,0,1.329,0V11.472h1.469a.665.665,0,0,0,0-1.33H11.148V8.674a.664.664,0,1,0-1.329,0v1.468H8.351a.665.665,0,0,0,0,1.33' transform='translate(1.607 1.675)' fill='%23fff'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}



#land_top_box_wrap .land_top_right_box .land_top_btn_box {
	width: 40px;
    height: 40px;
    box-shadow: 2px 3px 20px #FB8C0014;
    border-radius: 20px;
    background: rgba(34, 34, 34, .8);
}

#land_top_box_wrap .land_top_right_box .land_top_btn_box button {
	width: 100%;
	height: 100%;
}

#land_top_box_wrap .land_top_right_box .land_top_btn_box #mo_user_list {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cg id='list_icon' opacity='0.8'%3E%3Crect id='사각형_3930' data-name='사각형 3930' width='24' height='24' fill='none'/%3E%3Cg id='그룹_566' data-name='그룹 566' transform='translate(3.092 3.997)'%3E%3Cpath id='패스_1189' data-name='패스 1189' d='M18.975,8.667a3.327,3.327,0,0,1-3.009,3.285,2.063,2.063,0,0,1-.248.01.674.674,0,0,1-.72-.643.66.66,0,0,1,.68-.68,1.944,1.944,0,0,0,1.868-1.382,1.98,1.98,0,0,0-1.825-2.6c-.458-.036-.734-.3-.723-.683.012-.4.321-.652.8-.642.07,0,.138,0,.207.012a3.327,3.327,0,0,1,2.969,3.321' transform='translate(-3.064 -4.006)' fill='%23fff'/%3E%3Cpath id='패스_1190' data-name='패스 1190' d='M20.972,16.04a4.992,4.992,0,0,1-.058,1.075,1.987,1.987,0,0,1-1.852,1.513,6.7,6.7,0,0,1-.787,0,.657.657,0,0,1,.011-1.312c.22-.018.442,0,.662-.009a.652.652,0,0,0,.7-.663c.015-.5.012-.995,0-1.491a1.778,1.778,0,0,0-.278-.858c-.347-.576-.524-.645-1.145-.446a2.694,2.694,0,0,1-.436.13.64.64,0,0,1-.748-.447.617.617,0,0,1,.348-.79,8.035,8.035,0,0,0,1.056-.466.687.687,0,0,1,.673.064,3.283,3.283,0,0,1,1.857,2.8c.022.261,0,.524,0,.907' transform='translate(-3.074 -4.042)' fill='%23fff'/%3E%3Cpath id='패스_1191' data-name='패스 1191' d='M16.253,17.641a5.636,5.636,0,0,0-2.841-4.85,1.277,1.277,0,0,0-1.3-.072,5.349,5.349,0,0,1-4.977-.006,1.253,1.253,0,0,0-1.266.064A5.632,5.632,0,0,0,3,17.572a2.194,2.194,0,0,0,2.323,2.386c1.436,0,2.872,0,4.308,0s2.9.006,4.35,0a2.185,2.185,0,0,0,2.269-2.317m-2.332.991c-1.422,0-2.845,0-4.266,0s-2.845,0-4.267,0c-.755,0-1.1-.348-1.058-1.1a4.379,4.379,0,0,1,1.966-3.472.465.465,0,0,1,.525-.045,6.492,6.492,0,0,0,5.6.009.462.462,0,0,1,.526.027,4.387,4.387,0,0,1,1.978,3.549.89.89,0,0,1-1.006,1.027' transform='translate(-3 -4.044)' fill='%23fff'/%3E%3Cpath id='패스_1192' data-name='패스 1192' d='M9.656,4a3.978,3.978,0,1,0,3.963,3.994A3.984,3.984,0,0,0,9.656,4M9.627,10.63a2.652,2.652,0,1,1,2.666-2.649A2.657,2.657,0,0,1,9.627,10.63' transform='translate(-3.014 -3.999)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#land_top_box_wrap .land_top_right_box .land_top_btn_box #mo_device_setting {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cg id='settings_icon' opacity='0.8'%3E%3Crect id='사각형_3936' data-name='사각형 3936' width='24' height='24' fill='none'/%3E%3Cg id='그룹_579' data-name='그룹 579' transform='translate(2.952 3.176)'%3E%3Cpath id='패스_1193' data-name='패스 1193' d='M20.938,8.98a.9.9,0,0,1-.506.675,3.036,3.036,0,0,1-.665.19.292.292,0,0,0-.216.166.537.537,0,0,0,.064.682,1.018,1.018,0,0,1-.121,1.47c-.144.144-.284.292-.438.427a1,1,0,0,1-1.169.12.622.622,0,0,1-.174-.114c-.238-.275-.489-.177-.741-.034a.231.231,0,0,0-.086.132c-.036.146-.053.3-.09.443a1,1,0,0,1-.942.77c-.244.01-.488.01-.732,0a1.008,1.008,0,0,1-.953-.782.531.531,0,0,1-.031-.154c.015-.314-.16-.461-.441-.543a.259.259,0,0,0-.254.038,1.566,1.566,0,0,1-.723.364.959.959,0,0,1-.781-.22,7.068,7.068,0,0,1-.593-.591,1,1,0,0,1-.11-1.155.887.887,0,0,1,.134-.2.455.455,0,0,0,.069-.607.326.326,0,0,0-.276-.214,1.273,1.273,0,0,1-.836-.343.981.981,0,0,1-.287-.654c-.006-.239-.01-.477,0-.716a1.014,1.014,0,0,1,.838-1,1.786,1.786,0,0,1,.241-.04.378.378,0,0,0,.339-.257.484.484,0,0,0-.087-.576A1.044,1.044,0,0,1,11.5,4.734c.132-.131.261-.266.4-.39a1.011,1.011,0,0,1,1.214-.112.566.566,0,0,1,.144.1c.236.274.488.176.739.034a.232.232,0,0,0,.088-.134c.031-.117.043-.24.068-.359a1.015,1.015,0,0,1,.757-.826.258.258,0,0,0,.056-.035h1.012a1.078,1.078,0,0,1,.778.658,2.321,2.321,0,0,1,.1.474.344.344,0,0,0,.214.274.463.463,0,0,0,.619-.076.881.881,0,0,1,.174-.115,1,1,0,0,1,1.17.094,6.022,6.022,0,0,1,.59.592.993.993,0,0,1,.092,1.17c-.078.129-.17.25-.255.375-.022.033-.06.079-.051.1a1.891,1.891,0,0,0,.193.444c.043.062.173.072.266.086a1.124,1.124,0,0,1,.787.363,1.1,1.1,0,0,1,.277.514ZM18.966,5.559a.866.866,0,0,0-.088-.129c-.116-.121-.24-.237-.356-.359a.173.173,0,0,0-.261-.021c-.17.123-.344.24-.513.362a.513.513,0,0,1-.557.051c-.264-.12-.533-.229-.8-.332a.494.494,0,0,1-.34-.4c-.035-.207-.075-.412-.106-.619-.02-.128-.077-.2-.218-.193-.163.008-.326,0-.489,0a.174.174,0,0,0-.2.17c-.031.2-.074.4-.1.6a.522.522,0,0,1-.362.446c-.265.1-.53.206-.788.325a.507.507,0,0,1-.556-.048c-.16-.115-.327-.223-.484-.343a.2.2,0,0,0-.316.021c-.1.112-.21.219-.32.321a.189.189,0,0,0-.024.289c.12.164.232.335.351.5a.509.509,0,0,1,.053.556c-.121.264-.232.532-.335.8a.492.492,0,0,1-.4.34c-.206.036-.412.076-.619.107-.129.02-.195.08-.188.22.007.162,0,.325,0,.488a.172.172,0,0,0,.169.2c.2.031.4.074.6.1a.532.532,0,0,1,.454.378c.094.255.2.508.313.755a.529.529,0,0,1-.053.588c-.117.158-.225.325-.342.484a.189.189,0,0,0,.019.289q.173.16.333.333a.189.189,0,0,0,.289.021c.158-.117.325-.225.484-.342a.525.525,0,0,1,.587-.053c.246.117.5.219.755.312a.536.536,0,0,1,.382.47c.027.2.072.389.1.584a.172.172,0,0,0,.2.17c.163,0,.326-.006.488,0a.188.188,0,0,0,.221-.188c.031-.2.074-.4.1-.6a.51.51,0,0,1,.357-.43c.266-.1.529-.209.787-.326a.511.511,0,0,1,.557.051c.165.119.337.23.5.352a.2.2,0,0,0,.3-.031,3.919,3.919,0,0,1,.308-.308.2.2,0,0,0,.022-.317c-.113-.147-.21-.307-.322-.454a.542.542,0,0,1-.056-.619,7.343,7.343,0,0,0,.306-.738.535.535,0,0,1,.469-.383c.189-.027.377-.073.567-.1.134-.018.195-.08.19-.217-.006-.157-.007-.314,0-.471a.191.191,0,0,0-.189-.222c-.207-.033-.413-.073-.618-.106a.491.491,0,0,1-.406-.337c-.1-.27-.212-.54-.333-.8a.513.513,0,0,1,.048-.557q.177-.248.35-.5c.029-.042.051-.088.083-.144' transform='translate(-3.057 -3.009)' fill='%23fff'/%3E%3Cpath id='패스_1194' data-name='패스 1194' d='M6.174,8.688a1.069,1.069,0,0,1,.734.281.716.716,0,0,0,.936.13c.206-.114.333-.206.346-.442a2.061,2.061,0,0,1,.072-.394.463.463,0,0,1,.508-.33.447.447,0,0,1,.371.477c-.046.345-.113.688-.179,1.03a.443.443,0,0,1-.309.326c-.36.146-.72.291-1.076.446a.5.5,0,0,1-.526-.044c-.233-.165-.465-.329-.7-.49a.3.3,0,0,0-.462.042c-.162.159-.323.319-.481.482a.289.289,0,0,0-.038.435c.155.226.31.45.473.67a.559.559,0,0,1,.04.634,8.622,8.622,0,0,0-.385.932A.57.57,0,0,1,5,13.3c-.265.04-.528.088-.79.139-.21.04-.279.125-.282.331,0,.233,0,.466,0,.7,0,.211.083.3.3.338.268.048.538.1.807.14a.538.538,0,0,1,.448.383c.122.338.263.669.413,1a.535.535,0,0,1-.044.588q-.246.339-.481.685a.289.289,0,0,0,.034.436c.166.171.334.341.506.506a.285.285,0,0,0,.422.031c.236-.16.468-.324.7-.491a.527.527,0,0,1,.573-.042c.332.151.669.294,1.011.421a.526.526,0,0,1,.373.437q.069.4.14.807c.042.233.127.3.367.305.215,0,.431,0,.645,0,.235,0,.315-.065.36-.29.049-.246.1-.49.131-.738a.6.6,0,0,1,.473-.552,5.88,5.88,0,0,0,.882-.368.564.564,0,0,1,.649.042c.214.161.436.311.656.462a.293.293,0,0,0,.448-.038q.243-.239.481-.481a.3.3,0,0,0,.042-.449c-.157-.23-.318-.458-.481-.685a.536.536,0,0,1-.041-.589c.151-.325.288-.658.413-1a.529.529,0,0,1,.434-.377c.264-.046.526-.1.791-.137a.831.831,0,0,1,.293,0,.439.439,0,0,1,.338.434.457.457,0,0,1-.343.432c-.187.044-.376.078-.566.1a.19.19,0,0,0-.186.149.806.806,0,0,1-.106.274.5.5,0,0,0,.076.7,1.7,1.7,0,0,1,.3.508,1.076,1.076,0,0,1-.189,1.115,7.233,7.233,0,0,1-.71.719,1.141,1.141,0,0,1-1.419.114,4.911,4.911,0,0,1-.444-.308.256.256,0,0,0-.327-.035,1.767,1.767,0,0,1-.418.174.259.259,0,0,0-.2.259,4.876,4.876,0,0,1-.1.548,1.167,1.167,0,0,1-1.133.913c-.251.007-.5,0-.751,0a1.2,1.2,0,0,1-1.253-1.052,3.686,3.686,0,0,1-.07-.413.252.252,0,0,0-.207-.256c-.165-.052-.319-.139-.483-.2a.243.243,0,0,0-.185.016c-.192.119-.37.263-.565.379a1.135,1.135,0,0,1-1.346-.123,8.7,8.7,0,0,1-.693-.688,1.137,1.137,0,0,1-.125-1.389c.11-.184.248-.352.359-.536a.261.261,0,0,0,.02-.2,4.052,4.052,0,0,0-.221-.53.291.291,0,0,0-.168-.139c-.191-.049-.389-.068-.582-.111a1.176,1.176,0,0,1-.944-1.162c0-.251,0-.5,0-.751A1.191,1.191,0,0,1,4.043,12.54c.2-.038.443-.016.587-.126s.166-.357.266-.529a.314.314,0,0,0-.042-.4A3.679,3.679,0,0,1,4.531,11a1.127,1.127,0,0,1,.114-1.3,9.617,9.617,0,0,1,.74-.74,1.081,1.081,0,0,1,.789-.273' transform='translate(-3.018 -3.037)' fill='%23fff'/%3E%3Cpath id='패스_1195' data-name='패스 1195' d='M9.916,17.168A3.033,3.033,0,1,1,9.8,11.1a.467.467,0,0,1,.487.426A.445.445,0,0,1,9.858,12a2.252,2.252,0,0,0-1.408.528,2.124,2.124,0,1,0,3.505,1.763.678.678,0,0,1,.145-.471.447.447,0,0,1,.483-.1.462.462,0,0,1,.29.439,3.055,3.055,0,0,1-1.907,2.8,2.945,2.945,0,0,1-1.05.214' transform='translate(-3.039 -3.055)' fill='%23fff'/%3E%3Cpath id='패스_1196' data-name='패스 1196' d='M15.5,10.646a2.167,2.167,0,1,1,2.168-2.162A2.161,2.161,0,0,1,15.5,10.646m-.027-.911a1.258,1.258,0,1,0-1.23-1.278,1.262,1.262,0,0,0,1.23,1.278' transform='translate(-3.076 -3.028)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}


/* <!-- MO - 설정 버튼 클릭 시 노출되는 기기 설정 팝업 --> */
#device_setting_mo .device_setting {
	width: 440px;
    height: 60vh;
    overflow: auto;
}

#device_setting_mo .device_setting::-webkit-scrollbar {
	display: none;
}

#device_setting_mo .device_setting .setting_header {
	height: 42px;
    padding: 0 14px
}

#device_setting_mo .device_setting .setting_header .setting_header_left p {
	font-size: 15px;
}

#device_setting_mo .device_setting .setting_header .setting_header_right button {
	width: 20px;
    height: 20px;
}

#device_setting_mo .device_setting .setting_header .setting_header_right button svg {
	height: 20px;
}

#device_setting_mo .device_setting .setting_main {
	padding: 16px;
}

#device_setting_mo .device_setting .setting_main .setting_main_top p {
	font-size: 14px;
}

#device_setting_mo .device_setting .setting_main .setting_main_top span {
	font-size: 12px;
}

#device_setting_mo .device_setting .setting_main .setting_main_mid {
	margin: 14px 0;
}

#device_setting_mo .device_setting .setting_main .setting_main_mid .setting_video {
	width: 180px;
    height: 100px;
}


#device_setting_mo .device_setting .setting_main .setting_main_mid .setting_video_reversal {
	width: 180px;
}

#device_setting_mo .device_setting .setting_main .setting_main_mid .setting_video_reversal > span {
	font-size: 12px;
}

#device_setting_mo .toggleSwitch {
	width: 34px;
    height: 18px;
}

#device_setting_mo .toggleButton {
	width: 14px;
    height: 14px;
}

#device_setting_mo #reversal:checked ~ .toggleSwitch .toggleButton {
	left: calc(100% - 17px);
}

#device_setting_mo .device_setting .setting_main .setting_main_bot > div span {
	font-size: 14px;
}

#device_setting_mo .device_setting .setting_main .setting_main_bot > div select {
	height: 28px;
    font-size: 14px;
}

#device_setting_mo .device_setting .setting_main .setting_main_bot > div.mic_test span {
	font-size: 12px;
}

#device_setting_mo .device_setting .setting_main .setting_main_bot > div.mic_test .mic_test_bar_bg {
	width: 90px;
}


/* <!-- ********* #land_bot_box_wrap ********* --> */
#land_bot_box_wrap {
	position: fixed;
    width: 100%;
    padding: 0;
    transition: all .3s ease;
    bottom: 0;
    /* background: black; */

	display: none;
}

#land_bot_box_wrap.show {
	bottom: 45px;
}

#land_bot_box_wrap .land_bot_btn_box {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
    gap: 10px;
	width: 130px;
    padding: 10px 20px;
}

/* #land_bot_box_wrap .land_bot_btn_box > * + * {
	margin-left: 10px;
} */

#land_bot_box_wrap .land_bot_btn_box .land_bot_btn {
	width: 40px;
    height: 40px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 2px 3px 10px #22222214;
}

#land_bot_box_wrap .land_bot_btn_box .land_bot_btn button {
	width: 100%;
	height: 100%;

	transition: all .3s ease;

	display: flex;
	justify-content: center;
    align-items: center;
}

#land_bot_box_wrap .land_bot_btn_box .land_bot_btn button img {
	width: 28px;
    height: 28px;
}

.mo_sidebar_btn {
	background: url("data:image/svg+xml,%3Csvg id='plus' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_4165' data-name='사각형 4165' width='24' height='24' fill='none'/%3E%3Cg id='그룹_1195' data-name='그룹 1195' transform='translate(-760 -294)'%3E%3Cpath id='패스_1485' data-name='패스 1485' d='M7240.17,736.987h14' transform='translate(-6475.17 -435.987)' fill='none' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2'/%3E%3Cpath id='패스_1486' data-name='패스 1486' d='M7240.17,736.987h10.562' transform='translate(-6475.17 -430.987)' fill='none' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2'/%3E%3Cpath id='패스_1526' data-name='패스 1526' d='M7240.17,736.987h14' transform='translate(-6475.17 -425.987)' fill='none' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

.mo_sidebar_btn.toggle {
	background: url("data:image/svg+xml,%3Csvg id='plus' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_4165' data-name='사각형 4165' width='24' height='24' fill='none'/%3E%3Cg id='그룹_1195' data-name='그룹 1195' transform='translate(-760.45 -294.45)'%3E%3Cpath id='패스_1485' data-name='패스 1485' d='M7240.17,736.987h14' transform='translate(-4873.202 4909.844) rotate(-45)' fill='none' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2'/%3E%3Cpath id='패스_1526' data-name='패스 1526' d='M7240.17,736.987h14' transform='translate(-3830.945 -5339.202) rotate(45)' fill='none' stroke='%23fb8c00' stroke-linecap='round' stroke-width='2'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#mo_chat_btn {
	background: url("data:image/svg+xml,%3Csvg id='chat_icon' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_1414' data-name='사각형 1414' width='24' height='24' fill='none'/%3E%3Cg id='그룹_274' data-name='그룹 274' transform='translate(3 6)'%3E%3Cpath id='패스_622' data-name='패스 622' d='M2857.8,1169.9a1.062,1.062,0,0,1-.781-.345l-.9-.984h-4.186a2.787,2.787,0,0,1-3.1-2.759v-5.5a3.135,3.135,0,0,1,3.1-3.162h11.8a3.135,3.135,0,0,1,3.1,3.162v5.5a2.787,2.787,0,0,1-3.1,2.759h-4.245l-.9.984a1.062,1.062,0,0,1-.78.345Zm-5.87-11.742a2.136,2.136,0,0,0-2.112,2.155v5.5c0,1.291,1.091,1.751,2.112,1.751h4.442a.493.493,0,0,1,.449.294.11.11,0,0,0,.018.026l.9.984a.07.07,0,0,0,.118,0l.9-.985a.105.105,0,0,0,.017-.026.493.493,0,0,1,.449-.294h4.5c1.021,0,2.112-.46,2.112-1.751v-5.5a2.136,2.136,0,0,0-2.112-2.155Z' transform='translate(-2848.829 -1157.154)' fill='%23fb8c00'/%3E%3Ccircle id='타원_49' data-name='타원 49' cx='0.76' cy='0.76' r='0.76' transform='translate(5.167 4.807)' fill='%23fb8c00'/%3E%3Ccircle id='타원_50' data-name='타원 50' cx='0.76' cy='0.76' r='0.76' transform='translate(8.24 4.807)' fill='%23fb8c00'/%3E%3Ccircle id='타원_51' data-name='타원 51' cx='0.76' cy='0.76' r='0.76' transform='translate(11.314 4.807)' fill='%23fb8c00'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

/* .mo_fruit_btn {
	background: url("data:image/svg+xml,%3Csvg height='24px' viewBox='0 1 511 511.999' width='24px' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m498.699219 222.695312c-.015625-.011718-.027344-.027343-.039063-.039062l-208.855468-208.847656c-8.902344-8.90625-20.738282-13.808594-33.328126-13.808594-12.589843 0-24.425781 4.902344-33.332031 13.808594l-208.746093 208.742187c-.070313.070313-.144532.144531-.210938.214844-18.28125 18.386719-18.25 48.21875.089844 66.558594 8.378906 8.382812 19.441406 13.234375 31.273437 13.746093.484375.046876.96875.070313 1.457031.070313h8.320313v153.695313c0 30.417968 24.75 55.164062 55.167969 55.164062h81.710937c8.285157 0 15-6.71875 15-15v-120.5c0-13.878906 11.292969-25.167969 25.171875-25.167969h48.195313c13.878906 0 25.167969 11.289063 25.167969 25.167969v120.5c0 8.28125 6.714843 15 15 15h81.710937c30.421875 0 55.167969-24.746094 55.167969-55.164062v-153.695313h7.71875c12.585937 0 24.421875-4.902344 33.332031-13.8125 18.359375-18.367187 18.367187-48.253906.027344-66.632813zm-21.242188 45.421876c-3.238281 3.238281-7.542969 5.023437-12.117187 5.023437h-22.71875c-8.285156 0-15 6.714844-15 15v168.695313c0 13.875-11.289063 25.164062-25.167969 25.164062h-66.710937v-105.5c0-30.417969-24.746094-55.167969-55.167969-55.167969h-48.195313c-30.421875 0-55.171875 24.75-55.171875 55.167969v105.5h-66.710937c-13.875 0-25.167969-11.289062-25.167969-25.164062v-168.695313c0-8.285156-6.714844-15-15-15h-22.328125c-.234375-.015625-.464844-.027344-.703125-.03125-4.46875-.078125-8.660156-1.851563-11.800781-4.996094-6.679688-6.679687-6.679688-17.550781 0-24.234375.003906 0 .003906-.003906.007812-.007812l.011719-.011719 208.847656-208.839844c3.234375-3.238281 7.535157-5.019531 12.113281-5.019531 4.574219 0 8.875 1.78125 12.113282 5.019531l208.800781 208.796875c.03125.03125.066406.0625.097656.09375 6.644531 6.691406 6.632813 17.539063-.03125 24.207032zm0 0'/%3E%3C/svg%3E") center center no-repeat;;
}

.mo_inven_btn {
	
} */

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top {
	/* height: 160px; */
    background: rgba(39, 38, 46, .6);
    position: relative;
    padding: 10px 20px;

	display: flex;
    flex-direction: column;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox {
	height: 105px;
    overflow: auto;
    word-break: break-all;

	max-height: 320px;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox.size {
	height: auto;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox::-webkit-scrollbar {
	display: none;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox > div > * + * {
	margin-top: 4px;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox > div .chat_myself h3,
#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox > div .activity_farm h3 {
	display: inline;
    font-size: 14px;
    color: #6dc3e5;
    font-weight: 700;
    padding: 0;
    margin: 0 6px 0 0;
    border: none;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox > div .chat_other h3 {
	display: inline;
    font-size: 14px;
    color: #FFF;
    font-weight: 700;
    padding: 0;
    margin: 0 6px 0 0;
    border: none;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox > div .chat_myself p,
#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top #mo_tbox > div .chat_other p {
	display: inline;
    white-space: pre-line;
    font-size: 14px;
    color: #FFF;
    font-weight: 400;
}



#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap {
	flex: 1;
	padding: 5px 0 0;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button {
	width: 78px;
	height: 28px;
	margin: 0 6px 0 0;
	background-color: rgba(255, 255, 255, 0.8);
	border-radius: 8px;
	border: 1px solid rgba(0, 168, 250, 1);
	font-size: 14px;
	font-weight: 500;
	color: rgba(0, 168, 250, 1);

	position: relative;


}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button::after {
	content: '';
	position: absolute;
	top: 4px;
	left: 2px;
	width: 11px;
	height: 7px;
	background-color: rgba(255, 255, 255, .9);
	opacity: 0;
	transition: opacity 0.1s;

	border-radius:50% / 50%;
    transform: rotate(330deg);
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button:hover, 
#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button.selected {
	background: linear-gradient(to bottom, #6dc3e5 50%, #2baeea 50%);;
	color: #FFFFFF;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button:hover::after,
#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button.selected::after {
	opacity: 1;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap {
	position: absolute;
    right: 20px;
    top: 10px;
    display: flex;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap > * + * {
	margin-left: 10px;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap .land_chat_box_btn {
	width: 24px;
	height: 24px;
	border-radius: 50%;
	background: rgba(34, 34, 34, .6);
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap .land_chat_box_btn button {
	width: 100%;
	height: 100%;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap .land_chat_box_btn #mo_chat_size {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='16' height='16' viewBox='0 0 16 16'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4148' data-name='사각형 4148' width='16' height='16' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='그룹_783' data-name='그룹 783' opacity='0.8'%3E%3Crect id='사각형_4147' data-name='사각형 4147' width='16' height='16' fill='none'/%3E%3Cg id='그룹_782' data-name='그룹 782'%3E%3Cg id='그룹_781' data-name='그룹 781' clip-path='url(%23clip-path)'%3E%3Cpath id='합치기_25' data-name='합치기 25' d='M-11433.578-4521.8a.234.234,0,0,1-.045-.007.64.64,0,0,1-.367-.371.1.1,0,0,1-.01-.045v-5.77a.084.084,0,0,1,.01-.044.622.622,0,0,1,.229-.295.469.469,0,0,1,.1-.035.043.043,0,0,0,.021,0,.117.117,0,0,0,.034-.014.427.427,0,0,1,.168-.038.432.432,0,0,1,.065,0h.008c.044,0,.1,0,.161,0v-4.98a.528.528,0,0,1,.6-.6h10.208a.689.689,0,0,1,.351.086.542.542,0,0,1,.247.508v10.207a.546.546,0,0,1-.251.515.687.687,0,0,1-.354.086h-4.979a1.232,1.232,0,0,0,0,.161.574.574,0,0,1-.381.628.2.2,0,0,1-.045.007Zm.625-1.037h4.527v-4.538h-4.527Zm.795-5.581h4.185a.2.2,0,0,1,.1.027h0a.508.508,0,0,1,.485.56v4.187h4.54v-9.312h-9.315Zm5.311-.182a.527.527,0,0,1-.348-.333.52.52,0,0,1,.072-.466,1.312,1.312,0,0,1,.106-.117l.653-.652,1.2-1.2h-.7a.525.525,0,0,1-.559-.515.505.505,0,0,1,.414-.5l.024-.007a.494.494,0,0,1,.12-.017h2.272l.078,0a.118.118,0,0,1,.109.1l0,.014v.014a.05.05,0,0,1,0,.021.158.158,0,0,1,.008.048v.655c0,.536,0,1.091,0,1.633a.536.536,0,0,1-.134.354.013.013,0,0,0,0,.007c-.007.006-.018.02-.032.034a.466.466,0,0,1-.288.134.125.125,0,0,1-.055.014.592.592,0,0,1-.147-.021.489.489,0,0,1-.333-.344.2.2,0,0,0-.011-.031.365.365,0,0,1-.033-.13c0-.213,0-.429,0-.635v-.1l-1.137,1.137c-.246.247-.49.494-.734.738a.66.66,0,0,1-.217.144.271.271,0,0,1-.065.017.024.024,0,0,0-.013,0l-.014,0a.285.285,0,0,1-.09.017A.565.565,0,0,1-11426.848-4528.6Z' transform='translate(11435.899 4535.9)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap .land_chat_box_btn #mo_chat_size.click {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='16' height='16' viewBox='0 0 16 16'%3E%3Cdefs%3E%3CclipPath id='clip-path'%3E%3Crect id='사각형_4148' data-name='사각형 4148' width='16' height='16' fill='none'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg id='그룹_783' data-name='그룹 783' opacity='0.8'%3E%3Crect id='사각형_4147' data-name='사각형 4147' width='16' height='16' fill='none'/%3E%3Cg id='그룹_782' data-name='그룹 782'%3E%3Cg id='그룹_781' data-name='그룹 781' clip-path='url(%23clip-path)'%3E%3Cpath id='합치기_25' data-name='합치기 25' d='M-11433.576-4521.8a.13.13,0,0,1-.046-.008.639.639,0,0,1-.37-.37.118.118,0,0,1-.008-.046v-5.768a.116.116,0,0,1,.008-.046.632.632,0,0,1,.232-.292.29.29,0,0,1,.1-.035l.021,0a.237.237,0,0,0,.031-.014.434.434,0,0,1,.169-.04l.063,0h.009a.965.965,0,0,0,.163,0v-4.979a.53.53,0,0,1,.6-.605h10.207a.677.677,0,0,1,.35.089.542.542,0,0,1,.247.508v10.207a.532.532,0,0,1-.253.514.668.668,0,0,1-.353.086h-4.979a1.127,1.127,0,0,0,0,.164.567.567,0,0,1-.381.625.126.126,0,0,1-.043.008Zm.62-1.039h4.531v-4.537h-4.531Zm.8-5.579h4.184a.252.252,0,0,1,.106.026l0,0a.506.506,0,0,1,.484.56v4.187h4.537v-9.312h-9.314Zm5.113-.192h-.006l-.077-.006a.122.122,0,0,1-.109-.1l0-.014v-.015a.052.052,0,0,1,0-.02.2.2,0,0,1-.006-.049l.011-.654c.009-.537.021-1.09.032-1.635a.528.528,0,0,1,.138-.35l0,0a.162.162,0,0,1,.031-.038.473.473,0,0,1,.29-.129.154.154,0,0,1,.058-.012.531.531,0,0,1,.146.023.48.48,0,0,1,.325.35c0,.012.008.021.014.032a.339.339,0,0,1,.029.129c0,.212-.006.428-.009.637l0,.1c.385-.373.771-.746,1.156-1.116q.375-.362.749-.726a.669.669,0,0,1,.215-.138.229.229,0,0,1,.066-.017.018.018,0,0,0,.012,0c.009,0,.014,0,.02,0a.215.215,0,0,1,.086-.017.475.475,0,0,1,.152.025.515.515,0,0,1,.339.336.5.5,0,0,1-.08.465.9.9,0,0,1-.106.118l-.666.64q-.611.59-1.223,1.182l.365.006c.114,0,.227,0,.338.005a.523.523,0,0,1,.551.525.506.506,0,0,1-.421.491l-.023.005a.673.673,0,0,1-.12.015Z' transform='translate(11435.899 4535.9)' fill='%23fff'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .land_chat_box_btn_wrap .land_chat_box_btn #mo_chat_close {
	background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3E%3Cg id='그룹_777' data-name='그룹 777' transform='translate(-1242 -797.387)' opacity='0.8'%3E%3Crect id='사각형_4140' data-name='사각형 4140' width='16' height='16' transform='translate(1242 797.387)' fill='none'/%3E%3Cg id='그룹_775' data-name='그룹 775' transform='translate(1242 797)'%3E%3Crect id='사각형_3929' data-name='사각형 3929' width='16' height='16' transform='translate(0 0.387)' fill='none'/%3E%3Cg id='그룹_561' data-name='그룹 561' transform='translate(3.115 3.114)'%3E%3Cpath id='패스_1187' data-name='패스 1187' d='M0,0V14.365' transform='translate(0 0) rotate(-45)' fill='none' stroke='%23fff' stroke-linecap='round' stroke-width='1.5'/%3E%3Cpath id='패스_1188' data-name='패스 1188' d='M0,0V14.365' transform='translate(10.158 0) rotate(45)' fill='none' stroke='%23fff' stroke-linecap='round' stroke-width='1.5'/%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}


#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot {
	display: flex;
    padding: 10px 20px;
    backdrop-filter: blur(30px);
    -webkit-backdrop-filter: blur(30px);
    background: rgba(39, 38, 46, .8);

	align-items: center;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot > * + * {
	margin-left: 10px;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot .land_bot_btn {
	width: 40px;
    height: 40px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 2px 3px 10px #22222214;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot .land_bot_btn.asmo_close_btn {
	background: #FB8C00;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot .land_bot_btn button {
	width: 100%;
	height: 100%;
}

#mo_chat_btn_close {
	background: url("data:image/svg+xml,%3Csvg id='chat_icon' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_1414' data-name='사각형 1414' width='24' height='24' fill='none'/%3E%3Cg id='그룹_274' data-name='그룹 274' transform='translate(3 6)'%3E%3Cpath id='패스_622' data-name='패스 622' d='M2857.8,1169.9a1.062,1.062,0,0,1-.781-.345l-.9-.984h-4.186a2.787,2.787,0,0,1-3.1-2.759v-5.5a3.135,3.135,0,0,1,3.1-3.162h11.8a3.135,3.135,0,0,1,3.1,3.162v5.5a2.787,2.787,0,0,1-3.1,2.759h-4.245l-.9.984a1.062,1.062,0,0,1-.78.345Zm-5.87-11.742a2.136,2.136,0,0,0-2.112,2.155v5.5c0,1.291,1.091,1.751,2.112,1.751h4.442a.493.493,0,0,1,.449.294.11.11,0,0,0,.018.026l.9.984a.07.07,0,0,0,.118,0l.9-.985a.105.105,0,0,0,.017-.026.493.493,0,0,1,.449-.294h4.5c1.021,0,2.112-.46,2.112-1.751v-5.5a2.136,2.136,0,0,0-2.112-2.155Z' transform='translate(-2848.829 -1157.154)' fill='%23fff'/%3E%3Ccircle id='타원_49' data-name='타원 49' cx='0.76' cy='0.76' r='0.76' transform='translate(5.167 4.807)' fill='%23fff'/%3E%3Ccircle id='타원_50' data-name='타원 50' cx='0.76' cy='0.76' r='0.76' transform='translate(8.24 4.807)' fill='%23fff'/%3E%3Ccircle id='타원_51' data-name='타원 51' cx='0.76' cy='0.76' r='0.76' transform='translate(11.314 4.807)' fill='%23fff'/%3E%3C/g%3E%3C/svg%3E%0A") center center no-repeat;
}

#mo_chat_submit_btn {
	background: url("data:image/svg+xml,%3Csvg id='그룹_1028' data-name='그룹 1028' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Crect id='사각형_4160' data-name='사각형 4160' width='24' height='24' fill='none'/%3E%3Cpath id='패스_1484' data-name='패스 1484' d='M20.893,3.674a1.047,1.047,0,0,0-.835-.634,2.355,2.355,0,0,0-1.027.1q-3.275,1.1-6.553,2.188Q8.319,6.713,4.159,8.1a2.546,2.546,0,0,0-.72.374.984.984,0,0,0-.092,1.534,2.816,2.816,0,0,0,.715.481c.861.422,1.726.834,2.592,1.246l.885.421.068.034L7.176,13.26q-.587,1.446-1.168,2.9a2.639,2.639,0,0,0-.158.593,1.252,1.252,0,0,0,.274,1.012,1.2,1.2,0,0,0,.924.4h0a2.2,2.2,0,0,0,.782-.156c.947-.373,1.89-.756,2.833-1.139l1.1-.445.051-.02.546,1.141q.585,1.224,1.173,2.447a2.834,2.834,0,0,0,.3.511,1.132,1.132,0,0,0,.885.476l.057,0a1.117,1.117,0,0,0,.879-.585,2.726,2.726,0,0,0,.246-.542q2.067-6.189,4.128-12.38.277-.829.552-1.658l.385-1.16.007-.767ZM7.216,16.609q.629-1.576,1.269-3.148l.27-.665c.005-.014.012-.028.018-.043a4.311,4.311,0,0,1,2.481,2.481l-2.195.892c-.554.225-1.109.45-1.666.668a.987.987,0,0,1-.223.048.944.944,0,0,1,.046-.233M18.3,4.744l-7.607,7.6a31.51,31.51,0,0,0-3.3-1.687c-.618-.285-1.255-.579-1.87-.891-.2-.1-.4-.2-.606-.293l-.335-.158ZM14.671,19.389l-.764-1.6q-.841-1.767-1.692-3.531a7.47,7.47,0,0,0-.417-.715q-.07-.109-.138-.219l7.6-7.6-4.568,13.7c-.006-.013-.012-.026-.019-.038' fill='%23fb8c00'/%3E%3C/svg%3E%0A") center center no-repeat;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot .chatbox_footer_input {
	border: 1px solid rgba(99, 99, 99, 1);
	border-radius: 20px;

	backdrop-filter: blur(6px);
	-webkit-backdrop-filter: blur(6px);

	flex: 1;
	height: 40px;

	background: rgba(34, 34, 34, .9);

	display: flex;
    align-items: center;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_bot .chatbox_footer_input input {
	outline: none;
    border: 1px solid rgba(99, 99, 99, 1);
    border-radius: 20px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    flex: 1;
    height: 40px;
    background: rgba(34, 34, 34, .9);
    color: #fff;
}


#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_btn_box_wrap {
	display: flex;
    padding: 10px 20px;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_btn_box_wrap > * + * {
	margin-left: 10px;
}


#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_btn_box_wrap .land_bot_btn {
	width: 40px;
    height: 40px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 2px 3px 10px #22222214;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_btn_box_wrap .land_bot_btn button {
	width: 100%;
	height: 100%;

	transition: all .3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
}

#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_btn_box_wrap .land_bot_btn button img {
	width: 28px;
    height: 28px;
}



/* <!-- MO - 프로필 카드 팝업 --> */
#mo_profile_card .profile_card {
	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

	width: 260px;
}



</style>




<div id='box' class="box">


	<!-- ****************** 모바일, tablet 랜드 퍼블리싱 ****************** -->

	<!-- ********* #land_top_box_wrap ********* -->
	<div id="land_top_box_wrap">
		<div class="land_top_box">

			<!-- 디자인 상 슬라이드 swiperjs 추가 -->
			<div class="land_top_left_box swiper-container">
				
				<div class="video_call_box_wrap swiper-wrapper">
					<div class="video_call_box swiper-slide mic_on">
						<span>닉네임</span>
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
					</div>
					<div class="video_call_box swiper-slide ">
						<span>닉네임</span>
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
					</div>
					<div class="video_call_box swiper-slide">
						<span>닉네임</span>
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
					</div>
					<div class="video_call_box swiper-slide">
						<span>닉네임</span>
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
					</div>
					<div class="video_call_box swiper-slide">
						<span>닉네임</span>
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
					</div>
				</div>

			</div>

			<div class="land_top_right_box">
				<div class="video_setting_box">

					<!-- 클릭 시 toggle 클래스를 추가 및 삭제하면 됩니다. -->
					<button id="mo_toggle_mic" class="toggle">
						
					</button>

					<!-- 클릭 시 toggle 클래스를 추가 및 삭제하면 됩니다. -->
					<button id="mo_toggle_camera">
						
					</button>
					
				</div>

				<div class="land_top_btn_box"><button id="mo_user_list"></button></div>
				<div class="land_top_btn_box"><button id="mo_device_setting"></button></div>
			</div>
		</div>
	</div>
		


	<!-- ********* #land_bot_box_wrap ********* -->
	<div id="land_bot_box_wrap">
		<div class="land_bot_btn_box">

			<div class="land_bot_btn"><button id="mo_fruit_btn" class="mo_fruit_btn"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.png" alt="fruit"></button></div>
			<div class="land_bot_btn"><button id="mo_inven_btn" class="mo_inven_btn"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/inventory.png" alt="inventory"></button></div>

			<div class="land_bot_btn"><button id="mo_sidebar" class="mo_sidebar_btn">
				<!-- 클릭 시 toggle 클래스 추가 해야함 -->
			</button></div>
			<div class="land_bot_btn"><button id="mo_chat_btn"></button></div>
		</div>

		<div class="land_bot_chat_box_wrap dn">
			<div class="land_chat_box_btn_box_wrap">
				<div class="land_bot_btn"><button id="mo_fruit_btn" class="mo_fruit_btn"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.png" alt="fruit"></button></div>
				<div class="land_bot_btn"><button id="mo_inven_btn" class="mo_inven_btn"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/inventory.png" alt="inventory"></button></div>
			</div>

			<div class="land_chat_box_top">
				<div id="mo_tbox">
				
					<!-- 전체 채팅 -->
					<div id="mo_tbox_chat">
						
						<!--  -->
						<div class="chat_myself">
							<h3>마이랜드에 오신 것을 환영합니다.</h3>
						</div>

						<!-- 채팅 자기자신일 때 -->
						<div class="chat_myself">
							<h3>세움웹</h3>
							<p>어서오세요</p>
						</div>

						<!-- 채팅 상대방일 때 -->
						<div class="chat_other">
							<h3 >관리자</h3>
							<p>안녕하세요</p>
						</div>

						<div class="chat_other">
							<h3>김민수</h3>
							<p>길동님 안녕하세요</p>
						</div>

						<div class="chat_other">
							<h3>김영희</h3>
							<p>출근하신건가요?</p>
						</div>

						<div class="chat_myself">
							<h3>세움웹</h3>
							<p>넵 출근했어요~</p>
						</div>

					</div>

					<!-- 활동 내역 -->
					<div id="mo_tbox_activity" class="dn">
						<!-- 열매를 획득했을 때 -->
						<div class="activity_farm">
							<h3>씨앗이 모두 자라났습니다. 열매를 수확해 주세요.</h3>
						</div>
						<!-- 나머지 활동 내역일 때 -->
						<div class="chat_other">
							<h3 >열매 5개를 획득하였습니다.</h3>
						</div>

						<div class="chat_other">
							<h3 >낚시를 통해 고등어 1마리를 획득하였습니다.</h3>
						</div>

						<div class="chat_other">
							<h3 >열매 3개를 획득하였습니다.</h3>
						</div>

						<div class="chat_other">
							<h3 >낚시를 통해 은갈치 1마리를 획득하였습니다.</h3>
						</div>
					</div>
				</div>

				<div class="chatbox_button_wrap">
					<button class="selected">전체 채팅</button>
					<button>활동 내역</button>
				</div>

				<div class="land_chat_box_btn_wrap">

					<div class="land_chat_box_btn">
						<button id="mo_chat_close"></button>
					</div>
				</div>

			</div>
			<div class="land_chat_box_bot">
					<div class="land_bot_btn"><button id="mo_sidebar_v" class="mo_sidebar_btn"></button></div>
					<div class="land_bot_btn asmo_close_btn"><button id="mo_chat_btn_close"></button></div>

					<div class="chatbox_footer_input">
						<input class="form-control" type="text" name="chatcontent" id="mo_chatinput" placeholder="채팅을 입력해 주세요." style="outline: none;">
					</div>

					<div class="land_bot_btn"><button id="mo_chat_submit_btn"></button></div>
			</div>
		</div>
	</div>
	



	<!-- ****************** 클래스룸 게임 팝업 MO ****************** -->

	<!-- ********* #game_start_popup_mo ********* -->
	<!-- <div class="game_popup_bg" id="game_start_popup_mo">
		<div class="game_popup">
			<div class="game_start_popup">
				<div class="game_popup_header">
					<strong>[게임 방법]</strong>
				</div>
				<div class="game_popup_main">
					<div class="game_popup_main_cont">
						<p>제한 시간 안에 퀴즈 박스를 찾아 문제를 풀고 FINISH 지점에 도착하세요!</p>
					</div>
					<button id="game_start_btn">게임 시작하기</button>
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_wait_popup_mo ********* -->
	<!-- <div id="game_wait_popup_mo">
		<div class="game_wait_popup">
			<div class="game_wait_popup_bg">
				<strong id="game_wait_num">3</strong>
			</div>

			<div class="game_wait_popup_bottom">
				<p>잠시 후 게임이 시작됩니다.</p>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_test_btn_popup_mo ********* -->
	<!-- <div id="game_test_btn_popup_mo">
		<div class="game_popup game_btn">
			<div class="game_test_popup">
				<div class="game_popup_header">
					<strong>[문제 <span id="game_test_num">1</span>]</strong>
				</div>
				<div class="game_popup_main">
					<div class="game_popup_main_cont">
						<p id="game_test_title">2023년도 MMA(멜론 뮤직 어워드) 올해의 레코드를 받은 그룹은 누구일까요?</p>
					</div>

					<div class="game_test_answer_wrap">
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn1">[1] 엔시티 드림</button>
						</div>
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn2">[2] 샤이니</button>
						</div>
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn3">[3] 아이브</button>
						</div>
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn4">[4] 뉴진스</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_test_input_popup_mo ********* -->
	<!-- <div id="game_test_input_popup_mo">
		<div class="game_popup game_input">
			<div class="game_test_popup">
				<div class="game_popup_header">
					<strong>[문제 <span id="game_test_num">2</span>]</strong>
				</div>
				<div class="game_popup_main">
					<div class="game_popup_main_cont">
						<p id="game_test_title">2023년도 MMA(멜론 뮤직 어워드) 올해의 레코드를 받은 그룹은 누구일까요?</p>
					</div>

					<div class="game_test_input_wrap">

						<div class="game_test_input_box">
							<input type="text" id="game_test_input" placeholder="정답을 입력해주세요.">
						</div>

						<div class="game_test_input_btn_box">
							<button class="game_test_input_btn" id="game_test_input_btn">입력</button>
						</div>

					</div>
					
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_top_fixed_box_mo ********* -->
	<!-- <div id="game_top_fixed_box_mo">
		<div class="game_top_fixed_box">
			<div class="game_top_fixed_test_num_box">
				<p class="game_top_fixed_test_num"><span id="game_top_test_num">1</span> / <span id="game_top_test_entire_num">10</span></p>
			</div>

			<div class="game_top_fixed_test_time_box">
				<p class="game_top_fixed_test_time"><span id="game_top_test_time">00:00</span></p>
			</div>
		</div>

		<div class="game_top_fixed_box_bg"></div>
		<div class="game_top_fixed_box_bg_2"></div>
	</div> -->

	<!-- ********* #game_over_box_mo ********* -->
	<!-- <div class="game_popup_bg asmo_mo" id="game_over_box_mo">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p>제한 시간이 종료되었습니다. <br> 다시 도전하시겠습니까?</p>

				<div class="game_over_box_btn ">
					<button class="game_over_box_btn1" id="game_restart_btn">다시 도전</button>
					<button class="game_over_box_btn2" id="game_quit_btn">그만하기</button>
				</div>
			</div>
		</div>
	</div> -->

	<!-- ********* #game_ing_box_mo ********* -->
	<!-- <div class="game_popup_bg asmo_mo" id="game_ing_box_mo">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p class="game_ing_box_p">문제를 다 풀지 않았습니다.</p>

				<div class="game_over_box_btn game_ing_box_btn">
					<button id="game_ing_btn">확인</button>
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_complete_box_mo ********* -->
	<!-- <div class="game_popup_bg asmo_mo" id="game_complete_box_mo">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p class="game_ing_box_p">게임 학습을 완료하였습니다.</p>

				<div class="game_over_box_btn game_complete_box_btn">
					<button id="game_complete_btn">확인</button>
				</div>
			</div>
		</div>
	</div> -->

	<!-- ********* #game_correct_answer_popup_mo ********* -->
	<!-- <div class="game_answer_popup asmo_mo" id="game_correct_answer_popup_mo">
		<div class="game_answer_popup_box correct_answer">
			<div class="game_answer_popup_img">
				
			</div>

			<div class="game_answer_popup_bottom">
				<p id="game_answer">2023 MMA 올해의 레코드 상은 엔시티 드림, 올해의 아티스트는 뉴진스, 올해의 앨범은 아이브가 수상했습니다.</p>
			</div>
		</div>

		<div class="correct_answer_bg"></div>

		<div class="answer_btn">
			<button id="correct_answer_btn">확인</button>
		</div>
	</div> -->

	<!-- ********* #game_incorrect_answer_popup_mo ********* -->
	<!-- <div class="game_answer_popup asmo_mo" id="game_incorrect_answer_popup_mo">
		<div class="game_answer_popup_box incorrect_answer">
			<div class="game_answer_popup_img">
				
			</div>

			<div class="game_answer_popup_bottom">
				<p id="game_answer">2023 MMA 올해의 레코드 상은 엔시티 드림, 올해의 아티스트는 뉴진스, 올해의 앨범은 아이브가 수상했습니다.</p>
			</div>

			<div class="incorrect_answer_bg"></div>
			<div class="answer_btn">
				<button id="game_incorrect_answer_btn">확인</button>
			</div>
		</div>
	</div> -->


	<!-- ****************** 클래스룸 게임 팝업 PC 주석처리 (231226) ****************** -->

	<!-- ********* #game_start_popup ********* -->
	<!-- <div class="game_popup_bg" id="game_start_popup">
		<div class="game_popup">
			<div class="game_start_popup">
				<div class="game_popup_header">
					<strong>[게임 방법]</strong>
				</div>
				<div class="game_popup_main">
					<div class="game_popup_main_cont">
						<p>제한 시간 안에 퀴즈 박스를 찾아 문제를 풀고 FINISH 지점에 도착하세요!</p>
					</div>
					<button id="game_start_btn">게임 시작하기</button>
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_wait_popup ********* -->
	<!-- <div id="game_wait_popup">
		<div class="game_wait_popup">
			<div class="game_wait_popup_bg">
				<strong id="game_wait_num">3</strong>
			</div>

			<div class="game_wait_popup_bottom">
				<p>잠시 후 게임이 시작됩니다.</p>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_test_btn_popup ********* -->
	<!-- <div id="game_test_btn_popup">
		<div class="game_popup game_btn">
			<div class="game_test_popup">
				<div class="game_popup_header">
					<strong>[문제 <span id="game_test_num">1</span>]</strong>
				</div>
				<div class="game_popup_main">
					<div class="game_popup_main_cont">
						<p id="game_test_title">2023년도 MMA(멜론 뮤직 어워드) 올해의 레코드를 받은 그룹은 누구일까요?</p>
					</div>

					<div class="game_test_answer_wrap">
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn1">[1] 엔시티 드림</button>
						</div>
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn2">[2] 샤이니</button>
						</div>
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn3">[3] 아이브</button>
						</div>
						<div class="game_test_answer_box">
							<button class="game_test_answer_btn" id="game_test_answer_btn4">[4] 뉴진스</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_test_input_popup ********* -->
	<!-- <div id="game_test_input_popup">
		<div class="game_popup game_input">
			<div class="game_test_popup">
				<div class="game_popup_header">
					<strong>[문제 <span id="game_test_num">2</span>]</strong>
				</div>
				<div class="game_popup_main">
					<div class="game_popup_main_cont">
						<p id="game_test_title">2023년도 MMA(멜론 뮤직 어워드) 올해의 레코드를 받은 그룹은 누구일까요?</p>
					</div>

					<div class="game_test_input_wrap">

						<div class="game_test_input_box">
							<input type="text" id="game_test_input" placeholder="정답을 입력해주세요.">
						</div>

						<div class="game_test_input_btn_box">
							<button class="game_test_input_btn" id="game_test_input_btn">입력</button>
						</div>

					</div>
					
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_top_fixed_box ********* -->
	<!-- <div id="game_top_fixed_box">
		<div class="game_top_fixed_box">
			<div class="game_top_fixed_test_num_box">
				<p class="game_top_fixed_test_num"><span id="game_top_test_num">1</span> / <span id="game_top_test_entire_num">10</span></p>
			</div>

			<div class="game_top_fixed_test_time_box">
				<p class="game_top_fixed_test_time"><span id="game_top_test_time">00:00</span></p>
			</div>
		</div>

		<div class="game_top_fixed_box_bg"></div>
		<div class="game_top_fixed_box_bg_2"></div>
	</div> -->

	<!-- ********* #game_over_box ********* -->
	<!-- <div class="game_popup_bg" id="game_over_box">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p>제한 시간이 종료되었습니다. <br> 다시 도전하시겠습니까?</p>

				<div class="game_over_box_btn ">
					<button class="game_over_box_btn1" id="game_restart_btn">다시 도전하기</button>
					<button class="game_over_box_btn2" id="game_quit_btn">그만하기</button>
				</div>
			</div>
		</div>
	</div> -->

	<!-- ********* #game_ing_box ********* -->
	<!-- <div class="game_popup_bg" id="game_ing_box">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p class="game_ing_box_p">문제를 다 풀지 않았습니다.</p>

				<div class="game_over_box_btn game_ing_box_btn">
					<button id="game_ing_btn">확인</button>
				</div>
			</div>
		</div>
	</div> -->


	<!-- ********* #game_complete_box ********* -->
	<!-- <div class="game_popup_bg" id="game_complete_box">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p class="game_ing_box_p">게임 학습을 완료하였습니다.</p>

				<div class="game_over_box_btn game_complete_box_btn">
					<button id="game_complete_btn">확인</button>
				</div>
			</div>
		</div>
	</div> -->

	<!-- ********* #game_correct_answer_popup ********* -->
	<!-- <div class="game_answer_popup" id="game_correct_answer_popup">
		<div class="game_answer_popup_box correct_answer">
			<div class="game_answer_popup_img">
				
			</div>

			<div class="game_answer_popup_bottom">
				<p id="game_answer">2023 MMA 올해의 레코드 상은 엔시티 드림, 올해의 아티스트는 뉴진스, 올해의 앨범은 아이브가 수상했습니다.</p>
			</div>
		</div>

		<div class="correct_answer_bg"></div>

		<div class="answer_btn">
			<button id="correct_answer_btn">확인</button>
		</div>
	</div> -->

	<!-- ********* #game_incorrect_answer_popup ********* -->
	<!-- <div class="game_answer_popup" id="game_incorrect_answer_popup">
		<div class="game_answer_popup_box incorrect_answer">
			<div class="game_answer_popup_img">
				
			</div>

			<div class="game_answer_popup_bottom">
				<p id="game_answer">2023 MMA 올해의 레코드 상은 엔시티 드림, 올해의 아티스트는 뉴진스, 올해의 앨범은 아이브가 수상했습니다.</p>
			</div>

			<div class="incorrect_answer_bg"></div>
			<div class="answer_btn">
				<button id="game_incorrect_answer_btn">확인</button>
			</div>
		</div>
	</div> -->


	<!-- asmo sh 231213 기기 설정 버튼 클릭 시 노출되는 팝업 -->
	<div id="device_setting_bg">
		<div id="device_setting">
			<div class="setting_header">
				<div class="setting_header_left">
					<div class="setting_header_left_img">
						<svg id="settings_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
							<rect id="사각형_3936" data-name="사각형 3936" width="24" height="24" fill="none"/>
							<g id="그룹_579" data-name="그룹 579">
								<path id="패스_1193" data-name="패스 1193" d="M21,9.014a.906.906,0,0,1-.509.679,3.053,3.053,0,0,1-.669.191.293.293,0,0,0-.217.167.54.54,0,0,0,.064.686,1.024,1.024,0,0,1-.122,1.478c-.145.145-.286.294-.44.429a1.011,1.011,0,0,1-1.176.121.625.625,0,0,1-.175-.115c-.239-.277-.492-.178-.745-.034a.232.232,0,0,0-.086.133c-.036.147-.053.3-.091.446a1,1,0,0,1-.947.774c-.245.01-.491.01-.736,0a1.014,1.014,0,0,1-.958-.786.534.534,0,0,1-.031-.155c.015-.316-.161-.464-.443-.546a.261.261,0,0,0-.255.038,1.575,1.575,0,0,1-.727.366.964.964,0,0,1-.785-.221,7.108,7.108,0,0,1-.6-.594,1,1,0,0,1-.111-1.162.892.892,0,0,1,.135-.2.457.457,0,0,0,.069-.61.328.328,0,0,0-.278-.215,1.28,1.28,0,0,1-.841-.345.987.987,0,0,1-.289-.658c-.006-.24-.01-.48,0-.72a1.02,1.02,0,0,1,.843-1,1.8,1.8,0,0,1,.242-.04.381.381,0,0,0,.341-.258.487.487,0,0,0-.087-.579,1.05,1.05,0,0,1,.132-1.534c.133-.132.262-.268.4-.392a1.017,1.017,0,0,1,1.221-.113.569.569,0,0,1,.145.1c.237.276.491.177.743.034a.233.233,0,0,0,.089-.135c.031-.118.043-.241.068-.361a1.021,1.021,0,0,1,.761-.831.26.26,0,0,0,.056-.035h1.018a1.084,1.084,0,0,1,.782.662,2.334,2.334,0,0,1,.1.477.346.346,0,0,0,.215.276.466.466,0,0,0,.622-.076.886.886,0,0,1,.175-.116,1,1,0,0,1,1.177.1,6.055,6.055,0,0,1,.593.595A1,1,0,0,1,19.775,6.1c-.078.13-.171.251-.256.377-.022.033-.06.079-.051.105a1.9,1.9,0,0,0,.194.447c.043.062.174.072.268.086a1.13,1.13,0,0,1,.791.365A1.108,1.108,0,0,1,21,8ZM19.017,5.573a.87.87,0,0,0-.089-.13c-.117-.122-.241-.238-.358-.361a.174.174,0,0,0-.262-.021c-.171.124-.346.241-.516.364a.516.516,0,0,1-.56.051c-.265-.121-.536-.23-.808-.334a.5.5,0,0,1-.342-.406c-.035-.208-.075-.414-.107-.622-.02-.129-.077-.2-.219-.194-.164.008-.328,0-.492,0a.174.174,0,0,0-.2.171c-.031.2-.074.4-.1.605a.525.525,0,0,1-.364.449c-.267.1-.533.207-.792.327a.51.51,0,0,1-.559-.048c-.161-.116-.329-.224-.487-.345a.2.2,0,0,0-.318.021c-.1.113-.211.22-.322.323a.19.19,0,0,0-.024.291c.121.165.233.337.353.5a.512.512,0,0,1,.053.559c-.122.265-.233.535-.337.807a.494.494,0,0,1-.4.342c-.207.036-.414.076-.622.108-.13.02-.2.08-.189.221.007.163,0,.327,0,.491a.173.173,0,0,0,.17.2c.2.031.4.074.6.1a.535.535,0,0,1,.457.38c.095.256.2.511.315.759a.531.531,0,0,1-.053.591c-.118.159-.226.327-.344.487a.19.19,0,0,0,.019.291q.174.161.335.335a.19.19,0,0,0,.291.021c.159-.118.327-.226.487-.344a.528.528,0,0,1,.59-.053c.247.118.5.22.759.314a.54.54,0,0,1,.384.473c.027.2.072.391.1.587a.173.173,0,0,0,.2.171c.164,0,.328-.006.491,0a.189.189,0,0,0,.222-.189c.031-.2.074-.4.1-.6a.513.513,0,0,1,.359-.432c.267-.1.532-.21.791-.328a.514.514,0,0,1,.56.051c.166.12.339.231.5.354a.2.2,0,0,0,.3-.031,3.942,3.942,0,0,1,.31-.31.2.2,0,0,0,.022-.319c-.114-.148-.211-.309-.324-.457a.545.545,0,0,1-.056-.622,7.385,7.385,0,0,0,.308-.742.538.538,0,0,1,.472-.385c.19-.027.379-.073.57-.1.135-.018.2-.08.191-.218-.006-.158-.007-.316,0-.474a.192.192,0,0,0-.19-.223c-.208-.033-.415-.073-.622-.107a.494.494,0,0,1-.408-.339c-.1-.272-.213-.543-.335-.808a.515.515,0,0,1,.048-.56q.178-.249.352-.5c.029-.042.051-.089.083-.145" fill="#222"/>
								<path id="패스_1194" data-name="패스 1194" d="M6.192,8.692a1.075,1.075,0,0,1,.738.283.72.72,0,0,0,.941.131c.207-.115.335-.207.348-.445a2.072,2.072,0,0,1,.072-.4A.466.466,0,0,1,8.8,7.933a.45.45,0,0,1,.373.48c-.046.347-.114.692-.18,1.036a.445.445,0,0,1-.311.328c-.362.147-.724.293-1.082.449a.5.5,0,0,1-.529-.044c-.234-.166-.468-.331-.7-.493a.3.3,0,0,0-.465.042c-.163.16-.325.321-.484.485a.291.291,0,0,0-.038.437c.156.227.312.453.476.674a.562.562,0,0,1,.04.638,8.671,8.671,0,0,0-.387.937.573.573,0,0,1-.5.426c-.266.04-.531.089-.794.14-.211.04-.281.126-.284.333,0,.234,0,.469,0,.7,0,.212.083.3.3.34.27.048.541.1.812.141a.541.541,0,0,1,.451.385c.123.34.264.673.415,1a.538.538,0,0,1-.044.591q-.247.341-.484.689a.291.291,0,0,0,.034.438c.167.172.336.343.509.509a.286.286,0,0,0,.424.031c.237-.161.471-.326.7-.494a.53.53,0,0,1,.576-.042c.334.152.673.3,1.017.423a.529.529,0,0,1,.375.439q.069.406.141.812c.042.234.128.306.369.307.216,0,.433,0,.649,0,.236,0,.317-.065.362-.292.049-.247.1-.493.132-.742a.607.607,0,0,1,.476-.555,5.913,5.913,0,0,0,.887-.37.567.567,0,0,1,.653.042c.215.162.438.313.66.465a.294.294,0,0,0,.451-.038q.245-.24.484-.484a.3.3,0,0,0,.042-.452c-.158-.231-.32-.461-.484-.689a.539.539,0,0,1-.041-.592c.152-.327.29-.662.415-1a.532.532,0,0,1,.436-.379c.265-.046.529-.1.8-.138a.835.835,0,0,1,.3,0,.442.442,0,0,1,.34.436.46.46,0,0,1-.345.434c-.188.044-.378.078-.569.1a.191.191,0,0,0-.187.15.81.81,0,0,1-.107.276.5.5,0,0,0,.076.708,1.713,1.713,0,0,1,.3.511,1.082,1.082,0,0,1-.19,1.121,7.273,7.273,0,0,1-.714.723,1.147,1.147,0,0,1-1.427.115,4.939,4.939,0,0,1-.447-.31.258.258,0,0,0-.329-.035,1.777,1.777,0,0,1-.42.175.26.26,0,0,0-.206.26,4.9,4.9,0,0,1-.1.551,1.174,1.174,0,0,1-1.139.918c-.252.007-.5,0-.755,0a1.205,1.205,0,0,1-1.26-1.058,3.706,3.706,0,0,1-.07-.415.253.253,0,0,0-.208-.257c-.166-.052-.321-.14-.486-.2a.245.245,0,0,0-.186.016c-.193.12-.372.264-.568.381a1.142,1.142,0,0,1-1.354-.124,8.752,8.752,0,0,1-.7-.692,1.143,1.143,0,0,1-.126-1.4c.111-.185.249-.354.361-.539a.262.262,0,0,0,.02-.2,4.074,4.074,0,0,0-.222-.533.293.293,0,0,0-.169-.14c-.192-.049-.391-.068-.585-.112a1.183,1.183,0,0,1-.949-1.169c0-.252,0-.5,0-.755a1.2,1.2,0,0,1,1.028-1.231c.2-.038.446-.016.59-.127s.167-.359.268-.532a.316.316,0,0,0-.042-.406,3.7,3.7,0,0,1-.325-.479,1.133,1.133,0,0,1,.115-1.311A9.671,9.671,0,0,1,5.4,8.967a1.087,1.087,0,0,1,.793-.275" fill="#222"/>
								<path id="패스_1195" data-name="패스 1195" d="M9.934,17.2a3.051,3.051,0,1,1-.114-6.1.47.47,0,0,1,.49.428.448.448,0,0,1-.435.475,2.265,2.265,0,0,0-1.416.531,2.136,2.136,0,1,0,3.525,1.773.681.681,0,0,1,.146-.474.45.45,0,0,1,.486-.1.464.464,0,0,1,.292.441,3.073,3.073,0,0,1-1.918,2.814,2.962,2.962,0,0,1-1.056.215" fill="#222"/>
								<path id="패스_1196" data-name="패스 1196" d="M15.517,10.671A2.18,2.18,0,1,1,17.7,8.5a2.173,2.173,0,0,1-2.18,2.174m-.027-.916A1.265,1.265,0,1,0,14.253,8.47,1.269,1.269,0,0,0,15.49,9.755" fill="#222"/>
							</g>
						</svg>

					</div>
					<div class="setting_header_left_info">
						<p>기기 설정</p>
					</div>
				</div>

				<div class="setting_header_right">
					<button id="device_setting_close">
						<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
							<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
							<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
								<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
								<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
							</g>
						</svg>
					</button>
				</div>

			</div>
			<div class="setting_main">
				<div class="setting_main_top">
					<p>카메라/마이크 확인하기</p>
					<span>랜드에서 직접 카메라와 마이크를 켜지 않으면 다른 사용자들은 보거나 들을 수 없습니다.</span>
				</div>
				<div class="setting_main_mid">
					<div class="setting_video">

						<!-- 비디오 들어갈 자리 -->
						<video id="" autoplay playsinline>
							<source src="" type="">
							비디오 들어갈 자리 입니다.
						</video>
						<!-- 비디오 들어갈 자리 -->

					</div>

					<div class="setting_video_reversal">
						<span>비디오 좌우 반전</span>
						<div class="reversal_btn">
							<input type="checkbox" id="reversal" hidden> 
								<label for="reversal" class="toggleSwitch">
								<span class="toggleButton"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setting_main_bot">
					<div class="camera_setting">
						<span>카메라</span>

						<select name="camera" id="camera_set">
							<option value="0">카메라 1</option>
							<option value="1">카메라 2</option>
							<option value="2">카메라 3</option>
						</select>
					</div>

					<div class="mic_setting">
						<span>마이크</span>

						<select name="mic" id="mic_set">
							<option value="0">마이크 1</option>
							<option value="1">마이크 2</option>
							<option value="2">마이크 3</option>
						</select>
					</div>

					<div class="mic_test">
						<span>마이크 테스트</span>
						<div class="mic_test_bar_bg">
							<div id="mic_test_bar" class="mic_test_bar"></div>
						</div>
					</div>

					<div class="speaker_setting">
						<span>스피커</span>

						<select name="speaker" id="speaker_set">
							<option value="0">스피커 1</option>
							<option value="1">스피커 2</option>
							<option value="2">스피커 3</option>
						</select>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- asmo sh 231213 rtc 박스 클릭 시 노출되는 팝업 -->
	<div id="land_rtc_popup">

		<div class="land_rtc_popup_wrap">
			<!-- 비디오 들어갈 자리 -->
			<video id="" autoplay playsinline>
				<source src="" type="">
				비디오 들어갈 자리 입니다.
			</video>
			<!-- 비디오 들어갈 자리 -->
			<div class="rtc_popup_button">
				<button class="rtc_popup_close">
					<span>최소화</span>
				</button>
			</div>
		</div>
	</div>


	<!-- asmo sh 231206 랜드 우측 버튼 및 화상 박스 퍼블리싱 -->
	<!-- <div id="land_rtc_wrap">
		<div class="setting_btn_box">
			<button id="employee_list_btn">직원 목록</button>
			<button id="device_setting_btn">기기 설정</button>
		</div>

	 	<div class="video_setting_box">
			<button id="toggle_camera">
				<div class="camera_on_box">
					<div class="camera_on">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/video.svg" alt="video" title="video" />
						카메라 켜기
					</div>
				</div>

				<div class="camera_off_box">
					<div class="camera_off">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/video_off.svg" alt="video_off" title="video_off" />
						카메라 끄기
					</div>
				</div>
			</button>
			<button id="toggle_mic">
				<div class="mic_on_box">
					<div class="mic_on">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/mic.svg" alt="mic" title="mic" />
						마이크 켜기
					</div>
				</div>

				<div class="mic_off_box">
					<div class="mic_off">
						<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/mic_off.svg" alt="mic_off" title="mic_off" />
						마이크 끄기
					</div>
				</div>
			</button>
			<button id="share_screen">
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/screen_share.svg" alt="screen_share" title="screen_share" />
				화면 공유
			</button>
			<button id="add_media">
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/media_share.svg" alt="media_share" title="media_share" />
				미디어 추가
			</button>
		</div>

		<div class="video_call_box_wrap">
			<div class="video_call_box mic_on">
				<span>닉네임</span>
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
			</div>
			<div class="video_call_box">
				<span>닉네임</span>
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
			</div>
			<div class="video_call_box">
				<span>닉네임</span>	
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
			</div>
			<div class="video_call_box">
				<span>닉네임</span>	
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
			</div>
			<div class="video_call_box">
				<span>닉네임</span>	
				<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/character_100px.png" alt="character_100px">
			</div>
		</div>
	</div> -->



	<!-- asmo sh 231205 말풍선 퍼블리싱 -->

	<!-- <div id="speech">
		<span id="speech_text">리싱</span>
	</div> -->



	<!-- asmo sh 231205 열매바구니 버튼 퍼블리싱 -->
	<!-- <div id="fruit_btn">
		<div class="fruit_icon">
			<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.png" alt="fruit">
		</div>
	</div> -->


	<!-- asmo sh 231205 인벤토리 버튼 퍼블리싱 -->
	<!-- <div id="inventory_btn">
		<div class="inventory_icon">
			<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/inventory.png" alt="inventory">
		</div>
	</div> -->

	<!-- asmo sh 231204 프로필 카드 팝업 -->
	<div class="game_popup_bg" id="profile_card">
		<div class="profile_card">
			<div class="card_top">
				<div class="card_top_flex_box">
					<div class="card_top_left">
						<div class="card_top_left_img">
							<svg id="profile_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<rect id="사각형_3951" data-name="사각형 3951" width="24" height="24" fill="none"/>
								<g id="그룹_597" data-name="그룹 597">
									<path id="패스_1197" data-name="패스 1197" d="M19.492,18.375A6.373,6.373,0,0,0,16.28,12.89a1.443,1.443,0,0,0-1.473-.08A6.048,6.048,0,0,1,9.179,12.8a1.416,1.416,0,0,0-1.432.072A6.367,6.367,0,0,0,4.509,18.3,2.481,2.481,0,0,0,7.136,21c1.624,0,3.248,0,4.872,0,1.64,0,3.279.007,4.919,0a2.469,2.469,0,0,0,2.565-2.62M16.856,19.5c-1.608,0-3.217,0-4.825,0s-3.217,0-4.825,0c-.855,0-1.25-.393-1.2-1.24a4.954,4.954,0,0,1,2.224-3.925.524.524,0,0,1,.593-.051,7.342,7.342,0,0,0,6.337.01.525.525,0,0,1,.6.03,4.963,4.963,0,0,1,2.236,4.014A1.006,1.006,0,0,1,16.856,19.5" fill="#fff"/>
									<path id="패스_1198" data-name="패스 1198" d="M12.018,3A4.5,4.5,0,1,0,16.5,7.516,4.5,4.5,0,0,0,12.018,3m-.034,7.5A3,3,0,1,1,15,7.5a3.007,3.007,0,0,1-3.016,3" fill="#fff"/>
								</g>
							</svg>
						</div>
						<div class="card_top_left_info">
							<p>프로필 카드</p>
						</div>
					</div>
					<div class="card_top_right">
						<button id="profile_card_close">
							<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
								<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
								<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
									<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
									<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
								</g>
							</svg>
						</button>
					</div>
				</div>

				<div class="card_char_img">
					<img src="" alt="">
				</div>

				<div class="card_char_info">
					<div class="card_char_info_name">
						<strong id="card_info_name">홍길동 </strong>
					</div>

					<div class="card_char_info_department">
						<span id="info_department">디자인팀/사업본부 </span>
					</div>
				</div>

				
				<a href="">랜드 방문하기 </a>
				
			</div>

			<div class="card_bottom">
				
				
				<p>이건 상태명 입니다.</p>

			</div>
		</div>
	</div>


	<!-- asmo sh 231204 열매현황 팝업 -->
	<!-- <div id="status_popup">
		<div class="status_box">
			<div class="status_save_box">
				<div class="status_save">
					<div class="status_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.svg" alt="fruit"></div>
					<p>보유 열매 : <span id="fruit_count"><?php echo html_escape($this->member->item('mem_cur_fruit')); ?></span>개</p>
				</div>

				<div class="status_save">
					<div class="status_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/seed.png" alt="seed"></div>
					<p>보유 씨앗 : <span id="seed_count"><?php echo html_escape($this->member->item('mem_cur_seed')); ?></span>개 (<?php echo html_escape($this->member->item('mem_cur_seed')); ?>개 수확 중)</p>
				</div>

				<div class="status_save">
					<div class="status_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fertilizer.png" alt="fertilizer"></div>
					<p>보유 비료 : <span id="fertilizer_count">0</span>개 </p>
				</div>

				<div class="status_save">
					<div class="status_icon"><img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fertilizer.png" alt="fertilizer"></div>
					<p>보유 물 : <span id="water_count">0</span>개 </p>
				</div>
			</div>

			<div class="status_total_box">
				<p>현재까지 모은 열매/씨앗 : <span><?php echo html_escape($this->member->item('mem_cur_fruit')); ?>개 / <?php echo html_escape($this->member->item('mem_cur_seed')); ?>개</span></span></p>
			</div>
			<a href="<?php echo site_url('cmall/orderlist'); ?>">열매 사용 내역</a>
		</div>

		<button id="status_popup_close">
			<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
				<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
				<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
					<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
					<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
				</g>
			</svg>
		</button>
	</div> -->

	<!-- asmo sh 231204 인벤토리 캐릭터 적용 완료 팝업 -->
	<div id="save_char_popup">
		<div class="save_char_box">
			<p>저장이 완료되었습니다.</p>
		</div>
	</div>


	<!-- asmo sh 231204 인벤토리 랜드 적용 완료 팝업 -->
	<div id="save_land_popup">
		<div class="save_land_box">
			<p>적용이 완료되었습니다.</p>
			<button id="save_land_popup_close">닫기</button>
		</div>
	</div>

	<!-- asmo sh 231204 인벤토리 랜드 적용 버튼 팝업 -->
	<div id="save_land_btn_popup">
		<div class="save_land_btn_box">
			<p>적용이 완료되었습니다.</p>
			<div class="save_land_btn_wrap">
				<button id="save_land_btn_popup">확인</button>
				<button id="save_land_btn_popup_close">닫기</button>
			</div>
		</div>
	</div>

	


	<!-- asmo sh 231128 채팅 박스 퍼블리싱 -->

	<div class="dn chatbox">

		<div class="chatbox_wrap">
			<!-- 채팅 박스 상단 -->
			<div class="chatbox_header">
				<div class="chatbox_header_icon">
					<button id="chatbox_size_btn">

					</button>
					<button id="chatbox_close_btn">

						<svg id="cancel_icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
						<g id="cancel_icon-2" data-name="cancel_icon" transform="translate(-1242 -797.387)" opacity="0.8">
							<rect id="사각형_4140" data-name="사각형 4140" width="16" height="16" transform="translate(1242 797.387)" fill="none"/>
							<g id="그룹_775" data-name="그룹 775" transform="translate(1242 797)">
							<rect id="사각형_3929" data-name="사각형 3929" width="16" height="16" transform="translate(0 0.387)" fill="none"/>
							<g id="그룹_561" data-name="그룹 561" transform="translate(3.115 3.114)">
								<path id="패스_1187" data-name="패스 1187" d="M0,0V14.365" transform="translate(0 0) rotate(-45)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
								<path id="패스_1188" data-name="패스 1188" d="M0,0V14.365" transform="translate(10.158 0) rotate(45)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
							</g>
							</g>
						</g>
						</svg>

					</button>
				</div>
			</div>
			<!-- 채팅 박스 상단 -->
			<!-- 채팅 박스 메인 -->
			<div id="tbox">
			
				<!-- 전체 채팅 -->
				<div id="tbox_chat">
					
					<!--  -->
					<div class="chat_myself">
						<h3>마이랜드에 오신 것을 환영합니다.</h3>
					</div>

					<!-- 채팅 자기자신일 때 -->
					<div class="chat_myself">
						<h3>세움웹</h3>
						<p>어서오세요</p>
					</div>

					<!-- 채팅 상대방일 때 -->
					<div class="chat_other">
						<h3 >관리자</h3>
						<p>안녕하세요</p>
					</div>

					<div class="chat_other">
						<h3>김민수</h3>
						<p>길동님 안녕하세요</p>
					</div>

					<div class="chat_other">
						<h3>김영희</h3>
						<p>출근하신건가요?</p>
					</div>

					<div class="chat_myself">
						<h3>세움웹</h3>
						<p>넵 출근했어요~</p>
					</div>

				</div>

				<!-- 활동 내역 -->
				<div id="tbox_activity">
					<!-- 열매를 획득했을 때 -->
					<div class="activity_farm">
						<h3>씨앗이 모두 자라났습니다. 열매를 수확해 주세요.</h3>
					</div>
					<!-- 나머지 활동 내역일 때 -->
					<div class="activity_other">
						<h3 >열매 5개를 획득하였습니다.</h3>
					</div>

					<div class="activity_other">
						<h3 >낚시를 통해 고등어 1마리를 획득하였습니다.</h3>
					</div>

					<div class="activity_other">
						<h3 >열매 3개를 획득하였습니다.</h3>
					</div>

					<div class="activity_other">
						<h3 >낚시를 통해 은갈치 1마리를 획득하였습니다.</h3>
					</div>
				</div>
			</div>
			<!-- 채팅 박스 메인 -->

			<div class="chatbox_button_wrap">
				<button class="selected">전체 채팅</button>
				<button>활동 내역</button>
			</div>
		</div>

		<!-- 채팅 박스 하단 -->
		<div class="chatbox_footer">
			<div class="chatbox_footer_input">
				<input type="text" name="chatcontent" id="chatinput" placeholder="문장을 입력하세요." style="outline: none;">
			</div>
		</div>

		<!-- 채팅내역 열기 버튼  -->
		<button id="chatbox_open_btn">
			채팅내역 열기 
			<svg id="scale_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
				<defs>
					<clipPath id="clip-path">
					<rect id="사각형_4148" data-name="사각형 4148" width="16" height="16" fill="#fb8c00"/>
					</clipPath>
				</defs>
				<rect id="사각형_4147" data-name="사각형 4147" width="16" height="16" fill="none"/>
				<g id="그룹_782" data-name="그룹 782">
					<g id="그룹_781" data-name="그룹 781" clip-path="url(#clip-path)">
					<path id="합치기_25" data-name="합치기 25" d="M-11433.578-4521.8a.234.234,0,0,1-.045-.007.64.64,0,0,1-.367-.371.1.1,0,0,1-.01-.045v-5.77a.084.084,0,0,1,.01-.044.622.622,0,0,1,.229-.295.469.469,0,0,1,.1-.035.043.043,0,0,0,.021,0,.117.117,0,0,0,.034-.014.427.427,0,0,1,.168-.038.432.432,0,0,1,.065,0h.008c.044,0,.1,0,.161,0v-4.98a.528.528,0,0,1,.6-.6h10.208a.689.689,0,0,1,.351.086.542.542,0,0,1,.247.508v10.207a.546.546,0,0,1-.251.515.687.687,0,0,1-.354.086h-4.979a1.232,1.232,0,0,0,0,.161.574.574,0,0,1-.381.628.2.2,0,0,1-.045.007Zm.625-1.037h4.527v-4.538h-4.527Zm.795-5.581h4.185a.2.2,0,0,1,.1.027h0a.508.508,0,0,1,.485.56v4.187h4.54v-9.312h-9.315Zm5.311-.182a.527.527,0,0,1-.348-.333.52.52,0,0,1,.072-.466,1.312,1.312,0,0,1,.106-.117l.653-.652,1.2-1.2h-.7a.525.525,0,0,1-.559-.515.505.505,0,0,1,.414-.5l.024-.007a.494.494,0,0,1,.12-.017h2.272l.078,0a.118.118,0,0,1,.109.1l0,.014v.014a.05.05,0,0,1,0,.021.158.158,0,0,1,.008.048v.655c0,.536,0,1.091,0,1.633a.536.536,0,0,1-.134.354.013.013,0,0,0,0,.007c-.007.006-.018.02-.032.034a.466.466,0,0,1-.288.134.125.125,0,0,1-.055.014.592.592,0,0,1-.147-.021.489.489,0,0,1-.333-.344.2.2,0,0,0-.011-.031.365.365,0,0,1-.033-.13c0-.213,0-.429,0-.635v-.1l-1.137,1.137c-.246.247-.49.494-.734.738a.66.66,0,0,1-.217.144.271.271,0,0,1-.065.017.024.024,0,0,0-.013,0l-.014,0a.285.285,0,0,1-.09.017A.565.565,0,0,1-11426.848-4528.6Z" transform="translate(11435.899 4535.9)" fill="#fb8c00"/>
					</g>
				</g>
			</svg>

		</button>
	</div>








	<!-- //asmo sh 231128 채팅 박스 퍼블리싱 -->






		<div class="box_wrap">
			<div class="box_top">
				<div class="box_btn_wrap">
					<button class="selected">캐릭터</button>
					<button>랜드</button>
				</div>
				<div class="cancle_box">
					<button class="cancle_btn">

						<svg id="cancel_icon" data-name="cancel icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
						<rect id="사각형_3929" data-name="사각형 3929" width="32" height="32" fill="none"/>
						<g id="그룹_561" data-name="그룹 561" transform="translate(8.476 8.408)">
							<path id="패스_1187" data-name="패스 1187" d="M0,0V21.378" transform="translate(0 0) rotate(-45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
							<path id="패스_1188" data-name="패스 1188" d="M0,0V21.378" transform="translate(15.116 0.001) rotate(45)" fill="none" stroke="#00a8fa" stroke-linecap="round" stroke-width="3"/>
						</g>
						</svg>

					</button>
				</div>
			</div>

			<div class="box_bot character">
				<div class="selection_box">
					<ul>
						<li class="selected">헤어</li>
						<li>얼굴</li>
						<li>모자</li>
						<li>옷</li>
						<li>신발</li>
						<li>소품</li>
					</ul>
				</div>
				<div class="character_info_box">

					<div class="product_wrap_bottom_bar"></div>

					<div class="fixed_info">
						<div class="character_img">
							<img src="<?php echo element('view_skin_url', $layout); ?>/img/reset_img.svg" alt="reset_img">
							
						</div>
						<div class="character_button">
							<button id="reset" onClick=""><img src="<?php echo element('view_skin_url', $layout); ?>/img/reset_icon.svg" alt="reset_icon"></button>
							<button id="back"  onClick=""><img src="<?php echo element('view_skin_url', $layout); ?>/img/back_icon.svg" alt="back_icon"></button>
							<button id="save"  onClick=""><img src="<?php echo element('view_skin_url', $layout); ?>/img/save_icon.svg" alt="save_icon"></button>
						</div>
					</div>

					<div class="product_wrap">


						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 캐릭터 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/hair_rainbow.svg" alt="hair_rainbow.svg">
									</div>
								</div>
								<div class="product_name">
									<p>무지개 빛깔 헤어</p>
								</div>
							</div>
						</div>

						<!-- 만약 아이템이 없을 경우 -->
						<!-- <div class="nodata">
							<p>인벤토리에 아이템이 없습니다.</p>
						</div> -->

					</div>
				</div>
			</div>

			<div class="box_bot land">
				<div class="selection_box">
					<ul>
						<li class="selected">가구</li>
						<li>벽지/바닥</li>
						<li>텃밭</li>
						<li>기타</li>
					</ul>
				</div>
				<div class="character_info_box">
					
					<div class="product_wrap_bottom_bar land"></div>

					<div class="product_wrap">


						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>

						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>
						
						<!-- 랜드 상품 등록 하는 곳입니다. -->
						<div class="product_box">
							<div class="box_border">
								<div class="product_img">
									<div class="img_border">
										<img src="<?php echo element('view_skin_url', $layout); ?>/img/office_sofa.svg" alt="office_sofa.svg">
									</div>
								</div>
								<div class="product_name">
									<p>사무실 용 소파</p>
								</div>
							</div>
						</div>


						<!-- 만약 아이템이 없을 경우 -->
						<!-- <div class="nodata">
							<p>인벤토리에 아이템이 없습니다.</p>
						</div> -->

					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">



	//  #land_top_box_wrap swiperjs 스크립트 영역
	const swiper = new Swiper('.swiper-container', {
		loop: false,
		centeredSlides: false,
		slidesPerView: 'auto',
		slideToClickedSlide: true,		
	});


document.addEventListener("DOMContentLoaded", function() {

	

	// ********* 모바일 랜드 퍼블리싱 스크립트 영역 *********
	const land_top_box_wrap = document.querySelector("#land_top_box_wrap");
	const land_bot_box_wrap = document.querySelector("#land_bot_box_wrap");

	const land_bot_btn_box = document.querySelector(".land_bot_btn_box");
	const land_bot_chat_box_wrap = document.querySelector(".land_bot_chat_box_wrap");
	
	const mo_sidebar = document.querySelector("#mo_sidebar");
	const mo_sidebar_v = document.querySelector("#mo_sidebar_v");

	const mo_chat_btn = document.querySelector("#mo_chat_btn");
	const mo_chat_btn_close = document.querySelector("#mo_chat_btn_close");

	const mo_chat_close = document.querySelector("#mo_chat_close");


	// 사이드바 버튼을 눌렀을 때
	mo_sidebar.addEventListener("click", function() {
		land_top_box_wrap.classList.toggle('show');
		land_bot_box_wrap.classList.toggle('show');

		mo_sidebar.classList.toggle('toggle');
		mo_sidebar_v.classList.toggle('toggle');
	});

	mo_sidebar_v.addEventListener("click", function() {
		land_top_box_wrap.classList.toggle('show');
		land_bot_box_wrap.classList.toggle('show');

		mo_sidebar.classList.toggle('toggle');
		mo_sidebar_v.classList.toggle('toggle');
	});

	// 채팅 버튼을 눌렀을 때 
	mo_chat_btn.addEventListener("click", function() {
		land_bot_btn_box.classList.add('dn');
		land_bot_chat_box_wrap.classList.remove('dn');
	});

	mo_chat_btn_close.addEventListener("click", function() {
		land_bot_btn_box.classList.remove('dn');
		land_bot_chat_box_wrap.classList.add('dn');
	});

	mo_chat_close.addEventListener("click", function() {
		land_bot_btn_box.classList.remove('dn');
		land_bot_chat_box_wrap.classList.add('dn');
	});

	// 전체 채팅, 활동 내역 버튼 눌렀을 때
	const mo_tbox_chat = document.querySelector("#mo_tbox_chat");
	const mo_tbox_activity = document.querySelector("#mo_tbox_activity");


	const mo_chatBtn = document.querySelector("#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button:first-child");
	const mo_activityBtn = document.querySelector("#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button:last-child");


	mo_chatBtn.addEventListener("click", function() {
		mo_tbox_chat.classList.remove('dn');
		mo_tbox_activity.classList.add('dn');

		mo_chatBtn.classList.add('selected');
		mo_activityBtn.classList.remove('selected');
	});

	mo_activityBtn.addEventListener("click", function() {
		mo_tbox_chat.classList.add('dn');
		mo_tbox_activity.classList.remove('dn');

		mo_chatBtn.classList.remove('selected');
		mo_activityBtn.classList.add('selected');
	});

	// 사이즈 버튼 눌렀을 때
	const mo_chat_size = document.querySelector("#mo_chat_size");
	const mo_tbox = document.querySelector("#mo_tbox");

	mo_chat_size.addEventListener("click", function() {
		mo_tbox.classList.toggle("size");
		mo_chat_size.classList.toggle("click");
	});


	

	// ********* 기기 설정 버튼을 눌렀을 때  *********
	// const device_setting_btn = document.querySelector("#device_setting_btn");
	// const device_setting_bg = document.querySelector("#device_setting_bg");
	// const device_setting_close 	= document.querySelector("#device_setting_close");

	// device_setting_btn.addEventListener("click", function() {
	// 	device_setting_bg.style.display = "block";
	// });

	// device_setting_close.addEventListener("click", function() {
	// 	device_setting_bg.style.display = "none";
	// });



	// // ********* rtc 영상이 있을 때 클릭 시  *********
	// const videoCallBox = document.querySelectorAll(".video_call_box");
	// const landRtcPopup = document.querySelector("#land_rtc_popup");

	// videoCallBox.forEach(function(item) {
	// 	item.addEventListener("click", function() {
	// 		landRtcPopup.style.display = "block";
	// 	});
	// });

	// landRtcPopup.addEventListener("click", function() {
	// 	landRtcPopup.style.display = "none";
	// });


	// // ********* rtc toggle 버튼 스크립트 영역 *********
	// const toggleCamera = document.querySelector("#toggle_camera");
	// const toggleMic = document.querySelector("#toggle_mic");

	// toggleCamera.addEventListener("click", function() {
	// 	toggleCamera.classList.toggle("off");
	// });

	// toggleMic.addEventListener("click", function() {
	// 	toggleMic.classList.toggle("off");
	// });

	// // ********* 프로필 카드 팝업 스크립트 영역 *********
	// const profileCard = document.querySelector("#profile_card");
	// const profileCardBtn = document.querySelector("#profile_card_close");

	// profileCardBtn.addEventListener("click", function() {
	// 	profileCard.style.display = "none";
	// });


	// // ********* 열매현황 팝업 스크립트 영역 *********
	// const fruitBtn = document.querySelector("#fruit_btn");
	// const statusPopup = document.querySelector("#status_popup");
	// const statusPopupClose = document.querySelector("#status_popup_close");

	// fruitBtn.addEventListener("click", function() {
	// 	statusPopup.style.display = "block";
	// });

	// statusPopupClose.addEventListener("click", function() {
	// 	statusPopup.style.display = "none";
	// });



	// // ********* 인벤토리 적용 완료 팝업 스크립트 영역 *********

	// const saveLandPopup = document.querySelector("#save_land_popup");
	// const saveLandPopupBtn = document.querySelector("#save_land_popup_close");

	// const saveCharPopup = document.querySelector("#save_char_popup");


	// saveLandPopupBtn.addEventListener("click", function() {
	// 	saveLandPopup.style.display = "none";
	// });


	// document.querySelector("#save").addEventListener("click", function() {
	// 	saveCharPopup.style.display = "block";
	// 	saveCharPopup.style.opacity = "1";

	// 	setTimeout(function() {
	// 		saveCharPopup.style.opacity = "0";
	// 		saveCharPopup.style.transition = "opacity .3s";

	// 		setTimeout(function() {
	// 			saveCharPopup.style.display = "none";
	// 		}, 300);

	// 	}, 2000);
	// });





	// // ********* 채팅 박스 스크립트 영역 *********
	// const chatBox = document.querySelector("#tbox_chat");
	// const activityBox = document.querySelector("#tbox_activity");
	// const chatBtn = document.querySelector(".chatbox_button_wrap button:first-child");
	// const activityBtn = document.querySelector(".chatbox_button_wrap button:last-child");

	// const sizeBtn = document.querySelector("#chatbox_size_btn");
	// const tbox = document.querySelector("#tbox");
	
	// const chatOpenBtn = document.querySelector("#chatbox_open_btn");
	// const closeBtn = document.querySelector("#chatbox_close_btn");
	// const chatBoxWrap = document.querySelector(".chatbox_wrap");


	// // 초기 설정
	// chatBox.style.display = "block";
	// activityBox.style.display = "none";
	// chatOpenBtn.style.display = "none";

	// // 채팅 버튼 클릭 시
	// chatBtn.addEventListener("click", function() {
	// 	// 채팅 영역 표시, 활동 내역 영역 숨기기
	// 	chatBox.style.display = "block";
	// 	activityBox.style.display = "none";

	// 	// 버튼 스타일 변경
	// 	chatBtn.classList.add("selected");
	// 	activityBtn.classList.remove("selected");
	// });

	// // 활동 내역 버튼 클릭 시
	// activityBtn.addEventListener("click", function() {
	// 	// 활동 내역 영역 표시, 채팅 영역 숨기기
	// 	chatBox.style.display = "none";
	// 	activityBox.style.display = "block";

	// 	// 버튼 스타일 변경
	// 	chatBtn.classList.remove("selected");
	// 	activityBtn.classList.add("selected");
	// });

	// // 채팅 박스 크기 조절 버튼 클릭 시
	// sizeBtn.addEventListener("click", function() {
	// 	// 채팅 박스 크기 조절
	// 	tbox.classList.toggle("size");
	// 	sizeBtn.classList.toggle("click");
	// });


	// // 채팅 박스 닫기 버튼 클릭 시
	// closeBtn.addEventListener("click", function() {
	// 	console.log("닫기");
		
	// 	// 채팅 박스 닫기
	// 	chatBoxWrap.style.display = "none";

	// 	// 채팅 박스 열기 버튼 표시
	// 	chatOpenBtn.style.display = "block";
	// });

	// // 채팅 박스 열기 버튼 클릭 시
	// chatOpenBtn.addEventListener("click", function() {
	// 	// 채팅 박스 열기
	// 	chatBoxWrap.style.display = "block";

	// 	// 채팅 박스 열기 버튼 숨기기
	// 	chatOpenBtn.style.display = "none";
	// });


	// // ********* //채팅 박스 스크립트 영역 *********

    // const characterBtn = document.querySelector(".box_btn_wrap button:first-child");
    // const landBtn = document.querySelector(".box_btn_wrap button:last-child");
    // const characterBox = document.querySelector(".box_bot.character");
    // const landBox = document.querySelector(".box_bot.land");

	// const boxWrap = document.querySelector("#box .box_wrap");


    // // 초기 설정: 캐릭터 영역은 보이고, 랜드 영역은 숨기기
    // characterBox.style.display = "block";
    // landBox.style.display = "none";

    // // 캐릭터 버튼 클릭 시
    // characterBtn.addEventListener("click", function() {
    //     // 캐릭터 영역 표시, 랜드 영역 숨기기
    //     characterBox.style.display = "block";
    //     landBox.style.display = "none";

	// 	// boxWrap.style.width = "940px";

    //     // 버튼 스타일 변경
    //     characterBtn.classList.add("selected");
    //     landBtn.classList.remove("selected");
    // });

    // // 랜드 버튼 클릭 시
    // landBtn.addEventListener("click", function() {
    //     // 랜드 영역 표시, 캐릭터 영역 숨기기
    //     characterBox.style.display = "none";
    //     landBox.style.display = "block";

	// 	// boxWrap.style.width = "865px";

    //     // 버튼 스타일 변경
    //     characterBtn.classList.remove("selected");
    //     landBtn.classList.add("selected");
    // });


	var type = "<?php echo html_escape($this->cbconfig->get_device_view_type()); ?>"

	console.log(type);
});

</script>
