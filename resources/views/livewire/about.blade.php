<div class="bg-white">
    {{-- HERO SECTION --}}
    <livewire:hero hero_quote="Dedikasi dalam Membangun" hero_title="Tentang Kami"
        hero_subTitle="PT. Retdion Jaya Konstruksi hadir sebagai mitra profesional yang mengutamakan kualitas, keamanan, dan ketepatan waktu dalam setiap proyek pembangunan Anda." />
    <div class="mx-auto max-w-7xl px-6 pt-8">

        {{-- VIDEO --}}
        {{-- <video class="rounded-base mb-10 w-full" controls>
            <source src="{{ asset('storage/' . $about->video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video> --}}

        {{-- YOUTUBE VIDEO --}}
        <div class="mb-10">
            <div class="relative w-full pb-[56.25%]">
                <iframe class="rounded-base absolute inset-0 h-full w-full"
                    src="https://www.youtube.com/embed/{{ $about?->video_link }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>

                {{-- <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/Gx-jDkR55aU?si=ldH4zJ-FzJ7IWrJs" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe> --}}
            </div>
        </div>

        {{-- ABOUT --}}
        <div class="mb-10">
            <h2 class="mb-3 text-2xl font-bold">Tentang Kami</h2>

            @if ($about)
                <div
                    class="prose max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                    {!! $about->about !!}
                </div>
            @endif
        </div>

        {{-- VISION --}}
        <div class="mb-10">
            <h2 class="mb-3 text-2xl font-bold">Visi</h2>

            @if ($about)
                <div
                    class="prose max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                    {!! $about->vision !!}
                </div>
            @endif
        </div>

        {{-- MISSION --}}
        <div class="mb-10">
            <h2 class="mb-3 text-2xl font-bold">Misi</h2>

            @if ($about)
                <div
                    class="prose max-w-none text-justify text-gray-700 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
                    {!! $about->mission !!}
                </div>
            @endif
        </div>

        {{-- ACHIEVEMENTS --}}
        @php
            $achievements = collect($about->achievements ?? [])->filter(
                fn($item) => !empty($item['description']) || !empty($item['image'])
            );
        @endphp

        @if ($achievements->isNotEmpty())
            <div class="mb-10">
                <h2 class="mb-6 text-2xl font-bold">Achievements</h2>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    @foreach ($achievements as $item)
                        <div class="overflow-hidden rounded-md bg-white shadow transition hover:shadow-md">

                            {{-- Image --}}
                            @if (!empty($item['image']))
                                <div class="relative aspect-[16/9] w-full overflow-hidden rounded-t-md">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="Achievement Image"
                                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                                </div>
                            @endif

                            {{-- Content --}}
                            @if (!empty($item['description']))
                                <div class="p-5">
                                    <div class="prose max-w-none text-center text-gray-700">
                                        {!! $item['description'] !!}
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- PORTFOLIO & HISTORY --}}
        @php
            $portfolio = collect($about->portfolio ?? [])
                ->filter(fn($item) => !empty($item['title']) || !empty($item['description']) || !empty($item['image']))
                ->reverse()
                ->values();
        @endphp

        @if ($portfolio->isNotEmpty())
            <div class="relative mb-10">

                <h2 class="mb-6 text-2xl font-bold">Portfolio & History</h2>

                <div class="space-y-12">
                    @foreach ($portfolio as $index => $item)
                        <div class="relative grid items-center gap-4 md:grid-cols-2">

                            {{-- DOT --}}
                            <div
                                class="absolute left-1/2 top-1/2 z-10 hidden h-6 w-6 -translate-x-1/2 -translate-y-1/2 rounded-full border-4 border-white bg-green-600 md:block">
                            </div>

                            @if (!$loop->last)
                                <div
                                    class="absolute left-1/2 top-1/2 hidden h-[120%] w-[4px] -translate-x-1/2 bg-gray-200 md:block">
                                </div>
                            @endif

                            {{-- LEFT --}}
                            <div class="{{ $index % 2 == 0 ? 'md:order-1 md:pr-12' : 'md:order-2 md:pl-12' }}">
                                @if (!empty($item['image']))
                                    <div class="aspect-[16/9] overflow-hidden rounded-md shadow">
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                            class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                            alt="Portfolio image">
                                    </div>
                                @endif
                            </div>

                            {{-- RIGHT --}}
                            <div class="{{ $index % 2 == 0 ? 'md:order-2 md:pl-12' : 'md:order-1 md:pr-12' }}">
                                <div class="prose max-w-none text-justify">

                                    @if (!empty($item['title']))
                                        <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                            {{ $item['title'] }}
                                        </h3>
                                    @endif

                                    @if (!empty($item['description']))
                                        <div class="prose max-w-none text-justify text-gray-700">
                                            {!! $item['description'] !!}
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
