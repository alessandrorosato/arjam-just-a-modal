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
        const title = arjam_plugin_data.text ? `<h2 id="arjam-modal-title">${arjam_plugin_data.text}</h2>` : '';
        const image = arjam_plugin_data.image ? `<div id="arjam-modal-image"><img src="${arjam_plugin_data.image}" style="max-width:100%;" /></div>` : '';
        const text = arjam_plugin_data.richtext ? `<div id="arjam-modal-richtext">${arjam_plugin_data.richtext}</div>` : '';

        // Create modal HTML
        const modalHTML = `
            <div id="arjam-modal-background">
                <div id="arjam-modal-content" role="dialog" aria-modal="true"${arjam_plugin_data.text ? ' aria-labelledby="arjam-modal-title"' : ''}>
                    <button type="button" id="arjam-modal-close" aria-label="Close">&times;</button>
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
        let previouslyFocused = null;

        function closeModal() {
            modal.style.display = 'none';
            document.body.classList.remove('arjam-modal-open');
            document.removeEventListener('keydown', onKeydown);
            if (previouslyFocused) {
                previouslyFocused.focus();
            }
        }

        function onKeydown(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        }

        // Close modal
        closeBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        const delay = arjam_plugin_data.modal_delay * 1000;
        setTimeout(function () {
            previouslyFocused = document.activeElement;
            modal.style.display = 'block';
            localStorage.setItem('arjam_hash', currentHash);
            document.body.classList.add('arjam-modal-open');
            document.addEventListener('keydown', onKeydown);
            closeBtn.focus();
        }, delay);
    }
});