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
#profile_card {
	width: 390px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
}

#profile_card .profile_card_wrap {
	width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

#profile_card .profile_card_wrap .card_top {
	display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding: 24px 24px 0;
    background: transparent linear-gradient(130deg, #FB8C00 0%, #FDD199 100%) 0% 0% no-repeat padding-box;
    border-radius: 15px 15px 0px 0px;
}

#profile_card .profile_card_wrap .card_top .card_top_flex_box {
	display: flex;
    width: 100%;
}

#profile_card .profile_card_wrap .card_top .card_top_flex_box .card_top_left {
	display: flex;
    align-items: center;
    gap: 4px;
}

#profile_card .profile_card_wrap .card_top .card_top_flex_box .card_top_left p {
	font-size: 18px;
    font-weight: 500;
    color: #fff;
}

#profile_card .profile_card_wrap .card_top .card_top_flex_box .card_top_right {
	margin-left: auto;
}

#profile_card .profile_card_wrap .card_top .card_top_flex_box .card_top_right svg path {
	stroke: #fff;
}

#profile_card .profile_card_wrap .card_top .card_char_img {
	width: 150px;
    height: 150px;
    /* border: 5px solid #fff; */
    box-shadow: 2px 3px 20px #FB8C0014;
    background: #f6f6f6;
    border-radius: 50%;
    margin: 32px 0 16px;
} 

#profile_card .profile_card_wrap .card_top .card_char_img img {
	width: 100%;
	height: 100%;
	border-radius: 50%;
}

#profile_card .profile_card_wrap .card_top .card_char_info .card_char_info_name {
	margin: 0 0 10px;
	text-align: center;
}

#profile_card .profile_card_wrap .card_top .card_char_info .card_char_info_name #card_info_name {
	font-size: 24px;
    color: #fff;
    font-weight: 700;
}

#profile_card .profile_card_wrap .card_top .card_char_info .card_char_info_name #card_info_position {
	font-size: 15px;
    color: #fff;
    font-weight: 700;
}

#profile_card .profile_card_wrap .card_top .card_char_info .card_char_info_department #info_department {
	font-size: 16px;
    color: #fff;
}

#profile_card .profile_card_wrap .card_top > a {
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

#profile_card .profile_card_wrap .card_bottom {
	width: 100%;
    height: 128px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    border-radius: 0px 0px 15px 15px;
}

#profile_card .profile_card_wrap .card_bottom p {
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

#device_setting {
	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    border-radius: 15px;
    background: #fff;
}

#device_setting .setting_header {
	display: flex;
    height: 64px;
    align-items: center;
    padding: 0 24px;
    border-bottom: 1px solid rgba(169, 169, 169, .5);
}

#device_setting .setting_header .setting_header_left {
	display: flex;
    align-items: center;
}


#device_setting .setting_header .setting_header_left p {
	font-size: 18px;
    color: rgba(0, 0, 0, 1);
    font-weight: 500;
}

#device_setting .setting_header .setting_header_right {
	margin-left: auto;
}

#device_setting .setting_header .setting_header_right svg path {
	stroke: #000;
}

#device_setting .setting_main {
	padding: 20px 24px 40px;
}

#device_setting .setting_main .setting_main_top p {
	color: #000000;
    font-size: 16px;
    font-weight: 500;
}

#device_setting .setting_main .setting_main_top span {
	color: rgba(0, 0, 0, .6);
    font-size: 14px;
}

#device_setting .setting_main .setting_main_mid {
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

#device_setting .setting_main .setting_main_mid .setting_video {
	width: 300px;
    height: 180px;
    border-radius: 8px;
	margin: 12px 0;
    background: aqua;
}

#device_setting .setting_main .setting_main_mid .setting_video video {
	width: 100%;
    touch-action: none;
}

#device_setting .setting_main .setting_main_mid .setting_video_reversal {
	display: flex;
    align-items: center;
    padding: 0 0 12px;
    width: 300px;
    justify-content: space-between;
}

#device_setting .setting_main .setting_main_mid .setting_video_reversal > span {
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

#device_setting .setting_main .setting_main_bot {
	display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}

#device_setting .setting_main .setting_main_bot > div {
	display: flex;
    justify-content: space-between;
    align-items: center;

	margin: 0 0 15px;

	width: 100%;
}

