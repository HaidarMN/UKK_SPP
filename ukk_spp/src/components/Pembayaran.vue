<template>
    <div class="content">
        <h1 >DATA PEMBAYARAN</h1>

        <!-- Add | Search | Button -->
        <div class="grid">
            <input type="text" name="search" v-model="search" class="form-control grid-left" placeholder="Search..." 
            @keyup.enter="cari()" autocomplete="off">
            <router-link class="button-add grid-right" to="/pembayaran/tambahpembayaran">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </router-link>
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
                    <th>Aksi</th>
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
                    <td>
                        <router-link class="button-edit" :to="{path: '/pembayaran/editpembayaran/' + pem.id_pembayaran}">
                            <i class='bx bxs-edit-alt button-icon'></i>
                        </router-link>
                        &nbsp;
                        <a class="button-del" @click="delpembayaran(pem.id_pembayaran)">
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
        name: "Pembayaran",
        data() {
            return {
                pembayaran:[],
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

                this.axios.get("http://localhost/lat_spp/public/api/pembayaran", option).then((result) => {
                    // console.log(result)
                    this.pembayaran = result.data
                })
            },

            delpembayaran:function(id_pembayaran) {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                if(confirm('yakin?')) {
                    this.axios.delete("http://localhost/lat_spp/public/api/delete_pembayaran/" + id_pembayaran, option).then((result) => {
                        console.log(result)
                        this.getpembayaran()
                    })
                }
            }
        },

        mounted() {
            this.getpembayaran()
        }
    }
</script>