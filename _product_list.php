<?php
// echo "my product list.php"
?>
<div id="content">

</div>
<script>
    function getProductList() {
        let innerHTML = "";
        let uri = "http://localhost/Project/api/get_product_list.php";
        $.ajax({
            type: "POST",
            url: uri,
            async: false,
            data: null,
            success: function(response) {
                if (response.result === 1) {
                    for (let i = 0; i < response.datalist.length; i++) {
                        innerHTML = innerHTML + `
                        <div class="card" style="width: 21rem;">
                        <img class="card-img-top" src="` + (response.datalist[i].imgid) + `" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">` + (response.datalist[i].pname) + `</h5>
                                <p class="card-text">SKU: ` + (response.datalist[i].sku) + `</p>
                                <p class="card-text">` + (response.datalist[i].price) + `</p>
                                <a href="#" class="btn btn-danger" onclick='addCart("` + (response.datalist[i].id) + `",1,` + (response.datalist[i].price) + `)' >เพิ่มลงตะกร้า</a>
                            </div>
                        </div>
                        `;
                    }
                } else {
                    console.log(response.message);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
        document.getElementById("content").innerHTML =
            `<div class="row">` +
            innerHTML +
            `</div>`;
    }

    function addCart(id, num, price) {
        let customer_profile = localStorage.getItem("customer_profile");
        customer_profile = JSON.parse(customer_profile);
        console.log(customer_profile.id);
        let customer_id = customer_profile.id;

        let request_data = {
            "customer_id": customer_id,
            "product_id": id,
            "num": num,
            "price": price,
        }
        let uri = "http://localhost/Project/api/set_cart_add.php";

        alert("customer_id " + customer_id + " id: " + id + " num: " + num + " price: " + price);
        $.ajax({
            type: "POST",
            url: uri,
            async: false,
            data: JSON.stringify(request_data),
            success: function(response) {
                console.log(response);
                localStorage.setItem("customer_cart", JSON.stringify(response.datalist));
                window.location.reload();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>