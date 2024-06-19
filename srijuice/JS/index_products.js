function addProduct(containerId, imgSrc, title, price, isAdmin = false) {
    const productsContainer = document.querySelector(containerId);

    const columnDiv = document.createElement('div');
    columnDiv.className = 'column';

    const cardDiv = document.createElement('div');
    cardDiv.className = 'card';

    const imgContainerDiv = document.createElement('div');
    imgContainerDiv.className = 'img-container';

    const img = document.createElement('img');
    img.src = imgSrc;

    imgContainerDiv.appendChild(img);

    if (!isAdmin) {
        const cartIcon = document.createElement('a');
        cartIcon.className = 'cart-icon';
        const cartIconI = document.createElement('i');
        cartIconI.className = 'fa-solid fa-cart-shopping';
        cartIcon.appendChild(cartIconI);

        cartIcon.addEventListener('click', function(event) {
            event.preventDefault();
            addcard(imgSrc, title, price);
        });

        imgContainerDiv.appendChild(cartIcon);
    }

    const titleElement = document.createElement('h3');
    titleElement.textContent = title;

    const priceElement = document.createElement('p');
    priceElement.textContent = price + "RS";

    cardDiv.appendChild(imgContainerDiv);
    cardDiv.appendChild(titleElement);
    cardDiv.appendChild(priceElement);

    if (isAdmin) {
        const editIcon = document.createElement('a');
        editIcon.className = 'edit-icon';
        const editIconI = document.createElement('i');
        editIconI.className = 'fa-solid fa-edit';
        editIcon.appendChild(editIconI);

        const deleteIcon = document.createElement('a');
        deleteIcon.className = 'delete-icon';
        const deleteIconI = document.createElement('i');
        deleteIconI.className = 'fa-solid fa-trash';
        deleteIcon.appendChild(deleteIconI);

        editIcon.addEventListener('click', function(event) {
            event.preventDefault();
            editProduct(title);
        });

        deleteIcon.addEventListener('click', function(event) {
            event.preventDefault();
            deleteProduct(title);
        });

        cardDiv.appendChild(editIcon);
        cardDiv.appendChild(deleteIcon);
    }

    columnDiv.appendChild(cardDiv);
    productsContainer.appendChild(columnDiv);
}

function loadProductsByType(type, containerId) {
    $.ajax({
        url: 'SYS/producthandler.php',
        method: 'GET',
        data: { type: type, user: 'admin' },
        success: function(response) {
            const products = JSON.parse(response);
            let productCount = 0;
            products.forEach(product => {
                if (productCount < 4) {
                    addProduct(containerId, product.img_path, product.name, product.price, product.isAdmin);
                    productCount++;
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}

function fetchProductTypes() {
    $.ajax({
        url: 'SYS/producthandler.php',
        method: 'GET',
        data: { fetch_types: true },
        success: function(response) {
            const types = JSON.parse(response);
            let typeCount = 0;
            types.forEach(type => {
                if (typeCount < 2) {
                    const section = document.createElement('div');
                    section.className = 'product-section';

                    const heading = document.createElement('h2');
                    heading.textContent = type;
                    section.appendChild(heading);

                    const row = document.createElement('div');
                    row.className = 'row';
                    row.id = type.replace(/\s+/g, '-').toLowerCase() + '-products';
                    section.appendChild(row);

                    document.getElementById('product-container').appendChild(section);

                    loadProductsByType(type, '#' + row.id);
                    typeCount++;
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}

$(document).ready(function() {
    fetchProductTypes();
});

function deleteProduct(name) {
    if (confirm("Are you sure you want to delete " + name + "?")) {
        $.ajax({
            type: "POST",
            url: "SYS/producthandler.php",
            data: {
                action: 'delete',
                name: name
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.message.startsWith("Deleted")) {
                    show_message(result.message);
                    
                    $('#product-container').empty();
                    fetchProductTypes();
                } else {
                    show_message(result.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                show_message('Failed to delete product.');
            }
        });
    }
}

function addcard(imgSrc, title, price) {
    var data = {
        title: title,
        img_path: imgSrc,
        price: price
    };

    $.ajax({
        type: "POST",
        url: "SYS/cardhandler.php",
        data: data,
        success: function(response) {
            show_message('Product added to cart!',"cart.php","Go to carts");
        },
        error: function(response) {
            show_message('Failed to add product to cart.');
        }
    });
}

function editProduct(name) {
    $.ajax({
      type: "GET",
      url: "SYS/producthandler.php",
      data: { action: 'fetch_product', name: name },
      success: function(response) {
        const product = JSON.parse(response);
        if (product) {
          document.getElementById('editOriginalName').value = product.name;
          document.getElementById('editProductType').value = product.type;
          document.getElementById('editProductImage').value = product.img_path;
          document.getElementById('editProductName').value = product.name;
          document.getElementById('editProductPrice').value = product.price;
  
          const modal = document.getElementById('editProductModal');
          modal.style.display = "block";
        } else {
          show_message('Product not found');
        }
      },
      error: function() {
        show_message('Failed to fetch product details.');
      }
    });
}

function closeModal() {
    const modal = document.getElementById('editProductModal');
    modal.style.display = "none";
}

document.querySelector('.bclose').onclick = function() {
    closeModal();
}

window.onclick = function(event) {
    const modal = document.getElementById('editProductModal');
    if (event.target == modal) {
        closeModal();
    }
}

document.getElementById('editProductForm').onsubmit = function(event) {
    event.preventDefault();
  
    const formData = {
      action: 'edit',
      original_name: document.getElementById('editOriginalName').value,
      type: document.getElementById('editProductType').value,
      img_path: document.getElementById('editProductImage').value,
      name: document.getElementById('editProductName').value,
      price: document.getElementById('editProductPrice').value
    };
  
    $.ajax({
      type: "POST",
      url: "SYS/producthandler.php",
      data: formData,
      success: function(response) {
        const result = JSON.parse(response);
        if (result.message.startsWith("Updated")) {
          show_message(result.message);
          closeModal();
          $('#product-container').empty();
          fetchProductTypes();
        } else {
          show_message(result.message);
        }
      },
      error: function() {
        show_message('Failed to update product.');
      }
    });
}

window.onclick = function(event) {
    const modal = document.getElementById('editProductModal');
    if (event.target == modal) {
        closeModal();
    }
}
