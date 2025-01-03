function verifyComponents() {
    var headers = document.getElementsByClassName('header');

    if (headers) {
        headerCreator(headers);
    }

}

verifyComponents();

function headerCreator(headers) {

    for (const h of headers) {
        var header = document.createElement('header');
    }

}

/*        
<div class="header__items">
<img class="header__items__logo" src="../../../public/images/logo-mobile.png" alt="Logo Desconto da Maquininha">
<div class="header__items__search">
    <i class="material-icons">search</i>
    <input class="header__items__search__input" type="search" placeholder="Buscar">
</div>
</div> 
*/