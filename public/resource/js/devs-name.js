
document.addEventListener('DOMContentLoaded', () => {
    // Developer names from PHP environment variable
    const developerNames = "<?=$DEVS_NAME?>".split('|');

    const header = document.getElementById('header-devs');
    const footer = document.getElementById('footer-devs');

    // Function to add names to a scrolling container
    function addNamesToScrollingContainer(container) {
        developerNames.forEach(name => {
            const nameElement = document.createElement('div');
            nameElement.classList.add('name');
            nameElement.textContent = name.trim();
            container.appendChild(nameElement);
        });
    }

    // Add names to both the main content and footer
    addNamesToScrollingContainer(header);
    addNamesToScrollingContainer(footer);
});