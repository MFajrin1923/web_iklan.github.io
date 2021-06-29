const sidebar = document.querySelector('.sidebar');
const sidbtn = document.querySelector('.sidebar-btn');

sidbtn.addEventListener('click', () => {
    sidebar.classList.toggle('active')
})