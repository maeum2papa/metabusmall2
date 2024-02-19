const schema = require('@colyseus/schema');
const Schema = schema.Schema;

const { PlatformDef } = require('./PlatformDef');
const { TileInfo } = require('./TileInfo');

class MapLevel extends Schema {
    constructor(width, height,index, name){
        super();
        // this.platformDefs = new schema.ArraySchema<PlatformDef>(
        //     new PlatformDef(40,40)  // 벽 타일 류 
        //     );
        //this.tile = new TileInfo(tileinfo);
        this.width = width;
        this.height = height;  // 맵크기  서버에서 맵크기 받아서 적용해야 함
        this.index = index;
        this.name = name;
    }
}
schema.defineTypes(MapLevel, {
    //platformDefs: [PlatformDef],
    width:"uint16",
    height:"uint16",
    //tile: TileInfo,
    index:"number",
    name:"string"
  });


  exports.MapLevel = MapLevel;
  