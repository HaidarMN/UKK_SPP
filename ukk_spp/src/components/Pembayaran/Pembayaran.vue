<template>
    <div class="content">
        <h1 >DATA PEMBAYARAN</h1>

        <!-- Add | Search | Button -->
        <div style="padding: 25px; padding-bottom: 0;">
            <input type="text" name="search" v-model="search" class="form-control" placeholder="Search..." 
            @keyup.enter="cari()" @input="cari()" autocomplete="off">
        </div>

        <!-- Table -->
        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Petugas</th>
                    <th>Siswa</th>
                    <th>Tanggal Bayar</th>
                    <th>Bulan SPP</th>
                    <th>Tahun SPP</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="pem in pembayaran" :key="pem.id_pembayaran">
                    <td>{{pem.id_pembayaran}}</td>
                    <td>
                        <span  v-for="us in user.filter((us) => pem.id_petugas === us.id)" :key="us.id">
                            {{us.name}}
                        </span>
                    </td>
                    <td>
                        <span  v-for="sis in siswa.filter((sis) => pem.nisn === sis.nisn)" :key="sis.nisn">
                            {{sis.nama}}
                        </span>
                    </td>
                    <td>{{pem.tgl_bayar}}</td>
                    <td>{{pem.bulan_spp}}</td>
                    <td>{{pem.tahun_spp}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "Pembayaran",
        data() {
            return {
                pembayaran:[],
                user:[],
                siswa:[],
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

                this.axios.get("http://localhost/lat_spp/public/api/pembayaran" + data_cari, option).then((result) => {
                    // console.log(result)
                    this.pembayaran = result.data
                })
            },

            getpembayaran:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var data = localStorage.getItem('nisn');

                this.axios.get("http://localhost/lat_spp/public/api/pembayaran", option).then((result) => {
                    // console.log(result)
                    this.pembayaran = result.data
                })

                this.axios.get("http://localhost/lat_spp/public/api/pembayarans", option).then((result) => {
                    // console.log(result)
                    this.pembayaran = result.data
                })

                this.axios.get("http://localhost/lat_spp/public/api/pembayaranss/" + data, option).then((result) => {
                    // console.log(result)
                    this.pembayaran = result.data
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
                    console.log(result)
                    this.siswa = result.data
                })
            }
        },

        mounted() {
            this.getpembayaran()
            this.getpetugas()
            this.getsiswa()
        }
    }
</script>