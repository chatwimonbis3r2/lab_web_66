<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>API 180-5</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <h1>เรียกข้อมูลจาก API bis42_get_member</h1>
    <hr>
    <label>เลือกข้อมูล :</label>
    <select id="dataType">
        <option value="redcard">redcard</option>
        <option value="blackcard">blackcard</option>
    </select>
    <h3>รหัสประจำตัว 65342310180-5</h3>
    <h3>ชื่อ ฉัตรวิมล หวังสบาย</h3>
    <h3>กลุ่มเรียน BIS4R2</h3>
    <button type="button" onclick="selectType()">เรียกดูข้อมูล</button>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type=text/javascript>
    function selectType() {
        let dataType;
        dataType = document.getElementById("dataType").value;
        let request_data = {
            "mem_type": dataType,
        }
        console.log(request_data);
        let uri = "http://localhost/Project/api/bis42_get_menber.php";
        $.ajax({
            type: "POST",
            url: uri,
            async: false,
            data: JSON.stringify(request_data),
            success: function(response) {
                if (response.result === 1) {
                    console.log(response.datalist);
                    // for (let i = 0; i < response.datalist.length; i++) {
                    //     console.log(response.datalist[i]);
                    // }
                } else {
                    console.log(response.message);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>