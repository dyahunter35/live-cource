<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        @include('partials.head')
    </head>
    <body class="font-sans antialiased">
        <main>
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>