<?php

if (! function_exists('get_redirect_value')) {
    function get_redirect_value(?string $redirectParam): string
    {
        $redirectValue = old('redirect');
        if ($redirectValue === null) {
            $redirectValue = $redirectParam ?? '';
        }

        return sanitize_redirect($redirectValue) ?? '';
    }
}

if (! function_exists('build_redirect_url')) {
    function build_redirect_url(string $baseUrl, ?string $redirectParam): string
    {
        $redirectValue = get_redirect_value($redirectParam);
        if ($redirectValue === '' || $redirectValue === '/') {
            return $baseUrl;
        }

        return $baseUrl . '?redirect=' . urlencode($redirectValue);
    }
}
