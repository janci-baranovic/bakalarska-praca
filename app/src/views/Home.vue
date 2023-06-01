<template>
	<div class="my-container">
		<div class="columns">
			<div class="column is-half">
				<div class="is-flex is-flex-direction-column is-align-items-center is-justify-content-center">
					<h1 class="title is-1 has-text-light ">Kontajnerizácia</h1>
					<h2 class="subtitle is-3 has-text-light">Všetko čo potrebuješ vedieť na jednom mieste</h2>
					<router-link :to="{ name: 'Lections' }" class="button is-info is-outlined">
						<strong>Začať s výučbou</strong>
					</router-link>
				</div>
			</div>
		</div>
	</div>

</template>


<style scoped>
	.my-container {
		background: url("../../public/docker-background.jpg") center;
		height: 100vh;
	}
	div {
		height: 100vh;
	}
</style>