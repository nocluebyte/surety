var loading = false;

function loadMoreInit(page,url, url_parameter) {
    $(document).ready(function() {
        infiniteLoadMore(page,url,url_parameter);
    });

    $('#scrollableDiv').on('scroll', function() {
        var div = $(this);
        // Check if the div is scrolled to the bottom
        if (!loading && div.scrollTop() + div.innerHeight() >= div[0].scrollHeight - 100) {
            page++;
            infiniteLoadMore(page,url,url_parameter);
        }
    });
}

function infiniteLoadMore(page,url,url_parameter) {
    var data = {...url_parameter, page: page};
    loading = true;
    showFullPageLoader();
    $.ajax({
        method: "GET",
        url: url,
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.html) {
                $('.data-row').append(response.html);
                loading = false;
                hideFullPageLoader();
            } else {
                hideFullPageLoader();
                $('#scrollableDiv').off('scroll');
            }
        },
        error: function() {
            loading = false;
            hideFullPageLoader();
        }
    });
}
