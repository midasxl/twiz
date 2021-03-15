$(document).ready(function(){

	// ***************************** log in and log out functions across the site
		
	// submit the form
	$('#login-form').on('submit', function (e) {            
		
		// Get the form.
		var form = $('#login-form');

		// Get the messages div.
		var formMessages = $('#form-messages');
		var logInGood = $('#logInGood');
		
		// Stop the browser from submitting the form.
		e.preventDefault();
		
		// Serialize the form data.
		var formData = $(form).serialize();
		
		$.ajax({
			url: $(form).attr('action'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				if(data[0] == "match"){
					$(logInGood).html("<strong>Retrieving Membership Data</strong><br><img src='img/loading11.gif' alt='loading' />");
					$(logInGood).dialog({
						modal: true,
						draggable: false,
						autoOpen: false,
						closeOnEscape: false,
						dialogClass: "no-close",
						height: 100
					});
					$(logInGood).dialog("open");
					setTimeout(function(){ document.location.href = 'account.php'; }, 3000);
				}else{
					$(formMessages).html(data[0]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
						} ]
					});
					$(formMessages).dialog("open");
				}
			},
			error: function(xhr, desc, err) {
				//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + xhr);
				$(formMessages).html("The system has encountered an error");
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
						$( this ).dialog( "close" );
					} 
					} ]
				});
				$(formMessages).dialog("open");
			}
		}); // end ajax call
				
	});

	$("#logOutButton").click(function(e){
		e.preventDefault();
		$("#logOutDiv").dialog("open");
		setTimeout(function(){
			window.location.href = "logout.php";
		}, 3000);
	});
		
	$("#logOutDiv").dialog({
		modal: true,
		draggable: false,
		autoOpen: false,
		closeOnEscape: false,
		dialogClass: "no-close",
		height: 100
	});

	// ***************************** Contact form
		
    // submit the form
    $('#contact-form').on('submit', function (e) {
		
		// Get the form.
		var form = $('#contact-form');
	
		// Get the messages div.
		var formMessages = $('#form-messages');
		
		// Stop the browser from submitting the form.
		e.preventDefault();
		
		// Serialize the form data.
		var formData = $(form).serialize();
		
		$.ajax({
		  url: $(form).attr('action'),
		  type: 'POST',
		  data: formData,
		  dataType: 'json',
		  success: function(data) {
			  if(data[0] == "match"){
				$(formMessages).html(data[1]);
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							$( this ).dialog( "close" );
							$('form').find("input[type=text], textarea").val("");
							$('.success').show();
						} 
					} ]
				});
				$(formMessages).dialog("open");
			  }else{
				$(formMessages).html(data[0]);
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
					} ]
				});
				$(formMessages).dialog("open");
			  }
		  },
		  error: function(xhr, desc, err) {
				$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
				//$(formMessages).html("The system has encountered an error");
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
					} ]
				});
				$(formMessages).dialog("open");
		  }
		}); // end ajax call

}); // close submit function

// ***************************** delete race sheets from account

	$("#delSheetDiv").dialog({
		modal: true,
		draggable: false,
		autoOpen: false,
		closeOnEscape: false,
		dialogClass: "no-close",
		height: 100
	});
	
  	//function to manually delete user sheets	
  	$(".deleteSheetSet").submit(function(e){	
		e.preventDefault();
		var killForm = $(this);
		var formData = $(killForm).serialize();
		var sheetSet = $(this).attr('id');
		var formMessages = $('#form-messages');
		$("#dialog-confirm").html("You are about to delete the " + sheetSet + " sheet set.  Are you sure?");
				$("#dialog-confirm").dialog({
					autoOpen: false,
					modal: true,
					buttons : {
						"Delete" : function() {
							killSheetSet(formData, formMessages);// call to function below
							$(this).dialog("close");                                
						},
						"Cancel" : function() {
							$(this).dialog("close");
						}
					  }
				});
		$("#dialog-confirm").dialog("open");
	});

  	//function to delete sheet from database (but not the uploads folder!! The folder is cleaned via cron job)
  	function killSheetSet(formData, formMessages){
	$("#delSheetDiv").dialog("open");
	  $.ajax({
		  url: 'user-delete-sheets.php',
		  type: 'POST',
		  data: formData,
		  dataType: 'json',
			  success: function(data) {
				$("#delSheetDiv").dialog("close");
				$("#dialog-confirm").html(data[0]);
				$('#dialog-confirm').dialog('option', 'title', 'Sheet Deletion Confirmation');
				$("#dialog-confirm").dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							location.reload(true);
							$(this).dialog("close");
						} 
					}]
				});
				$("#dialog-confirm").dialog("open");
			},
			  error: function(response, xhr) {
				$("#delSheetDiv").dialog("close");
				  console.log(response);
				  $(formMessages).html(xhr.responseText);
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							$(this).dialog("close");
						} 
					} ]
				});
				$(formMessages).dialog("open");
			  }
		}); // end ajax call
	} // end killSheetSet function

