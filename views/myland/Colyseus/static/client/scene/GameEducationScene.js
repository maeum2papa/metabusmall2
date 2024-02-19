class GameEducationScene extends Phaser.Scene {
    static KEY = 'gameeducationscene';

    constructor() {
        super(GameEducationScene.name);
        this.player;
        this.outlineInstance;
        this.isPopup = false;
        this.mp_sno = -1;
        this.width = 0;
        this.height = 0;
        this.time = 0;
        this.elapsedTime = 0;
        this.secondsTime = 0;
        this.waitTime = 3;
        this.fixedTimeStep = 1000 / 60;
        this.minDinstace = 9999;
        this.successCount = 0;
        this.questionLength = 0;
        this.curframeCount = 0;
        this.preframeCount = 0;
        this.colltile = null;
        this.currentOutlineObj = null;
        this.curTile = [];
        this.frameTile = null;
        this.bgSkys = [];
        this.frontEndEventObj = [];

        this.joyStick = null;
        this.joyDiv = null;
        this.joyStickCursor = {
            left: false,
            right: false,
            up: false,
            down: false,
            space: false,
            KeyF: false
        }

        this.spaceDiv = null;
        this.mobileFDiv = null;

        this.inputPayload = {
            left: false,
            right: false,
            up: false,
            down: false,
            space: false,
            KeyF: false,
            collisionX: 0,
            collisionY: 0,
            IsFocus: true
        };

        this.aStarArrow = {
            left: false,
            right: false,
            up: false,
            down: false
        }

        this.collisionXY = {
            x: 0,
            y: 0
        };
    }

    init() {
        this.client = new Colyseus.Client(Config.Domain);
        // Box.style.pointerEvents = 'none';
    }

    async create() {
        try {
            while (user_Info.otherUser === undefined) {
                await this.sleep(1000);
            }

            this.room = await this.client.joinOrCreate(`${user_Info.room + '_' + user_Info.companyIdx + '_' + user_Info.otherUser}`, { user_Info });
            SendManager.getInstance().setRoom(this.room, user_Info.currentUser);
            console.log("====Join====");

        } catch (e) {
            console.error(e);
        }
        while (!this.room) {
            await this.sleep(1000);
        }

        this.cursorKeys = this.input.keyboard.createCursorKeys();
        this.cursorKeys.KeyW = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.W, false);
        this.cursorKeys.KeyA = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.A, false);
        this.cursorKeys.KeyS = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.S, false);
        this.cursorKeys.KeyD = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.D, false);
        this.cursorKeys.KeyF = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.F, false);

        this.outlineInstance = this.plugins.get('rexoutlinepipelineplugin');

        if (user_Info.type === "mobile") {
            this.joyDiv = document.createElement('div');
            this.joyDiv.id = 'joyDiv';
          
            document.querySelector("#gamecontainer").appendChild(this.joyDiv);

            let left = 170;
            var options = {
                zone: this.joyDiv,
                color: "white",
                size: 100,
                threshold: 0.1,
                fadeTime: 250,
                position: { left: left + 'px', top: window.innerHeight - 100 + 'px' },
                mode: 'static',
                restOpacity: 0.5,
                plain: true
            };

            this.joyStick = nipplejs.create(options);

            //this.cameras.main.zoom = 0.7132778526552522;            // 모바일 줌 디폴트? 

            this.joyStick.on('move', (evt, data) => {
                this.joyStickCursor.up = Utils.isUp(left - data.position.x , (window.innerHeight - 100) - data.position.y);
                this.joyStickCursor.down = Utils.isDown(left - data.position.x, (window.innerHeight - 100) - data.position.y);
                this.joyStickCursor.left = Utils.isLeft(left - data.position.x, (window.innerHeight - 100) - data.position.y);
                this.joyStickCursor.right = Utils.isRight(left - data.position.x, (window.innerHeight - 100) - data.position.y);
            });

            this.joyStick.on('end', () => {
                this.joyStickCursor.left = false;
                this.joyStickCursor.right = false;
                this.joyStickCursor.up = false;
                this.joyStickCursor.down = false;
            })

            this.spaceDiv = document.createElement('div');
            this.spaceDiv.classList.add('mo_sphere_button');
            this.spaceDiv.id = 'mo_space_button';
            this.spaceDiv.style.left = window.innerWidth - 200 + 'px';
            this.spaceDiv.style.top = window.innerHeight - 75 + 'px';


            const spaceP = document.createElement('p');
            spaceP.innerText = 'Space';

            this.spaceDiv.appendChild(spaceP);

            document.querySelector("#gamecontainer").appendChild(this.spaceDiv);

            this.spaceDiv.addEventListener('touchstart', () => {
                this.spaceDiv.classList.add('clicked');
                this.joyStickCursor.space = true;
            });
            this.spaceDiv.addEventListener('touchend', () => {
                this.spaceDiv.classList.remove('clicked');
                this.joyStickCursor.space = false;
            });

            const spaceLeft = this.spaceDiv.style.left.substring(0, this.spaceDiv.style.left.length - 2);
            this.mobileFDiv = document.createElement('div');
            this.mobileFDiv.classList.add('mo_sphere_button');
            this.mobileFDiv.id = 'mo_keyf_button';
            this.mobileFDiv.style.left = +spaceLeft + 75 + 'px';
            this.mobileFDiv.style.top = window.innerHeight - 75 + 'px';

            const mobileFp = document.createElement('p');
            mobileFp.innerText = 'F';

            this.mobileFDiv.appendChild(mobileFp);

            document.querySelector("#gamecontainer").appendChild(this.mobileFDiv);

            this.mobileFDiv.addEventListener('touchstart', () => {
                this.mobileFDiv.classList.add('clicked');
            });
            this.mobileFDiv.addEventListener('touchend', () => {
                this.mobileFDiv.classList.remove('clicked');
            });

            this.mobileFDiv.addEventListener('click', () => {
                this.joyStickCursor.KeyF = true;
            });
        }

        this.input.keyboard.on('keydown-NINE', async () => {                       // 룸이동할건데 나중에 타일이나 충돌시 이동할 수 있는 오브젝트의 설정이나 값을 주고 충돌시 뭐 하면 될 것 같다.
            // var hr = '/land/office';
            // window.top.postMessage({ info: 'pageChange', href: hr }, '*');
            // this.scene.start(MapMakeScene.name);
            for (let i = 0; i < this.colltile.length; ++i) {
                if (this.colltile[i].alpha === 1) {
                    this.colltile[i].alpha = 0;
                } else {
                    this.colltile[i].alpha = 1;
                }
            }
        }, this)

        gameStartBtn.addEventListener('click', () => {          // 게임시작버튼
            gameStartPopup.style.display = "none";
            gameWaitpopup.style.display = "block";
            this.isPopup = true;
        })

        gameRestartBtn.addEventListener('click', () => {        // 게임 다시하기 버튼
            var hr = '';
            window.top.postMessage({ info: 'pageChange', href: hr }, '*');
        })

        gameQuitbtn.addEventListener('click', () => {           // 게임 나가기 버튼
            var hr = '';
            hr = '/classroom';

            window.top.postMessage({ info: 'pageChange', href: hr }, '*');
        })

        gameIngBtn.addEventListener('click', () => {
            gameIngBox.style.display = "none";
            this.isPopup = false;
        })

        gameCompleteBtn.addEventListener('click', () => {
            if(this.mp_sno === -1) return;

            var hr = '';
            hr = `/classroom/process_ps?mode=g&&mp_sno=${+this.mp_sno}&&mps_sno=${+user_Info.mps_sno}`;

            window.top.postMessage({ info: 'pageChange', href: hr }, '*');
        })

        this.room.onMessage('success', async (mp_sno) => {
            this.mp_sno = mp_sno;
        })

        


        this.room.onMessage('educationInfo', async (info) => {
            var data = JSON.parse(info.data);
            var question = info.question;
            var ingItem = info.ing_item;

            this.width = data.width;
            this.height = data.height;
            this.time = info.time;
            //this.time = 10;
            this.questionLength = question.length;

            await Assets.loadPlayersheet(this, info.arrName);                           //나중에 json경로도 서버에서 전달하는게 좋을듯? 에디터 나 시트 등록하면 만들어지게 해야겠네.
            await Assets.loadEffectsheet(this, info.arrEffect);                           //나중에 json경로도 서버에서 전달하는게 좋을듯? 에디터 나 시트 등록하면 만들어지게 해야겠네.

            this.load.animation('defaultPlayer', 'static/client/assets/Json/player_animation.json');
            this.load.animation('defaultEffect', 'static/client/assets/Json/effect_animation.json');

            await this.load.tilemapTiledJSON(data.tile.name, data.tile.route);
            await Assets.loadImage(this, data.background);
            await Assets.loadObjOrSheetImage(this, data.object);
            // await Assets.loadTypeImage(this, data.object);

            this.load.once('complete', async () => {
                this.map = this.make.tilemap({ key: data.tile.name });

                const tiles = await this.map.addTilesetImage(Assets.TILEX);
                this.layer = await this.map.createLayer('Tile Layer 1', tiles, 0, 0);

                var arrtile = [];
                for (let i = 0; i < this.map.layers[0].data.length; ++i) {
                    for (let j = 0; j < this.map.layers[0].data[i].length; ++j) {
                        this.map.layers[0].data[i][j].alpha = 0;
                        // if (this.map.layers[0].data[i][j].index !== 83) {
                        //     arrtile.push(this.map.layers[0].data[i][j]);
                        // }
                    }
                }

                // this.colltile = arrtile;
                this.colltile = this.map.filterTiles(tile => (tile.index !== 1 && tile.index !== 83 && tile.index !== 84 && tile.index !== 2));

                for (let i = 0; i < data.background.length; ++i) {
                    const background = new Background(this, data.background[i].name, data.background[i].depth);

                    if (-1 !== data.background[i].name.indexOf('Sky')) {
                        this.bgSkys.push(background);
                    }
                }

                for (var type in data.object) {
                    for (let i = 0; i < data.object[type].obj.length; ++i) {
                        const obj = new MapObject(this, type, data.object[type].obj[i], i + 1, question[i],this.callbackCountPlus);
                        // context, name, info, count, question,callback
                        obj.init(this.frontEndEventObj);
                    }
                }

                var playerArr = [];

                for (var type in ingItem) {
                    var infomation = {
                        type: type,
                        index: ingItem[type].index,
                        frontDepth: ingItem[type].frontDepth,
                        backDepth: ingItem[type].backDepth
                    }

                    playerArr.push(infomation);
                }

                this.player = new Player(this, +data.startX, +data.startY, 4, 0, info.nickname, +user_Info.currentUser, info.title, info.depart, playerArr);

                this.player.sprite.setCollideWorldBounds(true);

                this.cameras.main.setBounds(0, 0, this.width, this.height);              // 맵파일 사이즈만큼 해야 함. 서버에서 맵 정보를 받아와야 함.
                this.physics.world.setBounds(0, 0, this.width, this.height);
                this.cameras.main.startFollow(this.player.sprite, true, 0.05, 0.05);

                this.physics.add.overlap(this.player.sprite, this.frontEndEventObj, this.collect, null, this);

                const chatManager = ChatManager.getInstance();
                chatManager.init(info.nickname);
                chatManager.create();

                this.elementInit();

                gameBtnPopUp.style.display = "block";
                gameStartPopup.classList.add("game_popup_bg");
                gameStartPopup.style.display = "block";
                gameTopBox.style.display = "block";

                const gameStartP = gameStartPopup.querySelector(".game_popup_main .game_popup_main_cont p");
                gameStartP.innerText = info.method;

                const gameTopFixed = gameTopBox.querySelector(".game_top_fixed_box .game_top_fixed_test_num_box");

                gameTopFixed.querySelector("#game_top_test_num").innerText = `${this.successCount}`;                //성공한 퀴즈개수
                gameTopFixed.querySelector("#game_top_test_entire_num").innerText = `${question.length}`;       //전체 퀴즈개수

                gameTopBox.querySelector(".game_top_fixed_box .game_top_fixed_test_time_box #game_top_test_time").innerText = `${this.time}`;       //남은시간
            })

            this.load.start();

        })
    }


    update(time, delta) {
        if (!this.player) return;

        this.elapsedTime += delta;

        while (this.elapsedTime >= this.fixedTimeStep) {
            this.elapsedTime -= this.fixedTimeStep;
            this.fixedTick(time, this.fixedTimeStep);
        }
    }

    fixedTick(time, delta) {
        ++this.curframeCount;

        this.secondsTime += delta;

        const seconds = this.secondsTime / 1000;

        if (this.time === 0) {
            gameOverBox.classList.add('game_popup_bg');
            gameOverBox.style.display = "block";
            this.isPopup = true;
        }

        if (this.waitTime < 0 && 1 <= seconds && 0 < this.time && gameCompleteBox.style.display !== 'block') {
            this.time -= 1;
            this.secondsTime = 0;
            gameTopBox.querySelector(".game_top_fixed_box .game_top_fixed_test_time_box #game_top_test_time").innerText = `${this.time}`;
        }

        if (gameWaitpopup.style.display === 'block' && 1 <= seconds) {
            if (this.waitTime <= 0) {
                gameWaitpopup.style.display = 'none';
                this.isPopup = false;
            }
            gameWaitNumber.innerText = `${this.waitTime--}`;
            this.secondsTime = 0;
        }






        if (this.waitTime < 0 && !this.isPopup) {

            this.collisionXY.x = 0;
            this.collisionXY.y = 0;

            if (this.colltile !== null) {
                this.physics.world.overlapTiles(this.player.sprite, this.colltile, this.tileCollision, null, this);
            }

            this.inputPayload.left = this.cursorKeys.left.isDown || this.cursorKeys.KeyA.isDown || this.joyStickCursor.left;
            this.inputPayload.right = this.cursorKeys.right.isDown || this.cursorKeys.KeyD.isDown || this.joyStickCursor.right;
            this.inputPayload.up = this.cursorKeys.up.isDown || this.cursorKeys.KeyW.isDown || this.joyStickCursor.up;
            this.inputPayload.down = this.cursorKeys.down.isDown || this.cursorKeys.KeyS.isDown || this.joyStickCursor.down;
            this.inputPayload.space = this.cursorKeys.space.isDown || this.joyStickCursor.space;
            this.inputPayload.KeyF = this.cursorKeys.KeyF.isDown || this.joyStickCursor.KeyF;
            if(this.joyStickCursor.KeyF) {
                this.joyStickCursor.KeyF = false;
            }

        } else {
            this.inputPayloadReset();
        }
        if (this.player.IsJump) {
            this.inputPayload.space = false;
        }

        const speed = this.player.speed;
        this.oldPos = {
            x: this.player.sprite.x,
            y: this.player.sprite.y
        };

        let velocityX = 0;
        let velocityY = 0;
        if (this.inputPayload.left) {
            velocityX = -1;

        } else if (this.inputPayload.right) {
            velocityX += 1;
        }

        if (this.inputPayload.up) {
            velocityY -= 1;

        } else if (this.inputPayload.down) {
            velocityY += 1;
        }

        if (velocityX !== 0 && velocityY !== 0) {
            // const length = Math.sqrt(velocityX ** 2 + velocityY ** 2);              //  ** 승수 

            velocityX /= 1.4142135623730951;
            velocityY /= 1.4142135623730951;
        }

        this.player.sprite.x += velocityX * speed;
        this.player.sprite.y += velocityY * speed;

        this.player.updateAnimation(this.inputPayload);

        if (this.inputPayload.space && (this.player.z <= this.player.zFloor)) {
            this.player.IsJump = true;
        }

        this.player.Jump();

        this.inputPayload.collisionX = this.collisionXY.x;
        this.inputPayload.collisionY = this.collisionXY.y;

       this.player.uiUpdate(delta);

       if (!this.physics.overlap(this.player.sprite, this.frontEndEventObj)) {
        this.frontEndEventObj.forEach(collisionObj => {

            this.minDinstace = 9999;

            collisionObj.coll = false;
            collisionObj.setActive(true);
            collisionObj.setVisible(true);


            if (collisionObj.outline) {
                this.player.collisionObj = null;
                this.currentOutlineObj = null;
            }
            collisionObj.outlineRemove(this.outlineInstance);
        })
    }

        if ((this.oldPos.x !== this.player.sprite.x) || (this.oldPos.y !== this.player.sprite.y)) {
            this.player.isCollisionActive = false;

            if (this.player.IsSitOrLie) {
                this.player.setSitOrLie(false);
            }

            this.player.collObjCallback(this.player.direction);
            this.player.collObjCallback = () => { };
        }

        this.player.collision(this.inputPayload);

        this.player.sprite.depth = Phaser.Math.Linear(0, 10, Utils.GetSortingOrder(0, this.height, this.player.sprite.y));

        this.player.update(this);
    }

    async sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    collect(player, collisionObj) {

        if (this.player.isCollisionActive && collisionObj.outline) {
            collisionObj.outlineRemove(this.outlineInstance);
            // this.outlineInstance.remove(collisionObj);
            // collisionObj.outline = false;
            // 여기서 각 각 개체마다 할 설정을 해야 함. 플레이어가 오브젝트와 충돌 중이면서 상호작용키를 누른 상태
            this.player.collisionObj = null;
            if (collisionObj.name === 'field') {
                const vInfo = {
                    x: collisionObj.x + collisionObj.collOffsetX,
                    y: collisionObj.y + collisionObj.collOffsetY,
                    index: collisionObj.index,
                    id: this.player.id
                };
                this.room.send('fruits', vInfo);
            }
            else if (collisionObj.name === 'fruits') {
                const startIndex = this.FruitsObj[collisionObj.index].level.indexOf('_') + 1;
                const level = this.FruitsObj[collisionObj.index].level.substring(startIndex, this.FruitsObj[collisionObj.index].level.length);

                if (+level === 5) {
                    const vInfo = {
                        index: collisionObj.index,
                        id: this.player.id
                    };

                    this.room.send('harvesting', vInfo);
                } else {
                    waterFBoxBg.style.display = "block";

                    this.curFruits = collisionObj;
                }
            } else if (collisionObj.name === "well") {
                if ((+user_Info.otherUser === +user_Info.currentUser && (this.player.myWater === 'y')) || (+user_Info.otherUser !== +user_Info.currentUser && (this.player.anyWater === 'y'))) {      // 내 룸   남의룸             
                    collisionObj.ftOption();
                }
            }
            else {          //오버라이드
                collisionObj.ftOption();
            }

            return;
        }

        if (this.currentOutlineObj !== null) {
            let distance = Phaser.Math.Distance.Between(player.x, player.y, collisionObj.x, collisionObj.y);
            if (this.currentOutlineObj === collisionObj || this.minDinstace > distance) {
                this.minDinstace = distance;
                if (this.currentOutlineObj !== collisionObj) {
                    if (this.currentOutlineObj.outline) {
                        this.currentOutlineObj.outlineRemove(this.outlineInstance);
                    }

                    this.currentOutlineObj = collisionObj;
                }
            } else {
                return;
            }
        } else {
            this.minDinstace = Phaser.Math.Distance.Between(player.x, player.y, collisionObj.x, collisionObj.y);
            this.currentOutlineObj = collisionObj;
        }

        this.currentOutlineObj = collisionObj;
        if (!collisionObj.coll) {
            collisionObj.outlineAdd(this.outlineInstance);
            collisionObj.collAdd();

            this.player.collisionObj = collisionObj;
        }
        else if (!this.player.isCollisionActive && !collisionObj.outline) {
            this.player.collisionObj = collisionObj;
            collisionObj.outlineAdd(this.outlineInstance);
        }
    }


    tileCollision(player, tile) {

        let endlineCheck = false;
        if (this.curframeCount === this.preframeCount) {
            var option = tile.properties.option;
            this.curTile.push(option);

            if (this.frameTile !== null) {

                for (let i = 0; i < this.curTile.length; ++i) {
                    if (this.curTile[i] === "Endline") {
                        endlineCheck = true;
                        break;
                    }
                }
            }
        }

        if (this.curframeCount !== this.preframeCount) {
            for (let i = 0; i < this.curTile.length; ++i) {
                if (this.curTile[i] === "Endline") {
                    endlineCheck = true;
                    break;
                }
            }
            this.curTile.length = 0;
            if (!endlineCheck) {
                this.frameTile = null;
            }

            this.preframeCount = this.curframeCount;

            var option = tile.properties.option;
            this.curTile.push(option);
        }

        if (tile.properties.option === "Endline") {     //도착지점타일

            if (gameIngBox.style.display !== "block") {

                if (this.questionLength !== this.successCount && !endlineCheck) {     // 다 못깻다.
                    gameIngBox.classList.add('game_popup_bg');
                    gameIngBox.style.display = "block";
                    this.isPopup = true;
                    this.frameTile = tile;
                    return;
                }
                if (this.questionLength === this.successCount) {            // 다 깼다.
                    gameCompleteBox.classList.add("game_popup_bg");                    
                    gameCompleteBox.style.display = "block";
                    this.isPopup = true;

                    this.room.send('educationSuccess', user_Info.mps_sno);
                }
            }
        }
        else if (tile.properties.option === "Wall") {
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
            //=============================debug================================
            // const a = this.add.rectangle(tileX, tileY, tileWidth, tileHeight);
            // a.setStrokeStyle(1, 0xff000);
            //=============================debug================================


            const playerX = player.x;
            const playerY = (player.y + (player.height / 2)) - (tile.height / 2);
            const playerMin = {
                x: playerX - (tile.width / 2),
                y: playerY - (tile.height / 2)
            };
            const playerMax = {
                x: playerX + (tile.width / 2),
                y: playerY + (tile.height / 2)
            };

            let collision = {
                x: 0,
                y: 0
            };

            // 플레이어가 왼쪽 
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

            if (Math.abs(collision.x) < Math.abs(collision.y)) {
                player.x = player.x - collision.x;
                this.collisionXY.x = collision.x;
            } else if (Math.abs(collision.y) < Math.abs(collision.x)) {
                player.y = player.y - collision.y;
                this.collisionXY.y = collision.y;
            }
        }
    }

    elementInit() {
        loading.style.display = "none";

        Box.style.display = "block";

        chatBox.style.display = "none";
        landRtcWrap.style.display = "none";
        landRtcPopup.style.display = "none";
        profileCard.style.display = "none";
        statusPopup.style.display = "none";
        saveCharPopup.style.display = "none";
        saveLandPopup.style.display = "none";
        boxWrap.style.display = "none";
        waterFBoxBg.style.display = "none";
        land_bot_box_wrap.style.display = "none";
        land_top_box_wrap.style.display = "none";
        document.querySelector(".mylandTop_wrap").style.display = 'none';
        document.querySelector(".myland_chatbox").style.display = 'none';
    }

    inputPayloadReset() {
        this.inputPayload.left = false;
        this.inputPayload.right = false;
        this.inputPayload.up = false;
        this.inputPayload.down = false;
        this.inputPayload.space = false;
        this.inputPayload.KeyF = false;
    }

    callbackCountPlus = (count) => {
        this.successCount += count;

        gameTopBox.querySelector(".game_top_fixed_box .game_top_fixed_test_num_box #game_top_test_num").innerText = `${this.successCount}`;
        this.isPopup = false;
    }
}