#device_setting .setting_main .setting_main_bot > div:last-child {
	margin: 0;
}

#device_setting .setting_main .setting_main_bot > div.mic_test {
	width: 50%;
}

#device_setting .setting_main .setting_main_bot > div.mic_test span {
	font-size: 14px;
    color: rgba(34, 34, 34, .6);
}

#device_setting .setting_main .setting_main_bot > div.mic_test .mic_test_bar_bg {
	width: 180px;
    height: 4px;
    background: rgba(238, 238, 238, 1);
    border-radius: 2px;
}

#device_setting .setting_main .setting_main_bot > div.mic_test .mic_test_bar_bg .mic_test_bar {
	height: 4px;
    background: transparent linear-gradient(90deg, rgba(251, 140, 0, 1) 0%, rgba(254, 227, 194, 1) 100%) 0% 0% no-repeat padding-box;
    border-radius: 2px;


	width: 50px;

}

#device_setting .setting_main .setting_main_bot > div span {
	font-size: 16px;
    color: #000;
}

#device_setting .setting_main .setting_main_bot > div select {
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

#game_wait_popup {
	position: absolute;
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

</style>




<div id='box' class="box">


	<!-- 클래스룸 게임 팝업 -->

	<!-- ********* #game_start_popup ********* -->
	<div class="game_popup_bg" id="game_start_popup">
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
	</div>


	<!-- ********* #game_wait_popup ********* -->
	<div id="game_wait_popup">
		<div class="game_wait_popup">
			<div class="game_wait_popup_bg">
				<strong id="game_wait_num">3</strong>
			</div>

			<div class="game_wait_popup_bottom">
				<p>잠시 후 게임이 시작됩니다.</p>
			</div>
		</div>
	</div>


	<!-- ********* #game_test_btn_popup ********* -->
	<div id="game_test_btn_popup">
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
	</div>


	<!-- ********* #game_test_input_popup ********* -->
	<div id="game_test_input_popup">
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
	</div>


	<!-- ********* #game_top_fixed_box ********* -->
	<div id="game_top_fixed_box">
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
	</div>

	<!-- ********* #game_over_box ********* -->
	<div class="game_popup_bg" id="game_over_box">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p>제한 시간이 종료되었습니다. <br> 다시 도전하시겠습니까?</p>

				<div class="game_over_box_btn ">
					<button class="game_over_box_btn1" id="game_restart_btn">다시 도전하기</button>
					<button class="game_over_box_btn2" id="game_quit_btn">그만하기</button>
				</div>
			</div>
		</div>
	</div>

	<!-- ********* #game_ing_box ********* -->
	<div class="game_popup_bg" id="game_ing_box">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p class="game_ing_box_p">문제를 다 풀지 않았습니다.</p>

				<div class="game_over_box_btn game_ing_box_btn">
					<button id="game_ing_btn">확인</button>
				</div>
			</div>
		</div>
	</div>


	<!-- ********* #game_complete_box ********* -->
	<div class="game_popup_bg" id="game_complete_box">
		<div class="game_popup border_box">
			<div class="game_over_box">
				<p class="game_ing_box_p">게임 학습을 완료하였습니다.</p>

				<div class="game_over_box_btn game_complete_box_btn">
					<button id="game_complete_btn">확인</button>
				</div>
			</div>
		</div>
	</div>

	<!-- ********* #game_correct_answer_popup ********* -->
	<div class="game_answer_popup" id="game_correct_answer_popup">
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
	</div>

	<!-- ********* #game_incorrect_answer_popup ********* -->
	<div class="game_answer_popup" id="game_incorrect_answer_popup">
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
	</div>


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
	<div id="land_rtc_wrap">
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
	</div>



	<!-- asmo sh 231205 말풍선 퍼블리싱 -->

	<div id="speech">
		<span id="speech_text">리싱</span>
	</div>



	<!-- asmo sh 231205 열매바구니 버튼 퍼블리싱 -->
	<div id="fruit_btn">
		<div class="fruit_icon">
			<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/fruit.png" alt="fruit">
		</div>
	</div>


	<!-- asmo sh 231205 인벤토리 버튼 퍼블리싱 -->
	<div id="inventory_btn">
		<div class="inventory_icon">
			<img src="<?php echo element('layout_skin_url', $layout); ?>/seum_img/inventory.png" alt="inventory">
		</div>
	</div>

	<!-- asmo sh 231204 프로필 카드 팝업 -->
	<div id="profile_card">
		<div class="profile_card_wrap">
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
					<!-- 여기에 캐릭터 이미지 넣으시면 됩니다! -->
					<img src="" alt="">
				</div>

				<div class="card_char_info">
					<div class="card_char_info_name">
						<strong id="card_info_name">홍길동 <!-- 여기에 캐릭터 이름 넣으시면 됩니다! --></strong>
					</div>

					<div class="card_char_info_department">
						<span id="info_department">디자인팀/사업본부 <!-- 여기에 캐릭터 부서명 넣으시면 됩니다! --></span>
					</div>
				</div>

				<!-- 여기에 캐릭터랜드 주소 넣으시면 됩니다! -->
				<a href="">랜드 방문하기 </a>
				<!-- 여기에 캐릭터랜드 주소 넣으시면 됩니다! -->
			</div>

			<div class="card_bottom">
				
				<!-- 만약 상태명이 있다면 -->
				<p>이건 상태명 입니다.</p>

				<!-- 만약 상태명이 없다면 -->
				<!-- <p>상태명을 입력하지 않았습니다.</p> -->
			</div>
		</div>
	</div>


	<!-- asmo sh 231204 열매현황 팝업 -->
	<div id="status_popup">
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
	</div>

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

	


	<!-- asmo sh 231128 채팅 박스 퍼블리싱 -->

	<div class="chatbox">

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
						<p>지렁지렁</p>
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


