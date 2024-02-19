const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class InteractionObj extends Schema {
  constructor(name, indexname, info) {
    super();

    this.name = name;
    this.indexName = indexname;
    this.property = info.property !== undefined ? info.property : 'default';
    this.collState = info.collState !== undefined ? info.collState : 'Default';
    this.teleportType = info.teleportType !== undefined ? info.teleportType : '';
    this.popUpType = info.popUpType !== undefined ? info.popUpType : '';

    this.isWall = info.isWall !== undefined ? info.isWall : false;
    this.isOverlap = info.isOverlap !== undefined ? info.isOverlap : false;
    this.isSpriteSheet = info.isSpriteSheet !== undefined ? info.isSpriteSheet : false;
    this.isYoyo = info.isYoyo !== undefined ? info.isYoyo : false;

    this.x = info.x !== undefined ? +info.x : 0;
    this.y = info.y !== undefined ? +info.y : 0;
    this.depth = info.depth !== undefined ? +info.depth : 0;
    this.offsetX = info.offsetX !== undefined ? +info.offsetX : 0;
    this.offsetY = info.offsetY !== undefined ? +info.offsetY : 0;
    this.sheetWidth = info.sheetWidth !== undefined ? +info.sheetWidth : 0;
    this.sheetHeight = info.sheetHeight !== undefined ? +info.sheetHeight : 0;   
    this.numFrame = info.numFrame !== undefined ? +info.numFrame : 0;
    this.frameCount = info.frameCount !== undefined ? +info.frameCount : 0;
    this.collText = info.collText !== undefined ? info.collText : '를 눌러 상호작용';

    this.collisionBefore = info.collisionBefore !== undefined ? info.collisionBefore : '';   
    this.collisionAfter = info.collisionAfter !== undefined ? info.collisionAfter : '';   

    this.collisionName = info.collisionName !== undefined ? info.collisionName : '';
    this.collisionOffsetX = info.collisionOffsetX !== undefined ? +info.collisionOffsetX : 0;
    this.collisionOffsetY = info.collisionOffsetY !== undefined ? +info.collisionOffsetY : 0;

    this.isFull = false;
  }

  getFull() {
    return this.isFull;
  }

  setFull(bool) {
    this.isFull = bool;
  }
}

schema.defineTypes(InteractionObj, {
  name: "string",
  indexName: "string",
  property: "string",
  collState: "string",
  teleportType: "string",
  popUpType: "string",
  collText : "string",
  collisionBefore:"string",
  collisionAfter: "string",
  collisionName : "string",
  isWall: "boolean",
  isOverlap: "boolean",
  isFull: "boolean",
  isSpriteSheet: "boolean",
  isYoyo: "boolean",
  x: "number",
  y: "number",
  depth: "number",
  offsetX: "number",
  offsetY: "number",
  sheetWidth: "number",
  sheetHeight: "number",
  numFrame: "number",
  frameCount: "number",  
  collisionOffsetX: "number",
  collisionOffsetY: "number",
});


exports.InteractionObj = InteractionObj;



