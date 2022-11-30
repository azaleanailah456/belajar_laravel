@extends('layout.layout')
<link rel="stylesheet" type="text/css" href="{{asset('style.css')}}">

@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
    <div class="wrapper" style="margin-top: 120px;">
        <h1>Login</h1>
        <form action="/login" method="POST" >
            @csrf
            <p class="right">Username</p>
            <input type="text" placeholder="Username" name="username">
            <p class="righ">Password</p>
            <input type="password" placeholder="Password" name="password">
            <button type="submit">Login</button>
         </form>
    <div class="member">
                @if(Session::get('success'))
                <div class="alert alert-success w-80">
                    {{ Session::get('success')}}
                </div> 
                @endif

                @if(Session::get('fail'))
                <div class="alert alert-danger w-80">
                    {{ Session::get('fail')}}
                </div> 
                @endif

                @if(Session::get('notAllowed'))
                <div class="alert alert-danger w-80">
                    {{ Session::get('notAllowed')}}
                </div> 
                @endif
                
                @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    </div>
</div>
@endsection