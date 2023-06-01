<template>
  	<div>
		<Navbar></Navbar>
		<main :class="$route.meta.hasBackgroundImage ? '' : 'section' ">
			<div :class="$route.meta.hasBackgroundImage ? '' : 'container' ">
				<RouterView></RouterView>
			</div>
		</main>
  	</div>
</template>

<script>

import Navbar from "./components/Navbar.vue"
export default {
	components: {
		Navbar
	},

  	data() {
	  	return {}
	}
}
</script>