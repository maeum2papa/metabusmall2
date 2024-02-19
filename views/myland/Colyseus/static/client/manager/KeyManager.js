class KeyManager {           
    static instance;
    isKeyDelay = false;
    curdelayTime = 0;
    maxDelaySec = 50; 
    constructor() {}

    static getInstance() {
        if (!KeyManager.instance) {
            KeyManager.instance = new KeyManager();
        }

        return KeyManager.instance;
    }

    setDelay() {
        this.isKeyDelay = true;
        setTimeout(() => {
            this.isKeyDelay = false;
        }, this.maxDelaySec);
    }


}
