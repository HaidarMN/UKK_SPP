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
            <button class="button-add" @click="addkelas()">
                <i class='bx bxs-file-plus button-icon'></i>
                <span class="button-text">Add</span>
            </button>
            <router-link class="button-back" to="/kelas">
                <i class='bx bxs-chevron-left button-icon'></i>
                <span class="button-text">Back</span>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TambahKelas",
        data() {
            return {
                nama_kelas:"",
                jurusan:"",
                angkatan:""
            }
        },

        methods: {
            addkelas:function() {
                var datakelas = {
                    nama_kelas:this.nama_kelas,
                    jurusan:this.jurusan,
                    angkatan:this.angkatan
                }

                this.axios.post("http://localhost/lat_spp/public/api/insert_kelas", datakelas).then((result) => {
                    console.log(result)
                })
            }
        }
    }
</script>