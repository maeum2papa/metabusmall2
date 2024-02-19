const schema = require('@colyseus/schema');
const Schema = schema.Schema;

const colyseus = require('colyseus');
const axios = require('axios')

const { Player } = require('./schema/player');
const { GameRoomState } = require('./schema/GameRoomState');
const { Mysql } = require('../database/mysql');
const fs = require('fs')
const Utils = require('../utils/utils');



class Empty extends Schema {
    constructor() {
        super();
        this.x = 0;
        this.y = 0;
    }

}
schema.defineTypes(Empty, {
    x: "number",
    y: "number"
})

class State extends Schema {
    constructor() {
        super();
        this.empty = new schema.Schema;
    }
}
schema.defineTypes(State, {
    empty: Empty
})
exports.Empty = Empty;
exports.State = State;


exports.MapMakeRoom = class extends colyseus.Room {

    fixedTimeStep = 1000 / 20;

    arrMapName = [];
    arrMapInfo = {};
    arrMap = [];
    arrObject = [];


    async onCreate(options) {
        console.log("MapMakeRoom_Create")
        this.setPatchRate(this.fixedTimeStep);


        let sql = 'SELECT cate_value, cate_sno FROM cb_asset_category WHERE cate_type = "tl" OR cate_type = "tg"';

        try {
            let result = await Mysql.getInstance().query(sql);

            for (var data of result) {
                var info = {
                    cate_sno: '',
                    cate_value: '',
                };
                info.cate_sno = data.cate_sno;
                info.cate_value = data.cate_value;

                this.arrMapName.push(info);
            }
        } catch (err) {
            console.log("Error!!!!!", err);
            throw err;
        }


        for (let i = 0; i < this.arrMapName.length; ++i) {
            sql = `SELECT cate_sno, tp_nm, tp_data FROM cb_asset_template WHERE cate_sno = ${this.arrMapName[i].cate_sno} `;

            try {
                let result = await Mysql.getInstance().query(sql);

                for (var data of result) {
                    var info = {
                        tp_nm: '',
                        tp_data: '',
                        tile: {},
                        cate_sno: 0
                    };


                    info.tp_nm = data.tp_nm;
                    info.tp_data = JSON.parse(data.tp_data);
                    info.tile = await new Promise(resolve => fs.readFile(__dirname + '/../../../../../../../' + info.tp_data.tile.route, 'utf8', (err, data) => {
                        if (err) {
                            console.log("tileError", err);
                            return;
                        }
                        try {
                            resolve(data);

                        } catch (err) {
                            console.log("JSONERROR", err);
                        }
                    }));


                    info.cate_sno = data.cate_sno;
                    this.arrMapInfo[data.tp_nm] = info;
                }


                //console.log(this.arrMapInfo)
            } catch (err) {
                console.log("Error!!!!!", err);
                throw err;
            }
        }




        let mapRoute = '../../../assets/img/map';
        const mapClientRoute = 'assets/img/map';
        let mapFile = fs.readdirSync(mapRoute);

        for (let i = 0; i < mapFile.length; ++i) {
            let info = {
                name: '',
                route: ''
            }

            let startIndex = mapFile[i].indexOf('.');
            info.name = mapFile[i].substring(0, startIndex);
            info.route = mapClientRoute + '/' + mapFile[i];


            this.arrMap.push(info);
        }


        sql = 'SELECT item_nm, item_img_in FROM cb_asset_item WHERE item_type = "l"';

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
                        if (arrImg[i].txt === undefined || arrImg[i].txt === '' || arrImg[i].txt === null || arrImg[i].img === undefined || arrImg[i].img === '' || arrImg[i].img === null) continue;

                        info.name = arrImg[i].txt;
                        let index = arrImg[i].img.indexOf('/') + 1;
                        info.route = arrImg[i].img.substring(index, arrImg[i].img.length);

                        this.arrObject.push(info);
                    }
                } catch (err) {
                    continue;
                }

            }
        } catch (err) {
            console.log("Error!!!!!", err);
            throw err;
        }

        this.onMessage('FileSave', async (client, arrFile) => {
            let fileJson = JSON.stringify(arrFile.fileInfo);

            let sql = 'SELECT * FROM cb_asset_template WHERE cate_sno = ? AND tp_nm = ?';
            let dataParams = [arrFile.fileInfo.templeteIndex, arrFile.fileInfo.templeteName];

            try {
                let result = await Mysql.getInstance().insertUpdateQuery(sql, dataParams);

                var regDt = new Date();
                regDt = regDt.getFullYear() + '-' + (regDt.getMonth() + 1) + '-' + regDt.getDate() + ' ' + regDt.getHours() + ':' + regDt.getMinutes() + ':' + Math.floor(regDt.getSeconds());
                if (result.length > 0) {                // db에 이미 있다.   덮어쓰기 해야 함(Update)
                    sql = 'UPDATE cb_asset_template SET tp_nm =?, tp_data =?, tp_modDt =? WHERE cate_sno = ? AND tp_nm = ?';
                    let UpdatedataParams = [arrFile.fileInfo.templeteName, fileJson, regDt, arrFile.fileInfo.templeteIndex, arrFile.fileInfo.templeteName];

                    try {
                        let result = await Mysql.getInstance().insertUpdateQuery(sql, UpdatedataParams);
                    } catch (err) {
                        console.log("FileSave_UPDATE_Error!!!!!", err);
                        return;
                    }

                } else {                        // db에 없다. 새로운 템플릿이다. (Insert)
                    var tp_type = 'l';
                    if (arrFile.fileInfo.templeteIndex === 11) {
                        tp_type = 'g';
                    }

                    sql = 'INSERT INTO cb_asset_template (cate_sno, tp_nm, tp_type, tp_data, tp_regDt, tp_modDt) VALUES (?, ?, ?, ?, ?, ?)';
                    let InsertdataParams = [arrFile.fileInfo.templeteIndex, arrFile.fileInfo.templeteName, tp_type, fileJson, regDt, regDt];

                    try {
                        let InsertResult = await Mysql.getInstance().insertUpdateQuery(sql, InsertdataParams);
                    } catch (err) {
                        console.log("FileSave_InsertResult_Error!!!!!", err);
                        return;
                    }
                }

                fs.writeFile('../../../' + arrFile.fileInfo.tile.route, arrFile.tileJson, (err) => {
                    if (err) {
                        console.log("FileSave_TILEJSON_Error!!!!!!", err);
                    }
                });

            } catch (err) {
                console.log("FileSave_Error!!!!!", err);
                return;
            }
        })
    }

    async onJoin(client) {
        console.log("MapMakeRoom_Join")

        var arrInfo = this.arrMap;
        var arrtem = this.arrMapInfo;
        var Merge = {
            arrInfo: arrInfo,
            arrtem: arrtem
        };
        var arrObjInfo = this.arrObject;
        client.send('MapArr', Merge);
        client.send('ObjArr', arrObjInfo);
    }

    onLeave(client, consented) { }

    onDispose() { }
}


