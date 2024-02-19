class FishingUI {
    constructor(context, x, y) {
        this.sprite = context.add.sprite(x, y, Assets.FISHINGSHEET).setOrigin(0.5, 0.5);
        this.sprite.setAlpha(0);
        this.sprite.setDepth(1000);

        this.gauge = context.add.image(x, y, Assets.FISHINGGAUGE).setOrigin(0, 0);
        this.gauge.setAlpha(0);
        this.gauge.setDepth(1001);

        this.gaugeMask = context.make.graphics();
        this.gaugeMask.setDepth(1001);
        this.gauge.mask = new Phaser.Display.Masks.GeometryMask(this, this.gaugeMask);

        this.gaugeMaskHeight = this.gauge.height;
        this.maskY = this.gauge.height;
        this.maskHeight = 0;
        this.linear = 0.5;
    }

    start(x, y, index) {
        this.sprite.x = x + (this.sprite.width / 4);
        this.sprite.y = y;
        this.gauge.x = this.sprite.x - (this.gauge.width / 2) - 9.5;
        this.gauge.y = this.sprite.y - (this.gauge.height / 2) + 17;

        this.sprite.setAlpha(1);
        this.gauge.setAlpha(1);

        if (!this.sprite.anims.isPlaying) {
            this.sprite.anims.play(Assets.FISHINGSHEETPLAY);
        }
        this.maskY = Phaser.Math.Linear(this.maskY, this.gaugeMaskHeight - (index * (this.gaugeMaskHeight * 0.1)), this.linear);
        this.maskHeight = Phaser.Math.Linear(this.maskHeight, index * (this.gaugeMaskHeight * 0.1), this.linear);

        if(this.maskY < 0) {
            this.maskY = 0;
        }
        if (this.maskHeight > this.gauge.height) {
            this.maskHeight = this.gauge.height;
        }

        this.gauge.mask.geometryMask.clear();
        this.gauge.mask.geometryMask.fillRect(this.gauge.x, this.gauge.y + this.maskY , this.gauge.width, this.maskHeight);
    }

    end() {
        this.sprite.setAlpha(0);
        this.gauge.setAlpha(0);

        this.maskHeight = 0;
        this.maskY = this.gauge.height;

        this.gauge.mask.geometryMask.clear();
        this.gauge.mask.geometryMask.fillRect(this.gauge.x, this.gauge.y, this.gauge.width, this.maskHeight);
        if (this.sprite.anims.isPlaying) {
            this.sprite.stop();
        }
    }
}