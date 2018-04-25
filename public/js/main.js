/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('.panel-radius .form-horizontal').on('submit', function(e){
        e.preventDefault();
        $("#result").addClass('hidden');
        $("#result img").prop('src', '');
        $('.alert-wrapper').addClass('hidden');
        $('.alert-wrapper .alert').removeClass('alert-danger').removeClass('alert-success').html('');
        $.ajax({
            url: 'index.php/plot-example',
            method: 'post',
            data: $(this).serializeArray(),
        }).done(function (data) {
            if(data.valid){
                $("#result").removeClass('hidden');
                $("#result img").prop('src', 'plot-images/'+data.image);
            }else{
                $('.alert-wrapper .alert').addClass('alert-danger');
                $('.alert-wrapper .alert').html(data.message);
                $('.btn-wrapper').removeClass('hidden');
                $('.progress-wrapper').addClass('hidden');
                $('.alert-wrapper').removeClass('hidden');
            }
        });
    });
});

