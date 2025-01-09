@extends('layouts.app')


@section('include')
<div id="Background-home" class="absolute w-full h-full top-0 bg-white">
    <div class="absolute top-0 w-full h-[1020px]"
        style="height: 2000px; background: linear-gradient(135deg, #D4AF37 0%, #F7E7B4 50%, #FFFFFF 100%);">
        <img src="{{ asset('assets/images/backgrounds/pngtree-javanese-arjuna-wayang-png-image_8815856.png') }}"
            class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image"
            style="transform: translateX(-200px);">
    </div>
</div>
<!-- <div id="Background-home" class="absolute w-full h-full top-0 bg-white">
    <div class="relative top-0 w-full h-[1020px]"
        style="background: linear-gradient(180deg, #D4AF37 0%, #F7E7B4 50%, #FFFFFF 100%);">
        <img src="assets/images/backgrounds/pngtree-javanese-arjuna-wayang-png-image_8815856.png"
            class="absolute right-0 top-[147px] object-contain max-h-[481px] translate-x-[-50px]" alt="background image">
    </div>
</div> -->
@endsection
<!-- @section('include')
<div id="Background-home" class="absolute w-full h-full top-0 bg-white">
    <div class="absolute top-0 w-full h-full"
        style="background: linear-gradient(90deg, #D4AF37 0%, #F7E7B4 50%, #FFFFFF 100%);">
        <img src="assets/images/backgrounds/pngtree-javanese-arjuna-wayang-png-image_8815856.png"
                class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>
</div>
@endsection -->

@section('content')

<div id="Hero-Text" class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto gap-[30px] mt-[86px]">
    <div class="Badge flex items-center w-fit rounded-full p-[8px_14px] gap-[10px] bg-white">
        <img src="assets/images/icons/crown-black.svg" class="w-5 h-5 flex shrink-0" alt="icon">
        <p class="font-semibold text-sm">Armada Unit Elegan dan Berkelas </p>
    </div>
    <h1 class="font-extrabold text-[50px] leading-[75px]">Armada unit elegan <br>dan berkelas</h1>
    <p class="text-lg leading-8">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia sint mollitia<br>
        veritatis sapiente repellat porro accusantium nemo enim. <br>Natus modi in quasi quam pariatur ipsam ullam quos
        velit quo laborum!</p>
</div>
<form action="{{ route('flight.index') }}" method="GET"
    class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[86px]">
    <div class="flex flex-col rounded-[30px] p-[30px] gap-4 bg-white">
        <h2 class="font-bold text-xl leading-[30px]">Cari Perjalanan Anda</h2>
        <div class="flex items-center gap-5">
            <div class="grid grid-cols-4 items-center rounded-[20px] border border-[#E8EFF7]">
                <div id="Departure"
                    class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                    <button type="button"
                        class="dropdown flex items-center gap-4 p-5 first:pl-6 first:border-l-0 last:pr-6 last:border-r-0"
                        data-dropdown-target="#Departure-Dropdown">
                        <img src="assets/images/icons/date.svg" class="w-[50px] flex shrink-0" alt="icon">
                        <div class="text-left">
                            <p class="text-sm text-garuda-grey">Pilih Asal</p>
                            <p id="Departure-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Asal
                            </p>
                        </div>
                    </button>
                    <div id="Departure-Dropdown"
                        class="dropdown-content hidden absolute z-10 top-full mt-4 h-[232px] rounded-[18px] bg-white border border-[#E8EFF7] overflow-y-scroll custom-scrollbar">
                        <div class="flex flex-col justify-center w-[483px] p-5 gap-4 shrink-0">
                            @foreach ($airports as $airport)
                                <label
                                    class="relative flex items-center rounded-[10px] gap-[10px] p-0 has-[:checked]:p-[10px] has-[:checked]:bg-garuda-bg-grey transition-all duration-300">
                                    <input type="radio" name="departure" id="{{ $airport->iata_code }}"
                                        class="absolute top-1/2 left-1/2 opacity-0" value="{{ $airport->iata_code }}">
                                    <img src="assets/images/icons/arrow-up-circle-black.svg" class="flex shrink-0 w-[34px]"
                                        alt="icon">
                                    <div class="flex flex-col gap-[2px]">
                                        <p class="font-semibold">{{ $airport->name }} ({{ $airport->iata_code }})</p>
                                        <p class="text-sm text-garuda-grey">{{ $airport->city }}</p>
                                    </div>
                                </label>
                                <hr class="border-[#E8EFF7]">
                            @endforeach

                        </div>
                    </div>
                </div>
                <div id="Arrival"
                    class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                    <button type="button" class="dropdown flex items-center gap-4 p-5 first:pl-6 last:pr-6"
                        data-dropdown-target="#Arrival-Dropdown">
                        <img src="assets/images/icons/date.svg" class="w-[50px] flex shrink-0" alt="icon">
                        <div class="text-left">
                            <p class="text-sm text-garuda-grey">Pilih Tujuan</p>
                            <p id="Arrival-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Tujuan</p>
                        </div>
                    </button>
                    <div id="Arrival-Dropdown"
                        class="dropdown-content hidden absolute z-10 top-full mt-4 h-[232px] rounded-[18px] bg-white border border-[#E8EFF7] overflow-y-scroll custom-scrollbar">
                        <div class="flex flex-col justify-center w-[483px] p-5 gap-4 shrink-0">
                            @foreach ($airports as $airport)
                                <label
                                    class="relative flex items-center rounded-[10px] gap-[10px] p-0 has-[:checked]:p-[10px] has-[:checked]:bg-garuda-bg-grey transition-all duration-300">
                                    <input type="radio" name="arrival" id="{{ $airport->iata_code }}"
                                        class="absolute top-1/2 left-1/2 opacity-0" value="{{ $airport->iata_code }}">
                                    <img src="assets/images/icons/arrow-up-circle-black.svg" class="flex shrink-0 w-[34px]"
                                        alt="icon">
                                    <div class="flex flex-col gap-[2px]">
                                        <p class="font-semibold">{{ $airport->name }} ({{ $airport->iata_code }})</p>
                                        <p class="text-sm text-garuda-grey">{{ $airport->city }}</p>
                                    </div>
                                </label>
                                <hr class="border-[#E8EFF7]">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="Date"
                    class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                    <input type="date" name="date" id="date" class="absolute top-1/2 -z-10">
                    <button type="button" id="Date-Button"
                        class="relative flex items-center gap-4 p-5 first:pl-6 last:pr-6">
                        <img src="assets/images/icons/date.svg" class="w-[50px] flex shrink-0" alt="icon">
                        <div class="text-left">
                            <p class="text-sm text-garuda-grey">Tanggal</p>
                            <p id="Date-Label" class="font-semibold text-lg mt-[2px] text-nowrap"></p>
                        </div>
                    </button>
                </div>
                <div id="Quantity"
                    class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                    <button type="button" class="dropdown flex items-center gap-4 p-5 first:pl-6 last:pr-6"
                        data-dropdown-target="#Quantity-Dropdown">
                        <img src="assets/images/icons/date.svg" class="w-[50px] flex shrink-0" alt="icon">
                        <div class="text-left">
                            <p class="text-sm text-garuda-grey">Jumlah</p>
                            <p id="Quantity-Label" class="font-semibold text-lg mt-[2px] text-nowrap"><span
                                    class="number">1</span> orang</p>
                        </div>
                    </button>
                    <div id="Quantity-Dropdown" class="dropdown-content hidden absolute z-10 top-full mt-4">
                        <div class="flex items-center rounded-[18px] border border-[#E8EFF7] p-5 gap-[28px] bg-white">
                            <button type="button" id="minus" class="w-[38px] h-[38px] flex shrink-0">
                                <img src="assets/images/icons/minus.svg" alt="icon">
                            </button>
                            <p class="font-semibold text-nowrap"><span class="number">1</span> orang</p>
                            <input type="number" name="quantity" id="quantity" value="1" class="hidden">
                            <button type="button" id="plus" class="w-[38px] h-[38px] flex shrink-0">
                                <img src="assets/images/icons/plus.svg" alt="icon">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="flex flex-col items-center gap-[6px] rounded-[30px] py-3 px-5 bg-garuda-black hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                <img src="assets/images/icons/search-status-white.svg" class="flex shrink-0 w-[30px]" alt="icon">
                <p class="text-center font-semibold text-sm text-white">Explore</p>
            </button>
        </div>
    </div>
