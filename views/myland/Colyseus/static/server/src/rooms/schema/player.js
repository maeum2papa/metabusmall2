const schema = require('@colyseus/schema');
const Schema = schema.Schema;
const type = schema.type
const { AbstractGameObjectSchema } = require('./AbstractGameObjectSchema');
const { PlayerPart } = require('./PlayerPart');
const { Fish } = require('../fish/fish');

class Player extends AbstractGameObjectSchema {
    inputQueue = [];
    aStarPosQueue = [];
    aStarArrowQueue = [];

    IsJump = false;
    z = 0;
    zSpeed = 1;
    zGravity = 0;
    zFloor = 0;
    maxHeight = -1;
    IsFocus = true;
    IsDance = false;
    seedCount = 0;

    static WALK_DOWN = 'Walk_Down';
    static WALK_LEFT = 'Walk_Left';
    static WALK_RIGHT = 'Walk_Right';
    static WALK_UP = 'Walk_Up';
    static IDLE_DOWN = 'Idle_Down';
    static IDLE_LEFT = 'Idle_Left';
    static IDLE_RIGHT = 'Idle_Right';
    static IDLE_UP = 'Idle_Up';
    static JUMP_DOWN = 'Jump_Down';
    static JUMP_LEFT = 'Jump_Left';
    static JUMP_RIGHT = 'Jump_Right';
    static JUMP_UP = 'Jump_Up';
    static SIT_DOWN = 'Sit_Down';
    static SIT_LEFT = 'Sit_Left';
    static SIT_RIGHT = 'Sit_Right';
    static SIT_UP = 'Sit_Up';
    static LIE_LEFT = 'Lie_Left';
    static LIE_RIGHT = 'Lie_Right';
    static DANCE_LEFT = 'Dance_Left';
    static DANCE_RIGHT = 'Dance_Right';

    constructor(id, x, y, speed, size, name, title, depart, fruit, playerParts, curroom, mywater, anywater,badge) {
        super(x, y, size, name);
        this.state = Player.IDLE_DOWN;
        this.id = id;
        this.speed = speed;
        this.title = title;
        this.depart = depart;
        this.badge = badge;
        
        this.fruit = fruit;
        this.curRoom = curroom;
        this.myWater = mywater;
        this.anyWater = anywater;

        this.isFishing = false;
        this.sitOrLie = false;

        this.sitOrLieType = '';
        this.leftOrRight = '';

        this.depth = 0;
        this.subDepth = 0;
        this.fishTime = 0;

        this.parts = new schema.ArraySchema();

        for (var type in playerParts) {
            try {
                var part = new PlayerPart(type, playerParts[type].name, playerParts[type].index, playerParts[type].frontDepth, playerParts[type].backDepth);
                this.parts.push(part);
            } catch (err) {
                console.log('part', playerParts[type], type);
            }

        }

        this.arrFish = new Map();
    }

    addPart(type, name, index, frontdepth, backdepth) {
        var part = new PlayerPart(type, name, index, frontdepth, backdepth);
        this.parts.push(part);
    }

    jumpReset() {
        this.z = this.zFloor;
        this.zGravity = 0;
        this.IsJump = false;
        this.maxHeight = -1;
    }

    addFish(arr) {
        for (let i = 0; i < arr.length; ++i) {
            this.arrFish.set(arr[i].index, new Fish(arr[i].index, arr[i].count));
        }
    }

    setSeed(count) {
        this.seedCount = count;
    }
}

schema.defineTypes(Player, {
    id: "string",
    state: "string",
    title: "string",
    depart: "string",
    badge: "string",
    curRoom: "string",
    sitOrLieType: "string",
    direction: "string",
    myWater: "string",
    anyWater: "string",
    isFishing: "boolean",
    sitOrLie: "boolean",
    score: "uint32",
    speed: "uint32",
    depth: "number",
    fruit: 'number',
    fishTime: "number",
    subDepth: "number",

    parts: [PlayerPart],
});
exports.Player = Player;