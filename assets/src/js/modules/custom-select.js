document.addEventListener("DOMContentLoaded", function () {
    const customSelect = document.querySelector(".custom-select");
    if(customSelect){
        const trigger = customSelect.querySelector(".custom-select-trigger");
        const options = customSelect.querySelector(".custom-options");
        const input = customSelect.querySelector("input[name='product_equipment']");
        const optionItems = options.querySelectorAll(".custom-option");
        // Открытие списка при клике
        trigger.addEventListener("click", function () {
            options.classList.toggle("hidden");
        });

        // Выбор элемента из списка
        optionItems.forEach((option) => {
            option.addEventListener("click", function () {
                trigger.textContent = this.textContent;
                input.value = this.dataset.value;
                options.classList.add("hidden");
            });
        });

        // Закрытие списка при клике вне его области
        document.addEventListener("click", function (e) {
            if (!customSelect.contains(e.target)) {
                options.classList.add("hidden");
            }
        });
    }
});