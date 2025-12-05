function WppBtn (){
  const MAIN_CONTAINER = document.getElementById("mainChatFloatContainer");
  const WPP_BTN = document.getElementById("wppFloatButton");

  if(WPP_BTN) {
    const CLOSE_BTN = MAIN_CONTAINER.querySelector(".btn-close");
    const WPP_TITLE = MAIN_CONTAINER.querySelector(".float-whatsapp_title");

    WPP_TITLE.querySelector("span").addEventListener("click", () => MAIN_CONTAINER.classList.toggle("active"));
    WPP_BTN.addEventListener("click", () => MAIN_CONTAINER.classList.toggle("active"));
    CLOSE_BTN.addEventListener("click", e => {
      console.log(e.currentTarget);
      MAIN_CONTAINER.classList.remove("active")
    });
  }
}

function SlideOfferCarousel () {
  document.querySelectorAll(".carousel-control").forEach($el => {
    $el.addEventListener("click", ev => {
      const $controlBtn = ev.currentTarget;
      const { scrollX, slide="next" } = $controlBtn.dataset;
      if(scrollX) {
        const $ParentElement = document.querySelector(scrollX);
        const $InnerContainer = $ParentElement.querySelector(".carousel-inner");

        let scrollAmount = $InnerContainer.scrollWidth - $ParentElement.clientWidth;
        let scrollPosition = slide === "next" ? `translateX(-${scrollAmount}px)` : `translateX(${scrollAmount}px)`;
        $InnerContainer.style.transform = scrollPosition;
      }
    });
  });
}

export {
  WppBtn,
  SlideOfferCarousel
}