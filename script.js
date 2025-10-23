const carousel = document.getElementById('carousel');
const cards = document.querySelectorAll('.card');
const visibleCards = 3; // visible cards in container
let currentIndex = 1;   // start at index 1 to hide first card

function scrollRight() {
  if (currentIndex < cards.length - visibleCards) {
    currentIndex++;
    updateCarousel();
  }
}

function scrollLeft() {
  if (currentIndex > 0) {
    currentIndex--;
    updateCarousel();
  }
}

function updateCarousel() {
  const cardWidth = cards[0].offsetWidth + 20; // width + gap
  carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
}

