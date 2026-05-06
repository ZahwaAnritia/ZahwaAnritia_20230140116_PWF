<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Header --}}
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('category.index') }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold dark:text-white">Add Category</h2>
                </div>

                {{-- Form Store --}}
                <form action="{{ route('category.store') }}" method="POST" class="space-y-6">
                    @csrf {{-- Pengaman agar tidak error 419 --}}
                    
                    <div>
                        <label for="name" class="block text-sm font-medium dark:text-gray-300">Category Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Elektronik, Pakaian, dll" 
                            class="w-full mt-1 px-4 py-2 rounded-lg border dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none transition @error('name') border-red-500 @enderror" required autofocus>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                        <a href="{{ route('category.index') }}" class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold shadow-md transition">
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>