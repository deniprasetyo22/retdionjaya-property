<footer class="relative z-30 mt-12 bg-blue-500 text-white">
    <div class="mx-auto px-8 py-14">
        <div class="grid gap-10 md:grid-cols-5">

            <div class="mb-4 flex items-center gap-2 md:justify-center">
                <img src="{{ asset('images/Logo.png') }}" alt="Urbanera" class="h-16 w-auto">
            </div>

            <div>
                <h3 class="mb-4 font-semibold text-white">Tautan Cepat</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-house text-xs"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('article-list') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-regular fa-newspaper text-xs"></i>
                            Artikel
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-circle-info text-xs"></i>
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-envelope text-xs"></i>
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 font-semibold text-white">Layanan</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li>
                        <a href="#" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-solid fa-building text-xs"></i>
                            Proyek
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 font-semibold text-white">Media Sosial</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li>
                        <a href="https://youtube.com/@urbanera_id" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-brands fa-youtube text-xs"></i>
                            YouTube
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/urbanera_id/"
                            class="flex items-center gap-2 hover:text-white">
                            <i class="fa-brands fa-instagram text-xs"></i>
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@urbanera_id" class="flex items-center gap-2 hover:text-white">
                            <i class="fa-brands fa-tiktok text-xs"></i>
                            Tiktok
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 font-semibold text-white">Hubungi Kami</h3>
                <ul class="text-tertiary space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <a href="https://wa.me/6287887355015">
                            <i class="fa-brands fa-whatsapp"></i>
                            0878-7356-5015 (admin)
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <a href="tel:08787356015">
                            <i class="fa-solid fa-phone"></i>
                            0878-7356-5015 (admin)
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <a href="mailto:retdionjaya@gmail.com">
                            <i class="fa-solid fa-envelope"></i>
                            retdionjaya@gmail.com
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="text-tertiary pb-6 text-center text-xs">
        ©{{ date('Y') }} Retdion Jaya. Hak cipta dilindungi undang-undang.
    </div>
</footer>
