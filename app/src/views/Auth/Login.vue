<template>
	<div>
		<section class="section">
			<div class="columns">
				<div class="column is-4 is-offset-4">
					<div class="box">
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
							<p class="control">
								<button @click="login(this.userData)" class="button is-success is-fullwidth">
									<strong>Prihlásiť</strong>
								</button>
							</p>
						</div>
					</div>

				</div>
			</div>
		</section>
	</div>
</template>

<script>
import {useAuthStore} from "../../stores/auth.js";
import {mapActions, mapState} from "pinia";
export default {
	data() {
		return {
			userData: {
				email: '',
				password: ''
			}
		}
	},

	computed: {
		...mapState(useAuthStore, {errors: "authErrors"})
	},

	methods: {
		...mapActions(useAuthStore, {login: "handleLogin"})
	}
}
</script>

<style scoped>

</style>
