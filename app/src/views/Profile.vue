<template>
	<h1 class="title is-4 mb-6 has-text-centered">Osobné informácie</h1>
	<div class="columns">
		<div class="column is-4 is-offset-4 has-text-centered">
			<p>Dátum registrácie: <strong> {{ formatDate }} </strong></p>
			<p class="mb-4">Posledná aktualizácia: <strong> {{ formatDate }} </strong></p>

			<div class="box">
				<div class="field">
					<div class="control has-icons-left">
						<input class="input" type="text" v-model="user.name">
						<span class="icon is-small is-left">
					  	<font-awesome-icon icon="fa-solid fa-user" />
					</span>
					</div>
					<p v-if="errors.name" class="help has-text-danger has-text-left">{{ this.errors.name[0] }}</p>
				</div>

				<div class="field">
					<div class="control has-icons-left">
						<input class="input" type="text" v-model="user.email">
						<span class="icon is-small is-left">
					  	<font-awesome-icon icon="fa-solid fa-envelope" />
					</span>
					</div>
					<p v-if="errors.email" class="help has-text-danger has-text-left">{{ this.errors.email[0] }}</p>
				</div>

				<button @click="updateUser" class="button is-primary is-block mb-4">Uložiť</button>
			</div>


			<router-link :to="{ name: 'CompletedTests' }" class="button is-link is-outlined">Zobraziť vypracované testy</router-link>
		</div>
	</div>
</template>

<script>
import {mapState} from "pinia";
import {useAuthStore} from "../stores/auth.js";
import axios from "axios";
import {useToast} from "vue-toastification";

export default {

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
		updateUser() {
			this.errors = [];
			axios.put('/api/users/' + this.user.id, {
				'name' : this.user.name,
				'email': this.user.email
			}).then(response => {
				this.showToast();
			}).catch(error => {
				if (error.response.status === 422) {
					this.errors = error.response.data.errors
				}
			});
		},

		showToast() {
			this.toast.success("Profilové údaje boli upravené", {
				timeout: 3000,
				position: "top-center",
			});
		},
	},

	computed: {
		...mapState(useAuthStore, {user: "authUser"}),

		formatDate() {
			const options = { year: 'numeric', month: 'long', day: 'numeric' }
			return new Date(this.user.created_at).toLocaleDateString('sk-SK', options);
		}
	},
}
</script>

<style scoped>

</style>