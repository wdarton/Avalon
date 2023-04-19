<?php
// When including this element, attach onclick="openDeleteModal(id, controller, labelField="");" to what you want to trigger this modal with

/**
 * $this->Form->postLink(__('<i class="fas fa-trash-alt"></i>'), [
	    'action' => 'delete',
	    $course->id
	],
	[
	    'onClick' => "openDeleteModal(".$course->id.",'".$params["controller"]."','course_name')",

	    'class' => 'btn btn-sm btn-outline-danger',
	    'escape' => false,
	    'title' => 'Delete',
	])
*/
?>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-label-delete"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-3 text-center">
						<i class="fas fa-exclamation-triangle fa-5x text-danger modal-icon"></i>
					</div>
					<div class="col text-center">
						Are you sure you want to delete [<strong><span id="delete-label"></span></strong>]?
						<br><br>
						This may have unintended system-wide consequences and <strong>cannot be undone</strong>.
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" id="submit-modal-delete">Yes, I want to delete this entity</button>
			</div>
		</div>
	</div>
</div>