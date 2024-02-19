const schema = require('@colyseus/schema');
const Schema = schema.Schema;
const { Tile } = require('../obj/Tile');
const { TileToWorldXY, TileIntersects } = require('../../utils/utils');


class TileInfo extends Schema {
    colltile = [];
    collisionX;
    collisionY;
    
    constructor(tileinfo) {
        super();

        this.height = tileinfo.height;
        this.data = tileinfo.layers[0].data;
        this.name = tileinfo.layers[0].name;
        this.opacity = tileinfo.layers[0].opacity;
        this.type = tileinfo.layers[0].type;
        this.visible = tileinfo.layers[0].visible;
        this.width = tileinfo.layers[0].width;
        this.x = tileinfo.layers[0].x;
        this.y = tileinfo.layers[0].y;
        this.orientation = tileinfo.orientation;
        this.tileheight = tileinfo.tileheight;
        this.firstgid = tileinfo.tilesets[0].firstgid;
        this.image = tileinfo.tilesets[0].image;
        this.imageheight = tileinfo.tilesets[0].imageheight;
        this.imagewidth = tileinfo.tilesets[0].imagewidth;
        this.margin = tileinfo.tilesets[0].margin;
        this.tilesetsName = tileinfo.tilesets[0].name;
        this.spacing = tileinfo.tilesets[0].spacing;
        this.tilewidth = tileinfo.tilesets[0].tilewidth;
        this.version = tileinfo.version;

        //this.tileWithin(34);
    }

    tileWithin(index) {
        for (let i = 0; i < this.height; ++i) {
            for (let j = 0; j < this.width; ++j) {
                if (this.data[i * this.width + j] === index) {
                    const tile = new Tile(j, i, this.tilewidth, this.tileheight, index);
                    this.colltile.push(tile);
                }
            }
        }
        console.log(this.colltile);
    }

    tileCollision(player) {
      
        var tile;
        var tileWorldRect = {left:0,right:0,top:0,bottom:0};
        
        for(let i =0; i < this.colltile.length; ++i) {

             tile = this.colltile[i];

             tileWorldRect.left = tile.pixelX;
             tileWorldRect.top = tile.pixelY;
             tileWorldRect.right = tileWorldRect.left + tile.width;
             tileWorldRect.bottom = tileWorldRect.top + tile.height;
           
             if(TileIntersects(tileWorldRect,player)) {
                return tile;
             }
        }
        return false;
    }
}

schema.defineTypes(TileInfo, {
    height: "number",
    data: ["number"],
    name: "string",
    opacity: "number",
    type: "string",
    visible: "boolean",
    width: "number",
    x: "number",
    y: "number",
    orientation: "string",
    tileheight: "number",
    firstgid: "number",
    image: "string",
    imageheight: "number",
    imagewidth: "number",
    margin: "number",
    tilesetsName: "string",
    spacing: "number",
    tilewidth: "number",
    version: "number"
})


exports.TileInfo = TileInfo