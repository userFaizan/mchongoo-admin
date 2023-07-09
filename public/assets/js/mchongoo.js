$(document).ready( function () {
    $('#myTable').DataTable();
} );
$(function() {
    $('.toggle-class').change(function() {
        let account_status = $(this).prop('checked') === true ? 1 : 0;
        let user_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'user/changeStatus',
            data: {'account_status': account_status, 'user_id': user_id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
$(function() {
    $('.toggle-class-1').change(function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let skill_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'skill/changeStatus',
            data: {'status': status, 'skill_id': skill_id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})

$(function() {
    $('.toggle-class-2').change(function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let category_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'category/changeStatus',
            data: {'status': status, 'category_id': category_id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
$(function() {
    $('.toggle-class-3').change(function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let service_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'services/changeRecommendedStatus',
            data: {'recommended': status, 'service_id': service_id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
$(function() {
    $('.toggle-class-4').change(function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let service_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'services/changeTrendingStatus',
            data: {'trending': status, 'service_id': service_id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
$(document).ready(function() {
    // Listen for form submission
    $('#ajax-request').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        let form = $(this);
        let url = form.attr('action');
        let formData = new FormData(form[0]);

        // Submit the form using AJAX
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Redirect to the specified URL
                let redirectUrl = form.data('redirect-url');
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});
