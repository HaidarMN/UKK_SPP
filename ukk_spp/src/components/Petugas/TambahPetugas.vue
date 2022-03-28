<template>
    <div class="content">
        <!-- Form -->
        <div class="add-form">
            Nama
            <input type="text" name="nama_petugas" class="form-control" v-model="nama_petugas" placeholder="Masukkan nama" 
            autocomplete="off">
            <br>
            Username
            <input type="text" name="username" class="form-control" v-model="username" placeholder="Masukkan username"
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
            Password Confirmation
            <input type="password" name="password_confirmation" class="form-control" v-model="password_confirmation" 
            placeholder="Ulangi password" autocomplete="off">
            <br>
            Level
            <select name="level" class="form-control" v-model="level">
                <option value="" selected hidden disabled>Pilih level</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
            </select>
            <br>

            <!-- Button -->
            <router-link class="button-back" to="/petugas">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>
            <button class="button-add" @click="addpetugas()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>

            <!-- Notification -->
            <div v-bind:class="style_msg">
                <div v-if="error == true">
                    <div v-for="msg in message" :key="msg.id">
                        <p v-for="m in msg" :key="m.id">{{m}}</p>
                    </div>
                </div>
                <p v-else>{{message}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TambahPetugas",
        data() {
            return {
                nama_petugas:'',
                username:'',
                email:'',
                password:'',
                password_confirmation:'',
                level:'',
                style_msg: '',
                message: '',
                error:false
            }
        },

        methods: {
            addpetugas:function() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var datauser = {
                    nama_petugas:this.nama_petugas,
                    username:this.username,
                    email:this.email,
                    password:this.password,
                    password_confirmation:this.password_confirmation,
                    level:this.level,
                }

                this.axios.post("http://localhost/lat_spp/public/api/register", datauser, option).then((result) => {
                    console.log(result)
                    if(result.data.status == true) {
                        this.error = false
                        this.message = result.data.message
                        this.style_msg = "alert alert-success"

                        // Pergi ke halaman sebelumnya setelah 2000ms
                        setTimeout(() => {
                            this.$router.push('/petugas')
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