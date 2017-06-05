@extends('layouts.app')
@section('title', 'About')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">It's educational project.</h3>
                    </div>
                    <div class="panel-body">
                        <p class="about__title"><b>User can:</b></p>
                        <ul class="about__list">
                            <li>search person by name, city and age</li>
                            <li>sort person by name, city and age</li>
                            <li>review paginated list of people</li>
                            <li>create, edit and remove person</li>
                            <li>upload photo for user</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
