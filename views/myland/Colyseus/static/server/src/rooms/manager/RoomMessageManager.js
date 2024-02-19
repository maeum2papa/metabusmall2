const {exec} = require('child_process');

class RoomMessageManager {
    static instance;
    room = {};
    restartTimeOut;

    constructor() { }


    static getInstance() {
        if (!RoomMessageManager.instance) {
            RoomMessageManager.instance = new RoomMessageManager();
        }

        return RoomMessageManager.instance;
    }

    setRoom(room, roomId) {
        if (!this.room[roomId]) {
            this.room[roomId] = room;
        }
    }


    removeRoom(roomId) {
        if (this.room[roomId]) {
            delete this.room[roomId];
        }
    }

    allMassage(text) {
        for (let roomId in this.room) {
            let info = {
                text: text,
                type: 'EveryOne'
            }
            this.room[roomId].commandMessage(info);
        }
    }

    serverReStart(count) {
        if (isNaN(+count)) return;
        if (this.restartTimeOut) {
            clearTimeout(this.restartTimeOut);
        }
        
        let num = +count;


        const updateSec = () => {
            num--;

            for (let roomId in this.room) {
                let info = {
                    text: `서버가 ${num}초 뒤에 재시작됩니다.`,
                    type: 'ServerReStart'
                }
                this.room[roomId].commandMessage(info);
            }

            if (0 < +num) {
                this.restartTimeOut = setTimeout(() => updateSec(), 1000);
            } else {
                this.reloadServer();
            }
        }

        updateSec();
    }

    reloadServer() {
        exec('pm2 reload server.js --force', (err,stdout,stderr) => {
            if(err) {
                setTimeout(() => {
                    this.reloadServer();
                }, 5000);
                //console.log(`Error pm2 reload : ${err}`);
                return;
            }
            console.log('reload success!');
        });
    }


}

exports.RoomMessageManager = RoomMessageManager;

