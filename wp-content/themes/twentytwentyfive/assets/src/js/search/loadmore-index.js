let currentPage = 1;
$('#load-more').on('click', function () {
    currentPage++; // load *next* page

    $.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        dataType: 'json',
        data: {
            action: 'inforepo_load_more',
            paged: currentPage,
        },
        success: function (res) {
            if (currentPage >= res.max) {
                $('#load-more').hide();
            }
            $('.case-list').append(res.html);
        }
    });
});