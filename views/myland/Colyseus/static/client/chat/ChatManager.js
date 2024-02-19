

class ChatManager {
  client;
  room;
  static instance;
  chatfocus = false;
  players = new Map();
  adminType = false;
  name;
  currentTileIndex = 0;
  noticeDiv;
  noticeTimeOut;
  maxDay = 0;
  preChatLength = 0;
  prePrivateLength = 0;
  preActivityLength = 0;
  isFirstActivity = true;

  //chat class를 만들고 하는게 유지보수가 좋을 것 같은데..?
  constructor() { }
  static getInstance() {
    if (!ChatManager.instance) {
      ChatManager.instance = new ChatManager();
    }

    return ChatManager.instance;
  }

  init(name) {
    ChatManager.getInstance().client = new Colyseus.Client(Config.Domain);
    if (name) {
      this.name = name;
    }
  }

  async create(name, callback) {
    try {
      while (user_Info.otherUser === undefined) {
        await this.sleep(1000);
      }

      user_Info.name = this.name;

      ChatManager.getInstance().room = await ChatManager.getInstance().client.joinOrCreate(`chatRoom_${user_Info.room + '_' + user_Info.companyIdx + '_' + user_Info.otherUser}`, { user_Info });
    } catch (e) {
      console.error("chat error =", e);
    }

    if (!ChatManager.getInstance().room) return;
    if (name) {
      this.contentLoaded(name, callback);

    

      ChatManager.getInstance().room.onMessage('initMessages', (infoText) => {
        let info = infoText;

        for (let i = 0; i < info.length; ++i) {
          ChatManager.getInstance().makeChatDiv("chat", info[i].name, info[i].message,0);
        }
        this.preChatLength = chattBox.querySelectorAll("div").length;
      });


      ChatManager.getInstance().room.state.messageInfo.onAdd((messageInfo, sessionId) => {
        this.players.set(messageInfo.name, '');

        if (sessionId === ChatManager.getInstance().room.sessionId) {
          this.adminType = messageInfo.adminType;

          messageInfo.onChange(() => {
            if (messageInfo.messages === undefined || messageInfo.messages.trim() === '') {
              return;
            }

            ChatManager.getInstance().makeChatDiv("chat", messageInfo.name, messageInfo.messages,messageInfo.currentIndex);
            this.players.set(messageInfo.name, messageInfo.messages);

            ChatManager.getInstance().room.send('resetMessage'); //초기화

            if (this.currentTileIndex < 100) {
              chatBtn.click();
            } else {
              privateBtn.click();
            }

            this.countCheck();
          })
        } else {
          messageInfo.onChange(() => {
            if (messageInfo.messages === undefined || messageInfo.messages.trim() === '' || (messageInfo.currentIndex !== 0 && this.currentTileIndex !== messageInfo.currentIndex)) {
              return;
            }

            ChatManager.getInstance().makeChatDiv("chat", messageInfo.name, messageInfo.messages,messageInfo.currentIndex);
            this.players.set(messageInfo.name, messageInfo.messages);

            this.countCheck();
          })
        }

      })

      ChatManager.getInstance().room.state.messageInfo.onRemove((messageInfo, sessionId) => {
        this.players.delete(messageInfo.name);
      })

      ChatManager.getInstance().room.onMessage('clearMsg', (msg) => {
        this.allChatClear();
        this.countCheck();
      })

      ChatManager.getInstance().room.onMessage('firstActivity', (arrMessage) => {
        for (let i = 0; i < arrMessage.length; ++i) {
          let type = 'other';
          // if (arrMessage[i].txt.indexOf('열매') !== -1) {
          //   type = 'farm';
          // }

          let strDate = new Date(arrMessage[i].dt);
          let curData = new Date(strDate.getFullYear(), strDate.getMonth(), strDate.getDate());
          if (this.maxDay < curData) {
            this.maxDay = curData;
            let text = `=======================${Utils.GetZeroCheck(this.maxDay.getFullYear()) + '-' + Utils.GetZeroCheck(this.maxDay.getMonth() + 1) + '-' + Utils.GetZeroCheck(this.maxDay.getDate())}=======================`;
            let timeType = 'farm';
            ChatManager.getInstance().makeActivityDiv("activity", '', text, timeType);
          }
          let hours = Utils.GetZeroCheck(strDate.getHours());
          let minutes = Utils.GetZeroCheck(strDate.getMinutes());

          let messagedt = hours + ':' + minutes;

          ChatManager.getInstance().makeActivityDiv("activity", '[' + messagedt + ']', arrMessage[i].text, type);
        }

        if (this.isFirstActivity) {
          this.preActivityLength = activityBox.querySelectorAll("div").length;
          this.isFirstActivity = false;
        } else {
          this.countCheck();
        }
      })

      ChatManager.getInstance().room.onMessage('addActivity', (message) => {
        let type = 'other';
        // if (message.text.indexOf('열매') !== -1) {
        //   type = 'farm';
        // }

        let strDate = new Date(message.dt);

        let messagedt = strDate.getHours() + ':' + strDate.getMinutes()

        ChatManager.getInstance().makeActivityDiv("activity", '[' + messagedt + ']', message.text, type);

        this.countCheck();
      })
    }
    this.room.onMessage('commandMessage', async (info) => {
      switch (info.type) {
        case "EveryOne":
          this.makeContent(info.text);
          break;
        case "ServerReStart":
          this.makeContent(info.text);
          break;
        default:
          break;
      }
    })






    chatInput.addEventListener("keyup", (e) => {
      if (e.key === "Enter") {
        const text = chatInput.value;

        if ((text !== '')) {
          chatInput.value = '';
          //let name = playerElement.getName();
        
          if (text.substring(0, 6) === '/clear') {
            if ((+user_Info.otherUser === +user_Info.currentUser) || ((this.adminType === 1 && (user_Info.room === 'land_office' || user_Info.room === 'land_education')))) {
              ChatManager.getInstance().room.send('clearMessage');
            }
            this.chatClear();
          } else if (text.substring(0, 5) === '/help') {
            this.helper();
          }
          else {
            ChatManager.getInstance().send(false, text);
          }

          ChatManager.getInstance().chatfocus = true;
          chatInput.focus();

        }
        else {
          ChatManager.getInstance().chatfocus = false;
        }
      }

    })
    chatInput.addEventListener('keydown', (e) => {
      if (e.isComposing) return;

      switch (e.code) {
        case 'Space':
          const curPos = chatInput.selectionStart;
          const curValue = chatInput.value;
          chatInput.value = curValue.substring(0, curPos) + ' ' + curValue.substring(curPos);
          chatInput.setSelectionRange(curPos + 1, curPos + 1);
          break;
        case 'ArrowLeft':
          {
            const currentPosition = chatInput.selectionStart;
            if (currentPosition === 0) return;
            chatInput.setSelectionRange(currentPosition - 1, currentPosition - 1);
          }
          break;
        case 'ArrowRight':
          {
            const currentPosition = chatInput.selectionStart;
            chatInput.setSelectionRange(currentPosition + 1, currentPosition + 1);
          }
          break;
        default:
          break;
      }

    })

    moChatInput.addEventListener("keyup", (e) => {
      if (e.key === "Enter") {
        const text = moChatInput.value;

        mo_chat_submit_btn.click();
        if ((text !== '')) {
          moChatInput.value = '';

          ChatManager.getInstance().chatfocus = true;
          moChatInput.focus();
        }
        else {
          ChatManager.getInstance().chatfocus = false;
        }
      }
    });

    moChatInput.addEventListener('keydown', (e) => {
      if (e.isComposing) return;

      switch (e.code) {
        case 'Space':
          const curPos = moChatInput.selectionStart;
          const curValue = moChatInput.value;
          moChatInput.value = curValue.substring(0, curPos) + ' ' + curValue.substring(curPos);
          moChatInput.setSelectionRange(curPos + 1, curPos + 1);
          break;
        case 'ArrowLeft':
          {
            const currentPosition = moChatInput.selectionStart;
            if (currentPosition === 0) return;
            moChatInput.setSelectionRange(currentPosition - 1, currentPosition - 1);
          }
          break;
        case 'ArrowRight':
          {
            const currentPosition = moChatInput.selectionStart;
            moChatInput.setSelectionRange(currentPosition + 1, currentPosition + 1);
          }
          break;
        default:
          break;
      }
    });

    mo_chat_submit_btn.addEventListener('click', () => {
      const text = moChatInput.value;

      if ((text !== '')) {
        moChatInput.value = '';
        if (text.substring(0, 6) === '/clear') {
          this.chatClear();
        } else {
          ChatManager.getInstance().send(false, text);
        }
        ChatManager.getInstance().chatfocus = true;
        moChatInput.focus();
      }
      else {
        ChatManager.getInstance().chatfocus = false;
      }
    })



    window.addEventListener("keyup", (e) => {
      let gameBgs = document.querySelectorAll(".game_popup_bg");
      for (let i = 0; i < gameBgs.length; ++i) {
        if (gameBgs[i].style.display === 'block') return;
      }

      const focusEle = document.activeElement;
      if (e.key == "Enter") {
        if ((!ChatManager.getInstance().chatfocus && (focusEle === chatInput) && (chatInput.value === '')) || (!ChatManager.getInstance().chatfocus && (focusEle === moChatInput) && (moChatInput.value === ''))) {
          if (user_Info.type === "mobile") {
            moChatInput.blur();
          } else {
            chatInput.blur();
          }
        }
        else {
          if (user_Info.type === "mobile") {
            moChatInput.focus();
          } else {
            chatInput.focus();
          }
        }
      }
    })

  }

