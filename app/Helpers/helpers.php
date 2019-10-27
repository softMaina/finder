<?php
if (! function_exists('user')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    function user()
    {
        $user = auth()->user();
        return $user;
    }
}