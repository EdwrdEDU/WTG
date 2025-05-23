/**
 * Help Center JavaScript
 * This file contains scripts for the help center functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    // Handle help center accordion functionality
    const accordionButtons = document.querySelectorAll('.help-center-accordion-button');
    
    if (accordionButtons.length > 0) {
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('active');
                const content = this.nextElementSibling;
                if (content.classList.contains('help-center-accordion-content')) {
                    if (content.style.maxHeight) {
                        content.style.maxHeight = null;
                    } else {
                        content.style.maxHeight = content.scrollHeight + 'px';
                    }
                }
            });
        });
    }
    
    // Initialize first item in each accordion section
    document.querySelectorAll('.help-center-faq-category').forEach(category => {
        const firstButton = category.querySelector('.help-center-accordion-button');
        if (firstButton) {
            // Uncomment the line below to automatically open the first item in each category
            firstButton.click();
        }
    });
    
    console.log('Help center scripts initialized');
});