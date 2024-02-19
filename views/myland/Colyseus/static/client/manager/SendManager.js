class SendManager {
   static instance;
    constructor() {
        this.room = null;
        this.id = 0;
     }

    static getInstance() {
        if (!SendManager.instance) {
            SendManager.instance = new SendManager();
        }

        return SendManager.instance;
    }

    setRoom(room,id) {
        this.room = room;
        this.id = id;

        this.roomLeave();
    }


    send(sendName, data) {  
        if (this.room !== undefined && this.room !== null) {
            var curdata = {
                data: data,
                id : this.id
            };
           
            this.room.send(sendName, curdata);
        }
    }

    onedataSend(sendName, data) {
        if (this.room !== undefined && this.room !== null) {
                      
            this.room.send(sendName, data);
        }
    }

    roomLeave() {
        this.room.onLeave(async (code) => {
            updateBox.style.display = 'block';
            updateBox.focus();
        });
    }
}