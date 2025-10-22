// ===== Featured Stories Carousel =====
const storyContainer = document.getElementById('storyContainer');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let scrollAmount = 0;
const cardWidth = 380; // card width + gap

nextBtn.addEventListener('click', () => {
  storyContainer.scrollBy({
    left: cardWidth,
    behavior: 'smooth'
  });
});

prevBtn.addEventListener('click', () => {
  storyContainer.scrollBy({
    left: -cardWidth,
    behavior: 'smooth'
  });
});
