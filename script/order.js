document.addEventListener("DOMContentLoaded", () => {
    const alertModal = document.getElementById('alertModal');
    const alertMessage = document.getElementById('alertMessage');
    const closeAlert = document.getElementById('closeAlert');
    const searchInput = document.getElementById('searchInput');
    const menuContainer = document.getElementById('menu-container');
    const confirmBtn = document.querySelector(".konfirmasi-btn");
    const profileIcon = document.getElementById('profileIcon');
    const dropdownMenu = document.getElementById('dropdownMenu');

    let selectedQuantities = {};
    let allMenuItems = {};
    let selectedKategori = null;

    // Show Custom Alert
    function showCustomAlert(message) {
        if (alertMessage && alertModal) {
            alertMessage.textContent = message;
            alertModal.classList.remove('hidden');
        }
    }

    // Close Alert Modal
    if (closeAlert) {
        closeAlert.addEventListener('click', () => {
            alertModal.classList.add('hidden');
        });
    }

    // Profile Dropdown Toggle
    if (profileIcon && dropdownMenu) {
        profileIcon.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!profileIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }

    // Update Summary
    function updateOrderSummary() {
        const container = document.getElementById("summary-items");
        const totalEl = document.getElementById("total-harga");
        container.innerHTML = '';
        let total = 0;

        for (const id in selectedQuantities) {
            const qty = selectedQuantities[id];
            if (qty > 0) {
                const item = allMenuItems[id];
                const subtotal = item.harga * qty;
                total += subtotal;
                container.innerHTML += `
                <div class="flex justify-between">
                    <span>${item.nama} x ${qty}</span>
                    <span>Rp${subtotal.toLocaleString('id-ID')}</span>
                </div>`;
            }
        }

        totalEl.textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    // Bind + / - Button
    function bindQuantityButtons() {
        document.querySelectorAll(".quantity-btn").forEach(btn => {
            btn.onclick = () => {
                const input = btn.parentElement.querySelector(".quantity");
                const id = btn.closest(".menu-item").dataset.id_menu;
                let val = parseInt(input.value);
                val = btn.classList.contains("plus") ? val + 1 : Math.max(val - 1, 0);
                input.value = val;
                selectedQuantities[id] = val;
                updateOrderSummary();
            };
        });

        document.querySelectorAll(".quantity").forEach(input => {
            input.addEventListener('input', () => {
                const id = input.closest(".menu-item").dataset.id_menu;
                let val = parseInt(input.value);
                selectedQuantities[id] = isNaN(val) || val < 0 ? 0 : val;
                updateOrderSummary();
            });
        });
    }

    // Update Menu Cards
    function updateMenu(data) {
        menuContainer.innerHTML = '';
        data.forEach(item => {
            allMenuItems[item.id_menu] = { nama: item.nama, harga: parseInt(item.harga) };
            const qty = selectedQuantities[item.id_menu] || 0;
            const bgMap = {
                'Sarapan': 'bg-[#C8F6BC]', 'Hidangan Utama': 'bg-[#FFD27E]',
                'Minuman': 'bg-[#A2F9FF]', 'Penutup': 'bg-[#FEC0FF]'
            };
            const bg = item.status_ketersediaan === 'Tersedia' ? (bgMap[item.nama_kategori] || 'bg-gray-200') : 'opacity-60 bg-gray-300';

            menuContainer.innerHTML += `
            <div class="menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm h-36 ${bg}" data-id_menu="${item.id_menu}">
                <div class="flex-grow">
                    <h3 class="font-bold text-xl">${item.nama}</h3>
                    <p class="font-semibold text-lg">Rp${new Intl.NumberFormat('id-ID').format(item.harga)}</p>
                </div>
                ${item.status_ketersediaan === 'Tersedia' ? `
                <div class="flex items-center justify-center gap-2 mt-2">
                    <button class="quantity-btn minus bg-white p-1 rounded w-7 h-7">-</button>
                    <input class="quantity text-center w-10" value="${qty}" min="0">
                    <button class="quantity-btn plus bg-white p-1 rounded w-7 h-7">+</button>
                </div>` : `<p class="text-center mt-4 font-bold text-gray-600">Tidak Tersedia</p>`}
            </div>`;
        });

        bindQuantityButtons();
    }

    // Fetch Menu
    function fetchMenu(kategoriId = null) {
        // DIUBAH
        let url = `${BASE_URL}/src/menuFiltered.php`;
        if (kategoriId) url += `?kategori_id=${kategoriId}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                updateMenu(data);
                updateOrderSummary();
            });
    }

    // Kategori Filter
    document.querySelectorAll(".kategori-btn").forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.kategori;
            selectedKategori = selectedKategori === id ? null : id;

            document.querySelectorAll(".kategori-btn").forEach(b => {
                b.classList.remove("border-1", "text-black");
                b.classList.add("text-gray-700");
            });

            if (selectedKategori !== null) {
                btn.classList.add("border-1", "text-black");
                btn.classList.remove("text-gray-700");
            }

            fetchMenu(selectedKategori);
        };
    });

    // Search Menu
    if (searchInput && menuContainer) {
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const menuItems = menuContainer.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                const menuName = item.querySelector('h3').textContent.toLowerCase();
                item.style.display = menuName.includes(searchTerm) ? 'flex' : 'none';
            });
        });
    }

    // Konfirmasi Pesanan
    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            const nomorMeja = document.querySelector("select[name='meja']").value;
            if (!nomorMeja) return showCustomAlert("Pilih meja terlebih dahulu.");

            const pesanan = Object.entries(selectedQuantities)
                .filter(([, qty]) => qty > 0)
                .map(([id_menu, jumlah]) => ({ id_menu: parseInt(id_menu), jumlah }));

            if (pesanan.length === 0) return showCustomAlert("Pesanan kosong.");
            
            // DIUBAH
            fetch(`${BASE_URL}/src/submitPesanan.php`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ nomor_meja: parseInt(nomorMeja), pesanan })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    showCustomAlert("Pesanan berhasil!");
                    window.location.reload();
                } else {
                    showCustomAlert("Gagal menyimpan: " + res.message);
                }
            });
        });
    }

    // Init
    fetchMenu();
});