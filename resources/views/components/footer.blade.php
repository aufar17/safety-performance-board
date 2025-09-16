    <!-- Footer -->
    <footer class="footer text-center py-3 mt-auto">
        <div class="container marquee-container">
            <p class="mb-0 text-dark marquee-text">
                Copyright © <script>document.write(new Date().getFullYear())</script>
                <strong class="text-dark">PT Kayaba Indonesia</strong>
            </p>
        </div>
    </footer>

    <style>
        footer.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #fff; /* kasih warna biar ga transparan */
    z-index: 999;
}

        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
        }
        .marquee-text {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 15s linear infinite;
        }
        @keyframes marquee {
            0%   { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>

