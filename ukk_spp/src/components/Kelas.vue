<template>
    <div class="content">
        <h1 >DATA KELAS</h1>

        <!-- Add | Search | Btn -->
        <div class="grid">
            <router-link class="button-add grid-left" to="/">
                <i class='bx bx-plus button-icon'></i>
                <span class="button-text">Add</span>
            </router-link>
            <input type="text" name="search" v-model="search" class="form-control grid-center" placeholder="Search..." 
            @keyup.enter="cari()" autocomplete="off">
            <button class="button-edit grid-right" @click="cari()">
                <i class='bx bx-search button-icon'></i>
                <span class="button-text">Search</span>
            </button>
        </div>

        <!-- Table -->
        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="kel in kelas" :key="kel.id_kelas">
                    <td>{{kel.id_kelas}}</td>
                    <td>{{kel.nama_kelas}}</td>
                    <td>{{kel.jurusan}}</td>
                    <td>{{kel.angkatan}}</td>
                    <td>
                        <router-link class="button-edit" to="/">
                            <i class='bx bx-edit-alt button-icon'></i>
                        </router-link>
                        &nbsp;
                        <button class="button-del">
                            <i class='bx bx-trash button-icon'></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "Kelas",
        data() {
            return {
                kelas:[],
                search:""
            }
        },

        methods: {
            cari:function() {
                this.axios.get("http://localhost/lat_spp/public/api/kelas/" + this.search).then((result)=>{
                    this.kelas = result.data
                    // console.log(result)
                })
            },

            getkelas:function() {
                this.axios.get("http://localhost/lat_spp/public/api/kelas").then((result)=>{
                    this.kelas = result.data
                    // console.log(result)
                })
            }
        },

        mounted() {
            this.getkelas()
        }
    }
</script>