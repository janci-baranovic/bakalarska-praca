<template>
	<div>
		<div class="notification is-success">
			<button @click="hide" class="delete"></button>
			{{ this.message }}
		</div>
	</div>
</template>

<script>
export default {
	props: ['message'],

	data() {
		return {
			visible: false
		}
	},

	created() {
		this.show()
	},

	methods: {
		show() {
			this.visible = true;
			setTimeout(() => this.hide(), 3000);
		},

		hide() {
			this.visible = false;
		},

	}
}
</script>

<style lang="scss" scoped>

</style>