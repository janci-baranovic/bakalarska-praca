<template>
	<div>
		<label class="label">Názov lekcie</label>
		<div class="field is-grouped mb-0">
			<div class="control is-expanded">
				<input class="input" type="text" v-model="title">
			</div>

			<div class="control">
				<div class="file has-name is-link">
					<label class="file-label">
						<input class="file-input" type="file" name="resume" @change="fileSelected">
						<span class="file-cta">
							<span class="file-icon">
								<font-awesome-icon icon="fa-solid fa-upload" />
							</span>
							<span class="file-label">
								Vyberte obrázok
							</span>
						</span>
						<span v-if="file" class="file-name">
					  		{{ this.file.name }}
						</span>
						<span v-else-if="imagePath" class="file-name">
					  		{{ this.imagePath }}
						</span>
					</label>
				</div>
			</div>
		</div>
		<div class="is-flex is-justify-content-space-between">
			<p v-if="errors.title" class="help has-text-danger">{{ this.errors.title[0] }}</p>
			<p v-if="errors.image" class="help has-text-danger">{{ this.errors.image[0] }}</p>
		</div>


		<div class="field mt-4">
			<div class="control content">
				<input id="x" type="hidden" name="content" :value="content">
				<trix-editor input="x" @trix-attachment-add="handleAttachment"></trix-editor>
				<p v-if="errors.content" class="help has-text-danger">{{ this.errors.content[0] }}</p>
			</div>
		</div>

		<div v-for="(video, index) in videos" :key="index" class="video-input">
			<label :for="'video-' + index" class="label">YouTube Video ID:</label>
			<div class="field is-grouped">
				<div class="control is-expanded">
					<input class="input" :id="'video-' + index" :name="'videos[' + index + ']'" :value="video" @input="updateVideo(index, $event.target.value)">
				</div>
				<div class="control">
					<button class="button is-danger is-outlined" @click="removeVideoInput">Odstrániť</button>
				</div>
			</div>
		</div>

		<div class="field is-grouped mt-4">
			<p class="control">
				<button class="button is-primary" @click="addLection">Uložiť</button>
			</p>
			<p class="control">
				<button class="button is-info" @click="addVideoInput">Pridať video</button>
			</p>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import Trix from "trix/dist/trix.esm.js";
export default {
	props: [
		'errors',
		'lection',
	],

	data() {
		return {
			title: '',
			content: '',
			file: null,
			imagePath: '',
			videos: []
		}
	},

	methods: {
		fileSelected(event) {
			this.file = event.target.files[0];
		},

		handleAttachment(event) {
			const file = event.attachment.file;
			const data = new FormData();
			data.append('file', file);

			axios.post('/api/lections/upload', data).then(response => {
				event.attachment.setAttributes({
					url: 'https://bakalarka-production.up.railway.app' + response.data.url,
					href: 'https://bakalarka-production.up.railway.app' + response.data.url,
				});
			}).catch(error => {
				console.log(error);
			});
		},

		addLection() {
			const data = new FormData();
			data.append('title', this.title);
			data.append('content', this.content);
			for (let i = 0; i < this.videos.length; i++) {
				data.append('videos[]', this.videos[i]);
			}

			if (this.file) {
				data.append('image', this.file, this.file.name);
			}

			this.$emit('lection-form-submitted', data);
		},

		addVideoInput() {
			this.videos.push("");
		},

		updateVideo(index, value) {
			this.videos[index] = value;
		},

		removeVideoInput() {
			this.videos.pop();
		}
	},

	watch: {
		lection(lection) {
			this.title = lection.title;
			this.content = lection.content;
			this.imagePath = lection.image;
			this.videos = lection.videos.map(video => video.youtubeVideoId);

			let trix = document.querySelector('trix-editor');
			trix.editor.insertHTML(lection.content);
		}
	},

	mounted() {
		document.addEventListener('trix-change', () => {
			this.content = document.getElementById('x').value;
		})
	}
}
</script>

<style scoped>
	trix-editor {
		min-height: 20em;
	}
</style>