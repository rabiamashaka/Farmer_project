@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Add Crop Information</h2>
    <form method="POST" action="{{ route('admin.cropinfo.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block font-semibold">Crop</label>
            <select name="crop_id" class="w-full border rounded p-2" required>
                <option value="">Sezzzzlect crop</option>
                @foreach($crops as $crop)
                    <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold">Type</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="tip">Farming Tip</option>
                <option value="pest_control">Pest Control</option>
                <option value="design">Design</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded p-2" rows="4" required></textarea>
        </div>
        <div>
            <label class="block font-semibold">Image (optional)</label>
            <input type="file" name="image" class="w-full">
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
        <a href="{{ route('admin.cropinfo.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection 