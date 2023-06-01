<template>
	<div>

		<loader v-if="loading"></loader>
		<h2 v-else-if="!data.length" class="subtitle">Zatiaľ si nevypracoval žiaden test :(</h2>

		<template v-else>
			<div class="tabs is-centered">
				<ul>
					<li v-for="test in this.data" :key="data.id" :class="{ 'is-active': activeTitle === test.title }"  @click="setActiveTitle(test.title)">
						<a>{{ test.title }}</a>
					</li>
				</ul>
			</div>

			<table class="table is-fullwidth">
				<thead>
					<th>Pokus</th>
					<th>Úspešnosť</th>
					<th>Čas vypravocania</th>
					<th>Detail</th>
				</thead>
				<tbody>
				<tr v-for="attempt in activeTestAttempts" :key="attempt.id">
					<td>{{ attempt.attempt }}</td>
					<td>{{ attempt.correct }} / {{ attempt.total }}</td>
					<td>{{ attempt.created_at }}</td>
					<td>
						<router-link :to="{ name: 'TestAttempt', params: {
							test: this.activeTitle,
							attempt: attempt.attempt,
							...(!!this.$route.params.user && { user: this.$route.params.user })
						} }" class="button is-primary is-outlined">
							Zobraziť
						</router-link>
					</td>
				</tr>

				</tbody>
			</table>
		</template>
	</div>
</template>

<script>
import axios from "axios";
import Loader from "../../components/Loader.vue";
export default {
	components: {
		Loader
	},

	data() {
		return {
			activeTestId: null,
			data: [],
			activeTitle: '',
			loading: false
		}
	},

	mounted() {
		this.loading = true;
		let user = '';
		if (this.$route.params.user) {
			user = '/' + this.$route.params.user;
		}
		axios.get('/api/completed' + user).then(response => {
			this.data = response.data;
			if (this.data.length > 0) {
				this.activeTitle = this.data[0].title;
				this.activeTestId = this.data[0].id;
			}
		}).finally(() => this.loading = false );
	},

	methods: {
		setActiveTitle(title) {
			this.activeTitle = title;
			this.activeTestId = this.data.find(test => test.title === title).id;
		},
	},

	computed: {
		activeTestAttempts() {
			const activeTest = this.data.find(test => test.id === this.activeTestId);
			if (activeTest) {
				return activeTest.attempts;
			} else {
				return [];
			}
		},
	},

}
</script>

<style scoped>
</style>