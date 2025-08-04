const confirmBtn = document.getElementById('confirmBtn');
const pendingSection = document.getElementById('pendingSection');
const confirmedSection = document.getElementById('confirmedSection');
const pendingTab = document.getElementById('pendingTab');
// const confirmedTab = document.getElementById('confirmedTab');

confirmBtn.addEventListener('click', () => {
    pendingSection.classList.add('hidden');
    confirmedSection.classList.remove('hidden');

    // Ganti warna tab juga
    pendingTab.classList.remove('bg-blue-400');
    pendingTab.classList.add('bg-blue-300', 'text-gray-600');

    confirmBtn.classList.remove('bg-blue-300', 'text-gray-600');
    confirmBtn.classList.add('bg-blue-400', 'text-gray-800');
});

pendingTab.addEventListener('click', () => {
    confirmedSection.classList.add('hidden');
    pendingSection.classList.remove('hidden');

    // Ganti warna tab juga
    pendingTab.classList.remove('bg-blue-300', 'text-gray-600');
    pendingTab.classList.add('bg-blue-400', 'text-gray-800');

    confirmBtn.classList.remove('bg-blue-400');
    confirmBtn.classList.add('bg-blue-300', 'text-gray-600');

    document.getElementById('detailBtn').addEventListener('click', function () {
        document.getElementById('menuDetail').classList.remove('hidden');
        document.getElementById('main').classList.add('blur-sm');
    });

});

// Fungsi menampilkan modal dan isi menu berdasarkan ID
function tampilkanDetail(idPesanan) {
    const modal = document.getElementById('reservasiModal');
    const menuList = document.getElementById('menuList');
    const main = document.getElementById('main');

    // Reset isi
    menuList.innerHTML = "";

    if (detailPesananData[idPesanan]) {
        detailPesananData[idPesanan].forEach((item, index) => {
            const li = document.createElement("li");
            li.textContent = `${index + 1}. ${item.nama} x ${item.jumlah}`;
            menuList.appendChild(li);
        });
    } else {
        menuList.innerHTML = "<li class='text-red-500'>Tidak ada pesanan.</li>";
    }

    modal.classList.remove('hidden');
    main.classList.add('blur-sm');
}

// Tombol X untuk menutup
document.getElementById('closeModal').addEventListener('click', function () {
    document.getElementById('reservasiModal').classList.add('hidden');
    document.getElementById('main').classList.remove('blur-sm');
});