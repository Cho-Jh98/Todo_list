function forgot_pop() {
  document.querySelector(".forgot_background").className = "forgot_background forgot";
}

function forgot_close() {
  document.querySelector(".forgot_background").className = "forgot_background";
}

document.querySelector("#forgot_button").addEventListener("click", forgot_pop);
document.querySelector("#forgot_close").addEventListener("click", forgot_close);





function sign_in() {
  document.querySelector(".sign_background").className = "sign_background sign";
}

function sign_close() {
  document.querySelector(".sign_background").className = "sign_background";
}

document.querySelector("#sign_button").addEventListener("click", sign_in);
document.querySelector("#sign_close").addEventListener("click", sign_close);
