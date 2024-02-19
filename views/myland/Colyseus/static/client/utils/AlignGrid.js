class AlignGrid {
    constructor(config) {
        if (!config.scene) {
            console.log("missing scene");
            return;
        }

        this.h = config.height || game.config.height;
        this.w = config.width || game.config.width;
        this.rows = config.rows || 3;
        this.cols = config.cols || 3;
        this.scene = config.scene;
        this.cw = this.w / this.cols;
        this.ch = this.h / this.rows;
        this.TextArr = [];
        this.graphics;
    }

    show(a = 1) {
        this.graphics = this.scene.add.graphics();
        this.graphics.lineStyle(4, 0xff0000, a);

        for (var i = 0; i < this.w; i += this.cw) {
            this.graphics.moveTo(i, 0);
            this.graphics.lineTo(i, this.h);
        }
        for (var i = 0; i < this.h; i += this.ch) {
            this.graphics.moveTo(0, i);
            this.graphics.lineTo(this.w, i);
        }
        this.graphics.strokePath();
    }

    placeAt(xx, yy, obj) {
        var x2 = this.cw * xx + this.cw / 2;
        var y2 = this.ch * yy + this.ch / 2;

        obj.x = x2;
        obj.y = y2;
    }

    showNumbers(a = 1) {
        this.show(a);
        var n = 0;
        for (var i = 0; i < this.rows; ++i) {
            for (var j = 0; j < this.cols; ++j) {
                var numText = this.scene.add.text(0, 0, n, {
                    color: 'red'
                });
                numText.setOrigin(0.5, 0.5);
                this.placeAt(j, i, numText);
                this.TextArr[n] = numText;
                ++n;
            }
        }
    }

    clearShow() {
        this.graphics.destroy();

        for(let i = 0; i < this.TextArr.length; ++i) {
            this.TextArr[i].destroy();
        }
    }

    placeAtIndex(index, obj) {
        var yy = Math.floor(index / this.cols);
        var xx = index - (yy * this.cols);
        this.placeAt(xx, yy, obj);
    }

    scaleToGameW(elName, per) {
        var el = document.getElementById(elName);
        var w = this.scene.game.config.width * per;
        el.style.width = w + "px";
    }

    scaleToGameH(elName, per) {
        var el = document.getElementById(elName);
        var h = this.scene.game.config.height * per;
        el.style.height = h + "px";
    }

    getPosByIndex(index) {
        var yy = Math.floor(index / this.cols);
        var xx = index - (yy * this.cols);
        var x2 = this.cw * xx + this.cw / 2;
        var y2 = this.ch * yy + this.ch / 2;
        return {
            x: x2,
            y: y2
        };
    }

    placeElementAt(index, elName, centerX = true, centerY = false) {
        //get the position from the grid
        var pos = this.getPosByIndex(index);
        //extract to local vars
        var x = pos.x;
        var y = pos.y;
        //get the element
        var el = document.getElementById(elName);
        //set the position to absolute
        el.style.position = "absolute";
        //get the width of the element
        var w = el.style.width;
        //convert to a number
        w = this.toNum(w);
        //
        //
        //center horizontal in square if needed
        if (centerX == true) {
            x -= w / 2;
        }
        //
        //get the height
        //        
        var h = el.style.height;
        //convert to a number
        h = this.toNum(h);
        //
        //center verticaly in square if needed
        //
        if (centerY == true) {
            y -= h / 2;
        }
        //set the positions
        el.style.top = y + "px";
        el.style.left = x + "px";
    }

    toNum(s) {
        s = s.replace("px", "");
        s = parseInt(s);
        return s;
    }
}