  async sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  makeChatDiv(type, name, text, currentTileIndex) {
    let div = document.createElement("div");
    let nameH3 = document.createElement("h3");
    let contenttext = document.createElement("p");

    if (type === "chat" || type === undefined || type === '') {
      if (name === this.name) {     // 나 자신
        div.classList.add("chat_myself");
      } else {
        div.classList.add("chat_other");
      }

      nameH3.innerText = `${name}`;
      contenttext.innerText = `${text}`;

      div.appendChild(nameH3);
      div.appendChild(contenttext);

      if (user_Info.type === "mobile") {
        mo_tbox_chat.appendChild(div);
        moTbox.scrollTop = moTbox.scrollHeight;
      } else {
        if (currentTileIndex < 100) {
          chattBox.appendChild(div);
        } else {
          privatetBox.appendChild(div);
        }
        tbox.scrollTop = tbox.scrollHeight;
      }


    }
    //chattBox  사람대화
    //activityBox 활동내역
  }

  makeActivityDiv(type, name, text, activityType) {
    let div = document.createElement("div");
    let nameH3 = document.createElement("h3");
    let contenttext = document.createElement("p");
    if (type === "activity") {
      if (activityType === "farm") { //열매 수확해야 함을 알려줌
        div.classList.add("activity_farm");
        nameH3.innerText = `${text}`;
      } else if (activityType === "other" || activityType === undefined || activityType === '') { //나머지
        div.classList.add("activity_other");
        nameH3.innerText = `${name}`;
        contenttext.innerText = `${text}`;
      }

      div.appendChild(nameH3);

      if (activityType !== "farm") {
        div.appendChild(contenttext);
      }

      if (user_Info.type === "mobile") {
        mo_tbox_activity.appendChild(div);
        moTbox.scrollTop = moTbox.scrollHeight;
      } else {
        activityBox.appendChild(div);
        tbox.scrollTop = tbox.scrollHeight;
      }
    }
  }


