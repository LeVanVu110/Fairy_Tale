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
        /* ----------------------------- Alchemist's Study Style ----------------------------- */
        #alchemist-study {
            background: #0d0d0d;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Mặt bàn gỗ mun */
        .ritual-table {
            position: absolute;
            inset: 0;
            background: url('https://www.transparenttextures.com/patterns/dark-wood.png'), #0a0a0a;
            opacity: 0.8;
            z-index: 1;
        }

        /* Giấy da cổ */
        .summoning-parchment {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 700px;
            background: #e6d5b8;
            background-image: url('https://www.transparenttextures.com/patterns/handmade-paper.png');
            padding: 60px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.9), 20px 20px 0 rgba(0, 0, 0, 0.2);
            clip-path: polygon(2% 2%, 97% 0%, 100% 98%, 1% 100%, 0% 50%);
            /* Xé cạnh */
            transform: rotate(-1deg);
        }

        /* Ô nhập liệu kiểu "thấm mực" */
        .alchemy-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(61, 43, 31, 0.2);
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            color: #1a1a1a;
            padding: 10px 0;
            margin-bottom: 30px;
            outline: none;
            transition: all 0.5s;
        }

        .alchemy-input::placeholder {
            color: rgba(61, 43, 31, 0.4);
            font-style: italic;
        }

        /* Hiệu ứng gõ chữ rực sáng rồi thấm mực */
        .alchemy-input:focus {
            border-bottom: 1px solid #a855f7;
            text-shadow: 0 0 10px rgba(168, 85, 247, 0.5);
        }

        /* Quả cầu tinh thể */
        .crystal-ball {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.2), transparent);
            box-shadow: inset 0 0 30px rgba(168, 85, 247, 0.4), 0 0 20px rgba(168, 85, 247, 0.2);
            position: absolute;
            right: -150px;
            top: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.5s;
        }

        /* Con mắt quỷ (Cảnh báo) */
        .demon-eye {
            position: absolute;
            top: -40px;
            right: 40px;
            width: 60px;
            height: 30px;
            background: #fff;
            border-radius: 50% 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #7a1a1a;
            transform: scale(0);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .demon-eye .pupil {
            width: 15px;
            height: 15px;
            background: #000;
            border-radius: 50%;
            box-shadow: 0 0 5px red;
        }

        /* Custom Scrollbar Sợi Xích */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: #3d2b1f;
            border: 2px solid #b8860b;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .summoning-parchment {
                padding: 30px;
                margin-top: 50px;
            }

            .crystal-ball {
                width: 60px;
                height: 60px;
                right: 10px;
                top: 10px;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* ----------------------------- Section 2: Spirit Messengers ----------------------------- */
        #spirit-messengers {
            background: #0a0a0a;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            transition: background 0.8s ease;
        }

        /* Hiệu ứng hào quang nhuộm màu toàn Section */
        #spirit-messengers.owl-active {
            background: #0a120a;
        }

        #spirit-messengers.mirror-active {
            background: #0a1015;
        }

        #spirit-messengers.raven-active {
            background: #120a15;
        }

        .messenger-card {
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            filter: grayscale(0.8) brightness(0.6);
            position: relative;
        }

        .messenger-card.active {
            filter: grayscale(0) brightness(1.2);
            transform: translateY(-20px) scale(1.1);
        }

        /* Bệ đá của linh thú */
        .pedestal {
            width: 100%;
            height: 20px;
            background: #222;
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 1);
            margin-top: 20px;
        }

        /* Hào quang linh thú */
        .aura {
            position: absolute;
            inset: -20px;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0;
            transition: opacity 0.5s;
            z-index: -1;
        }

        .active .aura {
            opacity: 0.4;
        }

        /* Thông tin linh thú (Parchment Tooltip) */
        .spirit-desc {
            position: absolute;
            bottom: -80px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            background: #e6d5b8;
            color: #3d2b1f;
            padding: 10px;
            font-size: 0.8rem;
            font-style: italic;
            opacity: 0;
            pointer-events: none;
            transition: 0.3s;
            clip-path: polygon(0% 0%, 100% 5%, 95% 100%, 5% 95%);
        }

        .messenger-card:hover .spirit-desc,
        .messenger-card.active .spirit-desc {
            opacity: 1;
            bottom: -100px;
        }

        /* Mobile Carousel */
        @media (max-width: 768px) {
            .messenger-grid {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding-bottom: 50px;
            }

            .messenger-card {
                min-width: 80%;
                scroll-snap-align: center;
                margin: 0 10%;
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
    <section id="alchemist-study">
        <div class="ritual-table"></div>

        <div id="candle-light" class="fixed inset-0 pointer-events-none z-20 opacity-30 bg-[radial-gradient(circle,#ffaa0011_0%,transparent_70%)]"></div>

        <div class="summoning-parchment">
            <div class="demon-eye" id="warning-eye">
                <div class="pupil"></div>
            </div>

            <h2 class="font-gothic text-[#3d2b1f] text-2xl mb-8 tracking-widest text-center">LỜI THỈNH CẦU PHÁP SƯ</h2>

            <form id="summon-form">
                <div class="relative">
                    <input type="text" id="name" class="alchemy-input" placeholder="Danh tính vị khách..." required oninput="dryInk(this)">
                </div>

                <div class="relative">
                    <input type="email" id="email" class="alchemy-input" placeholder="Địa chỉ linh hồn (Email)..." required oninput="checkCrystal(this)">
                </div>

                <div class="relative">
                    <textarea id="message" class="alchemy-input min-h-[150px]" placeholder="Lời thỉnh cầu được ghi lại tại đây..." required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="font-gothic text-[#7a1a1a] border-2 border-[#7a1a1a] px-10 py-3 hover:bg-[#7a1a1a] hover:text-[#e6d5b8] transition-all duration-500 tracking-[0.3em]">
                        TRIỆU HỒI
                    </button>
                </div>
            </form>
        </div>

        <div class="crystal-ball hidden md:flex" id="ball">
            <i class="ri-cloud-windy-line text-purple-300 animate-pulse text-3xl"></i>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="spirit-messengers">
        <div class="container mx-auto px-4">
            <h2 class="font-gothic text-[#b8860b] text-xl text-center mb-20 tracking-[0.5em]">CHỌN LINH THÚ ĐƯA TIN</h2>

            <div class="messenger-grid grid grid-cols-1 md:grid-cols-3 gap-20">

                <div class="messenger-card text-center" onclick="selectSpirit(this, 'owl')" data-spirit="owl">
                    <div class="aura bg-green-500"></div>
                    <div class="spirit-visual text-8xl mb-4">🦉</div>
                    <h3 class="font-gothic text-[#f2e8cf]">CÚ TUYẾT</h3>
                    <div class="pedestal"></div>
                    <div class="spirit-desc">"Vạn dặm xa xôi, thư điện tử sẽ được đưa đi một cách trang trọng nhất."</div>
                </div>

                <div class="messenger-card text-center" onclick="selectSpirit(this, 'mirror')" data-spirit="mirror">
                    <div class="aura bg-blue-500"></div>
                    <div class="spirit-visual text-8xl mb-4">🪞</div>
                    <h3 class="font-gothic text-[#f2e8cf]">GƯƠNG SOI</h3>
                    <div class="pedestal"></div>
                    <div class="spirit-desc">"Sương khói mờ ảo, tin nhắn trực tiếp sẽ hiện ra trong nháy mắt."</div>
                </div>

                <div class="messenger-card text-center" onclick="selectSpirit(this, 'raven')" data-spirit="raven">
                    <div class="aura bg-purple-600"></div>
                    <div class="spirit-visual text-8xl mb-4">🐦‍⬛</div>
                    <h3 class="font-gothic text-[#f2e8cf]">QUẠ ĐEN</h3>
                    <div class="pedestal"></div>
                    <div class="spirit-desc">"Trong bóng đêm sâu thẳm, bí mật của ngươi sẽ được giữ kín."</div>
                </div>

            </div>
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
    // 1. Hiệu ứng "Mực khô": Chữ sáng rực khi gõ, sau đó thẫm lại
    function dryInk(input) {
        input.style.color = "#a855f7";
        // Ánh nến nhảy múa theo phím gõ
        gsap.to("#candle-light", {
            opacity: 0.6,
            duration: 0.1,
            yoyo: true,
            repeat: 1
        });

        clearTimeout(input.inkTimeout);
        input.inkTimeout = setTimeout(() => {
            input.style.color = "#1a1a1a";
        }, 500);
    }

    // 2. Crystal Ball Connection: Kiểm tra email
    function checkCrystal(input) {
        const ball = document.getElementById('ball');
        const isEmail = input.value.includes('@');

        if (input.value.length > 0) {
            if (isEmail) {
                gsap.to(ball, {
                    boxShadow: "inset 0 0 50px rgba(34, 197, 94, 0.6)",
                    scale: 1.1
                });
                ball.innerHTML = '<i class="ri-check-line text-green-400 text-3xl"></i>';
            } else {
                gsap.to(ball, {
                    boxShadow: "inset 0 0 50px rgba(239, 68, 68, 0.6)",
                    scale: 0.9
                });
                ball.innerHTML = '<i class="ri-flashlight-line text-red-500 text-3xl animate-bounce"></i>';
            }
        }
    }

    // 3. Con mắt quỷ theo dõi
    document.getElementById('summon-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const inputs = this.querySelectorAll('.alchemy-input');
        let valid = true;

        inputs.forEach(input => {
            if (!input.value) {
                valid = false;
                gsap.to("#warning-eye", {
                    scale: 1
                });
                // Rung lắc form
                gsap.to(".summoning-parchment", {
                    x: 10,
                    repeat: 5,
                    yoyo: true,
                    duration: 0.05
                });
            }
        });

        if (valid) {
            // Nghi lễ thành công
            gsap.to("#alchemist-study", {
                filter: "brightness(2) white-out",
                duration: 1,
                onComplete: () => {
                    alert("Lời thỉnh cầu đã được gửi qua làn khói.");
                    location.reload();
                }
            });
        }
    });

    // Mobile Haptic Feedback
    document.querySelectorAll('.alchemy-input').forEach(input => {
        input.addEventListener('blur', () => {
            if (window.navigator.vibrate) window.navigator.vibrate(50);
        });
    });

    // -----------------------------section 2 ----------------------------- //
    function selectSpirit(element, spiritType) {
        // 1. Reset các trạng thái trước đó
        document.querySelectorAll('.messenger-card').forEach(card => card.classList.remove('active'));
        const section = document.getElementById('spirit-messengers');
        section.className = ''; // Reset background class

        // 2. Kích hoạt linh thú mới
        element.classList.add('active');
        section.classList.add(`${spiritType}-active`);

        // 3. Hiệu ứng âm thanh tinh tế (Sử dụng link âm thanh mẫu)
        let audioSrc = '';
        switch (spiritType) {
            case 'owl':
                audioSrc = 'https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-four-line/zapsplat_nature_bird_owl_hoot_001.mp3';
                break;
            case 'mirror':
                audioSrc = 'https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-61905/zapsplat_magic_spell_shimmer_glow_001_62051.mp3';
                break;
            case 'raven':
                audioSrc = 'https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_bird_wings_flap_001.mp3';
                break;
        }

        const spiritAudio = new Audio(audioSrc);
        spiritAudio.volume = 0.2; // Để âm lượng nhỏ tránh giật mình
        spiritAudio.play();

        // 4. Mobile Haptic
        if (window.navigator.vibrate) {
            window.navigator.vibrate(30);
        }

        // 5. Hiệu ứng xòe cánh/gợn sóng bằng GSAP
        gsap.fromTo(element.querySelector('.spirit-visual'), {
            scale: 1
        }, {
            scale: 1.2,
            duration: 0.3,
            yoyo: true,
            repeat: 1,
            ease: "power2.out"
        });
    }

    // Mobile: Theo dõi việc cuộn Carousel để tự động kích hoạt
    const grid = document.querySelector('.messenger-grid');
    if (window.innerWidth < 768) {
        grid.addEventListener('scroll', () => {
            // Logic để phát hiện card nào đang ở giữa màn hình và add class .active
        });
    }

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>