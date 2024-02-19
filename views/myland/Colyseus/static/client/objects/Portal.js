class Portal {

    constructor(context, x, y, name) {

        this.sprite = context.physics.add.image(x, y, name);
        this.sprite.setOrigin(0.5, 0.5);
        this.sprite.coll = false;
        this.sprite.outline = false;
        this.sprite.name = name;
        this.sprite.depth = -0.5;
        this.sprite.type = "portal";
        // context.physics.add.image()
        this.href = `/myland/inner_space/${user_Info.otherUser}`;

        this.sprite.outlineAdd = this.outlineAdd;
        this.sprite.outlineRemove = this.outlineRemove;
        this.sprite.collAdd = this.collAdd;

    
    }
   
    option = () => {
        window.top.postMessage({ info: 'pageChange', href: this.href }, '*');
    }

    outlineAdd = (outlineInstance) => {
        outlineInstance.add(this.sprite, {
            thickness: 3,
            outlineColor: Utils.OUTCOLOR
        });
    
        this.sprite.outline = true;
    } 

    outlineRemove = (outlineInstance) => {
        outlineInstance.remove(this.sprite);
        this.sprite.outline = false;
    }

    init = () => {

        this.sprite.ftOption = this.option;


    }
    collAdd = () => {
        this.sprite.coll = true;
    }
}