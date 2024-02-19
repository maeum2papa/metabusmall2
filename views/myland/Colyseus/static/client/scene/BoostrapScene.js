class BoostrapScene extends Phaser.Scene {
    static KEY = 'bootstrap';

    constructor() {
        super(BoostrapScene.name);
        this.assets = new Assets(this);
    }

    preload() {
        loading.style.display = "block";

        this.assets.load();
    }

    async create() {
        while (undefined === user_Info.currentUser) {
            await this.sleep(1000);
        }

        this.scale.pageAlignHorizontally = true;
        this.scale.pageAlignVertically = true;


        if (user_Info.currentUser === "3" || user_Info.currentUser === "101") {
            this.scene.launch(MapMakeScene.name);
        } else if (user_Info.room === 'gameeducation') {
            this.scene.launch(GameEducationScene.name);
        } else {
            this.scene.launch(GameScene.name);
        }
    }

    async sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
}

// exports.BoostrapScene = BoostrapScene;