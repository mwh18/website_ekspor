<?php

namespace App\Filters; // <-- PASTIKAN NAMESPACE INI BENAR

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * This method runs BEFORE a controller is executed.
     * Our security check goes here.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // If the 'isLoggedIn' session is not set or is false
        if (!session()->get('isLoggedIn')) {
            // Then, redirect the user to the login page
            return redirect()->to('/login');
        }
    }

    /**
     * This method runs AFTER a controller is executed.
     * We don't need to do anything here for this filter.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 