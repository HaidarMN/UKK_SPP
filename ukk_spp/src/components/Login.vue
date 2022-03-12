<template>
    <div class="container">
        <h1>LOGIN</h1>
        E-mail
        <input type="email" name="email" v-model="email" class="form-control" @keyup.enter="login()" autocomplete="off">
        <br>
        Password
        <input type="password" name="password" v-model="password" class="form-control" @keyup.enter="login()" autocomplete="off">
        <br>
        <button class="btn btn-success" @click="login()">Login</button>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                email:'',
                password:''
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
                    this.$emit("authenticated", true)
                    this.$router.replace({name: "Dashboard"})
                }).catch(error => {
                    console.log(error)
                    alert('email atau password salah')
                })
            }
        },

        mounted() {
            this.$emit("authenticated", false)
        }
    }
</script>