</form>
<section id="Popular" class="relative flex flex-col gap-[30px] mt-[70px] mb-[86px]">
    <div class="w-full max-w-[1280px] px-[75px] mx-auto">
        <h2 class="font-bold text-[28px] leading-[42px]">Terminal Pandawa</h2>
        <p class="text-lg mt-[6px]">You are missing out lorem dolor come</p>
    </div>
    <div class="swiper !w-full overflow-x-hidden">
        <div class="swiper-wrapper">

            @foreach ($airports as $airport)
                <div class="swiper-slide !w-fit first:ml-[calc(((100%-1280px)/2)+75px-24px)]">
                    <a href="#" class="card">
                        <div
                            class="flex items-end w-[230px] h-[280px] shrink-0 rounded-[30px] bg-white overflow-hidden hover:border-2 hover:border-garuda-blue hover:p-[10px] transition-all duration-300">
                            <img src="{{ asset('storage/' . $airport->image) }}"
                                class="w-full h-full object-cover rounded-[30px]" alt="thumbnails">
                            <div
                                class="absolute flex w-[210px] items-center bottom-[10px] left-[10px] right-[10px] rounded-[20px] p-[10px] gap-[10px] bg-white">
                                <img src="assets/images/icons/global-black.svg" class="w-6 flex shrink-0" alt="icon">
                                <div>
                                    <p class="font-semibold">{{ $airport->name }} ({{ $airport->iata_code }})</p>
                                    <p class="text-sm text-garuda-grey">{{ $airport->city }}, {{ $airport->country }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>

    <form action="{{ route('flight.index') }}" method="GET"
        class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[86px]">
        <div class="flex flex-col rounded-[30px] p-[30px] gap-4 bg-white">
            <h2 class="font-bold text-xl leading-[30px]">supported by</h2>
            <div style="display: flex; gap: 50px;">
                <img src="{{ asset('assets/images/logos/laravellogo.png') }}" alt=""
                    style="width: 100px; height: 100px; ">
                <img src="{{ asset('assets/images/logos/filamentlogo.jpg') }}" alt=""
                    style="width: 100px; height: 100px; ">
                <img src="{{ asset('assets/images/logos/midtranslogo.jpg') }}" alt=""
                    style="width: 100px; height: 100px; ">
            </div>



        </div>
    </form>
</section>
@endsection