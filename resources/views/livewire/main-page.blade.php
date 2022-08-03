<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 border-b border-gray-200">
                    <div class="mt-8 mb-8 text-2xl">
                        Configuration de l'import
                    </div>

                    <div class="relative overflow-hidden mb-8">
                        <form wire:submit.prevent="submit">
                            @if (session()->has('config_message'))
                                <div
                                    class="flex p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                                    role="alert">
                                    <svg aria-hidden="true" class="inline flex-shrink-0 mr-3 w-5 h-5"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium">{{ session('config_message') }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="grid-first-name">
                                        {{__('Date de début')}}
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        id="grid-first-name"
                                        type="date"
                                        wire:model.lazy="date_begin"
                                        required=""
                                    >
                                    @error('date_begin') <p
                                        class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="grid-last-name">
                                        {{__('Date de fin')}}
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-last-name"
                                        type="date"
                                        wire:model.lazy="date_end"
                                        required=""
                                    >
                                </div>
                                @error('date_end') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="grid-password">
                                        {{__('Nombre d\'heure par semaine')}}
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-last-name"
                                        type="number"
                                        wire:model.lazy="week_hours"
                                        required=""
                                    >
                                    @error('week_hours') <p
                                        class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="grid-first-name">
                                        {{('Heure de début de travail (format : hh:mm)')}}
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        id="grid-first-name"
                                        type="text"
                                        wire:model.lazy="hour_begin"
                                        required=""
                                    >
                                    @error('hour_begin') <p
                                        class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                                </div>

                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="grid-last-name">
                                        heure de fin
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-last-name"
                                        type="text"
                                        wire:model.lazy="hour_end"
                                    >
                                    @error('hour_end') <p
                                        class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                                </div>


                            </div>

                            <input type="hidden" name="user_id" wire:model="user_id"/>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{__('Save')}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-8">
                <div class="p-6 sm:px-20 border-b border-gray-200">
                    <div class="mt-8 mb-8 text-2xl">
                        {{__('Connexion aux fournisseurs Email')}}
                    </div>


                    <div
                        class="p-4 max-w-sm bg-white rounded-lg border shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700 {{ $blockClass }}">
                        <h5 class="mb-3 text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                            {{__('Gmail Suite')}}
                        </h5>
                        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                            @if(LaravelGmail::check())
                                {{__('Vous êtes connecté avec votre compte :name aux services suivant:', ['name' => LaravelGmail::user()])}}
                            @else
                                {{__('Si vous avez la suite Gmail, vous pouvez importer les mails et le données du calendrier')}}
                            @endif
                        </p>
                        <ul class="my-4 space-y-3">
                            @if(LaravelGmail::check())
                                @if(\App\Models\User::hasGmailScope())
                                    <li>
                                    <span
                                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px"
                                             height="48px"><linearGradient id="6769YB8EDCGhMGPdL9zwWa" x1="15.072"
                                                                           x2="24.111" y1="13.624" y2="24.129"
                                                                           gradientUnits="userSpaceOnUse"><stop
                                                    offset="0" stop-color="#e3e3e3"/><stop offset="1"
                                                                                           stop-color="#e2e2e2"/></linearGradient><path
                                                fill="url(#6769YB8EDCGhMGPdL9zwWa)"
                                                d="M42.485,40H5.515C4.126,40,3,38.874,3,37.485V10.515C3,9.126,4.126,8,5.515,8h36.969	C43.874,8,45,9.126,45,10.515v26.969C45,38.874,43.874,40,42.485,40z"/><linearGradient
                                                id="6769YB8EDCGhMGPdL9zwWb" x1="26.453" x2="36.17" y1="25.441"
                                                y2="37.643" gradientUnits="userSpaceOnUse"><stop offset="0"
                                                                                                 stop-color="#f5f5f5"/><stop
                                                    offset=".03" stop-color="#eee"/><stop offset="1" stop-color="#eee"/></linearGradient><path
                                                fill="url(#6769YB8EDCGhMGPdL9zwWb)"
                                                d="M42.485,40H8l37-29v26.485C45,38.874,43.874,40,42.485,40z"/><linearGradient
                                                id="6769YB8EDCGhMGPdL9zwWc" x1="3" x2="45" y1="24" y2="24"
                                                gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#d74a39"/><stop
                                                    offset="1" stop-color="#c73d28"/></linearGradient><path
                                                fill="url(#6769YB8EDCGhMGPdL9zwWc)"
                                                d="M5.515,8H8v32H5.515C4.126,40,3,38.874,3,37.485V10.515C3,9.126,4.126,8,5.515,8z M42.485,8	H40v32h2.485C43.874,40,45,38.874,45,37.485V10.515C45,9.126,43.874,8,42.485,8z"/><linearGradient
                                                id="6769YB8EDCGhMGPdL9zwWd" x1="24" x2="24" y1="8" y2="38.181"
                                                gradientUnits="userSpaceOnUse"><stop offset="0" stop-opacity=".15"/><stop
                                                    offset="1" stop-opacity=".03"/></linearGradient><path
                                                fill="url(#6769YB8EDCGhMGPdL9zwWd)"
                                                d="M42.485,40H30.515L3,11.485v-0.969C3,9.126,4.126,8,5.515,8h36.969	C43.874,8,45,9.126,45,10.515v26.969C45,38.874,43.874,40,42.485,40z"/><linearGradient
                                                id="6769YB8EDCGhMGPdL9zwWe" x1="3" x2="45" y1="17.73" y2="17.73"
                                                gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f5f5f5"/><stop
                                                    offset="1" stop-color="#f5f5f5"/></linearGradient><path
                                                fill="url(#6769YB8EDCGhMGPdL9zwWe)"
                                                d="M43.822,13.101L24,27.459L4.178,13.101C3.438,12.565,3,11.707,3,10.793v-0.278	C3,9.126,4.126,8,5.515,8h36.969C43.874,8,45,9.126,45,10.515v0.278C45,11.707,44.562,12.565,43.822,13.101z"/><linearGradient
                                                id="6769YB8EDCGhMGPdL9zwWf" x1="24" x2="24" y1="8.446" y2="27.811"
                                                gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#e05141"/><stop
                                                    offset="1" stop-color="#de4735"/></linearGradient><path
                                                fill="url(#6769YB8EDCGhMGPdL9zwWf)"
                                                d="M42.485,8h-0.3L24,21.172L5.815,8h-0.3C4.126,8,3,9.126,3,10.515v0.278	c0,0.914,0.438,1.772,1.178,2.308L24,27.459l19.822-14.358C44.562,12.565,45,11.707,45,10.793v-0.278C45,9.126,43.874,8,42.485,8z"/></svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">GMail</span>
                                    </span>
                                    </li>
                                @endif
                                @if(\App\Models\User::hasGCalendarScope())
                                    <li>
                                    <span
                                        class="flex items-center p-3 text-base font-bold text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px"
                                             height="48px" fill-rule="evenodd" clip-rule="evenodd"><path fill="#c7c7c7"
                                                                                                         fill-rule="evenodd"
                                                                                                         d="M38,5c-6.302,0-21.698,0-28,0C8.895,5,8,5.895,8,7 c0,3.047,0,3,0,3h32c0,0,0,0.047,0-3C40,5.895,39.105,5,38,5z M14,8c-0.552,0-1-0.448-1-1c0-0.552,0.448-1,1-1s1,0.448,1,1 C15,7.552,14.552,8,14,8z M34,8c-0.552,0-1-0.448-1-1c0-0.552,0.448-1,1-1s1,0.448,1,1C35,7.552,34.552,8,34,8z"
                                                                                                         clip-rule="evenodd"/><path
                                                fill="#1976d2" fill-rule="evenodd"
                                                d="M44,11c0.103-0.582-1.409-2-2-2C34.889,9,13.111,9,6,9 c-1,0-2.103,1.418-2,2c0.823,4.664,3,15,3,15h34C41,26,43.177,15.664,44,11z"
                                                clip-rule="evenodd"/><path fill="#1e88e5" fill-rule="evenodd"
                                                                           d="M41,26H7c0,0-2.177,10.336-3,15c0,1.146,0.792,2,2,2 c7.111,0,28.889,0,36,0c0.591,0,2-0.5,2-2C43.177,36.336,41,26,41,26z"
                                                                           clip-rule="evenodd"/><path fill="#fafafa"
                                                                                                      fill-rule="evenodd"
                                                                                                      d="M20.534 26c.984.325 1.687.85 2.105 1.557.433.732.65 1.55.65 2.457 0 1.582-.519 2.826-1.556 3.733-1.037.906-2.363 1.36-3.977 1.36-1.582 0-2.892-.427-3.93-1.282-1.038-.855-1.536-2.014-1.497-3.476l.036-.072h2.242c0 .914.28 1.642.841 2.182.56.541 1.33.811 2.308.811.994 0 1.773-.27 2.337-.811.564-.541.847-1.34.847-2.397 0-1.073-.25-1.864-.751-2.373-.501-.509-1.292-.763-2.373-.763h-2.051V26H20.534zM31.637 26H33.986000000000004V34.856H31.637z"
                                                                                                      clip-rule="evenodd"/><path
                                                fill="#e0e0e0" fill-rule="evenodd"
                                                d="M14.727 22.036h-2.254l-.024-.072c-.04-1.312.435-2.427 1.425-3.345.99-.918 2.284-1.377 3.882-1.377 1.606 0 2.886.427 3.84 1.282.954.855 1.431 2.073 1.431 3.655 0 .716-.217 1.429-.65 2.141-.433.712-1.083 1.254-1.95 1.628L20.534 26h-4.77v-.911h2.051c1.042 0 1.779-.26 2.212-.781.433-.521.65-1.246.65-2.176 0-.994-.246-1.749-.739-2.266-.493-.517-1.22-.775-2.182-.775-.914 0-1.648.268-2.2.805C15.022 20.414 14.746 21.098 14.727 22.036zM33.986 26L31.637 26 31.637 19.782 28.083 19.83 28.083 18.136 33.986 17.492z"
                                                clip-rule="evenodd"/><path fill="#1976d2" fill-rule="evenodd"
                                                                           d="M6 9c-1.438 0-2.103 1.418-2 2 .823 4.664 3 15 3 15M41 26c0 0 2.177-10.336 3-15 0-1.625-1.409-2-2-2"
                                                                           clip-rule="evenodd"/></svg>
                                        <span class="flex-1 ml-3 whitespace-nowrap">Google Calendar</span>
                                    </span>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('gmail.disconnect') }}"
                                       class="flex items-center p-3 text-base font-bold text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                        {{__('Logout')}}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('gmail.connect') }}"
                                       class="flex justify-center p-3 text-base font-bold text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                        <span class="flex-1 ml-3 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px"
                                                 height="48px"><path fill="#FFC107"
                                                                     d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path
                                                    fill="#FF3D00"
                                                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path
                                                    fill="#4CAF50"
                                                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path
                                                    fill="#1976D2"
                                                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                                        </span>
                                    </a>
                                </li>
                            @endauth

                        </ul>
                        <div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <button wire:click="export"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{__('Lancer l\'export')}}
                </button>
            </div>
            @if (session()->has('export_message'))
                <div
                    class="flex p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    <svg aria-hidden="true" class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor"
                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="font-medium">{{ session('export_message') }}</span>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
