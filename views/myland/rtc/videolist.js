/*
        <script type="text/javascript" src="./library/janus.js" ></script>
        <script type="text/javascript" src="./library/settings.js" ></script>        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.2.3/adapter.js"></script>
        <script type="text/javascript" src="./videolist.js"></script>
        <script type="text/javascript" src="./yanus_client.js"></script>
*/

const STRING_LAND_RTC_POPUP_TAG = "land_rtc_popup";
const STRING_CLOSE_POPUP_TAG = "rtc_popup_close";
const API_URL = "https://collaborland.kr:8000";


class VideoList {
    #_full_screen_id = null;
    //#_rootView;

    /**
     * 
     * @param {String_tagName} parent_tag : VideoList가 들어가는 TagName
     * @param {boolean} isMobile : 모바일 여부, 기본은 false
     * 
     */
    constructor(parent_tag, isMobile = false) {
        this._root_view = parent_tag;
        this._list = new Map();
        this.isMobile = isMobile;

        this._popup_view = document.getElementById(STRING_LAND_RTC_POPUP_TAG);
        this._popup_view.getElementsByClassName(STRING_CLOSE_POPUP_TAG)[0].addEventListener("click", () => {
            this.void_showTogglePopup(false);
        })
    }

    void_showTogglePopup = (bShow) => {
        if (bShow === true) {
            if (this.#_full_screen_id === null) {
                this.void_showTogglePopup(false);
                return;
            }

            let videoElement = this._list.get(this.#_full_screen_id);
            if (videoElement === null || videoElement === undefined) {
                this.void_showTogglePopup(false);
                return;
            }

            this._popup_view.getElementsByTagName("video")[0].srcObject = videoElement._videoElement.srcObject;
            this._popup_view.style.display = 'block';  
        } else {

            this.#_full_screen_id === null
            this._popup_view.style.display = 'none'
        }
    }

    void_closeMatchFullScreenID(id) {
        if (id === this.#_full_screen_id) {
            this.void_showTogglePopup(false);
        }
    }

    void_forceFullScreenID(id) {
        if (id.includes("_s")) {
            this.#_full_screen_id = id;
            this.void_showTogglePopup(true);
        }
    }    

    videoElement_addOrGetElement(id, session_id) {
        if (this._list.get(session_id) === undefined) {            
            //console.log(id +"가 없어서 새로 만듬");
            // TODO 정규식으로 아이디 뒤의 특수문자 지움, 추후 수정 필요함     
            let display_id = `${id}`.replace(/_v|_a/g, "");

            let videoElement = new VideoElement(session_id, this, this.isMobile, display_id);
                        
            videoElement.b_append_parent_tag(this._root_view);

            this._list.set(session_id, videoElement);

            videoElement._videoCallBox.addEventListener("click", () => {
                if (videoElement.b_get_activated()) {                    
                    this.#_full_screen_id = session_id;                    
                    this.void_showTogglePopup(true);
                }
            })


            return this._list.get(session_id);
        }


        return this._list.get(session_id);
    }

    b_videoElement_set_status(id, status) {
        id = id.replace(/_v|_a/g, "");
        if (this._list.get(id) !== undefined) {
            this._list.get(id).void_change_status_video(status);
            return true;
        }
        return false;
    }

    videoElement_getElementOrNull(id) {
        id = id.replace(/_v|_a/g, "");

        if (this._list.get(id) !== undefined) {
            return this._list.get(id);
        }
        return null;
    }

    b_removeElement(id) {
        id = id.replace(/_v|_a/g, "");

        if (this._list.get(id) === undefined) {
            //console.log("없어서 삭제 못함");
            return false;
        }

        let remove_target = this._list.get(id);
        remove_target.b_remove_parent_tag(this._root_view);
        if (this.#_full_screen_id === id) {
            this.void_showTogglePopup(false);
        }

        delete this._list.delete(id);
        return true;
    }


    // 룸에 있는 사람들만 제거해야 함
    void_destroy_all() {                
        // Map 태그에 남아있는 Listener 제거
        this._list.forEach((value, id) => {
            let remove_target = value;
            remove_target.b_remove_parent_tag(this._root_view);
            if (this.#_full_screen_id === id) {
                this.void_showTogglePopup(false);
            }
        })

        this._list.clear();

        // html 제거
        while (this._root_view.firstChild) {                        
            this._root_view.removeChild(this._root_view.firstChild);                        
        }
    }

    
}


class VideoElement {
    #_interval_id;
    #_interval_id_for_start = null;
    #_audio_listener = false;
    #_audio_connect_loop_id = null;
    #_list;
    #_name;    


