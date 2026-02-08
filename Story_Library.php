<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
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

        /* ----------------------------- section 2 ----------------------------- */
        #hall-of-whispers {
            perspective: 1000px;
        }

        /* Kệ gỗ */
        .wooden-shelf {
            background: #3d2b1f;
            height: 12px;
            width: 100%;
            position: relative;
            border-radius: 2px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5), inset 0 2px 2px rgba(255, 255, 255, 0.1);
            margin-bottom: 8rem;
        }

        /* Container chứa sách trên kệ */
        .books-row {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 2px;
            transform-style: preserve-3d;
        }

        /* Cấu trúc một cuốn sách */
        .book-item {
            position: relative;
            margin: 0 2px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-origin: bottom center;
            cursor: pointer;
        }

        /* Gáy sách */
        .book-spine {
            background: var(--book-color, #7a1a1a);
            width: var(--book-width, 30px);
            height: var(--book-height, 180px);
            border-radius: 2px 2px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Chữ in vàng kim trên gáy */
        .spine-title {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            color: rgba(184, 134, 11, 0.8);
            font-family: 'Cinzel Decorative', serif;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            /* Hiệu ứng Metallic quét qua */
            background: linear-gradient(120deg, transparent 30%, rgba(255, 255, 255, 0.4) 50%, transparent 70%);
            background-size: 200% 100%;
            background-clip: text;
            -webkit-background-clip: text;
        }

        .book-item:hover .spine-title {
            animation: goldSweep 1.5s infinite;
        }

        @keyframes goldSweep {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Hiệu ứng rút sách ra */
        .book-item:hover {
            transform: translateZ(50px) scale(1.1);
            margin: 0 15px;
            /* Dạt các cuốn bên cạnh */
            z-index: 50;
        }

        /* Teaser hiện ra khi hover lâu */
        .book-teaser {
            position: absolute;
            left: 100%;
            bottom: 20%;
            width: 200px;
            padding: 15px;
            background: rgba(253, 251, 247, 0.95);
            border-left: 3px solid #b8860b;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s 0.3s;
            font-size: 12px;
            font-style: italic;
            box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.2);
        }

        .book-item:hover .book-teaser {
            opacity: 1;
        }

        /* Mobile: Kệ đơn tập trung */
        @media (max-width: 768px) {
            .books-row {
                overflow-x: auto;
                justify-content: flex-start;
                padding: 20px;
            }

            .book-item {
                transform: scale(0.9);
            }

            .book-item.center-focus {
                transform: scale(1.1) translateY(-10px);
                z-index: 50;
            }
        }

        /* ----------------------------- section 3 ----------------------------- */
        /* ----------------------------- section 3: The Sanctuary ----------------------------- */
        #secret-nook {
            background: #0f0a06;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            /* Đảm bảo luôn đủ chiều cao */
            display: flex;
            align-items: center;
            z-index: 1;
        }

        /* Hiệu ứng Spotlight */
        .spotlight-overlay {
            position: absolute;
            inset: 0;
            /* Spotlight tập trung hơn */
            background: radial-gradient(circle at var(--light-x, 50%) var(--light-y, 50%),
                    transparent 5%,
                    rgba(0, 0, 0, 0.95) 35%);
            pointer-events: none;
            /* Quan trọng: Để có thể click xuyên qua lớp đen */
            z-index: 5;
        }

        /* Sửa lỗi chồng sách bị quá khít */
        .manuscript-stack {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: -40px;
            perspective: 1500px;
            /* Giảm độ chồng lấp để dễ nhìn hơn */
        }

        /* Đảm bảo nội dung nằm trên Spotlight */
        #secret-nook .container {
            position: relative;
            z-index: 20;
        }

        /* Ánh nến bập bùng */
        /* Ánh nến bập bùng */
        .candle-glow {
            position: absolute;
            width: 8px;
            height: 15px;
            background: #ffa500;
            border-radius: 50% 50% 20% 20%;
            filter: blur(2px);
            box-shadow: 0 0 15px #ff4500, 0 0 30px #ff8c00;
            animation: flicker 0.2s infinite alternate;
        }

        @keyframes flicker {
            0% {
                transform: scale(1) opacity(0.8) rotate(-2deg);
            }

            100% {
                transform: scale(1.1) opacity(1) rotate(2deg);
                filter: blur(4px);
            }
        }

        .manuscript-card {
            background: #f2e8cf;
            border-left: 10px solid #5a1414;
            box-shadow: -10px 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
            transform: rotateX(5deg);
            margin-bottom: -120px;
            /* Tạo hiệu ứng xếp lớp */
        }

        .manuscript-card:hover {
            transform: rotateY(-10deg) translateZ(30px) translateY(-20px);
            z-index: 100;
            margin-bottom: 20px;
            /* Đẩy các cuốn khác ra khi hover */
        }

        /* Hiệu ứng khói mực */
        .ink-spirit {
            position: absolute;
            bottom: 120%;
            left: 50%;
            width: 150px;
            height: 200px;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.15) 0%, transparent 70%);
            filter: blur(20px);
            opacity: 0;
            pointer-events: none;
            transition: all 1.5s ease;
            transform: translateX(-50%) translateY(20px);
        }

        .inkwell-container:hover .ink-spirit {
            opacity: 1;
            transform: translateX(-50%) translateY(-30px) scale(1.2);
        }

        /* Con dấu sáp (Wax Seals) */
        .wax-seal-btn {
            width: 65px;
            height: 65px;
            background: #7a1a1a;
            border-radius: 50%;
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.6), 4px 4px 10px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f2e8cf;
            border: 3px solid #5a1414;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .wax-seal-btn:active {
            transform: scale(0.9);
        }

        @media (max-width: 768px) {
            .manuscript-card {
                width: 100% !important;
                margin-bottom: 2rem;
                margin-left: 0;
            }

            .spotlight-overlay {
                background: radial-gradient(circle at center, transparent 20%, rgba(0, 0, 0, 0.85) 60%);
            }
        }

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

    <!-- ----------------------------- section 2 -----------------------------  -->
    <!-- <section id="hall-of-whispers" class="py-24 bg-[#1a120b]">
        <div class="container mx-auto px-4">

            <div class="shelf-category mb-20">
                <h2 class="font-gothic text-[#b8860b] text-xl mb-4 ml-10 opacity-60 tracking-[0.4em]">SINH VẬT HUYỀN BÍ</h2>

                <div class="books-row">
                    <div class="book-item" style="--book-color: #4a0e0e; --book-height: 200px; --book-width: 35px;">
                        <div class="book-spine">
                            <span class="spine-title">Kỳ Lân Truyện</span>
                        </div>
                        <div class="book-teaser">
                            <h4 class="font-bold mb-1">Kỳ Lân Truyện</h4>
                            <p>Hành trình tìm kiếm sinh vật mang máu bạc trong rừng thẳm...</p>
                        </div>
                    </div>

                    <div class="book-item" style="--book-color: #1e2d24; --book-height: 185px; --book-width: 40px; transform: rotate(-3deg);">
                        <div class="book-spine">
                            <span class="spine-title">Bách Thú Quy</span>
                        </div>
                        <div class="book-teaser">
                            <h4 class="font-bold mb-1">Bách Thú Quy</h4>
                            <p>Vạn vật hữu linh, ghi chép về các linh thú từ thời hồng hoang.</p>
                        </div>
                    </div>

                    <div class="book-item" style="--book-color: #2c3e50; --book-height: 195px; --book-width: 32px;">
                        <div class="book-spine"><span class="spine-title">Long Tộc Ký</span></div>
                    </div>
                    <div class="book-item" style="--book-color: #5d4037; --book-height: 210px; --book-width: 45px; transform: rotate(2deg);">
                        <div class="book-spine"><span class="spine-title">Hỏa Phượng Hoàng</span></div>
                    </div>
                </div>
                <div class="wooden-shelf"></div>
            </div>

            <div class="shelf-category mb-20">
                <h2 class="font-gothic text-[#b8860b] text-xl mb-4 ml-10 opacity-60 tracking-[0.4em]">DÂN GIAN THẾ GIỚI</h2>
                <div class="books-row">
                    <div class="book-item" style="--book-color: #3e2723; --book-height: 180px; --book-width: 38px;">
                        <div class="book-spine"><span class="spine-title">Cổ Tích Grimm</span></div>
                    </div>
                </div>
                <div class="wooden-shelf"></div>
            </div>

        </div>
    </section> -->
    <section id="hall-of-whispers" class="py-24 bg-[#1a120b]">
        <div class="container mx-auto px-4">

            <div class="shelf-category mb-20">
                <h2 class="font-gothic text-[#b8860b] text-xl mb-4 ml-10 opacity-60 tracking-[0.4em]">SINH VẬT HUYỀN BÍ</h2>

                <div class="books-row">
                    <a href="Detail_Story_Library.php?id=ky-lan-truyen" class="book-item" style="--book-color: #4a0e0e; --book-height: 200px; --book-width: 35px;">
                        <div class="book-spine">
                            <span class="spine-title">Kỳ Lân Truyện</span>
                        </div>
                        <div class="book-teaser">
                            <h4 class="font-bold mb-1">Kỳ Lân Truyện</h4>
                            <p>Hành trình tìm kiếm sinh vật mang máu bạc trong rừng thẳm...</p>
                        </div>
                    </a>

                    <a href="Detail_Story_Library.php?id=bach-thu-quy" class="book-item" style="--book-color: #1e2d24; --book-height: 185px; --book-width: 40px; transform: rotate(-3deg);">
                        <div class="book-spine">
                            <span class="spine-title">Bách Thú Quy</span>
                        </div>
                        <div class="book-teaser">
                            <h4 class="font-bold mb-1">Bách Thú Quy</h4>
                            <p>Vạn vật hữu linh, ghi chép về các linh thú từ thời hồng hoang.</p>
                        </div>
                    </a>

                    <a href="Detail_Story_Library.php?id=long-toc-ky" class="book-item" style="--book-color: #2c3e50; --book-height: 195px; --book-width: 32px;">
                        <div class="book-spine"><span class="spine-title">Long Tộc Ký</span></div>
                    </a>

                    <a href="Detail_Story_Library.php?id=hoa-phuong-hoang" class="book-item" style="--book-color: #5d4037; --book-height: 210px; --book-width: 45px; transform: rotate(2deg);">
                        <div class="book-spine"><span class="spine-title">Hỏa Phượng Hoàng</span></div>
                    </a>
                </div>
                <div class="wooden-shelf"></div>
            </div>

            <div class="shelf-category mb-20">
                <h2 class="font-gothic text-[#b8860b] text-xl mb-4 ml-10 opacity-60 tracking-[0.4em]">DÂN GIAN THẾ GIỚI</h2>
                <div class="books-row">
                    <a href="Detail_Story_Library.php?id=grimm" class="book-item" style="--book-color: #3e2723; --book-height: 180px; --book-width: 38px;">
                        <div class="book-spine"><span class="spine-title">Cổ Tích Grimm</span></div>
                    </a>
                </div>
                <div class="wooden-shelf"></div>
            </div>

        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="secret-nook">
        <div class="spotlight-overlay" id="spotlight-layer"></div>

        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-20">

                <div class="w-full md:w-1/2 flex flex-col items-center md:items-start">
                    <h3 class="font-gothic text-[#b8860b] text-xs mb-10 tracking-[0.4em] opacity-40 uppercase mt-5">Bản thảo dang dở</h3>

                    <div class="manuscript-stack w-full flex flex-col items-center md:items-start">

                        <div class="manuscript-card w-full max-w-[300px] h-80 p-8 flex flex-col justify-between" data-story="so-dua">
                            <div class="absolute -top-3 right-8 w-5 h-20 bg-[#7a1a1a] shadow-lg"></div>
                            <div class="h-1 bg-[#7a1a1a]/20 w-full mb-4"></div>
                            <h4 class="font-bold text-[#3d2b1f] text-xl">Sọ Dừa (18xx)</h4>
                            <p class="text-xs italic text-[#3d2b1f]/70">"Trang 42 - Người mẹ uống nước trong cái sọ dừa bên gốc cây..."</p>
                            <button class="text-[10px] font-bold text-[#7a1a1a] border-b border-[#7a1a1a]/30 w-fit">TIẾP TỤC</button>
                        </div>

                        <div class="manuscript-card w-full max-w-[300px] h-80 p-8 flex flex-col justify-between ms-5" data-story="ho-thien-nga">
                            <h4 class="font-bold text-[#3d2b1f] text-xl">Hồ Thiên Nga</h4>
                            <p class="text-xs italic text-[#3d2b1f]/70">Gợi ý: Phiên bản cổ chưa qua chỉnh lý.</p>
                            <button class="text-[10px] font-bold text-[#7a1a1a] border-b border-[#7a1a1a]/30 w-fit">MỞ KHÓA</button>
                        </div>
                        <div class="manuscript-card w-full max-w-[300px] h-80 p-8 flex flex-col justify-between ms-9" data-story="tam-cam">
                            <h4 class="font-bold text-[#3d2b1f] text-xl">Tấm Cám</h4>
                            <p class="text-xs italic text-[#3d2b1f]/70">Gợi ý: Phiên bản cổ chưa qua chỉnh lý.</p>
                            <button class="text-[10px] font-bold text-[#7a1a1a] border-b border-[#7a1a1a]/30 w-fit">MỞ KHÓA</button>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 flex flex-col items-center">
                    <div class="relative mb-12">
                        <i class="ri-ink-bottle-line text-9xl text-[#b8860b]/20"></i>
                        <div class="candle-glow top-0 right-0"></div>
                    </div>

                    <div class="bg-[#f2e8cf] p-8 shadow-2xl -rotate-2 border-l-4 border-[#3d2b1f]/20 max-w-sm">
                        <p class="font-serif italic text-sm text-[#3d2b1f] leading-relaxed">
                            "Nơi này dành cho những kẻ lữ hành biết dừng chân. Hãy chọn một bản thảo để tâm hồn được tĩnh tại."
                        </p>
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
    document.addEventListener('DOMContentLoaded', function() {
        const books = document.querySelectorAll('.book-item');

        // 1. Hiệu ứng âm thanh khi lướt (Optional)
        books.forEach(book => {
            book.addEventListener('mouseenter', () => {
                // Giả lập tiếng sột soạt nhẹ
                const audio = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-61905/zapsplat_leisure_game_board_game_piece_slide_wood_surface_001_62410.mp3');
                audio.volume = 0.1;
                audio.play().catch(() => {}); // Tránh lỗi trình duyệt chặn auto-play
            });

            // Đánh dấu đã đọc
            book.addEventListener('click', () => {
                book.classList.add('visited');
                book.style.filter = "brightness(1.2)";
            });
        });

        // 2. Mobile Center Focus
        if (window.innerWidth < 768) {
            const observerOptions = {
                root: null,
                threshold: 0.5,
                rootMargin: "0px -40% 0px -40%"
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('center-focus');
                    } else {
                        entry.target.classList.remove('center-focus');
                    }
                });
            }, observerOptions);

            books.forEach(book => observer.observe(book));
        }
    });

    //----------------------------- section 3 ----------------------------- //
    // ----------------------------- logic section 3 ----------------------------- //
    document.querySelector('#secret-nook').addEventListener('mousemove', (e) => {
        const section = e.currentTarget;
        const spotlight = document.getElementById('spotlight-layer');
        const rect = section.getBoundingClientRect();

        // Tính toán chuẩn xác vị trí tương đối
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;

        // Sử dụng GSAP để mượt hơn thay vì gán trực tiếp
        gsap.to(spotlight, {
            "--light-x": `${x}%`,
            "--light-y": `${y}%`,
            duration: 0.3,
            ease: "power1.out"
        });
    });

    // Hiệu ứng "Thổi nến" trên Mobile
    let isNookDark = false;

    function toggleNookLight() {
        const glow = document.querySelector('.candle-glow');
        const spotlight = document.getElementById('spotlight-layer');

        if (!isNookDark) {
            gsap.to(glow, {
                opacity: 0,
                duration: 0.3
            });
            gsap.to(spotlight, {
                background: "radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.98) 30%)",
                duration: 1
            });
            console.log("Ngọn nến đã tắt. Những bản thảo cấm đang hiện ra...");
        } else {
            gsap.to(glow, {
                opacity: 1,
                duration: 0.3
            });
            spotlight.style.background = "";
        }
        isNookDark = !isNookDark;
    }

    // Hiệu ứng lật trang và chuyển hướng thực tế
    document.querySelectorAll('.manuscript-card').forEach(card => {
        card.addEventListener('click', function() {
            // Lấy ID truyện từ data-story
            const storyId = this.getAttribute('data-story') || 'default';

            // Hiệu ứng GSAP: Lật trang + Phóng to
            gsap.to(this, {
                rotationY: -110, // Lật sâu hơn một chút
                x: -200,
                scale: 1.5,
                opacity: 0,
                duration: 1,
                ease: "power2.inOut",
                onStart: () => {
                    // Có thể thêm hiệu ứng tối dần toàn màn hình ở đây
                    document.body.style.pointerEvents = "none"; // Chặn click đúp
                },
                onComplete: () => {
                    // Chuyển hướng sang trang chi tiết với tham số id
                    window.location.href = `Detail_Story_Library.php?id=${storyId}`;
                }
            });
        });
    });

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>