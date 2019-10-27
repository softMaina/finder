<template>
	<div>
		<form v-on:submit.prevent>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div class="row no-gutters">
						<div class="col-md-3">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="mdi mdi-map-marker-multiple"></i>
								</div>
								<input
									class="form-control"
									placeholder="Enter Location"
									type="text"
									v-model="form.location"
								/>
							</div>
						</div>
						<div class="col-md-2">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="mdi mdi-google-maps"></i>
								</div>
								<select2 v-model="form.size" :placeholder="'Shop size'">
									<option disabled value="0">Select one</option>
									<option v-for="(size, index) in shopSizes" :key="index" :value="size.id">{{ size.size }}</option>
								</select2>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="mdi mdi-map-marker-multiple"></i>
								</div>
								<input class="form-control" placeholder="Enter Price" type="text" v-model="form.price" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="mdi mdi-security-home"></i>
								</div>
								<select2 v-model="form.type" :placeholder="'Select a property type'">
									<option disabled value="0">Select one</option>
									<option
										v-for="(item, index) in propertyTypes"
										:key="index"
										:value="item.id"
									>{{ item.title }}</option>
								</select2>
							</div>
						</div>
						<div class="col-sm-1">
							<button
								type="submit"
								class="btn btn-secondary btn-block no-radius font-weight-bold"
								v-on:click.prevent="sendData"
							>SEARCH</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	name: 'SearchComponent',

	components: {},

	props: {
		shopSizes: {
			type: Array,
			required: true
		},

		propertyTypes: {
			type: Array,
			required: true
		}
	},

	data: function() {
		return {
			form: {
				location: '',
				size: '',
				price: '',
				type: ''
			}
		}
	},

	created: function() {},

	mounted: function() {},

	methods: {
		sendData: function() {
			this.$eventBus.$emit('send-data', this.form)
		}
	}
}
</script>
