// Chatbot functionality
let chatOpen = false;

// Predefined responses for the chatbot
const botResponses = {
    greetings: [
        "Hello! How can I assist you today?",
        "Hi there! What can I help you with?",
        "Welcome! I'm here to help you with any questions."
    ],
    services: [
        "We offer AI chatbots, data analytics, and process automation. Which service interests you most?",
        "Our main services include intelligent chatbots, advanced analytics, and business automation solutions."
    ],
    pricing: [
        "Our pricing varies based on your specific needs. Would you like to schedule a consultation to discuss your requirements?",
        "We offer flexible pricing plans. Let me connect you with our sales team for a personalized quote."
    ],
    contact: [
        "You can reach us at contact@proaisolutions.com or call +1 (555) 123-4567. We're here 24/7!",
        "Feel free to contact us via email at contact@proaisolutions.com or use the contact form on this page."
    ],
    default: [
        "That's an interesting question! Let me connect you with a human agent who can provide more detailed information.",
        "I'd be happy to help! Could you please provide more details about what you're looking for?",
        "Thanks for your question! Our team can provide more specific information. Would you like me to arrange a callback?"
    ]
};

function toggleChat() {
    const chatbot = document.getElementById('chatbot');
    const chatToggle = document.getElementById('chatToggle');
    
    if (!chatbot || !chatToggle) return;
    
    chatOpen = !chatOpen;
    
    if (chatOpen) {
        chatbot.classList.add('active');
        chatToggle.style.display = 'none';
    } else {
        chatbot.classList.remove('active');
        chatToggle.style.display = 'block';
    }
}

function openChat() {
    const chatbot = document.getElementById('chatbot');
    const chatToggle = document.getElementById('chatToggle');
    
    if (!chatbot || !chatToggle) return;
    
    chatOpen = true;
    chatbot.classList.add('active');
    chatToggle.style.display = 'none';
}

function closeChat() {
    const chatbot = document.getElementById('chatbot');
    const chatToggle = document.getElementById('chatToggle');
    
    if (!chatbot || !chatToggle) return;
    
    chatOpen = false;
    chatbot.classList.remove('active');
    chatToggle.style.display = 'block';
}

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!input || !message) return;
    
    addMessage(message, 'user');
    input.value = '';
    
    // Simulate bot response after a short delay
    setTimeout(() => {
        const response = generateBotResponse(message);
        addMessage(response, 'bot');
    }, 1000);
}

function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chatMessages');
    if (!messagesContainer) return;
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const avatar = document.createElement('div');
    avatar.className = 'message-avatar';
    avatar.innerHTML = sender === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';
    
    const content = document.createElement('div');
    content.className = 'message-content';
    content.innerHTML = `<p>${text}</p>`;
    
    messageDiv.appendChild(avatar);
    messageDiv.appendChild(content);
    messagesContainer.appendChild(messageDiv);
    
    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function generateBotResponse(userMessage) {
    const message = userMessage.toLowerCase();
    
    if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
        return getRandomResponse(botResponses.greetings);
    } else if (message.includes('service') || message.includes('what do you do')) {
        return getRandomResponse(botResponses.services);
    } else if (message.includes('price') || message.includes('cost') || message.includes('pricing')) {
        return getRandomResponse(botResponses.pricing);
    } else if (message.includes('contact') || message.includes('reach') || message.includes('phone')) {
        return getRandomResponse(botResponses.contact);
    } else {
        return getRandomResponse(botResponses.default);
    }
}

function getRandomResponse(responses) {
    return responses[Math.floor(Math.random() * responses.length)];
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Smooth scrolling for navigation links
const anchorLinks = document.querySelectorAll('a[href^="#"]');
if (anchorLinks.length) {
    anchorLinks.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Contact form handling
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Get form data
        const formData = new FormData(this);
        const name = this.querySelector('input[type="text"]').value;
        const email = this.querySelector('input[type="email"]').value;
        const message = this.querySelector('textarea').value;
        // Simulate form submission
        alert(`Thank you, ${name}! Your message has been sent. We'll get back to you soon.`);
        // Reset form
        this.reset();
    });
}

// Add scroll effect to header
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    if (header) {
        if (window.scrollY > 100) {
            header.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
            header.style.background = 'rgba(255, 255, 255, 0.95)';
        }
    }
});

// Mobile navigation toggle
const navToggle = document.querySelector('.nav-toggle');
if (navToggle) {
    navToggle.addEventListener('click', function() {
        const navMenu = document.querySelector('.nav-menu');
        if (navMenu) {
            navMenu.classList.toggle('active');
        }
    });
}

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
document.querySelectorAll('.service-card, .about-text, .contact-content').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Initialize chatbot with welcome message
document.addEventListener('DOMContentLoaded', function() {
    // Add some sample conversation to demonstrate the chatbot
    setTimeout(() => {
        if (!chatOpen) {
            // Show a notification bubble
            const chatToggle = document.getElementById('chatToggle');
            if (chatToggle) {
                chatToggle.style.animation = 'pulse 2s infinite';
            }
        }
    }, 3000);
});

// Add pulse animation for chat button
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(style);

// Expose functions globally for Blade inline handlers
window.toggleChat = toggleChat;
window.openChat = openChat;
window.closeChat = closeChat;
window.sendMessage = sendMessage;
window.handleKeyPress = handleKeyPress;