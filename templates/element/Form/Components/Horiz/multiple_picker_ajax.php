<?php
use Cake\Utility\Inflector;

// Usage:
/**
 * echo $this->Element('Form/Components/Horiz/multiple_picker', [
        'formOptions' => $courses,
        'id' => 'current_course',
        'empty' => true,
        'emptyPlaceholder' => 'Select a course',
        'entity' => $person,
    ]);
 */

echo $this->Html->script('Avalon.select2.min.js',['block' => 'css']);
echo $this->Html->css('Avalon.select2.min.css',['block' => 'css']);
echo $this->Html->css('Avalon.select2-bootstrap.css',['block' => 'css']);


$elementId = $id;

if (!isset($multiple)) {
    $multiple = '';
}

if ($multiple == true) {
    $multiple = 'multiple';
    $elementId = Inflector::pluralize($id);
}

$elementLabel = Inflector::humanize($elementId);

// remove _id for the label if it is there
if (strpos($elementId, '_id') !== false) {
    $elementLabel = Inflector::humanize(str_replace('_id', '', $elementId));
}

$emptyJsSettings = '';

if (isset($empty)) {
    $emptyJsSettings = "
        placeholder: '{$emptyPlaceholder}',
        allowClear: true
    ";
} else {
    $empty = false;
}

if ($empty) {
    echo $this->Form->control($elementId,[
        'options' => $formOptions,
        'label' => $elementLabel,
        'multiple' => $multiple,
        'empty' => true,
        'value' => '',
    ]);

} else {
    echo $this->Form->control($elementId,[
        'options' => $formOptions,
        'label' => $elementLabel,
        'multiple' => $multiple,
    ]);
}

// Replace underscores with dashes to make javascript happy
$jsId = str_replace('_', '-', $elementId);
?>
<script type="text/javascript">
$('#<?= $jsId ?>').select2({
    ajax: {
        url: '/people/name-search/',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
            };
        },
        processResults: function (data) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used
              console.log(data);
            return {
                results: data.items
            };
        },

    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    },
    minimumInputLength: 2,
    placeholder: 'Search for a person',
    templateResult: formatList,
    templateSelection: formatSelection,
    theme: "bootstrap",
    width: '100%'
});

function formatList (data) {
    return data.label;
}

function formatSelection (data) {
    return data.label;
}

</script>