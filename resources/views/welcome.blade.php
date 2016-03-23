@extends('welcomelayout')

@section("input")
  <input type="text" name="search" placeholder="NA only"
  @if(!empty($displayname))
    value = {{ $displayname }}
  @endif
  />
@stop
