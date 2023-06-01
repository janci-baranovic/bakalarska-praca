<template>
	<div class="columns">
		<div class="column is-8 is-offset-2 box p-6">
			<div v-for="( question, index ) in this.testData" :key="question.id" class="mb-4">
				<h3 class="mb-2"> {{ index + 1 }}. otázka: <span class="subtitle"> {{ question.question }} </span></h3>
				<p>Správna odpoveď: <strong>{{ question.answer }}</strong> </p>
				<p>Tvoja odpoveď: <span :class="{'has-text-success': question.is_correct === 1, 'has-text-danger': question.is_correct === 0}">{{ question.user_answer }}</span></p>
				<hr v-if="index + 1 !== testData.length">
			</div>
		</div>
	</div>
</template>

<script>
import axios from "axios";

export default {
	data() {
		return {
			testData: []
		}
	},

	mounted() {
		let user = '';
		if (this.$route.params.user) {
			user = '/' + this.$route.params.user;
		}
		axios.get('/api/tests/completed/' + this.$route.params.test + '/' + this.$route.params.attempt + user)
			.then(response => {
				this.testData = response.data;
		})
	}
}
</script>

<style scoped>

</style>