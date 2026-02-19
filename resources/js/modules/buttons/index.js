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
  SlideOfferCarousel
}
