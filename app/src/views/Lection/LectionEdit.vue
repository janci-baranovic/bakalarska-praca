<template>
	<div>
		<h1 class="title has-text-centered">Edituješ lekciu {{ this.$route.params.id }}</h1>
		<LectionCreateForm :lection="lection" :errors="errors" @lection-form-submitted="updateLection"></LectionCreateForm>

	</div>
</template>

<script>
import axios from "axios";
import LectionCreateForm from "../../components/LectionCreateForm.vue";
import {useToast} from "vue-toastification";

export default {
	components: {
		LectionCreateForm
	},

	data() {
		return {
			lection: {},
			errors: [],
			id: this.$route.params.id,
			toast: null,
		}
	},

	methods: {
		updateLection(data) {
			data.append('_method', 'put');
			axios.post('/api/lections/' + this.id, data, {
				headers: {'Content-Type': 'multipart/form-data'}
			}).then(response => {
				this.$router.push('/lection/' + this.id);
				this.showToast();
			}).catch(error => {
				console.log(error);
				if (error.response.status === 422) {
					this.errors = error.response.data.errors
				}
			});
		},

		showToast() {
			this.toast.success("Lekcia bola úspešne upravená", {
				timeout: 3000,
				position: "top-center",
			});
		}
	},


	mounted() {
		axios.get('/api/lections/' + this.id).then(response => {
			this.lection = response.data.data;
		})

		this.toast = useToast();
	}
}
</script>

<style scoped>

</style>