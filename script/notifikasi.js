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
});