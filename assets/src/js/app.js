try {
    require('jquery');
    require("./vendors");
    require("./modules/input_mask");
    require("./modules/menu");
    require("./modules/rellax");
    // require("./modules/generall");
    require("./modules/woocommerce");
    require('slick-carousel');
    require("./modules/slider");
    //require("./modules/modal");
    // require("./modules/custom-select");
} catch (e) {
    console.log('JS ERROR!!!', e);
}