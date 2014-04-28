<?php

Event::listen('user.login', function($user)
{
    // Modular events are working
    //dd($user);
});