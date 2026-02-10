<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="mb-10 text-center">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Pengaturan Profil</h2>
                <p class="text-gray-500 mt-2 font-medium">Kelola informasi akun dan keamanan kata sandi Anda.</p>
            </div>

            <div class="space-y-12">
                {{-- Update Profile Info Section --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden relative group">
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-indigo-500/5 rounded-full blur-3xl transition-all duration-700 group-hover:bg-indigo-500/10"></div>
                    <div class="p-8 sm:p-12 relative z-10">
                        <div class="max-w-2xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Update Password Section --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden relative group">
                    <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-blue-500/5 rounded-full blur-3xl transition-all duration-700 group-hover:bg-blue-500/10"></div>
                    <div class="p-8 sm:p-12 relative z-10">
                        <div class="max-w-2xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Delete Account Section (Optional, but good for completeness) --}}
                @if(file_exists(resource_path('views/profile/partials/delete-user-form.blade.php')))
                <div class="bg-red-50/30 rounded-[2.5rem] shadow-sm border border-red-100/50 overflow-hidden relative group">
                    <div class="p-8 sm:p-12">
                        <div class="max-w-2xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
