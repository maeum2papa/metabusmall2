const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class GroundFruit extends Schema {
    constructor(x, y, index) {
        super();
        this.x = x;
        this.y = y;
        this.index = index;
        this.coll = false;
        this.id = '';
    }

    setColl(coll) {
        this.coll = coll;
    }

    setId(id) {
        this.id = id;
    }
}

schema.defineTypes(GroundFruit, {
    x: "number",
    y: "number",
    index: "number",
    coll:"boolean",
    id : "string"
});

exports.GroundFruit = GroundFruit;