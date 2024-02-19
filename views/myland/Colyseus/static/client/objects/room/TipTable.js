class TipTable extends Furniture{
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

        this.sprites[0].x = 849;
        this.sprites[0].y = 423;
    }

    option = () => { 
        if (tipDogam.style.display === 'block') {
            tipDogam.style.display = 'none';
            tipDogamPopup.style.display = 'none';
            UIManager.getInstance().removeElement(tipDogam);
        
        } else {
            tipDogam.style.display = 'block';
            UIManager.getInstance().setElement(tipDogam);
        
        }
    }
}

