class SOCKET_PACKET {
    // key는 쉼표 단위로,
    // data는 object
    constructor(request, keys, data) {
      this._request = request
      if (keys !== null) {
        

        this._keys = keys.split(',').map(key => key.trim());  
        this._data = data;

        // 유효한 request 검증
        // _key에 해당하는 값이 data에 있는지 검증
        let len = this._keys.length;

        if (len !== 0 && (data === null || typeof data !== 'object')) {
            throw Error("key는 존재하지만, 데이터가 null 입니다.");
        }

        for (let i = 0; i < len; i++) {
            if (!(this._keys[i] in data)) {
                throw Error(`${this._keys[i]}에 대한 데이터가 누락되어 있습니다.`);
            }            
        }

      } else {
        keys = null;
        if (data !== null) {
            throw Error("key가 누락되어 있습니다.");
        }
      }            

    }
}

