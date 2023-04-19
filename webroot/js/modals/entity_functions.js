// This handles the storing and updating of data

// Disables the enter key for submitting forms on the modal
$("#modal").on('keypress', 'input', function(args) {
    if (args.keyCode == 13) {
        return false;
    }
});

// Make sure that our default modal is of the smaller size
$('#modal').on('hidden.bs.modal', function (e) {
  $('.modal-dialog').removeClass('modal-lg');
  clearInvalidFields();
});

function editEntity(id, controller, method='') {
	// Switch for deciding if the entity needs a larger modal

	switch(controller) {
		case '/config/branch-offices':
		case '/people/employment':
			$('.modal-dialog').addClass('modal-lg');
			break;
		default:
			break;
	}

	var bodyUrl = controller+'/edit/'+id;

	if (method !== '') {
		bodyUrl = controller+'/'+method+'/'+id;
	}

	$('#modal-body').load(bodyUrl, function() {
		$('#modal-label').html('Edit - ' + $('#label').val());
		$("#modal").modal('show');
	});
}

function openDeleteModal(id, controller, labelField="") {
	$("#modal-delete").modal('show');
	console.log(controller);
	console.log('/'+controller+'/view/'+id);
	// Gets the info about the selected entity
	$.get({
		// url: '/'+controller+'/view/'+id,
		url: '/'+controller+'/view/'+id,
		data: {id: id},
		dataType: 'text',
		success: function(json) {
			var data = JSON.parse(JSON.parse(json));
			console.log(data);
			var label = '';
			if ('label' in data) {
				label = data['label'];
			} else if ('filename' in data) {
				label = data['filename'];
			} else if (labelField == 'full_name') {
				label = data['first_name']+' '+data['last_name'];
			} else if (labelField == 'course_name') {
				label = data['course_year']+' '+data['season'];
			}

			$('#modal-label-delete').html('Delete - ' + label);
			$('#delete-label').html(label);

			$('#submit-modal-delete').attr('onclick', 'deleteEntity("/'+controller+'/delete/'+data['id']+'")');
		}
	});
}

function openDeleteNonCriticalModal(id, controller, customDelete="") {
	$("#modal-delete").modal('show');

	// Gets the info about the selected entity
	$.get({
		url: '/'+controller+'/view/'+id,
		data: {id: id},
		dataType: 'text',
		success: function(json) {
			var data = JSON.parse(json);
			if (customDelete.length) {
				$('#submit-modal-delete').attr('onclick', 'deleteEntity("/'+controller+'/'+customDelete+'/'+data['id']+'")');
			} else {
				$('#submit-modal-delete').attr('onclick', 'deleteEntity("/'+controller+'/delete/'+data['id']+'")');
			}
		}
	});
}

function deleteEntity(url) {
	$.get(
	{
		url: url,
		async: true,
		success: function(data)
		{
			location.reload(false);
		}
	});
}

$("#submit-modal").click(function(){
    clearInvalidFields();
    // console.log(location);
    $.post(
    {
        url: $('#modal-form').prop('action'),
        async: true,
        data: $("#modal-form").serialize(),
        success: function(json)
        {
            var data = JSON.parse(json);
            // console.log(data['errors']);

            if (data['errors']) {
                $.each(data['errors'], function(element, error) {
                    // console.log('item: ' + element);
                    $('#'+element).addClass('is-invalid');
                    $.each(error, function(type, message) {
                        $('#'+element).parent().append('<div class="invalid-feedback">'+message+'</div>');
                        // console.log('message: ' + message);
                    });
                });
            } else {
                location.reload(false);
                $('#modal').modal('hide');
            }
        }
    });

});

function clearInvalidFields() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}