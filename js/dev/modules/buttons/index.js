function WppBtn (){
  const MAIN_CONTAINER = document.getElementById("mainChatFloatContainer");
  const WPP_BTN = document.getElementById("wppFloatButton");
  const CLOSE_BTN = document.querySelector(".btn-close");

  if(WPP_BTN) {
    WPP_BTN.addEventListener("click", e => MAIN_CONTAINER.classList.toggle("active"));
    CLOSE_BTN.addEventListener("click", e => MAIN_CONTAINER.classList.toggle("active"));
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