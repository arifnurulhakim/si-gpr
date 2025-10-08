@extends('layouts.app')

@section('title', 'Edit Rumah Warga - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Rumah Warga</h1>
        <a href="{{ route('resident-blocks.index') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <form action="{{ route('resident-blocks.update', $residentBlock->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                    <div>
                        <label for="block" class="block text-sm font-medium text-gray-700">Blok</label>
                        <input type="text" name="block" id="block" value="{{ old('block', $residentBlock->block) }}" required maxlength="10"
                               placeholder="Contoh: D1-12 atau D1-12A"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        <p class="mt-1 text-sm text-gray-500">Format: Huruf-Angka-Angka atau Huruf-Angka-Angka-Huruf (contoh: D1-12 atau D1-12A)</p>
                        @error('block')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="resident_id" class="block text-sm font-medium text-gray-700">Warga</label>
                        <select name="resident_id" id="resident_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                            <option value="">Pilih Warga</option>
                            @foreach($availableResidents as $resident)
                                <option value="{{ $resident->id }}" {{ old('resident_id', $residentBlock->resident_id) == $resident->id ? 'selected' : '' }}>
                                    {{ $resident->name }} ({{ $resident->nik }})
                                </option>
                            @endforeach
                        </select>
                        @error('resident_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('resident-blocks.index') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Update Rumah Warga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add search functionality to resident dropdown
    const residentSelect = document.getElementById('resident_id');
    const originalOptions = Array.from(residentSelect.options);

    // Create search input
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Cari warga...';
    searchInput.className = 'mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3';
    searchInput.autocomplete = 'off';

    // Set initial value
    const selectedOption = residentSelect.options[residentSelect.selectedIndex];
    if (selectedOption && selectedOption.value !== '') {
        searchInput.value = selectedOption.textContent;
    }

    // Create dropdown container
    const dropdownContainer = document.createElement('div');
    dropdownContainer.className = 'relative';

    // Wrap select in container
    residentSelect.parentNode.insertBefore(dropdownContainer, residentSelect);
    dropdownContainer.appendChild(searchInput);
    dropdownContainer.appendChild(residentSelect);

    // Hide select initially
    residentSelect.style.display = 'none';

    // Create dropdown list
    const dropdownList = document.createElement('div');
    dropdownList.className = 'absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto hidden';
    dropdownContainer.appendChild(dropdownList);

    // Populate dropdown list
    function populateDropdownList(options) {
        dropdownList.innerHTML = '';
        options.forEach(option => {
            if (option.value !== '') {
                const item = document.createElement('div');
                item.className = 'px-3 py-2 cursor-pointer hover:bg-indigo-50 hover:text-indigo-700';
                item.textContent = option.textContent;
                item.dataset.value = option.value;

                // Highlight current selection
                if (option.value === residentSelect.value) {
                    item.classList.add('bg-indigo-100');
                }

                item.addEventListener('click', function() {
                    searchInput.value = option.textContent;
                    residentSelect.value = option.value;
                    dropdownList.classList.add('hidden');
                });

                dropdownList.appendChild(item);
            }
        });
    }

    // Initial population
    populateDropdownList(originalOptions);

    // Show dropdown on focus
    searchInput.addEventListener('focus', function() {
        dropdownList.classList.remove('hidden');
    });

    // Filter options based on search
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const filteredOptions = originalOptions.filter(option =>
            option.textContent.toLowerCase().includes(searchTerm)
        );

        populateDropdownList(filteredOptions);
        dropdownList.classList.remove('hidden');
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdownContainer.contains(event.target)) {
            dropdownList.classList.add('hidden');
        }
    });

    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        const items = dropdownList.querySelectorAll('div[data-value]');
        const currentIndex = Array.from(items).findIndex(item => item.classList.contains('bg-indigo-100'));

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
            items.forEach((item, index) => {
                item.classList.toggle('bg-indigo-100', index === nextIndex);
            });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
            items.forEach((item, index) => {
                item.classList.toggle('bg-indigo-100', index === prevIndex);
            });
        } else if (e.key === 'Enter') {
            e.preventDefault();
            const selectedItem = dropdownList.querySelector('.bg-indigo-100');
            if (selectedItem) {
                selectedItem.click();
            }
        } else if (e.key === 'Escape') {
            dropdownList.classList.add('hidden');
        }
    });
});
</script>
@endsection
