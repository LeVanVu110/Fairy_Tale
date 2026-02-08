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

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>