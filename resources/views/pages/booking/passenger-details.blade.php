@extends('layouts.app')

@section('include')
<div id="Background-home" class="absolute w-full h-full top-0 bg-white">
    <div class="absolute top-0 w-full h-[1020px]"
        style="background: linear-gradient(90deg, #D4AF37 0%, #F7E7B4 50%, #FFFFFF 100%);">
    </div>
</div>
@endsection

@section('content')
<main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
    <a href="choose-seats-economy.html"
        class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
        <img src="{{ asset('assets/images/icons/arrow-left-white.svg') }}" class="w-6 h-6" alt="icon">
        <p class="font-semibold text-white">Kembali</p>
    </a>
    <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Detail Penumpang</h1>
    <form action="{{ route('booking.savePassengerDetails', $flight->flight_number) }}" method="POST"
        class="flex gap-[30px] mt-[30px]">
        @csrf
        <div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">
            <div id="Flight-Info" class="flex flex-col w-[470px] shrink-0 h-fit rounded-[20px] bg-white p-5 gap-5">
                <h2 class="font-bold text-xl leading-[30px]">Perjalanan Anda</h2>
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-garuda-grey">Asal</p>
                        <p class="font-semibold text-lg">{{ $flight->segments->first()->airport->city }}
                            ({{ $flight->segments->first()->airport->iata_code }})</p>
                    </div>
                    <div class="text-end">
                        <p class="text-sm text-garuda-grey">Tujuan</p>
                        <p class="font-semibold text-lg">{{ $flight->segments->last()->airport->city }}
                            ({{ $flight->segments->last()->airport->iata_code }})</p>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-garuda-grey">Tanggal</p>
                        <p class="font-semibold text-lg">{{ $flight->segments->first()->time->format('d F Y') }}</p>
                    </div>
                    <div class="text-end">
                        <p class="text-sm text-garuda-grey">Jumlah</p>
                        <p class="font-semibold text-lg">{{ count($transaction['selected_seats']) }} people</p>
                    </div>
                </div>
                <div class="flex flex-col rounded-[20px] border border-[#E8EFF7] p-5 gap-5">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-[10px]">
                                <img src="{{ asset('storage/' . $flight->airline->logo) }}"
                                    class="w-[60px] h-[60px] flex shrink-0" alt="logo">
                                <div>
                                    <p class="font-semibold">{{ $flight->airline->name }}</p>
                                    <p class="text-sm text-garuda-grey mt-[2px]">
                                        {{ $flight->segments->first()->time->format('H:i') }} -
                                        {{ $flight->segments->last()->time->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <a href="#"
                                class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
                                <p class="font-semibold text-white">Detail</p>
                            </a>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-[2px] items-center justify-center">
                                <p class="text-sm text-garuda-grey">
                                    {{ number_format($flight->segments->first()->time->diffInHours($flight->segments->last()->time), 0) }}
                                    jam
                                </p>
                                <div class="flex items-center gap-[6px]">
                                    <p class="font-semibold">{{ $flight->segments->first()->airport->iata_code }}
                                    </p>
                                    @if ($flight->segments->count() > 2)
                                        <img src="{{ asset('assets/images/icons/transit-black.svg') }}" alt="icon">
                                    @else
                                        <img src="{{ asset('assets/images/icons/direct-black.svg') }}" alt="icon">
                                    @endif
                                    <p class="font-semibold">{{ $flight->segments->last()->airport->iata_code }}
                                    </p>
                                </div>
                                @if ($flight->segments->count() > 2)
                                    <p class="text-sm text-garuda-grey">Transit {{$flight->segments->count() - 2}}x</p>
                                @else
                                    <p class="text-sm text-garuda-grey">Direct</p>
                                @endif
                            </div>
                            <p class="font-semibold text-garuda-green text-center">
                                {{'Rp. ' . number_format($flight->classes->first()->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="Transaction-Info"
                class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                <label class="flex items-center justify-between p-5">
                    <h2 class="font-bold text-xl leading-[30px]">Detail Transaksi</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
                        class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-garuda-grey">Jumlah</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ count($transaction['selected_seats']) }} orang
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Kelas</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">{{ ucfirst($tier->class_type) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Kursi</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ implode(',', $flight->seats->whereIn('id', $transaction['selected_seats'])->pluck('name')->toArray()) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-garuda-grey">Harga</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{'Rp. ' . number_format($tier->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">PPN</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">11%</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Sub Total</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. ' . number_format($tier->price * count($transaction['selected_seats']), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-garuda-grey">Total PPN</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. ' . number_format($tier->price * count($transaction['selected_seats']) * 0.11, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Grand Total</p>
                            <p class="font-bold text-2xl leading-9 text-garuda-blue mt-[2px]">
                                {{ 'Rp. ' . number_format($tier->price * count($transaction['selected_seats']) * 1.11, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                <span class="font-semibold text-white">Lanjutkan Pesanan</span>
            </button>
        </div>
        <div id="Right-Content" class="flex flex-col gap-[30px] w-[490px] shrink-0">
            <div id="Customer-Info"
                class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                <label class="flex items-center justify-between p-5">
                    <h2 class="font-bold text-xl leading-[30px]">Informasi Pelanggan</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
                        class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Nama Lengkap</p>
                        <div
                            class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('name') border-red-500 @enderror">
                            <img src="{{ asset('assets/images/icons/profile-black.svg') }}" class="w-5 flex shrink-0"
                                alt="icon">
                            <input type="text" id="" name="name"
                                class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                placeholder="Write your complete name">
                        </div>

                        @error('name')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Alamat Email</p>
                        <div
                            class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('email') border-red-500 @enderror">
                            <img src="{{ asset('assets/images/icons/sms-black.png') }}" class="w-5 flex shrink-0"
                                alt="icon">
                            <input type="email" id="" name="email"
                                class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                placeholder="Write your valid email">
                        </div>
                        @error('email')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">No. Telepon</p>
                        <div
                            class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('phone') border-red-500 @enderror">
                            <img src="{{ asset('assets/images/icons/call-black.svg') }}" class="w-5 flex shrink-0"
                                alt="icon">
                            <input type="tel" id="" name="phone"
                                class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                placeholder="Write your active number">
                        </div>
                        @error('phone')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <!-- for accordions with select input inside, the script was different from the normal accordion -->
            @foreach ($transaction['selected_seats'] as $transaction)

                <input type="hidden" name="passengers[{{ $loop->index }}][flight_seat_id]" value="{{ $transaction }}">
                <div id="Passenger-{{ $loop->index + 1 }}"
                    class="accordion-with-select group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden transition-all duration-300">
                    <button type="button" class="accordion-btn flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Penumpang {{ $loop->index + 1}}</h2>
                        <img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
                            class="arrow w-9 h-8 transition-all duration-300" alt="icon">
                    </button>
                    <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Nama Lengkap</p>
                            <div
                                class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('passengers.' . $loop->index . '.name') border-red-500 @enderror">
                                <img src="{{ asset('assets/images/icons/profile-black.svg') }}" class="w-5 flex shrink-0"
                                    alt="icon">
                                <input type="text" name="passengers[{{ $loop->index }}][name]" id=""
                                    class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                    placeholder="Write your complete name">
                            </div>
                            @error('passengers.' . $loop->index . '.name')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                        <div class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Tanggal Lahir</p>
                            <input type="hidden" name="passengers[{{ $loop->index }}][date_of_birth]"
                                id="dateOfBirth-{{ $loop->index }}" data-index="{{ $loop->index }}">
                            <div class="flex items-center gap-[10px]">
                                <label
                                    class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('passengers.' . $loop->index . '.date_of_birth') border-red-500 @enderror">
                                    <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                        class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                    <select id="day-select-{{ $loop->index }}" name=""
                                        class="date-select day-select appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal"
                                        data-index="{{ $loop->index }}" onChange="updateDateOfBirth({{ $loop->index }})">
                                        <option hidden>DD</option>
                                    </select>
                                </label>
                                <label
                                    class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('passengers.' . $loop->index . '.date_of_birth') border-red-500 @enderror">
                                    <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                        class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                    <select id="month-select-{{ $loop->index }}" name=""
                                        class="date-select month-select appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal"
                                        data-index="{{ $loop->index }}" onChange="updateDateOfBirth({{ $loop->index }})">
                                        <option hidden>MM</option>
                                    </select>
                                </label>
                                <label
                                    class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('passengers.' . $loop->index . '.date_of_birth') border-red-500 @enderror">
                                    <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                        class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                    <select id="year-select-{{ $loop->index }}" name=""
                                        class="date-select year-select appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal"
                                        data-index="{{ $loop->index }}" onChange="updateDateOfBirth({{ $loop->index }})">
                                        <option hidden>YYYY</option>
                                    </select>
                                </label>
                            </div>
                            @error('passengers.' . $loop->index . '.date_of_birth')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Kebangsaan</p>
                            <div
                                class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300 @error('passengers.' . $loop->index . '.nationality') border-red-500 @enderror">
                                <img src="{{ asset('assets/images/icons/global-black.svg') }}"
                                    class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                <select name="passengers[{{ $loop->index }}][nationality]" id=""
                                    class="appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal">
                                    <option hidden>Select country region</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Indonesia">Indonesia</option>
                                </select>
                            </div>
                            @error('passengers.' . $loop->index . '.nationality')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                </div>
            @endforeach


        </div>
    </form>
</main>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/date-of-birth.js') }}"></script>

<!-- <script src="{{ asset('assets/js/updateDOB.js') }}"></script> -->

<script>
    function updateDateOfBirth(index) {
        const day = document.getElementById(`day-select-${index}`).value;
        const month = document.getElementById(`month-select-${index}`).value;
        const year = document.getElementById(`year-select-${index}`).value;

        if (day && month && year) {
            document.getElementById(`dateOfBirth-${index}`).value = `${year}-${month}-${day}`;
        }
    }

</script>

@endsection