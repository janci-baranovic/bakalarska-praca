<template>
	<nav class="navbar is-link" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">

			<a role="button" :class="{ 'is-active': isActive }" @click="isActive = !isActive" class="navbar-burger" aria-label="menu" :aria-expanded="isActive" data-target="navbarBasicExample">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div id="navbarBasicExample" class="navbar-menu" :class="{ 'is-active': isActive }">
			<div class="navbar-start">
				<router-link :to="{ name: 'Home' }" class="navbar-item">
					Home
				</router-link>

				<router-link :to="{ name: 'Lections' }" class="navbar-item">
					Lekcie
				</router-link>

				<router-link :to="{ name: 'Tests' }" class="navbar-item">
					Testy
				</router-link>

			</div>

			<div class="navbar-end">
				<div class="navbar-item">
					<div class="buttons">
						<template v-if="!user">
							<router-link :to="{ name: 'Register' }" class="button">Zaregistrovať</router-link>
							<router-link :to="{ name: 'Login' }" class="button">Prihlásiť</router-link>
						</template>
						<template v-else>
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link"> {{ this.user.name }} </a>

								<div class="navbar-dropdown">
									<router-link :to="{ name: 'Dashboard' }" class="navbar-item">Dashboard</router-link>
									<router-link :to="{ name: 'Profile' }" class="navbar-item">Upraviť profil</router-link>
									<router-link :to="{ name: 'CompletedTests' }" class="navbar-item">Vypracované testy</router-link>
								</div>
							</div>
							<button @click="logout" class="button">Odhlásiť</button>
						</template>
					</div>
				</div>
			</div>
		</div>
	</nav>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useAuthStore} from "../stores/auth.js";

export default {
	data() {
		return {
			isActive: false,
			showNavbar: true
		}
	},

	computed: {
		...mapState(useAuthStore, {user: "authUser"})
	},

	mounted() {
		if (this.user == null) {
			this.getUser();
		}
	},

	methods: {
		...mapActions(useAuthStore, {logout: "handleLogout"}),
		...mapActions(useAuthStore, {getUser: "getUser"})
	},



}
</script>

<style lang="scss" scoped>

</style>
