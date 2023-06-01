<template>
	<section class="section">
		<div class="columns">
			<div class="column is-4 is-offset-4">
				<div class="box">
					<div class="field">
						<label class="label">Meno</label>
						<div class="control">
							<input v-model="userData.name" class="input" type="text">
						</div>
						<p v-if="errors.name" class="help has-text-danger">{{ this.errors.name[0] }}</p>
					</div>

					<div class="field">
						<label class="label">Email</label>
						<div class="control">
							<input v-model="userData.email" class="input" type="email">
						</div>
						<p v-if="errors.email" class="help has-text-danger">{{ this.errors.email[0] }}</p>
					</div>

					<div class="field">
						<label class="label">Heslo</label>
						<div class="control">
							<input v-model="userData.password" class="input" type="password">
						</div>
						<p v-if="errors.password" class="help has-text-danger">{{ this.errors.password[0] }}</p>
					</div>

					<div class="field">
						<label class="label">Potvrď heso</label>
						<div class="control">
							<input v-model="userData.password_confirmation" class="input" type="password">
						</div>
					</div>

					<div class="field">
						<p class="control">
							<button @click="register(this.userData)" class="button is-success is-fullwidth">
								<strong>Zaregistrovať</strong>
							</button>
						</p>
					</div>
				</div>

			</div>
		</div>
	</section>

</template>

<script>
import {mapActions, mapState} from "pinia";
import {useAuthStore} from "../../stores/auth.js";
export default {
	data() {
		return {
			userData: {
				name: '',
				email: '',
				password: '',
				password_confirmation: ''
			}
		}
	},

	computed: {
		...mapState(useAuthStore, {errors: "authErrors"})
	},

	methods: {
		...mapActions(useAuthStore, {register: "handleRegistration"})
	}
}
</script>

<style lang="scss" scoped>

</style>
