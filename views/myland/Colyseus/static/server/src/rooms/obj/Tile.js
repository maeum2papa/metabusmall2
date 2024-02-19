class Tile {
    x;
    y;
    index;
    width;
    height;
    right;
    bottom;
    pixelX;
    pixelY;

    constructor(x,y,width,height,index) {
        this.x = x;
        this.y = y;
        this.index = index;
        this.width = width;
        this.height = height;

        this.pixelX = this.x * this.width;
        this.pixelY = this.y * this.height;
    }
}

exports.Tile = Tile