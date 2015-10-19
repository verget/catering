$(function() {
    $('#add_to_menu').on('click', function(){
        var items = JSON.stringify($('#menu_items_select select').val());
        var menu = $(this).attr('data-menu');
        $.ajax({
            type:'POST',
            url: '/menu/add-items',
            dataType: 'json',
            data: {items:items, menu:menu},
            success: function() {
                $.pjax.reload({container:'#w1'});
            },
            error: function(){
                alert("Already in menu");
                $.pjax.reload({container:'#w1'});
            }
        });
    });
    
    $('body').on('click', '.del_from_menu', function(){
        var item = $(this).attr('data-item');
        var menu = $('#add_to_menu').attr('data-menu');
        $.ajax({
            type:'POST',
            url: '/menu/delete-item',
            dataType: 'json',
            data: {item:item, menu:menu},
            complete: function() {
                $.pjax.reload({container:'#w1'});
            },
        });
    });
    if ($('#order-order_menu').val()){
        getMenu();
    }
    $('#order-order_menu').on('change', function(){
        getMenu();
    });
    
    
    function getMenu(){
        var id = $('#order-order_menu').val();
        var order_id = $('#save-order-btn').attr('data-order');
        $.ajax({
            type:'POST',
            url: '/menu/get-menu',
            dataType: 'json',
            data: {'id':id, 'order_id':order_id},
            complete: function(data) {      
                $('#order-menu_desc_panel').hide();
                $('#order-items_panel').hide();
                $('#order-items').text('');
                if (!$.isEmptyObject(data.responseJSON.items)){
                    $('#order-items_panel').show();
                    var order_items = data.responseJSON.order_items;
                    $.each(data.responseJSON.items, function($key, $val){
                        var checked = '';
                        if ($key in order_items)
                            checked = "checked";
                        $('#order-items').append("<div class='checkbox'><label> <input type='checkbox' "+checked+" name='Order[order_items][]' value='"+$key+"' class='order-menu-items'>"+$val+"</label></div>");
                    })
                }
                if (data.responseJSON.desc){
                    $('#order-menu_desc_panel').show();
                    $('#menu-desc').text('');
                    $('#menu-desc').append(data.responseJSON.desc);
                }

            },
        });
    }
});