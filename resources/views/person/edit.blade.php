@extends('layouts.app')
@section('title', 'Edit person')
@section('content')
    <person-edit :person-prop="{{ $person }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <person-avatar v-if="person" :person="person"
                        photo-path="{{ $person->photoAbsolutePath() }}">
                    </person-avatar>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <update-person-form :person="person" v-if="person"></update-person-form>
                </div>
            </div>
        </div>
    </person-edit>
@endsection
