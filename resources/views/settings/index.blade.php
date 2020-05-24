@extends('layouts.app')

@section('title')
  {{__('common.settings.index.title')}} v0.9.5
@endsection

@section('content')
  @include('settings.changelog')
@endsection