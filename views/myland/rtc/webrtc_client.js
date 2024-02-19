/** 
 * 작성자 : JERRY
 * 2023-12-14
 * 
 * adapter.js, socket_package.js
 * 
 * client -> websocket -> Janus-server,
 * websocket 이 중간에 방 관리 처리함
 * 함수명에 _가 붙은 경우는 private, 외부에서 호출 금지
 * DEBUG 레벨이 클 수록 자세한 로그
 * 
 * ViewBinding은, DOM Tree가 렌더링 된 후에 호출할 것
 * 
*/

// 나중에 설정 파일로 분리할 수도 있음
const STRING_WEBSOCKET_URL = "wss://collaborland.kr:8088/ws" //"ws://localhost:8090" 
const STRING_JANUS_URL = "https://collaborland.kr:8088/janus";
const INT_WEBSOCKET_RETRY_DELAY = 3000;
const BOOLEAN_JANUS_DEBUG = false;
const INT_DEBUG_LEVEL = 5;
const STRING_ROOT_TAG_ID_VIDEO_LIST = "video_call_box_wrap";
const BOOLEAN_FOR_LOCAL_TEST = false;
const MEET_EVENT_LOOP_TIME = 100;


class WEBRTC_CLIENT {
    #_interval_id;
    static INSTANCE = null;
    static BANNED = false;
    static FORCE_LOGOUT = false;
    static USER_MEDIA = null;
    static #_MEET_EVENT_LOOP = null;


    // index.html 파일 기준임.
    static START_INDEX() {
        if (WEBRTC_CLIENT.INSTANCE === null) {
            return;
        }

        // TODO : Mobile와 PC 분리하기
        let toggle_camera;
        let toggle_mic;

        if (WEBRTC_CLIENT.INSTANCE.isMobile !== 1) {
            toggle_camera = document.querySelector("#toggle_camera");
            toggle_mic = document.querySelector("#toggle_mic");
        } else {
            toggle_camera = document.querySelector("#mo_toggle_camera");
            toggle_mic = document.querySelector("#mo_toggle_mic");
        }

        let janus_client = WEBRTC_CLIENT.INSTANCE;

        janus_client.init_menuButton_view_binding(toggle_camera, toggle_mic);
        // WEB_RTC Button Setting

        toggle_camera.addEventListener("click", function (event) {
            // 송출 상태가 아니면 송출하기
            janus_client.toggleMuteVideo();
        })

        toggle_mic.addEventListener("click", function (event) {
            // 송출 상태가 아니면 송출하기
            janus_client.toggleMuteAudio();
        })

        document.getElementById("share_screen").addEventListener("click", function (event) {
            // 송출 상태가 아니면 송출하기
            janus_client.toggleShareScreen();
        })

        // TODO: 미디어 추가
        document.getElementById("add_media").addEventListener("click", function (event) {
            alert("준비중입니다.");
        })

        document.getElementById("mo_device_setting").addEventListener("click", function (event) {
            janus_client.openDeviceSetting();
        })

        document.querySelector(".mlt-setting").addEventListener("click", function (event) {
            janus_client.openDeviceSetting();
        })

        document.getElementById("device_setting_close").addEventListener("click", function (event) {
            janus_client.closeDeviceSetting();
        })

    }

    static WEBRTC_CLIENT_GET_INSTANCE(infoToSend = null, isMobile = false, session_id) {
        if (WEBRTC_CLIENT.INSTANCE === null) {
            WEBRTC_CLIENT.INSTANCE = new WEBRTC_CLIENT(infoToSend, isMobile, session_id);
            WEBRTC_CLIENT.INSTANCE._void_start_connect_web_socket(true);
        }
        return WEBRTC_CLIENT.INSTANCE;
    }

    constructor(infoToSend, isMobile = false, session_id) {
        this.isMobile = isMobile === "mobile" ? 1 : 0;
        this._video_list = null;
        this._self_userInfo_id = BOOLEAN_FOR_LOCAL_TEST ? parseInt(Math.random() * 1000).toString() : `${infoToSend.currentUser}`;      
        this._local_tracks = {};
        this._web_socket_or_null = null;

        // 모든 사람이 개인 방을 소유하며, 타인이 접근시 서로의 방에 입장한다.
        this._room_idx = `${session_id}`

        this._janus = null;
        this.#_interval_id = null;

        this._webrtc_callback = new Map(); // key: request, value: list of response_callback;

        this._self_video_plugin_handler = null;
        this._self_audio_plugin_handler = null;
        this._self_screen_share_plugin_handler = null;


        this._other_user_handler = new Map() // key: user_id (string), value: publisher handler;
        this._other_subscribe_handler = new Map() // key room_idx (string), value: subscribe handler -> 

        // TODO 임시코드 -> 수정
        this._b_screen_shared = false;
        this._listen_local_audio = null;               

        this.DEVICE_SETTING = new DEVICE_SETTING();
        this.AUDIO_CONTEXT = null;

        //this.AUDIO_CONTEXT = new (window.AudioContext || window.webkitAudioContext)();
    }


    init_menuButton_view_binding(tag_toggle_camera, tag_toggle_mic) {
        this._toggleCamera = tag_toggle_camera;
        this._toggleMic = tag_toggle_mic;

        if (this.isMobile) {
            if (!this._toggleCamera.classList.contains('toggle')) {
                this._toggleCamera.classList.add('toggle');
            }
            if (!this._toggleMic.classList.contains('toggle')) {
                this._toggleMic.classList.add('toggle');
            }
            
        }

        this._video_list = new VideoList(document.getElementsByClassName(STRING_ROOT_TAG_ID_VIDEO_LIST)[this.isMobile ? 1 : 0], this.isMobile);
        this._video_list.videoElement_addOrGetElement(this._self_userInfo_id);

        // TODO 분리하기
        this.DEVICE_SETTING.initView();
        this.DEVICE_SETTING.initSetFlipHorizon();
    }

    getDeviceSetting() {
        return this.DEVICE_SETTING;
    }

    _void_start_connect_web_socket(initialTry = false) {
        if (initialTry) {
            WEBRTC_CLIENT.INSTANCE._void_connect_web_socket();
            return;
        }

        WEBRTC_CLIENT.INSTANCE.#_interval_id = setInterval(WEBRTC_CLIENT.INSTANCE._void_connect_web_socket, INT_WEBSOCKET_RETRY_DELAY);
    }

