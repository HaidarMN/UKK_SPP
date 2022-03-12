<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
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
                <option v-for="kel in listkelas" :key="kel.id_kelas" :value="kel.id">{{kel.nama_kelas}}</option>
            </select>
            <br>
            Alamat
            <textarea name="alamat" class="form-control" v-model="alamat" placeholder="Masukkan alamat" rows="3" 
            autocomplete="off"></textarea>
            <br>
            No Telp
            <input type="number" name="no_telp" class="form-control" v-model="no_telp" placeholder="Masukkan no telp"
            autocomplete="off">
            <br>
            E-mail
            <input type="email" name="email" class="form-control" v-model="email" placeholder="Masukkan email"
            autocomplete="off">
            <br>
            Password
            <input type="password" name="password" class="form-control" v-model="password" placeholder="Masukkan password"
            autocomplete="off">
            <br>

            <!-- Button -->
            <button class="button-add" @click="addsiswa()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>
            <router-link class="button-back" to="/siswa">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>

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
        name: "Tambahsiswa",
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

            addsiswa:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var datasiswa = {
                    nisn:this.nisn,
                    nis:this.nis,
                    nama:this.nama,
                    id_kelas:this.id_kelas,
                    alamat:this.alamat,
                    no_telp:this.no_telp,
                    email:this.email,
                    password:this.password
                }

                this.axios.post("http://localhost/lat_spp/public/api/insert_siswa", datasiswa, option).then((result) => {
                    // console.log(result)
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
        }
    }
</script>