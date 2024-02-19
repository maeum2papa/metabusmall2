class MapMakeScene extends Phaser.Scene {
    static KEY = 'mapmakescene';
    client;
    room;

    gui;
    objGui;
    videoGui;

    sheetGui;
    cursorKeys;
    curObjRect = null;
    choiceObjRect = null;
    stack = 0;
    sheetStack = 0;
    preAddObject = '';
    curMap = null;
    curObjName = {
        name: ''
    };
    curVideoName = {
        name: ''
    };

    curCollisionName = {
        name: ''
    };

    curCollsionOffset = {
        x: '0',
        y: '0'
    };

    sheetObjArr = {};

    sheetCheck = {
        sheet: false
    };

    sheetYoyo = {
        yoyo: false
    };

    sheetFrameCount = {
        count: ''
    };

    sheetFrame = {
        frame: ''
    };

    sheetCollisionBefore = {
        collision: ''
    };

    sheetCollisionAfter = {
        collision: ''
    };

    teleportController = null;
    popUpContrller = null;

    pointerFolder
    ObjectFolder
    videoFolder

    maps
    pointer = {
        x: 0,
        y: 0,
        zoom: ''
    };

    objPos = {
        x: '',
        y: ''
    };

    objOffsetPos = {
        x: '',
        y: ''
    };

    objdepth = {
        name: ''
    };

    objOption = {
        wall: false,
        overlap: false
    };

    objSheetSize = {
        width: '',
        height: '',
    };

    videoSize = {
        width: '100',
        height: '100'
    };

    objType = {
        obj: 'obj',
        video: 'video'
    };

    mapFolder;
    tileFolder;

    map = null;
    markerSize = 1;
    marker;
    layer;
    tileJson = {
        height: 32,
        layers: [
            {
                data: [],
                height: 32,
                name: "Tile Layer 1",
                opacity: 1,
                type: "tilelayer",
                visible: true,
                width: 32,
                x: 0,
                y: 0
            }],

        orientation: "orthogonal",
        properties:
        {

        },
        tileheight: 32,
        tilesets: [
            {
                firstgid: 0,
                image: "../Images/gridtiles1.png",
                imageheight: 320,
                imagewidth: 448,
                margin: 0,
                name: "tiles",                      // << 이거 각 템플릿 이름으로 바꿔야 함.
                properties:
                {

                },
                spacing: 0,
                tileheight: 32,
                tileproperties:
                {
                    3: {
                        option: "Wall"
                    },
                    4: {
                        option: "Endline"
                    }
                },
                tilewidth: 32
            }],
        tilewidth: 32,
        version: 1,
        width: 32
    };


    inputPayload = {
        left: false,
        right: false,
        up: false,
        down: false,
        space: false,
        KeyF: false,
        ctrl: false,
        collisionX: 0,
        collisionY: 0,
        IsFocus: true
    };

    defaultTile = {};
    tileState = {
        drag: false,
        eraser: false,
        wall: false,
        start: false,
        endline: false,
        private: false,
        wallprivate: false
    }

    startTileInfo = {
        index: 0,
        tileX: 0,
        tileY: 0
    }

    startPos = {
        x: 0,
        y: 0
    }

    isTileAlpha = {
        alpha: false
    }

    isDepthAuto = {
        auto: true
    };

    backgroundState = {
        overlap: false
    }
    cateState = {
        state: {
            inner: false,
            outer: false,
            office: false,
            education: false,
            gameEducation: false
        },
        inner: 1,
        outer: 6,
        office: 9,
        education: 10,
        gameEducation: 11
    };

    curCateState = {
        state: '',
        index: 0
    };

    collState = {
        state: {
            Default: false,
            Sit_Down: false,
            Sit_Left: false,
            Sit_Right: false,
            Sit_Up: false,
            Lie_Left: false,
            Lie_Right: false
        },
        Sit_Down: Player.SIT_DOWN,
        Sit_Left: Player.SIT_LEFT,
        Sit_Right: Player.SIT_RIGHT,
        Sit_Up: Player.SIT_UP,
        Lie_Left: Player.LIE_LEFT,
        Lie_Right: Player.LIE_RIGHT
    };

    property = {
        type: {
            default: false,
            fishing: false,
            well: false,
            field: false,
            secretary: false
        },
        fishing: "fishing",
        well: "well",
        field: "field",
        secretary: "secretary"
    };

    isFishing = {
        fishing: false
    };

    objState = {
        default: false,
        drag: false,
        choice: false
    };

    videoState = {
        default: false,
        drag: false,
        choice: false
    }

    grid;
    isClick = false;

    privateData = {};


    curMapController;
    curMapDepthController;
    curObjectController;
    curSheetController;
    curSheetObjController;
    curVideoController;

    sizeDiv;
    curButtonEle;

    pathfinderArrow;
    pathTween;
    constructor() {
        super(MapMakeScene.name);
    }

    init() {
        this.client = new Colyseus.Client(Config.Domain);
        Box.style.pointerEvents = 'none';
    }

    async create() {
        try {
            while (user_Info.otherUser === undefined) {
                await this.sleep(1000);
            }

            this.room = await this.client.joinOrCreate(`MapMaker_${user_Info.room + '_' + user_Info.companyIdx + '_' + user_Info.otherUser}`);
            SendManager.getInstance().setRoom(this.room, user_Info.currentUser);
            console.log("====Join====");

        } catch (e) {
            console.error(e);
        }
        while (!this.room) {
            await this.sleep(1000);
        }

        this.canvas = document.querySelector("#gamecontainer canvas");

        this.canvas.addEventListener('click', async (e) => {
            this.canvas.focus();

            let dg = document.querySelector(".dg.ac");
            
            let childInputs = dg.querySelectorAll("input");

            for(let i = 0; i < childInputs.length; ++i) {
                childInputs[i].blur();
            }
        });

        const chatManager = ChatManager.getInstance();
        chatManager.init();
        chatManager.create();


        this.makeMarkerSizeDiv();

        // this.input.keyboard.on('keydown-ONE', async () => {
        //     this.makeEmoji();
        // }, this);

        this.pathfinderArrow = this.add.image(0, 0, Assets.PATHFINDERARROW).setOrigin(0.5, 0.5);
        this.pathfinderArrow.setAlpha(0);
        this.pathfinderArrow.setDepth(1000);

        let originX;
        let originY;
        let originLeft;
        let originTop;
        let sizeDivDrag = false;

        const sizeDivWidth = this.sizeDiv.style.width.substring(0, this.sizeDiv.style.width.length - 2);
        const sizeDivHeight = this.sizeDiv.style.height.substring(0, this.sizeDiv.style.height.length - 2);

        this.sizeDiv.addEventListener('mouseover', () => {
            this.isClick = true;
        });

        this.sizeDiv.addEventListener('mouseout', () => {
            if (sizeDivDrag) return;

            this.isClick = false;
        });

        this.sizeDiv.addEventListener('mousedown', (e) => {
            sizeDivDrag = true;
            originX = e.clientX;
            originY = e.clientY;
            originLeft = this.sizeDiv.offsetLeft;
            originTop = this.sizeDiv.offsetTop;
        });

        document.addEventListener('mouseup', (e) => {
            sizeDivDrag = false;
        });
        document.addEventListener('mousemove', (e) => {
            if (sizeDivDrag) {
                const diffX = e.clientX - originX;
                const diffY = e.clientY - originY;

                const OutXPos = window.innerWidth - (+sizeDivWidth / 2);
                const OutYPos = window.innerHeight - (+sizeDivHeight / 2);

                this.sizeDiv.style.left = `${Math.min(Math.max(+sizeDivWidth / 2, originLeft + diffX), OutXPos)}px`;
                this.sizeDiv.style.top = `${Math.min(Math.max((+sizeDivHeight / 2), originTop + diffY), OutYPos)}px`;
            }
        });

        const buttons = this.sizeDiv.querySelectorAll('button');

        for (let i = 0; i < buttons.length; ++i) {
            buttons[i].addEventListener('click', () => {
                if (this.curButtonEle === buttons[i]) return;

                this.curButtonEle.title = '';
                const p = this.curButtonEle.querySelector('p');

                p.style.color = 'rgba(100,100,100,1)';

                this.curButtonEle = buttons[i];
                this.curButtonEle.style.backgroundColor = 'rgba(255,128,64,1)';
                this.curButtonEle.title = 'select';
                const newP = this.curButtonEle.querySelector('p');

                newP.style.color = 'rgba(255,255,255,1)';

                const size = newP.innerText.substring(0, newP.innerText.length - 1);

                this.markerSize = +size;

                if (this.marker) {
                    this.marker.clear();
                    this.marker.lineStyle(3, 0x000000, 1);
                    this.marker.strokeRect(0, 0, this.markerSize * this.map.tileWidth, this.markerSize * this.map.tileHeight);
                }
            });


            buttons[i].addEventListener('mouseover', () => {
                if (buttons[i].title === 'select') {
                    buttons[i].style.backgroundColor = 'rgba(255,128,64,1)';
                } else {
                    buttons[i].style.backgroundColor = 'rgba(255,255,255,1)';
                }

            });
            buttons[i].addEventListener('mouseout', () => {
                buttons[i].style.backgroundColor = 'rgba(35,35,35,1)';
            });



        }

        this.cursorKeys = this.input.keyboard.createCursorKeys();
        this.cursorKeys.KeyW = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.W, false);
        this.cursorKeys.KeyA = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.A, false);
        this.cursorKeys.KeyS = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.S, false);
        this.cursorKeys.KeyD = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.D, false);
        this.cursorKeys.Ctrl = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.CTRL, false);

        this.defaultTile = this.tileJson;

        this.gui = new dat.GUI();
        this.gui.domElement.addEventListener('mouseover', () => {
            this.isClick = true;
        })
        this.gui.domElement.addEventListener('mouseout', () => {
            this.isClick = false;
        })

        this.objGui = new dat.GUI();
        this.objGui.domElement.addEventListener('mouseover', () => {
            this.isClick = true;
        })
        this.objGui.domElement.addEventListener('mouseout', () => {
            this.isClick = false;
        })


        this.videoGui = new dat.GUI();
        this.videoGui.domElement.addEventListener('mouseover', () => {
            this.isClick = true;
        })
        this.videoGui.domElement.addEventListener('mouseout', () => {
            this.isClick = false;
        })

        this.pointerFolder = this.gui.addFolder('Pointer');
        this.pointerFolder.add(this.pointer, 'x').listen();
        this.pointerFolder.add(this.pointer, 'y').listen();
        this.pointerFolder.add(this.pointer, 'zoom')
            .name("zoom")
            .listen()
            .onChange(async (value) => {
                if (value === '') return;
                this.cameras.main.zoom = +value;
            });

        this.pointerFolder.open();

        this.grid = this.add.grid(0, 0, 0, 0, 32, 32, 0x000000, 0);
        this.grid.setOutlineStyle(0x999999, 0.5);
        this.grid.depth = -0.5;

        var isDrag = false;

        this.input.on('pointerdown', function (pointer) {
            // this.pathfinderArrow.x = pointer.x;
            // this.pathfinderArrow.y = pointer.y;
            // this.pathfinderArrow.setAlpha(1);
            // if (!this.pathTween) {
            //     this.pathTween = this.tweens.add({
            //         targets: this.pathfinderArrow,
            //         alpha: 0,
            //         yoyo: false,
            //         repeat: 0,
            //         ease: 'Sine.easeInOut'
            //     });
            // } else {
            //     this.pathTween.stop();
            //     this.pathfinderArrow.x = pointer.x;
            //     this.pathfinderArrow.y = pointer.y;
            //     this.pathfinderArrow.setAlpha(1);
            //     this.pathTween = this.tweens.add({
            //         targets: this.pathfinderArrow,
            //         alpha: 0,
            //         yoyo: false,
            //         repeat: 0,
            //         ease: 'Sine.easeInOut'
            //     });
            // }


            if (this.maps.curObjSprite !== null) {
                this.maps.curObjSprite = null;
                this.curObjRect.clear();
                this.curObjName.name = '';
            }
            if (this.maps.curVideoSprite !== null) {
                this.maps.curVideoSprite = null;
                if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                    this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                }
                this.curVideoName.name = '';
            }
        }, this);

        this.input.on('pointermove', (p) => {
            if (!p.isDown || isDrag) {
                if (this.maps) {
                    if (this.maps.curObjSprite !== null) {
                        const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);

                        if (this.map !== null) {
                            if (this.inputPayload.ctrl) {
                                this.maps.curObjSprite.x = worldPoint.x;
                                this.maps.curObjSprite.y = worldPoint.y;
                            } else {
                                const pointerTileX = this.map.worldToTileX(worldPoint.x);
                                const pointerTileY = this.map.worldToTileY(worldPoint.y);

                                const posX = this.map.tileToWorldX(pointerTileX);
                                const posY = this.map.tileToWorldY(pointerTileY);

                                this.maps.curObjSprite.x = posX;
                                this.maps.curObjSprite.y = posY;
                            }

                            if (this.maps.curObjSprite.depthAuto) {
                                this.maps.curObjSprite.depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, this.maps.mapMaxHeight, this.maps.curObjSprite.y));
                            }
                        }
                    } else if (this.maps.curVideoSprite !== null) {
                        const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);
                        if (this.map !== null) {
                            if (this.inputPayload.ctrl) {
                                this.maps.curVideoSprite.x = worldPoint.x;
                                this.maps.curVideoSprite.y = worldPoint.y;
                            } else {
                                const pointerTileX = this.map.worldToTileX(worldPoint.x);
                                const pointerTileY = this.map.worldToTileY(worldPoint.y);

                                const posX = this.map.tileToWorldX(pointerTileX);
                                const posY = this.map.tileToWorldY(pointerTileY);

                                this.maps.curVideoSprite.x = posX;
                                this.maps.curVideoSprite.y = posY;
                            }
                        }
                    }
                }
                return;
            }

            if (this.tileState.drag && !this.isClick) {
                this.cameras.main.scrollX -= (p.x - p.prevPosition.x) / this.cameras.main.zoom;
                this.cameras.main.scrollY -= (p.y - p.prevPosition.y) / this.cameras.main.zoom;
            }
        });

        this.input.on('wheel', (pointer, gameObjects, deltaX, deltaY, deltaZ) => {
            if (!this.map || this.map === null) return;

            const worldPoint = this.cameras.main.getWorldPoint(pointer.x, pointer.y);
            const newZoom = this.cameras.main.zoom - this.cameras.main.zoom * 0.001 * deltaY;

            const Max = this.maps.mapHeight < this.maps.mapWidth ? this.maps.mapWidth : this.maps.mapHeight;
            const Min = this.cameras.main.width < this.cameras.main.height ? this.cameras.main.height : this.cameras.main.width;

            const total = Min / Max;
            this.cameras.main.zoom = Phaser.Math.Clamp(newZoom, total, 2);

            this.cameras.main.preRender();
            const newWorldPoint = this.cameras.main.getWorldPoint(pointer.x, pointer.y);
            this.cameras.main.scrollX -= newWorldPoint.x - worldPoint.x;
            this.cameras.main.scrollY -= newWorldPoint.y - worldPoint.y;
        });

        this.input.on('drag', (pointer, gameobject, dragX, dragY) => {
            if (!this.objState.drag && !this.videoState.drag && !this.tileState.drag) return;

            if (gameobject.isVideo === undefined && !this.objState.drag) return;

            if (gameobject.isVideo && !this.videoState.drag) return;


            if (this.inputPayload.ctrl) {
                const worldPoint = this.cameras.main.getWorldPoint(pointer.x, pointer.y);
                gameobject.setPosition(worldPoint.x, worldPoint.y);
            } else {
                dragX = Phaser.Math.Snap.To(dragX, 32);
                dragY = Phaser.Math.Snap.To(dragY, 32);
                gameobject.setPosition(dragX, dragY);
            }
            if (gameobject.depthAuto) {
                gameobject.depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, this.maps.mapMaxHeight, gameobject.y));
            }
            if (gameobject.isVideo === undefined) {
                this.curObjRect.lineStyle(3, 0xffff33, 1);
                this.curObjRect.strokeRect(0, 0, gameobject.width, gameobject.height);
                this.curObjRect.x = gameobject.x - (gameobject.width / 2);
                this.curObjRect.y = gameobject.y - (gameobject.height / 2);
                this.maps.curObjSprite = gameobject;
                this.curObjName.name = gameobject.name;
            } else if (gameobject.isVideo) {
                this.maps.curVideoSprite = gameobject;
                this.curVideoName.name = gameobject.name;
                this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 1);
            }

            isDrag = true;
        });


        this.input.on('dragend', (pointer, gameobject) => {
            if (!this.objState.drag && !this.videoState.drag && !this.tileState.drag) return;

            if (gameobject.isVideo === undefined && !this.objState.drag) return;

            if (gameobject.isVideo && !this.videoState.drag) return;

            if (gameobject.isVideo === undefined) {
                this.curObjRect.clear();
                this.maps.curObjSprite = null;
                this.curObjName.name = '';
            } else if (gameobject.isVideo) {
                this.maps.curVideoSprite = null;
                this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                this.curVideoName.name = '';
            }

            isDrag = false;
        });

        this.room.onMessage('MapArr', async (arr) => {


            await Assets.loadImage(this, arr.arrInfo);
            this.load.start();
            this.load.once('complete', () => {
                this.createMapFolder(arr.arrInfo);
                this.createTileFolder();

                this.fileSave(arr.arrtem);
            });
        });

        this.room.onMessage("ObjArr", async (arr) => {
            await Assets.loadImage(this, arr);
            this.load.start();
            this.load.once('complete', () => {
                this.createObjectList(arr);

                this.createVideoFolder();
            });
        });

        loading.style.display = "none";
        chatBox.style.display = "none";
        Box.style.display = "none";
    }

    elapsedTime = 0;
    fixedTimeStep = 1000 / 60;
    update(time, delta) {

        if (this.cursorKeys === undefined || this.cursorKeys === null) return;
        this.elapsedTime += delta;

        while (this.elapsedTime >= this.fixedTimeStep) {
            this.elapsedTime -= this.fixedTimeStep;
            this.fixedTick(time, this.fixedTimeStep);
        }
    }

    fixedTick(time, delta) {

        for (var i = 0; i < Object.keys(this.gui.__folders).length; i++) {
            var key = Object.keys(this.gui.__folders)[i];
            for (var j = 0; j < this.gui.__folders[key].__controllers.length; j++) {
                this.gui.__folders[key].__controllers[j].updateDisplay();
            }
        }

        for (var i = 0; i < Object.keys(this.objGui.__folders).length; i++) {
            var key = Object.keys(this.objGui.__folders)[i];
            for (var j = 0; j < this.objGui.__folders[key].__controllers.length; j++) {
                this.objGui.__folders[key].__controllers[j].updateDisplay();
            }
        }

        const emoji = document.querySelectorAll(".emoji");
        if (emoji) {
            for (let i = 0; i < emoji.length; ++i) {
                emoji[i].style.left = +emoji[i].dataX - this.cameras.main.scrollX + 'px';
                emoji[i].style.top = +emoji[i].dataY - this.cameras.main.scrollY + 'px';
            }
        }

        if(this.maps) {
        for(let type in this.maps.objSprites) {
            
            if(this.maps.objSprites[type].domObj && this.maps.objSprites[type].domObj !== null) {
                this.maps.objSprites[type].domObj.x = this.maps.objSprites[type].x + +this.maps.objSprites[type].collisionOffsetX;
                this.maps.objSprites[type].domObj.y = this.maps.objSprites[type].y + +this.maps.objSprites[type].collisionOffsetY;
            }
           
        }
    }


        const cameraSpeed = 10;
        this.inputPayload.left = this.cursorKeys.left.isDown || this.cursorKeys.KeyA.isDown;
        this.inputPayload.right = this.cursorKeys.right.isDown || this.cursorKeys.KeyD.isDown;
        this.inputPayload.up = this.cursorKeys.up.isDown || this.cursorKeys.KeyW.isDown;
        this.inputPayload.down = this.cursorKeys.down.isDown || this.cursorKeys.KeyS.isDown;
        this.inputPayload.space = this.cursorKeys.space.isDown;
        this.inputPayload.ctrl = this.cursorKeys.Ctrl.isDown;

        if (this.inputPayload.up) {
            this.cameras.main.scrollY -= cameraSpeed;
        }
        else if (this.inputPayload.down) {
            this.cameras.main.scrollY += cameraSpeed;

        }
        if (this.inputPayload.left) {
            this.cameras.main.scrollX -= cameraSpeed;

        }
        else if (this.inputPayload.right) {
            this.cameras.main.scrollX += cameraSpeed;
        }

        const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);
        this.pointer.x = worldPoint.x;
        this.pointer.y = worldPoint.y;
        this.pointer.zoom = `${this.cameras.main.zoom}`;

        if (this.map !== null) {
            const pointerTileX = this.map.worldToTileX(worldPoint.x);
            const pointerTileY = this.map.worldToTileY(worldPoint.y);

            this.marker.x = this.map.tileToWorldX(pointerTileX);
            this.marker.y = this.map.tileToWorldY(pointerTileY);

            if (this.input.manager.activePointer.isDown && !this.isClick) {         //컨버스에 마우스를 눌렀다. 여기서 다 정의하면 된다.
                this.MakeTile(pointerTileX, pointerTileY);
            }

            if (this.maps.curObjSprite !== null) {
                if (this.inputPayload.ctrl) {
                    this.maps.curObjSprite.x = worldPoint.x;
                    this.maps.curObjSprite.y = worldPoint.y;
                } else {
                    const posX = this.map.tileToWorldX(pointerTileX);
                    const posY = this.map.tileToWorldY(pointerTileY);

                    this.maps.curObjSprite.x = posX;
                    this.maps.curObjSprite.y = posY;
                }
                if (this.maps.curObjSprite.depthAuto) {
                    this.maps.curObjSprite.depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, this.maps.mapMaxHeight, this.maps.curObjSprite.y));
                }

                this.curObjRect.x = this.maps.curObjSprite.x - (this.maps.curObjSprite.width / 2);
                this.curObjRect.y = this.maps.curObjSprite.y - (this.maps.curObjSprite.height / 2);
            }

            if (this.maps.curVideoSprite !== null) {
                if (this.inputPayload.ctrl) {
                    this.maps.curVideoSprite.x = worldPoint.x;
                    this.maps.curVideoSprite.y = worldPoint.y;
                } else {
                    const posX = this.map.tileToWorldX(pointerTileX);
                    const posY = this.map.tileToWorldY(pointerTileY);

                    this.maps.curVideoSprite.x = posX;
                    this.maps.curVideoSprite.y = posY;
                }
            }

        }

        if (this.maps) {

            if (this.maps.mapWidth < this.maps.mapMaxWidth || this.maps.mapHeight < this.maps.mapMaxHeight) {
                if (this.maps.mapWidth < this.maps.mapMaxWidth && this.maps.mapHeight < this.maps.mapMaxHeight) {
                    this.maps.mapWidth = this.maps.mapMaxWidth;
                    this.maps.mapHeight = this.maps.mapMaxHeight;
                } else if (this.maps.mapWidth < this.maps.mapMaxWidth) {
                    this.maps.mapWidth = this.maps.mapMaxWidth;
                } else if (this.maps.mapHeight < this.maps.mapMaxHeight) {
                    this.maps.mapHeight = this.maps.mapMaxHeight;
                }

                if (this.map) {
                    this.map.destroy();
                }

                for (let i = 0; i < this.maps.mapMaxHeight / 32; ++i) {
                    for (let j = 0; j < this.maps.mapMaxWidth / 32; ++j) {
                        if (!this.tileJson.layers[0].data[i * Math.ceil((this.maps.mapMaxWidth / 32)) + j]) {
                            this.tileJson.layers[0].data[i * Math.ceil((this.maps.mapMaxWidth / 32)) + j] = 84 - 1;
                        }
                    }
                }

                this.tileJson.height = Math.ceil(this.maps.mapHeight / 32);
                this.tileJson.width = Math.ceil(this.maps.mapWidth / 32);
                this.tileJson.layers[0].height = Math.ceil(this.maps.mapHeight / 32);
                this.tileJson.layers[0].width = Math.ceil(this.maps.mapWidth / 32);

                this.map = this.make.tilemap({ tileWidth: 32, tileHeight: 32, width: this.maps.mapWidth, height: this.maps.mapHeight });
                const tiles = this.map.addTilesetImage(Assets.TILEX);
                this.layer = this.map.createBlankLayer('Tile Layer 1', tiles);

                if (!this.marker) {
                    this.marker = this.add.graphics();
                    this.marker.lineStyle(3, 0x000000, 1);
                    this.marker.strokeRect(0, 0, this.markerSize * this.map.tileWidth, this.markerSize * this.map.tileHeight);
                }
                this.cameras.main.setBounds(0, 0, this.maps.mapWidth, this.maps.mapHeight);
                this.physics.world.setBounds(0, 0, this.maps.mapWidth, this.maps.mapHeight);
                this.grid.setSize(this.maps.mapWidth, this.maps.mapHeight);
            }
        }


        if (this.curObjName.name !== '') {
            this.objdepth.name = this.maps.objSprites[this.curObjName.name].depth;
            this.isDepthAuto.auto = this.maps.objSprites[this.curObjName.name].depthAuto;
            this.objOption.wall = this.maps.objSprites[this.curObjName.name].isWall;
            this.objOption.overlap = this.maps.objSprites[this.curObjName.name].isOverlap;
            if (this.maps.teleportlist !== this.maps.objSprites[this.curObjName.name].teleportType) {
                this.maps.teleportlist = this.maps.objSprites[this.curObjName.name].teleportType;

                this.teleportController = this.teleportController.options(this.teleporttype);
                this.teleportController.name("이동")
                    .onChange(async (value) => {
                        if (this.curObjName.name !== '') {
                            this.maps.objSprites[this.curObjName.name].teleportType = value;
                        }
                    })
            }
            if (this.maps.popuplist !== this.maps.objSprites[this.curObjName.name].popUpType) {
                this.maps.popuplist = this.maps.objSprites[this.curObjName.name].popUpType;

                this.popUpContrller = this.popUpContrller.options(this.popuptype);
                this.popUpContrller.name("팝업")
                    .onChange(async (value) => {
                        if (this.curObjName.name !== '') {
                            this.maps.objSprites[this.curObjName.name].popUpType = value;
                        }
                    })
            }

            this.objPos.x = this.maps.objSprites[this.curObjName.name].x;
            this.objPos.y = this.maps.objSprites[this.curObjName.name].y;
            this.objOffsetPos.x = this.maps.objSprites[this.curObjName.name].saveOffsetX;
            this.objOffsetPos.y = this.maps.objSprites[this.curObjName.name].saveOffsetY;
            this.objSheetSize.width = this.maps.objSprites[this.curObjName.name].sheetWidth;
            this.objSheetSize.height = this.maps.objSprites[this.curObjName.name].sheetHeight;

            this.setChecked(this.collState.state, this.maps.objSprites[this.curObjName.name].collState);
            this.setChecked(this.property.type, this.maps.objSprites[this.curObjName.name].property);
            this.sheetCheck.sheet = this.maps.objSprites[this.curObjName.name].isSpriteSheet;
            this.sheetYoyo.yoyo = this.maps.objSprites[this.curObjName.name].isYoyo;
            this.sheetFrame.frame = this.maps.objSprites[this.curObjName.name].numFrame;
            this.sheetFrameCount.count = this.maps.objSprites[this.curObjName.name].frameCount;
            this.sheetCollisionBefore.collision = this.maps.objSprites[this.curObjName.name].collisionBefore;
            this.sheetCollisionAfter.collision = this.maps.objSprites[this.curObjName.name].collisionAfter;
            this.curCollisionName.name = this.maps.objSprites[this.curObjName.name].collisionName;
            this.curCollsionOffset.x = this.maps.objSprites[this.curObjName.name].collisionOffsetX;
            this.curCollsionOffset.y = this.maps.objSprites[this.curObjName.name].collisionOffsetY;

            if(this.maps.objSprites[this.curObjName.name].domObj && this.maps.objSprites[this.curObjName.name].domObj !== null) {
                this.maps.objSprites[this.curObjName.name].domObj.x = this.maps.objSprites[this.curObjName.name].x + +this.maps.objSprites[this.curObjName.name].collisionOffsetX;
                this.maps.objSprites[this.curObjName.name].domObj.y = this.maps.objSprites[this.curObjName.name].y + +this.maps.objSprites[this.curObjName.name].collisionOffsetY;
            }

            if (this.choiceObjRect !== null) {
                this.choiceObjRect.x = this.maps.objSprites[this.curObjName.name].x - (this.maps.objSprites[this.curObjName.name].width / 2);
                this.choiceObjRect.y = this.maps.objSprites[this.curObjName.name].y - (this.maps.objSprites[this.curObjName.name].height / 2);
            }
        } else if (this.curObjName.name === '') {
            this.objdepth.name = '';
            this.isDepthAuto.auto = true;
            this.objOption.wall = false;
            this.objOption.overlap = false;
            this.objPos.x = '';
            this.objPos.y = '';
            this.objOffsetPos.x = '';
            this.objOffsetPos.y = '';
            this.objSheetSize.width = '';
            this.objSheetSize.height = '';
            this.sheetCheck.sheet = false;
            this.sheetYoyo.yoyo = false;
            this.sheetFrame.frame = '';
            this.sheetFrameCount.count = '';
            this.sheetCollisionBefore.collision = '';
            this.sheetCollisionAfter.collision = '';
            this.curCollisionName.name = ''
            this.curCollsionOffset.x = '0'
            this.curCollsionOffset.y = '0'
            // if (this.maps) {
            //     this.maps.teleportlist = '';
            //     this.teleportController = this.teleportController.options(this.maps.teleportlist,this.teleporttype);
            // }
            this.setChecked(this.collState.state, 'Default');
            this.setChecked(this.property.type, 'default');
        }

        if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
            this.videoSize.width = this.maps.videoSprites[this.curVideoName.name].width;
            this.videoSize.height = this.maps.videoSprites[this.curVideoName.name].height;
        }
    }

    createMapFolder(arr) {
        this.maps = new MapInfo(this);
        this.mapFolder = this.gui.addFolder('Map');

        var data = {};
        data[''] = '';
        for (let i = 0; i < arr.length; ++i) {
            var name = arr[i].name;

            data[name] = name;
            this.maps.mapRoute[name] = arr[i].route;
        }

        this.mapFolder.add(this.maps, "maplist", data)
            .name("BackGround")
            .onChange(async (value) => {
                if (value === '') return;

                if (!this.maps.mapSprites[value]) {
                    this.maps.mapSprites[value] = this.add.image(0, 0, value).setOrigin(0, 0);
                    this.maps.mapSprites[value].name = value;
                    this.maps.mapSprites[value].depth = -1;

                    this.maps.currentMapName[value] = value;
                    this.maps.currentmapinfo[value] = -1;

                    if (this.maps.mapMaxHeight < this.maps.mapSprites[value].height) {
                        this.maps.mapMaxHeight = this.maps.mapSprites[value].height;
                    }
                    if (this.maps.mapMaxWidth < this.maps.mapSprites[value].width) {
                        this.maps.mapMaxWidth = this.maps.mapSprites[value].width
                    }
                }

                this.curMapController = this.curMapController.options(this.maps.currentMapName)
                this.curMapController.name("설치한 배경리스트")
                    .onChange(async (value) => {
                        if (value === '') return;

                        this.curMap = this.maps.currentMapName[value];
                        this.maps.currentmapdepth = this.maps.currentmapinfo[value];
                    })
            })

        this.curMapController = this.mapFolder.add(this.maps, "currentmaplist", this.maps.currentMapName)
            .name("설치한 배경리스트")

        this.curMapDepthController = this.mapFolder.add(this.maps, "currentmapdepth", this.maps.mapdepthrange)
            .name("MapDepth")
            .listen()
            .onChange(async (value) => {
                if (this.maps.currentmapinfo[this.maps.currentmaplist]) {
                    this.maps.currentmapinfo[this.maps.currentmaplist] = value;
                    this.maps.mapSprites[this.maps.currentmaplist].depth = value;
                }
            });

        const deleteButton = {
            delete: async () => {
                if (this.curMap) {
                    var height = this.maps.mapSprites[this.curMap].height;
                    var width = this.maps.mapSprites[this.curMap].width;

                    this.maps.mapSprites[this.curMap].destroy();
                    delete this.maps.mapSprites[this.curMap];
                    delete this.maps.currentMapName[this.curMap];

                    this.curMapController = this.curMapController.options(this.maps.currentMapName);
                    this.curMapController.name("설치한 배경리스트")
                        .onChange(async (value) => {
                            if (value === '') return;

                            this.curMap = this.maps.currentMapName[value];
                            this.maps.currentmapdepth = this.maps.currentmapinfo[value];
                        })

                    var isEmpty = true;

                    for (var type in this.maps.mapSprites) {
                        isEmpty = false;
                        break;
                    }

                    if (isEmpty) {
                        if (this.map) {
                            this.map.destroy();
                            this.map = null;
                        }
                        if (this.tileJson) {
                            this.tileJson = this.defaultTile;
                        }

                        this.maps.currentmaplist = '';
                        this.maps.mapWidth = 0;
                        this.maps.mapHeight = 0;
                        this.maps.mapMaxWidth = 0;
                        this.maps.mapMaxHeight = 0;

                        this.grid.setSize(this.maps.mapMaxWidth, this.maps.mapMaxHeight);
                    } else {
                        if (this.maps.mapMaxHeight === height) {
                            var maxHeight = 0;
                            for (var type in this.maps.mapSprites) {
                                if (maxHeight < this.maps.mapSprites[type].height) {
                                    maxHeight = this.maps.mapSprites[type].height;
                                }
                            }
                            this.maps.mapMaxHeight = maxHeight;
                            this.maps.mapHeight = maxHeight;
                        }
                        if (this.maps.mapMaxWidth === width) {
                            var maxWidth = 0;
                            for (var type in this.maps.mapSprites) {
                                if (maxWidth < this.maps.mapSprites[type].width) {
                                    maxWidth = this.maps.mapSprites[type].width;
                                }
                            }
                            this.maps.mapMaxWidth = maxWidth;
                            this.maps.mapWidth = maxWidth;
                        }

                        this.tileJson.height = Math.ceil(this.maps.mapMaxHeight / 32);
                        this.tileJson.width = Math.ceil(this.maps.mapMaxWidth / 32);
                        this.tileJson.layers[0].height = Math.ceil(this.maps.mapMaxHeight / 32);
                        this.tileJson.layers[0].width = Math.ceil(this.maps.mapMaxWidth / 32);

                        this.cameras.main.setBounds(0, 0, this.maps.mapWidth, this.maps.mapHeight);
                        this.grid.setSize(this.maps.mapMaxWidth, this.maps.mapMaxHeight);
                    }

                    this.curMap = null;
                }
            }
        }

        this.mapFolder.add(deleteButton, 'delete')
            .name('선택된 맵 삭제');

        const clearButton = {
            clear: async () => {
                if (this.maps.mapSprites) {
                    for (let type in this.maps.mapSprites) {
                        this.maps.mapSprites[type].destroy();
                        delete this.maps.mapSprites[type];
                        delete this.maps.currentMapName[type];
                        this.curMapController = this.curMapController.options(this.maps.currentMapName);
                        this.curMapController.name("설치한 배경리스트");

                        if (this.map) {
                            this.map.destroy();
                            this.map = null;
                        }
                        if (this.tileJson) {
                            this.tileJson = this.defaultTile;
                        }

                        this.maps.currentmaplist = '';
                        this.maps.mapWidth = 0;
                        this.maps.mapHeight = 0;
                        this.maps.mapMaxWidth = 0;
                        this.maps.mapMaxHeight = 0;

                        this.grid.setSize(this.maps.mapWidth, this.maps.mapHeight);
                    }
                }
            }
        }

        this.mapFolder.add(clearButton, 'clear')
            .name('MapClear');
    }

    createTileFolder() {
        this.tileFolder = this.gui.addFolder('Tile');

        this.tileFolder.add(this.tileState, 'drag')
            .name('드래그')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'drag');
            });

        this.tileFolder.add(this.tileState, 'eraser')
            .name('지우개')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'eraser');
            });

        this.tileFolder.add(this.tileState, 'wall')
            .name('Wall')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'wall');
            });

        this.tileFolder.add(this.tileState, 'start')
            .name('SpawnPoint')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'start');
            });

        this.tileFolder.add(this.tileState, 'endline')
            .name('EndLine')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'endline');
            });

        this.tileFolder.add(this.tileState, 'private')
            .name('Private')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'private');
            });

        this.tileFolder.add(this.tileState, 'wallprivate')
            .name('WallPrivate')
            .listen()
            .onChange(async () => {
                this.setChecked(this.tileState, 'wallprivate');
            });


        this.setChecked(this.tileState, 'drag');

        this.privateData[''] = '';

        for (let i = 1; i < 40; ++i) {
            this.privateData[`zone${i}`] = 100 + i;
        }

        this.tileFolder.add(this.maps, "privatelist", this.privateData)
            .name("PrivateList")
            .onChange(async (value) => {
                this.maps.currentprivatelist = value;
            })


        this.tileFolder.add(this.isTileAlpha, 'alpha')
            .name('투명')
            .onChange(async () => {
                this.layer.setAlpha(!this.isTileAlpha.alpha);
            });


        // const tileSaveLoad = {
        //     save: async () => {

        //     },
        //     load: async () => {

        //     }
        // }
        // this.tileFolder.add(tileSaveLoad, 'save')
        //     .name('Tile_Save');

        // this.tileFolder.add(tileSaveLoad, 'load')
        //     .name('Tile_Load');

        const clearButton = {
            clear: async () => {
                if (this.map) {
                    this.map.destroy();
                }

                if (this.tileJson) {
                    this.tileJson = this.defaultTile;
                }

                this.tileJson.height = Math.ceil(this.maps.mapHeight / 32);
                this.tileJson.width = Math.ceil(this.maps.mapWidth / 32);
                this.tileJson.layers[0].height = Math.ceil(this.maps.mapHeight / 32);
                this.tileJson.layers[0].width = Math.ceil(this.maps.mapWidth / 32);

                this.map = await this.make.tilemap({ tileWidth: 32, tileHeight: 32, width: this.maps.mapWidth, height: this.maps.mapHeight });
                const tiles = this.map.addTilesetImage(Assets.TILEX);
                this.layer = this.map.createBlankLayer('Tile Layer 1', tiles);

            }
        }

        this.tileFolder.add(clearButton, 'clear')
            .name('TileClear');
    }

    createObjectList(arr) {
        //타입과 위치만 저장할 것임. 

        this.ObjectFolder = this.objGui.addFolder('Object');

        var data = {};
        data[''] = '';

        for (let i = 0; i < arr.length; ++i) {
            var name = arr[i].name;

            data[name] = name;
            this.maps.objRoute[name] = arr[i].route;
        }

        this.ObjectFolder.add(this.maps, "objlist", data)
            .name("Object")
            .onChange(async (value) => {
                this.preAddObject = value;
                if (value === '') return;

                var obj = this.add.image(0, 0, value).setOrigin(0.5, 0.5);
                obj.setInteractive({ pixelPerfect: true, draggable: true });

                obj.on('pointerup', (pointer) => {
                    if (!this.objState.choice || this.isClick) return;

                    if (this.choiceObjRect === null) {
                        this.choiceObjRect = this.add.graphics();
                        this.choiceObjRect.depth = 100;
                    }
                    this.choiceObjRect.clear();
                    this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                    this.choiceObjRect.strokeRect(0, 0, obj.width, obj.height);
                    this.curObjName.name = obj.name;
                })

                this.stack++;
                if (!this.maps.objSprites[value + `${this.stack}`]) {        //새로운 오브젝트 선택
                    obj.saveName = value;
                    obj.name = value + `${this.stack}`;
                    this.objDefault(obj);

                    if (this.choiceObjRect !== null) {
                        this.choiceObjRect.clear();
                    }
                    this.curObjName.name = '';

                    this.setChecked(this.objState, 'default');

                    this.curObjName.name = obj.name;
                    this.maps.objSprites[value + `${this.stack}`] = obj;
                    this.maps.curObjSprite = obj;

                    this.maps.currentObjName[value + `${this.stack}`] = value + `${this.stack}`;
                }


                if (this.curObjRect === null) {
                    this.curObjRect = this.add.graphics();
                    this.curObjRect.depth = 100;
                }

                this.curObjRect.clear();
                this.curObjRect.lineStyle(3, 0xffff33, 1);
                this.curObjRect.strokeRect(0, 0, obj.width, obj.height);

                this.curObjectController = this.curObjectController.options(this.maps.currentObjName);
                this.curObjectController.name("설치한 오브젝트")
                    .onChange(async (value) => {
                        if (value === '') return;

                        this.curObjName.name = value;

                        this.setChecked(this.objState, 'choice', this.objType.obj);

                        if (this.choiceObjRect === null) {
                            this.choiceObjRect = this.add.graphics();
                            this.choiceObjRect.depth = 100;
                        }
                        const choiceObj = this.maps.objSprites[value];
                        this.choiceObjRect.clear();
                        this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                        this.choiceObjRect.strokeRect(0, 0, choiceObj.width, choiceObj.height);
                    })
            })

        const addButton = {
            add: async () => {
                if (this.preAddObject === '') return;

                if (this.maps.curVideoSprite !== null) {
                    this.maps.curVideoSprite = null;
                    this.curVideoName.name = '';
                }

                var obj = this.add.image(0, 0, this.preAddObject).setOrigin(0.5, 0.5);
                obj.setInteractive({ pixelPerfect: true, draggable: true });

                obj.on('pointerup', (pointer) => {
                    if (!this.objState.choice || this.isClick) return;

                    if (this.choiceObjRect === null) {
                        this.choiceObjRect = this.add.graphics();
                        this.choiceObjRect.depth = 100;
                    }
                    this.choiceObjRect.clear();
                    this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                    this.choiceObjRect.strokeRect(0, 0, obj.width, obj.height);
                    this.curObjName.name = obj.name;
                })

                this.stack++;
                if (!this.maps.objSprites[this.preAddObject + `${this.stack}`]) {        //새로운 오브젝트 선택
                    obj.saveName = this.preAddObject;
                    obj.name = this.preAddObject + `${this.stack}`;
                    this.objDefault(obj);

                    if (this.choiceObjRect !== null) {
                        this.choiceObjRect.clear();
                    }
                    this.curObjName.name = '';

                    this.setChecked(this.objState, 'default');

                    this.curObjName.name = obj.name;
                    this.maps.objSprites[this.preAddObject + `${this.stack}`] = obj;
                    this.maps.curObjSprite = obj;

                    this.maps.currentObjName[this.preAddObject + `${this.stack}`] = this.preAddObject + `${this.stack}`;
                }


                if (this.curObjRect === null) {
                    this.curObjRect = this.add.graphics();
                    this.curObjRect.depth = 100;
                }

                this.curObjRect.clear();
                this.curObjRect.lineStyle(3, 0xffff33, 1);
                this.curObjRect.strokeRect(0, 0, obj.width, obj.height);

                this.curObjectController = this.curObjectController.options(this.maps.currentObjName);
                this.curObjectController.name("설치한 오브젝트")
                    .onChange(async (value) => {
                        if (value === '') return;

                        this.curObjName.name = value;
                        this.setChecked(this.objState, 'choice', this.objType.obj);
                        this.setChecked(this.videoState, 'default');
                        this.setChecked(this.tileState, 'drag');

                        if (this.choiceObjRect === null) {
                            this.choiceObjRect = this.add.graphics();
                            this.choiceObjRect.depth = 100;
                        }
                        const choiceObj = this.maps.objSprites[value];
                        this.choiceObjRect.clear();
                        this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                        this.choiceObjRect.strokeRect(0, 0, choiceObj.width, choiceObj.height);
                    })
            }
        }

        this.ObjectFolder.add(addButton, 'add')
            .name('오브젝트 추가');

        this.curObjectController = this.ObjectFolder.add(this.maps, "currentobjlist", this.maps.currentObjName)
            .name("설치한 오브젝트")


        this.ObjectFolder.add(this.objState, 'default')
            .name('Default')
            .listen()
            .onChange(async () => {
                if (this.choiceObjRect !== null) {
                    this.choiceObjRect.clear();
                }
                this.curObjName.name = '';

                this.setChecked(this.objState, 'default');
            });

        this.ObjectFolder.add(this.objState, 'drag')
            .name('Drag')
            .listen()
            .onChange(async () => {
                if (this.choiceObjRect !== null) {
                    this.choiceObjRect.clear();

                }
                this.curObjName.name = '';
                this.setChecked(this.objState, 'drag', this.objType.obj);
                this.setChecked(this.videoState, 'default');
                this.setChecked(this.tileState, 'drag');
            });

        this.ObjectFolder.add(this.objState, 'choice')
            .name('Choice')
            .listen()
            .onChange(async () => {
                this.setChecked(this.objState, 'choice', this.objType.obj);
                this.setChecked(this.videoState, 'default');
                this.setChecked(this.tileState, 'drag');
            });

        this.setChecked(this.objState, 'default');

        this.ObjectFolder.add(this.objPos, 'x')
            .name('x')
            .onChange((value) => {
                if (!this.objState.choice || isNaN(value) || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].x = +value;
            })
        this.ObjectFolder.add(this.objPos, 'y')
            .name('y')
            .onChange((value) => {
                if (!this.objState.choice || isNaN(value) || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].y = +value;
            })

        this.ObjectFolder.add(this.objOffsetPos, 'x')
            .name('Offset X')
            .onChange((value) => {
                if (!this.objState.choice || isNaN(value) || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].saveOffsetX = +value;
            })
        this.ObjectFolder.add(this.objOffsetPos, 'y')
            .name('Offset Y')
            .onChange((value) => {
                if (!this.objState.choice || isNaN(value) || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].saveOffsetY = +value;
            })

        this.ObjectFolder.add(this.curObjName, 'name')
            .name("선택된 오브젝트")

        const deleteButton = {
            delete: async () => {
                if (this.curObjName.name === '') return;
                delete this.maps.currentObjName[this.curObjName.name];
                if(this.maps.objSprites[this.curObjName.name].domObj) {
                    this.maps.objSprites[this.curObjName.name].domObj.destroy();
                }
                this.maps.objSprites[this.curObjName.name].destroy();
                delete this.maps.objSprites[this.curObjName.name];
                if (this.choiceObjRect !== null) {
                    this.choiceObjRect.clear();
                }

                this.curObjName.name = '';

                this.curObjectController = this.curObjectController.options(this.maps.currentObjName);
                this.curObjectController.name("설치한 오브젝트")
                    .onChange(async (value) => {
                        if (value === '') return;

                        this.curObjName.name = value;

                        this.setChecked(this.objState, 'choice', this.objType.obj);
                        this.setChecked(this.videoState, 'default');
                        this.setChecked(this.tileState, 'drag');

                        if (this.choiceObjRect === null) {
                            this.choiceObjRect = this.add.graphics();
                            this.choiceObjRect.depth = 100;
                        }
                        const choiceObj = this.maps.objSprites[value];
                        this.choiceObjRect.clear();
                        this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                        this.choiceObjRect.strokeRect(0, 0, choiceObj.width, choiceObj.height);
                    })
            }
        }

        this.ObjectFolder.add(deleteButton, 'delete')
            .name('선택된 오브젝트 삭제');

        this.ObjectFolder.add(this.isDepthAuto, 'auto')
            .name('Depth_Auto')
            .onChange((value) => {
                this.maps.objSprites[this.curObjName.name].depthAuto = value;
                if (value && this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, this.maps.mapMaxHeight, this.maps.objSprites[this.curObjName.name].y));
                }
            })

        this.ObjectFolder.add(this.objdepth, 'name')
            .name('Depth')
            .onChange((value) => {
                if (!this.isDepthAuto.auto && !isNaN(value) && this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].depth = +value;
                }
            })

        this.ObjectFolder.add(this.objOption, 'wall')
            .name('벽')
            .onChange((value) => {
                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].isWall = value;
                }
            })


        this.ObjectFolder.add(this.objOption, 'overlap')
            .name('상호작용')
            .onChange((value) => {
                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].isOverlap = value;
                }
            })


        this.ObjectFolder.add(this.collState.state, 'Default')
            .name('기본')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Default');

                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].collState = 'Default';
                }
            });

        this.ObjectFolder.add(this.collState.state, 'Sit_Down')
            .name('밑을 보고 앉기')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Sit_Down');

                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].collState = this.collState.Sit_Down;
                }
            });

        this.ObjectFolder.add(this.collState.state, 'Sit_Left')
            .name('왼쪽을 보고 앉기')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Sit_Left');

                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].collState = this.collState.Sit_Left;
                }
            });

        this.ObjectFolder.add(this.collState.state, 'Sit_Right')
            .name('오른쪽을 보고 앉기')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Sit_Right');

                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].collState = this.collState.Sit_Right;
                }
            });

        this.ObjectFolder.add(this.collState.state, 'Sit_Up')
            .name('위을 보고 앉기')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Sit_Up');

                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].collState = this.collState.Sit_Up;
                }

            });

        this.ObjectFolder.add(this.collState.state, 'Lie_Left')
            .name('왼쪽을 보고 눕기')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Lie_Left');

                if (this.curObjName.name !== '') {
                    this.maps.objSprites[this.curObjName.name].collState = this.collState.Lie_Left;
                }

            });

        this.ObjectFolder.add(this.collState.state, 'Lie_Right')
            .name('오른쪽을 보고 눕기')
            .listen()
            .onChange(async () => {
                this.setChecked(this.collState.state, 'Lie_Right');
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].collState = this.collState.Lie_Right;

            });

        this.setChecked(this.collState.state, 'Default');


        this.ObjectFolder.add(this.property.type, 'default')
            .name('기본 속성')
            .listen()
            .onChange(async (value) => {
                this.setChecked(this.property.type, 'default');
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].property = 'default';

            });

        this.ObjectFolder.add(this.property.type, 'fishing')
            .name('낚시')
            .listen()
            .onChange(async (value) => {
                this.setChecked(this.property.type, this.property.fishing);
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].property = this.property.fishing;

            });

        this.ObjectFolder.add(this.property.type, 'well')
            .name('우물')
            .listen()
            .onChange(async (value) => {
                this.setChecked(this.property.type, this.property.well);
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].property = this.property.well;

            });

        this.ObjectFolder.add(this.property.type, 'field')
            .name('밭')
            .listen()
            .onChange(async (value) => {
                this.setChecked(this.property.type, this.property.field);
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].property = this.property.field;

            });
           
            this.ObjectFolder.add(this.property.type, 'secretary')
            .name('챗봇')
            .listen()
            .onChange(async (value) => {
                this.setChecked(this.property.type, this.property.secretary);
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].property = this.property.secretary;

            });


        this.setChecked(this.property.type, 'default');

        this.teleporttype = {};
        this.teleporttype[''] = '';
        this.teleporttype['마이랜드 내부'] = "myland_inner";
        this.teleporttype['마이랜드 외부'] = "myland_outer";
        this.teleporttype['클래스룸'] = "land_office";
        this.teleporttype['강의장'] = "land_education";

        this.teleportController = this.ObjectFolder.add(this.maps, "teleportlist", this.teleporttype)
            .name("이동")
            .onChange(async (value) => {
                if (this.curObjName.name === '') return;

                this.maps.objSprites[this.curObjName.name].teleportType = value;
            })


        this.popuptype = {};
        this.popuptype[''] = '';
        this.popuptype['공지사항'] = "notice_popup";
        this.popuptype['랭킹'] = "lanking_popup";
        this.popuptype['일일퀘스트'] = "quest";

        this.popUpContrller = this.ObjectFolder.add(this.maps, "popuplist", this.popuptype)
            .name("팝업")
            .onChange(async (value) => {
                if (this.curObjName.name === '') return;

                this.maps.objSprites[this.curObjName.name].popUpType = value;
            });

        this.ObjectFolder.add(this.curCollisionName, 'name')
            .name("충돌시 이름")
            .onChange(async (value) => {
                if (value === '' || this.curObjName.name === '') {
                    if(value === '' && this.maps.objSprites[this.curObjName.name].domObj && this.maps.objSprites[this.curObjName.name].domObj !== null) {
                        this.maps.objSprites[this.curObjName.name].domObj.destroy();
                        this.maps.objSprites[this.curObjName.name].domObj = null;
                        this.maps.objSprites[this.curObjName.name].collisionName = '';
                    }
                    return;
                }
                this.maps.objSprites[this.curObjName.name].collisionName = value;

                if (!this.maps.objSprites[this.curObjName.name].domObj || this.maps.objSprites[this.curObjName.name].domObj === null) {
                    this.createCollisionName(this.maps.objSprites[this.curObjName.name]);
                } else {
                    this.maps.objSprites[this.curObjName.name].domText.innerText = value;
                }
            });

        this.ObjectFolder.add(this.curCollsionOffset, 'x')
            .name("충돌 Offset X")
            .onChange(async (value) => {
                if (this.curObjName.name === '' || isNaN(value)) return;

                if(value === '') {
                    this.maps.objSprites[this.curObjName.name].collisionOffsetX = '0';
                }
            
                this.maps.objSprites[this.curObjName.name].collisionOffsetX = value;

                if(this.maps.objSprites[this.curObjName.name].domObj && this.maps.objSprites[this.curObjName.name].domObj !== null) {
                    this.maps.objSprites[this.curObjName.name].domObj.x = this.maps.objSprites[this.curObjName.name].x + +value; 
                }
            });
        this.ObjectFolder.add(this.curCollsionOffset, 'y')
            .name("충돌 Offset Y")
            .onChange(async (value) => {
                if (this.curObjName.name === '' || isNaN(value)) return;

                if(value === '') {
                    this.maps.objSprites[this.curObjName.name].collisionOffsetY = '0';
                }
                
                this.maps.objSprites[this.curObjName.name].collisionOffsetY = value;

                if(this.maps.objSprites[this.curObjName.name].domObj && this.maps.objSprites[this.curObjName.name].domObj !== null) {
                    this.maps.objSprites[this.curObjName.name].domObj.y = this.maps.objSprites[this.curObjName.name].y + +value; 
                }
            });

       
        const offsetAutoButton = {
            apply: async () => {
                if(this.curObjName.name === '' ) return;
                if(!this.maps.objSprites[this.curObjName.name].domObj || this.maps.objSprites[this.curObjName.name].domObj === null) return;

                
                this.maps.objSprites[this.curObjName.name].collisionOffsetX = `${(this.maps.objSprites[this.curObjName.name].domBox.offsetWidth / 2) * -1}`;
                this.maps.objSprites[this.curObjName.name].collisionOffsetY = `${(this.maps.objSprites[this.curObjName.name].height / 2) + (this.maps.objSprites[this.curObjName.name].domBox.offsetHeight / 2)}` * -1;

                this.maps.objSprites[this.curObjName.name].domObj.x = this.maps.objSprites[this.curObjName.name].x + +this.maps.objSprites[this.curObjName.name].collisionOffsetX;
                this.maps.objSprites[this.curObjName.name].domObj.y = this.maps.objSprites[this.curObjName.name].y + +this.maps.objSprites[this.curObjName.name].collisionOffsetY;
            }
        };

        this.ObjectFolder.add(offsetAutoButton, 'apply')
        .name('충돌 Offset 자동버튼');

        this.ObjectFolder.add(this.sheetCheck, 'sheet')
            .name('SpriteSheet')
            .listen()
            .onChange(async (value) => {
                if (this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].isSpriteSheet = value;
            });

        this.ObjectFolder.add(this.objSheetSize, 'width')
            .name('width')
            .onChange((value) => {
                if (!this.sheetCheck.sheet || !this.objState.choice || isNaN(value) || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].sheetWidth = +value;
            })
        this.ObjectFolder.add(this.objSheetSize, 'height')
            .name('height')
            .onChange((value) => {
                if (!this.sheetCheck.sheet || !this.objState.choice || isNaN(value) || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].sheetHeight = +value;
            })


        this.ObjectFolder.add(this.sheetYoyo, 'yoyo')
            .name('yoyo')
            .listen()
            .onChange(async (value) => {
                if (!this.sheetCheck.sheet || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].isYoyo = value;
            });


        this.ObjectFolder.add(this.sheetFrameCount, 'count')
            .name('frameCount')
            .listen()
            .onChange(async (value) => {
                if (!this.sheetCheck.sheet || this.curObjName.name === '' || isNaN(value)) return;
                this.maps.objSprites[this.curObjName.name].frameCount = value;
            });



        this.ObjectFolder.add(this.sheetFrame, 'frame')
            .name('frameRate')
            .listen()
            .onChange(async (value) => {
                if (!this.sheetCheck.sheet || this.curObjName.name === '' || isNaN(value)) return;
                this.maps.objSprites[this.curObjName.name].numFrame = value;
            });

        this.ObjectFolder.add(this.sheetCollisionBefore, 'collision')
            .name('상호작용 전')
            .listen()
            .onChange(async (value) => {
                if (!this.sheetCheck.sheet || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].collisionBefore = value;
            });

        this.ObjectFolder.add(this.sheetCollisionAfter, 'collision')
            .name('상호작용 후')
            .listen()
            .onChange(async (value) => {
                if (!this.sheetCheck.sheet || this.curObjName.name === '') return;
                this.maps.objSprites[this.curObjName.name].collisionAfter = value;
            });

        const applyButton = {
            apply: async () => {
                if (this.curObjName.name === '' || !this.sheetCheck.sheet || this.sheetFrame.frame === '') return;


                if (this.maps.objSprites[this.curObjName.name].isCreateSprite !== undefined) {      //생성됨
                    this.textures.removeKey(this.maps.objSprites[this.curObjName.name].saveName);

                    let info = {
                        saveName: this.maps.objSprites[this.curObjName.name].saveName,
                        route: this.maps.objRoute[this.maps.objSprites[this.curObjName.name].saveName],
                        frameWidth: this.maps.objSprites[this.curObjName.name].sheetWidth,
                        frameHeight: this.maps.objSprites[this.curObjName.name].sheetHeight,
                    }


                    await Assets.loadSpriteSheet(this, info);

                    this.load.once('complete', async () => {
                        var exanim = this.anims.get(info.saveName);
                        if (exanim) {
                            this.anims.remove(info.saveName);

                            this.anims.create({
                                key: info.saveName,
                                frames: this.anims.generateFrameNumbers(info.saveName, { start: 0, end: this.maps.objSprites[this.curObjName.name].frameCount }),
                                frameRate: this.maps.objSprites[this.curObjName.name].numFrame,
                                yoyo: this.maps.objSprites[this.curObjName.name].isYoyo,
                                repeat: -1
                            });
                        }

                        this.choiceObjRect.clear();
                        this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                        this.choiceObjRect.strokeRect(0, 0, this.maps.objSprites[this.curObjName.name].sheetWidth, this.maps.objSprites[this.curObjName.name].sheetHeight);

                        this.maps.objSprites[this.curObjName.name].play(info.saveName);

                        this.maps.objSprites[this.curObjName.name].setFrame(0);

                    }, this);

                    this.load.start();
                } else {

                    let info = {
                        saveName: this.maps.objSprites[this.curObjName.name].saveName + "_sheet_" + `${this.sheetStack}`,
                        route: this.maps.objRoute[this.maps.objSprites[this.curObjName.name].saveName],
                        frameWidth: this.maps.objSprites[this.curObjName.name].sheetWidth,
                        frameHeight: this.maps.objSprites[this.curObjName.name].sheetHeight,
                    };

                    this.maps.objRoute[info.saveName] = this.maps.objRoute[this.maps.objSprites[this.curObjName.name].saveName];

                    await Assets.loadSpriteSheet(this, info);

                    this.load.once('complete', async () => {
                        this.anims.create({
                            key: info.saveName,
                            frames: this.anims.generateFrameNumbers(info.saveName, { start: 0, end: this.maps.objSprites[this.curObjName.name].frameCount }),
                            frameRate: this.maps.objSprites[this.curObjName.name].numFrame,
                            yoyo: this.maps.objSprites[this.curObjName.name].isYoyo,
                            repeat: -1
                        });

                        var obj = this.add.sprite(this.maps.objSprites[this.curObjName.name].x, this.maps.objSprites[this.curObjName.name].y, info.saveName).setOrigin(0.5, 0.5);
                        obj.setInteractive({ pixelPerfect: true, draggable: true });

                        obj.on('pointerup', (pointer) => {
                            if (!this.objState.choice || this.isClick) return;

                            this.curObjName.name = obj.name;

                            if (this.choiceObjRect === null) {
                                this.choiceObjRect = this.add.graphics();
                                this.choiceObjRect.depth = 100;
                            }
                            this.choiceObjRect.clear();
                            this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                            this.choiceObjRect.strokeRect(0, 0, obj.width, obj.height);
                        })

                        obj.isCreateSprite = true;            // 확인용

                        obj.saveName = info.saveName;
                        obj.name = this.curObjName.name;
                        obj.depthAuto = this.maps.objSprites[this.curObjName.name].depthAuto;
                        obj.isWall = this.maps.objSprites[this.curObjName.name].isWall;
                        obj.isOverlap = this.maps.objSprites[this.curObjName.name].isOverlap;
                        obj.collState = this.maps.objSprites[this.curObjName.name].collState;
                        obj.saveOffsetX = this.maps.objSprites[this.curObjName.name].saveOffsetX;
                        obj.saveOffsetY = this.maps.objSprites[this.curObjName.name].saveOffsetY;
                        obj.property = this.maps.objSprites[this.curObjName.name].property;
                        obj.teleportType = this.maps.objSprites[this.curObjName.name].teleportType;
                        obj.popUpType = this.maps.objSprites[this.curObjName.name].popUpType;
                        obj.isSpriteSheet = this.maps.objSprites[this.curObjName.name].isSpriteSheet;
                        obj.sheetWidth = this.maps.objSprites[this.curObjName.name].sheetWidth;
                        obj.sheetHeight = this.maps.objSprites[this.curObjName.name].sheetHeight;
                        obj.isYoyo = this.maps.objSprites[this.curObjName.name].isYoyo;
                        obj.numFrame = this.maps.objSprites[this.curObjName.name].numFrame;
                        obj.frameCount = this.maps.objSprites[this.curObjName.name].frameCount;
                        obj.collisionBefore = this.maps.objSprites[this.curObjName.name].collisionBefore;
                        obj.collisionAfter = this.maps.objSprites[this.curObjName.name].collisionAfter;
                        obj.collisionName = this.maps.objSprites[this.curObjName.name].collisionName;
                        obj.collisionOffsetX = this.maps.objSprites[this.curObjName.name].collisionOffsetX;
                        obj.collisionOffsetY = this.maps.objSprites[this.curObjName.name].collisionOffsetY;

                        if(obj.collisionName !== '') {
                            this.createCollisionName(obj);
                            }


                        if (this.maps.objSprites[this.curObjName.name].collText === undefined) {
                            obj.collText = '를 눌러 상호작용';
                        } else {
                            obj.collText = '를 눌러 상호작용';
                        }

                        obj.depth = this.maps.objSprites[this.curObjName.name].depth;

                        if(this.maps.objSprites[this.curObjName.name].domObj) {
                            this.maps.objSprites[this.curObjName.name].domObj.destroy();
                        }
                        this.maps.objSprites[this.curObjName.name].destroy();
                        this.maps.objSprites[this.curObjName.name] = null;

                        if (this.choiceObjRect !== null) {
                            this.choiceObjRect.clear();
                        }
                        this.curObjName.name = '';

                        this.setChecked(this.objState, 'default');

                        // this.curObjName.name = obj.name;
                        this.maps.objSprites[obj.name] = obj;
                        this.maps.curObjSprite = null;

                        this.maps.currentObjName[this.curObjName.name] = this.curObjName.name;

                        obj.play(info.saveName);

                        if (this.curObjRect === null) {
                            this.curObjRect = this.add.graphics();
                            this.curObjRect.depth = 100;
                        }

                        this.curObjRect.clear();
                        // this.curObjRect.lineStyle(3, 0xffff33, 1);
                        // this.curObjRect.strokeRect(0, 0, obj.width, obj.height);

                        this.curObjectController = this.curObjectController.options(this.maps.currentObjName);
                        this.curObjectController.name("설치한 오브젝트")
                            .onChange(async (value) => {
                                if (value === '') return;

                                this.curObjName.name = value;

                                this.setChecked(this.objState, 'choice', this.objType.obj);
                                this.setChecked(this.videoState, 'default');
                                this.setChecked(this.tileState, 'drag');
                                if (this.choiceObjRect === null) {
                                    this.choiceObjRect = this.add.graphics();
                                    this.choiceObjRect.depth = 100;
                                }
                                const choiceObj = this.maps.objSprites[value];
                                this.choiceObjRect.clear();
                                this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                                this.choiceObjRect.strokeRect(0, 0, choiceObj.width, choiceObj.height);
                            })
                    })

                    ++this.sheetStack;

                    this.load.start();
                }
            }
        }

        this.ObjectFolder.add(applyButton, 'apply')
            .name('적용');
    }

    MakeTile(tilePosX, tilePosY) {
        if ((this.tileState.private || this.tileState.wallprivate) && this.maps.currentprivatelist === '') return;
        for (let i = 0; i < this.markerSize; ++i) {
            for (let j = 0; j < this.markerSize; ++j) {

                let tileX = tilePosX + i;
                let tileY = tilePosY + j;

                let tile = this.map.getTileAt(tileX, tileY, this.layer);
                //let preAlpha = tile.alpha;
                if (!this.tileState.drag && tile) {
                    tile.setAlpha(0.5);
                    if (tile.tileText) {
                        tile.tileText.destroy();

                        delete tile.tileText;
                    }
                }

                if (this.tileState.drag) {

                } else if (this.tileState.eraser) {
                    this.map.putTileAt(1, tileX, tileY);
                    tile.setAlpha(0);

                    this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = 1;
                } else if (this.tileState.wall) {
                    this.map.putTileAt(3, tileX, tileY);

                    tile.tint = 0xFF0000;
                    this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = 3;
                } else if (this.tileState.start) {
                    if (this.startTileInfo.index === 0) {
                        this.map.putTileAt(2, tileX, tileY);
                        tile.tint = 0x00FF00;
                        this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = 2;
                        this.startTileInfo.index = tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX;
                        this.startTileInfo.tileX = tileX;
                        this.startTileInfo.tileY = tileY;

                    } else {
                        if (tileX !== this.startTileInfo.tileX || tileY !== this.startTileInfo.tileY) {
                            this.map.putTileAt(2, tileX, tileY);
                            tile.tint = 0x00FF00;

                            this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = 2;

                            this.map.putTileAt(2, this.startTileInfo.tileX, this.startTileInfo.tileY);
                            tile = this.map.getTileAt(this.startTileInfo.tileX, this.startTileInfo.tileY);
                            tile.tint = 0x000000;
                            tile.setAlpha(0);
                            this.tileJson.layers[0].data[this.startTileInfo.index] = 1;

                            this.startTileInfo.index = tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX;
                            this.startTileInfo.tileX = tileX;
                            this.startTileInfo.tileY = tileY;

                        }
                    }
                } else if (this.tileState.endline) {
                    this.map.putTileAt(4, tileX, tileY);
                    tile.tint = 0x800080;
                    this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = 4;
                } else if (this.tileState.private) {
                    this.map.putTileAt(+this.maps.currentprivatelist, tileX, tileY);
                    tile.tint = 0x0000FF;
                    this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = +this.maps.currentprivatelist;

                    this.tileJson.tilesets[0].tileproperties[+this.maps.currentprivatelist] = { option: 'Private', index: +this.maps.currentprivatelist };

                    console.log(this.maps.currentprivatelist)
                    let tileText = this.add.text(tileX * 32 + (32 / 2), tileY * 32 + (32 / 2), `${+this.maps.currentprivatelist - 100}`, { font: '16px Arial', fill: '#ffffff' });

                    tileText.setOrigin(0.5, 0.5);
                    tileText.depth = 101;
                    tile.tileText = tileText;
                } else if (this.tileState.wallprivate) {
                    this.map.putTileAt(+this.maps.currentprivatelist - 60, tileX, tileY);
                    tile.tint = 0xFF0000;
                    this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = +this.maps.currentprivatelist - 60;

                    this.tileJson.tilesets[0].tileproperties[+this.maps.currentprivatelist - 60] = { option: 'WallPrivate', index: +this.maps.currentprivatelist - 60 };

                    let tileText = this.add.text(tileX * 32 + (32 / 2), tileY * 32 + (32 / 2), `${+this.maps.currentprivatelist - 100}`, { font: '16px Arial', fill: '#ffffff' });

                    tileText.setOrigin(0.5, 0.5);
                    tileText.depth = 101;
                    tile.tileText = tileText;
                }

                if (!this.tileState.drag) {
                    if (this.choiceObjRect !== null) {
                        this.choiceObjRect.clear();

                    }
                    this.curObjName.name = '';

                    this.setChecked(this.objState, 'default');
                }
            }
        }

        this.layer.setDepth(100);
    }

    loadTile(tileindex, tileX, tileY) {
        let index = tileindex;
        if (index === 83 || index <= 0) {
            index = 1;
        } else if (index === 84) {
            index = 2;
        } else if (index === 34) {
            index = 3;
        } else if (index === 48) {
            index = 4;
        }

        this.map.putTileAt(index, tileX, tileY);
        let tile = this.map.getTileAt(tileX, tileY, this.layer);
        tile.setAlpha(0.5);

        this.tileJson.layers[0].data[tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX] = index;
        if (index === 1) {
            tile.setAlpha(0);
        } else if (index === 2) {
            this.startTileInfo.index = tileY * Math.ceil((this.maps.mapWidth / 32)) + tileX;
            this.startTileInfo.tileX = tileX;
            this.startTileInfo.tileY = tileY;
            tile.tint = 0x00FF00;
        } else if (index === 3) {
            tile.tint = 0xFF0000;
        }
        else if (index === 4) {
            tile.tint = 0x800080;
        } else if (index >= 40 && index < 100) {
            tile.tint = 0xFF0000;

            this.tileJson.tilesets[0].tileproperties[+index] = { option: 'WallPrivate', index: +index };

            let tileText = this.add.text(tileX * 32 + (32 / 2), tileY * 32 + (32 / 2), `${index - 40}`, { font: '16px Arial', fill: '#ffffff' });

            tileText.setOrigin(0.5, 0.5);
            tileText.depth = 101;
            tile.tileText = tileText;
        } else if (index >= 100) {
            tile.tint = 0x0000FF;

            this.tileJson.tilesets[0].tileproperties[+index] = { option: 'Private', index: +index };

            let tileText = this.add.text(tileX * 32 + (32 / 2), tileY * 32 + (32 / 2), `${index - 100}`, { font: '16px Arial', fill: '#ffffff' });

            tileText.setOrigin(0.5, 0.5);
            tileText.depth = 101;
            tile.tileText = tileText;
        }






        this.layer.setDepth(100);
    }

    async sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    fileSave(arr) {
        this.gui.add(this.cateState.state, 'inner')
            .name('내부')
            .listen()
            .onChange(async () => {
                this.setChecked(this.cateState.state, 'inner');

                this.curCateState.state = 'inner';
                this.curCateState.index = this.cateState['inner'];
            });

        this.gui.add(this.cateState.state, 'outer')
            .name('외부')
            .listen()
            .onChange(async () => {
                this.setChecked(this.cateState.state, 'outer');

                this.curCateState.state = 'outer';
                this.curCateState.index = this.cateState['outer'];
            });

        this.gui.add(this.cateState.state, 'office')
            .name('오피스')
            .listen()
            .onChange(async () => {
                this.setChecked(this.cateState.state, 'office');

                this.curCateState.state = 'office';
                this.curCateState.index = this.cateState['office'];
            });

        this.gui.add(this.cateState.state, 'education')
            .name('교육실')
            .listen()
            .onChange(async () => {
                this.setChecked(this.cateState.state, 'education');

                this.curCateState.state = 'education';
                this.curCateState.index = this.cateState['education'];
            });

        this.gui.add(this.cateState.state, 'gameEducation')
            .name('게임학습')
            .listen()
            .onChange(async () => {
                this.setChecked(this.cateState.state, 'gameEducation');

                this.curCateState.state = 'gameEducation';
                this.curCateState.index = this.cateState['gameEducation'];
            });


        this.setChecked(this.cateState.state, 'inner');
        this.curCateState.state = 'inner';
        this.curCateState.index = this.cateState['inner'];

        const conceptName = {
            name: ''
        };

        this.gui.add(conceptName, 'name')
            .name('템플릿명')
            .listen();

        const SaveLoad = {
            save: async () => {
                if (conceptName.name === '') return;

                var fileInfo = {
                    templeteName: '',
                    templeteIndex: '',
                    templeteState: '',
                    startX: 0,
                    startY: 0,
                    width: 0,
                    height: 0,
                    background: [],
                    tile: {},
                    object: {},
                    video: {},
                };
                var startPos = {
                    x: 0,
                    y: 0
                };

                if (this.layer) {
                    const p1 = this.layer.tileToWorldXY(this.startTileInfo.tileX, this.startTileInfo.tileY);
                    startPos.x = p1.x;
                    startPos.y = p1.y;
                }

                fileInfo.templeteName = conceptName.name + '_' + this.curCateState.state;
                fileInfo.templeteIndex = +this.curCateState.index;
                fileInfo.templeteState = this.curCateState.state;
                fileInfo.startX = startPos.x;
                fileInfo.startY = startPos.y;
                fileInfo.width = this.maps.mapMaxWidth;
                fileInfo.height = this.maps.mapMaxHeight

                for (let type in this.maps.currentMapName) {
                    if (this.maps.currentMapName[type] === '') continue;

                    var backInfo = {
                        name: '',
                        route: '',
                        depth: -1,
                    };

                    backInfo.name = type;
                    backInfo.route = this.maps.mapRoute[type];
                    backInfo.depth = +this.maps.currentmapinfo[type];

                    fileInfo.background.push(backInfo);
                }

                var tileInfo = {
                    name: '',
                    route: ''
                };

                tileInfo.name = conceptName.name;
                tileInfo.route = 'assets/tile' + '/' + tileInfo.name + '_' + fileInfo.templeteState + 'Tile.json';

                fileInfo.tile = tileInfo;


                for (var type in this.maps.objSprites) {
                    if (type === '') continue;

                    const objects = this.maps.objSprites[type];

                    if (!fileInfo.object[objects.saveName]) {
                        var option = {
                            isSpriteSheet: false,
                            frameWidth: 0,
                            frameHeight: 0,
                            route: '',
                            obj: []
                        };
                        option.route = this.maps.objRoute[objects.saveName];
                        option.isSpriteSheet = objects.isSpriteSheet;
                        option.frameWidth = objects.sheetWidth;
                        option.frameHeight = objects.sheetHeight;
                        fileInfo.object[objects.saveName] = option;
                    }

                    var info = {
                        x: 0,
                        y: 0,
                        depth: 0,
                        depthAuto: true,
                        isWall: false,
                        isOverlap: false,
                        collState: 'Default',
                        offsetX: 0,
                        offsetY: 0,
                        property: '',
                        teleportType: '',
                        popUpType: '',
                        isSpriteSheet: false,
                        sheetWidth: 0,
                        sheetHeight: 0,
                        isYoyo: false,
                        numFrame: 0,
                        frameCount: 0,
                        collText: '',
                        collisionBefore: '',
                        collisionAfter: '',
                    };

                    info.x = objects.x;
                    info.y = objects.y;
                    info.depth = objects.depth;
                    info.depthAuto = objects.depthAuto;
                    info.isWall = objects.isWall;
                    info.isOverlap = objects.isOverlap;
                    info.collState = objects.collState;
                    info.offsetX = objects.saveOffsetX;
                    info.offsetY = objects.saveOffsetY;
                    info.property = objects.property;
                    info.teleportType = objects.teleportType;
                    info.popUpType = objects.popUpType;
                    info.isSpriteSheet = objects.isSpriteSheet;
                    info.sheetWidth = objects.sheetWidth;
                    info.sheetHeight = objects.sheetHeight;
                    info.isYoyo = objects.isYoyo;
                    info.numFrame = objects.numFrame;
                    info.frameCount = objects.frameCount;
                    info.collisionBefore = objects.collisionBefore;
                    info.collisionAfter = objects.collisionAfter;
                    info.collisionName = objects.collisionName;
                    info.collisionOffsetX = objects.collisionOffsetX;
                    info.collisionOffsetY = objects.collisionOffsetY;



                    if (objects.collText === undefined) {
                        objects.collText = '를 눌러 상호작용';

                    } else {
                        info.collText = '를 눌러 상호작용';
                    }

                    fileInfo.object[objects.saveName].obj.push(info);
                }

                for (let type in this.maps.videoSprites) {
                    if (type === '') continue;

                    const objects = this.maps.videoSprites[type];

                    let info = {
                        x: 0,
                        y: 0,
                        width: 0,
                        height: 0,
                        name: ''
                    };

                    info.x = objects.x;
                    info.y = objects.y;
                    info.width = objects.width;
                    info.height = objects.height;
                    info.name = objects.name;

                    fileInfo.video[objects.name] = info;
                }

                const jsonFile = JSON.stringify(this.tileJson);
                this.room.send('FileSave', { fileInfo: fileInfo, tileJson: jsonFile });
            },
        }

        this.gui.add(SaveLoad, 'save')
            .name('저장');



        // this.gui.add(SaveLoad, 'load')
        //     .name('불러오기');

        var data = {};
        data[''] = '';



        for (var type in arr) {
            var name = type;

            data[name] = name;

        }

        this.gui.add(this.maps, "templetelist", data)
            .name("템플릿 리스트")
            .onChange(async (value) => {        //템플릿 선택했다. 모든 것을 초기화 하고 템플릿을 부르자.
                if (value === '') return;
                this.reset();

                const startIndex = arr[value].tp_nm.lastIndexOf('_') + 1;
                const type = arr[value].tp_nm.substring(startIndex);
                this.setChecked(this.cateState.state, type);

                this.curCateState.state = type;
                this.curCateState.index = this.cateState[type];

                conceptName.name = arr[value].tp_nm.substring(0, startIndex - 1);

                const data = arr[value].tp_data;

                this.maps.mapHeight = data.height;
                this.maps.mapMaxHeight = data.height;
                this.maps.mapWidth = data.width;
                this.maps.mapMaxWidth = data.width;

                for (let i = 0; i < this.maps.mapMaxHeight / 32; ++i) {
                    for (let j = 0; j < this.maps.mapMaxWidth / 32; ++j) {
                        if (!this.tileJson.layers[0].data[i * Math.ceil((this.maps.mapMaxWidth / 32)) + j]) {
                            this.tileJson.layers[0].data[i * Math.ceil((this.maps.mapMaxWidth / 32)) + j] = 84 - 1;
                        }
                    }
                }

                this.tileJson.height = Math.ceil(this.maps.mapHeight / 32);
                this.tileJson.width = Math.ceil(this.maps.mapWidth / 32);
                this.tileJson.layers[0].height = Math.ceil(this.maps.mapHeight / 32);
                this.tileJson.layers[0].width = Math.ceil(this.maps.mapWidth / 32);

                this.map = this.make.tilemap({ tileWidth: 32, tileHeight: 32, width: this.maps.mapWidth, height: this.maps.mapHeight });
                const tiles = this.map.addTilesetImage(Assets.TILEX);
                this.layer = this.map.createBlankLayer('Tile Layer 1', tiles);
                if (!this.marker) {
                    this.marker = this.add.graphics();
                    this.marker.lineStyle(3, 0x000000, 1);
                    this.marker.strokeRect(0, 0, this.markerSize * this.map.tileWidth, this.markerSize * this.map.tileHeight);
                }
                this.cameras.main.setBounds(0, 0, this.maps.mapWidth, this.maps.mapHeight);
                this.physics.world.setBounds(0, 0, this.maps.mapWidth, this.maps.mapHeight);

                this.grid.setSize(this.maps.mapWidth, this.maps.mapHeight);


                //타일 로드
                var tile = JSON.parse(arr[value].tile);

                const tileWidth = tile.tilewidth;
                const tileHeight = tile.tileheight;

                for (let i = 0; i < tile.layers.length; ++i) {
                    for (let j = 0; j < tile.layers[i].data.length; ++j) {
                        const index = j % Math.ceil(this.maps.mapWidth / tileWidth);
                        const iAdjusted = Math.floor(j / Math.ceil(this.maps.mapWidth / tileWidth));

                        const tileX = (index * tileWidth) / tileWidth;
                        const tileY = (iAdjusted * tileHeight) / tileHeight;

                        this.loadTile(tile.layers[i].data[j], tileX, tileY);
                    }
                }

                //백그라운드 로드
                console.log(data)

                for (let i = 0; i < data.background.length; ++i) {
                    this.maps.mapSprites[data.background[i].name] = this.add.image(0, 0, data.background[i].name).setOrigin(0, 0);
                    this.maps.mapSprites[data.background[i].name].name = data.background[i].name;
                    this.maps.mapSprites[data.background[i].name].depth = data.background[i].depth;
                    this.maps.currentMapName[data.background[i].name] = data.background[i].name;
                    this.maps.currentmapinfo[data.background[i].name] = data.background[i].depth;

                    if (this.maps.mapMaxHeight < this.maps.mapSprites[data.background[i].name].height) {
                        this.maps.mapMaxHeight = this.maps.mapSprites[data.background[i].name].height;
                    }
                    if (this.maps.mapMaxWidth < this.maps.mapSprites[data.background[i].name].width) {
                        this.maps.mapMaxWidth = this.maps.mapSprites[data.background[i].name].width
                    }
                }
                this.curMapController = this.curMapController.options(this.maps.currentMapName)
                this.curMapController.name("설치한 배경리스트")
                    .onChange(async (value) => {
                        if (value === '') return;
                        this.curMap = this.maps.currentMapName[value];
                        this.maps.currentmapdepth = this.maps.currentmapinfo[value];
                    })

                let loadSheetObj = [];

                //오브젝트 로드
                for (var objtype in data.object) {
                    for (let i = 0; i < data.object[objtype].obj.length; ++i) {

                        let issprite = data.object[objtype].obj[i].isSpriteSheet !== undefined ? data.object[objtype].obj[i].isSpriteSheet : false;

                        if (issprite) {
                            let info = {
                                saveName: objtype,
                                route: data.object[objtype].route,
                                obj: data.object[objtype].obj[i],
                                frameWidth: data.object[objtype].obj[i].sheetWidth,
                                frameHeight: data.object[objtype].obj[i].sheetHeight,
                            };

                            loadSheetObj.push(info);
                        } else {
                            let obj = this.add.image(0, 0, objtype).setOrigin(0.5, 0.5);

                            obj.setInteractive({ pixelPerfect: true, draggable: true });
                            obj.x = data.object[objtype].obj[i].x;
                            obj.y = data.object[objtype].obj[i].y;


                            obj.on('pointerup', (pointer) => {
                                if (!this.objState.choice || this.isClick) return;
                                if (this.choiceObjRect === null) {
                                    this.choiceObjRect = this.add.graphics();
                                    this.choiceObjRect.depth = 100;
                                }
                                this.choiceObjRect.clear();
                                this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                                this.choiceObjRect.strokeRect(0, 0, obj.width, obj.height);
                                this.curObjName.name = obj.name;
                            })

                            this.stack++;

                            obj.saveName = objtype;
                            obj.name = objtype + `${this.stack}`;
                            if (data.object[objtype].obj[i].depthAuto !== undefined) {
                                obj.depthAuto = data.object[objtype].obj[i].depthAuto;
                            } else {
                                obj.depthAuto = true;
                            }
                            obj.isWall = data.object[objtype].obj[i].isWall !== undefined ? data.object[objtype].obj[i].isWall : false;
                            obj.isOverlap = data.object[objtype].obj[i].isOverlap !== undefined ? data.object[objtype].obj[i].isOverlap : false;
                            obj.collState = data.object[objtype].obj[i].collState !== undefined ? data.object[objtype].obj[i].collState : 'Default';
                            obj.saveOffsetX = data.object[objtype].obj[i].offsetX !== undefined ? data.object[objtype].obj[i].offsetX : 0;
                            obj.saveOffsetY = data.object[objtype].obj[i].offsetY !== undefined ? data.object[objtype].obj[i].offsetY : 0;
                            obj.property = data.object[objtype].obj[i].property !== undefined ? data.object[objtype].obj[i].property : 'default';
                            obj.depth = data.object[objtype].obj[i].depth !== undefined ? data.object[objtype].obj[i].depth : 0;
                            obj.teleportType = data.object[objtype].obj[i].teleportType !== undefined ? data.object[objtype].obj[i].teleportType : '';
                            obj.popUpType = data.object[objtype].obj[i].popUpType !== undefined ? data.object[objtype].obj[i].popUpType : '';
                            obj.isSpriteSheet = data.object[objtype].obj[i].isSpriteSheet !== undefined ? data.object[objtype].obj[i].isSpriteSheet : false;
                            obj.sheetWidth = data.object[objtype].obj[i].sheetWidth !== undefined ? data.object[objtype].obj[i].sheetWidth : 0;
                            obj.sheetHeight = data.object[objtype].obj[i].sheetHeight !== undefined ? data.object[objtype].obj[i].sheetHeight : 0;
                            obj.isYoyo = data.object[objtype].obj[i].isYoyo !== undefined ? data.object[objtype].obj[i].isYoyo : false;
                            obj.numFrame = data.object[objtype].obj[i].numFrame !== undefined ? data.object[objtype].obj[i].numFrame : 0;
                            obj.frameCount = data.object[objtype].obj[i].frameCount !== undefined ? data.object[objtype].obj[i].frameCount : 0;
                            obj.collisionBefore = data.object[objtype].obj[i].collisionBefore !== undefined ? data.object[objtype].obj[i].collisionBefore : '';
                            obj.collisionAfter = data.object[objtype].obj[i].collisionAfter !== undefined ? data.object[objtype].obj[i].collisionAfter : '';
                            obj.collisionName = data.object[objtype].obj[i].collisionName !== undefined ? data.object[objtype].obj[i].collisionName : '';
                            obj.collisionOffsetX = data.object[objtype].obj[i].collisionOffsetX !== undefined ? data.object[objtype].obj[i].collisionOffsetX : '0';
                            obj.collisionOffsetY = data.object[objtype].obj[i].collisionOffsetY !== undefined ? data.object[objtype].obj[i].collisionOffsetY : '0';


                            if(obj.collisionName !== '') {
                                this.createCollisionName(obj);
                                }

                            if (data.object[objtype].obj[i].collText === undefined) {
                                obj.collText = '를 눌러 상호작용';
                            } else {
                                obj.collText = '를 눌러 상호작용';
                            }

                            this.curObjName.name = '';
                            this.setChecked(this.objState, 'default');
                            this.maps.objSprites[objtype + `${this.stack}`] = obj;
                            this.maps.currentObjName[objtype + `${this.stack}`] = objtype + `${this.stack}`;
                        }
                    }
                }


                console.log(data.video)
                // 비디오 지역 로드
                for (let type in data.video) {
                    let obj = this.add.rectangle(data.video[type].x, data.video[type].y, +data.video[type].width, +data.video[type].height, 0x000000, 0.7);
                    //obj.setStrokeStyle(3, 0xffff33, 1);
                    obj.setDepth(1000);
                    obj.name = type;
                    obj.isVideo = true;
                    obj.setInteractive({ draggable: true });

                    obj.on('pointerup', (pointer) => {
                        if (!this.videoState.choice || this.isClick) return;

                        if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                            this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                        }

                        this.curVideoName.name = obj.name;

                        obj.setStrokeStyle(3, 0xffff33, 1);
                    })

                    this.maps.currentVideoName[type] = type;

                    this.maps.videoSprites[type] = obj;
                    this.maps.curVideoSprite = null;

                    this.curVideoController = this.curVideoController.options(this.maps.currentVideoName);
                    this.curVideoController.name("생성한 영상 지역")
                        .onChange(async (value) => {
                            if (value === '') return;

                            if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                                this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                            }

                            this.curVideoName.name = value;

                            this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 1);
                            this.setChecked(this.videoState, 'choice', this.objType.video);
                            this.setChecked(this.objState, 'default');
                            this.setChecked(this.tileState, 'drag');
                        })

                    this.curVideoName.name = '';
                }


                await Assets.loadSpriteSheetArr(this, loadSheetObj);

                let maxNum = -1;
                this.load.once('complete', async () => {
                    for (let i = 0; i < loadSheetObj.length; ++i) {

                        let objtype = loadSheetObj[i].saveName;

                        this.maps.objRoute[objtype] = loadSheetObj[i].route;

                        const startIndex = objtype.lastIndexOf('_') + 1;
                        let numIndex = objtype.substring(startIndex, objtype.length);

                        if (maxNum < +numIndex) {
                            maxNum = +numIndex;
                            this.sheetStack = maxNum + 1;
                        }

                        this.anims.create({
                            key: loadSheetObj[i].saveName,
                            frames: this.anims.generateFrameNumbers(loadSheetObj[i].saveName, { start: 0, end: +loadSheetObj[i].obj.frameCount }),
                            frameRate: loadSheetObj[i].obj.numFrame,
                            yoyo: loadSheetObj[i].obj.isYoyo,
                            repeat: -1
                        });

                        let obj = this.add.sprite(0, 0, loadSheetObj[i].saveName).setOrigin(0.5, 0.5);
                        obj.setInteractive({ pixelPerfect: true, draggable: true });
                        obj.x = loadSheetObj[i].obj.x;
                        obj.y = loadSheetObj[i].obj.y;


                        obj.on('pointerup', (pointer) => {
                            if (!this.objState.choice || this.isClick) return;
                            if (this.choiceObjRect === null) {
                                this.choiceObjRect = this.add.graphics();
                                this.choiceObjRect.depth = 100;
                            }
                            this.choiceObjRect.clear();
                            this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                            this.choiceObjRect.strokeRect(0, 0, obj.width, obj.height);
                            this.curObjName.name = obj.name;
                        })

                        obj.saveName = objtype;
                        obj.name = objtype;
                        if (loadSheetObj[i].obj.depthAuto !== undefined) {
                            obj.depthAuto = loadSheetObj[i].obj.depthAuto;
                        } else {
                            obj.depthAuto = true;
                        }
                        obj.isWall = loadSheetObj[i].obj.isWall !== undefined ? loadSheetObj[i].obj.isWall : false;
                        obj.isOverlap = loadSheetObj[i].obj.isOverlap !== undefined ? loadSheetObj[i].obj.isOverlap : false;
                        obj.collState = loadSheetObj[i].obj.collState !== undefined ? loadSheetObj[i].obj.collState : 'Default';
                        obj.saveOffsetX = loadSheetObj[i].obj.offsetX !== undefined ? loadSheetObj[i].obj.offsetX : 0;
                        obj.saveOffsetY = loadSheetObj[i].obj.offsetY !== undefined ? loadSheetObj[i].obj.offsetY : 0;
                        obj.property = loadSheetObj[i].obj.property !== undefined ? loadSheetObj[i].obj.property : 'default';
                        obj.depth = loadSheetObj[i].obj.depth !== undefined ? loadSheetObj[i].obj.depth : 0;
                        obj.teleportType = loadSheetObj[i].obj.teleportType !== undefined ? loadSheetObj[i].obj.teleportType : '';
                        obj.popUpType = loadSheetObj[i].obj.popUpType !== undefined ? loadSheetObj[i].obj.popUpType : '';
                        obj.isSpriteSheet = loadSheetObj[i].obj.isSpriteSheet !== undefined ? loadSheetObj[i].obj.isSpriteSheet : false;
                        obj.sheetWidth = loadSheetObj[i].obj.sheetWidth !== undefined ? loadSheetObj[i].obj.sheetWidth : 0;
                        obj.sheetHeight = loadSheetObj[i].obj.sheetHeight !== undefined ? loadSheetObj[i].obj.sheetHeight : 0;
                        obj.isYoyo = loadSheetObj[i].obj.isYoyo !== undefined ? loadSheetObj[i].obj.isYoyo : false;
                        obj.numFrame = loadSheetObj[i].obj.numFrame !== undefined ? loadSheetObj[i].obj.numFrame : 0;
                        obj.frameCount = loadSheetObj[i].obj.frameCount !== undefined ? loadSheetObj[i].obj.frameCount : 0;
                        obj.collisionBefore = loadSheetObj[i].obj.collisionBefore !== undefined ? loadSheetObj[i].obj.collisionBefore : '';
                        obj.collisionAfter = loadSheetObj[i].obj.collisionAfter !== undefined ? loadSheetObj[i].obj.collisionAfter : '';
                        obj.collisionName = loadSheetObj[i].obj.collisionName !== undefined ? loadSheetObj[i].obj.collisionName : '';
                        obj.collisionOffsetX = loadSheetObj[i].obj.collisionOffsetX !== undefined ? loadSheetObj[i].obj.collisionOffsetX : '0';
                        obj.collisionOffsetY = loadSheetObj[i].obj.collisionOffsetY !== undefined ? loadSheetObj[i].obj.collisionOffsetY : '0';

                        if(obj.collisionName !== '') {
                        this.createCollisionName(obj);
                        }


                        if (loadSheetObj[i].obj.collText === undefined) {
                            obj.collText = '를 눌러 상호작용';
                        } else {
                            obj.collText = '를 눌러 상호작용';
                        }

                        obj.isCreateSprite = true;

                        this.curObjName.name = '';
                        this.setChecked(this.objState, 'default');
                        this.maps.objSprites[objtype] = obj;
                        this.maps.currentObjName[objtype] = objtype;

                        obj.play(objtype);
                    }

                    if (this.curObjRect === null) {
                        this.curObjRect = this.add.graphics();
                        this.curObjRect.depth = 100;
                    }

                    this.curObjectController = this.curObjectController.options(this.maps.currentObjName);
                    this.curObjectController.name("설치한 오브젝트")
                        .onChange(async (value) => {
                            if (value === '') return;
                            this.curObjName.name = value;
                            this.setChecked(this.objState, 'choice', this.objType.obj);
                            this.setChecked(this.videoState, 'default');
                            this.setChecked(this.tileState, 'drag');
                            if (this.choiceObjRect === null) {
                                this.choiceObjRect = this.add.graphics();
                                this.choiceObjRect.depth = 100;
                            }
                            const choiceObj = this.maps.objSprites[value];
                            this.choiceObjRect.clear();
                            this.choiceObjRect.lineStyle(3, 0xffff33, 1);
                            this.choiceObjRect.strokeRect(0, 0, choiceObj.width, choiceObj.height);
                        })
                }, this);

                this.load.start();
            })
    }

    setChecked(state, prop, type) {
        for (let param in state) {
            state[param] = false;
        }

        if (prop !== 'default' && type !== undefined) {
            if (type === 'obj') {
                this.maps.curVideoSprite = null;
                if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                    this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                }

                this.curVideoName.name = ''

            } else if (type === 'video') {
                this.maps.curObjSprite = null;
                if (this.curObjRect !== null) {
                    this.curObjRect.clear();
                }
                if (this.choiceObjRect !== null) {
                    this.choiceObjRect.clear();
                }

                this.curObjName.name = '';
            }
        }

        state[prop] = true;
    }

    reset() {
        if (this.maps.mapSprites) {         //모든 것을 초기화한다.
            for (let type in this.maps.mapSprites) {

                this.maps.mapSprites[type].destroy();
                delete this.maps.mapSprites[type];
                delete this.maps.currentMapName[type];
                this.curMapController = this.curMapController.options(this.maps.currentMapName);
                this.curMapController.name("설치한 배경리스트");

                if (this.map) {
                    this.map.forEachTile((tile) => {
                        if (tile.tileText) {
                            tile.tileText.destroy();

                            delete tile.tileText;
                        }
                    }, this);


                    this.map.destroy();
                    this.map = null;
                }
                if (this.tileJson) {
                    this.tileJson = this.defaultTile;
                }

                this.maps.currentmaplist = '';
                this.maps.mapWidth = 0;
                this.maps.mapHeight = 0;
                this.maps.mapMaxWidth = 0;
                this.maps.mapMaxHeight = 0;

                this.grid.setSize(this.maps.mapWidth, this.maps.mapHeight);
            }

            for (let type in this.maps.objSprites) {
                if (type === '') continue;
                if(this.maps.objSprites[type].domObj) {
                    this.maps.objSprites[type].domObj.destroy();
                }
                this.maps.objSprites[type].destroy();
            }

            this.maps.currentObjName = {};
            this.maps.objSprites = {};

            if (this.choiceObjRect !== null) {
                this.choiceObjRect.clear();
            }

            this.curObjName.name = '';

            this.curObjectController = this.curObjectController.options(this.maps.currentObjName);

            for (let type in this.maps.videoSprites) {
                if (type === '') continue;
                this.maps.videoSprites[type].destroy();
            }

            this.maps.currentVideoName = {};
            this.maps.videoSprites = {};

            this.curVideoName.name = '';

            this.curVideoController = this.curVideoController.options(this.maps.currentVideoName);
        }
    }


    makeMarkerSizeDiv() {
        this.sizeDiv = document.createElement('div');

        const divP = document.createElement('p');
        const button1 = document.createElement('button');
        const button2 = document.createElement('button');
        const button3 = document.createElement('button');
        const buttonP1 = document.createElement('p');
        const buttonP2 = document.createElement('p');
        const buttonP3 = document.createElement('p');

        this.sizeDiv.style.display = 'block';
        this.sizeDiv.style.position = 'absolute';
        this.sizeDiv.style.width = 120 + 'px';
        this.sizeDiv.style.height = 50 + 'px';
        this.sizeDiv.style.left = 50 + '%';
        this.sizeDiv.style.top = 25 + 'px';
        this.sizeDiv.style.backgroundColor = 'rgba(35,35,35,1)';
        this.sizeDiv.style.textAlign = 'center';
        this.sizeDiv.style.transform = 'translate(-50%,-50%)';
        this.sizeDiv.style.zIndex = 1000;
        this.sizeDiv.style.borderRadius = 10 + 'px';
        this.sizeDiv.style.fontSize = 13 + 'px';
        this.sizeDiv.style.padding = 5 + 'px';
        this.sizeDiv.style.color = '#ffffff';
        divP.innerText = 'Marker Size';

        buttonP1.innerText = '1x';
        buttonP2.innerText = '2x';
        buttonP3.innerText = '4x';
        buttonP1.style.color = 'rgba(255,255,255,1)';
        buttonP2.style.color = 'rgba(100,100,100,1)';
        buttonP3.style.color = 'rgba(100,100,100,1)';
        buttonP1.style.fontSize = 12 + 'px';
        buttonP2.style.fontSize = 12 + 'px';
        buttonP3.style.fontSize = 12 + 'px';

        button1.title = 'select';
        button2.title = '';
        button3.title = '';

        button1.style.width = 35 + 'px';
        button2.style.width = 35 + 'px';
        button3.style.width = 35 + 'px';
        button1.style.height = 20 + 'px';
        button2.style.height = 20 + 'px';
        button3.style.height = 20 + 'px';

        button1.style.borderRadius = 5 + 'px';
        button2.style.borderRadius = 5 + 'px';
        button3.style.borderRadius = 5 + 'px';

        button1.style.marginTop = 5 + 'px';
        button2.style.marginTop = 5 + 'px';
        button3.style.marginTop = 5 + 'px';

        button1.appendChild(buttonP1);
        button2.appendChild(buttonP2);
        button3.appendChild(buttonP3);

        this.sizeDiv.appendChild(divP);
        this.sizeDiv.appendChild(button1);
        this.sizeDiv.appendChild(button2);
        this.sizeDiv.appendChild(button3);
        this.curButtonEle = button1;

        document.querySelector("#gamecontainer").appendChild(this.sizeDiv);
    }

    makeEmoji() {
        const emoji = document.createElement('p');
        emoji.classList.add('emoji');

        emoji.style.left = this.pointer.x - this.cameras.main.scrollX + 'px';
        emoji.style.top = this.pointer.y - this.cameras.main.scrollY + 'px';

        emoji.dataX = `${this.pointer.x - this.cameras.main.scrollX}`;
        emoji.dataY = `${this.pointer.y - this.cameras.main.scrollY}`;

        emoji.innerText = '\u{1F603}';

        document.querySelector("#gamecontainer").appendChild(emoji);

        setTimeout(async () => {
            emoji.classList.add('emojistart');
            setTimeout(async () => {
                emoji.remove();
            }, 800);
        }, 1000);
    }

    objDefault(obj) {
        obj.depthAuto = true;
        obj.isWall = false;
        obj.isOverlap = false;
        obj.collState = 'Default';
        obj.saveOffsetX = 0;
        obj.saveOffsetY = 0;
        obj.property = 'default';
        obj.teleportType = '';
        obj.popUpType = '';
        obj.isSpriteSheet = false;
        obj.sheetWidth = 0;
        obj.sheetHeight = 0;
        obj.isYoyo = false;
        obj.numFrame = 0;
        obj.frameCount = 0;
        obj.collText = '';
        obj.collisionBefore = '';
        obj.collisionAfter = '';
        obj.collisionName = '';
        obj.collisionOffsetX = '0';
        obj.collisionOffsetY = '0';


    }


    createVideoFolder() {
        this.videoFolder = this.videoGui.addFolder('Video');

        this.videoFolder.add(this.maps, 'videoname')
            .name('지역명')
            .listen();

        this.videoFolder.add(this.videoSize, 'width')
            .name('너비')
            .listen()
            .onChange((value) => {
                if (!this.videoState.choice || isNaN(value) || this.curVideoName.name === '') return;

                this.maps.videoSprites[this.curVideoName.name].setSize(+value, this.maps.videoSprites[this.curVideoName.name].height);
                this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 1);
            });

        this.videoFolder.add(this.videoSize, 'height')
            .name('높이')
            .listen()
            .onChange((value) => {
                if (!this.videoState.choice || isNaN(value) || this.curVideoName.name === '') return;

                this.maps.videoSprites[this.curVideoName.name].setSize(this.maps.videoSprites[this.curVideoName.name].width, +value);
                this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 1);
            });

        const addButton = {
            add: async () => {
                if (this.maps.videoname === '' || isNaN(this.videoSize.width) || isNaN(this.videoSize.height)) return;

                if (this.maps.currentVideoName[this.maps.videoname]) return;
                let name = this.maps.videoname;

                let obj = this.add.rectangle(0, 0, +this.videoSize.width, +this.videoSize.height, 0x000000, 0.7);
                obj.setStrokeStyle(3, 0xffff33, 1);
                obj.setDepth(1000);
                obj.name = name;
                obj.isVideo = true;
                obj.setInteractive({ draggable: true });

                obj.on('pointerup', (pointer) => {
                    if (!this.videoState.choice || this.isClick) return;

                    if (this.curVideoName.name !== '') {
                        this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                    }

                    this.curVideoName.name = obj.name;

                    obj.setStrokeStyle(3, 0xffff33, 1);
                })

                this.maps.currentVideoName[name] = name;

                this.maps.videoSprites[name] = obj;
                this.maps.curVideoSprite = obj;

                this.curVideoName.name = name;

                this.setChecked(this.videoState, 'default');

                if (this.maps.curObjSprite !== null) {
                    this.maps.curObjSprite = null;
                    this.curObjRect.clear();
                }
                if (this.choiceObjRect !== null) {
                    this.choiceObjRect.clear();
                }
                this.curObjName.name = '';


                this.curVideoController = this.curVideoController.options(this.maps.currentVideoName);
                this.curVideoController.name("생성한 영상 지역")
                    .onChange(async (value) => {
                        if (value === '') return;

                        if (this.curVideoName.name !== '') {
                            this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                        }

                        this.curVideoName.name = value;

                        this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 1);
                        this.setChecked(this.videoState, 'choice', this.objType.video);
                        this.setChecked(this.objState, 'default');
                        this.setChecked(this.tileState, 'drag');
                    })

                this.maps.videoname = '';
            }
        }

        this.videoFolder.add(addButton, 'add')
            .name('지역 추가');

        this.curVideoController = this.videoFolder.add(this.maps, "videolist", this.maps.currentVideoName)
            .name("설치한 영상 지역");


        this.videoFolder.add(this.videoState, 'default')
            .name('Default')
            .listen()
            .onChange(async () => {
                if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                    this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                }

                this.curVideoName.name = '';
                this.setChecked(this.videoState, 'default');
            });

        this.videoFolder.add(this.videoState, 'drag')
            .name('Drag')
            .listen()
            .onChange(async () => {

                if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                    this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                }

                this.curVideoName.name = '';

                this.setChecked(this.videoState, 'drag', this.objType.video);
                this.setChecked(this.objState, 'default');
                this.setChecked(this.tileState, 'drag');
            });

        this.videoFolder.add(this.videoState, 'choice')
            .name('Choice')
            .listen()
            .onChange(async () => {
                this.setChecked(this.videoState, 'choice', this.objType.video);
                this.setChecked(this.objState, 'default');
                this.setChecked(this.tileState, 'drag');
            });

        this.setChecked(this.videoState, 'default');

        this.videoFolder.add(this.curVideoName, 'name')
            .name("선택된 영상 지역")
            .listen();


        const deleteButton = {
            delete: async () => {
                if (this.curVideoName.name === '') return;

                delete this.maps.currentVideoName[this.curVideoName.name];
                this.maps.videoSprites[this.curVideoName.name].destroy();
                delete this.maps.videoSprites[this.curVideoName.name];

                this.curVideoName.name = '';

                this.curVideoController = this.curVideoController.options(this.maps.currentVideoName);
                this.curVideoController.name("설치한 영상 지역")
                    .onChange(async (value) => {
                        if (value === '') return;

                        if (this.curVideoName.name !== '' && this.maps.videoSprites[this.curVideoName.name]) {
                            this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 0);
                        }

                        this.curVideoName.name = value;

                        this.maps.videoSprites[this.curVideoName.name].setStrokeStyle(3, 0xffff33, 1);
                        this.setChecked(this.videoState, 'choice', this.objType.video);
                        this.setChecked(this.objState, 'default');
                        this.setChecked(this.tileState, 'drag');
                    })
            }
        }

        this.videoFolder.add(deleteButton, 'delete')
            .name('선택된 지역 삭제');
    }

    createCollisionName(obj) {
        const collisionName = document.createElement('div');
        collisionName.classList.add("collisionname");

        const collisionLeft = document.createElement('div');
        const collisionText = document.createElement('span');
        const collisionRight = document.createElement('div');

        collisionLeft.classList.add("collisionname_left");
        collisionText.classList.add("collisionname_text");
        collisionRight.classList.add("collisionname_right");

        collisionText.innerText = obj.collisionName;

        collisionName.appendChild(collisionLeft);
        collisionName.appendChild(collisionText);
        collisionName.appendChild(collisionRight);

        document.querySelector("#gamecontainer").appendChild(collisionName);

        const dom = this.add.dom(obj.x + +obj.collisionOffsetX, obj.y + +obj.collisionOffsetY, collisionName)
            .setOrigin(0, 0)
            .setDepth(100);

        obj.domObj = dom;
        obj.domText = collisionText;
        obj.domBox = collisionName;
    }
}