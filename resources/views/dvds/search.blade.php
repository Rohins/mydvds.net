@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Search for DVD</div>

                <div class="panel-body" id='app'>
                    <search-list></search-list>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<template id ="search-list">
    <input 
        id="search-text"
        v-model="searchDvd"
        @keyup.enter="searchDvds">
    </input>
    <button 
        id="search-button"
        class="btn"
        @click="searchDvds">
        Search
    </button>
    <table v-if="dvds.length > 0" class="table">
        <thead>
                <th>Name</th>
                <th>Book</th>
                <th>Page</th>
                <th>Slot</th>
        </thead>
        <tbody>
            <tr v-for="dvd in dvds">
                <td> @{{ dvd['name'] }}</td>
                <td> @{{ dvd['book'] }}</td>
                <td> @{{ dvd['page'] }}</td>
                <td> @{{ dvd['slot'] }}</td>
            </tr>
        </tbody>
    </table>
</template>
