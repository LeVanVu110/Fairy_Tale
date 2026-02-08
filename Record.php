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
        /* ----------------------------- Section 2: The Archive of Whispers ----------------------------- */
        #archive-whispers {
            background: #0f0a06;
            /* Màu tối của kho lưu trữ */
            padding: 100px 0;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Bảng da thuộc chứa giấy */
        .leather-board {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 40px;
            padding: 40px;
            perspective: 1000px;
        }

        /* Mảnh giấy da ký ức */
        .whisper-scrap {
            background: #e6d5b8;
            background-image: url('https://www.transparenttextures.com/patterns/handmade-paper.png');
            padding: 25px;
            min-height: 300px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
            cursor: grab;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            /* Hiệu ứng xé cạnh bằng clip-path */
            clip-path: polygon(2% 0%, 98% 1%, 100% 98%, 1% 100%, 0% 50%);
        }

        /* Hiệu ứng Gió thổi (Flutter) */
        @keyframes flutter {

            0%,
            100% {
                transform: rotate(var(--r)) translateY(0);
            }

            50% {
                transform: rotate(calc(var(--r) + 2deg)) translateY(-5px);
            }
        }

        .whisper-scrap:hover {
            transform: scale(1.1) rotate(0deg) !important;
            z-index: 100;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
            filter: brightness(1.2);
        }

        /* Thời gian theo tuần trăng */
        .moon-phase {
            font-family: 'Cinzel Decorative', serif;
            font-size: 0.7rem;
            color: #7a1a1a;
            border-bottom: 1px dotted #7a1a1a;
            margin-bottom: 15px;
            display: block;
        }

        /* Lò sưởi để xóa (The Hearth) */
        .hearth-bin {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 120px;
            height: 120px;
            background: url('https://cdn-icons-png.flaticon.com/512/1694/1694435.png');
            /* Icon đống lửa cổ điển */
            background-size: contain;
            filter: drop-shadow(0 0 10px #ff4500);
            z-index: 200;
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .hearth-bin.drag-over {
            opacity: 1;
            transform: scale(1.2);
        }

        @media (max-width: 768px) {
            .leather-board {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: -50px;
                /* Chồng lớp trên mobile */
            }

            .whisper-scrap {
                width: 90%;
                margin-bottom: -150px;
                /* Tạo hiệu ứng Stack */
                transform: rotate(0deg) !important;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* ----------------------------- Section 3: The Sealed Destiny ----------------------------- */
        #sealed-destiny {
            background: #1a120b;
            padding: 100px 0;
            color: #f2e8cf;
            border-top: 2px dashed #b8860b;
            position: relative;
        }

        /* Khay con dấu */
        .seal-tray {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
        }

        .seal-tool {
            width: 60px;
            height: 60px;
            background: #7a1a1a;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #b8860b;
            transition: all 0.3s;
            font-size: 1.5rem;
        }

        .seal-tool:hover {
            transform: translateY(-10px) rotate(15deg);
            box-shadow: 0 10px 20px rgba(184, 134, 11, 0.4);
        }

        .seal-tool.active {
            background: #ff4500;
            box-shadow: 0 0 20px #ff4500;
        }

        /* Khu vực ký tên */
        #signature-pad {
            border: 1px solid #b8860b;
            background: rgba(242, 232, 207, 0.9);
            cursor: crosshair;
            border-radius: 5px;
        }

        /* Hòm thư đồng */
        .mailbox-container {
            text-align: center;
            margin-top: 50px;
        }

        .mailbox-icon {
            font-size: 5rem;
            color: #b8860b;
            cursor: pointer;
            transition: transform 0.5s;
        }

        .mailbox-icon:hover {
            transform: scale(1.1);
        }

        /* Hiệu ứng bóng chim quạ bay qua */
        .raven-shadow {
            position: fixed;
            top: 20%;
            left: -200px;
            font-size: 100px;
            color: rgba(0, 0, 0, 0.6);
            pointer-events: none;
            z-index: 1000;
            filter: blur(5px);
        }

        @media (max-width: 768px) {
            .seal-tray {
                flex-wrap: wrap;
            }
        }

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
    <section id="archive-whispers">
        <div class="container mx-auto">
            <h3 class="font-gothic text-[#b8860b] text-center text-2xl mb-16 tracking-[0.5em] opacity-40">KHO LƯU TRỮ NHỮNG LỜI THÌ THẦM</h3>

            <div class="leather-board">
                <div class="whisper-scrap" draggable="true" ondragstart="drag(event)" style="--r: -3deg; --age: 0.1;">
                    <span class="moon-phase">🌙 Đêm Trăng Khuyết vừa qua</span>
                    <h4 class="font-bold text-[#3d2b1f] mb-2">Cuộc gặp dưới gốc thị...</h4>
                    <p class="font-serif italic text-sm text-[#3d2b1f]/60 leading-relaxed">
                        Nàng Tấm bước ra từ quả thị, mùi hương thơm ngát tỏa khắp gian bếp nhỏ của bà lão...
                    </p>
                    <div class="absolute bottom-4 right-4 text-[#7a1a1a]/20"><i class="ri-quill-pen-line"></i></div>
                </div>

                <div class="whisper-scrap" draggable="true" ondragstart="drag(event)"
                    style="--r: 2deg; background-color: #d4c3a1; filter: sepia(0.3);">
                    <span class="moon-phase">🌕 Đêm Trăng Tròn tháng trước</span>
                    <h4 class="font-bold text-[#3d2b1f] mb-2">Bí mật máu bạc</h4>
                    <p class="font-serif italic text-sm text-[#3d2b1f]/60 leading-relaxed">
                        Kỳ lân không chết, nó chỉ tan vào ánh sáng để chờ đợi kẻ xứng đáng...
                    </p>
                    <div class="absolute bottom-4 right-4 text-[#7a1a1a]/20"><i class="ri-git-repository-line"></i></div>
                </div>

                <div class="whisper-scrap" draggable="true" ondragstart="drag(event)"
                    style="--r: -1deg; box-shadow: 8px 8px 0px #c2b296, 12px 12px 20px rgba(0,0,0,0.4);">
                    <span class="moon-phase">🌑 Đêm Không Trăng</span>
                    <h4 class="font-bold text-[#3d2b1f] mb-2">Hồi kết đen của Grimm</h4>
                    <p class="font-serif italic text-sm text-[#3d2b1f]/60 leading-relaxed">
                        Mọi con đường đều dẫn về khu rừng, nơi tiếng sói hú vang vọng những lời nguyền...
                    </p>
                </div>
            </div>
        </div>

        <div class="hearth-bin"
            ondrop="drop(event)"
            ondragover="allowDrop(event)"
            ondragleave="this.classList.remove('drag-over')">
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="sealed-destiny">
        <div class="container mx-auto px-4 text-center">
            <h2 class="font-gothic text-[#b8860b] text-xl tracking-[0.4em] mb-10">PHONG ẤN ĐỊNH MỆNH</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-center">
                <div class="wax-melting-station">
                    <div class="candle-glow mb-4"><i class="ri-fire-fill text-orange-500 text-4xl animate-pulse"></i></div>
                    <p class="font-serif italic text-sm opacity-60">Sáp nóng đang chờ đợi...</p>
                    <div class="mt-4 flex justify-center gap-2">
                        <div class="w-6 h-6 bg-[#7a1a1a] rounded-full cursor-pointer border border-white"></div>
                        <div class="w-6 h-6 bg-[#1a3a3a] rounded-full cursor-pointer border border-white"></div>
                    </div>
                </div>

                <div class="seal-and-sign">
                    <p class="font-gothic text-xs mb-4">KÝ TÊN VÀ CHỌN ẤN KÝ</p>
                    <canvas id="signature-pad" width="300" height="150" class="mx-auto mb-6"></canvas>

                    <div class="seal-tray">
                        <div class="seal-tool" onclick="selectSeal(this, '🌙')">🌙</div>
                        <div class="seal-tool" onclick="selectSeal(this, '⚔️')">⚔️</div>
                        <div class="seal-tool" onclick="selectSeal(this, '🌿')">🌿</div>
                    </div>
                </div>

                <div class="mailbox-container">
                    <div class="mailbox-icon" id="send-btn" onclick="sendRavenMessage()">
                        <i class="ri-mail-send-line"></i>
                    </div>
                    <p class="mt-4 font-serif italic text-sm">Gửi tin cho bầy Quạ</p>
                </div>
            </div>
        </div>
    </section>

    <div id="raven-effect" class="raven-shadow"><i class="ri-送信-fill"></i></div>

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
    // Cho phép thả vào lò sưởi
    function allowDrop(ev) {
        ev.preventDefault();
        document.querySelector('.hearth-bin').classList.add('drag-over');
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        // Tạo ID giả nếu chưa có
        if (!ev.target.id) ev.target.id = "scrap-" + Math.random().toString(36).substr(2, 9);
        ev.dataTransfer.setData("text", ev.target.id);
    }

    // HÀM QUAN TRỌNG NHẤT: Xử lý khi thả giấy vào lửa
    function drop(ev) {
        ev.preventDefault();
        const data = ev.dataTransfer.getData("text");
        const scrap = document.getElementById(data);
        const hearth = document.querySelector('.hearth-bin');

        hearth.classList.remove('drag-over');

        if (scrap) {
            // Hiệu ứng GSAP: Giấy đỏ rực lên rồi tan biến
            gsap.to(scrap, {
                scale: 0,
                opacity: 0,
                filter: "brightness(5) saturate(2) blur(10px)", // Sáng rực như đang cháy
                color: "#ff4500",
                duration: 0.6,
                ease: "power2.in",
                onComplete: () => {
                    scrap.remove(); // Xóa khỏi DOM
                    // Kích hoạt hạt tro tại vị trí con chuột khi thả
                    createAshes(ev.clientX, ev.clientY);
                }
            });
        }
    }

    // Hàm tạo hạt tro (Đã có trong file của bạn, đảm bảo nó trông như thế này)
    function createAshes(x, y) {
        for (let i = 0; i < 15; i++) { // Tăng lên 15 hạt cho đẹp
            const ash = document.createElement('div');
            // Tạo style cho hạt tro
            ash.className = 'fixed pointer-events-none rounded-full z-[300]';
            ash.style.width = Math.random() * 4 + 'px';
            ash.style.height = ash.style.width;
            ash.style.backgroundColor = Math.random() > 0.5 ? '#555' : '#222'; // Màu xám hoặc đen
            ash.style.left = x + 'px';
            ash.style.top = y + 'px';
            document.body.appendChild(ash);

            // Hiệu ứng tro bay lơ lửng rồi biến mất
            gsap.to(ash, {
                x: Math.random() * 150 - 75, // Bay ngang ngẫu nhiên
                y: -200 - Math.random() * 150, // Bay lên cao
                opacity: 0,
                rotation: Math.random() * 360,
                duration: 1.5 + Math.random(),
                ease: "power1.out",
                onComplete: () => ash.remove()
            });
        }
    }

    // Hiệu ứng Gió thổi ngẫu nhiên khi cuộn
    window.addEventListener('scroll', () => {
        document.querySelectorAll('.whisper-scrap').forEach(scrap => {
            if (Math.random() > 0.95) {
                scrap.style.animation = 'flutter 0.5s ease-in-out';
                setTimeout(() => scrap.style.animation = '', 500);
            }
        });
    });

    //----------------------------- section 3 ----------------------------- //
    // Khởi tạo Canvas cho chữ ký
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let writing = false;

    canvas.addEventListener('mousedown', () => writing = true);
    canvas.addEventListener('mouseup', () => {
        writing = false;
        ctx.beginPath();
    });

    canvas.addEventListener('mousemove', (e) => {
        if (!writing) return;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#3d2b1f';

        // Thuật toán làm mượt nét vẽ (Simple line)
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
    });

    function selectSeal(el, icon) {
        document.querySelectorAll('.seal-tool').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
        // Hiệu ứng âm thanh "cộp"
        new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-61905/zapsplat_leisure_game_board_game_piece_slide_wood_surface_001_62410.mp3').play();
    }

    function sendRavenMessage() {
        const btn = document.getElementById('send-btn');
        const raven = document.getElementById('raven-effect');

        // 1. Hiệu ứng Rung màn hình
        gsap.to("body", {
            x: 10,
            duration: 0.05,
            repeat: 10,
            yoyo: true
        });

        // 2. Bóng chim bay qua
        gsap.fromTo(raven, {
            left: "-200px",
            opacity: 0,
            scale: 1
        }, {
            left: "120%",
            opacity: 0.5,
            scale: 2,
            duration: 2,
            ease: "power1.inOut"
        });

        // 3. Bản thảo biến mất (The Disappearing Act)
        const mainEditor = document.getElementById('main-editor');
        gsap.to(mainEditor, {
            y: -500,
            rotation: 10,
            opacity: 0,
            duration: 1.5,
            ease: "back.in(1.7)",
            onComplete: () => {
                alert("Bản thảo đã được Quạ đưa vào cõi hư vô.");
                // Reset trang hoặc lưu dữ liệu
                location.reload();
            }
        });

        // Phát âm thanh cánh chim
        const wingSound = new Audio('https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-one/foley_bird_wings_flap_001.mp3');
        wingSound.play();
    }

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>