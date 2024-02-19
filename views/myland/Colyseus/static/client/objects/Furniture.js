class Furniture {

    constructor() {
        this.x = 0;
        this.y = 0;
        this.type = '';
        this.name = '';        
        this.sprites = [];
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

            //Phaser.Math.Linear(0, 10, Utils.GetSortingOrder(0, height, this.sprites[i].y));

            ref.depth = -0.5;
            this.sprites.push(ref);
        }
     }
    initOption = () => {
        for (let i = 0; i < this.sprites.length; ++i) {
            this.sprites[i].ftOption = this.option;
            this.sprites[i].outlineAdd = this.outlineAdd;
            this.sprites[i].outlineRemove = this.outlineRemove;
            this.sprites[i].collAdd = this.collAdd;
        }
    }

    setDepth = (height) => {
        for (let i = 0; i < this.sprites.length; ++i) {
            this.sprites[i].depth = Utils.Linear(0, 10, Utils.GetSortingOrder(0, height, this.sprites[i].y));
        }
    }

    setChange = (arr) => {
        for (let i = 0; i < this.sprites.length; ++i) {
            this.sprites[i].setTexture(arr[i].name);
            this.sprites[i].name = arr[i].name;
        }
    }

    setCollsition(frontobjArr) {
        for (let i = 0; i < this.sprites.length; ++i) {     
            if (this.sprites[i].outColl) {   
                frontobjArr.push(this.sprites[i]);  
            }          
        }
    }

    outlineAdd = async (outlineInstance) => {
        if(this.coll) return;
        
        for (let i = 0; i < this.sprites.length; ++i) {
            if (this.sprites[i].outColl) {
                outlineInstance.add(this.sprites[i], {
                    thickness: 3,
                    outlineColor: Utils.OUTCOLOR
                });

                this.sprites[i].outline = true;
                
            }
        }
        this.coll = true;
    }

    outlineRemove = async (outlineInstance) => {
        for (let i = 0; i < this.sprites.length; ++i) {
            if (this.sprites[i].outColl) {
                outlineInstance.remove(this.sprites[i]);
                this.sprites[i].outline = false;                
            }
        }
        this.coll = false;
    }

    collAdd = () => {
        for (let i = 0; i < this.sprites.length; ++i) {           
            this.sprites[i].coll = true;
        }
    }

    option = () => { }
}