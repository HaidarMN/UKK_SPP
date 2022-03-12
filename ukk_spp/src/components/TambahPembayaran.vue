<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
            NISN
            <input type="number" name="nisn" class="form-control" v-model="nisn" placeholder="Masukkan nisn" 
            autocomplete="off">
            <br>
            Bulan SPP
            <select name="bulan_spp" class="form-control" v-model="bulan_spp">
                <option value="" selected hidden disabled>Pilih bulan spp</option>
                <option v-for="bln in listbln" :key="bln.key" v-bind:value="bln.key">
                    {{bln.val}}
                </option>
            </select>
            <br>
            Tahun SPP
            <input type="number" name="tahun_spp" class="form-control" v-model="tahun_spp" placeholder="Masukkan tahun spp" 
            autocomplete="off">
            <br>

            <!-- Button -->
            <button class="button-add" @click="addpembayaran()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>
            <router-link class="button-back" to="/pembayaran">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>

            <!-- Notification -->
            <br><br>
            <div v-bind:class="style_msg">
                <div v-if="error == true">
                    <div v-for="msg in message" :key="msg.id_pembayaran">
                        <p v-for="m in msg" :key="m.id_pembayaran">{{m}}</p>
                    </div>
                </div>
                <p v-else>{{message}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TambahPembayaran",
        data() {
            return {
                nisn:'',
                bulan_spp: '',
                tahun_spp:'',
                listbln:[
                    {key:"1", val:"Januari"}, {key:"2", val:"Februari"}, {key:"3", val:"Maret"}, {key:"4", val:"April"},
                    {key:"5", val:"Mei"}, {key:"6", val:"Juni"}, {key:"7", val:"Juli"}, {key:"8", val:"Agustus"},
                    {key:"9", val:"September"}, {key:"10", val:"Oktober"}, {key:"11", val:"November"}, {key:"12", val:"Desember"}
                ],
                message: '',
                error:false
            }
        },

        methods: {
            addpembayaran:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var datapembayaran = {
                    nisn:this.nisn,
                    bulan_spp:this.bulan_spp,
                    tahun_spp:this.tahun_spp
                }

                this.axios.post("http://localhost/lat_spp/public/api/bayar", datapembayaran, option).then((result) => {
                    // console.log(result)
                    if(result.data.status == true) {
                        this.error = false
                        this.message = result.data.message
                        this.style_msg = "alert alert-success"

                        // Pergi ke halaman sebelumnya setelah 2000ms
                        setTimeout(() => {
                            this.$router.push('/pembayaran')
                        }, 2000);
                    } else {
                        this.error = true
                        this.message = result.data.message
                        this.style_msg = "alert alert-danger"
                    }
                })
            }
        }
    }
</script>