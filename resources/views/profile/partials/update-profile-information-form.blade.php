<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-black">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div>
            <x-input-label class="block text-sm font-medium !text-gray-700" for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm !bg-white !text-black" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label class="block text-sm font-medium !text-gray-700" for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm !bg-white !text-black" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- School ID -->
        <div>
            <x-input-label class="block text-sm font-medium !text-gray-700" for="school_id" :value="__('School ID')" />
            <x-text-input id="school_id" name="school_id" type="text" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm !bg-white !text-black" :value="old('school_id', $user->school_id)" />
            <x-input-error class="mt-2" :messages="$errors->get('school_id')" />
        </div>
 
        <div class="flex gap-4 mb-4">
            <!-- Profile Image -->
            <div>
                <x-input-label class="block text-sm font-medium !text-gray-700" for="image" :value="__('Profile Image')" />
                <input id="image" name="image" type="file" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm !bg-white !text-black" accept="image/*" />
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" class="mt-2 h-20 w-20 rounded-full object-cover">
                @endif
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>

            <!-- Barcode Image -->
            <div>
                <x-input-label class="block text-sm font-medium !text-gray-700" for="barcode_image" :value="__('Barcode Image')" />
                <input id="barcode_image" name="barcode_image" type="file" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm !bg-white !text-black" accept="image/*" />
                @if ($user->barcode_image)
                    <img src="{{ asset('storage/' . $user->barcode_image) }}" alt="Barcode Image" class="mt-2 h-20 w-20 object-cover">
                @endif
                <x-input-error class="mt-2" :messages="$errors->get('barcode_image')" />
            </div>
        </div>

        <div class="flex items-center justify-center mt-4 text-center">
            <x-primary-button class="ml-4 !bg-[maroon] hover:!bg-[#b90000] !text-white font-bold py-2 px-16 rounded transition duration-300 ease-in-out">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>



<script>
    function previewImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