    _void_connect_web_socket() {
        try {
            WEBRTC_CLIENT.INSTANCE._web_socket_or_null = new WebSocket(STRING_WEBSOCKET_URL);


            // TODO, web_socket 재연결시에 굳이 방을 다시 들어갈 필요가 있나? 등 확인하기
            // 만약에 JANUS 서버 join이라면, websocket을 재연결해도 이미 방에 들어가 있는 상태가 됨.

            // initial websocket -> connected;
            WEBRTC_CLIENT.INSTANCE._web_socket_or_null.addEventListener('open', async (event) => {
                void_print_log("websocket open", 4);

                // 재연결 요청이 남아있다면 이를 정리함
                clearInterval(WEBRTC_CLIENT.INSTANCE.#_interval_id);
                WEBRTC_CLIENT.INSTANCE.#_interval_id = null;
                
                WEBRTC_CLIENT.INSTANCE._void_put_request("register_id", (packet) => {

                    // TODO : 등록에 실패한 경우                   
                    if (packet._data.result === true) {
                        // ID 등록까지 끝냄
                        void_print_log(`success id binding - websocket`, 4);

                        if (WEBRTC_CLIENT.INSTANCE._janus === null) {
                            WEBRTC_CLIENT.INSTANCE._void_ready_janus();
                        }
                    }
                });


                let csrf = getSessionId();
                csrf = csrf === null ? "" : csrf;

                // id-binding request send
                let packet = new SOCKET_PACKET("register_id", "self_idx, csrf", { "self_idx": `${WEBRTC_CLIENT.INSTANCE._self_userInfo_id}`, csrf: `${csrf}` });
                let json = JSON.stringify(packet);
                WEBRTC_CLIENT.INSTANCE._web_socket_or_null?.send(json);
            })

            // WebSocket connection
            WEBRTC_CLIENT.INSTANCE._web_socket_or_null.addEventListener('message', (event) => {
                // WebSocket no request & response로 auto close 방지
                if (event.data === 'check') {
                    void_print_log("for keep connection", 5);
                    WEBRTC_CLIENT.INSTANCE._web_socket_or_null.send('check');
                    return;
                }

                try {
                    const json_data = JSON.parse(event.data);
                    let keys_string = Array.from(json_data._keys).join(",");
                    let packet = new SOCKET_PACKET(json_data._request, keys_string, json_data._data);
                    void_print_log(`${JSON.stringify(event.data)}`, 4);

                    // TODO : 유효한 요청인지 검사코드
                    // key에 대응하는 data값이 전부 있는지 확인하는 코드 있으면 됨

                    let wait_responses = WEBRTC_CLIENT.INSTANCE._webrtc_callback.get(packet._request);

                    // request 대한 응답이 Callback으로 등록 된 게 있으면 Callback 함수만 실행, (Pub-Sub 형태)
                    // 없는 경우 고정적인 처리를 진행
                    if (wait_responses !== undefined && wait_responses.length != 0) {                        
                        while (wait_responses.length > 0) {
                            const response = wait_responses.shift();
                            if (typeof response !== "function") {
                                void_print_log("wait response는 함수여야 합니다.", 3);
                                continue;
                            }
                            response(packet);
                        }

                    } else {
                        // 고정적인 응답
                        switch (packet._request) {
                            case "join_other":
                                if (WEBRTC_CLIENT.INSTANCE._video_list !== null) {
                                    WEBRTC_CLIENT.INSTANCE._video_list.videoElement_addOrGetElement(packet._data.id);
                                }
                                break;
                            case "already_login":
                                // TODO: 중복 로그인 감지                                
                                WEBRTC_CLIENT.FORCE_LOGOUT = packet._data.logout;
                                WEBRTC_CLIENT.BANNED = true;
                                WEBRTC_CLIENT.INSTANCE._web_socket_or_null.close();                                                        
                                
                                break;
                            case "leave_other":
                                if (WEBRTC_CLIENT.INSTANCE._video_list !== null) {
                                    WEBRTC_CLIENT.INSTANCE._video_list.b_removeElement(packet._data.id);
                                }
                                break;
                            case "participants": {
                                if (WEBRTC_CLIENT.INSTANCE._video_list !== null) {
                                    let list = packet._data.ids
                                    list.forEach(element => {
                                        WEBRTC_CLIENT.INSTANCE._video_list.videoElement_addOrGetElement(element);
                                    });
                                }
                            }
                                break;

                            default:                                
                                void_print_log(`undefined request websocket\n${JSON.stringify(event.data)}\n`, 4);
                                break;

                        }
                    }
                } catch (error) {
                    // error handling
                    void_print_log(`websocket message error - listener\n${JSON.stringify(error)}`, 4);
                }
            })


            // websocket closed;
            WEBRTC_CLIENT.INSTANCE._web_socket_or_null.addEventListener('close', (event) => {
                void_print_log("websocket closed", 4);
                // WEBRTC-middle-websocket 서버가 종료된 경우, janus 정리 && videoList도 삭제                
                if (WEBRTC_CLIENT.INSTANCE._janus !== null) {
                    WEBRTC_CLIENT.INSTANCE._janus.destroy();
                    WEBRTC_CLIENT.INSTANCE._janus = null;
                }

                if (!WEBRTC_CLIENT.BANNED && WEBRTC_CLIENT.INSTANCE.#_interval_id === null) {
                    WEBRTC_CLIENT.INSTANCE._void_start_connect_web_socket(false);
                }

                if (WEBRTC_CLIENT.INSTANCE._video_list !== null) {
                    WEBRTC_CLIENT.INSTANCE._video_list.void_destroy_all();
                }

                if (WEBRTC_CLIENT.BANNED) {
                    alert("중복 로그인이 감지되었습니다.");
                    if (WEBRTC_CLIENT.FORCE_LOGOUT) {
                        window.top.location.replace(`https://collaborland.kr/login/logout`);
                    } else {
                        window.top.location.replace(`https://collaborland.kr/dashboard`);
                    }                      
                }
            })

                                      
            WEBRTC_CLIENT.INSTANCE._web_socket_or_null.addEventListener('error', (event) => {
                void_print_log(`websocket message error - listener\n${JSON.stringify(error)}`, 4);
            })
            

        } catch (error) {
            void_print_log(`_void_connect_web_socket에서 에러 발생 ${error}`, 5);
        }
    }

    _void_ready_janus() {
        let janus_init_option = {
            debug: BOOLEAN_JANUS_DEBUG,
            dependencies: Janus.useDefaultDependencies({ adapter }), /* used adapter.js */
            withCredentials: false,
        }

        let janus_option = {
            server: STRING_JANUS_URL,
            ipv6: true,
            withCredentials: false,
            success: () => {
                void_print_log("JANUS object create success", 4);

                // 자기 자신을 송출할 수 있는 방에 입장함
                this._janus.attach(this._pluginHandle_make_self_handle("video"));
                this._janus.attach(this._pluginHandle_make_self_handle("audio"));

                setTimeout(() => {
                    WEBRTC_CLIENT.#_MEET_EVENT_LOOP  = setInterval(() => {
                        let webrtc_client_bridge = globalTransport.get_bridge("WEBRTC_CLIENT_BRIDGE");
                        let callback = (target_id, obj_order) => {
                            if (obj_order.status === "KEEP") {
                                return;
                            }

                            switch(obj_order.value) {
                                case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.MEET: 
                                    this._meetOrLeave(target_id, "meet", obj_order.session_id);
                                    break;
                                case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.LEAVE: 
                                    this._meetOrLeave(target_id, "leave", obj_order.session_id);
                                    break;
                                default:
                                    break;
                            }
                        }
                        
                        webrtc_client_bridge.consume_order(callback);


                    }, MEET_EVENT_LOOP_TIME)
                }, 3000)
            },
            error: (error) => {
                void_print_log(`JANUS object create failed\n${JSON.stringify(error)} \n`, 4);
            },
            destroyed: () => {
                void_print_log("JANUS object destroyed", 4);
                WEBRTC_CLIENT.INSTANCE._janus = null;
                if (WEBRTC_CLIENT.#_MEET_EVENT_LOOP !== null) {
                    clearInterval(WEBRTC_CLIENT.#_MEET_EVENT_LOOP);
                }

                WEBRTC_CLIENT.#_MEET_EVENT_LOOP = null;
            }
        }

        let janus_init_callback = () => {
            WEBRTC_CLIENT.INSTANCE._janus = new Janus(janus_option);
        }

        janus_init_option.callback = janus_init_callback;
        Janus.init(janus_init_option);
    }

