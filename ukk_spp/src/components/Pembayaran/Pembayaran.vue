<template>
    <div class="content">
        <h1 >DATA PEMBAYARAN</h1>

        <!-- Add | Search | Button -->
        <div style="padding: 25px; padding-bottom: 0;">
            <input type="text" name="search" v-model="search" class="form-control" placeholder="Search..." 
            @keyup.enter="cari()" autocomplete="off">
        </div>

        <!-- Table -->
        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Petugas</th>
                    <th>NISN</th>
                    <th>Tanggal Bayar</th>
                    <th>Bulan SPP</th>
                    <th>Tahun SPP</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="pem in pembayaran" :key="pem.id_pembayaran">
                    <td>{{pem.id_pembayaran}}</td>
                    <td>{{pem.id_petugas}}</td>
                    <td>{{pem.nisn}}</td>
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
                    console.log(result)
                    this.pembayaran = result.data
                })
            }
        },

        mounted() {
            this.getpembayaran()
        }
    }
</script>