/** 
 * 작성자 : JERRY
 * 2023-01-22
 * 
 * adapter.js, socket_package.js, LogUtil.js
 * 
 * 
 * 
*/

const STRING_WEBSOCKET_URL = "wss://collaborland.kr:8088/ws" //"ws://localhost:8090" 
const STRING_JANUS_URL = "https://collaborland.kr:8088/janus";
const INT_WEBSOCKET_RETRY_DELAY = 3000;
const BOOLEAN_JANUS_DEBUG = false;
const INT_DEBUG_LEVEL = 5;
const BOOLEAN_IS_LOCAL_TEST = false;
const LONG_EVENT_LOOP_TIME = 100;

class TagMap_WebRTCClient {
    static btn_desktop_toggle_camera() {
        return document.querySelector("#toggle_camera");
    } 

    static btn_desktop_toggle_mic() {
        return document.querySelector("#toggle_mic");
    }

    static btn_mobile_toggle_camera() {
        return document.querySelector("#mo_toggle_camera");
    }

    static btn_mobile_toggle_mic() {
        return document.querySelector("#mo_toggle_mic");
    }
    
    static btn_share_screen() {
        return document.getElementById("share_screen");
    }
    
    static btn_desktop_open_setting_device() {
        return document.getElementById("device_setting_btn");
    }

    static btn_mobile_open_setting_device() {
        return document.getElementById("mo_device_setting");
    }

    static btn_close_setting_device() {
        return document.getElementById("device_setting_close");
    }    

    /**
     * 
     * @param {boolean} isMobile - 모바일 여부, 기본은 false
     */
    static div_root_video_list_class(isMobile = false) {
        if (isMobile) {
            return document.getElementsByClassName("video_call_box_wrap")[1];
        } else {
            return document.getElementsByClassName("video_call_box_wrap")[0];
        }
    }
}

const RTC_EVENT_TYPE = {
    LEAVE: "LEAVE",
    MEET: "MEET",
    OUT: "OUT"
}

class WebRTCClient {
    static WebRTCClient_INSTANCE = null;
    static #EVENT_LOOP = null;

    // Colyseus/index.html 파일 기준임.
    static void_INIT_VIEW() {
        if (WebRTCClient.WebRTCClient_INSTANCE === null) {
            throw Exception("create WebRTCClient Instance first");
        }

        let instance = WebRTCClient.WebRTCClient_INSTANCE;

        let btn_toggle_camera;
        let btn_toggle_mic;
        let btn_open_device_setting;
        
        if (instance.boolean_isMobile) {
            btn_toggle_camera = TagMap_WebRTCClient.btn_mobile_toggle_camera();
            btn_toggle_mic = TagMap_WebRTCClient.btn_mobile_toggle_mic();
            btn_open_device_setting = TagMap_WebRTCClient.btn_desktop_open_setting_device();            
        } else {
            btn_toggle_camera = TagMap_WebRTCClient.btn_desktop_toggle_camera();
            btn_toggle_mic = TagMap_WebRTCClient.btn_desktop_toggle_mic();
            btn_open_device_setting = TagMap_WebRTCClient.btn_desktop_open_setting_device();

            if (!btn_toggle_camera.classList.contains('toggle')) {
                btn_toggle_camera.classList.add('toggle');
            }
            if (!btn_toggle_mic.classList.contains('toggle')) {
                btn_toggle_mic.classList.add('toggle');
            }
        }        

        let func_change_status_toggle_button = (btnTag, status) => {
            let String_statusClass = instance.boolean_isMobile ? "toggle" : "off";
            status = instance.boolean_isMobile? !status : status;
            
            if (status) {
                btnTag.classList.add(String_statusClass);
            } else {
                btnTag.classList.remove(String_statusClass);
            }
        };        

        btn_toggle_camera.addEventListener("click", function (event) {
            instance.void_toggleMuteVideo();
            func_change_status_toggle_button(btn_toggle_camera, instance.boolean_videoOn);
        })

        btn_toggle_mic.addEventListener("click", function (event) {
            instance.void_toggleMuteAudio();
            func_change_status_toggle_button(btn_toggle_mic, instance.boolean_micOn);
        })

        TagMap_WebRTCClient.btn_share_screen().addEventListener("click", function (event) {
            instance.toggleShareScreen();
        })

        btn_open_device_setting.addEventListener("click", function (event) {
            instance.void_openDeviceSetting();
        })

        TagMap_WebRTCClient.btn_close_setting_device().addEventListener("click", function (event) {
            instance.void_closeDeviceSetting();
        })


        instance.VideoList_videoList = new VideoList(TagMap_WebRTCClient.div_root_video_list_class(instance.isMobile), instance.isMobile);                
        instance.VideoList_videoList.videoElement_addOrGetElement(instance.String_userIDX, instance.String_instanceID);
    }

