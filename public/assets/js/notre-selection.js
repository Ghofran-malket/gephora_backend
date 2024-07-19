const notreSelectionProduits = document.getElementById("allProducts");
const titlle = "<img src=x onerror='window.location.replace(\"https://google.com\")'>";
const produit = getProducts("Mascara", "bsdjfhbsdfhbsdjf", 33.5, "../images/article-1.jpg");

notreSelectionProduits.innerHTML = produit;

function getProducts(title, description, price, image){
    title = sanitizeHtml(title);
    description = sanitizeHtml(description);
    price = sanitizeHtml(price);
    image = sanitizeHtml(image);

    return `<div class="col display">
            <div class="image-card text-dark">
                <img src="${image}" class="rounded-circle image-size" />
                <div class="titre-image d-flex justify-content-around text-white" data-show="admin">
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#editionProductModal">
                        <i class="bi bi-pencil-square h3"></i>
                    </button>
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#deleteProductModal">
                        <i class="bi bi-trash h3"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-dark">${title}</h3>
            <h4 class="text-dark pb-2">${price}$</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showProductModal">Découvrir</button>
        </div>`;
}