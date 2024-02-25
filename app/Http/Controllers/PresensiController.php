<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->count();
        return view('presensi.create', compact('cek'));
    }
    public function store(Request $request)
    {
        $nim            = Auth::guard('mahasiswa')->user()->nim;
        $tgl_presensi   = date('Y-m-d');
        $jam            = date('h:i:s');
        // jakarta -6.22592,106.8302336
        // sukabumi 6.9534653,107.0355653
        $latitudekantor = -6.22592;
        $langitudekantor = 106.8302336;
        $lokasi         = $request->lokasi;
        $lokasiuser     = explode(',', $lokasi);
        $latitudeuser   = $lokasiuser[0];
        $longitudeuser  = $lokasiuser[1];

        $jarak          = $this->distance($latitudekantor, $langitudekantor, $latitudeuser, $longitudeuser);
        $radius         = round($jarak['meters']);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->count();
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image          = $request->image;
        $folderPath     = 'public/uploads/absensi/';
        $formatName     =  $nim . '-' . $tgl_presensi . '-' . $ket;
        $image_parts    = explode(";base64", $image);
        $image_base64   = base64_decode($image_parts[1]);
        $fileName       = $formatName . ".png";
        $file           = $folderPath . $fileName;
        if ($radius > 50) {
            echo "error|Maaf... Anda Berada diluar Radius yaitu " . $radius . " Meter dari Kampus|radius";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out'        => $jam,
                    'foto_out'       => $fileName,
                    'lokasi_out'     => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->update($data_pulang);
                if ($update) {
                    echo "success|Terimakasih, Hati Hati Dijalan|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Gagal Login, Silahkan Coba Lagi!|in";
                }
            } else {
                $data = [
                    'nim'           => $nim,
                    'tgl_presensi'  => $tgl_presensi,
                    'jam_in'        => $jam,
                    'foto_in'       => $fileName,
                    'lokasi_in'     => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Terimakasih, Selamat Belajar|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Gagal Login, Silahkan Coba Lagi!|in";
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    function editprofile()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        return view('presensi.editprofile', compact('mahasiswa'));
    }

    function updateprofile(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        if ($request->hasFile('foto')) {
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $mahasiswa->foto;
        }

        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('mahasiswa')->where('nim', $nim)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/mahasiswa/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal di Update']);
        }
    }
}