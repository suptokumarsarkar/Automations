@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .rajdorbor h2.center{
            text-align: center;
        }
        .rajdorbor .optionGroup {
            display: grid;
            grid-auto-flow: row;
            grid-template-columns: repeat(2,1fr);
            gap: 40px 18px;

        }
        .rajdorbor .optionGroup .options{
            display: block;
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            transition: .4s;
        }
        .rajdorbor {
            max-width: 600px;
            margin: 80px auto;
        }
        .rajdorbor .optionGroup .options:hover{
            box-shadow: 1px 1px 3px 1px #ccc;
        }
    </style>
@endpush

@section('content')
    <div class="rajdorbor">
        <h2 class="center large">Where To Go Next?</h2>
        <hr>
        <div class="optionGroup">
            <a class="options" href="#">
                <h4>Website Settings</h4>
                <p>Set the content of your website</p>
            </a>
            <a class="options" href="#">
                <h4>Payment Gateway Settings</h4>
                <p>Set Your Payment Gateway Details</p>
            </a>
            <a class="options" href="#">
                <h4>Apps Management</h4>
                <p>Set Your Apps Token And Manage Activation</p>
            </a>
            <a class="options" href="#">
                <h4>Pricing Settings</h4>
                <p>Set The Price and Details for Subscriptions</p>
            </a>
            <a class="options" href="#">
                <h4>User Settings</h4>
                <p>See Your Users And Manage Them</p>
            </a>
            <a class="options" href="#">
                <h4>Admin Settings</h4>
                <p>Create Or Update Admins</p>
            </a>
            <a class="options" href="#">
                <h4>Website Login Settings</h4>
                <p>Select And Update 3rd Party Apps</p>
            </a>
            <a class="options" href="#">
                <h4>General Settings</h4>
                <p>Logo And Dashboard</p>
            </a>
        </div>
    </div>
@endsection
