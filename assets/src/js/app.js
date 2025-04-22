try {
    require('jquery');
    require("./vendors");
    require("./modules/input_mask");
    require("./modules/menu");
    require("./modules/slider");
    require("./modules/rellax");
    // require("./modules/generall");
    require("./modules/woocommerce");
    //require("./modules/modal");
    // require("./modules/custom-select");
} catch (e) {
    console.log('JS ERROR!!!', e);
}