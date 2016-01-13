require('easyeditor');

function Utilities(){

}

Utilities.prototype.attachEvents = function () {
    this.loadRiceTextEditor();
};

Utilities.prototype.loadRiceTextEditor = function () {
    //var _this = this;

    if( $('.editor').length > 0 ) {
        $('.editor').easyEditor({
            buttons: ['bold', 'italic', 'link', 'h2', 'h3', 'h4', 'alignleft', 'aligncenter', 'alignright', 'quote', 'code', 'list', 'x', 'source']
        });
    }
};

module.exports = function () {
    var utilities = new Utilities();
    utilities.attachEvents();
};
