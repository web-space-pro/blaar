(function ($, root, undefined) {
    $(document).ready(function(){
        $('.btn-burger').click(function(e){
            $('.btn-burger, .mobile-menu').toggleClass('toggled');
            $('body').toggleClass('ov-hidden');
        });
    });
})(jQuery);

document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");
    const subMenuWrap = document.querySelector(".sub-menu");
    let timeoutId;

    menuItems.forEach(item => {
        let menuId = item.id.replace("menu-item-", "");
        let submenu = document.querySelector('.custom-submenu[data-menu-id="' + menuId + '"]');

        if (!submenu) return; // Если нет подменю, ничего не делаем

        item.addEventListener("mouseenter", function () {
            clearTimeout(timeoutId); // Отменяем скрытие
            document.querySelectorAll(".custom-submenu").forEach(sub => sub.classList.remove("toggled"));
            submenu.classList.add("toggled");
            subMenuWrap.classList.add("toggled");
        });

        item.addEventListener("mouseleave", function () {
            timeoutId = setTimeout(() => {
                if (!submenu.matches(":hover") && !subMenuWrap.matches(":hover")) {
                    submenu.classList.remove("toggled");
                    subMenuWrap.classList.remove("toggled");
                }
            }, 200); //  200 мс на переход к подменю
        });

        submenu.addEventListener("mouseenter", function () {
            clearTimeout(timeoutId);
            submenu.classList.add("toggled");
            subMenuWrap.classList.add("toggled");
        });

        submenu.addEventListener("mouseleave", function () {
            timeoutId = setTimeout(() => {
                if (!submenu.matches(":hover") && !subMenuWrap.matches(":hover")) {
                    submenu.classList.remove("toggled");
                    subMenuWrap.classList.remove("toggled");
                }
            }, 200);
        });

        // Отключаем переход по клику
        item.addEventListener("click", function (e) {
            e.preventDefault();
            item.style.pointerEvents = "none";
            setTimeout(() => {
                item.style.pointerEvents = "";
            }, 500);
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const titles = document.querySelectorAll(".menu-title");
    const contents = document.querySelectorAll(".menu-content");

    titles.forEach((title) => {
        title.addEventListener("click", function () {
            const menuId = this.dataset.menuId;

            // Скрываем все блоки с контентом
            contents.forEach((content) => content.classList.add("hidden"));
            document.querySelector(`.menu-content[data-menu-id="${menuId}"]`).classList.remove("hidden");

            // Убираем класс 'active' у всех заголовков и добавляем к текущему
            titles.forEach((t) => t.classList.remove("active"));
            this.classList.add("active");
        });
    });
});





