class TableSet extends Furniture {
    constructor() {
        super();

        this.leftSprites;
        this.rightSprites;
        this.leftColl = false;
        this.rightColl = false;
        this.leftSit = false;
        this.rightSit = false;
    }


    init = (context, type, name, arrObj) => {
        this.type = type;
        this.name = name;
        this.coll = false;

        for (let i = 0; i < arrObj.length; ++i) {
            var ref = context.physics.add.image(0, 0, arrObj[i].name);
            ref.setOrigin(0.5, 0.5);
            ref.coll = false;
            ref.outline = false;
            ref.name = arrObj[i].name;
            ref.type = name;
            ref.outColl = true;

            ref.collText = '를 눌러 상호작용';

            //Phaser.Math.Linear(0, 10, Utils.GetSortingOrder(0, height, this.sprites[i].y));

            ref.depth = -0.5;
            this.sprites.push(ref);
        }

        for (let i = 0; i < this.sprites.length; ++i) {

            var lastIndex = this.sprites[i].name.indexOf('_');
            var types = this.sprites[i].name.substring(0, lastIndex);
            if (types === 'table') {      //table
                this.sprites[i].x = 913.5;
                this.sprites[i].y = 870.5;
                this.sprites[i].outColl = false;
            } else {    //chair
                if (-1 !== this.sprites[i].name.indexOf('_l_')) {
                    this.sprites[i].x = 849;
                    this.sprites[i].y = 833.5;
                    this.leftSprites = this.sprites[i];
                }
                else if (-1 !== this.sprites[i].name.indexOf('_r_')) {
                    this.sprites[i].x = 978;
                    this.sprites[i].y = 832.5;
                    this.rightSprites = this.sprites[i];
                }
            }
        }
    }

    initOption = () => {
        this.leftSprites.ftOption = this.leftOption;
        this.leftSprites.outlineAdd = this.outlineLeftAdd;
        this.leftSprites.outlineRemove = this.outlineLeftRemove;
        this.leftSprites.collAdd = this.collLeftAdd;

        this.rightSprites.ftOption = this.rightOption;
        this.rightSprites.outlineAdd = this.outlineRightAdd;
        this.rightSprites.outlineRemove = this.outlineRightRemove;
        this.rightSprites.collAdd = this.collRightAdd;

    }

    setDepth = (height) => {
        for (let i = 0; i < this.sprites.length; ++i) {
            this.sprites[i].depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, height, this.sprites[i].y));
        }

    }

    setChange = (arr) => {
        for (let i = 0; i < this.sprites.length; ++i) {
            var lastIndex = arr[i].name.indexOf('_');
            var type = arr[i].name.substring(0, lastIndex);
            if (type === 'table') {      //table
                this.sprites[i].setTexture(arr[i].name);
                this.sprites[i].name = arr[i].name;

            } else {    //chair
                if (-1 !== arr[i].name.indexOf('_l_')) {
                    this.sprites[i].setTexture(arr[i].name);
                    this.sprites[i].name = arr[i].name;
                } else if (-1 !== arr[i].name.indexOf('_r_')) {
                    this.sprites[i].setTexture(arr[i].name);
                    this.sprites[i].name = arr[i].name;
                } 
            }
        }
    }

    setState = (state) => {
        this.leftSit = state.left;
        this.rightSit = state.right;
    }

    setStatePlayer = (state) => {
        if (state === 'Left') {
            this.leftSit = false;
        } else if (state === 'Right') {
            this.rightSit = false;
        }

        var info = {
            type: this.type,
            left: this.leftSit,
            right: this.rightSit
        };

        SendManager.getInstance().send('curState', info);
    }

    outlineLeftAdd = async (outlineInstance) => {
        if (this.leftColl) return;

        if (this.leftSprites.outColl) {
            outlineInstance.add(this.leftSprites, {
                thickness: 3,
                outlineColor: Utils.OUTCOLOR
            });

            this.leftSprites.outline = true;
        }

        this.leftColl = true;
    }

    outlineRightAdd = async (outlineInstance) => {
        if (this.rightColl) return;

        if (this.rightSprites.outColl) {
            outlineInstance.add(this.rightSprites, {
                thickness: 3,
                outlineColor: Utils.OUTCOLOR
            });

            this.rightSprites.outline = true;
        }

        this.rightColl = true;
    }

    outlineLeftRemove = async (outlineInstance) => {

        if (this.leftSprites.outColl) {
            outlineInstance.remove(this.leftSprites);
            this.leftSprites.outline = false;
        }


        this.leftColl = false;
    }

    outlineRightRemove = async (outlineInstance) => {
        if (this.rightSprites.outColl) {
            outlineInstance.remove(this.rightSprites);
            this.rightSprites.outline = false;
        }

        this.rightColl = false;
    }

    collLeftAdd = () => {
        this.leftSprites.coll = true;
    }

    collRightAdd = () => {
        this.rightSprites.coll = true;
    }

    option = () => { }

    leftOption = () => {
        if(this.leftSit) return;

        this.leftSit = true;
        var pos = {
            x:0,
            y:0
        };
        pos.x = this.leftSprites.x;
        pos.y = this.leftSprites.y;

        var state = '';
        var dir = '';
        state = Player.SIT_RIGHT;
        dir = 'Left';
        var info = {
            type: this.type,
            left: this.leftSit,
            right: this.rightSit,
            dir: dir
        };
        
        
        ObjectManager.getInstance().setPos(pos);
        ObjectManager.getInstance().setState(state);        
        ObjectManager.getInstance().setDirection(dir);
        ObjectManager.getInstance().setSitOrLie(true);
        ObjectManager.getInstance().setSubDepth(this.leftSprites.depth + 0.1);
        ObjectManager.getInstance().setCollObj(this.setStatePlayer);

        SendManager.getInstance().send('curState',info);

    }

    rightOption = () => {
        if(this.rightSit) return;

        this.rightSit = true;

        var pos = {
            x:0,
            y:0
        };
        pos.x = this.rightSprites.x;
        pos.y = this.rightSprites.y + 0.1;
        var state = '';
        var dir = '';
        state = Player.SIT_LEFT;
        dir = "Right"

        var info = {
            type: this.type,
            left: this.leftSit,
            right: this.rightSit,
            dir : dir
        };
       

        ObjectManager.getInstance().setPos(pos);
        ObjectManager.getInstance().setState(state);        
        ObjectManager.getInstance().setDirection(dir);
        ObjectManager.getInstance().setSitOrLie(true);
        ObjectManager.getInstance().setSubDepth(this.rightSprites.depth + 0.1);
        ObjectManager.getInstance().setCollObj(this.setStatePlayer);

        SendManager.getInstance().send('curState',info);
    }

    setStatePlayer = (state) => {
        if(state === 'Left') {
            this.leftSit = false;
        } else if (state === 'Right') {
            this.rightSit = false;
        }

        var info = {
            type: this.type,
            left: this.leftSit,
            right: this.rightSit,
            dir : state
        };
        
        SendManager.getInstance().send('leaveState',info);
    }}