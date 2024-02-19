class Config {
    static title = "CollaborLand";
    static version = "Version 0.0.1";
    static lang = "en";

    static MainDomain = "wss://collaborland.kr/myland/";
    static port = 8000;
    static ColyseusDomain = "wss://collaborland.kr:8000";
    static LocalDomain = "ws://localhost:8000/";
    static Domain = "wss://collaborland.kr:8000";
    static originHttps = "https://collaborland.kr:8000";
    static MainHttps = "https://collaborland.kr/myland/space";
    static DomainPort = 'collaborland.kr:8000';
    static user_info;
    static info_state = Config.END;
    static END; 
    static LOAD;
}

exports.Config = Config;
