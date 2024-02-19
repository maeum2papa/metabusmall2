class Sofa extends Furniture{
    constructor(){
        super();
        this.leftSit = false;
        this.rightSit = false;
        this.sofaSprite = null;
    }


    init = (context,type, name, arrObj) => {
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

        for(let i = 0; i < this.sprites.length; ++i) {

            var lastIndex = this.sprites[i].name.indexOf('_');
            var types = this.sprites[i].name.substring(0,lastIndex);
            if(types === 'sofa') {      //sofa
                
                    this.sprites[i].x = 872.5;
                    this.sprites[i].y = 629;
                    this.sofaSprite = this.sprites[i]; 
            } else {    //sofatable
                this.sprites[i].x = 907.5;
                this.sprites[i].y = 663.5;
                this.sprites[i].outColl = false;
            }
        }
    }

    setDepth = (height) => {
        for (let i = 0; i < this.sprites.length; ++i) {
            var lastIndex = this.sprites[i].name.indexOf('_');
            var type = this.sprites[i].name.substring(0,lastIndex);
           
            if(type === 'sofa') {            
                this.sprites[i].depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, height, this.sprites[i].y - 20));
            } else {
                //this.sprites[i].depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, height, this.sprites[i].y + 35));
                this.sprites[i].depth = 0;
            }
        }
    }

    setChange = (arr) => { 
        for(let i = 0; i < this.sprites.length; ++i) {        
            var lastIndex = arr[i].name.indexOf('_');
            var type = arr[i].name.substring(0, lastIndex);
            if (type === 'sofa') {      //sofa
                
                    this.sprites[i].setTexture(arr[i].name);
                    this.sprites[i].name = arr[i].name;
                
            } else {    //sofatable
                this.sprites[i].setTexture(arr[i].name);
                this.sprites[i].name = arr[i].name;
            }
        }        
    }
                                                                        // 왼쪽 아래 오른쪽 위 점 주고 가운데 x값 통해서 플레이어가 소파 x보다 왼쪽으로가면 왼쪽 아래 기준 depth하면 될듯
    setState = (state) => {
        this.leftSit = state.left;
        this.rightSit = state.right;
    }

    option = () => { 
        if(this.leftSit && this.rightSit) return;           // 못앉는다..

        var pos = {
            x:0,
            y:0
        };
        var state = '';
        var dir = '';

        if(!this.leftSit && !this.rightSit) {         // 좌석 다 비었다.플레이어 위치에 따라 앉는 곳 결정
            var pos = ObjectManager.getInstance().getObjectPos();

            let Rdistance = Phaser.Math.Distance.Between(pos.x, pos.y, 913, 592);
            let Ldistance = Phaser.Math.Distance.Between(pos.x, pos.y, 851, 628);
            if(Ldistance > Rdistance) {         // Right가 더 가깝다.
                pos.x = 913;
                pos.y = 592; 
                this.rightSit = true
                dir = 'Right';
            } else {                           // left가 더 가깝다.
                pos.x = 851;
                pos.y = 628;
                this.leftSit = true;
                dir = 'Left';
            }

        } else {
            if(!this.leftSit) {         // 왼쪽좌석이 비었다.
                pos.x = 851;
                pos.y = 628;
                this.leftSit = true;
                dir = 'Left';

            } else if (!this.rightSit){                    // 오른쪽좌석이 비었다.
                pos.x = 913;
                pos.y = 592;
                this.rightSit = true;
                dir = 'Right';

            }
        }
        state = Player.SIT_RIGHT;     
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
        ObjectManager.getInstance().setSubDepth(this.sofaSprite.depth + 0.1);
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
    }
}