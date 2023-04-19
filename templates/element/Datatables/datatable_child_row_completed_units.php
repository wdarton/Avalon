<script type="text/javascript">
	function format(person) {
		// var person = JSON.parse(data);
		var output =
		'<table class="table table-sm table-borderless">'+
		    '<thead>'+
		        <?php foreach ($units as $unit) : ?>
		            '<th class="text-center table-info"><small><strong><?= $unit->label ?></strong></small></th>'+
		        <?php endforeach; ?>
		    '</thead>'+
		    '<tbody><tr class="table-info">';
		    	Object.keys(person['completed_units']).forEach(function(unit) {
		    		console.log(person['completed_units'][unit]['completed']);
		    		var status = person['completed_units'][unit]['completed'];

		    		if (status) {
		    			output += '<td class="text-center"><small><i class="fas fa-check text-success"></i> Yes</small></td>';
		    		} else {
		    			output += '<td class="text-center"><small><i class="fas fa-times text-danger"></i> No</small></td>';
		    		}
		    	});

		output += '</tr></tbody>'+
		'</table>';
		console.log(person);
		console.log(person['completed_units']);
		return output;
	}
	<?php
		$uniqueId = str_replace('-', '', $tableId);
	?>
	$(function () {
	  var table<?= $uniqueId ?> = $("#<?= $tableId ?>").DataTable({
	    'lengthMenu': [[15, 25, 50, -1], [15, 25, 50, 'All']],
	    'dom': 'lBfrtip',
        'buttons': [{
            'extend': 'excel',
            'text': 'Export to Excel',
            'title': 'People Missing Units <?= date("Y-m-d") ?>',
            'className': 'btn btn-secondary',
            'exportOptions': {
                'columns': ':not(.no-export)'
            }
        }],
	    <?php if (isset($sort)): ?>
		    "order": [[ <?= $sort['column'] ?>, "<?= strtolower($sort['direction']) ?>" ]],
	    <?php endif; ?>
	  });


	  // Add event listener for opening and closing details
	  $('#<?= $tableId ?>').on('click', 'td.details-control', function () {
	      var tr = $(this).closest('tr');
	      var row = table<?= $uniqueId ?>.row(tr);
	      var td = $(this).closest('td');
	      if (row.child.isShown()) {
	          // This row is already open - close it
	          row.child.hide();
	          tr.removeClass('shown');
	          td.children().removeClass('fas fa-minus-square text-primary');
	          td.children().addClass('far fa-plus-square text-primary');
	      } else {
	          // Open this row
	          row.child(format(tr.data('child-value'))).show();
	          tr.addClass('shown');
	          td.children().removeClass('far fa-plus-square text-primary');
	          td.children().addClass('fas fa-minus-square text-primary');
	      }
	  });
	  	// table<?= $uniqueId ?>.Buttons().container().appendTo('#people-index .col-sm-6:eq(0)');

	});


</script>
<script src='https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js'></script>