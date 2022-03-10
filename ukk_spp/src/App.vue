<template>
  <div class="sidebar">
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
        <router-link to="/">
          <i class='bx bxs-user'></i>
          <span class="links-name">Petugas</span>
        </router-link>
      </li>
      <li>
        <router-link to="/">
          <i class='bx bx-dollar'></i>
          <span class="links-name">SPP</span>
        </router-link>
      </li>
      <li>
        <router-link to="/">
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
        <i class='bx bx-log-out' id="log-out"></i>
      </div>
    </div>
  </div>
  <router-view></router-view>
</template>

<script>
  export default {
    name: 'App',
  }
</script>

<style>
  @import './assets/styles/style.css';
</style>