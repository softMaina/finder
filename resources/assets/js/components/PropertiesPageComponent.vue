<template>
	<div class="container">
		<div class="row" id="shops_row">
			<div v-for="(shop, index) in shopsData.data" :key="index" class="col-lg-4 col-md-4">
				<div class="card card-list">
					<div class="card-img">
						<div
							class="love-badge text-yellow"
							:class="shop.favorited ? `text-danger` : 'text-yellow'"
							v-on:click="favoriteMe(shop)"
						>
							<i class="mdi mdi-heart"></i>
						</div>
						<div class="badge images-badge">
							<i class="mdi mdi-image-filter"></i> 12
						</div>
						<span class="badge badge-primary">{{shop.shop_status.title}}</span>
						<img class="card-img-top" :src="shop.shop_images[0].path" alt="Card image cap" />
					</div>
					<div class="card-body">
						<h2 class="text-primary mb-2 mt-0">
							KShs. {{shop.price}}
							<small>/Per Month</small>
						</h2>
						<h5 class="card-title mb-2">Shop in {{shop.shop_location.location}}</h5>
						<h6 class="card-subtitle mt-1 mb-0 text-muted">
							<i class="mdi mdi-home-map-marker"></i>
							{{shop.name}}
						</h6>
					</div>
					<div class="card-footer">
						<span>
							<i class="mdi mdi-move-resize-variant"></i> Size :
							<strong>{{shop.shop_size.size}}</strong>
						</span>
						<div class="row mt-4">
							<div class="col-md-12 text-center">
								<a class="btn btn-info font-weight-bold btn-lg" :href="`shop/${shop.id}`">View</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-md-12 text-center">
				<button class="btn btn-secondary font-weight-bold btn-lg" type="submit">VIEW ALL</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'PropertiesPageComponent',

	props: {
		shops: {
			type: Object,
			required: true
		},

		isLoggedIn: {
			type: Boolean,
			required: true
		}
	},

	data: function() {
		return {
			shopsData: []
		}
	},

	created: function() {
		this.shopsData = this.shops
		this.$eventBus.$on('send-data', data => {
			this.searchProperty(data)
		})
	},

	methods: {
		searchProperty: function(searchParams) {
			let filters =
				'&location=' +
				searchParams.location +
				'&size=' +
				searchParams.size +
				'&type=' +
				searchParams.type +
				'&price=' +
				searchParams.price

			axios
				.get('/search?' + filters)
				.then(response => {
					this.shopsData = []
					this.shopsData = response.data
				})
				.catch(error => {
					console.log(error)
				})
		},

		favoriteMe: function(shop) {
			if (!this.isLoggedIn) {
				Swal.fire({
					type: 'warning',
					title: 'Ops!',
					text:
						'You must log in to add a shop to your favorites list.',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Login'
				}).then(result => {
					if (result.value) {
						window.location = '/login'
					}
				})
			} else {
				axios
					.post('/shops/favorite/' + shop.id)
					.then(response => {
						this.shopsData = []
						this.shopsData = response.data.shops

						Toast.fire({
							title: 'Success',
							type: 'success',
							text: response.data.message
						})
					})
					.catch(error => {})
			}
		}
	}
}
</script>
