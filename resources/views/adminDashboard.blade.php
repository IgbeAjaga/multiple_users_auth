<!-- resources/views/adminDashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
       
    </x-slot>

    <div class="py-12 flex justify-center items-center min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    {{ __("You're logged in!") }}
                    <h1>This is Admin dashboard!</h1>

                    <div class="flex flex-wrap justify-center mt-4 gap-4">
                        <div class="w-full sm:w-1/2 lg:w-1/3 p-2">
                            <a href="{{ route('create') }}" class="btn btn-primary w-full bg-blue-500 text-white py-2 px-4 rounded">Add Outgoing Report</a>
                        </div>
                        <div class="w-full sm:w-1/2 lg:w-1/3 p-2">
                            <a href="{{ route('alloutgoing') }}" class="btn btn-primary w-full bg-green-500 text-white py-2 px-4 rounded">View All Outgoing Report</a>
                        </div>
                        <div class="w-full sm:w-1/2 lg:w-1/3 p-2">
                            <a href="{{ route('addincoming') }}" class="btn btn-primary w-full bg-red-500 text-white py-2 px-4 rounded">Add Incoming Report</a>
                        </div>
                        <div class="w-full sm:w-1/2 lg:w-1/3 p-2">
                            <a href="{{ route('allincoming') }}" class="btn btn-primary w-full bg-yellow-500 text-white py-2 px-4 rounded">View All Incoming Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
