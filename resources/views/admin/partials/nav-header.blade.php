<div class="nav-header">
    <div class="brand-logo">
        <a href="{{ url('/') }}" class="logo-link">
            <div class="logo-container">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="main-logo">
            </div>
        </a>
    </div>
</div>

<style>
.nav-header {
    background: white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    height: 85px;
    padding-top: 10px;
    display: flex;
    align-items: flex-start;
    width: 244px;
    transition: all 0.3s ease;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}

.brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.logo-link {
    display: block;
    text-align: center;
}

.logo-container {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.main-logo {
    height: 75px;
    width: auto;
    object-fit: contain;
    transition: all 0.3s ease;
}

.main-logo:hover {
    transform: scale(1.05);
    opacity: 0.9;
}

@media (max-width: 1200px) {
    .nav-header {
        width: 70px;
    }

    .nav-header.show {
        width: 250px;
    }

    .main-logo {
        height: 60px;
    }

    .nav-header.show .main-logo {
        height: 60px;
    }
}

@media (max-width: 768px) {
    .nav-header {
        padding: 0.5rem 0.75rem;
        padding-top: 1rem;
        height: 85px;
    }

    .main-logo {
        height: 50px;
    }
}
</style>
