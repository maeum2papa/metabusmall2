const colyseus = require('colyseus');
const schema = require('@colyseus/schema');
const Schema = schema.Schema;
const { Mysql } = require('../database/mysql');
const fs = require('fs');

const { Player } = require('./schema/player');

class GameEducationRoom extends colyseus.Room {
    fixedTimeStep = 1000 / 20;
    sendInfo;
    arrName = [];
    arrEffect = [];

    async onCreate(options) {
        //템플릿의 정보와 플레이어의 정보를 가져와야 한다. 
        let user_info = options.user_Info;

        let sql = 'SELECT mp_sno FROM cb_my_process_sub WHERE mps_sno =' + +user_info.mps_sno;
        let mp_sno;
        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                mp_sno = data.mp_sno;
            }
        } catch (err) {
            console.log("GameEducationRoom_Create_cb_my_process_sub_Error!!", err);
            return;
        }

        sql = 'SELECT * FROM cb_my_process_sub as mps inner join cb_my_process as mp on mps.mps_sno = mp.mp_sno join cb_lms_process_curriculum as p on mp.p_sno = p.p_sno join cb_gamecontents as g on p.t_sno = g.g_sno WHERE mp.mp_sno =' + mp_sno;
        
        let tp_sno, g_question, g_time, g_method;
        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                tp_sno = data.tp_sno;
                g_question = JSON.parse(data.g_question);
                g_time = data.g_time;
                g_method = data.g_method;
            }
        } catch (err) {
            console.log("GameEducationRoom_Create_cb_gamecontents_Error!!", err);
            return;
        }

        // const index = 4;
        // sql = 'SELECT * FROM cb_gamecontents WHERE g_sno =' + +index;
        // let tp_sno, g_question, g_time, g_method;
        // try {
        //     let result = await Mysql.getInstance().query(sql);

        //     for (let data of result) {
        //         tp_sno = data.tp_sno;
        //         g_question = JSON.parse(data.g_question);
        //         g_time = data.g_time;
        //         g_method = data.g_method;
        //     }
        // } catch (err) {
        //     console.log("GameEducationRoom_Create_cb_gamecontents_Error!!", err);
        //     return;
        // }

        sql = 'SELECT tp_data FROM cb_asset_template WHERE tp_sno =' + +tp_sno;
        let tp_data;
        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                tp_data = data.tp_data;
            }
        } catch (err) {
            console.log("GameEducationRoom_Create_cb_asset_template_Error!!", err);
            return;
        }

        this.sendInfo = {
            data: tp_data,
            method: g_method,
            time: g_time,
            question: g_question
        };

        await this.playersheetLoad();


        this.onMessage('educationSuccess', async (client, mps_sno) => { 

            const partsUpdateSql = 'UPDATE cb_my_process_sub SET mps_endYn=? WHERE mps_sno=' + +mps_sno;
            const partParams = ['y'];
            try {
                let result = await Mysql.getInstance().insertUpdateQuery(partsUpdateSql, partParams);
            } catch (err) {
                console.log("GameEducationRoom_educationSuccess_Error!!!!!", err);
                return;
            }



            let sql = 'SELECT mp_sno FROM cb_my_process_sub WHERE mps_sno =' + +mps_sno;
            let mp_sno;
            try {
                let result = await Mysql.getInstance().query(sql);
    
                for (let data of result) {
                    mp_sno = data.mp_sno;
                }
            } catch (err) {
                console.log("GameEducationRoom_Create_cb_gamecontents_Error!!", err);
                return;
            }

            

            client.send('success', mp_sno);
        })

        
    }

    async onJoin(client, options) {
        let user_info = options.user_Info;
        console.log(user_info);
        const userID = user_info.currentUser;

        let nickname, title, ing_item, depart;

        let sql = 'SELECT mem_div, mem_position, mem_nickname, ing_item FROM cb_member WHERE mem_id =' + userID;

        try {
            let result = await Mysql.getInstance().query(sql);

            for (let data of result) {
                nickname = data.mem_nickname;               //닉네임
                title = data.mem_position;                   //직급                   
                ing_item = data.ing_item;                    //현재 착용중인 아이템
                depart = data.mem_div;                     // 부서명
            }

        } catch (err) {
            console.log("GameEducationRoom_onJoin_cb_member_Error!!", err);
            return;
        }

        const playerParts = await this.playerWearableLoadJson(userID, ing_item);

        let partinfo = await JSON.stringify(playerParts);

        const partsUpdateSql = 'UPDATE cb_member SET ing_item=? WHERE mem_id=' + userID;
        const partParams = [partinfo];
        try {
            let result = await Mysql.getInstance().insertUpdateQuery(partsUpdateSql, partParams);
        } catch (err) {
            console.log("GameEducationRoom_onJoin_partsUpdateSql_Error!!!!!", err);
            return;
        }


        let info = this.sendInfo;
        info.nickname = nickname;
        info.title = title; 
        info.ing_item = playerParts;
        info.depart = depart;
        info.arrName = this.arrName;
        info.arrEffect = this.arrEffect;

        client.send('educationInfo', info);
    }

    onLeave(client, consented) {

    }

    async playersheetLoad() {     // db접근 
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
                    if(match === null) continue;

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

    async playerWearableLoadJson(id, ingitem) {
        return new Promise(async (resolve, reject) => {
            if (ingitem === '') {           // 현재 플레이어의 파츠가 없다 (새로운 플레이어)

                let sql = 'SELECT item_sno, item_img_ch, item_img_in_txt FROM cb_asset_item WHERE item_nm = "face_basic" order by item_sno desc';

                let info = {
                    name: '',
                    index: 0,
                    frontDepth: 0,
                    backDepth: 0
                };

                try {
                    let result = await Mysql.getInstance().query(sql);

                    for (let data of result) {

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
                    face: info
                };
                resolve(defaultinfo);
            } else {                        // 파츠가 있다.
                let wearableInfo = JSON.parse(ingitem);

                resolve(wearableInfo);
            }
        })
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

            let frames = this.makeEffectFrame(data,this.arrEffect[i].frame);

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
    makeEffectFrame(data,frame) {
        let effectframes = [];
        for(let i = 0; i < frame; ++i) {
            let effectInfo = {
                "key": data,
                "frame": i,
                "duration": 0
            };

            effectframes.push(effectInfo);
        }

        return effectframes;
    }

}

exports.GameEducationRoom = GameEducationRoom;
