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


class WEBRTC_CLIENT {
    #_interval_id;
    static INSTANCE = null;
    static BANNED = false;
    static FORCE_LOGOUT = false;
    static USER_MEDIA = null;

    static WEBRTC_CLIENT_GET_INSTANCE(infoToSend = null, isMobile = false) {
        if (WEBRTC_CLIENT.INSTANCE === null) {
            WEBRTC_CLIENT.INSTANCE = new WEBRTC_CLIENT(infoToSend, isMobile);
            WEBRTC_CLIENT.INSTANCE._void_start_connect_web_socket(true);
        }
        return WEBRTC_CLIENT.INSTANCE;
    }

    constructor(infoToSend, isMobile = false) {
        this.isMobile = isMobile ? 1 : 0;

        this._video_list = null;
        this._self_userInfo_id = BOOLEAN_FOR_LOCAL_TEST ? parseInt(Math.random() * 1000).toString() : `${infoToSend.currentUser}`;      
        this._local_tracks = {};
        this._web_socket_or_null = null;
        this._room_idx = BOOLEAN_FOR_LOCAL_TEST ? `2345` : `${infoToSend.otherUser}${infoToSend.room}${infoToSend.companyIdx}`;
        this._private_room_idx = null;

        this._janus = null;
        this.#_interval_id = null;

        this._webrtc_callback = new Map(); // key: request, value: list of response_callback;

        this._self_video_plugin_handler = null;
        this._self_audio_plugin_handler = null;
        this._self_screen_share_plugin_handler = null;


        // TODO 임시코드 -> 수정
        this._b_screen_shared = false;

        this._selected_cam_index = -1;
        this._selected_mic_index = -1;
        this._selected_audio_index = -1;


        this._listen_local_audio = null;                       
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

        // TODO 분리하기
        this.initDeviceSettingView();
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

                // 재연결 정리
                clearInterval(WEBRTC_CLIENT.INSTANCE.#_interval_id);
                WEBRTC_CLIENT.INSTANCE.#_interval_id = null;

                WEBRTC_CLIENT.INSTANCE._void_put_request("register_id", (packet) => {

                    // TODO : 등록에 성공한 경우
                    //let keys_string = Array.from(json_data._keys).join(",");
                    //let packet = new SOCKET_PACKET(json_data._request, keys_string, json_data._data);

                    if (packet._data.result === true) {
                        void_print_log(`success id binding - websocket`, 4);

                        if (WEBRTC_CLIENT.INSTANCE._janus === null) {
                            WEBRTC_CLIENT.INSTANCE._void_ready_janus();
                        }
                    }
                });


                let csrf = getSessionId();
                csrf = csrf === null ? "" : csrf;

                // id-binding
                let packet = new SOCKET_PACKET("register_id", "self_idx, csrf", { "self_idx": `${WEBRTC_CLIENT.INSTANCE._self_userInfo_id}`, csrf: `${csrf}` });
                let json = JSON.stringify(packet);
                WEBRTC_CLIENT.INSTANCE._web_socket_or_null?.send(json);
            })

