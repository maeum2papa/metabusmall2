const colyseus = require('colyseus');
const schema = require('@colyseus/schema');
const Schema = schema.Schema;

const { Mysql } = require('../database/mysql');
const { RoomMessageManager } = require('./manager/RoomMessageManager');

class ChatRoom extends colyseus.Room {
    fixedTimeStep = 1000 / 20;
    userIdMap = new Map();
    clientIdMap = new Map();
    roomMasterId;
    roomPlace;
    roomType;
    userSessionIdArr = {};
    onCreate(options) {
        //console.log("oncreate");
        let user_info = options.user_Info;
        this.roomPlace = user_info.room;

        RoomMessageManager.getInstance().setRoom(this, this.roomName);

        let isLand = false;
        if (isNaN(+user_info.otherUser)) {
            isLand = true;      // 기업랜드 입성
        }

        if (!isLand) {
            let startIndex = this.roomName.lastIndexOf('_') + 1;
            this.roomMasterId = this.roomName.substring(startIndex, this.roomName.length);
        } else {
            this.roomMasterId = user_info.companyIdx;
        }

        this.setPatchRate(this.fixedTimeStep);

        const message = new Message();
        this.setState(message);

        const sql = 'INSERT INTO cb_chat (ch_sno, ch_memNo, ch_txt, ch_place, ch_roomNo) VALUES (?, ?, ?, ?, ?)';
        let dataToInsert = [];

        if (this.roomPlace === 'myland_inner') {
            this.roomType = 'land_in';
        } else if (this.roomPlace === 'myland_outer') {
            this.roomType = 'land_out';
        } else if (this.roomPlace === 'land_office') {
            this.roomType = 'office';
        } else if (this.roomPlace === 'land_class') {
            this.roomType = 'class';
        }

        this.onMessage(0, async (client, data) => {
            let adminIndex = data.indexOf('n') + 1;
            const admin = data.substring(0, adminIndex);
            if (admin === '/admin' && data.length > 6) {
                const Allcommand = data.substring(adminIndex + 1, data.length);
                const commandIndex = Allcommand.indexOf(' ');
                const command = Allcommand.substring(0, commandIndex);
                const param = Allcommand.substring(commandIndex + 1, Allcommand.length);

                switch (command) {
                    case "전체에게":
                        RoomMessageManager.getInstance().allMassage(param);
                        break;
                    case "서버재시작":
                        RoomMessageManager.getInstance().serverReStart(param);
                        break;
                    default:
                        break;
                }
                return;
            }
            if (data === '' || admin === '/admin') return;
            const messageInfo = this.state.messageInfo[client.sessionId];
            messageInfo.messages = (`${data}`);

            if (messageInfo.messages !== '' && +messageInfo.currentIndex < 100) {
                dataToInsert = [null, +messageInfo.userIndex, messageInfo.messages, this.roomType, +this.roomMasterId];

                try {
                    let result = await Mysql.getInstance().insertUpdateQuery(sql, dataToInsert);
                } catch (err) {
                    console.log("GameRoom_Create_Message_Error!!!!!", err);
                }
            }
        })

        this.onMessage('currentIndex', async (client, index) => {
            this.state.messageInfo[client.sessionId].currentIndex = index;
        })

        this.onMessage('Acquisition', async (client, data) => {
            // data.currentUserId;      // myidx
            // data.currentRoom;        // office, useridx ... 
            // data.type = "fruit","seed", "fertilizer", "water", "fishing";            ing
            let text = '';

            if (data.type === "getFruit") {
                text = '열매를 수확했습니다.';
            } else if (data.type === 'baitDecoy') {         // 지렁이 쓰기
                text = '지렁이를 사용했습니다.';
            } else if (data.type === 'getDecoy') {   // 지렁이 획득
                text = `지렁이 ${data.count}개를 획득했습니다.`
            } else if (data.type === 'plantSeed') {  //씨앗 쓰기 (심기)
                text = '씨앗을 심었습니다.';
            } else if (data.type === 'getSeed') {    //씨앗 획득
                text = '씨앗을 획득했습니다.';
            } else if (data.type === 'spreadFertilizer') {   // 비료 쓰기 (뿌리기)
                text = '비료를 사용했습니다.';
            } else if (data.type === 'getFertilizer') {      // 비료 획득
                text = '비료가 배달되었습니다.';
            } else if (data.type === 'spreadWater') {      // 물 쓰기 (뿌리기)
                text = '물을 사용했습니다.';
            } else if (data.type === 'getWater') {      // 물 획득
                text = '연못에서 물을 담았습니다.';
            } else if (data.type === 'getFish') {       //생선 획득
                let fishname = data.fishName;
                if (fishname === '') {
                    fishname = "물고기";
                }

                text = `낚시를 통해 ${fishname}을(를) 획득했습니다.`;
            } else if (data.type === 'getTrash') {     //쓰레기
                text = '낚시를 통해 쓰레기를 건졌습니다.'
            } else if (data.type === 'getBottle') {  // 유리병 획득
                text = '낚시를 통해 유리병을 건졌습니다.'
            } else if (data.type === 'getFruitFishing') {    //코인 획득
                text = `낚시를 통해 열매를 건졌습니다.`
            } else if (data.type === 'petSeed') {  //펫 씨앗 획득
                text = '펫이 씨앗을 발견했습니다.'
            }   

            let sql = "INSERT INTO cb_object_log (log_sno, log_memNo, log_txt, log_place) VALUES (?, ?, ?, ?)";
            let datas = [null, +data.currentUserId, text, data.currentRoom];

            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, datas);
            } catch (err) {
                console.log("GameRoom_Create_Message_Error!!!!!", err);
                return;
            }

            sql = 'SELECT * FROM cb_object_log WHERE log_place = ? OR log_memNo = ? and log_regDt BETWEEN DATE_ADD(NOW(),INTERVAL -1 WEEK ) AND NOW() ORDER BY log_sno DESC LIMIT 1';

            let dataParam = [+data.currentUserId, +data.currentUserId];
            let textArr = [];

            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, dataParam);

