//Ajax Call for the signup form
//Once the form is submtted
$("#signupform").submit(function(event){

	//prevent default php processing
	event.preventDefault();

	//collect the user data
	var dataToPost = $(this).serializeArray();
	//console.log(dataToPost);

	//send them to the signup.php file using AJAX
	$.ajax({

		url: "signup.php",
		type: "POST",
		data: dataToPost,

		//AJAX Call Successful : show error or success message
		success: function(data){
			if(data){
				$("#signupmessage").html(data);
			}
		},

		//AJAX Call Fails: show Ajax Call Error
		error: function(){
			
			$("#signupmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
		}
	});
});


//Ajax Call for the login form
//Once the form is submitted
$("#loginform").submit(function(event){

	//prevent default php processing
	event.preventDefault();

	//collect the user data
	var dataToPost = $(this).serializeArray();
	//console.log(dataToPost);

	//send them to the login.php file using AJAX
	$.ajax({

		url: "login.php",
		type: "POST",
		data: dataToPost,

		//AJAX Call Successful : show error or success message
		success: function(data){
			if(data == "success"){
				
				window.location = "mainpageloggedin.php";

			} else {

				$("#loginmessage").html(data);
			}
		},

		//AJAX Call Fails: show Ajax Call Error
		error: function(){
			
			$("#loginmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
		}
	});
});



//Ajax Call for the forgot password form
//Once the form is submtted

$("#forgotpasswordform").submit(function(event){

	//prevent default php processing
	event.preventDefault();

	//collect the user data
	var dataToPost = $(this).serializeArray();
	//console.log(dataToPost);

	//send them to the forgotPassword.php file using AJAX

	$.ajax({

		url: "forgotPassword.php",
		type: "POST",
		data: dataToPost,

		//AJAX Call Successful : show error or success message
		success: function(data){

			$("#forgotpasswordmessage").html(data);
		},

		//AJAX Call Fails: show Ajax Call Error
		error: function(){
			
			$("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
		}
	});
});
