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
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Histori Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <h4>Sabtu, 13 Maret 2022</h4>
                                <div>
                                    <span>Petugas: aditya | Siswa: Arayndra</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Sabtu, 13 Maret 2022</h4>
                                <div>
                                    <span>Petugas: eko | Siswa: Haidar Muhammad</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Sabtu, 13 Maret 2022</h4>
                                <div>
                                    <span>Petugas: eko | Siswa: Haidar Muhammad</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Senin, 14 Februari 2022</h4>
                                <div>
                                    <span>Petugas: eko | Siswa: Asrizal Novi</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Kamis, 20 Januari 2022</h4>
                                <div>
                                    <span>Petugas: salsabil | Siswa: Asrizal Novi</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- ?? -->
            <div class="content-db-2">
                <div class="db-chart">
                    
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
                totalpetugas:''
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

                this.axios.get("http://localhost/lat_spp/public/api/totaluser", option).then((result) => {
                    // console.log(result)
                    this.totalpetugas = result.data
                })
            }
        },

        mounted() {
            this.totkel()
            this.totsis()
            this.totpet()
        }
    }
</script>