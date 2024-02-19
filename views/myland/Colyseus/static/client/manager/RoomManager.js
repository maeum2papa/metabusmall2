class RoomManager {             // 아직 안썻음.
    static instance;
    
    constructor() {
        this.client = null;
    }
    static getInstance() {
        if (!RoomManager.instance) {
            RoomManager.instance = new RoomManager();
        }

        return RoomManager.instance;
    }
    init() {
        if (RoomManager.getInstance().client === null) {
            RoomManager.getInstance().client = new Colyseus.Client(Config.Domain);
        }
    }

    async joinOrCreate(roomname, options) {
        return new Promise(function (resolve, reject) {
            resolve(RoomManager.getInstance().client.joinOrCreate(roomname, options));
        })
    }
}