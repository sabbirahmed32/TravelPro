<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | {{ config('app.name', 'TravelPro') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 20px;
        }
        
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        
        .error-description {
            color: #6b7280;
            margin-bottom: 40px;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .search-form {
            max-width: 400px;
            margin: 40px auto 0;
        }
        
        .search-form .input-group {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-radius: 50px;
            overflow: hidden;
        }
        
        .search-form input {
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
        }
        
        .search-form button {
            background: var(--gradient-primary);
            border: none;
            padding: 12px 20px;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .error-container {
                padding: 40px 20px;
            }
            
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary, .btn-outline-primary {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-description">
            Oops! The page you're looking for seems to have vanished into thin air. 
            Don't worry, even the best travelers get lost sometimes.
        </p>
        
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn-primary">
                <i class="bi bi-house me-2"></i>Go Home
            </a>
            <a href="javascript:history.back()" class="btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Go Back
            </a>
        </div>
        
        <form class="search-form" action="{{ url('/search') }}" method="GET">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search for something...">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        
        <div class="mt-4">
            <h6 class="text-muted mb-3">Popular Destinations</h6>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ url('/tours-holidays?destination=dubai') }}" class="btn btn-sm btn-outline-primary">Dubai</a>
                <a href="{{ url('/tours-holidays?destination=singapore') }}" class="btn btn-sm btn-outline-primary">Singapore</a>
                <a href="{{ url('/tours-holidays?destination=malaysia') }}" class="btn btn-sm btn-outline-primary">Malaysia</a>
                <a href="{{ url('/visa-services?country=usa') }}" class="btn btn-sm btn-outline-primary">USA</a>
            </div>
        </div>
    </div>
</body>
</html>