$(function () {
	
	$(".del").on("click", function(){					//delete row
	        var id = $(this).attr("name");
	        $.ajax({
	        	url: './delete.php',
	        	type: 'POST',
	        	dataType: 'json',
	        	data: {'row' : id},
	        	
	        	beforeSend: function() {
	        		$(this).prop('disabled', true);
	        	},
	        	success: function(data) {
	        		console.log(typeof(data), data);
	        		if (data == 1) {
	        			console.log('tr #' + id);
	        			$('#' + id).remove();
	        		}else if(data == 0){
	        			alert('Произошла ошибка при удалении строки');
	        		}
	        	}
	        })
	        .done(function() {
	        	console.log("success");
	        })
	        .fail(function() {
	        	console.log("error");
	        })
	        .always(function() {
	        	console.log("complete");
	        });
	        ;
	    });
	

	
	$('td').on('click', '.edit', function() {			//edit row
		console.log('edit')
		attr = $('#' + row_id).html();
		$('.error_mes').text("");
		var row_id = $(this).attr("name");
		$('#make'+row_id).html('<input type="text" class="form-control m-0 " 	name="make" value="'+$('#make'+row_id).text()+'">');
		$('#model'+row_id).html('<input type="text" class="form-control m-0" 	name="model" value="'+$('#model'+row_id).text()+'">');
		$('#year'+row_id).html('<input type="text" class="form-control m-0" 	name="year" value="'+$('#year'+row_id).text()+'">');
		$('#mileage'+row_id).html('<input type="text" class="form-control m-0" 	name="mileage" value="'+$('#mileage'+row_id).text()+'">');
		$(this).after($('<button>', {
			class: "save btn btn-success mx-2",
			name: row_id,
			text: 'Save'
		}))
		$(this).remove();
	})
	
	$('td').on('click', '.save', function() {			//save edited row 
		console.log('save')
		
		var row_id = $(this).attr("name");
		var sv_btn = $(this);
		var make = $('#make'+row_id+' input').val().trim();
		var model = $('#model'+row_id +' input').val().trim();
		var year = $('#year'+row_id +' input').val().trim();
		var mileage = $('#mileage'+row_id +' input').val().trim();
		
		console.log(make, model , mileage);
		
		if (make == '') {
			$('.error_mes').text("Введите марку");
			return false;
		} else if (model == '') {
			$('.error_mes').text("Введите модель");
			return false;
		} else if (year =='') {
			$('.error_mes').text("Введите год");
			return false;
		} else if (mileage == '' ) {
			$('.error_mes').text("Введите пробег");
			return false;
		}

		$('.error_mes').text("");
		console.log('error_mes')
		
		$.ajax({
			url: './edit.php',
			type: 'POST',
			dataType: 'html',
			data: { 'model': model,
					'make': make,
					'year': year,
					'mileage': mileage,
					'id': row_id
			},

			success: function (data) {
				$(sv_btn).after($('<button>', {
					class: "edit btn btn-success mx-2",
					name: row_id,
					text: 'Edit'
				}))
				$(sv_btn).remove();

				console.log(data);
				if (data == 1) {
					console.log('saved');
					$('#make'+row_id).html(make);
					$('#model'+row_id).html(model)
					$('#year'+row_id).html(year)
					$('#mileage'+row_id).html(mileage)
				}else{
					console.log('not saved');
					$('#' + row_id).html(attr);
					$('.error_mes').text("Не удалось сохранить изменения");
				}
				
			},
			error: function (jqXHR, textStatus, errorThrown) {
				        console.log(jqXHR, textStatus, errorThrown);
				      }
		})
		
		
	})


	$('.btn-add').on('click', function() {					//create add form
		$('.add-mes').text('')
		$(this).attr("disabled", true);
		user_id = $(this).attr('id');
		$('.add-cont').html('<div class="form-group row mb-4 mt-4">\
			<label class="col-md-1 col-form-label">Make:</label>\
			<div class="col-md-4"> <input id="add-make" type="text" name="make" class="form-control" /></div>\
			</div>\
			<div class="form-group row mb-4">\
				<label class="col-md-1 col-form-label">Model:</label>\
				<div class="col-md-4 "><input id="add-model" type="text" name="model" class="form-control"/></div></div>\
			<div class="form-group row mb-4">\
				<label class="col-md-1 col-form-label">Year:</label>\
				<div class="col-md-4 "><input id="add-year" type="text" name="year" class="form-control"/></div></div>\
			<div class="form-group row mb-4">\
				<label class="col-md-1 col-form-label">Mileage:</label>\
			<div class="col-md-4 "><input id="add-mileage" type="text" name="mileage" class="form-control mb-2"/></div></div>\
		<button class="add btn btn-success mx-2">Add</button>\
		<button class="cancel btn btn-success mx-2">Cancel</button>')

	})


	$('.add-cont').on('click', '.add', function() {				// add new row in table
		var make = $('#add-make').val();
		var model = $('#add-model').val();
		var year = $('#add-year').val();
		var mileage = $('#add-mileage').val();
		console.log(make, model, year, mileage);
		$.ajax({
			url: './add.php',
			type: 'POST',
			dataType: 'json',
			data: {'make': make,
					'model': model,
					'year': year,
					'mileage': mileage,
					'user_id': user_id
			},
			success: function(data) {
				console.log(data)
				if (data[0] == 1) {
					console.log('data[0]==1')
					$('.cars').append('<tr id ="'+data[1]+'"><td id="make'+data[1]+'">'+make+'</td><td id="model'+data[1]+'">'+model+'</td>\
							<td id="year'+data[1]+'">'+year+'</td><td id="mileage'+data[1]+'">'+mileage+'</td><td>\
							<button class="edit btn btn-success mx-2" name="'+data[1]+'">Edit</button>\
							<button class="del btn btn-danger mx-2" name="'+data[1]+'">Delete</button></td></tr>');
				}else {
					$('.add-mes').text('Ошибка при добавлении')
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				        console.log(jqXHR, textStatus, errorThrown);
				      }
		})
		
		$('.add-cont').html('')
		$('.btn-add').attr("disabled", false);
		
		
	});
	$('.add-cont').on('click', '.cancel', function() {
		$('.add-mes').text('')
		$('.add-cont').html('')
		$('.btn-add').attr("disabled", false);
	});
})
	