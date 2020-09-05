$(document).ready(function(){

    $('body').on('click', '[data-ajax]', function(e){
        e.preventDefault();
        
        var url = '/app/ajax/'+$(this).data('entity')+'.php';
        var id = $(this).data('id');
        var action = $(this).data('action');
        var $htmlWrapper = $('.cart-header-wrapper');
        
        var data = new FormData();
        data.append('id', id);
        data.append('action', action);
        if($(this).data('tmp') && $(this).data('tmp') != '') {
            $htmlWrapper = $('.cart-page-wrapper');
            data.append('tmp', $(this).data('tmp'));
        }   
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            success: function(output){
                var basket = JSON.parse(output);
                
                var cnt = Object.keys(basket.items).length;
                if(cnt > 0)
                    $('.action-icons .cart .badge').html(cnt);
                else
                    $('.action-icons .cart .badge').html('');

                $htmlWrapper.html(basket.rendered);
            }
        });
    });

    $('body').on('change', '[data-ajax-input]', function(e){
        e.preventDefault();
        
        var url = '/app/ajax/'+$(this).data('entity')+'.php';
        var id = $(this).data('id');
        var action = $(this).data('action');
        var cnt = $(this).val()-$(this).data('default-val');
        var $htmlWrapper = $('.cart-header-wrapper');
        
        var data = new FormData();
        data.append('id', id);
        data.append('action', action);        
        data.append('cnt', cnt);       
        if($(this).data('tmp') && $(this).data('tmp') != '') {
            $htmlWrapper = $('.cart-page-wrapper');
            data.append('tmp', $(this).data('tmp'));
        }   
         
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            success: function(output){
                var basket = JSON.parse(output);
                
                var cnt = Object.keys(basket.items).length;
                if(cnt > 0)
                    $('.action-icons .cart .badge').html(cnt);
                else
                    $('.action-icons .cart .badge').html('');

                $htmlWrapper.html(basket.rendered);
            }
        });
    });

    $('body').on('submit', '#checkoutForm', function(e){
        e.preventDefault();
        
        var url = '/app/ajax/'+$(this).attr('action')+'.php';       
        
        $.ajax({
            type: 'POST',
            url: url,
            processData: false,
            contentType: false,
            success: function(output){
                if(parseInt(output) > 0)
                    window.location.replace('/personal/checkout/?bid='+output);
                else {
                    swal({
                        title: "Error",
                        text: output,
                        type: "error",
                        confirmButtonText: "Understood"
                    });
                }
            }
        });
    });

    $('body').on('change', '.deliveries input', function(e){
        e.preventDefault();
        var $wrapper = $('.cart-page-wrapper');
        
        var url = '/app/ajax/changeDelivery.php';       
        
        var data = new FormData($('#createOrder')[0]);
        data.append('bid', $wrapper.data('bid'));
        data.append('delivery', $(this).val());     
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            success: function(output){
                $wrapper.html(output);
            }
        });
    });

    $('body').on('submit', '#createOrder', function(e){
        e.preventDefault();
        var data = new FormData($(this)[0]);
        var url = '/app/ajax/'+$(this).attr('action')+'.php';       
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            success: function(output){
                if(output > 0)
                    window.location.replace('/personal/checkout/?order_id='+output);
                else
                    console.log(output);
            }
        });
    });

});