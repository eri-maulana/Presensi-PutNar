@if ($dataizin->isEmpty())
    <div class="alert alert-outline-warning">
        <p class="text-center">Belum Ada Data Pengajuan Cuti</p>
    </div>
@endif
@foreach ($dataizin as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                {{-- <img src="{{ url($path) }}" alt="image" class="image"> --}}
                <div class="in">
                    <div>
                        <b class="text-lg">{{ date("d-m-Y",strtotime($d->tgl_izin)) }} - ( <em>{{ $d->status == "i" ? "Izin" : "Sakit" }}</em> ) </b><br>
                        <small class="text-muted text-sm">{{ $d->keterangan }}</small>
                    </div>
                    @if ($d->status_approved == 0)
                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                    @elseif($d->status_approved == 1)
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($d->status_approved == 2)
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
            </div>
        </li>
    </ul>
@endforeach
