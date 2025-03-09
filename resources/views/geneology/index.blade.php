@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .tree {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .tree ul {
        padding-top: 20px;
        position: relative;
        transition: .5s;
        display: flex;
        justify-content: center;
    }

    .tree li {
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;
    }

    .tree li::before, 
    .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid #ccc;
        width: 50%;
        height: 20px;
    }

    .tree li::after {
        right: auto;
        left: 50%;
    }

    .tree li:only-child::after, 
    .tree li:only-child::before {
        display: none;
    }

    .tree li:only-child {
        padding-top: 0;
    }

    .tree li:first-child::before,
    .tree li:last-child::after {
        border: none;
    }

    .tree li:last-child::before {
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
    }

    .tree li:first-child::after {
        border-left: 2px solid #ccc;
        border-radius: 5px 0 0 0;
    }

    .tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid #ccc;
        width: 0;
        height: 20px;
    }

    .box {
        display: inline-block;
        border: 2px solid #3498db;
        padding: 10px 15px;
        background: #fff;
        border-radius: 8px;
        font-weight: bold;
        color: #3498db;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        text-decoration: none;
    }

    .box:hover {
        background: #3498db;
        color: #fff;
        transition: 0.3s;
    }
</style>

<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">MY Genealogy</h1>
        </div>
    </div>
</div>
@php
$colorMap = [
    2 => '#FF5733',   // Red-Orange
    5 => '#FF5733',   // Green
    10 => '#FF5733',  // Blue
    15 => '#FF5733',  // Yellow
    20 => '#FF5733',  // Dark Red
    30 => '#FF5733',  // Burgundy
    40 => '#FF5733',  // Purple
    50 => '#FF5733',  // Teal
    75 => '#FF5733',  // Dark Purple
    100 => '#FF5733'  // Light Blue
];

// After 100, set colors for every 110, 120, 130...
function getDynamicColor($index, $colorMap) {
    if (isset($colorMap[$index])) {
        return $colorMap[$index];
    } elseif ($index > 100) {
        $mod = $index % 10;
        $colorCycle = ['#FF5733', '#FF5733', '#FF5733', '#FF5733', '#FF5733']; // Rotating colors
        return $colorCycle[$mod % count($colorCycle)];
    }
    return '#3498db'; // Default Blue
}
@endphp
<div class="card border-0 shadow mb-4">
    <div class="tree">
        <ul>
            <li>
                <div class="box" style="background: #3498db; color: white;">
                    {{ auth()->user()->name }}
                </div>
                <ul>
                    @foreach ($childerns as $index => $childern)
                    <li>
                        <a href="" class="box" style="background: {{ getDynamicColor($index + 1, $colorMap) }}; color: white;">
                            {{ $childern->user->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
