@if ($histori->isEmpty())
    <div class="alert alert-outline-warning">
        <p class="text-center">Belum Ada Data Presensi</p>
    </div>
@endif
@foreach ($histori as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                 $path = Storage::url('uploads/absensi/'.$d->foto_in)   
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b class="text-lg">{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b> <br>
                        {{-- <small class="text-muted text-sm">{{ $d->kelas }}</small> --}}
                    </div>
                    <span
                        class="badge {{ $d->jam_in < '07:00' ? 'bg-primary' : 'bg-warning' }}">{{ $d->jam_in }}</span>
                    <span class="badge bg-danger">{{ $d->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach
