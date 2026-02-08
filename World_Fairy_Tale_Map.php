<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* Hiệu ứng Bụi vàng quét qua khi load */
        @keyframes goldenScan {
            0% {
                left: -100%;
                opacity: 0;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                left: 100%;
                opacity: 0;
            }
        }

        #map-container::after {
            content: '';
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(184, 134, 11, 0.2), transparent);
            animation: goldenScan 3s ease-in-out infinite;
            pointer-events: none;
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Marker Phù hiệu vẽ tay */
        .vignette-marker {
            position: absolute;
            cursor: pointer;
            z-index: 10;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Hiệu ứng nhịp thở thần thoại */
        .vignette-marker::after {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.4) 0%, transparent 70%);
            animation: mythicPulse 3s infinite;
            z-index: -1;
        }

        @keyframes mythicPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.6;
            }
        }

        /* Khung Popup mảnh giấy da cuộn mở */
        #story-popup {
            display: none;
            position: absolute;
            width: 320px;
            background: #fdfbf7;
            border: 1px solid #3d2b1f;
            box-shadow: 20px 20px 60px rgba(0, 0, 0, 0.3);
            z-index: 100;
            transform-origin: center;
            clip-path: inset(0 50% 0 50%);
            /* Trạng thái đóng: thu vào giữa */
            transition: clip-path 0.6s ease-in-out;
        }

        #story-popup.open {
            display: block;
            clip-path: inset(0 0% 0 0%);
            /* Trạng thái mở: bung ra hai bên */
        }

        .cinnabar-title {
            color: #7a1a1a;
            /* Màu mực đỏ Cinnabar */
            font-family: 'Cinzel Decorative', serif;
        }

        /* Bottom Sheet cho Mobile */
        @media (max-width: 768px) {
            #story-popup {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                width: 100%;
                border-radius: 20px 20px 0 0;
                clip-path: none;
                transform: translateY(100%);
                transition: transform 0.5s ease;
            }

            #story-popup.open {
                transform: translateY(0);
            }
        }

        /* ----------------------------- section 3 ----------------------------- */
        #explorer-journal {
            background: #e8e4d9;
            /* Màu giấy cũ hơn */
            background-image: url('https://www.transparenttextures.com/patterns/paper.png');
            padding-top: 10vh;
        }

        /* Hiệu ứng cuốn sổ mở ra */
        .journal-book {
            background: #fdfbf7;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2), inset 0 0 100px rgba(184, 134, 11, 0.1);
            border-radius: 4px;
            position: relative;
            min-height: 70vh;
        }

        /* Đường kẻ giữa cuốn sổ */
        .journal-spine {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, transparent, rgba(61, 43, 31, 0.1), transparent);
            transform: translateX(-50%);
        }

        /* Chữ viết tay tự hiện (Ink writing) */
        .handwriting {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #3d2b1f;
            border-right: 2px solid transparent;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            /* Sẽ dùng GSAP để chạy width */
        }

        /* Con dấu sáp đỏ */
        .wax-seal {
            width: 80px;
            height: 80px;
            background: #7a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            /* Sửa từ items-center thành align-items */
            justify-content: center;
            /* Sửa từ justify-center thành justify-content */
            color: #fcfaf5;
            font-weight: bold;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3);
            position: absolute;
            transform: rotate(-15deg) scale(0);
            border: 2px solid #5a1414;
            z-index: 20;
            margin-left: 65%;
            margin-top: -30px;
        }

        /* Phím tắt Back to Map */
        #anchor-to-map {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: #b8860b;
            border-radius: 50%;
            color: white;
            z-index: 100;
        }

        @media (max-width: 768px) {
            .journal-spine {
                display: none;
            }

            .journal-book {
                flex-direction: column;
            }

            .wax-seal {
                margin-top: 50%;
                margin-left: 20%;
            }

        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="explorer-desk" class="relative min-h-screen bg-[#1a120b] overflow-hidden flex items-center justify-center py-20 mt-12">

        <div class="absolute inset-0 z-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/dark-wood.png')]"></div>

        <div class="relative z-10 w-full max-w-[1400px] h-[80vh] flex items-center justify-center px-4">

            <div id="magic-lens-tool" class="hidden md:flex absolute left-10 top-1/4 z-30 flex-col items-center gap-4">
                <div class="w-16 h-16 rounded-full border-4 border-[#b8860b] flex items-center justify-center bg-[#fcfaf5]/10 cursor-pointer shadow-lg hover:scale-110 transition-transform">
                    <i class="ri-search-eye-line text-[#b8860b] text-3xl"></i>
                </div>
                <span class="font-gothic text-[#b8860b] text-xs tracking-widest uppercase">Tìm vùng đất</span>
            </div>

            <div id="filter-scroll" class="hidden md:block absolute right-10 top-1/4 z-30">
                <div class="bg-[#fdfbf7] p-6 shadow-2xl border-l-4 border-[#b8860b] relative w-48 transition-all hover:w-56">
                    <h4 class="font-gothic text-sm mb-4 border-b border-[#3d2b1f]/20 pb-2">Biên niên sử</h4>
                    <ul class="space-y-3 text-xs italic">
                        <li class="hover:text-[#7a1a1a] cursor-pointer"><i class="ri-map-pin-line mr-2"></i>Châu Âu cổ</li>
                        <li class="hover:text-[#7a1a1a] cursor-pointer"><i class="ri-map-pin-line mr-2"></i>Viễn Đông</li>
                        <li class="hover:text-[#7a1a1a] cursor-pointer"><i class="ri-map-pin-line mr-2"></i>Vùng đất hứa</li>
                    </ul>
                </div>
            </div>

            <div id="map-container" class="relative w-full h-full bg-[#f2e8cf] shadow-[0_0_100px_rgba(0,0,0,0.5)] border-[12px] border-[#3d2b1f] overflow-hidden group">
                <div id="ancient-map" class="absolute inset-0 bg-[url('https://png.pngtree.com/thumb_back/fh260/background/20240819/pngtree-vintage-world-map-on-grunge-paper-texture-image_16170179.jpg')] bg-cover bg-center grayscale sepia-[0.5] transition-transform duration-500 ease-out">

                    <div class="absolute top-1/3 left-1/4 w-10 h-10 flex items-center justify-center group/marker">
                        <div class="absolute w-12 h-12 bg-transparent cursor-pointer rounded-full z-10"></div> <i class="ri-map-pin-fill text-[#7a1a1a] text-2xl relative z-0 transition-transform group-hover/marker:scale-125"></i>
                    </div>
                </div>
                <div id="mythic-markers-layer" class="absolute inset-0 z-20 pointer-events-none">

                    <div class="vignette-marker pointer-events-auto" style="top: 60%; left: 75%;"
                        onclick="openStory('vn', event)" onmouseenter="playSfx('flute')">
                        <div class="w-12 h-12 flex items-center justify-center bg-[#fcfaf5] border border-[#b8860b] rounded-full shadow-lg overflow-hidden group">
                            <img src="https://img.icons8.com/color/48/dragon.png" class="w-8 h-8 group-hover:scale-125 transition-transform">
                        </div>
                        <span class="absolute top-full left-1/2 -translate-x-1/2 mt-2 text-[10px] font-bold tracking-widest text-[#3d2b1f] whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">LẠC LONG QUÂN</span>
                    </div>

                    <div class="vignette-marker pointer-events-auto" style="top: 25%; left: 60%;"
                        onclick="openStory('ru', event)" onmouseenter="playSfx('snow')">
                        <div class="w-12 h-12 flex items-center justify-center bg-[#fcfaf5] border border-[#b8860b] rounded-full shadow-lg overflow-hidden group">
                            <img src="https://img.icons8.com/color/48/crown.png" class="w-8 h-8 group-hover:scale-125 transition-transform">
                        </div>
                        <span class="absolute top-full left-1/2 -translate-x-1/2 mt-2 text-[10px] font-bold tracking-widest text-[#3d2b1f] whitespace-nowrap">CÔNG CHÚA ẾCH</span>
                    </div>
                </div>

                <div id="lens-overlay" class="pointer-events-none absolute inset-0 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    style="background: radial-gradient(circle 150px at var(--mouse-x) var(--mouse-y), transparent 95%, rgba(0,0,0,0.4) 100%);">
                </div>
            </div>

            <div id="compass" class="absolute bottom-6 right-10 z-40 w-24 h-24 md:w-32 md:h-32">
                <img src="https://cdn-icons-png.flaticon.com/512/854/854866.png" class="w-full h-full object-contain opacity-80" id="compass-needle">
            </div>

        </div>

        <div class="md:hidden fixed bottom-6 left-0 right-0 z-50 flex justify-between px-10 pointer-events-none">
            <button class="w-14 h-14 bg-[#b8860b] rounded-full shadow-xl pointer-events-auto text-white"><i class="ri-search-2-line text-xl"></i></button>
            <button class="w-14 h-14 bg-[#3d2b1f] rounded-full shadow-xl pointer-events-auto text-white"><i class="ri-filter-3-line text-xl"></i></button>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <div id="story-popup" class="p-0 overflow-hidden">
        <div class="p-6 border-4 border-double border-[#3d2b1f]/10">
            <div class="flex justify-between items-start mb-4">
                <h3 id="pop-title" class="cinnabar-title text-xl font-bold">Tiêu đề truyện</h3>
                <button onclick="closeStory()" class="text-[#3d2b1f] hover:text-[#7a1a1a]"><i class="ri-close-line text-2xl"></i></button>
            </div>

            <div class="w-full h-32 bg-gray-100 mb-4 overflow-hidden border border-[#3d2b1f]/20">
                <img id="pop-sketch" src="" class="w-full h-full object-cover grayscale opacity-80">
            </div>

            <p id="pop-desc" class="text-sm italic text-[#3d2b1f] leading-relaxed mb-6">
                Mô tả tóm tắt đầy chất thơ của câu chuyện cổ tích...
            </p>

            <div class="flex items-center justify-between border-t border-[#3d2b1f]/10 pt-4">
                <div class="text-[10px] text-[#b8860b]">
                    <i class="ri-arrow-left-right-line mr-1"></i> TRUYỆN TƯƠNG ĐỒNG
                </div>
                <button class="flex items-center gap-2 bg-[#3d2b1f] text-[#fcfaf5] px-4 py-2 text-xs hover:bg-[#7a1a1a] transition-colors">
                    BẮT ĐẦU HÀNH TRÌNH <i class="ri-compass-discover-line"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="explorer-journal" class="relative py-20 min-h-screen">

        <a href="#explorer-desk" class="fixed bottom-10 right-10 z-50 w-14 h-14 bg-[#3d2b1f] text-[#b8860b] rounded-full flex items-center justify-center shadow-2xl border border-[#b8860b]/30">
            <i class="ri-map-2-line text-2xl"></i>
        </a>

        <div class="container mx-auto max-w-6xl px-4">
            <h2 class="font-gothic text-center text-4xl mb-16 tracking-widest text-[#3d2b1f]">NHẬT KÝ VIỄN CHINH</h2>

            <div class="journal-book flex flex-col md:flex-row p-8 md:p-12 relative overflow-hidden">
                <div class="journal-spine"></div>

                <div class="w-full md:w-1/2 pr-0 md:pr-12 flex flex-col items-center">
                    <h3 class="font-gothic text-xl mb-8 border-b border-[#3d2b1f]/20 w-full text-center">Tỷ Lệ Khai Phá</h3>

                    <div class="relative w-64 h-64 mb-10">
                        <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#3d2b1f" stroke-width="0.5" stroke-dasharray="100, 100" />
                            <circle id="exploration-circle" cx="18" cy="18" r="16" fill="none" stroke="#b8860b" stroke-width="2"
                                stroke-dasharray="0, 100" class="transition-all duration-1000" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span id="exploration-percent" class="text-3xl font-bold text-[#3d2b1f]">0%</span>
                            <span class="text-[10px] tracking-widest uppercase opacity-60">Thế giới</span>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-4">
                        <div id="badge-asia" class="wax-seal relative">
                            <span class="text-[10px]">ASIA</span>
                        </div>
                        <div id="badge-euro" class="wax-seal relative" style="background: #3d2b1f; opacity: 0.2;">
                            <span class="text-[10px]">EURO</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 pl-0 md:pl-12 mt-12 md:mt-0">
                    <h3 class="font-gothic text-xl mb-8 border-b border-[#3d2b1f]/20 w-full text-center">Ghi Chép Gần Đây</h3>

                    <div id="journal-logs" class="space-y-8">
                        <div class="log-entry">
                            <span class="text-[10px] opacity-40 block mb-1">Ngày 08, Tháng 02, 2026</span>
                            <div class="handwriting text-xl" id="log-1">Đã đặt chân đến vùng Rồng Biếc...</div>
                            <p class="text-xs opacity-60 mt-2">Mảnh ghép thứ nhất của nòi giống Tiên Rồng.</p>
                        </div>

                        <div class="log-entry opacity-20">
                            <span class="text-[10px] block mb-1">Ngày ..., Tháng ..., ...</span>
                            <div class="border-b border-[#3d2b1f] w-3/4 h-6"></div>
                            <p class="text-xs mt-2 italic">Những trang giấy còn trống đang đợi bước chân bạn.</p>
                        </div>
                    </div>

                    <div class="mt-16 text-center">
                        <button id="export-journal" class="group flex items-center justify-center gap-3 mx-auto border border-[#3d2b1f] px-6 py-3 hover:bg-[#3d2b1f] hover:text-[#fcfaf5] transition-all">
                            <i class="ri-quill-pen-line"></i>
                            <span class="font-gothic text-xs tracking-widest uppercase">Gói ghém hành trình</span>
                        </button>
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
        const mapContainer = document.getElementById('map-container');
        const map = document.getElementById('ancient-map');
        const lens = document.getElementById('lens-overlay');
        const compass = document.getElementById('compass-needle');

        // 1. Hiệu ứng Kính lúp ma thuật
        mapContainer.addEventListener('mousemove', (e) => {
            const rect = mapContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Cập nhật vị trí Mask CSS
            lens.style.setProperty('--mouse-x', `${x}px`);
            lens.style.setProperty('--mouse-y', `${y}px`);

            // 2. Hiệu ứng Gió phương Nam (3D Tilt)
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            gsap.to(mapContainer, {
                rotationX: rotateX,
                rotationY: rotateY,
                duration: 0.5,
                ease: "power2.out"
            });

            // 3. Kim la bàn xoay theo chuột
            const angle = Math.atan2(y - centerY, x - centerX) * (180 / Math.PI);
            gsap.to(compass, {
                rotation: angle + 90,
                duration: 0.3
            });
        });

        // Reset khi chuột rời đi
        mapContainer.addEventListener('mouseleave', () => {
            gsap.to(mapContainer, {
                rotationX: 0,
                rotationY: 0,
                duration: 1
            });
        });

        // 4. Onboarding: Ánh sáng quét khi vào trang
        gsap.from("#map-container", {
            scale: 0.8,
            opacity: 0,
            duration: 2,
            ease: "expo.out"
        });
    });

    // -----------------------------section 2 ----------------------------- //
    const storyData = {
        vn: {
            title: "LẠC LONG QUÂN",
            desc: "Thuở hồng hoang, nòi rồng kết duyên cùng giống tiên, đẻ ra bọc trăm trứng, nở thành trăm con người Việt đầu tiên...",
            sketch: "https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=500"
        },
        ru: {
            title: "CÔNG CHÚA ẾCH",
            desc: "Trong tuyết trắng của phương Bắc, mũi tên của hoàng tử đã rơi vào đầm lầy, dẫn lối đến một lời nguyền cổ xưa của Ivan...",
            sketch: "https://upload.wikimedia.org/wikipedia/vi/9/95/Poster_phim_C%C3%B4ng_ch%C3%BAa_v%C3%A0_ch%C3%A0ng_%E1%BA%BFch.jpg"
        }
    };

    function openStory(id, event) {
        const data = storyData[id];
        const popup = document.getElementById('story-popup');

        // Đổ dữ liệu
        document.getElementById('pop-title').innerText = data.title;
        document.getElementById('pop-desc').innerText = data.desc;
        document.getElementById('pop-sketch').src = data.sketch;

        // Vị trí Popup (tránh rìa màn hình)
        if (window.innerWidth > 768) {
            popup.style.top = `${event.clientY - 100}px`;
            popup.style.left = `${event.clientX + 50}px`;
        }

        popup.classList.add('open');
    }

    function closeStory() {
        document.getElementById('story-popup').classList.remove('open');
    }

    // Giả lập âm thanh (Spatial Audio)
    function playSfx(type) {
        console.log(`Đang phát âm thanh: ${type}`);
        // Bạn có thể tích hợp thư viện Howler.js để phát tiếng sáo/tuyết thực sự
    }

    //----------------------------- section 3 ----------------------------- //
    window.addEventListener('load', function() {
        // 1. Giả lập lấy dữ liệu từ LocalStorage (Dấu chân người dùng)
        const visitedTales = JSON.parse(localStorage.getItem('visited_tales')) || [];

        // 2. Animation khi cuộn đến Section Nhật ký
        gsap.timeline({
                scrollTrigger: {
                    trigger: "#explorer-journal",
                    start: "top 60%",
                }
            })
            .to("#log-1", {
                width: "100%",
                duration: 2,
                ease: "power1.inOut"
            })
            .to("#exploration-circle", {
                strokeDasharray: "35, 100",
                duration: 1.5
            }, "-=1") // Giả lập 35%
            .to("#exploration-percent", {
                textContent: 35,
                duration: 1.5,
                snap: {
                    textContent: 1
                },
                onUpdate: function() {
                    document.getElementById('exploration-percent').innerHTML = Math.round(this.targets()[0].textContent) + "%";
                }
            }, "-=1.5")
            .to("#badge-asia", {
                scale: 1,
                rotation: -15,
                duration: 0.5,
                ease: "back.out(2)"
            });

        // 3. Hiệu ứng Rung màn hình khi đóng dấu (Seal)
        const badgeAsia = document.getElementById('badge-asia');
        gsap.fromTo(badgeAsia, {
            y: -100,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            delay: 2,
            onComplete: () => {
                gsap.to("body", {
                    x: 5,
                    duration: 0.05,
                    repeat: 5,
                    yoyo: true
                });
            }
        });

        // 4. Nút xuất ảnh (Sử dụng Window.print hoặc cảnh báo đơn giản)
        document.getElementById('export-journal').addEventListener('click', () => {
            alert("Hệ thống đang cuộn lại hành trình của bạn thành một bức ảnh da cừu...");
            // Ở đây bạn có thể tích hợp thư viện html2canvas để xuất ảnh thật.
        });
    });
    // Ví dụ khi người dùng click xem truyện
    function trackJourney(taleId) {
        let journey = JSON.parse(localStorage.getItem('visited_tales')) || [];
        if (!journey.includes(taleId)) {
            journey.push(taleId);
            localStorage.setItem('visited_tales', JSON.stringify(journey));
        }
    }

    //----------------------------- section 4 ----------------------------- //

    //----------------------------- section 5 ----------------------------- //

    //----------------------------- section 6 ----------------------------- //
</script>

</html>