    /**
    * @constructor
    * 
    * @param {UserInfo_infoToSend} UserInfo_infoToSend - 유저 정보를 담은 구조체, (* currentUser -> userIdx, type -> mobile 여부가 보장되어 있어야 함, type이 undefined인 경우 desktop으로 간주 *), 초기 최초 1회만
    * @param {String} String_instanceID - 메타버스 공간 안에서 현재 클라이언트를 식별하는 특수한 문자열, 초기 최초 1회만
    * 
    */
    static WEBRTC_CLIENT_GET_INSTANCE(UserInfo_infoToSend = null, String_instanceID) {
        if (WebRTCClient.WebRTCClient_INSTANCE === null) {
            WebRTCClient.WebRTCClient_INSTANCE = new WebRTCClient(UserInfo_infoToSend, String_instanceID);
        }

        return WebRTCClient.WebRTCClient_INSTANCE;
    }
    
    // webSocket 재연결 interval 저장값
    #int_reconnect_webSocket = -1;

    /**
    * @constructor
    * 
    * @param {UserInfo_infoToSend} UserInfo_infoToSend - 유저 정보를 담은 구조체, (* currentUser -> userIdx, type -> mobile 여부가 보장되어 있어야 함, type이 undefined인 경우 desktop으로 간주 *)
    * @param {String} String_instanceID - 메타버스 공간 안에서 현재 클라이언트를 식별하는 특수한 문자열
    * 
    */
    constructor(UserInfo_infoToSend, String_instanceID) {
        this.boolean_isMobile = UserInfo_infoToSend.type === "mobile" ? true : false;
        this.String_instanceID = String_instanceID;
        this.String_userIDX = UserInfo_infoToSend.currentUser; // 회원 정보

        this.LogSystem = new LogSystem("WebRTCClient", true, LOG_TYPE.NORMAL, 5)        
        this.WebSocket_socket = null;            
        this.Janus = null;

        this.Map_webSocketcallback = new Map();

        this.Handler_screenSharePlugin = null;
        this.Handler_sendRTCPlugin = null;

        this.DeviceSetting = new DeviceSetting();
        
        this.JSEP_default = null;
        this.VideoList_videoList = null;

        this.void_startConnectWebSocket(true);

        this.boolean_videoOn = false;
        this.boolean_micOn = false;
        this.boolean_statusChanged = false;
    }


    /**
     * 
     * websocket 
     * 
     * 
     */
    void_startConnectWebSocket(boolean_initialTry = false) {
        let instance = this;
        
        if (boolean_initialTry) {
            instance.void_connectWebSocket();
            return;
        }

        instance.#int_reconnect_webSocket = setInterval(instance.void_connectWebSocket, INT_WEBSOCKET_RETRY_DELAY)
    }

    void_connectWebSocket() {
        let instance = this; 

        try {
            instance.WebSocket_socket = new WebSocket(STRING_WEBSOCKET_URL);
            let socket = instance.WebSocket_socket;

            // TODO, web_socket 재연결시에 굳이 방을 다시 들어갈 필요가 있나? 등 확인하기
            // 만약에 JANUS 서버 join이라면, websocket을 재연결해도 이미 방에 들어가 있는 상태가 됨.

            // initial websocket -> connected;
            socket.addEventListener('open', async (event) => {
                instance.void_print_log(7, LOG_TYPE.NORMAL, "websocket open");

                // 재연결 요청이 남아있다면 이를 정리함
                clearInterval(instance.#int_reconnect_webSocket);
                instance.#int_reconnect_webSocket = null;
                
                instance.void_readyJanus();

                /*instance.void_putRequest("register_id", (packet) => {

                    // TODO : 등록에 실패한 경우                   
                    if (packet._data.result === true) {
                        // ID 등록까지 끝냄
                        instance.void_print_log(7, LOG_TYPE.NORMAL ,`success id binding - websocket`);

                        if (instance.Janus === null) {
                           //WEBRTC_CLIENT.INSTANCE._void_ready_janus();
                        }
                    } else {

                    }
                });*/


                let csrf = getSessionId();
                csrf = csrf === null ? "" : csrf;

                // id-binding request send
                let packet = new SOCKET_PACKET("register_id", "self_idx, csrf", { "self_idx": `${instance.String_userIDX}`, csrf: `${csrf}` });
                let json = JSON.stringify(packet);
                socket?.send(json);
            })

            // WebSocket connection
            socket.addEventListener('message', (event) => {
                // WebSocket no request & response로 auto close 방지
                if (event.data === 'check') {
                    instance.void_print_log(8, LOG_TYPE.NORMAL, `for keep connection`);
                    socket.send('check');
                    return;
                }

                /*try {
                    const json_data = JSON.parse(event.data);
                    let keys_string = Array.from(json_data._keys).join(",");
                    let packet = new SOCKET_PACKET(json_data._request, keys_string, json_data._data);
                    instance.void_print_log(8, LOGTYPE_NORMAL, `${JSON.stringify(event.data)}`);

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
                                socket.close();                                                        
                                
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
                }*/
            })


            // websocket closed;
            socket.addEventListener('close', (event) => {
                instance.void_print_log(6, LOG_TYPE.NORMAL, `close WebSocket`);


                /*instance.void_print_log(6, LOG_TYPE.NORMAL, `close WebSocket`);
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
                }*/
            })

                                      
            socket.addEventListener('error', (event) => {
                void_print_log(`websocket message error - listener\n${JSON.stringify(error)}`, 4);
            })
            

        } catch (error) {
            this.void_print_log(3, LogType.ERROR, `error at void_connect_web_socket ${error}`)
        }
    }

    void_putRequest(request, callback) {
        if (this.Map_webSocketcallback.has(request)) {
            this.Map_webSocketcallback.get(request).push(callback);
        } else {
            this.Map_webSocketcallback.set(request, []);
            this.Map_webSocketcallback.get(request).push(callback);
        }
    }

    
    /**
     * 
     * RTC 부분
     * 
     */
    void_readyJanus() {
        let instance = this;

        let janusInitOption = {
            debug: BOOLEAN_JANUS_DEBUG,
            dependencies: Janus.useDefaultDependencies({ adapter }), /* used adapter.js */
            withCredentials: false,
        }

        let janus_option = {
            server: STRING_JANUS_URL,
            ipv6: true,
            withCredentials: false,
            success: () => {
                instance.void_print_log(7, LOG_TYPE.NORMAL, "JANUS object create success");

                // 자기 자신을 송출할 수 있는 방에 입장함 -> 수정 해야하는 것                
                this.Janus.attach(this.Handler_pluginHandleMakeSelf());                

                setTimeout(() => {
                    WebRTCClient.#EVENT_LOOP  = setInterval(() => {
                        let webrtc_client_bridge = globalTransport.get_bridge("WEBRTC_CLIENT_BRIDGE");
                        let callback = (target_id, obj_order) => {
                            if (obj_order.status === "KEEP") {
                                return;
                            }

                            switch(obj_order.value) {
                                case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.MEET: 
                                    this.void_meetOrLeave(target_id, RTC_EVENT_TYPE.MEET, obj_order.session_id);
                                    break;
                                case WEBRTC_CLIENT_BRIDGE.ORDER_TYPE.LEAVE: 
                                    this.void_meetOrLeave(target_id, RTC_EVENT_TYPE.LEAVE, obj_order.session_id);
                                    break;
                                default:
                                    break;
                            }
                        }
                        
                        webrtc_client_bridge.consume_order(callback);


                    }, LONG_EVENT_LOOP_TIME)
                }, 3000)
            },
            error: (error) => {
                instance.void_print_log(3, LOG_TYPE.ERROR, `JANUS object create failed\n${JSON.stringify(error)} \n`);
            },
            destroyed: () => {
                instance.void_print_log(7, LOG_TYPE.NORMAL, "JANUS object destroyed");

                instance.Janus = null;
                if (WebRTCClient.#EVENT_LOOP !== null) {
                    clearInterval(WebRTCClient.#EVENT_LOOP);
                }

                WebRTCClient.#EVENT_LOOP = null;
            }
        }

        let janusInitCallback = () => {
            instance.Janus = new Janus(janus_option);
        }

        janusInitOption.callback = janusInitCallback;
        Janus.init(janusInitOption);
    }

