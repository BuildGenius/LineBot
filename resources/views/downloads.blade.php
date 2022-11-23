@extends('layouts.index')

@section('contents')
    <div class='row mt-3'>
        <h1>files</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h5">
                <li class="breadcrumb-item disabled">
                    .
                </li>
                <li class="breadcrumb-item disabled">
                    ..
                </li>
                <li class="breadcrumb-item disabled">
                    <a href="http://localhost:8000/Downloads/storages">storages</a>
                </li>
                @for ($i = 0; $i < count($files['folders']) - 1; $i++)
                    @if (($i + 1) == count($files['folders']))
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ 'http://localhost:8000/Downloads/storages' . $files['folders'][$i] }}">{{ $files['folders'][$i] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ 'http://localhost:8000/Downloads/storages' . $files['folders'][$i] }}">{{ $files['folders'][$i] }}</a>
                        </li>
                    @endif
                @endfor
            </ol>
        </nav>

        <div class='row'>
            @for ($i = 0; $i < count($files); $i++)
                @for ($ii = 0; $ii < count($files[array_keys($files)[$i]]); $ii++)
                    @if (array_keys($files)[$i] == 'files')
                        <div class="col-1 text-warning">
                            <a href="{{ Request::httpHost() . '/' . $files[array_keys($files)[$i]][$ii] }}">
                                <div class='h1 text-center'>
                                    <i class="fa-solid fa-file"></i>
                                </div>
                                <div class="text-center">
                                    {{ $files[array_keys($files)[$i]][$ii] }}
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-1 text-warning">
                            <a href="{{ Request::url() . '/' . $files[array_keys($files)[$i]][$ii] }}">
                                <div class='h1 text-center'>
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <div class="text-center">
                                    {{ $files[array_keys($files)[$i]][$ii] }}
                                </div>
                            </a>
                        </div>
                    @endif
                    
                @endfor
            @endfor
        </div>
    </div>
@endsection