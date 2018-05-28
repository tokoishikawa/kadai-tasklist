@extends('layouts.app')

@section('content')

    <h1>メッセージ新規作成ページ</h1>

    {!! Form::model($task, ['route' => 'tasks.store']) !!}

        {!! Form::label('content', 'メッセージ:') !!}
        {!! Form::label('status', 'ステータス:') !!}
        {!! Form::text('content') !!}

        {!! Form::submit('投稿') !!}

    {!! Form::close() !!}


     @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    
@endsection


