<template>
	<div class="box px-6">
		<div class="field">
			<label class="label">Názov testu</label>
			<div class="control">
				<input v-model="testTitle" class="input" type="text" placeholder="napr. Základy nástroja Docker">
			</div>
			<p v-if="errors.title" class="help has-text-danger">{{ this.errors.title[0] }}</p>
		</div>

		<section v-for="(question, index) in questions" :key="index">
			<h2 class="title is-4 mt-6">Otázka {{ index + 1}}</h2>
			<div class="columns">
				<div class="column is-2">
					<label class="label">Typ otázky</label>
					<div class="select">
						<select v-model="question.type" @change="updateQuestionType(index)">
							<option value="text">Text</option>
							<option value="multipleChoices">Viac možností</option>
						</select>
					</div>
				</div>

				<div class="column">
					<div class="field">
						<div class="control">
							<label class="label">Text otázky</label>
							<input v-model="question.text" class="input" type="text">
						</div>
						<p v-if="errors.text" class="help has-text-danger">{{ this.errors.text[0] }}</p>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="control">
					<label class="label">Správna odpoveď</label>
					<input v-model="question.answer" class="input" type="text">
				</div>
				<p v-if="errors.questions" class="help has-text-danger">{{ this.errors.questions[0] }}</p>
				<p v-else-if="errors.answer" class="help has-text-danger">{{ this.errors.answer[0] }}</p>
				<p v-else-if="errors.choices" class="help has-text-danger">{{ this.errors.choices[0] }}</p>
			</div>

			<template v-if="question.type === 'multipleChoices'">
				<ul>
					<li v-for="(choice, index) in question.choices" :key="index">
						<div class="is-flex is-align-items-center my-2">
							<p class="mr-2">{{ index + 1 }}.</p>
							<input v-model="choice.text" class="input is-small">
						</div>
					</li>
				</ul>

				<button class="button is-info is-small mt-4 mr-2" @click="addChoice(question)">
					<span class="icon">
						<font-awesome-icon icon="fa-solid fa-plus" />
					</span>
					<span>Pridať možnosť</span>
				</button>

				<button class="button is-danger is-small is-outlined mt-4" @click="removeChoice(question)">
					<span class="icon">
						<font-awesome-icon icon="fa-solid fa-trash" />
					</span>
					<span>Odobrať možnosť</span>
				</button>
			</template>
		</section>

		<div class="field is-grouped is-flex is-justify-content-space-between mt-6">

			<div>
				<button class="button is-info mr-2" @click="addQuestion">
				<span class="icon">
					<font-awesome-icon icon="fa-solid fa-plus" />
				</span>
					<span>Pridať otázku</span>
				</button>

				<button class="button is-danger is-outlined" @click="removeQuestion">
				<span class="icon">
					<font-awesome-icon icon="fa-solid fa-trash" />
				</span>
					<span>Odobrať otázku</span>
				</button>
			</div>

			<button class="button is-success" @click="saveTest">
				<strong>Uložiť test</strong>
			</button>
		</div>

	</div>
</template>

<script>
import axios from "axios";
import {mapState} from "pinia";
import {useAuthStore} from "../stores/auth.js";

export default {
	props: [
		'test',
		'errors'
	],

	data() {
		return {
			testTitle: '',
			questions: [
				{
					text: '',
					type: 'text',
					answer: '',
					choices: []
				}
			]
		}
	},

	computed: {
		...mapState(useAuthStore, {user: "authUser"})
	},

	watch: {
		test(test) {
			this.testTitle = test.title;
			this.questions = test.questions;
		}
	},

	methods: {
		addQuestion() {
			this.questions.push({text: '', type: 'text', answer: '',  choices: []});
			console.log(this.user);
		},

		updateQuestionType(index) {
			const question = this.questions[index];
			if (question.type === 'multipleChoices' && !question.choices) {
				question['choices'] = [{text: ''}];
			} else if (question.type !== 'multipleChoices' && question.choices) {
				question['choices'] = [];
			}
		},

		removeQuestion() {
			this.questions.pop();
		},

		addChoice(question) {
			question.choices.push({text: ''});
		},

		removeChoice(question) {
			question.choices.pop();
		},

		saveTest() {
			this.$emit('test-form-submitted', {title: this.testTitle, questions: this.questions});
		}
	}
}
</script>

<style scoped>

</style>