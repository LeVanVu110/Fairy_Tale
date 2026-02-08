<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin-top: 100px;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* ----------------------------- Section 1: The Great Unrolling ----------------------------- */
        #explorer-atlas {
            background: #0d0a08;
            /* Màu bóng tối phòng làm việc */
            height: 100vh;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mặt bàn gỗ sồi */
        .oak-table {
            position: absolute;
            inset: 0;
            background: url('https://www.transparenttextures.com/patterns/dark-wood.png'), #1a140f;
            z-index: 1;
        }

        /* Container của bản đồ */
        .map-container {
            position: relative;
            z-index: 10;
            width: 0%;
            /* Khởi đầu là 0 để diễn hoạt mở cuộn */
            height: 80vh;
            background: #d4bc8d;
            background-image: url('https://www.transparenttextures.com/patterns/old-map.png');
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8), inset 0 0 100px rgba(0, 0, 0, 0.2);
            border-left: 20px solid #3d2b1f;
            /* Thanh gỗ trái */
            border-right: 20px solid #3d2b1f;
            /* Thanh gỗ phải */
            display: flex;
            overflow: hidden;
            transition: width 2s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* Rìa bản đồ cháy xém */
        .map-container::before,
        .map-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 10px;
            background: radial-gradient(circle, #ff4500 10%, transparent 70%);
            box-shadow: 0 0 15px #ff4500;
            opacity: 0.5;
            animation: ember-glow 2s infinite alternate;
        }

        .map-container::before {
            left: 0;
        }

        .map-container::after {
            right: 0;
        }

        @keyframes ember-glow {
            from {
                filter: blur(2px) brightness(1);
            }

            to {
                filter: blur(4px) brightness(1.5);
            }
        }

        /* Lớp sương mù (Fog of War) */
        #fog-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            /* Ép chiều rộng hiển thị */
            height: 100%;
            z-index: 20;
            pointer-events: none;
            mix-blend-mode: screen;
        }

        /* Mobile: Cuộn dọc */
        @media (max-width: 768px) {
            .map-container {
                width: 90% !important;
                /* Cố định chiều rộng trên mobile */
                height: 0;
                /* JS sẽ kích hoạt height khi load */
                border-left: none;
                border-right: none;
                /* Chuyển thanh gỗ thành nằm ngang (trên/dưới) */
                border-top: 15px solid #3d2b1f;
                border-bottom: 15px solid #3d2b1f;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* ----------------------------- Section 2: Living Landmarks ----------------------------- */
        .landmark-layer {
            position: absolute;
            inset: 0;
            z-index: 25;
            /* Nằm trên lớp sương mù */
            pointer-events: none;
        }

        .landmark {
            position: absolute;
            pointer-events: auto;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Hiệu ứng hình minh họa vẽ tay */
        .landmark-icon {
            font-size: 3rem;
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.5));
            animation: idle-float 3s infinite alternate ease-in-out;
        }

        @keyframes idle-float {
            from {
                transform: translateY(0) rotate(-2deg);
            }

            to {
                transform: translateY(-10px) rotate(2deg);
            }
        }

        /* Hộp thông tin giấy da (Desktop) */
        .info-card {
            position: absolute;
            top: -120px;
            left: 50%;
            transform: translateX(-50%) scale(0.8);
            width: 200px;
            background: #e6d5b8;
            background-image: url('https://www.transparenttextures.com/patterns/handmade-paper.png');
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
            z-index: 100;
        }

        .landmark:hover .info-card {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) scale(1);
        }

        /* Mobile: Bottom Sheet */
        #bottom-sheet {
            position: fixed;
            bottom: -100%;
            left: 0;
            width: 100%;
            background: #1a140f;
            border-top: 3px solid #b8860b;
            padding: 30px;
            z-index: 1000;
            transition: bottom 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-radius: 20px 20px 0 0;
        }

        #bottom-sheet.active {
            bottom: 0;
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* ----------------------------- Section 3: Navigator's Tools ----------------------------- */

        /* La bàn đồng cổ */
        #navigator-compass {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 150px;
            height: 150px;
            background: url('./assets/image/la_ban.png') no-repeat center;
            background-size: contain;
            z-index: 500;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.5));
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        #compass-needle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 80px;
            background: linear-gradient(to bottom, #7a1a1a 50%, #d4bc8d 50%);
            margin-left: -5px;
            margin-top: -40px;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Vòng tròn hào quang tiến độ */
        .progress-aura {
            position: absolute;
            inset: -10px;
            border: 4px solid transparent;
            border-top-color: #ffaa00;
            border-radius: 50%;
            filter: blur(2px) drop-shadow(0 0 10px #ffaa00);
            transform: rotate(0deg);
            /* JS sẽ update giá trị này */
        }

        /* Thấu kính ma thuật (Magnifying Lens) */
        #magic-lens {
            position: fixed;
            width: 250px;
            height: 250px;
            border: 15px solid #3d2b1f;
            border-radius: 50%;
            pointer-events: none;
            z-index: 400;
            display: none;
            backdrop-filter: brightness(1.2) contrast(1.2) saturate(1.5);
            box-shadow: inset 0 0 50px rgba(255, 255, 255, 0.2), 0 0 30px rgba(0, 0, 0, 0.5);
        }

        #explorer-journal {
            position: fixed;
            bottom: 20px;
            left: 200px;
            /* Nằm cạnh la bàn trên Desktop */
            width: 280px;
            height: 350px;
            background: #e6d5b8;
            background-image: url('https://www.transparenttextures.com/patterns/handmade-paper.png');
            padding: 25px;
            border: 2px solid #3d2b1f;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            z-index: 450;
            transform: translateY(120%);
            /* Ẩn xuống dưới */
            clip-path: polygon(0 0, 100% 2%, 98% 100%, 2% 98%);
            /* Cạnh giấy rách */
        }

        /* Mobile: Đưa sổ vào giữa khi mở */
        @media (max-width: 768px) {
            #explorer-journal {
                left: 5%;
                width: 90%;
                bottom: 130px;
                /* Nằm trên la bàn mobile */
            }
        }

        /* Mobile: Radial Menu */
        @media (max-width: 768px) {
            #navigator-compass {
                left: auto;
                right: 20px;
                bottom: 20px;
                width: 100px;
                height: 100px;
            }

            #navigator-compass.active {
                transform: scale(1.5) rotate(-45deg);
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="explorer-atlas">
        <div class="oak-table"></div>

        <div class="paperweights hidden md:block">
            <div class="absolute top-10 left-10 text-4xl z-30 filter drop-shadow-lg">🗡️</div>
            <div class="absolute bottom-10 right-10 text-4xl z-30 filter drop-shadow-lg animate-pulse">💎</div>
            <div class="absolute top-10 right-10 text-4xl z-30 filter drop-shadow-lg">🧭</div>
        </div>

        <div class="map-container" id="main-map">
            <div class="map-content w-[2000px] h-full relative" id="pan-content">
                <img src="https://img.freepik.com/free-vector/hand-drawn-vintage-map_23-2148780134.jpg"
                    class="absolute inset-0 w-full h-full object-cover opacity-70" alt="World Map">

                <div class="landmark absolute top-1/3 left-1/4 group">
                    <div class="w-4 h-4 bg-red-600 rounded-full animate-ping"></div>
                    <span class="absolute top-6 left-0 text-xs font-bold text-black opacity-0 group-hover:opacity-100 transition-opacity">Đảo Đầu Lâu</span>
                </div>
            </div>

            <canvas id="fog-canvas"></canvas>
        </div>

        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-40 text-[#d4bc8d] font-serif italic text-sm">
            "Di chuyển để xua tan sương mù của quá khứ..."
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <div class="landmark-layer">
        <div class="landmark" style="top: 25%; left: 65%;" onclick="openLandmark('volcano', 'Núi Lửa Cổ Đại', 'Nơi hơi thở của rồng vẫn còn âm ỉ...')">
            <div class="landmark-icon">🌋</div>
            <div class="info-card hidden md:block">
                <h4 class="font-gothic text-red-900 border-b border-red-200">The Ember Peak</h4>
                <p class="text-xs italic mt-2">Dành cho những ai không sợ lửa.</p>
            </div>
        </div>

        <div class="landmark" style="top: 60%; left: 30%;" onclick="openLandmark('harbor', 'Bến Cảng Sương Mù', 'Tiếng chuông tàu vang vọng trong đêm.')">
            <div class="landmark-icon">⛵</div>
            <div class="info-card hidden md:block">
                <h4 class="font-gothic text-blue-900 border-b border-blue-200">The Lost Port</h4>
                <p class="text-xs italic mt-2">Chuyến tàu không bao giờ trở lại.</p>
            </div>
        </div>
    </div>

    <div id="bottom-sheet">
        <div class="w-12 h-1.5 bg-gray-600 rounded-full mx-auto mb-6"></div>
        <h3 id="sheet-title" class="font-gothic text-[#b8860b] text-2xl mb-2"></h3>
        <p id="sheet-desc" class="text-[#d4bc8d] italic mb-8"></p>
        <button class="w-full py-4 bg-[#b8860b] text-black font-bold tracking-widest uppercase rounded">
            Bắt đầu hành trình
        </button>
    </div>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <div id="magic-lens"></div>

    <div id="navigator-compass" onclick="toggleJournal()">
        <div class="progress-aura" id="discovery-progress"></div>
        <div id="compass-needle"></div>

        <div class="radial-menu hidden">
            <button onclick="teleportTo('harbor')" class="btn-tp" style="--i:1">⚓</button>
            <button onclick="teleportTo('volcano')" class="btn-tp" style="--i:2">🔥</button>
            <button onclick="teleportTo('castle')" class="btn-tp" style="--i:3">🏰</button>
        </div>
    </div>

    <div id="explorer-journal" class="fixed bottom-10 left-[200px] w-64 h-80 bg-[#e6d5b8] shadow-2xl translate-y-[120%] transition-transform duration-500 z-[450] p-6 font-serif overflow-y-auto">
        <div class="border-b border-[#3d2b1f] mb-4 pb-2 font-bold text-[#3d2b1f]">NHẬT KÝ VIỄN THÁM</div>
        <ul class="space-y-4 text-sm" id="journal-list">
            <li class="cursor-pointer hover:text-red-800 transition-colors" dblclick="teleportTo('volcano')">
                📖 Núi Lửa Cổ Đại <span class="text-green-600 ml-2">✓</span>
            </li>
            <li class="opacity-50 italic">??? - Chưa khám phá</li>
        </ul>
    </div>

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    // ----------------------------- LOGIC BẢN ĐỒ VIỄN THÁM -----------------------------

    const mapContainer = document.getElementById('main-map');
    const canvas = document.getElementById('fog-canvas');
    const ctx = canvas.getContext('2d');

    // 1. Hiệu ứng Unrolling (Mở cuộn) khi tải trang
    window.addEventListener('load', () => {
        if (window.innerWidth > 768) {
            mapContainer.style.width = '85%';
        } else {
            mapContainer.style.height = '80%';
        }

        // Phát âm thanh mở giấy da
        const audio = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_paper_parchment_crumple_001.mp3');
        audio.volume = 0.5;
        audio.play();

        // Đợi hiệu ứng mở cuộn (transition 2s) hoàn tất rồi mới vẽ sương mù
        setTimeout(() => {
            resizeAndInitFog();
        }, 2100);
    });

    // 2. Hàm định dạng lại kích thước Canvas chuẩn theo Container
    function resizeAndInitFog() {
        // Lấy kích thước thực tế mà Container đang hiển thị
        canvas.width = mapContainer.clientWidth;
        canvas.height = mapContainer.clientHeight;

        // Vẽ lớp sương mù ban đầu
        ctx.fillStyle = 'rgba(200, 200, 200, 0.7)'; // Màu mây xám nhạt
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    // 3. Cơ chế Xóa mây (Hỗ trợ cả Mouse và Touch)
    function eraseFog(e) {
        const rect = canvas.getBoundingClientRect();
        let x, y;

        if (e.touches) {
            // Dành cho Mobile
            x = e.touches[0].clientX - rect.left;
            y = e.touches[0].clientY - rect.top;
        } else {
            // Dành cho Desktop
            x = e.clientX - rect.left;
            y = e.clientY - rect.top;
        }

        // Thiết lập chế độ "Xóa"
        ctx.globalCompositeOperation = 'destination-out';
        ctx.beginPath();
        ctx.arc(x, y, 60, 0, Math.PI * 2); // Bán kính xóa 60px
        ctx.fill();
    }

    // Lắng nghe sự kiện di chuyển
    mapContainer.addEventListener('mousemove', eraseFog);
    mapContainer.addEventListener('touchmove', (e) => {
        eraseFog(e);
        e.preventDefault(); // Ngăn việc cuộn trang khi đang xóa mây trên mobile
    }, {
        passive: false
    });

    // 4. Gyroscope Parallax (Nghiêng điện thoại để di chuyển góc nhìn)
    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', (e) => {
            const content = document.getElementById('pan-content');
            if (!content) return;

            const xMove = e.gamma / 15; // Nghiêng trái phải
            const yMove = e.beta / 15; // Nghiêng trước sau

            gsap.to(content, {
                x: -xMove * 30,
                y: -yMove * 30,
                duration: 0.6,
                ease: "power1.out"
            });
        });
    }

    // 5. Cập nhật lại nếu người dùng thay đổi kích thước trình duyệt
    window.addEventListener('resize', () => {
        // Debounce hoặc delay nhẹ để chờ trình duyệt ổn định kích thước mới
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(resizeAndInitFog, 300);
    });

    // -----------------------------section 2 ----------------------------- //
    // Quản lý âm thanh môi trường
    const ambientSounds = {
        volcano: new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_fire_ignite_large_gas_001.mp3'),
        harbor: new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-four-line/zapsplat_nature_ocean_waves_gentle_001.mp3')
    };

    let currentSound = null;

    function openLandmark(id, title, desc) {
        // 1. Hiệu ứng Haptic cho Mobile
        if (window.navigator.vibrate) window.navigator.vibrate(40);

        // 2. Chuyển đổi âm thanh
        if (currentSound) {
            gsap.to(currentSound, {
                volume: 0,
                duration: 1,
                onComplete: () => currentSound.pause()
            });
        }
        currentSound = ambientSounds[id];
        if (currentSound) {
            currentSound.volume = 0;
            currentSound.play();
            gsap.to(currentSound, {
                volume: 0.3,
                duration: 1
            });
        }

        // 3. Hiệu ứng Focus bản đồ
        gsap.to(".map-content", {
            scale: 1.5,
            filter: "blur(2px)",
            duration: 1,
            ease: "power2.inOut"
        });

        // 4. Hiển thị thông tin
        if (window.innerWidth <= 768) {
            document.getElementById('sheet-title').innerText = title;
            document.getElementById('sheet-desc').innerText = desc;
            document.getElementById('bottom-sheet').classList.add('active');
        } else {
            // Trên Desktop có thể mở một Modal hoặc Side Panel khác
            alert("Đang thám hiểm: " + title);
        }
    }

    // Đóng bottom sheet khi chạm ra ngoài
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.landmark') && !e.target.closest('#bottom-sheet')) {
            document.getElementById('bottom-sheet').classList.remove('active');
            gsap.to(".map-content", {
                scale: 1,
                filter: "blur(0px)",
                duration: 1
            });
            if (currentSound) gsap.to(currentSound, {
                volume: 0,
                duration: 1,
                onComplete: () => currentSound.pause()
            });
        }
    });

    //----------------------------- section 3 ----------------------------- //
    // 1. Hiệu ứng Sonar Pulse: Phát sóng âm tìm bí mật
    setInterval(() => {
        const pulse = document.createElement('div');
        pulse.className = 'fixed rounded-full border-2 border-orange-500/30 pointer-events-none z-[100]';
        pulse.style.left = '105px';
        pulse.style.bottom = '105px'; // Tâm la bàn
        document.body.appendChild(pulse);

        gsap.fromTo(pulse, {
            width: 0,
            height: 0,
            opacity: 0.8
        }, {
            width: 3000,
            height: 3000,
            opacity: 0,
            duration: 3,
            ease: "power1.out",
            onComplete: () => pulse.remove()
        });

        // Tiếng chuông nhỏ khi sóng quét qua (âm lượng cực thấp)
        const bell = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_crystal_glass_ping_001.mp3');
        bell.volume = 0.05;
        bell.play();
    }, 30000);

    // 2. Dịch chuyển tức thời (Teleport)
    function teleportTo(targetId) {
        const targets = {
            volcano: {
                x: -800,
                y: -200
            }, // Tọa độ trên map lớn
            harbor: {
                x: -200,
                y: -600
            }
        };

        const content = document.getElementById('pan-content');

        // Hiệu ứng Motion Blur khi di chuyển nhanh
        gsap.to(content, {
            filter: "blur(10px) brightness(1.5)",
            duration: 0.2
        });

        gsap.to(content, {
            x: targets[targetId].x,
            y: targets[targetId].y,
            duration: 1.5,
            delay: 0.2,
            ease: "expo.inOut",
            onComplete: () => gsap.to(content, {
                filter: "blur(0px) brightness(1)",
                duration: 0.5
            })
        });
    }

    // 3. Kim la bàn chỉ hướng "Bí mật"
    document.addEventListener('mousemove', (e) => {
        const needle = document.getElementById('compass-needle');
        // Giả lập kim luôn hướng về một điểm bí mật chưa mở
        const secretPoint = {
            x: 500,
            y: 500
        };
        const angle = Math.atan2(secretPoint.y - e.pageY, secretPoint.x - e.pageX) * 180 / Math.PI;

        gsap.to(needle, {
            rotation: angle + 90,
            duration: 0.5
        });
    });

    // 4. Thấu kính ma thuật theo chuột
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Shift') {
            const lens = document.getElementById('magic-lens');
            lens.style.display = 'block';
            document.addEventListener('mousemove', moveLens);
        }
    });

    document.addEventListener('keyup', (e) => {
        if (e.key === 'Shift') {
            document.getElementById('magic-lens').style.display = 'none';
            document.removeEventListener('mousemove', moveLens);
        }
    });

    function moveLens(e) {
        const lens = document.getElementById('magic-lens');
        gsap.to(lens, {
            left: e.clientX - 125,
            top: e.clientY - 125,
            duration: 0.1
        });
    }

    function toggleJournal() {
        const journal = document.getElementById('explorer-journal');
        const compass = document.getElementById('navigator-compass');

        // Kiểm tra trạng thái hiện tại bằng class hoặc style
        if (journal.style.transform === 'translateY(0%)') {
            // Đóng sổ
            gsap.to(journal, {
                translateY: '120%',
                duration: 0.6,
                ease: "power4.in"
            });
            compass.classList.remove('active');

            // Tiếng đóng sách
            new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_book_close_001.mp3').play();
        } else {
            // Mở sổ
            gsap.to(journal, {
                translateY: '0%',
                duration: 0.8,
                ease: "back.out(1.2)"
            });
            compass.classList.add('active');

            // Tiếng lật giấy da
            new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_paper_parchment_crumple_001.mp3').play();
        }

        // Hiệu ứng rung phản hồi (Haptic)
        if (window.navigator.vibrate) window.navigator.vibrate(20);
    }

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>