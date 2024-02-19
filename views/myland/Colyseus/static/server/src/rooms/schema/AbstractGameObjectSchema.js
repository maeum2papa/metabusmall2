const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class AbstractGameObjectSchema extends Schema{
    
    constructor(x,y,size,name) {
        super();
        this.x = x;
        this.y = y;
        this.size = size;
        this.name = name;
    }
}

schema.defineTypes(AbstractGameObjectSchema, {
    x:"number",
    y:"number",
    size:"number",
    name:"string"
  });

exports.AbstractGameObjectSchema = AbstractGameObjectSchema;