    _void_put_request(request, callback) {
        if (this._webrtc_callback.has(request)) {
            this._webrtc_callback.get(request).push(callback);
        } else {
            this._webrtc_callback.set(request, []);
            this._webrtc_callback.get(request).push(callback);
        }
    }

    _pluginHandle_make_self_handle(type) {
        if (this._room_idx === null || this._room_idx === undefined) {
            throw Error("undefined the room");            
        }

        if (type !== "audio" && type !== "video") {
            throw Error("handler type can video or audio")
        }

        let handler_name = "self_handler";

        return {
            plugin: 'janus.plugin.videoroom',
            success: (handle) => {
                void_print_log("create success self videoroom_plugin", 4);
                if (type === "video") {
                    WEBRTC_CLIENT.INSTANCE._self_video_plugin_handler = handle;
                } else if (type === "audio") {
                    WEBRTC_CLIENT.INSTANCE._self_audio_plugin_handler = handle;
                }

                // websocket에서 방 입장 전 검사하기
                // websocket에 요청을 보내면 방이 없는 경우 websocket이 방을 만드는 요청을 통해 방을 만들고 돌려줌
                // 이후 해당 방으로 클라이언트에서 janus에 접속함
                WEBRTC_CLIENT.INSTANCE._void_put_request("response_room_exist", (packet) => {
                    if (packet._data.hasOwnProperty('room_exist') && packet._data.room_exist) {
                        // janus에서 같은 id의 핸들러를 등록할 수는 없음.
                        // _v -> video, _a -> mic, _s -> screen, <- 다음과 같이 정의함.
                        let id = `${this._self_userInfo_id}${type === "video" ? "_v" : "_a"}`;

                        let register = {
                            request: "join",
                            room: this._room_idx,
                            ptype: "publisher",
                            id: id,
                        };

                        let success = (data) => {
                            void_print_log(`self-handler join room success`, 4);
                        }

                        let error = (error) => {
                            void_print_log(`self-handler join room error\n${JSON.stringify(error)}\n`, 4);
                        }

                        // 방에 참가하는 코드1                        
                        handle.send({ message: register, success: success, error: error });
                    }}
                );

                // video & audio stream 분리를 위하여, 두 개의 핸들러를 만들어서 진행 중임.
                // 그러나 클라이언트는 하나이므로, 둘중 하나만 방에 접속했다는 요청을 보내면 됨.
                // 그걸 Video로 하기로 함 
                if (type === "video") {
                    let packet = new SOCKET_PACKET("join_room", "room_idx", { "room_idx": `${this._room_idx}` });
                    let json = JSON.stringify(packet);
                    WEBRTC_CLIENT.INSTANCE._web_socket_or_null.send(json);
                }

            },
            error: (error) => {
                void_print_log(`error self videoroom_plugin ${JSON.stringify(error)}`, 4);
            },
            consentDialog: (on) => {
                if (on) {
                    this._toggleMic.setAttribute('disabled', 'disabled');
                    this._toggleCamera.setAttribute('disabled', 'disabled');

                } else {
                    this._toggleMic.removeAttribute('disabled');
                    this._toggleCamera.removeAttribute('disabled');
                }

                // Janus WebRTC Gateway에서 사용자의 개인 정보 처리에 대한 동의를 얻기 위한 컨센트 다이얼로그(consent dialog)를 관리하는 개체
                // TODO : on & off 파악하여 대기하는 동안에는 publishing 요청 방지 (동의 창이 여러번 나오게 됨.)
            },
            onmessage: (message, jsep) => {                        
                if (jsep) {
                    // TODO 추후 파악
                    if (type === "video") {
                        WEBRTC_CLIENT.INSTANCE._self_video_plugin_handler.handleRemoteJsep({ jsep: jsep });
                    } else if (type === "audio") {
                        WEBRTC_CLIENT.INSTANCE._self_audio_plugin_handler.handleRemoteJsep({ jsep: jsep });
                    }
                }
            },
            onlocaltrack: (track, on) => {            

                console.log(`onlocaltrack ${track.muted}, on : ${on}`);
                
                // OLD VERSION                
                // on -> 각각 audio, video 연결 // off -> stream 중지 처리                
                // track ID를 요소의 이름으로 쓸 건데, 유효하지 않은 문자가 포함되어 있는 것을 정규식을 통해 제거함.
                let trackId = track.id.replace(/[{}]/g, "");

                if (!on) {
                    let stream = this._local_tracks[track];
                    if (stream) {
                        try {
                            let tracks = stream.getTracks();
                            for (let i in tracks) {
                                let mst = tracks[i];
                                // MediaStreamTrack을 중지하는 것을 말함.
                                if (mst !== null && mst !== undefined) {
                                    mst.stop();
                                }
                            }

                        } catch (e) {
                            
                        }
                    }
                    if (track.kind === "video") {
                        let box = this._video_list.videoElement_addOrGetElement(this._self_userInfo_id);
                        box.void_change_status_video(false);
                    }

                    delete this._local_tracks[trackId];
                    return;
                }


                if (track.kind === "audio") {
                    let stream = new MediaStream([track]);
                    this._local_tracks[trackId]  = stream
                    let id = this._self_userInfo_id;
                    let box = this._video_list.videoElement_addOrGetElement(id);
                    box.void_attach_self_audio_stream(this._local_tracks[trackId]);

                    if (this.isMobile) {
                        this._toggleMic?.classList.remove("toggle");
                    } else {
                        this._toggleMic?.classList.add("off");
                    }

                } else if (track.kind === "video") {
                    let stream = new MediaStream([track]);
                    stream['muted'] = true;

                    this._local_tracks[trackId] = stream;
                                        
                    if (this.isMobile) {
                        this._toggleCamera?.classList.remove("toggle");
                    } else {
                        this._toggleCamera?.classList.add("off");
                    }

                    // 뷰에 비디오를 연결함                                        
                    let id = this._self_userInfo_id;
                    let box = this._video_list.videoElement_addOrGetElement(id)
                    box.void_change_status_video(true);
                    box.void_attach_video_stream(stream);
                }
            },
            oncleanup: () => {

            },
            ondetached: () => {

            },
            webrtcState: (is_connected) => {
                void_print_log(`[${handler_name}] webrtc_state : ${JSON.stringify(is_connected)}`, 5);
            },
            iceState: (data) => {
                void_print_log(`[${handler_name}] ice_state : ${JSON.stringify(data)}`, 5);
            },
            destroyed: () => {
                void_print_log(`[${handler_name}] - videoroom_plugin_handler destroyed `, 5);
            }
        };
    }


