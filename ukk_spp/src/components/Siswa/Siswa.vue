<template>
    <div class="content">
        <h1 >DATA SISWA</h1>

        <!-- Add | Search | Button -->
        <div class="grid">
            <input type="text" name="search" v-model="search" class="form-control grid-left" placeholder="Search..." 
            @keyup.enter="cari()" autocomplete="off">
            <router-link class="button-add grid-right" to="/siswa/tambahsiswa">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </router-link>
        </div>

        <!-- Table -->
        <table class="content-table">
            <thead>
                <tr>
                    <th>NISN</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>E-mail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sis in siswa" :key="sis.nisn">
                    <td>{{sis.nisn}}</td>
                    <td>{{sis.nis}}</td>
                    <td>{{sis.nama}}</td>
                    <td>{{sis.alamat}}</td>
                    <td>{{sis.no_telp}}</td>
                    <td>{{sis.email}}</td>
                    <td>
                        <router-link class="button-edit" :to="{path: '/siswa/editsiswa/' + sis.nisn}">
                            <i class='bx bxs-edit-alt button-icon'></i>
                        </router-link>
                        &nbsp;
                        <a class="button-del" @click="delsiswa(sis.nisn)">
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
        name: "Siswa",
        data() {
            return {
                siswa:[],
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

                this.axios.get("http://localhost/lat_spp/public/api/siswa" + data_cari, option).then((result) => {
                    // console.log(result)
                    this.siswa = result.data
                })
            },

            getsiswa:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/siswa", option).then((result) => {
                    console.log(result)
                    this.siswa = result.data
                })
            },

            delsiswa:function(nisn) {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                if(confirm('yakin?')) {
                    this.axios.delete("http://localhost/lat_spp/public/api/delete_siswa/" + nisn, option).then((result) => {
                        console.log(result)
                        this.getsiswa()
                    })
                }
            }
        },

        mounted() {
            this.getsiswa()
        }
    }
</script>