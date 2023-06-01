import {defineStore} from "pinia";
import axios from "axios";
import { useToast } from 'vue-toastification'

const toast = useToast();

export const useAuthStore = defineStore("auth", {
    state: () => {
        return {
            authUser: null,
            authErrors: []
        }
    },

    getters: () => ({
        user: (state) => state.authUser,
        errors: (state) => state.authErrors,
    }),

    actions: {
        getToken() {
            axios.get('/sanctum/csrf-cookie');
        },

        getUser() {
            this.getToken();
            axios.get('/api/user').then(response => {
                this.authUser = response.data;
            }).catch(error => console.log(error));
        },

        handleLogin(userData) {
            this.authErrors = [];
            this.getToken();

            axios.post('/login', userData).then(response => {
                this.getUser();
                this.router.push("/lections");
            }).catch(error => {
                if (error.response.status === 422) {
                    this.authErrors = error.response.data.errors
                }
            });
        },

        handleRegistration(userData) {
            this.authErrors = [];
            this.getToken();
            axios.post('/register', userData).then(response => {
                this.getUser();
                this.router.push("/lections");
                toast.success("Úspešne si sa zaregistroval, príjemné vzdelávanie", {
                    timeout: 3000,
                    position: "top-center",
                })
            }).catch(error => {
                if (error.response.status === 422) {
                    this.authErrors = error.response.data.errors
                }
            });
        },

        handleLogout() {
            axios.post("/logout").then(response => {
                this.authUser = null;
                this.router.push("/");
                toast.info("Bol si odhlásený", {
                    timeout: 3000,
                    position: "top-center",
                })
            })
        }
    }
});