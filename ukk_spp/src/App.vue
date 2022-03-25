<template>
  <div class="sidebar" v-if="authenticated" @level = "setLevel" @username = "setUsername">
    <div class="logo-content">
      <div class="logo">
        <i class='bx bxl-vuejs'></i>
        <div class="logo-name">SPP</div>
      </div>
      <i class='bx bx-menu' id="btn"></i>
    </div>
    <ul>
      <li v-if="level != 'siswa'">
        <router-link to="/bayar" class="bayar">
          <i class='bx bx-money'></i>
          <span class="links-name">Bayar</span>
        </router-link>
      </li>
      <hr v-if="level != 'siswa'">
      <li v-if="level == 'admin'">
        <router-link to="/">
          <i class='bx bxs-grid-alt'></i>
          <span class="links-name">Dashboard</span>
        </router-link>
      </li>
      <li v-if="level == 'admin'">
        <router-link to="/kelas">
          <i class='bx bxs-home'></i>
          <span class="links-name">Kelas</span>
        </router-link>
      </li>
      <li v-if="level == 'admin'">
        <router-link to="/siswa">
          <i class='bx bxs-face'></i>
          <span class="links-name">Siswa</span>
        </router-link>
      </li>
      <li v-if="level == 'admin'">
        <router-link to="/petugas">
          <i class='bx bxs-user'></i>
          <span class="links-name">Petugas</span>
        </router-link>
      </li>
      <li v-if="level == 'admin'">
        <router-link to="/spp">
          <i class='bx bx-dollar'></i>
          <span class="links-name">SPP</span>
        </router-link>
      </li>
      <li v-if="level == 'admin' || 'petugas' || 'siswa'">
        <router-link to="/pembayaran">
          <i class='bx bxs-wallet-alt'></i>
          <span class="links-name">Pembayaran</span>
        </router-link>
      </li>
      <li v-if="level != 'siswa'">
        <router-link to="/report">
          <i class='bx bxs-file-pdf'></i>
          <span class="links-name">Report</span>
        </router-link>
      </li>
    </ul>
    <div class="profile-content">
      <div class="profile">
        <div class="profile-details">
          <i class='bx bxs-user'></i>
          <div class="name-job">
            <div class="name">{{this.$store.state.user.username}}</div>
            <div class="job">{{this.$store.state.user.level}}</div>
          </div>
        </div>
        <router-link to="/login" @click="logout()">
          <i class='bx bx-log-out' id="log-out"></i>
        </router-link>
      </div>
    </div>
  </div>
  <router-view @authenticated = "setAuthenticated"></router-view>
  <br>
  <div class="footer" v-if="authenticated">
    <p>
      Copyright &copy; 2022
      <a href="https://haidarmn.github.io" target="_blank">HaidarMN</a>
      | in project
      <a href="https://github.com/HaidarMN/UKK_SPP" target="_blank">UKK_SPP</a>
    </p>
  </div>
</template>

<script>
  export default {
    name: 'App',
    data() {
      return {
        // JSON.parse merubah data ke Boolean
        authenticated:JSON.parse(localStorage.getItem('status')),
        level:localStorage.getItem('level'),
        username:localStorage.getItem('username'),
        nisn:localStorage.getItem('nisn')
      }
    },

    created() {
      this.axios.get("http://localhost/lat_spp/public/api/login/check", {
        headers: {'Authorization':'bearer ' + localStorage.getItem("token")}
      }).then((result) => {
        console.log(result)
        if(!(result.data.success)) {
          localStorage.removeItem('status')
          localStorage.removeItem('token')
          localStorage.removeItem('level')
          localStorage.removeItem('username')
          localStorage.removeItem('nisn')

          alert("Sesi anda sudah berakhir\n\nSilahkan login kembali")
          this.$router.push('/login')
        }
      })
    },

    methods: {
      setAuthenticated(status) {
        this.authenticated = status
      },

      setLevel(status) {
        this.level = status
      },

      setUsername(status) {
        this.username = status
      },

      setNisn(status) {
        this.nisn = status
      },

      logout() {
        this.authenticated = false
        localStorage.removeItem('status')
        localStorage.removeItem('token')
        localStorage.removeItem('level')
        localStorage.removeItem('username')
        localStorage.removeItem('nisn')
      }
    },

    mounted() {
      if(!this.authenticated) {
        this.$router.replace({name: "Login"})
      }
    }
  }
</script>

<style>
  @import './assets/style.css';
</style>