// ***************************** user account update form

	// submit the form
	$('#user-update-form').on('submit', function(e){
		
		// Get the form.
		var form = $('#user-update-form');
	
		// Get the messages div.
		var formMessages = $('#form-messages');
		
		// Stop the browser from submitting the form.
		e.preventDefault();
		
		// Serialize the form data.
		var formData = $(form).serialize();
		
		$.ajax({
			url: $(form).attr('action'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				$(formMessages).html(data[0]);
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function(){ 
							$(this).dialog("close");
						} 
					} ]
				});
				$(formMessages).dialog("open");
				if(data[1] == "match"){
					$("#chg-pwd").hide();
				}
			},
			error: function(xhr, desc, err) {
				//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
				$(formMessages).html("The system has encountered an error");
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
						$( this ).dialog( "close" );
					} 
					} ]
				});
				$(formMessages).dialog("open");
			}
		}); // end ajax call	

	}); // close submit function

// ***************************** lost password form

$('#lost-pass-form').on('submit', function (e) {
		
		// Get the form.
		var form = $('#lost-pass-form');
	
		// Get the messages div.
		var formMessages = $('#form-messages');
		
		// Stop the browser from submitting the form.
		e.preventDefault();
		
		// Serialize the form data.
		var formData = $(form).serialize();
		
		$.ajax({
			url: $(form).attr('action'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				if(data[0] == "match"){
					$(formMessages).html(data[1]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$( this ).dialog( "close" );
							} 
						} ]
					});
					$(formMessages).dialog("open");
				}else{
					$(formMessages).html(data[0]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$( this ).dialog( "close" );
							} 
						} ]
					});
					$(formMessages).dialog("open");
				}
			},
			error: function(xhr, desc, err) {
				//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
				$(formMessages).html("The system has encountered an error");
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
					} ]
				});
				$(formMessages).dialog("open");
			}
		}); // end ajax call

    }); // close submit function

// ***************************** resend activation form

    // submit the form
    $('#resend-activation-form').on('submit', function (e) {

		// Get the form.
		var form = $('#resend-activation-form');
	
		// Get the messages div.
		var formMessages = $('#form-messages');
		
		// Stop the browser from submitting the form.
		e.preventDefault();
		
		// Serialize the form data.
		var formData = $(form).serialize();

		$.ajax({
			url: $(form).attr('action'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				if(data[0] == "match"){
					$(formMessages).html(data[1]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$( this ).dialog( "close" );
							} 
						} ]
					});
					$(formMessages).dialog("open");
				}else{
					$(formMessages).html(data[0]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$( this ).dialog( "close" );
							} 
						} ]
					});
					$(formMessages).dialog("open");
				}
			},
			error: function(xhr, desc, err) {
				//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
				$(formMessages).html("The system has encountered an error");
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
						$( this ).dialog( "close" );
					} 
					} ]
				});
				$(formMessages).dialog("open");
			}
		}); // end ajax call

    }); // close submit function

// ***************************** register form

    // submit the form
    $('#user-register-form').on('submit', function (e) {
		
		// Get the form.
		var form = $('#user-register-form');
	
		// Get the messages div.
		var formMessages = $('#form-messages');
		
		// Stop the browser from submitting the form.
		e.preventDefault();
		
		// Serialize the form data.
		var formData = $(form).serialize();
		
		$.ajax({
			url: $(form).attr('action'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				if(data[0] == "match"){
					$(formMessages).html(data[1]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$( this ).dialog( "close" );
								location.href = "index.php";
							} 
						} ]
					});
					$(formMessages).dialog("open");
				}else{
					$(formMessages).html(data[0]);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$( this ).dialog( "close" );
							} 
						} ]
					});
					$(formMessages).dialog("open");
				}
			},
			error: function(xhr, desc, err) {
				//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
				$(formMessages).html("The system has encountered an error");
				$(formMessages).dialog({
					autoOpen: false,
					modal: true,
					buttons: [ { 
						text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
					} ]
				});
				$(formMessages).dialog("open");
			}
		}); // end ajax call

    }); // close submit function

}); // end jQuery