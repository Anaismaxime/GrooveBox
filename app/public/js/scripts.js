const toggleButton = document.querySelector('#burger');
const sidebar = document.querySelector('#sidebar');

toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('open');
})

const closeButton = document.querySelector('#closeSidebar');

closeButton.addEventListener('click', () => {
    sidebar.classList.remove('open');
});
