<!DOCTYPE html>
<html>
<head>
    <title>Locale Debug</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .debug-info { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .debug-info div { margin: 5px 0; }
        button { padding: 10px 15px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .test-section { background: #e8f5e8; padding: 15px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Locale Debug Information</h2>
    
    <div class="debug-info">
        <div><strong>Session locale:</strong> {{ session('locale') }}</div>
        <div><strong>Current locale:</strong> {{ app()->getLocale() }}</div>
        <div><strong>Test translation:</strong> {{ __('Test Phrase') }}</div>
    </div>
    
    <div class="test-section">
        <h3>Additional Translation Tests</h3>
        <div><strong>Dashboard:</strong> {{ __('Dashboard') }}</div>
        <div><strong>Welcome:</strong> {{ __('Welcome') }}</div>
        <div><strong>Login:</strong> {{ __('Login') }}</div>
        <div><strong>Register:</strong> {{ __('Register') }}</div>
    </div>
    
    <h3>Language Switcher</h3>
    <form method="POST" action="{{ url('/set-locale/sw') }}">
        @csrf
        <button type="submit">Switch to Kiswahili</button>
    </form>
    <form method="POST" action="{{ url('/set-locale/en') }}">
        @csrf
        <button type="submit">Switch to English</button>
    </form>
    
    <h3>Quick Test Links</h3>
    <a href="/force-sw" style="display: inline-block; padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 3px; margin: 5px;">Force Swahili</a>
    <a href="/test-locale-debug" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 3px; margin: 5px;">Refresh Page</a>
</body>
</html> 