<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* Hiệu ứng Bụi vàng quét qua khi load */
        @keyframes goldenScan {
            0% {
                left: -100%;
                opacity: 0;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                left: 100%;
                opacity: 0;
            }
        }

        #map-container::after {
            content: '';
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(184, 134, 11, 0.2), transparent);
            animation: goldenScan 3s ease-in-out infinite;
            pointer-events: none;
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
    <section id="explorer-desk" class="relative min-h-screen bg-[#1a120b] overflow-hidden flex items-center justify-center py-20 mt-12">

        <div class="absolute inset-0 z-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/dark-wood.png')]"></div>

        <div class="relative z-10 w-full max-w-[1400px] h-[80vh] flex items-center justify-center px-4">

            <div id="magic-lens-tool" class="hidden md:flex absolute left-10 top-1/4 z-30 flex-col items-center gap-4">
                <div class="w-16 h-16 rounded-full border-4 border-[#b8860b] flex items-center justify-center bg-[#fcfaf5]/10 cursor-pointer shadow-lg hover:scale-110 transition-transform">
                    <i class="ri-search-eye-line text-[#b8860b] text-3xl"></i>
                </div>
                <span class="font-gothic text-[#b8860b] text-xs tracking-widest uppercase">Tìm vùng đất</span>
            </div>

            <div id="filter-scroll" class="hidden md:block absolute right-10 top-1/4 z-30">
                <div class="bg-[#fdfbf7] p-6 shadow-2xl border-l-4 border-[#b8860b] relative w-48 transition-all hover:w-56">
                    <h4 class="font-gothic text-sm mb-4 border-b border-[#3d2b1f]/20 pb-2">Biên niên sử</h4>
                    <ul class="space-y-3 text-xs italic">
                        <li class="hover:text-[#7a1a1a] cursor-pointer"><i class="ri-map-pin-line mr-2"></i>Châu Âu cổ</li>
                        <li class="hover:text-[#7a1a1a] cursor-pointer"><i class="ri-map-pin-line mr-2"></i>Viễn Đông</li>
                        <li class="hover:text-[#7a1a1a] cursor-pointer"><i class="ri-map-pin-line mr-2"></i>Vùng đất hứa</li>
                    </ul>
                </div>
            </div>

            <div id="map-container" class="relative w-full h-full bg-[#f2e8cf] shadow-[0_0_100px_rgba(0,0,0,0.5)] border-[12px] border-[#3d2b1f] overflow-hidden group">
                <div id="ancient-map" class="absolute inset-0 bg-[url('https://png.pngtree.com/thumb_back/fh260/background/20240819/pngtree-vintage-world-map-on-grunge-paper-texture-image_16170179.jpg')] bg-cover bg-center grayscale sepia-[0.5] transition-transform duration-500 ease-out">

                    <div class="absolute top-1/3 left-1/4 w-10 h-10 flex items-center justify-center group/marker">
                        <div class="absolute w-12 h-12 bg-transparent cursor-pointer rounded-full z-10"></div> <i class="ri-map-pin-fill text-[#7a1a1a] text-2xl relative z-0 transition-transform group-hover/marker:scale-125"></i>
                    </div>
                </div>

                <div id="lens-overlay" class="pointer-events-none absolute inset-0 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    style="background: radial-gradient(circle 150px at var(--mouse-x) var(--mouse-y), transparent 95%, rgba(0,0,0,0.4) 100%);">
                </div>
            </div>

            <div id="compass" class="absolute bottom-6 right-10 z-40 w-24 h-24 md:w-32 md:h-32">
                <img src="https://cdn-icons-png.flaticon.com/512/854/854866.png" class="w-full h-full object-contain opacity-80" id="compass-needle">
            </div>

        </div>

        <div class="md:hidden fixed bottom-6 left-0 right-0 z-50 flex justify-between px-10 pointer-events-none">
            <button class="w-14 h-14 bg-[#b8860b] rounded-full shadow-xl pointer-events-auto text-white"><i class="ri-search-2-line text-xl"></i></button>
            <button class="w-14 h-14 bg-[#3d2b1f] rounded-full shadow-xl pointer-events-auto text-white"><i class="ri-filter-3-line text-xl"></i></button>
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
    window.addEventListener('load', function() {
        const mapContainer = document.getElementById('map-container');
        const map = document.getElementById('ancient-map');
        const lens = document.getElementById('lens-overlay');
        const compass = document.getElementById('compass-needle');

        // 1. Hiệu ứng Kính lúp ma thuật
        mapContainer.addEventListener('mousemove', (e) => {
            const rect = mapContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Cập nhật vị trí Mask CSS
            lens.style.setProperty('--mouse-x', `${x}px`);
            lens.style.setProperty('--mouse-y', `${y}px`);

            // 2. Hiệu ứng Gió phương Nam (3D Tilt)
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            gsap.to(mapContainer, {
                rotationX: rotateX,
                rotationY: rotateY,
                duration: 0.5,
                ease: "power2.out"
            });

            // 3. Kim la bàn xoay theo chuột
            const angle = Math.atan2(y - centerY, x - centerX) * (180 / Math.PI);
            gsap.to(compass, {
                rotation: angle + 90,
                duration: 0.3
            });
        });

        // Reset khi chuột rời đi
        mapContainer.addEventListener('mouseleave', () => {
            gsap.to(mapContainer, {
                rotationX: 0,
                rotationY: 0,
                duration: 1
            });
        });

        // 4. Onboarding: Ánh sáng quét khi vào trang
        gsap.from("#map-container", {
            scale: 0.8,
            opacity: 0,
            duration: 2,
            ease: "expo.out"
        });
    });

    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>