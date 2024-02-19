function GetSortingOrder(backY, frontY, objposY) {
    let objDist = Math.abs(backY - objposY);
    let totalDist = Math.abs(backY - frontY);

    return objDist / totalDist;
}

function Linear(p0,p1,t) {
    return (p1 - p0) * t + p0;
}

function TileToWorldXY(tile) {
    let point = {
        x:0,
        y:0
    };

    point.x = tile.x * tile.width;
    point.y = tile.y * tile.height;

    return point;
}

function TileIntersects(tileRect,player) {

    return !(player.x + (96 /2) <= tileRect.left ||
            player.y + (96 /2) <= tileRect.top || 
            player.x >= tileRect.right ||
            player.y >= tileRect.bottom);
}

function RandomPrize(arr) {
    const ranNum = Math.floor(Math.random() * 99) + 1;
    var cumulative = 0;

    for(let i = 0; i < arr.length; ++i) {
        cumulative += +arr[i];
        if(ranNum <= cumulative) {
            return (arr.length - 1) - i;
        }
    }

    RandomPrize(arr);
}

function RandomFishPrize(arr) {
    const ranNum = Math.floor(Math.random() * 99) + 1; 
    var cumulative = 0;

    for(let i = 0; i < arr.length; ++i) {
        cumulative += +arr[i].probability;
        if(ranNum <= cumulative) {
            return i;
        }
    }

    RandomFishPrize(arr);
}

function RandomPercentagePrize(arr) {
    const ranNum = Math.floor(Math.random() * 99) + 1; 
    let cumulative = 0;

    for(let i = 0; i < arr.length; ++i) {
        cumulative += +arr[i];
        if(ranNum <= cumulative) {
            return i;
        }
    }

    RandomPercentagePrize(arr);
}

function GetDate() {
    var regDt = new Date();
    return regDt.getFullYear() + '-' + (regDt.getMonth() + 1) + '-' + regDt.getDate() + ' ' + regDt.getHours() + ':' + regDt.getMinutes() + ':' + Math.floor(regDt.getSeconds());
}

function DatetoDt(regDt) {
    return `${regDt.getFullYear()}/${regDt.getMonth() + 1}/${regDt.getDate()} - ${regDt.getHours()}:${regDt.getMinutes()}:${regDt.getSeconds()}.${regDt.getMilliseconds()}`;
}

function jsonToCSV(title,json) {
    const jsonArr = json;
    let csv_string = '';
    
    const titles = Object.keys(title);

    titles.forEach((title, index) => {
      csv_string += (index !== titles.length - 1 ? `${title},` : `${title}\r\n`);
    });

    jsonArr.forEach((content, index) => {
      let row = '';

      for (let title in content) {
        row += (row === '' ? `${content[title]}` : `,${content[title]}`);
      }

      csv_string += (index !== jsonArr.length - 1 ? `${row}\r\n` : `${row}`);
    });

    return csv_string;
}

function RandomCount(min,max) {
    const ranNum = Math.floor(Math.random() * max) + min; 
    return ranNum;
}

function moveTowards(cur, target, maxDistanceDelta) {
    let a = {
        x: target.x - cur.x, y: target.y - cur.y
    };
    let magnitude = Math.sqrt(a.x * a.x + a.y * a.y);

    if (magnitude <= maxDistanceDelta || magnitude === 0) {
        return target;
    }
    let returnPos = {
        x:0,
        y:0
    };

    returnPos.x = cur.x + a.x / magnitude * maxDistanceDelta;
    returnPos.y = cur.y + a.y / magnitude * maxDistanceDelta;

    return returnPos;
}

function Between(x1,y1,x2,y2) {
    let dx = x1 - x2;
    let dy = y1 - y2;

    return Math.sqrt(dx * dx + dy * dy);
}

function isSameDate(date1,date2) {
    return date1.getFullYear() === date2.getFullYear()
    && date1.getMonth() === date2.getMonth()
    && date1.getDate() === date2.getDate();
}

exports.GetSortingOrder = GetSortingOrder;
exports.Linear = Linear;
exports.TileToWorldXY = TileToWorldXY;
exports.TileIntersects = TileIntersects;
exports.RandomPrize = RandomPrize;
exports.RandomFishPrize = RandomFishPrize;
exports.GetDate = GetDate;
exports.DatetoDt = DatetoDt;
exports.jsonToCSV = jsonToCSV;
exports.RandomCount = RandomCount;
exports.moveTowards = moveTowards;
exports.Between = Between;
exports.RandomPercentagePrize = RandomPercentagePrize;
exports.isSameDate = isSameDate;