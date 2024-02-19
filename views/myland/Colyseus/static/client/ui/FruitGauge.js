class FruitGauge {
    constructor() {
        this.isLoaded = false;
        this.fruitImage = new Image();
        this.fruitImage.src = '/static/client/assets/Images/fruitGaugeSheet.png';
        this.fruitImage.onload = () => {
            this.isLoaded = true;
        }

        this.fruitGaugeUI = {};
        this.fruitGaugeAnim = {
            "Level1": [[0, 0], [1, 0]],
            "Level2": [[2, 0], [3, 0]],
            "Level3": [[4, 0], [5, 0]],
            "Level4": [[6, 0], [7, 0]],
            "Level5": [[8, 0], [9, 0]],
            "Level6": [[10, 0], [11, 0]],
            "Level7": [[0, 1], [1, 1]],
            "Level8": [[2, 1], [3, 1]],
            "Level9": [[4, 1], [5, 1]],
            "Level10": [[6, 1], [7, 1]],
            "Level11": [[8, 1], [9, 1]],
        };
        this.curFruitGauge = 'Level1';
        this.curFruitGaugeFrame = 0;

        this.fruitGaugeUI.maxWidth = 1536;
        this.fruitGaugeUI.width = 128;
       
        this.fruitGaugeUI.maxHeight = 128;
        this.fruitGaugeUI.height = 64;
      
        this.fruitGaugeUI.frameCount = 60;      // 60 == 1초
        this.time = 0;
    }

    get frame() {
        return this.fruitGaugeAnim[this.curFruitGauge][this.curFruitGaugeFrame];
    }

    draw(ctx,posx,posy,level) {
        if(!this.isLoaded) return;
        ++this.time;

        this.curFruitGauge = level;

        if(this.time >= this.fruitGaugeUI.frameCount) {
            this.time = 0;
            if(this.curFruitGaugeFrame === 0) {
                this.curFruitGaugeFrame = 1
            } else {
                this.curFruitGaugeFrame = 0;
            }
        }

        const [frameX, frameY] = this.frame;
        const x = posx;
        const y = posy;

        ctx.drawImage(this.fruitImage,
            frameX * this.fruitGaugeUI.width, frameY * this.fruitGaugeUI.height,
            this.fruitGaugeUI.width, this.fruitGaugeUI.height,
            x - (this.fruitGaugeUI.width / 2), y - (this.fruitGaugeUI.height / 2),
            this.fruitGaugeUI.width, this.fruitGaugeUI.height);
    }

    destroy() {
        this.fruitImage = null;
    }
}