@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body" id='app-browse'>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<template id ="browse-list">
    <ol>
        <li v-for="dvd in dvds">
            @{{ dvd['name'] }}
        </li>
    </ol>
</template>
