class GroundFruit {
    constructor(context, x, y, index, height) {
        this.fruit = context.physics.add.image(x, y, Assets.GROUNDFRUIT).setOrigin(0.5, 0.5);
        this.fruit.x = x - 16;
        this.fruit.y = y - 16;
       // this.fruit.setScale(0.1, 0.1);
        this.fruit.index = index;
        this.fruit.setDepth(Utils.Linear(0, 10, Utils.GetSortingOrder(0, height, y)));
        this.fruit.outline = false;
        this.fruit.coll = false;
        this.fruit.select = false;
        this.fruit.arrIndex = 0;
        this.IsCollision = false;
        this.tween = context.tweens.add({
            targets: this.fruit,
            y: '+=10',
            ease: 'Sine.easeInOut',
            duration: 1000,
            yoyo: true,
            repeat: -1
        });

        this.fruit.ftOption = this.option;
        this.fruit.outlineAdd = this.outlineAdd;
        this.fruit.outlineRemove = this.outlineRemove;
        this.fruit.collAdd = this.collAdd;

        this.frontArr;
    }

    setCollsition(frontobjArr) {
        frontobjArr.push(this.fruit);
        this.frontArr = frontobjArr; 
        this.fruit.arrIndex = frontobjArr.length - 1; 
    }
    
    option = () => {
        if(this.fruit.select) return;

        this.fruit.select = true;
        this.tween.remove();
        delete this.frontArr[this.fruit.arrIndex];

        SendManager.getInstance().onedataSend('GroundFruitCollision',this.fruit.index);
      //  this.targetFollow();
    }

    outlineAdd = (outlineInstance) => {
        if(this.fruit.select) return;

        outlineInstance.add(this.fruit, {
            thickness: 3,
            outlineColor: Utils.OUTCOLOR
        });

        this.fruit.outline = true;
    }

    outlineRemove = (outlineInstance) => {
        outlineInstance.remove(this.fruit);
        this.fruit.outline = false;
    }

    collAdd = () => {
        this.fruit.coll = true;
    }

    collisionOp() {
        if(this.fruit.select) return;
        this.fruit.select = true;
        this.tween.remove();
        delete this.frontArr[this.fruit.arrIndex];
    }

    destroy() {
       // this.tween.remove();
        this.fruit.destroy();        
    }

    targetFollow() {
        const update = () => {
            const targetPos = ObjectManager.getInstance().getObjectPos();
            
            let target = new Phaser.Math.Vector2(targetPos.x,targetPos.y);
            let fruit = new Phaser.Math.Vector2(this.fruit.x,this.fruit.y);
 
            let pos = Utils.moveTowards(fruit,target,2);
 
            this.fruit.x = pos.x;
            this.fruit.y = pos.y;

            let distance = Phaser.Math.Distance.Between(this.fruit.x, this.fruit.y, target.x, target.y);

            if(distance <= 3) {
                this.destroy();
                return;
            }

            requestAnimationFrame(update);
        }

        update();
    }
}