class WallFloor extends Furniture{
    constructor(){
        super();
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
        
            if(-1 !== this.sprites[i].name.indexOf('_b_')) {
                this.sprites[i].x = 960;
                this.sprites[i].y = 540;
                this.sprites[i].depth = -0.9;
            } else {
                this.sprites[i].x = 960;
                this.sprites[i].y = 540;
                this.sprites[i].depth = 11;
            }

            this.sprites[i].outColl = false;
        }
    }

    setDepth = (height) => {
        
    }

    setChange = (arr) => { 
        for(let i = 0; i < this.sprites.length; ++i) {        
            if(-1 !== arr[i].name.indexOf('_b_')) {
                this.sprites[i].setTexture(arr[i].name);
                this.sprites[i].name = arr[i].name;
            } else {
                this.sprites[i].setTexture(arr[i].name);
                this.sprites[i].name = arr[i].name;
            }
        }
    }
}