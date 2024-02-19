const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class PlatformDef extends Schema {
    constructor(x,y) {
        super();
    this.x = x;
    this.y = y;
    }
}

schema.defineTypes(PlatformDef, {
   x:"number",
   y:"number",
});

exports.PlatformDef = PlatformDef;