const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  purge: {
    mode: 'layers',
    content: [
      'function.php',
      'index.php',
      'header.php',
      '404.php',
      'comments.php',
      'sidebar.php',
      'footer.php',
      'page.php',
      'front-page.php',
      'single-services.php',
      'single.php',
      'content-parts/content.php',

      'block-parts/tpl-hero.php',
      'block-parts/tpl-find-us.php',
      'block-parts/tpl-read-us.php',
      'block-parts/tpl-contact-us.php',
      'block-parts/tpl-offer.php',
      'block-parts/tpl-projects-list.php',

      'woocommerce/archive-product.php',
      'woocommerce/content-product.php',
      'woocommerce/loop/price.php',
      'woocommerce/loop/loop-start.php',
      'woocommerce/loop/loop-end.php',
      'woocommerce/single-product/add-to-cart/simple.php',
      'woocommerce/cart/cart.php',
      'woocommerce/cart/cart-totals.php',
      'woocommerce/checkout/form-checkout.php',
      'woocommerce/checkout/payment.php',



      'inc/functions-menus.php',
      'inc/woocommerce/woocommerce-single-product.php',
    ],
  },
  darkMode: false,
  theme: {
    extend: {
      fontFamily: {
        'reg': ['Steinbeck','sans-serif'],
        'sans': ['NotoSansMono','sans-serif'],
      },
      container: {
        center: true,
        padding: '1rem',
        screens: {
          'xs': '100%',
          'sm': '885px',
          'md': '992px',
          'lg': '1024px',
          'xl': '1140px',
          '2xl': '1240px'
        }
      },
      screens: {
        'xs': '640px',
        'sm': '768px',
        'md': '992px',
        'lg': '1024px',
        'xl': '1180px',
        '2xl': '1440px',
        '3xl': '1600px',
        '4xl': '1920px',
      },
      colors: {
        white: {
          10: '#f2f2f0',
          20: '#d9d9d9',
        },
        gray:{
          10: '#3f4042',
          20: '#afafaf',
        },
      },
      boxShadow: {
        'icon': '0 0 5px #cca670',
        'input': '0 0 10px #cca670',
        'popup': '0 0 8px 1px rgba(217,217,217,0.5)',
      },
      backgroundImage: {
        'bg-gradient': "linear-gradient(180deg, #1a1f1b 0%, #001202 100%);",
        'bg-link': 'linear-gradient(90deg, #0ecccf 0%, #086b6d 100%)',
      }
    },
  },
  plugins: [],
}