    // type -> 1. spot_light, 2.private_room, 3.p2p
    constructor(id, list, isMobile, display_id) {
        let videoCallBox = document.createElement('div');
        videoCallBox.setAttribute('class', 'video_call_box');
        
        
        if (!isMobile) {
            videoCallBox.style.position = 'relative';
        } else {
            videoCallBox.classList.add('swiper-slide');
        }

        let isScreenShared = display_id.indexOf("_s") !== -1;


        this._id = id;

        id = display_id.replace(/_s|_a/g, "");


        this.#_list = list;

        let audioElement = document.createElement('audio');
        let videoElement = document.createElement('video');

        videoElement.style.display = 'none';

        videoElement.controls = false;
        videoElement.autoplay = true;
        videoElement.playsInline = true;
        videoElement.muted = true;
        videoElement.style.position = "absolute";
        videoElement.style.borderRadius = "15px";
        videoElement.style.objectFit = "cover";
        videoElement.style.width = "100%";
        videoElement.style.height = "100%";

        audioElement.autoplay = true;
        audioElement.playsInline = true;

        let labelElement = document.createElement('span');
        
        labelElement.innerText = `${id}`;
        /*if (`${id}` === WEBRTC_CLIENT.INSTANCE._self_userInfo_id) {
            labelElement.style.color = '#6dc3e5';
        }*/

        let temp_id = id.split(":")[0];//replace(/:\d+/g, "");        
        
        const requestNickNameUrl = `${API_URL}/nick?userid=${temp_id}`;

        fetch(requestNickNameUrl)
        .then(response => response.json())
        .then(data => {
            labelElement.innerText = `${data.name}${id.split(":")[1] ? `:${id.split(":")[1]}` : ""}${isScreenShared ? "의 화면": ""}`;

        }).catch(error => {
            console.log("오류 발생" + error);
        })
        


        this._videoElement = videoElement;
        this._audioElement = audioElement;

        videoCallBox.appendChild(videoElement);
        videoCallBox.appendChild(audioElement);
        videoCallBox.appendChild(labelElement);

        // 아바타 추후에 바꿀 수도 있음
        let imgElement = document.createElement('img');
        imgElement.setAttribute('src', '/rtc/image/logo.png');
        videoCallBox.appendChild(imgElement);

        this._videoCallBox = videoCallBox;

        // audio 소리 감지
        this.#_interval_id = null;
        this.#_audio_listener = false;
    }

    b_set_name(name) {
        this.#_name = name;
    }

    b_get_activated() {
        return this._videoElement.style.display === '';
    }

    // 비디오를 활성화 or 비활성화 상태로 함
    void_change_status_video(b_actived) {

        // 활성화
        if (b_actived) {
            this._videoElement.style.display = '';                      
        } else {
            this._videoElement.style.display = 'none'
            this._videoElement.src = '';
            this.#_list.void_closeMatchFullScreenID(this._id);
        }
    }

    // TODO : 임시코드
    // _audio_listener의 초기화 때문에 씀
    void_change_status_audio(b_actived) {
        if (!b_actived) {
            this.#_audio_listener = false;

            if (this.#_interval_id !== null) {            
                clearInterval(this.#_interval_id);
                this.#_interval_id = null;                
            }

            if (this.#_interval_id_for_start !== null) {
                clearInterval(this.#_interval_id_for_start);
                this.#_interval_id_for_start = null;                
            }

            if (this.#_audio_connect_loop_id !== null) {
                clearTimeout(this.#_audio_connect_loop_id);
                this.#_audio_connect_loop_id = null;
            }

            this._videoCallBox.classList.remove("mic_on")
        }
    }

    // Stream Listener 반응을 위해 Janus가 아니라 VideoElement에서 관리하도록 변경함
    void_attach_video_stream(stream) {        

        let isFailed = false;
        try {        
            this._videoElement.srcObject = stream;        
        } catch (e) {                        
            try {                
                
                this._videoElement.src = URL.createObjectURL(stream);
            } catch (e) {
                Janus.error("Error attaching stream to element", e);
                isFailed = true;                
            }
        } finally {
            if (!isFailed) {  
                this.#_list.void_forceFullScreenID(this._id);
                this._videoElement.play();                        
            } else {
                console.log(`failed to set srcObject : ${this._videoElement} ${stream}`);
            }
        }

    }


    void_attach_audio_stream(stream) {
        let isSuccess = true;
        try {
            this._audioElement.srcObject = stream;
        } catch (e) {
            try {
                this._videoElement.src = URL.createObjectURL(stream);
            } catch (e) {
                isSuccess = false;
                Janus.error("Error attaching stream to element", e);
            }
        } finally {
            if (!isSuccess) {
                return;
            }

            let audioElement = this._audioElement;

            // 임시코드, 소리 자동재생 안되서 성공할 때 까지 반복 10초간격
            // 사용자 상호작용이 있어야 성공함.(연관없는 버튼 누르니까 됨)
            // TODO 본 콘텐츠에 붙인 이후에는 잘 될 수도 있음. 사용자 조작이 발생하기 때문에                  
            //playAudio(audioElement);
            let videoElement = this;

            videoElement.#_interval_id_for_start = 1;
            
            // 비디오관련 루프
            setTimeout(function f() {                
                if (videoElement.#_interval_id_for_start !== null) {
                    audioElement.play()
                    .then(function () {
                        console.log("successfully.");
                    })
                    .catch(function (error) {
                        videoElement.#_interval_id_for_start = setTimeout(function () {
                                console.log("Retrying after 5 seconds...");
                                f();
                            }, 5000);
                    });
                }
            }, 100);


            // TODO 임시코드
            // play랑 마찬가지로 사용자 입력이 없는 경우 window.AudioContext가 시작이 안됨. (브라우저에서 막는 거)
            // 그래서 테두리가 안보일 수 있음.
            // 임시로 실패시 3초마다 반복되게 처리함
            

            // TODO : 임시코드 여러번 부착되어서 만든거
            if (this.#_audio_listener === true) {
                return;
            }

            // 오디오 관련 루프
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();

            let checkAudioContext = async () => {
                try {
                    await audioContext.resume();
                } catch(error) {   
                    print(`: 에러 ${error}`);
                }
                
                if (audioContext.state !== "running") {
                    console.log("음성 감지 안되서 3초 뒤에 다시 시도함");
                    videoElement.#_audio_connect_loop_id = setTimeout(() => {
                        checkAudioContext()
                    }, 3000);
                    return;
                } else {
                    videoElement.#_audio_listener = false;
                    const source = audioContext.createMediaStreamSource(stream);        
                    const analyser = audioContext.createAnalyser();
                    analyser.fftSize = 256;
                    source.connect(analyser);
        
                    const dataArray = new Uint8Array(analyser.frequencyBinCount);
        
                    // 특정 시간마다 오디오 사운드 검사
                        if (videoElement.#_interval_id !== null) {
                        clearInterval(videoElement.#_interval_id);
                        videoElement.#_interval_id = null;
                    }
        
                    videoElement.#_interval_id = setInterval(() => {
                        analyser.getByteFrequencyData(dataArray);
                        const average = dataArray.reduce((acc, value) => acc + value, 0) / dataArray.length;
        
                        console.log("setInterval");
        
                        if (average > 1) {
                            videoElement._videoCallBox.classList.add("mic_on")
                        } else {
                            videoElement._videoCallBox.classList.remove("mic_on")
                        }
                    }, 500);
                }   
            }
    
