/**
* @enum {int}
*/
const LOG_TYPE = {
    NORMAL : 0,
    WARNING : 1,
    ERROR : 2
}

class LogSystem {    
    /**
     * @param {String} String_name - 로그 시스템 소유 클래스 이름
     * @param {boolean} boolean_Showed - 로그를 보여줄지 말지를 선택함
     * @param {LOG_TYPE} LogType_type - 특정 타입 이상으로 중요한 로그만 보여줌
     * @param {int_show_level} int_show_level - 특정 레벨 이하로 중요한 로그만 보여줌   
     * 
     */
    constructor(String_name, boolean_Showed, LogType_type, int_show_level) {
        this.String_name = String_name;
        this.boolean_Showed = boolean_Showed;
        this.LogType_type = LogType_type; /* 특정 로그 이상만 보임, (ex) NORMAL -> NORM, WARN, ERROR ; ERROR -> ERROR  */
        this.int_show_level = int_show_level; /* 레벨 이하의 로그만 보임 */
    }

    void_print_log(int_level, LogType_type, String_msg) {
        if (!this.boolean_Showed || this.LogType_type > LogType_type || this.init_show_level < int_level) {
            return;
        }

        let String_content = `${this.String_name} : ${String_msg}`;
        
        switch(LogType_type) {
            case LOG_TYPE.NORMAL: {
                console.log(String_content);
            }
            break;
            case LOG_TYPE.WARNING: {
                console.warn(String_content);
            }
            break;
            case LOG_TYPE.ERROR: {
                console.error(String_content);
            }
            break;
        }
    }
    
}