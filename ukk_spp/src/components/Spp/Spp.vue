<template>
    <div class="content">
        <h1 >DATA SPP</h1>

        <!-- Add | Search | Button -->
        <div class="grid">
            <input type="text" name="search" v-model="search" class="form-control grid-left" placeholder="Search..." 
            @keyup.enter="cari()" autocomplete="off">
            <router-link class="button-add grid-right" to="/spp/tambahspp">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </router-link>
        </div>

        <!-- Table -->
        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Angkatan</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="s in spp" :key="s.id_spp">
                    <td>{{s.id_spp}}</td>
                    <td>{{s.angkatan}}</td>
                    <td>{{s.tahun}}</td>
                    <td>{{s.nominal}}</td>
                    <td>
                        <router-link class="button-edit" :to="{path: '/spp/editspp/' + s.id_spp}">
                            <i class='bx bxs-edit-alt button-icon'></i>
                        </router-link>
                        &nbsp;
                        <a class="button-del" @click="delspp(s.id_spp)">
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
        name: "Spp",
        data() {
            return {
                spp:[],
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

                this.axios.get("http://localhost/lat_spp/public/api/spp" + data_cari, option).then((result) => {
                    // console.log(result)
                    this.spp = result.data
                })
            },

            getspp:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/spp", option).then((result) => {
                    // console.log(result)
                    this.spp = result.data
                })
            },

            delspp:function(id_spp) {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                if(confirm('yakin?')) {
                    this.axios.delete("http://localhost/lat_spp/public/api/delete_spp/" + id_spp, option).then((result) => {
                        console.log(result)
                        this.getspp()
                    })
                }
            }
        },

        mounted() {
            this.getspp()
        }
    }
</script>