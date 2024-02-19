const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class FurnitureType extends Schema {
    constructor(index,name) {
        super();
        
        this.index = index;         //아이템 코드
        this.name = name;           //item_img_in에 있는 name ex) wallfloor_b_basic
    }
}

schema.defineTypes(FurnitureType, {
   index:"number",
   name:"string",  
});

exports.FurnitureType = FurnitureType;