    Handler_pluginHandleMakeSelf() {
        let instance = this;

        return {
            plugin: 'janus.plugin.videoroom',
            success: (handle) => {
                instance.void_print_log(7, LOG_TYPE.NORMAL, "create success self videoroom_plugin");        
                instance.Handler_sendRTCPlugin = handle;

                // websocket에서 방 입장 전 검사하기
                // websocket에 요청을 보내면 방이 없는 경우 websocket이 방을 만드는 요청을 통해 방을 만들고 돌려줌
                // 이후 해당 방으로 클라이언트에서 janus에 접속함
                /*
                instance.void_putRequest("response_room_exist", (packet) => {
                    if (packet._data.hasOwnProperty('room_exist') && packet._data.room_exist) {
                        // janus에서 같은 id의 핸들러를 등록할 수는 없음.
                        // _v -> video, _a -> mic, _s -> screen, <- 다음과 같이 정의함.
                        let id = `${this.String_userIDX}`;

                        let register = {
                            request: "join",
                            room: this.String_instanceID,
                            ptype: "publisher",
                            id: this.String_instanceID,
                        };

                        let success = (data) => {
                            instance.void_print_log(7, LOG_TYPE.NORMAL ,`self-handler join room success`);
                        }

                        let error = (error) => {
                            instance.void_print_log(3, LOG_TYPE.ERROR , `self-handler join room error\n${JSON.stringify(error)}\n`);                            
                        }

                        // 방에 참가하는 코드1                        
                        handle.send({ message: register, success: success, error: error });
                    }}
                );
            
                let packet = new SOCKET_PACKET("join_room", "room_idx", { "room_idx": `${this._room_idx}` });
                let json = JSON.stringify(packet);
                instance.WebSocket_socket.send(json);
                */

            },
            error: (error) => {
                instance.void_print_log(7, LOG_TYPE.ERROR, `error self videoroom_plugin ${JSON.stringify(error)}`);
            },
            consentDialog: (on) => {
                if (on) {
                    //this._toggleMic.setAttribute('disabled', 'disabled');
                    //this._toggleCamera.setAttribute('disabled', 'disabled');
                } else {
                    //this._toggleMic.removeAttribute('disabled');
                    //this._toggleCamera.removeAttribute('disabled');
                }

                // Janus WebRTC Gateway에서 사용자의 개인 정보 처리에 대한 동의를 얻기 위한 컨센트 다이얼로그(consent dialog)를 관리하는 개체
                // TODO : on & off 파악하여 대기하는 동안에는 publishing 요청 방지 (동의 창이 여러번 나오게 됨.)
            },
            onmessage: (message, jsep) => {                                        
                if (jsep) {                    
                    instance.Handler_sendRTCPlugin.handleRemoteJsep({ jsep: jsep });
                }
            },
            onlocaltrack: (track, on) => {            
                
                this.void_print_log(6, LOG_TYPE.NORMAL, `onlocaltrack ${track.muted}, on : ${on}`);
                                
                // on -> 각각 audio, video 연결 // off -> stream 중지 처리                
                // track ID를 요소의 이름으로 쓸 건데, 유효하지 않은 문자가 포함되어 있는 것을 정규식을 통해 제거함.                
                let id = this.String_userIDX;
                let box = this.VideoList_videoList.videoElement_addOrGetElement(id, this.String_instanceID);

                if (!on) {                    
                    if (track.kind === "video") {                        
                        box.void_change_status_video(false);                            
                    }

                    if (track.kind === "audio") {
                        box.void_change_status_audio(false);
                    }
                    
                    return;
                }

                if (track.kind === "audio") {
                    let stream = new MediaStream([track]);
                    
                    box.void_attach_self_audio_stream(stream);                    

                } else if (track.kind === "video") {
                    let stream = new MediaStream([track]);
                    stream['muted'] = true;                    

                    // 뷰에 비디오를 연결함                                                            
                    box.void_change_status_video(true);
                    box.void_attach_video_stream(stream);
                }
            },
            oncleanup: () => {

            },
            ondetached: () => {

            },
            webrtcState: (is_connected) => {
                instance.void_print_log(7, LOG_TYPE.NORMAL,`[${handler_name}] webrtc_state : ${JSON.stringify(is_connected)}`);
            },
            iceState: (data) => {
                instance.void_print_log(7, LOG_TYPE.NORMAL,`[${handler_name}] ice_state : ${JSON.stringify(data)}`, 5);
            },
            destroyed: () => {
                instance.void_print_log(7, LOG_TYPE.NORMAL,`[${handler_name}] - videoroom_plugin_handler destroyed `, 5);
            }
        };
    }

