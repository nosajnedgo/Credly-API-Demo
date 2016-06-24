@extends('layout')
@section('title', 'Sign In')

@section('content')

  <div class="container">
  
    <form class="form-signin" method="POST" action="/checklogin">
    {{ csrf_field() }}
    <h2 class="form-signin-heading">Please sign in</h2>

    @if (Session::has('status'))
    <div class="alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      {{ Session::get('status') }}
    </div>
    @endif

    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" class="form-control" 
      placeholder="Email address" required autofocus value="{{ old('email') }}">

    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" 
      placeholder="Password" required value="{{ old('password') }}">

    <button class="btn btn-lg btn-primary btn-block" 
      type="submit">Sign in</button>
  </form>

  </div>

@stop
