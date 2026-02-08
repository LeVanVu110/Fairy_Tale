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

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>