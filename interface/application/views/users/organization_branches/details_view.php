<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-centered table-bordered data-view-tables">
				<tbody>
					<tr>
						<td>Name</td>
						<td><?php echo $data_list['name'] ?></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><?php echo $data_list['address'] ?></td>
					</tr>
					<tr>
						<td>City</td>
						<td><?php echo $data_list['city'] ?></td>
					</tr>
					<tr>
						<td>State</td>
						<td><?php echo $data_list['state'] ?></td>
					</tr>
					<tr>
						<td>Country</td>
						<td><?php echo $data_list['country'] ?></td>
					</tr>
					<tr>
						<td>Pincode</td>
						<td><?php echo $data_list['pincode'] ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $data_list['email'] ?></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><?php echo $data_list['phone'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>


		<div class="table-responsive">
			<table class="table table-centered table-bordered data-view-tables">
				<tbody>
					<tr>
						<td>Created</td>
						<td>
							<?php echo 'On '.custom_date('d-M-Y h:i A',$data_list['created_at']); ?>
							<?php if($data_list['created_username']!=''){ echo 'By '.ucwords($data_list['created_username']);} ?>
						</td>
					</tr>
					<tr>
						<td>Last updated</td>
						<td>
							<?php if(!empty($data_list['updated_at'])){echo 'On '.custom_date('d-M-Y h:i A',$data_list['updated_at']);}else{ echo '---';} ?>
								
							<?php if($data_list['updated_username']!=''){ echo 'By '.ucwords($data_list['updated_username']);} ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>