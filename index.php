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

        /* ----------------------------- section 3 -----------------------------  */

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
                        <a href="#" class="relative inline-block text-xl md:text-2xl font-bold tracking-widest uppercase group py-2">
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

    <!-- ----------------------------- section 3 -----------------------------  -->

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

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>