  send(check = false, text) {
    if (!check && text.trim() === '') return;

    ChatManager.getInstance().room.send(0, text);
  }

  contentLoaded(name, callback) {
    if (user_Info.type !== "mobile") {
      chattBox.style.display = "block";
      activityBox.style.display = "none";
    }

    chatOpenBtn.style.display = "none";
    let div = document.createElement("div");
    let nameH3 = document.createElement("h3");
    div.classList.add("chat_myself");
    let defaultChar = '랜드에 오신 것을 환영합니다.'

    //최초 1회
    if (name === this.name) {    // 나의 랜드
      nameH3.innerText = '마이' + defaultChar;
    } else if (name === undefined) {
      nameH3.innerText = defaultChar;
    } else {
      nameH3.innerText = name + defaultChar;
    }

    div.appendChild(nameH3);
    if (user_Info.type === "mobile") {
      mo_tbox_chat.appendChild(div);
    } else {
      chattBox.appendChild(div);
    }

    chatBtn.addEventListener("click", () => {
      chattBox.style.display = "block";
      privatetBox.style.display = "none";
      activityBox.style.display = "none";
      chatBtn.querySelector(".navCounter").style.display = 'none';
      tbox.scrollTop = tbox.scrollHeight;
      this.preChatLength = chattBox.querySelectorAll("div").length;

      chatBtn.classList.add("chatTabactive");
      privateBtn.classList.remove("chatTabactive");
      activityBtn.classList.remove("chatTabactive");
    });

    mo_chatBtn.addEventListener("click", () => {
      mo_tbox_chat.classList.remove('dn');
      mo_tbox_activity.classList.add('dn');
      moTbox.scrollTop = moTbox.scrollHeight;
      this.preChatLength = mo_tbox_chat.querySelectorAll("div").length;

      mo_chatBtn.classList.add('chatTabactive');
      mo_activityBtn.classList.remove('chatTabactive');

    });

    privateBtn.addEventListener("click", () => {
      chattBox.style.display = "none";
      privatetBox.style.display = "block";
      activityBox.style.display = "none";
      privateBtn.querySelector(".navCounter").style.display = 'none';
      tbox.scrollTop = tbox.scrollHeight;
      this.prePrivateLength = privatetBox.querySelectorAll("div").length;

      chatBtn.classList.remove("chatTabactive");
      privateBtn.classList.add("chatTabactive");
      activityBtn.classList.remove("chatTabactive");
    });


    activityBtn.addEventListener("click", () => {
      chattBox.style.display = "none";
      privatetBox.style.display = "none";
      activityBox.style.display = "block";
      activityBtn.querySelector(".navCounter").style.display = 'none';
      tbox.scrollTop = tbox.scrollHeight;
      this.preActivityLength = activityBox.querySelectorAll("div").length;

      chatBtn.classList.remove("chatTabactive");
      privateBtn.classList.remove("chatTabactive");
      activityBtn.classList.add("chatTabactive");
    });

    mo_activityBtn.addEventListener("click", () => {
      mo_tbox_chat.classList.add('dn');
      mo_tbox_activity.classList.remove('dn');
      moTbox.scrollTop = moTbox.scrollHeight;
      this.preActivityLength = mo_tbox_activity.querySelectorAll("div").length;

      mo_chatBtn.classList.remove('chatTabactive');
      mo_activityBtn.classList.add('chatTabactive');
    });



    sizeBtn.addEventListener("click", (e) => {
      if (user_Info.type === "mobile") {
        moTbox.classList.toggle("size");
      } else {
        sizeBtnChild[0].classList.toggle('VMDactiveF');
        sizeBtnChild[1].classList.toggle('VMDactiveF');

        tbox.classList.toggle("size");
      }
    });

    closeBtn.addEventListener("click", () => {

      chatBoxWrap.style.display = "none";
      chatOpenBtn.style.display = "flex";

    });

    chatOpenBtn.addEventListener("click", () => {
      chatBoxWrap.style.display = "block";
      chatOpenBtn.style.display = "none";
    })

    callback();

    mo_chat_submit_btn
  }

