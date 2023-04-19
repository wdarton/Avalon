<?php

// When including this element, attach onclick="openDateRangeModal();" to what you want to trigger this modal with

if (!isset($title)) {
    $title = '';
}
if (!isset($draggable)) {
    $draggable = false;
}
if (!isset($allowEnterSubmit)) {
    $allowEnterSubmit = false;
}


?>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-drag">
                <h5 class="modal-title" id="modal-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <p class="text-center">
                    <small><em id="prompt-exact">Select the exact dates you wish to pull data for.</em></small>
                    <small><em id="prompt-monthly" hidden="">Select any day in the month that you want to pull data for.</em></small>
                </p>
                <?php
                    echo $this->Form->control('start_date');
                    echo $this->element('Form/Components/Horiz/date_picker', [
                        'name' => 'start_date',
                    ]);
                    echo $this->Form->control('end_date');
                    echo $this->element('Form/Components/Horiz/date_picker', [
                        'name' => 'end_date',
                    ]);
                ?>
                <div class="row">
                    <label for="range_type" class="col-4">Range Type</label>
                    <div class="col">
                        <?php
                            echo $this->Form->radio('range_type', [
                                ['Exact'],
                                'Month',
                            ], [
                                'value' => 0
                            ]);

                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submit-modal">Submit</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

<?php if ($draggable): ?>
$(function() {
    $('#modal').children().draggable({
        handle: '#modal-drag',
    });

    $('#modal-drag').css('cursor', 'all-scroll');

    $('#modal').on('hidden.bs.modal', function (e) {
      $('.modal-dialog').removeAttr('style');
    });
});
<?php endif; ?>
function openDateRangeModal() {
    $('#modal-label').html(<?= "'".$title."'" ?>);
    $("#modal").modal('show');
}
<?php if (!$allowEnterSubmit): ?>
// Disables the enter key for submitting forms on the modal
$("#modal").on('keypress', 'input', function(args) {
    if (args.keyCode == 13) {
        return false;
    }
});
<?php endif; ?>

$("[name='range_type']").click(function() {
    var rangeType = $("[name='range_type']:checked").val();

    if (rangeType == 1) {
        // Monthly only
        $("[name='end_date']").parent().parent().animate({
            opacity: 0
        },150, function(){
            $("[name='end_date']").parent().parent().prop('hidden', true);
            $('#end-date').val();
        });
        $('#prompt-exact').animate({
            opacity: 0
        },250, function(){
            $('#prompt-exact').prop('hidden', true);
        });
        $('#prompt-monthly').animate({
            opacity: 1
        },250, function(){
            $('#prompt-monthly').prop('hidden', false);
        });

        $('#prompt').html('Select any day in the month that you want to pull data for.');
    } else if (rangeType == 0) {
        // Exact dates
        if ($("[name='end_date']").parent().parent().prop('hidden')) {
            $("[name='end_date']").parent().parent().css('opacity', 0);
            $("[name='end_date']").parent().parent().prop('hidden', false);
            $("[name='end_date']").parent().parent().animate({
                opacity: 1
            }, 150);
        }
        $('#prompt-monthly').animate({
            opacity: 0
        },250, function(){
            $('#prompt-monthly').prop('hidden', true);
        });
        $('#prompt-exact').animate({
            opacity: 1
        },250, function(){
            $('#prompt-exact').prop('hidden', false);
        });

        $('#prompt').html('Select the exact dates you wish to pull data for.');
    }
});

$("#submit-modal").click(function(){
    var rangeType = $("[name='range_type']:checked").val();
    var getParams = '?';
    var startDate = $('#start-date').val().split('/');
    var endDate = $('#end-date').val().split('/');

    // Error checking for empty fields
    if (checkErrors()) {
        getParams += 'y='+startDate[2]+'&m='+startDate[0];

        if (rangeType == 0) {
            // Exact Dates
            getParams += '&d='+startDate[1];
            getParams += '&ey='+endDate[2]+'&em='+endDate[0]+'&ed='+endDate[1];
        }

        window.location.href = window.location.origin+window.location.pathname+getParams;
    }

});

function checkErrors() {
    var success = true; // Assume there are no errors
    var rangeType = $("[name='range_type']:checked").val();

    if ($('#start-date').val() == '') {
        $('#start-date').addClass('is-invalid');
        $('#start-date').parent().append('<div class="invalid-feedback">Please enter a start date</div>');
        success = false;
    }

    if (rangeType == 0) {
        if ($('#end-date').val() == '') {
            $('#end-date').addClass('is-invalid');
            $('#end-date').parent().append('<div class="invalid-feedback">Please enter an end date</div>');
            success = false;
        }
    }

    return success;
}

$('#modal').on('hide.bs.modal', function(e) {
    // Clear any invalid feedback
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});
</script>