$(document).ready(function () {
    var select = $('#inputGroupSelect01');
    var noResult = $('#noResult');
    if (select.length) {
        var userId = select.find('option:selected').val();
        getAddresses(userId);
        select.change(function () {
            userId = select.find('option:selected').val();
            getAddresses(userId)
        })
    }
    if (noResult.length) {
        getAddresses(0);
    }

    function getAddresses(userId) {
        $('#noResult').hide();
        $('table').show();
        $.ajax({
            type: 'POST',
            url: '/address/ajax',
            data: {userId: userId},
            success: function (data) {
                var addresses = JSON.parse(data);
                if (!addresses.length) {
                    noResult.show();
                    $('table').hide();
                } else {
                    $('tbody').empty();
                    $(addresses).each(function (key, val) {
                        $('tbody').append('<tr></tr>')
                        $('tbody tr:last')
                            .append('<th scope="row">' + val.id + '</th>')
                            .append('<td>' + val.city + '</td>')
                            .append('<td>' + val.postcode + '</td>')
                            .append('<td>' + val.region + '</td>')
                            .append('<td>' + val.street + '</td>')
                            .append('<td><a href="/address/user/' + val.user_id + '">' + val.user + '</a></td>')
                    });
                    if (addresses.length <= 9) {
                        $('.paginateContainer').hide();
                    } else {
                        $('.paginateContainer').show();
                    }
                    pagination(addresses.length);
                }
            }
        })
    }
    function pagination(num) {
        $('table').paginate({
            'elemsPerPage': 9,
            'maxButtons': Math.ceil(num / 9 +1)
        });
    }
});