    void_meetOrLeave(int_userIdx, RTC_EVENT_TYPE_type, String_instanceID) {
        let handler;

        switch(RTC_EVENT_TYPE_type) {
            case RTC_EVENT_TYPE.LEAVE: {
                this.void_leaveOther(String_instanceID);
            }
            break;
            case RTC_EVENT_TYPE.MEET: {
                this.void_meetOther(int_userIdx, String_instanceID);
            }
            break;
        }
    }

    void_leaveOther(String_instanceID) {
        let message = {request: "leave"};
        let array = [];

        // TODO 핸들러 array에 추가
        
        for (let handler of array) {        
            if (handler !== undefined) {
                handler.send({ message: message });
            }
        }    

        const onSuccess = (data) => {};
        const onError = (error) => {};

        // let handler = 
        //handler.send({ message: message, success: onSuccess, error: onError });
        // 핸들러 삭제
    }

    void_meetOther(int_userIdx, String_instanceID) {
        /*this.Janus.attach(
            {
                plugin: "janus.plugin.videoroom",
                success: function (pluginHandle) {
                    const register = {
                        request: "join",
                        room: String_instanceID,
                        ptype: "listener", // 사용자 역할을 listener로 설정
                        display: userId,
                      };

                      pluginHandle.send({ message: register });
                      
                      pluginHandle.addHandler({
                        onmessage: (msg, jsep) => {
                            //handleRoomEvents(msg, jsep);
                        },
                        onremotetrack: (track, mid, on, metaData) => {
                            if (!on) {
                                return;
                            }                        
                        },                        
                    });
                }
            }

        )*/
    }

    /**
     * 
     * @param {int} int_level LogLevel
     * @param {LOG_TYPE} LOG_TYPE 타입 
     * @param {String} String_msg - 메세지
     */
    void_print_log(int_level, LogType_type, String_msg) {
        this.LogSystem.void_print_log(int_level, LogType_type, String_msg);
    }

