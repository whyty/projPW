/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('.gnuplot .form-horizontal').on('submit', function(e){
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

    $('.api [name="request"]').change(function(){
        $(".api .btn-wrapper").addClass('hidden');
        $(".api #generic, .api #custom, .api #example-id, .api #employee-id").addClass('hidden');
        $(".api #generic-actions, .api #custom-actions, .api #example-id, .api #employee-id").val('');
        if ($(this).val()) {
            var id = $(this).val();
            $(".api #" + id).removeClass('hidden');
        }
    });

    $('.api [name="custom_actions"]').change(function(){
        $('.api #generic-actions').val('');
        $(".api #example-id").addClass('hidden').val('');
        $(".api #employee-id").addClass('hidden').val('');
        $(".api .btn-wrapper").removeClass('hidden');
        if ($(this).val() && $(this).val() == 'employee') {
            var id = $(this).val();
            $(".api #" + id + "-id").removeClass('hidden');
        }
    });

    $('.api [name="generic_actions"]').change(function(){
        $('.api #custom-actions').val('');
        $(".api #employee-id").addClass('hidden').val('');
        $(".api #example-id").addClass('hidden').val('');
        $(".api .btn-wrapper").removeClass('hidden');
        if ($(this).val() && $(this).val() == 'example') {
            var id = $(this).val();
            $(".api #" + id + "-id").removeClass('hidden');
        }
    });

    $('.api .btn-default').click(function(){
        var app = $('.request').val();
        var generic = $('#generic').val();
        var errorMsg = '';
        var custom = $('#custom').val();
        $("#result").addClass('hidden');
        $('.alert-wrapper').addClass('hidden');
        $('#result').addClass('hidden');
        $('.alert-wrapper .alert').removeClass('alert-danger').removeClass('alert-success').html('');
        var method = generic ? generic : (custom ? custom : '');
        var genericAction = $('#generic-actions').val();
        var customAction = $('#custom-actions').val();
        var action = genericAction ? genericAction : (customAction ? customAction : '');
        var exampleId = $('#example-id').val();
        var employeeId = $('#employee-id').val();
        var id = exampleId ? exampleId : (employeeId ? employeeId : '');
        if (!action) {
            errorMsg = "Please select an action.";
        } else {
            if (action && $.inArray(action, ['example', 'employee']) != -1  && !id) {
                errorMsg = 'Please select an id for chosen action.';
            }
        }
        if(errorMsg) {
            $('.alert-wrapper .alert').addClass('alert-danger');
            $('.alert-wrapper .alert').html(errorMsg);
            $('.btn-wrapper').removeClass('hidden');
            $('.progress-wrapper').addClass('hidden');
            $('.alert-wrapper').removeClass('hidden');
        } else {
            var baseUrl = '/project/public/index.php/api/',
                url = id ? baseUrl + action + '/' + id : baseUrl + action;
            $.ajax({
                url: url,
                method: 'get',
            }).done(function (result) {
                if (result.error) {
                    $('.alert-wrapper .alert').addClass('alert-danger');
                    $('.alert-wrapper .alert').html('<pre>'+JSON.stringify(result, undefined, 2)+'</pre>');
                    $('.btn-wrapper').removeClass('hidden');
                    $('.progress-wrapper').addClass('hidden');
                    $('.alert-wrapper').removeClass('hidden');
                } else {
                    $("#result").removeClass('hidden');
                    $("#result").html('<pre>'+JSON.stringify(result, undefined, 2)+'</pre>');
                }
            });
        }
    });
});

