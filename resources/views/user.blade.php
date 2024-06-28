@php
    $telephone = $profile[0]['user']['telephone'];
    $telephone = '+' . substr($telephone, 0, 1) . ' ' . substr($telephone, 1, 3) . ' ' . substr($telephone, 4, 3) . ' ' . substr($telephone, 7, 2) . ' ' . substr($telephone, 9, 2);

    $birthdate = $profile[0]['user']['birthday'];
    $birthDateObj = new DateTime($birthdate);
    $currentDate = new DateTime();
    
    $age = $currentDate->diff($birthDateObj)->y;

    $opened_social = \App\Models\UserViewSocial::query()->where('user_id', '=', Auth::user()->id)->where('profile_id', '=', $profile[0]['id'])->first();
    $opened_telephone = \App\Models\UserViewTelephone::query()->where('user_id', '=', Auth::user()->id)->where('profile_id', '=', $profile[0]['id'])->first();
@endphp

@extends('layouts/index')

@section('content')
    
    {{-- 
    
    Header

    --}}
    <x-header />

    {{-- 
    
    Main content

    --}}
    <div class="container mx-auto px-4">

        <div class="flex flex-col md:flex-row mt-10 gap-5">
            {{-- User short information --}}
            <div class="w-full md:max-w-64">
                <img class="w-full rounded-3xl h-96 object-cover" src="{{ asset('storage/images/' . (!$opened_profile ? 'blur_' : '') . ($profile[0]['image'] ?? 'user-logo.png')) }}" alt="">
                <div class="flex flex-col mt-3">
                    <div class="font-medium text-lg">@if(!$opened_profile) ********** @else {{$profile[0]['user']['username']}} @endif</div>
                    <div class="text-md text-slate-500">@if(!$opened_telephone) +7 *** *** ** ** @else {{$telephone}} @endif</div>
                </div>
            </div>

            {{-- User profile information --}}
            <div class="flex flex-col gap-5 max-w-3xl w-full">
                @error('msg-error')
                    <span class="text-sm text-red-400">{{ $message }}</span>
                @enderror
                @session('msg-success')
                    <span class="text-sm text-green-400">{{ session('msg-success') }}</span>
                @endsession

                <form method="POST" action="{{route('user.open', $profile[0]['id'])}}" class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @csrf

                    <button type="submit" name="action" value="profile" class="flex items-center justify-center w-full border border-slate-900 text-black px-4 py-2 rounded-md font-medium text-sm text-center">
                        Открыть фото и ФИО
                    </button>
                    <button type="submit" name="action" value="telephone" class="flex items-center justify-center w-full border border-slate-900 text-black px-4 py-2 rounded-md font-medium text-sm text-center">
                        Открыть номер телефона
                    </button>
                    <button type="submit" name="action" value="social" class="flex items-center justify-center w-full border border-slate-900 text-black px-4 py-2 rounded-md font-medium text-sm text-center">
                        Открыть социцальные сети
                    </button>
                </form>

                <div class="font-medium text-xl">Открытые данные</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl w-full">

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Номер анкеты</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['id']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Возраст</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$age}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Страна</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['country']}}
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Город</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['city']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Национальность</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['nationality']}}
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Профессия</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['profession']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Место работы</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['work_place']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Статус</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['status']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Вес</label>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['weight']}}
                            </div>
                            <div>кг.</div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Рост</label>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['height']}}
                            </div>
                            <div>см.</div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Хобби</label>
                        <div class="mt-2">
                            <div class="grid grid-cols-2">
                                @foreach($profile[0]['hobbies'] as $hobby)
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
                                @foreach($profile[0]['preferences'] as $hobby)
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
                                @foreach($profile[0]['about'] as $hobby)
                                <div class="flex items-center mt-2">
                                    <input type="checkbox" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" checked>
                                    <label class="ml-2 block text-sm text-gray-900">{{ $hobby['preference']['name'] }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Родители</label>
                        <div class="mt-2">
                            <div class="grid grid-cols-2">
                                @foreach($profile[0]['parents'] as $hobby)
                                <div class="flex items-center mt-2">
                                    <input type="checkbox" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" checked>
                                    <label class="ml-2 block text-sm text-gray-900">{{ $hobby['parent']['name'] }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Детская травма</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['child_trauma']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Образование</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                {{$profile[0]['education']}}
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Комментарий</label>
                        <div class="mt-2">
                            <textarea name="message" class="max-h-32 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6" id="" cols="30" rows="10">{{$profile[0]['message']}}</textarea>
                        </div>
                    </div>

                </div>

                <div class="font-medium text-xl">Закрытые данные</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl w-full">

                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Instagram</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                @if (!$opened_social)
                                    Закрыто    
                                @else
                                    {{$profile[0]['instagram'] ?? "Пусто"}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Telegram</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                @if (!$opened_social)
                                    Закрыто
                                @else
                                    {{$profile[0]['telegram'] ?? "Пусто"}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Facebook</label>
                        <div class="mt-2">
                            <div class="w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm">
                                @if (!$opened_social)
                                    Закрыто    
                                @else
                                    {{$profile[0]['facebook'] ?? "Пусто"}}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> 

    </div>

    {{-- 
    
    Footer

    --}}
    <x-footer />


@endsection