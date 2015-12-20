require('easyeditor');

function Utilities(){

}

Utilities.prototype.attachEvents = function () {
    this.loadRiceTextEditor();
};

Utilities.prototype.loadRiceTextEditor = function () {
    //var _this = this;

    if( $('.editor').length > 0 ) {
        $('.editor').easyEditor();
    }
};

module.exports = function () {
    var utilities = new Utilities();
    utilities.attachEvents();
};
