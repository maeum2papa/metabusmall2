class AnimCreate {
    constructor() {}

    saveJSON() {
        var curJson;

       return  fetch('static/client/assets/Json/player_animation.json');
            // .then(res => {
            //     return res.json()
            // })
            // .catch(err => {
            //     console.log("!!ERROR!!" + err)
            // })
            // .then(jsondata => {
            //     curJson = jsondata
            //     console.log(jsondata)
            //     curJson.anims.push({
            //         "key": data + "Walk_Down",
            //         "type": "frame",
            //         "frames": [
            //             {
            //                 "key": data,
            //                 "frame": 1,
            //                 "duration": 0
            //             },
            //             {
            //                 "key": data,
            //                 "frame": 2,
            //                 "duration": 0
            //             },
            //             {
            //                 "key": data,
            //                 "frame": 3,
            //                 "duration": 0
            //             },
            //             {
            //                 "key": data,
            //                 "frame": 4,
            //                 "duration": 0
            //             },
            //             {
            //                 "key": data,
            //                 "frame": 5,
            //                 "duration": 0
            //             },
            //             {
            //                 "key": data,
            //                 "frame": 6,
            //                 "duration": 0
            //             }
            //         ],
            //         "frameRate": 16,
            //         "duration": 0,
            //         "skipMissedFrames": true,
            //         "delay": 0,
            //         "repeat": -1,
            //         "repeatDelay": 0,
            //         "yoyo": false,
            //         "showOnStart": false,
            //         "hideOnComplete": false
            //     },
            //         {
            //             "key": data + "Walk_Left",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 8,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 9,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 10,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 11,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 12,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 13,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": -1,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Walk_Right",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 15,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 16,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 17,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 18,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 19,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 20,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": -1,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Walk_Up",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 22,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 23,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 24,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 25,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 26,
            //                     "duration": 0
            //                 },
            //                 {
            //                     "key": data,
            //                     "frame": 27,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": -1,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Idle_Down",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 0,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Idle_Left",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 7,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Idle_Right",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 14,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Idle_Up",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 21,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Jump_Down",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 28,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Jump_Left",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 29,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Jump_Right",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 30,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         },
            //         {
            //             "key": data + "Jump_Up",
            //             "type": "frame",
            //             "frames": [
            //                 {
            //                     "key": data,
            //                     "frame": 31,
            //                     "duration": 0
            //                 }
            //             ],
            //             "frameRate": 16,
            //             "duration": 0,
            //             "skipMissedFrames": true,
            //             "delay": 0,
            //             "repeat": 0,
            //             "repeatDelay": 0,
            //             "yoyo": false,
            //             "showOnStart": false,
            //             "hideOnComplete": false
            //         })
            // })
    }
}