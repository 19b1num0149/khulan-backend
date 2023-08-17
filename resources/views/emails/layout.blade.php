<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">        
        <title>Email</title>
        @include('emails.style')
    </head>
    <body>
        <section class="max-w-2xl px-6 py-8 mx-auto bg-white dark:bg-gray-900">
            
            @yield('content')

        </section>
    </body>
</html>