const openButton = document.querySelector(".products__detail__button");
const closeButton = document.querySelector(".products__moreInfo__button");
const modal = document.querySelector(".products__moreInfo");

openButton.addEventListener("click", () => {
    modal.classList.add("open");
});

closeButton.addEventListener("click", () => {
    modal.classList.remove("open"); 
});
