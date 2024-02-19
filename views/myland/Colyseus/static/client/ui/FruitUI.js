class FruitUI {
    constructor(context, x, y) {
        this.sprite = context.add.sprite(x, y, Assets.FRUITICONSHEET).setOrigin(0.5, 0.5);
        this.fruitbar = context.add.sprite(x, y, Assets.FRUITBARSHEET).setOrigin(0.5, 0.5);
        this.gauge = context.add.image(x, y, Assets.FRUITGAUGE).setOrigin(0, 0);

        this.sprite.setDepth(1000);
        this.fruitbar.setDepth(1000);
        this.gauge.setDepth(1000);

        this.sprite.setAlpha(0);
        this.fruitbar.setAlpha(0);
        this.gauge.setAlpha(0);

        this.gaugeMask = context.make.graphics();
        this.gaugeMask.setDepth(1001);
        this.gauge.mask = new Phaser.Display.Masks.GeometryMask(this, this.gaugeMask);

        this.gauge.x = x - (this.gauge.width / 3);
        this.gauge.y = y - (this.gauge.height / 2) + 26.5;

        this.isDone = false;

        this.maskWidth = 0;
        this.linear = 0.1;
    }

    render(average) {
        if (!this.isDone) {
            average /= 100;
            
            if (+average === 1 && this.maskWidth >= this.gauge.width - 0.01) {
                this.isDone = true;
                this.sprite.setAlpha(1);
                this.fruitbar.setAlpha(0);
                this.gauge.setAlpha(0);

                if (!this.sprite.anims.isPlaying) {
                    this.sprite.anims.play(Assets.FRUITICONSHEETPLAY);
                }
                return;
            } else if (+average <= 0) {
                average = 0;
            }

            if(!this.fruitbar.anims.isPlaying) {
                this.fruitbar.anims.play(Assets.FRUITBARSHEETPLAY);
            }

            this.fruitbar.setAlpha(1);
            this.gauge.setAlpha(1);

            this.maskWidth = Phaser.Math.Linear(this.maskWidth, average * this.gauge.width, this.linear);

            if (this.maskY < 0) {
                this.maskY = 0;
            }
            if (this.maskWidth > this.gauge.width) {
                this.maskWidth = this.gauge.width;
            }

            this.gauge.mask.geometryMask.clear();
            this.gauge.mask.geometryMask.fillRect(this.gauge.x, this.gauge.y, this.maskWidth, this.gauge.height);
        }
    }

    destroy() {
        this.sprite.destroy();
        this.fruitbar.destroy();
        this.gauge.destroy();
    }
}