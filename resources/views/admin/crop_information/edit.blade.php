@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Edit Crop Information</h2>
    <form method="POST" action="{{ route('admin.cropinfo.update', $cropinfo) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold">Crop</label>
            <select name="crop_id" class="w-full border rounded p-2" required>
                @foreach($crops as $crop)
                    <option value="{{ $crop->id }}" @if($cropinfo->crop_id == $crop->id) selected @endif>{{ $crop->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold">Type</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="tip" @if($cropinfo->type == 'tip') selected @endif>Farming Tip</option>
                <option value="pest_control" @if($cropinfo->type == 'pest_control') selected @endif>Pest Control</option>
                <option value="design" @if($cropinfo->type == 'design') selected @endif>Design</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" value="{{ $cropinfo->title }}" required>
        </div>
        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded p-2" rows="4" required>{{ $cropinfo->description }}</textarea>
        </div>
        <div>
            <label class="block font-semibold">Image (optional)</label>
            <input type="file" name="image" class="w-full">
            @if($cropinfo->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $cropinfo->image_path) }}" alt="Current Image" class="w-32 h-32 object-cover rounded">
                </div>
            @endif
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('admin.cropinfo.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection 