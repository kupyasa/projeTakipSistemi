<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <x-application-logo width="36" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex">
                @auth
                    @ogrenci
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hoşgeldin {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="/">{{ __('Ana Sayfa') }}</a>
                            </li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Çıkış Yap') }}
                                </x-dropdown-link>
                            </form>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ogrenci.konuonerileriget') }}">Önerdiğim
                                    Konular</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ogrenci.raporlarget') }}">Yüklediğim
                                    Raporlar</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ogrenci.tezlerget') }}">Yüklediğim Tezler</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ogrenci.benzerkonuonerileriget') }}">Önerdiğim
                                    Benzer Konular</a>
                            </li>
                        </ul>
                    </li>

                    @endogrenci

                    @danisman

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hoşgeldin {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="/">{{ __('Ana Sayfa') }}</a>
                            </li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Çıkış Yap') }}
                                </x-dropdown-link>
                            </form>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('danisman.konuonerileriget') }}">Önerilen
                                    Konular</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('danisman.raporlarget') }}">Yüklenilen
                                    Raporlar</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('danisman.tezlerget') }}">Yüklenilen Tezler</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('danisman.benzerkonuonerileriget') }}">Önerilen
                                    Benzer Konular</a>
                            </li>
                        </ul>
                    </li>
                    @enddanisman

                    @sistemyoneticisi

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hoşgeldin {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="/">{{ __('Ana Sayfa') }}</a>
                            </li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Çıkış Yap') }}
                                </x-dropdown-link>
                            </form>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('sistemyoneticisi.ogrenciekleget') }}">Sisteme
                                    Öğrenci Ekle</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('sistemyoneticisi.danismanekleget') }}">Sisteme
                                    Danışman Ekle</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('sistemyoneticisi.aktifdonemget') }}">Aktif
                                    Yıl-Dönem Değiştir</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sistemyoneticisi.danismandahiletget') }}">Danışmanı Sisteme Dahil
                                    Et</a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sistemyoneticisi.ogrencidahiletget') }}">Öğrenciyi Sisteme Dahil
                                    Et</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sistemyoneticisi.konuonerileriyildonemget') }}">Önerilen Konular</a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sistemyoneticisi.raporlaryildonemget') }}">Yüklenilen Raporlar</a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sistemyoneticisi.tezleryildonemget') }}">Yüklenilen Tezler</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sistemyoneticisi.kullanicilarget') }}">Kullanıcıları Düzenle</a>
                            </li>
                        </ul>
                    </li>
                    @endsistemyoneticisi
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"
                            class="text-muted">Giriş Yap</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"
                            class="text-muted">Kayıt Ol</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
