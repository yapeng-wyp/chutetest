jQuery(function($){

	// pagination / filtering
	$('body').on('wcpt_after_every_load', '.wcpt', function(){
		var $this__wcpt = $(this);

		$('.wcpt-yith-ywraq', $this__wcpt).each(function(){
			set_status( $(this) );
		})
	})

	// toggle default / added state
	function set_status( $button ){
		console.log('running status');
		var id = 0,
				$row = $button.closest('.wcpt-row'),
				product_type = $row.attr('data-wcpt-type');

		if( product_type == 'variable' ){
			id = $row.data('wcpt_variation_id');

		}else if( product_type == 'variation' ){
			id = $row.attr('data-wcpt-variation-id');				

		}else{
			id = $row.attr('data-wcpt-product-id');				
		}


		if( -1 !== $.inArray( id + "", window.wcpt_ywraq_ids ) ){
			$button.addClass('wcpt-yith-ywraq--added');
			$button.removeClass('wcpt-yith-ywraq--default');
		}else{
			$button.addClass('wcpt-yith-ywraq--default');				
			$button.removeClass('wcpt-yith-ywraq--added');				
		}
	}

	// @TODO
	// -- When added / removed, update window.wcpt_ywraq_ids
	// -- when added / removed / run set_status($button) on all buttons

	// reflect remove
	$('body').on('click', '.yith-ywraq-item-remove', function(){
		var $this = $(this),
				product_id = $this.attr('data-product_id'), // could be variation
				$button = $('.wcpt-yith-ywraq');

		$button.each(function(){
			var $this = $(this),
					$row = $this.closest('.wcpt-row'),
					variations_attr = $this.attr('data-variation'), 
					variations =  variations_attr ? $.map( variations_attr.split(","), $.trim ) : [];

			if( variations ){
				var index = $.inArray( product_id, variations );

				if( index !== -1 ){
					variations.splice(index, 1);
				}

				variations.join(',');
				$this.attr('data-variation', variations);
			}

			if( 
				$row.attr('data-wcpt-product-id') == product_id ||
				$row.attr('data-wcpt-variation-id') == product_id
			){
				$this.removeClass('wcpt-yith-ywraq--added');
				$this.addClass('wcpt-yith-ywraq--default');
			}

			// the variation removed from quote is the one selected in this row
			if( 
				$row.hasClass('wcpt-product-type-variable') &&
				$row.data('wcpt_variation_id') &&
				$row.data('wcpt_complete_match') &&
				$row.data('wcpt_variation_id') == product_id
			){
				$this.removeClass('wcpt-yith-ywraq--added');
				$this.addClass('wcpt-yith-ywraq--default');
			}

		})

		// -- update wcpt_ywraq_ids
		var index = wcpt_ywraq_ids.indexOf( product_id );
		if( product_id > -1 ){
			wcpt_ywraq_ids.splice( index, 1 );
		}

	})

	// click added

	$('body').on('click', '.wcpt-yith-ywraq--added', function(){
		window.location = wcpt_ywraq_url;		
	})

	// change button class based on - is variation in quote?

	$('body').on('select_variation', '.wcpt-row', function(){

		var $row = $(this),
				variation_id = $row.data('wcpt_variation_id'),
				complete_match = $row.data('wcpt_complete_match'),
				$ywraq = $('.wcpt-yith-ywraq', $row),
				variations_attr = $ywraq.attr('data-variation'), 
				variations =  variations_attr ? $.map( variations_attr.split(","), $.trim ) : [];

		if( ! complete_match ){
			return false;

		}

		if( $.inArray( variation_id, variations ) == -1 ){
			$ywraq.removeClass('wcpt-yith-ywraq--added');
			$ywraq.addClass('wcpt-yith-ywraq--default');
		}else{
			$ywraq.addClass('wcpt-yith-ywraq--added');
			$ywraq.removeClass('wcpt-yith-ywraq--default');
		}

	})

	// prevent link redirect
	$('body').on('click', '.wcpt-yith-ywraq__content--default', function(e){
		e.preventDefault();
	})


	// add to quote
  $('body').on('click', '.wcpt-yith-ywraq', function(){
    var $this = $(this),
				$row = $this.closest('.wcpt-row');
				
		if( $this.hasClass('wcpt-yith-ywraq--added') ){
			return;
		}

		$this = $row.find('.wcpt-yith-ywraq');

		// check if disabled / out of stock
		if( $this.hasClass('wcpt-out-of-stock') ){
			return;

		}else if( $this.hasClass('wcpt-out-of-stock--variation') ){
			window.alert( ywraq_frontend.i18n_out_of_stock );
			return;

    }

    var $qty = $row.find('.qty, .wcpt-qty-select'),
        qty = $qty.val() ? $qty.val() : $qty.attr('min');

    var data = {
      // product
      product_id: $row.attr('data-wcpt-product-id'),
      quantity: qty,

      // yith
      context: 'frontend',
      ywraq_action: 'add_item',
      'yith-add-to-cart': 12,

      // wp
      wp_nonce: $this.attr('data-wp_nonce'),
		};

		// variable
		if( $row.hasClass('wcpt-product-type-variable') ){
			var variation_id = $row.data('wcpt_variation_id'),
			variation_available = $row.data('wcpt_variation_available');

			if( 
				variation_id &&
				variation_available
			){
				data.variation_id = variation_id;
				var attributes = $row.data('wcpt_attributes');				
				$.extend( data, attributes );				

			}else if( 
				variation_id &&
				! variation_available 
			){
				window.alert( ywraq_frontend.i18n_out_of_stock );
				return;

			}else{
				window.alert( ywraq_frontend.i18n_choose_a_variation );
				return;

			}

		}

		// variation
		if( $row.hasClass('wcpt-product-type-variation') ){
			var variation_id = $row.attr('data-wcpt-variation-id'),
					attributes = JSON.parse($row.attr('data-wcpt-variation-attributes'));

			data.variation_id = variation_id;					
			$.extend( data, attributes );
		}

		// update wcpt_ywraq_ids
		if( data.variation_id ){
			wcpt_ywraq_ids.push( data.variation_id );
		}else{
			wcpt_ywraq_ids.push( data.product_id );			
		}

		$this.addClass('wcpt-yith-ywraq--adding');
		$this.removeClass('wcpt-yith-ywraq--default');

    var success = function(response){

			$this.removeClass('wcpt-yith-ywraq--adding');

			if ( -1 !== $.inArray( response.result, ['true', 'exists'] ) ){

				$this.addClass('wcpt-yith-ywraq--added');
				$this.removeClass('wcpt-yith-ywraq--default');

				if (ywraq_frontend.go_to_the_list == 'yes') {
					window.location.href = response.rqa_url;

				} else {
					$this.removeClass('wcpt-yith-ywraq--default');

					$('.wcpt-yith-ywraq').attr('data-variation', response.variations);

					$(document).find('.widget_ywraq_list_quote, .widget_ywraq_mini_list_quote').ywraq_refresh_widget();
				}

				$(document).trigger('yith_wwraq_added_successfully', [response]);

			} else if (response.result == 'false') {
				alert(response.message);
				$(document).trigger('yith_wwraq_error_while_adding');

			}

    }

    var url = ywraq_frontend.ajaxurl.replace("%%endpoint%%", "yith_ywraq_action");

    $.post(url, data, success);
    
  })

})