@props(['topics'])


<div
    x-data="{ isOpen: false }"
    x-init="() => {
        if ({{ ($errors->has('pertanyaan') || $errors->has('jawaban') || $errors->has('faq_topic_id')) && old('modal_source') == 'create' ? 'true' : 'false' }}) {
            isOpen = true;
        }
    }"
    @open-create-modal.window="isOpen = true"
    @keydown.escape.window="isOpen = false"
    x-show="isOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-gray-800 bg-opacity-75"
>
    {{-- Panel Modal --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.outside="isOpen = false"
        class="w-full max-w-lg bg-white rounded-lg shadow-2xl"
    >
        {{-- Header Modal --}}
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Buat Pertanyaan Baru</h3>
            {{-- Tombol close sekarang mengubah state lokal 'isOpen' --}}
            <button @click="isOpen = false" class="p-1 text-gray-500 rounded-full hover:bg-gray-200 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.faq.store') }}" method="POST">
            @csrf
            <input type="hidden" name="modal_source" value="create">

            <div class="p-6 space-y-6">

                {{-- Dropdown Topik dengan x-data-nya sendiri (ini tidak masalah, karena nested) --}}
                <div x-data="{
                        open: false,
                        selectedTopicId: '{{ old('faq_topic_id', '') }}',
                        selectedTopicName: 'Pilih sebuah topik',
                        topics: {{ $topics->map(function($topic) { return ['id' => $topic->id, 'name' => $topic->name]; })->toJson() }},
                        searchTerm: '',
                        get filteredTopics() {
                            if (this.searchTerm === '') { return this.topics; }
                            return this.topics.filter(topic => topic.name.toLowerCase().includes(this.searchTerm.toLowerCase()));
                        },
                        selectTopic(topic) {
                            this.selectedTopicId = topic.id;
                            this.selectedTopicName = topic.name;
                            this.open = false;
                        },
                        init() {
                            if (this.selectedTopicId) {
                                const foundTopic = this.topics.find(t => t.id == this.selectedTopicId);
                                if (foundTopic) { this.selectedTopicName = foundTopic.name; }
                            }
                        }
                    }"
                    x-init="init()"
                    class="relative">
                    <label for="faq_topic_id" class="block text-sm font-medium text-gray-700">Nama Topics</label>
                    <input type="hidden" name="faq_topic_id" x-model="selectedTopicId">
                    <button type="button" @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 mt-1 text-left text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white">
                        <span x-text="selectedTopicName"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                        <div class="p-2">
                            <input type="text" x-model="searchTerm" placeholder="Cari topik..." class="w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:ring-[#028579] focus:border-[#028579]">
                        </div>
                        <ul>
                            <template x-for="topic in filteredTopics" :key="topic.id">
                                <li @click="selectTopic(topic)" class="px-4 py-2 text-sm text-gray-800 cursor-pointer hover:bg-[#028579] hover:text-white" :class="{ 'bg-gray-100': selectedTopicId == topic.id }">
                                    <span x-text="topic.name"></span>
                                </li>
                            </template>
                            <template x-if="filteredTopics.length === 0">
                                <li class="px-4 py-2 text-sm text-center text-gray-500">Topik tidak ditemukan.</li>
                            </template>
                        </ul>
                    </div>
                    @error('faq_topic_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Pertanyaan --}}
                <div>
                    <label for="pertanyaan" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                    <input type="text" name="pertanyaan" value="{{ old('pertanyaan') }}" class="w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white" placeholder="Tulis pertanyaan di sini...">
                    @error('pertanyaan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Jawaban --}}
                <div>
                    <label for="jawaban" class="block text-sm font-medium text-gray-700">Jawaban</label>
                    <textarea name="jawaban" rows="6" class="w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white" placeholder="Tulis jawaban lengkap di sini...">{{ old('jawaban') }}</textarea>
                    @error('jawaban')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Footer Modal (Tombol Aksi) --}}
            <div class="flex items-center justify-end p-5 space-x-3 border-t bg-gray-50 rounded-b-lg">
                 {{-- Tombol Batal sekarang mengubah state lokal 'isOpen' --}}
                <button type="button" @click="isOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#028579]">
                    Simpan Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>
