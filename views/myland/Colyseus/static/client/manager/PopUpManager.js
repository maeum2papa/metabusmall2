class PopUpManager {
    static instance;
    fishData = {};
    constructor() { }

    static getInstance() {
        if (!PopUpManager.instance) {
            PopUpManager.instance = new PopUpManager();
        }

        return PopUpManager.instance;
    }

    setFishData(data) {
        this.fishData = data;
    }

    makeFishPopUp(data) {
        const fishingDiv = document.createElement("div");
        if (data.type === 'getFish') {       //생선 획득
            fishingDiv.id = 'fishing_popup_etc';
            const fishDiv = document.createElement("div");
            const fishP = document.createElement("p");
            const fishImg = document.createElement("img");
            const fishH1 = document.createElement("h1");
            const fishP2 = document.createElement("p");

            fishDiv.classList.add("fishing_fish");

            fishP.innerText = '물고기 획득';

            fishImg.src = this.fishData[data.index].route;
            fishImg.alt = this.fishData[data.index].name;

            fishH1.innerHTML = `
            <span id="fishName">${this.fishData[data.index].name}</span>
            를(을) 발견했습니다.`;

            fishP2.innerText = '물고기 도감을 확인해주세요!';

            fishDiv.appendChild(fishP);
            fishDiv.appendChild(fishImg);
            fishDiv.appendChild(fishH1);
            fishDiv.appendChild(fishP2);

            fishingDiv.appendChild(fishDiv);
        } else if (data.type === 'getTrash') {     //쓰레기 획득
            fishingDiv.id = 'fishing_popup_etc2';
            const trashDiv = document.createElement("div");
            const trashImg = document.createElement("img");
            const trashH1 = document.createElement("h1");
            const trashP = document.createElement("p");

            trashDiv.classList.add("fishing_trash");

            trashImg.src = data.route;
            trashImg.alt = '쓰레기';

            trashH1.innerText = '쓰레기 획득';

            trashP.innerHTML = `
            <em>쓰레기</em>를 발견했습니다.`;

            trashDiv.appendChild(trashH1);
            trashDiv.appendChild(trashImg);
            trashDiv.appendChild(trashP);

            fishingDiv.appendChild(trashDiv);

        } else if (data.type === 'getFruitFishing') {    //코인 획득
            fishingDiv.id = 'fishing_popup_etc3';
            const fruitDiv = document.createElement("div");
            const fruitP = document.createElement("p");
            const fruitImg = document.createElement("img");
            const fruitH1 = document.createElement("h1");

            fruitDiv.classList.add("fishing_coin");

            fruitP.innerText = '열매 획득';
            fruitImg.src = '/seum_img/ui/fruiticon.png';
            fruitImg.alt = '열매';

            fruitH1.innerHTML = `
            <em>열매</em><span>${1}</span><em>개</em>를 획득했습니다.
            `;

            fruitDiv.appendChild(fruitP);
            fruitDiv.appendChild(fruitImg);
            fruitDiv.appendChild(fruitH1);

            fishingDiv.appendChild(fruitDiv);

        } else if (data.type === 'getBottle') {     //유리병 획득
            fishingDiv.id = 'fishing_popup';
            const bottleBoxDiv = document.createElement("div");
            const bottleTitleDiv = document.createElement("div");
            const bottleglassDiv = document.createElement("div");
            const bottleglassImg = document.createElement("img");
            const bottleglassH1 = document.createElement("h1");
            const bottleglassP = document.createElement("p");
            const bottleglassP2 = document.createElement("p");
            const bottleglassEm2 = document.createElement("em");
            const bottleTextDiv = document.createElement("div");
            const bottleTextH2 = document.createElement("h2");
            const bottleTextP = document.createElement("p");

            bottleBoxDiv.classList.add("fishing_popup_box");
            bottleTitleDiv.classList.add("fishing_popup_title");
            bottleglassDiv.classList.add("fishing_glass");
            bottleTextDiv.classList.add("fishing_popup_text");

            bottleglassImg.src = '/seum_img/ui/glass.png';
            bottleglassH1.innerText = '유리병 획득';

            bottleglassP.innerHTML = `
            <em>유리병</em>에서 편지를 발견했습니다.`;

            bottleglassEm2.innerText = 'TIP모음집을 확인해주세요!';
            bottleglassP2.appendChild(bottleglassEm2);

            bottleglassDiv.appendChild(bottleglassH1);
            bottleglassDiv.appendChild(bottleglassImg);
            bottleglassDiv.appendChild(bottleglassP);
            bottleglassDiv.appendChild(bottleglassP2);

            bottleTitleDiv.appendChild(bottleglassDiv);

            bottleTextH2.innerText = '직장인 생활 TIP.';
            bottleTextP.innerText = data.text;
            // `\u{1F603} 컴퓨터 바탕화면의 업무 폴더를 카테고리별이나 우선순위 중심으로 정리하면 효율성이 올라갑니다.`;            

            bottleTextDiv.appendChild(bottleTextH2);
            bottleTextDiv.appendChild(bottleTextP);

            bottleBoxDiv.appendChild(bottleTitleDiv);
            bottleBoxDiv.appendChild(bottleTextDiv);

            fishingDiv.appendChild(bottleBoxDiv);

            this.makeUpdateTipPopup(data.text);
        }

        UIManager.getInstance().setElement(fishingDiv);
        fishingDiv.style.transition = 'opacity 2.0s ease';
        fishingDiv.style.opacity = 1;

        fishingDiv.addEventListener('transitionend', () => {
            if (fishingDiv.style.opacity === '0') {
                UIManager.getInstance().removeElement(fishingDiv);
                fishingDiv.remove();
            }
        });

        setTimeout(() => {
            fishingDiv.style.opacity = 0;
        }, 2000);

        Box.appendChild(fishingDiv);
    }


    makeTipPopup(arr) {
        for (let i = 0; i < arr.length; ++i) {
            const p = document.createElement("p");
            p.classList.add("tdcon");
            p.innerText = arr[i].content;

            tbConDiv.appendChild(p);

            p.addEventListener('click', () => {
                if (tipDogamPopup.style.display === "block") return;

                const msCon = tipDogamPopup.querySelector(".ms_con");
                msCon.innerText = p.innerText;

                setTimeout(() => {
                    UIManager.getInstance().setElement(tipDogamPopup);
                    tipDogamPopup.style.display = 'block';
                }, 100);
            })
        }
    }

    makeUpdateTipPopup(content) {
        const tbConP = tbConDiv.querySelectorAll("p");
        for(let i = 0; i < tbConP.length; ++i) {
            if(tbConP[i].innerText === content) return;
        }


        const p = document.createElement("p");
        p.classList.add("tdcon");
        p.innerText = content;

        tbConDiv.appendChild(p);

        p.addEventListener('click', () => {
            if (tipDogamPopup.style.display === "block") return;

            const msCon = tipDogamPopup.querySelector(".ms_con");
            msCon.innerText = p.innerText;

            setTimeout(() => {
                UIManager.getInstance().setElement(tipDogamPopup);
                tipDogamPopup.style.display = 'block';
            }, 100);
        })
    }


    makeTestPopup(text) {
        const textDiv = document.createElement("div");
        textDiv.classList.add("testPopup");
        textDiv.innerText = `${text}`;
        document.querySelector("#gamecontainer").appendChild(textDiv);
        textDiv.style.display = "block";
        textDiv.style.opacity = "1";
        textDiv.style.zIndex = 100;
        setTimeout(() => {
            textDiv.style.opacity = "0";
            textDiv.style.transition = "opacity .3s";

            setTimeout(() => {
                textDiv.style.display = "none";
                textDiv.parentNode.removeChild(textDiv);
            }, 300);
        }, 4000);
    }
}