                for (let obj of result) {
                    let logplace = +obj.log_place;
                    if (data.type === 'getWater') {
                        if (+data.currentUserId !== +logplace) {

                            if (this.userSessionIdArr[+logplace]) {
                                const messageInfo = this.state.messageInfo[client.sessionId];
                                const targetclient = this.clients.getById(this.userSessionIdArr[+logplace]);

                                let texArr = [];
                                let targettxt = {
                                    text: messageInfo.name + '님이 ' + text,
                                    dt: obj.log_regDt
                                };

                                texArr.push(targettxt);

                                if (texArr.length > 0) {
                                    targetclient.send('firstActivity', texArr);
                                }
                            }

                            text = data.name + '님의 ' + text;
                        }

                    }
                    let txt = {
                        text: text,
                        dt: obj.log_regDt
                    };

                    textArr.push(txt);
                }
            } catch (err) {
                console.log("ChatRoom_onJoin_first_Error!!!!!", err);
                return;
            }

            if (textArr.length > 0) {
                client.send('firstActivity', textArr);
            }
        })

        this.onMessage('resetMessage', async (client) => {
            this.resetMessage(client.sessionId);
        });

        this.onMessage('clearMessage', async (client) => {
            if(this.state.messageInfo[client.sessionId].adminType !== 1 && +this.state.messageInfo[client.sessionId].userIndex !== +this.roomMasterId) return;

            let sql = `DELETE
            FROM cb_chat 
            WHERE cb_chat.ch_place = ? 
            AND cb_chat.ch_roomNo = ? 
            AND cb_chat.ch_regDt >= DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK)`;
            let logParam = [this.roomType,this.roomMasterId];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql,logParam);
            } catch (err) {
                console.log("209",err);
            }
            
            let msg = '';
            this.broadcast('clearMsg', msg,{afterNextPatch: true });
        });
    }

    async onJoin(client, options) {
        //console.log("onjoin");

        let user_info = options.user_Info;
        const userID = user_info.currentUser;

        let sql = 'SELECT mem_nickname,mem_is_admin FROM cb_member WHERE mem_id =' + userID;
        let nickname;
        let isAdmin;
        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                nickname = data.mem_nickname;
                isAdmin = data.mem_is_admin;
            }
        } catch (err) {
            console.log("Error!!!!!", err);
            throw err;
        }

        
        //채팅내역

        let logSql = 'SELECT cb_chat.ch_txt, cb_member.mem_nickname FROM cb_chat INNER JOIN cb_member ON cb_chat.ch_memNo = cb_member.mem_id WHERE cb_chat.ch_place = ? AND cb_chat.ch_roomNo = ? AND cb_chat.ch_regDt >= DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK)';
        let logParam = [this.roomType,this.roomMasterId];
        let arrText = [];
        try {
            let result = await Mysql.getInstance().insertUpdateQuery(logSql,logParam);

            for(let data of result) {
                let info = {
                    name: '',
                    message: ''
                }
                info.name = data.mem_nickname;
                info.message = data.ch_txt;
                arrText.push(info);   
            }

            
        } catch(err) {
            console.log("236, Error",err);
            return;
        }

        if(arrText.length > 0) {
            client.send('initMessages', arrText);
        }

        //활동내역 
        sql = 'SELECT * FROM cb_object_log WHERE log_regDt BETWEEN DATE_ADD(DATE(NOW()),INTERVAL -1 WEEK ) AND NOW() AND log_place = ? AND log_memNo = ?;';
        let dataParam = [+userID, userID];
        let text = [];
        try {
            let result = await Mysql.getInstance().insertUpdateQuery(sql, dataParam);

            for (let data of result) {
                let logtxt = data.log_txt;
                let memId;

                if (logtxt.indexOf('연못') !== -1) {
                    if (+userID !== +data.log_memNo || +userID !== +data.log_place) {

                        if (+userID !== +data.log_memNo) { //남이 내우물 뜸
                            memId = +data.log_memNo;

                            logtxt = "님이 " + logtxt;
                        } else if (+userID !== +data.log_place) {
                            memId = +data.log_place;

                            logtxt = "님의 " + logtxt;
                        }

                        let sql = 'SELECT mem_nickname FROM cb_member WHERE mem_id =' + +memId;
                        let nickname;
                        try {
                            let result = await Mysql.getInstance().query(sql);

                            for (let data of result) {
                                nickname = data.mem_nickname;
                            }
                        } catch (err) {
                            console.log("Error!!!!!", err);
                            throw err;
                        }

                        logtxt = nickname + logtxt;
                    }
                }

                let txt = {
                    text: logtxt,
                    dt: data.log_regDt
                }

                text.push(txt);
            }
        } catch (err) {
            console.log("ChatRoom_onJoin_first_Error!!!!!", err);
            return;
        }

        // this.state.messageInfo.forEach((value,key,map) => {         // 같은 아이디로 여러 로그인하면 닉네임에 인덱스붙임
        //     if(value.name === nickname) {
        //         let index = 0;
        //         nickname = this.nameCheck(nickname,index);
        //     }
        // })

        nickname = user_info.name;

        const messageInfo = this.state.addMessageInfo(nickname, +userID,isAdmin);
        this.userSessionIdArr[userID] = client.sessionId;
        this.state.messageInfo.set(client.sessionId, messageInfo);
        // this.userIdMap.set(userID, client.sessionId);
        // this.clientIdMap.set(client.sessionId, userID);

        if (text.length > 0) {
            client.send('firstActivity', text);
        }
    }

    onLeave(client, consented) {
        this.state.messageInfo.delete(client.sessionId);

        // let userid = this.clientIdMap.get(client.sessionId);
        // this.clientIdMap.delete(client.sessionId);
        // this.userIdMap.delete(userid);
    }

    onDispose() {
        RoomMessageManager.getInstance().removeRoom(this.roomName);
    }

    async sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    nameCheck(name, index) {
        let nick = name + index;
        let stackIndex = index;
        this.state.messageInfo.forEach((value, key, map) => {
            if (value.name === nick) {
                ++stackIndex;
                nick = this.nameCheck(name, stackIndex);
            }
        })

        return nick;
    }

    commandMessage(info) {
        this.broadcast('commandMessage', info);
    }

    resetMessage(sessionId) {
        const messageInfo = this.state.messageInfo[sessionId];
        messageInfo.messages = '';
    }
}

class MessageInfo extends Schema {
    constructor(name, index,adminType) {
        super();
        this.name = name;
        this.userIndex = index;
        this.messages = '';
        this.currentIndex = 0;
        this.adminType = adminType;
    }
}
schema.defineTypes(MessageInfo, {
    messages: 'string',
    name: 'string',
    adminType: "number",
    userIndex: "number",
    currentIndex: "number"
});



class Message extends Schema {
    constructor() {
        super();
        this.messageInfo = new schema.MapSchema();
    }

    addMessageInfo(name, index,adminType) {
        const messageInfo = new MessageInfo(name, index,adminType);
        return messageInfo;
    }
}
schema.defineTypes(Message, {
    messageInfo: { map: MessageInfo }
});

exports.ChatRoom = ChatRoom;