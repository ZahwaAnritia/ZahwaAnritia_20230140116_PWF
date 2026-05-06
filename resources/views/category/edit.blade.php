<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold mb-6 dark:text-white">Edit Category</h2>
                <form action="{{ route('category.update', $category->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm dark:text-gray-300">Category Name</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="w-full mt-1 dark:bg-gray-700 dark:text-white rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('category.index') }}" class="px-4 py-2 text-gray-500">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>