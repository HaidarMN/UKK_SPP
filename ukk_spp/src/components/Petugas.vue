<template>
    <div class="content">
        <h1 >DATA PETUGAS</h1>

        <!-- Add | Search | Button -->
        <div class="grid">
            <router-link class="button-add grid-left" to="/petugas/tambahpetugas">
                <i class='bx bxs-file-plus button-icon'></i>
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
                    <th>E-mail</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="us in user" :key="us.id">
                    <td>{{us.id}}</td>
                    <td>{{us.name}}</td>
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

                this.axios.get("http://localhost/lat_spp/public/api/user" + data_cari, option).then((result) => {
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

                this.axios.get("http://localhost/lat_spp/public/api/user", option).then((result) => {
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
                    this.axios.delete("http://localhost/lat_spp/public/api/delete_user/" + id, option).then((result) => {
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