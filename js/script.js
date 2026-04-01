
const carousel = document.querySelector(".carousel");
let scrollAmount = 0;
const cardWidth = 320; // 300 width + gap

function scrollRight() {
  carousel.scrollLeft += cardWidth;
}

function scrollLeft() {
  carousel.scrollLeft -= cardWidth;
}

