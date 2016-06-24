@extends('layout')
@section('title', 'Profile Badges')

@section('nav')
  <ul class="nav">
    <li><a href="/logout">Logout</a></li>
  </ul>
@stop

@section('content')
<div class="container">

  <div class="row cr-profile">
    <div class="col-md-3 col-sm-6">
    <img src="{{ $user->avatar }}" class="img-circle img-responsive">      
    </div>
    <div class="col-md-9 col-sm-6">
      <h1>{{ $user->display_name }}</h1>
      <h5>{{ $user->email }}</h5>
      <p>Member since {{ date('F d, Y', strtotime($user->created_at)) }}</p>      
    </div>
  </div>

  <div class="row">
  <h3>Earned Badges</h3>
  @foreach ($badges as $badge)
    <div class="col-md-3 col-sm-4">
      <div class="card">
        <img class="img-responsive" src="{{ $badge->image }}">
        <div class="card-content">
          <h4>{{ $badge->title }}</h4>
          <p>{{ $badge->short_description }}</p>
        </div>
      </div>
    </div>
  @endforeach
  </div>

</div> 
@stop