    void_createOffer(callback_getJSEP = null) {
        /*if (!this.boolean_micOn && !this.boolean_videoOn) {
            this.void_print_log(5, LOG_TYPE.WARNING, "video & audio 둘다 끄는 설정이라 offer를 만들 필요가 없음");
            return;
        }*/
        
        let tracks = [];
        let capture = true;
        let instance = this;
        

        if (this.DeviceSetting.int_selectedMicIndex !== -1) {            
            let list = TagMap_DeviceSetting.selector_set_mic();        
            let deviceId = list.options[list.selectedIndex].value;
            capture = { deviceId: { exact: deviceId } };
        }

        let Track_audioTrack = { type: 'audio', mid: '0', capture: capture, recv: false };

        if (!this.boolean_micOn) {
            Track_audioTrack["remove"] = true;
            Track_audioTrack["capture"] = false;
        }

        tracks.push(Track_audioTrack);
        
        if (this.DeviceSetting.int_selectedCamIndex !== -1) {            
            let list = TagMap_DeviceSetting.selector_set_camera();        
            let deviceId = list.options[list.selectedIndex].value;
            capture = { deviceId: { exact: deviceId } };
        }

        let Track_videoTrack = { type: 'video', mid: '1', capture: capture, recv: false };
        
        if (!this.boolean_videoOn) {
            Track_videoTrack["remove"] = true;
            Track_videoTrack["capture"] = false;
        }

        tracks.push(Track_videoTrack);
        //tracks.push({ type: 'video', mid: '1', capture: capture, recv: false });


        this.Handler_sendRTCPlugin.createOffer({
            tracks: tracks,
            success: function(jsep) {
                instance.JSEP_default = jsep;                
                if (callback_getJSEP !== null) {
                    callback_getJSEP(jsep);
                }
            },
            error: function(error) {
                instance.JSEP_default = null;
                if (callback_getJSEP !== null) {
                    callback_getJSEP(null);
                }

                if (error.message === "Requested device not found" || error.message === "Could not start video source") {
                    alert(`카메라 및 마이크가 연결되었는지 확인해주세요.`);
                } else if (error.message === "Permission denied") {
                    alert("카메라 및 마이크 사용을 허용해주세요.");
                } else {
                    alert("WebRTC error... " + error.message);
                }
            }
        });
    }

    void_publishOwnFeed() {
        if (this.boolean_statusChanged) {
            this.JSEP_default = null;
            this.boolean_statusChanged = false;
        }

        let func_publish = (jsep) => {
            if (jsep === null) {
                this.void_print_log(5, LOG_TYPE.ERROR, "sdp 생성 실패");
                return;
            }

            let message = { request: "configure" };

            message["audio"] = this.boolean_micOn;
            message["video"] = this.boolean_videoOn;

            //this.Handler_sendRTCPlugin.send({ message: message, jsep: jsep });
        }

        if (this.JSEP_default === null || this.JSEP_default === undefined) {                                           
            this.void_createOffer(func_publish);
        } else {
            func_publish(this.JSEP_default);
        }

    }

    void_toggleMuteVideo() {        
        this.boolean_videoOn = !this.boolean_videoOn;        
        this.boolean_statusChanged = true;
        this.void_publishOwnFeed();                
    }

    void_toggleMuteAudio() {
        this.boolean_micOn = !this.boolean_micOn;
        this.boolean_statusChanged = true;
        this.void_publishOwnFeed();        
    }

    void_toggleShareScreen() {        

    }
    

    /**
     * 
     * DeviceSetting
     * 
     */
    void_openDeviceSetting() {
        this.DeviceSetting.void_openDeviceSetting();
    }

    void_closeDeviceSetting() {
        this.DeviceSetting.void_closeDeviceSetting();
    }

}

class TagMap_DeviceSetting {
    static selector_set_camera() { 
        return document.getElementById('camera_set');
    }
    static selector_set_mic() { 
        return document.getElementById('mic_set');
    }
    static selector_set_speaker() {
        return document.getElementById('speaker_set');
    }
    static video_setting_video() { 
        return document.getElementsByClassName("setting_video")[0].getElementsByTagName("video")[0];
    }
    static div_setting_background() {
        return document.getElementById("device_setting_bg");
    }
    static div_device_setting() {
        return document.getElementById("device_setting");
    }
    static div_mic_test_bar() {
         return document.getElementById("mic_test_bar");
    }

    static input_reversal() {
         return document.getElementById("reversal");
    }

}

class DeviceSetting {
    constructor() {
        this.int_selectedCamIndex = -1;
        this.int_selectedMicIndex = -1;
        this.userMedia = null;
        this.LogSystem = new LogSystem("DeviceSetting", true, LOG_TYPE.NORMAL, 5)
        this.AudioContext_context = null;
        this.frameUpdateVolume= null;
    }