    // 다른 사람에 만나면 그 사람의 방에 들어가서 송출하는 것을 받도록 처리함.
    // 모든 사람은 각자마다 개별방에 송출함, 서로 만나면 서로가 서로의 방에 들어감
    _pluginHandle_join_other_handle(session_id) {
        if (session_id === null || session_id === undefined) {
            throw Error("undefined the room");            
        }
        
        // TODO : 리스트에 저장해두기, key-value 셋으로
        if (this._other_user_handler.get(session_id) !== undefined) {
            throw Exception("핸들러 삭제 안함");
        }

        let handler_name = `other_handler ${session_id}`;

        return {            
            plugin: 'janus.plugin.videoroom',
            success: (handle) => {                                
                this._other_user_handler.set(`${session_id}`, handle);

                // id값에 랜덤 문자열을 추가하여, 중복을 방지함
                const generateRandomString = (num) => {
                    const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                    let result = '';
                    const charactersLength = characters.length;
                    for (let i = 0; i < num; i++) {
                        result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    }
                  
                    return result;
                  }


                // websocket에서 방 입장 전 검사하기
                // websocket에 요청을 보내면 방이 없는 경우 websocket이 방을 만드는 요청을 통해 방을 만들고 돌려줌
                // 이후 해당 방으로 클라이언트에서 janus에 접속함                
                let id = `${this._self_userInfo_id}${generateRandomString(10)}`;

                let register = {
                    request: "join",
                    room: `${session_id}`,
                    ptype: "publisher",
                    id: id,
                };

                let success = (data) => {                            
                }

                let error = (error) => {                            
                }

                // 방에 참가하는 코드1                        
                handle.send({ message: register, success: success, error: error });
                  
            },
            error: (error) => {
                void_print_log(`error self videoroom_plugin ${JSON.stringify(error)}`, 4);
            },
            onmessage: (message, jsep) => {                            
                
                if (message["publishers"]) {

                    let list = message["publishers"];

                    for (let p in list) {
                        let id = list[p]["id"];
                        let streams = list[p]["streams"];

                        for (let s in streams) {
                            let stream = streams[s];
                            stream['id'] = id;
                        }
                        
                        if (id !== this._self_userInfo_id) {
                            WEBRTC_CLIENT.INSTANCE.newRemoteFeed(id, streams, session_id) // 이게 가장 핵심 코드
                        }
                    }
                }
                // 이거 방에 영상 송출자 받으려고 스파이짓 하는거지, 영상 송출자가 누군지 볼 마음 없음.
                /* if (jsep) {
                    // TODO 추후 파악
                    if (type === "video") {
                        WEBRTC_CLIENT.INSTANCE._self_video_plugin_handler.handleRemoteJsep({ jsep: jsep });
                    } else if (type === "audio") {
                        WEBRTC_CLIENT.INSTANCE._self_audio_plugin_handler.handleRemoteJsep({ jsep: jsep });
                    }
                }*/
            },
            oncleanup: () => {
                // 방 삭제될 때, 여기서 비디오 리스트에서 해당 송출자 제거함
            },
            ondetached: () => {

            },
            webrtcState: (is_connected) => {
                void_print_log(`[${handler_name}] webrtc_state : ${JSON.stringify(is_connected)}`, 5);
            },
            iceState: (data) => {
                void_print_log(`[${handler_name}] ice_state : ${JSON.stringify(data)}`, 5);
            },
            destroyed: () => {
                void_print_log(`[${handler_name}] - videoroom_plugin_handler destroyed `, 5);
            }
        };
    }


    _meetOrLeave(user_idx, type, session_id) {

        let handler = this._other_user_handler.get(`${session_id}`);
 
        if (type === "leave") {
            if (handler === undefined) {
                //throw Exception("유효하지 않는 유저임");
                WEBRTC_CLIENT.INSTANCE._video_list.b_removeElement(session_id);
                return;
            }
    
            this._leave_other_user(session_id, user_idx);
        } else if (type === "meet") {
            if (handler !== undefined) {
                //throw Exception("유효하지 않는 유저임");
                return;
            }
    
            this._meet_other_user(user_idx, session_id);
        }
    }

    _meet_other_user(user_idx, session_id) {

        if (this._other_user_handler.get(session_id) !== undefined) {
            return;
        }

        WEBRTC_CLIENT.INSTANCE._video_list.videoElement_addOrGetElement(user_idx, session_id);
        this._janus.attach(this._pluginHandle_join_other_handle(session_id))
    }

    _leave_other_user(session_id, user_idx) {
        let message = { request: "leave" };
        let array = [];
        
        array.push(this._other_subscribe_handler.get(`${session_id}_v`));
        array.push(this._other_subscribe_handler.get(`${session_id}_a`));
        array.push(this._other_subscribe_handler.get(`${user_idx}_s`));
        
        for (let handler of array) {        
            if (handler !== undefined) {
                handler.send({ message: message });
            }
        }    

        const success = (data) => {
            void_print_log(`leave ${session_id} success`, 4);            
            WEBRTC_CLIENT.INSTANCE._video_list.b_removeElement(session_id);
            WEBRTC_CLIENT.INSTANCE._other_subscribe_handler.delete(`${session_id}_v`)
            WEBRTC_CLIENT.INSTANCE._other_subscribe_handler.delete(`${session_id}_a`)
            WEBRTC_CLIENT.INSTANCE._other_subscribe_handler.delete(`${user_idx}_s`)
        }

        const error = (error) => {
            void_print_log(`leave ${session_id} failed`, 4);
        }

        let handler = this._other_user_handler.get(`${session_id}`);

        handler.send({ message: message, success: success, error: error });

        this._other_user_handler.delete(`${session_id}`);
    }



    // TODO: 나중에 모바일 대응하기
    // 현재는 모바일에서 Screen 자체를 안하기 때문에 따로 예외처리 안해도 기능상에 문제는 없음
    endShareScreen() {
        if (this._self_screen_share_plugin_handler === null) {
            return;
        }

        this._b_screen_shared = false;

        let message = { request: "unpublish" };

        const success = (data) => {

            // TODO 공유 UI 하드코딩임

            let screen_shared_id = `${WEBRTC_CLIENT.INSTANCE._self_userInfo_id}_s`;
            WEBRTC_CLIENT.INSTANCE._video_list.b_videoElement_set_status(screen_shared_id, false);
            
            let btn_share_screen = document.getElementById("share_screen");
            let btn_child_img = btn_share_screen.getElementsByTagName('img')[0]
            btn_share_screen.innerHTML = '';
            btn_share_screen.append(btn_child_img);
            btn_share_screen.append("화면 공유")

            const message = {
                request: 'leave',
            }

            const success = (data) => {
                console.log("screen share leave success");
                WEBRTC_CLIENT.INSTANCE._video_list.b_removeElement(screen_shared_id, false);
            }


            const error = (data) => {
                console.log("screen share leave failed");
            }

            this._self_screen_share_plugin_handler.send({ message: message, success: success, error: error });

        }

        const error = (error) => {
            void_print_log("unpublished screen share failed", 4);
        }

        this._self_screen_share_plugin_handler.send({ message: message, success: success, error: error });
    }

