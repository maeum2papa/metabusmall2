class Fruits {
    sprite; 
    level;
    index;
    constructor(context,x,y,level,index,depth,time) {
        this.sprite = context.physics.add.sprite(x,y,Assets.FRUITS).setOrigin(0.5,0.5);
        
        this.sprite.depth = depth;

        this.sprite.coll = false;
        this.sprite.outline = false;
        this.sprite.index = index;
        this.sprite.name = 'fruits';
        this.sprite.type = 'fruits' + index;

        this.level = level;
        this.index = index;

        this.sprite.anims.play(this.level,true);

        this.sprite.outlineAdd = this.outlineAdd;
        this.sprite.outlineRemove = this.outlineRemove;
        this.sprite.collAdd = this.collAdd;
        this.curTime = time;

        this.fruitUI = new FruitUI(context,x,y - this.sprite.height);

        this.sprite.collText = '를 눌러 상호작용';
    }

    levelUp(level) {
        this.level = level;
        this.sprite.anims.play(this.level,true);
    }

    outlineAdd = (outlineInstance) => {
        outlineInstance.add(this.sprite, {
            thickness: 3,
            outlineColor: Utils.OUTCOLOR
        });
    
        this.sprite.outline = true;
    } 

    outlineRemove = (outlineInstance) => {
        outlineInstance.remove(this.sprite);
        this.sprite.outline = false;
    }

    collAdd = () => {
        this.sprite.coll = true;
    }
    
    draw(ctx,scrollX,scrollY) {
        if(this.fruitGauge === undefined || this.fruitGauge === null || !this.fruitGauge) return; 
        const average = (1 - this.curTime / 480) * 100;

        let level = '';
        level = "Level" + `${Math.ceil(+average * 0.1)}`;
        
        if(+average === 100) {
            level = "Level11";
        } else if(+average <= 0) {
            level = "Level1";
        }

       this.fruitGauge.draw(ctx,this.sprite.x - scrollX, this.sprite.y - scrollY - 60,level);
    }

    render() {
        const average = (1 - this.curTime / 480) * 100;
        this.fruitUI.render(average);
    }

    destroy() {
        this.sprite.destroy();
        this.fruitUI.destroy();        
    }
}