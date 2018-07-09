$(function() {	
	//define variables
	var activeNote = 0;
	var editmode = false;

	//load notes on page load: Ajax call to loadnotes.php file
	$.ajax({

		url: "loadnotes.php",
		success: function (data) {
			$('#notes').html(data);
			clickOnNote();
			clickOnDelete();
		},
		error: function(){
			$('#alertContent').text("There was an error with the Ajax call. Please try again later!");
			$('#alert').fadeIn();
		}
	});


	//add a new note: Ajax call to createnotes.php file

	$('#addnotes').click(function() {		
		$.ajax({
			url: "createnotes.php",
			success: function(data) {
				if (data == 'error') {
					$('#alertContent').text("There was an issue inserting the new note in the database!");
					$('#alert').fadeIn();
				}else {
					//update activenote to the id of the new note
					activeNote = data;
					$("textarea").val("");

					//show and hide elements
					showHide(["#allnotes","#notepad"], ["#edit","#addnotes","#notes","#done"]);

					$("textarea").focus();
				}
			},
			error: function(){
				$('#alertContent').text("There was an error with the Ajax call. Please try again later!");
				$('#alert').fadeIn();
			}
		});
	})

	//typing a note: Ajax call to updatenote.php file

	$('textarea').keyup(function(){

		//ajax call to update the task of id activeNote
		$.ajax({
			url: "updatenote.php",
			type: "POST",
			//we need to send the current note content with its id to the php file
			data: {
				note: $(this).val(),
				id: activeNote
			},
			success: function (data) {
				if (data == 'error') {

					$('#alertContent').text("There was an issue updating the note in the database");
					$('#alert').fadeIn();
				}
			},
			error: function(){
				$('#alertContent').text("There was an error with the Ajax call. Please try again later!");
				$('#alert').fadeIn();
			} 
		})


	});

	//click on all notes button
	$("#allnotes").click(function(){
		$.ajax({

			url: "loadnotes.php",
			success: function (data) {
				$('#notes').html(data);				
				showHide(["#edit","#addnotes","#notes"], ["#allnotes","#notepad"]);
				clickOnNote();
				clickOnDelete();
			},
			error: function(){
				$('#alertContent').text("There was an error with the Ajax call. Please try again later!");
				$('#alert').fadeIn();
			}
		});

	});
	//click on done after editing: load notes again
	$("#done").click(function(){

		//switch the edit mode
		editmode = false;

		//reducing the width of notes b adding bootstrap row classes
		$(".noteheader").removeClass("col-xs-7 col-sm-9");

		showHide(["#edit"],["#done", ".delete"]);

	});
	//click on edit: go to edit mode(show delete buttons, reducing width of notes,......)

	$("#edit").click(function(){

		//switch the edit mode
		editmode = true;

		//reducing the width of notes b adding bootstrap row classes
		$(".noteheader").addClass("col-xs-7 col-sm-9");

		showHide(["#done", ".delete"],["#edit"]);

	});



	//functions
		//click on a note
		function clickOnNote(){

			$('.noteheader').click(function(){

				if (!editmode) {

					// update the activeNote variable to id of the note 
					activeNote = $(this).attr("id");

					//fill the text area
					$("textarea").val($(this).find('.text').text());

					showHide(["#allnotes","#notepad"], ["#edit","#addnotes","#notes","#done"]);

					$("textarea").focus();
				}

			});
		}

		// click on delete

		function clickOnDelete(){

			$('.delete').click(function(){

				var deleteID = $(this);

				//ajax call to delete the task of id deleteID
				$.ajax({
					url: "deletenotes.php",
					type: "POST",
					//we need to send only id of the note to the php file
					data: {
						id: deleteID.next().attr("id")
					},
					success: function (data) {
						if (data == 'error') {

							$('#alertContent').text("There was an issue deleting the note from the database");
							$('#alert').fadeIn();
						}else {
							
							//removing contaning div
							deleteID.parent().remove();

						}
					},
					error: function(){
						$('#alertContent').text("There was an error with the Ajax call. Please try again later!");
						$('#alert').fadeIn();
					} 
				})
			})

		}

		//show hide function

		function showHide(array1, array2) {
			for (var i = 0; i < array1.length; i++) {
				$(array1[i]).show();
			}
			for (var i = 0; i < array2.length; i++) {
				$(array2[i]).hide();
			}
		}
});