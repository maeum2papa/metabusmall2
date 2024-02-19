class GameManager {
    static instance;
    constructor() {
        this.bottomLeft;
        this.topRight;
        this.startPos;
        this.targetPos;

        this.finalNodeList = [];

        this.allowDiagonal = false;
        this.dontCrossCorner = true;

        this.sizeX;
        this.sizeY;

        this.nodeArr;

        this.startNode;
        this.TargetNode;
        this.curNode;

        this.openList;
        this.closedList;

        this.startTR;
        this.targetTR;
        this.isFind = false;
        this.isfirst = false;
        this.isfirstTile = false;

        this.playerTileX = 0;
        this.playerTileY = 0;
        this.tileX = 0;
        this.tileY = 0;

        this.graphics = null;

        this.isWater = false;
    }

    static getInstance() {
        if (!GameManager.instance) {
            GameManager.instance = new GameManager();
        }

        return GameManager.instance;
    }




    // if (this.map !== null) {
    //     if (this.inputPayload.ctrl) {
    //         this.maps.curObjSprite.x = worldPoint.x;
    //         this.maps.curObjSprite.y = worldPoint.y;
    //     } else {
    //         const pointerTileX = this.map.worldToTileX(worldPoint.x);
    //         const pointerTileY = this.map.worldToTileY(worldPoint.y);

    //         const posX = this.map.tileToWorldX(pointerTileX);
    //         const posY = this.map.tileToWorldY(pointerTileY);

    //         this.maps.curObjSprite.x = posX;
    //         this.maps.curObjSprite.y = posY;




    pathFinding(context, startTr, targetTr) {

        this.startTR = startTr;
        this.targetTR = targetTr;

        this.startPos = {
            x: context.map.worldToTileX(Math.floor(startTr.x)),
            y: context.map.worldToTileY(Math.floor(startTr.y))
        }
        this.targetPos = {
            x: context.map.worldToTileX(Math.floor(targetTr.x)),
            y: context.map.worldToTileY(Math.floor(targetTr.y))
        }

        this.bottomLeft = {
            x: Math.floor(Math.min(this.startPos.x, this.targetPos.x)),
            y: Math.floor(Math.min(this.startPos.y, this.targetPos.y))
        };

        this.topRight = {
            x: Math.floor(Math.max(this.startPos.x, this.targetPos.x)),
            y: Math.floor(Math.max(this.startPos.y, this.targetPos.y))
        };


        // this.sizeX = this.topRight.x - this.bottomLeft.x + 1;
        // this.sizeY = this.topRight.y - this.bottomLeft.y + 1;
        this.sizeX = context.map.width + 1;
        this.sizeY = context.map.height + 1;

        this.nodeArr = [];

        for (let i = 0; i < this.sizeX; ++i) {
            this.nodeArr[i] = [];
            for (let j = 0; j < this.sizeY; ++j) {
                let isWall = false;

                // 벽 wall 판단 넣어야                
                // const tile = context.map.getTileAt(i + this.bottomLeft.x,j + this.bottomLeft.y);
                const tile = context.map.getTileAt(i, j);
                if (tile) {
                    if (tile.properties.option !== undefined && tile.properties.option === 'Wall' || tile.properties.option === 'WallPrivate') {
                        isWall = true;
                    }
                }

                // this.nodeArr[i][j] = new TileNode(isWall, i + this.bottomLeft.x, j + this.bottomLeft.y);
                this.nodeArr[i][j] = new TileNode(isWall, i, j);
            }
        }

        // this.startNode = this.nodeArr[this.startPos.x - this.bottomLeft.x][this.startPos.y - this.bottomLeft.y];
        // this.TargetNode = this.nodeArr[this.targetPos.x - this.bottomLeft.x][this.targetPos.y - this.bottomLeft.y];
        this.startNode = this.nodeArr[this.startPos.x][this.startPos.y];
        this.TargetNode = this.nodeArr[this.targetPos.x][this.targetPos.y];


        this.openList = [];
        this.openList.push(this.startNode);
        this.closedList = [];
        this.finalNodeList = [];

        while (this.openList.length > 0) {
            this.curNode = this.openList[0];

            for (let i = 1; i < this.openList.length; ++i) {

                if (this.openList[i].getF() <= this.curNode.getF() && this.openList[i].h < this.curNode.h) {
                    this.curNode = this.openList[i];
                }
            }
            this.remove(this.openList, this.curNode);
            let closenode = this.curNode;
            this.closedList.push(closenode);

            if (this.curNode === this.TargetNode) {
                let targetCurNode = this.TargetNode;
                while (targetCurNode !== this.startNode) {
                    this.finalNodeList.push(targetCurNode);
                    targetCurNode = targetCurNode.parentNode;
                }

                let startN = this.startNode;
                this.finalNodeList.push(startN);
                this.finalNodeList.reverse();


                this.isfirst = true;
                this.isfirstTile = true;
                this.isFind = true;
                return;
            }

            if (this.allowDiagonal) {

            }

            this.openListAdd(this.curNode.x, this.curNode.y + 1);
            this.openListAdd(this.curNode.x + 1, this.curNode.y);
            this.openListAdd(this.curNode.x, this.curNode.y - 1);
            this.openListAdd(this.curNode.x - 1, this.curNode.y);

            if (this.openList.length === 0) {
                let closedNode = this.findClosedWall();
                if (closedNode) {
                    let targetNode = closedNode;
                    while (targetNode !== this.startNode) {
                        this.finalNodeList.push(targetNode);
                        targetNode = targetNode.parentNode;
                    }

                    let startN = this.startNode;
                    this.finalNodeList.push(startN);
                    this.finalNodeList.reverse();

                    this.isfirst = true;
                    this.isfirstTile = true;
                    this.isFind = true;
                    return;
                }
                else {
                    return;
                }
            }
        }
    }

    remove(list, node) {
        const index = list.indexOf(node);
        if (index !== -1) {
            list.splice(index, 1);
        }
    }

    openListAdd(checkX, checkY) {

        // let arrX = checkX - this.bottomLeft.x;
        // let arrY = checkY - this.bottomLeft.y;
        let arrX = checkX;
        let arrY = checkY;

        // if (checkX >= this.bottomLeft.x && checkX < this.topRight.x + 1 &&
        //     checkY >= this.bottomLeft.y && checkY < this.topRight.y + 1 &&
        //     !this.nodeArr[arrX][arrY].isWall &&
        //     !this.closedList.includes(this.nodeArr[arrX][arrY])) {

        if (arrX >= 0 && arrX < this.sizeX - 1 &&
            arrY >= 0 && arrY < this.sizeY - 1 &&
            !this.nodeArr[arrX][arrY].isWall &&
            !this.closedList.includes(this.nodeArr[arrX][arrY])) {
            if (this.allowDiagonal) {

            }

            if (this.dontCrossCorner) {
                // if (this.nodeArr[this.curNode.x - this.bottomLeft.x][arrY].isWall &&
                //     this.nodeArr[arrX][this.curNode.y - this.bottomLeft.y].isWall) {
                //     return;
                // }
                if (this.nodeArr[this.curNode.x][arrY].isWall &&
                    this.nodeArr[arrX][this.curNode.y].isWall) {
                    return;
                }
            }

            let neighborNode = this.nodeArr[arrX][arrY];
            let moveCost = this.curNode.g + (this.curNode.x - checkX === 0 || this.curNode.y - checkY === 0 ? 10 : 14);
            // https://m.blog.naver.com/lbs0718/221182030733   << 최적화 코스트 비용 정렬하면 최적화?
            if (moveCost < neighborNode.g || !this.openList.includes(neighborNode)) {
                neighborNode.g = moveCost;
                neighborNode.h = (Math.abs(neighborNode.x - this.TargetNode.x) + Math.abs(neighborNode.y - this.TargetNode.y)) * 10;
                let curnode = this.curNode;
                neighborNode.parentNode = curnode;

                this.openList.push(neighborNode);
            }
        }
    }

    draw(context) {
        if(this.graphics !== null) {
            this.graphics.clear();
        }
        this.graphics = context.add.graphics({ lineStyle: { width: 4, color: 0xffff33 } });

        this.graphics.lineStyle(2, 0xffff33);
        this.graphics.beginPath();
        this.graphics.moveTo(this.startTR.x, this.startTR.y);
        this.graphics.setDepth(1000);
        if (this.finalNodeList.length !== 0) {
            for (let i = 0; i < this.finalNodeList.length; ++i) {
                this.graphics.lineTo(this.finalNodeList[i].x * 32 + 16, this.finalNodeList[i].y * 32 + 16);
            }
        }

        this.graphics.strokePath();
    }

    AStarFollow(context, player, inputPayload, pos, duration, delta) {

        if (this.finalNodeList.length !== 0 && this.isFind) {
            if (this.finalNodeList.length === 1) {
                this.isFind = false; 
                return 0;
            }

            let finalX = context.map.tileToWorldX(this.finalNodeList[1].x) + 16;
            let finalY = context.map.tileToWorldY(this.finalNodeList[1].y) - 16 - 8;

            let final = new Phaser.Math.Vector2();
            final.x = finalX;
            final.y = finalY;

            let position = new Phaser.Math.Vector2();
            position.x = pos.x;
            position.y = pos.y;

            let AstarPos = Utils.moveTowards(position, final, 4);

            const distance = Phaser.Math.Distance.BetweenPoints(pos, final);
            if (distance < 5) {
                this.remove(this.finalNodeList, this.finalNodeList[0]);

                // console.log("remove", pos.y);
                // console.log("remove", this.finalNodeList);                
            }

            if (this.finalNodeList.length === 0) {
                this.isFind = false;
            }
            return AstarPos;
        }

        return 0;
    }

    findClosedWall() {
        let closedNode = null;
        let closedDistance = Number.MAX_SAFE_INTEGER;

        for (let i = 0; i < this.closedList.length; ++i) {
            const curNode = this.closedList[i];
            const distance = Phaser.Math.Distance.Between(this.TargetNode.x, this.TargetNode.y, curNode.x, curNode.y);
            if (distance < closedDistance) {
                closedDistance = distance;
                closedNode = curNode;
            }
        }

        return closedNode;
    }

    nodeReset() {
        this.finalNodeList = [];
        this.isfirst = false;
        this.isFind = false;
    }

    getIsWater() {
        return this.isWater;
    }

    setIsWater(iswater) {
        this.isWater = iswater;
    }
}