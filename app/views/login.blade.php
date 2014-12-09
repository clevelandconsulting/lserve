@extends('layouts.master')

@section('title')
Dashboard
@stop

@section('content')
	<span>{{{ $message }}}</span>
	<form action='/dologin' method='post'>
		<label for='email'>Email</label>
		<input type='text' id='email' name='email' placeholder='email'>
		<label for='password'>Password</label>
		<input type='password' id='password' name='password' placeholder="password">
		<button>Login</button>
@stop
