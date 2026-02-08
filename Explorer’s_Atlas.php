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

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>