    toggleShareScreen() {
        // 화면 공유를 송출하거나 삭제함    
        let screen_handler;

        if (!this._b_screen_shared) {
            this._janus.attach({
                plugin: 'janus.plugin.videoroom',

                success: (handle) => {
                    WEBRTC_CLIENT.INSTANCE._self_screen_share_plugin_handler = handle;
                    screen_handler = WEBRTC_CLIENT.INSTANCE._self_screen_share_plugin_handler;
                    let screen_shared_id = `${WEBRTC_CLIENT.INSTANCE._self_userInfo_id}_s`;

                    let subscribe = {
                        request: "join",
                        room: this._room_idx, // 방 번호 - 추후 필요한 곳으로 연결하기
                        ptype: "publisher",
                        id: screen_shared_id
                    };

                    let success = (data) => {
                        void_print_log("screen - shared success", 4);

                        // 화면 공유
                        screen_handler.createOffer(
                            {
                                tracks: [{ type: 'screen', capture: true, add: true }],
                                success: function (jsep) {
                                    let publish = { request: "configure", audio: false, video: true };
                                    screen_handler["screen"] = true;
                                    screen_handler.send({ message: publish, jsep: jsep });
                                    WEBRTC_CLIENT.INSTANCE._b_screen_shared = true;
                                },
                                error: function (error) {
                                    alert("화면 공유에 실패하셨습니다.");
                                    WEBRTC_CLIENT.INSTANCE.endShareScreen();
                                },
                            }
                        )
                    }

                    let error = (error) => {
                        void_print_log("screen - error", 4);
                    }

                    screen_handler.send({ message: subscribe, success: success, error: error });
                },
                onmessage: (message, jsep) => {
                    if (message && message.videoroom) {
                        if (message.videoroom == 'joined') {
                            console.log('message', 'joined-sharedroom', message);
                        }
                    }

                    if (jsep) {
                        console.log('i got jsep! - screen_shared', jsep);
                        screen_handler.handleRemoteJsep({ jsep: jsep })
                    }
                },
                onlocaltrack: (track, on) => {
                    console.log("공유 화면이 켜지거나 꺼짐 : " + on);
                    let screen_shared_id = `${WEBRTC_CLIENT.INSTANCE._self_userInfo_id}_s`;

                    if (!on) {                        
                        //WEBRTC_CLIENT.INSTANCE._video_list.b_videoElement_set_status(screen_shared_id, false);
                        WEBRTC_CLIENT.INSTANCE.endShareScreen();
                    }

                    if (on) {
                        let stream = new MediaStream([track]);

                        let btn_share_screen = document.getElementById("share_screen");
                        let btn_child_img = btn_share_screen.getElementsByTagName('img')[0]
                        btn_share_screen.innerHTML = '';
                        btn_share_screen.append(btn_child_img);
                        btn_share_screen.append("공유 중지");

                        let box = WEBRTC_CLIENT.INSTANCE._video_list.videoElement_addOrGetElement(screen_shared_id, screen_shared_id)
                        box.void_change_status_video(true);
                        box.void_attach_video_stream(stream);
                    }
                },
                error: (error) => {
                    console.log("error : %o", error);
                }

            })
        } else {
            this.endShareScreen()
        }
    }
    

    // OLD_VERSION
    // TODO : 나중에 수정,
    publishOwnFeed(bAudio, bVideo) {
        // TODO -> stream을 위로 올리게 변경
        if (bAudio === bVideo) {
            throw Error("한 번에 둘 중 하나만 켜주세요.");
        }
        let tracks = [];
        let plug_handler;


        //옵션에서 가져오는 코드        
        if (bAudio) {
            plug_handler = this._self_audio_plugin_handler;

            let capture = true;
            if (this.DEVICE_SETTING._selected_mic_index !== -1) {
                // TODO : select 코드 분리
                //let list = this.DEVICE_SETTING._mic_device_list;
                let list = document.getElementById("mic_set");
                
                let device_id = list.options[list.selectedIndex].value;
                capture = { deviceId: { exact: device_id } };
            }

            tracks.push({ type: 'audio', mid: 0, capture: capture, recv: false });
        }

        if (bVideo) {
            plug_handler = this._self_video_plugin_handler;
            plug_handler.jsep = null;

            let capture = true;
            if (this.DEVICE_SETTING._selected_cam_index !== -1) {
                // TODO : select 코드 분리
                //let list = this.DEVICE_SETTING._tag_video_device_list

                let list = document.getElementById("camera_set");
                let device_id = list.options[list.selectedIndex].value;

                capture = { deviceId: { exact: device_id } };
            }

            tracks.push({ type: 'video', mid: '1', capture: capture, recv: false });
        }

        plug_handler.createOffer(
            {
                tracks: tracks,
                success: function (jsep) {
                    plug_handler.jsep = jsep;
                    let publish = { request: "configure" };  
                
                    if (bAudio) {
                        publish["audio"] = true;
                    }

                    if (bVideo) {
                        publish["video"] = true;
                    }

                    let error = (e) => {
                        alert(e);
                    }                

                    plug_handler.send({ message: publish, jsep: jsep, error: error });
                },
                error: function (error) {
                    if (error.message === "Requested device not found" || error.message === "Could not start video source") {
                        alert(`카메라 및 마이크가 연결되었는지 확인해주세요.`);
                    } else if (error.message === "Permission denied") {
                        alert("카메라 및 마이크 사용을 허용해주세요.");
                    } else {
                        alert("WebRTC error... " + error.message);
                    }
                }

            }
        )        
    }

    // 협상시 재협상 요청하는 코드
    async rePublishOwnFeed(bAudio, bVideo) {        
        if (bAudio === bVideo) {
            throw Error("한 번에 둘 중 하나만 켜주세요.");
        }
        

        if (bAudio) {
            if (this.b_check_publish_and_stop("audio")) {   
                let plug_handler = this._self_audio_plugin_handler;

                let tracks = [];
                    
                let capture = true;
                if (this.DEVICE_SETTING._selected_mic_index !== -1) {
                    let list = document.getElementById("mic_set");
                    
                    let device_id = list.options[list.selectedIndex].value;

                    capture = { deviceId: { exact: device_id } };
                }

                tracks.push({ type: 'audio', mid: '0', capture: capture, recv: false });
                

                plug_handler.replaceTracks({
                    tracks: tracks,
                    error: function(err) {
                        bootbox.alert(err.message);
                    }
                });
            } 
        }
        
        if (bVideo) {                        
            // publish중이면 마찬가지로 publishing
                // 기존 트랙은 중지, 새로운 트랙만 on
            // 아니라면 하지 않음.
            
            
            if (this.b_check_publish_and_stop("video")) {                                        
                let tracks = [];                
                let plug_handler = this._self_video_plugin_handler;
    
                let capture = true;
                if (this.DEVICE_SETTING._selected_cam_index !== -1) {
                    let list = document.getElementById("camera_set");
                    let device_id = list.options[list.selectedIndex].value;
    
                    capture = { deviceId: { exact: device_id } };
                }
    
                tracks.push({ type: 'video', mid: '1', capture: capture, recv: false });
                

                plug_handler.replaceTracks({
                    tracks: tracks,
                    error: function(err) {
                        bootbox.alert(err.message);
                    }
                });
                
            }
        }        
    }            