document.addEventListener("DOMContentLoaded", function() {

	// ********* 기기 설정 버튼을 눌렀을 때  *********
	const device_setting_btn = document.querySelector("#device_setting_btn");
	const device_setting_bg = document.querySelector("#device_setting_bg");
	const device_setting_close 	= document.querySelector("#device_setting_close");

	device_setting_btn.addEventListener("click", function() {
		device_setting_bg.style.display = "block";
	});

	device_setting_close.addEventListener("click", function() {
		device_setting_bg.style.display = "none";
	});



	// ********* rtc 영상이 있을 때 클릭 시  *********
	const videoCallBox = document.querySelectorAll(".video_call_box");
	const landRtcPopup = document.querySelector("#land_rtc_popup");

	videoCallBox.forEach(function(item) {
		item.addEventListener("click", function() {
			landRtcPopup.style.display = "block";
		});
	});

	landRtcPopup.addEventListener("click", function() {
		landRtcPopup.style.display = "none";
	});


	// ********* rtc toggle 버튼 스크립트 영역 *********
	const toggleCamera = document.querySelector("#toggle_camera");
	const toggleMic = document.querySelector("#toggle_mic");

	toggleCamera.addEventListener("click", function() {
		toggleCamera.classList.toggle("off");
	});

	toggleMic.addEventListener("click", function() {
		toggleMic.classList.toggle("off");
	});

	// ********* 프로필 카드 팝업 스크립트 영역 *********
	const profileCard = document.querySelector("#profile_card");
	const profileCardBtn = document.querySelector("#profile_card_close");

	profileCardBtn.addEventListener("click", function() {
		profileCard.style.display = "none";
	});


	// ********* 열매현황 팝업 스크립트 영역 *********
	const fruitBtn = document.querySelector("#fruit_btn");
	const statusPopup = document.querySelector("#status_popup");
	const statusPopupClose = document.querySelector("#status_popup_close");

	fruitBtn.addEventListener("click", function() {
		statusPopup.style.display = "block";
	});

	statusPopupClose.addEventListener("click", function() {
		statusPopup.style.display = "none";
	});



	// ********* 인벤토리 적용 완료 팝업 스크립트 영역 *********

	const saveLandPopup = document.querySelector("#save_land_popup");
	const saveLandPopupBtn = document.querySelector("#save_land_popup_close");

	const saveCharPopup = document.querySelector("#save_char_popup");


	saveLandPopupBtn.addEventListener("click", function() {
		saveLandPopup.style.display = "none";
	});


	document.querySelector("#save").addEventListener("click", function() {
		saveCharPopup.style.display = "block";
		saveCharPopup.style.opacity = "1";

		setTimeout(function() {
			saveCharPopup.style.opacity = "0";
			saveCharPopup.style.transition = "opacity .3s";

			setTimeout(function() {
				saveCharPopup.style.display = "none";
			}, 300);

		}, 2000);
	});





	// ********* 채팅 박스 스크립트 영역 *********
	const chatBox = document.querySelector("#tbox_chat");
	const activityBox = document.querySelector("#tbox_activity");
	const chatBtn = document.querySelector(".chatbox_button_wrap button:first-child");
	const activityBtn = document.querySelector(".chatbox_button_wrap button:last-child");

	const sizeBtn = document.querySelector("#chatbox_size_btn");
	const tbox = document.querySelector("#tbox");
	
	const chatOpenBtn = document.querySelector("#chatbox_open_btn");
	const closeBtn = document.querySelector("#chatbox_close_btn");
	const chatBoxWrap = document.querySelector(".chatbox_wrap");


	// 초기 설정
	chatBox.style.display = "block";
	activityBox.style.display = "none";
	chatOpenBtn.style.display = "none";

	// 채팅 버튼 클릭 시
	chatBtn.addEventListener("click", function() {
		// 채팅 영역 표시, 활동 내역 영역 숨기기
		chatBox.style.display = "block";
		activityBox.style.display = "none";

		// 버튼 스타일 변경
		chatBtn.classList.add("selected");
		activityBtn.classList.remove("selected");
	});

	// 활동 내역 버튼 클릭 시
	activityBtn.addEventListener("click", function() {
		// 활동 내역 영역 표시, 채팅 영역 숨기기
		chatBox.style.display = "none";
		activityBox.style.display = "block";

		// 버튼 스타일 변경
		chatBtn.classList.remove("selected");
		activityBtn.classList.add("selected");
	});

	// 채팅 박스 크기 조절 버튼 클릭 시
	sizeBtn.addEventListener("click", function() {
		// 채팅 박스 크기 조절
		tbox.classList.toggle("size");
		sizeBtn.classList.toggle("click");
	});


	// 채팅 박스 닫기 버튼 클릭 시
	closeBtn.addEventListener("click", function() {
		console.log("닫기");
		
		// 채팅 박스 닫기
		chatBoxWrap.style.display = "none";

		// 채팅 박스 열기 버튼 표시
		chatOpenBtn.style.display = "block";
	});

	// 채팅 박스 열기 버튼 클릭 시
	chatOpenBtn.addEventListener("click", function() {
		// 채팅 박스 열기
		chatBoxWrap.style.display = "block";

		// 채팅 박스 열기 버튼 숨기기
		chatOpenBtn.style.display = "none";
	});


	// ********* //채팅 박스 스크립트 영역 *********

    const characterBtn = document.querySelector(".box_btn_wrap button:first-child");
    const landBtn = document.querySelector(".box_btn_wrap button:last-child");
    const characterBox = document.querySelector(".box_bot.character");
    const landBox = document.querySelector(".box_bot.land");

	const boxWrap = document.querySelector("#box .box_wrap");


    // 초기 설정: 캐릭터 영역은 보이고, 랜드 영역은 숨기기
    characterBox.style.display = "block";
    landBox.style.display = "none";

    // 캐릭터 버튼 클릭 시
    characterBtn.addEventListener("click", function() {
        // 캐릭터 영역 표시, 랜드 영역 숨기기
        characterBox.style.display = "block";
        landBox.style.display = "none";

		// boxWrap.style.width = "940px";

        // 버튼 스타일 변경
        characterBtn.classList.add("selected");
        landBtn.classList.remove("selected");
    });

    // 랜드 버튼 클릭 시
    landBtn.addEventListener("click", function() {
        // 랜드 영역 표시, 캐릭터 영역 숨기기
        characterBox.style.display = "none";
        landBox.style.display = "block";

		// boxWrap.style.width = "865px";

        // 버튼 스타일 변경
        characterBtn.classList.remove("selected");
        landBtn.classList.add("selected");
    });
});



</script>