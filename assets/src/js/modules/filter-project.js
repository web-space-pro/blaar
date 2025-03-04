document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll("[data-id]");
    const projectsContainer = document.getElementById("projects-container");
    const pageID = document.body.dataset.pageId;

    if(projectsContainer){
        filterButtons.forEach(button => {
            button.addEventListener("click", function () {
                let categoryId = this.getAttribute("data-id");

                // Удаляем класс активной кнопки у всех, добавляем к текущей
                filterButtons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                // Показываем лоадер
                projectsContainer.innerHTML = '<div class="m-auto col-span-2 lg:col-span-3 loadingspinner"></div>';

                fetch(ajaxurl, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        action: "blaar_filter_projects",
                        category_id: categoryId,
                        page_id: pageID
                    }),
                })
                    .then(response => response.text())
                    .then(data => {
                        projectsContainer.innerHTML = data;
                    })
                    .catch(error => {
                        console.error("Ошибка:", error);
                        projectsContainer.innerHTML = '<p class="error">Ошибка загрузки</p>';
                    });
            });
        });
    }
});
