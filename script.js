// Simple carousel scroll logic
const carousel = document.querySelector('.carousel');

function scrollLeft() {
  carousel.scrollBy({ left: -320, behavior: 'smooth' });
}

function scrollRight() {
  carousel.scrollBy({ left: 320, behavior: 'smooth' });
}
