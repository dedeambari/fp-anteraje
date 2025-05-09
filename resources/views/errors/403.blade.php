@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('description', __('opps! something went wrong'))
@section('message', __($exception->getMessage() ?: 'Forbidden'))
