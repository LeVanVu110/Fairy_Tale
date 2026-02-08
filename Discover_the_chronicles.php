<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Chronos Gate - Biên Niên Sử</title>
    <style>
        :root {
            --ink-color: #3d2b1f;
            --bg-color: #fcfaf5;
            --gold-color: #b8860b;
        }

        body {
            margin: 0;
            background-color: var(--bg-color);
            font-family: 'Playfair Display', serif;
            color: var(--ink-color);
            overflow-x: hidden;
        }

        /* ----------------------------- section 1 -----------------------------  */
        .font-gothic {
            font-family: 'Cinzel Decorative', serif;
        }

        /* Canvas cho hiệu ứng sương mù */
        #fog-canvas {
            position: absolute;
            inset: 0;
            z-index: 50;
            /* Cao hơn nội dung */
            pointer-events: none;
        }

        /* Đồng hồ cát/Bản đồ tinh tú */
        .astrolabe {
            position: relative;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle at center, rgba(var(--gold-color), 0.8) 0%, rgba(var(--gold-color), 0.5) 50%, transparent 100%);
            border: 5px solid var(--gold-color);
            box-shadow: 0 0 30px rgba(var(--gold-color), 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-color);
            font-family: 'Times New Roman', serif;
            font-size: 2.5rem;
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
            overflow: hidden;
            /* Giữ các bánh răng bên trong */
        }

        .astrolabe::before,
        .astrolabe::after {
            content: '';
            position: absolute;
            border: 1px dashed var(--ink-color);
            border-radius: 50%;
        }

        .astrolabe::before {
            width: 90%;
            height: 90%;
        }

        .astrolabe::after {
            width: 60%;
            height: 60%;
        }

        /* Bánh răng giả lập */
        .gear {
            position: absolute;
            background-color: var(--ink-color);
            border-radius: 50%;
            opacity: 0.1;
            z-index: -1;
        }

        .gear-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
        }

        .gear-2 {
            width: 150px;
            height: 150px;
            bottom: 5%;
            right: 5%;
        }

        /* Mực chảy ở cuối section */
        #ink-drop-line {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 0;
            /* Bắt đầu ẩn */
            background-color: var(--ink-color);
            z-index: 10;
        }

        /* Dải văn bản dọc Desktop */
        .vertical-text {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            white-space: nowrap;
            font-family: 'Times New Roman', serif;
            font-size: 0.9rem;
            opacity: 0.3;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .vertical-text-left {
            left: 5%;
        }

        .vertical-text-right {
            right: 5%;
        }

        @media (max-width: 768px) {
            .astrolabe {
                width: 200px;
                height: 200px;
                font-size: 1.8rem;
            }

            .gear {
                display: none;
            }

            .vertical-text {
                display: none;
            }

            #chronos-gate {
                padding-top: 10vh;
                padding-bottom: 10vh;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="chronos-gate" class="relative min-h-screen flex flex-col items-center justify-center py-[15vh] bg-[#fcfaf5] text-[#3d2b1f] overflow-hidden">

        <canvas id="fog-canvas"></canvas>

        <div class="relative z-20 text-center">
            <h1 class="font-gothic text-5xl md:text-7xl leading-none tracking-tighter mb-8 opacity-0" id="main-title">
                Cánh Cổng <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-700 to-yellow-900">Thời Gian</span>
            </h1>

            <div class="astrolabe opacity-0 scale-50" id="astrolabe" style="justify-self:anchor-center;">
                <div class="gear gear-1"></div>
                <div class="gear gear-2"></div>
                <span id="eternity-text">ETERNITY</span>
            </div>

            <p class="text-sm md:text-base italic mt-8 max-w-lg mx-auto opacity-0" id="sub-text">
                "Hành trình xuyên qua dòng chảy bất tận của Biên niên sử..."
            </p>
        </div>

        <div class="vertical-text vertical-text-left hidden md:block" id="quote-left">
            "Tempus Fugit, Memento Mori." <br> <i>(Thời gian trôi, hãy nhớ rằng bạn sẽ chết.)</i>
        </div>
        <div class="vertical-text vertical-text-right hidden md:block" id="quote-right">
            "Carpe Diem." <br> <i>(Nắm bắt ngày hôm nay.)</i>
        </div>

        <div id="ink-drop-line"></div>

    </section>

    <main class="h-[200vh] flex items-center justify-center bg-gray-100">
        <p class="text-3xl text-gray-700 font-bold">Dòng thời gian bắt đầu từ đây...</p>
    </main>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    // Đăng ký Plugin
    gsap.registerPlugin(ScrollTrigger);

    // 1. Quản lý hiệu ứng Màn sương (Fog)
    const fogCanvas = document.getElementById('fog-canvas');
    const fogCtx = fogCanvas.getContext('2d');
    let particles = [];
    let requestId;

    function resizeFogCanvas() {
        fogCanvas.width = window.innerWidth;
        fogCanvas.height = window.innerHeight;
        particles = [];
        for (let i = 0; i < 200; i++) {
            particles.push({
                x: Math.random() * fogCanvas.width,
                y: Math.random() * fogCanvas.height,
                size: Math.random() * 2 + 1,
                speedX: (Math.random() - 0.5) * 0.5,
                speedY: (Math.random() - 0.5) * 0.5,
                opacity: Math.random() * 0.3 + 0.1
            });
        }
    }

    function drawFog() {
        fogCtx.clearRect(0, 0, fogCanvas.width, fogCanvas.height);
        fogCtx.fillStyle = 'rgba(61, 43, 31, 0.1)';
        particles.forEach(p => {
            p.x += p.speedX;
            p.y += p.speedY;
            if (p.x < 0 || p.x > fogCanvas.width) p.speedX *= -1;
            if (p.y < 0 || p.y > fogCanvas.height) p.speedY *= -1;
            fogCtx.beginPath();
            fogCtx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            fogCtx.fill();
        });
        requestId = requestAnimationFrame(drawFog);
    }

    // Đảm bảo mọi thứ chạy sau khi load trang
    window.addEventListener('load', function() {
        window.addEventListener('resize', resizeFogCanvas);
        resizeFogCanvas();
        drawFog();

        // --- KHỞI TẠO TIMELINE CHÍNH ---
        const chronosTl = gsap.timeline();

        // A. Sương mù mờ dần và biến mất
        chronosTl.to("#fog-canvas", {
                opacity: 0,
                duration: 2,
                ease: "power2.inOut",
                onComplete: () => {
                    fogCanvas.style.display = 'none'; // Xóa hẳn canvas để không chặn click
                    if (requestId) cancelAnimationFrame(requestId);
                }
            })
            // B. Hiện tiêu đề (Dùng .to để đưa từ opacity-0 lên 1)
            .to("#main-title", {
                opacity: 1,
                y: 0,
                duration: 1.5,
                ease: "power3.out"
            }, "-=1.5") // Chạy lồng vào khi sương đang tan
            // C. Hiện Đồng hồ cát (Astrolabe)
            .to("#astrolabe", {
                opacity: 1,
                scale: 1,
                duration: 1.5,
                ease: "back.out(1.7)"
            }, "-=1.2")
            // D. Hiện text mô tả
            .to("#sub-text", {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: "power2.out"
            }, "-=0.8")
            // E. Hiện văn bản dọc
            .to(["#quote-left", "#quote-right"], {
                opacity: 0.3,
                x: 0,
                duration: 1,
                ease: "power2.out"
            }, "-=0.5");

        // 2. Hiệu ứng bánh răng khi cuộn (Scroll Rotation)
        gsap.to(".gear-1", {
            rotation: 360,
            ease: "none",
            scrollTrigger: {
                trigger: "#chronos-gate",
                start: "top top",
                end: "bottom top",
                scrub: 2
            }
        });

        gsap.to(".gear-2", {
            rotation: -360,
            ease: "none",
            scrollTrigger: {
                trigger: "#chronos-gate",
                start: "top top",
                end: "bottom top",
                scrub: 2
            }
        });

        // 3. Hiệu ứng dòng mực (Ink Line)
        gsap.to("#ink-drop-line", {
            height: 150,
            scrollTrigger: {
                trigger: "#chronos-gate",
                start: "bottom 80%",
                end: "bottom 20%",
                scrub: 1
            }
        });

        // 4. Xử lý tương tác Astrolabe (Hover/Gyro)
        const astrolabe = document.getElementById('astrolabe');
        if (window.innerWidth < 768 && window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (e) => {
                gsap.to(astrolabe, {
                    rotationX: e.beta * -0.2,
                    rotationY: e.gamma * 0.5,
                    duration: 0.5
                });
            });
        } else {
            astrolabe.addEventListener('mousemove', (e) => {
                const rect = astrolabe.getBoundingClientRect();
                const x = (e.clientX - rect.left - rect.width / 2) / 10;
                const y = (e.clientY - rect.top - rect.height / 2) / -10;
                gsap.to(astrolabe, {
                    rotationX: y,
                    rotationY: x,
                    duration: 0.5
                });
            });
            astrolabe.addEventListener('mouseleave', () => {
                gsap.to(astrolabe, {
                    rotationX: 0,
                    rotationY: 0,
                    duration: 0.5
                });
            });
        }
    });

    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>