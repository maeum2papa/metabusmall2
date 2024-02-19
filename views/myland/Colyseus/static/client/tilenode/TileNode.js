class TileNode {
    constructor(isWall, x, y) {
        this.isWall = isWall ? isWall : false;
        this.x = x ? x : 0;
        this.y = y ? y : 0;
        this.g = 0;
        this.h = 0;
        this.f = 0;
        this.parentNode = null;
    }

    getF() {
        return this.g + this.h;
    }
}