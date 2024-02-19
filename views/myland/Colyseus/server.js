const express = require('express')
const http = require('http')
const https = require('https')
const path = require('path')

const bodyParser = require('body-parser')
const colyseus = require('colyseus')
const { monitor } = require('@colyseus/monitor')
const fs = require('fs')
const cors = require('cors')
const { WebSocketTransport } = require('@colyseus/ws-transport')

const { GameRoom } = require('./static/server/src/rooms/GameRoom')
const { ChatRoom } = require('./static/server/src/rooms/ChatRoom')
const { MapMakeRoom } = require('./static/server/src/rooms/MapMakeRoom.js')

const { Config } = require('./static/shared/config.js')
const { Mysql } = require('./static/server/src/database/mysql')
const { GameEducationRoom } = require('./static/server/src/rooms/GameEducationRoom.js')
const { RoomMessageManager } = require('./static/server/src/rooms/manager/RoomMessageManager.js')

const options = {
    key: fs.readFileSync(__dirname + "/static/server/src/config/_wildcard_.collaborland.kr_20231020EABD7.key.pem"),
    cert: fs.readFileSync(__dirname + "/static/server/src/config/_wildcard_.collaborland.kr_20231020EABD7.crt.pem")
};

// ===========================DataBase=========================== //


Mysql.getInstance().init();              // 나중엔 게임룸에서 각각 하나씩 만들어서 dispose때 end로 db닫기 풀링으로 해서 안닫아도 됨


// ===========================DataBase=========================== //


const port = process.env.port || Config.port;

const app = express();
app.use(express.json());
app.use(cors());

//var server = http.createServer(app)
const server = https.createServer(options, app)
const gameServer = new colyseus.Server({
    transport: new WebSocketTransport({
        server,
        pingInterval: 30000,
        pingMaxRetries: 4
    }),
    publicAddress: Config.DomainPort
});
// server.on('clientError', (err,socket) => {
//     console.log('clientError',err); 
// })

app.set('port', port);
app.use('/static', express.static(__dirname + '/static'));
//app.use('/myland', express.static(__dirname + '/../../myland'))

app.use('/font', express.static(__dirname + '/../../_layout/basic/css/font'));
app.use('/img', express.static(__dirname + '/static/client/css/img'));
app.use('/land', express.static(__dirname + '/../../land'));
app.use('/uploads', express.static(__dirname + '/../../../uploads'));
app.use('/assets', express.static(__dirname + '/../../../assets'));
app.use('/seum_img', express.static(__dirname + '/../../_layout/basic/seum_img'));
app.use('/rtc', express.static(__dirname + '/../rtc'));
app.use('/mobile', express.static(__dirname + '/../mobile'));
app.use('/preview', express.static(__dirname + '/../../_layout/bootstrap/seum_img/preview'));

app.use(bodyParser.text());
app.use(bodyParser.json({limit:'100mb'}));
app.use(bodyParser.urlencoded({
    limit: '100mb',
    extended: true
}));

// API
app.get('/nick', async (req, res) => { 
    let { userid } = req.query;
    //console.log(userid);
    let sql = 'SELECT mem_nickname FROM cb_member WHERE mem_id =' + +userid;

     try{
        let result = await Mysql.getInstance().query(sql);
        //console.log(result); 
        var info = {
            name:''
        };
        for (var data of result) {
            info.name = data.mem_nickname
        }
        
        res.send(JSON.stringify(info));
     } catch(err) {
        //res.send(`{'userid': 'null', 'error': '${err}'}`)        
    }
})

app.get('/empolyee_list', async (req, res) => { 
    let { companyIdx } = req.query;
    let sql = `SELECT mem_div, mem_nickname, mem_id FROM cb_member WHERE company_idx = ${companyIdx}`;

     try{
        let result = await Mysql.getInstance().query(sql);
        let sets = [];        

        for (const data of result) {
            let info = {};
            info.div = data.mem_div;
            info.nick = data.mem_nickname;
            info.id = data.mem_id
            sets.push(info);
        }
        
        res.send(JSON.stringify(sets));
     } catch(err) {
        
    }
})


app.get('/:id', function (req, res) {
    res.sendFile(path.join(__dirname, '/index.html'));
});

app.post('/info', (req, res) => {
    var user_info = req.body;
    console.log("current : ", user_info.currentUser,  ', other : ', user_info.otherUser);

    //==========info==============
    // user_info.currentUser 
    // user_info.otherUser 
    //==========info==============
    const roomName = `${user_info.room + '_' + user_info.companyIdx + '_' + user_info.otherUser}`;
    const chatName = `chatRoom_${user_info.room + '_' + user_info.companyIdx + '_' + user_info.otherUser}`;
    if (user_info.room === "gameeducation") {
        gameServer.define(roomName, GameEducationRoom);
    } else {     
        gameServer.define(roomName, GameRoom);        
    }

    gameServer.define(chatName, ChatRoom);
    gameServer.define(`MapMaker_${user_info.room + '_' + user_info.companyIdx + '_' + user_info.otherUser}`, MapMakeRoom);
});


app.post('/saveImage', async (req, res) => {
    const base64Image = req.body.image;

    const imagePath = path.join(__dirname + '../../_layout/bootstrap/seum_img/preview/', 'captureImage.png');
    const data = base64Image.replace(/^data:image\/\w+;base64,/, '');
    const buffer = Buffer.from(data, 'base64');

    fs.writeFile(imagePath, buffer, 'binary', err => {
        if (err) {
            console.log("err", err);
        }
    });
});

//gameServer.define('chat_room', ChatRoom)

app.use('/debug/colyseus', monitor())

gameServer.listen(port).then(() => {
    console.log('===========listening on ======', port);
});