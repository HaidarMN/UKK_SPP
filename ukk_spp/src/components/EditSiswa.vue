<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
            <input type="hidden" name="nisn" v-model="nisn" class="form-control">
            NIS
            <input type="number" name="nis" class="form-control" v-model="nis" placeholder="Masukkan nis"
            autocomplete="off">
            <br>
            Nama
            <input type="text" name="nama" class="form-control" v-model="nama" placeholder="Masukkan nama"
            autocomplete="off">
            <br>
            Kelas
            <select name="kelas" class="form-control" v-model="kelas">
                <option value="" selected hidden disabled>Pilih kelas</option>
                <option v-for="kel in listkelas" :key="kel.id_kelas" v-bind:value="kel.id_kelas">{{kel.nama_kelas}}</option>
            </select>
            <br>
            Alamat
            <textarea name="alamat" class="form-control" v-model="alamat" placeholder="Masukkan alamat" rows="3" 
            autocomplete="off"></textarea>
            <br>
            No Telp
            <input type="tel" name="no_telp" class="form-control" v-model="no_telp" placeholder="Masukkan no telp"
            autocomplete="off">
            <br>
            E-mail
            <input type="email" name="email" class="form-control" v-model="email" placeholder="Masukkan email"
            autocomplete="off">
            <br>
            <input type="hidden" name="password" class="form-control" v-model="password">
            <br>

            <!-- Button -->
            <router-link class="button-back" to="/siswa">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>
            <button class="button-add" @click="editsiswa()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>

            <!-- Notification -->
            <br><br>
            <div v-bind:class="style_msg">
                <div v-if="error == true">
                    <div v-for="msg in message" :key="msg.nisn">
                        <p v-for="m in msg" :key="m.nisn">{{m}}</p>
                    </div>
                </div>
                <p v-else>{{message}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditSiswa",
        data() {
            return {
                nisn:'',
                nis:'',
                nama:'',
                kelas:'',
                alamat:'',
                no_telp:'',
                email:'',
                password:'',
                listkelas:[],
                style_msg: '',
                message: '',
                error:false
            }
        },

        methods: {
            getkelas:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/kelas", option).then((result) => {
                    // console.log(result)
                    this.listkelas = result.data
                })
            },

            getdetail(nisn) {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                this.axios.get("http://localhost/lat_spp/public/api/getsiswa/" + nisn, option).then((result) => {
                    // console.log(result)
                    this.nisn       = result.data.nisn,
                    this.nis        = result.data.nis,
                    this.nama       = result.data.nama,
                    this.kelas      = result.data.id_kelas
                    this.alamat     = result.data.alamat
                    this.no_telp    = result.data.no_telp
                    this.email      = result.data.email
                    this.password   = result.data.password
                })
            },

            editsiswa:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var datasiswa = {
                    nisn:this.nisn,
                    nis:this.nis,
                    nama:this.nama,
                    id_kelas:this.kelas,
                    alamat:this.alamat,
                    no_telp:this.no_telp,
                    email:this.email,
                    password:this.password
                }

                this.axios.put("http://localhost/lat_spp/public/api/update_siswa/" + this.nisn, datasiswa, option).then((result) => {
                    console.log(result)
                    if(result.data.status == true) {
                        this.error = false
                        this.message = result.data.message
                        this.style_msg = "alert alert-success"

                        // Pergi ke halaman sebelumnya setelah 2000ms
                        setTimeout(() => {
                            this.$router.push('/siswa')
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
            this.getkelas()
            this.getdetail(this.$route.params.nisn)
        }
    }
</script>