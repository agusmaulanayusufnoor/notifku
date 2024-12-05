<div x-data="{ isOpen: true, isDevicesOpen: false }" class="flex h-screen transition-all duration-300 ease-in-out"
    :class="isOpen ? 'w-64' : 'w-20'">
    <div :class="isOpen ? 'w-64' : 'w-20'"
        class="flex flex-col h-full bg-gradient-to-b from-blue-500 to-green-600 text-white 
        shadow-[0_15px_30px_5px_rgba(0,0,0,0.2)] rounded-lg transition-all duration-300 ease-in-out">
        <div class="flex items-center justify-between p-4">
            <h2 x-show="isOpen" class="text-2xl font-bold">NotifKU</h2>
            <button @click="isOpen = !isOpen"
                class="p-2 rounded-full hover:bg-white/20 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white"
                aria-label="Toggle sidebar">
                <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H9m6 0l-3-3m3 3l-3 3" />
                </svg>
                <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 0l3 3m-3-3l3-3" />
                </svg>
            </button>
        </div>
        <nav class="flex-grow">
            <ul class="space-y-1 p-4">

                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-white/20 transition-colors duration-200"
                        :class="isOpen ? 'justify-start' : 'justify-center'">
                        <x-heroicon-o-home class="w-5 h-5 mr-0" />
                        <span x-show="isOpen" class="ml-4">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a @click="isDevicesOpen = !isDevicesOpen"
                        class="flex items-center p-3 rounded-lg hover:bg-white/20 transition-colors duration-200"
                        :class="isOpen ? 'justify-start' : 'justify-center'">

                        <x-heroicon-o-cog class="w-5 h-5 mr-0" />
                        <span x-show="isOpen" class="ml-4">
                            Settings
                        </span>
                        <svg x-show="isOpen" :class="isDevicesOpen ? 'rotate-90' : 'rotate-0'"
                            class="h-4 w-4 ml-auto transition-transform duration-200" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M6 8l4 4 4-4H6z" />
                        </svg> <!-- Arrow icon -->
                    </a>
                    {{-- <a @click="isDevicesOpen = !isDevicesOpen" class="flex items-center p-3 rounded-lg hover:bg-white/20 transition-colors duration-200" :class="isOpen ? 'justify-start' : 'justify-center'">
                        <x-heroicon-o-cog class="w-5 h-5 mr-0" />
                        <span x-show="isOpen" class="ml-4">Settings</span>
                    </a> --}}
                    <ul x-show="isDevicesOpen" class="ml-4 space-y-2">
                        <li>
                            <a href="{{ route('devices.index') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-white/20 transition-colors duration-200"
                                :class="isOpen ? 'justify-start' : 'justify-center'">
                                <x-heroicon-o-device-phone-mobile class="w-5 h-5 mr-0" />
                                <span x-show="isOpen" class="ml-4">Devices</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
