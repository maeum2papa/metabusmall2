class Assets {
    static STATIC = 'static';
    static FRUITS = 'fruits';
    static ICON = 'icon';
    static TILEX = 'tiles';
    static TILEBLACK = 'tiles';
    static TILE = 'tile';
    static FRUITCOUNT = 'fruitcount';

    static FRUTIS_ANIM = {
        LEVEL_1: 'level_1',
        LEVEL_2: 'level_2',
        LEVEL_3: 'level_3',
        LEVEL_4: 'level_4',
        LEVEL_5: 'level_5'
    };

    static PATHFINDERARROW = 'pathfinderarrow';

    static FISHINGUI = "fishingui";
    static FISHINGINDEX = {
        ONE: 'fishing0',
        TWO: 'fishing1',
        THREE: 'fishing2',
        FOUR: 'fishing3',
        FIVE: 'fishing4',
        SIX: 'fishing5',
        SEVEN: 'fishing6',
        EIGHT: 'fishing7',
        NINE: 'fishing8',
        TEN: 'fishing9',
    }

    static FISHINGSHEET = 'fishingsheet';
    static FISHINGSHEETPLAY = 'fishingsheetplay';
    static FISHINGGAUGE = 'fishinggauge';

    static FRUITGAUGEUI = 'fruitgaugeui';

    static FRUITICONSHEET = 'fruiticonsheet';
    static FRUITICONSHEETPLAY = 'fruiticonsheetplay';
    static FRUITGAUGE = 'fruitgauge';
    static FRUITBARSHEET = 'fruitbarsheet';
    static FRUITBARSHEETPLAY = 'fruitbarsheet';

    static GROUNDFRUIT = 'groundfruit';

    static CLOUD = {
        cloud1_1: 'cloud1_1',
        cloud1_2: 'cloud1_2',
        cloud1_3: 'cloud1_3',
        cloud2_1: 'cloud2_1',
        cloud2_2: 'cloud2_2',
        cloud2_3: 'cloud2_3',
        cloud3_1: 'cloud3_1',
        cloud3_2: 'cloud3_2',
        cloud3_3: 'cloud3_3',
        cloud4_1: 'cloud4_1',
        cloud4_2: 'cloud4_2',
        cloud4_3: 'cloud4_3',
        cloud5_1: 'cloud5_1',
        cloud5_2: 'cloud5_2',
        cloud5_3: 'cloud5_3',
        cloud6_1: 'cloud6_1',
        cloud6_2: 'cloud6_2',
        cloud6_3: 'cloud6_3',
    }

    static WATERICONSHEET = 'watericonsheet';
    static WATERICONSHEETPLAY = 'watericonsheetplay';

    constructor(context) {
        this.context = context;
    }

    load() {
        const loader = this.context.load;

        loader.plugin('rexoutlinepipelineplugin', 'static/plugins/rexoutlinepipelineplugin.js', true);
        loader.plugin('rexvirtualjoystickplugin', 'static/plugins/rexvirtualjoystickplugin.min.js', true);

        loader.image(Assets.TILEX, 'static/client/assets/Images/gridtiles.png');
        loader.image(Assets.TILEBLACK, 'static/client/assets/Images/gridtiles1.png');


        this.uiLoad();
        this.objLoad();
        this.audioLoad();
    }

    static async loadPlayersheet(context, arr) {
        const loader = context.load;

        for (let i = 0; i < arr.length; ++i) {
            if (arr[i].name === '' || arr[i].route === '') continue;
            loader.spritesheet(arr[i].name, arr[i].route, {                 // 나중에 캐릭터가 96과 다른게 있으면 width,height도 받아와야 함.
                frameWidth: 96,
                frameHeight: 96
            });
        }
    }

    static async loadEffectsheet(context, arr) {
        const loader = context.load;

        for (let i = 0; i < arr.length; ++i) {
            if (arr[i].name === '' || arr[i].route === '') continue;

            loader.spritesheet(arr[i].name, arr[i].route, {
                frameWidth: +arr[i].width,
                frameHeight: +arr[i].height
            });
        }
    }

    static async loadImage(context, arr) {
        const loader = context.load;

        for (let i = 0; i < arr.length; ++i) {

            if (arr[i].name === undefined || arr[i].name === '' || arr[i].route === undefined || arr[i].route === '') continue;

            loader.image(arr[i].name, arr[i].route);
        }
    }

    static async loadTypeImage(context, arr) {
        const loader = context.load;

        for (let type in arr) {
            loader.image(type, arr[type].route);
        }
    }

    static async loadObjOrSheetImage(context, arr) {
        const loader = context.load;

        for (let type in arr) {
            if (arr[type].isSpriteSheet) {
                loader.spritesheet(type, arr[type].route, {
                    frameWidth: arr[type].frameWidth,
                    frameHeight: arr[type].frameHeight
                });
            } else {
                loader.image(type, arr[type].route);
            }
        }
    }

    static async loadSpriteSheet(context, obj) {
        const loader = context.load;

        loader.spritesheet(obj.saveName, obj.route, {
            frameWidth: obj.frameWidth,
            frameHeight: obj.frameHeight
        });
    }

    static async loadSpriteSheetArr(context, arr) {
        const loader = context.load;

        for (let i = 0; i < arr.length; ++i) {
            loader.spritesheet(arr[i].saveName, arr[i].route, {
                frameWidth: arr[i].frameWidth,
                frameHeight: arr[i].frameHeight
            });

        }
    }

    static async loadCloudImage(context) {
        const loader = context.load;

        for (let name in this.CLOUD) {
            loader.image(`${name}`, 'static/client/assets/Images/cloud/' + `${name}` + ".png");
        }
    }

    uiLoad() {
        const loader = this.context.load;

        loader.image(Assets.FRUITCOUNT, 'static/client/assets/Images/fruitcount.png');
        loader.image(Assets.ICON, 'static/client/assets/Images/donot.png');

        loader.spritesheet(Assets.FRUITS, 'static/client/assets/Images/Fruit_Under_sheet.png', {
            frameWidth: 98,
            frameHeight: 90
        });

        loader.image(Assets.PATHFINDERARROW, 'static/client/assets/Images/ui/pathfinderArrow.png');

        loader.spritesheet(Assets.FISHINGSHEET, 'static/client/assets/Images/ui/fishingbarsheet.png', {
            frameWidth: 64,
            frameHeight: 160
        });

        loader.image(Assets.FISHINGGAUGE, 'static/client/assets/Images/ui/fishinggauge.png');

        loader.spritesheet(Assets.FRUITICONSHEET, 'static/client/assets/Images/ui/fruiticonsheet.png', {
            frameWidth: 160,
            frameHeight: 96
        });

        loader.image(Assets.FRUITGAUGE, 'static/client/assets/Images/ui/fruitgauge.png');
        loader.spritesheet(Assets.FRUITBARSHEET, 'static/client/assets/Images/ui/fruitbarsheet.png', {
            frameWidth: 160,
            frameHeight: 96
        });

        loader.spritesheet(Assets.WATERICONSHEET, 'static/client/assets/Images/ui/watericonsheet.png', {
            frameWidth: 128,
            frameHeight: 128
        });
    }

    objLoad() {
        const loader = this.context.load;

        loader.image(Assets.GROUNDFRUIT, 'static/client/assets/Images/ui/groundfruiticon.png');
    }

    audioLoad() {
        const loader = this.context.load;
        
        loader.audio('percussion', ['static/client/assets/audio/percussion.ogg', 'static/client/assets/audio/percussion.mp3'], {
            instances: 2
        });

        loader.audio('coin', 'static/client/assets/audio/dooing.mp3', {
            instances: 1
        });
    }
}