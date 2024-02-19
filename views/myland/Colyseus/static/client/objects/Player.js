class Player {
    static WALK_DOWN = 'Walk_Down';
    static WALK_LEFT = 'Walk_Left';
    static WALK_RIGHT = 'Walk_Right';
    static WALK_UP = 'Walk_Up';

    static IDLE_DOWN = 'Idle_Down';
    static IDLE_LEFT = 'Idle_Left';
    static IDLE_RIGHT = 'Idle_Right';
    static IDLE_UP = 'Idle_Up';

    static JUMP_DOWN = 'Jump_Down';
    static JUMP_LEFT = 'Jump_Left';
    static JUMP_RIGHT = 'Jump_Right';
    static JUMP_UP = 'Jump_Up';

    static SIT_DOWN = 'Sit_Down';
    static SIT_LEFT = 'Sit_Left';
    static SIT_RIGHT = 'Sit_Right';
    static SIT_UP = 'Sit_Up';

    static LIE_LEFT = 'Lie_Left';
    static LIE_RIGHT = 'Lie_Right';

    static DANCE_LEFT = 'Dance_Left';
    static DANCE_RIGHT = 'Dance_Right';

    constructor(context, x, y, speed, depth, name, id, title, depart, parts, mywater, anywater,badge) {                 // 아무것도 안입었다면 껍데기 아무것도 없는 투명 이미지를 씌워야 할듯. 아니면 나중에 플레이어가 현재 착용하고 있는 json을 가져올때 만들면 될 듯.
        this.sprite;
        this.speed;
        this.IsJump = false;
        this.IsDance = false;
        this.z = 0;
        this.zFloor = 0;
        this.zGravity = 0;
        this.zSpeed = 1;
        this.maxHeight = -1;
        this.accumulate = 0;

        this.id;
        this.name;
        this.nameLabelY;
        this.bubbleY = 56;
        this.nameBar;
        this.fKey;
        this.danceDir = '';

        this.speechBubble = null;
        this.speechcurrentTime = 0;
        this.speechMaxTime = 6000;
        this.speechElement = false;

        this.isCollisionActive = false;
        this.collisionObj = null;

        this.positionBuffer = [];
        this.direction = '';
        this.collObjCallback = () => { };
        this.IsSitOrLie = false;
        this.subDepth = 0;
        this.light = null;
        this.isFishing = false;
        this.fishingTime = 0;
        this.fishingMaxSeconds = 10;     //낚시시간

        this.myWater = mywater;
        this.anyWater = anywater;

        this.mapFishs = null;

        this.isKeyDelay = false;

        // ========================플레이어 파츠================================ 

        this.playerParts = [];

        // ========================플레이어 파츠================================ 

        for (let i = 0; i < parts.length; ++i) {   //type,name
            if (parts[i].type === "body") {
                this.sprite = context.physics.add.sprite(x, y, parts[i].index).setOrigin(0.5, 0.5);
                this.sprite.name = parts[i].index;
                this.sprite.type = parts[i].type;
                this.sprite.nickname = name;
                this.sprite.prePos = {
                    x: x,
                    y: y
                };

                this.sprite.setInteractive({ pixelPerfect: true });
            } else {
                var part = context.add.sprite(x, y, parts[i].index).setOrigin(0.5, 0.5);
                part.name = parts[i].index;
                part.type = parts[i].type;
                part.frontDepth = parts[i].frontDepth;
                part.backDepth = parts[i].backDepth;

                this.playerParts.push(part);
            }
        }

        this.sprite.anims.play(this.sprite.name + '_' + Player.IDLE_DOWN);

        this.id = id;
        this.name = name;
        this.speed = speed;
        this.sprite.depth = depth;

        let Title = title;
        let Depart = depart;
        let playerbadge = badge;
        if (Title === undefined || Title === null || Title === '') {
            Title = '';
        }

        if (Depart === undefined || Depart === null || Depart === '') {
            Depart = '';
        }
        
        if (playerbadge === undefined || playerbadge === null || playerbadge === '') {
            playerbadge = '';
        }

        if (this.name === undefined) {
            this.name = '손님';
        }

        this.createNameBar(context, Depart, Title,playerbadge);
        this.createFKey(context);

        this.light = context.lights.addLight(0, 0, 100).setIntensity(1);
    }

    init(subdepth, sitorlie) {
        this.subDepth = subdepth;
        this.IsSitOrLie = sitorlie;
    }
    updateAnimation(input, AstarArrow) {
        let inputPayload = {
            left: false,
            right: false,
            up: false,
            down: false,
            space: false,
            KeyF: false,
            KeyZ: false,
        };
        if (AstarArrow) {
            inputPayload.left = AstarArrow.left ? AstarArrow.left : input.left;
            inputPayload.right = AstarArrow.right ? AstarArrow.right : input.right;
            inputPayload.up = AstarArrow.up ? AstarArrow.up : input.up;
            inputPayload.down = AstarArrow.down ? AstarArrow.down : input.down;
            inputPayload.space = input.space;
            inputPayload.KeyF = input.KeyF;
            inputPayload.KeyZ = input.KeyZ;
        } else {
            inputPayload.left = input.left;
            inputPayload.right = input.right;
            inputPayload.up = input.up;
            inputPayload.down = input.down;
            inputPayload.space = input.space;
            inputPayload.KeyF = input.KeyF;
            inputPayload.KeyZ = input.KeyZ;
        }

        if (inputPayload.KeyZ) {
            if (!inputPayload.left && !inputPayload.right && !inputPayload.up && !inputPayload.down && !inputPayload.space && !this.IsJump) {
                let namelength = this.sprite.anims.getName().length;
                let startindex = this.sprite.anims.getName().lastIndexOf('_') + 1;
                let dir = this.sprite.anims.getName().substring(startindex, namelength);

                if (dir === 'Up' || dir === 'Down') {
                    dir = 'Left';
                }

                this.danceDir = dir;
                if (dir === 'Right') {
                    this.sprite.setScale(-1, 1);
                }

                this.sprite.anims.play(this.sprite.name + '_' + 'Dance' + '_' + dir, true);
                this.IsDance = true;

            }
        }

        if (this.IsJump) {
            if (inputPayload.up) {
                this.sprite.anims.play(this.sprite.name + '_' + Player.JUMP_UP, true);
            }
            else if (inputPayload.down) {
                this.sprite.anims.play(this.sprite.name + '_' + Player.JUMP_DOWN, true);
            }

            if (inputPayload.left) {
                this.sprite.anims.play(this.sprite.name + '_' + Player.JUMP_LEFT, true);
            }
            else if (inputPayload.right) {
                this.sprite.anims.play(this.sprite.name + '_' + Player.JUMP_RIGHT, true);
            }

            if (!inputPayload.up && !inputPayload.down && !inputPayload.left && !inputPayload.right && !inputPayload.space) {
                if (this.sprite.anims.getName().length !== 0) {
                    let namelength = this.sprite.anims.getName().length;
                    let startindex = this.sprite.anims.getName().lastIndexOf('_') + 1;
                    this.sprite.anims.play(this.sprite.name + '_' + 'Jump' + '_' + this.sprite.anims.getName().substring(startindex, namelength));
                }
                else {
                    this.sprite.anims.play(this.sprite.name + '_' + Player.JUMP_DOWN);
                }
            }
        } else {
            if (inputPayload.left) {
                if (!this.IsJump && !inputPayload.space) {
                    this.sprite.anims.play(this.sprite.name + '_' + Player.WALK_LEFT, true);
                }
            } else if (inputPayload.right) {
                if (!this.IsJump && !inputPayload.space) {
                    this.sprite.anims.play(this.sprite.name + '_' + Player.WALK_RIGHT, true);
                }
            }
    
            if (inputPayload.up) {
                if (!inputPayload.left && !inputPayload.right && !this.IsJump && !inputPayload.space) {
                    this.sprite.anims.play(this.sprite.name + '_' + Player.WALK_UP, true);
                }
            } else if (inputPayload.down) {
                if (!inputPayload.left && !inputPayload.right && !this.IsJump && !inputPayload.space) {
                    this.sprite.anims.play(this.sprite.name + '_' + Player.WALK_DOWN, true);
                }
            }
    
        }

        if (this.sprite.anims.getName().length !== 0) {
            let startindex = this.sprite.anims.getName().indexOf('_') + 1;
            let lastindex = this.sprite.anims.getName().lastIndexOf('_');
            let state = this.sprite.anims.getName().substring(startindex, lastindex);

            if (state !== 'Idle' && state !== 'Sit' && state !== 'Lie' && !inputPayload.up && !inputPayload.down && !inputPayload.left && !inputPayload.right && !inputPayload.space && !this.IsJump && !this.IsDance) {

                let namelength = this.sprite.anims.getName().length;
                let startindex = this.sprite.anims.getName().lastIndexOf('_') + 1;
                let currentstate = 'Idle' + '_' + this.sprite.anims.getName().substring(startindex, namelength);

                this.sprite.anims.play(this.sprite.name + '_' + currentstate);
            }
        }
    }

    Jump() {
        if (this.IsJump) {
            this.z += this.zSpeed;
        }

        if (!this.z <= this.zFloor) {
            this.z -= this.zGravity;
            this.zGravity += 0.1;
        }

        if (this.z <= this.zFloor) {
            this.jumpReset();
        }

        if (this.IsJump && (this.maxHeight < this.z)) {
            this.maxHeight = this.z;         // 아직 상승중
            this.sprite.y = this.sprite.y - this.z;
            this.accumulate += this.z;
        }
        else if (this.IsJump) {                              // 하강 
            this.sprite.y = this.sprite.y + this.z;
            this.accumulate -= this.z;
        }
    }

    updateSpeechBubbleBox(dt, scrollX, scrollY) {
        if (this.speechElement) {

            this.speechcurrentTime += dt;

            // this.speechBubble.style.left = this.sprite.prePos.x - scrollX + "px";
            // this.speechBubble.style.top = this.sprite.prePos.y - this.bubbleY - scrollY + "px";

            this.speechBubble.x = this.sprite.x;
            this.speechBubble.y = this.sprite.y - this.bubbleY;

            if (this.speechcurrentTime >= this.speechMaxTime) {
                this.speechBubble.destroy();
                this.speechcurrentTime = 0;
                this.speechElement = false;
            }
        }
    }

    createSpeechBubbleBox(context, wrapWidth, message) {
        if (this.speechElement) {
            this.speechBubble.destroy();
            this.speechcurrentTime = 0;
            this.speechElement = false;
        }

        let speechBubble = document.createElement('div');
        speechBubble.classList.add("speech");
        let span = document.createElement('span');
        span.classList.add("speech_text");

        span.innerText = message;

        speechBubble.appendChild(span);

        Box.appendChild(speechBubble);
        this.speechElement = true;

        this.speechBubble = context.add.dom(100, 100, speechBubble);
        this.speechBubble.setOrigin(0.5, 1);

        this.speechBubble.setDepth(101);

        //this.speechBubble.offWidth = +window.getComputedStyle(document.querySelector(`#${trNameId}`)).width.substring(0,window.getComputedStyle(document.querySelector(`#${trNameId}`)).width.length - 2);
    }

    collision(inputPayload) {
        if (this.collisionObj !== null) {
            if (this.collisionObj.coll && !this.isCollisionActive && inputPayload.KeyF) {
                this.isCollisionActive = true;
            } else if (!this.collisionObj.coll) {
                this.isCollisionActive = false;
            }
            // fKeyP.innerText = '를 눌러 상호작용';
            // fKeyUI.style.display = 'flex';
            this.fKey.setVisible(true);

        } else {
            this.isCollisionActive = false;
            //fKeyUI.style.display = 'none';
            this.fKey.setVisible(false);
        }
    }

    update(context) {
        const lastIndex = this.sprite.anims.getName().lastIndexOf('_');
        const fixStr = this.sprite.anims.getName().substring(0, lastIndex);
        const startIndex = fixStr.lastIndexOf('_') + 1;
        const curAnimstr = this.sprite.anims.getName().substring(startIndex, this.sprite.anims.getName().length);

        let namelength = this.sprite.anims.getName().length;
        let startindex = this.sprite.anims.getName().lastIndexOf('_') + 1;
        let currentstate = this.sprite.anims.getName().substring(startindex, namelength);
        let isfront = true;
        if (currentstate === 'Up') {
            isfront = false;
        }

        for (let i = 0; i < this.playerParts.length; ++i) {
            this.playerParts[i].setScale(this.sprite.scaleX, this.sprite.scaleY);

            this.playerParts[i].x = this.sprite.x;
            this.playerParts[i].y = this.sprite.y;

            if (this.playerParts[i].anims !== undefined) {
                if (this.playerParts[i].type.indexOf('effect') !== -1) {
                    this.playerParts[i].anims.play(this.playerParts[i].name + '_' + 'play', true);
                } else {
                    this.playerParts[i].anims.play(this.playerParts[i].name + '_' + curAnimstr, true);
                }
            }

            if (this.sprite.anims.currentFrame !== null && this.playerParts[i].anims.currentFrame !== null && this.playerParts[i].anims.currentFrame.index !== this.sprite.anims.currentFrame.index &&
                this.playerParts[i].type.indexOf('effect') === -1) {
                this.playerParts[i].setFrame(this.sprite.anims.currentFrame.textureFrame);
                // this.playerParts[i].anims.play({key:this.playerParts[i].name + '_' + curAnimstr, startFrame: +this.sprite.anims.currentFrame.index}, true);
            }
            if (isfront) {
                this.playerParts[i].depth = this.sprite.depth + (this.playerParts[i].frontDepth * 0.0001);
            } else {
                this.playerParts[i].depth = this.sprite.depth + (this.playerParts[i].backDepth * 0.0001);
            }
        }
    }

    addPart(context, parts) {
        for (let i = 0; i < this.playerParts.length; ++i) {
            if ("body" === this.playerParts[i].type) {
                continue;
            }

            let isCheck = false;
            for (var type in parts) {
                if (type === this.playerParts[i].type) {  // 새로운 파츠 타입과 현재 있는 파츠의 타입 같은게 있다.
                    this.playerParts[i].name = parts[type].index;
                    this.playerParts[i].setTexture(parts[type].index);
                    isCheck = true;
                    break;
                }
            }

            if (!isCheck) {           // 새로운 파츠 타입엔 없는데 현재 있는 파츠 타입엔 있다.
                this.playerParts[i].destroy();
                this.playerParts.splice(i, 1);
                --i;
            }
        }

        for (var type in parts) {
            if ("body" === type) {
                continue;
            }
            const typeExists = this.playerParts.some(part => part.type === type);
            if (!typeExists) {       // 현재 파츠엔 없는데 새 파츠엔 있다
                var part = context.add.sprite(this.sprite.x, this.sprite.y, parts[type].index).setOrigin(0.5, 0.5);
                part.name = parts[type].index;
                part.type = type;

                this.playerParts.push(part);
            }
        }
    }

    async addParts(context, parts) {
        for (let i = 0; i < this.playerParts.length; ++i) {
            if ("body" === this.playerParts[i].type) {
                continue;
            }

            const partInfo = parts.find(part => part.type === this.playerParts[i].type);

            if (!partInfo || partInfo === undefined) {      // 새로운 파츠 타입엔 없는데 현재 있는 파츠 타입엔 있다.
                this.playerParts[i].destroy();
                this.playerParts.splice(i, 1);
                --i;
            } else {                                        // 새로운 파츠 타입과 현재 있는 파츠의 타입 같은게 있다.
                if (partInfo.index !== this.playerParts[i].name) {
                    this.playerParts[i].name = partInfo.index;
                    this.playerParts[i].setTexture(partInfo.index);
                }
            }
        }

        for (let i = 0; i < parts.length; ++i) {
            if ("body" === parts[i].type) {
                continue;
            }

            const typeExists = this.playerParts.some(part => part.type === parts[i].type);

            if (!typeExists) {       // 현재 파츠엔 없는데 새 파츠엔 있다
                var part = context.add.sprite(this.sprite.x, this.sprite.y, parts[i].index).setOrigin(0.5, 0.5);
                part.name = parts[i].index;
                part.type = parts[i].type;

                this.playerParts.push(part);
            }
        }
    }

    async checkRemoveParts(context, parts) {
        for (let i = 0; i < this.playerParts.length; ++i) {
            if ("body" === this.playerParts[i].type) {
                continue;
            }

            const partInfo = parts.find(part => part.type === this.playerParts[i].type);

            if (!partInfo || partInfo === undefined) {      // 새로운 파츠 타입엔 없는데 현재 있는 파츠 타입엔 있다.
                this.playerParts[i].destroy();
                this.playerParts.splice(i, 1);
                --i;
            }
        }
    }



    async addPlayerPart(context, part) {
        if ("body" === part.type) {
            return;
        }
        const index = this.playerParts.findIndex(parts => parts.type === part.type);

        if (index !== -1) {                        // 같은 타입의 파츠가 있다.
            this.playerParts[index].name = part.index;
            this.playerParts[index].setTexture(part.index);
            this.playerParts[index].frontDepth = part.frontDepth;
            this.playerParts[index].backDepth = part.backDepth;
        } else {                               // 현재 파츠에 없는 새로운 파츠
            var newPart = context.add.sprite(this.sprite.x, this.sprite.y, part.index).setOrigin(0.5, 0.5);
            newPart.name = part.index;
            newPart.type = part.type;
            newPart.frontDepth = part.frontDepth;
            newPart.backDepth = part.backDepth;

            this.playerParts.push(newPart);
        }
    }

    createNameBar(context, depart, title,badge) {
        let iconrouter = '';
        let nametd = '';
        if (this.icon || badge !== '') {
            this.icon = 'static/client/assets/Images/donot.png';
            iconrouter = `<img src="${this.icon}" class="nickname_icon" align="center" valign="center">`;
            //  icontd += `<td align="center" valign="center"><img src="static/client/assets/Images/donot.png" class="nickname_icon"></td>\n`;
        }
        // if (this.name) {
        //     nametd += `<td id="${this.name + "font"}" colspan="2" align="center" valign="center">${this.name}</td>\n`;
        // }
        // if (this.action) {
        //     nametd += `<td>${this.action}</td>\n`;
        // }

        let trBadgeId = this.name + 'Badge';
        let trTitleId = this.name + 'Title';
        let trNameId = this.name + 'Nick';

        const nameBar = document.createElement('div');
        const badgeBar = document.createElement('div');
        const titleBar = document.createElement('div');
        const nickBar = document.createElement('div');
        nameBar.className = 'nickname';
        badgeBar.id = trBadgeId;
        titleBar.id = trTitleId;
        nickBar.id = trNameId;

        badgeBar.innerHTML = `
        ${iconrouter}
        ${badge}
        `;

        titleBar.innerText = depart + ' ' + title;
        nickBar.innerText = this.name;

        nameBar.appendChild(badgeBar);
        nameBar.appendChild(titleBar);
        nameBar.appendChild(nickBar);              
        username.appendChild(nameBar);

        document.getElementById(trBadgeId).style.color = "#b464eb";
        document.getElementById(trTitleId).style.color = "#86D7FF";
        document.getElementById(trNameId).style.color = "#43d637";

        this.nameBar = context.add.dom(100, 100, nameBar);
        this.nameBar.setOrigin(0, 0);
        
        this.nameBar.setDepth(100);
        this.nameBar.dom = nameBar; 
        
        // this.nameLabelY = (this.sprite.height) - table.height;
        this.nameLabelY = (this.sprite.height / 2) - 7;
        // 42;       //폰트사이즈의 x3 하면 딱맞는데.. 뭐지 
    }

    setPos(pos) {
        this.sprite.x = pos.x;
        this.sprite.y = pos.y;

        var curPos = {
            x: this.sprite.x,
            y: this.sprite.y
        };

        this.jumpReset();

        SendManager.getInstance().send('setPos', curPos);
    }

    setState(state) {
        this.sprite.anims.play(this.sprite.name + '_' + state);
        let curState = state;

        SendManager.getInstance().send('setState', curState);
    }

    setDirection(dir) {
        this.direction = dir;
    }

    setCollObj(callback) {
        this.collObjCallback = callback;
    }

    setSitOrLie(state) {
        this.IsSitOrLie = state;
        let sol = state;

        SendManager.getInstance().send('setSitOrLie', sol);

        this.isKeyDelay = true;
        setTimeout(() => {
            this.isKeyDelay = false;
        }, 100);
    }

    setSubDepth(depth) {
        this.subDepth = depth;
        let sd = depth;
        SendManager.getInstance().send('setSubDepth', sd);
    }

    setFish(arr) {
        this.mapFishs = new Map();

        for (let i = 0; i < arr.length; ++i) {
            this.mapFishs.set(arr[i].index, new Fish(arr[i].index, arr[i].count));
        }
    }

    destroy(context) {
        for (let i = 0; i < this.playerParts.length; ++i) {
            this.playerParts[i].destroy();
        }

        context.lights.removeLight(this.light);

        if (this.speechElement) {
            this.speechBubble.destroy();
            this.speechcurrentTime = 0;
        }

        this.nameBar.destroy();
    }

    jumpReset() {
        this.z = this.zFloor;
        this.zGravity = 0;
        this.IsJump = false;
        this.maxHeight = -1;
        this.accumulate = 0;
    }

    preSavePos() {
        this.sprite.prePos.x = this.sprite.x;
        this.sprite.prePos.y = this.sprite.y;
    }

    uiUpdate(dt) {
        this.nameBar.x = this.sprite.x - (+this.nameBar.dom.getBoundingClientRect().width / 2);
        this.nameBar.y = this.sprite.y - (+this.nameBar.height) - this.nameLabelY;

        this.fKey.x = this.sprite.x;
        this.fKey.y = this.sprite.y + 12 + (this.sprite.height / 2);


        if (this.speechElement) {
            this.speechcurrentTime += dt;

            this.speechBubble.x = this.sprite.x;
            this.speechBubble.y = this.sprite.y - this.bubbleY;

            if (this.speechcurrentTime >= this.speechMaxTime) {
                this.speechBubble.destroy();
                this.speechcurrentTime = 0;
                this.speechElement = false;
            }
        }
    }

    createFKey(context) {
        this.fKey = context.add.dom(100, 100, document.querySelector("#fkeyui"));
        this.fKey.setOrigin(0.5, 0.5);
        this.fKey.setDepth(100);

        this.fKey.setVisible(false);
    }
}

