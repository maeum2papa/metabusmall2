class GameScene extends Phaser.Scene {
    static KEY = 'gamescene';
    static MobileKey = {
        left: false,
        right: false,
        up: false,
        down: false,
        space: false,
        KeyF: false
    };

    constructor() {
        super(GameScene.name);
        this.client;
        this.room;
        this.canvas;
        this.UICanvas;
        this.UICanvasCTX;

        this.followObject = null;
        this.followObjectPrePos = {
            x: 0,
            y: 0
        };

        this.followCamera;
        this.darkLayer;
        this.currentTileIndex = 0;
        this.durtaionTime = 0;
        this.durationSec = 2;
        this.IsDurtaion = true;
        this.isAlphaDown = false;
        this.targetAlpha = 0;
        this.darkAlpha = 0.3;
        this.overlapTileCheck = false;
        this.saveTilesIndex = [];

        this.elementVideo;

        this.curDelta = 0;

        this.isLoaded = false;

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

        this.player = null;
        this.collisionPlayer;
        this.otherPlayers = {};
        this.oldPos = {
            x: 0,
            y: 0
        };
        this.inventory;
        this.fruitCount;
        this.statusCount;
        this.isLight = false;
        this.light;
        this.remoteRef;
        this.playerRef;
        this.playerEntities = {};
        this.aGrid;
        this.debug;
        this.frontEndEventObj = [];
        this.fieldObj = [];
        this.saveFrontEndEventObj = [];
        this.debugFieldObj = null;
        this.allObject = [];

        this.FruitsObj = {};
        this.curFruits = null;

        this.wellObj = null;
        this.decoyCount = 0;

        this.map;
        this.layer;
        this.colltile = null;

        // this.fishingUI = {};

        this.fishingUI;
        this.fishingObj;

        this.cloudinfoArr = [];
        this.cloud1Arr = [];
        this.cloud2Arr = [];
        this.cloud3Arr = [];

        this.bgSkys = [];

        this.bgSea = null;
        this.bgSeas = [];
        this.bgSeasFrameTime = 2;       //프레임당

        this.width;
        this.height;

        this.collisionXY = {
            x: 0,
            y: 0
        };
        this.inputPayload = {
            left: false,
            right: false,
            up: false,
            down: false,
            space: false,
            KeyF: false,
            KeyZ: false,
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

        this.loadTest = false;
        this.loadTestTime = '2024/01/05/22:15:00';
        this.LeftAndRight;
        this.UpAndDown;
        this.JumpCheck;
        this.firstCheck = false;
        this.saveTimeDelta = 0;
        this.randomNumber = 0;

        this.cursorKeys;
        this.outlineInstance;

        this.cureentTile;

        this.currentOutlineObj = null;
        this.minDinstace = 9999;

        this.range = 100;

        this.testbar;
        this.testWidth = 0;
        this.testTime = 0;
        this.testDown = true;

        this.bgSkysDebug = {
            debug: false,
            level1: false,
            level2: false,
            level3: false,
        };

        this.pathFinderArrow;
        this.pathTween;
        this.isPathTween = false;

        this.randomTxt = [];

        this.groundFruits = {};



        this.arrParentNode = ["box_wrap", "fishDogam_bg", "tipDogam_bg", "profile_card", "fdCoin", "ms_bg", "statusBox", "waterF_box_bg", "save_land_popup"];

        this.preCameraScoll = {
            scrollX: 0,
            scrollY: 0
        };

        this.seedCount = 0;
        this.isWater = false;
    }

    init() {
        // const protocol = window.location.protocol.replace("http", "ws");
        // console.log(process.env.NODE_ENV);
        // const endpoint = (process.env.NODE_ENV === "production")
        //     ? `wss://mazmorra.io`
        //     : `${protocol}//${window.location.hostname}:2567`;  8000
        //ws://localhost:8000/                  //    

        this.client = new Colyseus.Client(Config.Domain);
    }

    preload() {
    }

    async create() {
        try {
            while (user_Info.otherUser === undefined) {
                await this.sleep(1000);
            }
            // 동접 테스트
            let emergencyEnd = Date.parse(this.loadTestTime);
            let currentTime = Date.now();

            while (currentTime < emergencyEnd) {
                currentTime = Date.now();
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

        //this.sound.pauseOnBlur = false;
        this.sound.add('coin');
        const testsound = this.sound.add('percussion');
        testsound.setLoop(true);

        this.input.keyboard.on('keydown-PAGE_UP', async () => {
            testsound.volume += 0.1;
            if (testsound.volume >= 1) {
                testsound.volume = 1;
            }
        });

        this.input.keyboard.on('keydown-PAGE_DOWN', async () => {
            testsound.volume -= 0.1;
            if (testsound.volume <= 0) {
                testsound.volume = 0;
            }
        });

        if (!this.sound.locked) {
            testsound.play();
        } else {
            this.sound.once(Phaser.Sound.Events.UNLOCKED, () => {
                testsound.play();
            })
        }
        let isPause = false;
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                this.sound.pauseAll();
            } else {
                this.sound.resumeAll();
            }
        })




        // 2024-01-16 jerry JANUS_CLIENT 생성 요청
        globalTransport.get_bridge("WEBRTC_CLIENT_BRIDGE").add_order(WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.INIT_CLIENT, {
            user_Info: user_Info,
            session_id: this.room.sessionId
        });

        let mask = this.make.graphics();
        mask.setDepth(1001);
        mask.setScrollFactor(0);

        this.pathFinderArrow = this.add.image(0, 0, Assets.PATHFINDERARROW).setOrigin(0.5, 0.5);
        this.pathFinderArrow.setAlpha(0);
        this.pathFinderArrow.setDepth(1000);

        // this.testbar = this.add.image(900, 100, 'bar')
        //     .setDepth(1000)
        //     .setOrigin(0, 0)
        //     .setScrollFactor(0);

        // this.testbar.mask = new Phaser.Display.Masks.GeometryMask(this, mask);

        this.canvas = document.querySelector("#gamecontainer canvas");

        this.UICanvas = document.createElement("canvas");
        this.UICanvas.id = "UICanvas";
        this.UICanvas.style.imageRendering = "pixelated";
        this.UICanvas.style.marginLeft = "0px";
        this.UICanvas.style.marginTop = "0px";
        this.UICanvas.style.pointerEvents = 'none';
        this.UICanvasCTX = this.UICanvas.getContext('2d');

        this.darkLayer = this.add.graphics().setBlendMode(Phaser.BlendModes.DIFFERENCE);
        this.darkLayer.setDepth(1000);

        document.querySelector("#gamecontainer").appendChild(this.UICanvas);

        this.game.events.on('hidden', () => {
            this.inputPayload.IsFocus = false;
            this.room.send('input', this.inputPayload);
        }, this);

        this.game.events.on('visible', () => {
            this.inputPayload.IsFocus = true;
        }, this);

        this.cursorKeys = this.input.keyboard.createCursorKeys();
        this.cursorKeys.KeyW = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.W, false);
        this.cursorKeys.KeyA = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.A, false);
        this.cursorKeys.KeyS = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.S, false);
        this.cursorKeys.KeyD = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.D, false);
        this.cursorKeys.KeyF = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.F, false);
        this.cursorKeys.KeyZ = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.Z, false);

        this.outlineInstance = this.plugins.get('rexoutlinepipelineplugin');
        if (user_Info.type === "mobile") {
            this.joyDiv = document.createElement('div');
            this.joyDiv.id = 'joyDiv';

            document.querySelector("#gamecontainer").appendChild(this.joyDiv);

            let left = 170;
            let options = {
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

            // this.joyDiv.style.position = "fixed";
            // document.querySelector("#gamecontainer").appendChild(this.joyDiv);

            // this.joyStick = new JoyStick('joyDiv', {
            //      width: 100,
            //      height: 100,
            //     internalFillColor: "#00AA00",
            //     internalLineWidth: 2,
            //     internalStrokeColor: "#003300",
            //     externalLineWidth: 2,
            //     externalStrokeColor: "#008000",
            //     autoReturnToCenter: true
            // });
            //this.cameras.main.zoom = 0.7132778526552522;            // 모바일 줌 디폴트? 


            this.joyStick.on('move', (evt, data) => {
                this.joyStickCursor.up = Utils.isUp(left - data.position.x, (window.innerHeight - 100) - data.position.y);
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

            document.querySelector(".mylandTop_wrap").style.display = 'none';
            document.querySelector(".myland_chatbox").style.display = 'none';
        }

        // this.input.on('wheel', (pointer, gameObjects, deltaX, deltaY, deltaZ) => {
        //     const newZoom = this.cameras.main.zoom - this.cameras.main.zoom * 0.001 * deltaY;
        //     const Max = 2000;
        //     const Min = this.cameras.main.width < this.cameras.main.height ? this.cameras.main.height : this.cameras.main.width;

        //     const total = Min / Max;
        //     this.cameras.main.zoom = Phaser.Math.Clamp(newZoom, total, 2);

        //     console.log(this.cameras.main.zoom)
        // })


        this.lights.enable();
        this.lights.setAmbientColor(0x808080);

        this.createAnimation();

        if (user_Info.room === "myland_outer") {                    // 마이랜드 결국 오브젝트 클래스로 만들어 관리해야 함.
            await Assets.loadCloudImage(this);        // 구름생성


            {
                let info = {
                    x: 262,
                    y: 404,
                    speed: 0.018,
                    width: 0
                };
                this.cloudinfoArr.push(info);
            }
            {
                let info = {
                    x: 613,
                    y: 196,
                    speed: 0.02,
                    width: 0
                };
                this.cloudinfoArr.push(info);
            }
            {
                let info = {
                    x: 1008,
                    y: 330,
                    speed: 0.022,
                    width: 0
                };
                this.cloudinfoArr.push(info);
            }
            {
                let info = {
                    x: 1681,
                    y: 190,
                    speed: 0.02,
                    width: 0
                };
                this.cloudinfoArr.push(info);
            }
            {
                let info = {
                    x: 2091,
                    y: 147,
                    speed: 0.019,
                    width: 0
                };
                this.cloudinfoArr.push(info);
            }
            {
                let info = {
                    x: 2425,
                    y: 340,
                    speed: 0.02,
                    width: 0
                };
                this.cloudinfoArr.push(info);
            }

            this.load.once('complete', async () => {
                for (let name in Assets.CLOUD) {

                    const cloud = this.add.image(0, 0, name).setOrigin(0.5, 0.5).setDepth(0).setVisible(false);

                    const index = name.substring(name.length - 1, name.length);
                    if (+index === 1) {
                        this.cloud1Arr.push(cloud);
                    } else if (+index === 2) {
                        this.cloud2Arr.push(cloud);
                    } else if (+index === 3) {
                        this.cloud3Arr.push(cloud);
                    } else {
                        cloud.destroy();
                    }
                }
            })

            this.load.start();
        }

        // this.fishingUIImage = new Image();
        // this.fishingUIImage.src = '/static/client/assets/Images/ui/fishingbarsheet.png';
        // this.fishingUIImage.onload = () => {
        //     this.isLoaded = true;
        // }

        // this.fishingUI.maxWidth = 576;
        // this.fishingUI.width = 96;
        // this.fishingUI.widthCount = 0;
        // this.fishingUI.maxHeight = 160;
        // this.fishingUI.height = 160;
        // this.fishingUI.heightCount = 0;
        // this.fishingUI.frameCount = 10;

        // this.fishingUI.draw = (posx, posy, count) => {
        //     if (!this.isLoaded) return;

        //     const x = posx;
        //     const y = posy;
        //     this.fishingUI.widthCount = count;

        //     this.UICanvasCTX.drawImage(this.fishingUIImage,
        //         this.fishingUI.widthCount * this.fishingUI.width, this.fishingUI.heightCount * this.fishingUI.height,
        //         this.fishingUI.width, this.fishingUI.height,
        //         x - (this.fishingUI.width / 2), y - (this.fishingUI.height / 2),
        //         this.fishingUI.width, this.fishingUI.height);
        // }

        //========================debug==============================

        //====================html2canvas=======================

        // html2canvas(document.getElementById("imgDiv")[0], {
        //     logging: false,
        // });

        //====================html2canvas=======================

        //==================단순 none , block========================

        profileCardBtn.addEventListener('click', () => {
            profileCard.style.display = "none";
        })

        this.input.keyboard.on('keydown-ENTER', async () => {
            saveLandPopup.style.display = "none";
            UIManager.getInstance().removeElement(saveLandPopup);
        }, this)

        statusBtn.addEventListener("click", () => {
            window.top.postMessage({ info: 'pageChange', href: '/cmall/activity' }, '*');
        });

        statusPopupClose.addEventListener("click", () => {
            statusPopup.style.display = "none";
            UIManager.getInstance().removeElement(statusPopup);
        });

        saveLandPopupBtn.addEventListener("click", () => {
            saveLandPopup.style.display = "none";
            UIManager.getInstance().removeElement(saveLandPopup);
        })


        for (let i = 0; i < mo_fruit_btns.length; ++i) {
            mo_fruit_btns[i].addEventListener("click", () => {
                if (statusPopup.style.display === "block") {
                    statusPopup.style.display = "none";
                    UIManager.getInstance().removeElement(statusPopup);
                } else {
                    statusPopup.style.display = "block";
                    UIManager.getInstance().setElement(statusPopup);
                }
            });
        }

        for (let i = 0; i < mo_inven_btns.length; ++i) {
            mo_inven_btns[i].addEventListener("click", () => {
                if (this.inventory) {
                    this.inventory.invenShown();
                }
            });
        }




        coinCloseBtn.addEventListener("click", () => {
            coinPopup.style.display = 'none';
            UIManager.getInstance().removeElement(coinPopup);
        })

        waterFPopup_Close.addEventListener("click", () => {
            waterFBoxBg.style.display = "none";
            UIManager.getInstance().removeElement(waterFBoxBg);
        })

        if (user_Info.type === "mobile") {
            waterButton.addEventListener("touchstart", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon-hover").style.opacity = '1';
            })
            waterButton.addEventListener("click", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '1';
                waterButton.querySelector("#W_use_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon-hover").style.opacity = '0';

                if (+waterBoxCount.innerText <= 0 || this.curFruits === null) return;

                const Info = {
                    index: this.curFruits.index,
                    id: this.player.id,
                    type: "Water"
                };
                this.room.send('applyFertilizer', Info);
            })

            waterButton.addEventListener("touchend", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '1';
                waterButton.querySelector("#W_use_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon-hover").style.opacity = '0';
            })


            //fer ---------------
            fertilizerButton.addEventListener("touchstart", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon-hover").style.opacity = '1';
            })

            fertilizerButton.addEventListener("click", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '1';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon-hover").style.opacity = '0';

                if (+fertilizerBoxCount.innerText <= 0 || this.curFruits === null) return;

                const Info = {
                    index: this.curFruits.index,
                    id: this.player.id,
                    type: "Fertilizer"
                };
                this.room.send('applyFertilizer', Info);
            })

            fertilizerButton.addEventListener("touchend", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '1';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon-hover").style.opacity = '0';
            })

        } else {
            waterButton.addEventListener("mousedown", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon-hover").style.opacity = '1';
            })

            waterButton.addEventListener("click", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon").style.opacity = '1';
                waterButton.querySelector("#W_use_icon-hover").style.opacity = '0';

                if (+waterBoxCount.innerText <= 0 || this.curFruits === null) return;

                const Info = {
                    index: this.curFruits.index,
                    id: this.player.id,
                    type: "Water"
                };
                this.room.send('applyFertilizer', Info);
            })

            waterButton.addEventListener("mouseover", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon").style.opacity = '1';
            })

            waterButton.addEventListener("mouseout", () => {
                waterButton.querySelector("#W_none_icon").style.opacity = '1';
                waterButton.querySelector("#W_use_icon").style.opacity = '0';
                waterButton.querySelector("#W_use_icon-hover").style.opacity = '0';
            })



            //===
            fertilizerButton.addEventListener("mousedown", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon-hover").style.opacity = '1';
            })

            fertilizerButton.addEventListener("click", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '1';
                fertilizerButton.querySelector("#W_use_icon-hover").style.opacity = '0';

                if (+fertilizerBoxCount.innerText <= 0 || this.curFruits === null) return;

                const Info = {
                    index: this.curFruits.index,
                    id: this.player.id,
                    type: "Fertilizer"
                };
                this.room.send('applyFertilizer', Info);
            })

            fertilizerButton.addEventListener("mouseover", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '1';
            })

            fertilizerButton.addEventListener("mouseout", () => {
                fertilizerButton.querySelector("#W_none_icon").style.opacity = '1';
                fertilizerButton.querySelector("#W_use_icon").style.opacity = '0';
                fertilizerButton.querySelector("#W_use_icon-hover").style.opacity = '0';
            })
        }

        this.input.keyboard.on('keydown-I', async () => {
            if (document.activeElement === chatInput || document.activeElement === moChatInput || updateBox.style.display === 'block') return;

            if (this.inventory) {
                this.inventory.invenShown();
            }
        }, this)


        this.input.keyboard.on('keydown-G', async () => {
            if (document.activeElement === chatInput || document.activeElement === moChatInput || updateBox.style.display === 'block') return;

            if (fishDogamBg.style.display === "block") {
                fishDogamBg.style.display = "none";
                UIManager.getInstance().removeElement(fishDogamBg);

            } else {
                fishDogamBg.style.display = "block";
                UIManager.getInstance().setElement(fishDogamBg);
            }
        }, this);


        fishDogamBgClose_btn.addEventListener('click', () => {
            fishDogamBg.style.display = "none";
            UIManager.getInstance().removeElement(fishDogamBg);

        })

        document.addEventListener('click', (e) => {
            let event = e;
            for (let i = 0; i < this.arrParentNode.length; ++i) {
                if (event.target.classList.contains(this.arrParentNode[i]) || event.target.id === this.arrParentNode[i]) {
                    if (event.target.classList.contains("box_wrap")) return;
                    UIManager.getInstance().selectElement(event);
                    return;
                }
            }
            event = event.target.parentNode;

            while (true) {

                if (event.classList.contains("gamecontainer") || event.classList.contains("box") || event.tagName === "BODY") break;

                for (let i = 0; i < this.arrParentNode.length; ++i) {
                    if (event.classList.contains(this.arrParentNode[i]) || event.id === this.arrParentNode[i]) {
                        UIManager.getInstance().selectElement(event);
                        return;
                    }
                }

                let parent = event.parentNode;
                event = parent;
            }
        })

        this.input.keyboard.on('keydown-ESC', async () => {
            UIManager.getInstance().popBackElement();
        }, this);

        {
            let fishDogamBgDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const fishDogamBgWidth = fishDogamBg.style.width.substring(0, fishDogamBg.style.width.length - 2);
            const fishDogamBgHeight = fishDogamBg.style.height.substring(0, fishDogamBg.style.height.length - 2);

            fishDogamBg.addEventListener('mousedown', (e) => {
                UIManager.getInstance().selectElement(fishDogamBg);
                if (e.target !== fishDogamBg && e.target.innerText !== "물고기 도감") return;

                fishDogamBgDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = fishDogamBg.offsetLeft;
                originTop = fishDogamBg.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                fishDogamBgDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (fishDogamBgDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+fishDogamBgWidth / 2);
                    const OutYPos = window.innerHeight - (+fishDogamBgHeight / 2);

                    fishDogamBg.style.left = `${Math.min(Math.max(+fishDogamBgWidth / 2, originLeft + diffX), OutXPos)}px`;
                    fishDogamBg.style.top = `${Math.min(Math.max((+fishDogamBgHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }

        {
            let tipDogamDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const tipDogamWidth = tipDogam.style.width.substring(0, tipDogam.style.width.length - 2);
            const tipDogamHeight = tipDogam.style.height.substring(0, tipDogam.style.height.length - 2);

            tipDogam.addEventListener('mousedown', (e) => {
                UIManager.getInstance().setElement(tipDogam);
                if (e.target !== tipDogam && e.target.innerText !== "TIP 도감") return;

                tipDogamDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = tipDogam.offsetLeft;
                originTop = tipDogam.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                tipDogamDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (tipDogamDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+tipDogamWidth / 2);
                    const OutYPos = window.innerHeight - (+tipDogamHeight / 2);

                    tipDogam.style.left = `${Math.min(Math.max(+tipDogamWidth / 2, originLeft + diffX), OutXPos)}px`;
                    tipDogam.style.top = `${Math.min(Math.max((+tipDogamHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }

        {
            let tipDogamPopupDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const tipDogamPopupWidth = tipDogamPopup.style.width.substring(0, tipDogamPopup.style.width.length - 2);
            const tipDogamPopupHeight = tipDogamPopup.style.height.substring(0, tipDogamPopup.style.height.length - 2);

            tipDogamPopup.addEventListener('mousedown', (e) => {
                UIManager.getInstance().setElement(tipDogamPopup);

                tipDogamPopupDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = tipDogamPopup.offsetLeft;
                originTop = tipDogamPopup.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                tipDogamPopupDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (tipDogamPopupDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+tipDogamPopupWidth / 2);
                    const OutYPos = window.innerHeight - (+tipDogamPopupHeight / 2);

                    tipDogamPopup.style.left = `${Math.min(Math.max(+tipDogamPopupWidth / 2, originLeft + diffX), OutXPos)}px`;
                    tipDogamPopup.style.top = `${Math.min(Math.max((+tipDogamPopupHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }

        {
            let statusPopupDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const statusPopupWidth = statusPopup.style.width.substring(0, statusPopup.style.width.length - 2);
            const statusPopupHeight = statusPopup.style.height.substring(0, statusPopup.style.height.length - 2);

            statusPopup.addEventListener('mousedown', (e) => {
                UIManager.getInstance().selectElement(statusPopup);

                // if (e.target !== statusPopup && e.target.innerText !== '현재 보유한 아이템') return;

                statusPopupDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = statusPopup.offsetLeft;
                originTop = statusPopup.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                statusPopupDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (statusPopupDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+statusPopupWidth / 2);
                    const OutYPos = window.innerHeight - (+statusPopupHeight / 2);

                    statusPopup.style.left = `${Math.min(Math.max(+statusPopupWidth / 2, originLeft + diffX), OutXPos)}px`;
                    statusPopup.style.top = `${Math.min(Math.max((+statusPopupHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }


        {
            let coinPopupDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const coinPopupWidth = coinPopup.style.width.substring(0, coinPopup.style.width.length - 2);
            const coinPopupHeight = coinPopup.style.height.substring(0, coinPopup.style.height.length - 2);

            coinPopup.addEventListener('mousedown', (e) => {
                UIManager.getInstance().selectElement(coinPopup);

                if (e.target !== coinPopup && e.target.innerText !== '현재 보유한 아이템') return;

                coinPopupDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = coinPopup.offsetLeft;
                originTop = coinPopup.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                coinPopupDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (coinPopupDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+coinPopupWidth / 2);
                    const OutYPos = window.innerHeight - (+coinPopupHeight / 2);

                    coinPopup.style.left = `${Math.min(Math.max(+coinPopupWidth / 2, originLeft + diffX), OutXPos)}px`;
                    coinPopup.style.top = `${Math.min(Math.max((+coinPopupHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }

        {
            let waterFBoxBgDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const waterFBoxBgWidth = waterFBoxBg.style.width.substring(0, waterFBoxBg.style.width.length - 2);
            const waterFBoxBgHeight = waterFBoxBg.style.height.substring(0, waterFBoxBg.style.height.length - 2);

            waterFBoxBg.addEventListener('mousedown', (e) => {
                UIManager.getInstance().selectElement(waterFBoxBg);

                if (e.target !== waterFBoxBg && e.target.innerText !== '현재 보유한 아이템') return;

                waterFBoxBgDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = waterFBoxBg.offsetLeft;
                originTop = waterFBoxBg.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                waterFBoxBgDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (waterFBoxBgDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+waterFBoxBgWidth / 2);
                    const OutYPos = window.innerHeight - (+waterFBoxBgHeight / 2);

                    waterFBoxBg.style.left = `${Math.min(Math.max(+waterFBoxBgWidth / 2, originLeft + diffX), OutXPos)}px`;
                    waterFBoxBg.style.top = `${Math.min(Math.max((+waterFBoxBgHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }

        {
            let saveLandPopupDrag = false;
            let originX = false;
            let originY = false;
            let originLeft = false;
            let originTop = false;

            const saveLandPopupWidth = saveLandPopup.style.width.substring(0, saveLandPopup.style.width.length - 2);
            const saveLandPopupHeight = saveLandPopup.style.height.substring(0, saveLandPopup.style.height.length - 2);

            saveLandPopup.addEventListener('mousedown', (e) => {
                UIManager.getInstance().selectElement(saveLandPopup);

                saveLandPopupDrag = true;
                originX = e.clientX;
                originY = e.clientY;
                originLeft = saveLandPopup.offsetLeft;
                originTop = saveLandPopup.offsetTop;
            });

            document.addEventListener('mouseup', (e) => {
                saveLandPopupDrag = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (saveLandPopupDrag) {
                    const diffX = e.clientX - originX;
                    const diffY = e.clientY - originY;

                    const OutXPos = window.innerWidth - (+saveLandPopupWidth / 2);
                    const OutYPos = window.innerHeight - (+saveLandPopupHeight / 2);

                    saveLandPopup.style.left = `${Math.min(Math.max(+saveLandPopupWidth / 2, originLeft + diffX), OutXPos)}px`;
                    saveLandPopup.style.top = `${Math.min(Math.max((+saveLandPopupHeight / 2), originTop + diffY), OutYPos)}px`;
                }
            });
        }

        //==



        mo_sidebar.addEventListener("click", function () {
            let isShow = land_top_box_wrap.classList.toggle('show');
            land_bot_box_wrap.classList.toggle('show');

            mo_sidebar.classList.toggle('toggle');
            mo_sidebar_v.classList.toggle('toggle');

            window.top.postMessage({ info: 'mobileShow', isShow: isShow }, '*');
        });

        mo_sidebar_v.addEventListener("click", function () {
            let isShow = land_top_box_wrap.classList.toggle('show');

            land_bot_box_wrap.classList.toggle('show');

            mo_sidebar.classList.toggle('toggle');
            mo_sidebar_v.classList.toggle('toggle');

            window.top.postMessage({ info: 'mobileShow', isShow: isShow }, '*');
        });

        // 채팅 버튼을 눌렀을 때 
        mo_chat_btn.addEventListener("click", function () {
            land_bot_btn_box.classList.add('dn');
            land_bot_chat_box_wrap.classList.remove('dn');
        });

        mo_chat_btn_close.addEventListener("click", function () {
            land_bot_btn_box.classList.remove('dn');
            land_bot_chat_box_wrap.classList.add('dn');
        });

        mo_chat_close.addEventListener("click", function () {
            land_bot_btn_box.classList.remove('dn');
            land_bot_chat_box_wrap.classList.add('dn');
        });


        tipDogamClose.addEventListener("click", () => {
            tipDogam.style.display = 'none';
            tipDogamPopup.style.display = 'none';

            UIManager.getInstance().removeElement(tipDogam);
            UIManager.getInstance().removeElement(tipDogamPopup);
        });

        tipDogamPopupClose.addEventListener("click", () => {
            tipDogamPopup.style.display = 'none';
            UIManager.getInstance().removeElement(tipDogamPopup);
        });

        statusList.addEventListener("click", (e) => {
            if (e.target.parentNode.classList.contains("mlt-reward")) {            //활동보상
                if (statusPopup.style.display === "block") {
                    statusPopup.style.display = "none";
                    UIManager.getInstance().removeElement(statusPopup);
                } else {
                    statusPopup.style.display = "block";
                    UIManager.getInstance().setElement(statusPopup);
                }
            } else if (e.target.parentNode.classList.contains("mlt-inventory")) {  //인벤토리
                if (this.inventory) {
                    this.inventory.invenShown();
                }
            } else if (e.target.parentNode.classList.contains("mlt-messageBox")) { //쪽지함

            } else if (e.target.parentNode.classList.contains("mlt-staffList")) {  //직원목록

            } else if (e.target.parentNode.classList.contains("mlt-setting")) {    //설정

            }

        });

        // this.input.on('pointerdown', async () => {
        //     if (document.activeElement === document.body) {
        //         const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);

        //         await GameManager.getInstance().pathFinding(this, this.collisionPlayer, worldPoint);

        //         if (this.pathTween) {
        //             this.pathTween.stop();
        //             this.isPathTween = false;
        //         }

        //        const node = GameManager.getInstance().finalNodeList[GameManager.getInstance().finalNodeList.length - 1];

        //         let finalX = this.map.tileToWorldX(node.x) + 16;
        //         let finalY = this.map.tileToWorldY(node.y);

        //         this.pathFinderArrow.x = finalX;
        //         this.pathFinderArrow.y = finalY;
        //         this.pathFinderArrow.setAlpha(1);
        //     }
        // });

        this.canvas.addEventListener('click', async (e) => {
            this.canvas.focus();
            ChatManager.getInstance().blur();
        });

        this.canvas.addEventListener('dblclick', () => {
            if (GameManager.getInstance().isFind) return;


            const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);
            this.player.sprite.x = worldPoint.x;
            this.player.sprite.y = worldPoint.y;
            let starttime = Date.now();
            let info = {
                date: new Date(),
                startTime: JSON.stringify(starttime),
                type: "game",
                type2: "send",
                content: "move",
                x: this.player.sprite.x,
                y: this.player.sprite.y
            }

            this.room.send('teleport', info);
        });

        this.input.on('pointerdown', async (pointer, gameObject) => {
            if (!pointer.rightButtonDown() && user_Info.type !== "mobile") return;
            if (gameObject.length > 0) {
                const obj = gameObject[0];
                if (obj.nickname !== this.player.sprite.nickname) {
                    this.followObject = obj;
                    return;
                }
            }

            const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);

            await GameManager.getInstance().pathFinding(this, this.collisionPlayer, worldPoint);
            //GameManager.getInstance().draw(this);

            if (this.pathTween) {
                this.pathTween.stop();
                this.isPathTween = false;
            }

            const node = GameManager.getInstance().finalNodeList[GameManager.getInstance().finalNodeList.length - 1];

            let finalX = this.map.tileToWorldX(node.x) + 16;
            let finalY = this.map.tileToWorldY(node.y);

            this.pathFinderArrow.x = finalX;
            this.pathFinderArrow.y = finalY;
            this.pathFinderArrow.setAlpha(1);

            this.followReset();
        })

        this.emojiKeyDownEvent();

        //===================================================DEBUGKEY===================================================
        this.input.keyboard.on('keydown-H', async () => {
            if (document.activeElement === chatInput || document.activeElement === moChatInput || updateBox.style.display === 'block') return;

            let info = {
                isFishing: true
            };
            this.room.send('fishing', info);

        }, this);

        this.input.keyboard.on('keydown-P', async () => {
            if (document.activeElement === chatInput || document.activeElement === moChatInput || updateBox.style.display === 'block') return;

            if (profileCard.style.display === "block") {
                profileCard.style.display = "none";
                UIManager.getInstance().removeElement(profileCard);

            } else {
                profileCard.style.display = "block";
                UIManager.getInstance().setElement(profileCard);
            }

        }, this)


        this.input.keyboard.on('keydown-NINE', async () => {                       // 룸이동할건데 나중에 타일이나 충돌시 이동할 수 있는 오브젝트의 설정이나 값을 주고 충돌시 뭐 하면 될 것 같다.
            // let hr = '/land/office';
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

        this.input.keyboard.on('keydown-O', async () => {
            if (document.activeElement === chatInput || document.activeElement === moChatInput || updateBox.style.display === 'block') return;

            if (waterFBoxBg.style.display === 'block') {
                waterFBoxBg.style.display = "none";
                UIManager.getInstance().removeElement(waterFBoxBg);

            } else {
                waterFBoxBg.style.display = "block";
                UIManager.getInstance().setElement(waterFBoxBg);
            }

        }, this);

        // this.input.keyboard.on('keydown-V', () => {
        //     console.log('csvSave');
        //     this.room.send('csvSave');
        // }, this);

        // this.input.on('pointerdown', (p) => {
        //     //if (user_Info.type === "mobile") return;
        //     //if(!p.rightButtonDown()) return;

        // }, this);

        this.input.keyboard.on('keydown-T', async () => {
            if (document.activeElement === chatInput || document.activeElement === moChatInput || updateBox.style.display === 'block') return;

            if (tipDogam.style.display === 'block') {
                tipDogam.style.display = 'none';
                tipDogamPopup.style.display = 'none';
                UIManager.getInstance().removeElement(tipDogam);

            } else {
                tipDogam.style.display = 'block';
                UIManager.getInstance().setElement(tipDogam);

            }
        }, this);

        // this.input.keyboard.on('keydown-R', async () => {
        //     const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);

        //     await GameManager.getInstance().pathFinding(this, this.collisionPlayer, worldPoint);
        //     GameManager.getInstance().draw(this);

        //     if (this.pathTween) {
        //         this.pathTween.stop();
        //         this.isPathTween = false;
        //     }

        //     const node = GameManager.getInstance().finalNodeList[GameManager.getInstance().finalNodeList.length - 1];

        //     let finalX = this.map.tileToWorldX(node.x) + 16;
        //     let finalY = this.map.tileToWorldY(node.y);

        //     this.pathFinderArrow.x = finalX;
        //     this.pathFinderArrow.y = finalY;
        //     this.pathFinderArrow.setAlpha(1);
        // })


        this.input.keyboard.on('keydown-NUMPAD_ONE', async () => {
            this.bgSkysDebug.debug = true;
            this.bgSkysDebug.level1 = true;
            this.bgSkysDebug.level2 = false;
            this.bgSkysDebug.level3 = false;
        }, this);
        this.input.keyboard.on('keydown-NUMPAD_TWO', async () => {
            this.bgSkysDebug.debug = true;
            this.bgSkysDebug.level1 = false;
            this.bgSkysDebug.level2 = true;
            this.bgSkysDebug.level3 = false;
        }, this);
        this.input.keyboard.on('keydown-NUMPAD_THREE', async () => {
            this.bgSkysDebug.debug = true;
            this.bgSkysDebug.level1 = false;
            this.bgSkysDebug.level2 = false;
            this.bgSkysDebug.level3 = true;
            this.isLight = false;
        }, this);

        this.input.keyboard.on('keydown-NUMPAD_FOUR', async () => {
            let info = {
                index: 0,
                id: this.player.id
            };

            this.room.send('levelUpFruit', info);
        }, this);

        this.input.keyboard.on('keydown-NUMPAD_FIVE', async () => {
            let info = {
                index: 1,
                id: this.player.id
            };

            this.room.send('levelUpFruit', info);
        }, this);

        this.input.keyboard.on('keydown-NUMPAD_NINE', async () => {
            const worldPoint = this.input.activePointer.positionToCamera(this.cameras.main);
            const pointerTileX = this.map.worldToTileX(worldPoint.x);
            const pointerTileY = this.map.worldToTileY(worldPoint.y);

            const posX = this.map.tileToWorldX(pointerTileX);
            const posY = this.map.tileToWorldY(pointerTileY);

            console.log(posX, posY);

            let info = `${this.randomTxt.length}: {x: ${posX}, y: ${posY}}\n`;
            this.randomTxt.push(info);

            window.navigator.clipboard.writeText(this.randomTxt).then(() => { });
        }, this);


        // this.input.keyboard.on('keydown-R', async () => {
        //     let info = {
        //         table: "cb_member",
        //         cul:"ing_furniture",
        //         param:''
        //     };

        //     this.room.send('reset', info);
        //     console.log('reset');

        // }, this);



        //===================================================DEBUGKEY===================================================

        //==================단순 none , block========================



        let Isload = false;
        this.room.onMessage('fileload', async (arr) => {
            await Assets.loadPlayersheet(this, arr.arrName);                           //나중에 json경로도 서버에서 전달하는게 좋을듯? 에디터 나 시트 등록하면 만들어지게 해야겠네.
            await Assets.loadEffectsheet(this, arr.arrEffect);                           //나중에 json경로도 서버에서 전달하는게 좋을듯? 에디터 나 시트 등록하면 만들어지게 해야겠네.

            this.load.animation('defaultPlayer', 'static/client/assets/Json/player_animation.json');
            this.load.animation('defaultEffect', 'static/client/assets/Json/effect_animation.json');

            await this.load.tilemapTiledJSON(arr.arrMap.tile.name, arr.arrMap.tile.route);
            // await Assets.loadTypeImage(this, arr.arrMap.object);
            await Assets.loadObjOrSheetImage(this, arr.arrMap.object);

            await Assets.loadImage(this, arr.arrFurniture);
            await Assets.loadImage(this, arr.arrMap.background);

            this.load.once('complete', async () => {
                this.map = this.make.tilemap({ key: arr.arrMap.tile.name });

                const tiles = await this.map.addTilesetImage(Assets.TILEBLACK);
                this.layer = await this.map.createLayer('Tile Layer 1', tiles, 0, 0);

                let arrtile = [];
                for (let i = 0; i < this.map.layers[0].data.length; ++i) {
                    for (let j = 0; j < this.map.layers[0].data[i].length; ++j) {
                        this.map.layers[0].data[i][j].alpha = 0;

                        // if (this.map.layers[0].data[i][j].index !== 1 && this.map.layers[0].data[i][j].index !== 83) {
                        //     console.log(this.map.layers[0].data[i][j].index)
                        //     arrtile.push(this.map.layers[0].data[i][j]);
                        // }
                    }
                }

                // this.colltile = arrtile;
                this.colltile = this.map.filterTiles(tile => (tile.index !== 1 && tile.index !== 83 && tile.index !== 84 && tile.index !== 2));

                for (let i = 0; i < arr.arrMap.background.length; ++i) {

                    if (-1 !== arr.arrMap.background[i].name.indexOf('Sea')) {
                        let keyInfo = {
                            key: arr.arrMap.background[i].name
                        };

                        this.bgSeas.push(keyInfo);
                    } else {
                        const background = new Background(this, arr.arrMap.background[i].name, arr.arrMap.background[i].depth);

                        if (-1 !== arr.arrMap.background[i].name.indexOf('Sky')) {
                            this.bgSkys.push(background);
                        }

                        this.allObject.push(background.image);
                    }
                }

                if (this.bgSeas.length !== 0) {
                    this.anims.create({
                        key: 'Sea',
                        frames: this.bgSeas,
                        frameRate: this.bgSeasFrameTime,
                        repeat: -1
                    });

                    this.bgSea = this.add.sprite(0, 0, this.bgSeas[0].key).setOrigin(0, 0)
                        .play('Sea');
                }

                if (arr.arrVideo) {
                    //     this.elementVideo = new ElementVideo(this, arr.arrVideo);
                }
                this.width = arr.arrMap.width;
                this.height = arr.arrMap.height;

                Isload = true;
            }, this);

            this.load.start();

            this.inventory = new Inventory(this, arr.arrInven);

            this.statusCount = new StatusCount();
        });

        this.room.onMessage('logSend', async (infos) => {
            let info = infos;
            let data = info;
            data.currentUserId = this.player.id;
            data.currentRoom = user_Info.otherUser;
            // let data = {
            //     type: info.type,
            //     currentUserId: this.player.id,
            //     currentRoom: user_Info.otherUser            // 왜 이렇게 했지;  data = infos;    >>> data.currentUser 하면 되는데
            // };

            // 나중에 반복적인 문들은 묶어야함 
            if (data.type === 'baitDecoy') {         // 지렁이 쓰기             
                data.count = +info.count;
                data.total = +info.total;
                this.decoyCount = +info.total;
            } else if (data.type === 'getDecoy') {   // 지렁이 획득
                data.count = +info.count;
                data.total = +info.total;
                this.decoyCount = +info.total;
            } else if (data.type === 'getFruit') {   // 열매 획득
                data.count = +info.count;
                data.total = +info.total;
                if (user_Info.type === "mobile") {
                    this.fruitCount.count = info.total;
                    window.top.postMessage({ info: 'fruitCount', count: this.fruitCount.count }, '*');
                }
            } else if (data.type === 'plantSeed') {  //씨앗 쓰기 (심기)
                data.total = +info.total;
            } else if (data.type === 'getSeed') {    //씨앗 획득
                data.total = +info.total;
            } else if (data.type === 'spreadFertilizer') {   // 비료 쓰기 (뿌리기)
                data.total = +info.total;
            } else if (data.type === 'getFertilizer') {      // 비료 획득
                data.total = +info.total;
            } else if (data.type === 'spreadWater') {      // 물 쓰기 (뿌리기)
                data.total = +info.total;
            } else if (data.type === 'getWater') {      // 물 획득
                data.total = +info.total;
                data.name = info.name;
            } else if (data.type === 'getFish') {       //생선 획득
                data.fishName = info.fishName;
                data.index = info.index;
                MissionManager.getInstance().updateFishBook(data);
            } else if (data.type === 'getTrash') {     //쓰레기 획득
                data.route = '/seum_img/ui/trash.png';
            } else if (data.type === 'getBottle') {     //유리병 획득
                data.route = '/seum_img/ui/glass.png';
            } else if (data.type === 'getFruitFishing') {    //열매 획득

                data.count = +info.count;
                data.total = +info.total;
                if (user_Info.type === "mobile") {
                    this.fruitCount.count = info.total;
                    window.top.postMessage({ info: 'fruitCount', count: this.fruitCount.count }, '*');
                }
                data.route = '/seum_img/ui/fruiticon.png';
            }

            ChatManager.getInstance().activitySend(data);

            if (data.type === 'petSeed') return; //펫 씨앗 획득

            if (data.type.indexOf('getFish') === -1 && data.type.indexOf('Trash') === -1 && data.type.indexOf('Bottle') === -1) {

                let type = '';

                for (let i = 0; i < data.type.length; ++i) {
                    if (data.type[i] === data.type[i].toUpperCase()) {
                        type = data.type.substring(i, data.type.length).toLowerCase();
                        break;
                    }
                }
                this.statusCount.countUpdate(type, +data.total);
                if (data.type.indexOf('getFruitFishing') !== -1) {
                    PopUpManager.getInstance().makeFishPopUp(data);
                }
            } else {
                PopUpManager.getInstance().makeFishPopUp(data);
            }
        });

       

        this.room.onMessage('countUpdate', async (info) => {
            if (info.type === "decoy") {
                this.decoyCount = +info.count;
            }

            this.statusCount.countUpdate(info.type, +info.count);
        });

        this.room.onMessage('petSeed', async (count) => {
            this.seedCount = count;
            
        });

        this.room.onMessage('isPossibleWater', async (iswater) => {
            this.isWater = iswater;
        });

        this.room.onMessage('myTipList', async (arrTip) => {
            PopUpManager.getInstance().makeTipPopup(arrTip);
        });

        
        //========================Backgroud, Object=============================

        //========================Player=============================


        this.room.state.players.onAdd(async (player, sessionId) => {
            while (!Isload) {
                await this.sleep(1000);
            }

            const newPlayer = new Player(this, player.x, player.y, player.speed, player.depth, player.name, player.id, player.title, player.depart, player.parts, player.myWater, player.anyWater, player.badge);
            const entity = newPlayer.sprite;
            newPlayer.init(player.subDepth, player.sitOrLie);

            this.playerEntities[sessionId] = entity;

            entity.setData('serverX', player.x);
            entity.setData('serverY', player.y);

            const remoteRef = this.add.rectangle(player.x, player.y, this.range, this.range);
            //remoteRef.setStrokeStyle(1, 0xff000);
            remoteRef.depth = 100;

            entity.remoteRef = remoteRef;

            if (sessionId === this.room.sessionId) {                     // 나 일때 초기 설정   
                this.player = newPlayer;
                ObjectManager.getInstance().setObject(newPlayer);

                const chatManager = ChatManager.getInstance();
                chatManager.init(player.name);
                chatManager.create(player.curRoom, loaded);

                function loaded() {
                    loading.style.display = "none";
                    
                }
                Box.style.display = "block";
                if (user_Info.type === 'desktop') {
                    chatBox.style.display = "block";
                }
                if (this.seedCount !== 0) {
                    PopUpManager.getInstance().makeTestPopup(`펫이 씨앗 ${this.seedCount}개를 획득..Test`);
                }

                profileImg.src = `/preview/${this.player.id}_preview.png?v=${new Date().getTime()}`;
                statusUI.querySelector('.mltP_btm #mltP_name').innerText = this.player.name;
                statusUI.querySelector('.mltP_btm #mltP_position').innerText = player.title;
                this.fishingUI = new FishingUI(this, player.x, player.y);

                //this.light = this.lights.addLight(0, 0, 100).setIntensity(1);

                this.player.sprite.setCollideWorldBounds(true);

                this.followCamera = this.add.rectangle(player.x, player.y, 0, 0).setAlpha(0);

                this.cameras.main.setBounds(0, 0, this.width, this.height);              // 맵파일 사이즈만큼 해야 함. 서버에서 맵 정보를 받아와야 함.
                this.physics.world.setBounds(0, 0, this.width, this.height);
                this.cameras.main.startFollow(this.followCamera, true, 1, 1);

                // 0.05
                this.physics.add.overlap(entity, this.frontEndEventObj, this.collect, null, this);

                this.fruitCount = new FruitCount(this, player.fruit);
                this.statusCount.countUpdate('fruit', player.fruit);
                this.inventory.curWearableParts = this.player.playerParts;

                this.collisionPlayer = this.add.rectangle(player.x, player.y + (entity.height / 2), 32, 32);
                //this.collisionPlayer.setStrokeStyle(2, 0x1a65ac);
                this.physics.add.existing(this.collisionPlayer);
                //==================DEBUG=====================
                // this.remoteRef = this.add.rectangle(player.x, player.y + (96 / 2),32, 32);
                // this.remoteRef.setStrokeStyle(1, 0xff000);

                //  this.playerRef = this.add.rectangle(player.x, player.y,player.width, player.height);
                //  this.playerRef.setStrokeStyle(2, 0xffffff);
                //==================DEBUG=====================

                this.preCameraScoll.scrollX = this.cameras.main.scrollX;
                this.preCameraScoll.scrollY = this.cameras.main.scrollY;

                player.onChange(() => {                 // 자신 동기화
                    this.player.isFishing = player.isFishing;
                    this.player.myWater = player.myWater;
                    this.player.anyWater = player.anyWater;

                    if (!player.isFishing) {
                        this.fishingUI.end();
                        // this.fishingUIImage.alpha = 0;
                    }
                })

                player.parts.onAdd(async (part, index) => {
                    part.onChange(() => {

                        this.player.addPlayerPart(this, part);
                    })
                })
                player.parts.onChange(() => {
                    this.player.checkRemoveParts(this, player.parts);
                })

            } else {
                this.otherPlayers[sessionId] = newPlayer;
                entity.anims.play('9999' + '_' + player.state, true);


                if (player.state === Player.DANCE_RIGHT) {
                    entity.setScale(-1, 1);
                } else {
                    entity.setScale(1, 1);
                }

                player.onChange(() => {                 //다른 사용자 동기화
                    entity.setData('serverX', player.x);
                    entity.setData('serverY', player.y);

                    // let timeStamp = +new Date();

                    // let pos = {
                    //     x : 0,
                    //     y : 0
                    // };
                    // pos.x = player.x;
                    // pos.y = player.y;

                    // this.otherPlayers[sessionId].positionBuffer.push([timeStamp, pos]);
                    entity.anims.play('9999' + '_' + player.state, true);        // 나중에 바꿔야함
                    //entity.depth = player.depth;
                    if (player.state === Player.DANCE_RIGHT) {
                        entity.setScale(-1, 1);
                    } else {
                        entity.setScale(1, 1);
                    }

                    this.otherPlayers[sessionId].subDepth = player.subDepth;
                    this.otherPlayers[sessionId].IsSitOrLie = player.sitOrLie;
                })

                player.parts.onAdd(async (part, index) => {
                    part.onChange(() => {
                        this.otherPlayers[sessionId].addPlayerPart(this, part);
                    })
                })
                player.parts.onChange(() => {
                    this.otherPlayers[sessionId].checkRemoveParts(this, player.parts);
                })
            }
        })

        this.room.state.players.onRemove(async (player, sessionId) => {
            const entity = this.playerEntities[sessionId];
            if (this.room.sessionId === sessionId) {
                this.player.collObjCallback(this.player.direction);
                this.player.destroy(this);
            }

            if (entity) {
                // 2024-01-11 jerry 방에서 나갔을 때 해당 유저 삭제,
                globalTransport.get_bridge("WEBRTC_CLIENT_BRIDGE").add_order(WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.OUT, {
                    target_idx: `${this.otherPlayers[sessionId].id}`,
                    session_id: `${sessionId}`
                });

                entity.remoteRef.destroy();

                entity.destroy();

                delete this.playerEntities[sessionId];
                this.otherPlayers[sessionId].destroy(this);
                delete this.otherPlayers[sessionId];
            }
        })
        //========================Player=============================

        //========================Fruits=============================
        this.room.state.crops.onAdd(async (crops, sessionId) => {
            while (this.fieldObj.length !== 2) {
                await this.sleep(1000);
            }

            let pos = {
                x: this.fieldObj[crops.index].sprites.x + this.fieldObj[crops.index].offsetX,
                y: this.fieldObj[crops.index].sprites.y + this.fieldObj[crops.index].offsetY
            };


            const newCrops = new Fruits(this, pos.x, pos.y, 'level_' + crops.level, crops.index, Phaser.Math.Linear(0, 10, Utils.GetSortingOrder(0, this.height, pos.y)), crops.totalTime);
            this.FruitsObj[crops.index] = newCrops;

            if (+user_Info.otherUser === +user_Info.currentUser) {

                let field = this.frontEndEventObj[this.fieldObj[crops.index].index];
                this.saveFrontEndEventObj[field.index] = field;
                delete this.frontEndEventObj[this.fieldObj[crops.index].index];

                if (field.outline) {
                    this.player.collisionObj = null;
                    this.currentOutlineObj = null;
                    field.outlineRemove(this.outlineInstance);
                }

                setTimeout(() => {
                    this.frontEndEventObj[this.fieldObj[crops.index].index] = newCrops.sprite;
                }, 100);

            }

            this.allObject.push(newCrops.sprite);
            crops.onChange(() => {
                newCrops.levelUp('level_' + crops.level);
                newCrops.curTime = crops.totalTime;
            })
        })

        this.room.state.crops.onRemove((crops, sessionId) => {           //삭제 안하고 그냥 대입하면 어떻게 될까..
            if (+user_Info.otherUser === +user_Info.currentUser) {
                delete this.frontEndEventObj[this.fieldObj[crops.index].index];
                this.frontEndEventObj[this.fieldObj[crops.index].index] = this.saveFrontEndEventObj[this.fieldObj[crops.index].sprites.index];
                delete this.saveFrontEndEventObj[this.fieldObj[crops.index].sprites.index];
            }
            const crop = this.FruitsObj[crops.index];

            if (crop.sprite) {
                crop.destroy();

                delete this.FruitsObj[crops.index];

                if (crop.sprite.outline) {
                    this.player.collisionObj = null;
                    this.currentOutlineObj = null;

                    crop.sprite.outlineRemove(this.outlineInstance);
                }

            }
        })

        //========================Fruits=============================

        //========================Furniture=============================

        this.room.state.furniture.onAdd(async (furniture, sessionId) => {
            while (!Isload) {
                await this.sleep(1000);
            }

            let newfurniture;
            if (furniture.type === "bed") {
                newfurniture = new Bed();
            } else if (furniture.type === "closet") {
                newfurniture = new Closet();
            } else if (furniture.type === "sofa") {
                newfurniture = new Sofa();
            } else if (furniture.type === "tableset") {
                newfurniture = new TableSet();
            } else if (furniture.type === "desk") {
                newfurniture = new Desk();
            } else if (furniture.type === "wallfloor") {
                newfurniture = new WallFloor();
            } else if (furniture.type === "door") {
                newfurniture = new Door();
            } else if (furniture.type === "fishbowl") {
                newfurniture = new LandEtc();
            } else if (furniture.type === 'tiptable') {
                newfurniture = new TipTable();
            } else if (furniture.type === 'House') {
                newfurniture = new House();
            } else if (furniture.type === 'outerdoor') {
                newfurniture = new OuterDoor();
            } else {
                console.log(furniture);
            }

            if (newfurniture) {
                newfurniture.init(this, furniture.type, furniture.name, furniture.furnitureType);

                newfurniture.initOption();
                newfurniture.setDepth(this.height);
                newfurniture.setCollsition(this.frontEndEventObj);
                if (furniture.type === "closet") {
                    newfurniture.setInven(this.inventory);
                }
                if (furniture.type === "sofa" || furniture.type === "bed" || furniture.type === "tableset") {
                    let state = {
                        left: furniture.left,
                        right: furniture.right
                    };
                    newfurniture.setState(state);
                }

                // for(let i = 0; i < furniture.furnitureType.length; ++i) {
                //     console.log(furniture.furnitureType[i])
                // }
                furniture.onChange(() => {

                    newfurniture.setChange(furniture.furnitureType);
                    if (furniture.type === "sofa" || furniture.type === "bed" || furniture.type === "tableset") {
                        let state = {
                            left: furniture.left,
                            right: furniture.right
                        };
                        newfurniture.setState(state);
                    }
                })
            }
        });
        //========================Furniture=============================


        let fieldIndex = 0;
        //========================interactionObj=============================
        this.room.state.interactionObj.onAdd(async (interactionObj, sessionId) => {
            while (!Isload) {
                await this.sleep(1000);
            }

            let isBeforeAndAfter = false;
            if (interactionObj.isSpriteSheet) {
                if (interactionObj.collisionBefore !== '' && interactionObj.collisionAfter !== '') {
                    let [beforeStart, beforeEnd] = interactionObj.collisionBefore.split(',');
                    let [afterStart, afterEnd] = interactionObj.collisionAfter.split(',');

                    this.anims.create({
                        key: interactionObj.name + 'Before',
                        frames: this.anims.generateFrameNumbers(interactionObj.name, { start: +beforeStart, end: +beforeEnd }),
                        frameRate: interactionObj.numFrame,
                        yoyo: interactionObj.isYoyo,
                        repeat: -1
                    });
                    this.anims.create({
                        key: interactionObj.name + 'After',
                        frames: this.anims.generateFrameNumbers(interactionObj.name, { start: +afterStart, end: +afterEnd }),
                        frameRate: interactionObj.numFrame,
                        yoyo: interactionObj.isYoyo,
                        repeat: -1
                    });

                    isBeforeAndAfter = true;
                } else {
                    this.anims.create({
                        key: interactionObj.name,
                        frames: this.anims.generateFrameNumbers(interactionObj.name, { start: 0, end: +interactionObj.frameCount }),
                        frameRate: interactionObj.numFrame,
                        yoyo: interactionObj.isYoyo,
                        repeat: -1
                    });
                }
            }
            let interactObj = null;
            if (interactionObj.property === "field") {
                interactObj = new Field(this,
                    interactionObj.name
                    , interactionObj.indexName
                    , interactionObj.x
                    , interactionObj.y
                    , interactionObj.depth
                    , interactionObj.isWall
                    , interactionObj.isOverlap
                    , interactionObj.isFull
                    , interactionObj.collState
                    , interactionObj.offsetX
                    , interactionObj.offsetY
                    , interactionObj.property
                    , interactionObj.teleportType
                    , interactionObj.isSpriteSheet
                    , fieldIndex
                    , interactionObj.collText
                    , interactionObj.collisionName
                    , interactionObj.collisionOffsetX
                    , interactionObj.collisionOffsetY
                );

                ++fieldIndex;

                this.fieldObj.push(interactObj);

            } else if (interactionObj.property === "well") {
                interactObj = new Well(this,
                    interactionObj.name
                    , interactionObj.indexName
                    , interactionObj.x
                    , interactionObj.y
                    , interactionObj.depth
                    , interactionObj.isWall
                    , interactionObj.isOverlap
                    , interactionObj.isFull
                    , interactionObj.collState
                    , interactionObj.offsetX
                    , interactionObj.offsetY
                    , interactionObj.property
                    , interactionObj.teleportType
                    , interactionObj.isSpriteSheet
                    , interactionObj.collText
                    , interactionObj.collisionName
                    , interactionObj.collisionOffsetX
                    , interactionObj.collisionOffsetY
                );

                this.wellObj = interactObj;

            } else if (interactionObj.property === "fishing") {
                interactObj = new Fishing(this,
                    interactionObj.name
                    , interactionObj.indexName
                    , interactionObj.x
                    , interactionObj.y
                    , interactionObj.depth
                    , interactionObj.isWall
                    , interactionObj.isOverlap
                    , interactionObj.isFull
                    , interactionObj.collState
                    , interactionObj.offsetX
                    , interactionObj.offsetY
                    , interactionObj.property
                    , interactionObj.teleportType
                    , interactionObj.isSpriteSheet
                    , interactionObj.collText
                    , isBeforeAndAfter
                    , interactionObj.collisionName
                    , interactionObj.collisionOffsetX
                    , interactionObj.collisionOffsetY
                );

                this.fishingObj = interactObj;

            } else if (interactionObj.property === "secretary") {
                interactObj = new Secretary(this,
                    interactionObj.name
                    , interactionObj.indexName
                    , interactionObj.x
                    , interactionObj.y
                    , interactionObj.depth
                    , interactionObj.isWall
                    , interactionObj.isOverlap
                    , interactionObj.isFull
                    , interactionObj.collState
                    , interactionObj.offsetX
                    , interactionObj.offsetY
                    , interactionObj.property
                    , interactionObj.teleportType
                    , interactionObj.popUpType
                    , interactionObj.isSpriteSheet
                    , interactionObj.collText
                    , interactionObj.collisionName
                    , interactionObj.collisionOffsetX
                    , interactionObj.collisionOffsetY
                );
            } else {
                interactObj = new InteractionObj(this,
                    interactionObj.name
                    , interactionObj.indexName
                    , interactionObj.x
                    , interactionObj.y
                    , interactionObj.depth
                    , interactionObj.isWall
                    , interactionObj.isOverlap
                    , interactionObj.isFull
                    , interactionObj.collState
                    , interactionObj.offsetX
                    , interactionObj.offsetY
                    , interactionObj.property
                    , interactionObj.teleportType
                    , interactionObj.popUpType
                    , interactionObj.isSpriteSheet
                    , interactionObj.collText
                    , interactionObj.collisionName
                    , interactionObj.collisionOffsetX
                    , interactionObj.collisionOffsetY
                );
            }

            interactObj.setCollsition(this.frontEndEventObj);

            this.allObject.push(interactObj.sprites);

            interactionObj.onChange(() => {
                interactObj.setIsFull(interactionObj.isFull);
            })
        })


        //========================interactionObj=============================

        //========================GroundFruit=============================

        this.room.state.groundFruits.onAdd(async (groundfruit, sessionId) => {
            while (!Isload) {
                await this.sleep(1000);
            }

            let groundFruits = new GroundFruit(this, groundfruit.x, groundfruit.y, groundfruit.index, this.height);

            groundFruits.setCollsition(this.frontEndEventObj);

            this.allObject.push(groundFruits.fruit);

            if (this.isLight) {
                groundFruits.fruit.setPipeline('Light2D');
            }
            this.groundFruits[groundfruit.index] = groundFruits;
            if (groundfruit.coll) {
                groundFruits.collisionOp();
            }
            groundfruit.onChange(() => {
                groundFruits.IsCollision = groundfruit.coll;
                if (groundfruit.coll) {
                    groundFruits.collisionOp();
                }
                groundFruits.fruit.setData('serverX', groundfruit.x);
                groundFruits.fruit.setData('serverY', groundfruit.y);
            })
        });

        this.room.state.groundFruits.onRemove((groundfruit, sessionId) => {
            this.groundFruits[groundfruit.index].destroy();
            delete this.groundFruits[groundfruit.index];

            this.sound.play('coin');
        });

        //========================GroundFruit=============================

        //========================fish=============================

        let isFishCheck = false;
        this.room.onMessage('fish', async (arr) => {
            while (!this.player) {
                await this.sleep(100);
            };

            this.player.setFish(arr);

            isFishCheck = true;
        })



        //========================fish=============================


        //========================missionDebug=============================
        this.room.onMessage('mission', async (arr) => {
            while (!isFishCheck) {
                await this.sleep(100);
            };

            MissionManager.getInstance().createFishBook(arr, this.player.mapFishs);
        })

        //========================missionDebug=============================



        //========================fishList=============================
        this.room.onMessage('fishList', async (arr) => {

            let fishArr = {};
            let fishroute = ['/seum_img/fish/river/fish_1.png', '/seum_img/fish/river/fish_2.png', '/seum_img/fish/river/fish_3.png', '/seum_img/fish/river/fish_4.png', '/seum_img/fish/river/fish_5.png',
                '/seum_img/fish/sea/fish_6.png', '/seum_img/fish/sea/fish_7.png', '/seum_img/fish/sea/fish_8.png', '/seum_img/fish/sea/fish_9.png', '/seum_img/fish/sea/fish_10.png',
                '/seum_img/fish/amazon/fish_11.png', '/seum_img/fish/amazon/fish_12.png', '/seum_img/fish/amazon/fish_13.png', '/seum_img/fish/amazon/fish_14.png', '/seum_img/fish/amazon/fish_15.png'];
            for (let type in arr) {
                let info = {
                    name: '',
                    route: ''
                };
                info.name = arr[type];
                info.route = fishroute[+type - 1];

                fishArr[type] = info;
            }

            PopUpManager.getInstance().setFishData(fishArr);
        })

        //========================fishList=============================

        this.room.onMessage('receiveEmoji', async (sendInfo) => {
            let info = sendInfo;
            this.receiveEmoji(info);
        })


        this.aa = false;
    }

    elapsedTime = 0;
    fixedTimeStep = 1000 / 60;
    update(time, delta) {

        if (!this.player) return;


        this.elapsedTime += delta;

        while (this.elapsedTime >= this.fixedTimeStep) {
            this.elapsedTime -= this.fixedTimeStep;
            this.fixedTick(time, this.fixedTimeStep);
        }
    }


    fixedTick(time, delta) {
        if (updateBox.style.display === 'block' || infoBox.style.display === 'block') return;

        this.astarFollowObj();

        // const te = document.querySelector('#test');
        // te.style.left = 800 - this.cameras.main.scrollX + 'px';
        // te.style.top = 500 - this.cameras.main.scrollY + 'px';

        //==================test==================================== 

        if (this.testbar) {
            let a = 0.5;
            if (this.testDown) {
                this.testTime += delta * 0.05;
            } else {
                this.testTime -= delta * 0.05;
            }

            this.testWidth = Phaser.Math.Linear(this.testWidth, this.testTime, a);

            if (this.testWidth > this.testbar.width) {
                this.testWidth = this.testbar.width;
                this.testDown = false;
            } else if (0 > this.testWidth) {
                this.testWidth = 0;
                this.testDown = true;
            }

            this.testbar.mask.geometryMask.clear();
            this.testbar.mask.geometryMask.fillRect(this.testbar.x, this.testbar.y, this.testWidth, 20);
        }
        //==================test==================================== 


        this.UICanvas.width = this.canvas.width;
        this.UICanvas.height = this.canvas.height;

        let today = new Date();
        let hours = ('0' + today.getHours()).slice(-2);
        if (this.bgSkysDebug.debug) {
            if (this.bgSkysDebug.level1) {
                hours = 12;
            } else if (this.bgSkysDebug.level2) {
                hours = 18;
            } else if (this.bgSkysDebug.level3) {
                hours = 0;
            }
        }
        if (this.bgSkys.length > 0) {
            if (hours >= 6 && hours < 16) {                             // 나중에 에디터에서 몇시부터 몇시는 이 sky라는걸 설정할 수 있게 하자.  // 아점저 순서
                if (this.isLight) {
                    for (let i = 0; i < this.allObject.length; ++i) {
                        if (this.allObject[i].name.indexOf('Sky') === -1) {
                            this.allObject[i].resetPipeline();
                        }
                    }
                    this.isLight = false;
                }
                this.bgSkys[0].image.depth = this.bgSkys[0].depth;
                this.bgSkys[1].image.depth = this.bgSkys[0].depth - 1;
                this.bgSkys[2].image.depth = this.bgSkys[0].depth - 1;

            } else if (hours >= 16 && hours < 19) {
                if (this.isLight) {
                    for (let i = 0; i < this.allObject.length; ++i) {
                        if (this.allObject[i].name.indexOf('Sky') === -1) {
                            this.allObject[i].resetPipeline();
                        }
                    }
                    this.isLight = false;
                }
                this.bgSkys[0].image.depth = this.bgSkys[1].depth - 1;
                this.bgSkys[1].image.depth = this.bgSkys[1].depth;
                this.bgSkys[2].image.depth = this.bgSkys[1].depth - 1;

            } else {
                this.bgSkys[0].image.depth = this.bgSkys[2].depth - 1;
                this.bgSkys[1].image.depth = this.bgSkys[2].depth - 1;
                this.bgSkys[2].image.depth = this.bgSkys[2].depth;
                if (!this.isLight && user_Info.room === 'myland_outer') {     //최초 한번만!
                    this.isLight = true;

                    for (let i = 0; i < this.allObject.length; ++i) {

                        if (this.allObject[i].scene) {
                            if (this.allObject[i].name.indexOf('Sky') === -1) {
                                this.allObject[i].setPipeline('Light2D');
                            }
                        }
                    }
                }
            }
        }

        for (let i = 0; i < this.cloudinfoArr.length; ++i) {
            if (hours >= 6 && hours < 16) {                             // 나중에 에디터에서 몇시부터 몇시는 이 sky라는걸 설정할 수 있게 하자.  // 아점저 순서
                this.cloud1Arr[i].setVisible(true);
                this.cloud2Arr[i].setVisible(false);
                this.cloud3Arr[i].setVisible(false);

                this.cloud1Arr[i].x = this.cloudinfoArr[i].x;
                this.cloud1Arr[i].y = this.cloudinfoArr[i].y;
                this.cloudinfoArr[i].width = this.cloud1Arr[i].width;
            } else if (hours >= 16 && hours < 19) {
                this.cloud1Arr[i].setVisible(false);
                this.cloud2Arr[i].setVisible(true);
                this.cloud3Arr[i].setVisible(false);

                this.cloud2Arr[i].x = this.cloudinfoArr[i].x;
                this.cloud2Arr[i].y = this.cloudinfoArr[i].y;
                this.cloudinfoArr[i].width = this.cloud2Arr[i].width;
            } else {
                this.cloud1Arr[i].setVisible(false);
                this.cloud2Arr[i].setVisible(false);
                this.cloud3Arr[i].setVisible(true);

                this.cloud3Arr[i].x = this.cloudinfoArr[i].x;
                this.cloud3Arr[i].y = this.cloudinfoArr[i].y;
                this.cloudinfoArr[i].width = this.cloud3Arr[i].width;
            }

            this.cloudinfoArr[i].x += this.cloudinfoArr[i].speed * delta;

            if ((this.cloudinfoArr[i].x - (this.cloudinfoArr[i].width / 2)) > this.width) {
                this.cloudinfoArr[i].x = 0 - (this.cloudinfoArr[i].width / 2);
            }
        }


        //===============================================================================================================
        //================================================================================================================

        if (this.inventory.IsSave) {     // 인벤 세이브 버튼을 눌렀다.
            //this.player.addPart(this, this.inventory.saveParts);
            this.inventory.IsSave = false;
            let saveParts = this.inventory.saveParts;
            let savePreview = this.inventory.imageData;

            this.room.send('saveParts', saveParts);
            this.room.send('savePreview', JSON.stringify(savePreview));
            profileImg.src = `/preview/${this.player.id}_preview.png?v=${new Date().getTime()}`;

            // window.top.postMessage({ info: 'preview', rand: Math.random() * Number.MAX_SAFE_INTEGER }, '*');         // php에 값 받는 작업부터 하면 됨
        }


        this.collisionXY.x = 0;
        this.collisionXY.y = 0;

        if (this.colltile !== null && !this.player.IsSitOrLie) {
            this.overlapTileCheck = false;
            this.physics.world.overlapTiles(this.collisionPlayer, this.colltile, this.tileCollision, null, this);
            // this.collisionPlayer   this.player.sprite
        }

        if (!this.overlapTileCheck) {
            if (this.currentTileIndex !== 0) {
                this.IsDurtaion = true;
                this.isAlphaDown = true;
                this.targetAlpha = 0;
                this.currentTileIndex = 0;

                ChatManager.getInstance().setCurrentTileIndex(this.currentTileIndex);
            }
        }

        if (this.IsDurtaion) {
            if (this.targetAlpha === this.darkLayer.alpha) {
                this.IsDurtaion = false;
            } else {
                this.GraphicsAlphaInterpolation(this.darkLayer, this.targetAlpha, 1, this.isAlphaDown);
            }
        }

        if (document.activeElement !== chatInput && document.activeElement !== moChatInput) {
            this.cursorKeys.space.enabled = true;

            this.inputPayload.left = this.cursorKeys.left.isDown || this.cursorKeys.KeyA.isDown || this.joyStickCursor.left;
            this.inputPayload.right = this.cursorKeys.right.isDown || this.cursorKeys.KeyD.isDown || this.joyStickCursor.right;
            this.inputPayload.up = this.cursorKeys.up.isDown || this.cursorKeys.KeyW.isDown || this.joyStickCursor.up;
            this.inputPayload.down = this.cursorKeys.down.isDown || this.cursorKeys.KeyS.isDown || this.joyStickCursor.down;
            this.inputPayload.space = this.cursorKeys.space.isDown || this.joyStickCursor.space;
            this.inputPayload.KeyF = this.input.keyboard.checkDown(this.cursorKeys.KeyF, 300000) || this.joyStickCursor.KeyF;
            // if(this.input.keyboard.checkDown(this.cursorKeys.KeyF,300000)) {
            //     this.inputPayload.KeyF = this.cursorKeys.KeyF.isDown;
            // }

            if (document.activeElement === chatInput || document.activeElement === moChatInput || this.player.isKeyDelay) {
                this.inputPayload.left = false;
                this.inputPayload.right = false;
                this.inputPayload.up = false;
                this.inputPayload.down = false;
                this.inputPayload.space = false;
                this.inputPayload.KeyF = false;
                this.cursorKeys.space.enabled = false;
            }

            if (this.player.IsSitOrLie && this.inputPayload.KeyF) {
                this.inputPayload.KeyF = false;
            }
            this.inputPayload.KeyZ = this.cursorKeys.KeyZ.isDown;

            if (this.joyStickCursor.KeyF) {
                this.joyStickCursor.KeyF = false;
            }
        } else {
            for (let type in this.inputPayload) {
                this.inputPayload[type] = false;
            }
            this.cursorKeys.space.enabled = false;
        }

        if (this.player.IsJump) {
            this.inputPayload.space = false;
        }

        let check = false;

        this.saveTimeDelta += delta;
        if (this.randomNumber === 0) {
            this.randomNumber = Math.floor(Math.random() * (2750 - 500 + 1)) + 500;
        }
        if (this.saveTimeDelta >= this.randomNumber) {
            this.saveTimeDelta = 0;
            check = true;
        }

        if (this.loadTest) {
            this.aiMove(check);
        }

        const speed = this.player.speed;

        let aStarPos = GameManager.getInstance().AStarFollow(this, this.collisionPlayer, this.inputPayload, this.player.sprite, this.player.speed, delta / 1000);
        this.aStarArrow.left = false;
        this.aStarArrow.right = false;
        this.aStarArrow.up = false;
        this.aStarArrow.down = false;

        this.oldPos = {
            x: this.player.sprite.x,
            y: this.player.sprite.y
        };

        if (aStarPos !== undefined && aStarPos !== 0) {
            // console.log(aStarPos);
            if ((this.inputPayload.left || this.inputPayload.right || this.inputPayload.up || this.inputPayload.down || this.inputPayload.space) || this.inputPayload.KeyZ || this.inputPayload.KeyF) {
                GameManager.getInstance().nodeReset();
                this.aStarArrowPointer();
                this.followReset();
            } else {
                if (this.followObject !== null && GameManager.getInstance().finalNodeList.length === 2) {
                    GameManager.getInstance().nodeReset();
                    this.followObjectPrePos.x = 0;
                    this.followObjectPrePos.y = 0;
                } else {
                    if (this.player.IsDance) {
                        this.player.IsDance = false;
                        this.player.sprite.setScale(1, 1);
                    }

                    const deltaX = this.player.sprite.x - aStarPos.x;
                    const deltaY = this.player.sprite.y - aStarPos.y;
                    let angle = Math.atan2(deltaX, deltaY);
                    angle *= 180 / Math.PI;

                    if (angle < 0) {
                        angle += 360;
                    }

                    if (angle >= 45 && angle < 135) {

                        this.aStarArrow.left = true;
                    } else if (angle >= 135 && angle < 225) {
                        this.aStarArrow.down = true;
                    } else if (angle >= 225 && angle < 315) {
                        this.aStarArrow.right = true;
                    } else {
                        this.aStarArrow.up = true;
                    }

                    this.player.sprite.x = aStarPos.x;
                    this.player.sprite.y = aStarPos.y;

                    let info = {
                        x: aStarPos.x,
                        y: aStarPos.y,
                        arrow: this.aStarArrow
                    };
                    this.room.send('Astar', info);
                }
            }
        } else if (!GameManager.getInstance().isFind) {
            this.aStarArrow.left = false;
            this.aStarArrow.right = false;
            this.aStarArrow.up = false;
            this.aStarArrow.down = false;
            this.aStarArrowPointer();
        }

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
        this.followCamera.x = this.player.sprite.x;
        if (this.player.IsJump && (this.player.maxHeight < this.player.z)) {
            this.followCamera.y = this.player.sprite.y - this.player.accumulate;
        }
        else if (this.player.IsJump) {                              // 하강 
            this.followCamera.y = this.player.sprite.y + this.player.accumulate;

        } else {
            this.followCamera.y = this.player.sprite.y;
        }

        this.player.updateAnimation(this.inputPayload, this.aStarArrow);

        if (this.inputPayload.space && (this.player.z <= this.player.zFloor)) {
            this.player.IsJump = true;
        }


        this.player.Jump();

        this.inputPayload.collisionX = this.collisionXY.x;
        this.inputPayload.collisionY = this.collisionXY.y;

        if (this.inputPayload.down || this.inputPayload.left || this.inputPayload.right || this.inputPayload.up || this.inputPayload.space || this.inputPayload.KeyF || this.inputPayload.KeyZ || this.inputPayload.collisionX !== 0 || this.inputPayload.collisionY !== 0) {
            this.room.send('input', this.inputPayload);
        }

        this.player.sprite.remoteRef.x = this.player.sprite.x;
        this.player.sprite.remoteRef.y = this.player.sprite.y;

        this.collisionPlayer.x = this.player.sprite.x;
        this.collisionPlayer.y = this.player.sprite.y + (this.player.sprite.height / 2) - (16 / 2);
        // this.playerRef.x = this.player.sprite.x;
        // this.playerRef.y = this.collisionPlayer.y;

        this.player.light.x = this.player.sprite.x;
        this.player.light.y = this.player.sprite.y + ((this.player.sprite.height / 2) / 2);

        if (ChatManager.getInstance().players.get(this.player.name) && (ChatManager.getInstance().players.get(this.player.name).trim() !== '')) {
            this.player.createSpeechBubbleBox(this, 100, ChatManager.getInstance().players.get(this.player.name));

            ChatManager.getInstance().players.set(this.player.name, '');
        }



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
            if (this.player.IsDance) {
                this.player.IsDance = false;
                this.player.sprite.setScale(1, 1);
            }

            if (this.player.IsSitOrLie) {
                this.player.setSitOrLie(false);

                if (this.player.collisionObj && typeof this.player.collisionObj.setPoint === 'function') {
                    let dir = '';
                    if (this.oldPos.x > this.player.sprite.x) {
                        dir = 'left';
                    } else {
                        dir = 'right';
                    }
                    this.player.collisionObj.setPoint(dir);
                }
            }

            if (this.player.isFishing) {
                this.player.isFishing = false;
                this.player.fishingTime = 0;

                let info = {
                    isFishing: false
                };
                this.room.send('fishing', info);
            }

            if ((this.inputPayload.left || this.inputPayload.right || this.inputPayload.up || this.inputPayload.down || this.inputPayload.space) || this.inputPayload.KeyZ || this.inputPayload.KeyF) {

                GameManager.getInstance().nodeReset();
                this.aStarArrow.left = false;
                this.aStarArrow.right = false;
                this.aStarArrow.up = false;
                this.aStarArrow.down = false;
                this.aStarArrowPointer();

                this.followReset();
            }


            this.player.collObjCallback(this.player.direction);
            this.player.collObjCallback = () => { };
        }

        this.player.collision(this.inputPayload);

        if (this.player.isFishing) {
            if (this.decoyCount <= 0) {
                this.player.isFishing = false;
                this.player.fishingTime = 0;

                let info = {
                    isFishing: false
                };
                this.room.send('fishing', info);
            } else {
                this.player.fishingTime += delta;
                const seconds = this.player.fishingTime / 1000;
                let index = seconds;
                // this.fishingUIImage.alpha = 1;
                if (index >= 10) {
                    index = 9;
                }

                this.fishingUI.start(this.player.sprite.x + (this.player.sprite.width * 0.5), this.player.sprite.y, index);

                // this.fishingUI.draw(this.player.sprite.x - this.cameras.main.scrollX, this.player.sprite.y - (this.player.bubbleY * 2) - this.cameras.main.scrollY, Math.floor(index));

                if (this.player.fishingMaxSeconds <= seconds) {        // 낚시 성공
                    this.player.fishingTime = 0;

                    let info = {
                        isFishing: true
                    };
                    this.room.send('fishing', info);

                    this.room.send('fishingPrize', seconds);
                }
            }
        }

        for (let index in this.FruitsObj) {
            this.FruitsObj[index].render();
        }

        if (this.wellObj !== null) {
            if ((+user_Info.otherUser === +user_Info.currentUser && (this.player.myWater === 'y')) ||
                (+user_Info.otherUser !== +user_Info.currentUser && (this.player.anyWater === 'y' && this.isWater))) {      // 내 룸  , // 남의 룸              
                this.wellObj.draw(this);
            } else {                // 이미 물을 다 떳다.!
                this.wellObj.destroy();
            }
        }

        if (this.player.IsSitOrLie) {
            this.player.sprite.depth = this.player.subDepth;
        } else {
            this.player.sprite.depth = Phaser.Math.Linear(0, 10, Utils.GetSortingOrder(0, this.height, (this.player.sprite.y + ((this.player.sprite.height / 2) / 2))));
        }

        this.player.uiUpdate(delta);
        this.player.update(this);
        this.player.preSavePos();

        for (let index in this.groundFruits) {
            if (this.groundFruits[index].IsCollision) {
                const { serverX, serverY } = this.groundFruits[index].fruit.data.values;

                this.groundFruits[index].fruit.x = Phaser.Math.Linear(this.groundFruits[index].fruit.x, serverX, 0.2);
                this.groundFruits[index].fruit.y = Phaser.Math.Linear(this.groundFruits[index].fruit.y, serverY, 0.2);
            }
        }
        //==========================================otherPlayer================================= 

        for (let sessionId in this.playerEntities) {

            if (sessionId === this.room.sessionId) {
                continue;
            }
            const entity = this.playerEntities[sessionId];

            // let now = +new Date();
            // let render_timestamp = now - (1000 / 60);

            // const otherPlayer = this.otherPlayers[sessionId];
            // let buffer = otherPlayer.positionBuffer;

            // while(buffer.length >= 2 && buffer[1][0] <= render_timestamp) {
            //     buffer.shift();
            // }

            // if(buffer.length >= 2 && buffer[0][0] <= render_timestamp && render_timestamp <= buffer[1][0]) {
            //     let x0 = buffer[0][1].x;
            //     let x1 = buffer[0][1].x;
            //     let y0 = buffer[0][1].y;
            //     let y1 = buffer[0][1].y;
            //     let t0 = buffer[0][0];
            //     let t1 = buffer[1][0];

            //     entity.x = x0 + (x1 - x0) * (render_timestamp - t0) / (t1 - t0);
            //     entity.y = y0 + (y1 - y0) * (render_timestamp - t0) / (t1 - t0);
            // }

            const { serverX, serverY } = entity.data.values;

            entity.x = Phaser.Math.Linear(entity.x, serverX, 0.2);
            entity.y = Phaser.Math.Linear(entity.y, serverY, 0.2);

            entity.remoteRef.x = entity.x;
            entity.remoteRef.y = entity.y;

            this.otherPlayers[sessionId].light.x = this.otherPlayers[sessionId].sprite.x;
            this.otherPlayers[sessionId].light.y = this.otherPlayers[sessionId].sprite.y + ((this.otherPlayers[sessionId].sprite.height / 2) / 2);

            if (ChatManager.getInstance().players.get(this.otherPlayers[sessionId].name) && ChatManager.getInstance().players.get(this.otherPlayers[sessionId].name).trim() !== '') {
                this.otherPlayers[sessionId].createSpeechBubbleBox(this, 100, ChatManager.getInstance().players.get(this.otherPlayers[sessionId].name));

                ChatManager.getInstance().players.set(this.otherPlayers[sessionId].name, '');     //초기화
            }

            if (this.otherPlayers[sessionId].IsSitOrLie) {
                entity.depth = this.otherPlayers[sessionId].subDepth;
            } else {
                entity.depth = Phaser.Math.Linear(0, 10, Utils.GetSortingOrder(0, this.height, entity.y));
            }

            this.otherPlayers[sessionId].uiUpdate(delta);
            this.otherPlayers[sessionId].update(this);
            this.otherPlayers[sessionId].preSavePos();

            let distance = Phaser.Math.Distance.Between(this.player.sprite.x, this.player.sprite.y, entity.x, entity.y);
            if (distance <= this.range) {
                //entity.remoteRef.setStrokeStyle(1,  0xff0000);
                //this.player.sprite.remoteRef.setStrokeStyle(1, 0xff0000);

                // 2024-01-11 Jerry 추가 -> 다른 유저 만남
                globalTransport.get_bridge("WEBRTC_CLIENT_BRIDGE").add_order(WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.MEET, {
                    target_idx: `${this.otherPlayers[sessionId].id}`,
                    session_id: `${sessionId}`,
                });
            } else {
                //entity.remoteRef.setStrokeStyle(1,  0xff000);
                //this.player.sprite.remoteRef.setStrokeStyle(1, 0xff000);

                // 2024-01-11 Jerry 추가 -> 다른 유저 떠남
                globalTransport.get_bridge("WEBRTC_CLIENT_BRIDGE").add_order(WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.LEAVE, {
                    target_idx: `${this.otherPlayers[sessionId].id}`,
                    session_id: `${sessionId}`
                });
            }

        }
        //  this.playerRef.x = this.player.sprite.x;
        //  this.playerRef.y = this.player.sprite.y - 8;

        //==========================================otherPlayer================================= 
    }

    createAnimation() {
        const animContext = this.anims;

        animContext.create({
            key: Assets.FRUTIS_ANIM.LEVEL_1,
            frames: [{ key: Assets.FRUITS, frame: 0 }],
            frameRate: 2,
        });
        animContext.create({
            key: Assets.FRUTIS_ANIM.LEVEL_2,
            frames: animContext.generateFrameNumbers(Assets.FRUITS, { start: 1, end: 4 }),
            frameRate: 2.5,
            repeat: -1
        });
        animContext.create({
            key: Assets.FRUTIS_ANIM.LEVEL_3,
            frames: animContext.generateFrameNumbers(Assets.FRUITS, { start: 5, end: 8 }),
            frameRate: 2.5,
            repeat: -1
        });
        animContext.create({
            key: Assets.FRUTIS_ANIM.LEVEL_4,
            frames: animContext.generateFrameNumbers(Assets.FRUITS, { start: 9, end: 12 }),
            frameRate: 2.5,
            repeat: -1
        });

        animContext.create({
            key: Assets.FRUTIS_ANIM.LEVEL_5,
            frames: animContext.generateFrameNumbers(Assets.FRUITS, { start: 13, end: 16 }),
            frameRate: 2.5,
            repeat: -1
        });

        animContext.create({
            key: Assets.FISHINGSHEETPLAY,
            frames: animContext.generateFrameNumbers(Assets.FISHINGSHEET, { start: 0, end: 5 }),
            frameRate: 6,
            repeat: -1,
            yoyo: true
        });

        animContext.create({
            key: Assets.FRUITICONSHEETPLAY,
            frames: animContext.generateFrameNumbers(Assets.FRUITICONSHEET, { start: 0, end: 1 }),
            frameRate: 2,
            repeat: -1,
        });

        animContext.create({
            key: Assets.FRUITBARSHEETPLAY,
            frames: animContext.generateFrameNumbers(Assets.FRUITBARSHEET, { start: 0, end: 7 }),
            frameRate: 2,
            repeat: -1,
        });

        animContext.create({
            key: Assets.WATERICONSHEETPLAY,
            frames: animContext.generateFrameNumbers(Assets.WATERICONSHEET, { start: 0, end: 1 }),
            frameRate: 2,
            repeat: -1
        });
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
            if (collisionObj.name === 'field') {            //씨앗 심기
                if(+seedCount.innerText <= 0) return;
                
                const vInfo = {
                    x: collisionObj.x + collisionObj.collOffsetX,
                    y: collisionObj.y + collisionObj.collOffsetY,
                    index: collisionObj.index,
                    id: this.player.id
                };
                this.room.send('fruits', vInfo);
            }
            else if (collisionObj.name === 'fruits') {              // 열매 수확
                const startIndex = this.FruitsObj[collisionObj.index].level.indexOf('_') + 1;
                const level = this.FruitsObj[collisionObj.index].level.substring(startIndex, this.FruitsObj[collisionObj.index].level.length);

                if (+level === 5) {
                    const vInfo = {
                        index: collisionObj.index,
                        id: this.player.id
                    };

                    this.room.send('harvesting', vInfo);
                } else {
                    if (waterFBoxBg.style.display === "block") {
                        waterFBoxBg.style.display = "none";
                        UIManager.getInstance().removeElement(waterFBoxBg);

                    } else {
                        waterFBoxBg.style.display = "block";
                        UIManager.getInstance().setElement(waterFBoxBg);
                    }
                    UIManager.getInstance().setElement(waterFBoxBg);

                    this.curFruits = collisionObj;
                }
            } else if (collisionObj.name === "well") {
                if ((+user_Info.otherUser === +user_Info.currentUser && (this.player.myWater === 'y')) || (+user_Info.otherUser !== +user_Info.currentUser && (this.player.anyWater === 'y' && this.isWater))) {      // 내 룸   남의룸             
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
            }//else {
            //     if (this.minDinstace > distance) {
            //         this.minDinstace = distance;

            //         if (this.currentOutlineObj !== collisionObj) {
            //             if (this.currentOutlineObj.outline) {
            //                 this.currentOutlineObj.outlineRemove(this.outlineInstance);
            //             }
            //         }
            //     }
            //     else {
            //         let curObjLeftTop = {
            //             x: this.currentOutlineObj.x - (this.currentOutlineObj.width / 2),
            //             y: this.currentOutlineObj.y - (this.currentOutlineObj.height / 2)

            //         };
            //         let curObjRightBottom = {
            //             x: this.currentOutlineObj.x + (this.currentOutlineObj.width / 2),
            //             y: this.currentOutlineObj.y + (this.currentOutlineObj.height / 2)

            //         };

            //         if (player.x < curObjLeftTop.x || player.y < curObjLeftTop.y ||
            //             player.x > curObjRightBottom.x || player.y > curObjRightBottom.y) {
            //             if (this.currentOutlineObj !== collisionObj) {
            //                 if (this.currentOutlineObj.outline) {
            //                     this.currentOutlineObj.outlineRemove(this.outlineInstance);
            //                 }
            //             }
            //         }
            //         else {
            //             return;
            //         }
            //     }
            // }
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

    tileCollision(obj, tile) {
        if (tile.properties.option === "Endline") return;

        let player = this.player.sprite;

        if (tile.properties.option === 'Wall' || tile.properties.option === 'WallPrivate') {
            if (this.collisionPlayer.y === tile.pixelY) return;
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
            const playerY = (player.y + (player.height / 2)) - (tile.height / 4);
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
        } else if (tile.properties.option === 'Private') {          // 프라이빗 존 타일에 들어왔다!
            this.overlapTileCheck = true;

            if (this.currentTileIndex === tile.properties.index) return;

            this.currentTileIndex = tile.properties.index;

            ChatManager.getInstance().setCurrentTileIndex(this.currentTileIndex);

            this.IsDurtaion = true;
            this.isAlphaDown = false;
            this.targetAlpha = this.darkAlpha;             //페이드인 or 아웃

            this.darkLayer.clear();
            this.darkLayer.fillStyle(0x000000, 1);
            this.darkLayer.setAlpha(0);

            const tileSize = tile.width;

            this.map.forEachTile((mapTile) => {
                if (mapTile.properties.index !== tile.properties.index) {
                    if (mapTile.properties.option !== 'WallPrivate' || (+mapTile.properties.index + 60) !== +tile.properties.index) {
                        this.darkLayer.fillRect(mapTile.pixelX, mapTile.pixelY, tileSize, tileSize);
                    }
                }
            }, this);
        }
    }

    async loadFile(context, json) {
        return new Promise(function (resolve, reject) {
            context.load.tilemapTiledJSON(Assets.TILE, json);
            resolve();
        })
    }

    aiMove(random) {                    //부하테스트 
        if (random) {
            this.LeftAndRight = Math.random();
            this.UpAndDown = Math.random();
            this.JumpCheck = Math.random();
        }

        if (!this.firstCheck) {           // 최초 한번
            this.LeftAndRight = Math.random();
            this.UpAndDown = Math.random();
            this.JumpCheck = Math.random();

            this.firstCheck = true;
        }

        if (this.LeftAndRight < 0.35) {
            this.inputPayload.right = true;
            this.inputPayload.left = false;
        } else if (this.LeftAndRight < 0.7) {
            this.inputPayload.right = false;
            this.inputPayload.left = true;
        } else {
            this.inputPayload.right = false;
            this.inputPayload.left = false;
        }

        if (this.UpAndDown < 0.35) {
            this.inputPayload.up = true;
            this.inputPayload.down = false;
        } else if (this.UpAndDown < 0.7) {
            this.inputPayload.up = false;
            this.inputPayload.down = true;
        } else {
            this.inputPayload.up = false;
            this.inputPayload.down = false;
        }

        if (this.Jump > 0.4) {
            this.inputPayload.space = true;
        } else {
            this.inputPayload.space = false;
        }
    }

    GraphicsAlphaInterpolation(graphic, targetAlpha, speed, isdown) {
        let curSpeed = isdown ? speed * -1 : speed;

        let curAlpha = graphic.alpha + (curSpeed * (this.fixedTimeStep / 1000));

        if (isdown && targetAlpha > curAlpha) { //알파가 내려가야 한다.
            curAlpha = targetAlpha;
        } else if (!isdown && targetAlpha < curAlpha) {
            curAlpha = targetAlpha;
        }

        if (curAlpha > 1 || curAlpha < 0) {
            curAlpha = targetAlpha;
        }

        graphic.setAlpha(curAlpha);
    }
    calculateTweenDuration(startAlpha, endAlpha, sec, speed) {
        let alphaDiff = Math.abs(endAlpha - startAlpha);
        let calculSpeed = alphaDiff / speed;

        let duration = sec * calculSpeed;

        return duration;
    }


    emojiKeyDownEvent() {
        this.input.keyboard.on('keydown-ONE', async (e) => {
            this.makeEmoji(+e.key);
        }, this);

        this.input.keyboard.on('keydown-TWO', async (e) => {
            this.makeEmoji(+e.key);
        }, this);

        this.input.keyboard.on('keydown-THREE', async (e) => {
            this.makeEmoji(+e.key);
        }, this);

        this.input.keyboard.on('keydown-FOUR', async (e) => {
            this.makeEmoji(+e.key);
        }, this);
    }


    makeEmoji(number) {
        const emoji = document.createElement('p');
        emoji.classList.add('emoji');

        let emojiCode;
        switch (number) {
            case 1:
                emojiCode = `&#x1F603`;       // 웃기 
                break;
            case 2:
                emojiCode = `&#129505`;       // 하트 
                break;
            case 3:
                emojiCode = `&#127881`;       // 축하
                break;
            case 4:
                emojiCode = `&#128075`;       // 손 흔들기
                break;
            default:
                emojiCode = `&#x1F603`;       // 디폴트 웃기
                break;
        }

        emoji.innerHTML = emojiCode;

        document.querySelector("#gamecontainer").appendChild(emoji);

        const emojiDom = this.add.dom(this.player.sprite.x, this.player.sprite.y - this.player.bubbleY - 14, emoji)
            .setOrigin(0.5, 0.5)
            .setDepth(100);

        const tween = this.tweens.add({
            targets: emojiDom,
            duration: 500,
            delay: 1000,
            y: '-=40',
            scaleX: 0.8,
            scaleY: 0.8,
            alpha: 0,
            ease: 'Linear',
            onComplete: () => {
                tween.stop();
            }
        });

        let info = {
            x: this.player.sprite.x,
            y: this.player.sprite.y - this.player.bubbleY - 14,
            code: emojiCode
        };

        this.room.send('sendEmoji', info);
    }

    receiveEmoji(info) {
        const emoji = document.createElement('p');
        emoji.classList.add('emoji');

        emoji.innerHTML = `${info.code}`;

        document.querySelector("#gamecontainer").appendChild(emoji);

        const emojiDom = this.add.dom(info.x, info.y, emoji)
            .setOrigin(0.5, 0.5)
            .setDepth(100);

        const tween = this.tweens.add({
            targets: emojiDom,
            duration: 500,
            delay: 1000,
            y: '-=40',
            scaleX: 0.8,
            scaleY: 0.8,
            alpha: 0,
            ease: 'Linear',
            onComplete: () => {
                tween.stop();
            }
        });
    }

    aStarArrowPointer() {
        if (this.followObject !== null) return;

        if (!this.pathTween) {
            this.pathTween = this.tweens.add({
                targets: this.pathFinderArrow,
                alpha: 0,
                yoyo: false,
                duration: 500,
                repeat: 0,
                ease: 'Sine.easeInOut',
                onComplete: () => {
                }
            });
            this.isPathTween = true;
        } else if (!this.isPathTween) {
            this.pathTween.stop();
            this.pathTween.destroy();
            //this.pathFinderArrow.setAlpha(1);
            this.pathTween = this.tweens.add({
                targets: this.pathFinderArrow,
                alpha: 0,
                yoyo: false,
                duration: 500,
                repeat: 0,
                ease: 'Sine.easeInOut',
                onComplete: () => {
                }
            });
            this.isPathTween = true;
        }
    }


    async astarFollowObj() {
        if (this.followObject !== null) {
            this.pathFinderArrow.setAlpha(0);

            if ((this.followObjectPrePos.x === this.followObject.x) && (this.followObjectPrePos.y === this.followObject.y)) return;
            const worldPoint = {
                x: this.followObject.x,
                y: this.followObject.y + (this.followObject.height / 2),
            }

            this.followObjectPrePos.x = this.followObject.x;
            this.followObjectPrePos.y = this.followObject.y;

            await GameManager.getInstance().pathFinding(this, this.collisionPlayer, worldPoint);

            if (this.pathTween) {
                this.pathTween.stop();
                this.isPathTween = false;
            }

            // const node = GameManager.getInstance().finalNodeList[GameManager.getInstance().finalNodeList.length - 1];

            // let finalX = this.map.tileToWorldX(node.x) + 16;
            // let finalY = this.map.tileToWorldY(node.y);

            // this.pathFinderArrow.x = finalX;
            // this.pathFinderArrow.y = finalY;
            // this.pathFinderArrow.setAlpha(1);
        }

    }
    followReset() {
        this.followObjectPrePos.x = 0;
        this.followObjectPrePos.y = 0;
        this.followObject = null;

    }
}