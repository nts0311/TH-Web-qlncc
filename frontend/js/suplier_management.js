var supplierData = []
var supplierTable = document.getElementById("suppliersTable")//$("#suppliersTable")
var form = $("#supplierModalForm")
$("#alert-info").hide()
$("#alert-error").hide()
var formElement = {
    'name': form.find('input[name="name"]').val(""),
    'category': form.find('input[name="category"]').val(""),
    'phone': form.find('input[name="phone"]').val(""),
    'email': form.find('input[name="email"]').val(""),
    'address': form.find('input[name="address"]').val("")
}

//lay danh sach câc nha cung cap sau khi load trang
$(document).ready(function () {
    $.ajax({
        type: 'POST',
        url: '../backend/controller/SuppliersController.php',
        data: {
            func: 'get_suppliers'
        },
        success: function (respnose) {
            console.log(respnose)
            if (respnose['error']) {
                alert(respnose["msg"])
            }
            else {
                supplierData = respnose
                loadSupplierData()
            }
        }
    })
});

$("#add_btn").click(function () {
    $("#suplierModalLabel").text("Thêm nhà cung cấp")
    $('#supplierModal').modal('show')

    formElement['name'].val("")
    formElement['category'].val("")
    formElement['phone'].val("")
    formElement['email'].val("")
    formElement['address'].val("")

    $("#modalSubmitBtn").click(function () {
        var url = form.attr('action')
        

        var supplier = {}
        supplier["name"] = formElement['name'].val()
        supplier["category"] = formElement['category'].val()
        supplier["email"] = formElement['email'].val()
        supplier["phone"] = formElement['phone'].val()
        supplier["address"] = formElement['address'].val()


        $.ajax({
            type: 'POST',
            url: url,
            data: {
                name: supplier["name"],
                category: supplier["category"],
                email: supplier["email"],
                phone: supplier["phone"],
                address: supplier["address"],
                func: 'create_supplier'
            },
            success: function (response) {
                console.log(response)

                $('#supplierModal').modal('hide')

                if (response['error']) {
                    //hien thong bao
                    $("#alert-error-text").text(response['msg'])
                    $("#alert-error").show()
                    setTimeout(function () {
                        $("#alert-error").hide()
                    }, 3000)
                }
                else {
                    //them nha cung cap thanh cong
                    supplier['id'] = response['supplierId']

                    //hien thong bao
                    $("#alert-info-text").text(response['msg'])
                    $("#alert-info").show()
                    setTimeout(function () {
                        $("#alert-info").hide()
                    }, 3000)

                    //them vao bang
                    supplierData.push(supplier)

                    var numRow = 1
                    if (supplierTable.rows) numRow = supplierTable.rows.length

                    insertSupplier(numRow, supplier)

                    console.log('numrow ' + numRow)
                    numRow++;

                    supplierTable.rows[numRow - 1].cells[6].childNodes[0].onclick = function () {
                        var row = this.parentNode.parentNode
                        onEditSuppplierClick(row.rowIndex - 1)
                    }

                    supplierTable.rows[numRow - 1].cells[7].childNodes[0].onclick = function () {
                        var row = this.parentNode.parentNode
                        onDeleteSupplierClick(row.rowIndex - 1)
                    }
                }
            }
        })
    })
})

function loadSupplierData() {
    var rowIndex = 1
    supplierData.forEach(sup => {
        var supplier = supplierData[rowIndex - 1]
        insertSupplier(rowIndex, supplier)
        rowIndex++
    })

    //bat su kien nut sua
    var editBtns = document.getElementsByClassName("btn-edit-supplier")
    for (var i = 0; i < editBtns.length; i++) {
        editBtns[i].onclick = function () {
            var row = this.parentNode.parentNode
            onEditSuppplierClick(row.rowIndex - 1)
        }
    }

    //bat su kien nut xoa
    var delBtns = document.getElementsByClassName("btn-delete-supplier")
    for (var i = 0; i < delBtns.length; i++) {
        delBtns[i].onclick = function () {
            var row = this.parentNode.parentNode
            var index = row.rowIndex - 1

            onDeleteSupplierClick(index, supplierData[index]['id'])
        }
    }

    console.log('done load supp to table')
}

