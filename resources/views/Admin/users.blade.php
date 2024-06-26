@extends('layouts/admin')

@section('content')

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">

    {{-- Sidebar --}}
    <x-admin.sidebar />

    <div class="flex flex-col flex-1">
        
        {{-- Header --}}
        <x-admin.header :user="$user" />

        <main class="h-full pb-16 overflow-y-auto">

            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Пользователи
                </h2>

                <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">Фильтр</h4>
                <a href="{{route('admin.users')}}" class="w-max mb-3 flex items-center gap-1 px-4 py-2 border border-gray-300 rounded-xl font-medium text-lg hover:cursor-pointer">
                    Очистить фильтр
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 6H20M6 12H18M4 18H16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>                                                   
                </a>
                <div class="flex flex-col gap-4 mb-4">
                    <div class="flex flex-col gap-3">
                        <div class="text-gray-400">Выберите страну</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filter_data['countries'] as $key => $item)
                                <a href="{{route('admin.users', ['country' => $key])}}" class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white {{ request('country') == $key ? 'bg-gray-300 text-white' : 'border-gray-300' }}">{{$key}}</a>
                            @endforeach
                        </div>
                    </div>

                    @if ($cities)
                        <div class="flex flex-col gap-3">
                            <div class="text-gray-400">Выберите город</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($cities as $key => $item)
                                    <a href="{{route('admin.users', array_merge(request()->query(), ['city' => $item]))}}" class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white {{ request('city') == $item ? 'bg-gray-300 text-white' : 'border-gray-300' }}">{{$item}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col gap-3">
                        <div class="text-gray-400">Выберите национальность</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filter_data['nationalities'] as $key => $item)
                                <a href="{{route('admin.users', array_merge(request()->query(), ['nationality' => $item]))}}" class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white {{ request('nationality') == $item ? 'bg-gray-300 text-white' : 'border-gray-300' }}">{{$item}}</a>
                            @endforeach
                        </div>
                    </div>
    
                    <div class="flex flex-col gap-3">
                        <div class="text-gray-400">Выберите пол</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filter_data['genders'] as $key => $item)
                                <a href="{{route('admin.users', array_merge(request()->query(), ['gender' => $item]))}}" class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white {{ request('gender') == $item ? 'bg-gray-300 text-white' : 'border-gray-300' }}">{{$item}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>


                <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">Список пользователей</h4>

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                      <table class="w-full whitespace-no-wrap">
                            <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Пользователь</th>
                                <th class="px-4 py-3">Пол</th>
                                <th class="px-4 py-3">День рождения</th>
                                <th class="px-4 py-3">Дата регистрации</th>
                                <th class="px-4 py-3">Статус</th>
                                <th class="px-4 py-3">Действия</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($users as $item)

                                    @php
                                        $telephone = $item['user']['telephone'];
                                        $telephone = '+' . substr($telephone, 0, 1) . ' ' . substr($telephone, 1, 3) . ' ' . substr($telephone, 4, 3) . ' ' . substr($telephone, 7, 2) . ' ' . substr($telephone, 9, 2);
                                    @endphp

                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm">
                                            {{$item['user']['id']}}
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{route('admin.user', $item['user']['id'])}}" class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full" src="{{asset('storage/images/'.($item['image']  ?? 'user-logo.png'))}}" alt="" loading="lazy">
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                <p class="font-semibold">{{$item['user']['username']}}</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{$telephone}}
                                                </p>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($item['user']['gender'] == 1)
                                                Мужской
                                            @else
                                                Женский
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            {{$item['user']['birthday']}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{$item['user']['created_at']}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($item['is_active'])
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                Активный
                                            </span>
                                            @else
                                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                                                Неактивный
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center space-x-4 text-sm">
                                                <button onclick="setVisibility({{$item['user']['id']}})" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                                        <path d="M8.3335 10C8.3335 10.442 8.50909 10.866 8.82165 11.1785C9.13421 11.4911 9.55814 11.6667 10.0002 11.6667C10.4422 11.6667 10.8661 11.4911 11.1787 11.1785C11.4912 10.866 11.6668 10.442 11.6668 10C11.6668 9.55798 11.4912 9.13406 11.1787 8.8215C10.8661 8.50894 10.4422 8.33334 10.0002 8.33334C9.55814 8.33334 9.13421 8.50894 8.82165 8.8215C8.50909 9.13406 8.3335 9.55798 8.3335 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M17.5 10C15.5 13.3333 13 15 10 15C7 15 4.5 13.3333 2.5 10C4.5 6.66667 7 5 10 5C13 5 15.5 6.66667 17.5 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>                                                                                                                     
                                                </button>
                                                @if ($item['user']['is_admin'] == 0)
                                                    @if ($item['user']['id'] != auth()->user()->id)
                                                        <button @click="openModal" onclick="setUserId({{$item['user']['id']}})" :data-userId="{{$item['id']}}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                      </table>
                    </div>
                    <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        {{-- <span class="flex items-center col-span-3">
                            Showing 21-30 of 100
                        </span>
                        <span class="col-span-2"></span>
                        <!-- Pagination -->
                        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            <nav aria-label="Table navigation">
                            <ul class="inline-flex items-center">
                                <li>
                                <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                                </li>
                                <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    1
                                </button>
                                </li>
                                <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    2
                                </button>
                                </li>
                                <li>
                                <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    3
                                </button>
                                </li>
                                <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    4
                                </button>
                                </li>
                                <li>
                                <span class="px-3 py-1">...</span>
                                </li>
                                <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    8
                                </button>
                                </li>
                                <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    9
                                </button>
                                </li>
                                <li>
                                <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                                </li>
                            </ul>
                            </nav>
                        </span> --}}
                    </div>
                </div>

            </div>

            <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
                <!-- Modal -->
                <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal" style="display: none;">
                    <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                    <header class="flex justify-end">
                        <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                                <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </button>
                    </header>
                    <!-- Modal body -->
                    <div class="mt-4 mb-6">
                        <!-- Modal title -->
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                            Удаление пользователя
                        </p>
                        <!-- Modal description -->
                        <p class="text-sm text-gray-700 dark:text-gray-400">
                        Вы действительно хотите удалить этого пользователя? Анкета и все данные будут полностью удалены.
                        </p>
                    </div>
                    <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                        <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                            Назад
                        </button>
                        <button @click="deleteUser()" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Удалить
                        </button>
                    </footer>
                </div>
            </div>

        </main>
      </div>

</div>

<script>
    let userId = null;

    function setUserId(id) {
        userId = id;
    }

    function setVisibility(userId) {
        axios.post('/admin/users/' + userId)
        .then(response => {
            location.reload();
        })
        .catch(error => {
            console.error(error);
        });
    }

    function deleteUser() {
        axios.delete('/admin/users/' + userId)
        .then(response => {
            location.reload();
        })
        .catch(error => {
            console.error(error);
        });
    }
</script>

@endsection