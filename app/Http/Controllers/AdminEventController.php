<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminEventController extends Controller
{
    // Menampilkan daftar event: admin ormawa hanya miliknya, super admin semua
    public function index()
    {
        $user = auth()->user();

        $events = Event::with('organization')
            ->when(! $user->isSuperAdmin(), fn ($query) => $query->where('organization_id', $user->organization_id))
            ->orderByDesc('event_date')
            ->paginate(10);

        return view('admin.events.index', [
            'events' => $events,
            'categories' => Event::CATEGORIES,
        ]);
    }

    // Menampilkan form tambah event
    public function create()
    {
        return view('admin.events.create', [
            'event' => new Event(),
            'categories' => Event::CATEGORIES,
            'organizations' => $this->daftarOrganisasi(),
        ]);
    }

    // Memvalidasi lalu menyimpan event baru beserta posternya dalam satu transaksi
    public function store(Request $request)
    {
        $request->merge(['title' => $this->rapikanJudul($request->input('title'))]);

        $validated = $request->validate(
            $this->aturanValidasi($request),
            $this->pesanValidasi(),
            $this->namaKolom()
        );

        $validated['organization_id'] = $this->organisasiId($request);
        unset($validated['poster']);

        $posterPath = null;

        try {
            DB::transaction(function () use ($request, &$validated, &$posterPath) {
                $posterPath = $this->pindahkanPoster($request);
                $validated['poster_path'] = $posterPath;

                Event::create($validated);
            });
        } catch (\Throwable $e) {
            $this->hapusPoster($posterPath);
            throw $e;
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event "' . $validated['title'] . '" berhasil ditambahkan.');
    }

    // Menampilkan form ubah event (hanya pemilik atau super admin)
    public function edit(Event $event)
    {
        $this->pastikanPemilik($event);

        return view('admin.events.edit', [
            'event' => $event,
            'categories' => Event::CATEGORIES,
            'organizations' => $this->daftarOrganisasi(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $this->pastikanPemilik($event);

        $request->merge(['title' => $this->rapikanJudul($request->input('title'))]);

        $validated = $request->validate(
            $this->aturanValidasi($request, $event),
            $this->pesanValidasi(),
            $this->namaKolom()
        );

        $validated['organization_id'] = $this->organisasiId($request);
        unset($validated['poster']);

        $posterLama = $event->poster_path;
        $posterBaru = null;

        try {
            DB::transaction(function () use ($request, $event, &$validated, &$posterBaru) {
                $posterBaru = $this->pindahkanPoster($request);

                if ($posterBaru) {
                    $validated['poster_path'] = $posterBaru;
                }

                $event->update($validated);
            });
        } catch (\Throwable $e) {
            $this->hapusPoster($posterBaru);
            throw $e;
        }

        if ($posterBaru) {
            $this->hapusPoster($posterLama);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event "' . $event->title . '" berhasil diperbarui.');
    }

    // ===================== Helper =====================

        // Menolak akses (403) jika event bukan milik organisasi admin yang login
    private function pastikanPemilik(Event $event): void
    {
        $user = auth()->user();

        abort_unless(
            $user->isSuperAdmin() || (int) $event->organization_id === (int) $user->organization_id,
            403,
            'Kamu tidak berhak mengelola event organisasi lain.'
        );
    }

    // Menentukan organisasi pemilik event: super admin memilih, admin ormawa otomatis organisasinya
    private function organisasiId(Request $request): ?int
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return $request->filled('organization_id') ? (int) $request->input('organization_id') : null;
        }

        return $user->organization_id;
    }

    // Daftar organisasi untuk dropdown, hanya untuk super admin
    private function daftarOrganisasi()
    {
        return auth()->user()->isSuperAdmin()
            ? Organization::orderBy('name')->pluck('name', 'id')
            : collect();
    }

    // Merapikan spasi berlebih pada judul sebelum dicek duplikat
    private function rapikanJudul(?string $judul): string
    {
        return preg_replace('/\s+/', ' ', trim((string) $judul));
    }

    // Aturan validasi untuk tambah dan ubah event (saat ubah, id event sendiri diabaikan)
    private function aturanValidasi(Request $request, ?Event $event = null): array
    {
        $orgId = $this->organisasiId($request);

        $rules = [
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('events', 'title')
                    ->where(fn ($query) => $query
                        ->where('event_date', $request->input('event_date'))
                        ->where('organization_id', $orgId))
                    ->ignore($event?->id),
            ],
            'category' => ['required', Rule::in(array_keys(Event::CATEGORIES))],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'registration_deadline' => ['required', 'date', 'before_or_equal:event_date'],
            'registration_url' => ['required', 'url', 'max:255'],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if (auth()->user()->isSuperAdmin()) {
            $rules['organization_id'] = ['required', 'exists:organizations,id'];
        }

        return $rules;
    }

    // Pesan error validasi dalam bahasa Indonesia
    private function pesanValidasi(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'in' => ':attribute yang dipilih tidak valid.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'url' => ':attribute harus berupa tautan yang valid (diawali http:// atau https://).',
            'title.max' => 'Judul maksimal 255 karakter.',
            'location.max' => 'Lokasi maksimal 255 karakter.',
            'registration_url.max' => 'Tautan pendaftaran maksimal 255 karakter.',
            'title.unique' => 'Event dengan judul dan tanggal acara yang sama sudah ada di organisasi ini.',
            'registration_deadline.before_or_equal' => 'Deadline pendaftaran harus sama dengan atau sebelum tanggal acara.',
            'poster.uploaded' => 'Poster gagal diunggah. Coba lagi atau pilih file lain.',
            'poster.image' => 'Poster harus berupa gambar.',
            'poster.mimes' => 'Poster harus berformat JPG, PNG, atau WEBP.',
            'poster.max' => 'Ukuran poster maksimal 2 MB.',
        ];
    }

    // Nama kolom yang tampil di pesan error
    private function namaKolom(): array
    {
        return [
            'organization_id' => 'Organisasi',
            'title' => 'Judul',
            'category' => 'Kategori',
            'description' => 'Deskripsi',
            'location' => 'Lokasi',
            'event_date' => 'Tanggal acara',
            'registration_deadline' => 'Deadline pendaftaran',
            'registration_url' => 'Tautan pendaftaran',
            'poster' => 'Poster',
        ];
    }

    // Memindahkan poster ke public/posters dengan nama unik lalu mengembalikan path-nya (koordinasi dengan Arya)
    private function pindahkanPoster(Request $request): ?string
    {
        if (! $request->hasFile('poster')) {
            return null;
        }

        $file = $request->file('poster');
        $namaFile = time() . '_' . Str::random(8) . '.' . $file->extension();
        $file->move(public_path('posters'), $namaFile);

        return 'posters/' . $namaFile;
    }

    // Menghapus file poster dari folder public jika ada
    private function hapusPoster(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

        // Menghapus event beserta file posternya (file dihapus setelah baris database terhapus)
    public function destroy(Event $event)
    {
        $this->pastikanPemilik($event);

        $judul = $event->title;
        $posterPath = $event->poster_path;

        $event->delete();
        $this->hapusPoster($posterPath);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event "' . $judul . '" berhasil dihapus.');
    }
}