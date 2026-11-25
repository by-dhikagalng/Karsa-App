@if ($organizations->isNotEmpty())
    <div class="form-group">
        <label for="organization_id">Organisasi</label>
        <select id="organization_id" name="organization_id">
            <option value="">-- Pilih organisasi --</option>
            @foreach ($organizations as $id => $nama)
                <option value="{{ $id }}" @selected(old('organization_id', $event->organization_id) == $id)>{{ $nama }}</option>
            @endforeach
        </select>
        @error('organization_id') <span class="form-error">{{ $message }}</span> @enderror
    </div>
@endif

<div class="form-group">
    <label for="title">Judul</label>
    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}">
    @error('title') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="category">Kategori</label>
    <select id="category" name="category">
        <option value="">-- Pilih kategori --</option>
        @foreach ($categories as $kode => $label)
            <option value="{{ $kode }}" @selected(old('category', $event->category) == $kode)>{{ $label }}</option>
        @endforeach
    </select>
    @error('category') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description" rows="5">{{ old('description', $event->description) }}</textarea>
    @error('description') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="location">Lokasi</label>
    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}">
    @error('location') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="event_date">Tanggal Acara</label>
    <input type="date" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}">
    @error('event_date') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="registration_deadline">Deadline Pendaftaran</label>
    <input type="date" id="registration_deadline" name="registration_deadline" value="{{ old('registration_deadline', $event->registration_deadline?->format('Y-m-d')) }}">
    @error('registration_deadline') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="registration_url">Tautan Pendaftaran</label>
    <input type="text" id="registration_url" name="registration_url" placeholder="https://..." value="{{ old('registration_url', $event->registration_url) }}">
    @error('registration_url') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="poster">Poster (JPG/PNG/WEBP, maks. 2 MB)</label>
    <input type="file" id="poster" name="poster" accept="image/jpeg,image/png,image/webp">
    @error('poster') <span class="form-error">{{ $message }}</span> @enderror
</div>