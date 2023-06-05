export default function (){
  const MAIN_CONTAINER = document.getElementById("mainChatFloatContainer");
  const WPP_BTN = document.getElementById("wppFloatButton");
  const CLOSE_BTN = document.querySelector(".btn-close");

  WPP_BTN.addEventListener("click", e => MAIN_CONTAINER.classList.toggle("active"));
  CLOSE_BTN.addEventListener("click", e => MAIN_CONTAINER.classList.toggle("active"));
}