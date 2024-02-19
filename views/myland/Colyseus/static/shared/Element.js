const loading = document.getElementById('loading');
const Box = document.getElementById('box');
//const tboxContainer = document.getElementById("tbox")

const chatInput = document.getElementById("chatinput");
chatInput.style.outline = "none"

const chatBox = document.querySelector('.myland_chatbox');
const chattBox = document.querySelector("#tbox_chat");
const privatetBox = document.querySelector("#tbox_private");
const activityBox = document.querySelector("#tbox_activity");
const tbox = document.querySelector("#tbox");

const chatBtn = document.querySelectorAll(".chatTabs button")[0];
const privateBtn = document.querySelectorAll(".chatTabs button")[1];
const activityBtn = document.querySelectorAll(".chatTabs button")[2];

const sizeBtn = document.querySelector(".chatScale");
const sizeBtnChild = document.querySelectorAll(".chatScale button");

const chatOpenBtn = document.querySelector("#chatbox_open_btn");
const closeBtn = document.querySelector("#chatbox_close_btn");
const chatBoxWrap = document.querySelector(".chatWrap");

const statusPopup = document.querySelector(".statusBox");
const statusPopupClose = document.querySelector("#status_popup_close");

const saveLandPopup = document.querySelector("#save_land_popup");
const saveLandPopupBtn = document.querySelector("#save_land_popup_close");
const saveCharPopup = document.querySelector("#save_char_popup");

const username = document.querySelector("#username");
const profileCard = document.querySelector("#profile_card");
const profileCardBtn = document.querySelector("#profile_card_close");

const fruitCount = document.querySelector("#fruit_count");
const seedCount = document.querySelector("#seed_count");
const fertilizerCount = document.querySelector("#fertilizer_count");
const waterCount = document.querySelector("#water_count");
const decoyCount = document.querySelector("#earthworm_count");

const fruitSeedAllCount = document.querySelector(".status_total_box span");

const landRtcWrap = document.querySelector("#land_rtc_wrap");
const landRtcPopup = document.querySelector("#land_rtc_popup");

const boxWrap = document.querySelector("#box .box_wrap");

const boxChar = document.querySelector(".box_bot.character");
const boxLand = document.querySelector(".box_bot.land");

const gameStartPopup = document.querySelector("#game_start_popup");
const gameTopBox = document.querySelector("#game_top_fixed_box");

const gameStartBtn = document.querySelector("#game_start_btn");

const gameWaitpopup = document.querySelector("#game_wait_popup");
const gameWaitNumber = document.querySelector("#game_wait_num");

const gameOverBox = document.querySelector("#game_over_box");
const gameRestartBtn = document.querySelector("#game_restart_btn");
const gameQuitbtn = document.querySelector("#game_quit_btn");

const gameIngBox = document.querySelector("#game_ing_box");
const gameIngBtn = document.querySelector("#game_ing_btn");

const gameBtnPopUp = document.querySelector("#game_test_btn_popup");

const gameCompleteBox = document.querySelector("#game_complete_box");
const gameCompleteBtn = document.querySelector("#game_complete_btn");

const gamecorrectPopUp = document.querySelector("#game_correct_answer_popup");
const gameIncorrectPopUp = document.querySelector("#game_incorrect_answer_popup");

const waterFBoxBg = document.querySelector(".waterF_box_bg");
const waterFPopup_Close = document.querySelector("#waterF_popup_close");

const waterBox = document.querySelector(".waterBox");
const waterButton = document.querySelector(".waterBox .useBox");

const fertilizerBox = document.querySelector(".fertilizerBox");
const fertilizerButton = document.querySelector(".fertilizerBox .useBox");

const waterBoxCount = document.querySelector("#waterBox_count");
const fertilizerBoxCount = document.querySelector("#fertilizerBox_count");



// 전체 채팅, 활동 내역 버튼 눌렀을 때

const moChatInput = document.querySelector("#mo_chatinput");
moChatInput.style.outline = "none"

const moTbox = document.querySelector("#mo_tbox");
const mo_tbox_chat = document.querySelector("#mo_tbox_chat");
const mo_tbox_activity = document.querySelector("#mo_tbox_activity");


const mo_chatBtn = document.querySelector("#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button:first-child");
const mo_activityBtn = document.querySelector("#land_bot_box_wrap .land_bot_chat_box_wrap .land_chat_box_top .chatbox_button_wrap button:last-child");

const land_top_box_wrap = document.querySelector("#land_top_box_wrap");
const land_bot_box_wrap = document.querySelector("#land_bot_box_wrap");

const land_bot_btn_box = document.querySelector(".land_bot_btn_box");
const land_bot_chat_box_wrap = document.querySelector(".land_bot_chat_box_wrap");

const mo_sidebar = document.querySelector("#mo_sidebar");
const mo_sidebar_v = document.querySelector("#mo_sidebar_v");

const mo_chat_btn = document.querySelector("#mo_chat_btn");
const mo_chat_btn_close = document.querySelector("#mo_chat_btn_close");

const mo_chat_close = document.querySelector("#mo_chat_close");

const mo_chat_submit_btn = document.querySelector("#mo_chat_submit_btn");

const mo_fruit_btns = document.querySelectorAll(".mo_fruit_btn");
const mo_inven_btns = document.querySelectorAll(".mo_inven_btn");

const fishDogamBg = document.querySelector(".fishDogam_bg");

const fishDogamBgClose_btn = document.querySelector("#fishDogam_popup_close");
const fishDogam = document.querySelector(".fishDogam_bg .fishDogam");

const coinCloseBtn = document.querySelector(".fdCoin .fdCoin_popup .fdCoin_close");
const coinPopup = document.querySelector(".fdCoin");

const fKeyUI = document.querySelector('.fkey_massge');
const fKeyP = document.querySelector('.fkey_massge p');

const tipDogam = document.querySelector('.tipDogam_bg');
const tipDogamClose = document.querySelector('#tdClose');
//const tipDogamCon = document.querySelectorAll('.tdcon');
const tbConDiv = document.querySelector(".tdconDiv");
const tipDogamPopup = document.querySelector('.ms_bg');
const tipDogamPopupClose = document.querySelector('#ms_close');

const profileImg = document.querySelector('.mylandTop_wrap .mlt_left .mltProfile .mltP_img img');

const fruitNum = document.querySelector('.mylandTop_wrap .mlt_left .mltFP_status .mlFruits_status .mltF-number');
const statusUI = document.querySelector('.mylandTop_wrap .mlt_left .mltProfile .mltP_status');
const statusList = document.querySelector('.mylandTop_wrap .mlt_right .mlt_statusList');

const gameBgs = document.querySelectorAll(".game_popup_bg");

for(let i = 0; i < gameBgs.length; ++i) {
    gameBgs[i].addEventListener("keyup", (e) => {
        if(e.key === 'Enter') {
        gameBgs[i].querySelector("button").click();
        e.stopPropagation();
    }
    });
}

// 새로고침
const updateBox = document.querySelector("#updatebox");
updateBox.querySelector('button').addEventListener('click', () => {
    location.reload(true);
});

const infoBox = document.querySelector("#infobox");
infoBox.querySelector('button').addEventListener('click', () => {
    infoBox.style.display = 'none';
    infoBox.blur();
    
});

const statusBtn = document.querySelector('#statusBtn');