function insertSupplier(index, supplier) {
    var row = supplierTable.insertRow(index)
    var numCell = row.insertCell(0)
    var nameCell = row.insertCell(1)
    var cateCell = row.insertCell(2)
    var phonell = row.insertCell(3)
    var emailCell = row.insertCell(4)
    var addressCell = row.insertCell(5)
    var editCell = row.insertCell(6)
    var delCell = row.insertCell(7)

    numCell.innerHTML = index
    nameCell.innerHTML = supplier["name"]
    cateCell.innerHTML = supplier["category"]
    phonell.innerHTML = supplier["phone"]
    emailCell.innerHTML = "<span class=\"badge badge-primary\">" + supplier["email"] + "</span>"
    addressCell.innerHTML = supplier["address"]
    editCell.innerHTML = "<button type=\"button\" class=\"btn btn-primary btn-edit-supplier\">Sửa</button>"
    delCell.innerHTML = "<button type='button' class='btn btn-danger btn-delete-supplier'>Xóa</button>"
}

function onEditSuppplierClick(index) {
    $('#supplierModal').modal('show')
    $("#suplierModalLabel").text("Sửa nhà cung cấp")
    $("#modalSubmitBtn").text("Xong")

    var supplier = supplierData[index]

    formElement['name'].val(supplier["name"])
    formElement['category'].val(supplier["category"])
    formElement['phone'].val(supplier["phone"])
    formElement['email'].val(supplier["email"])
    formElement['address'].val(supplier["address"])

    document.getElementById("modalSubmitBtn").onclick = function () {
        supplier["name"] = formElement['name'].val()
        supplier["category"] = formElement['category'].val()
        supplier["phone"] = formElement['phone'].val()
        supplier["email"] = formElement['email'].val()
        supplier["address"] = formElement['address'].val()

        //call api

        $.ajax({
            type: 'POST',
            url: '../backend/controller/SuppliersController.php',
            data: {
                id: supplier["id"],
                name: supplier["name"],
                category: supplier["category"],
                email: supplier["email"],
                phone: supplier["phone"],
                address: supplier["address"],
                func: 'update_supplier'
            },
            success: function (respnose) {
                $('#supplierModal').modal('hide')

                if (respnose['error']) {
                    showErrorAlert(respnose['msg'])
                }
                else {
                    //sua thanh cong
                    supplierTable.rows[index + 1].cells[1].innerHTML = supplier["name"]
                    supplierTable.rows[index + 1].cells[2].innerHTML = supplier["category"]
                    supplierTable.rows[index + 1].cells[3].innerHTML = supplier["phone"]
                    supplierTable.rows[index + 1].cells[4].innerHTML = supplier["email"]
                    supplierTable.rows[index + 1].cells[5].innerHTML = supplier["address"]
                    showInforAlert(respnose['msg'])
                }
            }
        })
    }
}

function showInforAlert(str) {
    $("#alert-info-text").text(str)
    $("#alert-info").show()
    setTimeout(function () {
        $("#alert-info").hide()
    }, 3000)
}

function showErrorAlert(str) {
    $("#alert-error-text").text(str)
    $("#alert-error").show()
    setTimeout(function () {
        $("#alert-error").hide()
    }, 3000)
}

function onDeleteSupplierClick(index, supplierId) {

    console.log(supplierId)

    //call api
    $.ajax({
        type: 'POST',
        url: '../backend/controller/SuppliersController.php',
        data: {
            func: 'delete_supplier',
            supplierId: supplierId
        },
        success: function (respnose) {
            if (respnose['error']) {
                showErrorAlert(respnose['msg'])
            }
            else {
                supplierTable.deleteRow(index + 1)
                supplierData.splice(index, 1)
                showInforAlert(respnose['msg'])
            }
        }
    })
}

$("#logout-btn").click(function()
{
    $.ajax({
        type: 'POST',
        url: '../backend/controller/UserController.php',
        data: {
            func: 'logout_user'
        },
        success: function (respnose) {
            window.location.replace("login.html");
        }
    })
})