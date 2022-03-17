<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
            Angkatan
            <input type="number" name="angkatan" class="form-control" v-model="angkatan" placeholder="Masukkan angkatan" 
            autocomplete="off">
            <br>
            Tahun
            <input type="number" name="tahun" class="form-control" v-model="tahun" placeholder="Masukkan tahun" 
            autocomplete="off">
            <br>
            Nominal
            <input type="number" name="nominal" class="form-control" v-model="nominal" placeholder="Masukkan nominal" 
            autocomplete="off">
            <br>

            <!-- Button -->
            <router-link class="button-back" to="/spp">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>
            <button class="button-add" @click="addspp()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>

            <!-- Notification -->
            <br><br>
            <div v-bind:class="style_msg">
                <div v-if="error == true">
                    <div v-for="msg in message" :key="msg.id_spp">
                        <p v-for="m in msg" :key="m.id_spp">{{m}}</p>
                    </div>
                </div>
                <p v-else>{{message}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TambahSpp",
        data() {
            return {
                angkatan:'',
                tahun:'',
                nominal: '',
                message: '',
                error:false
            }
        },

        methods: {
            addspp:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var dataspp = {
                    angkatan:this.angkatan,
                    tahun:this.tahun,
                    nominal:this.nominal
                }

                this.axios.post("http://localhost/lat_spp/public/api/insert_spp", dataspp, option).then((result) => {
                    // console.log(result)
                    if(result.data.status == true) {
                        this.error = false
                        this.message = result.data.message
                        this.style_msg = "alert alert-success"

                        // Pergi ke halaman sebelumnya setelah 2000ms
                        setTimeout(() => {
                            this.$router.push('/spp')
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