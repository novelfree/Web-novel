// Toggle sidebar menu
document.getElementById('toggleMenu').addEventListener('click', () => {
  const menuItems = document.getElementById('menuItems');
  menuItems.classList.toggle('visible');
});

// Handle page title change based on navigation
function setPageTitle(title) {
  document.getElementById('pageTitle').textContent = title;
}

// Example function to load popular novels dynamically
function loadPopularNovels() {
  const popularNovels = [
    { title: 'Novel A', genre: 'Action', img: 'assets/images/novel-a.jpg' },
    { title: 'Novel B', genre: 'Romance', img: 'assets/images/novel-b.jpg' },
    // Add more novels
  ];

  const popularNovelsContainer = document.getElementById('popularNovels');
  popularNovels.forEach(novel => {
    const novelItem = document.createElement('div');
    novelItem.classList.add('novel-item');
    novelItem.innerHTML = `
      <img src="${novel.img}" alt="${novel.title}">
      <h3>${novel.title}</h3>
      <p>${novel.genre}</p>
    `;
    popularNovelsContainer.appendChild(novelItem);
  });
}

// Call the function to load popular novels when the page loads
window.onload = loadPopularNovels;y

