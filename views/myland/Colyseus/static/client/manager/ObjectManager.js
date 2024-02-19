class ObjectManager {               // 나중엔 진짜 옵젝매니저 만들어야 함 지금은 플레이어 매니저와 다를게 없다.
    static instance;
    constructor() {
        this.object = null;
    }

    static getInstance() {
        if (!ObjectManager.instance) {
            ObjectManager.instance = new ObjectManager();
        }

        return ObjectManager.instance;
    }

    setObject(obj) {
        if (this.object === null) {
            this.object = obj;
        }
    }

    setPos(pos) {
        this.object.setPos(pos);
    }

    setState(state) {
        this.object.setState(state);
    }

    setDirection(dir) {
        this.object.setDirection(dir);
    }

    setCollObj(callback) {
        this.object.setCollObj(callback);
    }

    setSitOrLie(state) {
        this.object.setSitOrLie(state);
    }

    setSubDepth(depth){
        this.object.setSubDepth(depth);
    }

    getObjectPos() {
        var pos = {
            x:this.object.sprite.x,
            y:this.object.sprite.y
        };
        return pos; 
    }

}