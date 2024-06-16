@php
    $birthdate = $data['user']['birthday'];

    $birthDateObj = new DateTime($birthdate);

    $currentDate = new DateTime();

    $age = $currentDate->diff($birthDateObj)->y;
@endphp

<div class="px-4 py-4 rounded-2xl flex flex-col justify-between h-96 bg-cover" style="background-image: url(storage/images/{{$data['image']}}); background-position: center;">
    <div class="flex justify-between">
        <div></div>
        <div class="text-white font-medium text-lg">{{$data['id']}}</div>
        <div class="flex">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.4998 12.572L11.9998 20L4.49981 12.572C4.00512 12.0906 3.61546 11.512 3.35536 10.8726C3.09527 10.2333 2.97037 9.54694 2.98855 8.85693C3.00673 8.16691 3.16758 7.48813 3.46097 6.86333C3.75436 6.23853 4.17395 5.68125 4.6933 5.22657C5.21265 4.7719 5.82052 4.42968 6.47862 4.22147C7.13673 4.01327 7.83082 3.94358 8.51718 4.0168C9.20354 4.09001 9.86731 4.30455 10.4667 4.6469C11.0661 4.98925 11.5881 5.45199 11.9998 6.00599C12.4133 5.45602 12.9359 4.99731 13.5349 4.6586C14.1339 4.31988 14.7963 4.10844 15.4807 4.03751C16.1652 3.96658 16.8569 4.03769 17.5126 4.24639C18.1683 4.45508 18.7738 4.79687 19.2914 5.25036C19.8089 5.70385 20.2272 6.25928 20.5202 6.88189C20.8132 7.50449 20.9746 8.18088 20.9941 8.8687C21.0137 9.55653 20.8911 10.241 20.6339 10.8792C20.3768 11.5175 19.9907 12.0958 19.4998 12.578" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>                                                         
        </div>
    </div>

    <div class="flex flex-col gap-1">
        <div class="text-white font-medium text-lg">{{$data['nationality']}}</div>
        <div class="flex justify-between">
            <div class="px-4 py-2 bg-white text-black rounded-full font-medium">{{$age}} лет</div>
            <div class="text-white font-medium text-lg">{{$data['city']}}</div>
        </div>
    </div>
</div>