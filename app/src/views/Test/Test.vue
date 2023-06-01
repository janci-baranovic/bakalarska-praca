<template>
	<div class="box">
		<h1 class="title has-text-centered">{{ this.title }}</h1>
		<ul>
			<li v-for="(question, index) in this.questions" :key="question.id" class="mb-5">
				<span class="title is-5 mb-2">{{ index + 1 }}. {{ question.text }}</span>
				<template v-if="question.type === 'text'">
					<div class="field mt-2">
						<div class="control">
							<input class="input is-small" type="text" v-model="answers[question.id]">
						</div>
					</div>
				</template>
				<ul v-else>
					<li v-for="choice in question.choices" :key="choice.id">
						<div class="control">
							<label class="radio">
								<input type="radio" :name="'answer' + question.id" :value="choice.text" v-model="answers[question.id]">
								{{ choice.text }}
							</label>
						</div>
					</li>
				</ul>
			</li>
		</ul>
		<div class="control">
			<button @click="submitTest" class="button is-success">Odoslať</button>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import {useToast} from "vue-toastification";

export default {
	data() {
		return {
			title: '',
			questions: [],
			answers: {},
			toast: null,
		}
	},

	methods: {
		submitTest() {
			axios.post('/api/tests/upload', this.answers).then(response => {
				this.$router.push('/tests/completed');
				this.showToast();
			})
		},

		showToast() {
			this.toast.success("Test bol úspešne odovzdaný", {
				timeout: 3000,
				position: "top-center",
			});
		}
	},

	mounted() {
		axios.get('/api/tests/' + this.$route.params.id).then(response => {
			this.title = response.data.title;
			this.questions = response.data.questions;
			this.answers['testId'] = response.data.id;
			this.questions.forEach(question => this.answers[question.id] = '');
		})

		this.toast = useToast();
	}
}
</script>

<style lang="scss" scoped>

</style>