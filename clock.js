const clockC = document.querySelector('.clockContainer');
const clock = clockC.querySelector('.clock');


function getTime(){

  const time = new Date();
  const hour = time.getHours();
  const minutes = time.getMinutes();
  const seconds = time.getSeconds();
  //clock.innerHTML = hour +":" + minutes + ":"+seconds;
  clock.innerText = `${hour<10 ? `0${hour}`:hour}:${minutes<10 ? `0${minutes}`:minutes}:${seconds<10 ? `0${seconds}`:seconds}`
}


function init(){
    setInterval(getTime, 1000);
}

init();
