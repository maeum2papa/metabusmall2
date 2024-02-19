class Bed extends Furniture{
    constructor(){
        super();
        this.left = false;
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

        this.sprites[0].x = 1314;
        this.sprites[0].y = 663.5;
        this.sprites[0].setPoint = this.setPoint;
    }

    setDepth = (height) => {
    
    }
    
    setState = (state) => {
        this.left = state.left;
    }
    option = () => {
        if(this.left) return;

        let pos = {
            x:1328,
            y:624
        };
        let dir = 'Left';
        this.left = true;

        let info = {
            type: this.type,
            left: this.left,
            right: this.left,
            dir:dir
        };

        ObjectManager.getInstance().setPos(pos);
        ObjectManager.getInstance().setState(Player.LIE_LEFT);
        ObjectManager.getInstance().setDirection(dir);
        ObjectManager.getInstance().setSitOrLie(true);
        ObjectManager.getInstance().setSubDepth(this.sprites[0].depth + 0.1);
        ObjectManager.getInstance().setCollObj(this.setStatePlayer);
        SendManager.getInstance().send('curState',info);

    }

    setStatePlayer = (state) => {
        if(state === 'Left') {
            this.left = false;
        } else if (state === 'Right') {
            this.left = false;
        }

        var info = {
            type: this.type,
            left: this.left,
            right: this.left,
            dir : state
        };
        

        SendManager.getInstance().send('leaveState',info);
    }

    setPoint(dir) {  
        let pos = {
            x:0,
            y:0
        };      
        if(dir === 'left') {
            pos.x = 1216;
            pos.y = 608;
            ObjectManager.getInstance().setPos(pos);
        } else {
            pos.x = 1344;
            pos.y = 704;
            ObjectManager.getInstance().setPos(pos);
        }
    }
}