<template>
	<div>
		<div :class="['modal', isActive ? 'is-active' : '']">
			<div class="modal-background"></div>
			<div class="modal-content">
				<div class="box">
					<h2 class="subtitle has-text-centered">Určite chceš vykonať túto akciu?</h2>
					<div class="field is-grouped d-flex is-justify-content-center">
						<p class="control">
							<button @click="this.$emit('delete')" class="button is-danger">Potvrdiť vymazanie</button>
						</p>
						<p class="control">
							<button @click="this.$emit('closeModal')" class="button">Zrušiť</button>
						</p>
					</div>
				</div>
			</div>
			<button @click="this.$emit('closeModal')" class="modal-close is-large" aria-label="close"></button>
		</div>
	</div>
</template>

<script>
export default {
	props: ['isActive'],

}
</script>

<style scoped>

</style>