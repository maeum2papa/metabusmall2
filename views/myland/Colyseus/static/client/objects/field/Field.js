class Field {
    constructor(context, name, indexname, x, y, depth, iswall, isoverlap, isfull, collstate, offsetx, offsety,
         property, teleportType, isspritesheet, index, colltext,collisionName,collisionOffsetX,collisionOffsetY) {
        this.indexName = indexname;

        this.sprites = context.physics.add.image(x, y, name).setOrigin(0.5, 0.5);
    
        this.sprites.depth = depth;
        this.sprites.name = property;
        this.sprites.type = indexname;
        this.sprites.isWall = iswall;
        this.sprites.isOverlap = isoverlap;
        this.sprites.isFull = isfull;
        this.sprites.collState = collstate;
        this.sprites.property = property;
        this.sprites.teleportType = teleportType;
        this.sprites.isSpriteSheet = isspritesheet;
        this.sprites.index = index; 
        this.sprites.collText = colltext;         

        this.sprites.collOffsetX = offsetx;
        this.sprites.collOffsetY = offsety;
        this.offsetX = offsetx;
        this.offsetY = offsety;

        this.sprites.coll = false;
        this.sprites.outline = false;
        this.sprites.outColl = true;

        this.sprites.ftOption = this.option;
        this.sprites.outlineAdd = this.outlineAdd;
        this.sprites.outlineRemove = this.outlineRemove;
        this.sprites.collAdd = this.collAdd;

        this.index = 0;

        if(collisionName !== '') {
            this.createCollisionDom(context,collisionName,collisionOffsetX,collisionOffsetY);
        }
    }


    setCollsition(frontobjArr) {
        this.index = frontobjArr.length;
        if (+user_Info.otherUser !== +user_Info.currentUser) return;
           
        frontobjArr.push(this.sprites);
    }

    option = () => {

    }

    outlineAdd = (outlineInstance) => {
        outlineInstance.add(this.sprites, {
            thickness: 3,
            outlineColor: Utils.OUTCOLOR
        });
    
        this.sprites.outline = true;
        if (this.sprites.domObj) {
            this.sprites.domObj.setAlpha(1);
        }
    }

    outlineRemove = (outlineInstance) => {
        outlineInstance.remove(this.sprites);
        this.sprites.outline = false;
        if (this.sprites.domObj) {
            this.sprites.domObj.setAlpha(0);
        }
    }

    collAdd = () => {
        this.sprites.coll = true;
    }

    createCollisionDom(context, name, offsetX, offsetY) {
        const collisionName = document.createElement('div');
        collisionName.classList.add("collisionname");

        const collisionLeft = document.createElement('div');
        const collisionText = document.createElement('span');
        const collisionRight = document.createElement('div');

        collisionLeft.classList.add("collisionname_left");
        collisionText.classList.add("collisionname_text");
        collisionRight.classList.add("collisionname_right");

        collisionText.innerText = name;

        collisionName.appendChild(collisionLeft);
        collisionName.appendChild(collisionText);
        collisionName.appendChild(collisionRight);

        Box.appendChild(collisionName);

        const dom = context.add.dom(this.sprites.x + offsetX, this.sprites.y + offsetY, collisionName)
            .setOrigin(0, 0)
            .setDepth(100)
            .setAlpha(0);
        this.sprites.domObj = dom;
    }
}



