@extends('master')

@section('content')
<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li class="active">{{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('moduleIndex', 'Your Modules') }}</li>
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Your Modules</h2>
        <ul class="list-group" id="module-list">
            @foreach($user->modules as $module)
                <li class="list-group-item">
                    {{ HTML::linkRoute('module', $module->module_name, $module->id) }}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Announcements</h2>
        <ul class="list-group">
            @foreach($announcements as $announcement)
                <li class="list-group-item">
                    <h class="list-group-heading">
                        <strong>{{{ Module::find($announcement->module_id)->module_name }}} </strong>
                    </p>

                    <p class="list-group-item-text">{{{ $announcement->announcement_body }}}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h2>Quote of the day</h2>
        <p>some quote</p>
    </div>
</div>
@stop

@section('javascript')
<script>
    $(document).ready(function() {
        $('#module-list li').mouseenter(function(){
            var moduleName = $(this).text();
            $("<li class='list-group-item module-description'><div> module description for " + moduleName + " here. </div></li>")
                    .insertAfter($(this))
                    .hide()
                    .slideDown(300);
        }).mouseleave (
        function() {
            $('.module-description').remove();
        });
    });
</script>
@stop