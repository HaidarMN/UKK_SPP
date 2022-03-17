<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
            Nama Kelas
            <input type="text" name="nama_kelas" class="form-control" v-model="nama_kelas" placeholder="Masukkan nama" 
            autocomplete="off">
            <br>
            Jurusan
            <select name="jurusan" class="form-control" v-model="jurusan">
                <option value="" selected hidden disabled>Pilih jurusan</option>
                <option value="RPL">Rekayasa Perangkat Lunak</option>
                <option value="TKJ">Teknik Komputer Jaringan</option>
            </select>
            <br>
            Angkatan
            <input type="number" name="angkatan" class="form-control" v-model="angkatan" placeholder="Masukkan angkatan" 
            autocomplete="off">
            <br>

            <!-- Button -->
            <router-link class="button-back" to="/kelas">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>
            <button class="button-add" @click="addkelas()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>

            <!-- Notification -->
            <br><br>
            <div v-bind:class="style_msg">
                <div v-if="error == true">
                    <div v-for="msg in message" :key="msg.id_kelas">
                        <p v-for="m in msg" :key="m.id_kelas">{{m}}</p>
                    </div>
                </div>
                <p v-else>{{message}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TambahKelas",
        data() {
            return {
                nama_kelas:'',
                jurusan:'',
                angkatan:'',
                style_msg: '',
                message: '',
                error:false
            }
        },

        methods: {
            addkelas:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var datakelas = {
                    nama_kelas:this.nama_kelas,
                    jurusan:this.jurusan,
                    angkatan:this.angkatan
                }

                this.axios.post("http://localhost/lat_spp/public/api/insert_kelas", datakelas, option).then((result) => {
                    // console.log(result)
                    if(result.data.status == true) {
                        this.error = false
                        this.message = result.data.message
                        this.style_msg = "alert alert-success"

                        // Pergi ke halaman sebelumnya setelah 2000ms
                        setTimeout(() => {
                            this.$router.push('/kelas')
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