$(document).ready(function() {

    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('' +
                '</br>' +
                '<tr>' +
                '<td><input type="number"  name="mytext[]" class="form-control" ></td>' +
                '<td><input type="text"  name="mytext[]" class="form-control" ></td>' +
                '<td><input type="text"  name="mytext[]" class="form-control" ></td>' +
                '<td><input type="text"  name="mytext[]" class="form-control" ></td>' +
                '<td><button type="button" id="remove-table" class="btn btn-default btn-sm error-btn"><span class="glyphicon glyphicon-remove-sign"></span> Verwijderen</button></td>' +
                '</tr>'); //add input box

        }
    });

    $(wrapper).on("click","#remove-table", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('tr').remove(); x--;
    })

    var max_fields_hours      = 10; //maximum input boxes allowed
    var wrapper_hours         = $(".input_fields_wrap_hours"); //Fields wrapper
    var add_button_hours      = $(".add_hour_field_button"); //Add button ID

    var z = 1; //initlal text box count

    $(add_button_hours).click(function(e){ //on add input button click
        e.preventDefault();
        if(z < max_fields_hours){ //max input box allowed
            z++; //text box increment
            $(wrapper_hours).append('' +
                '</br>' +
                '<tr>' +
                '<td><input type="text"  name="workers[]" class="form-control" ></td>' +
                '<td><input type="number"  name="myhours[]" class="form-control" value="0"></td>' +
                '<td><input type="number"  name="myhours[]" class="form-control" value="0"></td>' +
                '<td><input type="number"  name="myhours[]" class="form-control" value="0"></td>' +
                '<td><input type="number"  name="myhours[]" class="form-control" value="0"></td>' +
                '<td><input type="number"  name="myhours[]" class="form-control" value="0"></td>' +
                '<td><button type="button" id="remove-table-hours" class="btn btn-default btn-sm error-btn"><span class="glyphicon glyphicon-remove-sign"></span> Verwijderen</button></td>' +
                '</tr>'); //add input box

        }
    });

    $(wrapper_hours).on("click","#remove-table-hours", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('tr').remove(); x--;
    })


    //console.log(window.location.href.indexOf("id"));
    //-------------------------------URL CHECKER-----------------------------------
    if(window.location.href.indexOf("id") == -1) {
        $("#register").prop('disabled', true);
        var toValidate = $('#submitdate, #usersubmit, #week, #radio, #projectnr, #namecustomer, #adres, #city, #activities'),
            valid = false;
        toValidate.keyup(function () {
            if ($(this).val().length > 0) {
                $(this).data('valid', true);
            } else {
                $(this).data('valid', false);
            }
            toValidate.each(function () {
                if ($(this).data('valid') == true) {
                    valid = true;
                } else {
                    valid = false;
                }
            });
            if (valid === true) {
                $("#register").prop('disabled', false);
                $("#validated").css('visibility', 'visible');
                $("#notvalidated").css('visibility', 'hidden');
            } else {
                $("#register").prop('disabled', true);
                $("#validated").css('visibility', 'hidden');
                $("#notvalidated").css('visibility', 'visible');
            }
        });
    }


});