            checkAudioContext();
    
            /*setTimeout(function s() {
                videoElement.#_audio_listener = true;

                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                console.log(`FOR DEBUGING -> STATE : ${audioContext.state}`);
                if (audioContext.state !== "running") {
                    videoElement.#_audio_connect_loop_id = setTimeout(function () {                        
                        s();
                    }, 3000);
                    return;
                }
                const source = audioContext.createMediaStreamSource(stream);        
                const analyser = audioContext.createAnalyser();
                analyser.fftSize = 256;
                source.connect(analyser);
    
                const dataArray = new Uint8Array(analyser.frequencyBinCount);
    
                // 특정 시간마다 오디오 사운드 검사
                 if (videoElement.#_interval_id !== null) {
                    clearInterval(videoElement.#_interval_id);
                    videoElement.#_interval_id = null;
                }
    
                videoElement.#_interval_id = setInterval(() => {
                    analyser.getByteFrequencyData(dataArray);
                    const average = dataArray.reduce((acc, value) => acc + value, 0) / dataArray.length;
    
                    if (average > 1) {
                        videoElement._videoCallBox.classList.add("mic_on")
                    } else {
                        videoElement._videoCallBox.classList.remove("mic_on")
                    }
                }, 500);
            }, 100);*/
          
        }
    }

    // 소리는 없이 외곽선만 표현함;
    void_attach_self_audio_stream(stream) {
        if (this.#_audio_listener === true) {
            return;            
            
        }
        // TODO : 임시코드 여러번 부착되어서 만든거
        let videoElement = this;

        videoElement.#_audio_listener = true;
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        let checkAudioContext = async () => {
            await audioContext.resume();
            if (audioContext.state !== "running") {
                console.log("음성 감지 안되서 3초 뒤에 다시 시도함");
                videoElement.#_audio_connect_loop_id = setTimeout(() => {
                    checkAudioContext()
                }, 3000);
                return;
            } else {
                videoElement.#_audio_listener = false;
                const source = audioContext.createMediaStreamSource(stream);        
                const analyser = audioContext.createAnalyser();
                analyser.fftSize = 256;
                source.connect(analyser);
    
                const dataArray = new Uint8Array(analyser.frequencyBinCount);
    
                // 특정 시간마다 오디오 사운드 검사
                    if (videoElement.#_interval_id !== null) {
                    clearInterval(videoElement.#_interval_id);
                    videoElement.#_interval_id = null;
                }
    
                videoElement.#_interval_id = setInterval(() => {
                    analyser.getByteFrequencyData(dataArray);
                    const average = dataArray.reduce((acc, value) => acc + value, 0) / dataArray.length;
    
                    console.log("setInterval");
    
                    if (average > 1) {
                        videoElement._videoCallBox.classList.add("mic_on")
                    } else {
                        videoElement._videoCallBox.classList.remove("mic_on")
                    }
                }, 500);
            }   
        }

        checkAudioContext();
        
        
    }

    b_append_parent_tag(parent_tag) {
        parent_tag.appendChild(this._videoCallBox);  
    }

    b_remove_parent_tag(parent_tag) {
        clearInterval(this.#_interval_id_for_start);
        clearInterval(this.#_interval_id);
        parent_tag.removeChild(this._videoCallBox);
    }
}
