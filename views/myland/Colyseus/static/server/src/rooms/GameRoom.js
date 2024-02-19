const colyseus = require('colyseus');
const axios = require('axios')

const { Player } = require('./schema/player');
const { GameRoomState } = require('./schema/GameRoomState');
const { Mysql } = require('../database/mysql');
const fs = require('fs');
const Utils = require('../utils/utils');
const { start } = require('repl');
const path = require('path');
const { dumpChanges } = require('@colyseus/schema');
const { checkPrimeSync } = require('crypto');


exports.GameRoom = class extends colyseus.Room {
    fixedTimeStep = 1000 / 60;
    fishingMaxSeconds = 10;         // 낚시 시간
    mapWidth;
    mapHeight;
    roomMasterId;
    roomMasterNickName;
    arrFile = [];
    arrPreviewFile = [];
    arrThumbnail = [];
    arrName = [];
    arrEffect = [];
    arrFurniture = [];
    arrItemDepth = [];
    arrMission = [];
    furnitureInfo = [];
    fishInfo = {};
    templeteInfo = {};
    curfurniture = {};
    reset = false;      // db초기화
    isLand = false;
    isWater = false;
    arrTip = [];

    randomBoxPos = {
        0: { x: 1024, y: 992 }
        , 1: { x: 800, y: 1120 }
        , 2: { x: 864, y: 1120 }
        , 3: { x: 1376, y: 928 }
        , 4: { x: 1664, y: 1056 }
        , 5: { x: 96, y: 672 }
        , 6: { x: 288, y: 640 }
        , 7: { x: 448, y: 640 }
        , 8: { x: 480, y: 800 }
        , 9: { x: 704, y: 640 }
        , 10: { x: 640, y: 800 }
        , 11: { x: 864, y: 800 }
        , 12: { x: 864, y: 640 }
        , 13: { x: 1088, y: 704 }
        , 14: { x: 960, y: 928 }
        , 15: { x: 768, y: 1056 }
        , 16: { x: 480, y: 960 }
        , 17: { x: 288, y: 896 }
        , 18: { x: 160, y: 992 }
        , 19: { x: 288, y: 1152 }
        , 20: { x: 416, y: 1280 }
        , 21: { x: 576, y: 1184 }
        , 22: { x: 800, y: 1184 }
        , 23: { x: 672, y: 1344 }
        , 24: { x: 864, y: 1408 }
        , 25: { x: 1088, y: 1472 }
        , 26: { x: 1280, y: 1312 }
        , 27: { x: 1184, y: 1088 }
        , 28: { x: 1344, y: 960 }
        , 29: { x: 1568, y: 928 }
        , 30: { x: 1632, y: 1120 }
        , 31: { x: 1792, y: 1088 }
        , 32: { x: 1792, y: 1312 }
        , 33: { x: 2272, y: 1312 }
        , 34: { x: 2560, y: 1216 }
        , 35: { x: 2208, y: 1088 }
        , 36: { x: 2080, y: 928 }
        , 37: { x: 2080, y: 736 }
        , 38: { x: 2464, y: 736 }
        , 39: { x: 2560, y: 736 }
        , 40: { x: 1664, y: 672 }
        , 41: { x: 2688, y: 1088 }
    };

    cumFruitCount = 0;
    randomSec = 20;
    cumTime = 0;

    //===debug===
    nickCount = 1;
    xCount = 0;
    yCount = 0;
    inputCount = 0;
    makeCount = 0;
    startTime = {};
    csvString = {};
    csvTitle = {
        'date': '',
        'type': '',
        'id': '',
        "type2": '',
        "content": '',
        'diff(ms)': ''
    };

    videoInfo = {};

    async onCreate(options) {                 // 해당 룸 주인의 데이터를 불러와서 세팅해야 함! (ex) 맵정보(씨앗 위치 등등)) 
        this.setSeatReservationTime(30);

        // this.maxClients = 1000;

        let user_info = options.user_Info;

        this.setState(new GameRoomState());

        let mapsql = 'SELECT template_inner, template_outer, template_office, template_class FROM cb_company_info WHERE company_idx =' + +user_info.companyIdx;

        let innerIdx = 0;
        let outerIdx = 0;
        let officeIdx = 0;
        let classIdx = 0;

        try {
            let result = await Mysql.getInstance().query(mapsql);

            for (let data of result) {
                innerIdx = data.template_inner;
                outerIdx = data.template_outer;
                officeIdx = data.template_office;
                classIdx = data.template_class;
            }
        } catch (err) {
            console.log("GameRoom_mapsql_Error!!!!!", err);
            throw err;
        }

        let temIdx = 0;
        if (user_info.room === "myland_inner") {
            temIdx = +innerIdx;
        } else if (user_info.room === "myland_outer") {
            temIdx = +outerIdx;
        } else if (user_info.room === "land_office") {
            temIdx = +officeIdx;
        } else if (user_info.room === "land_education") {
            temIdx = +classIdx;
        }

        let temsql = 'SELECT tp_data FROM cb_asset_template WHERE tp_sno =' + temIdx;

        try {
            let result = await Mysql.getInstance().query(temsql);

            for (let data of result) {
                this.templeteInfo = JSON.parse(data.tp_data);
            }
        } catch (err) {
            console.log("GameRoom_mapsql_Error!!!!!", err);
            throw err;
        }

        const maplevel = this.state.addMapLevel(this.templeteInfo.width, this.templeteInfo.height, this.templeteInfo.templeteIndex, this.templeteInfo.templeteName);

        this.state.maplevel = maplevel;

        this.createWorld(this.state.maplevel);

        // if (this.reset) {
        //     this.resetItem();
        // }

        for (let type in this.templeteInfo.object) {
            for (let i = 0; i < this.templeteInfo.object[type].obj.length; ++i) {
                const nameindex = type + `${i}`;
                const interactionObj = this.state.addInteractionObj(type, nameindex, this.templeteInfo.object[type].obj[i]);
                this.state.interactionObj.set(nameindex, interactionObj);
            }
        }

        let testVideoInfo = {
            "지역1": {
                isYoutube: false,
                route: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                poster: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/images/BigBuckBunny.jpg"
            },
            "지역2": {
                isYoutube: true,
                route: "bIzMpAwt7qY"
            }
        };

        if (this.templeteInfo.video) {
            Object.keys(testVideoInfo).forEach(key => {
                this.videoInfo[key] = Object.assign({}, testVideoInfo[key], this.templeteInfo.video[key]);
            });
        }

        let startIndex = this.roomName.lastIndexOf('_') + 1;
        this.roomMasterId = this.roomName.substring(startIndex, this.roomName.length);

        this.isLand = false;
        if (isNaN(+user_info.otherUser)) {
            this.isLand = true;      // 기업랜드 입성
        }

        if (!this.isLand && user_info.room === "myland_outer") {
            await this.mylandOuter();
        }
        else if (!this.isLand && user_info.room === "myland_inner") {
            await this.mylandInner();
        }
        else {              // 기업랜드 입장
            let companyRoom = user_info.companyIdx;
            let startindex = companyRoom.indexOf('_') + 1;
            let companyIdx = user_info.companyIdx;//companyRoom.substring(startindex,companyRoom.length);
            let sql = 'SELECT company_name FROM cb_company_info WHERE company_idx=' + companyIdx;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    this.roomMasterNickName = data.company_name;
                }
            } catch (err) {
                console.log("GameRoom_Create_Error!!!!!", err);
                throw err;
            }
        }

        this.onMessage('Json', (client, jsonFile) => {          // make tile
            fs.writeFileSync('static/client/assets/Json/tile.json', jsonFile);
        })


        this.onMessage('input', (client, input) => {
            this.state.players[client.sessionId].inputQueue.push(input);
        })

        this.onMessage('move', (client, info) => {
            let endTime = JSON.parse(info.endTime);
            // console.log('start', this.startTime[info.count]);
            // console.log('end', endTime);

            if (this.startTime[info.count] === undefined) {
                console.log('count', info.count, 'startTime', this.startTime, 'inputcount', this.inputCount);
            }
            const oneWayLatency = endTime - this.startTime[info.count];

            let csvInfo = {
                'date': '',
                'type': '',
                'id': '',
                "type2": '',
                "content": '',
                'diff(ms)': ''
            };

            csvInfo['date'] = `${Utils.DatetoDt(info.date)}`;
            csvInfo['type'] = info.type;
            csvInfo['type2'] = info.type2;
            csvInfo['id'] = this.state.players[client.sessionId].name;
            csvInfo['content'] = info.content + ` from Id: ${info.player.name} x: ${info.player.x} y: ${info.player.y}`;
            csvInfo['diff(ms)'] = `${oneWayLatency}`;

            console.log(`messengerName: ${this.state.players[client.sessionId].name}, x: ${info.player.x}, y: ${info.player.y}, Latency: ${oneWayLatency}, moveCount: ${info.count}`);
            this.csvString[info.count].push(csvInfo);
        });

        this.onMessage('teleport', (client, info) => {
            this.state.players[client.sessionId].x = info.x;
            this.state.players[client.sessionId].y = info.y;

            // this.startTime[this.inputCount] = JSON.parse(info.startTime);
            // //console.log('teleport', this.startTime, this.inputCount);

            // let csvInfo = {
            //     'date': '',
            //     'type': '',
            //     'id': '',
            //     "type2": '',
            //     "content": '',
            //     'diff(ms)': ''
            // };

            // csvInfo['date'] = `${Utils.DatetoDt(info.date)}`;
            // csvInfo['type'] = info.type;
            // csvInfo['type2'] = info.type2;
            // csvInfo['id'] = this.state.players[client.sessionId].name;
            // csvInfo['content'] = info.content + ` x: ${info.x} y: ${info.y}`;;
            // csvInfo['diff(ms)'] = '';

            // this.csvString[this.inputCount] = []
            // this.csvString[this.inputCount].push(csvInfo);

            // let player = {
            //     x: this.state.players[client.sessionId].x,
            //     y: this.state.players[client.sessionId].y,
            //     name: this.state.players[client.sessionId].name,
            //     count: this.inputCount
            // };
            // this.broadcast('playerMove', player, { except: client });

            ++this.inputCount;
        });

        this.onMessage('csvSave', () => {
            console.log('csvSave');
            for (let i = 0; i < 2; ++i) {
                const csv_string = Utils.jsonToCSV(this.csvTitle, this.csvString[i]);
                fs.writeFileSync(`static/${i + 1}.csv`, csv_string);
            }
        })


        this.onMessage('animjson', (client, curjson) => {
            const jsonFile = fs.readFileSync('static/client/assets/Json/player_animation.json');
            //const jsonData = JSON.parse(jsonFile); //보류

            fs.writeFileSync('static/client/assets/Json/player_animation.json', curjson);
        })

        this.onMessage('saveParts', async (client, saveparts) => {             // 파츠 세이브
            const player = this.state.players[client.sessionId];

            const partsUpdateSql = 'UPDATE cb_member SET ing_item=? WHERE mem_id=' + player.id;
            const partParams = [JSON.stringify(saveparts)];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(partsUpdateSql, partParams);
            } catch (err) {
                console.log("GameRoom_Create_saveParts_Error!!!!!", err);
                return;
            }

            for (let type in saveparts) {
                let isCheck = false;
                for (let i = 0; i < player.parts.length; ++i) {
                    if (player.parts[i].type === type) {             //기존도 있고 새로운 파츠도 있다.
                        player.parts[i].name = saveparts[type].name;
                        player.parts[i].index = saveparts[type].index;
                        player.parts[i].frontDepth = saveparts[type].frontDepth;
                        player.parts[i].backDepth = saveparts[type].backDepth;
                        isCheck = true;
                        break;
                    }
                }
                if (!isCheck) {                                       // 기존 파츠에 없다.
                    player.addPart(type, saveparts[type].name, saveparts[type].index, saveparts[type].frontDepth, saveparts[type].backDepth);
                }
            }

            for (let i = 0; i < player.parts.length; ++i) {           //기존파츠엔 있지만 새로운 파츠엔 없다.

                let isCheck = false;
                for (let type in saveparts) {
                    if (player.parts[i].type === type) {
                        isCheck = true;
                        break;
                    }
                }

                if (!isCheck) {
                    player.parts.splice(i, 1);            //삭제
                    --i;
                }
            }

        })

        this.onMessage('savePreview', async (client, saveparts) => {
            const player = this.state.players[client.sessionId];

            const base64Image = JSON.parse(saveparts);

            // const imagePath = path.join(,  + );
            const data = base64Image.replace(/^data:image\/\w+;base64,/, '');
            const buffer = Buffer.from(data, 'base64');

            fs.writeFile(__dirname + '/../../../../../../_layout/bootstrap/seum_img/preview/' + `${player.id}_preview.png`, buffer, 'binary', err => {
                if (err) {
                    console.log("err", err);
                }
            });

        });

        this.onMessage('setPos', async (client, data) => {
            const player = this.state.players[client.sessionId];

            player.x = data.data.x;
            player.y = data.data.y;

            player.jumpReset();
        });

        this.onMessage('setState', async (client, data) => {
            const player = this.state.players[client.sessionId];
            player.state = data.data;
        });

        this.onMessage('setSitOrLie', async (client, data) => {
            const player = this.state.players[client.sessionId];
            player.sitOrLie = data.data;
        });

        this.onMessage('setSubDepth', async (client, data) => {
            const player = this.state.players[client.sessionId];
            player.subDepth = data.data;
        });

        this.onMessage('setInteractState', async (client, Info) => {
            const interactionObj = this.state.interactionObj[Info.data.type];
            const player = this.state.players[client.sessionId];

            interactionObj.isFull = Info.data.isFull;

            player.sitOrLieType = Info.data.type;
        });

        this.onMessage('sendEmoji', async (client, sendInfo) => {
            let info = sendInfo;
            this.broadcast('receiveEmoji', info, { except: client, afterNextPatch: true });
        });

        this.onMessage('Astar', async (client, info) => {
            let Info = {
                x: info.x,
                y: info.y,
                arrow: info.arrow
            };

            this.state.players[client.sessionId].aStarPosQueue.push(Info);
            this.state.players[client.sessionId].aStarArrowQueue.push(Info.arrow);
        });

        this.onMessage('GroundFruitCollision', async (client, index) => {
            this.state.groundFruits[index].setColl(true);
            this.state.groundFruits[index].setId(client.sessionId);
        });


        this.onMessage('reset', (client, info) => {
            this.resetSql(info.table, info.cul, info.param);
        })




        this.setPatchRate(/*this.fixedTimeStep*/1000 / 20);             //서버에서 클라이언트에 보내주는 업데이트 속도. 20fps

        let elapesdTime = 0;

        this.setSimulationInterval((deltaTime) => {             //서버 자체의 Tick 클라이언트 TickRate와 같다.
            elapesdTime += deltaTime;

            while (elapesdTime >= this.fixedTimeStep) {
                elapesdTime -= this.fixedTimeStep;
                this.fixedTick(this.fixedTimeStep);
            }
        })

        if (!this.isLand && user_info.room === "myland_outer") {
            setTimeout(async () => {
                let sql = 'SELECT * FROM cb_game_field WHERE mem_id =' + this.roomMasterId;

                try {
                    let result = await Mysql.getInstance().query(sql);

                    for (let data of result) {
                        if ((data.cur_lv <= 5) && (data.crop_flag === 0)) {
                            const crops = this.state.crops[data.plant_index];
                            if (crops && crops.level !== undefined) {
                                crops.level = +data.cur_lv;
                            }
                        }
                    }
                } catch (err) {
                    console.log(`GameRoom_Create_setTimeout_Error!!!!!, ${this.roomName}`, err);
                    return;
                }
                console.log('GameRoom_Update');
            }, 600000);
        }

        let river = {
            index: 1,
            title: '민 물고기',
            detail: [{ id: 1, name: '미꾸라지', route: '/seum_img/fish/river/fish_1.png' }, { id: 2, name: '피라미', route: '/seum_img/fish/river/fish_2.png' }, { id: 3, name: '붕어', route: '/seum_img/fish/river/fish_3.png' }, { id: 4, name: '메기', route: '/seum_img/fish/river/fish_4.png' }, { id: 5, name: '연어', route: '/seum_img/fish/river/fish_5.png' }]
        };
        let sea = {
            index: 2,
            title: '바다 물고기',
            detail: [{ id: 6, name: '흰동가리', route: '/seum_img/fish/sea/fish_6.png' }, { id: 7, name: '넙치', route: '/seum_img/fish/sea/fish_7.png' }, { id: 8, name: '돌돔', route: '/seum_img/fish/sea/fish_8.png' }, { id: 9, name: '도미', route: '/seum_img/fish/sea/fish_9.png' }, { id: 10, name: '다랑어', route: '/seum_img/fish/sea/fish_10.png' }]
        };
        let amazon = {
            index: 3,
            title: '아마존 물고기',
            detail: [{ id: 11, name: '블루길', route: '/seum_img/fish/amazon/fish_11.png' }, { id: 12, name: '구피', route: '/seum_img/fish/amazon/fish_12.png' }, { id: 13, name: '피라니아', route: '/seum_img/fish/amazon/fish_13.png' }, { id: 14, name: '천사어', route: '/seum_img/fish/amazon/fish_14.png' }, { id: 15, name: '피라루크', route: '/seum_img/fish/amazon/fish_15.png' }]
        };

        this.arrMission.push(river, sea, amazon);

        await this.itemDepth();
        await this.playersheetLoad();

        // 플레이어의 sheet 
    }

    async onJoin(client, options) {
        // 여기서mysql 읽어서 뭐 해야할 것 같은데? 
        let user_info = options.user_Info;

        if (!user_info.mecro) {
            const userID = user_info.currentUser;

            let sql = 'SELECT * FROM cb_member WHERE mem_id =' + userID;
            let nickname, title, depart, fruit, decoy, water, fertilizer, seed, arrinfo, ing_item, myWater, anyWater, badge;

            let avatar = null;
            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    nickname = data.mem_nickname;               //닉네임
                    title = data.mem_position;                  //직급
                    depart = data.mem_div;                      //부서명
                    fruit = data.mem_cur_fruit;                 //현재 보유 열매 개수                
                    decoy = data.mem_cur_decoy;                 //현재 보유 지렁이 개수
                    water = data.mem_cur_water;                 //현재 보유 물 개수
                    fertilizer = data.mem_cur_fertilizer;       //현재 보유 비료 개수
                    seed = data.mem_cur_seed;                   //현재 보유 씨앗 개수
                    myWater = data.my_waterYn;                //오늘 내 물 풀 수 있는지
                    anyWater = data.any_waterYn;              // 남의 물

                    arrinfo = JSON.parse(data.member_item);     //현재 보유하고 있는 아이템
                    ing_item = data.ing_item;                   //현재 착용중인 아이템
                    badge = data.mem_title_no;                  //현재 칭호
                }

                avatar = arrinfo.avatar;

            } catch (err) {
                console.log("GameRoom_onJoin_350_Error!!!!!", err);
                return;
            }

            let seedCount = 0;
            if (+userID === +user_info.otherUser) {              // 출첵
                try {
                    let result = await this.dailyCheck(+userID);
                    if (result.affectedRows > 0) {      //출첵해야함 
                        seedCount = Math.floor(Math.random() * 10) + 1;      // 1 ~ 10
                        seed += seedCount;
                        try {
                            result = await this.dailySeedUpdate(+seedCount, +userID);

                            const text = '펫이 씨앗을 발견했습니다.'
                            let sql = "INSERT INTO cb_object_log (log_sno, log_memNo, log_txt, log_place) VALUES (?, ?, ?, ?)";
                            let datas = [null, +userID, text, +userID];

                            try {
                                let result = await Mysql.getInstance().insertUpdateQuery(sql, datas);
                            } catch (err) {
                                console.log("GameRoom_Create_cb_object_log_Message_Error!!!!!", err);
                                return;
                            }

                        } catch (err) {
                            console.log("dailySeedUpdate", err);
                            return;
                        }
                    }
                } catch (err) {
                    console.log("dailyCheck", err);
                    return;
                }
            }

            let arrTip = [];
            sql = "SELECT cb_tip.* FROM cb_member_tip INNER JOIN cb_tip ON cb_member_tip.tip_sno = cb_tip.tip_sno WHERE cb_member_tip.mem_id =" + +userID;
            try {
                let result = await Mysql.getInstance().query(sql);

                for(let data of result) {
                    let info = {
                        index: data.tip_sno,
                        content: data.tip_content
                    };
                 
                    arrTip.push(info);
                }
            } catch (err) {
                console.log('SELECT cb_tip.* FROM cb_member_tip INNER JOIN',err);
                return err;
            }

            let array = {
                item_sno: 9999,
                item_nm: 'body_player',
                item_img_ch: 'uploads/item/avata/ch/body_player.png'
            };

            let players = {
                cate_value: "body",
                cate_kr: "몸체",
                item: [array]
            };


            if (avatar === null) {
                await this.sleep(1000);
            }

            avatar.push(players);
            //미리 json을 가져와야함 그래야 시그마동기화 addplayer한테 넘김. 결국 플레이어 시그마 변수개수가 에셋만큼 늘어나야 함. 현재 무슨 옷을 입는지. arr로 해도될듯

            sql = 'SELECT mf_cnt, f_sno FROM cb_member_fish WHERE mem_id =' + userID;
            let arrFish = [];

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    let info = {
                        index: data.f_sno,
                        count: data.mf_cnt
                    };
                    arrFish.push(info);
                }
            } catch (err) {
                console.log("GameRoom_onJoin_388_Error!!!!!", err);
                return;
            }


            const playerParts = await this.playerWearableLoadJson(userID, ing_item);

            let partinfo = await JSON.stringify(playerParts);

            const partsUpdateSql = 'UPDATE cb_member SET ing_item=? WHERE mem_id=' + userID;
            const partParams = [partinfo];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(partsUpdateSql, partParams);
            } catch (err) {
                console.log("GameRoom_onJoin_406_Error!!!!!", err);
                return;
            }

            this.state.players.forEach((value, key, map) => {         // 같은 아이디로 여러 로그인하면 닉네임에 인덱스붙임
                if (value.name === nickname) {
                    let index = 0;
                    nickname = this.nameCheck(nickname, index);
                }
            });

            let x = 0, y = 0;
            if (this.templeteInfo.startX !== undefined) {
                x = +this.templeteInfo.startX;
            }

            if (this.templeteInfo.startY !== undefined) {
                y = +this.templeteInfo.startY;
            }

            let roomMasterName = this.roomMasterNickName;

            let badgetitle = badge === 0 ? '' : "칭호란";
            const player = this.state.addPlayer(userID, x, y, 4, 16, nickname, title, depart, fruit, playerParts, roomMasterName, myWater, anyWater, badgetitle);
            this.state.players.set(client.sessionId, player);
            player.addFish(arrFish);
            player.setSeed(seed);

            let arr = this.arrName;
            let arrEffect = this.arrEffect;
            let itemDt = this.arrItemDepth;
            let mapinfo = this.templeteInfo;
            let furn = this.arrFurniture;
            let videoInfo = this.videoInfo;

            let arrInven = {
                arrAvatar: avatar,
                arrLand: arrinfo.land,
                arrItemDepth: itemDt
            };

            let arrAll = {
                arrInven: arrInven,
                arrName: arr,
                arrEffect: arrEffect,
                arrMap: mapinfo,
                arrFurniture: furn,
                arrVideo: videoInfo,
            };

            client.send('fileload', arrAll);

            let info = {
                type: "fruit",
                count: fruit
            };
            client.send('countUpdate', info);               //나중에 all 함수 로 한번에 처리/.

            let decoyinfo = {
                type: "decoy",
                count: decoy
            };
            client.send('countUpdate', decoyinfo);

            let waterinfo = {
                type: "water",
                count: water
            };
            client.send('countUpdate', waterinfo);
            let fertilizerinfo = {
                type: "fertilizer",
                count: fertilizer
            };
            client.send('countUpdate', fertilizerinfo);

            let seedinfo = {
                type: "seed",
                count: seed
            };
            client.send('countUpdate', seedinfo);

            let arrf = arrFish;
            client.send('fish', arrf);

            let mission = this.arrMission;
            client.send('mission', mission);

            if (user_info.room === "myland_outer") {
                let list = this.fishInfo;
                client.send('fishList', list);
                let isWt = this.isWater;
                client.send('isPossibleWater', isWt);
            }
            if (+userID === +user_info.otherUser) {
                client.send('petSeed', seedCount);
            }

            client.send('myTipList',arrTip);
        } //else {
        //     let avatar = [];

        //     let array = {
        //         item_sno: 9999,
        //         item_nm: 'body_player',
        //         item_img_ch: 'uploads/item/avata/ch/body_player.png'
        //     };

        //     let players = {
        //         cate_value: "body",
        //         cate_kr: "몸체",
        //         item: [array]
        //     };

        //     avatar.push(players);

        //     const playerParts = await this.playerWearableLoadJson(99999999, '');

        //     let roomMasterName = this.roomMasterNickName;

        //     //let index = this.nickCount % Math.ceil(this.state.maplevel.width / 16);

        //     //const iAdjusted = Math.floor(this.nickCount / Math.ceil(this.state.maplevel.width / 16));

        //     let x = 0, y = 0;
        //     if (this.templeteInfo.startX !== undefined) {
        //         x = +this.templeteInfo.startX + ((this.xCount * 64));
        //         ++this.xCount;

        //         if (x >= this.mapWidth) {
        //             x = +this.templeteInfo.startX;
        //             this.xCount = 1;
        //             ++this.yCount;
        //         }

        //     }

        //     if (this.templeteInfo.startY !== undefined) {
        //         y = +this.templeteInfo.startY + (this.yCount * 32);
        //     }

        //     let nickname = `mecro${this.nickCount}`;

        //     let userID = `${this.nickCount + 1000}`;
        //     const player = this.state.addPlayer(userID, x, y, 4, 16, nickname, '', '', 0, playerParts, roomMasterName, 'n', 'n');
        //     this.state.players.set(client.sessionId, player);

        //     console.log('Join ID : ', userID);
        //     console.log('currentUserCount : ', this.nickCount);
        //     ++this.nickCount;
        // }
    }

    async onLeave(client, consented) {
        const player = this.state.players[client.sessionId];
        if (player.sitOrLie) {
            const sitorLieType = player.sitOrLieType;
            if (sitorLieType in this.state.furniture) {
                const furniture = this.state.furniture[sitorLieType];

                if ("Left" === player.direction) {
                    furniture.left = false;
                } else if ("Right" === player.direction) {
                    furniture.right = false;
                }
            } else {
                const interactionObj = this.state.interactionObj[sitorLieType];

                if (interactionObj) {
                    interactionObj.isFull = false;
                }
            }

        }
        this.state.players.delete(client.sessionId);
    }

    onDispose() {
    }

    createWorld(maplevel) {
        const { width, height, platformDefs } = maplevel;
        this.mapWidth = width;
        this.mapHeight = height;
    }

    fixedTick(deltaTime) {
        this.state.players.forEach(player => {
            let input = null;
            let lastInput = null;
            let aStarPos = null;
            let aStarArrow = null;
            let lastAstarArrow = null;


            while ((aStarArrow = player.aStarArrowQueue.shift()) || (aStarPos = player.aStarPosQueue.shift()) || (input = player.inputQueue.shift())) {
                let oldPos = {
                    x: player.x,
                    y: player.y
                };
                if (aStarPos) {
                    player.x = aStarPos.x;
                    player.y = aStarPos.y;
                }

                let velocityX = 0;
                let velocityY = 0;

                if (input) {
                    if (input.left) {
                        velocityX -= 1;

                    } else if (input.right) {
                        velocityX += 1;
                    }

                    if (input.up) {
                        velocityY -= 1;

                    } else if (input.down) {
                        velocityY += 1;
                    }

                    if (velocityX !== 0 && velocityY !== 0) {
                        velocityX /= 1.4142135623730951;
                        velocityY /= 1.4142135623730951;
                    }

                    player.x += velocityX * player.speed;
                    player.y += velocityY * player.speed;

                    if (input.space && (player.z <= player.zFloor)) {
                        player.IsJump = true;
                    }

                    if (input.collisionX !== 0) {                 // 벽 충돌인데 클라에서 값을 받아옴.. 클라 의존식 벽충돌
                        player.x = player.x - input.collisionX;
                    }
                    if (input.collisionY !== 0) {
                        player.y = player.y - input.collisionY;
                    }

                    if (input.IsFocus && (!player.IsFocus && !player.IsJump)) {
                        player.IsFocus = input.IsFocus;
                    } else if (!input.IsFocus) {
                        player.IsFocus = input.IsFocus;
                    }
                    this.Jump(player);

                    lastInput = input;

                }
                if (aStarArrow) {
                    lastAstarArrow = aStarArrow;
                }

                if ((oldPos.x !== player.x) || (oldPos.y !== player.y)) {
                    if (player.IsDance) {
                        player.IsDance = false;
                    }
                }
            }

            // && !player.IsFocus
            if (lastInput === null && player.IsJump) {
                this.Jump(player);
            }

            this.State(player, lastInput, lastAstarArrow);
            this.OutWorldBoundary(player);


            //================================================================================
            //player.depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, this.mapHeight, player.y));
            // 부하가 크면 클라이언트에서 해도 된다.여기서는 모든 플레이어 다 하는데 클라이언트에서 하면 나 자신만 하고 서버에 depth를 보내면 그대로 적용하면 된다. (굳이 서버에 depth를 보낼 필요가 있을까?)
        })

        this.state.groundFruits.forEach(fruit => {
            if (fruit.coll && fruit.id) {

                let target = {
                    x: this.state.players[fruit.id].x ? this.state.players[fruit.id].x : 0,
                    y: this.state.players[fruit.id].y ? this.state.players[fruit.id].y : 0,
                }
                if (target.x === 0 && target.y === 0) return;
                let cur = {
                    x: fruit.x,
                    y: fruit.y,
                };

                const pos = Utils.moveTowards(cur, target, 4);

                fruit.x = pos.x;
                fruit.y = pos.y;

                let distance = Utils.Between(fruit.x, fruit.y, target.x, target.y);

                if (distance <= 3) {
                    this.state.groundFruits.delete(fruit.index);
                }
            }
        })


        this.cumTime += deltaTime / 1000;

        if (this.cumTime > this.randomSec) {
            this.cumTime = 0;
            //this.randomBox();
        }
    }

    OutWorldBoundary(player) {              //월드 밖에 나가는지
        player.size = 96 / 2                //임의
        if (player.x - player.size <= 0) {                  //playersize 정보도 필요하다. 플레이어 width,height 두개
            player.x = 0 + player.size;
        } else if (player.x + player.size >= this.mapWidth) {
            player.x = this.mapWidth - player.size;
        }

        if (player.y - player.size <= 0) {
            player.y = 0 + player.size;
        } else if (player.y + player.size >= this.mapHeight) {
            player.y = this.mapHeight - player.size;
        }
    }

    State(player, inputPay, aStar) {
        let input = {
            left: false,
            right: false,
            up: false,
            down: false,
            space: false,
            KeyF: false,
            KeyZ: false,
        };

        if (inputPay) {
            input.left = inputPay.left;
            input.right = inputPay.right;
            input.up = inputPay.up;
            input.down = inputPay.down;
            input.space = inputPay.space;
            input.KeyF = inputPay.KeyF;
            input.KeyZ = inputPay.KeyZ;
        }

        if (aStar) {
            if (!input.KeyZ && !input.KeyF) {
                input.left = aStar.left ? aStar.left : input.left;
                input.right = aStar.right ? aStar.right : input.right;
                input.up = aStar.up ? aStar.up : input.up;
                input.down = aStar.down ? aStar.down : input.down;
            }

        }

        if (input) {
            if (input.KeyZ) {
                if (!input.left && !input.right && !input.up && !input.down && !input.space && !player.IsJump) {

                    let namelength = player.state.length;
                    let startindex = player.state.lastIndexOf('_') + 1;
                    let dir = player.state.substring(startindex, namelength);

                    if (dir === 'Up' || dir === 'Down') {
                        dir = 'Left';
                    }
                    player.state = 'Dance' + '_' + dir;
                    player.IsDance = true;

                }
            }

            if (!player.IsJump && !input.space) {
                if (input.left) {
                    player.state = Player.WALK_LEFT;
                } else if (input.right) {
                    player.state = Player.WALK_RIGHT;
                }
            }
            if (!input.left && !input.right && !player.IsJump && !input.space) {
                if (input.up) {
                    player.state = Player.WALK_UP;
                } else if (input.down) {
                    player.state = Player.WALK_DOWN;
                }
            }
            if (player.IsJump) {
                if (input.up) {
                    player.state = Player.JUMP_UP;
                }
                else if (input.down) {
                    player.state = Player.JUMP_DOWN;
                }

                if (input.left) {
                    player.state = Player.JUMP_LEFT;
                }
                else if (input.right) {
                    player.state = Player.JUMP_RIGHT;
                }

                if (player.state.length !== 0) {
                    let namelength = player.state.length;
                    let startindex = player.state.lastIndexOf('_') + 1;
                    player.state = 'Jump' + '_' + player.state.substring(startindex, namelength);
                }
                else {
                    player.state = Player.JUMP_DOWN;
                }
            }


            if (player.state.length !== 0) {
                let lastindex = player.state.lastIndexOf('_');
                let state = player.state.substring(0, lastindex);

                if (state !== 'Idle' && state !== 'Sit' && state !== 'Lie' && !input.up && !input.down && !input.left && !input.right && !input.space && !player.IsJump && !player.IsDance) {

                    let namelength = player.state.length;
                    let startindex = player.state.lastIndexOf('_') + 1;
                    let currentstate = 'Idle' + '_' + player.state.substring(startindex, namelength);
                    player.state = currentstate;
                }
            }

            // !player.IsFocus && 
        } else if ((input === undefined || input === null)) {
            if (player.state.length !== 0) {
                let lastindex = player.state.lastIndexOf('_');
                let state = player.state.substring(0, lastindex);
                if (state !== 'Idle' && state !== 'Sit' && state !== 'Lie' && !player.IsJump && !player.IsDance) {
                    let namelength = player.state.length;
                    let startindex = player.state.lastIndexOf('_') + 1;
                    let currentstate = 'Idle' + '_' + player.state.substring(startindex, namelength);
                    player.state = currentstate;
                }
            }
        }
    }
    Jump(player) {
        if (player.IsJump) {
            player.z += player.zSpeed;
        }

        if (!player.z <= player.zFloor) {
            player.z -= player.zGravity;
            player.zGravity += 0.1;
        }

        if (player.z <= player.zFloor) {
            player.jumpReset();
        }

        if (player.IsJump && (player.maxHeight < player.z)) {
            player.maxHeight = player.z;         // 아직 상승중
            player.y = player.y - player.z;
        }
        else if (player.IsJump) {                              // 하강 
            player.y = player.y + player.z;
        }
    }

    TileCollision(player) {
        let tile;
        let tileWorldRect = { left: 0, right: 0, top: 0, bottom: 0 };
        for (let i = 0; i < this.state.maplevel.tile.colltile.length; ++i) {

            tile = this.state.maplevel.tile.colltile[i];

            tileWorldRect.left = tile.pixelX;
            tileWorldRect.top = tile.pixelY;
            tileWorldRect.right = tileWorldRect.left + tile.width;
            tileWorldRect.bottom = tileWorldRect.top + tile.height;

            if (Utils.TileIntersects(tileWorldRect, player)) {
                this.TileCheck(player, tile);
            }
        }
    }

    TileCheck(player, tile) {
        const tileX = tile.pixelX + (tile.width / 2);
        const tileY = tile.pixelY + (tile.height / 2);
        const tileMin = {
            x: tileX - (tile.width / 2),
            y: tileY - (tile.height / 2)
        };
        const tileMax = {
            x: tileX + (tile.width / 2),
            y: tileY + (tile.height / 2)
        };



        const playerX = player.x;
        const playerY = player.y + (96 / 2);
        const playerMin = {
            x: playerX - (tile.width / 2),
            y: playerY - (tile.height / 2)
        };
        const playerMax = {
            x: playerX + (tile.width / 2),
            y: playerY
        };

        let collision = {
            x: 0,
            y: 0
        };


        if (playerX < tileX) {
            if (playerMax.x <= tileMin.x) {
                return;
            } else {
                collision.x = playerMax.x - tileMin.x;

                if (playerY < tileY) {
                    if (playerMax.y <= tileMin.y) {
                        return;
                    } else {
                        collision.y = playerMax.y - tileMin.y;
                    }
                } else {
                    if (playerMin.y >= tileMax.y) {
                        return;
                    } else {
                        collision.y = playerMin.y - tileMax.y;
                    }
                }
            }
        } else {
            if (playerMin.x >= tileMax.x) {
                return;
            } else {
                collision.x = playerMin.x - tileMax.x;

                if (playerY < tileY) {
                    if (playerMax.y <= tileMin.y) {
                        return;
                    } else {
                        collision.y = playerMax.y - tileMin.y;
                    }
                } else {
                    if (playerMin.y >= tileMax.y) {
                        return;
                    } else {
                        collision.y = playerMin.y - tileMax.y;
                    }
                }
            }
        }
        // console.log("player", playerMin, playerMax);
        // console.log("collision", collision.x, collision.y);
        if (Math.abs(collision.x) < Math.abs(collision.y)) {
            player.x = player.x - collision.x;
        } else if (Math.abs(collision.y) < Math.abs(collision.x)) {
            player.y = player.y - collision.y;
        }
    }

    async playersheetLoad() {     // db접근 
        // let sheetRoute = '../../../uploads/item/avata/in'
        // let clientRoute = 'uploads/item/avata/in'
        // let file = fs.readdirSync(sheetRoute)

        // for (let i = 0; i < file.length; ++i) {
        //     let info = {
        //         name: '',
        //         route: ''
        //     }

        //     let startIndex = file[i].indexOf('.')           // 같은 이름인데 다른 부위가 있을 수 있다. 결국 이름 앞에 타입까지 같이 가져와야 함. 확장자명만 뺴기
        //     info.name = file[i].substring(0, startIndex)
        //     info.route = clientRoute + '/' + file[i]
        //     this.arrName.push(info)
        //     console.log(info)
        // }
        let sql = 'SELECT item_sno, item_img_in, item_img_in_txt FROM cb_asset_item WHERE item_type = "a" order by item_sno desc';

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {

                if (data.item_img_in_txt.indexOf('effect') !== -1) {
                    let info = {
                        name: '',
                        route: '',
                        width: 0,
                        height: 0,
                        frame: 0
                    };
                    let num = data.item_img_in_txt.match(/-?\d+(\.\d+)?/g);
                    const match = data.item_img_in_txt.match(/\d+_\d+_\d+_\D/g);
                    if (match === null) continue;

                    const numbers = data.item_img_in_txt.match(/-?\d+(\.\d+)?/g);

                    info.name = data.item_sno;
                    let index = data.item_img_in.indexOf('/') + 1;
                    info.route = data.item_img_in.substring(index, data.item_img_in.length);
                    info.width = +numbers[2];
                    info.height = +numbers[3];
                    info.frame = +numbers[4];

                    this.arrEffect.push(info);
                } else {
                    let info = {
                        name: '',
                        route: ''
                    };
                    info.name = data.item_sno;
                    let index = data.item_img_in.indexOf('/') + 1;
                    info.route = data.item_img_in.substring(index, data.item_img_in.length);

                    this.arrName.push(info);
                }
            }
        } catch (err) {
            console.log("Error!!!!!", err);
            throw err;
        }

        let info_state = {
            name: '',
            route: ''
        };

        info_state.name = '9999';            // 임시로 플레이어.
        info_state.route = 'uploads/item/avata/in/body_player.png';
        this.arrName.push(info_state);

        //arrfile에 있는 name 꺼내서 애니메이션json 만들자.
        this.playerAnimationJson();
        this.playerEffectAnimationJson();
    }

    async playerFurnitureLoad() {
        let sql = 'SELECT item_sno, item_img_in FROM cb_asset_item WHERE item_type = "l" order by item_sno desc';

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                try {
                    let arrImg = JSON.parse(data.item_img_in);

                    for (let i = 0; i < arrImg.length; ++i) {
                        let info = {
                            name: '',
                            route: ''
                        };

                        info.name = arrImg[i].txt;
                        let index = arrImg[i].img.indexOf('/') + 1;
                        info.route = arrImg[i].img.substring(index, arrImg[i].img.length);

                        this.arrFurniture.push(info);
                    }
                }
                catch (err) {
                    continue;
                }
            }
        } catch (err) {
            console.log("Error!!!!!", err);
            throw err;
        }
    }

    playerAnimationJson() {
        let arr = {
            anims: []
        };
        let frameRate = 8;

        for (let i = 0; i < this.arrName.length; ++i) {     // 줄이는 방법 있는데 좀 생각해야 함. 어차피 나중엔 시트는 디자이너가 적용하게 만들거임 그때 다시하자.
            let data = this.arrName[i].name;

            let dataKey = data + '_';
            arr.anims.push({
                "key": dataKey + Player.WALK_DOWN,
                "type": "frame",
                "frames": [
                    {
                        "key": data,
                        "frame": 1,
                        "duration": 0
                    },
                    {
                        "key": data,
                        "frame": 2,
                        "duration": 0
                    },
                    {
                        "key": data,
                        "frame": 3,
                        "duration": 0
                    },
                    {
                        "key": data,
                        "frame": 4,
                        "duration": 0
                    },
                    {
                        "key": data,
                        "frame": 5,
                        "duration": 0
                    },
                    {
                        "key": data,
                        "frame": 6,
                        "duration": 0
                    },
                ],
                "frameRate": frameRate,
                "duration": 0,
                "skipMissedFrames": true,
                "delay": 0,
                "repeat": -1,
                "repeatDelay": 0,
                "yoyo": false,
                "showOnStart": false,
                "hideOnComplete": false
            },
                {
                    "key": dataKey + Player.WALK_LEFT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 15,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 16,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 17,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 18,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 19,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 20,
                            "duration": 0
                        },
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": -1,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.WALK_RIGHT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 22,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 23,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 24,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 25,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 26,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 27,
                            "duration": 0
                        },
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": -1,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.WALK_UP,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 8,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 9,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 10,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 11,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 12,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 13,
                            "duration": 0
                        },
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": -1,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.IDLE_DOWN,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 0,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.IDLE_LEFT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 14,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.IDLE_RIGHT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 21,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.IDLE_UP,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 7,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.JUMP_DOWN,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 28,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.JUMP_LEFT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 29,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.JUMP_RIGHT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 30,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.JUMP_UP,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 31,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.SIT_DOWN,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 32,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.SIT_LEFT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 33,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.SIT_RIGHT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 34,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.SIT_UP,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 35,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.LIE_LEFT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 36,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.LIE_RIGHT,
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 37,
                            "duration": 0
                        }
                    ],
                    "frameRate": frameRate,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": 0,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.DANCE_LEFT,            ///asdpasjkdas;ldka;lsdka;lskd
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 42,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 43,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 44,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 45,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 46,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 47,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 48,
                            "duration": 0
                        },
                    ],
                    "frameRate": 16,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": -1,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                },
                {
                    "key": dataKey + Player.DANCE_RIGHT,            ///asdpasjkdas;ldka;lsdka;lskd
                    "type": "frame",
                    "frames": [
                        {
                            "key": data,
                            "frame": 42,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 43,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 44,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 45,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 46,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 47,
                            "duration": 0
                        },
                        {
                            "key": data,
                            "frame": 48,
                            "duration": 0
                        },
                    ],
                    "frameRate": 16,
                    "duration": 0,
                    "skipMissedFrames": true,
                    "delay": 0,
                    "repeat": -1,
                    "repeatDelay": 0,
                    "yoyo": false,
                    "showOnStart": false,
                    "hideOnComplete": false
                }

            );
        }

        let playerAnimJSON = JSON.stringify(arr);
        fs.writeFileSync('static/client/assets/Json/player_animation.json', playerAnimJSON);         // 이것도 나중에 경로 서버에 잡아야 함.
    }

    async playerEffectAnimationJson() {
        let arr = {
            anims: []
        };
        let frameRate = 8;

        for (let i = 0; i < this.arrEffect.length; ++i) {     // 줄이는 방법 있는데 좀 생각해야 함. 어차피 나중엔 시트는 디자이너가 적용하게 만들거임 그때 다시하자.
            let data = this.arrEffect[i].name;

            let frames = this.makeEffectFrame(data, this.arrEffect[i].frame);

            let dataKey = data + '_';
            arr.anims.push({
                "key": dataKey + 'play',
                "type": "frame",
                "frames": frames,
                "frameRate": frameRate,
                "duration": 0,
                "skipMissedFrames": true,
                "delay": 0,
                "repeat": -1,
                "repeatDelay": 0,
                "yoyo": false,
                "showOnStart": false,
                "hideOnComplete": false
            });
        }

        let playerEffectAnim = JSON.stringify(arr);
        fs.writeFileSync('static/client/assets/Json/effect_animation.json', playerEffectAnim);         // 이것도 나중에 경로 서버에 잡아야 함.
    }

    makeEffectFrame(data, frame) {
        let effectframes = [];
        for (let i = 0; i < frame; ++i) {
            let effectInfo = {
                "key": data,
                "frame": i,
                "duration": 0
            };

            effectframes.push(effectInfo);
        }

        return effectframes;
    }



    async playerWearableLoadJson(id, ingitem) {
        return new Promise(async (resolve, reject) => {
            if (ingitem === '') {           // 현재 플레이어의 파츠가 없다 (새로운 플레이어)

                let sql = 'SELECT item_sno, item_img_ch, item_img_in_txt FROM cb_asset_item WHERE item_nm = "arms_basic" OR item_nm = "face_basic" OR item_nm = "top_basic" OR item_nm = "bottoms_basic" order by item_sno desc';


                let infoArr = {};


                try {
                    let result = await Mysql.getInstance().query(sql);

                    for (let data of result) {
                        let info = {
                            name: '',
                            index: 0,
                            frontDepth: 0,
                            backDepth: 0
                        };

                        let startIndex = data.item_img_ch.lastIndexOf('/') + 1;
                        let lastIndex = data.item_img_ch.lastIndexOf('.');

                        info.name = data.item_img_ch.substring(startIndex, lastIndex);
                        info.index = data.item_sno;

                        startIndex = data.item_img_in_txt.indexOf('_') + 1;
                        let frontdepth = data.item_img_in_txt.substring(startIndex, data.item_img_in_txt.length);
                        lastIndex = frontdepth.indexOf('_');
                        let frontdt = frontdepth.substring(0, lastIndex);

                        let backdepth = frontdepth.substring(lastIndex + 1, frontdepth.length);
                        lastIndex = backdepth.indexOf('_');
                        let backdt = backdepth.substring(0, lastIndex);

                        info.frontDepth = +frontdt;
                        info.backDepth = +backdt;

                        infoArr[data.item_img_in_txt.substring(0, startIndex - 1)] = info;

                    }
                } catch (err) {
                    console.log("playerWearableLoadJson_Error!!!!!", err);
                    throw err;
                }

                let defaultinfo = {
                    body: {
                        name: "body_player",
                        index: 9999,
                        frontDepth: 1,
                        backDepth: 1
                    },
                    arms: infoArr["arms"],
                    face: infoArr["face"],
                    top: infoArr["top"],
                    bottoms: infoArr["bottoms"]
                };
                resolve(defaultinfo);
            } else {                        // 파츠가 있다.
                let wearableInfo = JSON.parse(ingitem);

                resolve(wearableInfo);
            }
        })
    }

    async playerFurniture(ingfurniture) {
        return new Promise(async (resolve, reject) => {
            if (ingfurniture === '') {           // 디폴트 가구가 db에 없다.
                let sql = 'SELECT item_sno, item_nm, item_img_in FROM cb_asset_item WHERE item_type = "l" order by item_sno desc';

                try {
                    let result = await Mysql.getInstance().query(sql);
                    let defaultinfo = {};
                    let typesave = {};
                    for (let data of result) {

                        let checkIndex = data.item_nm.indexOf('basic');

                        if (checkIndex !== -1) {
                            let arr = [];
                            1
                            let lastIndex = data.item_nm.indexOf('_');
                            let type = data.item_nm.substring(0, lastIndex);
                            if (typesave[type] !== undefined) {
                                continue;
                            }
                            typesave[type] = true;
                            let img_inJson = JSON.parse(data.item_img_in);

                            for (let i = 0; i < img_inJson.length; ++i) {
                                let info = {
                                    name: '',
                                    index: '',
                                    parentname: ''
                                };

                                info.name = img_inJson[i].txt;
                                info.index = data.item_sno;
                                info.parentname = data.item_nm;
                                arr.push(info);
                            }

                            defaultinfo[type] = arr;
                        }
                    }
                    resolve(defaultinfo);

                } catch (err) {
                    console.log("playerFurniture_ERROR!!!!!", err);
                    throw err;
                }
            } else {
                let ingFurniture = JSON.parse(ingfurniture);

                resolve(ingFurniture);
            }
        });
    }

    nameCheck(name, index) {
        let nick = name + index;
        let stackIndex = index;
        this.state.players.forEach((value, key, map) => {
            if (value.name === nick) {
                ++stackIndex;
                nick = this.nameCheck(name, stackIndex);
            }
        })

        return nick;
    }

    async itemDepth() {
        let sql = 'SELECT * FROM cb_asset_item WHERE item_type ="a"';

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                let num = data.item_img_in_txt.match(/-?\d+(\.\d+)?/g);
                if (num === null) {
                    console.log("2046 null");
                }
                // let startIndex = data.item_img_in_txt.indexOf('_') + 1;
                // let frontdepth = data.item_img_in_txt.substring(startIndex, data.item_img_in_txt.length);
                // let lastIndex = frontdepth.indexOf('_');
                // let frontdt = frontdepth.substring(0, lastIndex);

                // let backdepth = frontdepth.substring(lastIndex + 1, frontdepth.length);
                // lastIndex = backdepth.indexOf('_');
                // let backdt = backdepth.substring(0, lastIndex);
                let frontdt = num[0];
                let backdt = num[1];
                let nmidx = data.item_nm.indexOf('_') + 1;

                if (frontdt === '') {
                    frontdt = 1;
                }
                if (backdt === '') {
                    backdt = 1;
                }

                let info = {
                    itemIdx: +data.item_sno,
                    itemAlt: data.item_nm.substring(0, nmidx) + data.item_sno,
                    frontDepth: +frontdt,
                    backDepth: +backdt
                };


                this.arrItemDepth.push(info);
            }
        } catch (err) {
            console.log("GameRoom_Create_Error!!!!!", err);
            throw err;
        }
    }

    async sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    resetItem() {

    }


    async mylandOuter() {
        let sql = 'SELECT mem_nickname FROM cb_member WHERE mem_id =' + this.roomMasterId;

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                this.roomMasterNickName = data.mem_nickname;
            }

        } catch (err) {
            console.log("GameRoom_Create_Error!!!!!", err);
            return err;
        }

        sql = 'SELECT * FROM cb_game_field WHERE mem_id =' + this.roomMasterId;

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                if ((data.cur_lv <= 5) && (data.crop_flag === 0)) {
                    const crops = this.state.addCrops(data.plant_index, data.cur_lv, data.total_time);         //cur_lv, crop_flag, plant_index
                    // 결국 x,y 받아야함 임의로 함 일단.
                    this.state.crops.set(data.plant_index, crops);
                }
            }
        } catch (err) {
            console.log("GameRoom_Create_Error!!!!!", err);
            return err;
        }

        sql = 'SELECT f_sno, f_nm FROM cb_fish';

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                let index = data.f_sno;
                let name = data.f_nm;

                this.fishInfo[index] = name;
            }
        } catch (err) {
            console.log("GameRoom_cb_fish_Create_Error!!!!!", err);
            return err;
        }

        sql = "SELECT * FROM cb_myland_table WHERE mem_id =" + +this.roomMasterId;

        try {
            let result = await Mysql.getInstance().query(sql);
            if (result.length === 0) {              // 데이터가 아예 없다.   
                // sql = "INSERT INTO cb_myland_daily_login (mem_id,type,login_date) VALUES (?,?,?)";
                // let param = [+userId, "pet", Utils.GetDate()]
                // result = await Mysql.getInstance().insertUpdateQuery(sql, param);
                // if (result.affectedRows === 0) {
                //     console.log("INSERT INTO cb_myland_daily_login Err");

                // } else {
                this.isWater = true;
            } else {            // 데이터는 있다.
                let lastTime;

                for (let data of result) {
                    lastTime = data.last_water_date;
                }

                if (lastTime !== null) {
                    const lastDate = new Date(lastTime);
                    const toDay = new Date();

                    if (!Utils.isSameDate(toDay, lastDate)) {     // 오늘 아무도 안 뜸
                        this.isWater = true;
                    }
                }

                if (lastTime === null) {        // 단 한번도 뜬 사람이 없다.
                    this.isWater = true;
                }
            }

        } catch (err) {
            console.log("GameRoom_cb_myland_table_Create_Error", err);
            return err;
        }

        sql = "SELECT * FROM cb_tip";

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                let info = {
                    index: data.tip_sno,
                    content: data.tip_content
                }

                this.arrTip.push(info);
            }
        } catch (err) {
            console.log("cb_tip Err", err);
            return err;
        }

        this.onMessage('fruits', async (client, vInfo) => {             //밭에 설치

            if (this.state.crops.has(`${vInfo.index}`) || vInfo.id !== this.roomMasterId || +this.state.players[client.sessionId].seedCount === 0) return;

            const crops = this.state.addCrops(vInfo.index, 1, 480);
            crops.x = vInfo.x;
            crops.y = vInfo.y;
            this.state.crops.set(vInfo.index, crops);

            const sql = 'INSERT INTO cb_game_field (mem_id, cur_lv, total_time, next_lv_time, crop_flag, plant_index) VALUES (?, ?, ?, ?, ?, ?)';

            const dataToInsert = [this.roomMasterId, 1, 480, 120, 0, vInfo.index];      //열매 설치 디폴트

            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, dataToInsert);
            } catch (err) {
                console.log("GameRoom_Create_fruits_Error!!!!!", err);
                return;
            }

            //지렁이 1~5 확률   5: 40%  4: 30%  3: 15%  2: 10%  1:5%
            let percent = [5, 10, 15, 30, 40];
            let index = Utils.RandomPrize(percent) + 1;

            const UpdateSql = 'UPDATE cb_member SET mem_cur_decoy = mem_cur_decoy + ?, mem_cur_seed = mem_cur_seed - 1   WHERE mem_id=?';
            const dataParams = [+index, this.roomMasterId];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(UpdateSql, dataParams);
            } catch (err) {
                console.log("GameRoom_Create_mem_cur_decoy_Error!!!!!", err);
                return;
            }

            let decoy = 0;
            let seed = 0;
            let selectsql = 'SELECT mem_cur_seed, mem_cur_decoy FROM cb_member WHERE mem_id =' + this.roomMasterId;

            try {
                let result = await Mysql.getInstance().query(selectsql);

                for (let data of result) {
                    seed = data.mem_cur_seed;
                    decoy = data.mem_cur_decoy;
                }
            } catch (err) {
                console.log("mylandInner_Error!!!!!", err);
                return;
            }
            this.state.players[client.sessionId].setSeed(seed);


            let info = {
                type: "plantSeed",
                total: seed
            };

            client.send('logSend', info);

            let decoyinfo = {
                type: "getDecoy",
                count: index,
                total: decoy
            };

            client.send('logSend', decoyinfo);
        })

        this.onMessage('harvesting', async (client, vInfo) => {         //열매 수확
            if (!this.state.crops.has(`${vInfo.index}`) || vInfo.id !== this.roomMasterId || (this.state.crops[vInfo.index].level !== 5)) return;

            const harvestingSql = 'UPDATE cb_game_field SET crop_flag =? WHERE mem_id=? AND crop_flag = 0 AND plant_index = ?';
            const dataParams = ['1', this.roomMasterId, `${vInfo.index}`];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(harvestingSql, dataParams);
            } catch (err) {
                console.log("GameRoom_Create_harvesting_Error!!!!!", err);
                return;
            }

            let percent = [5, 10, 15, 30, 40];
            let index = Utils.RandomPrize(percent) + 1;

            const updateSql = 'UPDATE cb_member SET mem_cur_fruit= mem_cur_fruit + 1, mem_cur_decoy= mem_cur_decoy + ?  WHERE mem_id=' + this.roomMasterId;            // 열매 + 1
            const dataParam = [+index];

            try {
                let result = await Mysql.getInstance().insertUpdateQuery(updateSql, dataParam);
            } catch (err) {
                console.log("GameRoom_Create_updateSql_Error!!!!!", err);
                return;
            }

            let decoy = 0;
            let sql = 'SELECT mem_cur_decoy FROM cb_member WHERE mem_id =' + this.roomMasterId;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    decoy = data.mem_cur_decoy;
                }
            } catch (err) {
                console.log("mylandInner_Error!!!!!", err);
                return;
            }

            this.state.crops.delete(`${vInfo.index}`);
            ++this.state.players[client.sessionId].fruit;

            let info = {
                type: "getFruit",
                count: this.state.players[client.sessionId].fruit,
                total: this.state.players[client.sessionId].fruit
            };

            client.send('logSend', info);


            let decoyinfo = {
                type: "getDecoy",
                count: index,
                total: decoy
            };

            client.send('logSend', decoyinfo);
        })

        this.onMessage('levelUpFruit', async (client, info) => {
            if (!this.state.crops.has(`${info.index}`) || info.id !== this.roomMasterId || (this.state.crops[info.index].level === 5)) return;
            const crops = this.state.crops[`${info.index}`];
            ++crops.level;
            let totaltime = 0;
            totaltime = 480 - 120 * (+crops.level - 1);

            crops.totalTime = +totaltime;

            let updateSql = 'UPDATE cb_game_field SET cur_lv =?, total_time=? WHERE mem_id=? AND crop_flag = 0 AND plant_index = ?';
            const dataParam = [+crops.level, +totaltime, this.roomMasterId, `${info.index}`];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(updateSql, dataParam);
            } catch (err) {
                console.log("GameRoom_Create_levelUpFruit_Error!!!!!", err);
                return;
            }
        });


        this.onMessage('applyFertilizer', async (client, info) => {         // 비료 or 물를 썼다.
            if (!this.state.crops.has(`${info.index}`) || info.id !== this.roomMasterId || (this.state.crops[info.index].level === 5)) return;

            let curWater = 0;
            let curFertilizer = 0;
            let totalcount = 0;
            const selectSql = 'SELECT mem_cur_water, mem_cur_fertilizer FROM cb_member WHERE mem_id=' + +this.state.players[client.sessionId].id;

            try {
                let result = await Mysql.getInstance().query(selectSql);

                for (let data of result) {
                    curWater = data.mem_cur_water;
                    curFertilizer = data.mem_cur_fertilizer;
                }
            } catch (err) {
                console.log("GameRoom_selectSqlFertilizer_Error!!!!!", err);
                return;
            }

            if (info.type === 'Water' && curWater <= 0) return;
            if (info.type === 'Fertilizer' && curFertilizer <= 0) return;

            let curLv, totalTime, nextLvTime;
            const applySql = 'SELECT cur_lv, total_time, next_lv_time FROM cb_game_field WHERE mem_id=? AND crop_flag = 0 AND plant_index = ?';
            const dataParams = [this.roomMasterId, `${info.index}`];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(applySql, dataParams);

                for (let data of result) {
                    curLv = data.cur_lv;
                    totalTime = data.total_time;
                    nextLvTime = data.next_lv_time;
                }
            } catch (err) {
                console.log("GameRoom_applyFertilizer_Error!!!!!", err);
                return;
            }

            const waterTime = 60;       //분
            const defaultTime = 120;
            const defaultMaxTime = 480;

            if (info.type === 'Water') {            //물
                let curTime = totalTime - waterTime;
                if (curTime <= 0) { //수확해야함 레벨 5만들고 나머지 0
                    curLv = 5;
                    curTime = 0;
                    nextLvTime = 0;
                } else {        //수확은 못한다.
                    const nextTime = nextLvTime - waterTime;
                    if (nextTime === 0) {      // 다음 레벨로 올라가야함.
                        ++curLv;
                        nextLvTime = defaultTime;
                    } else if (nextTime < 0) {
                        ++curLv;
                        nextLvTime = defaultTime - nextTime;
                    } else {                 // 다음 레벨 안감.
                        nextLvTime = nextTime;
                    }
                }

                --curWater;
                totalcount = curWater;
                totalTime = curTime;
            } else if (info.type === 'Fertilizer') {
                if (totalTime <= 10) {
                    curLv = 5;
                    totalTime = 0;
                    nextLvTime = 0;

                } else {
                    // 레벨구하기 : 최대레벨 - (최소레벨 + (현재총남은시간 / 기본 레벨당 남은시간)) 
                    totalTime /= 2;
                    totalTime = Math.floor(totalTime * 0.1) * 10;

                    const notCeilLv = 5 - (1 + (totalTime / defaultTime));
                    let line = Math.floor((totalTime % defaultTime === 0 ? 1 : 0));

                    curLv = Math.ceil(notCeilLv) + line;

                    // 남은시간 구하기 
                    nextLvTime = totalTime % defaultTime + line * 120;
                }

                --curFertilizer;
                totalcount = curFertilizer;
            }

            let updateSql = 'UPDATE cb_game_field SET cur_lv =?, total_time =?, next_lv_time =? WHERE mem_id=? AND crop_flag = 0 AND plant_index = ?';
            const dataParam = [+curLv, +totalTime, +nextLvTime, this.roomMasterId, `${info.index}`];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(updateSql, dataParam);
            } catch (err) {
                console.log("GameRoom_Create_harvesting_Error!!!!!", err);
                return;
            }

            const crops = this.state.crops[`${info.index}`];
            crops.level = +curLv;
            crops.totalTime = +totalTime;

            updateSql = 'UPDATE cb_member SET mem_cur_water =?, mem_cur_fertilizer =? WHERE mem_id=' + +this.state.players[client.sessionId].id;
            const Param = [curWater, curFertilizer];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(updateSql, Param);
            } catch (err) {
                console.log("GameRoom_Create_harvesting_Error!!!!!", err);
                return;
            }

            let sendinfo = {
                type: "spread" + info.type,
                total: totalcount
            };
            client.send('logSend', sendinfo);
        })

        this.onMessage('fishing', async (client, info) => {    //낚시 시작 or 중도 포기 // 지렁이 -1 해야하고 확률 계산 (확률 계산 후 결과가 나오면 마지막에 지렁이 -1)
            this.state.players[client.sessionId].isFishing = info.isFishing;

            if (this.state.players[client.sessionId].isFishing) {
                let decoy = 0;

                let sql = 'SELECT mem_cur_decoy FROM cb_member WHERE mem_id =' + this.state.players[client.sessionId].id;

                try {
                    let result = await Mysql.getInstance().query(sql);

                    for (let data of result) {
                        decoy = data.mem_cur_decoy;
                    }
                } catch (err) {
                    console.log("mylandInner_Error!!!!!", err);
                    return;
                }

                if (decoy <= 0) {
                    this.state.players[client.sessionId].isFishing = false;
                    //client.send('지렁이부족')
                    return;
                }
            }
        })


        this.onMessage('fishingPrize', async (client, time) => {
            if (time < this.fishingMaxSeconds || !this.state.players[client.sessionId].isFishing) return;

            let decoy = 0;
            let sql = 'SELECT mem_cur_decoy FROM cb_member WHERE mem_id =' + this.state.players[client.sessionId].id;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    decoy = data.mem_cur_decoy;
                }

                if (decoy <= 0) return;

                let info = await this.fishingPrize(client.sessionId);

                if (info === undefined) return;

                client.send('logSend', info);

                let decoyinfo = {
                    type: "baitDecoy",
                    total: --decoy
                };

                client.send('logSend', decoyinfo);

            } catch (err) {
                console.log("mylandInner_Error!!!!!", err);
                return;
            }
        })

        this.onMessage('well', async (client) => {
            const player = this.state.players[client.sessionId];
            if (player.myWater !== "y" && player.anyWater !== "y") return;

            let waterInfo = {
                type: "getWater",
                total: 0,
                name: ''
            };

            if ((player.id === this.roomMasterId) && (player.myWater === "y")) {       // 나의 룸
                const UpdateSql = 'UPDATE cb_member SET mem_cur_water = mem_cur_water + 1 ,my_waterYn= "n" WHERE mem_id=' + player.id;
                try {
                    let result = await Mysql.getInstance().query(UpdateSql);

                    player.myWater = "n";
                    waterInfo.name = player.name;
                } catch (err) {
                    console.log("my_waterYn_Error!!!!!", err);
                    return;
                }
            } else if ((player.id !== this.roomMasterId) && (player.anyWater === "y" && this.isWater)) {                // 상대방의 룸

                const UpdateSql = 'UPDATE cb_member SET mem_cur_water = mem_cur_water + 1 ,any_waterYn="n" WHERE mem_id=' + player.id;
                try {
                    let result = await Mysql.getInstance().query(UpdateSql);

                    player.anyWater = "n";
                    this.isWater = false;
                    let isWt = this.isWater;
                    this.broadcast('isPossibleWater', isWt);

                    const sql = 'INSERT INTO cb_myland_table (mem_id, last_water_date) VALUES (?,?) ON DUPLICATE KEY UPDATE last_water_date = ?';
                    const param = [this.roomMasterId, Utils.GetDate(), Utils.GetDate()];

                    try {
                        result = await Mysql.getInstance().insertUpdateQuery(sql, param);
                    } catch (err) {
                        console.log("INSERT INTO cb_myland_table", err);
                        return err;
                    }

                } catch (err) {
                    console.log("any_waterYn_Error!!!!!", err);
                    return err;
                }
            } else {
                return;
            }

            let waterCount = 0;

            const selectSql = 'SELECT mem_cur_water FROM cb_member WHERE mem_id=' + player.id;

            try {
                let result = await Mysql.getInstance().query(selectSql);

                for (let data of result) {
                    waterCount = data.mem_cur_water;
                }
            } catch (err) {
                console.log("GameRoom_mem_cur_water_Error!!!!!", err);
                return;
            }

            if (+player.id !== +this.roomMasterId) {
                waterInfo.name = this.roomMasterNickName;
            }

            waterInfo.total = waterCount;

            client.send('logSend', waterInfo);
        });



        //나중에 디비에서 갖고와야할 정보를 하드코딩해서 미리 작업 . 240104  ing~
    }

    async mylandInner() {
        let ingfurn;
        //let arrinfo;

        let sql = 'SELECT mem_nickname, member_item, ing_furniture FROM cb_member WHERE mem_id =' + this.roomMasterId;

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                this.roomMasterNickName = data.mem_nickname;
                ingfurn = data.ing_furniture;
                // arrinfo = JSON.parse(data.member_item);
            }

            // console.log(arrinfo.land);
        } catch (err) {
            console.log("mylandInner_Error!!!!!", err);
            return;
        }

        // for(let i =0; i < arrinfo.land.length; ++i) {            // db 입출력이 너무 많으면 미리 다 생성해서 정보를 담고 있으려고 만들었던 코드.
        //     for(let j =0; j < arrinfo.land[i].item.length; ++j) {
        //         console.log(arrinfo.land[i].item[j]);
        //this.curfurniture[arrinfo.land]
        //     }

        // }


        await this.playerFurnitureLoad();

        const furnArr = await this.playerFurniture(ingfurn);

        let info = await JSON.stringify(furnArr);

        const UpdateSql = 'UPDATE cb_member SET ing_furniture=? WHERE mem_id=' + this.roomMasterId;
        const Params = [info];

        try {
            let result = await Mysql.getInstance().insertUpdateQuery(UpdateSql, Params);
        } catch (err) {
            console.log("GameRoom_mylandInnerSql_Error!!!!!", err);
            return;
        }

        for (let type in furnArr) {
            const furnitures = this.state.addFurniture(type, furnArr[type]);
            this.state.furniture.set(type, furnitures);
        }

        this.onMessage('changeFurniture', async (client, Info) => {
            if (Info.id !== this.roomMasterId) return;
            const furniture = this.state.furniture[Info.data.type];
            if (furniture.type === Info.data.type) {
                if (furniture.index === Info.data.index) {       // 이미 같은 가구다.
                    return;
                }
                let itemName = '';
                let itemimgin = [];
                sql = 'SELECT item_nm, item_img_in FROM cb_asset_item WHERE item_sno =' + Info.data.index;

                try {
                    let result = await Mysql.getInstance().query(sql);

                    for (let data of result) {
                        itemName = data.item_nm;
                        itemimgin = JSON.parse(data.item_img_in);
                    }
                } catch (err) {
                    console.log('changeFurniture_Error!!!!!', err);
                    return;
                }

                if (itemName === '' || itemimgin.length <= 0) {
                    return;
                }

                sql = 'SELECT ing_furniture FROM cb_member WHERE mem_id =' + this.roomMasterId;

                try {
                    let result = await Mysql.getInstance().query(sql);

                    for (let data of result) {
                        ingfurn = JSON.parse(data.ing_furniture);
                    }
                } catch (err) {
                    console.log("mylandInner_Error!!!!!", err);
                    throw err;
                }

                if (ingfurn[Info.data.type] !== undefined) {
                    let arr = [];

                    for (let i = 0; i < itemimgin.length; ++i) {
                        let info = {
                            name: '',
                            index: '',
                            parentname: ''
                        };

                        info.name = itemimgin[i].txt;
                        info.index = Info.data.index;
                        info.parentname = itemName;
                        arr.push(info);
                    }
                    ingfurn[Info.data.type] = arr;

                    const UpdateSql = 'UPDATE cb_member SET ing_furniture=? WHERE mem_id=' + this.roomMasterId;
                    const Params = [JSON.stringify(ingfurn)];

                    try {
                        let result = await Mysql.getInstance().insertUpdateQuery(UpdateSql, Params);
                    } catch (err) {
                        console.log("GameRoom_mylandInner_changeFurnitureSql_Error!!!!!", err);
                        return;
                    }

                    furniture.changeType(ingfurn[Info.data.type]);
                }

                return;
            }
        })

        this.onMessage('curState', async (client, Info) => {
            const furniture = this.state.furniture[Info.data.type];
            const player = this.state.players[client.sessionId];

            furniture.left = Info.data.left;
            furniture.right = Info.data.right;

            player.sitOrLieType = Info.data.type;
            player.direction = Info.data.dir
        })


        this.onMessage('leaveState', async (client, Info) => {
            const furniture = this.state.furniture[Info.data.type];
            const player = this.state.players[client.sessionId];

            furniture.left = Info.data.left;
            furniture.right = Info.data.right;

            player.sitOrLieType = '';
            player.direction = '';
        })

    }

    async fishingPrize(sessionId) {
        let sql = 'SELECT * FROM cb_fish_cate WHERE fc_depth =1';
        let typeArr = [];
        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                let info = {
                    index: 0,
                    name: '',
                    probability: 0
                };
                info.index = data.fc_sno;
                info.name = data.fc_nm;
                info.probability = data.fc_probability;

                typeArr.push(info);
            }
        } catch (err) {
            console.log('fishingPrize_Error!!!!!', err);
            return;
        }

        typeArr.sort((a, b) => {
            return a.probability - b.probability;
        });

        let index = Utils.RandomFishPrize(typeArr);

        let sendInfo = {
            type: ''
        };

        if (typeArr[index].name === "유리병") {
            sendInfo.type = "getBottle";

            const index = Utils.RandomCount(0, this.arrTip.length - 1);
            sendInfo.text = this.arrTip[index].content;

            sql = "SELECT * FROM cb_member_tip WHERE tip_sno = ? AND mem_id =" + +this.state.players[sessionId].id;
            let param = [this.arrTip[index].index];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, param);

                if (result.length === 0) { //삽입해야 함.
                    sql = "INSERT INTO cb_member_tip (tip_sno, mtip_count, mem_id) VALUES (?, ?, ?)";
                    param = [this.arrTip[index].index, 1, +this.state.players[sessionId].id];

                    try {
                        result = await Mysql.getInstance().insertUpdateQuery(sql, param);
                    } catch (err) {
                        console.log('INSERT INTO cb_member_tip', err);
                        return err;
                    }
                } else {            // 카운터만 올리자.
                    sql = "UPDATE cb_member_tip SET mtip_count = mtip_count + 1 WHERE mem_id =" + +this.state.players[sessionId].id;
                    try {
                        result = await Mysql.getInstance().query(sql);
                    } catch (err) {
                        console.log('UPDATE cb_member_tip', err);
                        return err;
                    }
                }
            } catch (err) {
                console.log("cb_member_tip WHERE Err", err);
                return err;
            }

        } else if (typeArr[index].name === "쓰레기") {
            sendInfo.type = "getTrash";
        } else if (typeArr[index].name === "코인") {
            const updatesql = 'UPDATE cb_member SET mem_cur_fruit= mem_cur_fruit + 1 WHERE mem_id=' + +this.state.players[sessionId].id;
            try {
                let result = await Mysql.getInstance().query(updatesql);
            } catch (err) {
                console.log("GameRoom_cb_member_getFruitFishing_Error!!!!!", err);
                return;
            }

            ++this.state.players[sessionId].fruit;

            sendInfo.type = "getFruitFishing";
            sendInfo.count = this.state.players[sessionId].fruit;
            sendInfo.total = this.state.players[sessionId].fruit;


        } else if (typeArr[index].name === "물고기") {
            sendInfo.type = "getFish";

            let waterTypeArr = [];

            sql = 'SELECT * FROM cb_fish_cate WHERE fc_parent =' + +typeArr[index].index;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    let info = {
                        index: 0,
                        name: '',
                        probability: 0
                    };
                    info.index = data.fc_sno;
                    info.name = data.fc_nm;
                    info.probability = data.fc_probability;

                    waterTypeArr.push(info);
                }
            } catch (err) {
                console.log('fishingPrize_1Error!!!!!', err);
                return;
            }

            waterTypeArr.sort((a, b) => {
                return a.probability - b.probability;
            });

            index = Utils.RandomFishPrize(waterTypeArr);


            let gradeArr = [];
            sql = 'SELECT * FROM cb_fish_cate WHERE fc_parent =' + +waterTypeArr[index].index;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    let info = {
                        index: 0,
                        name: '',
                        probability: 0
                    };
                    info.index = data.fc_sno;
                    info.name = data.fc_nm;
                    info.probability = data.fc_probability;

                    gradeArr.push(info);
                }
            } catch (err) {
                console.log('fishingPrize_2Error!!!!!', err);
                return;
            }

            gradeArr.sort((a, b) => {
                return a.probability - b.probability;
            });

            index = Utils.RandomFishPrize(gradeArr);

            let fishArr = [];

            sql = 'SELECT f_sno, f_nm FROM cb_fish WHERE f_cate =' + +gradeArr[index].index;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (let data of result) {
                    let info = {
                        index: 0,
                        name: '',
                        probability: 0
                    };

                    info.index = data.f_sno;
                    info.name = data.f_nm;

                    fishArr.push(info);
                }
            } catch (err) {
                console.log('fishingPrize_3Error!!!!!', err);
                return;
            }

            let Aver = 100 / (fishArr.length);

            for (let i = 0; i < fishArr.length; ++i) {
                fishArr[i].probability = Aver;
            }

            fishArr.sort((a, b) => {
                return a.probability - b.probability;
            });

            index = Utils.RandomFishPrize(fishArr);


            let countCheck = 0;
            sql = 'SELECT COUNT(*) as count_f_sno FROM cb_member_fish WHERE mem_id= ? AND f_sno =' + +fishArr[index].index;
            const param = [this.state.players[sessionId].id];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, param);

                for (let data of result) {
                    countCheck = data.count_f_sno;
                }
            } catch (err) {
                console.log('fishingPrize_3Error!!!!!', err);
                return;
            }

            if (countCheck > 0) { //컬럼있다.
                const updatesql = 'UPDATE cb_member_fish SET mf_cnt= mf_cnt + 1 WHERE mem_id= ? AND f_sno= ?';
                const partParams = [this.state.players[sessionId].id, fishArr[index].index];
                try {
                    let result = await Mysql.getInstance().insertUpdateQuery(updatesql, partParams);
                } catch (err) {
                    console.log("GameRoom_cb_member_fish1_Error!!!!!", err);
                    return;
                }
            } else { //추가해야한다.
                const insertsql = 'INSERT INTO cb_member_fish (mf_cnt, f_sno, mem_id) VALUES (?, ?, ?)';
                const dataToInsert = [1, fishArr[index].index, this.state.players[sessionId].id];

                try {
                    let result = await Mysql.getInstance().insertUpdateQuery(insertsql, dataToInsert);
                } catch (err) {
                    console.log("GameRoom_cb_member_fish2_Error!!!!!", err);
                    return;
                }
            }

            const updatesql = 'UPDATE cb_member SET mem_cur_fish= mem_cur_fish + 1 WHERE mem_id= ?';
            const partParams = [this.state.players[sessionId].id];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(updatesql, partParams);
            } catch (err) {
                console.log("GameRoom_cb_member_fish1_Error!!!!!", err);
                return;
            }

            sendInfo.fishName = fishArr[index].name;
            sendInfo.index = fishArr[index].index;
        }

        const updatesql = 'UPDATE cb_member SET mem_cur_decoy= mem_cur_decoy - 1 WHERE mem_id=' + +this.state.players[sessionId].id;

        try {
            let result = await Mysql.getInstance().query(updatesql);
        } catch (err) {
            console.log("GameRoom_cb_member_mem_cur_decoy_Error!!!!!", err);
            return;
        }

        return sendInfo;
    }

    randomBox() {
        let count = Utils.RandomCount(0, Object.keys(this.randomBoxPos).length - 1);

        let fruitCount = this.cumFruitCount++;

        const fruit = this.state.addGroundFruit(this.randomBoxPos[count].x, this.randomBoxPos[count].y, fruitCount);
        this.state.groundFruits.set(fruitCount, fruit);
    }

    async resetSql(table, cul, param) {
        const updateSql = `UPDATE ${table} SET ${cul} = ?`;
        const updateParam = [param];
        try {
            let result = await Mysql.getInstance().insertUpdateQuery(updateSql, updateParam);
            console.log(updateSql);
        } catch (err) {
            console.log("GameRoom_reset_Error!!!!!", err);
            return;
        }

    }

    async dailyCheck(userId) {
        return new Promise(async (resolve, reject) => {
            let sql = "SELECT * FROM cb_myland_daily_login WHERE DATE(login_date) = DATE(NOW()) AND mem_id =" + +userId;

            try {
                let result = await Mysql.getInstance().query(sql);
                if (result.length === 0) {           // 오늘자 데이터가 없다.
                    sql = "INSERT INTO cb_myland_daily_login (mem_id,type,login_date) VALUES (?,?,?)";
                    let param = [+userId, "pet", Utils.GetDate()]
                    result = await Mysql.getInstance().insertUpdateQuery(sql, param);
                    if (result.affectedRows === 0) {
                        console.log("INSERT INTO cb_myland_daily_login Err");
                        reject();
                    } else {
                        resolve(result);
                    }
                }

                resolve(result);
            } catch (err) {
                console.log("cb_myland_daily_login Err", err);
                reject(err);
            }
        });
    }

    async dailySeedUpdate(count, userId) {
        return new Promise(async (resolve, reject) => {
            let userID = userId;
            let seedCount = count;
            let sql = "UPDATE cb_member SET mem_cur_seed= mem_cur_seed + ? WHERE mem_id=" + userID;
            let param = [seedCount];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, param);

                resolve(result);
            } catch (err) {
                reject(err);
            }
        });
    }
}

