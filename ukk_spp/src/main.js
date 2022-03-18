import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'
import store from './store.js'

import {createWebHistory, createRouter} from 'vue-router'

// Dashboard
import Dashboard from './components/Dashboard.vue'
// Kelas
import Kelas from './components/Kelas/Kelas.vue'
import TambahKelas from './components/Kelas/TambahKelas.vue'
import EditKelas from './components/Kelas/EditKelas.vue'
// Siswa
import Siswa from './components/Siswa/Siswa.vue'
import TambahSiswa from './components/Siswa/TambahSiswa.vue'
import EditSiswa from './components/Siswa/EditSiswa.vue'
// Petugas
import Petugas from './components/Petugas/Petugas.vue'
import TambahPetugas from './components/Petugas/TambahPetugas.vue'
// SPP
import Spp from './components/Spp/Spp.vue'
import TambahSpp from './components/Spp/TambahSpp.vue'
import EditSpp from './components/Spp/EditSpp.vue'
// Pembayaran
import Pembayaran from './components/Pembayaran/Pembayaran.vue'
import TambahPembayaran from './components/Pembayaran/TambahPembayaran.vue'
// Login
import Login from './components/Login.vue'

const router = createRouter({
    history : createWebHistory(),
    routes : [
        // Dashboard
        {path: '/', name: "Dashboard", component: Dashboard},
        // Kelas
        {path: '/kelas', name: "Kelas", component: Kelas},
        {path: '/kelas/tambahkelas', name: "TambahKelas", component: TambahKelas},
        {path: '/kelas/editkelas/:id_kelas', name: "EditKelas", component: EditKelas},
        // Siswa
        {path: '/siswa', name: "Siswa", component: Siswa},
        {path: '/siswa/tambahsiswa', name: "TambahSiswa", component: TambahSiswa},
        {path: '/siswa/editsiswa/:nisn', name: "EditSiswa", component: EditSiswa},
        // Petugas
        {path: '/petugas', name: "Petugas", component: Petugas},
        {path: '/petugas/tambahpetugas', name: "TambahPetugas", component: TambahPetugas},
        // Spp
        {path: '/spp', name: "Spp", component: Spp},
        {path: '/spp/tambahspp', name: "TambahSpp", component: TambahSpp},        
        {path: '/spp/editspp/:id_spp', name: "EditSpp", component: EditSpp},        
        // Pembayaran
        {path: '/pembayaran', name: "Pembayaran", component: Pembayaran},
        {path: '/bayar', name: "TambahPembayaran", component: TambahPembayaran},
        // Login
        {path: '/login', name: "Login", component: Login},
    ],
    base : '/'
})

const app = createApp(App)
app.use(router)
app.use(store)
app.config.globalProperties.axios  = axios
app.mount("#app")

// Toogle Sidebar
let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");

btn.onclick = function() {
  sidebar.classList.toggle("active");
}
