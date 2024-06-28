@php
    $telephone = $user[0]['telephone'];
    $telephone = '+' . substr($telephone, 0, 1) . ' ' . substr($telephone, 1, 3) . ' ' . substr($telephone, 4, 3) . ' ' . substr($telephone, 7, 2) . ' ' . substr($telephone, 9, 2);
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
    <div class="container mx-auto px-4 mb-20">

        <div class="flex flex-col md:flex-row mt-10 gap-5">
            {{-- User short information --}}
            <div class="w-full md:max-w-64">
                <img class="w-full rounded-3xl h-96 object-cover" src="{{ asset('storage/images/' . ($user[0]['profile']['image'] ?? 'user-logo.png')) }}" alt="">
                <div class="flex flex-col mt-3">
                    <div class="font-medium text-lg">{{$user[0]['username']}}</div>
                    <div class="text-md text-slate-500">{{$telephone}}</div>
                </div>
            </div>

            {{-- User profile information --}}
            <div class="flex flex-col gap-5 max-w-3xl w-full">
                
                @php
                    $profileRoute = request()->is('profile');
                    $favouritesRoute = request()->is('profile/favourites');
                    $recomendationsRoute = request()->is('profile/recomendations');
                @endphp

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:flex md:gap-5">
                    <a href="{{ route('profile') }}" class="{{ $profileRoute ? 'bg-slate-900 text-white' : 'border border-slate-900 text-black' }} px-4 py-2 rounded-md font-medium text-sm text-center w-full">Анкета</a>
                    <a href="{{ route('profile.favourites') }}" class="{{ $favouritesRoute ? 'bg-slate-900 text-white' : 'border border-slate-900 text-black' }} px-4 py-2 rounded-md font-medium text-sm text-center sm:col-span-1 w-full">Избранное</a>
                    <a href="{{ route('profile.recomendations') }}" class="{{ $recomendationsRoute ? 'bg-slate-900 text-white' : 'border border-slate-900 text-black' }} px-4 py-2 rounded-md font-medium text-sm text-center w-full sm:col-span-2">Рекомендуемые анкеты</a>
                </div>

                @if (!isset($favourites) && !isset($recomendations))

                    {{-- User profile form --}}
                    <x-user-profile-form :user="$user" :preferences="$preferences" :hobbies="$hobbies" :parents="$parents"/>

                @endif

                @if (isset($favourites) && $favourites == 1)
                    {{-- Users favourites profiles --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5 mt-5"> 
                        @foreach ($favourites_data as $item)
                            <x-user-card :data="$item['profile']" :favourites="$favourites_list" :opened="$opened_profiles->contains('profile_id', $item['profile']['id'])" />
                        @endforeach
                    </div>
                @endif

                @if (isset($recomendations) && $recomendations == 1)
                    {{-- Users recomendations profiles --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5 mt-5"> 
                        @foreach ($recommendations_data as $item)
                            <x-user-card :data="$item['profile']" :favourites="$favourites_list" :opened="$opened_profiles->contains('profile_id', $item['profile']['id'])" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div> 
        

    </div>

    {{-- 
    
    Footer

    --}}
    <x-footer />

@endsection