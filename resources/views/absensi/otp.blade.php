<x-app-layout>
    <div class="min-h-[80vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01] duration-300">
            
            {{-- Header Color Bar --}}
            <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

            <div class="p-8">
                {{-- Icon --}}
                <div class="mx-auto w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-2">
                    Verifikasi OTP
                </h2>
                
                <p class="text-center text-gray-500 mb-8 text-sm">
                    Kode verifikasi telah dikirim ke email<br>
                    <span class="font-semibold text-gray-800">{{ preg_replace('/(?<=.).(?=.*@)/', '*', auth()->user()->email) }}</span>
                </p>

                {{-- Timer Display --}}
                <div class="flex justify-center mb-8">
                    <div class="bg-gray-50 rounded-2xl px-6 py-3 border border-gray-100 shadow-inner">
                        <span id="countdown-display" class="font-mono text-3xl font-bold text-blue-600 tracking-wider">
                            --:--
                        </span>
                    </div>
                </div>

                {{-- Alert Messages --}}
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg text-sm mb-6 animate-pulse">
                        {{ session('error') }}
                    </div>
                @endif
                 @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg text-sm mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form OTP --}}
                <form method="POST" action="{{ route('absensi.verifikasiOtp') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="otp" class="sr-only">Kode OTP</label>
                        <input type="text" name="otp" id="otp" placeholder="Masukkan 6 Digit OTP"
                               maxlength="6"
                               class="block w-full text-center text-2xl font-bold tracking-[0.5em] rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 py-4 text-gray-700 placeholder:tracking-normal placeholder:font-normal placeholder:text-base placeholder:text-gray-400"
                               required
                               autocomplete="off"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>

                    <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                        Verifikasi Sekarang
                    </button>
                </form>

                {{-- Resend Section --}}
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 mb-3">Belum menerima kode?</p>
                    <form method="POST" action="{{ route('absensi.kirimOtp') }}">
                        @csrf
                        <button id="resend-btn" type="submit" disabled
                                class="text-sm font-semibold text-gray-400 cursor-not-allowed transition duration-200"
                                onclick="return confirm('Kirim ulang OTP?');">
                            Kirim Ulang OTP <span id="resend-timer"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ExpiredAt timestamp (seconds) from controller
            // PHP passes it as seconds integer
            const serverExpiredAt = {{ $otpExpiredAt ?? 0 }};
            // Convert to milliseconds
            const expiredTime = serverExpiredAt * 1000;
            
            const display = document.getElementById('countdown-display');
            const resendBtn = document.getElementById('resend-btn');
            const resendTimerLabel = document.getElementById('resend-timer');
            const otpInput = document.getElementById('otp');

            // Focus input automatically
            if(otpInput) otpInput.focus();

            function updateTimer() {
                const now = new Date().getTime();
                const distance = expiredTime - now;

                if (distance < 0) {
                    // Expired
                    display.innerText = "00:00";
                    display.classList.remove('text-blue-600');
                    display.classList.add('text-red-500');
                    
                    // Enable Resend
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('text-gray-400', 'cursor-not-allowed');
                    resendBtn.classList.add('text-blue-600', 'hover:text-blue-800', 'hover:underline');
                    resendTimerLabel.innerText = "";
                    return;
                }

                // Calculate time
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Format "MM:SS"
                const fmtMin = minutes.toString().padStart(2, '0');
                const fmtSec = seconds.toString().padStart(2, '0');
                
                display.innerText = `${fmtMin}:${fmtSec}`;
                resendTimerLabel.innerText = `(${fmtMin}:${fmtSec})`;
            }

            // Init
            if (serverExpiredAt > 0) {
                updateTimer(); // run once
                setInterval(updateTimer, 1000);
            } else {
                display.innerText = "--:--";
                // If 0, assume expired or error, enable resend
                resendBtn.disabled = false;
                resendBtn.classList.remove('text-gray-400', 'cursor-not-allowed');
                resendBtn.classList.add('text-blue-600', 'hover:text-blue-800');
            }
        });
    </script>
</x-app-layout>
