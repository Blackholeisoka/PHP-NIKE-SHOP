const cards = document.querySelectorAll('.container_card');

cards.forEach((card, cardIndex) => {
  const mainImage = card.querySelector('.main-image');
  const hoverImages = card.querySelectorAll('.container-img_hover img');

  hoverImages.forEach((img, imgIndex) => {
    img.addEventListener('mouseover', () => {
      mainImage.src = img.src;
    });

    img.addEventListener('click', () => {
      window.location.href = `./product-shop.php?id=${cardIndex}&color=${imgIndex}`;
    });

    mainImage.addEventListener('click', () => {
      window.location.href = `./product-shop.php?id=${cardIndex}&color=${imgIndex}`;
    });
  });
});