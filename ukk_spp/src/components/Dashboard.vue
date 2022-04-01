<template>
    <div class="content">
        <!-- Info total data -->
        <div class="grid-box">
            <div class="box-info box-1">
                <span class="box-icon bg-info">
                    <i class='bx bxs-home'></i>
                </span>
                <div class="box-content">
                    <span class="box-title">Total Kelas</span>
                    <span class="box-number">{{totalkelas}}</span>
                </div>
            </div>
            <div class="box-info box-2">
                <span class="box-icon bg-danger">
                    <i class='bx bxs-face'></i>
                </span>
                <div class="box-content">
                    <span class="box-title">Total Siswa</span>
                    <span class="box-number">{{totalsiswa}}</span>
                </div>
            </div>
            <div class="box-info box-3">
                <span class="box-icon bg-warning">
                    <i class='bx bxs-user'></i>
                </span>
                <div class="box-content">
                    <span class="box-title">Total Petugas</span>
                    <span class="box-number">{{totalpetugas}}</span>
                </div>
            </div>
        </div>

        <div class="grid-db">
            <!-- History Pembayaran -->
            <div class="content-db-1">
                <table class="content-table" style="margin-right: 12.5px;">
                    <thead>
                        <tr>
                            <th style="font-size: 40px">
                                History
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="last in latest" :key="last.id_pembayaran" style="text-align: left">
                            <td>
                                <h3>
                                    {{ $filters.formatDate(last.tgl_bayar) }}
                                </h3>
                                <span  v-for="us in user.filter((us) => last.id_petugas === us.id)" :key="us.id">
                                    Petugas: {{us.name}} | 
                                </span>
                                <span  v-for="sis in siswa.filter((sis) => last.nisn === sis.nisn)" :key="sis.nisn">
                                    Siswa: {{sis.nama}} | 
                                </span>
                                <span>
                                    SPP: {{last.bulan_spp}} {{last.tahun_spp}} | 
                                </span>
                                <span>
                                    Status: {{last.status}}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Quick Access -->
            <div class="content-db-2">
                <div class="db-qa" style="margin-left: 12.5px;">
                    <h1>Quick Access</h1>
                    <hr>
                    <router-link class="button-kelas grid-right" to="/kelas/tambahkelas">
                        <i class='bx bxs-home button-icon'></i>
                        <span class="button-text">Add Kelas</span>
                    </router-link>
                    <br><br>
                    <router-link class="button-siswa grid-right" to="/siswa/tambahsiswa">
                        <i class='bx bxs-face button-icon'></i>
                        <span class="button-text">Add Siswa</span>
                    </router-link>
                    <br><br>
                    <router-link class="button-petugas grid-right" to="/petugas/tambahpetugas">
                        <i class='bx bxs-user button-icon'></i>
                        <span class="button-text">Add Petugas</span>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                totalkelas:'',
                totalsiswa:'',
                totalpetugas:'',
                latest:[],
                user:[],
                siswa:[]
            }
        },

        methods: {
            totkel:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/totalkelas", option).then((result) => {
                    // console.log(result)
                    this.totalkelas = result.data
                })
            },

            totsis:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/totalsiswa", option).then((result) => {
                    // console.log(result)
                    this.totalsiswa = result.data
                })
            },

            totpet:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/totalpetugas", option).then((result) => {
                    // console.log(result)
                    this.totalpetugas = result.data
                })
            },

            lastpembayaran:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/latest", option).then((result) => {
                    console.log(result)
                    this.latest = result.data
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

            getsiswa:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/siswa", option).then((result) => {
                    // console.log(result)
                    this.siswa = result.data
                })
            }
        },

        mounted() {
            this.totkel()
            this.totsis()
            this.totpet()
            this.lastpembayaran()
            this.getpetugas()
            this.getsiswa()
        }
    }
</script>