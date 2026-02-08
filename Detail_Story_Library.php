<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1: The Incipit ----------------------------- */
        #manuscript-opening {
            background-color: #fcfaf5;
            background-image: url('https://www.transparenttextures.com/patterns/parchment.png');
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 4rem 2rem;
            overflow: hidden;
        }

        /* Khung viền hoa văn vẽ tay */
        .border-frame {
            position: relative;
            padding: 3rem;
            border: 20px solid transparent;
            border-image: url('https://i.pinimg.com/originals/30/8a/6c/308a6c8e310034a7810793132626e274.png') 30 round;
            /* Link ảnh khung viền hoa văn */
            max-width: 900px;
            text-align: center;
            background: rgba(252, 250, 245, 0.8);
            transition: transform 0.1s ease-out;
        }

        /* Bức tiểu họa Oval */
        .miniature-oval {
            width: 120px;
            height: 160px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            border: 4px solid #b8860b;
            box-shadow: 0 0 20px rgba(184, 134, 11, 0.3);
            overflow: hidden;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .miniature-oval img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: sepia(0.5) contrast(1.1);
        }

        /* Tiêu đề mực loang */
        .ink-title {
            font-family: 'Cinzel Decorative', serif;
            font-size: 4rem;
            color: #3d2b1f;
            margin-bottom: 1.5rem;
            opacity: 0;
            filter: blur(10px);
        }

        .ink-active {
            animation: inkBleed 3s forwards ease-in-out;
        }

        @keyframes inkBleed {
            0% {
                opacity: 0;
                filter: blur(10px);
                letter-spacing: 15px;
            }

            50% {
                opacity: 0.5;
                filter: blur(5px);
            }

            100% {
                opacity: 1;
                filter: blur(0);
                letter-spacing: normal;
            }
        }

        /* Metadata thủ thư */
        .librarian-notes {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #7a1a1a;
            font-size: 1.1rem;
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
        }

        .librarian-notes span::after {
            content: '•';
            margin-left: 15px;
            color: #b8860b;
            opacity: 0.5;
        }

        .librarian-notes span:last-child::after {
            content: '';
        }

        /* Hạt bụi nắng hoàng hôn */
        .dust-particle {
            position: absolute;
            background: rgba(184, 134, 11, 0.4);
            border-radius: 50%;
            pointer-events: none;
            z-index: 5;
        }

        @media (max-width: 768px) {
            .ink-title {
                font-size: 2.5rem;
            }

            .border-frame {
                border: 10px solid #b8860b;
                border-image: none;
                padding: 2rem 1rem;
            }

            .librarian-notes {
                flex-direction: column;
                gap: 5px;
            }

            .librarian-notes span::after {
                display: none;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* ----------------------------- Section 2: The Sacred Manuscript ----------------------------- */
        #sacred-manuscript {
            background-color: var(--paper-bg, #fcfaf5);
            background-image: url('https://www.transparenttextures.com/patterns/handmade-paper.png');
            color: var(--ink-color, #3d2b1f);
            transition: all 0.8s ease;
            padding: 100px 0;
            min-height: 100vh;
        }

        /* Chế độ đêm (Ink Mode) */
        .night-mode {
            --paper-bg: #1a1a1a;
            --ink-color: #a59d81;
        }

        /* Sợi ruy băng tiến độ */
        #progress-ribbon {
            position: fixed;
            top: 0;
            right: 10%;
            width: 15px;
            height: 0;
            /* Sẽ điều khiển bằng JS */
            background: #7a1a1a;
            z-index: 100;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        #progress-ribbon::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            border-left: 7.5px solid transparent;
            border-right: 7.5px solid transparent;
            border-top: 10px solid #7a1a1a;
        }

        /* Bố cục nội dung bản thảo */
        .manuscript-body {
            max-width: 750px;
            margin: 0 auto;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: justify;
            position: relative;
        }

        /* Chữ cái đầu chương (Illuminating Drop Cap) */
        .drop-cap {
            float: left;
            font-family: 'Cinzel Decorative', serif;
            font-size: 5.5rem;
            line-height: 0.8;
            padding-right: 15px;
            padding-top: 10px;
            color: #b8860b;
            background: linear-gradient(to bottom, #b8860b 0%, #7a1a1a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        /* Ghi chú lề (Marginalia) */
        .marginalia-trigger {
            text-decoration: underline dotted #b8860b;
            cursor: help;
            position: relative;
        }

        .marginalia-note {
            position: absolute;
            left: 110%;
            /* Đẩy ra lề Desktop */
            top: 0;
            width: 180px;
            font-size: 0.9rem;
            font-style: italic;
            color: #7a1a1a;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.4s ease;
            pointer-events: none;
            border-left: 2px solid #b8860b;
            padding-left: 10px;
        }

        .marginalia-trigger:hover .marginalia-note {
            opacity: 0.8;
            transform: translateX(0);
        }

        /* Nút ngọn nến */
        #candle-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            cursor: pointer;
            z-index: 100;
            font-size: 2rem;
            filter: drop-shadow(0 0 10px #ffa500);
        }

        @media (max-width: 768px) {
            .manuscript-body {
                padding: 10px 25px;
                font-size: 1.1rem;
            }

            .marginalia-note {
                position: relative;
                left: 0;
                width: 100%;
                display: none;
                /* Ẩn trên mobile hoặc hiện kiểu khác */
            }

            .marginalia-trigger:active .marginalia-note {
                display: block;
                opacity: 1;
                margin: 10px 0;
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
    <section id="manuscript-opening" class=" mt-12">
        <div id="parchment-texture" class="absolute inset-0 pointer-events-none opacity-20 bg-[url('https://www.transparenttextures.com/patterns/handmade-paper.png')]"></div>

        <div class="border-frame" id="main-frame">
            <div class="miniature-oval">
                <img src="https://images.unsplash.com/photo-1512149177596-f817c7ef5d4c?q=80&w=500" alt="Story Miniature">
            </div>

            <h1 class="ink-title" id="story-title">TẤM CÁM</h1>

            <div class="librarian-notes">
                <span>Bản thảo số: #VN-001</span>
                <span>Chép lại bởi: Archivist An</span>
                <span>Thời gian đọc: 12 phút</span>
            </div>
        </div>

        <div class="mt-20 animate-bounce">
            <i class="ri-arrow-down-double-line text-[#b8860b] text-3xl"></i>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <div id="progress-ribbon"></div>

    <div id="candle-toggle" onclick="toggleInkMode()">🕯️</div>

    <section id="sacred-manuscript">
        <div class="container mx-auto">
            <article class="manuscript-body p-5">

                <p>
                    <span class="drop-cap">N</span>gày xửa ngày xưa, ở một vùng đất mà mây trắng bao phủ quanh năm,
                    có một ngôi làng nhỏ nằm nép mình bên dòng sông bạc. Người dân nơi đây kể rằng, mỗi khi
                    <span class="marginalia-trigger">
                        trăng thượng huyền
                        <span class="marginalia-note">Trăng vào khoảng mùng 7, mùng 8 âm lịch, có hình bán nguyệt.</span>
                    </span>
                    lên cao, dòng nước sẽ ngừng chảy và những linh hồn của rừng già sẽ hiện thân để hát vang bài ca của đất trời.
                </p>

                <div class="my-16 flex items-center justify-center opacity-40 select-none">
                    <svg width="200" height="40" viewBox="0 0 200 40" fill="none" stroke="#3d2b1f" stroke-width="1.5">
                        <path d="M0 20h60M140 20h60" stroke-linecap="round" />
                        <path d="M70 20c5-10 15-10 20 0s15 10 20 0" stroke-linejoin="round" />
                        <circle cx="100" cy="20" r="3" fill="#3d2b1f" />
                        <path d="M85 15l5 5-5 5M115 15l-5 5 5 5" />
                    </svg>
                </div>

                <p>
                    Tấm, người con gái có đôi mắt trong veo như nước mùa thu, vẫn thường ngồi bên gốc cây
                    <span class="marginalia-trigger">
                        thị cổ thụ
                        <span class="marginalia-note">Cây thị lâu năm, thường xuất hiện trong tâm thức dân gian Việt Nam như biểu tượng của sự che chở.</span>
                    </span>.
                    Nàng không biết rằng, định mệnh của mình đã được ghi lại trong những trang sách cổ của thời gian,
                    đợi chờ một khoảnh khắc để bừng sáng như ngọn lửa giữa đêm đông giá rét...
                </p>

                <p class="mt-8">
                    Cuộc hành trình của nàng không chỉ là tìm kiếm hạnh phúc cho riêng mình, mà còn là hành trình
                    đánh thức những giá trị thiện lương đã bị vùi lấp dưới lớp bụi của sự đố kỵ và lòng tham.
                    Mỗi bước chân của Tấm đều để lại một đóa hoa sen trắng, tỏa hương thơm ngát giữa chốn trần gian đầy bụi bặm.
                </p>

            </article>
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
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Kích hoạt hiệu ứng mực loang sau 0.5s
        setTimeout(() => {
            document.getElementById('story-title').classList.add('ink-active');
        }, 500);

        // 2. Parallax vân giấy nhẹ khi di chuột
        const texture = document.getElementById('parchment-texture');
        const frame = document.getElementById('main-frame');

        window.addEventListener('mousemove', (e) => {
            const x = (e.clientX - window.innerWidth / 2) / 50;
            const y = (e.clientY - window.innerHeight / 2) / 50;

            texture.style.transform = `translate(${x}px, ${y}px)`;
            frame.style.transform = `rotateY(${x/2}deg) rotateX(${-y/2}deg)`;
        });

        // 3. Hiệu ứng Gyroscope cho Mobile (Lấp lánh viền vàng)
        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (e) => {
                const glowX = e.gamma; // Nghiêng trái/phải
                const glowY = e.beta; // Nghiêng trước/sau

                frame.style.boxShadow = `${glowX/2}px ${glowY/2}px 30px rgba(184, 134, 11, 0.4)`;
            });
        }

        // 4. Tạo hạt bụi nắng bay lơ lửng
        const opening = document.getElementById('manuscript-opening');
        for (let i = 0; i < 30; i++) {
            let dust = document.createElement('div');
            dust.className = 'dust-particle';
            let size = Math.random() * 3 + 'px';
            dust.style.width = size;
            dust.style.height = size;
            dust.style.left = Math.random() * 100 + '%';
            dust.style.top = Math.random() * 100 + '%';
            opening.appendChild(dust);

            // Animation bụi bay
            gsap.to(dust, {
                y: "-=100",
                x: "+=" + (Math.random() * 50 - 25),
                opacity: 0,
                duration: Math.random() * 5 + 5,
                repeat: -1,
                ease: "none",
                delay: Math.random() * 5
            });
        }
    });

    // -----------------------------section 2 ----------------------------- //
    // 1. Điều khiển ruy băng tiến độ
    window.addEventListener('scroll', () => {
        const ribbon = document.getElementById('progress-ribbon');
        const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = (window.scrollY / scrollHeight) * 100;

        // Ruy băng dài dần theo % cuộn
        ribbon.style.height = scrolled + "%";

        // Nếu cuộn hết (99%), sợi ruy băng có thể đổi hiệu ứng
        if (scrolled > 98) {
            ribbon.style.backgroundColor = "#228b22"; // Thắt nút thành màu xanh (hoặc giữ đỏ)
        } else {
            ribbon.style.backgroundColor = "#7a1a1a";
        }
    });

    // 2. Chuyển chế độ Ink Mode (Night Mode)
    function toggleInkMode() {
        const body = document.getElementById('sacred-manuscript');
        const candle = document.getElementById('candle-toggle');

        body.classList.toggle('night-mode');

        if (body.classList.contains('night-mode')) {
            candle.innerHTML = "🔥";
            candle.style.filter = "drop-shadow(0 0 15px #ff4500)";
        } else {
            candle.innerHTML = "🕯️";
            candle.style.filter = "drop-shadow(0 0 10px #ffa500)";
        }
    }

    // 3. Hiệu ứng bóng đổ 3D nhẹ khi cuộn (Shadow following scroll)
    window.addEventListener('scroll', () => {
        const scrollPos = window.scrollY;
        const manuscript = document.querySelector('.manuscript-body');
        const shadowIntensity = Math.min(scrollPos / 1000, 0.1);
        manuscript.style.boxShadow = `inset 20px 0 50px rgba(0,0,0,${shadowIntensity}), inset -20px 0 50px rgba(0,0,0,${shadowIntensity})`;
    });

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>