<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-label-delete">Delete</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-3 text-center">
						<i class="fas fa-exclamation-triangle fa-5x text-danger modal-icon"></i>
					</div>
					<div class="col text-center">
						Are you sure you want to delete this?<br>
						This action <strong>cannot be undone</strong>.
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" id="submit-modal-delete">Yes, I want to delete this</button>
			</div>
		</div>
	</div>
</div>