    // OLD_VERSION    
    // TODO : 나중에 수정
    // 새로운 송출 들어왔을 때, 구독패턴 하는 거임
    newRemoteFeed(id, streams, session_id) {
        let remote_handle = null;
        if (!streams) {
            return;
        }
        
        //let user_idx = id.replace(/_v|_a/g, "");
        let type_set = id.split("_");
        let type = type_set.length > 1 ? `_${type_set[1]}` : "";

        let video_list = this._video_list;
        let handler = WEBRTC_CLIENT.INSTANCE._other_subscribe_handler.get(`${session_id}${type}`);
        if (handler !== undefined) {                    
            return;
        }

        this._janus.attach(
            {
                plugin: "janus.plugin.videoroom",
                success: function (plug_handle) {

                    remote_handle = plug_handle;
                    if (id.indexOf("_s") === -1) {
                        WEBRTC_CLIENT.INSTANCE._other_subscribe_handler.set(`${session_id}`, plug_handle);
                    } else {
                        WEBRTC_CLIENT.INSTANCE._other_subscribe_handler.set(`${id}`, plug_handle);
                    }

                    let subscription = [];

                    for (let i in streams) {
                        let stream = streams[i];

                        subscription.push({
                            feed: stream.id, 
                            mid: stream.mid 
                        })
                    }

                    // 송출 중인 mediaStream을 구독함
                    // plugin의 오퍼를 기다림
                    let subscribe = {
                        request: "join",
                        room: `${session_id}`,
                        ptype: "subscriber",
                        streams: subscription
                    };


                    let success = (data) => {
                        void_print_log('joinAsSubscriber success', 6)
                    }

                    let error = (error) => {
                        void_print_log('joinAsSubscriber error', 6)
                    }

                    remote_handle.send({ message: subscribe, success: success, error: error });
                },
                error: function (error) {
                    print_log('new remote-error ' + error);
                },
                iceState: function (state) {
                    // 핸들에 관련된 PeerConnection에 대한 ICE 상태가 변경될 때,
                    //void_print_log("ICE state (feed #" + remote_handle.rfindex + ") changed to " + state, 4);
                },
                webrtcState: function (on) {
                },
                slowLink: function (uplink, lost, mid) {
                },
                onmessage: function (message, jsep) {
                    Janus.debug(" ::: (subscriber)로 부터 메세지를 받음 :::", message);
                    //print_log("[remoteHandler] new message come : %o", message);

                    let event = message["videoroom"];

                    // 에러 처리 early exit
                    if (message["error"]) {
                        return;
                    }

                    if (jsep) {
                        Janus.debug("Handling SDP as well...", jsep);
                        remote_handle.createAnswer(
                            {
                                jsep: jsep,
                                // We only specify data channels here, as this way in
                                // case they were offered we'll enable them. Since we
                                // don't mention audio or video tracks, we autoaccept them
                                // as recvonly (since we won't capture anything ourselves)
                                tracks: [
                                    { type: 'data' }
                                ],
                                success: function (jsep) {
                                    Janus.debug("Got SDP!", jsep);
                                    let body = { request: "start", room: session_id };
                                    remote_handle.send({ message: body, jsep: jsep });
                                },
                                error: function (error) {
                                    Janus.error("[Remote_handler] WebRTC error:", error);
                                    bootbox.alert("[Remote_handler] WebRTC error... " + error.message);
                                }
                            });
                    }


                },
                onlocaltrack: function (track, on) {
                },
                onremotetrack: function (track, mid, on, metadata) {                

                    if (!on) {
                        track.stop();
                        if (track.kind === "video") {                            
                            if (id.indexOf('_s') !== -1) {
                                WEBRTC_CLIENT.INSTANCE._video_list.b_removeElement(id);
                            } else {
                                WEBRTC_CLIENT.INSTANCE._video_list.b_videoElement_set_status(session_id, false);
                            }                                            
                        }

                        if (track.kind === "audio") {
                            let element_or_null = video_list.videoElement_getElementOrNull(session_id);
                            if (element_or_null !== null) {
                                element_or_null.void_change_status_audio(false);
                            }
                        }
                       
                        return;
                    }

                    if (track.kind === "audio") {
                        let stream = new MediaStream([track]);

                        if (`${metadata.reason}` === 'unmute') {
                            let box = video_list.videoElement_addOrGetElement(id, session_id);
                            box.void_attach_audio_stream(stream);
                        }

                    } else if (track.kind === "video") {
                        
                        let stream = new MediaStream([track]);

                        if (`${metadata.reason}` === 'unmute') {                            
                            let box;

                            if (id.indexOf('_s') !== -1) {
                                box = video_list.videoElement_addOrGetElement(id, id);
                            } else {
                                box = video_list.videoElement_addOrGetElement(id, session_id);
                            }
                            box.void_change_status_video(true);
                            box.void_attach_video_stream(stream);
                        }

                    }

                },
                oncleanup: function () {
                    // 방을 폭파했을 때
                }

            }
        )


    }

    // OLD_VERSION
    // TODO : 나중에 수정
    // 오디오 끄기 or 켜기 변경
    toggleMuteAudio(menu_change = true) {
        let isNotPublihsed = true;
        let audio_track = null;

        if (this._local_tracks !== null) {
            for (const key in this._local_tracks) {
                let stream = this._local_tracks[key];
                if (stream) {
                    try {
                        let tracks = stream.getTracks();
                        for (let i in tracks) {
                            let track = tracks[i];
                            if (track.kind === "audio") {
                                audio_track = track;
                                isNotPublihsed = false;
                            }

                        }

                    } catch (e) {
                        //console.error(" self-janus-plugin error onlocaltrack : " + e)
                    }
                }
            }
        }


        if (isNotPublihsed) {
            this.publishOwnFeed(true, false);
            return;
        }

        if (audio_track !== null) {
            let trackId = audio_track.id.replace(/[{}]/g, "");

            let unpublish = { request: "unpublish" };
            this._self_audio_plugin_handler.send({ message: unpublish });
            if (menu_change) {
                if (this.isMobile) {
                    this._toggleMic?.classList.add("toggle");
                } else {
                    this._toggleMic?.classList.remove("off");
                }
                
            }
            
            let box = this._video_list.videoElement_getElementOrNull(this._self_userInfo_id);
            if (box !== null) {
                box.void_change_status_audio(false);
            }            

            delete this._local_tracks[trackId];
        }
    }

