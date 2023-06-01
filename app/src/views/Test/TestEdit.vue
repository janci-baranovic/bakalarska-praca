<template>
	<test-create-form
		:test="test"
		:errors="errors"
		@test-form-submitted="updateTest">
	</test-create-form>
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
			id: this.$route.params.id,
			test: {},
			errors: [],
			toast: null,
		}
	},

	mounted() {
		axios.get('/api/tests/' + this.id).then(response => {
			this.test = response.data;
		})

		this.toast = useToast();
	},

	methods: {
		updateTest(data) {
			axios.put('/api/tests/' + this.id, data).then(response => {
				if (response.status === 201) {
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
			this.toast.success("Test bol úspešne upravený", {
				timeout: 3000,
				position: "top-center",
			});
		}
	}
}
</script>

<style scoped>

</style>