<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Digital Parchment Header</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink-color: #3d2b1f;
            --divider-color: rgba(61, 43, 31, 0.2);
            --bg-color: #fcfaf5;
        }

        body {
            margin: 0;
            background-color: var(--bg-color);
            font-family: 'Playfair Display', serif;
            color: var(--ink-color);
            overflow-x: hidden;
        }

        /* Custom utility cho border đôi */
        .border-double-bottom {
            border-bottom: 4px double var(--ink-color);
        }

        /* Font Masthead */
        .font-gothic {
            font-family: 'Cinzel Decorative', serif;
        }

        /* Mobile Menu Overlay */
        #mobile-menu {
            clip-path: inset(0 0 100% 0);
            /* Giấu menu bằng cách cắt từ dưới lên */
        }

        /* Khử gạch chân mặc định và hiệu ứng hover Nav */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: var(--ink-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>

<body>

    <header id="parchment-header" class="fixed top-0 w-full z-50 py-6 border-t border-[#3d2b1f] border-b-[4px] border-double border-[#3d2b1f] bg-[#fcfaf5]">
        <div class="container mx-auto px-6 max-w-[1400px]">
            <div class="flex items-center justify-between md:justify-center md:gap-[8vw]">

                <div class="section-info hidden md:flex flex-col text-xs uppercase tracking-widest leading-tight shrink-0">
                    EST. 2024<br><span class="font-bold">VOL. I</span>
                </div>

                <div class="vertical-line hidden md:block w-[1px] h-8 bg-[#3d2b1f]/20 shrink-0"></div>

                <div class="section-masthead text-center">
                    <h1 class="font-gothic text-xl sm:text-3xl md:text-5xl font-black whitespace-nowrap tracking-tight italic md:not-italic">
                        CỔ TÍCH BIÊN NIÊN
                    </h1>
                </div>

                <div class="vertical-line hidden md:block w-[1px] h-8 bg-[#3d2b1f]/20 shrink-0"></div>

                <nav class="hidden lg:block shrink-0">
                    <ul class="flex gap-8 text-[11px] uppercase tracking-[0.3em]">
                        <li><a href="#" class="hover:opacity-50 transition-opacity">Kho tàng</a></li>
                        <li><a href="#" class="hover:opacity-50 transition-opacity">Bản đồ</a></li>
                        <li><a href="#" class="hover:opacity-50 transition-opacity">Ghi chép</a></li>
                    </ul>
                </nav>

                <button id="menu-toggle" class="lg:hidden text-2xl z-50 relative">
                    <i class="ri-menu-3-line" id="menu-icon"></i>
                </button>
            </div>
        </div>
    </header>

    <div id="mobile-menu" class="fixed inset-0 bg-[#fcfaf5] z-40 flex flex-col items-center justify-center lg:hidden border-b-[4px] border-double border-[#3d2b1f]">
        <ul class="text-center space-y-8 text-2xl uppercase tracking-[0.4em] font-gothic">
            <li class="mobile-item opacity-0"><a href="#">Kho tàng</a></li>
            <li class="mobile-item opacity-0"><a href="#">Bản đồ</a></li>
            <li class="mobile-item opacity-0"><a href="#">Ghi chép</a></li>
        </ul>
        <div class="mt-12 text-[10px] tracking-widest opacity-50 mobile-item opacity-0">
            EST. 2024 • VOL. I
        </div>
    </div>

    <!-- <main class="pt-40 h-[150vh] p-10 text-center">
        <p class="italic">Nội dung trang web bắt đầu từ đây...</p>
    </main> -->

    <script>
        // Đăng ký thư viện GSAP
        gsap.registerPlugin(ScrollTrigger);

        // ----------------------------- SECTION 1: ANIMATION ----------------------------- //

        // Timeline cho việc xuất hiện Header
        const headerTl = gsap.timeline();

        headerTl.to("#parchment-header", {
                opacity: 1,
                y: 0,
                duration: 0.1
            })
            .from("#parchment-header", {
                y: -50,
                duration: 1.2,
                ease: "power4.out"
            })
            .from(".section-masthead", {
                scale: 0.8,
                opacity: 0,
                duration: 1.5,
                ease: "expo.out"
            }, "-=0.8")
            .from(".vertical-line", {
                height: 0,
                opacity: 0,
                duration: 1,
                stagger: 0.2
            }, "-=1")
            .from(".section-info, .section-nav, #menu-toggle", {
                x: (i, target) => target.classList.contains('section-info') ? -20 : 20,
                opacity: 0,
                duration: 1,
                ease: "power3.out"
            }, "-=0.8");

        // Hiệu ứng ScrollTrigger: Header thu nhỏ khi cuộn
        gsap.to("#parchment-header", {
            scrollTrigger: {
                trigger: "body",
                start: "top top",
                end: "100",
                scrub: 1
            },
            paddingTop: "10px",
            paddingBottom: "10px",
            marginTop: "0px",
            backgroundColor: "rgba(252, 250, 245, 0.95)", // Màu nền mờ khi cuộn
            ease: "none"
        });

        // ----------------------------- LOGIC MOBILE MENU ----------------------------- //
        const menuBtn = document.getElementById('menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileItems = document.querySelectorAll('.mobile-item');

        let isMenuOpen = false;

        // Tạo GSAP Animation cho Menu
        const menuTl = gsap.timeline({
            paused: true
        });

        menuTl.to(mobileMenu, {
                clipPath: "inset(0 0 0% 0)",
                duration: 0.8,
                ease: "power4.inOut"
            })
            .to(mobileItems, {
                opacity: 1,
                y: -20,
                stagger: 0.1,
                duration: 0.5,
                ease: "power2.out"
            }, "-=0.3");

        // Sự kiện Click nút Menu
        menuBtn.addEventListener('click', () => {
            if (!isMenuOpen) {
                menuTl.play();
                menuIcon.classList.replace('ri-menu-3-line', 'ri-close-line');
            } else {
                menuTl.reverse();
                menuIcon.classList.replace('ri-close-line', 'ri-menu-3-line');
            }
            isMenuOpen = !isMenuOpen;
        });

        // Tự động đóng menu nếu xoay màn hình sang ngang (Desktop mode)
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && isMenuOpen) {
                menuTl.reverse();
                menuIcon.classList.replace('ri-close-line', 'ri-menu-3-line');
                isMenuOpen = false;
            }
        });

        // Animation Header lúc load trang
        gsap.from("#parchment-header", {
            y: -100,
            duration: 1,
            ease: "power3.out"
        });
    </script>
</body>

</html>