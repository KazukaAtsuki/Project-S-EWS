<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Layouts
    public function withoutMenu()
    {
        return view('pages.layouts.without-menu');
    }

    public function withoutNavbar()
    {
        return view('pages.layouts.without-navbar');
    }

    public function container()
    {
        return view('pages.layouts.container');
    }

    public function fluid()
    {
        return view('pages.layouts.fluid');
    }

    public function blank()
    {
        return view('pages.layouts.blank');
    }

    // Account Settings
    public function accountSettings()
    {
        return view('pages.account.settings');
    }

    public function accountNotifications()
    {
        return view('pages.account.notifications');
    }

    public function accountConnections()
    {
        return view('pages.account.connections');
    }

    // Components
    public function cards()
    {
        return view('pages.components.cards');
    }

    public function accordion()
    {
        return view('pages.ui.accordion');
    }

    public function alerts()
    {
        return view('pages.ui.alerts');
    }

    public function badges()
    {
        return view('pages.ui.badges');
    }

    public function buttons()
    {
        return view('pages.ui.buttons');
    }

    // Forms
    public function basicInputs()
    {
        return view('pages.forms.basic-inputs');
    }

    public function inputGroups()
    {
        return view('pages.forms.input-groups');
    }

    public function verticalForm()
    {
        return view('pages.forms.vertical-form');
    }

    public function horizontalForm()
    {
        return view('pages.forms.horizontal-form');
    }

    // Tables
    public function tables()
    {
        return view('pages.tables.basic');
    }

    // Misc
    public function error()
    {
        return view('pages.misc.error');
    }

    public function underMaintenance()
    {
        return view('pages.misc.maintenance');
    }
}