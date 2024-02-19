
const fishall = document.querySelectorAll ('#fd_fishBook > fd_fish_li')
const fishN = document.querySelectorAll ('.fishN')
const liBg = document.querySelectorAll ('.after')
const fdRW = document.querySelectorAll ('.fdBtn > #fd_Rewards')
const fdclose = document.querySelector ('.fdCoin > .fdCoin_popup > .fdCoin_close')


//팝업 닫기
fdclose.addEventListener('click',function(){
    const fdpop = document.querySelector ('.fdCoin')
    fdpop.style.display='none'
})
//팝업

fdRW[0].addEventListener('click',function(){
    const fdpop = document.querySelector ('.fdCoin')
    fdpop.style.display='block'
    fdRW[0].style.background='#D9D9D9'
    fdRW[0].innerText="보상 획득 완료"
    fdRW[0].style.color='#000'
})
fdRW[1].addEventListener('click',function(){
    const fdpop = document.querySelector ('.fdCoin')
    fdpop.style.display='block'
    fdRW[1].style.background='#D9D9D9'
    fdRW[1].innerText="보상 획득 완료"
    fdRW[1].style.color='#000'
})

fdRW[2].addEventListener('click',function(){
    const fdpop = document.querySelector ('.fdCoin')
    fdpop.style.display='block'
    fdRW[2].style.background='#D9D9D9'
    fdRW[2].innerText="보상 획득 완료"
    fdRW[2].style.color='#000'
})


//물고기 도감 슬라이드
const nextfdBtn = document.querySelectorAll ('#nextfdBtn')
const prevfdBtn = document.querySelectorAll ('#prevfdBtn')
const fishBook = document.querySelectorAll ('#fd_fishBook')
const fishBookall = document.querySelectorAll ('.fishBook >.fishBookTop > #fd_fishBook  > .fd_fish_li')
// console.log(slide, nextfdBtn, prevfdBtn,fishBook)

fishBookall.forEach(function(t,i){
    nextfdBtn[i].addEventListener('click',function(){
        fishBookall[i].style.transform = 'translateX(-445px)'
        fishBookall[i].style.transition = 'transform 0.3s'
    })
})
fishBookall.forEach(function(t,i){
    prevfdBtn[i].addEventListener('click',function(){
        fishBookall[i].style.transform = 'translateX(0)'
        fishBookall[i].style.transition = 'transform 0.3s'
    })
})




/*var slide = 1;
$('#nextfdBtn').on('click',function(){
    if (slide == 1){
        $('#fd_fishBook').css('transform', 'translateX(-100vw');
        $('#fd_fishBook').css('display', 'none')
        slide = 2;
    } else if (slide == 2){
        $('#fd_fishBook').css('transform', 'translateX(-200vw');
        slide = 3;
    }
})*/