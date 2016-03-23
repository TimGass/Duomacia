@extends('welcomelayout')

@section("input")
  @if($status === 404)
    <input class="notfound" type="text" name="search" placeholder="Account not found in NA"/>
  @elseif($status === "empty")
    <input class="failed" type="text" name="search" placeholder="No account given!"/>
  @elseif($status === "unranked")
    <input class="notfound" type="text" name="search" placeholder="Account is unranked"/>
  @else
    <input class="failed" type="text" name="search" placeholder="Search failed! status: {{ $status }}"/>
  @endif
@stop
