@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div
                id='app' 
                class="panel panel-default">
                <div class="panel-heading">
                    Browse Books
                </div>

                <div class="panel-body" >
                <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">@{{ browse_name }}</h4>
                          </div>
                          <div class="modal-body">
                            <h2></h2>
                            <table class="table table-condensed ">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th>Slot</th>
                                        <th>DVD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="page in browse_pages">
                                        <tr>
                                            <td>@{{page.number}}</td>
                                            <td>1</td>
                                            <td>
                                                @{{page.disk1}}
                                                <button 
                                                    type='button'
                                                    class='btn btn-default'
                                                    @click="updateDisk(browse_book_id,page['id'],1,page['disk1'])">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </button>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>@{{page.number}}</td>
                                            <td>2</td>
                                            <td>
                                                @{{page.disk2}}
                                                <button 
                                                    type='button'
                                                    class='btn btn-default'
                                                    @click="updateDisk(browse_book_id,page['id'],2,page['disk2'])">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </button>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>@{{page.number}}</td>
                                            <td>3</td>
                                            <td>
                                                @{{page.disk3}}
                                                <button 
                                                    type='button'
                                                    class='btn btn-default'
                                                    @click="updateDisk(browse_book_id,page['id'],3,page['disk3'])">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </button>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>@{{page.number}}</td>
                                            <td>4</td>
                                            <td>
                                                @{{page.disk4}}
                                                <button 
                                                    type='button'
                                                    class='btn btn-default'
                                                    @click="updateDisk(browse_book_id,page['id'],4,page['disk4'])">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </button>
                                            </td>
                                        </tr>   
                                    </template>
                                </tbody>
                            </table>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                    <button 
                        id="add-book" 
                        class="btn btn-default pull-right"
                        @click="createBook">
                        Add New Book
                    </button>
                    <div class="clearfix"></div>
                    <browse-list></browse-list>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<template id ="browse-list">
    <ol>
        <li v-for="dvd in dvds" class='list-group-item'>
            <button 
                type='button'
                class='btn btn-default'
                @click="this.$root.editBookName(dvd['id'], dvd['name'])">
                <span class="glyphicon glyphicon-edit"></span>
            </button>
                @{{ dvd['name'] }}
            <button 
                type='button'
                class='btn btn-default pull-right'
                data-toggle="modal" 
                data-target="#myModal"
                @click="this.$root.modalBook(dvd['id'])">
                <span class="glyphicon glyphicon-eye-open"></span>
            </button>
        </li>
    </ol>
</template>

