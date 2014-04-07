$(function() {
    var appeal_hash = {};

    appeal_hash.go = function () {
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
    };

    appeal_hash.click_listener = function() {
        $('#myTab a').click(function (e) {
            window.location.hash = this.hash;
        });
    };

    appeal_hash.go();
    appeal_hash.click_listener();
});