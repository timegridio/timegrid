Click here to reset your password: {{ url('/auth/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}