  activitySend(data) {
    var sendData = data;
    ChatManager.getInstance().room.send("Acquisition", sendData);
  }

  setCurrentTileIndex(index) {
    let sendIndex = index;
    this.room.send('currentIndex', sendIndex);

    this.currentTileIndex = index;

    if(this.currentTileIndex === 0) {
      chatBtn.click();
    } else {
      privateBtn.click();
    }
  }

  blur() {
    ChatManager.getInstance().chatfocus = false;
    if (user_Info.type === "mobile") {
      moChatInput.blur();
    } else {
      chatInput.blur();
    }
  }

  makeContent(text) {
    if (!this.noticeDiv) {
      this.noticeDiv = document.createElement('div');
      const noticeH1 = document.createElement('h1');
      const noticeContent = document.createElement('div');
      const noticeContentP = document.createElement('p');
      const noticeContentButton = document.createElement("button");
      const noticeContentButtonImg = document.createElement('img');

      this.noticeDiv.classList.add('noticeLand');
      noticeH1.innerText = '공지사항';
      noticeContent.id = 'noticeContents';
      noticeContentP.id = "notice_con";
      noticeContentP.innerText = text;
      noticeContentButton.id = 'nLbtn';
      noticeContentButtonImg.src = '/seum_img/ui/nl_down_icon.png';
      noticeContentButtonImg.alt = '더보기';

      noticeContentButton.appendChild(noticeContentButtonImg);

      noticeContent.appendChild(noticeContentP);
      noticeContent.appendChild(noticeContentButton);

      this.noticeDiv.appendChild(noticeH1);
      this.noticeDiv.appendChild(noticeContent);

      this.noticeTimeOut = setTimeout(() => {
        this.noticeDiv.style.opacity = 0;
      }, 20000);

      document.querySelector("#gamecontainer").appendChild(this.noticeDiv);

      if (noticeContentP.offsetHeight > noticeContent.offsetHeight) {
        noticeContentButton.style.display = 'block';
      }

      noticeContentButton.addEventListener('click', function () {
        if (noticeContent.style.maxHeight === 'none') {
          noticeContent.style.maxHeight = '120px';
        } else {
          noticeContent.style.maxHeight = 'none';
        }
        noticeContentButton.classList.toggle('rotate')
      });

    } else {
      clearTimeout(this.noticeTimeOut);
      this.noticeDiv.style.opacity = 1;
      const noticeContentP = this.noticeDiv.querySelector('p');
      noticeContentP.innerText = text;

      const noticeContent = this.noticeDiv.querySelector("#noticeContents");
      if (noticeContentP.offsetHeight > noticeContent.offsetHeight) {
        this.noticeDiv.querySelector('button').style.display = 'block';
      } else {
        this.noticeDiv.querySelector('button').style.display = 'none';
      }

      this.noticeTimeOut = setTimeout(() => {
        this.noticeDiv.style.opacity = 0;
      }, 20000);
    }
  }

