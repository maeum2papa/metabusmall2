class StatusCount {
    constructor() { }

    countUpdate(type, count) {
        if(type === 'fruit' || type === 'fruitfishing') {
            fruitCount.innerText = count;
            fruitNum.innerText = count;
        } else if (type === 'seed') {
            seedCount.innerText = count;
        } else if (type === 'fertilizer') {
            fertilizerCount.innerText = count;
            fertilizerBoxCount.innerText = count;
        } else if (type === 'water') {
            waterCount.innerText = count;
            waterBoxCount.innerText = count;
        } else if (type === 'decoy') {
            decoyCount.innerText = count;
        }
    }
}

