<?php $user = $this->getdata_model->get_user($order['user_id']); ?>
<div class="body-container">
	<div class="all-pages-container">
		<h1>Order <?php echo $order['id']; ?></h1>
		<br>
		<div class="table-responsive">
			<table class="order table table-bordered table-striped">
				<tbody>
					<tr>
						<td class="order-right">Order ID</td>
						<td><?php echo $order['id']; ?></td>
					</tr>
					<tr>
						<td class="order-right">PayPal Transaction ID</td>
						<td><?php echo $order['transaction_id']; ?></td>
					</tr>
					<tr>
						<td class="order-right">PayPal Payer ID</td>
						<td><?php echo $order['payer_id']; ?></td>
					</tr>
					<tr>
						<td class="order-right">Order Date</td>
						<td><?php echo $order['created_at']; ?> UTC</td>
					</tr>
					<tr>
						<td class="order-right">Total</td>
						<td><?php echo $order['currency_symbol'].number_format($order['amount'],2); ?></td>
					</tr>
					<tr>
						<td class="order-right">Fee</td>
						<td><?php echo $order['currency_symbol'].number_format($order['fee'],2); ?></td>
					</tr>
					<tr>
						<td class="order-right">Net</td>
						<td><?php echo $order['currency_symbol'].number_format($order['amount'] - $order['fee'],2); ?></td>
					</tr>
					<tr>
						<td class="order-right">Description</td>
						<td><?php echo $order['description']; ?></td>
					</tr>
					<tr>
						<td class="order-right">Buyer</td>
						<td><a href="<?php echo base_url('admin/users/'.$order['user_id'].'/edit'); ?>"><?php echo $user['email']; ?></a></td>
					</tr>
					<tr>
						<?php if($order['credits'] != ''){ ?>
							<td class="order-right">Credits Purchased</td>
							<td><?php echo $order['credits']; ?></td>
						<?php }elseif($order['listing_id'] != ''){ ?>
							<td class="order-right">Listing ID</td>
							<td><a href="<?php echo base_url('admin/listings/'.$order['listing_id'].'/edit'); ?>"><?php echo $order['listing_id']; ?></a></td>
						<?php } ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>