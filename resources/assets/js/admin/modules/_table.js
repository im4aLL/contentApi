function Table(){
    this.elem = '.table';
    this.selectAllelem = '#selectall';
    this.submitContainer = 'html';
    this.submitElem = '[data-ajax-submit]';
    this.ajaxRoute = null;
    this.singleItemId = 0;
    this.redirectTo = null;
}

Table.prototype.attachEvents = function () {
    this.selectAll();
    this.submitHandler();
};

Table.prototype.selectAll = function () {
    var _this = this;

    $(_this.submitContainer).delegate(_this.selectAllelem, 'change', function(){
        var checkFlag = $(this).prop('checked') ? true : false;

        $(this).closest(_this.elem).find('tbody :checkbox').each(function(index, el) {
            $(el).prop('checked', checkFlag);
        });
    });
};

Table.prototype.submitHandler = function () {
    var _this = this;

    $(_this.submitContainer).delegate(_this.submitElem, 'click', function (event) {
        event.preventDefault();
        _this.ajaxRoute = $(this).attr('data-ajax-route');

        var submissionType = $(this).attr('data-ajax-submit');

        // if button contain id for archive / unarchive
        if($(this).attr('data-ajax-id') !== undefined) {
            _this.singleItemId = $(this).attr('data-ajax-id');
        }
        else {
            _this.singleItemId = 0;
        }

        // if button contains redirect url
        if($(this).attr('data-ajax-redirect') !== undefined) {
            _this.redirectTo = $(this).attr('data-ajax-redirect');
        }
        else {
            _this.redirectTo = null;
        }

        if (submissionType === 'publish' || submissionType === 'unpublish') {
            _this.stateHandler(this);
        } else if (submissionType === 'delete') {
            _this.deleteHandler(this);
        }
    });
};

Table.prototype.getSelectedItems = function () {
    var _this = this;
    var items = [];

    if(_this.singleItemId > 0) {
        items.push(_this.singleItemId);
    }
    else {
        $(_this.elem).find('tbody :checkbox').each(function(index, el) {
            if($(this).prop('checked')) {
                items.push($(this).val());
            }
        });
    }

    return items;
};

Table.prototype.getToken = function () {
    return $('meta[name="csrf-token"]').attr("content");
};

Table.prototype.stateHandler = function (btn) {
    var _this = this;
    var items = _this.getSelectedItems();
    if(items.length === 0) {
        return false;
    }

    var btnText = $(btn).text();
    $(btn).attr('disabled', 'disabled').html('Processing...');

    $.ajax({
        url: _this.ajaxRoute,
        method: 'PUT',
        dataType: 'json',
        data: { items: items, _token: _this.getToken() }
    })
        .done(function () {
            if(_this.redirectTo !== null) {
                window.location.href = _this.redirectTo;
            }
            else {
                location.reload();
            }
        })
        .fail(function () {
            $(btn).html(btnText);
        });
};

Table.prototype.deleteHandler = function (btn) {
    var _this = this;
    var items = _this.getSelectedItems();
    if(items.length === 0) {
        return false;
    }

    if(!confirm('Are you sure? This can\'t be undone!')) {
        return false;
    }

    var btnText = $(btn).text();
    $(btn).attr('disabled', 'disabled').html('Deleting...');

    $.ajax({
        url: _this.ajaxRoute,
        method: 'DELETE',
        dataType: 'json',
        data: { items: items, _token: _this.getToken() }
    })
        .done(function () {
            location.reload();
        })
        .fail(function () {
            $(btn).html(btnText);
        });
};

module.exports = function () {
    var table = new Table();
    table.attachEvents();
};
