@extends('emails.layout')

@section('content')

    @include('emails.header')

    <main class="mt-8">
        <h2 class="text-gray-700 dark:text-gray-200">{{ $name }},</h2>

        <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
            {{ trans('mail.verification_code') }}
        </p>

        <div class="flex items-center mt-4 gap-x-4">
            @foreach($numbers as $number)
            <p class="flex items-center justify-center w-10 h-10 text-2xl font-medium text-blue-500 border border-blue-500 rounded-md dark:border-blue-400 dark:text-blue-400 ">{{ $number }}</p>
            @endforeach
        </div>

        <p class="mt-4 mb-4 leading-loose text-gray-600 dark:text-gray-300">
            {{ trans('mail.verification_code_lifetime') }}
        </p>
        
        <a class="px-6 py-2 mt-6 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
            {{ trans('mail.verify_email') }}
        </a>
        
        <p class="mt-8 text-gray-600 dark:text-gray-300">
            {{ trans('mail.thanks') }}, <br>
            {{ trans('mail.company_name') }}
        </p>
    </main>

    @include('emails.footer')


@endsection