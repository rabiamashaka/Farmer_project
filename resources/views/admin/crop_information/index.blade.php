@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Crop Information</h2>
    <a href="{{ route('admin.cropinfo.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded">Add New</a>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <table class="w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Crop</th>
                <th class="p-2 border">Type</th>
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($infos as $info)
                <tr>
                    <td class="p-2 border">{{ $info->crop->name }}</td>
                    <td class="p-2 border capitalize">{{ $info->type }}</td>
                    <td class="p-2 border">{{ $info->title }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.cropinfo.edit', $info) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.cropinfo.destroy', $info) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this info?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $infos->links() }}</div>
</div>
@endsection 