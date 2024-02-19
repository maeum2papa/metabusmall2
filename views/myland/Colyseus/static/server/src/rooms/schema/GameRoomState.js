const schema = require('@colyseus/schema');
const Schema = schema.Schema;
const { Player } = require('./player');
const { MapLevel } = require('./MapLevel');
const { Crops } = require('./Crops');
const { Furniture } = require('./Furniture');
const { InteractionObj } = require('./InteractionObj');
const { GroundFruit } = require('./GroundFruit');


class GameRoomState extends Schema {
  constructor() {
    super();

    this.players = new schema.MapSchema();
    this.crops = new schema.MapSchema();
    this.maplevel = new schema.Schema();
    this.furniture = new schema.MapSchema();
    this.interactionObj = new schema.MapSchema();
    this.groundFruits = new schema.MapSchema();
  }

  addPlayer(id, x, y, speed, size, name, title, depart, fruit, playerParts, curroom, mywater, anywater,badge) {
    const player = new Player(id, x, y, speed, size, name, title, depart, fruit, playerParts, curroom, mywater, anywater,badge);

    // 841, 1254,
    return player;
  }

  addCrops(index, level, total) {
    const crops = new Crops(index, level, total);
    return crops;
  }

  addMapLevel(width, height, index, name) {
    const map = new MapLevel(width, height, index, name);
    return map;
  }

  addFurniture(type, truniture) {
    const furniture = new Furniture(type, truniture);
    return furniture;
  }

  addInteractionObj(name, indexname, info) {
    const interactionObj = new InteractionObj(name, indexname, info);
    return interactionObj;
  }

  addGroundFruit(x,y,index) {
    const groundfruit = new GroundFruit(x,y,index);
    return groundfruit;
  }
}

schema.defineTypes(GameRoomState, {
  players: { map: Player },
  crops: { map: Crops },
  maplevel: MapLevel,
  furniture: { map: Furniture },
  interactionObj: { map: InteractionObj },
  groundFruits: { map: GroundFruit }
});

exports.GameRoomState = GameRoomState;