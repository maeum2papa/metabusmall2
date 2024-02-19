<?php

$user_info = $this->member->item('mem_id');
$companyIdx = $this->member->item('company_idx');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="mobile chatting">
    <meta name="keywords" content="mobile chatting">
    
    <style>
        /* 스크롤 디자인 */
        /* html::-o-scrollbar-thumb:hover {background-color:;} */
        /* Chrome, Safari, Edge 등 웹킷 기반 브라우저 */

        body {
            height: 100vh;
        }
        .mobile_chat ::-webkit-scrollbar {width: 15px;}/*스크롤바 크기*/
        .mobile_chat ::-webkit-scrollbar-track {box-shadow: inset 0 0 5px rgba(0, 0, 0, 0);}/*스크롤바 배경*/
        .mobile_chat ::-webkit-scrollbar-thumb {background: #2222221A 0% 0% no-repeat padding-box;border-radius:10px;
            background-clip: padding-box; border:5px solid transparent;
        }/*스크롤 드래그바*/
        .mobile_chat ::-webkit-scrollbar-button:vertical:start:decrement,::-webkit-scrollbar-button:vertical:start:increment{
            display:block;
            height: 5px;
            /* 스크롤바 위 공간여백 */
        }
        .mobile_chat::-webkit-scrollbar-button:vertical:end:decrement{
            display: block; width:10px;
        }
        /* 모바일 직원목록 */
        .mobile_chat {
            /*padding-top:40px; */
            /*padding-bottom:45px;*/
            display: flex; flex-flow: column-nowrap;
            height: 100vh; width: 100%;
            overflow-y: hidden
        }
        .mobile_chat .mobile_chatList {
            display: inline-block;    
        }
        .mobile_chat .mobile_chatList h1 {
            text-align: center;
            background-color:#F6F9FF;
            /*width:250px; */
            height: 44px;
            width: 100%;
            height: 40px;
            letter-spacing: -0.02em;
        }
        .mobile_chat .mobile_chatList h1 img {
            position: relative; top:7px;
        }
        .mobile_chat .mobile_chatList .m_ChList {
            overflow-y:scroll;
            background-color: #fff;
            /* background-color: pink; */
            width:100%; height: 309px;
        }
        .mobile_chat .mobile_chatList .m_ChList li {
            width:100%; height: 56px;
            border-bottom:1px solid #ddd;
            cursor: pointer;
            display: flex;
        }
        .mobile_chat .mobile_chatList .m_ChList li p {
            margin:10px 0 0 10px;
        }
        .mobile_chat .mobile_chatList .m_ChList li .ch_work {}
        .mobile_chat .mobile_chatList .m_ChList li .ch_name {}

        /* 모바일 채팅창 */
        .mobile_chat #moChat_close {position:absolute; top:5px; right:5px;}
        .mobile_chat .mobile_chatBox {
            padding-left: 12px;
            /*width:730px; */
            flex: 1;
            /*height: 352px;*/
            background-color: #fff;
            display: flex; flex-flow: column nowrap;
            position: relative;
            overflow:hidden;
            /* justify-content: space-between; */
            /*display: none; js에서 수정*/
            visibility: hidden;
        }
        .mobile_chat .mobile_chatBox h1 {
            padding:10px 10px;
            height: 44px;
        }
        .mobile_chat .mobile_chatBox .mochTxt {
            width:100%px; height:240px;
            overflow-y: scroll;
        }
        .mobile_chat .mobile_chatBox .mochTxt .moChat {}
        .mobile_chat .mobile_chatBox .mochTxt .chtxt1 {
            display: flex; flex-flow: column nowrap; 
            justify-content: flex-start; align-items: flex-end;
            margin-bottom:16px;
        }
        .mobile_chat .mobile_chatBox .mochTxt .chtxt2 {
            display: flex; flex-flow: column nowrap; 
            justify-content: flex-start; align-items: flex-start;
            margin-bottom:16px;
        }
        .mobile_chat .mobile_chatBox .chtxt1 .moChat_con {
            text-align: right;
            /*width:300px;*/
            max-width:calc(100% - 75px);
            background-color: #FB8C001A;
            padding:8px 12px;
            border-radius: 10px 10px 0px 10px;
            font-size: 14px;
            line-height: 20px;
        }
        .mobile_chat .mobile_chatBox .mochTxt .moChat_time {
            margin-top: 10px;
            opacity: 0.4;
        }
        .mobile_chat .mobile_chatBox .chtxt1 .moChat_time span {}
        .mobile_chat .mobile_chatBox .chtxt1 .moChat_time em {}
        .mobile_chat .mobile_chatBox .chtxt2 {}
        .mobile_chat .mobile_chatBox .chtxt2 .moChat_con {
            text-align: left;
            /*width:200px;*/
            margin-top: 16px;
            background-color:#F6F9FF; padding:8px 12px;
            max-width:calc(100% - 70px);
            border-radius: 10px 10px 10px 0px;
            font-size: 14px;
        }
        .mobile_chat .mobile_chatBox .chtxt2 .moChat_time {}
        .mobile_chat .mobile_chatBox .chtxt2 .moChat_time span {}
        .mobile_chat .mobile_chatBox .chtxt2 .moChat_time em {}

        /* 채팅창 입력칸 */
        .mobile_chat .mobile_chatting {
            bottom: 14px;
        }
        .mobile_chat .mobile_chatting #mobile_ChatFrm {
            background-color:#fff; padding: 10px;
            position: relative;
        }
        .mobile_chat .mobile_chatting #mobile_ChatFrm fieldset {}
        .mobile_chat .mobile_chatting #mobile_ChatFrm fieldset #mobileChatting::placeholder {opacity: 0.3;}
        .mobile_chat .mobile_chatting #mobile_ChatFrm fieldset #mchat_send {position:absolute; bottom:15px; right:23px;}
        .mobile_chat .mobile_chatting #mobile_ChatFrm fieldset #mobileChatting {
            width:100%; 
            height: 44px;
            border-radius: 10px;
            padding: 11px 16px 11px 16px;
            border:1px solid #000;
        }

        .Fdchatting {background-color:#00A8FA; color:#fff;
            font-weight: 400; 
            /*width: 20%; */
            padding:10px;
            height: 55%; 
            border-radius: 8px; font-size: 14px; margin: auto;
            display: block;
            transition: all 0.1s linear;
            margin-left: 0;
            margin-right: 0;
        }
    
        * {box-sizing:border-box;}
        /* font */
        @font-face {
            font-family: 'NEXON_Lv2_Gothic';
            /*src: url(../font/NEXON_Lv2_Gothic.woff) format('woff');*/
            src: url("https://collaborland.kr:8000/rtc/font/NEXON_Lv2_Gothic.woff") format('woff');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'NexonLv2Gothic';
            /*src: url(../font/NEXON_Lv2_Gothic_Bold.woff) format('woff');*/

            src: url("https://collaborland.kr:8000/rtc/font/NEXON_Lv2_Gothic_Bold.woff") format('woff');
            font-weight: 700;
            font-style: normal;
        }
        /* reset.css */
        html, body,
        h1,h2,h3,h4,h5,h6,p, blockquote,address,
        span,strong,em,q,sub,sup,del,s,a,img,
        div,header,nav,aside,main,footer,article,figure,figcaption,
        section,video,
        table,thead,tbody,tfoot,tr,th,td,ul,ol,li,dl,dt,dd,
        form,fieldset,legend,input,select,option,button,label,textarea {
            font-family: 'NexonLv2Gothic';
            margin:0; padding:0; line-height:1.0;
            font-size:16px; font-style:normal; font-weight:400;
            text-decoration:none; letter-spacing: -0.02em;
        }
        th {text-align:left;}
        table, tr, th, td {border-collapse:collapse;}
        ul,ol,li {list-style:none;}
        a {color:#000;}
        input {outline:none; border:0;}
        button {cursor:pointer; border:0; background: transparent;}
        fieldset {border:0;}
        .skip {display:none;}
    </style>


    <!--<link rel="stylesheet" href="./style/reset.css">-->
    <!--<link rel="stylesheet" href="./style/mobile_listBox.css">-->

    <title>모바일 채팅</title>        

    <script>
        const CHAT_API_URL = `https://collaborland.kr:8088/ws_sample`;
        const CHAT_SERVER_URL = `wss://collaborland.kr:8088/ws_chatserver`;
        const PAGE_COUNT = 10;

        class ChatSystem {
            static INSTANCE = null;

            // DO NOT USE! BECAUSE THIS IS SINGLE-TON
            constructor() {
            }

            static getInstance() {
                if (ChatSystem.INSTANCE === null) {
                    ChatSystem.INSTANCE = new ChatSystem();
                }

                return ChatSystem.INSTANCE;
            }

            // INSTANCE에 정보 바인딩하기
            initBinding(self_idx, selectChatCallBack, addNewMessageCallBack, companyIdx) {
                this.socket;

                this.self_idx = self_idx;

                // target_idx,
                this.chatMessages = new Map();
                this.companyIdx = companyIdx;

                // 방 정보 가져와서 Map에 추가하기 (이름만)
                // chatMessages.set(+target, new ChatList(self_id, +target));                  
                // Chatting 목록 View에 추가하기

                // view 호출하기

                // user 클릭시 메세지 처리해서 분기처리하는 코드
                this.selectChatCallBack = selectChatCallBack;
                this.addNewMessageCallBack = addNewMessageCallBack;
                this.selectedChatsKey = null;


                this.connect_websocket(this.socket, this.self_idx);
            }

            
            add_users(callbacks) {        
                fetch(`https://collaborland.kr:8000/empolyee_list?companyIdx=${this.companyIdx}`)
                .then(response => response.json())
                .then(data => {
                    for (let i = 0; i < data.length; ++i) {
                        let target_idx = data[i].id;
                        let target_info = {};
                        target_info.div = data[i].div;
                        target_info.nick = data[i].nick;
                        target_info.id = data[i].id;
        
                        if (!this.chatMessages.has(target_idx)) {
                        this.chatMessages.set(target_idx, new ChatList(this.self_idx, +target_idx, target_info));   
                        }
                    }
                    
                    if (callbacks !== null) {
                        callbacks(this.chatMessages);
                    }
                }).catch(error => {
                    console.log("오류 발생" + error);
                })  
            }

            get_name_by_id(id) {
                if (this.chatMessages.has(id)) {
                    return this.chatMessages.get(id).meta_data.nick
                }

                return null;
            }


            selectChatByKey(key) {
                let chatMessages = this.chatMessages;
                let list = chatMessages.has(key) ? chatMessages.get(key).msg_list : null;        
                this.selectedChatsKey = key;
                this.selectChatCallBack(key, list);
            }

            connectToWebSocket(socket, self_idx) {
                return new Promise((resolve, reject) => {
                    socket = new WebSocket(CHAT_SERVER_URL);

                    socket.addEventListener('open', () => {
                        console.log('Chatting server connect successfully');
                        socket.send(`${JSON.stringify({ 'register_id': self_idx })}`);

                        resolve(socket);
                    });

                    socket.addEventListener('error', (error) => {
                        console.error('Error of WebSocket Connection :', error);
                        reject(error);
                    });
                });
            }


            async connect_websocket(socket, self_idx) {
                socket = await this.connectToWebSocket(socket, self_idx);
                this.socket = socket;

                let chatMessages = this.chatMessages;        

                socket.addEventListener('message', (event) => {
                    if (event.data === "check") {
                        socket.send("check");
                        return;
                    }

                    // 아이디 등록 성공시 -> 활성화
                    const response = JSON.parse(event.data);
                    console.log(response);

                    if (response.response === "message") {
                        let target;

                        if (response.error) {
                            /*target = "Clear";
                            if (!chatMessages.has("Clear")) {
                                chatMessages.set("Clear", new ChatList(self_id, "Clear"));
                            } */                   
                            console.log(`에러 메세지 ${error}\n`);

                        } else {
                            target = +response.sender_id === self_idx ? +response.recv_id : +response.sender_id;

                            let msg_list = chatMessages.get(+target)                    
                            let nMsg = msg_list.Msg_addMsg(-1, +response.sender_id, +response.recv_id, response.data, response.reg_time);                    

                            if (this.selectedChatsKey === +target) {
                                // 메세지가 현재 화면일 경우 추가함
                                if (this.addNewMessageCallBack !== null) {
                                    this.addNewMessageCallBack(nMsg);
                                }
                            }
                        }
                    }
                })

            }

            sendMessage(message) {
                this.socket.send(`${JSON.stringify({'request': 'message', 'sender_id': `${this.self_idx}`, 'recv_id': `${this.selectedChatsKey}`, 'data': `${message}`})}`);
            }


            // 스크롤에 적용함
            addInfinitePaging() {
                if (this.selectedChatsKey !== null) {
                    let list = this.chatMessages.get(this.selectedChatsKey)
                    if (list === undefined || list === null) {
                        console.log("add Infinite Paging, list is error\n");
                        return;
                    }

                    list.getPreviousMsg();
                }
            }
        }


        class ChatList {
            constructor(self_idx, target_idx, meta_data) {
                // [ 여기 ]        
                this.self_idx = self_idx;
                this.target_idx = target_idx;
                this.first_index = null;
                this.meta_data = meta_data;


                // 이전 자료를 전부 가져온 경우
                this.is_ended = false;
                this.page = 0;
                // 첫 번째 요소를 기준으로 계속 이전 데이터를 가져오게 페이징처리함
                // 스크롤이 최상단인 경우 && is_ended가 false인 경우 이전 자료를 요청함
                this.msg_list = [];

                this.already = false;

                this.getPreviousMsg();
            }


            Msg_addMsg(idx, send_user_idx, recv_user_idx, msg, reg_time) {
                let n_msg = new Msg(idx, send_user_idx, recv_user_idx, msg, reg_time, send_user_idx === this.self_idx);
                if (idx == -1) {
                    this.msg_list.push(n_msg);
                }

                return n_msg
            }

            // TODO: 페이징 처리 하기
            getPreviousMsg() {

                if (this.already) {
                    console.log("이미 가져오는 중");
                    return;
                }

                // 이미 다 가져옴
                if (this.is_ended) {
                    console.log("이미 다 가져옴");
                    return;
                }

                this.already = true;

                let body = {
                    self_idx: `${this.self_idx}`,
                    target_idx: `${this.target_idx}`
                };

                // 이전값이 있는 경우 가져와서 붙여
                if (this.first_index !== null && this.first_index !== -1) {
                    body.first_idx = this.first_index;
                }        

                // api 요청        
                fetch(`${CHAT_API_URL}/get_messages`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"                
                    },
                    body: JSON.stringify(body),            
                })
                    .then(response => response.json())
                    .then(data => {
                        this.already = false;

                        let list = [];
                        for (let i = 0; i < data.rows.length; ++i) {
                            let row = data.rows[i];
                            if (this.first_index === -1 || this.first_index > row.sender_idx) {
                                this.first_index = row.msg_idx;
                            } else if (this.first_index === null) {
                                this.first_index = row.msg_idx;
                            }

                            let n_msg = new Msg(row.msg_idx, row.sender_idx, row.receiver_idx, row.msg, row.reg_time, row.sender_idx === this.self_idx);
                            list.push(n_msg);
                            if (this.msg_list.length !== 0) {
                                this.msg_list.splice(0, 0, n_msg);;
                            } else {
                                this.msg_list.push(n_msg);
                            }
                        }

                        if (this.target_idx === ChatSystem.INSTANCE.selectedChatsKey && this.selectChatCallBack !== null) {
                            ChatSystem.INSTANCE.selectChatCallBack(this.target_idx, list, true);
                        }

                        if (data.rows.length < PAGE_COUNT) {
                            this.is_ended = true;
                        }

                    }).catch(error => {
                        console.log("오류 발생" + error);
                        this.already = false;
                    }).finally(() => {
                        console.log("메세지 가져오는 것 종료됨!");                            
                    })

                // 저장
            }
        }

        class Msg {
            constructor(idx, send_user_idx, recv_user_idx, msg, reg_time, is_mine) {
                this.idx = idx;
                this.send_user_idx = send_user_idx;
                this.recv_user_idx = recv_user_idx;
                this.msg = msg;
                this.reg_time = reg_time;
                this.is_mine = is_mine;
            }

            string_msg_to_txt() {
                return `${this.msg}`;
            }
        }
        
        let self_idx = <?php echo $user_info; ?>;
        let companyIdx = <?php echo $companyIdx; ?>;;

        // 유저 idx가 들어온다고 가정
        document.addEventListener("DOMContentLoaded", async (event) => {    
            let c = ChatSystem.getInstance();

            // 메세지 관련 처리
            let messageInput = document.getElementById('mobileChatting');            

            messageInput.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    if (messageInput.value.trim() !== '') {
                        let message = `${messageInput.value}`;


                        // 메시지 입력란 비우기
                        messageInput.value = '';

                        c.sendMessage(message = message);
                    }
                }
            })

            document.getElementById("mchat_send").addEventListener("click", function(event) {
                if (messageInput.value.trim() !== '') {
                        let message = `${messageInput.value}`;


                        // 메시지 입력란 비우기
                        messageInput.value = '';

                        c.sendMessage(message = message);
                    }
            })
            
            // 직원 눌렀을 때 필요한 메세지 바인딩
            let selectChatCallBack = function (key, list, append_option = false) {
                console.log(`key ${key}`);
                
                // 이름
                let target_name = document.getElementById("mobile_chatName");
                let scrollDiv = document.getElementsByClassName("mochTxt")[0];
                let chatBox = scrollDiv;
                target_name.textContent = `${c.get_name_by_id(key)}`;				

                let scrollDown = false;

                // 나 인경우
                if (!append_option) {
                    // 작아서 스크롤이 맨 아래에 있을 때, 페이징 하면서 위로 올라오는 거 방지함
                    chatBox.innerHTML = "";

                    if (scrollDiv.scrollHeight < scrollDiv.offsetHeight) {
                        scrollDown = true;
                    } else if (scrollDiv.scrollTop === 0) { // 0이면 스크롤 position이 초기화 되어서 1만큼 움직여서 방지함.
                        scrollDiv.scrollTop = 1;
                    }

                    for (message of list) {

                        let div = div_msg_make(message);
                        chatBox.append(div);
                    }

                    scrollDiv.scrollTop = scrollDiv.scrollHeight;

                } else {
                    if (scrollDiv.scrollHeight < scrollDiv.offsetHeight) {
                        scrollDown = true;


                    } else if (scrollDiv.scrollTop === 0) { // 0이면 스크롤 position이 초기화 되어서 1만큼 움직여서 방지함.
                        scrollDiv.scrollTop = 1;
                    }

                    for (message of list) {

                        let div = div_msg_make(message);

                        // 위에 삽입
                        chatBox.insertBefore(div, chatBox.firstChild);
                    }
                }
                if (scrollDown) {
                    scrollDiv.scrollTop = scrollDiv.scrollHeight;
                } else if (scrollDiv.scrollTop === 0) {
                    scrollDiv.scrollTop = 1;
                    c.addInfinitePaging();
                }                            


                // 늘리기
                if (window.flutter_inappwebview !== undefined) {
                    console.log("성공함");
                    window.flutter_inappwebview.callHandler('handlerChatWindow', 'activated_chat');
                } else {
                    console.log("실패함");
                }

            }

            // 새로운 메세지 도착했을 때 callback
            let addNewMessageCallBack = function (nMsg) {
                let scrollDiv = document.getElementsByClassName("mochTxt")[0];
                let chatBox = scrollDiv;
                chatBox.append(div_msg_make(nMsg));

                scrollDiv.scrollTop = scrollDiv.scrollHeight;  
            }


            c.initBinding(self_idx = self_idx, selectChatCallBack = selectChatCallBack, addNewMessageCallBack = addNewMessageCallBack, companyIdx = companyIdx);

            let initEmployeeList = (chatMessages) => {
                let list = document.getElementsByClassName("m_ChList")[0];

                for (let info of chatMessages) {
                    let li = document.createElement("li");
                    let div = document.createElement("div");
                    div.style.width = "50%";
                    div.style.flexDirection = "column";
                    div.style.display = "flex";
                    div.style.flex = 1;

                    let ch_work = document.createElement("p");
                    ch_work.classList.add("ch_work");
                    ch_work.textContent = `${info[1].meta_data.div}`

                    let ch_name = document.createElement("p");
                    ch_name.classList.add("ch_name");
                    ch_name.textContent = `${info[1].meta_data.nick}`;

                    div.appendChild(ch_work);
                    div.appendChild(ch_name);
                    li.appendChild(div);

                    if (info[1].target_idx !== self_idx) {                    
                        let button = document.createElement("button");
                        button.classList.add("Fdchatting");
                        button.addEventListener("click", (event) => {
                            const moChatting = document.querySelector('.mobile_chat > .mobile_chatBox')
                            moChatting.style.visibility = 'visible'    
                            c.selectChatByKey(info[0]);                        
                        })

                        let buttonText = document.createElement("span");
                        buttonText.textContent = "1:1채팅";
                        button.appendChild(buttonText);
                        li.appendChild(button);                                                
                    }
                                        
                    list.appendChild(li);
                }


            }

            c.add_users(initEmployeeList);

            function div_msg_make(nMsg) {
				let div = document.createElement("div");
                div.classList.add("moChat");
                // 나 인경우 chtxt1 , 상대인 경우 chtxt2

				if (nMsg.is_mine) {
					div.classList.add("chtxt1");
	
				} else {
					div.classList.add("chtxt2");
				}

				let chatContents = document.createElement("p");
                chatContents.classList.add("moChat_con");
				chatContents.textContent = nMsg.string_msg_to_txt()                

				let reg_time = document.createElement("p");
                reg_time.classList.add("moChat_time");

                const originalDateString = nMsg.reg_time;
                const originalDate = new Date(originalDateString);

                let padNumber = function (num) {
                    return num.toString().padStart(2, '0');
                }

                // 원하는 포맷으로 변경
                const formattedDate = `${originalDate.getFullYear()}-${padNumber(originalDate.getMonth() + 1)}-${padNumber(originalDate.getDate())} ${padNumber(originalDate.getHours())}:${padNumber(originalDate.getMinutes())}`;
                const time = formattedDate.split(" ");

                let date = document.createElement("span");
                date.textContent = `${time[0]} `;
                reg_time.appendChild(date);

                let em = document.createElement("em");
                em.textContent = time[1];
                reg_time.appendChild(em)

				div.appendChild(chatContents);
				div.appendChild(reg_time);
				return div;

			}

            // 페이징 처리
            let scrollDiv = document.getElementsByClassName("mochTxt")[0];
            scrollDiv.addEventListener('scroll', function() {
                let scrollTop = scrollDiv.scrollTop;

                if (scrollTop == 0) {
                    c.addInfinitePaging();
                }
            })

            // 닫기 창 처리
            const moClose = document.querySelector('#moChat_close')
            moClose.addEventListener('click',function(e){
                if (window.flutter_inappwebview !== undefined) {
                    window.flutter_inappwebview.callHandler('handlerChatWindow', 'inactivated');
                }
                const moChatting = document.querySelector('.mobile_chat > .mobile_chatBox')
                moChatting.style.visibility = 'hidden'
            })

            // 폼이 제출되는 것을 막음
            document.getElementById('mobile_ChatFrm').addEventListener('submit', function(event) {
                event.preventDefault(); // 폼이 제출되는 것을 막음
            });  



        })
    </script>
</head>
<body>
    <div class="mobile_chat">
        <div class="mobile_chatBox">
            <h1 id="mobile_chatName">닉네임</h1>
            <button id="moChat_close"><img src="https://collaborland.kr:8000/rtc/image/close.svg" alt="닫기"></button>
            <div class="mochTxt">
            </div>
            <div class="mobile_chatting">
                <form method="get" id="mobile_ChatFrm">
                    <fieldset>
                        <!-- <legend>채팅 양식</legend> -->
                        <input type="text" placeholder="채팅을 입력해주세요." name="chatting" id="mobileChatting">
                        <button id="mchat_send"><img src="https://collaborland.kr:8000/rtc/image/M_Send_icon.png" alt="보내기"></button>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="mobile_chatList">
            <h1>직원목록 <img src="https://collaborland.kr:8000/rtc/image/hu_icon.svg" alt=""></h1>
            <ul class="m_ChList">
            </ul>
        </div>
    </div>
</body>
</html>
