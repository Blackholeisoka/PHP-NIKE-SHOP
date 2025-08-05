const cart_items = document.querySelectorAll('.cart-item');

cart_items.forEach(cart_item => {
    const id = parseInt(cart_item.dataset.id);
    const selector = cart_item.querySelector('.quantity-selector');
    const less_btn = selector.querySelectorAll('button')[0];
    const more_btn = selector.querySelectorAll('button')[1];
    const quantity_input = selector.querySelector('.quantity-input');
    const remove_btn = cart_item.querySelector('.remove-btn');

    const updateQuantity = (n) => {
        fetch('bag-update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id, count: n })
        })
        .then(res => res.json())
        .then(_ => window.location.reload());
    };

    less_btn.addEventListener('click', () => {
        let current = parseInt(quantity_input.value);
        if (current > 1) {
            quantity_input.value = current - 1;
            updateQuantity(current - 1);
        }
    });

    more_btn.addEventListener('click', () => {
        let current = parseInt(quantity_input.value);
        if (current < 10) {
            quantity_input.value = current + 1;
            updateQuantity(current + 1);
        }
    });

    remove_btn.addEventListener('click', () => {
        fetch('bag-trash.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(id)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                swal("Supprimé!", "Article supprimé du panier.", "success")
                    .then(() => window.location.reload());
            } else {
                swal("Erreur", data.message || "Problème pendant la suppression", "error");
            }
        })
        .catch(() => {
            swal("Erreur", "Erreur réseau", "error");
        });
    });
});