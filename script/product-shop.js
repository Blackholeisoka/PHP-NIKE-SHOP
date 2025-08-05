const mainImage = document.querySelector('.container_view img');

const view = document.querySelector('.container_preview');

  const hoverImages = view.querySelectorAll('img');

  hoverImages.forEach(img => {
    img.addEventListener('click', () => {
      mainImage.src = img.src;
    });
  });

const container_slider = document.querySelectorAll('.container_slider-btn button');
const previous_img = container_slider[0];
const next_img = container_slider[1];

let index = 0;

previous_img.addEventListener('click', () => {
  index = (index === 0) ? hoverImages.length - 1 : index - 1;
  mainImage.src = hoverImages[index].src;
});

next_img.addEventListener('click', () => {
  index = (index === hoverImages.length - 1) ? 0 : index + 1;
  mainImage.src = hoverImages[index].src;
});

const shoes_color_img = document.querySelectorAll('.container_details-shoes img');
const param = new URLSearchParams(window.location.search);
const id = param.get('id');
const color = param.get('color');

shoes_color_img.forEach((c, index) =>{
  c.addEventListener('click', () => window.location.href = `./product-shop.php?id=${id}&color=${index}`);
});
 
const container_details = document.querySelectorAll('.container_details-size-btn .size_btn');
const container_details_btn = document.querySelector('.container_details-buy button');

let shoes_select = '';
container_details.forEach((s) => {
  s.addEventListener('click', () => {
    const isActive = s.style.border === '1px solid black';

    container_details.forEach((btn) => {
      btn.style.border = '1px solid #ddd';
    });

    s.style.border = isActive ? '1px solid #ddd' : '1px solid black';
    const oneIsActive = Array.from(container_details).some(btn => btn.style.border === '1px solid black');

    if (oneIsActive) {
      container_details_btn.classList.remove('disabled-button');
      container_details_btn.disabled = false;
      shoes_select = s.textContent.split(' ')[1];
    } else {
      container_details_btn.classList.add('disabled-button');
      container_details_btn.disabled = true;
    }
  });
});

container_details_btn.addEventListener('click', () => {
  const bag_data = {
    shoes_index: id,
    color_index: color,
    size_value: shoes_select,
    count: 1,
  };

  fetch('bag-json.php', {
    method: 'POST',
    headers: {
      'Content-type': 'application/json',
    },
    body: JSON.stringify(bag_data)
  })
  .then(response => response.json())
  .then(result => {
    if (result.status === 'success') {
      swal("Bon travail!", "Article ajouté au panier!", "success")
          .then(() => window.location.reload());
    } else {
      swal("Oups...", "Une erreur est survenue.", "error");
    }
  });
});