  chatClear() {
    const activeTab = document.querySelector(".chatTabactive"); // 현재 채팅 포커스
    if (activeTab === chatBtn) {              //전체 채팅
      while (chattBox.firstChild) {
        chattBox.removeChild(chattBox.firstChild);
      }
      this.preChatLength = 0;
    } else if (activeTab === privateBtn) {   //프라이빗 채팅
      while (privatetBox.firstChild) {
        privatetBox.removeChild(privatetBox.firstChild);
      }
      this.prePrivateLength = 0;
    } else if (activeTab === activityBtn) {  //활동 내역
      while (chattBox.firstChild) {
        chattBox.removeChild(chattBox.firstChild);
      }
      this.preChatLength = 0;
    }
  }

  helper() {
    let div = document.createElement("div");
    let nameH3 = document.createElement("h3");

    div.classList.add("chat_help");

    nameH3.innerText = `명령어에 관한 정보입니다.
    /admin 전체에게 MESSAGE : 구성원 전체에게 메세지를 보냅니다.
    /admin 서버재시작 SECONDS : 서버를 SECONDS초 후에 재시작합니다.
    /clear : 채팅을 삭제합니다.`;

    div.appendChild(nameH3);

    if (user_Info.type === "mobile") {
      mo_tbox_chat.appendChild(div);
      moTbox.scrollTop = moTbox.scrollHeight;
    } else {
      chattBox.appendChild(div);
      tbox.scrollTop = tbox.scrollHeight;
    }
  }

  countCheck() {
    const activeTab = document.querySelector(".chatTabactive"); // 현재 채팅 포커스
    if (activeTab === chatBtn) {              //전체 채팅
      this.preChatLength = chattBox.querySelectorAll("div").length;
    } else if (activeTab === privateBtn) {   //프라이빗 채팅
      this.prePrivateLength = privatetBox.querySelectorAll("div").length;
    } else if (activeTab === activityBtn) {  //활동 내역
      this.preActivityLength = activityBox.querySelectorAll("div").length;
    }

    if (this.preChatLength !== chattBox.querySelectorAll("div").length) {
      chatBtn.querySelector(".navCounter").innerText = chattBox.querySelectorAll("div").length - this.preChatLength;
      chatBtn.querySelector(".navCounter").style.display = 'block';
    } else if (this.prePrivateLength !== privatetBox.querySelectorAll("div").length && privatetBox.querySelectorAll("div").length !== 0) {
      privateBtn.querySelector(".navCounter").innerText = privatetBox.querySelectorAll("div").length - this.prePrivateLength;
      privateBtn.querySelector(".navCounter").style.display = 'block';

    } else if (this.preActivityLength !== activityBox.querySelectorAll("div").length && activityBox.querySelectorAll("div").length !== 0) {
      activityBtn.querySelector(".navCounter").innerText = activityBox.querySelectorAll("div").length - this.preActivityLength;
      activityBtn.querySelector(".navCounter").style.display = 'block';
    }

    if(chattBox.querySelectorAll("div").length === 0) {
      this.preChatLength = 0;
      chatBtn.querySelector(".navCounter").style.display = 'none';
    } else if(privatetBox.querySelectorAll("div").length === 0) {
      this.prePrivateLength = 0;
      privateBtn.querySelector(".navCounter").style.display = 'none';
    } else if(activityBox.querySelectorAll("div").length === 0) {
      this.preActivityLength = 0;
      activityBtn.querySelector(".navCounter").style.display = 'none';
    }
  }

  allChatClear() {
    while (chattBox.firstChild) {
      chattBox.removeChild(chattBox.firstChild);
    }
    this.preChatLength = 0;
  }
}

// var chatRoom = ChatManager.getInstance();
// chatRoom.init();
// chatRoom.create();