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
        #scribes-altar {
            background: #1a120b;
            /* Màu gỗ sồi già */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1000px;
            overflow: hidden;
            position: relative;
            padding: 20px;
        }

        /* Mặt bàn gỗ */
        .wooden-desk {
            position: absolute;
            inset: 0;
            background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
            opacity: 0.3;
            pointer-events: none;
        }

        /* Tấm giấy da (Parchment) */
        .parchment-editor {
            width: 100%;
            max-width: 800px;
            min-height: 80vh;
            background: #f2e8cf;
            background-image: url('https://www.transparenttextures.com/patterns/handmade-paper.png');
            box-shadow: 20px 20px 60px rgba(0, 0, 0, 0.5), inset 0 0 100px rgba(184, 134, 11, 0.1);
            padding: 60px;
            position: relative;
            z-index: 10;
            transform: rotateX(5deg) rotateY(-2deg);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        /* Hiệu ứng Focus Mode */
        .focus-active .accessory {
            opacity: 0.05;
            filter: blur(5px);
        }

        .focus-active .parchment-editor {
            transform: rotate(0) scale(1.02);
            box-shadow: 0 0 100px rgba(255, 255, 255, 0.05);
        }

        /* Ô nhập liệu */
        #scribe-input {
            width: 100%;
            height: 60vh;
            background: transparent;
            border: none;
            outline: none;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            line-height: 1.8;
            color: #3d2b1f;
            resize: none;
            transition: color 0.5s ease;
        }

        /* Hiệu ứng khi hover vào nút lọ mực */
        button[title="Lọ mực màu"]:active i {
            transform: scale(0.8) translateY(5px);
            color: var(--ink-color);
        }

        #scribe-input::placeholder {
            font-style: italic;
            color: #b8860b;
            opacity: 0.4;
        }

        /* Phụ kiện: Lọ mực & Lông vũ */
        .accessory {
            position: absolute;
            z-index: 5;
            transition: all 0.8s ease;
        }

        .inkwell {
            bottom: 10%;
            right: 5%;
            font-size: 80px;
            color: #b8860b;
            opacity: 0.4;
        }

        .compass {
            top: 10%;
            left: 5%;
            font-size: 60px;
            color: #b8860b;
            opacity: 0.3;
            animation: spin 20s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Mobile: Lược bỏ phụ kiện */
        @media (max-width: 768px) {
            .accessory {
                display: none;
            }

            .parchment-editor {
                padding: 40px 20px;
                transform: none !important;
                min-height: 90vh;
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
    <section id="scribes-altar">
        <div class="wooden-desk"></div>

        <div id="candle-light" class="absolute pointer-events-none z-20 w-full h-full"
            style="background: radial-gradient(circle at 20% 20%, rgba(255,165,0,0.05) 0%, transparent 50%);"></div>

        <div class="accessory compass"><i class="ri-compass-discover-line"></i></div>
        <div class="accessory inkwell"><i class="ri-ink-bottle-fill"></i></div>

        <div class="parchment-editor" id="main-editor">
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#7a1a1a] text-[#f2e8cf] px-8 py-2 font-gothic text-xs tracking-[0.3em] shadow-lg">
                GHI CHÉP HÀNH TRÌNH
            </div>

            <input type="text" class="w-full bg-transparent border-none outline-none font-gothic text-[#7a1a1a] text-2xl mb-8"
                placeholder="Tiêu đề chương..." />

            <textarea id="scribe-input" placeholder="Những lời thì thầm của quá khứ đang đợi bạn ghi lại..."></textarea>

            <div class="flex justify-between items-center mt-8 border-t border-[#3d2b1f]/10 pt-4">
                <div class="flex gap-4 opacity-40 hover:opacity-100 transition-opacity">
                    <button title="Lọ mực màu" onclick="changeInk()"><i class="ri-drop-line"></i></button>
                    <button title="Dao cạo lỗi" onclick="clearText()"><i class="ri-eraser-line"></i></button>
                    <button title="Mảnh ký ức" onclick="openMemories()"><i class="ri-book-open-line"></i></button>
                </div>
                <div class="font-serif italic text-xs opacity-30" id="word-count">0 chữ</div>
            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('scribe-input');
        const editor = document.getElementById('main-editor');
        const altar = document.getElementById('scribes-altar');
        let wordCount = 0;

        // 1. Hiệu ứng Focus Mode & Đếm chữ
        input.addEventListener('input', (e) => {
            const text = e.target.value;
            const words = text.trim().split(/\s+/).length;
            document.getElementById('word-count').innerText = `${words} chữ`;

            if (words > 5) {
                altar.classList.add('focus-active');
            } else {
                altar.classList.remove('focus-active');
            }

            // 2. Hiệu ứng âm thanh sột soạt (Optional)
            playScribbleSound();
        });

        // 3. Hiệu ứng bóng nến theo chuột
        altar.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth) * 100;
            const y = (e.clientY / window.innerHeight) * 100;
            document.getElementById('candle-light').style.background =
                `radial-gradient(circle at ${x}% ${y}%, rgba(255,165,0,0.08) 0%, transparent 60%)`;
        });

        // 4. Giả lập âm thanh ngòi bút
        function playScribbleSound() {
            const audio = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-61905/zapsplat_foley_pencil_scribble_paper_001_62254.mp3');
            audio.volume = 0.05;
            audio.play().catch(() => {}); // Chặn lỗi nếu trình duyệt chưa cho phép
        }

        // 5. Chức năng thanh công cụ
        window.clearText = () => {
            if (confirm("Bạn muốn dùng dao cạo sạch bản thảo này?")) {
                input.value = "";
            }
        }

    });
    // 1. Thay đổi màu mực (Change Ink)
    const inkColors = ['#3d2b1f', '#1a3a3a', '#5a1414', '#2d1a4a']; // Nâu đen, Xanh rêu cổ, Đỏ rượu, Tím than
    let currentInkIndex = 0;

    function changeInk() {
        const input = document.getElementById('scribe-input');
        currentInkIndex = (currentInkIndex + 1) % inkColors.length;

        // Đổi màu chữ kèm hiệu ứng mượt
        gsap.to(input, {
            color: inkColors[currentInkIndex],
            duration: 0.5
        });

        // Thông báo nhỏ kiểu thủ thư
        console.log("Đã thay lọ mực mới: " + inkColors[currentInkIndex]);
    }

    // 2. Mở mảnh ký ức (Open Memories)
    function openMemories() {
        // Tạo một lớp phủ (Modal) kiểu giấy cổ
        const memoryOverlay = document.createElement('div');
        memoryOverlay.id = 'memory-modal';
        memoryOverlay.className = 'fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm';

        memoryOverlay.innerHTML = `
        <div class="bg-[#f2e8cf] p-10 max-w-lg w-full rotate-1 shadow-2xl border-l-8 border-[#b8860b]/30">
            <h4 class="font-gothic text-[#7a1a1a] text-xl mb-6">Mảnh ký ức đã lưu</h4>
            <ul class="font-serif italic text-[#3d2b1f] space-y-4">
                <li class="border-b border-black/5 pb-2 cursor-pointer hover:text-[#7a1a1a]">"...hạt gạo hóa thành những ngôi sao nhỏ" - Sọ Dừa</li>
                <li class="border-b border-black/5 pb-2 cursor-pointer hover:text-[#7a1a1a]">"Tiếng đàn vang lên minh oan cho kẻ yếu" - Thạch Sanh</li>
                <li class="border-b border-black/5 pb-2 cursor-pointer hover:text-[#7a1a1a]">"Mùi hương thị thơm ngát cả một vùng trời" - Tấm Cám</li>
            </ul>
            <button onclick="this.parentElement.parentElement.remove()" class="mt-8 font-gothic text-xs tracking-widest text-[#b8860b]">ĐÓNG LẠI</button>
        </div>
    `;

        document.body.appendChild(memoryOverlay);

        // Hiệu ứng hiện Modal
        gsap.from('#memory-modal div', {
            scale: 0.8,
            opacity: 0,
            rotate: -5,
            duration: 0.5,
            ease: "back.out(1.7)"
        });
    }

    // -----------------------------section 2 ----------------------------- //

    //----------------------------- section 3 ----------------------------- //

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>