@extends('layouts.presensi')

@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('mahasiswa')->user()->foto))
                    @php
                        $pathprofile = Storage::url('uploads/mahasiswa/' . Auth::guard('mahasiswa')->user()->foto);
                    @endphp
                    <img src="{{ url($pathprofile) }}" alt="avatar" class="imaged w64 rounded">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('mahasiswa')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('mahasiswa')->user()->kelas }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="text-secondary" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izin" class="text-secondary" style="font-size: 40px;">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/histori" class="text-secondary" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="text-secondary" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card" style="background-color: #B0DB9C">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url("uploads/absensi/$presensihariini->foto_in");
                                        @endphp
                                        <img src="{{ asset($path) }}" alt="foto absen masuk" class="imaged w64">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail ">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span class="text-white">{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card " style="background-color: #AF3E3E;" >
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null && $presensihariini->jam_out)
                                        @php
                                            $path_out = Storage::url("uploads/absensi/$presensihariini->foto_out");
                                        @endphp
                                        <img src="{{ url($path_out) }}" alt="foto absen keluar" class="imaged w64">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail  ">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span class="text-white">{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekappresensi">
            <h3>Rekap Presensi {{ $namabulan[$bulanini] . ' ' . $tahunini }}</h3>
            <div class="row ">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body p-1 text-center">
                            <span class="badge b position-absolute  text-white" style="top: 2px; left: 9px;z-index: 9;background-color: #B0DB9C">
                                {{ $rekappresensi->jmlhadir }}
                            </span>
                            <ion-icon name="calendar-outline" style="font-size: 1.8rem" class="text-secondary"></ion-icon>
                            <span class="d-block mt-0">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body p-1 text-center">
                            <span class="badge  position-absolute  text-white"
                                style="top: 2px; left: 9px;z-index: 9; background-color: #FFDF88"">{{ $rekapizin->jmlizin }}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.8rem" class=" text-secondary"></ion-icon>
                            <span class="d-block mt-0">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body p-1 text-center">
                            <span class="badge position-absolute  text-white"
                                style="top: 2px; left: 9px;z-index: 9; background-color: #FFDDAB;">{{ $rekapizin->jmlsakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.8rem" class="text-secondary"></ion-icon>
                            <span class="d-block mt-0">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body p-1 text-center">
                            <span class="badge position-absolute  text-white" style="top: 2px; left: 9px;z-index: 9; background-color: #BF3131;">
                                {{ $rekappresensi->jmlterlambat }}
                            </span>
                            <ion-icon name="alarm-outline" style="font-size: 1.8rem" class="text-secondary"></ion-icon>
                            <span class="d-block mt-0">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Presensi Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:50px;margin-top:50px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historibulanini as $d)
                            <li>
                                <div class="item">

                                    <div class="icon-box text-white" style="background-color: #B0DB9C">
                                        <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>

                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>
                                        <div class="text-center">
                                            <span class="badge " style="color: #B0DB9C">{{ $d->jam_in }}</span>
                                            <br>
                                            <span
                                                class="mt-1 badge "  style="color: #AF3E3E">{{ ($d->jam_out != null) ? $d->jam_out : 'Belum Absen' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-pane fade " id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $lead)
                            @if (empty($leaderboard))
                                <div class="alert alert-warning">Data leaderboard kosong!</div>
                            @endif
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b class="text-lg">{{ $lead->nama_lengkap }}</b> <br>
                                            <small class="text-muted text-sm">{{ $lead->kelas }}</small>
                                        </div>
                                        <span class="badge {{ $lead->jam_in < '07:00' ? 'text-primary' : 'orange' }}">
                                            {{ $lead->jam_in }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
