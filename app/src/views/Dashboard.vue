<template>
	<div>
		<div class="columns">
			<div class="column is-3 has-background-light pl-6 pt-6">
				<router-link :to="{ name: 'TestCreate' }" class="nav-link is-size-5 is-block is-underlined">
					Pridať test
				</router-link>
				<router-link :to="{ name: 'LectionCreate' }" class="nav-link is-size-5 is-block is-underlined">
					Pridať lekciu
				</router-link>
			</div>
			<div class="column is-9 p-6">
				<nav class="level has-text-left py-4 mb-0">
					<div class="level-item has-text-centered">
						<div>
							<p class="heading">Používateľov</p>
							<p class="title">{{ this.statistics.users }}</p>
						</div>
					</div>
					<div class="level-item has-text-centered">
						<div>
							<p class="heading">Lekcií</p>
							<p class="title">{{ this.statistics.lections }}</p>
						</div>
					</div>
					<div class="level-item has-text-centered">
						<div>
							<p class="heading">Testov</p>
							<p class="title">{{ this.statistics.tests }}</p>
						</div>
					</div>
				</nav>
				<table class="table is-fullwidth is-striped mt-6">
					<thead>
					<th>Id</th>
					<th>Používateľské meno</th>
					<th>Email</th>
					<th>Dátum registrácie</th>
					<th>Akcie</th>
					</thead>
					<tbody>
					<tr v-for="user in users" :key="user.id">
						<td>{{ user.id }}</td>
						<td>{{ user.name }}</td>
						<td>{{ user.email }}</td>
						<td>{{ user.created_at }}</td>
						<td>
							<router-link :to="{ name: 'CompletedTests', params: { user: user.id } }" class="button is-small is-info is-outlined mr-1">Testy</router-link>
							<button @click="isActive=true" class="button is-small is-danger is-outlined">Vymazať</button>
						</td>
						<modal :isActive="isActive" @closeModal="isActive=false" @delete="deleteUser(user.id)"></modal>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import Modal from "../components/Modal.vue";
import {useToast} from "vue-toastification";

export default {
	components: {
		Modal
	},

	data() {
		return {
			users: [],
			statistics: {},
			isActive: false,
			toast: null
		}
	},

	methods: {
		deleteUser(id) {
			axios.delete('api/users/' + id).then(response => {
				this.showToast();
				this.isActive = false;
			});

			const index = this.users.findIndex(user => user.id === id)
			if (index !== -1) {
				this.users.splice(index, 1)
			}
		},

		showToast() {
			this.toast.warning("Test bol úspešne vymazaný", {
				timeout: 3000,
				position: "top-center",
			});
		},
	},

	mounted() {
		axios.get('/api/users').then(response => {
			this.statistics.users = response.data.users;
			delete response.data.users;
			this.statistics.lections = response.data.lections;
			delete response.data.lections;
			this.statistics.tests = response.data.tests;
			delete response.data.tests;
			this.users = Object.keys(response.data).map(key => ({
				id: key,
				...response.data[key]
			}));
		});

		this.toast = useToast();
	}
}
</script>

<style scoped>
	.columns,
	.column {
		min-height: 100vh;
	}
	.nav-link {
		margin-bottom: .7rem;
	}
</style>