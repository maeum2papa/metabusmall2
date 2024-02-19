class Inventory {

    constructor(context, arr) {
        this.boxWrap;
        this.curWearableParts = [];
        this.charImg;
        this.IsSave = false;
        this.basicParts = {};
        this.saveParts = {};

        this.arrAvatar = [];
        this.arrItemDepth = [];
        this.imageData;
        this.boxWrapDrag = false;
        this.isClick = false;
        this.boxWrapWidth = boxWrap.style.width.substring(0, boxWrap.style.width.length - 2);
        this.boxWrapHeight = boxWrap.style.height.substring(0, boxWrap.style.height.length - 2);
        this.create(arr);
    }

    async create(arr) {       //arrAvatar, arrLand             cate_value,cate_kr,      item 현재 내가 보유 중인

        let arrAvatar = arr.arrAvatar;
        this.arrAvatar = arr.arrAvatar;
        let arrLand = arr.arrLand;
        this.arrItemDepth = arr.arrItemDepth;

        for (let i = 0; i < arrAvatar.length; ++i) {
            arrAvatar[i].item.sort((a, b) => {
                return a.item_kr.localeCompare(b.item_kr, 'ko-KR', { sensitivity: 'base' });
            });
        }

        for (let i = 0; i < arrLand.length; ++i) {
            arrLand[i].item.sort((a, b) => {
                return a.item_kr.localeCompare(b.item_kr, 'ko-KR', { sensitivity: 'base' });
            });
        }

        this.invenMove();

        const characterBtn = document.querySelector(".box_btn_wrap button:first-child");
        const landBtn = document.querySelector(".box_btn_wrap button:last-child");
        const characterBox = document.querySelector(".box_bot.character");
        const landBox = document.querySelector(".box_bot.land");
        const cancleBtn = document.querySelector(".cancle_btn");
        const charImg = document.querySelector(".character_img");
        this.charImg = charImg;
        const resetBtn = document.getElementById("reset");
        const backBtn = document.getElementById("back");
        const saveBtn = document.getElementById("save");

        this.boxWrap = document.querySelector("#box .box_wrap");

        // const li = document.querySelectorAll('.selection_box li');

        const chardiv = characterBox.getElementsByClassName('selection_box')[0];
        const charul = chardiv.querySelector('ul');
        const charInfoBox = characterBox.getElementsByClassName('character_info_box')[0];

        const landdiv = landBox.getElementsByClassName('selection_box')[0];
        const landul = landdiv.querySelector('ul');
        const landInfoBox = landBox.getElementsByClassName('character_info_box')[0];


        //카테고리 생성
        let isfirst = false;
        for (let i = 0; i < arrAvatar.length; ++i) {
            if ("body" === arrAvatar[i].cate_value) {
                continue;
            }

            let newli = document.createElement('li');
            newli.id = arrAvatar[i].cate_value;
            newli.textContent = arrAvatar[i].cate_kr;

            if (!isfirst) {
                newli.className = 'selected';
                isfirst = true;
            }

            charul.appendChild(newli);

            let newWrap = document.createElement('div');
            newWrap.className = 'product_wrap';
            newWrap.id = arrAvatar[i].cate_value + 'Wrap';

            charInfoBox.appendChild(newWrap);
        }

        isfirst = false;
        for (let i = 0; i < arrLand.length; ++i) {
            let newli = document.createElement('li');
            newli.id = arrLand[i].cate_value;
            newli.textContent = arrLand[i].cate_kr;

            if (!isfirst) {
                newli.className = 'selected';
                isfirst = true;
            }

            landul.appendChild(newli);

            let newWrap = document.createElement('div');
            newWrap.className = 'product_wrap';
            newWrap.id = arrLand[i].cate_value + 'Wrap';

            landInfoBox.appendChild(newWrap);
        }

        const charli = chardiv.getElementsByTagName("li");
        const landli = landdiv.getElementsByTagName("li");
        // const charInfoBox = characterBox.getElementsByClassName('character_info_box')[0];

        // 초기 설정
        let currentCharli = charli[0];
        let currentLandli = landli[0];

        let categoryCharId = currentCharli.id + "Wrap";
        let currentCharWrap = document.getElementById(categoryCharId);
        currentCharWrap.style.display = "flex";

        let categoryLandId = currentLandli.id + "Wrap";
        let currentLandWrap = document.getElementById(categoryLandId);
        currentLandWrap.style.display = "flex";



        //<!-- <img src="img/default/player.png" alt="reset_img"> -->
        // 초기 설정: 캐릭터 영역은 보이고, 랜드 영역은 숨기기
        characterBox.style.display = "block";
        landBox.style.display = "none";

        //초기 설정: 인벤 창 안보이게
        this.boxWrap.style.display = "none";

        // 캐릭터 버튼 클릭 시
        characterBtn.addEventListener("click", () => {
            // 캐릭터 영역 표시, 랜드 영역 숨기기
            characterBox.style.display = "block";
            landBox.style.display = "none";

            //this.boxWrap.style.width = "940px";

            // 버튼 스타일 변경
            characterBtn.classList.add("selected");
            landBtn.classList.remove("selected");
        });

        // 랜드 버튼 클릭 시
        landBtn.addEventListener("click", () => {
            // 랜드 영역 표시, 캐릭터 영역 숨기기
            characterBox.style.display = "none";
            landBox.style.display = "block";

            //this.boxWrap.style.width = "865px";

            // 버튼 스타일 변경
            characterBtn.classList.remove("selected");
            landBtn.classList.add("selected");
        });

        for (let i = 0; i < charli.length; ++i) {
            charli[i].addEventListener('click', (e) => {

                currentCharli.classList.remove("selected");
                charli[i].classList.add("selected");
                currentCharli = charli[i];

                currentCharWrap.style.display = "none";
                let curCategoryId = currentCharli.id + "Wrap";
                currentCharWrap = document.getElementById(curCategoryId);
                currentCharWrap.style.display = "flex";
            })
        }

        for (let i = 0; i < landli.length; ++i) {
            landli[i].addEventListener('click', (e) => {
                currentLandli.classList.remove("selected");
                landli[i].classList.add("selected");
                currentLandli = landli[i];

                currentLandWrap.style.display = "none";
                let curCategoryId = currentLandli.id + "Wrap";
                currentLandWrap = document.getElementById(curCategoryId);
                currentLandWrap.style.display = "flex";
            })
        }

        cancleBtn.addEventListener('click', (e) => {             // 인벤 닫기
            this.boxWrap.style.display = "none";
        })


        for (let i = 0; i < charli.length; ++i) {               // 캐릭터 인벤토리 설정 (현재 보유중인 아이템) 썸네일
            let curCategoryId = charli[i].id + "Wrap";
            let productWrap = document.getElementById(curCategoryId);


            for (let j = 0; j < arrAvatar.length; ++j) {
                let isCheck = false;
                if (charli[i].id === arrAvatar[j].cate_value) {
                    for (let k = 0; k < arrAvatar[j].item.length; ++k) {
                        if (arrAvatar[j].item[k].item_nm.indexOf("basic") !== -1) {
                            this.basicParts[arrAvatar[j].item[k].item_nm] = arrAvatar[j].item[k];
                        }
                        addNewProductBox(productWrap, arrAvatar[j].item[k].item_kr, arrAvatar[j].cate_value, arrAvatar[j].item[k].item_sno, arrAvatar[j].item[k].item_img_th);
                        isCheck = true;
                    }

                    if (!isCheck) {      // 인벤에 아무것도 없다.
                        let noDataDiv = document.createElement('div');
                        noDataDiv.className = 'nodata';
                        noDataDiv.innerHTML = `
                        <p>인벤토리에 아이템이 없습니다.</p>
                        `;
                        productWrap.appendChild(noDataDiv);
                    }
                }

            }

            //test
            // for (let j = 0; j < 10; ++j) {
            //     addNewProductBox(productWrap,'사무실 용 소파' + `${ i * 10 + j}`,'사무실 용 소파',"img/icon/office_sofa.svg");
            // }
        }

        for (let i = 0; i < landli.length; ++i) {           //랜드 인벤토리 설정 (현재 보유중인 아이템) 썸네일
            let curCategoryId = landli[i].id + "Wrap";
            let productWrap = document.getElementById(curCategoryId);


            for (let j = 0; j < arrLand.length; ++j) {
                let isCheck = false;
                if (landli[i].id === arrLand[j].cate_value) {
                    for (let k = 0; k < arrLand[j].item.length; ++k) {
                        addNewProductBox(productWrap, arrLand[j].item[k].item_kr, arrLand[j].cate_value, arrLand[j].item[k].item_sno, arrLand[j].item[k].item_img_th);
                        isCheck = true;
                    }

                    if (!isCheck) {      // 인벤에 아무것도 없다.
                        let noDataDiv = document.createElement('div');
                        noDataDiv.className = 'nodata';
                        noDataDiv.innerHTML = `
                        <p>인벤토리에 아이템이 없습니다.</p>
                        `;
                        productWrap.appendChild(noDataDiv);
                    }
                }
            }

            // for (let j = 0; j < 10; ++j) {
            //     addNewProductBox(productWrap, '사무실 용 소파' + `${i * 10 + j}`, '사무실 용 소파', "img/icon/office_sofa.svg");
            // }

        }

        for (let i = 0; i < arrAvatar.length; ++i) {                     // preview 세팅
            if ("body" === arrAvatar[i].cate_value) {        // preview 바디
                const playerPreviewImg = document.createElement('img');
                playerPreviewImg.src = arrAvatar[i].item[0].item_img_ch;
                playerPreviewImg.alt = arrAvatar[i].item[0].item_sno;
                playerPreviewImg.id = arrAvatar[i].cate_value;
                playerPreviewImg.style.zIndex = 1;
                charImg.appendChild(playerPreviewImg);

                break;
            }
        }

        resetBtn.addEventListener('click', (e) => {              // 초기화
            let childElements = charImg.children
            for (let i = childElements.length - 1; i >= 0; --i) {
                if ("body" === childElements[i].id || "armspreview" === childElements[i].id) {
                    continue;
                }

                if (childElements[i].id === 'bottomspreview' || childElements[i].id === 'toppreview' || childElements[i].id === "facepreview") {
                    const lastIndex = childElements[i].alt.indexOf('_');
                    let type = childElements[i].alt.substring(0, lastIndex);
                    let parts = this.basicParts[type + '_basic'];
                    let Info = this.arrItemDepth.find((info) => {
                        return info.itemAlt === (type + '_' + parts.item_sno)
                    })
                    childElements[i].src = parts.item_img_ch;
                    childElements[i].alt = Info.itemAlt;
                    childElements[i].style.zIndex = Info.frontDepth;
                    
                    continue;
                } else if (childElements[i].id === 'setpreview') {
                    let bottomType = 'bottoms';

                    let bottomParts = this.basicParts[bottomType + '_basic'];
                    let bottomInfo = this.arrItemDepth.find((info) => {
                        return info.itemAlt === (bottomType + '_' + bottomParts.item_sno)
                    })

                    let newBottomPreview = document.createElement('img');
                    newBottomPreview.src = bottomParts.item_img_ch;
                    newBottomPreview.alt = bottomInfo.itemAlt;
                    newBottomPreview.id = bottomType + 'preview';
                    newBottomPreview.style.zIndex = +bottomInfo.frontDepth;

                    let topType = 'top';

                    let topParts = this.basicParts[topType + '_basic'];
                    let topInfo = this.arrItemDepth.find((info) => {
                        return info.itemAlt === (topType + '_' + topParts.item_sno)
                    })

                    let newTopPreview = document.createElement('img');
                    newTopPreview.src = topParts.item_img_ch;
                    newTopPreview.alt = topInfo.itemAlt;
                    newTopPreview.id = topType + 'preview';
                    newTopPreview.style.zIndex = +topInfo.frontDepth;

                    charImg.appendChild(newBottomPreview);
                    charImg.appendChild(newTopPreview);
                }
               
                    charImg.removeChild(childElements[i]);
                
            }
        })

        backBtn.addEventListener('click', (e) => {                // 원래모습     // json이든 뭐든 가져와야함. 내 생각엔 this로 하나 계속 저장하고 업데이트를 씬이나 플레이어에서 계속 값을 주면 될듯 
            let childElements = charImg.children

            for (let i = childElements.length - 1; i >= 0; --i) {
                if ("body" === childElements[i].id) {
                    continue;
                }

                const startIndex = childElements[i].alt.indexOf('_');
                const childType = childElements[i].alt.substring(0, startIndex);

                let IsOverlabCheck = this.curWearableParts.some((part) => {
                    return part.type === childType && part.type + '_' + part.index !== childElements[i].alt;
                })

                if (!IsOverlabCheck) {
                    charImg.removeChild(childElements[i]);
                }
            }

            for (let i = 0; i < this.curWearableParts.length; ++i) {
                if ("body" === this.curWearableParts[i].type) {
                    continue;
                }

                let findinfo = false;
                for (let j = 0; j < this.arrAvatar.length; ++j) {
                    findinfo = this.arrAvatar[j].item.find((info) => {
                        return parseInt(info.item_sno) === parseInt(this.curWearableParts[i].name);
                    })

                    if (findinfo && findinfo !== undefined) {
                        break;
                    }
                }

                if (!findinfo || findinfo === undefined) { //없으면 서버랑 클라랑 동기화 안됐다
                    continue;
                }

                let depthInfo = false;
                let zIndex = 0;
                depthInfo = this.arrItemDepth.find((info) => {
                    return info.itemAlt === (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name);
                });

                if (depthInfo !== undefined && depthInfo !== false) {
                    zIndex = depthInfo.frontDepth;
                }
                if (+zIndex <= 0) {
                    zIndex = 0;
                }

                let previewElement = document.getElementById(this.curWearableParts[i].type + 'preview');

                if (previewElement) {
                    if (previewElement.alt !== (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name)) {
                        previewElement.src = findinfo.item_img_ch;
                        previewElement.alt = (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name);
                        previewElement.style.zIndex = zIndex;
                    }
                } else {
                    let newPreview = document.createElement('img');
                    newPreview.src = findinfo.item_img_ch;
                    newPreview.alt = (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name);
                    newPreview.id = this.curWearableParts[i].type + 'preview';
                    newPreview.style.zIndex = zIndex;

                    charImg.appendChild(newPreview);
                }
            }

        })

        saveBtn.addEventListener('click', async (e) => {                // 저장         // json으로 저장해야함. 이걸 저장한지 플레이어가 아는 법. (bool값 체크?)
            let childElements = charImg.children;
            let savingParts = {};

            for (let i = 0; i < childElements.length; ++i) {
                let startindex = childElements[i].src.lastIndexOf('/') + 1;
                let lastindex = childElements[i].src.lastIndexOf('.');
                if ("body" === childElements[i].id) {
                    let info = {
                        name: childElements[i].src.substring(startindex, lastindex),
                        index: parseInt(childElements[i].alt),
                        frontDepth: 1,
                        backDepth: 1
                    };
                    savingParts[childElements[i].id] = info;
                } else {
                    const startIndex = childElements[i].alt.indexOf('_');
                    const childType = childElements[i].alt.substring(0, startIndex);

                    let depthInfo = false;

                    depthInfo = this.arrItemDepth.find((info) => {
                        return info.itemAlt === childElements[i].alt;
                    });

                    if (depthInfo !== undefined && depthInfo !== false) {
                        let stIndex = childElements[i].alt.lastIndexOf('_') + 1;
                        let info = {
                            name: childElements[i].src.substring(startindex, lastindex),
                            index: parseInt(childElements[i].alt.substring(stIndex, childElements[i].alt.length)),
                            frontDepth: depthInfo.frontDepth,
                            backDepth: depthInfo.backDepth
                        };

                        savingParts[childType] = info;
                    }
                }
            }

            let imgAll = document.querySelectorAll(".character_img img");

            let saveImg = document.createElement("div");
            saveImg.classList.add("charsaveimg");

            for (let i = 0; i < imgAll.length; ++i) {
                const img = document.createElement("img");
                img.src = imgAll[i].currentSrc;

                img.style.zIndex = imgAll[i].style.zIndex <= 0 ? 0 : imgAll[i].style.zIndex;

                saveImg.appendChild(img);
            }

            document.querySelector("#gamecontainer").appendChild(saveImg);

            html2canvas(saveImg, { scale: 1 }).then(async (canvas) => {
                this.imageData = await canvas.toDataURL('image/png', 1);
                this.IsSave = true;
                saveImg.remove();               
            })

            this.saveParts = savingParts;

            saveCharPopup.style.display = "block";
            saveCharPopup.style.opacity = "1";
            setTimeout(() => {
                saveCharPopup.style.opacity = "0";
                saveCharPopup.style.transition = "opacity .3s";

                setTimeout(() => {
                    saveCharPopup.style.display = "none";
                }, 300);
            }, 2000);
        })

        // 항상 마지막에 product_box를 얻어와야 생성된 모든 product_box를 가져올 수 있음 이거 캐릭터의 product와 랜드의 product 각각 받아야 할지도 모르겠다.
        //let BoxArr = document.querySelectorAll('.product_box');

        let charBoxArr = charInfoBox.querySelectorAll('.product_box');
        let landBoxArr = landInfoBox.querySelectorAll('.product_box');

        charBoxArr.forEach((item) => {                        //캐릭터 인벤토리 리스트
            item.addEventListener('click', () => {
                const name = item.querySelector('.product_name p');
                const img = item.querySelector('.product_img img');
                // console.log(name);
                // console.log(img.src);
                // console.log(img.alt);
                const lastIndex = img.alt.indexOf('_');
                const imgType = img.alt.substring(0, lastIndex);
                const startIndex = img.alt.lastIndexOf('_') + 1;
                const imgIndex = img.alt.substring(startIndex, img.alt.length);

                let previewElement = document.getElementById(imgType + 'preview');

                let info = false;
                for (let i = 0; i < arrAvatar.length; ++i) {
                    info = arrAvatar[i].item.find((info) => {
                        return parseInt(info.item_sno) === parseInt(imgIndex);
                    });

                    if (info && info !== undefined) {
                        break;
                    }
                }

                if (!info || info === undefined) {
                    return;
                }

                let depthInfo = false;
                let zIndex = 0;
                depthInfo = this.arrItemDepth.find((info) => {
                    return info.itemAlt === img.alt
                })

                if (depthInfo !== undefined && depthInfo !== false) {
                    zIndex = depthInfo.frontDepth;
                }
                if (+zIndex <= 0) {
                    zIndex = 0;
                }

                if (previewElement) {           //같은 타입의 preview가 있다면
                    if (previewElement.alt === img.alt) {       // 똑같은 아이템 착용 해제
                        if (imgType === 'bottoms' || imgType === 'top' || imgType === "face" || imgType === "arms") {
                            let type = imgType + '_basic';
                            let parts = this.basicParts[type];
                            previewElement.src = parts.item_img_ch;
                            previewElement.alt = imgType + '_' + parts.item_sno;
                            previewElement.style.zIndex = zIndex;
                        } else if (imgType === 'set') {
                            let bottomType = 'bottoms';

                            let bottomParts = this.basicParts[bottomType + '_basic'];
                            let bottomInfo = this.arrItemDepth.find((info) => {
                                return info.itemAlt === (bottomType + '_' + bottomParts.item_sno)
                            })

                            let newBottomPreview = document.createElement('img');
                            newBottomPreview.src = bottomParts.item_img_ch;
                            newBottomPreview.alt = bottomInfo.itemAlt;
                            newBottomPreview.id = bottomType + 'preview';
                            newBottomPreview.style.zIndex = +bottomInfo.frontDepth;

                            let topType = 'top';

                            let topParts = this.basicParts[topType + '_basic'];
                            let topInfo = this.arrItemDepth.find((info) => {
                                return info.itemAlt === (topType + '_' + topParts.item_sno)
                            })

                            let newTopPreview = document.createElement('img');
                            newTopPreview.src = topParts.item_img_ch;
                            newTopPreview.alt = topInfo.itemAlt;
                            newTopPreview.id = topType + 'preview';
                            newTopPreview.style.zIndex = +topInfo.frontDepth;

                            charImg.appendChild(newBottomPreview);
                            charImg.appendChild(newTopPreview);
                            charImg.removeChild(previewElement);
                        } else {
                            charImg.removeChild(previewElement);
                        }

                    } else {                   // 타입은 같지만 같은 아이템은 아니므로 경로와 alt이름만 변경
                        previewElement.src = info.item_img_ch;
                        previewElement.alt = img.alt;
                        previewElement.style.zIndex = zIndex;
                    }
                } else {                        // 해당 타입을 아예 착용하지 않았다.                    
                    if (imgType === 'bottoms' || imgType === 'top') {     // 상의 나 하의를 새로 입는데 한벌옷이 있는 경우 벗는다.
                        let previewElement = document.getElementById('set' + 'preview');
                        if (previewElement) {        //한벌옷이 있다.
                            charImg.removeChild(previewElement);
                        }
                        
                        if(imgType === 'bottoms') {
                            let topType = 'top';

                            let topParts = this.basicParts[topType + '_basic'];
                            let topInfo = this.arrItemDepth.find((info) => {
                                return info.itemAlt === (topType + '_' + topParts.item_sno)
                            })

                            let newTopPreview = document.createElement('img');
                            newTopPreview.src = topParts.item_img_ch;
                            newTopPreview.alt = topInfo.itemAlt;
                            newTopPreview.id = topType + 'preview';
                            newTopPreview.style.zIndex = +topInfo.frontDepth;

                            charImg.appendChild(newTopPreview);
                        } else {
                            let bottomType = 'bottoms';

                            let bottomParts = this.basicParts[bottomType + '_basic'];
                            let bottomInfo = this.arrItemDepth.find((info) => {
                                return info.itemAlt === (bottomType + '_' + bottomParts.item_sno)
                            })

                            let newBottomPreview = document.createElement('img');
                            newBottomPreview.src = bottomParts.item_img_ch;
                            newBottomPreview.alt = bottomInfo.itemAlt;
                            newBottomPreview.id = bottomType + 'preview';
                            newBottomPreview.style.zIndex = +bottomInfo.frontDepth;

                            charImg.appendChild(newBottomPreview);
                        }
                    } else if (imgType === 'set') {                       // 한벌옷을 입는데 상의나 하의가 있다.
                        let previewElement = document.getElementById('bottoms' + 'preview');
                        if (previewElement) {        ////하의가 있다.
                            charImg.removeChild(previewElement);
                        }

                        previewElement = document.getElementById('top' + 'preview');
                        if (previewElement) {        ////상의가 있다.
                            charImg.removeChild(previewElement);
                        }
                    } 
                        let newPreview = document.createElement('img');
                        newPreview.src = info.item_img_ch;
                        newPreview.alt = img.alt;
                        newPreview.id = imgType + 'preview';
    
                        newPreview.style.zIndex = +zIndex;
    
                        charImg.appendChild(newPreview);
                    
                }
            })
        })

        landBoxArr.forEach((item) => {
            item.addEventListener('click', () => {
                if (saveLandPopup.style.display === "block" || user_Info.room !== "myland_inner") {
                    return;
                }

                const img = item.querySelector('.product_img img');

                const lastIndex = img.alt.indexOf('_');
                const imgType = img.alt.substring(0, lastIndex);
                const startIndex = img.alt.lastIndexOf('_') + 1;
                const imgIndex = img.alt.substring(startIndex, img.alt.length);
                let info = {
                    type: imgType,
                    index: imgIndex
                };

                SendManager.getInstance().send('changeFurniture', info);

                setTimeout(() => {
                    saveLandPopup.style.display = "block";
                    UIManager.getInstance().setElement(saveLandPopup);
                }, 50);
               
            })
        })



        function addNewProductBox(wrap, name, type, index, route) {								// 요소 추가.
            let newProductBox = document.createElement('div');
            newProductBox.className = 'product_box';
            newProductBox.innerHTML = `
            <div class="box_border">
                <div class="product_img">
                    <img src="${route}" alt="${type + '_' + index}" width="96" height="96">
                </div>
                <div class="product_name">
                    <p>${name}</p>
                </div>
            </div>
            `;

            wrap.appendChild(newProductBox);
        }
    }

    invenShown() {
        if (this.boxWrap.style.display === "none") {
            const charImg = this.charImg;

            let childElements = charImg.children;
            for (let i = childElements.length - 1; i >= 0; --i) {
                if ("body" === childElements[i].id) {
                    continue;
                }
                const startIndex = childElements[i].alt.indexOf('_');
                const childType = childElements[i].alt.substring(0, startIndex);

                let IsOverlabCheck = this.curWearableParts.some((part) => {
                    return part.type === childType && part.type + '_' + part.index !== childElements[i].alt;
                })

                if (!IsOverlabCheck) {
                    charImg.removeChild(childElements[i]);
                }
            }
            for (let i = 0; i < this.curWearableParts.length; ++i) {
                if ("body" === this.curWearableParts[i].type) {
                    continue;
                }

                let findinfo = false;
                for (let j = 0; j < this.arrAvatar.length; ++j) {
                    findinfo = this.arrAvatar[j].item.find((info) => {
                        return parseInt(info.item_sno) === parseInt(this.curWearableParts[i].name);
                    })

                    if (findinfo && findinfo !== undefined) {
                        break;
                    }
                }

                if (!findinfo || findinfo === undefined) { //없으면 서버랑 클라랑 동기화 안됐다
                    continue;
                }

                let depthInfo = false;
                let zIndex = 0;
                depthInfo = this.arrItemDepth.find((info) => {
                    return info.itemAlt === (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name);
                });

                if (depthInfo !== undefined && depthInfo !== false) {
                    zIndex = depthInfo.frontDepth;
                }
                if (+zIndex <= 0) {
                    zIndex = 0;
                }
                let previewElement = document.getElementById(this.curWearableParts[i].type + 'preview');

                if (previewElement) {
                    if (previewElement.alt !== (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name)) {
                        previewElement.src = findinfo.item_img_ch;
                        previewElement.alt = (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name);
                        previewElement.style.zIndex = zIndex;
                    }
                } else {
                    let newPreview = document.createElement('img');
                    newPreview.src = findinfo.item_img_ch;
                    newPreview.alt = (this.curWearableParts[i].type + '_' + this.curWearableParts[i].name);
                    newPreview.id = this.curWearableParts[i].type + 'preview';

                    newPreview.style.zIndex = zIndex;
                    charImg.appendChild(newPreview);
                }
            }

            this.boxWrap.style.display = 'block';
            UIManager.getInstance().setElement(this.boxWrap);
        } else {
            this.boxWrap.style.display = "none";
            UIManager.getInstance().removeElement(this.boxWrap);

        }
    }

    invenMove() {
        boxWrap.addEventListener('mousedown', (e) => {
            UIManager.getInstance().setElement(boxWrap);

            if (!this.isClick) return;

            this.boxWrapDrag = true;
            this.originX = e.clientX;
            this.originY = e.clientY;
            this.originLeft = this.boxWrap.offsetLeft;
            this.originTop = this.boxWrap.offsetTop;
        });

        boxChar.addEventListener("mouseover", (e) => {
            if (e.target === boxChar) {
                this.isClick = true;
            }
        });

        boxChar.addEventListener("mouseout", (e) => {
            if (e.target === boxChar) {
                if (this.boxWrapDrag) return;

                this.isClick = false;
            }
        });

        document.addEventListener('mouseup', (e) => {
            this.boxWrapDrag = false;
        });

        document.addEventListener('mousemove', (e) => {
            if (this.boxWrapDrag) {
                const diffX = e.clientX - this.originX;
                const diffY = e.clientY - this.originY;

                const OutXPos = window.innerWidth - (+this.boxWrapWidth / 2);
                const OutYPos = window.innerHeight - (+this.boxWrapHeight / 2);

                this.boxWrap.style.left = `${Math.min(Math.max(+this.boxWrapWidth / 2, this.originLeft + diffX), OutXPos)}px`;
                this.boxWrap.style.top = `${Math.min(Math.max((+this.boxWrapHeight / 2), this.originTop + diffY), OutYPos)}px`;
            }
        });

        boxLand.addEventListener("mouseover", (e) => {
            if (e.target === boxLand) {
                this.isClick = true;
            }
        });

        boxLand.addEventListener("mouseout", (e) => {
            if (e.target === boxLand) {
                if (this.boxWrapDrag) return;

                this.isClick = false;
            }
        });

    }
}