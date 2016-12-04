@extends('admin.layout.main')
@section('header')
    <section class="content-header" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-lg-6">
                <h5>
                    {{ $title }}
                </h5>
            </div>
            <div class="col-lg-6">
                @if(hasAccess('positions','edit'))
                    <a href="{{ $set_hook_url }}" class="pull-right rebuild btn btn-info">
                            {{ transTpl('set_hook','positions') }}
                    </a>
                @endif
            </div>
        </div>
        <ol class="breadcrumb">
            @include('admin.layout.breadcrumb')
        </ol>

    </section>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{trans('List')}}</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                    @if(count($hooks))
                        @foreach($hooks as $hook)
                            <div class="table_position">
                                <div class="title" id="{{ $hook->name }}">{{ $hook->name }}</div>
                                @if(count($hook->modules))
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="hook_{{$hook->id}}">
                                        @foreach($hook->modules as $module)
                                            <tr id="module-{{ $module->id }}*{{ $hook->id }}">
                                                <td><div class="icon_position"></div></td>
                                                <td>{{ $module->author }}/{{$module->name}}</td>
                                                <td>@include('admin.position.actions')</td>
                                            <tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="no_modules">
                                        {{ transTpl('no_modules_in_this_position') }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection