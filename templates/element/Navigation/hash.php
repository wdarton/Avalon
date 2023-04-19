<script type="text/javascript">
	$('[role="tab"]').click(function() {
	    top.location.hash = $(this).attr("href");
	});

	$(function() {
	    var hash = top.location.hash;
	    var defaultTab = '<?= $default ?>';

	    if (hash != '') {
	        $(hash).addClass('active show');
	        $('a[href="'+hash+'"]').addClass('active show');
	    } else {
	        $('#'+defaultTab).addClass('active show');
	        $('a[href="#'+defaultTab+'"]').addClass('active show');
	    }

	});
</script>