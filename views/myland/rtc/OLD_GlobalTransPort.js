
/// 등록시 하단 main 함수에 추가


class GlobalTransPort {

    static INSTANCE = null;

    static getInstance() {
        if (this.INSTANCE === null) {
            this.INSTANCE = new GlobalTransPort();
        }

        return this.INSTANCE;
    }

    // "key" - "value : object"
    #_bridgeMap;

    constructor() {
        this.#_bridgeMap = new Map();
    }

    set_bridge(name, any) {
        if (this.#_bridgeMap.has(name)) {
            throw Exception("GlobalTransPort Can't register duplicate case");
        }
        this.#_bridgeMap.set(name, any);
    }

    get_bridge(name) {
        return this.#_bridgeMap.get(name);
    }
}

class WEBRTC_CLIENT_BRIDGE {
    static ORDER_TYPE = {
        LEAVE: "LEAVE",
        MEET: "MEET",
        JOIN: "JOIN",
        OUT: "OUT",
        INIT_CLIENT: "INIT_CLIENT",
        START_CLIENT: "START_CLIENT",
        SPORT_LIGHT: "SPORT_LIGHT"
    }

    static getInstance() {
        if (this.INSTANCE === null) {
            INSTANCE = new GlobalTransPort();
        }

        return this.INSTANCE;
    }


    // key : targetId, value : {type (ORDER_TYPE), status (CHANGE or KEEP)};
    #meetStatus;


    // key : name (Game에서 사용), userIdx -> webRTC에서 사용
    #nameTable;

    constructor() {
        this.#meetStatus = new Map();
        this.#nameTable = new Map();
    }

    add_order(type, json_metaData) {
        //json.Stringify();
        switch (type) {
            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.INIT_CLIENT: {
                let user_info = json_metaData.user_Info;
                let session_id = json_metaData.session_id;
                WEBRTC_CLIENT.WEBRTC_CLIENT_GET_INSTANCE(user_info, user_info.type, session_id);
                WEBRTC_CLIENT.START_INDEX();
            }
                break;

            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.START_CLIENT:
                WEBRTC_CLIENT.START_INDEX();
                break;
            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.LEAVE:
            /* INTERNATIONAL FALL THROUGH */
            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.MEET: {
                let user_idx = json_metaData.target_idx;
                let session_id = json_metaData.session_id;

                if (this.#meetStatus.has(user_idx) === false) {
                    this.#meetStatus.set(user_idx, {
                        value: type, status: `CHANGE`, session_id: session_id
                    })
                    break;
                }
                let previous = this.#meetStatus.get(user_idx);
                previous.status = (previous.status === "KEEP") && (previous.value === type) ? "KEEP" : "CHANGE";
                previous.session_id = session_id;
                previous.value = type;
                this.#meetStatus.set(user_idx, previous);
            }
                break;

            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.OUT:
                {
                    let user_idx = json_metaData.target_idx;
                    let session_id = json_metaData.session_id;

                    if (this.#meetStatus.has(user_idx) === false) {
                        this.#meetStatus.set(user_idx, {
                            value: WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.LEAVE, status: `CHANGE`, session_id: session_id
                        })
                        break;
                    }
                    let previous = this.#meetStatus.get(user_idx);
                    previous.status = "CHANGE";
                    previous.session_id = session_id;
                    previous.value = WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.LEAVE;
                    this.#meetStatus.set(user_idx, previous);

                }
                break;
            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.JOIN:
                break;
            
            case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.SPORT_LIGHT:
                let user_idx = json_metaData.target_idx;
                let session_id = json_metaData.session_id;
                let order = json_metaData.order; // in or out



                break;
            
            default:
                break;
        }
    }
    // callback (target_id, order-j)
    consume_order(callback) {
        this.#meetStatus.forEach((value, key) => {
            callback(key, value)
            value.status = "KEEP";
        });
    }


}


/// Register시 여기에 추가
var globalTransport;

function main() {
    globalTransport = GlobalTransPort.getInstance();
    globalTransport.set_bridge("WEBRTC_CLIENT_BRIDGE", new WEBRTC_CLIENT_BRIDGE());
}

main();