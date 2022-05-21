/**
 * @output wp-content/themes/generatepress_child/asset/js/store.js
 */
/* global ajaxurl */
jQuery( document ).ready( function( $ ) {
    var ajaxurl = $('#ajaxurl').val();
    var ajaxurl ='http://chutetest.test/wp-admin/admin-ajax.php';

    $('#reg_password_again').on("blur",function(){
        var psd_again = $('#reg_password_again').val();
        var psd = $('#reg_password').val();
        if(psd !== psd_again){
            $('#error').show();
            $('#error').text("Les deux mots de passe saisis sont incohérents  ") ;
        }else{
            $('#error').hide();
        }
    })

    $('#reg_username').on("blur",function(){
        var nickname = $('#reg_username').val();
//        console.log(ajaxurl);
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'unique-nickname',
                nickname: nickname,
            },
            success: function(res){
                if(res.code== 0 ){
                    alert(res.msg);
                }
//                console.log(res.code);
//                alert(res.msg);
            }
        })
    })
    $('#format').on("click",function(){
//        alert("1111111");
        show_select();
    })

    function show_select() {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action : 'select-format',
            },
            success: function (res){
//                var html = res.msg.replace('"','').replace(/[\\]/g,'');
                $('#format_select').show();
                $('#select-formats').append(res.msg);
                $('#select-formats').on("change",function(){
                    toInput(this);
                })
            }
        })
    }

    function toInput(select){
//        alert(1111111);
//        alert($(select).children('option:selected').text());
        var name = $(select).children('option:selected').text();
        var nameId = $(select).children('option:selected').val();
        $('#format').val(name);
        $('#format-hide').val(nameId);
        $('#format_select').hide();
    }
    $('#search-product').on("click",function(){
        toShop();
    })

    function toShop(){
//        alert(123456);
        var searchNuance = $('#nuance').val();
        var searchFormat = $('#format-hide').val();
        var searchEpaisseur = $('#epaisseur').val();
        var searchDiameter = $('#diameter').val();
        var searchLongueur = $('#longueur').val();
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data:{
                action : 'link-to-shop',
                nuance: searchNuance,
                format: searchFormat,
                epaisseur: searchEpaisseur,
                diameter: searchDiameter,
                longueur: searchLongueur,
            },
            success: function(res) {

                if(res.code==1) {
                    window.open(res.msg,'_self');
                }else if(res.code==0) {
                    alert(res.mag);
                    window.reload();
                }

            }
        })
    }

    $('.certificate-button').each(function(){
        var ccpu_id = $(this).attr('id');
        $('#'+ccpu_id).on('click',function(){
            var certificate= $('#hide_'+ccpu_id).val();
            var ccpuText_id = ccpu_id.replace("add_ccpu_","num_add_ccpu_");
            var pro_id = ccpu_id.replace('add_ccpu_',"");
//            addLine(ccpu_id);
//            var num = $('#'+ccpuText_id).val() + 1;
//            $('#'+ccpuText_id).val(num);
//            disabledSubmit(ccpu_id,ccpuText_id);
//            console.log($('#'+ccpuText_id).val());
//            $('#'+ccpu_id).attr('disabled',true);
            wc_cart_ajax(pro_id,certificate);
        })
    })

    function disabledSubmit(btnId,hideId){
//    console.log($('#'+hideId).val());
//    alert(123456);
        if($('#'+hideId).val() != 1 ){
            $('#'+btnId).attr('disabled',true);
        }
    }

    function addLine(ccpu_id) {
//        alert(ccpu_id);
        var row = $("#"+ccpu_id).closest("tr").index()
        var hide = $('#hide_'+ccpu_id).val();

        if(hide == '' || hide == '0'){
            var price = '3.81';
            var name = 'Certificat de Conformité Quali Chutes @ 3.81 €';
        }else if(hide == 'N/A'){
            var price = '7.62';
            var name = ' CCPU selon disponibilité @ 7.62 €';
        }else{
            var price = '7.62';
            var name = 'CCPU 3.1.B (Certificat de contrôle produit par l\'usine) @ 7.62 €'
        }

        var currency = $('.woocommerce-Price-currencySymbol').eq(0).text();
        var num = row+2;
        var tr = $('#cart-table tr').eq(num);
        var trHtml = '<tr class="woocommerce-cart-form__cart-item cart_item_ccpu" id="ccpu_'+ ccpu_id + '" data-ccpu-price = "'+ price +'"><td><a herf="javascript:void(0);" class="remove" id="del_'+ ccpu_id +'" >×</a></td><td><img alt="certificate image " src="./../wp-content/themes/generatepress_child/asset/images/certificate.png" /></td><td class="product-name" data-title="Product" >'+ name +'</td><td colspan="2" ></td><td class="product-price" data-title="Price" ><span class="woocommerce-Price-amount amount"><bdi>'+ price +'&nbsp;<span class="woocommerce-Price-currencySymbol">'+currency+'</span></bdi></span></td><td>1</td><td <td class="product-subtotal" data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi>'+ price +'&nbsp;<span class="woocommerce-Price-currencySymbol">'+currency+'</span></bdi></span></td></tr>';

        tr.after(trHtml);
        $('#del_'+ccpu_id).on('click',function(){
            delTr($(this).attr('id'));
        })
        var removeCcpu = '';
        ccpu_price_num(removeCcpu);
    }

    function delTr(imageId){
        var trId = imageId.replace("del_","ccpu_");
        var ccpuText_id = imageId.replace("del_add_ccpu_","ccpu_text_");
        var button = imageId.replace("del_","");
        $('#'+ccpuText_id).attr('ccpu-state','0');
        $('#'+trId).remove();
        var removeCcpu = $('#'+trId).attr('data-ccpu-price');
        $('#'+button).removeAttr('disabled');
        ccpu_price_num(removeCcpu);
    }

    function ccpu_price_num(removeCcpu){
        var priceAarr = [];
        var idArr = [];
        $('.cart_item_ccpu').each(function(){
            var price = $(this).attr('data-ccpu-price');
            var ccpuIdVal = $(this).attr('id').replace("ccpu_add_ccpu_","");;
            priceAarr.push(price);
            idArr.push(ccpuIdVal);
        });

        var index = $.inArray(removeCcpu,priceAarr);
        var id_index = $.inArray(removeCcpu,idArr);
        if(id_index>=0)  idArr.splice(id_index, 1);
        if (index >= 0)  priceAarr.splice(index, 1);
//        real_ccpu(priceAarr,idArr);
    }

    function real_ccpu(priceAarr,idArr) {
        var currency = $('.woocommerce-Price-currencySymbol').eq(0).text();
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action : 'sub-ccpu-price',
                price: priceAarr,
                ids: idArr,
            },
            success: function(res){
                var fee = '<span class="woocommerce-Price-amount amount"><bdi>'+res.msg+'&nbsp;<span class="woocommerce-Price-currencySymbol">'+currency+'</span></bdi></span>';
//                $('.fee td').html(fee);
            }
        })
    }

    function wc_cart_ajax(proId,certificate){
//        console.log(proId);
//        console.log(certificate);
        $.ajax({
//            url:'http://chutetest.test/?wc-ajax=wcpt_cart',
            url:ajaxurl,
            type: 'POST',
            dataType: 'json',
            data:{
                action: 'add-customize-field-to-certificate',
                product_id: proId,
                certificate: certificate,
            },
            success: function(res){
                if(res.code == 1){
                    $('#'+proId).attr('disabled',true);
                }
            }
        })
    }

});


