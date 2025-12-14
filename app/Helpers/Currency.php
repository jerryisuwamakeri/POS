<?php

if (!function_exists('format_money')) {
    /**
     * Format amount (in kobo/lowest unit) to currency string with N symbol
     *
     * @param int $amount Amount in kobo (lowest unit)
     * @return string Formatted currency string
     */
    function format_money(int $amount): string
    {
        $naira = $amount / 100;
        return 'N' . number_format($naira, 2, '.', ',');
    }
}

if (!function_exists('to_kobo')) {
    /**
     * Convert decimal amount to kobo (lowest unit)
     *
     * @param float|string $decimal Decimal amount
     * @return int Amount in kobo
     */
    function to_kobo(float|string $decimal): int
    {
        return (int) round((float) $decimal * 100);
    }
}

if (!function_exists('dashboard_route')) {
    /**
     * Get the dashboard route based on user's role
     *
     * @return string Dashboard route name
     */
    function dashboard_route(): string
    {
        $user = auth()->user();
        
        if (!$user) {
            return 'login';
        }
        
        if ($user->hasRole('super_admin')) {
            return 'dashboard.super-admin';
        } elseif ($user->hasRole('admin')) {
            return 'dashboard.admin';
        } elseif ($user->hasRole('sales')) {
            return 'dashboard.sales';
        } elseif ($user->hasRole('accounting')) {
            return 'dashboard.accounting';
        }
        
        return 'dashboard';
    }
}

