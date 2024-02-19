class Utils {
    static OUTCOLOR = 0xff8a50;

    constructor() { }
    static GetSortingOrder(backY, frontY, objposY) {
        let objDist = Math.abs(backY - objposY);
        let totalDist = Math.abs(backY - frontY);

        return objDist / totalDist;
    }

    static Linear(p0, p1, t) {
        return (p1 - p0) * t + p0;
    }

    static GetZeroCheck(date) {
        return String(date).padStart(2, '0');
    }

    static isDown(dx, dy) {
        if (dy >= 0) {
            return false;
        }
        if (Math.abs(dx) > 2 * Math.abs(dy)) {
            return false;
        }
        return true;
    }

    static isUp(dx, dy) {
        if (dy <= 0) {
            return false;
        }
        if (Math.abs(dx) > 2 * Math.abs(dy)) {
            return false;
        }
        return true;
    }

    static isRight(dx, dy) {
        if (dx >= 0) {
            return false;
        }
        if (Math.abs(dy) > 2 * Math.abs(dx)) {
            return false;
        }
        return true;
    }
    static isLeft(dx, dy) {
        if (dx <= 0) {
            return false;
        }
        if (Math.abs(dy) > 2 * Math.abs(dx)) {
            return false;
        }
        return true;
    }

    static RandomCount(count) {
        const ranNum = Math.floor(Math.random() * count); 
        return ranNum;
    }


    static moveTowards(cur, target, maxDistanceDelta) {
        let a = target.clone().subtract(cur);
        let magnitude = a.length();

        if (magnitude <= maxDistanceDelta || magnitude === 0) {
            return target;
        }
        let returnPos = new Phaser.Math.Vector2();

        returnPos.x = cur.x + a.x / magnitude * maxDistanceDelta;
        returnPos.y = cur.y + a.y / magnitude * maxDistanceDelta;

        return returnPos;
    }
}

