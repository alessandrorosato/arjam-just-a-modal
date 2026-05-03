document.addEventListener('DOMContentLoaded', function() {
    // Modal content
    const title = jam_plugin_data.text ? `<h2>${jam_plugin_data.text}</h2>` : '';
    const image = jam_plugin_data.image ? `<div class="jam-image"><img src="${jam_plugin_data.image}" style="max-width:100%;" /></div>` : '';
    const text = jam_plugin_data.richtext ? `<div class="jam-richtext">${jam_plugin_data.richtext}</div>` : '';

    // Create modal HTML
    const modalHTML = `
        <div id="jam-modal-container">
            <div id="jam-modal-content">
                <span id="jam-modal-close">&times;</span>
                ${title}
                ${image}
                ${text}
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Get DOM elements
    const modal = document.getElementById('jam-modal-container');
    const closeBtn = document.getElementById('jam-modal-close');

    // Visitor's stored hash and current hash from settings
    const modalHash = localStorage.getItem('jam_hash');
    const currentHash = jam_plugin_data.modal_hash;

    // Check if modal is enabled and not shown before
    if (
        jam_plugin_data.enable_modal
        && (modalHash !== currentHash)
    ) {
        const delay = jam_plugin_data.modal_delay * 1000;
        setTimeout(function(){
            modal.style.display = 'block';
            localStorage.setItem('jam_hash', currentHash);
        }, delay);
    }

    // Close modal
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});