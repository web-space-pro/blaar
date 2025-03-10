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
      'woocommerce/content-single-product.php',
      'woocommerce/loop/price.php',
      'woocommerce/loop/loop-start.php',
      'woocommerce/loop/loop-end.php',

      'woocommerce/single-product/add-to-cart/simple.php',
      'woocommerce/single-product/add-to-cart/variable.php',
      'woocommerce/single-product/title.php',


      'woocommerce/cart/cart.php',
      'woocommerce/cart/mini-cart.php',
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
        'relaway': ['Raleway','sans-serif'],
        'oswald': ['Oswald','sans-serif'],
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
          10: '#ffffff',
          20: '#f1f1f1',
          30: '#f5f5f5',
          40: '#ebedf2',
          50: '#e6e6e6',
        },
        gray:{
          10: '#dddddd',
          20: '#cccccc',
          30: '#bbbbbb',
          40: '#adafb2',
          50: '#999999',
          60: '#777777',
          70: '#616266',

        },
        black: {
          10: '#222222',
          20: '#242833',
          30: '#525766'
        }
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
