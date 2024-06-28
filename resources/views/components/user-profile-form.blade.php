@php
    $birthdate = $user[0]['birthday'];

    $birthDateObj = new DateTime($birthdate);

    $currentDate = new DateTime();

    $age = $currentDate->diff($birthDateObj)->y;
@endphp
<form method="post" action="{{route('profile.store')}}" enctype="multipart/form-data">
    @csrf

    @if ($user[0]['profile']['country'] == null ||
    $user[0]['profile']['city'] == null ||
    $user[0]['profile']['nationality'] == null ||
    $user[0]['profile']['profession'] == null ||
    $user[0]['profile']['work_place'] == null ||
    $user[0]['profile']['status'] == null ||
    $user[0]['profile']['height'] == null ||
    $user[0]['profile']['weight'] == null ||
    $user[0]['profile']['education'] == null ||
    $user[0]['profile']['image'] == null
    )
    
    <div class="font-medium text-xl">Ваша анкета не заполнена.</div>
    <div class="text-sm text-slate-500">Чтобы другие могли видеть вашу анкету, вы должны заполнить обязательные поля, обозначенные <span class="text-red-400">*</span></div>
    
    @else
    
    <div class="font-medium text-xl">Ваша анкета активна.</div>
    <div class="text-sm text-slate-500">Ваша анкета видна другим пользователям.</div>

    @endif

    @error('msg-error')
        <span class="text-sm text-red-400">{{ $message }}</span>
    @enderror
    @session('msg-success')
        <span class="text-sm text-green-400">{{ session('msg-success') }}</span>
    @endsession


    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-5">


        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Номер анкеты</label>
            <div class="mt-2">
                <input value="{{$user[0]['profile']['id']}}" disabled class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Возраст</label>
            <div class="mt-2">
                <input value="{{$age}}" disabled class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Страна<span class="text-red-400">*</span></label>
            @error('country')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            {{-- <div class="mt-2">
                <select name="country" class="h-9 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6">
                    <option value="Россия">Россия</option>
                    <option value="Казахстан">Казахстан</option>
                    <option value="Киргизия">Киргизия</option>
                    <option value="Узбекистан">Узбекистан</option>
                    <option value="Таджикистан">Таджикистан</option>
                    <option value="Чечня">Чечня</option>
                    <option value="Татарстан">Татарстан</option>
                    <option value="Другая">Другая</option>
                </select>
            </div> --}}
            <div class="mt-2">
                <input name="country" value="{{$user[0]['profile']['country']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Город<span class="text-red-400">*</span></label>
            @error('city')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            {{-- <div class="mt-2">
                <select name="city" class="h-9 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6">
                    <option value="Москва">Москва</option>
                    <option value="Астана">Астана</option>
                </select>
            </div> --}}
            <div class="mt-2">
                <input name="city" value="{{$user[0]['profile']['city']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Национальность<span class="text-red-400">*</span></label>
            @error('nationality')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <select name="nationality" class="h-9 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6">
                    <option value="Русский" {{ $user[0]['profile']['nationality'] == 'Русский' ? 'selected' : '' }}>Русский</option>
                    <option value="Казах" {{ $user[0]['profile']['nationality'] == 'Казах' ? 'selected' : '' }}>Казах</option>
                    <option value="Киргиз" {{ $user[0]['profile']['nationality'] == 'Киргиз' ? 'selected' : '' }}>Киргиз</option>
                    <option value="Узбек" {{ $user[0]['profile']['nationality'] == 'Узбек' ? 'selected' : '' }}>Узбек</option>
                    <option value="Таджик" {{ $user[0]['profile']['nationality'] == 'Таджик' ? 'selected' : '' }}>Таджик</option>
                    <option value="Чеченец" {{ $user[0]['profile']['nationality'] == 'Чеченец' ? 'selected' : '' }}>Чеченец</option>
                    <option value="Татар" {{ $user[0]['profile']['nationality'] == 'Татар' ? 'selected' : '' }}>Татар</option>
                </select>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Профессия<span class="text-red-400">*</span></label>
            @error('profession')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <input name="profession" value="{{$user[0]['profile']['profession']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Место работы<span class="text-red-400">*</span></label>
            @error('work_place')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <input name="work_place" value="{{$user[0]['profile']['work_place']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Статус<span class="text-red-400">*</span></label>
            @error('status')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <select name="status" class="h-9 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6">
                    <option value="Свободен/Свободна"{{ $user[0]['profile']['status'] == 'Свободен/Свободна' ? 'selected' : '' }}>Свободен/Свободна</option>
                    <option value="В отношениях"{{ $user[0]['profile']['status'] == 'В отношениях' ? 'selected' : '' }}>В отношениях</option>
                    <option value="Женат/Замужем"{{ $user[0]['profile']['status'] == 'Женат/Замужем' ? 'selected' : '' }}>Женат/Замужем</option>
                    <option value="Разведен/Разведена"{{ $user[0]['profile']['status'] == 'Разведен/Разведена' ? 'selected' : '' }}>Разведен/Разведена</option>
                </select>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Рост<span class="text-red-400">*</span></label>
            @error('height')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2 flex items-center gap-2">
                <input name="height" type="number" value="{{$user[0]['profile']['height']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                <div>см.</div>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Вес<span class="text-red-400">*</span></label>
            @error('weight')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2 flex items-center gap-2">
                <input name="weight" type="number" value="{{$user[0]['profile']['weight']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
                <div>кг.</div>
            </div>
        </div>


        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Хобби</label>
            <div class="mt-2">
                <div id="hobbies" class="grid grid-cols-2">
                    @foreach ($hobbies as $item)
                        <div class="flex items-center">
                            <input type="checkbox" name="hobbies[]" value="{{$item['id']}}" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" {{ in_array($item['name'], $user[0]['profile']['hobbies']->pluck('hobby.name')->toArray()) ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-900">{{$item['name']}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center mt-2 gap-2">
                    <input type="text" id="new-hobby" class="text-black w-1/2 border-gray-300 rounded focus:ring-black border border-slate-400 w-32 py-1.5 px-2 text-sm">
                    <button id="add-hobbies" class="bg-slate-900 w-1/2 text-white px-4 py-2 rounded-md font-medium text-sm">Добавить</button>
                </div>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Предпочтения</label>
            <div class="mt-2">
                <div id="preferences" class="grid grid-cols-2">

                    @foreach ($preferences as $item)
                        <div class="flex items-center">
                            <input type="checkbox" name="preferences[]" value="{{$item['id']}}" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" {{ in_array($item['name'], $user[0]['profile']['preferences']->pluck('preference.name')->toArray()) ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-900">{{$item['name']}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center mt-2 gap-2">
                    <input type="text" id="new-preference" class="text-black w-1/2 border-gray-300 rounded focus:ring-black border border-slate-400 w-32 py-1.5 px-2 text-sm">
                    <button id="add-preference" class="bg-slate-900 w-1/2 text-white px-4 py-2 rounded-md font-medium text-sm">Добавить</button>
                </div>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Про себя</label>
            <div class="mt-2">
                <div id="preferencesabot" class="grid grid-cols-2">

                    @foreach ($preferences as $item)
                        <div class="flex items-center">
                            <input type="checkbox" name="preferencesabot[]" value="{{$item['id']}}" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" {{ in_array($item['name'], $user[0]['profile']['about']->pluck('preference.name')->toArray()) ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-900">{{$item['name']}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center mt-2 gap-2">
                    <input type="text" id="new-preferencesabot" class="text-black w-1/2 border-gray-300 rounded focus:ring-black border border-slate-400 w-32 py-1.5 px-2 text-sm">
                    <button id="add-preferencesabot" class="bg-slate-900 w-1/2 text-white px-4 py-2 rounded-md font-medium text-sm">Добавить</button>
                </div>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Родители</label>
            <div class="mt-2">
                <div class="grid grid-cols-2">

                    @foreach ($parents as $item)
                        <div class="flex items-center">
                            <input type="checkbox" name="parents[]" value="{{$item['id']}}" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black" {{ in_array($item['name'], $user[0]['profile']['parents']->pluck('parent.name')->toArray()) ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-900">{{$item['name']}}</label>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Детская травма.</label>
            @error('child_trauma')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <input name="child_trauma" value="{{$user[0]['profile']['child_trauma']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class=""></div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Образование<span class="text-red-400">*</span></label>
            @error('education')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <select name="education" class="h-9 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6">
                    <option value="Среднее" {{ $user[0]['profile']['education'] == 'Среднее' ? 'selected' : '' }}>Среднее</option>
                    <option value="Среднее специальное" {{ $user[0]['profile']['education'] == 'Среднее специальное' ? 'selected' : '' }}>Среднее специальное</option>
                    <option value="Высшее" {{ $user[0]['profile']['education'] == 'Высшее' ? 'selected' : '' }}>Высшее</option>
                    <option value="Неоконченное высшее" {{ $user[0]['profile']['education'] == 'Неоконченное высшее' ? 'selected' : '' }}>Неоконченное высшее</option>
                    <option value="Аспирантура/Докторантура" {{ $user[0]['profile']['education'] == 'Аспирантура/Докторантура' ? 'selected' : '' }}>Аспирантура/Докторантура</option>
                </select>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Ссылка на instagram</label>
            @error('instagram')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <input name="instagram" value="{{$user[0]['profile']['instagram']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Ссылка на telegram</label>
            @error('telegram')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <input name="telegram" value="{{$user[0]['profile']['telegram']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Ссылка на facebook</label>
            @error('facebook')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <input name="facebook" value="{{$user[0]['profile']['facebook']}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Фотография<span class="text-red-400">*</span></label>
            @error('image')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2 h-32 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 items-center">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                    </svg>
                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                        <label for="image" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                            <span>Upload a file</span>
                            <input id="image" name="image" type="file" accept=".jpeg,.jpg,.png" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs leading-5 text-gray-600">JPEG, PNG, JPG, up to 2MB</p>
                </div>
            </div>
        </div>

        <div class="">
            <label class="block text-sm font-medium leading-6 text-gray-900">Комментарий</label>
            @error('message')
                <span class="text-sm text-red-400">{{ $message }}</span>
            @enderror
            <div class="mt-2">
                <textarea name="message" class="max-h-32 block w-full rounded-md border-0 py-1.5 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-black sm:text-sm sm:leading-6" id="" cols="30" rows="10">{{$user[0]['profile']['message']}}</textarea>
            </div>
        </div>


    </div>
    

    <div class="flex items-center mt-2 gap-2">
        <button type="submit" class="bg-slate-900 w-full text-white px-4 py-2 rounded-md font-medium text-sm">Сохранить</button>
    </div>

</form>