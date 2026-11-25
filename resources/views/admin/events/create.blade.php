@extends('layouts.app')

@section('title', 'Tambah Event')

@section('hide-header', '1')

@section('content')
    <h1>Tambah Event</h1>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="form-event">
        @csrf

        @include('admin.events._form')

        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('admin.events.index') }}" class="btn">Batal</a>
    </form>
@endsection