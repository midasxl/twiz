// active-nav.js

$(document).ready(function() {
	"use strict";
	
	$("#navigation li a").each(function() {
		if (this.href === window.location) {
			$(this).parent().prop("class", "active");
		}
	});
	 
	$("#productForm").submit(function(e){
			if($("#twiz-agree").prop('checked') !== true){
				e.preventDefault();
				//alert("You must agree to the Thoroughwiz Terms of Service!");
				$("#dialogDetails").html("You must agree to the Thoroughwiz Terms of Service!");
						$("#dialogDetails").dialog({
							autoOpen: false,
							modal: true,
							buttons: [ { 
								text: "Ok", click: function() { 
								$( this ).dialog( "close" );
							} 
							} ]
						});
						$("#dialogDetails").dialog("open");
			}
	}); 
	
	$("#toggle-chg-pwd").click(function(e){
			e.preventDefault();
			$("#chg-pwd").slideToggle("fast");
	});
		
	$("#cancel-pw").click(function(){
		$("#chg-pwd").hide();
	});
	
});