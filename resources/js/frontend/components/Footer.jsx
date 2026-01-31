import React from 'react';

const Footer = ({ isDarkMode = false }) => {
    const currentYear = new Date().getFullYear();

    return (
        <footer className={`${isDarkMode ? 'bg-gray-900' : 'bg-gray-100'} ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
            <div className="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 md:grid-cols-5 gap-8">
                    {/* Personal Info */}
                    <div className="col-span-1 md:col-span-2">
                        <div className="flex items-center mb-4">
                            <img
                                src="/frontend/images/logo/invidiatech-software-engineer.png"
                                alt="InvidiaTech Logo - Professional Software Engineering & Development Services"
                                title="InvidiaTech - Professional Software Engineering & Development Services"
                                className="h-48 md:h-52 w-auto object-contain"
                            />
                        </div>
                        <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'} mb-4 max-w-md`}>
                            Full-Stack Software Engineer & Technical Writer building modern, intelligent, and scalable digital experiences.
                        </p>
                        <div className="flex space-x-4">
                            <a href="https://linkedin.com/in/muhammad-nawaz" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                <span className="sr-only">LinkedIn</span>
                                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fillRule="evenodd" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" clipRule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://github.com/muhammad-nawaz" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                <span className="sr-only">GitHub</span>
                                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fillRule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clipRule="evenodd" />
                                </svg>
                            </a>
                            <a href="mailto:muhammad@example.com" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                <span className="sr-only">Email</span>
                                <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h3 className={`text-sm font-semibold ${isDarkMode ? 'text-gray-400' : 'text-gray-500'} tracking-wider uppercase mb-4`}>
                            Quick Links
                        </h3>
                        <ul className="space-y-2">
                            <li>
                                <a href="/about" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    About
                                </a>
                            </li>
                            <li>
                                <a href="/projects" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Projects
                                </a>
                            </li>
                            <li>
                                <a href="/blog" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="/contact" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Contact
                                </a>
                            </li>
                            <li>
                                <a href="/faq" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    FAQ
                                </a>
                            </li>
                        </ul>
                    </div>

                    {/* Services */}
                    <div>
                        <h3 className={`text-sm font-semibold ${isDarkMode ? 'text-gray-400' : 'text-gray-500'} tracking-wider uppercase mb-4`}>
                            Services
                        </h3>
                        <ul className="space-y-2">
                            <li>
                                <a href="/services/laravel-development" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Laravel Development
                                </a>
                            </li>
                            <li>
                                <a href="/services/api-development" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    API Development
                                </a>
                            </li>
                            <li>
                                <a href="/services/performance-optimization" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Performance Optimization
                                </a>
                            </li>
                            <li>
                                <a href="/software-engineer" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Software Engineer
                                </a>
                            </li>
                            <li>
                                <a href="/resume" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>
                                    Resume
                                </a>
                            </li>
                        </ul>
                    </div>

                    {/* Developer Tools */}
                    <div>
                        <h3 className={`text-sm font-semibold ${isDarkMode ? 'text-gray-400' : 'text-gray-500'} tracking-wider uppercase mb-4`}>
                            Developer Tools
                        </h3>
                        <ul className="space-y-2">
                            <li>
                                <a href="/tools/json-formatter" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors flex items-center gap-1`}>
                                    <i className="fas fa-code text-xs"></i>
                                    JSON Formatter
                                </a>
                            </li>
                            <li>
                                <a href="/tools/base64-encoder-decoder" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors flex items-center gap-1`}>
                                    <i className="fas fa-lock text-xs"></i>
                                    Base64 Tool
                                </a>
                            </li>
                            <li>
                                <a href="/tools/hash-generator" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors flex items-center gap-1`}>
                                    <i className="fas fa-hashtag text-xs"></i>
                                    Hash Generator
                                </a>
                            </li>
                            <li>
                                <a href="/tools/url-encoder-decoder" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors flex items-center gap-1`}>
                                    <i className="fas fa-link text-xs"></i>
                                    URL Encoder
                                </a>
                            </li>
                            <li>
                                <a href="/tools/timestamp-converter" className={`${isDarkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors flex items-center gap-1`}>
                                    <i className="fas fa-clock text-xs"></i>
                                    Timestamp Tool
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div className={`mt-8 pt-8 ${isDarkMode ? 'border-t border-gray-800' : 'border-t border-gray-200'}`}>
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <p className={`${isDarkMode ? 'text-gray-400' : 'text-gray-500'} text-sm`}>
                            © {currentYear} Invidiatech. All rights reserved.
                        </p>
                        <p className={`mt-4 md:mt-0 ${isDarkMode ? 'text-gray-500' : 'text-gray-500'} text-sm`}>
                            Built with ❤️ by Muhammad Nawaz.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
