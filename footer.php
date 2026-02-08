<footer class="w-full bg-[#fcfaf5] text-[#3d2b1f] pt-20 pb-10 px-6 overflow-hidden border-t border-[#3d2b1f]/10">
    <div class="max-w-[1200px] mx-auto">

        <div class="ornament-container flex justify-center mb-16">
            <div class="ornament h-[2px] bg-[#3d2b1f]/20 w-1/2 md:w-[80%] relative transition-all duration-700">
                <div class="absolute inset-0 flex justify-around -top-1">
                    <span class="w-2 h-2 rounded-full bg-[#3d2b1f]/40 rotate-45"></span>
                    <span class="w-2 h-2 rounded-full bg-[#3d2b1f]/40 rotate-45 hidden md:block"></span>
                    <span class="w-2 h-2 rounded-full bg-[#3d2b1f]/40 rotate-45"></span>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6 md:gap-[6rem]">

            <div class="footer-col-left order-3 md:order-1 flex-1 text-center md:text-left space-y-4">
                <h3 class="font-gothic text-lg uppercase tracking-widest">Sứ Mệnh</h3>
                <p class="text-sm italic leading-relaxed opacity-80">
                    "Lưu giữ những mảnh vụn của thời gian, nơi những câu chuyện cổ xưa tìm thấy nơi trú ẩn giữa thế kỷ số."
                </p>
            </div>

            <div class="footer-emblem order-1 md:order-2 flex-shrink-0">
                <div class="seal-container relative cursor-pointer">
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-[#7a1a1a] rounded-full flex items-center justify-center text-[#fcfaf5] shadow-lg border-4 border-[#5a1212] transition-all duration-300 hover:scale-105 active:scale-95" id="wax-seal">
                        <i class="ri-quill-pen-line text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="footer-col-right order-2 md:order-3 flex-1 text-center md:text-right space-y-4">
                <h3 class="font-gothic text-lg uppercase tracking-widest text-center md:text-right">La Bàn</h3>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="Ancient_Secrets.php" class="footer-link opacity-70 hover:opacity-100 transition-all duration-500 text-sm tracking-widest">BÍ MẬT CỔ NGỮ</a></li>
                        <li><a href="Explorer’s_Atlas.php" class="footer-link opacity-70 hover:opacity-100 transition-all duration-500 text-sm tracking-widest">BẢN ĐỒ VIỄN THÁM</a></li>
                        <li><a href="Alchemist's_Study.php" class="footer-link opacity-70 hover:opacity-100 transition-all duration-500 text-sm tracking-widest">LIÊN HỆ PHÁP SƯ</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="mt-16 pt-10 border-t border-[#3d2b1f]/5 text-center">
            <p class="text-[9px] uppercase tracking-[0.5em] opacity-40">
                © 2024 Cổ Tích Biên Niên - Được viết bởi ánh nến kỹ thuật số.
            </p>
        </div>
    </div>
</footer>

<style>
    /* Hiệu ứng phát sáng lân tinh cho link */
    .footer-link:hover {
        text-shadow: 0 0 8px rgba(61, 43, 31, 0.4), 0 0 12px rgba(255, 255, 255, 0.8);
        letter-spacing: 0.35em;
    }

    /* Hiệu ứng vùng tối mờ ảo của con dấu */
    .seal-active-shadow {
        box-shadow: 0 0 30px 10px rgba(122, 26, 26, 0.2);
    }
</style>

<script>
    // 1. Hiệu ứng Dấu Sáp Phản Ứng (The Interactive Seal)
    const seal = document.getElementById('wax-seal');

    seal.addEventListener('mouseenter', () => {
        gsap.to(seal, {
            rotate: "random(-5, 5)",
            repeat: 3,
            yoyo: true,
            duration: 0.1,
            onComplete: () => gsap.set(seal, {
                className: "+=seal-active-shadow"
            })
        });
    });

    seal.addEventListener('mouseleave', () => {
        gsap.to(seal, {
            rotate: 0,
            duration: 0.5
        });
        seal.classList.remove('seal-active-shadow');
    });

    // 2. Hiệu ứng Responsive Scroll (Slide in với Parallax nhẹ)
    gsap.from(".footer-col-left", {
        scrollTrigger: {
            trigger: "footer",
            start: "top bottom",
            toggleActions: "play none none reverse"
        },
        x: -50,
        opacity: 0,
        duration: 1.2,
        ease: "power2.out"
    });

    gsap.from(".footer-col-right", {
        scrollTrigger: {
            trigger: "footer",
            start: "top bottom",
            toggleActions: "play none none reverse"
        },
        x: 50,
        opacity: 0,
        duration: 1.5, // Tốc độ khác nhau để tạo hiệu ứng chiều sâu
        ease: "power2.out"
    });

    gsap.from(".footer-emblem", {
        scrollTrigger: {
            trigger: "footer",
            start: "top bottom"
        },
        scale: 0,
        opacity: 0,
        duration: 1,
        delay: 0.3,
        ease: "back.out(1.7)"
    });
</script>