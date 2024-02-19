<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="./style/reset.css">
    <link rel="stylesheet" href="./style/mobile_listBox.css">

    <title>모바일 채팅</title>
        
    <script src="chat_system.js"></script>

    <script>
        // 유저 idx가 들어온다고 가정
        document.addEventListener("DOMContentLoaded", async (event) => {
            let self_idx = 43;
            let companyIdx = 1;
            
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
            <button id="moChat_close"><img src="./image/close.svg" alt="닫기"></button>
            <div class="mochTxt">
            </div>
            <div class="mobile_chatting">
                <form method="get" id="mobile_ChatFrm">
                    <fieldset>
                        <!-- <legend>채팅 양식</legend> -->
                        <input type="text" placeholder="채팅을 입력해주세요." name="chatting" id="mobileChatting">
                        <button id="mchat_send"><img src="./image/M_Send_icon.png" alt="보내기"></button>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="mobile_chatList">
            <h1>직원목록 <img src="./image/hu_icon.svg" alt=""></h1>
            <ul class="m_ChList">
            </ul>
        </div>
    </div>
</body>
</html>