    // TODO: 좌우반전 -> 로직 작성 필요
    void_initSetFlipHorizon() {
        let video_selectedVideoScren = TagMap_DeviceSetting.video_setting_video();
        let input_reversal = TagMap_DeviceSetting.input_reversal();

        input_reversal.addEventListener("change", () => {
            // 송출 중인 비디오에 반영 -> DataChannel 연결시 해결되는 부분

            if (input_reversal.checked) {
                video_selectedVideoScren.style.transform = `scaleX(-1)`
            } else {
                video_selectedVideoScren.style.transform = `scaleX(1)`
            }
        })        
    }

    void_initView() {
        let selector_setCamera = TagMap_DeviceSetting.selector_set_camera();
        let selector_setMic = TagMap_DeviceSetting.selector_set_mic();

        let func_startMediaStream = () => {
            let Video_videoElement = TagMap_DeviceSetting.video_setting_video;

            this.int_selectedCamIndex = selector_setCamera.selectedIndex;
            this.int_selectedMicIndex = selector_setMic.selectedIndex;

            const String_selectedCamDeviceID = selector_setCamera.value;
            const String_selectedMicDeviceID = selector_setMic.value;

            navigator.mediaDevices.getUserMedia({
                video: { deviceId: String_selectedCamDeviceID },
                audio: { deviceId: String_selectedMicDeviceID }
            }).then(stream => {
                Video_videoElement.srcObject = stream;

                // 음량 표시
                this.detatchAudioStreamListener();
                this.attachAudioStreamListener(stream);

                // TODO : 이미 송출중인 경우 자동 송출하게 변경하기
            })
        }

        selector_setCamera.addEventListener('change', func_startMediaStream);
        selector_setMic.addEventListener('change', func_startMediaStream);
    }

    void_openDeviceSetting() {                
        let selector_setCamera = TagMap_DeviceSetting.selector_set_camera();
        let selector_setMic = TagMap_DeviceSetting.selector_set_mic();
        
        let selector_setSpeaker = TagMap_DeviceSetting.selector_set_speaker();
        
        // 리스트 초기화
        selector_setCamera.innerHTML = '';
        selector_setMic.innerHTML = '';
        selector_setSpeaker.innerHTML = '';


        let video_videoElement = TagMap_DeviceSetting.video_setting_video();
        
        try {
            if (this.AudioContext_context === null) {
                this.AudioContext_context = new (window.AudioContext || window.webkitAudioContext)();
            }
        } catch(error) {
            this.AudioContext_context = null;
            this.void_print_log(4, LOG_TYPE.ERROR, `create audio context failed: ${error}\n`)                  
        }
        

        navigator.mediaDevices.enumerateDevices().then(
            devices => {
                devices.forEach(device => {                    

                    const option = document.createElement('option');
                    option.value = device.deviceId;

                    let selector_list = null;

                    switch (device.kind) {
                        case "videoinput": {
                            selector_list = selector_setCamera;
                        }
                            break;
                        case "audioinput": {
                            selector_list = selector_setMic;
                        }
                            break;
                        case "audiooutput": {
                            selector_list = selector_setSpeaker;
                        }
                            break;

                        default:
                            break;
                    }

                    if (selector_list !== null) {
                        option.text = device.label || `${device.kind} ${selector_list.length + 1}`;
                        selector_list.appendChild(option);
                    }
                });

                if (selector_setCamera.innerHTML === "") {
                    selector_setCamera.innerHTML = '<option value="" disabled selected hidden>카메라</option>';   
                }
                if (selector_setMic.innerHTML === "") {
                    selector_setMic.innerHTML = '<option value="" disabled selected hidden>마이크</option>'
                }
                if (selector_setSpeaker.innerHTML === "") {
                    selector_setSpeaker.innerHTML = '<option value="" disabled selected hidden>스피커</option>';
                }      

                let String_selectedCamDeviceID = null; // selector_setCamera.value;
                let String_selectedMicDeviceID = null; // selector_setMic.value;

                if (selector_setCamera.options.length !== 0) {
                    selector_setCamera.selectedIndex = this.int_selectedCamIndex < selector_setCamera.options.length ? this.int_selectedCamIndex : 0;
                    selector_setCamera.selectedIndex = selector_setCamera.selectedIndex < 0 ? 0 : selector_setCamera.selectedIndex;
                    String_selectedCamDeviceID = selector_setCamera.options[selector_setCamera.selectedIndex].value;
                }

                if (selector_setMic.options.length !== 0) {
                    selector_setMic.selectedIndex = this.int_selectedMicIndex < selector_setMic.options.length ? this.int_selectedMicIndex : 0;
                    selector_setMic.selectedIndex = selector_setMic.selectedIndex < 0 ? 0 : selector_setMic.selectedIndex;
                    String_selectedMicDeviceID = selector_setMic.options[selector_setMic.selectedIndex].value;

                }

                this.userMedia = navigator.mediaDevices.getUserMedia({
                    video: { deviceId: String_selectedCamDeviceID },
                    audio: { deviceId: String_selectedMicDeviceID }
                });

                this.userMedia.then(stream => {
                    video_videoElement.style.width = "100%";
                    video_videoElement.style.height = "100%";
                    video_videoElement.style.objectFit = "cover";                
                    video_videoElement.srcObject = stream;

                    if (video_videoElement.pause) {
                        video_videoElement.play();
                    }

                    this.attachAudioStreamListener(stream);
                })
                this.userMedia.catch(error => {
                    this.void_print_log(3, LOG_TYPE.ERROR, `get mediaStream failed: ${error}\n`)                    
                });


                // 화면 켜기
                
                TagMap_DeviceSetting.div_setting_background().style.display = 'block';
                TagMap_DeviceSetting.div_device_setting().style.scrollTop = 0;
            })
            .catch(error => {
                this.void_print_log(3, LOG_TYPE.ERROR, `get device list failed: ${error}\n`)      
            });  
    }

