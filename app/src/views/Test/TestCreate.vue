<template>
	<test-create-form :errors="errors" @test-form-submitted="saveTest"></test-create-form>
</template>

<script>

import axios from "axios";
import TestCreateForm from "../../components/TestCreateForm.vue";
import {useToast} from "vue-toastification";

export default {
	components: {
		TestCreateForm
	},

	data() {
		return {
			errors: [],
			toast: null,
		}
	},

	mounted() {
		this.toast = useToast();
	},

	methods: {
		saveTest(data) {
			axios.post('/api/tests', data).then(response => {
				if (response.status === 200) {
					this.$router.push('/tests');
					this.showToast();
				}
			}).catch(error => {
				if (error.response.status === 422) {
					this.errors = error.response.data.errors
				}
			})
		},

		showToast() {
			this.toast.success("Test bol úspešne vytvorený", {
				timeout: 3000,
				position: "top-center",
			});
		}
	}
}
</script>

<style scoped>

</style>