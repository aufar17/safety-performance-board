<style>
    footer.footer {
        bottom: 0;
        left: 0;
        width: 100%;
        background: #fff;
        z-index: 999;
        overflow: hidden;
        /* biar ga ada scroll horizontal */
    }

    .marquee-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .marquee-text {
        display: inline-block;
        white-space: nowrap;
        padding-right: 100%;
        animation: marquee 20s linear infinite;
    }

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>

<footer class="footer text-center py-3 mt-auto">
    <div class="marquee-wrapper">
        <p class="mb-0 text-dark marquee-text">
            Copyright © <script>
                document.write(new Date().getFullYear())
            </script>
            <strong class="text-dark ">PT Kayaba Indonesia</strong>
        </p>
    </div>
</footer>