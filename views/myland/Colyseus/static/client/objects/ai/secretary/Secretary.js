class Secretary {
    constructor(context, name, indexname, x, y, depth, iswall, isoverlap, isfull, collstate, offsetx, offsety, property, teleportType, popupType, isspritesheet, colltext
        , collisionName, collisionOffsetX, collisionOffsetY) {
        this.indexName = indexname;
        let isSheet = isspritesheet;

        if (isSheet) {
            this.sprites = context.physics.add.sprite(x, y, name).setOrigin(0.5, 0.5);
            this.sprites.anims.play(name);

        } else {
            this.sprites = context.physics.add.image(x, y, name).setOrigin(0.5, 0.5);
        }

        this.sprites.name = name;
        this.sprites.type = indexname;
        this.sprites.depth = depth;
        this.sprites.isWall = iswall;
        this.sprites.isOverlap = isoverlap;
        this.sprites.isFull = isfull;
        this.sprites.collState = collstate;
        this.sprites.property = property;
        this.sprites.teleportType = teleportType;
        this.sprites.popUpType = popupType;
        this.sprites.isSpriteSheet = isspritesheet;
        //  this.sprites.collText = colltext;

        this.sprites.collText = '를 눌러 상호작용';     //test        

        this.offsetX = offsetx;
        this.offsetY = offsety;

        this.sprites.coll = false;
        this.sprites.outline = false;

        if (!this.sprites.isOverlap && this.sprites.collState === 'Default' && this.sprites.property === 'default' && this.sprites.teleportType === '' && this.sprites.popUpType === '') {
            this.sprites.outColl = false;
        } else {
            this.sprites.outColl = true;
        }

        this.sprites.ftOption = this.option;
        this.sprites.outlineAdd = this.outlineAdd;
        this.sprites.outlineRemove = this.outlineRemove;
        this.sprites.collAdd = this.collAdd;

        if (collisionName !== '') {
            this.createCollisionDom(context, collisionName, collisionOffsetX, collisionOffsetY);
        }


        // "myland_inner";
        // "myland_outer";
        // "land_office";
        // "land_education";            ../ 텔레포트 타입        
    }

    setIsFull(full) {
        this.sprites.isFull = full;
    }

    setCollsition(frontobjArr) {
        if (this.sprites.outColl) {
            frontobjArr.push(this.sprites);
        }
    }

    setStatePlayer = (state) => {
        this.sprites.isFull = false;
        let info = {
            type: this.indexName,
            isFull: this.sprites.isFull,
        };

        SendManager.getInstance().send('setInteractState', info);
    }

    option = () => {
        infoBox.style.display = 'block';
        infoBox.focus();
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
            .setOrigin(0,0)
            .setDepth(100)
            .setAlpha(0);

        this.sprites.domObj = dom;
    }
}