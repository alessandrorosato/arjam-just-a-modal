document.addEventListener('DOMContentLoaded', function() {
    const customBtn = document.getElementById('my-custom-admin-btn');
    const hashField = document.querySelector('input[name="arjam_plugin_hash"]');

    if (customBtn) {
        customBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            try {
                const hash = await generateTimeHash();
                // Insert the hash into the input field
                hashField.value = hash;
                customBtn.textContent = 'Done!';
                customBtn.disabled = true;
            } catch (err) {
                alert('Hash generation failed.');
            } finally {
                setTimeout(() => {
                    customBtn.textContent = 'Generate!';
                    customBtn.disabled = false;
                }, 1000);
            }
        });
    }
});


// Function to generate a SHA-256 hash from the current timestamp
async function generateTimeHash() {
    const encoder = new TextEncoder();
    // Use current time in milliseconds as the source
    const data = encoder.encode(Date.now().toString());
    
    // Generate the hash buffer using Web Crypto API
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    
    // Convert buffer to a hex string
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const fullHash = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    // Return only the first 16 characters
    return fullHash.substring(0, 16);
}