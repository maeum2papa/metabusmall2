const schema = require('@colyseus/schema');
const Schema = schema.Schema;

class Crops extends Schema {
    x;
    y;
    constructor(index,level,totaltime) {
        super();
        this.index = +index;
        this.level = +level;
        this.totalTime = +totaltime !== undefined ? totaltime : 480;
    }
}

schema.defineTypes(Crops, {
    // x:'number',
    // y:'number',
    index:'number',
    level:'number',
    totalTime:'number'
  });

  exports.Crops = Crops;