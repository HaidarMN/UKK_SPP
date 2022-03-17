<template>
  <div class="sidebar" v-if="authenticated">
    <div class="logo-content">
      <div class="logo">
        <i class='bx bxl-vuejs'></i>
        <div class="logo-name">SPP</div>
      </div>
      <i class='bx bx-menu' id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <router-link to="/">
          <i class='bx bxs-grid-alt' ></i>
          <span class="links-name">Dashboard</span>
        </router-link>
      </li>
      <li>
        <router-link to="/kelas">
          <i class='bx bxs-home'></i>
          <span class="links-name">Kelas</span>
        </router-link>
      </li>
      <li>
        <router-link to="/siswa">
          <i class='bx bxs-face'></i>
          <span class="links-name">Siswa</span>
        </router-link>
      </li>
      <li>
        <router-link to="/petugas">
          <i class='bx bxs-user'></i>
          <span class="links-name">Petugas</span>
        </router-link>
      </li>
      <li>
        <router-link to="/spp">
          <i class='bx bx-dollar'></i>
          <span class="links-name">SPP</span>
        </router-link>
      </li>
      <li>
        <router-link to="/pembayaran">
          <i class='bx bxs-wallet-alt'></i>
          <span class="links-name">Pembayaran</span>
        </router-link>
      </li>
    </ul>
    <div class="profile-content">
      <div class="profile">
        <div class="profile-details">
          <i class='bx bxs-user'></i>
          <div class="name-job">
            <div class="name">Anonymous</div>
            <div class="job">admin</div>
          </div>
        </div>
        <router-link to="/login" @click="logout()">
          <i class='bx bx-log-out' id="log-out"></i>
        </router-link>
      </div>
    </div>
  </div>
  <router-view @authenticated = "setAuthenticated"></router-view>
  <div class="footer" v-if="authenticated">
    <p>
      Copyright &copy;
      <a href="https://github.com/HaidarMN" target="_blank">HaidarMN</a>
      2022
    </p>
  </div>
</template>

<script>
  export default {
    name: 'App',
    data() {
      return {
        // JSON.parse merubah data ke Boolean
        authenticated:JSON.parse(localStorage.getItem('status'))
      }
    },

    methods: {
      setAuthenticated(status) {
        this.authenticated = status
      },

      logout() {
        this.authenticated = false
        localStorage.removeItem('status')
        localStorage.removeItem('token')
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