    // OLD_VERSION
    // TODO : 나중에 수정
    // video 켜기 or 끄기
    toggleMuteVideo(menu_change = true) {
        // localStream 중 videoTrack이 있는지 확인
        // -> 없으면 아직 송출 X -> localStream으로 송출함
        let isNotPublihsed = true;
        let video_track = null;

        if (this._local_tracks !== null) {

            for (const key in this._local_tracks) {
                let stream = this._local_tracks[key];
                if (stream) {
                    try {
                        let tracks = stream.getTracks();
                        for (let i in tracks) {
                            let track = tracks[i];
                            if (track.kind === "video") {
                                if (video_track != null) {
                                    console.error("의도하지 않은 상황, local_track에 복수의 비디오 stream이 있음");
                                }
                                video_track = track;
                                isNotPublihsed = false;
                            }

                        }

                    } catch (e) {
                        console.error(" self-janus-plugin error onlocaltrack : " + e)
                    }
                }
            }
        }


        if (isNotPublihsed) {
            this.publishOwnFeed(false, true);
            return;
        }


        if (video_track !== null) {
            let trackId = video_track.id.replace(/[{}]/g, "");

            let unpublish = { request: "unpublish" };
            this._self_video_plugin_handler.send({ message: unpublish });            
            this._video_list.videoElement_addOrGetElement(this._self_userInfo_id).void_change_status_video(false);
            if (menu_change) {
                if (this.isMobile) {
                    this._toggleCamera?.classList.add("toggle");
                } else {
                    this._toggleCamera?.classList.remove("off");
                }
            }

            delete this._local_tracks[trackId];
        }
    }

    b_check_publish_and_stop(kind) {
        let isNotPublihsed = true;

        if (this._local_tracks !== null) {
            for (const key in this._local_tracks) {
                let stream = this._local_tracks[key];
                if (stream) {
                    try {
                        let tracks = stream.getTracks();
                        for (let i in tracks) {
                            let track = tracks[i];
                            if (track.kind === kind) {                                
                                track = track;
                                isNotPublihsed = false;

                                let trackId = track.id.replace(/[{}]/g, "");
                                delete this._local_tracks[trackId];
                                track.stop();
                            }
                        }

                    } catch (e) {
                        console.error(" self-janus-plugin error onlocaltrack : " + e)
                    }
                }
            }
        }


        return !isNotPublihsed;
    }

    b_check_audio_publish() {
        let isNotPublihsed = true;
        let audio_track = null;

        if (this._local_tracks !== null) {
            for (const key in this._local_tracks) {
                let stream = this._local_tracks[key];
                if (stream) {
                    try {
                        let tracks = stream.getTracks();
                        for (let i in tracks) {
                            let track = tracks[i];
                            if (track.kind === "audio") {
                                audio_track = track;
                                isNotPublihsed = false;
                            }

                        }

                    } catch (e) {
                        //console.error(" self-janus-plugin error onlocaltrack : " + e)
                    }
                }
            }
        }


        return !isNotPublihsed;
    }



    // 송출 -> websocket sever랑 연동 생각해야함

    // 송출 종료 -> websocket sever랑 연동 생각해야함

    // 오디오 끄기 -> websocket sever랑 연동 생각해야함

    // 오디오 켜기 -> websocket sever랑 연동 생각해야함

    // 새로운 사람 입장 처리
    // TODO: 태그 부분(하드코딩) 추출하여 분리

    // open, close 이후에 호출 할 것

    openDeviceSetting() {
       this.DEVICE_SETTING.openDeviceSetting();
    }

    closeDeviceSetting() {
        this.DEVICE_SETTING.closeDeviceSetting();
    }

}


class DEVICE_SETTING {
    constructor() {
        this._setting_box_bg = null;
        this._tag_flip_horizon = null;
        this._tag_setting_video = null;

        // 카메라 선택 select_list
        this._tag_video_device_list;

        // mic 선택 select_list
        this._mic_device_list;

        // audio 선택 select_list
        this._audio_device_list = null;

        // mic_test_bar
        this._mic_test_bar;  
    }


    // TODO : 분리
    initView() {
        this._tag_video_device_list = document.getElementById('camera_set');
        this._mic_device_list = document.getElementById('mic_set');
        this._audio_device_list = document.getElementById('speaker_set');
        this._tag_setting_video = document.getElementsByClassName("setting_video")[0].getElementsByTagName("video")[0];

        this._setting_box_bg = document.getElementById("device_setting_bg");
        this._setting_box = document.getElementById("device_setting");
        this.initSetFlipHorizon();
        this._mic_test_bar = document.getElementById("mic_test_bar")

        this._selected_cam_index = -1;        
        this._selected_mic_index = -1;


        this.initChangeDeviceSet();
    }

    // TODO 분리2
    initSetFlipHorizon() {
        // TODO 사실상 하드코딩
        this._tag_flip_horizon = document.getElementById("reversal"); //tag_flip_horizon
        let videoElement = this._tag_setting_video;

        // TODO, 현재 송출 중인 바깥 뷰도 반영 되어야 함.
        this._tag_flip_horizon.addEventListener("change", () => {
            let selfVideoElement = WEBRTC_CLIENT.INSTANCE._video_list.videoElement_getElementOrNull(WEBRTC_CLIENT.INSTANCE._self_userInfo_id);

            if (this._tag_flip_horizon.checked) {                
                selfVideoElement._videoElement.style.transform = `scaleX(-1)`
                videoElement.style.transform = `scaleX(-1)`;
            } else {            
                selfVideoElement._videoElement.style.transform = `scaleX(1)`
                videoElement.style.transform = `scaleX(1)`;
            }
        })
    }

    // TODO Listener가 창이 실행될 때 마다가 아닌 한번만 적용시키기
    initChangeDeviceSet() {

        let video_device_list =  this._tag_video_device_list; 
        let mic_device_list = this._mic_device_list;

        let start_media_stream = () => {
            let videoElement = this._tag_setting_video;

            let isVideo = this._selected_cam_index !== video_device_list.selectedIndex

            this._selected_cam_index = video_device_list.selectedIndex;
            this._selected_mic_index = mic_device_list.selectedIndex;

            const selected_cam_index = video_device_list.value;
            const selected_mic_index = mic_device_list.value;



            navigator.mediaDevices.getUserMedia({
                video: { deviceId: selected_cam_index },
                audio: { deviceId: selected_mic_index }
            })
                .then(stream => {
                    videoElement.srcObject = stream;

                    this.detatchAudioStreamListener();
                    this.attachAudioStreamListener(stream);

                    if (isVideo) {
                       WEBRTC_CLIENT.INSTANCE.rePublishOwnFeed(false, true);
                    } else {
                       WEBRTC_CLIENT.INSTANCE.rePublishOwnFeed(true, false);
                    }
                    
                })
                .catch(error => {
                    //console.error('미디어 스트림 가져오기 실패:', error);
                });
        }

        video_device_list.addEventListener('change', start_media_stream);
        mic_device_list.addEventListener('change', start_media_stream);
    }

