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
                <h1 style="margin-right: 12.5px;">Histori Pembayaran</h1>
                <table class="content-table" style="margin-right: 12.5px;">
                    <thead>
                        <tr>
                            <th>Petugas</th>
                            <th>Siswa</th>
                            <th>Tanggal Bayar</th>
                            <th>Bulan SPP</th>
                            <th>Tahun SPP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="last in latest" :key="last.id_pembayaran">
                            <td>{{last.id_petugas}}</td>
                            <td>{{last.nisn}}</td>
                            <td>{{last.tgl_bayar}}</td>
                            <td>{{last.bulan_spp}}</td>
                            <td>{{last.tahun_spp}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ?? -->
            <div class="content-db-2">
                <h1 style="margin-left: 12.5px;">??</h1>
                <div class="db-chart" style="margin-left: 12.5px;">
                    
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
                latest:[]
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
            },

            lastpembayaran:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/latest", option).then((result) => {
                    // console.log(result)
                    this.latest = result.data
                })
            }
        },

        mounted() {
            this.totkel()
            this.totsis()
            this.totpet()
            this.lastpembayaran()
        }
    }
</script>