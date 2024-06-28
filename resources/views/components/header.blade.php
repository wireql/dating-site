<div class="border-b-2 shadow-lg" x-data="{ open: false }">
    <div class="py-4 flex items-center justify-between container mx-auto px-4">
        <a href="{{route('index')}}" class="font-medium text-5xl">
            JUP
        </a>
        <div class="hidden lg:flex items-center gap-10 text-slate-600 text-lg font-medium">
            <a href="{{route('index')}}" class="">Главная</a>
            <a href="/#tariffs" class="">Тарифы</a>
            {{-- <a href="/#feedback" class="">Отзывы</a> --}}
        </div>
        @guest
            <a href="{{route('login')}}" class="hidden lg:flex items-center font-semibold text-sm gap-1 border-2 border-gray-300 rounded-3xl hover:cursor-pointer px-4 py-2">
                Войти   
            </a>
        @endguest
        @auth
            <div class="flex items-center gap-5">
                <a href="{{route('profile')}}" class="hidden lg:flex items-center font-semibold text-sm gap-1 border-2 border-gray-300 rounded-3xl hover:cursor-pointer px-4 py-2">
                    Профиль   
                </a>
                <a href="{{route('login.logout')}}" class="hidden lg:flex">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 12V12.01M3 21H21M5 21V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H14.5M17 13.5V21M14 7H21M21 7L18 4M21 7L18 10" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        @endauth
        <div class="flex lg:hidden gap-4">
            <button type="button" @click="open = true" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
              <span class="sr-only">Open main menu</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
            </button>
        </div>
    </div>


    <div class="lg:hidden" x-show="open" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-4 py-4 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="{{route('index')}}" class="font-medium text-5xl">
                    JUP
                </a>
                <button type="button" @click="open = false" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="{{route('index')}}" @click="open = false" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Главная</a>
                        <a href="/#tariffs" @click="open = false" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Тарифы</a>
                        <a href="/#feedback" @click="open = false" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Отзывы</a>
                    </div>
                    <div class="py-6">
                        @guest
                            <a href="{{route('login')}}" class="flex items-center justify-center font-semibold text-sm gap-1 border-2 border-gray-300 rounded-3xl hover:cursor-pointer px-4 py-2">
                                Войти   
                            </a>
                        @endguest
                        @auth
                            <a href="{{route('profile')}}" class="flex items-center justify-center font-semibold text-sm gap-1 border-2 border-gray-300 rounded-3xl hover:cursor-pointer px-4 py-2">
                                Профиль   
                            </a>
                            <a href="{{route('login.logout')}}" class="mt-3 flex items-center justify-center font-semibold text-sm gap-1 border-2 border-gray-300 rounded-3xl hover:cursor-pointer px-4 py-2">
                                Выйти
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>