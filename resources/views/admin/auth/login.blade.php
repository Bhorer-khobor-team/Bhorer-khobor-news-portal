@extends('layouts.admin')

@section('content')

<h2>Admin Login</h2>

<form>
    <input type="email" placeholder="Email"><br><br>
    <input type="password" placeholder="Password"><br><br>
    <button type="submit">Login</button>
</form>

@endsection