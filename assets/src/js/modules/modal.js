(function ($, root, undefined) {
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('open-modal');
        const openBtns = document.querySelectorAll('.open-modal');
        const closeBtns = document.querySelectorAll('.modal-close, .modal-backdrop');

        let fileToDownload = "";

        // Открытие модального окна
        openBtns.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                modal.classList.add('active');
                history.pushState(null, null, '#open-modal');
                fileToDownload = this.dataset.file;
            });
        });

        // Закрытие модального окна
        closeBtns.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                modal.classList.remove('active');
                history.replaceState(null, null, ' ');
            });
        });

        // Закрытие при нажатии Esc
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape" && modal.classList.contains('active')) {
                modal.classList.remove('active');
                history.replaceState(null, null, ' ');
            }
        });

        // if (window.location.hash === "#open-modal") {
        //     modal.classList.add('active');
        // }

        document.addEventListener("wpcf7mailsent", function (event) {
            const formId = event.detail.contactFormId;
            if (formId === 341 && fileToDownload) { // Замените 456 на реальный ID вашей формы скачивания
                downloadFile(fileToDownload);
            }
        }, false);

        function downloadFile(file) {
            const a = document.createElement("a");
            a.href = file;
            a.download = file.split("/").pop();
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });
})(jQuery);