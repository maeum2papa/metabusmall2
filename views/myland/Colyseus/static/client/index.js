// const { BoostrapScene } = require("./scene/BoostrapScene")
// const { GameScene } = require("./scene/GameScene")
// import { BoostrapScene } from "./scene/BoostrapScene"
// import { GameScene } from "./scene/GameScene"


var config = {
  type: Phaser.AUTO,
  parent: 'gamecontainer',//'phaser-example',
  width: window.innerWidth,
  height: window.innerHeight,
  pixelArt: true,     //pixelPerfact 알아보자.
  backgroundColor: '#ffffff',
  physics: {
    default: 'arcade',
    arcade: {
      debug: false,
      gravity: { y: 0 }
    }
  },
  scale: {
    mode: Phaser.Scale.RESIZE,
    autoCenter: Phaser.Scale.CENTER_BOTH,
  },
  scene: [BoostrapScene, GameScene, MapMakeScene, GameEducationScene],
  plugins: {
    scene: [
      {
        key: 'rexUI',
        plugin: rexuiplugin,
        mapping: 'rexUI'
      }
    ]
  },
 
}

var game = new Phaser.Game(config);