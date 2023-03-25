<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        @font-face {
            font-family: 'Material Symbols Outlined';
            font-style: normal;
            src: url(/fonts/MaterialSymbolsOutlined.woff2) format('woff2');
        }
    </style>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    @php
        function removePath(String $directoryPath, String $fileSystemNode): String
        {
            return str_replace($directoryPath . '/', '', $fileSystemNode);
        }
    @endphp

    <div class="filesystem">

        <div class="row header">
            <a href="/files" class="title">
                Cloud
            </a>

            <span class="new">
                <button class="material-symbols-outlined new-file" id="new_file_button">note_add</button>
                <button class="material-symbols-outlined new-folder" id="new_folder_button">create_new_folder</button>
            </span>
        </div>

        <div class="row new-file hidden" id="new_file_menu">
            <form action="/new/file" enctype=multipart/form-data method="post">
                @csrf

                <input type="hidden" name="path" value="{{ $path }}">
                <input type="file" name="file" id="new_file">
                <input type="submit" value="Upload">
            </form>
        </div>

        <div class="row new-directory hidden" id="new_folder_menu">
            <form action="/new/directory" method="post">
                @csrf

                <input type="hidden" name="path" value="{{ $path }}">
                <input type="text" name="directory_name" id="directory_name" placeholder="New Directory..." maxlength="255">
                <input type="submit" value="Create">
            </form>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="row">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        @if ($path != '')

            <a href="
                /files/{{ implode('/', explode('/', $path, -1)) }}
            " class="row">
                <span class="name">
                    ..
                </span>
            </a>

        @endif

        @if (count($directories) == 0 && count($files) == 0)
            <div class="row">
                Nothing here ¯\_(ツ)_/¯
            </div>
        @endif

        @foreach ($directories as $directory)

            <a href="/files/{{ $directory }}" class="row directory">

                <span class="material-symbols-outlined icon">
                    folder
                </span>

                <span class="name">
                    {{ removePath($path, $directory) }}
                </span>

            </a>

        @endforeach

        @foreach ($files as $file)
            <a href="/download/{{ $file }}" class="row file">

                <span class="material-symbols-outlined icon">
                    draft
                </span>

                <span class="name">
                    {{ removePath($path, $file) }}
                </span>

            </a>
        @endforeach
    </div>
</body>
</html>
