const schema = require('@colyseus/schema');
const { FurnitureType } = require('./FurnitureType');
const Schema = schema.Schema;

class Furniture extends Schema {
    constructor(type, turnituretype) {
        super();
        this.type = type;
        this.furnitureType = new schema.ArraySchema();
        this.left = false;
        this.right = false;
        
        for (let i = 0; i < turnituretype.length; ++i) {
            this.name = turnituretype[i].parentname;
            this.index = +turnituretype[i].index;
            var furniture = new FurnitureType(+turnituretype[i].index, turnituretype[i].name);
            this.furnitureType.push(furniture);
        }
    }

    changeType(newType) {
        for (let i = 0; i < newType.length; ++i) {
            this.name = newType[i].parentname;
            this.index = +newType[i].index;
            this.furnitureType[i].index = +newType[i].index;
            this.furnitureType[i].name = newType[i].name;
        }
    }
}

schema.defineTypes(Furniture, {
    name: "string",
    type: "string",
    index: "number",
    left: "boolean",
    right: 'boolean',
    furnitureType: [FurnitureType]
});

exports.Furniture = Furniture;