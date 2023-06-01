<template>
	<loader v-if="loading"></loader>
	<div class="has-text-centered">
		<h1 v-if="!loading && tests.length" class="title">Testy, ktoré môžeš absolvovať</h1>
		<h1 class="title" v-if="!loading && !tests.length">Zatiaľ pre vás neboli vytvorené žiadne testy</h1>
		<div class="columns">
			<div class="column is-half is-offset-one-quarter">
				<div class="box has-text-left" v-for="test in tests" :key="test.id">
					<test-card :test="test" :user="user" @deleteTest="deleteTest"></test-card>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import Loader from "../../components/Loader.vue";
import TestCard from "../../components/TestCard.vue";
import {mapState} from "pinia";
import {useAuthStore} from "../../stores/auth.js";
import {useToast} from "vue-toastification";
export default {
	components: {
		Loader,
		TestCard,
	},

	data() {
		return {
			tests: [],
			loading: false,
			toast: null,
		}
	},

	mounted() {
		this.loading = true;
		axios.get('/api/tests').then(response => {
			this.tests = response.data;
		}).finally(() => this.loading = false);

		this.toast = useToast();
	},

	methods: {
		deleteTest(id) {
			axios.delete('api/tests/' + id).then(response => {
				this.showToast();
			});

			const index = this.tests.findIndex(test => test.id === id)
			if (index !== -1) {
				this.tests.splice(index, 1)
			}
		},

		showToast() {
			this.toast.warning("Test bol úspešne vymazaný", {
				timeout: 3000,
				position: "top-center",
			});
		},
	},

	computed: {
		...mapState(useAuthStore, {user: "authUser"})
	},
}
</script>

<style lang="scss" scoped>

</style>