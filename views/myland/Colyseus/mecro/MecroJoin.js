import * as Colyseus from 'colyseus.js';

(async () => {
    const clientCCU = 50;
    const isAiMove = false;
    const Domain = 'collaborland.kr:8000';
    let infoToSend = {
        currentUser: 0,
        otherUser: 'office',
        room: "land_office",
        type: "desktop",
        companyIdx: 5,
        mecro: true
    };
    let roomName = 'GameRoom';//`${infoToSend.room + '_' + infoToSend.companyIdx + '_' + infoToSend.otherUser}`;
    for (let i = 0; i < clientCCU; ++i) {
        let client = new Colyseus.Client("wws://collaborland.kr:8000");
   
        let room;                
        try {
            room = await client.joinOrCreate(roomName, {infoToSend });
            
            room.onLeave(async (code) => {
                room = null;
                while (room === null) {
                    room = await client.joinOrCreate(roomName, { infoToSend });
                }
            });
        } catch (e) {
            room = null;
            console.log('catch err',e);
            while (room === null) {
                
                room = await client.joinOrCreate(roomName, { infoToSend });
                console.log("chatWhile",room);
            }
        } finally {
            console.log(room);
            let count = 0;
            let first = true;

            room.state.players.onAdd(async (player, sessionId) => {

                player.onChange(() => {

                    if (first) {
                        first = false;
                        return;
                    }
                    let endtime = Date.now();

                    let info = {
                        date: new Date(),
                        endTime: JSON.stringify(endtime),
                        player: player,
                        count: count,
                        type: "game",
                        type2: 'receiver',
                        content: "move",
                    };

                    room.send('move', info);
                    ++count;
                });
            });
        }

        if (isAiMove) {
            let msPrev = performance.now();
            let msperFrame = 1000 / 60;

            let input = {
                left: false,
                right: false,
                up: false,
                down: false
            };

            setInterval(() => {
                const msNow = performance.now();
                const msPassed = msNow - msPrev;

                if (msPassed < msperFrame) return;

                const excessTime = msPassed % msperFrame;
                msPrev = msNow - excessTime;

                const delta = msPassed / 1000;

                input = aiMove(input);

                room.send(0, input);
            }, 1000 / 60);
        }
    }

    function aiMove(input) {
        let leftAndRight = 0;
        let upAndDown = 0;
        leftAndRight = Math.random();
        upAndDown = Math.random();

        if (leftAndRight < 0.35) {
            input.right = true;
            input.left = false;
        } else if (leftAndRight < 0.7) {
            input.right = false;
            input.left = true;
        } else {
            input.right = false;
            input.left = false;
        }

        if (upAndDown < 0.35) {
            input.up = true;
            input.down = false;
        } else if (upAndDown < 0.7) {
            input.up = false;
            input.down = true;
        } else {
            input.up = false;
            input.down = false;
        }
        return input;
    }

    async function wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function jsonToCSV(json) {
        const jsonArr = json;
        let csv_string = '';

        const titles = Object.keys(jsonArr[0]);

        titles.forEach((title, index) => {
            csv_string += (index !== titles.length - 1 ? `${title},` : `${title}\r\n`);
        });

        jsonArr.forEach((content, index) => {
            let row = '';

            for (let title in content) {
                row += (row === '' ? `${content[title]}` : `,${content[title]}`);
            }

            csv_string += (index !== jsonArr.length - 1 ? `${row}\r\n` : `${row}`);
        });

        return csv_string;
    }
})();




