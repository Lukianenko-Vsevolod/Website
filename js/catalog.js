const products = [
{
    id: 0,
    name: "Asics Sky Elite FF",
    price: 13000,
    category: "asics",
    image: "image/asics.jpg",
    link: "element/asics.html"
},
{
    id: 1,
    name: "Nike HyperAce 3",
    price: 15000,
    category: "nike",
    image: "image/nike.jpg",
    link: "element/nike.html"    
},
{
    id: 2,
    name: "Mizuno Wave Lightning Z",
    price: 14000,
    category: "mizuno",
    image: "image/mizuno.jpg",
    link: "element/mizuno.html"
}];  

let cart = [];

const filterProducts = (category) => {
    if (category === "all") {
        showProducts(products);
    } else {
        const filtered = products.filter(product => product.category === category);
        showProducts(filtered);
    }
};

function saveLocalStorage(cart){
    localStorage.setItem("cart", JSON.stringify(cart))
}
function loadFromLocalStorage() {

        if (localStorage.getItem("cart") === null){
        return []
    }

    const Scart = JSON.parse(localStorage.getItem("cart"))

    if (Scart.length == 0) {
        return []
    }
    else{
        return Scart;
    }
}

function showProducts(SProducts){
    const container = document.getElementById("products-container");
    let html = ""
    for (let i = 0; i < SProducts.length; i++){
        html += `
            <div class = "product-card">
            <img src = "${SProducts[i].image}" width = "170">
            <a href = "${SProducts[i].link}"> ${SProducts[i].name}</a>
            <p class = price> Цена: ${SProducts[i].price} руб</p>  
            <button class = "add_cart" data-id="${SProducts[i].id}">Добавить в корзину</button>
            </div>
        `;
    }
    container.innerHTML = html;
}

function showCart(){
    const container = document.getElementById("products-cart");
    const totalSpan = document.getElementById("cart-total")
    let html = ""
    let total = 0;
    for (let i = 0; i < cart.length; i++) {
        html +=`
        <div class = "product-cart">
        <a href = "${cart[i].link}"> ${cart[i].name} "- ${cart[i].price} руб"</a>
        <button class = "Del_cart" data-id="${cart[i].id}">Удалить</button>
        `;
        total += cart[i].price
    }
    container.innerHTML = html;
    totalSpan.textContent = total;
    saveLocalStorage(cart)
}

const filterButtons = document.querySelectorAll(".filter")
filterButtons.forEach(button => {
    button.addEventListener("click", function() {   
        const category = button.getAttribute('data-category');
        filterProducts(category);
    });
});     

const AddCart = (productid) => {
    const product = products.find(p => p.id === productid) 
    if (product){
        cart.push(product);
        showCart();
    }
   saveLocalStorage(cart)
};

const CleanCart = () => {
    cart = [];
    showCart();
    saveLocalStorage(cart)
};

const checkout = () => {
    if (cart.length === 0) {
        alert("Корзина пуста")
    }
    else {
        alert("Оплата прошла успешно")
        CleanCart()
    }
}

const clearBtn = document.querySelector(".Cart[data-category='clear']");
if (clearBtn) clearBtn.addEventListener("click", CleanCart);

document.getElementById("products-container").addEventListener("click", (event) => {
    if(event.target.classList.contains("add_cart")) {
        const id = parseInt(event.target.getAttribute("data-id"));
        AddCart(id);
    }
    saveLocalStorage(cart)
});

const payBtn = document.querySelector(".Cart[data-category='Pay']");
if (payBtn) payBtn.addEventListener("click", checkout);

document.getElementById("products-cart").addEventListener("click", (event) => {
    if (event.target.classList.contains("Del_cart")) {
        const id = parseInt(event.target.getAttribute("data-id"));
        const index = cart.findIndex(item => item.id === id);
        if (index !== -1) {
            cart.splice(index, 1);
        }
        showCart();
    }
    saveLocalStorage(cart)
});

const savedCart = loadFromLocalStorage(); 

if (savedCart) {  
    cart = savedCart;  
}
showProducts(products);
showCart();