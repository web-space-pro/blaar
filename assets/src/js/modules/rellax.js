import Rellax from 'rellax';
let rellaxInstance;

function initRellax() {
    if (window.innerWidth > 992) {
        rellaxInstance = new Rellax('.rellax', {
            speed: -3,
            center: false,
            wrapper: null,
            round: true,
            vertical: true,
            horizontal: false
        });
    } else if (rellaxInstance) {
        rellaxInstance.destroy();
        rellaxInstance = null;
    }
}

document.addEventListener("DOMContentLoaded", initRellax);
window.addEventListener("resize", initRellax);