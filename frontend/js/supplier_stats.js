var statTable = document.getElementById("statTable")
var max = -1

$.ajax({
    type: 'POST',
    url: '../backend/controller/StaticticsController.php',
    data: {
        func: 'get_suppliers_stat'
    },
    success: function (respnose) {
        console.log(respnose)


        respnose.forEach(stat => {
            if (max < parseInt(stat["totalIncome"]))
                max = parseInt(stat["totalIncome"])
        })

        var rowIndex = 1
        respnose.forEach(stat => {
            console.log(stat)
            insertStat(rowIndex, stat)
            rowIndex++
        })
    }
})

function insertStat(index, stat) {
    var row = statTable.insertRow(index + 1)
    var numCell = row.insertCell(0)
    var nameCell = row.insertCell(1)
    var cateCell = row.insertCell(2)
    var phonell = row.insertCell(3)
    var emailCell = row.insertCell(4)
    var addressCell = row.insertCell(5)
    var editCell = row.insertCell(6)
    var delCell = row.insertCell(7)

    numCell.innerHTML = index
    nameCell.innerHTML = stat["name"]
    cateCell.innerHTML = stat["category"]

    var percent = parseFloat(stat["totalIncome"]) / max * 100
    console.log(parseInt(percent).toString())

    phonell.innerHTML = '<progress class="progress progress-custom" value="' + parseInt(percent).toString() + '" max="100"></progress><h5>' + parseInt(stat["totalIncome"]).toLocaleString(); +'</h5>'


    emailCell.innerHTML = stat["sp1"]
    addressCell.innerHTML = stat["sp2"]
    editCell.innerHTML = stat["sp3"]
    delCell.innerHTML = stat["sp4"]
}