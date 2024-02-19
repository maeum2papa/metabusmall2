class MissionManager {
    static instance;
    missions = [];
    fishBooks;
    constructor() { }


    static getInstance() {
        if (!MissionManager.instance) {
            MissionManager.instance = new MissionManager();
        }

        return MissionManager.instance;
    }

    createFishBook(arr, mapfishs) {
        for (let i = 0; i < arr.length; ++i) {
            const dogamDiv = document.createElement('div');
            const dogamTopDiv = document.createElement('div');
            const dogamTopH2 = document.createElement('h2');
            const dogamTopUl = document.createElement('ul');
            const dogamFishLi = document.createElement('li');
            // const dogamBtnDiv = document.createElement('div');
            // const dogamBtn = document.createElement('button');

            dogamDiv.classList.add("fishBook");
            dogamTopDiv.classList.add("fishBookTop");
            dogamTopH2.innerText = arr[i].title;
            dogamTopUl.id = 'fd_fishBook';
            dogamFishLi.classList.add("fd_fish_li");
            // dogamBtnDiv.classList.add("fdBtn");
            // dogamBtn.id = 'fd_Rewards';
            // dogamBtn.alt = '0';
            // dogamBtn.innerText = '보상 획득';
            // dogamBtn.style.backgroundColor = '#D9D9D9';
            
            let ischeck = true;

            for (let j = 0; j < arr[i].detail.length; ++j) {
                const fishConDiv = document.createElement('div');
                const fishConAfter = document.createElement('p');
                const fishConFishN = document.createElement('p');
                const fishConFishNSpan = document.createElement('span');
                const fishConImg = document.createElement('img');

                fishConDiv.classList.add("fishCon");
                fishConAfter.classList.add('after');
                fishConFishN.classList.add("fishN");
                fishConFishNSpan.innerText = arr[i].detail[j].name;
                fishConImg.src = arr[i].detail[j].route;
                fishConImg.alt = `${arr[i].detail[j].id}`;
                fishConImg.style.opacity = mapfishs.has(+fishConImg.alt) ? '1' : '0.2';

                if (+fishConImg.style.opacity !== 1) {
                    ischeck = false;
                }

                fishConFishN.appendChild(fishConFishNSpan);
                fishConDiv.appendChild(fishConAfter);
                fishConDiv.appendChild(fishConFishN);
                fishConDiv.appendChild(fishConImg);


                dogamFishLi.appendChild(fishConDiv);

                // if (ischeck && j === (arr[i].detail.length - 1)) {        // 다 모았다.
                //     dogamBtn.style.backgroundColor = '#FB8C00';
                //     dogamBtn.style.alt = '1';
                // }
            }

            // dogamBtn.addEventListener('click', () => {
            //     if(+dogamBtn.style.alt !== 1) return;
                
            //     setTimeout(() => {
            //         UIManager.getInstance().setElement(coinPopup);
            //         coinPopup.style.display = 'block';
            //     }, 100);
               
            // })

            // dogamBtnDiv.appendChild(dogamBtn);

            dogamTopUl.appendChild(dogamFishLi);

            dogamTopDiv.appendChild(dogamTopH2);
            dogamTopDiv.appendChild(dogamTopUl);

            dogamDiv.appendChild(dogamTopDiv);
           // dogamDiv.appendChild(dogamBtnDiv);

            fishDogam.appendChild(dogamDiv);
        }

        const fd_fishBooks = document.querySelectorAll('#fd_fishBook');
        let startX = 0;
        let scrollLeft = 0;
        let isDown = false;
        for (let i = 0; i < fd_fishBooks.length; ++i) {
            fd_fishBooks[i].addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - fd_fishBooks[i].offsetLeft;
                scrollLeft = fd_fishBooks[i].scrollLeft;
            })

            fd_fishBooks[i].addEventListener('mouseup', (e) => {
                isDown = false;
            })

            fd_fishBooks[i].addEventListener('mouseleave', (e) => {
                isDown = false;
            })

            fd_fishBooks[i].addEventListener('mousemove', (e) => {
                if (!isDown) return;

                e.preventDefault();

                const x = e.pageX - fd_fishBooks[i].offsetLeft;
                const preScrollLeft = (x - startX);
                fd_fishBooks[i].scrollLeft = scrollLeft - preScrollLeft;
            })
        }
    }

    updateFishBook(fishInfo) {      // 나중에 쓸지도 
        const fishImg = fishDogam.querySelector(`.fishBook .fishBookTop ul li .fishCon img[alt="${fishInfo.index}"]`);


        if (fishImg) {
            if (+fishImg.style.opacity === 1) return;

            fishImg.style.opacity = '1';

            let currentElement = fishImg.parentElement;

            while (currentElement && currentElement.tagName !== "LI") {
                currentElement = currentElement.parentElement;
            }

            if (currentElement) {
                const arrImg = currentElement.querySelectorAll(".fishCon img");
   
                let isOpacity = true;
                for (let i = 0; i < arrImg.length; ++i) {

                    if (arrImg[i].style.opacity === '0.2') {
                        isOpacity = false;
                        break;
                    }
                }

                if (isOpacity) {         //도감채움
                    while (currentElement && !currentElement.classList.contains('fishBook')) {
                        currentElement = currentElement.parentNode;
                    }

                    // if (currentElement) {
                    //     const reward = currentElement.querySelector('.fdBtn #fd_Rewards');
                    //     reward.style.backgroundColor = '#FB8C00';
                    //     reward.style.alt = '1';
                    // }
                }
            }
        }
    }
}