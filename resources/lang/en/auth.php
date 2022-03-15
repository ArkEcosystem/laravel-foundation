<?php

declare(strict_types=1);

return [
    'confirm-password' => [
        'page_header' => 'Confirm Password',
    ],

    'forgot-password' => [
        'page_header' => 'Password Reset Email',
        'reset_link'  => 'Send Reset Link',
    ],

    'sign-in' => [
        'forgot_password'  => 'Forgot password?',
        'register_now'     => 'Not a member? <a href=":route" class="font-semibold underline link">Sign up</a>',
        'remember_me'      => 'Remember Me',
    ],

    'register-form' => [
        'conditions'         => 'I accept the <a href=":termsOfServiceRoute" target="_blank" class="link">Terms of Service</a> and <a href=":privacyPolicyRoute" target="_blank" class="link">Privacy Policy</a>.',
        'create_account'     => 'Create Account',
        'already_member'     => 'Already have an account? <a href=":route" class="font-semibold underline link">Sign in</a>',
    ],

    'register' => [
        'page_header'      => 'Sign Up',
    ],

    'reset-password' => [
        'page_header' => 'Reset Password',
    ],

    'two-factor' => [
        'page_header'      => '2FA Authentication',
        'page_description' => 'Enter your 2FA or recovery code below to sign in.',
    ],

    'verify' => [
        'page_header'         => 'Verify Your Email Address',
        'link_description'    => 'A verification link has been sent to your email address.',
        'line_1'              => 'Before proceeding, please check your email for a verification link.',
        'line_2'              => 'If you did not receive the email,',
    ],
];
