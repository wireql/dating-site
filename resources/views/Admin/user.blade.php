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
                    <div class="flex flex-col gap-5 max-w-3xl w-full">

                        <div class="font-medium text-xl">Возможности просмотров</div>
                        <form method="POST" action="{{route('admin.user.add', $user_data['id'])}}" class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl w-full">
                            @csrf
                            @method('PUT')

                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Количество просмотров ФИО и фото</label>
                                <div class="mt-2">
                                    <div class="flex flex-row gap-3">
                                        <input type="number" min="0" name="profiles_views" id="" value="{{$user_data['profiles_views']}}" class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm text-center w-full">
                                            Изменить
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Количество просмотров номера телефона</label>
                                <div class="mt-2">
                                    <div class="flex flex-row gap-3">
                                        <input type="number" min="0" name="telephone_views" id="" value="{{$user_data['telephone_views']}}" class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm text-center w-full">
                                            Изменить
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Количество просмотров соц. сетей</label>
                                <div class="mt-2">
                                    <div class="flex flex-row gap-3">
                                        <input type="number" min="0" name="social_views" id="" value="{{$user_data['social_views']}}" class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm text-center w-full">
                                            Изменить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="font-medium text-xl">Фото</div>
                        <img src="{{asset('storage/images/'.$user_data['profile']['image'])}}" alt="">
        
                        <div class="font-medium text-xl">Открытые данные</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl w-full">
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Номер анкеты</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['id']}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Дата рождения</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['birthday']}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Страна</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['country'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Город</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['city'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Национальность</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['nationality'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Профессия</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['profession'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Хобби</label>
                                <div class="mt-2">
                                    <div class="grid grid-cols-2">
                                        @foreach($user_data['profile']['hobbies'] as $hobby)
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" checked>
                                            <label class="ml-2 block text-sm text-gray-900">{{ $hobby['hobby']['name'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Предпочтения</label>
                                <div class="mt-2">
                                    <div class="grid grid-cols-2">
                                        @foreach($user_data['profile']['preferences'] as $hobby)
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" checked>
                                            <label class="ml-2 block text-sm text-gray-900">{{ $hobby['preference']['name'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Про себя</label>
                                <div class="mt-2">
                                    <div class="grid grid-cols-2">
                                        @foreach($user_data['profile']['about'] as $hobby)
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" checked>
                                            <label class="ml-2 block text-sm text-gray-900">{{ $hobby['preference']['name'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Детская травма</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['child_trauma'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Место работы</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['work_place'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Статус</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['status'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Вес</label>
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['weight'] ?? "Пусто"}}
                                    </div>
                                    <div>кг.</div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Рост</label>
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['height'] ?? "Пусто"}}
                                    </div>
                                    <div>см.</div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Образование</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['education'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Комментарий</label>
                                <div class="mt-2">
                                    <textarea name="message" class="max-h-32 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6" id="" cols="30" rows="10">{{$user_data['message'] ?? "Пусто"}}</textarea>
                                </div>
                            </div>
        
                        </div>
        
                        <div class="font-medium text-xl">Закрытые данные</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl w-full">
        
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Instagram</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['instagram'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Telegram</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['telegram'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Facebook</label>
                                <div class="mt-2">
                                    <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                        {{$user_data['facebook'] ?? "Пусто"}}
                                    </div>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </h2>
            </div>

        </main>
      </div>

</div>
    
@endsection