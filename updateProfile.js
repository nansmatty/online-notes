//Ajax call to update username into profile.php and also in database

$("#updateusernameform").submit(function(event){

	//prevent default php processing
	event.preventDefault();

	//collect the user data
	var dataToPost = $(this).serializeArray();

	$.ajax({

		url: "updateusername.php",
		type: "POST",
		data: dataToPost,
		success: function(data){
			if(data == 'true'){

				window.location.reload(data);

			}else {

				$("#updatemessage").html("<div class='alert alert-danger'>There was an error updating the new username in the database</div>");
			}
		},
		//AJAX Call Fails: show Ajax Call Error
		error: function(){
			
			$("#updatemessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
		}
	});
});


//Ajax call to update email into updateemail.php file and also in database
$("#updateemailform").submit(function(event){

	//prevent default php processing
	event.preventDefault();

	//collect the user data
	var dataToPost = $(this).serializeArray();

	$.ajax({

		url: "updateemail.php",
		type: "POST",
		data: dataToPost,
		success: function(data){
			if(data){

				$("#updateEmailmessage").html(data);

			}
		},
		//AJAX Call Fails: show Ajax Call Error
		error: function(){
			
			$("#updateEmailmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
		}
	});
});


//Ajax call to update password into updatepassword.php file and also in database
$("#updatepasswordform").submit(function(event){

	//prevent default php processing
	event.preventDefault();

	//collect the user data
	var dataToPost = $(this).serializeArray();

	$.ajax({

		url: "updatepassword.php",
		type: "POST",
		data: dataToPost,
		success: function(data){
			if(data){

				$("#updatepasswordmessage").html(data);

			}
		},
		//AJAX Call Fails: show Ajax Call Error
		error: function(){
			
			$("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
		}
	});
});

