<?php
// home.php
session_start();

// Check if the user is NOT logged in, redirect them to index.php (login page)
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Optionally set a message that their session timed out or they need to login
    $_SESSION['login_message'] = "Please log in to access the website.";
    header("Location: index.php?timeout=true");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://placehold.co/16x16/000000/FFFFFF?text=E">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        /* Your general styles from index.html (like scroll-behavior, body font, etc.) */
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; color: #1f2937; }
        #scrollToTopBtn { display: none; }
        /* Add any other global styles you want to apply to home.php */
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <header class="bg-white shadow-md py-4 sticky top-0 z-50">
        <nav class="container mx-auto px-4 flex justify-between items-center">
            <a href="home.php" class="text-2xl font-bold text-blue-600">Event<span class="text-gray-800">Hub</span></a>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <ul id="desktop-menu" class="hidden md:flex space-x-8">
                <li><a href="home.php" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a></li>
                <li><a href="home.php#about" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">About</a></li>
                <li><a href="home.php#events" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Events</a></li>
                
                <li><a href="home.php#contact" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Contact</a></li>
                <li><a href="logout.php" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Logout</a></li>
            </ul>
        </nav>

        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg mt-2">
            <ul class="flex flex-col space-y-2 px-4 py-2">
                <li><a href="home.php" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a></li>
                <li><a href="home.php#about" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">About</a></li>
                <li><a href="home.php#events" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Events</a></li>
               
                <li><a href="home.php#contact" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Contact</a></li>
                <li><a href="logout.php" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Logout</a></li>
            </ul>
        </div>
    </header>

    <main id="main-content" class="flex-grow container mx-auto px-4 py-8">
        <section class="hero-area text-center py-20 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg shadow-xl">
            <h1 class="text-5xl font-extrabold mb-4 animate-fade-in-down">Welcome to EventHub!</h1>
            <p class="text-xl mb-8 animate-fade-in-up">Your ultimate destination for discovering and managing amazing events.</p>
            <div class="space-x-4">
                <a href="#events" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">Explore Events</a>
            </div>
            <div class="mt-10 flex justify-center space-x-8">
                <div class="flex flex-col items-center">
                    <span class="text-4xl font-bold">150+</span>
                    <span class="text-lg">Upcoming Events</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl font-bold">50K+</span>
                    <span class="text-lg">Happy Attendees</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl font-bold">20+</span>
                    <span class="text-lg">Expert Speakers</span>
                </div>
            </div>
        </section>

        <section id="features" class="features-section py-16">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-900">Why Choose EventHub?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="text-blue-600 text-5xl mb-4">💡</div>
                    <h3 class="text-2xl font-semibold mb-2">Diverse Events</h3>
                    <p class="text-gray-600">From tech conferences to music festivals, find events that match your interests.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="text-blue-600 text-5xl mb-4">🎟️</div>
                    <h3 class="text-2xl font-semibold mb-2">Easy Registration</h3>
                    <p class="text-gray-600">Seamless and secure registration process for all events.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="text-blue-600 text-5xl mb-4">🤝</div>
                    <h3 class="text-2xl font-semibold mb-2">Connect & Network</h3>
                    <p class="text-gray-600">Opportunities to meet new people and expand your professional network.</p>
                </div>
            </div>
        </section>

        <section id="events" class="events-list-section py-16 bg-white rounded-lg shadow-lg">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-extrabold text-center mb-12 text-gray-900">Our Exciting College Events</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <img src="Freshers_welcome.jpg" alt="Tech Symposium" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Fresher Welcome</h3>
                            <p class="text-gray-600 text-sm mb-4">A formal speech from the Principal, a senior faculty member, or a senior student representative, expressing a warm welcome to the new students and outlining the college's vision and values. </p>
                            <div class="flex items-center text-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                <span>Nov 26-28, 2025</span>
                            </div>
                            <div class="flex items-center text-gray-700 mb-4">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                <span>College Auditorium</span>
                            </div>
                           
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <img src="annual_socail.jpg" alt="Cultural Fest" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Annual Social</h3>
                            <p class="text-gray-600 text-sm mb-4">Celebrate diversity with music, dance, drama, and art exhibitions. Join the fun!</p>
                            <div class="flex items-center text-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                <span>Feb 15-17, 2025</span>
                            </div>
                            <div class="flex items-center text-gray-700 mb-4">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                <span>College Grounds & Auditorium</span>
                            </div>
                           
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <img src="annual_sports.jpg" alt="Sports Meet" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Annual Sports Meet</h3>
                            <p class="text-gray-600 text-sm mb-4">Compete in various sports, cheer for your teams, and show your athletic spirit!</p>
                            <div class="flex items-center text-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                <span>Dec 01-03, 2025</span>
                            </div>
                            <div class="flex items-center text-gray-700 mb-4">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                <span>College Sports Complex</span>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="about-us-section py-16 bg-white rounded-lg shadow-lg mt-8">
            <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="md:order-2">
                    <img src="events-photo.jpg" alt="About EventHub" class="rounded-lg shadow-xl w-full h-auto object-cover">
                </div>
                <div class="md:order-1">
                    <h2 class="text-4xl font-extrabold mb-6 text-gray-900">About EventHub - Your College Event Partner</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        EventHub is dedicated to revolutionizing how college events are organized and experienced. We provide a seamless platform for students, faculty, and clubs to discover, register for, and manage all campus activities. From academic conferences and workshops to vibrant cultural festivals and thrilling sports tournaments, we've got it all covered.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        Our mission is to foster a dynamic campus environment by connecting students with opportunities to learn, grow, and have fun. We believe that well-organized events are key to a thriving student community, and EventHub is here to make that a reality.
                    </p>
                    <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
                        <li>Empowering student organizations with easy event management tools.</li>
                        <li>Providing a central hub for all college event information.</li>
                        <li>Enhancing student engagement and participation.</li>
                        <li>Facilitating a vibrant and inclusive campus culture.</li>
                    </ul>
                </div>
            </div>
        </section>

       

        <section id="contact" class="contact-us-section py-16 bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-lg shadow-xl mt-8">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-extrabold text-center mb-12">Get In Touch With EventHub</h2>
                <p class="text-xl text-center mb-10 max-w-2xl mx-auto">
                    Have questions, suggestions, or need assistance? Reach out to us using the form below or find our contact details.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                    <div class="bg-white p-8 rounded-lg shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h3>
                        <form action="#" method="POST" class="space-y-6">
                            <div>
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Your Name</label>
                                <input type="text" id="name" name="name" class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Name" required>
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Your Email</label>
                                <input type="email" id="email" name="email" class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="your.email@example.com" required>
                            </div>
                            <div>
                                <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Inquiry about events" required>
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Your Message</label>
                                <textarea id="message" name="message" rows="6" class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Type your message here..." required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition-colors duration-300 shadow-lg">Send Message</button>
                            </div>
                        </form>
                    </div>

                    <div class="text-white p-8 rounded-lg shadow-xl bg-blue-700 bg-opacity-70 backdrop-blur-sm">
                        <h3 class="text-2xl font-bold mb-6">Our Contact Information</h3>
                        <address class="not-italic text-lg space-y-4 mb-8">
                            <p class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.51a1 1 0 001.2.98l.68.12a1 1 0 001.07-.36l.75-.9a1 1 0 011.64 0l.75.9a1 1 0 001.07.36l.68-.12A1 1 0 0019 4.51V17a2 2 0 01-2 2H7a2 2 0 01-2-2V4.51a1 1 0 00-1-1l.68-.12a1 1 0 001.07-.36l.75-.9a1 1 0 011.64 0l.75.9a1 1 0 001.07.36l.68-.12A1 1 0 009 4.51V3a1 1 0 011-1zM5 7a1 1 0 00-1 1v7a1 1 0 001 1h10a1 1 0 001-1V8a1 1 0 00-1-1H5z" clip-rule="evenodd"></path></svg>
                                <span>EventHub Campus Office, Michael Madhusudan Memorial College,  Durgapur, West Bengal</span>
                            </p>
                            <p class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06L6.22 10.272a1 1 0 00-.21 1.014l.063.155a15.938 15.938 0 008.077 8.077l.155.063a1 1 0 001.014-.21l1.15-.54a1 1 0 011.06-.54h4.435a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                                <span>0343 256 6700</span>
                            </p>
                            <p class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                <span>principalmmmc@gmail.com</span>
                            </p>
                        </address>
                        <div class="rounded-lg overflow-hidden shadow-lg aspect-w-16 aspect-h-9">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.519128738104!2d87.30841157455664!3d23.549791896449754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f76e02a734fdc9%3A0xcbd3550951955ac4!2sMichael%20Madhusudan%20Memorial%20College!5e0!3m2!1sen!2sin!4v1748938178624!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-gray-900 text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold text-blue-400">EventHub</h3>
                    <p class="text-gray-400 text-sm">Organizing memorable experiences.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">FAQ</a>
                </div>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 text-gray-500 text-sm">
                &copy; <span id="current-year-home-footer"></span> EventHub. All rights reserved.
            </div>
        </div>
    </footer>

    <button id="scrollToTopBtn" class="fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors duration-300 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.getElementById('current-year-home-footer').textContent = new Date().getFullYear();

        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollToTopBtn.style.display = 'block';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>