<template>
    <div class="login">
        <h1>LOGIN</h1>
        <br>
        <input type="email" name="email" v-model="email" @keyup.enter="login()" placeholder="E-mail"
        autocomplete="off">
        <br>
        <input type="password" name="password" v-model="password" @keyup.enter="login()" placeholder="Password"
        autocomplete="off">

        <!-- Error message -->
        <div v-bind:class="style_msg">
            <p>{{msg}}</p>
        </div>
        
        <button type="submit" class="button-log" @click="login()">Login</button>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                email:'',
                password:'',
                msg:''
            }
        },

        methods: {
            login() {
                var datalogin = {
                    email:this.email,
                    password:this.password
                }

                this.axios.post("http://localhost/lat_spp/public/api/login", datalogin).then((result) => {
                    // console.log(result)
                    localStorage.setItem('token', result.data.token)
                    localStorage.setItem('status', true)
                    localStorage.setItem('level', result.data.level)
                    localStorage.setItem('username', result.data.username)
                    localStorage.setItem('nisn', result.data.nisn)

                    this.$emit("authenticated", true)
                    this.$emit("level", result.data.level)
                    this.$emit("username", result.data.username)
                    this.$emit("nisn", result.data.nisn)

                    this.$store.dispatch('setUsername', result.data.username)
                    this.$store.dispatch('setLevel', result.data.level)
                    this.$store.dispatch('setNisnl', result.data.nisn)

                    if (result.data.level == 'admin') {
                        this.$router.replace({name: "Dashboard"});
                    } else {
                        this.$router.replace({name: "Pembayaran"})
                    }
                }).catch(error => {
                    console.log(error)
                    // alert('email atau password salah')
                    this.msg = "email atau password salah"
                    this.style_msg = "erlog"
                })
            }
        },

        mounted() {
            this.$emit("authenticated", false)
        }
    }
</script>