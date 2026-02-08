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
        /* Hiệu ứng mảnh giấy da */
        .parchment-fragment {
            /* Đảm bảo nội dung không bị cắt khi con số tràn ra ngoài một chút */
            position: relative;
            clip-path: polygon(2% 0%, 98% 1%, 100% 98%, 1% 100%, 0% 50%);
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #fdfbf7;
            z-index: 5;
        }

        .milestone.active .parchment-fragment {
            transform: scale(1.05);
        }

        .date-stamp {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 900;
            line-height: 1;
            pointer-events: none;
            z-index: 10;
            /* Đảm bảo nằm trên lớp giấy */
            color: #7a1a1a;
            opacity: 0.1;
            transition: opacity 0.5s ease;
        }

        /* Khi cuộn tới (active), con số sẽ hiện rõ hơn */
        .milestone.active .date-stamp {
            opacity: 0.25;
        }

        .milestone.active .parchment-fragment {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(61, 43, 31, 0.15);
        }

        /* Bánh răng trục giữa */
        .gear-node {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fcfaf5;
            border: 1px solid rgba(184, 134, 11, 0.3);
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(184, 134, 11, 0.2);
        }

        /* Mobile Responsive adjustments */
        @media (max-width: 768px) {
            #main-thread {
                left: 30px !important;
                transform: none !important;
            }

            .milestone {
                align-items: flex-start !important;
            }

            .milestone-node {
                margin-left: 5px !important;
            }

            .parchment-fragment {
                margin-left: 20px !important;
                width: calc(100% - 40px) !important;
            }

            .date-stamp {
                font-size: 3rem !important;
                top: -20px !important;
                left: 10px !important;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        #quills-rest {
            background: linear-gradient(to bottom, #fcfaf5 0%, #e8e4d9 100%);
            position: relative;
            overflow: hidden;
        }

        /* Hiệu ứng Mực khô */
        .drying-ink {
            color: #3d2b1f;
            transition: color 3s ease-out, filter 3s ease-out;
        }

        .section-active .drying-ink {
            color: rgba(61, 43, 31, 0.4);
            filter: blur(0.5px);
        }

        /* Khung Epilogue lộng lẫy */
        .epilogue-frame {
            border: 2px solid #b8860b;
            padding: 3rem;
            position: relative;
            background: #fdfbf7;
            box-shadow: inset 0 0 50px rgba(184, 134, 11, 0.05);
        }

        .epilogue-frame::before {
            content: '';
            position: absolute;
            inset: 10px;
            border: 1px solid rgba(184, 134, 11, 0.2);
        }

        /* Hiệu ứng Khói nến SVG */
        #candle-smoke {
            filter: blur(8px);
            opacity: 0.6;
        }

        /* Trang giấy cuối cùng bị cong */
        .page-fold {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, transparent 50%, rgba(0, 0, 0, 0.05) 50%, rgba(0, 0, 0, 0.1) 100%);
            cursor: pointer;
            transition: all 0.5s ease;
            z-index: 30;
        }

        .page-fold:hover {
            width: 150px;
            height: 150px;
        }

        /* Nút Chìa khóa & La bàn */
        .cta-item {
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .cta-item:hover {
            transform: translateY(-10px);
            color: #7a1a1a;
        }

        .cta-item i {
            font-size: 3rem;
            display: block;
            margin-bottom: 1rem;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
        }

        @media (max-width: 768px) {
            .epilogue-frame {
                padding: 1.5rem;
            }

            .cta-container {
                flex-direction: column;
                gap: 2rem;
            }
        }

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

    <main class="h-[30vh] flex items-center justify-center bg-gray-100">
        <p class="text-3xl text-gray-700 font-bold">Dòng thời gian bắt đầu từ đây...</p>
    </main>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="weaver-thread" class="relative py-24 min-h-screen">

        <div id="main-thread" class="absolute left-1/2 -translate-x-1/2 top-0 w-[2px] bg-[#3d2b1f]/10 h-0 z-0 origin-top"></div>

        <div class="container mx-auto max-w-6xl px-6 relative z-10">

            <div class="milestone flex flex-col md:flex-row items-center justify-between mb-[20vh] opacity-0 translate-y-20">
                <div class="w-full md:w-[45%] relative order-2 md:order-1">
                    <span class="date-stamp absolute -top-12 md:-top-16 -left-4 md:-left-8 text-6xl md:text-8xl">1200</span>

                    <div class="parchment-fragment p-8 shadow-2xl border border-[#3d2b1f]/5">
                        <h3 class="font-gothic text-2xl md:text-3xl mb-3">Vương Quốc Phù Du</h3>
                        <p class="italic text-sm opacity-80 mb-6">Sự kiện: Đại dịch Đen bắt đầu lan rộng khắp Châu Âu, thay đổi bản đồ nhân loại mãi mãi.</p>
                        <div class="w-full aspect-video bg-[#3d2b1f]/5 rounded-sm overflow-hidden border border-[#3d2b1f]/10">
                            <img src="https://www.vietnammonpaysnatal.fr/wp-content/uploads/2016/11/founan.jpg"
                                class="w-full h-full object-cover grayscale sepia-[0.2] hover:grayscale-0 transition-all duration-1000">
                        </div>
                    </div>
                </div>

                <div class="milestone-node z-20 order-1 md:order-2 my-10 md:my-0">
                    <div class="gear-node text-[#b8860b]">
                        <i class="ri-settings-4-line text-2xl"></i>
                    </div>
                </div>

                <div class="hidden md:block w-[45%] order-3"></div>
            </div>

            <div class="milestone flex flex-col md:flex-row items-center justify-between mb-[20vh] opacity-0 translate-y-20">
                <div class="hidden md:block w-[45%] order-1"></div>

                <div class="milestone-node z-20 order-2 my-10 md:my-0">
                    <div class="gear-node text-[#b8860b]">
                        <i class="ri-settings-4-line text-2xl"></i>
                    </div>
                </div>

                <div class="w-full md:w-[45%] relative order-3">
                    <span class="date-stamp absolute -top-12 md:-top-16 -right-4 md:-right-8 text-6xl md:text-8xl">1789</span>

                    <div class="parchment-fragment p-8 shadow-2xl border border-[#3d2b1f]/5">
                        <h3 class="font-gothic text-2xl md:text-3xl mb-3">Vũ Điệu Chém Giết</h3>
                        <p class="italic text-sm opacity-80 mb-6">Sự kiện: Ngọn lửa Cách mạng Pháp bùng cháy tại ngục Bastille, kỷ nguyên dân chủ bắt đầu.</p>
                        <div class="w-full aspect-video bg-[#3d2b1f]/5 rounded-sm overflow-hidden border border-[#3d2b1f]/10">
                            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1000"
                                class="w-full h-full object-cover grayscale sepia-[0.2] hover:grayscale-0 transition-all duration-1000">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="quills-rest" class="relative py-32 md:py-48 mt-[20vh]">

        <div class="page-fold"></div>

        <div class="container mx-auto max-w-4xl px-6 text-center">

            <div class="relative mb-16 opacity-0" id="final-visual">
                <div class="text-6xl text-[#3d2b1f]/20 mb-4">
                    <i class="ri-quill-pen-line"></i>
                </div>
                <svg class="mx-auto w-24 h-24" viewBox="0 0 100 100" id="candle-smoke">
                    <path d="M50,80 Q40,60 50,40 T50,0" fill="none" stroke="#3d2b1f" stroke-width="2" />
                </svg>
            </div>

            <div class="epilogue-frame mb-20 opacity-0 translate-y-10" id="epilogue-container">
                <h2 class="font-gothic text-3xl md:text-5xl mb-8">Lời Kết</h2>
                <p class="drying-ink text-lg md:text-xl italic leading-relaxed">
                    "Dòng mực có thể khô, trang giấy có thể sờn, nhưng những câu chuyện thì vẫn luôn ở đó,
                    đợi chờ một tâm hồn đủ tò mò để đánh thức chúng thêm một lần nữa.
                    Hành trình của bạn tại Biên niên sử hôm nay dừng bước, nhưng thế giới ngoài kia,
                    những chương mới vẫn đang được viết tiếp bằng chính dấu chân của bạn..."
                </p>
            </div>

            <div class="cta-container flex justify-center gap-16 md:gap-32 opacity-0" id="final-actions">
                <div class="cta-item group">
                    <i class="ri-key-2-line"></i>
                    <span class="font-gothic text-sm tracking-widest">VỀ THƯ VIỆN</span>
                </div>
                <div class="cta-item group">
                    <i class="ri-compass-3-line"></i>
                    <span class="font-gothic text-sm tracking-widest">TRUYỆN NGẪU NHIÊN</span>
                </div>
                <div class="cta-item group" id="back-to-top">
                    <i class="ri-history-line"></i>
                    <span class="font-gothic text-sm tracking-widest">VỀ KHỞI NGUYÊN</span>
                </div>
            </div>

        </div>
    </section>

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
    window.addEventListener('load', function() {
        gsap.registerPlugin(ScrollTrigger);

        // 1. Hiệu ứng sợi chỉ tự vẽ (Growth Animation)
        gsap.to("#main-thread", {
            scrollTrigger: {
                trigger: "#weaver-thread",
                start: "top center",
                end: "bottom bottom",
                scrub: 1.5
            },
            height: "100%",
            ease: "none"
        });

        // 2. Xử lý từng Milestone (Memory Fade & Snap)
        gsap.utils.toArray('.milestone').forEach((stone, i) => {
            const gear = stone.querySelector('.gear-node');

            gsap.to(stone, {
                scrollTrigger: {
                    trigger: stone,
                    start: "top 80%",
                    end: "top 40%",
                    toggleActions: "play none none reverse",
                    onEnter: () => stone.classList.add('active'),
                    onLeaveBack: () => stone.classList.remove('active'),
                },
                opacity: 1,
                y: 0,
                duration: 1
            });

            // Hiệu ứng xoay bánh răng khi cuộn
            gsap.to(gear, {
                scrollTrigger: {
                    trigger: stone,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1
                },
                rotation: 360,
                ease: "none"
            });
        });
    });

    //----------------------------- section 3 ----------------------------- //
    window.addEventListener('load', function() {
        // ScrollTrigger cho Section 3
        const section3Tl = gsap.timeline({
            scrollTrigger: {
                trigger: "#quills-rest",
                start: "top 60%",
                onEnter: () => document.getElementById('quills-rest').classList.add('section-active')
            }
        });

        section3Tl.to("#final-visual", {
                opacity: 1,
                duration: 2
            })
            .to("#epilogue-container", {
                opacity: 1,
                y: 0,
                duration: 1.5
            }, "-=1")
            .to("#final-actions", {
                opacity: 1,
                duration: 1.5,
                ease: "power2.out"
            }, "-=0.5");

        // Animation cho khói nến (bay lượn nhẹ nhàng)
        gsap.to("#candle-smoke path", {
            attr: {
                d: "M50,80 Q60,60 40,40 T50,0"
            },
            duration: 3,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // Nút "Về khởi nguyên" - Đồng hồ ngược
        document.getElementById('back-to-top').addEventListener('click', () => {
            gsap.to(window, {
                duration: 3,
                scrollTo: 0,
                ease: "power4.inOut"
            });
        });

        // Hiệu ứng Chìa khóa tỏa sáng khi hover
        document.querySelectorAll('.cta-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                gsap.to(item.querySelector('i'), {
                    scale: 1.2,
                    color: "#b8860b",
                    duration: 0.3
                });
            });
            item.addEventListener('mouseleave', () => {
                gsap.to(item.querySelector('i'), {
                    scale: 1,
                    color: "#3d2b1f",
                    duration: 0.3
                });
            });
        });
    });

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>