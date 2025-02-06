<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <img src="<?= base_url('../assets/assets/images/logouns.png') ?>" alt="" width="60" height="60">
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?=base_url('admin/dashboard')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Master</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('staf')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Staf</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('mahasiswa')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Mahasiswa</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('mata-kuliah')?>">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Mata Kuliah</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('mitra')?>">
                    <i class="fe fe-codepen fe-16"></i>
                    <span class="ml-3 item-text">Mitra</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mb-2">
            <span>Daftar Sistem D3 TI</span>
        </p>
        <!-- SIPEMA -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#sipema">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">SIPEMA</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="sipema">
                    <!-- <h6>Menu tidak diizinkan diakses oleh Admin (Prodi)</h6> -->
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/bidang')?>"><span class="ml-1 item-text">Data
                                Bidang</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/sub-bidang')?>"><span
                                class="ml-1 item-text">Data
                                Subidang</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/bobot')?>"><span class="ml-1 item-text">Data
                                Bobot</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/pemetaan_mata_kuliah')?>"><span
                                class="ml-1 item-text">Pemetaan Mata Kuliah</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/nilai')?>"><span class="ml-1 item-text">Data
                                Nilai</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/rekomendasi')?>"><span
                                class="ml-1 item-text">Rekomendasi
                                Mahasiswa</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('sipema/hasil_pemetaan_keterampilan')?>"><span
                                class="ml-1 item-text">Hasil
                                Pemetaan</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- MBKM -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#mbkm">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">MBKM</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="mbkm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/berkas')?>"><span class="ml-1 item-text">Data
                                Berkas</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/msib')?>"><span class="ml-1 item-text">Data
                                MSIB</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/mbkmProdi')?>"><span
                                class="ml-1 item-text">Data
                                MBKM Prodi</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/hibah')?>"><span class="ml-1 item-text">Data
                                Hibah UNS</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/mbkmFix')?>"><span class="ml-1 item-text">Data
                                MBKM Aktif</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/monitoring')?>"><span
                                class="ml-1 item-text">Monitoring</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/pertanyaan')?>"><span
                                class="ml-1 item-text">Data Indikator Penilaian</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/penilaian')?>"><span
                                class="ml-1 item-text">Data Penilaian</span></a>
                    </li>


                </ul>
            </li>
        </ul>
        <!-- KMM -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#kmm">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">KMM</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="kmm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('kmm/berkas')?>"><span class="ml-1 item-text">Data
                                Berkas</span></a>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-4 w-100" id="kmm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('kmm/pertanyaan-penilaian')?>"><span
                                class="ml-1 item-text">Data Indikator Penilaian</span></a>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-4 w-100" id="kmm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('kmm/bobot')?>"><span class="ml-1 item-text">Data
                                Bobot
                                Penilaian</span></a>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-4 w-100" id="kmm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('kmm/kmm')?>"><span class="ml-1 item-text">Data
                                KMM</span></a>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-4 w-100" id="kmm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('kmm/seminar')?>"><span class="ml-1 item-text">Data
                                Seminar KMM</span></a>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-4 w-100" id="kmm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('kmm/penilaian')?>"><span class="ml-1 item-text">Data
                                Penilaian KMM</span></a>
                    </li>
                </ul>
            </li>
        </ul>

        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#tracer">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">Tracer Study</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="tracer">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/agenda')?>"><span class="ml-1 item-text">Data
                                Agenda</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/tahun')?>"><span class="ml-1 item-text">Data
                                Tahun</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/tips_karir')?>"><span
                                class="ml-1 item-text">Data
                                Tips Karir</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/alumni_berprestasi')?>"><span
                                class="ml-1 item-text">Data
                                Alumni Berprestasi</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/lowongan_kerja')?>"><span
                                class="ml-1 item-text">Data
                                Lowongan Kerja</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/informasi_magang')?>"><span
                                class="ml-1 item-text">Data
                                Informasi Magang</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/jenis_kuesioner')?>"><span
                                class="ml-1 item-text">Jenis Kuesioner</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span
                                class="ml-1 item-text">Pertanyaan Kuesioner</span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?=base_url('tracer/pertanyaan_kuesioner')?>">type radio</a>
                            <a class="dropdown-item" href="<?=base_url('tracer/pertanyaan_isian')?>">type isian</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/jadwal_kuesioner')?>"><span
                                class="ml-1 item-text">Jadwal Kuesioner</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/faq')?>"><span class="ml-1 item-text">Data
                                Faq</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('tracer/cms')?>"><span class="ml-1 item-text">Data
                                CMS</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- TA -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#simta">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">TA</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="simta">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/timeline')?>"><span 
                        class="ml-1 item-text">Timeline</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/berkas')?>"><span 
                        class="ml-1 item-text">Data Berkas</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/taterdahulu')?>"><span
                                class="ml-1 item-text">Data TA Terdahulu</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/pengajuanjudul')?>"><span
                                class="ml-1 item-text">Data Pengajuan Judul</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/pengajuanbimbingan')?>"><span
                                class="ml-1 item-text">Data Pengajuan Bimbingan</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/ujianproposal')?>"><span
                                class="ml-1 item-text">Data Ujian Proposal</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/seminarhasil')?>"><span
                                class="ml-1 item-text">Data Seminar Hasil</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/ujianta')?>"><span 
                        class="ml-1 item-text">Data Ujian TA</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/bobotpenilaian')?>"><span
                                class="ml-1 item-text">Data Bobot Penilaian</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('simta/penilaianakhir')?>"><span 
                        class="ml-1 item-text">Data Penilaian Akhir</span></a>
                    </li>

                </ul>
            </li>
        </ul>

        <!-- TIMELINEREMINDER -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link"
                    href="#timelinereminder">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-1 item-text">Agenda Prodi</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="timelinereminder">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('timelinereminder/agenda')?>"><span
                                class="ml-1 item-text">Agenda</span></a>
                    </li>

                </ul>
            </li>
        </ul>

        <!-- BOT -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#bot">
                    <i class="fe fe-message-circle fe-16"></i>
                    <span class="ml-1 item-text">Chatbot</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="bot">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/blast_chat')?>"><span
                                class="ml-1 item-text">Blast
                                Chat</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/kelola_bot')?>"><span
                                class="ml-1 item-text">Kelola
                                Chatbot</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/kelola_bot/user/mahasiswa')?>"><span
                                class="ml-1 item-text">Chatbot User Mahasiswa</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/kelola_bot/user/staf')?>"><span
                                class="ml-1 item-text">Chatbot User Staf</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/register_app')?>"><span
                                class="ml-1 item-text">Register API
                                Chatbot</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/log/notifikasi')?>"><span
                                class="ml-1 item-text">Notifikasi Log</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/log/notifikasi_kegiatan')?>"><span
                                class="ml-1 item-text">Notifikasi Kegiatan Log</span></a>
                    </li>
                </ul>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Manajemen Akun</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('group')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Role</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('users')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">User</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>