class Background {
    name;
    depth;
    image;
    constructor(context,name,depth) {
        this.name = name;
        this.depth = depth;

        this.image = context.add.image(0,0,name);
        this.image.name = name;
        this.image.depth = depth;
        this.image.setOrigin(0,0);
        
    }
}