<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border mb-6">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="flex space-x-4">
                    @csrf
                    <input type="text" name="name" placeholder="Category Name" class="border-gray-300 rounded flex-1" required>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Category</button>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Name</th>
                            <th class="p-4">Slug</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                        <tr class="border-t">
                            <td class="p-4 font-bold">{{ $cat->name }}</td>
                            <td class="p-4">{{ $cat->slug }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="text-xs bg-gray-200 text-gray-700 px-3 py-1.5 rounded font-bold hover:bg-gray-300">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded font-bold hover:bg-red-200" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
