const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  purge: {
    mode: 'layers',
    content: [
      'function.php',
      'index.php',
      'header.php',
      '404.php',
      'archive-product.php',
      'comments.php',
      'sidebar.php',
      'footer.php',
      'page.php',
      'front-page.php',
      'single-services.php',
      'single.php',
      'content-parts/content.php',

      'block-parts/tpl-slider.php',
      'block-parts/tpl-banner.php',
      'block-parts/tpl-promo-products.php',

      'woocommerce/archive-product.php',
      'woocommerce/content-product.php',
      'woocommerce/content-single-product.php',
      'woocommerce/loop/price.php',
      'woocommerce/loop/loop-start.php',
      'woocommerce/loop/header.php',
      'woocommerce/loop/loop-end.php',
      'woocommerce/loop/orderby.php',

      'woocommerce/single-product/add-to-cart/simple.php',
      'woocommerce/single-product/add-to-cart/variable.php',
      'woocommerce/single-product/title.php',
      'woocommerce/single-product/meta.php',

      'woocommerce/cart-checkout.php',
      'woocommerce/cart/cart.php',
      'woocommerce/cart/cart-empty.php',
      'woocommerce/cart/mini-cart.php',
      'woocommerce/cart/cart-totals.php',
      'woocommerce/cart/cart-item-data.php',
      'woocommerce/checkout/form-checkout.php',
      'woocommerce/checkout/form-billing.php',
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
        'xl': '1280px',
        '2xl': '1366px',
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
          60: '#F5F6F8',
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
          30: '#525766',
          40: '#10283A',
        }
      },
      boxShadow: {
        'icon': '0 0 5px #cca670',
        'input': '0 0 10px #cca670',
        'popup': '0 0 8px 1px rgba(217,217,217,0.5)',
      },
      backgroundImage: {
        'gradient': "linear-gradient(180deg, rgba(245, 245, 245, 0) 0%, rgba(245, 245, 245, 0.75) 100%)",
        'gradient-black': 'linear-gradient(180deg, rgba(34, 34, 34, 0) 0%, rgba(34, 34, 34, 0.75) 100%)',
      }
    },
  },
  plugins: [],
}
