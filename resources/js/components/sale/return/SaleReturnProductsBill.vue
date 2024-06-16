<template>
	<div>
		<div v-for="(sale_return, index) in sale_returns" :key="index">
			<p class="text-center" style="margin-top: 5%">
				{{ sale_return.type_name }} : {{ sale_return.format_date }}
			</p>
			<table style="width: 100%">
				<tbody>
					<tr style="border-bottom: 1px dashed black; border-collapse: collapse" v-for="(product, index) in sale_return.return_products" :key="index">
						<td class="mrp">{{ index + 1 }} .</td>
						<td class="description">
							{{ product.product_name }} X
							{{ product.quantity }}
						</td>
						<td class="price">= {{ product.product_total }}</td>
					</tr>
				</tbody>
			</table>

			<table style="width: 100%; margin-top: 5px" class="not-dashed">
				<tbody>
					<tr>
						<td style="vertical-align: baseline">
							<div style="display: grid"></div>
						</td>
						<td>
							<p>Total</p>
							<p>Vat ({{ sale_return.vat_percentage }}%)</p>
							<p>Discount</p>
							<p>Return</p>
						</td>
						<td>
							<p class="left">{{ sale_return.product_total.toLocaleString() }}</p>
							<p class="left">(+) {{ sale_return.vat_amount.toLocaleString() }}</p>
							<p class="left">
								(-) {{ sale_return.total_discount.toLocaleString() }}
							</p>
							<p class="left">
								{{ sale_return.return_total.toLocaleString() }}
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
export default {
	props: ["sale_returns"],
};
</script>
