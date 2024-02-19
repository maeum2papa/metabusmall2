class ElementVideo {
    constructor(context,videoinfo) {
        this.arrYoutube = [];
        this.arrYoutubeDiv = [];
        this.arrId = [];
        this.arrVideoPlayer = [];
        this.arrVideoEle = [];
        this.count = 0;
        this.createCount = 0;
        this.videoCount = 0;

        this.first = true;

        for (let type in videoinfo) {
            if (videoinfo[type].isYoutube) { //유튜브 
                this.createYoutube(context,videoinfo[type]);
            } else {    //비디오
                this.createVideo(context,videoinfo[type]);
            }
        }

        for(let i = 0; i < this.arrVideoEle.length; ++i) {
            context.add.dom(+this.arrVideoPlayer[i].dataX,+this.arrVideoPlayer[i].dataY,this.arrVideoEle[i])
            .setOrigin(0.5,0.5)
            .setDepth(100);
        }
    }

    createYoutube(context,infomation) {
        const youtubeDiv = document.createElement('div');
        youtubeDiv.classList.add("youtube");

        document.querySelector("#gamecontainer").appendChild(youtubeDiv);
        let info = infomation;
        if (this.first) {
            this.first = false;

            let tag = document.createElement('script');
            tag.src = 'https://www.youtube.com/iframe_api';
            let fisrtScriptTag = document.getElementsByTagName('script')[0];
            fisrtScriptTag.parentNode.insertBefore(tag, fisrtScriptTag);
        }

        let count = this.count;

        youtubeDiv.id = 'player' + count;
        this.arrId.push('player' + count);
    
        ++this.count;

        window.onYouTubeIframeAPIReady = () => {
            let player;
            let playerId = this.arrId[count];
            player = new YT.Player(playerId, {
                width: `${info.width}`,
                height: `${info.height}`,
                videoId: info.route,
                playerVars: {
                    'rel': 0,
                    'controls': 1,
                    'autoplay': 0,
                    'mute': 0,
                    'loop': 0,
                    'playsinline': 1,
                    'playlist': info.route,
                    'modestbranding': 1,
                },
                events: {
                    'onReady': onPlayerReady,
                    // 'onStateChange': onPlayerStateChange
                }
            });
            // player.dataX = `${info.x}`;
            // player.dataY = `${info.y}`;
            this.arrYoutube.push(player);
        }
        var self = this;
        function onPlayerReady(event) {
            event.target.playVideo();
            self.callback(context,info);
        }

        //var done = false;

        // function onPlayerStateChange(event) {
        // 	 if(event.data == YT.PlayerState.PLAYING && !done) {
        // 		setTimeout(stopVideo,6000);
        // 		done = false;
        // 	}
        // }

        // function stopVideo() {
        // 	player.stopVideo();
        // }
    }
     createVideo(context,info) {

        const video = document.createElement('video');
        video.id = "video" + this.videoCount;
        video.className = "video-js vjs-big-play-centerd";
        video.width = info.width;
        video.height = info.height;

        video.onfocus = function () {
            this.blur();
        }

        document.querySelector("#gamecontainer").appendChild(video);

        let options = this.setVideoOptions(info);
        let player =  videojs(video.id, options);
        player.dataX = `${info.x}`;
        player.dataY = `${info.y}`;

        this.arrVideoPlayer.push(player);

        

        const controlbarButtons = document.querySelectorAll(".vjs-control-bar button");
        for (let i = 0; i < controlbarButtons.length; ++i) {
            controlbarButtons[i].onfocus = function () {
                this.blur();
            }
        }

        this.arrVideoEle = document.querySelectorAll(".video-js");
      
        ++this.videoCount;
    }

    callback(context,info) {
        const arrYoutubeDiv = document.querySelector(`#${this.arrId[this.createCount]}`);

        context.add.dom(+info.x, +info.y,arrYoutubeDiv)
        .setOrigin(0.5,0.5)
        .setDepth(100);
        // for (let i = 0; i < this.arrYoutubeDiv.length; ++i) {
        //     this.arrYoutubeDiv[i].style.display = 'block';
        // }

        ++this.createCount;
    }


    setVideoOptions(info) {
        let videoOp = {
            sources: [
                {
                    src: info.route,
                    type: "video/mp4",
                    label: "720p"
                }
            ],
            poster: info.poster,
            controls: true,
            playsinline: true,
            muted: false,
            preload: "auto",
            controlBar: {
                playToggle: true,
                volumePanel: true,
                pictureInPictureToggle: false,
                remainingTimeDisplay: true,
                progressControl: true,
                qualitySelector: true
            },
            notSupportedMessage: "ERROR",
            inactivityTimeout: 300
        };
        return videoOp;
    }
}