    // let audio_test_bar = TagMap_DeviceSetting.audio_test_bar;
    void_closeDeviceSetting() {
        // stream을 끔
        let video_videoElement = TagMap_DeviceSetting.video_setting_video(); 
        video_videoElement.srcObject = null;
        if (this.userMedia !== null) {
            this.userMedia.then(stream => {
                const tracks = stream.getTracks();

                tracks.forEach(track => {
                    track.stop();
                })
            })
            this.userMedia = null;
        }

        // 창을 닫음
        TagMap_DeviceSetting.div_setting_background().style.display = 'none';

        this.detatchAudioStreamListener();
        
    }

    attachAudioStreamListener(stream) {
        let getAverageVolume = (array) => {
            let sum = 0;
            for (let i = 0; i < array.length; i++) {
                sum += array[i];
            }
            return sum / array.length;
        }

        const audioContext = this.AudioContext_context; //new (window.AudioContext || window.AudioContext)();
        const analyser = audioContext.createAnalyser();
        const microphone = audioContext.createMediaStreamSource(stream);
        microphone.connect(analyser);

        analyser.fftSize = 256;
        const dataArray = new Uint8Array(analyser.frequencyBinCount);
        let input_MicTestBar = TagMap_DeviceSetting.div_mic_test_bar();


        // 오디오 데이터를 주기적으로 분석
        let updateVolume = () => {
            analyser.getByteFrequencyData(dataArray);
            const average = getAverageVolume(dataArray);

            // 0~100으로 변환
            let volumePercentage = (average / 255) * 100;
            volumePercentage = volumePercentage > 100 ? 100 : volumePercentage;

            input_MicTestBar.style.width = volumePercentage + "%";

            // 주기적으로 업데이트
            this.frameUpdateVolume = requestAnimationFrame(updateVolume);
        }

        // 오디오 분석 시작
        updateVolume();
    }

    detatchAudioStreamListener() {
        if (this.frameUpdateVolume !== null) {
            cancelAnimationFrame(this.frameUpdateVolume);
            this.frameUpdateVolume = null;
        }
    }

    
    void_print_log(int_level, LogType_type, String_msg) {
        this.LogSystem.void_print_log(int_level, LogType_type, String_msg);
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



