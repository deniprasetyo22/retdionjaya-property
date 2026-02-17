<div class="mt-16 bg-white">
    <div class="mx-auto max-w-7xl px-6 pt-8">

        <p class="text-md mb-3 font-semibold text-gray-500">
            <a href="{{ route('project-list') }}"class="hover:text-brand">
                Proyek
            </a>/ <span class="text-gray-900">Detail Proyek</span>
        </p>

        <!-- MAIN IMAGE -->
        {{-- PHP LOGIC: Normalisasi Data & Helper --}}
        @php
            $rawMedia = $project->media;
            $gallery = [];

            // Pastikan jadi array
            if (is_array($rawMedia)) {
                $gallery = $rawMedia;
            } elseif (is_string($rawMedia)) {
                $decoded = json_decode($rawMedia, true);
                $gallery = is_array($decoded) ? $decoded : [$rawMedia];
            }

            // Hapus item kosong
            $gallery = array_filter($gallery);
            $firstItem = $gallery[0] ?? null;

            // Tentukan item grid
            $gridItems = $showAll ? $gallery : array_slice($gallery, 0, 4);

            // Helper Cek Video
            $isVideo = fn($file) => in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), [
                'mp4',
                'mov',
                'avi',
                'webm'
            ]);
        @endphp

        @if ($firstItem)
            <div class="relative w-full">
                @if ($isVideo($firstItem))
                    {{-- TAMPILAN VIDEO UTAMA --}}
                    <video wire:click="openModal('{{ $firstItem }}')" autoplay muted loop playsinline
                        class="w-full cursor-pointer rounded-md object-cover transition">
                        <source src="{{ asset('storage/' . $firstItem) }}">
                    </video>
                @else
                    {{-- TAMPILAN GAMBAR UTAMA --}}
                    <img src="{{ asset('storage/' . $firstItem) }}" wire:click="openModal('{{ $firstItem }}')"
                        class="w-full cursor-pointer rounded-md object-cover transition">
                @endif
            </div>
        @endif

        <div class="mt-4">
            <div class="grid grid-cols-4 gap-4">
                @foreach ($gridItems as $item)
                    {{-- WRAPPER UTAMA (Wajib relative agar icon bisa nempel) --}}
                    {{-- Saya pindahkan wire:click ke sini agar area klik lebih luas --}}
                    <div class="group relative cursor-pointer overflow-hidden rounded-md"
                        wire:click="openModal('{{ $item }}')">

                        @if ($isVideo($item))
                            {{-- ITEM GRID VIDEO --}}
                            {{-- Hapus rounded-md di sini karena sudah ada di wrapper --}}
                            <video muted loop onmouseover="this.play()" onmouseout="this.pause()"
                                class="h-12 w-full object-cover transition duration-500 group-hover:scale-110 md:h-48">
                                <source src="{{ asset('storage/' . $item) }}">
                            </video>

                            {{-- 1. ICON PLAY TENGAH (Hilang saat di-hover/play) --}}
                            <div
                                class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center transition duration-300 group-hover:opacity-0">
                                <div class="rounded-full bg-black/30 p-2 backdrop-blur-[2px]">
                                    <i class="fa-solid fa-play text-xs text-white opacity-90 md:text-lg"></i>
                                </div>
                            </div>

                            {{-- 2. ICON VIDEO POJOK (Tetap ada sebagai penanda) --}}
                            <div class="pointer-events-none absolute right-1 top-1 z-10">
                                <i
                                    class="fa-solid fa-video text-[10px] text-white shadow-black drop-shadow-md md:text-xs"></i>
                            </div>
                        @else
                            {{-- ITEM GRID GAMBAR --}}
                            <img src="{{ asset('storage/' . $item) }}"
                                class="h-12 w-full object-cover transition duration-500 group-hover:scale-110 md:h-48">
                        @endif

                    </div>
                @endforeach
            </div>

            {{-- BUTTON --}}
            @if (count($gallery) > 4)
                <div class="mt-4 flex justify-center">
                    <button type="button" wire:click="toggleShow" wire:loading.attr="disabled" wire:target="toggleShow"
                        class="border-brand bg-neutral-primary text-fg-brand hover:bg-brand relative rounded-full border px-5 py-2 text-xs leading-5 transition hover:text-white disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="toggleShow">
                            Lihat Lebih {{ $showAll ? 'Sedikit' : 'Banyak' }}
                        </span>

                        <span wire:loading wire:target="toggleShow">
                            Loading...
                        </span>

                    </button>
                </div>
            @endif
        </div>

        <div class="mt-8">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $project->title }}
            </h1>

            <p class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 21s-7-4.35-7-11a7 7 0 1114 0c0 6.65-7 11-7 11z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
                <span>{{ Str::title(strtolower($project->location)) }}</span>
            </p>

            <div
                class="prose mt-2 max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                {!! $project->description !!}
            </div>
        </div>

        {{-- MODAL --}}
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80" x-data
                x-on:keydown.window.escape="$wire.closeModal()" x-on:keydown.window.arrow-right="$wire.nextImage()"
                x-on:keydown.window.arrow-left="$wire.prevImage()">

                <div class="absolute inset-0" wire:click="closeModal"></div>

                <div class="relative z-10 flex w-full max-w-5xl items-center px-4">

                    {{-- Tombol Prev --}}
                    <button wire:click="prevImage"
                        class="absolute left-4 z-30 rounded-full bg-black/40 p-2 text-white transition hover:bg-black/50">
                        <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    <div class="relative flex w-full items-center justify-center overflow-hidden rounded-md">
                        <button wire:click="closeModal"
                            class="absolute right-0 top-0 z-40 flex h-6 w-6 items-center justify-center rounded-full bg-black/40 text-white transition hover:bg-black/50 md:h-9 md:w-9">
                            ✕
                        </button>

                        @if ($isVideo($activeImage))
                            <video controls autoplay class="max-h-[85vh] w-auto bg-black object-contain">
                                <source src="{{ asset('storage/' . $activeImage) }}">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $activeImage) }}"
                                class="max-h-[85vh] w-auto select-none object-contain shadow-2xl">
                        @endif

                        {{-- Label Index (Opsional) --}}
                        <div
                            class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/50 px-3 py-1 text-xs text-white">
                            {{ $currentIndex + 1 }} /
                            {{ count(array_filter(is_array($project->media) ? $project->media : json_decode($project->media, true) ?? [])) }}
                        </div>
                    </div>

                    {{-- Tombol Next --}}
                    <button wire:click="nextImage"
                        class="absolute right-4 z-30 rounded-full bg-black/40 p-2 text-white transition hover:bg-black/50">
                        <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
