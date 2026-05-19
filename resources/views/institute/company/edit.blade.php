<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company Profile') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('institute.company.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Company Name</label>
                        <input type="text" name="name" value="{{ $company->name }}" class="w-full border-gray-300 rounded" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-2">Website</label>
                            <input type="text" name="website" value="{{ $company->website }}" class="w-full border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block font-bold mb-2">Location</label>
                            <input type="text" name="location" value="{{ $company->location }}" class="w-full border-gray-300 rounded">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border-gray-300 rounded" rows="5">{{ $company->description }}</textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold hover:bg-indigo-700">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
