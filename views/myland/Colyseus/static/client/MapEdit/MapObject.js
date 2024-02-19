class MapObject {
    constructor(context, name, info, count, question,callback) {
        this.sprites = null;
        this.IsColl = false;            // 충돌할건지
        this.IsWall = false;            // 벽으로 할건지.
        this.depth = 0;

        this.sprites = context.physics.add.image(info.x, info.y, name);
        this.sprites.setOrigin(0.5, 0.5);
        this.sprites.depth = info.depth;

        this.sprites.coll = false;
        this.sprites.outline = false;
        this.sprites.name = name;
        this.sprites.type = name;
        this.sprites.outColl = true;
        this.sprites.isOverlap = info.isOverlap;


        this.sprites.ftOption = this.option;
        this.sprites.outlineAdd = this.outlineAdd;
        this.sprites.outlineRemove = this.outlineRemove;
        this.sprites.collAdd = this.collAdd;

        this.buttons = [];
        this.answerDivArr = [];
        this.popUpDiv = null;
        this.headerDiv = null;
        this.mainDiv = null;
        this.answer = +question.answer;
        this.count = 1;
        this.isShow = false;

        this.makeQuestion(count, question);
        this.makeAnswer(count, question,callback);

        this.gamePopup();
    }

    init = (frontEndEventObj) => {
        if (this.sprites.isOverlap) {
            frontEndEventObj.push(this.sprites);
        }
    }

    option = () => {
        this.popUpDiv.style.display = "block";

        return true;
    }

    outlineAdd = (outlineInstance) => {
        outlineInstance.add(this.sprites, {
            thickness: 3,
            outlineColor: Utils.OUTCOLOR
        });

        this.sprites.outline = true;
    }

    outlineRemove = (outlineInstance) => {
        outlineInstance.remove(this.sprites);
        this.sprites.outline = false;
    }

    collAdd = () => {
        this.sprites.coll = true;
    }

    makeQuestion(count, question) {

        this.popUpDiv = document.createElement('div');
        this.popUpDiv.classList.add("game_test_popup");
        this.popUpDiv.style.display = "none";

        this.headerDiv = document.createElement('div');
        this.headerDiv.classList.add("game_popup_header");
        this.headerDiv.innerHTML = `
        <strong>${'[문제'} <span id="${'game_test_num' + count}">${count}</span>${']'}</strong>`

        this.mainDiv = document.createElement('div');
        this.mainDiv.classList.add("game_popup_main");

        const contDiv = document.createElement('div');
        contDiv.classList.add("game_popup_main_cont");
        contDiv.innerHTML = `
        <p id="${'game_test_title' + count}">${question.question}</p>`;

        this.mainDiv.appendChild(contDiv);

        const wrapDiv = document.createElement('div');
        wrapDiv.classList.add("game_test_answer_wrap");

        for (let i = 0; i < question.ex.length; ++i) {
            const boxDiv = document.createElement('div');
            boxDiv.classList.add("game_test_answer_box");
            const button = document.createElement('button');
            button.classList.add("game_test_answer_btn");
            button.innerText = `[${i + 1}] ${question.ex[i]}`;

            boxDiv.appendChild(button);
            wrapDiv.appendChild(boxDiv);
            this.buttons.push(button);
        }

        this.mainDiv.appendChild(wrapDiv);
        this.popUpDiv.appendChild(this.headerDiv);
        this.popUpDiv.appendChild(this.mainDiv);

        gameBtnPopUp.querySelector(".game_popup").appendChild(this.popUpDiv);

        
    }

    gamePopup() {
        for (let i = 0; i < this.buttons.length; ++i) {
            this.buttons[i].addEventListener('click', (e) => {
                if(!this.isShow) {
                this.answerDivArr[i].style.display = "flex";
                this.isShow = true;    
            }
            })
        }
    }

    makeAnswer(count, question,callback) {

        for (let i = 0; i < question.chk_txt.length; ++i) {
            const answerDiv = document.createElement('div');
            answerDiv.classList.add("game_answer_popup");
            answerDiv.style.display ="none";

            if ((i + 1) !== this.answer) {           // 정답이 아니다.              
                answerDiv.id = "game_incorrect_answer_popup";

                const incorrectDiv = document.createElement('div');
                incorrectDiv.className = 'game_answer_popup_box incorrect_answer';


                const answerPopUpImgDiv = document.createElement('div');
                answerPopUpImgDiv.classList.add("game_answer_popup_img");

                const popupBottonDiv = document.createElement('div');
                popupBottonDiv.classList.add("game_answer_popup_bottom");
                popupBottonDiv.innerHTML = `
                <p>${question.chk_txt[i]}</p>`;

                const bgDiv = document.createElement('div');
                bgDiv.classList.add("incorrect_answer_bg");

                const btnDiv = document.createElement('div');
                btnDiv.classList.add('answer_btn');

                const incorrentButton = document.createElement('button');
                incorrentButton.id = 'game_incorrect_answer_btn'
                incorrentButton.innerText = "확인";

                btnDiv.appendChild(incorrentButton);

                incorrentButton.addEventListener('click', () => {
                    answerDiv.style.display = 'none';
                    this.isShow = false;
                })

                incorrectDiv.appendChild(answerPopUpImgDiv);
                incorrectDiv.appendChild(popupBottonDiv);
                incorrectDiv.appendChild(bgDiv);
                incorrectDiv.appendChild(btnDiv);

                answerDiv.appendChild(incorrectDiv);

            } else if ((i + 1) === this.answer) {     //정답
                answerDiv.id = "game_correct_answer_popup";

                const correctDiv = document.createElement('div');
                correctDiv.className = "game_answer_popup_box correct_answer";              

                const answerPopUpImgDiv = document.createElement('div');
                answerPopUpImgDiv.classList.add("game_answer_popup_img");

                const popupBottonDiv = document.createElement('div');
                popupBottonDiv.classList.add("game_answer_popup_bottom");
                popupBottonDiv.innerHTML = `
                <p>${question.chk_txt[i]}</p>`;

                correctDiv.appendChild(answerPopUpImgDiv);
                correctDiv.appendChild(popupBottonDiv);

                const buttonDiv = document.createElement('div');
                buttonDiv.classList.add("answer_btn");
               
                const answerButton = document.createElement('button');
                answerButton.id = "correct_answer_btn";
                answerButton.innerText = "확인";

                buttonDiv.appendChild(answerButton);

                answerButton.addEventListener('click', () => {              //성공 했고 닫기 버튼을 누른다.
                    answerDiv.style.display = 'none';
                    this.popUpDiv.style.display = 'none';
                    this.isShow = false;
                    var add = this.count;
                    callback(add);
                    this.count = 0;
                })

                answerDiv.appendChild(correctDiv);
                answerDiv.appendChild(buttonDiv);
            }

            Box.appendChild(answerDiv);

            this.answerDivArr.push(answerDiv);
        }
    }
}



