import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'

import {createWebHistory, createRouter} from 'vue-router'

// Dashboard
import Dashboard from './components/Dashboard.vue'
// Kelas
import Kelas from './components/Kelas.vue'
import TambahKelas from './components/TambahKelas.vue'
import EditKelas from './components/EditKelas.vue'
// Siswa
import Siswa from './components/Siswa.vue'

const router = createRouter({
    history : createWebHistory(),
    routes : [
        // Dashboard
        {path: '/', name: "Dashboard", component: Dashboard},
        // Kelas
        {path: '/kelas', name: "Kelas", component: Kelas},
        {path: '/tambahkelas', name: "TambahKelas", component: TambahKelas},
        {path: '/editkelas', name: "EditKelas", component: EditKelas},
        // Siswa
        {path: '/siswa', name: "Siswa", component: Siswa},       
    ],
    base : '/'
})

const app = createApp(App)
app.use(router)
app.config.globalProperties.axios  = axios
app.mount("#app")

// Toogle Sidebar
let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");

btn.onclick = function() {
  sidebar.classList.toggle("active");
}
