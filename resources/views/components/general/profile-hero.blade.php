<section id="heroSection" class="flex justify-center items-center relative px-5 bg-center bg-cover bg-no-repeat"
         style="background-image: url({{ asset('images/profile-hero-bg.jpg') }})">
    <p class="relative -top-5 text-white text-3xl lg:text-6xl text-center font-bold tracking-wide">{{ __('short-phrases.welcome') }}, {{ $user->first_name }}!</p>
    <label class="flex justify-center items-center absolute -bottom-8 lg:-bottom-12 w-24 h-24 lg:w-32 lg:h-32 bg-blue bg-center bg-cover bg-no-repeat border-6 border-white rounded-full cursor-pointer"
           style="background-image: url({{ $user->profile }})">
        @if(!$user->profile)
            <svg class="w-16 h-16" viewBox="0 0 166 166" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M83.0002 76.0833C98.28 76.0833 110.667 63.6965 110.667 48.4167C110.667 33.1368 98.28 20.75 83.0002
                      20.75C67.7203 20.75 55.3335 33.1368 55.3335 48.4167C55.3335 63.6965 67.7203 76.0833 83.0002 76.0833Z"
                      stroke="white" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M110.887 146.233C120.488 144.505 128.099 141.872 131.637 138.333C132.135 133.859 131.637 126.805
                      131.637 126.805C131.637 120.691 128.723 114.827 123.534 110.503C107.149 96.8484 52.3761 96.8484 35.9908
                      110.503C30.8023 114.827 27.8875 120.691 27.8875 126.805C27.8875 126.805 27.3903 133.859 27.8875 138.333C31.4258
                      141.872 39.037 144.505 48.6374 146.233" stroke="white" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        @endif
        <input hidden type="file" name="profile_picture">
    </label>
</section>
