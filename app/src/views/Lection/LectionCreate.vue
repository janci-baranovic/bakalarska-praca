<template>
	<div>
		<h1 class="title has-text-centered">Nová lekcia</h1>
		<LectionCreateForm :errors="errors" @lection-form-submitted="addLection"></LectionCreateForm>

	</div>
</template>

<script>
import axios from "axios";
import { useToast } from "vue-toastification";
import LectionCreateForm from "../../components/LectionCreateForm.vue";
export default {
	components: {
		LectionCreateForm
	},

	data() {
		return {
			toast: null,
			errors: []
		}
	},

	mounted() {
		this.toast = useToast();
	},

	methods: {
		addLection(data) {
			axios.post('/api/lections', data).then(response => {
				this.$router.push('/lections');
				this.showToast();

			}).catch(error => {
				if (error.response.status === 422) {
					this.errors = error.response.data.errors
				}
			});
		},

		showToast() {
			this.toast.success("Lekcia bola úspešne vytvorená", {
				timeout: 3000,
				position: "top-center",
			});
		}
	},
}
</script>

<style scoped>

</style>