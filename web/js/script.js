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
    
    $('body').on('click','.order-menu-items', function(){
        var count = 0;
        $('.order-menu-items').each(function(){
            if($(this).prop('checked'))
                count++;
        });
        var limit = $('#menu-limit').text()*1;
        if (count > limit){
            $('.order-menu-items').prop('checked', false);
        }
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
                $('#menu-limit').text('');
                var items = data.responseJSON.items;
                if (!$.isEmptyObject(items)){
                    $('#order-items_panel').show();
                    var order_items = (data.responseJSON.order_items) ? data.responseJSON.order_items : [];
                    if (!$.isEmptyObject(items.dozen)){
                        $.each(items.dozen, function(key, val){
                            var checked = '';
                            var count = "";
                            if (order_items){
                                if (key in order_items){
                                    checked = "checked";
                                    count = order_items[key];
                                }
                            }
                            
                            $('#order-items').append("<div class='col-sm-8'><div class='row'><div class='col-xs-10'><div class='checkbox'><label> " +
                                    "<input type='checkbox' "+checked+" name='Order[order_items]["+key+"]' value='1' class='order-menu-items'>"+val+"</label></div></div>" +
                                            "<div class='col-xs-2'><input type='text' name='Order[order_items]["+key+"]' placeholder='dozen' value='"+count+"' class='order-addon-num'></div></div></div>");
                        })
                    }
                    if (!$.isEmptyObject(items.person)){
                        $.each(items.person, function(key, val){
                            var checked = '';
                            if (key in order_items)
                                checked = "checked";
                            $('#order-items').append("<div class='col-sm-8'><div class='row'><div class='col-xs-12'><div class='checkbox'><label> " +
                                    "<input type='checkbox' "+checked+" name='Order[order_items]["+key+"]' value='1' class='order-menu-items'>"+val+"</label></div></div></div></div>");
                        })
                    }
                }
                if (data.responseJSON.desc){
                    $('#order-menu_desc_panel').show();
                    $('#menu-desc').text('');
                    $('#menu-desc').append(data.responseJSON.desc);
                }
                if (data.responseJSON.limit){
                    $('#menu-limit').text('');
                    $('#menu-limit').text(data.responseJSON.limit);
                }

            },
        });
    }
});