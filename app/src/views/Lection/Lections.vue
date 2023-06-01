<template>
	<loader v-if="loading"></loader>
	<h1 class="title has-text-centered" v-if="!loading && !lections.length">Zatiaľ neboli vytvorené žiadne lekcie</h1>
	<div class="columns is-multiline">
		<div class="column is-4" v-for="lection in lections" :key="lection.id">
			<lection-card :lection="lection" @handleDelete="deleteLection" />
		</div>
	</div>
</template>

<script>
import axios from "axios";
import LectionCard from "../../components/LectionCard.vue";
import Loader from "../../components/Loader.vue";
import {useToast} from "vue-toastification";
export default {
	name: "Lections",
	components: {
		LectionCard,
		Loader
	},

	data() {
		return {
			lections: [],
			loading: false,
			toast: null,
		}
	},

	mounted() {
		this.loading = true;
		axios.get('/api/lections').then(response => {
			this.lections = response.data;
		}).finally(() => this.loading = false);

		this.toast = useToast();
	},

	methods: {
		deleteLection(id) {
			axios.delete('api/lections/' + id).then(response => {
				this.showToast();
			});

			const index = this.lections.findIndex(lection => lection.id === id)
			if (index !== -1) {
				this.lections.splice(index, 1)
			}
		},

		showToast() {
			this.toast.warning("Lekcia bola úspešne vymazaná", {
				timeout: 3000,
				position: "top-center",
			});
		},
	}
}
</script>

<style scoped>

</style>