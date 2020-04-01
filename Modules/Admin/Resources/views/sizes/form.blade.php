@extends('admin::layouts.master')
<?php $title = (isset($sizeInfo))? 'Update Size':'Create Size'?>
@section('title', $title)

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="col-md-4 col-md-offset-4">
@if(isset($sizeInfo))
<form action="{{ route('admin::sizes.update',$sizeInfo->id) }}" method="POST" autocomplete="off">
@else
<form action="{{ route('admin::sizes.store') }}" method="POST" autocomplete="off">
@endIf
    @csrf
  
     <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Size Name:</label>
                <input required pattern=".*\S+.*" title="This field is required" type="text" name="size_name" class="form-control" placeholder="Size Name" value="{{isset($sizeInfo)? $sizeInfo->size_name:''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Width(mm):</label>
                <input required pattern=".*\S+.*" type="number" name="width" step="any" class="form-control" placeholder="Width" value="{{isset($sizeInfo)? $sizeInfo->width:''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Height(mm):</label>
                <input required pattern=".*\S+.*" type="number" step="any" name="height" class="form-control" placeholder="Height" value="{{isset($sizeInfo)? $sizeInfo->height:''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">{{isset($sizeInfo)? 'Update':'Create'}}</button>
                <a style="margin-left: 10px;" href="{{route('admin::sizes')}}" class="btn btn-danger">Cancle</a>
        </div>
        
    </div>
</div>
    </div>
   
</form>
</div>

@endsection

@push('javascript')

@endpush