<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    // alamat API server (project server harus jalan di port 8000)
    private string $api = 'http://127.0.0.1:8000/api/v1/users';

    // field yang dikirim ke server
    private array $fields = [
        'name', 'email', 'password', 'address', 'house_number',
        'phone_number', 'city', 'roles',
    ];

    // aturan validasi di sisi client
    private array $rules = [
        'name'         => 'required',
        'email'        => 'required|email',
        'password'     => 'required',
        'address'      => 'required',
        'house_number' => 'required',
        'phone_number' => 'required',
        'city'         => 'required',
        'roles'        => 'required',
    ];

    // pesan error lengkap: teks bawaan + kode HTTP + isi jawaban server
    private function pesanError($response, string $default): string
    {
        $json  = $response->json();
        $pesan = $default;

        if (!empty($json['message'])) {
            $pesan .= ' ' . $json['message'];
        }

        if (!empty($json['errors'])) {
            $pesan .= ' ' . collect($json['errors'])->flatten()->implode(' ');
        }

        $pesan .= ' [HTTP ' . $response->status() . ': '
               . Str::limit($response->body(), 250) . ']';

        return $pesan;
    }

    // READ - daftar user
    public function index(): View
    {
        $response = Http::acceptJson()->get($this->api)->json();

        return view('users.index', ['data' => $response['data'] ?? []]);
    }

    // CREATE - tampilkan form tambah
    public function create(): View
    {
        return view('users.create');
    }

    // CREATE - simpan data
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->rules);

        try {
            $response = Http::acceptJson()->post($this->api, $request->only($this->fields));
        } catch (\Throwable $e) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['api' => 'Server API tidak bisa dihubungi: ' . $e->getMessage()]);
        }

        $json = $response->json();

        if ($response->successful() && (($json['success'] ?? false) === true)) {
            return redirect()->route('users.index')->with('success', 'Data Berhasil Disimpan!');
        }

        return back()
            ->withInput($request->except('password'))
            ->withErrors(['api' => $this->pesanError($response, 'Data gagal disimpan!')]);
    }

    // tombol EDIT di tabel memanggil show -> diarahkan ke form edit
    public function show(string $id): RedirectResponse
    {
        return redirect()->route('users.edit', $id);
    }

    // UPDATE - tampilkan form edit
    public function edit(string $id): View|RedirectResponse
    {
        $response = Http::acceptJson()->get($this->api . '/' . $id);
        $json     = $response->json();

        if (!$response->successful() || empty($json['data'])) {
            return redirect()->route('users.index')
                ->with('error', $this->pesanError($response, 'Data user tidak ditemukan!'));
        }

        return view('users.edit', ['user' => $json['data']]);
    }

    // UPDATE - simpan perubahan
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate($this->rules);

        try {
            $response = Http::acceptJson()->put($this->api . '/' . $id, $request->only($this->fields));
        } catch (\Throwable $e) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['api' => 'Server API tidak bisa dihubungi: ' . $e->getMessage()]);
        }

        $json = $response->json();

        if ($response->successful() && (($json['success'] ?? false) === true)) {
            return redirect()->route('users.index')->with('success', 'Data Berhasil Diubah!');
        }

        return back()
            ->withInput($request->except('password'))
            ->withErrors(['api' => $this->pesanError($response, 'Data gagal diubah!')]);
    }

    // DELETE - hapus data
    public function destroy(string $id): RedirectResponse
    {
        $response = Http::acceptJson()->delete($this->api . '/' . $id);
        $json     = $response->json();

        if ($response->successful() && (($json['success'] ?? false) === true)) {
            return redirect()->route('users.index')->with('success', 'Data Berhasil Dihapus!');
        }

        return redirect()->route('users.index')
            ->with('error', $this->pesanError($response, 'Data gagal dihapus!'));
    }
}