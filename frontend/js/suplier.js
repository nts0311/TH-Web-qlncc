var supplierData = [
    {
        "id": 1,
        "name": "Nhà cung cấp 1",
        "category": "Đồ gia dụng",
        "phone": "0123456789",
        "email": "abc@gmail.com",
        "address": "Số 1 Đội Cấn, Ba Đình, Hà Nội"
    },
    {
        "id": 2,
        "name": "Nhà cung cấp 2",
        "category": "Thực phẩm",
        "phone": "0123456789",
        "email": "abc@gmail.com",
        "address": "Số 2 Đội Cấn, Ba Đình, Hà Nội"
    },
    {
        "id": 3,
        "name": "Nhà cung cấp 3",
        "category": "Đồ gia dụng",
        "phone": "0123456789",
        "email": "abc@gmail.com",
        "address": "Số 3 Đội Cấn, Ba Đình, Hà Nội"
    },
    {
        "id": 4,
        "name": "Nhà cung cấp 4",
        "category": "Đồ điện tử",
        "phone": "0123456789",
        "email": "abc@gmail.com",
        "address": "Số 4 Đội Cấn, Ba Đình, Hà Nội"
    },
    {
        "id": 5,
        "name": "Nhà cung cấp 5",
        "category": "Máy tính",
        "phone": "0123456789",
        "email": "abc@gmail.com",
        "address": "Số 5 Đội Cấn, Ba Đình, Hà Nội"
    }
]

var supplierTable = document.getElementById("suppliersTable")


loadSupplierData()
setTableButtonListener()


function setTableButtonListener() {
    var btnAddSupplier = document.getElementById("add_btn")

    btnAddSupplier.onclick = function () {
        $('#supplierModal').modal('show')
        document.getElementById("suplierModalLabel").innerHTML = "Thêm nhà cung cấp"

        document.getElementById("modalSuppName").value = ""
        document.getElementById("modalSuppCate").value = ""
        document.getElementById("modalSuppPhone").value = ""
        document.getElementById("modalSuppEmail").value=""
        document.getElementById("modalSuppAddress").value=""

        document.getElementById("modalSubmitBtn").onclick = function () {
            var supplier = {}
            supplier["name"] = document.getElementById("modalSuppName").value
            supplier["category"] = document.getElementById("modalSuppCate").value
            supplier["phone"] = document.getElementById("modalSuppPhone").value
            supplier["email"] = document.getElementById("modalSuppEmail").value
            supplier["address"] = document.getElementById("modalSuppAddress").value

            supplierData.push(supplier)
            insertSupplier(supplierTable.rows.length, supplier)

            supplierTable.rows[supplierTable.rows.length - 1].cells[6].childNodes[0].onclick = function () {
                var row = this.parentNode.parentNode
                onEditSuppplierClick(row.rowIndex - 1)
            }

            supplierTable.rows[supplierTable.rows.length - 1].cells[7].childNodes[0].onclick = function () {
                var row = this.parentNode.parentNode
                onDeleteSupplierClick(row.rowIndex - 1)
            }

            document.getElementById("modalSuppName").value = ""
            document.getElementById("modalSuppCate").value = ""
            document.getElementById("modalSuppPhone").value = ""
            document.getElementById("modalSuppEmail").value = ""
            document.getElementById("modalSuppAddress").value = ""
            $('#supplierModal').modal('hide')
        }
    }

    var editBtns = document.getElementsByClassName("btn-edit-supplier")
    for (var i = 0; i < editBtns.length; i++) {
        editBtns[i].onclick = function () {
            var row = this.parentNode.parentNode
            onEditSuppplierClick(row.rowIndex - 1)
        }
    }

    var delBtns = document.getElementsByClassName("btn-delete-supplier")
    for (var i = 0; i < delBtns.length; i++) {
        delBtns[i].onclick = function () {
            var row = this.parentNode.parentNode
            onDeleteSupplierClick(row.rowIndex - 1)
        }
    }
}

function onEditSuppplierClick(index) {
    $('#supplierModal').modal('show')
    document.getElementById("suplierModalLabel").innerHTML = "Sửa nhà cung cấp"
    document.getElementById("modalSubmitBtn").innerHTML = "Xong"

    var supplier = supplierData[index]

    document.getElementById("modalSuppName").value = supplier["name"]
    document.getElementById("modalSuppCate").value = supplier["category"]
    document.getElementById("modalSuppPhone").value = supplier["phone"]
    document.getElementById("modalSuppEmail").value = supplier["email"]
    document.getElementById("modalSuppAddress").value = supplier["address"]

    document.getElementById("modalSubmitBtn").onclick = function () {
        supplier["name"] = document.getElementById("modalSuppName").value
        supplier["category"] = document.getElementById("modalSuppCate").value
        supplier["phone"] = document.getElementById("modalSuppPhone").value
        supplier["email"] = document.getElementById("modalSuppEmail").value
        supplier["address"] = document.getElementById("modalSuppAddress").value

        supplierTable.rows[index + 1].cells[1].innerHTML = supplier["name"]
        supplierTable.rows[index + 1].cells[2].innerHTML = supplier["category"]
        supplierTable.rows[index + 1].cells[3].innerHTML = supplier["phone"]
        supplierTable.rows[index + 1].cells[4].innerHTML = supplier["email"]
        supplierTable.rows[index + 1].cells[5].innerHTML = supplier["address"]

        $('#supplierModal').modal('hide')
    }
}

function onDeleteSupplierClick(index) {
    supplierTable.deleteRow(index + 1)
    supplierData.splice(index, 1)
}

function loadSupplierData() {
    var rowIndex = 1
    supplierData.forEach(sup => {
        var supplier = supplierData[rowIndex - 1]
        insertSupplier(rowIndex, supplier)
        rowIndex++
    })
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
    emailCell.innerHTML = "<span class=\"badge badge-info\">" + supplier["email"] + "</span>"
    addressCell.innerHTML = supplier["address"]
    editCell.innerHTML = "<button type=\"button\" class=\"btn btn-primary btn-edit-supplier\">Sửa</button>"
    delCell.innerHTML = "<button type='button' class='btn btn-danger btn-delete-supplier'>Xóa</button>"
}