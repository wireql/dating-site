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

        
        <form action="{{route('register.store')}}" method="post" class="max-w-sm mx-auto mt-20">
            @csrf

            <div class="flex flex-col gap-5">
                <div class="text-2xl font-medium text-center">Создание нового аккаунта</div>
                @error('msg-error')
                    <span class="text-sm text-red-400">{{ $message }}</span>
                @enderror

                @if (session('is_sms_code'))
                    <div>
                        <label for="sms-code" class="block text-sm font-medium leading-6 text-gray-900">Код из СМС</label>
                        {{-- Временно, код: {{session('sms-code')}} --}}
                        @error('sms-code')
                            <span class="text-sm text-red-400">{{ $message }}</span>
                        @enderror
                        <div class="mt-2">
                            <input id="sms-code" name="sms-code" type="text" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                            <div class="mt-2" id="sms_code_timer">0:59</div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm">Зарегистрироваться</button>
                    </div>

                    <script>
                        $(document).ready(function() {
                            let timeLeft = 60;

                            function updateTimer() {
                                let minutes = Math.floor(timeLeft / 60);
                                let seconds = timeLeft % 60;

                                seconds = seconds < 10 ? '0' + seconds : seconds;

                                $('#sms_code_timer').text(`${minutes}:${seconds}`);

                                timeLeft--;

                                if (timeLeft < 0) {
                                    clearInterval(timerInterval);
                                    $('#sms_code_timer').text('Повторите регистрацию еще раз.');
                                }
                            }

                            let timerInterval = setInterval(updateTimer, 1000);

                            updateTimer();
                        });
                    </script>
                @else
                    <div class="step active flex flex-col gap-3">
                        <div class="">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Пол</label>
                            @error('gender')
                                <span class="text-sm text-red-400">{{ $message }}</span>
                            @enderror
                            <div class="mt-2">
                                <select name="gender" class="h-9 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6">
                                    <option value="1">Мужчина</option>
                                    <option value="2">Женщина</option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <button type="button" class="btn-next bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm">Далее</button>
                        </div>
                    </div>

                    <div class="step flex flex-col gap-3">
                        <div class="">
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Фамилия, имя, отчество</label>
                            @error('username')
                                <span class="text-sm text-red-400">{{ $message }}</span>
                            @enderror
                            <div class="mt-2">
                                <input id="username" name="username" value="{{old('username')}}" type="text" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <button type="button" class="btn-next bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm">Далее</button>
                            <button type="button" class="btn-prev border border-slate-900 text-slate-900 px-4 py-2 rounded-md font-medium text-sm">Назад</button>
                        </div>
                    </div>

                    <div class="step flex flex-col gap-3">
                        <div class="">
                            <label for="birthday" class="block text-sm font-medium leading-6 text-gray-900">Дата рождения</label>
                            @error('birthday')
                                <span class="text-sm text-red-400">{{ $message }}</span>
                            @enderror
                            <div class="mt-2">
                                <input id="birthday" name="birthday" value="{{old('birthday')}}" type="date" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <button type="button" class="btn-next bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm">Далее</button>
                            <button type="button" class="btn-prev border border-slate-900 text-slate-900 px-4 py-2 rounded-md font-medium text-sm">Назад</button>
                        </div>
                    </div>

                    <div class="step flex flex-col gap-3">
                        <div class="">
                            <label for="telephone" class="block text-sm font-medium leading-6 text-gray-900">Номер телефона</label>
                            @error('telephone')
                                <span class="text-sm text-red-400">{{ $message }}</span>
                            @enderror
                            <div class="mt-2">
                                <input id="telephone" name="telephone" value="{{old('telephone')}}" type="text" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                            </div>
                            <div class="mt-2 flex items-center align-middle">
                                <input required type="checkbox" name="accept" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black">
                                <label class="ml-2 block text-sm text-gray-900">Даю согласие на обработку персональных данных</label>
                            </div>
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-md font-medium text-sm">Зарегистрироваться</button>
                            <button type="button" class="btn-prev border border-slate-900 text-slate-900 px-4 py-2 rounded-md font-medium text-sm">Назад</button>
                        </div>
                    </div>
                @endif

                <div class="text-sm">Есть аккаунт? <a class="font-medium text-slate-400 underline" href="{{route('login')}}">Авторизоваться</a></div>
            </div>

        </form>
        

    </div>


@endsection