    //Device Setting 창 열기
    openDeviceSetting() {
        // 1. 기기 리스트를 가져와서 리스트에 띄워줌
        let video_device_list =  this._tag_video_device_list; 
        let mic_device_list = this._mic_device_list;
        let audio_device_list = this._audio_device_list; 
        let audio_test_bar = this._mic_test_bar

        // 리스트 초기화
        video_device_list.innerHTML = '';
        mic_device_list.innerHTML = '';
        audio_device_list.innerHTML = '';


        let videoElement = this._tag_setting_video;     
        
        try {
            if (WEBRTC_CLIENT.INSTANCE.AUDIO_CONTEXT === null) {
                WEBRTC_CLIENT.INSTANCE.AUDIO_CONTEXT = new (window.AudioContext || window.webkitAudioContext)();
            }
        } catch(error) {
            this.AUDIO_CONTEXT = null;
            console.error(`error : ${error}`);
        }
        

        navigator.mediaDevices.enumerateDevices().then(
            devices => {
                devices.forEach(device => {                    

                    const option = document.createElement('option');
                    option.value = device.deviceId;

                    let list = null;

                    switch (device.kind) {
                        case "videoinput": {
                            list = video_device_list;
                        }
                            break;
                        case "audioinput": {
                            list = mic_device_list;
                        }
                            break;
                        case "audiooutput": {
                            list = audio_device_list;
                        }
                            break;

                        default:
                            break;
                    }

                    if (list !== null) {
                        option.text = device.label || `${device.kind} ${list.length + 1}`;
                        list.appendChild(option);
                    }
                });

                if (video_device_list.innerHTML === "") {
                    video_device_list.innerHTML = '<option value="" disabled selected hidden>카메라</option>';   
                }
                if (mic_device_list.innerHTML === "") {
                    mic_device_list.innerHTML = '<option value="" disabled selected hidden>마이크</option>'
                }
                if (audio_device_list.innerHTML === "") {
                    audio_device_list.innerHTML = '<option value="" disabled selected hidden>스피커</option>';
                }      

                let selected_cam_value = null;
                let selected_mic_value = null

                if (video_device_list.options.length !== 0) {
                    video_device_list.selectedIndex = this._selected_cam_index < video_device_list.options.length ? this._selected_cam_index : 0;
                    video_device_list.selectedIndex = video_device_list.selectedIndex < 0 ? 0 : video_device_list.selectedIndex;
                    selected_cam_value = video_device_list.options[video_device_list.selectedIndex].value;
                }

                if (mic_device_list.options.length !== 0) {
                    mic_device_list.selectedIndex = this._selected_mic_index < mic_device_list.options.length ? this._selected_mic_index : 0;
                    mic_device_list.selectedIndex = mic_device_list.selectedIndex < 0 ? 0 : mic_device_list.selectedIndex;
                    selected_mic_value = mic_device_list.options[mic_device_list.selectedIndex].value;

                }

                WEBRTC_CLIENT.USER_MEDIA = navigator.mediaDevices.getUserMedia({
                    video: { deviceId: selected_cam_value },
                    audio: { deviceId: selected_mic_value }
                });

                WEBRTC_CLIENT.USER_MEDIA.then(stream => {
                    videoElement.style.width = "100%";
                    videoElement.style.height = "100%";
                    videoElement.style.objectFit = "cover";                
                    videoElement.srcObject = stream;

                    if (videoElement.pause) {
                        videoElement.play();
                    }

                    this.attachAudioStreamListener(stream);
                })
                WEBRTC_CLIENT.USER_MEDIA.catch(error => {
                    console.error('미디어 스트림 가져오기 실패:', error);
                });


                // 화면 켜기
                this._setting_box_bg.style.display = 'block';
                this._setting_box.scrollTop = 0;

            })
            .catch(error => {
                console.log(`목록 가져오기 실패: ${error}\n`);
            });      
    }

    closeDeviceSetting() {
        // stream을 끔
        let videoElement = this._tag_setting_video; 
        videoElement.srcObject = null;
        if (WEBRTC_CLIENT.USER_MEDIA !== null) {
            WEBRTC_CLIENT.USER_MEDIA.then(stream => {
                const tracks = stream.getTracks();

                tracks.forEach(track => {
                    track.stop();
                })
            })
            WEBRTC_CLIENT.USER_MEDIA = null;
        }

        // 창을 닫음
        this._setting_box_bg.style.display = 'none';

        this.detatchAudioStreamListener();
        
    }

    detatchAudioStreamListener() {
        if (WEBRTC_CLIENT.INSTANCE._listen_local_audio !== null) {
            cancelAnimationFrame(WEBRTC_CLIENT.INSTANCE._listen_local_audio);
            WEBRTC_CLIENT.INSTANCE._listen_local_audio = null;
        }
    }

    attachAudioStreamListener(stream) {
        let getAverageVolume = (array) => {
            let sum = 0;
            for (let i = 0; i < array.length; i++) {
                sum += array[i];
            }
            return sum / array.length;
        }

        const audioContext = WEBRTC_CLIENT.INSTANCE.AUDIO_CONTEXT;//new (window.AudioContext || window.AudioContext)();
        const analyser = audioContext.createAnalyser();
        const microphone = audioContext.createMediaStreamSource(stream);
        microphone.connect(analyser);

        analyser.fftSize = 256;
        const dataArray = new Uint8Array(analyser.frequencyBinCount);

        // 오디오 데이터를 주기적으로 분석
        let updateVolume = () => {
            analyser.getByteFrequencyData(dataArray);
            const average = getAverageVolume(dataArray);

            // 0~100으로 변환
            let volumePercentage = (average / 255) * 100;
            volumePercentage = volumePercentage > 100 ? 100 : volumePercentage;
            //volumeRange.value = volumePercentage.toFixed(0);

            this._mic_test_bar.style.width = volumePercentage + "%";
            //audio_test_bar.style.width = volumePercentage + "%";

            // 주기적으로 업데이트
            WEBRTC_CLIENT.INSTANCE._listen_local_audio = requestAnimationFrame(updateVolume);
        }

        // 오디오 분석 시작
        updateVolume();
    }
}



function void_print_log(string, level = 4) {
    if (level <= INT_DEBUG_LEVEL) {
        console.log(string);
    }
}

// TODO, WebRTC_Client에서 처리할 내용은 아님
// 중복 로그인 방지를 위하여 CSRF를 바인딩 시키고 이것으로 구분함
function getSessionId() {
    // 쿠키 문자열을 가져오기
    var cookies = document.cookie.split(';');
  
    // 쿠키를 순회하며 세션 아이디 찾기
    for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
  
      // 쿠키 이름이 'sessionId'인 경우
      if (cookie.startsWith('csrf_cookie_name=')) {
        // '=' 다음의 값이 세션 아이디
        return cookie.substring('csrf_cookie_name='.length, cookie.length);
      }
    }
  
    // 세션 아이디를 찾지 못한 경우
    return null;
}
