<?php
if (!isset($footer)) {
    $footer = true;
}
?>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-drag">
                <h5 class="modal-title" id="modal-label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
            <?php if ($footer) : ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submit-modal">Submit</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    // $('#modal').children().draggable({
    $('#modal').children().draggable({
        handle: '#modal-drag',
    });

    $('#modal-drag').css('cursor', 'all-scroll');

    $('#modal').on('hidden.bs.modal', function (e) {
      $('.modal-dialog').removeAttr('style');
    });
});

</script>