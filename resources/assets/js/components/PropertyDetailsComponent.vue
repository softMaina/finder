<template>
	<div>
		<section class="osahan-slider">
			<div class="property-single-title property-single-title-gallery">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-md-8">
							<h1>Shop in {{initialShop.shop_location.address_1}}</h1>
							<h6>
								<i class="mdi mdi-home-map-marker"></i>
								{{ initialShop.shop_location.location }}
							</h6>
						</div>
						<div class="col-lg-4 col-md-4 text-right">
							<h6 class="mt-2">{{ initialShop.shop_status_id == 1 ? 'Available' : 'Taken' }}</h6>
							<h2 class="text-primary">
								Ksh. {{ initialShop.price }}
								<small>/month</small>
							</h2>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-lg-8 col-md-8">
							<p class="mt-1 mb-0">
								<strong>Property ID</strong>
								: {{initialShop.id}} &nbsp;&nbsp;
								<strong>
									Add to
									favorites
								</strong>
								<i class="mdi mdi-heart text-danger"></i>
							</p>
						</div>
						<div class="col-lg-4 col-md-4 text-right">
							<div class="footer-social">
								<span>Share :</span> &nbsp;
								<a class="btn-facebook" href="#">
									<i class="mdi mdi-facebook"></i>
								</a>
								<a class="btn-twitter" href="#">
									<i class="mdi mdi-twitter"></i>
								</a>
								<a class="btn-instagram" href="#">
									<i class="mdi mdi-instagram"></i>
								</a>
								<a class="btn-whatsapp" href="#">
									<i class="mdi mdi-whatsapp"></i>
								</a>
								<a class="btn-messenger" href="#">
									<i class="mdi mdi-facebook-messenger"></i>
								</a>
								<a class="btn-google" href="#">
									<i class="mdi mdi-google"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="sectio-padding">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-8">
						<div class="card">
							<div class="card-body osahan-slider pl-0 pr-0 pt-0 pb-0">
								<img class="card-img-top" :src="initialShop.shop_images[0].path" alt="Card image cap" />
							</div>
						</div>
						<div class="card padding-card">
							<div class="card-body">
								<h5 class="card-title mb-3">Description</h5>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<div class="list-icon">
											<i class="mdi mdi-move-resize-variant"></i>
											<strong>Size:</strong>
											<p class="mb-0">{{ initialShop.shop_size.size}}</p>
										</div>
									</div>
								</div>

								<p>{{initialShop.description}}</p>
							</div>
						</div>

						<div class="card padding-card" v-if="initialShop.available">
							<div class="card-body">
								<h5 class="card-title mb-4">Would you like to take {{ initialShop.name }}?</h5>
								<form action name="sendMessage" method="POST">
									<div class="row">
										<div class="control-group form-group col-lg-4 col-md-4">
											<div class="controls">
												<button
													type="submit"
													class="btn btn-primary btn-lg"
												>{{ initialShop.visited ? 'Pay for Shop' : 'Request a visit to ' + initialShop.name }}</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-4">
						<div class="card sidebar-card">
							<div class="card-body">
								<h5 class="card-title mb-4">Featured Shops</h5>
								<div id="featured-properties" class="carousel slide" data-ride="carousel">
									<ol class="carousel-indicators">
										<li
											v-for="(featured_shop, index) in featured"
											:key="index"
											data-target="#featured-properties"
											:data-slide-to="index"
											:class="index == 0 ? 'active' : ''"
										></li>
									</ol>
									<div class="carousel-inner">
										<div
											v-for="(featured_shop, index) in featured"
											:key="index"
											:class="index ==0?'carousel-item active':'carousel-item'"
										>
											<div class="card card-list">
												<a :href="`/shop/${featured_shop.id}`">
													<div class="card-img">
														<div class="love-badge text-danger">
															<i class="mdi mdi-heart-outline"></i>
														</div>
														<div class="badge images-badge">
															<i class="mdi mdi-image-filter"></i> 5
														</div>
														<span v-if="featured_shop.available" class="badge badge-success">Available</span>
														<span v-else class="badge badge-info">Taken</span>
														<img
															class="card-img-top"
															:src="featured_shop.shop_images[0].path"
															alt="Card image cap"
														/>
													</div>
													<div class="card-body">
														<h2 class="text-primary mb-2 mt-0">
															Kshs.{{featured_shop.price}}
															<small>/month</small>
														</h2>
														<h5 class="card-title mb-2">{{featured_shop.shop_location.address_1}}</h5>
														<h6 class="card-subtitle mt-1 mb-0 text-muted">
															<i class="mdi mdi-home-map-marker"></i>
															{{featured_shop.shop_location.location}}
														</h6>
													</div>
													<div class="card-footer">
														<span>
															<i class="mdi mdi-move-resize-variant"></i> Size :
															<strong>{{featured_shop.shop_size.size}}</strong>
														</span>
													</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
export default {
	name: 'PropertyDetailsComponent',

	props: {
		initialShop: {
			type: Object,
			required: true
		},

		featured: {
			type: Array,
			required: true
		}
	},

	data: function() {
		return {
			shop: {}
		}
	}
}
</script>
