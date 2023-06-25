<?php include('db_connect.php'); ?>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<!-- <div class="col-md-4">
			<form action="" id="manage-category">
				<div class="card">
					<div class="card-header">
						    Category Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" class="form-control" name="name">
							</div>
					</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control" name="description" cols="30" rows="10"></textarea>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div> -->
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Category List</b>
						<span class="">
							<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_category">
								<i class="fa fa-plus"></i> Create Category</button>
						</span>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<colgroup>
								<col width="5%">
								<col width="75%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Information</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$category = $conn->query("SELECT * FROM categories order by name asc");
								while ($row = $category->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p>Name: <b><?php echo $row['name'] ?></b></p>
											<p>Description</p>
											<p class="truncate"><?php echo $row['description'] ?></p>

										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-primary edit_category" data-bs-toggle="modal" data-bs-target="#myModal" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>">Edit</button>
											<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<!-- Modal header -->
						<div class="modal-header">
							<h5 class="modal-title">Edit Category</h5>
						</div>

						<!-- Modal body -->
						<div class="modal-body">
							<form action="" id="manage-category-modal">
								<div class="card">
									<div class="card-body">
										<input type="hidden" name="id">
										<div class="form-group">
											<label class="control-label">Name</label>
											<input type="text" class="form-control" name="name">
										</div>
									</div>
									<div class="card-body">
										<input type="hidden" name="id">
										<div class="form-group">
											<label class="control-label">Description</label>
											<textarea class="form-control" name="description" cols="30" rows="10"></textarea>
										</div>
									</div>
									<div class="card-footer">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-sm btn-primary col-sm-3 offset-md-3" onclick="save()"> Save</button>
												<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category-modal').get(0).reset()"> Cancel</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}
</style>
<script>
	$('#new_category').click(function() {
		uni_modal("New Category", "manage_category.php", 'mid-large');
	});



	$('.delete_category').click(function() {
		_conf("Are you sure to delete this category?", "delete_category", [$(this).attr('data-id')], 'mid-large');
	});

	$('#manage-category').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_category',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully added", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 2) {
					alert_toast("Data successfully updated", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	})
	$(document).ready(function() {
		$('.edit_category').click(function() {
			var id = $(this).data('id');
			var name = $(this).data('name');
			var description = $(this).data('description');

			// Populate modal fields with data
			$('#myModal').find('[name="id"]').val(id);
			$('#myModal').find('[name="name"]').val(name);
			$('#myModal').find('[name="description"]').val(description);

			// Show the modal
			$('#myModal').modal('show');
		});

		function save() {
			var id = $('#myModal').find('[name="id"]').val();
			var name = $('#myModal').find('[name="name"]').val();
			var description = $('#myModal').find('[name="description"]').val();

			// Perform the save operation using AJAX or submit the form
			// ...
		}
	});
	$('.delete_category').click(function() {
		_conf("Are you sure to delete this category?", "delete_category", [$(this).attr('data-id')])
	})

	function delete_category($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_category',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>