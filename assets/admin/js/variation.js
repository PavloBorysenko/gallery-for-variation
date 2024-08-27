"use strict";

document.addEventListener("DOMContentLoaded", function(){
    jQuery( '#woocommerce-product-data' ).on(
	    'woocommerce_variations_loaded',
	    function(e){		
		jQuery(this).find('.gfv-add-items').on('click', function(e){
		    e.preventDefault();
		    e.stopPropagation();
		    let id = jQuery(this).data('id');
		    let loop = jQuery(this).data('loop');
		    gfv_add_gallery_items(id, loop);
		    
		});
		gfv_make_sortable();
		gfv_init_delete();
	    }
    );
});

function gfv_init_delete(){
    jQuery('.gfv_delete_item').off('click');
    jQuery('.gfv_delete_item').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	let  item_list = jQuery(this).parents('li.gfv_item')
	gfv_can_update(item_list);
	item_list.remove();
    });
}

function gfv_add_gallery_items(id, loop) {
    var _this = this;
    let frame;
    if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
    if (frame) {
      frame.open();
      return;
    } 
    frame = wp.media({
      title: gfv_localize.title,
      button: {
	text: gfv_localize.btn
      },        
      library: {
	type: [ 'video', 'image' ]
      }, 
    multiple : true
    });
    frame.on('select', function () {
      var items = frame.state().get('selection').toJSON();
      let product_id = id;
      let item_list = document.querySelector(".gfv-items-list-" + product_id);
      items.map(function (image) {
	//console.log(image)
	let item_id = image.id;
	let src = '';
	if (image.type == 'image') {
	    src = image.sizes.thumbnail.url;
	}else{
	    src = image.thumb.src;
	}

	let templates = document.getElementById("gfv_item_template");
	let html = templates.innerHTML 
	let template = templates.querySelector('li').cloneNode(true);

	let item = html.replaceAll("__SRC__", src)
		.replaceAll('__ITEM_ID__', item_id)
		.replaceAll('__PRODUCT_ID__', product_id)
		.replaceAll('__TYPE__', image.type)
		.replaceAll('__TITLE__', image.title);

	item_list.innerHTML = item_list.innerHTML+ item;
      }).join('');
	gfv_can_update(item_list);
	gfv_init_delete(); 
    }); 
    frame.open();
    }
};
 
function gfv_can_update(select){
    jQuery(select).closest('.woocommerce_variation').addClass('variation-needs-update');
    jQuery('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
    jQuery('#variable_product_options').trigger('woocommerce_variations_input_changed');
}
 
function gfv_make_sortable(){
    jQuery('.gfv-items-list').sortable({
	items: 'li.gfv_item',
	cursor: 'move',
	scrollSensitivity: 40,
	forcePlaceholderSize: true,
	forceHelperSize: false,
	helper: 'clone',
	opacity: 0.65,
	update: function update() {
	  gfv_can_update(this);
	}
    });
}