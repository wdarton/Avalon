<script type="text/javascript">
	function format(person) {
	    let output = 
	    '<table class="table table-sm table-borderless">'+
	        '<tbody><tr class="table-info">';
	        	Object.keys(person['people_notes']).forEach(function(note) {
        			output += '<tr><td class="">'+person['people_notes'][note]['note']+'</td></tr>';
	        	});

	    output += '</tr></tbody>'+
	    '</table>';
	    return output;
	}
	<?php
		$uniqueId = str_replace('-', '', $tableId);
	?>
	$(function () {
	  var table<?= $uniqueId ?> = $("#<?= $tableId ?>").DataTable({
	    'lengthMenu': [[15, 25, 50, -1], [15, 25, 50, 'All']],
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

	});
</script>