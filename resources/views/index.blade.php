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

        {{-- 
    
        Hello section

        --}}
        <x-landing.hello-section />


        <div x-data="{ filter: false }">
            <div class="flex flex-col gap-3">
                <div class="text-4xl font-bold">Отыщите того с кем вам будет лучше</div>
                <div class="text-lg font-medium text-gray-400">Воспользуйтесь фильтром для лучшего поиска</div>
            </div>

            <div class="flex justify-between mt-5 items-end">
                <div @click="filter = !filter" class="flex items-center gap-1 px-4 py-2 border border-gray-300 rounded-xl font-medium text-lg hover:cursor-pointer">
                    Фильтр
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H20V6.172C19.9999 6.70239 19.7891 7.21101 19.414 7.586L15 12V19L9 21V12.5L4.52 7.572C4.18545 7.20393 4.00005 6.7244 4 6.227V4Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>                        
                </div>

                <div class="text-gray-400">Найдено: {{$users_total}} анкет</div>
            </div>

            <div x-show="filter" class="mt-5 flex flex-col gap-4">
                <div class="flex flex-col gap-3">
                    <div class="text-gray-400">Выберите город</div>
                    <div class="flex flex-wrap gap-2">
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Москва</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Москва</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Москва</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Москва</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Москва</div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="text-gray-400">Выберите национальность</div>
                    <div class="flex flex-wrap gap-2">
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Казах</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Русский</div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="text-gray-400">Выберите пол</div>
                    <div class="flex flex-wrap gap-2">
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Мужчина</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Женщина</div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="text-gray-400">Выберите страну</div>
                    <div class="flex flex-wrap gap-2">
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Россия</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Россия</div>
                        <div class="px-3 py-1 border border-gray-300 rounded-full hover:cursor-pointer hover:bg-gray-300 hover:text-white">Россия</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 mt-5">

                @foreach ($users as $item)
                    <x-user-card :data="$item" />                    
                @endforeach

            </div>
        </div>


        {{-- 
    
        Pricing

        --}}
        <x-pricing-cards />


        {{-- 
    
        Feedback

        --}}
        <div class="my-20">
            <div class="text-5xl font-bold text-center mb-10" id="feedback">Отзывы</div>


            <div class="carousel" data-flickity='{ "autoPlay": true }'>
                <div class="carousel-cell w-full flex justify-center">
                    <div class="lg:max-w-5xl flex gap-5 items-center max-w-64 sm:max-w-sm md:max-w-md flex-col lg:flex-row">
                        <div class="max-w-96">
                            <img class="w-full" src="{{asset('storage/images/feedback/1.jpg')}}" alt="" srcset="">
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="font-bold text-3xl">Максим и Ксения</div>
                            <div class="text-md">Lorem ipsum, dolor sit amet consectetur adipisicing elit. At nesciunt magnam quam sequi, reprehenderit consectetur accusantium possimus ipsa vel tenetur saepe facilis hic quasi itaque repudiandae omnis dignissimos quo dolorem.</div>
                        </div>
                    </div>
                </div>
                
                <div class="carousel-cell w-full flex justify-center">
                    <div class="lg:max-w-5xl flex gap-5 items-center max-w-64 sm:max-w-sm md:max-w-md flex-col lg:flex-row">
                        <div class="max-w-96">
                            <img class="w-full" src="{{asset('storage/images/feedback/1.jpg')}}" alt="" srcset="">
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="font-bold text-3xl">Максим и Ксения</div>
                            <div class="text-md">Lorem ipsum, dolor sit amet consectetur adipisicing elit. At nesciunt magnam quam sequi, reprehenderit consectetur accusantium possimus ipsa vel tenetur saepe facilis hic quasi itaque repudiandae omnis dignissimos quo dolorem.</div>
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