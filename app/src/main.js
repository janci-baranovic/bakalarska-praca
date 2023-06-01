import { createApp, markRaw } from 'vue';
import { createPinia } from "pinia";
import router from './router';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import './axios';
import './style.css';
import App from './App.vue';

const pinia = createPinia();

pinia.use(({ store }) => {
    store.router = markRaw(router);
})

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core';

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

/* import specific icons */
import {faPlus} from "@fortawesome/free-solid-svg-icons";
import {faTrash} from "@fortawesome/free-solid-svg-icons";
import {faUpload} from "@fortawesome/free-solid-svg-icons";
import {faUser} from "@fortawesome/free-solid-svg-icons";
import {faEnvelope} from "@fortawesome/free-solid-svg-icons";
import {faArrowRight} from "@fortawesome/free-solid-svg-icons";
import {faArrowLeft} from "@fortawesome/free-solid-svg-icons";

/* add icons to the library */
library.add(faPlus);
library.add(faTrash);
library.add(faUpload);
library.add(faUser);
library.add(faEnvelope);
library.add(faArrowRight);
library.add(faArrowLeft);

const app = createApp(App);
app.use(pinia);
app.use(router);
app.use(Toast, {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true
});
app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');
