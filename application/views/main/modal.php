<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				 Widget settings form goes here
			</div>
			<div class="modal-footer">
				<button type="button" class="btn blue">Save changes</button>
				<button type="button" class="btn default" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- PopUp  for searching -->
<div id="stack1" class="modal fade" tabindex="-1" data-focus-on="input:first">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">Search</h4>
	</div>
	<form method="get" action="search.php">
		<div class="modal-body">
			
			<div class="form-group">

				<input class="form-control" type="text" data-tabindex="1" placeholder="Search">
			</div>

			<div class="form-group">
				<label for="end_date">Start Date</label>
				<input type="date" name="end_date" id="end_date" class="form-control">

			</div>

			<div class="form-group">
				<label for="start_date">End Date</label>
				<input type="date" name="start_date" id="start_date" class="form-control">

			</div>

			<div class="form-group">
				<input type="checkbox" name="checkbox_title" id="radio_title">
				<label for="radio_title">Subject</label>

				<input type="checkbox" name="checkbox_content" id="radio_content">
				<label for="radio_content">Content</label>
			</div>

			<hr>

			<div>
				<label>Order :</label>
				<select class="form-control input-xlarge" style="direction:ltr !important;">
					<option>Most words</option>
					<option>Date</option>
					<option>A - Z</option>
					<option>Z - A</option>
				
				</select>
			</div>
			<br>
			<br>
			<br>
			<br>
		</div>

		<div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
			<button type="submit" class="btn btn-primary">Search</button>
		</div>
	</form>
</div>
<!-- end of popUp for searching -->

<!-- PopUp for delete  -->
<div id="popd" class="modal fade" tabindex="-1" data-focus-on="input:first">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">Delete ?</h4>
	</div>

	<div class="modal-footer">
		
		<a href="" class="btn btn-primary pull-right">Yes</a>
		<button type="button" data-dismiss="modal" class="btn btn-primary pull-left">No</button>
	</div>
	<!-- </form> -->
</div>