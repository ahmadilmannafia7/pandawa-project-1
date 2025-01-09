@extends('layouts.app')

@section('include')
<div id="Background-home" class="absolute w-full h-full top-0 bg-white">
    <div class="absolute top-0 w-full h-[1020px]"
        style="background: linear-gradient(180deg, #D4AF37 0%, #F7E7B4 50%, #FFFFFF 100%);">
    </div>
</div>
@endsection

@section('content')
<main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
    <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Cari Pesanan</h1>
    <div class="flex gap-[30px] mt-[30px]">
        <form action="{{ route('booking.check') }}" method="POST" class="flex flex-col gap-[30px] w-[490px] shrink-0">
            @csrf
            <div id="Booking-details" class="flex flex-col rounded-[20px] p-5 gap-5 bg-white overflow-hidden">
                <h2 class="font-bold text-xl leading-[30px]">Cek Pesanan Tiket Anda</h2>
                <div class="flex flex-col gap-5">
                    <p class="font-semibold">ID Transaksi Pesanan</p>
                    <div
                        class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300">
                        <img src="assets/images/icons/note-favorite-black.svg" class="w-5 flex shrink-0" alt="icon">
                        <input type="text" name="code" id=""
                            class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                            placeholder="Write your booking id">
                    </div>
                </div>
                <div class="flex flex-col gap-5">
                    <p class="font-semibold">No. Telepon</p>
                    <div
                        class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300">
                        <img src="assets/images/icons/call-black.svg" class="w-5 flex shrink-0" alt="icon">
                        <input type="tel" name="phone" id=""
                            class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                            placeholder="Write your phone number">
                    </div>
                </div>
                <button type="submit"
                    class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300" style="background-color: #D9A520;">
                    <span class="font-semibold text-white">Cari Detail Pesanan Saya</span>
                </button>
                <p class="mt-5">Jika anda memiliki masalah dalam pemeriksaan status silahkan menghubungi tim sales kami
                    untuk anda</p>
                <a href="#"
                    class="flex justify-center w-full rounded-full py-3 px-5 text-center border border-garuda-black gap-[10px] hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                    <img src="assets/images/icons/call-calling-black.svg" class="w-5 flex shrink-0" alt="icon">
                    <span class="font-semibold">Hubungi Kami</span>
                </a>
            </div>
        </form>
    </div>
</main>
@endsection