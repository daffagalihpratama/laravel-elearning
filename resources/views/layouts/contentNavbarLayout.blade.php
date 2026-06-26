@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@extends('layouts/commonMaster')

@php
$contentNavbar = $contentNavbar ?? true;
$containerNav = $containerNav ?? 'container-xxl';
$isNavbar = $isNavbar ?? true;
$isMenu = $isMenu ?? true;
$isFlex = $isFlex ?? false;
$isFooter = $isFooter ?? true;
$customizerHidden = $customizerHidden ?? '';

$navbarDetached = 'navbar-detached';
$menuFixed = isset($configData['menuFixed']) ? $configData['menuFixed'] : '';
if (isset($navbarType)) {
  $configData['navbarType'] = $navbarType;
}
$navbarType = isset($configData['navbarType']) ? $configData['navbarType'] : '';
$footerFixed = isset($configData['footerFixed']) ? $configData['footerFixed'] : '';
$menuCollapsed = isset($configData['menuCollapsed']) ? $configData['menuCollapsed'] : '';

$container = ($container ?? 'container-xxl');
@endphp

@section('layoutContent')
<div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
    <div class="layout-container">

        @if ($isMenu)
            @if(auth()->user()->role == 'admin')
                @include('layouts.sections.menu.verticalMenu')
            @elseif(auth()->user()->role == 'mahasiswa')
                @include('layouts.sections.menu.verticalMenuMahasiswa')
            @elseif(auth()->user()->role == 'dosen')
                @include('layouts.sections.menu.verticalMenuDosen')
            @endif
        @endif

        <div class="layout-page">

            @if ($isNavbar)
                @include('layouts/sections/navbar/navbar')
            @endif

            <div class="content-wrapper">

                @if ($isFlex)
                    <div class="{{ $container }} d-flex align-items-stretch flex-grow-1 p-0">
                @else
                    <div class="{{ $container }} flex-grow-1 container-p-y">
                @endif

                        @yield('content')

                    </div>

                @if ($isFooter)
                    @include('layouts/sections/footer/footer')
                @endif

                <div class="content-backdrop fade"></div>
            </div>

        </div>

    </div>

    @if ($isMenu)
        <div class="layout-overlay layout-menu-toggle"></div>
    @endif

    <div class="drag-target"></div>
</div>
@endsection

@push('styles')
<style>
.layout-menu .menu-bullet {
    display: none !important;
}
.layout-menu .menu-sub .menu-link {
    padding-top: 6px !important;
    padding-bottom: 6px !important;
}
</style>
@endpush
