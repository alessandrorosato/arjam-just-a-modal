document.addEventListener('DOMContentLoaded', function () {
    // Visitor's stored hash and current hash from settings
    const modalHash = localStorage.getItem('arjam_hash');
    const currentHash = arjam_plugin_data.modal_hash;

    // Check if modal is enabled and not shown before
    if (
        arjam_plugin_data.enable_modal
        && (modalHash !== currentHash)
    ) {
        // Modal content
        const title = arjam_plugin_data.text ? `<h2>${arjam_plugin_data.text}</h2>` : '';
        const image = arjam_plugin_data.image ? `<div class="arjam-image"><img src="${arjam_plugin_data.image}" style="max-width:100%;" /></div>` : '';
        const text = arjam_plugin_data.richtext ? `<div class="arjam-richtext">${arjam_plugin_data.richtext}</div>` : '';

        // Create modal HTML
        const modalHTML = `
            <div id="arjam-modal-background">
                <div id="arjam-modal-content">
                    <span id="arjam-modal-close">&times;</span>
                    ${title}
                    ${image}
                    ${text}
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Get DOM elements
        const modal = document.getElementById('arjam-modal-background');
        const closeBtn = document.getElementById('arjam-modal-close');

        // Close modal
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
            document.body.classList.remove('arjam-modal-open');
        });

        // Close modal when clicking outside
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        const delay = arjam_plugin_data.modal_delay * 1000;
        setTimeout(function () {
            modal.style.display = 'block';
            localStorage.setItem('arjam_hash', currentHash);
            document.body.classList.add('arjam-modal-open');
        }, delay);
    }
});