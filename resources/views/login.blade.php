@extends('layouts/index')

@section('content')
    
    {{-- 
    
    Header

    --}}
    @auth
        <x-header />   
    @endauth


    {{-- 
    
    Main content

    --}}
    <div class="container mx-auto px-4">

        
        <form action="{{route('login.store')}}" method="POST" class="max-w-sm mx-auto mt-20">
            @csrf

            <div class="flex flex-col gap-5">
                <div class="text-2xl font-medium text-center">Вход в личный кабинет</div>

                @error('msg-error')
                    <span class="text-sm text-red-400">{{ $message }}</span>
                @enderror
                @session('msg-success')
                    <span class="text-sm text-green-400">{{ session('msg-success') }}</span>
                @endsession

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
                                    $('#sms_code_timer').text('Повторите авторизацию еще раз.');
                                    clearInterval(timerInterval);
                                }
                            }

                            let timerInterval = setInterval(updateTimer, 1000);

                            updateTimer();
                        });
                    </script>
                @else
                    <div class="">
                        <label for="telephone" class="block text-sm font-medium leading-6 text-gray-900">Номер телефона</label>
                        @error('telephone')
                            <span class="text-sm text-red-400">{{ $message }}</span>
                        @enderror
                        <div class="mt-2">
                            <input id="telephone" name="telephone" type="telephone" autocomplete="telephone" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                        </div>
                    </div>
                @endif

                <div class="text-sm">Нет аккаутна? <a class="font-medium text-slate-400 underline" href="{{route('register')}}">Зарегистрироваться</a></div>

                <div class="w-full flex flex-col gap-1">
                    <button type="submit" class="text-sm bg-slate-900 text-white px-4 py-2 rounded-md font-medium">Авторизоваться</button>
                </div>
            </div>

        </form>
        

    </div>


@endsection