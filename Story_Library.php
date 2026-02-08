<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="library-portal" class="relative min-h-screen bg-[#1a120b] overflow-hidden flex flex-col items-center justify-center py-20">

        <div class="absolute inset-0 z-10 pointer-events-none shadow-[inset_0_0_150px_rgba(0,0,0,0.9)] bg-[radial-gradient(circle_at_20%_20%,rgba(184,134,11,0.15)_0%,transparent_50%)]"></div>

        <canvas id="dust-canvas" class="absolute inset-0 z-10 pointer-events-none opacity-40"></canvas>

        <div id="deep-library-bg" class="absolute inset-0 z-0 opacity-20 scale-110 bg-[url('https://www.transparenttextures.com/patterns/dark-wood.png')] bg-repeat">
        </div>

        <div class="container relative z-20 max-w-6xl px-6 flex flex-col md:flex-row items-center justify-between gap-16">

            <div class="w-full md:w-3/5 text-center md:text-left">
                <div id="title-scroll" class="relative p-10 bg-[url('https://www.transparenttextures.com/patterns/parchment.png')] bg-[#f2e8cf] shadow-2xl rounded-sm border-x-8 border-[#3d2b1f]/10">
                    <h1 class="font-gothic text-4xl md:text-6xl text-[#3d2b1f] mb-4 relative overflow-hidden">
                        <span id="ink-title" class="opacity-0">THƯ VIỆN VẠN CUỐN</span>
                    </h1>
                    <p class="font-serif italic text-[#3d2b1f]/70 text-lg leading-relaxed">
                        "Gác lại sự ồn ào của thời đại, bước vào nơi trí tuệ ngủ yên trong từng trang giấy cổ."
                    </p>
                </div>
            </div>

            <div class="w-full md:w-2/5 flex flex-col items-center">
                <div id="card-catalog" class="relative bg-[#3d2b1f] p-8 rounded-sm shadow-[10px_10px_30px_rgba(0,0,0,0.5)] border-t-2 border-white/10 group">
                    <h3 class="text-[#b8860b] font-gothic text-xs tracking-[0.3em] mb-6 text-center">MỤC LỤC THẺ CỔ</h3>

                    <div id="search-drawer" class="relative w-full h-16 bg-[#2a1d15] mb-4 cursor-pointer transition-all duration-500 hover:translate-x-2 border-b-2 border-black/50 shadow-inner overflow-hidden">
                        <div class="absolute inset-0 flex items-center px-4 gap-4 transition-transform duration-500 group-[.drawer-open]:translate-y-[-100%]">
                            <i class="ri-search-line text-[#b8860b] text-xl"></i>
                            <span class="text-[#b8860b]/40 italic text-sm">Kéo để tìm kiếm...</span>
                        </div>

                        <input type="text" id="library-search"
                            class="absolute inset-0 bg-transparent px-4 text-[#f2e8cf] outline-none opacity-0 translate-y-[100%] transition-all duration-500 group-[.drawer-open]:opacity-100 group-[.drawer-open]:translate-y-0"
                            placeholder="Tên sách, tác giả...">
                    </div>

                    <div class="grid grid-cols-2 gap-4 w-full">
                        <button class="drawer-btn bg-[#2a1d15] p-3 text-[10px] text-[#b8860b]/60 border-b-2 border-black/40 hover:text-[#f2e8cf] transition-colors">TRUYỀN THUYẾT</button>
                        <button class="drawer-btn bg-[#2a1d15] p-3 text-[10px] text-[#b8860b]/60 border-b-2 border-black/40 hover:text-[#f2e8cf] transition-colors">DÂN GIAN</button>
                    </div>

                    <div class="absolute top-1/2 -right-2 w-4 h-8 bg-[#b8860b] rounded-sm shadow-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .font-gothic {
            font-family: 'Cinzel Decorative', serif;
        }

        /* Hiệu ứng Mực loang (Ink Spread) */
        .ink-animate {
            animation: inkFlow 3s forwards ease-out;
        }

        @keyframes inkFlow {
            from {
                filter: blur(10px);
                opacity: 0;
                letter-spacing: 10px;
            }

            to {
                filter: blur(0);
                opacity: 1;
                letter-spacing: normal;
            }
        }

        /* Hiệu ứng nút lún (Chạm vào quá khứ) */
        .drawer-btn:active {
            transform: scale(0.95);
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.5);
            filter: brightness(0.8);
        }
    </style>

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
        // 1. Hiệu ứng Mực loang tiêu đề
        setTimeout(() => {
            document.getElementById('ink-title').classList.add('ink-animate');
        }, 500);

        // 2. Tương tác Ngăn kéo tìm kiếm
        const catalog = document.getElementById('card-catalog');
        const searchDrawer = document.getElementById('search-drawer');
        const searchInput = document.getElementById('library-search');

        searchDrawer.addEventListener('click', () => {
            catalog.classList.add('drawer-open');
            searchInput.focus();
            // Giả lập âm thanh gỗ
            console.log("Creak... sliding wood sound");
        });

        // 3. Hiệu ứng Bụi vàng (Dust Motes)
        const canvas = document.getElementById('dust-canvas');
        const ctx = canvas.getContext('2d');
        let motes = [];

        function initMotes() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            for (let i = 0; i < 80; i++) {
                motes.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 1.5,
                    speedX: (Math.random() - 0.5) * 0.2,
                    speedY: Math.random() * 0.3 + 0.1,
                    opacity: Math.random() * 0.5
                });
            }
        }

        function drawMotes() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            motes.forEach(m => {
                m.x += m.speedX;
                m.y += m.speedY;
                if (m.y > canvas.height) m.y = -10;
                ctx.fillStyle = `rgba(184, 134, 11, ${m.opacity})`;
                ctx.beginPath();
                ctx.arc(m.x, m.y, m.size, 0, Math.PI * 2);
                ctx.fill();
            });
            requestAnimationFrame(drawMotes);
        }

        initMotes();
        drawMotes();

        // 4. Parallax Sâu & Mobile Tilt
        window.addEventListener('mousemove', (e) => {
            const moveX = (e.clientX - window.innerWidth / 2) / 50;
            const moveY = (e.clientY - window.innerHeight / 2) / 50;
            gsap.to("#deep-library-bg", {
                x: moveX,
                y: moveY,
                duration: 1
            });
        });

        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (e) => {
                gsap.to("#deep-library-bg", {
                    x: e.gamma * 2,
                    y: e.beta * 2,
                    duration: 1
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