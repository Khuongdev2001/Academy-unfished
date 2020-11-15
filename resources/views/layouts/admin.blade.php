<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    {{-- title --}}
    <title>@yield('title')</title>
    {{-- font google --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{asset("css/dashmix.min-3.0.css")}}">
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
    {{-- require css more --}}
    @section('css')
    @show
    <link rel="stylesheet" href="{{asset("css/response.css")}}">
</head>

<body>
    <!-- loading -->
    <div id="page-loader" class="bg-gd-sun show"></div>
   
@section('header')
<div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
    <aside id="side-overlay">
        <div class="bg-image">
            <div class="bg-primary-op">
                <div class="content-header">
                    <a class="img-link mr-1" href="be_pages_generic_profile.html">
                        <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar10.jpg" alt=""> -->
                    </a>
                    <div class="ml-2">
                        <a class="text-white font-w600" href="be_pages_generic_profile.html">George Taylor</a>
                        <div class="text-white-75 font-size-sm">Full Stack Developer</div>
                    </div>
                    <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="content-side">
            <div class="block block-transparent pull-x pull-t">
                <ul class="nav nav-tabs nav-tabs-block nav-justified" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#so-settings">
                            <i class="fa fa-fw fa-cog"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#so-people">
                            <i class="far fa-fw fa-user-circle"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#so-profile">
                            <i class="far fa-fw fa-edit"></i>
                        </a>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane pull-x fade fade-up show active" id="so-settings" role="tabpanel">
                        <div class="block mb-0">
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Color Themes</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny text-center">
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-default" data-toggle="theme" data-theme="default" href="#">
                                            Default
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xwork" data-toggle="theme" data-theme="assets/css/themes/xwork.min-3.1.css" href="#">
                                            xWork
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xmodern" data-toggle="theme" data-theme="assets/css/themes/xmodern.min-3.1.css" href="#">
                                            xModern
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xeco" data-toggle="theme" data-theme="assets/css/themes/xeco.min-3.1.css" href="#">
                                            xEco
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xsmooth" data-toggle="theme" data-theme="assets/css/themes/xsmooth.min-3.1.css" href="#">
                                            xSmooth
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xinspire" data-toggle="theme" data-theme="assets/css/themes/xinspire.min-3.1.css" href="#">
                                            xInspire
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xdream" data-toggle="theme" data-theme="assets/css/themes/xdream.min-3.1.css" href="#">
                                            xDream
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xpro" data-toggle="theme" data-theme="assets/css/themes/xpro.min-3.1.css" href="#">
                                            xPro
                                        </a>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <a class="d-block py-3 text-white font-size-sm font-w600 bg-xplay" data-toggle="theme" data-theme="assets/css/themes/xplay.min-3.1.css" href="#">
                                            xPlay
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" href="be_ui_color_themes.html">All Color Themes</a>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Sidebar</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny text-center">
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">Dark</a>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">Light</a>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Header</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny text-center mb-2">
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">Dark</a>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">Light</a>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="header_mode_fixed" href="javascript:void(0)">Fixed</a>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="header_mode_static" href="javascript:void(0)">Static</a>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Content</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny text-center">
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="content_layout_boxed" href="javascript:void(0)">Boxed</a>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="content_layout_narrow" href="javascript:void(0)">Narrow</a>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <a class="d-block py-3 bg-body-dark font-w600 text-dark" data-toggle="layout" data-action="content_layout_full_width" href="javascript:void(0)">Full Width</a>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content row justify-content-center border-top">
                                <div class="col-9">
                                    <a class="btn btn-block btn-hero-primary" href="be_layout_api.html">
                                        <i class="fa fa-fw fa-flask mr-1"></i> Layout API
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane pull-x fade fade-up" id="so-people" role="tabpanel">
                        <div class="block mb-0">
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Online</span>
                            </div>
                            <div class="block-content">
                                <ul class="nav-items">
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar8.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Danielle Jones</div>
                                                <div class="font-size-sm text-muted">Photographer</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar9.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Thomas Riley</div>
                                                <div class="font-w400 font-size-sm text-muted">Web Designer</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar5.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Danielle Jones</div>
                                                <div class="font-w400 font-size-sm text-muted">Web Developer</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Busy</span>
                            </div>
                            <div class="block-content">
                                <ul class="nav-items">
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar7.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-danger"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Amanda Powell</div>
                                                <div class="font-w400 font-size-sm text-muted">UI Designer</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Away</span>
                            </div>
                            <div class="block-content">
                                <ul class="nav-items">
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar16.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-warning"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Jesse Fisher</div>
                                                <div class="font-w400 font-size-sm text-muted">Copywriter</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar1.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-warning"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Lori Grant</div>
                                                <div class="font-w400 font-size-sm text-muted">Writer</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Offline</span>
                            </div>
                            <div class="block-content">
                                <ul class="nav-items">
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar9.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-muted"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Brian Cruz</div>
                                                <div class="font-w400 font-size-sm text-muted">Teacher</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar1.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-muted"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Alice Moore</div>
                                                <div class="font-w400 font-size-sm text-muted">Photographer</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar8.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-muted"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Laura Carr</div>
                                                <div class="font-w400 font-size-sm text-muted">Front-end Developer</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="media py-2" href="be_pages_generic_profile.html">
                                            <div class="mx-3 overlay-container">
                                                <!-- <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar9.jpg" alt=""> -->
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-muted"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">Ryan Flores</div>
                                                <div class="font-w400 font-size-sm text-muted">UX Specialist</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-content row justify-content-center border-top">
                                <div class="col-9">
                                    <a class="btn btn-block btn-hero-primary" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-plus mr-1"></i> Add People
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane pull-x fade fade-up" id="so-profile" role="tabpanel">
                        <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                            <div class="block mb-0">
                                <div class="block-content block-content-sm block-content-full bg-body">
                                    <span class="text-uppercase font-size-sm font-w700">Personal</span>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" readonly class="form-control" id="staticEmail" value="Admin">
                                    </div>
                                    <div class="form-group">
                                        <label for="so-profile-name">Name</label>
                                        <input type="text" class="form-control" id="so-profile-name" name="so-profile-name" value="George Taylor">
                                    </div>
                                    <div class="form-group">
                                        <label for="so-profile-email">Email</label>
                                        <input type="email" class="form-control" id="so-profile-email" name="so-profile-email" value="g.taylor@example.com">
                                    </div>
                                </div>
                                <div class="block-content block-content-sm block-content-full bg-body">
                                    <span class="text-uppercase font-size-sm font-w700">Password Update</span>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="form-group">
                                        <label for="so-profile-password">Current Password</label>
                                        <input type="password" class="form-control" id="so-profile-password" name="so-profile-password">
                                    </div>
                                    <div class="form-group">
                                        <label for="so-profile-new-password">New Password</label>
                                        <input type="password" class="form-control" id="so-profile-new-password" name="so-profile-new-password">
                                    </div>
                                    <div class="form-group">
                                        <label for="so-profile-new-password-confirm">Confirm New Password</label>
                                        <input type="password" class="form-control" id="so-profile-new-password-confirm" name="so-profile-new-password-confirm">
                                    </div>
                                </div>
                                <div class="block-content block-content-sm block-content-full bg-body">
                                    <span class="text-uppercase font-size-sm font-w700">Options</span>
                                </div>
                                <div class="block-content">
                                    <div class="custom-control custom-checkbox custom-control-primary mb-1">
                                        <input type="checkbox" class="custom-control-input" id="so-settings-status" name="so-settings-status" value="1">
                                        <label class="custom-control-label" for="so-settings-status">Online Status</label>
                                    </div>
                                    <p class="text-muted font-size-sm">
                                        Make your online status visible to other users of your app
                                    </p>
                                    <div class="custom-control custom-checkbox custom-control-primary mb-1">
                                        <input type="checkbox" class="custom-control-input" id="so-settings-notifications" name="so-settings-notifications" value="1" checked>
                                        <label class="custom-control-label" for="so-settings-notifications">Notifications</label>
                                    </div>
                                    <p class="text-muted font-size-sm">
                                        Receive desktop notifications regarding your projects and sales
                                    </p>
                                    <div class="custom-control custom-checkbox custom-control-primary mb-1">
                                        <input type="checkbox" class="custom-control-input" id="so-settings-updates" name="so-settings-updates" value="1" checked>
                                        <label class="custom-control-label" for="so-settings-updates">Auto Updates</label>
                                    </div>
                                    <p class="text-muted font-size-sm">
                                        If enabled, we will keep all your applications and servers up to date with the most recent features automatically
                                    </p>
                                </div>
                                <div class="block-content row justify-content-center border-top">
                                    <div class="col-9">
                                        <button type="submit" class="btn btn-block btn-hero-primary">
                                            <i class="fa fa-fw fa-save mr-1"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>
<header id="page-header">
<div class="content-header">
    <div>
        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
        </button>
        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="header_search_on">
            <i class="fa fa-fw fa-search"></i> <span class="ml-1 d-none d-sm-inline-block">Search</span>
        </button>
    </div>
    <div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src=" @if(Auth::check()) {{ asset(Auth::user()->thumbnail) }} @endif" style="width: 30px; height: 30px; border-radius: 50px;">
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                <div class="bg-primary rounded-top font-w600 text-white text-center p-3">
                    User Options
                </div>
                <div class="p-2">
                    <a class="dropdown-item" href="be_pages_generic_profile.html">
                        <i class="far fa-fw fa-user mr-1"></i> Profile
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_inbox.html">
                        <span><i class="far fa-fw fa-envelope mr-1"></i> Inbox</span>
                        <span class="badge badge-primary badge-pill">3</span>
                    </a>
                    <a class="dropdown-item" href="be_pages_generic_invoice.html">
                        <i class="far fa-fw fa-file-alt mr-1"></i> Invoices
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                        <i class="far fa-fw fa-building mr-1"></i> Settings
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a href="{{ route("admin.user.logout") }}" class="dropdown-item" href="op_auth_signin.html">
                        <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-fw fa-bell"></i>
                <span class="badge badge-secondary badge-pill">5</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="bg-primary rounded-top font-w600 text-white text-center p-3">
                    Notifications
                </div>
                <ul class="nav-items my-2">
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mx-3">
                                <i class="fa fa-fw fa-check-circle text-success"></i>
                            </div>
                            <div class="media-body font-size-sm pr-2">
                                <div class="font-w600">App was updated to v5.6!</div>
                                <div class="text-muted font-italic">3 min ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mx-3">
                                <i class="fa fa-fw fa-user-plus text-info"></i>
                            </div>
                            <div class="media-body font-size-sm pr-2">
                                <div class="font-w600">New Subscriber was added! You now have 2580!</div>
                                <div class="text-muted font-italic">10 min ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mx-3">
                                <i class="fa fa-fw fa-times-circle text-danger"></i>
                            </div>
                            <div class="media-body font-size-sm pr-2">
                                <div class="font-w600">Server backup failed to complete!</div>
                                <div class="text-muted font-italic">30 min ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mx-3">
                                <i class="fa fa-fw fa-exclamation-circle text-warning"></i>
                            </div>
                            <div class="media-body font-size-sm pr-2">
                                <div class="font-w600">You are running out of space. Please consider upgrading your plan.</div>
                                <div class="text-muted font-italic">1 hour ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mx-3">
                                <i class="fa fa-fw fa-plus-circle text-primary"></i>
                            </div>
                            <div class="media-body font-size-sm pr-2">
                                <div class="font-w600">New Sale! + $30</div>
                                <div class="text-muted font-italic">2 hours ago</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="p-2 border-top">
                    <a class="btn btn-light btn-block text-center" href="javascript:void(0)">
                        <i class="fa fa-fw fa-eye mr-1"></i> View All
                    </a>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="side_overlay_toggle">
            <i class="far fa-fw fa-list-alt"></i>
        </button>
    </div>
</div>
<div id="page-header-search" class="overlay-header bg-header-dark">
    <div class="bg-white-10">
        <div class="content-header">
            <form class="w-100" action="be_pages_generic_search.html" method="POST">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-alt-primary" data-toggle="layout" data-action="header_search_off">
                            <i class="fa fa-fw fa-times-circle"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control border-0" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                </div>
            </form>
        </div>
    </div>
</div>
<div id="page-header-loader" class="overlay-header bg-header-dark">
    <div class="bg-white-10">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-sun fa-spin text-white"></i>
            </div>
        </div>
    </div>
</div>
</header>
@show
@section('sidebar')
<nav id="sidebar">
    <div class="bg-info">
        <div class="content-header bg-white-10">
            <a class="font-w600 text-white tracking-wide" href="index.html">
                <span class="smini-visible">
                    D<span class="opacity-75">x</span>
                </span>
                <span class="smini-hidden">
                    Dash<span class="opacity-75">mix</span>
                </span>
            </a>
            <div>
                <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');" href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a href="{{ route("admin.dashboard") }}" class="nav-main-link active" href="be_pages_dashboard.html">
                        <i class="nav-main-link-icon fa fa-location-arrow"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                        <span class="nav-main-link-badge badge badge-pill badge-success">3</span>
                    </a>
                </li>

                <li class="nav-main-heading">Khóa Học</li>

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-chalkboard-teacher"></i>
                        <span class="nav-main-link-name">Tác vụ</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route("admin.course.add") }}">
                                <span class="nav-main-link-name">Thêm khóa học</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- course offline --}}

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-rocket"></i>
                        <span class="nav-main-link-name">Offline</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a href=" {{ route("admin.course",2) }} " class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Các khóa học</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Thời khóa biểu</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a href="" class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Lộ trình</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- course online --}}

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-chalkboard-teacher"></i>
                        <span class="nav-main-link-name">Online</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a href=" {{ route("admin.course",1) }} " class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Các khóa học</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Lịch sử học</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-heading">Base</li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-border-all"></i>
                        <span class="nav-main-link-name">Bài viết</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a href="{{ route("admin.post.add") }}" class="nav-main-link" href="be_blocks_styles.html">
                                <span class="nav-main-link-name">Thêm</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a href="{{ route("admin.post.cat.add") }}" class="nav-main-link" href="be_blocks_options.html">
                                <span class="nav-main-link-name">Danh mục</span>
                            </a>
                        </li>
                    </ul>
                </li>
                                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-comment"></i>
                        <span class="nav-main-link-name">Comment</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <span class="nav-main-link-name">Danh sách</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fab fa-paypal"></i>
                        <span class="nav-main-link-name">Thanh toán</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a href="{{ route("admin.pay") }}" class="nav-main-link" href="be_ui_icons.html">
                                <span class="nav-main-link-name">Danh sách loại Thanh Toán</span>
                            </a>
                            <a href="{{ route("admin.user.pay.course") }}" class="nav-main-link" href="be_ui_icons.html">
                                <span class="nav-main-link-name">Học Viên Và Khóa Học </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-heading">Giao diện</li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-wrench"></i>
                        <span class="nav-main-link-name">Slider</span>
                    </a>
                    <ul class="nav-main-submenu">
                           <li class="nav-main-item">
                            <a href="{{ route("admin.slider") }}" class="nav-main-link" href="be_comp_onboarding.html">
                                <span class="nav-main-link-name">Danh sách</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-heading">Core</li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-chalkboard-teacher"></i>
                        <span class="nav-main-link-name">Quản Trị Tài Khoản</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a href="{{ route("admin.user.add") }}" class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Thêm</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a href="{{ route("admin.user") }}" class="nav-main-link" href="be_pages_dashboard_all.html">
                                <span class="nav-main-link-name">Danh sách</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
