<template>
    <div class="content">
        <h1 >DATA PETUGAS</h1>

        <!-- Add | Search | Button -->
        <div class="grid">
            <input type="text" name="search" v-model="search" class="form-control grid-left" placeholder="Search..." 
            @keyup.enter="cari()" @input="cari()" autocomplete="off">
            <router-link class="button-add grid-right" to="/petugas/tambahpetugas">
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
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="us in user" :key="us.id_petugas">
                    <td>{{us.id_petugas}}</td>
                    <td>{{us.nama_petugas}}</td>
                    <td>{{us.username}}</td>
                    <td>{{us.email}}</td>
                    <td>{{us.level}}</td>
                    <td>
                        <router-link class="button-edit" :to="{path: '/petugas/editpetugas/' + us.id}">
                            <i class='bx bxs-edit-alt button-icon'></i>
                        </router-link>
                        &nbsp;
                        <a class="button-del" @click="delpetugas(us.id)">
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
        name: "User",
        data() {
            return {
                user:[],
                search:''
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

                this.axios.get("http://localhost/lat_spp/public/api/petugas" + data_cari, option).then((result) => {
                    // console.log(result)
                    this.user = result.data
                })
            },

            getpetugas:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/petugas", option).then((result) => {
                    // console.log(result)
                    this.user = result.data
                })
            },

            delpetugas:function(id) {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                if(confirm('yakin?')) {
                    this.axios.delete("http://localhost/lat_spp/public/api/delete_petugas/" + id, option).then((result) => {
                        console.log(result)
                        this.getpetugas()
                    })
                }
            }
        },

        mounted() {
            this.getpetugas()
        }
    }
</script>