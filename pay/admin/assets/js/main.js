function auth(){
    let data = $('#auth').serialize();


    $.ajax({
        type: "POST",
        url: '/admin/ajax/auth.php',
        data: data,
        success: function (data) {
            data = JSON.parse(data);
            if(data.SACCES === "Y"){
                console.log(data);
                location.reload();
            } else {
                alert(data.error);
            }


        }
    });

}

function updateRow(id){
    $.ajax({
        type: "POST",
        url: '/admin/ajax/update_row.php',
        data: {id:id},
        success: function (data) {

            $('#element_line_'+id).html(data).removeClass('reload');
        }
    });
}

function showRequzit(id){

    $.ajax({
        type: "POST",
        url: '/admin/ajax/rqauzits.php',
        data: {id:id},
        success: function (data) {
            $('#container_requzit').html(data);

        }
    });

    $('#showRequzit').modal('show');
}

function paymend(id){
    $('#element_line_'+id).addClass('reload');
    $.ajax({
        type: "POST",
        url: '/admin/ajax/paymend.php',
        data: {id:id},
        success: function () {
            updateRow(id);
        }
    });
}

function sendTiket(id){
    $('#element_line_'+id).addClass('reload');
    $.ajax({
        type: "GET",
        url: '/pdf.php',
        data: {id:id},
        success: function () {
            updateRow(id);
        }
    });
}
