//const API_URL = `http://127.0.0.1:8091`;

const API_URL = `https://collaborland.kr:8088/ws_sample`;
const CHAT_SERVER_URL = `wss://collaborland.kr:8088/ws_chatserver`;
const PAGE_COUNT = 10;

class ChatManager {
    static INSTANCE = null;

    // DO NOT USE! BECAUSE THIS IS SINGLE-TON
    constructor() {
    }

    static getInstance() {
        if (ChatManager.INSTANCE === null) {
            ChatManager.INSTANCE = new ChatManager();
        }

        return ChatManager.INSTANCE;
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
        fetch(`https://collaborland.kr:8000/empolyee_list?companyIdx=${companyIdx}`)
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
        fetch(`${API_URL}/get_messages`,
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

                if (this.target_idx === ChatManager.INSTANCE.selectedChatsKey && this.selectChatCallBack !== null) {
                    ChatManager.INSTANCE.selectChatCallBack(this.target_idx, list, true);
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