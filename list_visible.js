const DoingBtn = document.querySelector(".doing_button");
const CompletedBtn = document.querySelector(".completed_button");
const DoingContainer = document.querySelector(".doing_list");
const CompletedContainer = document.querySelector(".completed_list");

const VISIBLE = "visible";
const ACTIVE = "active";

function handleBtn(e) {
    const target = e.target;

    if(!target.classList.contains(ACTIVE)) {
        target.classList.add(ACTIVE);
    }
    if(target.classList.contains("doing_button")) {
        DoingContainer.classList.add(VISIBLE);
        CompletedContainer.classList.remove(VISIBLE);
        CompletedBtn.classList.remove(ACTIVE);
    } else {
        CompletedContainer.classList.add(VISIBLE);
        DoingContainer.classList.remove(VISIBLE);
        DoingBtn.classList.remove(ACTIVE);
    }
}

function init() {
    DoingBtn.addEventListener("click", handleBtn);
    CompletedBtn.addEventListener("click", handleBtn);
}
init();
