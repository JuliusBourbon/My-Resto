const pendingTab = document.getElementById('pendingTab');
const confirmedTab = document.getElementById('confirmedTab');
const pendingSection = document.getElementById('pendingSection');
const confirmedSection = document.getElementById('confirmedSection');

pendingTab.addEventListener('click', () => {
    // Tampilkan section pending
    pendingSection.classList.remove('hidden');
    confirmedSection.classList.add('hidden');
    // Atur style tab
    pendingTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50";
    confirmedTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500";
});

confirmedTab.addEventListener('click', () => {
    // Tampilkan section terkonfirmasi
    confirmedSection.classList.remove('hidden');
    pendingSection.classList.add('hidden');
    // Atur style tab
    confirmedTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50";
    pendingTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500";
});

const modal = document.getElementById('reservasiModal');
const menuList = document.getElementById('menuList');

function tampilkanDetail(id_pesanan) {
    // Kosongkan list sebelumnya
    menuList.innerHTML = '';
    
    // Cek apakah ada data untuk id_pesanan ini
    if (detailPesananData[id_pesanan]) {
        detailPesananData[id_pesanan].forEach(item => {
            const li = document.createElement('li');
            li.className = "border-b pb-2";
            li.innerHTML = `<span class="font-bold">${item.jumlah}x</span> ${item.nama_menu}`;
            menuList.appendChild(li);
        });
    } else {
        menuList.innerHTML = '<li>Tidak ada detail untuk pesanan ini.</li>';
    }
    
    // Tampilkan modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function tutupModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}