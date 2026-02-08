<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* ----------------------------- Section 1: The Sealed Vault ----------------------------- */
        #sealed-vault {
            background: #050505;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            cursor: none;
            /* Sử dụng đèn pin ảo thay cho chuột */
        }

        /* Tường đá rêu phong */
        .stone-wall {
            position: absolute;
            inset: 0;
            background: url('https://www.transparenttextures.com/patterns/rocky-wall.png'), #1a1a1a;
            opacity: 0.8;
            filter: brightness(0.1);
            /* Rất tối lúc ban đầu */
            transition: filter 1s ease;
        }

        /* Ổ khóa vòng tròn đồng tâm */
        .cryptex-lock {
            position: relative;
            width: 400px;
            height: 400px;
            z-index: 10;
        }

        .stone-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 15px solid #2a2a2a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.8);
            background: rgba(30, 30, 30, 0.5);
        }

        .ring-outer {
            width: 400px;
            height: 400px;
            border-style: double;
        }

        .ring-middle {
            width: 280px;
            height: 280px;
        }

        .ring-inner {
            width: 160px;
            height: 160px;
        }

        /* Ký tự cổ ngữ */
        .rune-char {
            position: absolute;
            font-family: 'Cinzel Decorative', serif;
            color: #444;
            font-size: 1.2rem;
            pointer-events: none;
            transition: color 0.3s;
        }

        .rune-char.active {
            color: #00f2ff;
            text-shadow: 0 0 15px #00f2ff, 0 0 30px #00f2ff;
        }

        /* Hiệu ứng Đèn pin / Lửa xanh */
        .blue-wisp {
            position: fixed;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 242, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 100;
            transform: translate(-50%, -50%);
        }

        /* Mobile: Cryptex focus */
        @media (max-width: 768px) {
            .cryptex-lock {
                transform: scale(0.8);
            }

            .stone-wall {
                filter: brightness(0.2);
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* ----------------------------- Section 2: The Deciphering Altar ----------------------------- */
        #deciphering-altar {
            background: #120f0c;
            min-height: 100vh;
            padding: 80px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* Phiến đá giải mã */
        .decipher-slab {
            background: #2a2a2a;
            background-image: url('https://www.transparenttextures.com/patterns/padded-cells.png');
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8), inset 0 0 100px rgba(0, 0, 0, 0.5);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 900px;
            border: 8px solid #3d3d3d;
        }

        /* Các rãnh trống trên đá */
        .stone-slot {
            width: 60px;
            height: 80px;
            background: rgba(0, 0, 0, 0.4);
            border: 2px inset #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s;
        }

        .stone-slot.hint-drop::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid rgba(0, 242, 255, 0.3);
            animation: ripple 2s infinite;
        }

        @keyframes ripple {
            0% {
                transform: scale(0.5);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* Mảnh đá cổ ngữ (Tiles) */
        .rune-tile {
            width: 50px;
            height: 70px;
            background: #b8a681;
            background-image: url('https://www.transparenttextures.com/patterns/granite.png');
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cinzel Decorative', serif;
            font-size: 1.5rem;
            color: #3d2b1f;
            cursor: grab;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
            user-select: none;
        }

        .rune-tile:active {
            cursor: grabbing;
        }

        /* Bảng tra cứu (Legend) */
        .parchment-legend {
            position: absolute;
            left: 20px;
            top: 100px;
            width: 180px;
            background: #e6d5b8;
            padding: 15px;
            transform: rotate(-2deg);
            font-family: 'Dancing Script', cursive;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
            border-left: 5px solid #7a1a1a;
        }

        /* Mobile: Bàn xoay cổ ngữ */
        @media (max-width: 768px) {
            .decipher-slab {
                padding: 20px;
                gap: 8px;
            }

            .stone-slot {
                width: 45px;
                height: 60px;
            }

            .parchment-legend {
                position: static;
                width: 90%;
                margin-bottom: 20px;
                transform: none;
            }

            .mobile-carousel {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background: #1a120b;
                padding: 20px;
                display: flex;
                gap: 15px;
                overflow-x: auto;
                border-top: 2px solid #b8860b;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="sealed-vault" onmousemove="moveFlashlight(event)">
        <div class="stone-wall" id="main-wall"></div>
        <div class="blue-wisp" id="flashlight"></div>

        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="fog-layer"></div>
        </div>

        <div class="cryptex-lock">
            <div class="stone-ring ring-outer" onclick="rotateRing(this, 45)">
                <span class="rune-char" style="top: 10%; left: 50%;">ᚠ</span>
                <span class="rune-char" style="top: 50%; right: 10%;">ᚦ</span>
                <span class="rune-char" style="bottom: 10%; left: 50%;">ᚨ</span>
                <span class="rune-char" style="top: 50%; left: 10%;">ᚱ</span>
            </div>

            <div class="stone-ring ring-middle" onclick="rotateRing(this, -60)">
                <span class="rune-char" style="top: 15%; left: 50%;">ᚲ</span>
                <span class="rune-char" style="bottom: 15%; left: 50%;">ᚷ</span>
            </div>

            <div class="stone-ring ring-inner" onclick="openVault()">
                <i class="ri-eye-2-line text-2xl text-[#444] hover:text-[#00f2ff] transition-all"></i>
            </div>
        </div>

        <div class="absolute bottom-10 text-[#00f2ff]/30 font-serif italic text-xs tracking-widest">
            "Xoay các vòng đá để căn chỉnh ánh sáng của ngàn năm trước..."
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="deciphering-altar">
        <div class="parchment-legend">
            <h4 class="text-xs uppercase font-bold mb-2">Bản đồ Cổ ngữ</h4>
            <div class="space-y-1 text-sm">
                <p>ᚠ : A (Đã tìm thấy)</p>
                <p>ᚦ : B (Thất lạc...)</p>
                <p class="opacity-30">ᚱ : ?????</p>
            </div>
        </div>

        <h3 class="font-gothic text-[#b8860b] mb-12 tracking-widest text-center">GIẢI MÃ LỜI NGUYỀN</h3>

        <div class="decipher-slab" id="drop-zone">
            <div class="stone-slot" data-answer="ᛗ"></div>
            <div class="stone-slot hint-drop" data-answer="ᚨ"></div>
            <div class="stone-slot" data-answer="ᚷ"></div>
            <div class="stone-slot" data-answer="ᛁ"></div>
            <div class="stone-slot" data-answer="ᚲ"></div>
        </div>

        <div class="mt-16 flex flex-wrap justify-center gap-6" id="tile-source">
            <div class="rune-tile" draggable="true" ondragstart="drag(event)" id="tile1">ᛗ</div>
            <div class="rune-tile" draggable="true" ondragstart="drag(event)" id="tile2">ᚨ</div>
            <div class="rune-tile" draggable="true" ondragstart="drag(event)" id="tile3">ᚷ</div>
            <div class="rune-tile" draggable="true" ondragstart="drag(event)" id="tile4">ᛁ</div>
            <div class="rune-tile" draggable="true" ondragstart="drag(event)" id="tile5">ᚲ</div>
            <div class="rune-tile" draggable="true" ondragstart="drag(event)" id="tile6">ᚦ</div>
        </div>

        <div class="md:hidden mobile-carousel" id="mobile-tray">
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include('footer.php'); ?>
</body>
<script>
    //----------------------------- section 1 ----------------------------- //
    let currentRotations = [0, 0]; // Lưu góc quay của các vòng

    function moveFlashlight(e) {
        const wisp = document.getElementById('flashlight');
        wisp.style.left = e.clientX + 'px';
        wisp.style.top = e.clientY + 'px';

        // Khi đưa đèn gần ổ khóa, tường đá sáng lên một chút
        const wall = document.getElementById('main-wall');
        const dist = Math.hypot(e.clientX - window.innerWidth / 2, e.clientY - window.innerHeight / 2);
        if (dist < 300) {
            wall.style.filter = `brightness(${0.4 - dist/1000})`;
        } else {
            wall.style.filter = 'brightness(0.1)';
        }
    }

    function rotateRing(el, degree) {
        // Tiếng rắc rắc của đá (Giả lập)
        const stoneSound = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_stone_scrape_rough_001.mp3');
        stoneSound.volume = 0.3;
        stoneSound.play();

        // Lấy trạng thái quay hiện tại
        const ringIndex = el.classList.contains('ring-outer') ? 0 : 1;
        currentRotations[ringIndex] += degree;

        gsap.to(el, {
            rotation: currentRotations[ringIndex],
            duration: 0.8,
            ease: "back.out(1.7)",
            onComplete: checkCombination
        });
    }

    function checkCombination() {
        // Giả sử đúng là vòng ngoài quay 90 độ, vòng trong quay -120 độ
        if (currentRotations[0] % 360 === 90 && currentRotations[1] % 360 === -120) {
            document.querySelectorAll('.rune-char').forEach(r => r.classList.add('active'));
            console.log("Mật mã đã khớp!");
        }
    }

    function openVault() {
        // Chỉ cho phép mở khi đã đúng mật mã
        const activeRunes = document.querySelectorAll('.rune-char.active').length;
        if (activeRunes > 0) {
            gsap.to(".stone-ring", {
                scale: 2,
                opacity: 0,
                stagger: 0.1,
                duration: 1.5,
                ease: "power4.in"
            });
            gsap.to("#main-wall", {
                scale: 1.5,
                filter: "brightness(2) white-out",
                duration: 2,
                onComplete: () => {
                    alert("Cánh cửa hầm đã mở. Chào mừng Sứ Giả.");
                    // window.location.href = "Secret_Archive.php";
                }
            });
        }
    }

    // Mobile Gyroscope (Nghiêng máy đổi hướng sáng)
    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', (e) => {
            const wall = document.getElementById('main-wall');
            const x = e.gamma; // Nghiêng trái phải
            const y = e.beta; // Nghiêng trước sau
            wall.style.backgroundPosition = `${x}px ${y}px`;
        });
    }

    // -----------------------------section 2 ----------------------------- //
    // Cấu hình Drag & Drop
    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    document.querySelectorAll('.stone-slot').forEach(slot => {
        slot.addEventListener('dragover', (e) => e.preventDefault());

        slot.addEventListener('drop', function(ev) {
            ev.preventDefault();
            const tileId = ev.dataTransfer.getData("text");
            const tile = document.getElementById(tileId);
            const expectedRune = this.getAttribute('data-answer');

            if (tile.innerText === expectedRune) {
                // Đúng: Snap-to-place
                this.appendChild(tile);
                tile.style.cursor = "default";
                tile.draggable = false;

                // Hiệu ứng ánh sáng vàng
                gsap.to(tile, {
                    backgroundColor: "#ffd700",
                    duration: 0.5
                });
                new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_stone_scrape_rough_001.mp3').play();

                checkWin();
            } else {
                // Sai: Rung lắc đá
                gsap.to(this, {
                    x: 5,
                    repeat: 5,
                    yoyo: true,
                    duration: 0.05,
                    clearProps: "x"
                });
                const errorSound = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-61905/zapsplat_horror_hit_distorted_002.mp3');
                errorSound.volume = 0.2;
                errorSound.play();
            }
        });
    });

    function checkWin() {
        const filled = document.querySelectorAll('.stone-slot .rune-tile').length;
        const total = document.querySelectorAll('.stone-slot').length;

        if (filled === total) {
            // Hiệu ứng Glow of Truth: Biến cổ ngữ thành chữ Latin
            const translation = ["M", "A", "G", "I", "C"];
            document.querySelectorAll('.stone-slot .rune-tile').forEach((tile, i) => {
                gsap.to(tile, {
                    rotationY: 360,
                    duration: 1,
                    delay: i * 0.2,
                    onComplete: () => {
                        tile.innerText = translation[i];
                        tile.style.color = "#fff";
                        tile.style.textShadow = "0 0 10px #00f2ff";
                    }
                });
            });

            setTimeout(() => alert("Lời nguyền đã được hóa giải!"), 2000);
        }
    }

    // Mobile: Lắc để xóa (Gia tốc kế)
    if (typeof DeviceMotionEvent.requestPermission === 'function') {
        // Xử lý quyền trên iOS
    } else {
        window.addEventListener('devicemotion', (e) => {
            const acc = e.accelerationIncludingGravity;
            if (Math.abs(acc.x) > 15 || Math.abs(acc.y) > 15) {
                location.reload(); // Đơn giản là reset lại bàn cờ
            }
        });
    }

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>