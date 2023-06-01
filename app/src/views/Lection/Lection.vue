<template>
	<div>
		<h1 class="title has-text-centered">{{ this.title }}</h1>
		<p class="has-text-centered is-underlined mb-4">{{ this.date }}</p>
		<div class="columns">
			<div class="column is-8 is-offset-2">
				<p v-html="content" class="content is-medium" id="content"></p>
				<h3 v-if="this.videos.length" class="title is-4 mt-6 has-text-centered">Táto lekcia obsahuje aj videoukážky</h3>
				<iframe v-for="video in videos" width="100%" height="420"
						:src="'https://www.youtube.com/embed/' + video.youtubeVideoId" >
				</iframe>
				<div class="field has-addons is-grouped is-flex is-justify-content-space-between mt-6">
					<p class="control" v-if="this.previous">
						<router-link :to="{ name: 'Lection', params: { id: this.previous } }" class="button is-link is-outlined">
							 <span class="icon is-small">
								 <font-awesome-icon icon="fa-solid fa-arrow-left" />
							 </span>
							<span> Predchádzajúca lekcia </span>
						</router-link>
					</p>
					<p class="control" v-if="this.next">
						<router-link :to="{ name: 'Lection', params: { id: this.next } }" class="button is-link is-outlined">
							<span> Nasledujúca lekcia </span>
							<span class="icon is-small">
								<font-awesome-icon icon="fa-solid fa-arrow-right" />
							</span>
						</router-link>
					</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from "axios";
export default {
	data() {
		return {
			id: this.$route.params.id,
			title: '',
			date: '',
			content: '',
			videos: [],
			next: null,
			previous: null
		}
	},

	watch: {
		'$route' () {
			this.id = this.$route.params.id;
			this.getData();
		}
	},

	mounted() {
		this.getData();
	},

	methods: {
		getData() {
			axios.get('/api/lections/' + this.id).then(response => {
				this.title = response.data.data.title;
				this.date = response.data.data.updated_at;
				this.content = response.data.data.content;
				this.videos = response.data.data.videos;
				this.next = response.data.data.next;
				this.previous = response.data.data.previous;
			})
		}
	}
}
</script>

<style scoped>
</style>