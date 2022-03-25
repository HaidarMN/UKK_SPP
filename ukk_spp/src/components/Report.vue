<template>
    <div class="content">
        <h1>Laporan</h1>
    
        <div class="grid-rp">
            <div class="add-form rp-1">
                Bulan
                <select name="bulan_spp" class="form-control" v-model="bulan">
                    <option value="" selected hidden disabled>Pilih bulan</option>
                    <option v-for="bln in listbln" :key="bln.key" v-bind:value="bln.key">
                        {{bln.val}}
                    </option>
                </select>
                <br>
                Tahun
                <input type="number" name="tahun" class="form-control" v-model="tahun" placeholder="Masukkan tahun" 
                autocomplete="off">
                <br>

                <!-- Button -->
                <button class="button-add" style="float: left" @click="getreport()">
                    <span class="button-text">Show</span>
                </button>
            </div>

            <div class="report rp-2">
                <!-- <vue-html2pdf
                    :show-layout                    = "true"
                    :float-layout                   = "false"
                    :enable-download                = "false"
                    :preview-modal                  = "true"
                    :paginate-elements-by-height    = "1400"
                    filename                        = "laporan_spp"
                    :pdf-quality                    = "2"
                    :manual-pagination              = "false"
                    pdf-format                      = "a4"
                    pdf-orientation                 = "portrait"
                    pdf-content-width               = "800px"
                    ref                             = "html2Pdf"
                > -->
                    <section>
                        <!-- </vue-html2pdf> -->
                        <!-- Title -->
                        <h1>Laporan SPP</h1>
                        <h3>SMK Telkom Malang</h3>
                        <h5>Jl. Danau Ranau, Sawojajar, Kec. Kedungkandang, Kota Malang, Jawa Timur</h5>

                        <!-- Table -->
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>ID Petugas</th>
                                    <th>NISN</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Bulan SPP</th>
                                    <th>Tahun SPP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rep in report" :key="rep.id_pembayaran">
                                    <td>{{rep.id_petugas}}</td>
                                    <td>{{rep.nisn}}</td>
                                    <td>{{rep.tgl_bayar}}</td>
                                    <td>{{rep.bulan_spp}}</td>
                                    <td>{{rep.tahun_spp}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                <!-- <button class="button-add" style="float: left" @click="addsiswa()">
                    <span class="button-text">Generate</span>
                </button> -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Report",
        data() {
            return {
                bulan:'',
                tahun:'',
                listbln:[
                    {key:"Januari", val:"Januari"}, {key:"Februari", val:"Februari"}, {key:"Maret", val:"Maret"},
                    {key:"April", val:"April"}, {key:"Mei", val:"Mei"}, {key:"Juni", val:"Juni"},
                    {key:"Juli", val:"Juli"}, {key:"Agustus", val:"Agustus"}, {key:"September", val:"September"},
                    {key:"Oktober", val:"Oktober"}, {key:"November", val:"November"}, {key:"Desember", val:"Desember"}
                ],
                report:[]
            }
        },

        methods: {
            getreport() {
                var option = {
                    headers:{
                        'Authorization':'bearer ' + localStorage.getItem("token")
                    }
                }

                var data = {
                    bulan:this.bulan,
                    tahun:this.tahun,
                }

                this.axios.post("http://localhost/lat_spp/public/api/report", data, option).then((result) => {
                    // console.log(result)
                    this.report = result.data
                })
            }
        }
    }
</script>