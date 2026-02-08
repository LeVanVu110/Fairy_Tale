<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* CSS hỗ trợ cho Drop Cap */
        .drop-cap {
            font-family: 'Cinzel Decorative', serif;
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
        }

        /* Hiệu ứng Parallax cho ảnh bên trong khung */
        .hero-image-wrapper:hover .hero-img {
            transform: scale(1.12) translateY(-10px);
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Hiệu ứng "Mực loang tiêu đề" */
        .story-card:hover .story-title {
            color: #7a1a1a;
            /* Burgundy (Đỏ rượu chát) */
            text-shadow: 0.5px 0.5px 1px rgba(122, 26, 26, 0.2);
        }

        /* Hiệu ứng phóng to thẻ nhẹ nhàng */
        .story-card {
            perspective: 1000px;
            /* Cần thiết cho hiệu ứng Tilt 3D */
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* Hiệu ứng Gió thổi: Tạo bóng đổ nhẹ ở góc thẻ */
        .parchment-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, transparent 50%, rgba(61, 43, 31, 0.05) 50%);
            box-shadow: -2px -2px 5px rgba(0, 0, 0, 0.02);
            transition: all 0.5s ease;
        }

        .parchment-card:hover::before {
            width: 45px;
            height: 45px;
        }

        /* Đảm bảo SVG signature tàng hình trước khi vẽ */
        #signature-path {
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .desk-illustration {
                position: relative;
                left: 0;
                margin-bottom: -30px;
                transform: rotate(0deg) scale(0.8);
                opacity: 1 !important;
            }

            .parchment-card {
                padding: 2rem 1.5rem;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>


<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="hero-manuscript" class="relative min-h-[90vh] flex items-center justify-center py-12 md:py-20 px-6 overflow-hidden select-none bg-[#fcfaf5] mt-12">

        <canvas id="dust-canvas" class="absolute inset-0 pointer-events-none opacity-40 z-10"></canvas>

        <div class="container mx-auto max-w-7xl z-20">
            <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-[5vw]">

                <div class="hero-image-wrapper relative group w-full md:w-1/2 flex justify-center">
                    <div class="relative p-4 border-[12px] border-double border-[#3d2b1f]/20 rounded-sm shadow-2xl overflow-hidden bg-white/50 transition-all duration-700 hover:border-[#3d2b1f]/40">
                        <div class="overflow-hidden relative w-full aspect-[4/5] md:aspect-square lg:w-[450px]">
                            <img
                                src="https://images.unsplash.com/photo-1589998059171-988d887df646?q=80&w=2076&auto=format&fit=crop"
                                alt="Mythical Illustration"
                                class="hero-img w-full h-full object-cover grayscale-[30%] scale-105 transition-all duration-[2s] ease-out group-hover:scale-110 group-hover:grayscale-0 group-hover:saturate-150">
                            <div class="absolute inset-0 shadow-[inset_0_0_60px_rgba(252,250,245,1)] pointer-events-none"></div>
                        </div>
                    </div>
                    <i class="ri-quill-pen-line absolute -top-4 -left-4 text-3xl opacity-20"></i>
                </div>

                <div class="hero-content w-full md:w-1/2 space-y-8 text-center md:text-left">
                    <h1 class="font-gothic text-4xl md:text-6xl lg:text-7xl font-black leading-tight tracking-tighter opacity-0 translate-y-10" id="hero-title">
                        KỲ TÍCH <br> <span class="text-[#7a1a1a]">RỪNG THỦY TINH</span>
                    </h1>

                    <p class="teaser-text text-lg md:text-xl text-[#3d2b1f]/80 leading-relaxed font-serif opacity-0" id="hero-teaser">
                        <span class="drop-cap inline-block float-left text-7xl md:text-8xl font-black leading-[0.8] mr-4 text-[#7a1a1a] opacity-0" id="ink-drop-cap">N</span>
                        gày xửa ngày xưa, tại nơi ánh trăng không bao giờ lặn, những linh hồn cổ xưa đã dệt nên một bản thảo bằng tơ nhện và ánh sáng lân tinh để lưu giữ lại ký ức của vương quốc đã mất...
                    </p>

                    <div class="cta-wrapper pt-4 opacity-0 translate-y-10" id="hero-cta">
                        <a href="Discover_the_chronicles.php" class="relative inline-block text-xl md:text-2xl font-bold tracking-widest uppercase group py-2">
                            Khám phá biên niên sử
                            <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-[#7a1a1a] transition-all duration-700 ease-in-out group-hover:w-full"></span>
                            <span class="absolute -bottom-2 left-0 w-full h-[1px] bg-[#3d2b1f]/10"></span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="story-grid" class="relative py-20 px-6 bg-[#fcfaf5] overflow-hidden">
        <div class="container mx-auto max-w-7xl">

            <div class="mb-12 text-center md:text-left">
                <h2 class="font-gothic text-3xl md:text-4xl uppercase tracking-widest border-b border-[#3d2b1f]/20 inline-block pb-2">
                    Kho Tàng Di Sản
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-12" id="grid-container">

                <div class="story-card group md:col-span-2 relative p-4 border border-[#3d2b1f]/30 bg-[#fdfbf7] shadow-sm transition-all duration-500">
                    <div class="absolute top-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute top-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>

                    <div class="overflow-hidden mb-4 aspect-[16/9] md:aspect-video">
                        <img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?q=80&w=2070&auto=format&fit=crop"
                            class="w-full h-full object-cover sepia-[0.3] group-hover:sepia-0 transition-all duration-700" alt="Story 1">
                    </div>
                    <div class="space-y-1">
                        <h3 class="story-title text-xl md:text-2xl font-bold transition-colors duration-500">Bạch Tuyết và Bảy Chú Lùn</h3>
                        <p class="text-xs uppercase tracking-widest opacity-60">Nguồn gốc: Truyện cổ Grimm</p>
                    </div>
                </div>

                <div class="story-card group relative p-4 border border-[#3d2b1f]/30 bg-[#fdfbf7] shadow-sm">
                    <div class="absolute top-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute top-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>

                    <div class="overflow-hidden mb-4 aspect-square">
                        <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=1974&auto=format&fit=crop"
                            class="w-full h-full object-cover sepia-[0.3] group-hover:sepia-0 transition-all duration-700" alt="Story 2">
                    </div>
                    <div class="space-y-1">
                        <h3 class="story-title text-xl font-bold transition-colors duration-500">Sự Tích Trầu Cau</h3>
                        <p class="text-xs uppercase tracking-widest opacity-60">Dân gian Việt Nam</p>
                    </div>
                </div>

                <div class="story-card group relative p-4 border border-[#3d2b1f]/30 bg-[#fdfbf7] shadow-sm">
                    <div class="absolute top-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute top-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>

                    <div class="overflow-hidden mb-4 aspect-square">
                        <img src="https://truyencotich.top/storage/img/oxpoyAGfLTvxPBNksDHdyMUM78GlTlgchcYp8htf.webp"
                            class="w-full h-full object-cover sepia-[0.3] group-hover:sepia-0 transition-all duration-700" alt="Story 3">
                    </div>
                    <div class="space-y-1">
                        <h3 class="story-title text-xl font-bold transition-colors duration-500">Bộ Quần Áo Mới Của Hoàng Đế</h3>
                        <p class="text-xs uppercase tracking-widest opacity-60">Truyện cổ Andersen</p>
                    </div>
                </div>

                <div class="story-card group relative p-4 border border-[#3d2b1f]/30 bg-[#fdfbf7] shadow-sm">
                    <div class="absolute top-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute top-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 left-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>
                    <div class="absolute bottom-1 right-1"><i class="ri-asterisk text-[10px] opacity-30"></i></div>

                    <div class="overflow-hidden mb-4 aspect-square">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=1974&auto=format&fit=crop"
                            class="w-full h-full object-cover sepia-[0.3] group-hover:sepia-0 transition-all duration-700" alt="Story 4">
                    </div>
                    <div class="space-y-1">
                        <h3 class="story-title text-xl font-bold transition-colors duration-500">Nghìn Lẻ Một Đêm</h3>
                        <p class="text-xs uppercase tracking-widest opacity-60">Dân gian Ả Rập</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="collectors-desk" class="relative py-[100px] md:py-[150px] px-6 bg-[#fcfaf5] overflow-hidden">

        <div class="container mx-auto max-w-6xl relative">
            <div class="flex flex-col md:flex-row items-center justify-center relative">

                <div class="desk-illustration relative md:absolute md:-left-10 z-20 w-40 md:w-64 transform -rotate-12 opacity-0 translate-x-[-50px]">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1000&auto=format&fit=crop"
                        alt="Ink and Quill"
                        class="rounded-full border-8 border-[#3d2b1f]/5 shadow-2xl sepia-[0.5]">
                    <div class="absolute -bottom-4 -right-4 text-[#7a1a1a] text-4xl opacity-40">
                        <i class="ri-quill-pen-fill"></i>
                    </div>
                </div>

                <div class="parchment-card relative z-10 bg-[#fdfbf7] p-8 md:p-16 shadow-[0_10px_50px_rgba(0,0,0,0.1)] max-w-2xl border border-[#3d2b1f]/10 rounded-[2px] transition-all duration-500 hover:shadow-[0_15px_60px_rgba(0,0,0,0.15)]">

                    <div class="corner-curl top-0 right-0"></div>

                    <div class="space-y-6">
                        <h2 class="font-gothic text-2xl md:text-3xl text-[#7a1a1a] tracking-widest">Lời Nhắn Từ Nhà Chép Sử</h2>

                        <div class="message-content font-serif italic text-[#3d2b1f]/80 leading-relaxed md:text-lg">
                            <p>"Cảm ơn lữ khách đã dừng chân bên bàn làm việc của ta. Những câu chuyện này không chỉ là những dòng code khô khan, mà là hơi thở của quá khứ được tái sinh. Hy vọng bạn tìm thấy một chút phép thuật giữa những dòng chữ này."</p>
                        </div>

                        <div class="signature-container py-4 flex justify-end">
                            <svg width="200" height="60" viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path id="signature-path" d="M20 40C30 35 50 10 70 25C90 40 110 45 130 20C150 -5 170 30 190 35"
                                    stroke="#3d2b1f" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>

                        <div class="newsletter-area pt-8 border-t border-[#3d2b1f]/10">
                            <p class="text-xs uppercase tracking-[0.3em] mb-4">Để lại danh tính để nhận thư tín:</p>
                            <form class="relative group">
                                <input type="email" placeholder="Địa chỉ thư tín (Email)..."
                                    class="w-full bg-transparent border-none border-b border-[#3d2b1f]/30 py-2 focus:ring-0 focus:border-[#7a1a1a] transition-all italic text-[#3d2b1f] placeholder-[#3d2b1f]/40 outline-none">
                                <button class="absolute right-0 bottom-2 text-[#7a1a1a] hover:translate-x-2 transition-transform">
                                    <i class="ri-send-plane-2-line text-xl"></i>
                                </button>
                            </form>
                        </div>

                        <div class="social-links pt-6 flex gap-6 justify-center md:justify-start opacity-60">
                            <a href="#" class="hover:text-[#7a1a1a] transition-colors"><i class="ri-facebook-circle-line text-xl"></i></a>
                            <a href="#" class="hover:text-[#7a1a1a] transition-colors"><i class="ri-instagram-line text-xl"></i></a>
                            <a href="#" class="hover:text-[#7a1a1a] transition-colors"><i class="ri-twitter-x-line text-xl"></i></a>
                        </div>
                    </div>
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
    // 1. Hiệu ứng Bụi thần thoại (Dust Particles)
    const canvas = document.getElementById('dust-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 1.5;
            this.speedX = (Math.random() - 0.5) * 0.3;
            this.speedY = (Math.random() - 0.5) * 0.2;
            this.opacity = Math.random() * 0.5;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x > canvas.width) this.x = 0;
            if (this.y > canvas.height) this.y = 0;
        }
        draw() {
            ctx.fillStyle = `rgba(61, 43, 31, ${this.opacity})`;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function initParticles() {
        particles = [];
        for (let i = 0; i < 150; i++) particles.push(new Particle());
    }

    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.update();
            p.draw();
        });
        requestAnimationFrame(animateParticles);
    }

    window.addEventListener('resize', resize);
    resize();
    initParticles();
    animateParticles();

    // 2. Hiệu ứng GSAP: Chữ cái khởi đầu & Loading Sequence
    window.addEventListener('load', () => {
        const tl = gsap.timeline();

        // Vẽ mực cho Drop Cap (Giả lập bằng scale và opacity)
        tl.to("#ink-drop-cap", {
                opacity: 1,
                scale: 1.5,
                duration: 0.1
            })
            .from("#ink-drop-cap", {
                scale: 4,
                filter: "blur(20px)",
                duration: 1.5,
                ease: "expo.out"
            })
            // Hiện tiêu đề
            .to("#hero-title", {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: "power4.out"
            }, "-=1")
            // Hiện teaser
            .to("#hero-teaser", {
                opacity: 1,
                duration: 1,
                ease: "power2.out"
            }, "-=0.5")
            // Hiện CTA
            .to("#hero-cta", {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: "back.out(1.7)"
            }, "-=0.5");
    });

    // -----------------------------section 2 ----------------------------- //
    // 1. Hiệu ứng "Lật thẻ" nhẹ (The Tilt Effect) dùng Vanilla GSAP
    const cards = document.querySelectorAll('.story-card');

    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            if (window.innerWidth < 1024) return; // Chỉ chạy trên Desktop

            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 15;
            const rotateY = (centerX - x) / 15;

            gsap.to(card, {
                rotateX: rotateX,
                rotateY: rotateY,
                scale: 1.02,
                duration: 0.5,
                ease: "power2.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                rotateX: 0,
                rotateY: 0,
                scale: 1,
                duration: 0.5,
                ease: "power2.out"
            });
        });
    });

    // 2. Hiệu ứng "Scroll Reveal" (Dành cho cả Desktop và đặc biệt là Mobile)
    gsap.utils.toArray('.story-card').forEach((card, i) => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: "top bottom-=100",
                toggleActions: "play none none reverse"
            },
            opacity: 0,
            y: 50,
            duration: 1,
            ease: "power3.out",
            delay: i % 3 * 0.1 // Stagger hiệu ứng cho đẹp
        });
    });

    //----------------------------- section 3 ----------------------------- //
    // 1. Hiệu ứng trượt vào của minh họa lọ mực
    gsap.to(".desk-illustration", {
        scrollTrigger: {
            trigger: "#collectors-desk",
            start: "top 70%",
        },
        opacity: 1,
        x: 0,
        rotate: -5,
        duration: 1.5,
        ease: "power3.out"
    });

    // 2. Hiệu ứng Bút ký (Signature Animation)
    gsap.to("#signature-path", {
        scrollTrigger: {
            trigger: ".signature-container",
            start: "top 80%",
        },
        strokeDashoffset: 0,
        duration: 3,
        ease: "power1.inOut"
    });

    // 3. Hiệu ứng rung nhẹ khi Hover Card (The Subtle Leaf Turn)
    const card = document.querySelector('.parchment-card');
    card.addEventListener('mouseenter', () => {
        gsap.to(card, {
            y: -5,
            rotateZ: 0.5,
            duration: 0.4,
            ease: "sine.inOut"
        });
    });
    card.addEventListener('mouseleave', () => {
        gsap.to(card, {
            y: 0,
            rotateZ: 0,
            duration: 0.4,
            ease: "sine.inOut"
        });
    });

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>