            // WebSocket connection
            WEBRTC_CLIENT.INSTANCE._web_socket_or_null.addEventListener('message', (event) => {
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
                // janus 정리 && videoList도 삭제                
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
            }).bind(this);

                                      
        WEBRTC_CLIENT.INSTANCE._web_socket_or_null.addEventListener('error', (event) => {
            void_print_log(`websocket message error - listener\n${JSON.stringify(error)}`, 4);
        })
            

        } catch (error) {


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
                this._janus.attach(this._pluginHandle_make_self_handle("video"));
                this._janus.attach(this._pluginHandle_make_self_handle("audio"));
            },
            error: (error) => {
                void_print_log(`JANUS object create failed\n${JSON.stringify(error)} \n`, 4);
            },
            destroyed: () => {
                void_print_log("JANUS object destroyed", 4);
                WEBRTC_CLIENT.INSTANCE._janus = null;
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

                // websocket에서 방 입장 전 검사하기 -> 
                // request, response로 두기
                WEBRTC_CLIENT.INSTANCE._void_put_request("response_room_exist", (packet) => {
                    if (packet._data.hasOwnProperty('room_exist') && packet._data.room_exist) {
                        let id = `${this._self_userInfo_id}${type === "video" ? "_v" : "_a"}`;

                        let register = {
                            request: "join",
                            room: this._room_idx,
                            ptype: "publisher",
                            id: id,//this._self_userInfo_id,
                        };

                        let success = (data) => {
                            void_print_log(`self-handler join room success`, 4);
                        }

                        let error = (error) => {
                            void_print_log(`self-handler join room error\n${JSON.stringify(error)}\n`, 4);
                        }

                        // 방에 참가하는 코드1                        
                        handle.send({ message: register, success: success, error: error });
                    }
                    console.log("콜백 테스트")
                }
                );

                // audio일 때 두번 요청 방지
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
                // Janus WebRTC Gateway에서 사용자의 개인 정보 처리에 대한 동의를 얻기 위한 컨센트 다이얼로그(consent dialog)를 관리하는 개체
                // TODO : on & off 파악하여 대기하는 동안에는 publishing 요청 방지 (동의 창이 여러번 나오게 됨.)
            },
            onmessage: (message, jsep) => {
            
                let event = message["videoroom"];
                if (event) {

                    // 방 입장에 성공했을 때
                    // TODO 임시코드 -> audio & video 핸들러 구분하면서 방 입장을 두번해서
                    if (event === "joined" && type === "video") {
                        void_print_log("방 입장에 성공함", 4);
                        this._video_list = new VideoList(document.getElementsByClassName(STRING_ROOT_TAG_ID_VIDEO_LIST)[WEBRTC_CLIENT.INSTANCE.isMobile], WEBRTC_CLIENT.INSTANCE.isMobile);
                        this._video_list.videoElement_addOrGetElement(this._self_userInfo_id);

                        let packet = new SOCKET_PACKET("join_room_success", "room_idx", { "room_idx": `${this._room_idx}` });
                        let json = JSON.stringify(packet);
                        this._web_socket_or_null.send(json);

                    }
                }

                if (event === "destroyed") {
                    void_print_log(`[${handler_name}] the room destroyed`, 4);
                } else if (event === "event") {
                    /*if (message["leaving"]) {
                        void_print_log(`[${handler_name}] ${message["leaving"]}leave the room`, 4);
                    }*/

                    if (message["leaving"]) {
                        WEBRTC_CLIENT.INSTANCE._video_list.b_removeElement(message["leaving"]);
                        void_print_log(`${message["leaving"]}님이 나갔습니다.\n`, 4);
                    }
                } else {
                    void_print_log(`[${handler_name}] undefined message :\n${event}\n`, 4);
                }

                // 카메라 혹은 비디오 송출하는 사람 리스트 확인
                // 핸들러 추가
                // WebSocket에 stream 상태 조회 후에 audio & video 활성화 하기
                // 이미 있는 경우는 생략

                if (message["publishers"] && type === "video") {
                    let list = message["publishers"];

                    for (let p in list) {
                        let id = list[p]["id"];
                        let streams = list[p]["streams"];

                        for (let s in streams) {
                            let stream = streams[s];
                            stream['id'] = id;
                        }

                        // remoteHandler 추가하는 코드
                        // TODO : 임시코드임 추후 수정 필요
                        let self_id = id.replace(/_v|_a/g, "");
                        if (self_id !== this._self_userInfo_id) {
                            WEBRTC_CLIENT.INSTANCE.newRemoteFeed(id, streams)
                        }
                    }
                }

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
                
                // track check
                // on -> 각각 audio, video 연결
                // off -> stream 중지 처리
                // OLD VERSION
                // TODO : 추후 수정

                // track ID를 요소의 이름으로 쓸 건데, 유효하지 않은 문자가 포함되어 있는 것을 정규식을 통해 제거함.
                let trackId = track.id.replace(/[{}]/g, "");

                if (!on) {
                    //console.log("스트림을 끄려함.");
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
                            //console.error(" self-janus-plugin error onlocaltrack : " + e)
                        }
                    }
                    if (track.kind === "video") {
                        let box = this._video_list.videoElement_addOrGetElement(this._self_userInfo_id);
                        box.void_change_status_video(false);
                    }

                    delete this._local_tracks[trackId];
                    return;
                }

                // TODO 뭐지 이 코드는
                // 여기 시점에서는 new track이 추가되어야 한다고 볼 수 있음
                /* let stream = this._local_tracks[trackId];
                if (stream) {
                    // 아직 track이 준비되지 않은 상태임
                    return;
                } */

                if (track.kind === "audio") {
                    let stream = new MediaStream([track]);;
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



    // TODO : 모바일쪽 아직 기기 설정 화면을 안 만듬
    // 처리 후에 dom 다시 잡기

    initDeviceSettingView() {
        // TODO 사실상 하드코딩
        let checkbox = document.getElementById("reversal");
        let videoElement = document.getElementsByClassName("setting_video")[0].getElementsByTagName("video")[0];

        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                let selfVideoElement = WEBRTC_CLIENT.INSTANCE._video_list.videoElement_getElementOrNull(WEBRTC_CLIENT.INSTANCE._self_userInfo_id);
                selfVideoElement._videoElement.style.transform = `scaleX(-1)`
                videoElement.style.transform = `scaleX(-1)`;
            } else {
                let selfVideoElement = WEBRTC_CLIENT.INSTANCE._video_list.videoElement_getElementOrNull(WEBRTC_CLIENT.INSTANCE._self_userInfo_id);
                selfVideoElement._videoElement.style.transform = `scaleX(1)`
                videoElement.style.transform = `scaleX(1)`;
            }
        })
    }


    openDeviceSetting() {
        // 1. 기기 리스트를 가져와서 리스트에 띄워줌
        let video_device_list = document.getElementById('camera_set');
        let mic_device_list = document.getElementById('mic_set');
        let audio_device_list = document.getElementById('speaker_set');

        // 리스트 초기화
        video_device_list.innerHTML = ''; 
        mic_device_list.innerHTML = '';
        audio_device_list.innerHTML = '';

        console.log("openDeviceSetting called");

        let videoElement = document.getElementsByClassName("setting_video")[0].getElementsByTagName("video")[0];

        navigator.mediaDevices.enumerateDevices().then(
            devices => {
                devices.forEach(device => {

                    console.log("forEach find devices");


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

                console.log("before getUserMedia completed\n");

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

                    let getAverageVolume = (array) => {
                        let sum = 0;
                        for (let i = 0; i < array.length; i++) {
                            sum += array[i];
                        }
                        return sum / array.length;
                    }

                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const analyser = audioContext.createAnalyser();
                    const microphone = audioContext.createMediaStreamSource(stream);
                    microphone.connect(analyser);

                    analyser.fftSize = 256;
                    const dataArray = new Uint8Array(analyser.frequencyBinCount);

                    // 오디오 데이터를 주기적으로 분석
                    function updateVolume() {
                        analyser.getByteFrequencyData(dataArray);
                        const average = getAverageVolume(dataArray);

                        // 0~100으로 변환
                        let volumePercentage = (average / 255) * 100;
                        volumePercentage = volumePercentage > 100 ? 100 : volumePercentage;
                        //volumeRange.value = volumePercentage.toFixed(0);

                        document.getElementById("mic_test_bar").style.width = volumePercentage + "%";

                        // 주기적으로 업데이트
                        WEBRTC_CLIENT.INSTANCE._listen_local_audio = requestAnimationFrame(updateVolume);
                    }

                    // 오디오 분석 시작
                    updateVolume();
                })
                WEBRTC_CLIENT.USER_MEDIA.catch(error => {
                    console.error('미디어 스트림 가져오기 실패:', error);
                });


                // TODO: 스피커 안되는 거 확인해서 제외시킴.

                let start_media_stream = () => {

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

                            if (isVideo) {
                               this.rePublishOwnFeed(false, true);
                            } else {
                               this.rePublishOwnFeed(true, false);
                            }
                            
                        })
                        .catch(error => {
                            //console.error('미디어 스트림 가져오기 실패:', error);
                        });
                }


                if (!WEBRTC_CLIENT.temp[0]) {
                    video_device_list.addEventListener('change', start_media_stream);
                    WEBRTC_CLIENT.temp[0] = true;
                }

                if (!WEBRTC_CLIENT.temp[1]) {
                    mic_device_list.addEventListener('change', start_media_stream);
                    WEBRTC_CLIENT.temp[1] = true;
                }
                
                // 화면 켜기
                document.getElementById("device_setting_bg").style.display = 'block';
                document.getElementById("device_setting").scrollTop = 0;                
            })
            .catch(error => {
                console.log(`목록 가져오기 실패: ${error}\n`);
            });

        // 이전의 설정값 입니다

        // 2. stream을 시작함        

        //options[list.selectedIndex].value

        // 오디오의 경우 마이크 테스트 게이지가 움직임
        // select에 listener을 달아서, 리스트가 바뀌면 스트림이 달라짐

    }

    // TODO 나중에 class뺄 떄 따로
    static temp = [false, false];

    closeDeviceSetting() {
        // stream을 끔
        let video_device_list = document.getElementById('camera_set');
        let mic_device_list = document.getElementById('mic_set');


        let videoElement = document.getElementsByClassName("setting_video")[0].getElementsByTagName("video")[0];
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
        document.getElementById("device_setting_bg").style.display = 'none';

        if (WEBRTC_CLIENT.INSTANCE._listen_local_audio !== null) {
            cancelAnimationFrame(WEBRTC_CLIENT.INSTANCE._listen_local_audio);
            WEBRTC_CLIENT.INSTANCE._listen_local_audio = null;
        }


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
                        room: this._private_room_idx !== null ? this._private_room_idx : this._room_idx, // 방 번호 - 추후 필요한 곳으로 연결하기
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
                                    // Audio + Video 권한 확인 에러시 이게 나타남
                                    console.log("test : " + error);
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

                    if (!on) {
                        WEBRTC_CLIENT.INSTANCE.endShareScreen();
                    }

                    if (on) {
                        let btn_share_screen = document.getElementById("share_screen");
                        let btn_child_img = btn_share_screen.getElementsByTagName('img')[0]
                        btn_share_screen.innerHTML = '';
                        btn_share_screen.append(btn_child_img);
                        btn_share_screen.append("공유 중지");
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



    // TODO privateRoom 들어가기

    _outOfCurrentRoom() {
        const message = {
            request: 'leave',
        }        

        let plugin_type = ["video", "audio"]
        let handler = [this._self_video_plugin_handler, this._self_audio_plugin_handler];


        for (let i = 0; i < 2; ++i) {
            const success = (data) => {
                console.log(`${plugin_type[i]} plugin leave success for join private_room`);
            }
            
            const error = (data) => {
                console.log(`${plugin_type[i]} plugin leave error for join private_room`);
            }

            handler[i]._self_video_plugin_handler.send({ message: message, success: success, error: error });            

        }    
        
        this.endShareScreen();
        
    }

    // TOOD 나중에 유지보수
    joinPrivateRoom(room_idx) {
        // 전체 방 나가기
       this._outOfCurrentRoom();
        
        // private Room 접속하기       
        //this._janus.attach(this._pluginHandle_make_self_handle("video", room_idx));
        //this._janus.attach(this._pluginHandle_make_self_handle("audio", room_idx));         
    }

    leavePrivateRoom(room_idx) {
        // private 방 나가기
        // 이전 방 접속하기
    }



    // OLD_VERSION
    // TODO : 나중에 수정,
    publishOwnFeed(bAudio, bVideo) {
        if (bAudio === bVideo) {
            throw Error("한 번에 둘 중 하나만 켜주세요.");
        }

        let tracks = [];

        //옵션에서 가져오는 코드        
        if (bAudio) {
            let capture = true;
            if (this._selected_mic_index !== -1) {
                // TODO : select 코드 분리
                //let list = this.DEVICE_SETTING._mic_device_list;
                let list = document.getElementById("mic_set");
                
                let device_id = list.options[list.selectedIndex].value;
                capture = { deviceId: { exact: device_id } };

            }

            tracks.push({ type: 'audio', mid: 0, capture: capture, recv: false });
        }

        if (bVideo) {
            let capture = true;
            if (this._selected_cam_index !== -1) {
                // TODO : select 코드 분리
                //let list = this.DEVICE_SETTING._tag_video_device_list

                let list = document.getElementById("camera_set");
                let device_id = list.options[list.selectedIndex].value;

                capture = { deviceId: { exact: device_id } };
            }

            tracks.push({ type: 'video', mid: 1, capture: capture, recv: false });

        }

        let plug_handler;

        if (bAudio) {
            plug_handler = this._self_audio_plugin_handler;
        } else if (bVideo) {
            plug_handler = this._self_video_plugin_handler;
        }


        plug_handler.createOffer(
            {
                tracks: tracks,
                success: function (jsep) {
                    let publish = { request: "configure" };
                    if (bAudio) {
                        publish["audio"] = true;
                    }

                    if (bVideo) {
                        publish["video"] = true;
                    }



                    plug_handler.send({ message: publish, jsep: jsep });
                },
                error: function (error) {
                    if (error.message === "Requested device not found" || error.message === "Could not start video source") {
                        alert("카메라 및 마이크가 연결되었는지 확인해주세요.");
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
            let plug_handler = this._self_audio_plugin_handler;
            if (this.b_check_audio_publish()) {
                this.publishOwnFeed(true, false);
            }
        } 
        
        if (bVideo) {
            let plug_handler = this._self_video_plugin_handler;
            if (this.b_check_video_publish()) {
                this.publishOwnFeed(false, true);
            }
        }        
    }
            

    // OLD_VERSION
    // TODO : 나중에 수정
    newRemoteFeed(id, streams) {
        let remote_handle = null;
        if (!streams) {
            return;
        }


        void_print_log("new Remote Feed Function", 6);

        let room_number = this._room_idx;
        let video_list = this._video_list;

        this._janus.attach(
            {
                plugin: "janus.plugin.videoroom",
                success: function (plug_handle) {
                    remote_handle = plug_handle;
                    remote_handle.remoteTracks = {};

                    let subscription = [];
                    for (let i in streams) {
                        let stream = streams[i];

                        // codec에 따라 처리함, ex) 게시자가 VP8/VP9 코덱이라고 가정, 현재 사용 중인 브라우저가 오래된 Safari인 경우, 비디오를 피한다.
                        subscription.push({
                            feed: stream.id, // 필수사항
                            mid: stream.mid // 선택사항 (생략시 모든 stream이 대상이 된다.)
                        })

                        // 용도를 잘 모르겠음 (* Meet 코드에는 없고, 예제에만 있음)
                        // FIXME Right now, this is always the same feed: in the future, it won't
                        // remoteFeed.rfid = stream.id;
                        // remoteFeed.rfdisplay = escapeXmlTags(stream.display);
                    }

                    // 방 출입하는 코드

                    // plugin의 오퍼를 기다림
                    let subscribe = {
                        request: "join",
                        room: room_number, // 방 번호 - 추후 필요한 곳으로 연결하기
                        ptype: "subscriber",
                        streams: subscription
                        // streams: subscription, //-> 예제 코드에만 있음 Meet에는 없고
                        // use_msid: use_msid, 잘 모르겠음. -> 예제 코드에만 있음
                        // private_id: mypvtid 잘 모르겠음. -> 예제 코드에만 있음
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
                    //print_log('new remote-error ' + error);
                },
                iceState: function (state) {
                    // 핸들에 관련된 PeerConnection에 대한 ICE 상태가 변경될 때,
                    //janus.log("ICE state (feed #" + remote_handle.rfindex + ") changed to " + state);
                },
                webrtcState: function (on) {
                    // Handle에 연결된 PeerConnection이 Janus 관점에서 활성화 될 때, 
                    // 따라서, ICE & DTLS 및 모든 것이 성공했을 때 -> true

                    //janus.log("Janus says this WebRTC PeerConnection (feed #" + remote_handle.rfindex + ") is " + (on ? "up" : "down") + " now");
                },
                slowLink: function (uplink, lost, mid) {
                    Janus.warn("Janus reports problems " + (uplink ? "sending" : "receiving") +
                        " packets on mid " + mid + " (" + lost + " lost packets)");
                },
                onmessage: function (message, jsep) {
                    Janus.debug(" ::: (subscriber)로 부터 메세지를 받음 :::", message);
                    //print_log("[remoteHandler] new message come : %o", message);

                    let event = message["videoroom"];

                    // 에러 처리 early exit
                    if (message["error"]) {
                        return;
                    }

                    if (event) {
                        if (event === "attached") {

                        } else if (event === "event") {

                        } else {
                            // 기대되지 않은 처리
                        }
                    } else {
                        // 의도하지 않은 동작
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
                                    let body = { request: "start", room: room_number };
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
                    // metadata field;

                    console.log("onremotetrack metadata : %o", metadata);
                    console.log("onremotetrack track : %o", track);
                    console.log("onremotetrack on : " + on);




                    if (!on) {
                        track.stop();
                        if (track.kind === "video") {
                            let element_or_null = video_list.videoElement_getElementOrNull(id);
                            if (element_or_null !== null) {
                                element_or_null.void_change_status_video(false);
                            }
                        }

                        if (track.kind === "audio") {
                            let element_or_null = video_list.videoElement_getElementOrNull(id);
                            if (element_or_null !== null) {
                                element_or_null.void_change_status_audio(false);
                            }
                        }
                       

                        delete remote_handle.remoteTracks[mid];
                        return;
                    }

                    if (track.kind === "audio") {
                        let stream = new MediaStream([track]);
                        remote_handle.remoteTracks[mid] = stream;

                        if (`${metadata.reason}` !== 'created') {
                            let box = video_list.videoElement_addOrGetElement(id);
                            box.void_attach_audio_stream(stream);
                        }

                    } else if (track.kind === "video") {

                        let stream = new MediaStream([track]);
                        remote_handle.remoteTracks[mid] = stream;

                        //janus.log("Created remote stream:", stream);
                        //janus.log(stream.getTracks());
                        //janus.log(stream.getVideoTracks());

                        let box = video_list.videoElement_addOrGetElement(id)

                        box.void_change_status_video(true);
                        box.void_attach_video_stream(stream);

                    }

                },
                oncleanup: function () {
                    // 방을 폭파했을 때
                    remote_handle.remoteTracks = {};
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

    b_check_video_publish() {
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

    /*openDeviceSetting() {
       this.DEVICE_SETTING.openDeviceSetting();
    }

    closeDeviceSetting() {
        this.DEVICE_SETTING.closeDeviceSetting();
    }*/

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