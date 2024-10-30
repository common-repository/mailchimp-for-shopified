
jQuery( document ).ready(function() {

	//alert(mcsf_pluginDirUrl);

	var checkbox_html = "";

	jQuery.getJSON( mcsf_pluginDirUrl + "include/checkbox.php", function( json ) {

	    checkbox_html = json.html;
	    jQuery( "#order_form .terms" ).append( checkbox_html );
	    start_newsletter_listen();
	    
	});

	
	function start_newsletter_listen(){

		jQuery('#newsletter').change(function() {
		   if(jQuery("#newsletter").is(":checked")) {

		        // subscribe
		      	jQuery.ajax({
				  url: mcsf_pluginDirUrl + "include/ajax.php?newsletter=subscribe",
				  context: document.body
				}).done(function() {
					// done
				});

				return;

		   }

		    // unsubscribe
		   
	   	    jQuery.ajax({
			  url: mcsf_pluginDirUrl + "include/ajax.php?newsletter=unsubscribe",
			  context: document.body
			}).done(function() {
			    // done
			});

		});	

	}



});