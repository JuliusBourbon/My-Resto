// Menunggu seluruh konten halaman dimuat sebelum menjalankan skrip
document.addEventListener("DOMContentLoaded", () => {

    const menuContainer = document.getElementById('menu-container');
    const searchInput = document.getElementById('searchInput');

    // Elemen untuk modal
    const tambahMenuBtn = document.getElementById('tambahMenuBtn');
    const tambahMenuModal = document.getElementById('tambahMenuModal');
    const konfirmasiHapusModal = document.getElementById('konfirmasiHapusModal');
    const namaMenuHapusEl = document.getElementById('namaMenuHapus');
    const idMenuHapusInput = document.getElementById('idMenuHapus');
    const updateMenuModal = document.getElementById('updateMenuModal');
    const updateIdMenuInput = document.getElementById('update_id_menu');
    const updateNamaMenuInput = document.getElementById('update_nama_menu');
    const updateHargaInput = document.getElementById('update_harga');

    const allModals = [tambahMenuModal, konfirmasiHapusModal, updateMenuModal];
    let selectedKategori = null; 

    function updateMenuContainer(data) {
        if (!menuContainer) return;
        menuContainer.innerHTML = ''; 

        const bgMap = {
            'Sarapan': 'bg-[#C8F6BC]',
            'Hidangan Utama': 'bg-[#FFD27E]',
            'Minuman': 'bg-[#A2F9FF]',
            'Penutup': 'bg-[#FEC0FF]'
        };

        data.forEach(item => {
            const bg = bgMap[item.nama_kategori] || 'bg-gray-200';
            const el = document.createElement('div');
            el.className = `menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm h-full ${bg}`;
            el.dataset.id_menu = item.id_menu;

            el.innerHTML = `
            <div class="flex flex-col justify-between h-full">
                <div class="flex justify-between mt-2">
                    <div class="flex flex-col">
                        <div class="flex justify-center">
                            <button class="edit-menu-btn text-gray-500 hover:text-blue-600 transition" 
                                    data-id="${item.id_menu}"
                                    data-nama="${item.nama}"
                                    data-harga="${item.harga}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-line-icon lucide-pen-line"><path d="M13 21h8"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>
                            </button>
                        </div>
                        <div class=" opacity-0">
                            H
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-end text-center mt-4">
                        <h3 class="font-bold text-gray-800 text-xl">${item.nama}</h3>
                        <p class="text-lg text-gray-700 font-medium">Rp${parseInt(item.harga).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex justify-center">
                            <button class="hapus-menu-btn text-gray-500 hover:text-red-600 transition" 
                                    data-id="${item.id_menu}" 
                                    data-nama="${item.nama}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>

                        <div class=" opacity-0">
                                H
                        </div>
                    </div>
                </div>
                <div class="mt-7">
                    <form method="POST" action="${BASE_URL}/src/kokiMenuUpdate.php" class="flex justify-center">
                        <input type="hidden" name="id_menu" value="${item.id_menu}">
                        <select name="status_ketersediaan" onchange="this.form.submit()" class="w-3/4 bg-white border border-gray-300 rounded px-2 py-1 text-md shadow-sm hover:border-blue-400 transition focus:outline-none">
                            <option value="Tersedia" ${item.status_ketersediaan === 'Tersedia' ? 'selected' : ''}>Tersedia</option>
                            <option value="Tidak Tersedia" ${item.status_ketersediaan === 'Tidak Tersedia' ? 'selected' : ''}>Tidak Tersedia</option>
                        </select>
                    </form>
                </div>
            </div>`;
            menuContainer.appendChild(el);
        });
    }

    function fetchMenu(kategoriId = null) {
        let url = `${BASE_URL}/src/menuFiltered.php`; 
        if (kategoriId) {
            url += `?kategori_id=${kategoriId}`;
        }

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                updateMenuContainer(data);
            })
            .catch(error => console.error('Error fetching menu:', error));
    }

    // --- Filter Kategori ---
    document.querySelectorAll(".kategori-btn").forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.kategori;
            selectedKategori = selectedKategori === id ? null : id;

            document.querySelectorAll(".kategori-btn").forEach(b => {
                b.classList.remove("border-blue-700", "text-black", "font-bold");
                b.classList.add("text-gray-700");
            });

            if (selectedKategori !== null) {
                btn.classList.add("border-blue-700", "text-black", "font-bold");
                btn.classList.remove("text-gray-700");
            }

            fetchMenu(selectedKategori);
        };
    });

    // --- Pencarian Menu ---
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const menuItems = menuContainer.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                const menuName = item.querySelector('h3').textContent.toLowerCase();
                item.style.display = menuName.includes(searchTerm) ? 'flex' : 'none';
            });
        });
    }

    // --- Logika Modal (Tambah & Hapus) ---
    const openModal = (modal) => modal.classList.remove('hidden');
    const closeModal = (modal) => modal.classList.add('hidden');
    
    // Buka modal tambah menu
    if (tambahMenuBtn) {
        tambahMenuBtn.addEventListener('click', () => openModal(tambahMenuModal));
    }

    // Tutup semua jenis modal
    allModals.forEach(modal => {
        if (modal) {
            modal.querySelectorAll('.modal-close-btn, [type="button"]').forEach(btn => {
                // Pastikan tombol submit tidak menutup modal
                if (btn.type !== 'submit') {
                    btn.addEventListener('click', () => closeModal(modal));
                }
            });
            // Klik di luar area konten modal
            modal.addEventListener('click', (event) => {
                if (event.target === modal) closeModal(modal);
            });
        }
    });

    if (menuContainer) {
        menuContainer.addEventListener('click', (event) => {
            const editBtn = event.target.closest('.edit-menu-btn');
            const hapusBtn = event.target.closest('.hapus-menu-btn');

            // --- Jika Tombol EDIT yang diklik ---
            if (editBtn) {
                // Ambil data dari tombol
                const id = editBtn.dataset.id;
                const nama = editBtn.dataset.nama;
                const harga = editBtn.dataset.harga;

                // Masukkan data ke dalam form di modal update
                updateIdMenuInput.value = id;
                updateNamaMenuInput.value = nama;
                updateHargaInput.value = harga;
                
                // Tampilkan modal update
                openModal(updateMenuModal);
            }

            // --- Jika Tombol HAPUS yang diklik ---
            if (hapusBtn) {
                const id = hapusBtn.dataset.id;
                const nama = hapusBtn.dataset.nama;
                
                namaMenuHapusEl.textContent = nama;
                idMenuHapusInput.value = id;
                
                openModal(konfirmasiHapusModal);
            }
        });
    }

    fetchMenu();
});