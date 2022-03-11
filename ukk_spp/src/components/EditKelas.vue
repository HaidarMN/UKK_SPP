<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
            <input type="hidden" name="id_kelas" v-model="id_kelas" class="form-control">
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
            <button class="button-edit" @click="editkelas()">
                <i class='bx bxs-edit-alt button-icon'></i>
                <span class="button-text">Edit</span>
            </button>
            <router-link class="button-back" to="/kelas">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>

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
        name: "EditKelas",
        data() {
            return {
                id_kelas:'',
                nama_kelas:'',
                jurusan:'',
                angkatan:'',
                style_msg: '',
                message: '',
                error:false
            }
        },

        methods: {
            getdetail(id_kelas) {
                this.axios.get("http://localhost/lat_spp/public/api/getkelas/" + id_kelas).then((result) => {
                    // console.log(result)
                    this.id_kelas   = result.data.id_kelas,
                    this.nama_kelas = result.data.nama_kelas,
                    this.jurusan    = result.data.jurusan,
                    this.angkatan   = result.data.angkatan
                })
            },

            editkelas:function() {
                var datakelas = {
                    nama_kelas:this.nama_kelas,
                    jurusan:this.jurusan,
                    angkatan:this.angkatan
                }

                this.axios.put("http://localhost/lat_spp/public/api/update_kelas/" + this.id_kelas, datakelas).then((result) => {
                    console.log(result)
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
        },

        mounted() {
            this.getdetail(this.$route.params.id_kelas)
        }
    }
</script>