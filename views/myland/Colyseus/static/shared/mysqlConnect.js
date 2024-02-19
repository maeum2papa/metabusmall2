window.onload = function () {
    window.top.postMessage({ info: 'onLoad' }, '*');
}

var jsonData;
var curRoom;
var user_Info;
var isSidebarOpen = true;

window.addEventListener('message', function (e) {
    if (e.data.state === "Info") {
        jsonData = e.data.infoString;
        sidebar = e.data.close;

        curRoom = JSON.parse(jsonData).room;
        //user_Index = JSON.parse(jsonData).currentUser;
        
        user_Info = JSON.parse(jsonData)

        fetch('/info', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonData
        })
            .then(response => {
                if (response.ok) {
                    console.log("Good");
                }
                else {
                    console.log("not Good");
                }
            })
            .catch(error => {
                console.error("오류", error);
            })
    } else {
        isSidebarOpen = e.data.isOpen;
    }

    // if(isSidebarOpen) {
    //     fruitBtn.classList.remove("fruit_sidebar_close");
    //     fruitBtn.classList.add("fruit_sidebar_open");
    //     inventoryBtn.classList.remove("inventory_btn_close");
    //     inventoryBtn.classList.add("inventory_btn_open");

    // } else {
    //     fruitBtn.classList.remove("fruit_sidebar_open");
    //     fruitBtn.classList.add("fruit_sidebar_close");
    //     inventoryBtn.classList.add("inventory_btn_close");
    //     inventoryBtn.classList.remove("inventory_btn_open");
    // }
})


