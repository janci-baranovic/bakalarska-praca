<template>
	<div>
		<h2 class="subtitle mb-1">{{ test.title }}</h2>
		<p class="mb-4">Počet otázok: {{ test.questions_count }}</p>
		<router-link :to="{ name: 'Test', params: { id: test.id } }" class="button is-success is-responsive">Začať test</router-link>
		<router-link :to="{ name: 'TestEdit', params: { id: test.id } }" v-if="user.is_admin" class="button is-info ml-2 is-responsive">Upraviť test</router-link>
		<a @click="isActive=true" v-if="user.is_admin" class="button is-danger is-outlined ml-2 is-responsive">Vymazať test</a>
		<modal :isActive="isActive" @closeModal="isActive=false" @delete="this.$emit('deleteTest', test.id)"></modal>
	</div>
</template>

<script>

import Modal from "./Modal.vue";
export default {
	props: {
		test: Object,
		user: Object,
	},

	components: {
		Modal
	},

	emits: ['handleDelete'],

	data() {
		return {
			isActive: false,
		}
	},

}
</script>

<style scoped>

</style>