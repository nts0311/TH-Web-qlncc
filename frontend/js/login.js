$("#login_form").submit(function (event) {

    event.preventDefault();

    var form = $(this)
    var url = form.attr('action')

    var username = form.find('input[name="username"]').val()
    var password = form.find('input[name="password"]').val()

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            username: username,
            password: password,
            func: 'login_user'
        },
        success: function (result) {
            console.log(result)
            var result = JSON.parse(result)

            if (result['error'] == 0) {
                window.location.replace("supplier_management.html");
            }
            else
            {
                alert(result['msg'])
            }
        }
    })
})