@show

{{-- require content  --}}
@section('content')
    
@show
@section('footer')
<footer id="page-footer" class="bg-body-light">
    <div class="content py-0">
        <div class="row font-size-sm">
            <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">
                Crafted with <i class="fa fa-heart text-danger"></i> by <a class="font-w600" href="https://1.envato.market/ydb" target="_blank">pixelcave</a>
            </div>
            <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                <a class="font-w600" href="https://1.envato.market/r6y" target="_blank">Dashmix 3.1</a> &copy; <span data-toggle="year-copy"></span>
            </div>
        </div>
    </div>
</footer>     
@show
<script src="{{asset("js/dashmix.core.min-3.0.js")}}"></script>
<script src="{{asset("js/dashmix.app.min-3.0.js")}}"></script>
<script src="{{asset("js/main.js")}}"></script>
<script src="{{ asset('plugin/notification/notification.min.js') }}"></script>
{{-- require js more --}}
@section('js')
    
@show
<script>
{{-- error form --}}
$(document).ready(function(){
    @if ($errors->any())
        Dashmix.helpers('notify', {type: 'danger', icon: 'fa fa-times mr-1', message: 'đã có {{count($errors->all())}} lỗi'});
    @endif

    {{-- alert Notification --}}
    @if (session("notification"))
    @php
        $notifi=session("notification");
    @endphp
        let notification={error:{type:"danger",icon:"fa fa-times mr-1"},success:{type:"success",icon:"fa fa-check mr-1"}};
            Dashmix.helpers('notify', {type: notification.{{$notifi['type']}}.type, icon: notification.{{$notifi['type']}}.icon, message: '{{$notifi["alert"]}}'});
    @endif  
})
</script>
</body>

</html>