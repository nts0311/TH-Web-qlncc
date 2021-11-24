
$("#register_form").submit(function (event) {

    event.preventDefault();

    var form = $(this)
    var url = form.attr('action')

    var username = form.find('input[name="username"]').val()
    var password = form.find('input[name="password"]').val()
    var name = form.find('input[name="name"]').val()
    var email = form.find('input[name="email"]').val()
    var phone = form.find('input[name="phone"]').val()
    var address = form.find('input[name="address"]').val()

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            username: username,
            password: password,
            name: name,
            email: email,
            phone: phone,
            address: address,
            func: 'register_user'
        },
        success: function (response) {
            console.log(response)
            var result = JSON.parse(response)
            console.log(result)
            alert(result["msg"])
        }
    })
})