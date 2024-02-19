const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class PlayerPart extends Schema {
    constructor(type,name,index,frontdepth,backdepth) {
        super();
        this.type = type;
        this.name = name;
        this.index = index;
        this.frontDepth = frontdepth;
        this.backDepth = backdepth;
    }
}

schema.defineTypes(PlayerPart, {
    type:"string",
    name:"string",
    index:"number",
    frontDepth:"number",
    backDepth:"number"
})

exports.PlayerPart = PlayerPart;