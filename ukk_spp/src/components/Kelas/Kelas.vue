<template>
    <div class="content">
        <h1 >DATA KELAS</h1>

        <!-- Add | Search | Button -->
        <div class="grid">
            <input type="text" name="search" v-model="search" class="form-control grid-left" placeholder="Search..." 
            @keyup.enter="cari()" @input="cari()" autocomplete="off">
            <router-link class="button-add grid-right" to="/kelas/tambahkelas">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </router-link>
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
                        <router-link class="button-edit" :to="{path: '/kelas/editkelas/' + kel.id_kelas}">
                            <i class='bx bxs-edit-alt button-icon'></i>
                        </router-link>
                        &nbsp;
                        <a class="button-del" @click="delkelas(kel.id_kelas)">
                            <i class='bx bxs-trash button-icon'></i>
                        </a>
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
                search:'',
            }
        },

        methods: {
            cari:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var data_cari = ""
                if(this.search == "") {
                    data_cari = ""
                } else {
                    data_cari = "/" + this.search
                }

                this.axios.get("http://localhost/lat_spp/public/api/kelas" + data_cari, option).then((result) => {
                    // console.log(result)
                    this.kelas = result.data
                })
            },

            getkelas:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/kelas", option).then((result) => {
                    // console.log(result)
                    this.kelas = result.data
                })
            },

            delkelas:function(id_kelas) {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                if(confirm('yakin?')) {
                    this.axios.delete("http://localhost/lat_spp/public/api/delete_kelas/" + id_kelas, option).then((result) => {
                        console.log(result)
                        this.getkelas()
                    })
                }
            }
        },

        mounted() {
            this.getkelas()
        }
    }
</script>