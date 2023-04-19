<?php if (isset($fixedHeader)): ?>
<?= $this->Html->css('https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css') ?>
<?= $this->Html->script('https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js') ?>

<?php endif; ?>

<script type="text/javascript">
	$(function () {
	  $("#<?= $tableId ?>").DataTable({
	  	// 'dom': 'Bfrtip',
	    'lengthMenu': [[15, 30, 50, -1], [15, 30, 50, 'All']],
	    <?php if (isset($pageLength)): ?>
	    	'pageLength': <?= $pageLength ?>,
	    <?php endif; ?>
	    <?php if (isset($sort)): ?>
		    "order": [[ <?= $sort['column'] ?>, "<?= strtolower($sort['direction']) ?>" ]],
	    <?php endif; ?>
	    <?php if (isset($fixedHeader)): ?>
		    "fixedHeader": {
		    	'headerOffset': 45,
		    	'header': true
		    },
	    <?php endif; ?>
	    <?php if (isset($buttons)): ?>
	    	'buttons': [<?= $buttons ?>],
	    <?php endif; ?>
	    <?php if (isset($download)): ?>
	    	'dom': 'lBfrtip',
	        'buttons': [{
	            'extend': 'excel',
	            'text': 'Export to Excel',
	            'title': '<?= $title ?> - <?= date("Y-m-d") ?>',
	            'className': 'btn btn-secondary',
	            'exportOptions': {
	                'columns': ':not(.no-export)',
	            }
	        }],
	    <?php endif; ?>
	  });

	});
</script>

<?php if (isset($download)): ?>
	<script src='https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js'></script>
	<script src='https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
	<script src='https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js'></script>
<?php endif; ?>