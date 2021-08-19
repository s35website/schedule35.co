$(document).ready(function(){
    var counter = 0;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td class="col-sm-5"><input type="text" class="form-control" name="title_multi[]" placeholder="Title"/></td>';
        cols += '<td class="col-sm-2"><input type="text" class="form-control" name="weight_multi[]" placeholder="Weight"/></td>';
        cols += '<td class="col-sm-2"><input type="text" class="form-control" name="price_multi[]" placeholder="Price"/></td>';
        cols += '<td class="col-sm-2"><input type="text" class="form-control" name="sale_price_multi[]" placeholder="Sale Price"/></td>';

        cols += '<td class="col-sm-1"><i class="fas fa-times-circle ibtnDel"></i></td>';
        newRow.append(cols);
        $("#priceTable").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    $( document ).on( "click", ".tab_price", function () {
        $( "#hdn_product_type" ).val( $( this ).data( 'mode' ) );
    });

});
