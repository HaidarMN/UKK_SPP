import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'

import {createWebHistory, createRouter} from 'vue-router'

// Dashboard
import Dashboard from './components/Dashboard.vue'
// Kelas
import Kelas from './components/Kelas.vue'
// Siswa
import Siswa from './components/Siswa.vue'

const router = createRouter({
    history : createWebHistory(),
    routes : [
        // Dashboard
        {path: '/', name: "Dashboard", component: Dashboard},
        // Kelas
        {path: '/kelas', name: "Kelas", component: Kelas},
        // Siswa
        {path: '/siswa', name: "Siswa", component: Siswa},       
    ],
    base : '/'
})

const app = createApp(App)
app.use(router)
app.config.globalProperties.axios  = axios
app.mount("#app")

let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");

btn.onclick = function() {
  sidebar.classList.toggle("active");
}
