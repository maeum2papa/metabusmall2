class InteractionObj {
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
        if (this.sprites.teleportType !== '') {
            let hr = '';
            let userId = +user_Info.otherUser;
            if (user_Info.room === 'land_office' || user_Info.room === 'land_class' || user_Info.room === 'land_education') {
                userId = +user_Info.currentUser;
            }

            if (this.sprites.teleportType === 'myland_inner') {
                hr = `/myland/inner_space/${userId}`;
            } else if (this.sprites.teleportType === 'myland_outer') {
                hr = `/myland/space/${userId}`;
            } else if (this.sprites.teleportType === 'land_office') {
                hr = '/land/office';
            } else if (this.sprites.teleportType === 'land_education') {
                hr = '/land/hall';
            }

            window.top.postMessage({ info: 'pageChange', href: hr }, '*');
        }

        if (this.sprites.popUpType !== '') {
            let idName = this.sprites.popUpType;
            window.top.postMessage({ info: 'popup', id: idName }, '*');
        }

        if (this.sprites.isWall) {

        }

        if (this.sprites.collState !== 'Default') {
            if (this.sprites.isFull) return;

            this.sprites.isFull = true;
            let pos = {
                x: this.sprites.x + this.offsetX,
                y: this.sprites.y + this.offsetY
            };

            let info = {
                type: this.indexName,
                isFull: this.sprites.isFull,
            };

            const startIndex = this.sprites.collState.lastIndexOf('_') + 1;
            const animType = this.sprites.collState.substring(startIndex, this.sprites.collState.length);

            let subdepth = animType !== 'Up' ? 0.01 : -0.01

            ObjectManager.getInstance().setPos(pos);
            ObjectManager.getInstance().setState(this.sprites.collState);
            ObjectManager.getInstance().setSitOrLie(true);
            ObjectManager.getInstance().setSubDepth(this.sprites.depth + subdepth);
            ObjectManager.getInstance().setCollObj(this.setStatePlayer);
            SendManager.getInstance().send('setInteractState', info);
        }


        if (this.sprites.property === 'fishing') {

            let info = {
                isFishing: true
            };
            SendManager.getInstance().onedataSend('fishing', info);
        }
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

