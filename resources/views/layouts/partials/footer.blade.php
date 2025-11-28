<!-- Footer Modern SAMU -->
<footer class="content-footer footer bg-footer-theme samu-footer">

    <!-- Decorative Gradient Line -->
    <div class="samu-footer-line"></div>

    <div class="container-fluid px-4 d-flex flex-wrap justify-content-between py-3 flex-md-row flex-column align-items-center">

        <!-- Left Side: Copyright & Version -->
        <div class="mb-2 mb-md-0">
            <div class="d-flex align-items-center">
                <span class="text-muted me-2">© <script>document.write(new Date().getFullYear());</script></span>
                <span class="fw-bold samu-text-gradient me-2">SAMU EWS Platform</span>
                <span class="badge bg-label-secondary rounded-pill" style="font-size: 0.65rem;">v1.2.0</span>
            </div>
            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                Engineered for precision & reliability.
            </small>
        </div>

        <!-- Right Side: Links -->
        <div class="d-flex gap-3 align-items-center mt-2 mt-md-0">
            {{-- <a href="javascript:void(0);" class="footer-link samu-link">
                <i class="bx bx-book-content me-1"></i> Documentation
            </a> --}}
            <a href="{{ route('support.tickets') }}" class="footer-link samu-link">
                <i class="bx bx-support me-1"></i> Support
            </a>
            <div class="samu-divider-vertical"></div>
            <div class="d-flex align-items-center text-muted" style="font-size: 0.8rem;">
                <span class="me-1">System Status:</span>
                <span class="d-flex align-items-center text-success fw-bold">
                    <span class="samu-dot-pulse me-1"></span> Operational
                </span>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Variables (Sama dengan Navbar) */
    :root {
        --samu-gold: #D4A12A;
        --samu-blue: #1E6BA8;
        --samu-cyan: #2EBAC6;
        --samu-bg-glass: rgba(255, 255, 255, 0.9);
    }

    /* 1. Footer Container */
    .samu-footer {
        background-color: var(--samu-bg-glass) !important;
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 10;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.02);
    }

    /* 2. Gradient Top Line */
    .samu-footer-line {
        height: 2px;
        width: 100%;
        background: linear-gradient(90deg, var(--samu-gold), var(--samu-blue), var(--samu-cyan));
        opacity: 0.6;
    }

    /* 3. Gradient Text for Brand */
    .samu-text-gradient {
        background: linear-gradient(135deg, var(--samu-blue), var(--samu-cyan));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    /* 4. Links Styling */
    .samu-link {
        color: #697a8d;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .samu-link:hover {
        color: var(--samu-blue);
        transform: translateY(-1px);
    }

    .samu-divider-vertical {
        width: 1px;
        height: 15px;
        background-color: #d9dee3;
    }

    /* 5. Pulsing Dot (Status) */
    .samu-dot-pulse {
        width: 8px;
        height: 8px;
        background-color: #28a745;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        animation: pulse-green 2s infinite;
    }

    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(40, 167, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }

    /* Dark Mode Support (Jika dipakai) */
    [data-theme="dark"] .samu-footer {
        background-color: #1c1f2e !important; /* Dark Card BG */
        box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
    }
    [data-theme="dark"] .samu-link { color: #a0a6b1; }
    [data-theme="dark"] .samu-link:hover { color: #fff; }
</style>