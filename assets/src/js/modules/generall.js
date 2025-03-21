(function ($, root, undefined) {
    document.querySelectorAll('a[href^="/#"], a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            let href = this.getAttribute('href');
            let target = href.split('#')[1];
            let headerHeight = document.querySelector('header')?.offsetHeight || 0;
            let targetElement = document.getElementById(target);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - headerHeight,
                    behavior: 'smooth'
                });
            } else if (href.startsWith('/#')) {
                window.location.href = window.location.origin + '/#' + target;
            }
        });
    });
})(jQuery);

